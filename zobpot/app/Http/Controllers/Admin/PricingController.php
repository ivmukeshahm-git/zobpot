<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;


class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pricing.pricing');
    }
    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_plan_pricing')
                ->select([
                    'plan_id',
                    'plan_name',
                    'plan_price',
                    'plan_description',
                    'plan_for as plan_for_type',
                    'service',
                    'service_limit',
                    'job_limit',
                    'opportunity_limit',
                    'benefits',
                    'plan_duration',
                    'plan_time',
                    'status',
                    'created_at',
                ])
                ->whereNull('deleted_at'); // If you're using SoftDeletes

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('plan_name', function ($row) {
                    return PlanPricing::decodePlanText($row->plan_name);
                })
                ->editColumn('plan_description', function ($row) {
                    return PlanPricing::decodePlanText($row->plan_description);
                })
                ->editColumn('benefits', function ($row) {
                    return PlanPricing::decodePlanText($row->benefits);
                })
                ->addColumn('price_duration', function ($row) {
                    return $row->plan_price . ' / ' . $row->plan_time . ' ' . ($row->plan_duration == 'Y' ? 'Year' : ($row->plan_duration == 'M' ? 'Month' : 'Day'));
                })
                ->editColumn('status', function ($row) {
                    $isActive = (int) $row->status === 1;
                    if (!auth()->user()->can('PlanPricing-Edit')) {
                        return $isActive
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Deactive</span>';
                    }

                    $label = $isActive ? 'Active' : 'Deactive';
                    $class = $isActive ? 'btn-success' : 'btn-danger';

                    return '<button type="button" class="btn btn-sm '.$class.' plan-status-btn" data-id="'.$row->plan_id.'" data-status="'.($isActive ? 1 : 0).'">'.$label.'</button>';
                })->editColumn('plan_for', function ($row) {
                    return '<span class="badge rounded-pill bg-label-secondary">' . ucfirst($row->plan_for_type) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('PlanPricing-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning" data-id="' . $row->plan_id . '">
                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                </button>
        ';
                    }

                    if (auth()->user()->can('PlanPricing-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-plan-btn btn-sm rounded-pill btn-icon btn-danger" data-id="' . $row->plan_id . '">
                    <span class="tf-icons bx bx-trash bx-18px"></span>
                </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('plan_name', function ($query, $keyword) {
                    $query->where('plan_name', 'like', "%$keyword%");
                })
                ->filterColumn('plan_price', function ($query, $keyword) {
                    $query->where('plan_price', 'like', "%$keyword%");
                })
                ->rawColumns(['status', 'action', 'plan_for', 'price_duration'])
                ->make(true);
        }

        return abort(403, 'Unauthorized access.');
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
        $service = PlanPricing::normalizeService($request->input('service', 'none'));
        $request->merge(['service' => $service]);

        $validator = Validator::make($request->all(), [
            'plan_name'           => 'required|string|max:255',
            'plan_price'          => 'required|numeric',
            'plan_description'    => 'nullable|string',
            'plan_for'            => 'required|string',
            'service'             => 'required|in:none,all,job,internship,opportunity',
            'job_limit'           => 'nullable|integer|min:1',
            'opportunity_limit'   => 'nullable|integer|min:1',
            'plan_benefits'       => 'nullable',
            'plan_duration'       => 'required|string',
            'duration_time'       => 'required|string',
        ]);

        $validator->after(function ($validator) use ($service, $request) {
            if (in_array($service, ['all', 'job'], true) && !$request->filled('job_limit')) {
                $validator->errors()->add('job_limit', 'Please enter Job Limit.');
            }
            if (in_array($service, ['all', 'internship'], true) && !$request->filled('opportunity_limit')) {
                $validator->errors()->add('opportunity_limit', 'Please enter Opportunity Limit.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $benefits = $this->normalizePlanBenefits($request->input('plan_benefits'));
            $limits = $this->resolvePlanLimits($service, $request);

            $plan = PlanPricing::create([
                'plan_name'          => $this->cleanPlanText($request->input('plan_name')),
                'plan_price'         => $request->input('plan_price'),
                'plan_description'   => $this->cleanPlanText($request->input('plan_description')),
                'plan_for'           => $request->input('plan_for'),
                'service'            => $service,
                'job_limit'          => $limits['job_limit'],
                'opportunity_limit'  => $limits['opportunity_limit'],
                'service_limit'      => $limits['service_limit'],
                'benefits'           => $benefits,
                'plan_duration'      => $request->input('plan_duration'),
                'plan_time'          => $request->input('duration_time'),
                'status'             => 1,
            ]);

             StaffActivityController::insertActivity(Auth::user()->id, 'Plan Added Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Plan created successfully.',
                'data'    => $plan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to create plan.',
                'error'   => $e->getMessage(),
            ], 500);
        }
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
        $service = PlanPricing::normalizeService($request->input('service', 'none'));
        $request->merge(['service' => $service]);

        $validator = Validator::make($request->all(), [
            'plan_name'           => 'required|string|max:255',
            'plan_price'          => 'required|numeric',
            'plan_description'    => 'nullable|string',
            'plan_for'            => 'required|string',
            'service'             => 'required|in:none,all,job,internship,opportunity',
            'job_limit'           => 'nullable|integer|min:1',
            'opportunity_limit'   => 'nullable|integer|min:1',
            'plan_benefits'       => 'nullable',
            'plan_duration'       => 'required|string',
            'duration_time'       => 'required|string',
        ]);

        $validator->after(function ($validator) use ($service, $request) {
            if (in_array($service, ['all', 'job'], true) && !$request->filled('job_limit')) {
                $validator->errors()->add('job_limit', 'Please enter Job Limit.');
            }
            if (in_array($service, ['all', 'internship'], true) && !$request->filled('opportunity_limit')) {
                $validator->errors()->add('opportunity_limit', 'Please enter Opportunity Limit.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $plan = PlanPricing::findOrFail($id);

            $benefits = $this->normalizePlanBenefits($request->input('plan_benefits'));
            $limits = $this->resolvePlanLimits($service, $request);

            $plan->update([
                'plan_name'          => $this->cleanPlanText($request->input('plan_name')),
                'plan_price'         => $request->input('plan_price'),
                'plan_description'   => $this->cleanPlanText($request->input('plan_description')),
                'plan_for'           => $request->input('plan_for'),
                'service'            => $service,
                'job_limit'          => $limits['job_limit'],
                'opportunity_limit'  => $limits['opportunity_limit'],
                'service_limit'      => $limits['service_limit'],
                'benefits'           => $benefits,
                'plan_duration'      => $request->input('plan_duration'),
                'plan_time'          => $request->input('duration_time'),
                'status'             => 1,
            ]);

             StaffActivityController::insertActivity(Auth::user()->id, 'Plan Update Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Plan updated successfully.',
                'data'    => $plan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to update plan.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Resolve job/opportunity limits from request based on service type.
     * Also keeps legacy service_limit in sync (max of set limits).
     */
    private function resolvePlanLimits(string $service, Request $request): array
    {
        $jobLimit = null;
        $opportunityLimit = null;

        if (in_array($service, ['all', 'job'], true) && $request->filled('job_limit')) {
            $jobLimit = max(1, (int) $request->input('job_limit'));
        }
        if (in_array($service, ['all', 'internship'], true) && $request->filled('opportunity_limit')) {
            $opportunityLimit = max(1, (int) $request->input('opportunity_limit'));
        }

        $legacy = null;
        if ($jobLimit !== null || $opportunityLimit !== null) {
            $legacy = max($jobLimit ?? 0, $opportunityLimit ?? 0) ?: null;
        }

        return [
            'job_limit' => $jobLimit,
            'opportunity_limit' => $opportunityLimit,
            'service_limit' => $legacy,
        ];
    }

    public function updateStatus(Request $request)
    {
        if (!auth()->user()->can('PlanPricing-Edit')) {
            return response()->json([
                'status' => 0,
                'message' => 'You are not allowed to change plan status.',
            ], 403);
        }

        $plan = PlanPricing::find($request->input('plan_id'));
        if (!$plan) {
            return response()->json([
                'status' => 0,
                'message' => 'Plan not found.',
            ], 404);
        }

        $plan->status = (int) $plan->status === 1 ? 0 : 1;
        $plan->save();

        $isActive = (int) $plan->status === 1;
        StaffActivityController::insertActivity(
            Auth::user()->id,
            $isActive ? 'Plan activated successfully.' : 'Plan deactivated successfully.'
        );

        return response()->json([
            'status' => 1,
            'plan_status' => $isActive ? 1 : 0,
            'message' => $isActive
                ? 'Plan activated. It is visible on the website.'
                : 'Plan deactivated. It is hidden on the website.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $plan = PlanPricing::findOrFail($id);
            $plan->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Plan Delete Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Plan deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to delete plan.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Keep only non-empty benefit rows and store as CSV.
     * Decode HTML entities so "&amp;" is never persisted as literal text.
     */
    private function normalizePlanBenefits($benefits): ?string
    {
        if (is_string($benefits)) {
            $benefits = explode(',', $benefits);
        }

        if (!is_array($benefits)) {
            return null;
        }

        $clean = [];
        foreach ($benefits as $benefit) {
            if (is_array($benefit)) {
                $benefit = $benefit['name'] ?? '';
            }

            $text = PlanPricing::decodePlanText(trim((string) $benefit));
            if ($text === '' || strtolower($text) === 'null') {
                continue;
            }

            $clean[] = $text;
        }

        return empty($clean) ? null : implode(',', $clean);
    }

    /**
     * Decode HTML entities on text fields before save.
     */
    private function cleanPlanText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $text = PlanPricing::decodePlanText(trim($value));

        return $text === '' ? null : $text;
    }
}
