<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobCategory;
use App\Models\Jobsubcategory;
use App\Models\CategorySubcategoryRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;

class JobsubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $JobCategory = JobCategory::get();
        return view('admin.jobsubcategory.job-sub-category', compact('JobCategory'));
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Jobsubcategory::select([
                'tbl_sub_category.sub_category_id',
                'tbl_sub_category.category_id',
                'tbl_sub_category.sub_category_nm',
                'tbl_sub_category.created_at',
                'tbl_job_category.category_nm',
            ])
                ->leftJoin('tbl_job_category', 'tbl_sub_category.category_id', '=', 'tbl_job_category.category_id');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';
                    if (auth()->user()->can('SubCategory-Edit')) {
                        $actions .= '<button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>';
                    }

                    if (auth()->user()->can('SubCategory-Delete')) {
                        $actions .= '<button type="button" class="btn delete-sub-cetegory-btn btn-sm rounded-pill btn-icon btn-danger">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>';
                    }

                    return $actions;
                })
                ->filterColumn('category_nm', function ($query, $keyword) {
                    $query->where('tbl_job_category.category_nm', 'like', "%$keyword%");
                })
                ->filterColumn('sub_category_nm', function ($query, $keyword) {
                    $query->where('tbl_sub_category.sub_category_nm', 'like', "%$keyword%");
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return abort(403, 'Unauthorized');
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
        $request->validate([
            'category_id' => 'required|integer|exists:tbl_job_category,category_id',
            'sub_category_nm' => 'required|string|max:255',
        ]);

        try {
            // Create the subcategory with both fields
            $Subcategory = Jobsubcategory::create([
                'category_id' => $request->input('category_id'),
                'sub_category_nm' => $request->input('sub_category_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Subcategory Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Job Subcategory created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create Job Subcategory.',
            ]);
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
        $request->validate([
            'category_id' => 'required|integer|exists:tbl_job_category,category_id',
            'sub_category_nm' => 'required|string|max:255',
        ]);

        try {
            // Find the subcategory
            $subcategory = Jobsubcategory::findOrFail($id);

            // Update the subcategory
            $subcategory->update([
                'category_id' => $request->input('category_id'),
                'sub_category_nm' => $request->input('sub_category_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Subcategory Update Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Job Sub Category updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update Job Subcategory.'
            ]);
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
        $category = Jobsubcategory::findOrFail($id);

        if (!$category) {
            return response()->json([
                'status' => 0,
                'message' => 'Job Sub Category not found.',
            ]);
        }

        $category->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Job Subcategory Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Job Sub Category deleted successfully.',
        ]);
    }

    public function getSubcategoryRequestsTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = CategorySubcategoryRequest::select([
                    'tbl_category_subcategory_requests.id',
                    'tbl_category_subcategory_requests.requested_name',
                    'tbl_category_subcategory_requests.category_id',
                    'tbl_category_subcategory_requests.parent_category_name',
                    'tbl_category_subcategory_requests.status',
                    'tbl_category_subcategory_requests.created_at',
                    'users.name as company_name',
                    'users.email as company_email',
                    'tbl_job_category.category_nm',
                    'parent_req.requested_name as requested_category_name',
                ])
                ->leftJoin('users', 'users.id', '=', 'tbl_category_subcategory_requests.user_id')
                ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'tbl_category_subcategory_requests.category_id')
                ->leftJoin('tbl_category_subcategory_requests as parent_req', function ($join) {
                    $join->on('parent_req.internship_id', '=', 'tbl_category_subcategory_requests.internship_id')
                        ->where('parent_req.request_type', '=', 'category')
                        ->whereColumn('parent_req.id', '!=', 'tbl_category_subcategory_requests.id');
                })
                ->where('tbl_category_subcategory_requests.request_type', 'subcategory')
                ->where('tbl_category_subcategory_requests.status', CategorySubcategoryRequest::STATUS_PENDING);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('category_nm', function ($row) {
                    return $row->category_nm
                        ?: ($row->parent_category_name ?: ($row->requested_category_name ?: '-'));
                })
                ->addColumn('status_label', function ($row) {
                    if ($row->status == CategorySubcategoryRequest::STATUS_APPROVED) {
                        return '<span class="badge bg-success">Approved</span>';
                    }
                    if ($row->status == CategorySubcategoryRequest::STATUS_REJECTED) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    }
                    return '<span class="badge bg-warning">Pending</span>';
                })
                ->addColumn('action', function ($row) {
                    if ($row->status != CategorySubcategoryRequest::STATUS_PENDING) {
                        return '-';
                    }

                    return '
                        <button type="button" class="btn btn-sm btn-success approve-subcategory-request-btn" data-id="' . $row->id . '">Approve</button>
                        <button type="button" class="btn btn-sm btn-danger reject-subcategory-request-btn" data-id="' . $row->id . '">Reject</button>
                    ';
                })
                ->filterColumn('requested_name', function ($query, $keyword) {
                    $query->where('tbl_category_subcategory_requests.requested_name', 'like', "%$keyword%");
                })
                ->filterColumn('category_nm', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('tbl_job_category.category_nm', 'like', "%$keyword%")
                            ->orWhere('tbl_category_subcategory_requests.parent_category_name', 'like', "%$keyword%")
                            ->orWhere('parent_req.requested_name', 'like', "%$keyword%");
                    });
                })
                ->filterColumn('company_name', function ($query, $keyword) {
                    $query->where('users.name', 'like', "%$keyword%");
                })
                ->rawColumns(['status_label', 'action'])
                ->make(true);
        }

        return abort(403, 'Unauthorized');
    }

    public function approveSubcategoryRequest($id)
    {
        try {
            $requestRecord = CategorySubcategoryRequest::where('id', $id)
                ->where('request_type', 'subcategory')
                ->where('status', CategorySubcategoryRequest::STATUS_PENDING)
                ->firstOrFail();

            if (!$requestRecord->category_id) {
                $parentRequest = CategorySubcategoryRequest::where('internship_id', $requestRecord->internship_id)
                    ->where('request_type', 'category')
                    ->orderByDesc('id')
                    ->first();

                if ($parentRequest && $parentRequest->approved_id) {
                    $requestRecord->category_id = $parentRequest->approved_id;
                } elseif ($parentRequest && $parentRequest->status == CategorySubcategoryRequest::STATUS_PENDING) {
                    $category = JobCategory::create([
                        'preference_type' => 2,
                        'category_nm' => $parentRequest->requested_name,
                    ]);
                    $parentRequest->update([
                        'status' => CategorySubcategoryRequest::STATUS_APPROVED,
                        'approved_id' => $category->category_id,
                    ]);
                    $requestRecord->category_id = $category->category_id;
                } elseif ($requestRecord->parent_category_name) {
                    $category = JobCategory::create([
                        'preference_type' => 2,
                        'category_nm' => $requestRecord->parent_category_name,
                    ]);
                    $requestRecord->category_id = $category->category_id;
                }
            }

            if (!$requestRecord->category_id) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Cannot approve subcategory request without a parent category.',
                ], 422);
            }

            $subcategory = Jobsubcategory::create([
                'category_id' => $requestRecord->category_id,
                'sub_category_nm' => $requestRecord->requested_name,
            ]);

            $requestRecord->update([
                'status' => CategorySubcategoryRequest::STATUS_APPROVED,
                'approved_id' => $subcategory->sub_category_id,
            ]);

            if ($requestRecord->internship_id) {
                $internship = \App\Models\Internship::find($requestRecord->internship_id);
                if ($internship) {
                    $subCategories = is_array($internship->sub_categories) ? $internship->sub_categories : [];
                    $subCategories[] = (int) $subcategory->sub_category_id;
                    $internship->update(['sub_categories' => array_values(array_unique($subCategories))]);
                }
            }

            StaffActivityController::insertActivity(Auth::user()->id, 'Subcategory request approved: ' . $requestRecord->requested_name);

            return response()->json([
                'status' => 1,
                'message' => 'Subcategory request approved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to approve subcategory request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function rejectSubcategoryRequest($id)
    {
        try {
            $requestRecord = CategorySubcategoryRequest::where('id', $id)
                ->where('request_type', 'subcategory')
                ->where('status', CategorySubcategoryRequest::STATUS_PENDING)
                ->firstOrFail();

            $requestRecord->update([
                'status' => CategorySubcategoryRequest::STATUS_REJECTED,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Subcategory request rejected: ' . $requestRecord->requested_name);

            return response()->json([
                'status' => 1,
                'message' => 'Subcategory request rejected successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to reject subcategory request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
