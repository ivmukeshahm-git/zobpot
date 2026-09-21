<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;


class CandidateregisterlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.candidatesregisterlist.candidates-register-list');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Employee')
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_plan_id',
                    'b.plan_name',
                    'a.created_at',
                    's.state_name',
                    'c.city_nm',
                );

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Plan column logic
                ->addColumn('plan', function ($row) {
                    if (is_null($row->active_plan_id)) {
                        return '<span class="badge bg-secondary">No Plan Purchased</span>';
                    } elseif ($row->active_plan_id == 0) {
                        return '<span class="badge bg-danger">Plan Expired</span>';
                    } elseif ($row->plan_name) {
                        return '<span class="badge bg-success">' . e($row->plan_name) . '</span>';
                    } else {
                        return '<span class="badge bg-warning">Unknown Plan</span>';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}");
                    return '
                <a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary" title="View">
                                    <span class="tf-icons fa fa-eye "></span>
                                </a>
                                <button type="button" class="btn btn-sm btn-warning" onclick="ViewPlanHistory(' . $row->id . ')">
                                    Plan History
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="OpenUpdatePlanModal(' . $row->id . ')">
                                    Update Plan
                                </button>';
                })
                 ->filterColumn('name', function ($query, $keyword) {
                    $query->where('a.name', 'like', "%$keyword%");
                })
                 ->filterColumn('email', function ($query, $keyword) {
                    $query->where('a.email', 'like', "%$keyword%");
                })
                 ->filterColumn('contact_no', function ($query, $keyword) {
                    $query->where('a.contact_no', 'like', "%$keyword%");
                })
                 ->filterColumn('state_name', function ($query, $keyword) {
                    $query->where('s.state_name', 'like', "%$keyword%");
                })
                 ->filterColumn('city_nm', function ($query, $keyword) {
                    $query->where('c.city_nm', 'like', "%$keyword%");
                })
                ->rawColumns(['plan', 'action']) // ✅ Allow HTML
                ->make(true);
        }
    }


    public function ViewCandidatesPlanHistory(Request $request)
    {
        $id = $request->input('id'); // user_id

        try {
            // ✅ Fetch plan history with plan details
            $planHistory = DB::table('tbl_plan_history as a')
                ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
                ->select(
                    'a.*',
                    'b.plan_name',
                    'b.plan_price'
                )
                ->where('a.user_id', $id)
                ->orderByDesc('a.id')
                ->get();

            if ($planHistory->isEmpty()) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No plan history found for this user.'
                ]);
            }

            return response()->json([
                'status' => 1,
                'message' => 'Plan History Fetch Successfully.',
                'data' => $planHistory
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 0,
                'message'   => $th->getMessage(), // Hide this in production
            ], 200);
        }
    }

    /**
     * Fetch current plan + available candidate plans for update modal.
     */
    public function getUpdatePlanData(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        try {
            $user = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->where('a.id', $request->user_id)
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Employee')
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.active_plan_id',
                    'a.plan_service',
                    'a.plan_job_limit',
                    'a.plan_opportunity_limit',
                    'a.plan_job_used',
                    'a.plan_internship_used',
                    'b.plan_name',
                    'b.plan_price',
                    'b.plan_time',
                    'b.plan_duration',
                    'b.service as plan_default_service',
                    'b.job_limit as plan_job_limit_default',
                    'b.opportunity_limit as plan_opportunity_limit_default'
                )
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Candidate not found.',
                ]);
            }

            $activeHistory = DB::table('tbl_plan_history')
                ->where('user_id', $user->id)
                ->where('status', 1)
                ->orderByDesc('id')
                ->first();

            // Fallback: show latest history dates when plan marked expired but history remains
            if (!$activeHistory) {
                $activeHistory = DB::table('tbl_plan_history')
                    ->where('user_id', $user->id)
                    ->orderByDesc('id')
                    ->first();
            }

            $plans = DB::table('tbl_plan_pricing')
                ->where('plan_for', 'Employee')
                ->where('status', 1)
                ->whereNull('deleted_at')
                ->orderBy('plan_price')
                ->get(['plan_id', 'plan_name', 'plan_price', 'plan_time', 'plan_duration', 'service', 'job_limit', 'opportunity_limit']);

            // Heal orphan active history in admin modal data too
            if (((int) ($user->active_plan_id ?? 0) === 0) && $activeHistory && (int) $activeHistory->status === 1) {
                $expireOk = $activeHistory->expire_date
                    && Carbon::parse($activeHistory->expire_date)->gte(Carbon::today());
                if ($expireOk) {
                    DB::table('users')->where('id', $user->id)->update([
                        'active_plan_id' => $activeHistory->plan_id,
                        'updated_at' => now(),
                    ]);
                    $user->active_plan_id = $activeHistory->plan_id;
                    if (empty($user->plan_name)) {
                        $user->plan_name = DB::table('tbl_plan_pricing')
                            ->where('plan_id', $activeHistory->plan_id)
                            ->value('plan_name');
                    }
                }
            }

            $currentPlanLabel = 'No Plan Purchased';
            if (is_null($user->active_plan_id)) {
                $currentPlanLabel = 'No Plan Purchased';
            } elseif ((int) $user->active_plan_id === 0) {
                $currentPlanLabel = 'Plan Expired';
            } elseif ($user->plan_name) {
                $currentPlanLabel = $user->plan_name;
            } else {
                $currentPlanLabel = 'Unknown Plan';
            }

            $currentService = $user->plan_service ?: ($user->plan_default_service ?: 'none');

            return response()->json([
                'status' => 1,
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'active_plan_id' => $user->active_plan_id,
                    'current_plan_name' => $currentPlanLabel,
                    'current_plan_price' => $user->plan_price,
                    'current_service' => $currentService,
                    'job_limit' => $user->plan_job_limit ?? $user->plan_job_limit_default,
                    'opportunity_limit' => $user->plan_opportunity_limit ?? $user->plan_opportunity_limit_default,
                    'plan_job_used' => (int) ($user->plan_job_used ?? 0),
                    'plan_internship_used' => (int) ($user->plan_internship_used ?? 0),
                    'purchase_date' => $activeHistory->purchase_date ?? null,
                    'expire_date' => $activeHistory->expire_date ?? null,
                    'plans' => $plans,
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Update candidate active_plan_id and insert plan history.
     */
    public function updatePlan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'plan_id' => 'required|integer|exists:tbl_plan_pricing,plan_id',
            'service' => 'required|in:none,all,job,internship,opportunity',
            'job_limit' => 'nullable|integer|min:1',
            'opportunity_limit' => 'nullable|integer|min:1',
            'note' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $user = DB::table('users')
                ->where('id', $request->user_id)
                ->where('role', 'User')
                ->where('profile_type', 'Employee')
                ->first();

            if (!$user) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'message' => 'Candidate not found.',
                ]);
            }

            $plan = DB::table('tbl_plan_pricing')
                ->where('plan_id', $request->plan_id)
                ->where('plan_for', 'Employee')
                ->where('status', 1)
                ->whereNull('deleted_at')
                ->first();

            if (!$plan) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid candidate plan selected.',
                ]);
            }

            $service = \App\Models\PlanPricing::normalizeService($request->input('service', 'none'));
            $jobLimit = $request->filled('job_limit') ? (int) $request->input('job_limit') : null;
            $opportunityLimit = $request->filled('opportunity_limit') ? (int) $request->input('opportunity_limit') : null;

            if (in_array($service, ['all', 'job'], true) && empty($jobLimit)) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'message' => 'Please enter Job Limit.',
                ]);
            }
            if (in_array($service, ['all', 'internship'], true) && empty($opportunityLimit)) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'message' => 'Please enter Opportunity Limit.',
                ]);
            }

            // Clear limits not included in selected service
            if (!in_array($service, ['all', 'job'], true)) {
                $jobLimit = null;
            }
            if (!in_array($service, ['all', 'internship'], true)) {
                $opportunityLimit = null;
            }

            $isSamePlan = (int) ($user->active_plan_id ?? 0) === (int) $plan->plan_id
                && (int) ($user->active_plan_id ?? 0) > 0
                && DB::table('tbl_plan_history')
                    ->where('user_id', $user->id)
                    ->where('plan_id', $plan->plan_id)
                    ->where('status', 1)
                    ->whereDate('expire_date', '>=', Carbon::today()->toDateString())
                    ->exists();

            if ($isSamePlan) {
                // Same active plan: update service/limits only — keep purchase & expire dates and usage counters
                DB::table('users')->where('id', $user->id)->update([
                    'active_plan_id' => $plan->plan_id,
                    'plan_service' => $service,
                    'plan_job_limit' => $jobLimit,
                    'plan_opportunity_limit' => $opportunityLimit,
                    'updated_at' => now(),
                ]);

                $activeHistoryId = DB::table('tbl_plan_history')
                    ->where('user_id', $user->id)
                    ->where('status', 1)
                    ->where('plan_id', $plan->plan_id)
                    ->orderByDesc('id')
                    ->value('id');

                if ($activeHistoryId) {
                    DB::table('tbl_plan_history')->where('id', $activeHistoryId)->update([
                        'note' => $request->note,
                        'updated_at' => now(),
                    ]);
                }
            } else {
                // New / renewed plan: new purchase/expire dates and reset usage
                $startDate = Carbon::now();
                $duration = (int) $plan->plan_time;
                $expireDate = match (strtoupper(trim($plan->plan_duration))) {
                    'M' => $startDate->copy()->addMonths($duration),
                    'Y' => $startDate->copy()->addYears($duration),
                    'D' => $startDate->copy()->addDays($duration),
                    default => $startDate->copy()->addDays($duration),
                };
                $durationText = $duration . strtoupper(trim($plan->plan_duration));

                DB::table('tbl_plan_history')
                    ->where('user_id', $user->id)
                    ->where('status', 1)
                    ->update([
                        'status' => 0,
                        'updated_at' => now(),
                    ]);

                DB::table('tbl_plan_history')->insert([
                    'plan_id' => $plan->plan_id,
                    'user_id' => $user->id,
                    'purchase_date' => $startDate->toDateString(),
                    'expire_date' => $expireDate->toDateString(),
                    'duration' => $durationText,
                    'status' => 1,
                    'payment_id' => null,
                    'order_id' => null,
                    'note' => $request->note,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                \App\Models\PlanPricing::activatePlanForUser(
                    (object) ['id' => $user->id],
                    $plan,
                    $service,
                    $jobLimit,
                    $opportunityLimit
                );
            }

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => $isSamePlan
                    ? 'Plan limits updated successfully. Purchase and expire dates unchanged.'
                    : 'Plan updated successfully.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
