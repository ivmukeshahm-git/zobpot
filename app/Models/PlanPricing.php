<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PlanPricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_plan_pricing';
    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'plan_name',
        'plan_price',
        'plan_description',
        'plan_for',
        'service',
        'service_limit',
        'job_limit',
        'opportunity_limit',
        'benefits',
        'plan_duration',
        'plan_time',
        'status',
    ];

    /**
     * Benefits list without empty / "null" entries.
     * Decodes HTML entities so "&amp;" stored in DB still shows as "&".
     */
    public function getBenefitsListAttribute(): array
    {
        return array_values(array_filter(
            array_map(function ($benefit) {
                return self::decodePlanText(trim((string) $benefit));
            }, explode(',', (string) ($this->benefits ?? ''))),
            function ($benefit) {
                return $benefit !== '' && strtolower($benefit) !== 'null';
            }
        ));
    }

    /**
     * Decode HTML entities repeatedly (handles &amp; and &amp;amp;).
     */
    public static function decodePlanText(?string $value): string
    {
        $text = (string) $value;
        if ($text === '') {
            return '';
        }

        for ($i = 0; $i < 3; $i++) {
            $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ($decoded === $text) {
                break;
            }
            $text = $decoded;
        }

        return $text;
    }

    /**
     * Normalize service value.
     * UI uses "opportunity"; backend treats it as internship.
     * Canonical: none | all | job | internship
     */
    public static function normalizeService(?string $service): string
    {
        $service = strtolower(trim((string) $service));
        if ($service === 'opportunity') {
            $service = 'internship';
        }
        if (!in_array($service, ['none', 'all', 'job', 'internship'], true)) {
            return 'none';
        }

        return $service;
    }

    /**
     * Resolve job/internship type to canonical job|internship.
     */
    public static function normalizeType(string $type): string
    {
        $rawType = strtolower(trim($type));
        if ($rawType === 'opportunity') {
            return 'internship';
        }

        return in_array($rawType, ['job', 'internship'], true) ? $rawType : 'job';
    }

    /**
     * Activate / refresh plan for user:
     * - sets active_plan_id + plan_service
     * - resets usage counters to 0 (fresh limit for new purchase)
     * - optionally sets per-user job/opportunity limits
     */
    public static function activatePlanForUser($user, $plan, ?string $service = null, ?int $jobLimit = null, ?int $opportunityLimit = null): void
    {
        if (!$user || !$plan) {
            return;
        }

        $planId = is_object($plan) ? (int) ($plan->plan_id ?? 0) : (int) $plan;
        if ($planId <= 0) {
            return;
        }

        $planModel = is_object($plan) && isset($plan->service)
            ? $plan
            : self::find($planId);

        $resolvedService = $service !== null
            ? self::normalizeService($service)
            : self::normalizeService($planModel->service ?? 'none');

        // If limits not passed, default from plan pricing
        if ($jobLimit === null && $planModel) {
            $jobLimit = ($planModel->job_limit !== null && $planModel->job_limit !== '')
                ? (int) $planModel->job_limit
                : null;
        }
        if ($opportunityLimit === null && $planModel) {
            $opportunityLimit = ($planModel->opportunity_limit !== null && $planModel->opportunity_limit !== '')
                ? (int) $planModel->opportunity_limit
                : null;
        }

        // Clear limits not included in selected service
        if (!in_array($resolvedService, ['all', 'job'], true)) {
            $jobLimit = null;
        }
        if (!in_array($resolvedService, ['all', 'internship'], true)) {
            $opportunityLimit = null;
        }

        $payload = [
            'active_plan_id' => $planId,
            'plan_service' => $resolvedService,
            'plan_job_used' => 0,
            'plan_internship_used' => 0,
            'plan_job_limit' => $jobLimit,
            'plan_opportunity_limit' => $opportunityLimit,
            'updated_at' => now(),
        ];

        if ($user instanceof User) {
            $user->forceFill($payload)->save();
        } else {
            DB::table('users')->where('id', $user->id ?? $user)->update($payload);
        }
    }

    /**
     * Clear plan on expire / cancel:
     * - active_plan_id = 0
     * - plan_service = null
     * - usage counters = 0
     * - per-user limits = null
     */
    public static function clearPlanForUser($user): void
    {
        if (!$user) {
            return;
        }

        $payload = [
            'active_plan_id' => 0,
            'plan_service' => null,
            'plan_job_used' => 0,
            'plan_internship_used' => 0,
            'plan_job_limit' => null,
            'plan_opportunity_limit' => null,
            'updated_at' => now(),
        ];

        if ($user instanceof User) {
            $user->forceFill($payload)->save();
        } else {
            $userId = is_object($user) ? ($user->id ?? null) : $user;
            if ($userId) {
                DB::table('users')->where('id', $userId)->update($payload);
            }
        }
    }

    /**
     * Resolve job/internship tab visibility from plan service.
     * service: none | all | job | internship (opportunity accepted as alias)
     */
    public static function serviceFlags(?self $plan): array
    {
        // No active plan → keep both tabs visible (legacy behaviour)
        if (!$plan) {
            return [
                'service' => 'all',
                'show_job_tab' => true,
                'show_internship_tab' => true,
                'service_limit' => null,
            ];
        }

        $service = self::normalizeService($plan->service ?? 'none');

        return [
            'service' => $service,
            'show_job_tab' => in_array($service, ['all', 'job'], true),
            'show_internship_tab' => in_array($service, ['all', 'internship'], true),
            'service_limit' => $plan->service_limit !== null ? (int) $plan->service_limit : null,
            'job_limit' => $plan->job_limit !== null ? (int) $plan->job_limit : null,
            'opportunity_limit' => $plan->opportunity_limit !== null ? (int) $plan->opportunity_limit : null,
        ];
    }

    /**
     * Whether user active plan includes job or internship service.
     *
     * @param  \App\Models\User|null  $user
     * @param  string  $type  job|internship|opportunity
     */
    public static function hasPlanService($user, string $type): bool
    {
        if (!$user) {
            return false;
        }

        $type = self::normalizeType($type);

        $planId = (int) ($user->active_plan_id ?? 0);
        if ($planId <= 0) {
            return false;
        }

        // Per-user override from admin Update Plan modal
        $rawUserService = strtolower(trim((string) ($user->plan_service ?? '')));
        if (in_array($rawUserService, ['none', 'all', 'job', 'internship', 'opportunity'], true)) {
            $userService = self::normalizeService($rawUserService);
            $showJob = in_array($userService, ['all', 'job'], true);
            $showInternship = in_array($userService, ['all', 'internship'], true);

            return $type === 'internship' ? $showInternship : $showJob;
        }

        $plan = self::find($planId);
        if (!$plan) {
            return false;
        }

        $flags = self::serviceFlags($plan);

        if ($type === 'internship') {
            return !empty($flags['show_internship_tab']);
        }

        return !empty($flags['show_job_tab']);
    }

    /**
     * Active plan limit for a type (job|internship).
     * null = unlimited; 0 = no quota (expired / none / not included).
     */
    public static function getActivePlanServiceLimit($user, ?string $type = null): ?int
    {
        if (!$user) {
            return 0;
        }

        $planId = (int) ($user->active_plan_id ?? 0);
        if ($planId <= 0) {
            return 0;
        }

        $plan = self::find($planId);
        if (!$plan) {
            return 0;
        }

        $type = $type ? self::normalizeType($type) : 'job';

        // 1) Per-user override from admin Update Plan modal
        if ($type === 'internship') {
            if (isset($user->plan_opportunity_limit) && $user->plan_opportunity_limit !== null && $user->plan_opportunity_limit !== '') {
                return max(0, (int) $user->plan_opportunity_limit);
            }
        } else {
            if (isset($user->plan_job_limit) && $user->plan_job_limit !== null && $user->plan_job_limit !== '') {
                return max(0, (int) $user->plan_job_limit);
            }
        }

        // 2) Plan pricing defaults
        if ($type === 'internship') {
            if ($plan->opportunity_limit !== null && $plan->opportunity_limit !== '') {
                return max(0, (int) $plan->opportunity_limit);
            }
        } else {
            if ($plan->job_limit !== null && $plan->job_limit !== '') {
                return max(0, (int) $plan->job_limit);
            }
        }

        // 3) Legacy single column fallback
        if ($plan->service_limit === null || $plan->service_limit === '') {
            return null; // unlimited
        }

        return max(0, (int) $plan->service_limit);
    }

    /**
     * Usage from user counters (reset on purchase, zero on expire).
     */
    public static function countServiceUsage($user, string $type, string $action = 'apply'): int
    {
        if (!$user) {
            return 0;
        }

        $type = self::normalizeType($type);

        if ($type === 'internship') {
            return (int) ($user->plan_internship_used ?? 0);
        }

        return (int) ($user->plan_job_used ?? 0);
    }

    /**
     * Increment usage after successful create/apply.
     */
    public static function incrementServiceUsage($user, string $type): void
    {
        if (!$user) {
            return;
        }

        $type = self::normalizeType($type);
        $column = $type === 'internship' ? 'plan_internship_used' : 'plan_job_used';

        DB::table('users')->where('id', $user->id)->increment($column);

        if ($user instanceof User) {
            $user->{$column} = (int) ($user->{$column} ?? 0) + 1;
        }
    }

    /**
     * Check whether user is still within plan service_limit for create/apply.
     * When service=all and limit=1 → 1 job AND 1 opportunity separately.
     * No active plan → limit 0 (blocked).
     *
     * @return array{allowed:bool,limit:?int,used:int,remaining:?int,message:?string,upgrade_url:?string}
     */
    public static function checkServiceLimit($user, string $type, string $action = 'apply'): array
    {
        $type = self::normalizeType($type);
        $label = $type === 'internship' ? 'Internship' : 'Job';
        $planId = (int) ($user->active_plan_id ?? 0);
        $upgradeUrl = null;
        try {
            if ($user && !empty($user->id)) {
                $upgradeUrl = route('pricing', ['user_id' => $user->id]);
            }
        } catch (\Throwable $e) {
            $upgradeUrl = null;
        }

        if (!$user || $planId <= 0) {
            return [
                'allowed' => false,
                'limit' => 0,
                'used' => 0,
                'remaining' => 0,
                'message' => 'Your plan has expired or is not active. Please upgrade your plan to continue.',
                'upgrade_url' => $upgradeUrl,
            ];
        }

        $limit = self::getActivePlanServiceLimit($user, $type);
        $used = self::countServiceUsage($user, $type, $action);

        // Unlimited plan
        if ($limit === null) {
            return [
                'allowed' => true,
                'limit' => null,
                'used' => $used,
                'remaining' => null,
                'message' => null,
                'upgrade_url' => $upgradeUrl,
            ];
        }

        $remaining = max(0, $limit - $used);
        $allowed = $used < $limit;
        $actionPhrase = $action === 'create' ? 'creating' : 'applying to';

        return [
            'allowed' => $allowed,
            'limit' => $limit,
            'used' => $used,
            'remaining' => $remaining,
            'message' => $allowed ? null : (
                "Your plan allows {$actionPhrase} only {$limit} {$label}" . ($limit === 1 ? '' : 's') .
                ". Limit reached. Please upgrade your plan to continue."
            ),
            'upgrade_url' => $upgradeUrl,
        ];
    }

    /**
     * Whether an employee may apply for a job or internship based on active plan service.
     *
     * @param  \App\Models\User|null  $user
     * @param  string  $type  job|internship
     */
    public static function employeeCanApply($user, string $type): bool
    {
        if (!$user || ($user->profile_type ?? '') !== 'Employee') {
            return false;
        }

        return self::hasPlanService($user, $type);
    }

    /**
     * Whether a company may post a job or internship based on active plan service.
     *
     * @param  \App\Models\User|null  $user
     * @param  string  $type  job|internship
     */
    public static function companyCanPost($user, string $type): bool
    {
        if (!$user || ($user->profile_type ?? '') !== 'Company') {
            return false;
        }

        return self::hasPlanService($user, $type);
    }
}
