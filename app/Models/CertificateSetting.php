<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateSetting extends Model
{
    protected $table = 'tbl_certificate_setting';

    protected $fillable = [
        'cert_type',
        'brand_title',
        'heading',
        'subtitle',
        'badge_label',
        'certify_text',
        'student_of_text',
        'pursuing_text',
        'completed_text',
        'conducted_by_text',
        'association_text',
        'awarded_by_text',
        'disclaimer_text',
        'left_signatory_role',
        'platform_director_name',
        'platform_director_role',
        'seal_line1',
        'seal_line2',
    ];

    public static function defaults(string $type): array
    {
        $type = strtolower($type) === 'college' ? 'college' : 'company';

        $shared = [
            'brand_title' => 'ZobPot Internship Portal',
            'heading' => 'Certificate',
            'subtitle' => 'Of Internship Completion',
            'certify_text' => 'This is to certify that',
            'completed_text' => 'has successfully completed the internship programme',
            'disclaimer_text' => 'The intern has demonstrated dedication, professionalism and satisfactory performance throughout the internship duration.',
            'label_certificate_no' => 'Certificate No.',
            'label_duration' => 'Duration',
            'label_period' => 'Period',
            'label_issue_date' => 'Issue Date',
            'label_mode' => 'Mode',
            'platform_director_name' => 'ZobPot',
            'platform_director_role' => 'Platform Director',
            'seal_line1' => 'OFFICIAL',
            'seal_line2' => 'SEAL',
        ];

        if ($type === 'college') {
            return array_merge($shared, [
                'cert_type' => 'college',
                'badge_label' => 'College Certificate',
                'student_of_text' => 'a student of',
                'pursuing_text' => 'pursuing',
                'conducted_by_text' => null,
                'association_text' => 'in association with',
                'awarded_by_text' => 'and is hereby awarded this certificate by',
                'left_signatory_role' => 'College Authorized Signatory',
            ]);
        }

        return array_merge($shared, [
            'cert_type' => 'company',
            'badge_label' => 'Company Certificate',
            'student_of_text' => null,
            'pursuing_text' => null,
            'conducted_by_text' => 'conducted by',
            'association_text' => null,
            'awarded_by_text' => null,
            'left_signatory_role' => 'Authorized Company Signatory',
        ]);
    }

    /**
     * Get settings for certificate type with defaults filled in.
     */
    public static function forType(string $type): array
    {
        $type = strtolower($type) === 'college' ? 'college' : 'company';
        $defaults = self::defaults($type);

        try {
            $row = self::where('cert_type', $type)->first();
        } catch (\Throwable $e) {
            return $defaults;
        }

        if (!$row) {
            return $defaults;
        }

        $data = $row->toArray();
        foreach ($defaults as $key => $value) {
            if (!array_key_exists($key, $data) || $data[$key] === null || $data[$key] === '') {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
