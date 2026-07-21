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
                    'benefits',
                    'plan_duration',
                    'plan_time',
                    'status',
                    'created_at',
                ])
                ->whereNull('deleted_at'); // If you're using SoftDeletes

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('price_duration', function ($row) {
                    return $row->plan_price . ' / ' . $row->plan_time . ' ' . ($row->plan_duration == 'Y' ? 'Year' : ($row->plan_duration == 'M' ? 'Month' : 'Day'));
                })
                ->editColumn('status', function ($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
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
        $validator = Validator::make($request->all(), [
            'plan_name'        => 'required|string|max:255',
            'plan_price'       => 'required|numeric',
            'plan_description' => 'nullable|string',
            'plan_for'         => 'required|string', // or array if needed
            'plan_benefits'         => 'nullable',        // array or string
            'plan_duration'    => 'required|string',
            'duration_time'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Convert benefits to comma-separated string if it's an array
            $benefits = $request->input('plan_benefits');
            if (is_array($benefits)) {
                $benefits = implode(',', array_map('trim', $benefits));
            }

            $plan = PlanPricing::create([
                'plan_name'        => $request->input('plan_name'),
                'plan_price'       => $request->input('plan_price'),
                'plan_description' => $request->input('plan_description'),
                'plan_for'         => $request->input('plan_for'),
                'benefits'         => $benefits,
                'plan_duration'    => $request->input('plan_duration'),
                'plan_time'        => $request->input('duration_time'),
                'status'           => 1,
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
        $validator = Validator::make($request->all(), [
            'plan_name'        => 'required|string|max:255',
            'plan_price'       => 'required|numeric',
            'plan_description' => 'nullable|string',
            'plan_for'         => 'required|string',
            'plan_benefits'    => 'nullable',
            'plan_duration'    => 'required|string',
            'duration_time'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $plan = PlanPricing::findOrFail($id);

            $benefits = $request->input('plan_benefits');
            if (is_array($benefits)) {
                $benefits = implode(',', array_map('trim', $benefits));
            }

            $plan->update([
                'plan_name'        => $request->input('plan_name'),
                'plan_price'       => $request->input('plan_price'),
                'plan_description' => $request->input('plan_description'),
                'plan_for'         => $request->input('plan_for'),
                'benefits'         => $benefits,
                'plan_duration'    => $request->input('plan_duration'),
                'plan_time'        => $request->input('duration_time'),
                'status'           => 1,
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
}
