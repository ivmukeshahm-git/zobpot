<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobCategory;
use App\Models\Jobsubcategory;
use App\Models\CategorySubcategoryRequest;
use App\Models\Internship;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

use Intervention\Image\Facades\Image;

use App\Http\Controllers\StaffActivityController;


class JobcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jobcategory.job-category');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = JobCategory::select(['category_id', 'preference_type', 'image', 'category_nm', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('preference_type_name', function ($row) {
                    if ($row->preference_type == 1) {
                        $name = 'Skilled';
                        $color = 'bg-success'; // green
                    } elseif ($row->preference_type == 2) {
                        $name = 'Non Skilled';
                        $color = 'bg-warning'; // yellow
                    } else {
                        $name = 'N/A';
                        $color = 'bg-secondary'; // grey
                    }

                    return '<span class="badge ' . $color . '">' . $name . '</span>';
                })


                ->addColumn('images', function ($row) {
                    $imgUrl = asset('uploads/category_img/' . ($row->image ? $row->image : 'default.png'));
                    return '<img src="' . $imgUrl . '" alt="Category Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">';
                })
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('Category-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                <span class="tf-icons bx bx-edit-alt bx-18px"></span>
            </button>
        ';
                    }

                    if (auth()->user()->can('Category-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-cetegory-btn btn-sm rounded-pill btn-icon btn-danger">
                <span class="tf-icons bx bx-trash bx-18px"></span>
            </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('category_nm', function ($query, $keyword) {
                    $query->where('category_nm', 'like', "%$keyword%");
                })
                ->rawColumns(['action', 'images', 'preference_type_name'])
                ->make(true);
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
        $validator = Validator::make($request->all(), [
            'category_nm' => 'required|string|max:255',
            'job_preference_type' => 'required',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file_name = null;
            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image');
                $ext = $image->getClientOriginalExtension();
                $file_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/category_img');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                // Just move without Intervention
                Image::make($image->getRealPath())
                    ->fit(100, 100)
                    ->save($uploadPath . '/' . $file_name, 60);
            }

            // Save to DB
            JobCategory::create([
                'preference_type' =>  $request->input('job_preference_type'),
                'category_nm' => $request->input('category_nm'),
                'image' => $file_name,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Category Added Successfully.');


            return response()->json([
                'status' => 1,
                'message' => 'Job category created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create job category.',
                'error' => $e->getMessage()
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
        $request->validate([
            'category_nm' => 'required|string|max:255',
            'job_preference_type' => 'required',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $category = JobCategory::findOrFail($id);

        try {
            $oldImagePath = $category->image; // Save old image path
            $file_name = $oldImagePath;

            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image');
                $ext = $image->getClientOriginalExtension();
                $file_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/category_img');

                // Create folder if it doesn't exist
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                // Resize and compress the image
                Image::make($image)
                    ->fit(100, 100)
                    ->encode($ext, 60)
                    ->save($uploadPath . '/' . $file_name);

                // Remove old image if it exists
                if ($oldImagePath && file_exists(public_path('uploads/category_img/' . $oldImagePath))) {
                    unlink(public_path('uploads/category_img/' . $oldImagePath));
                }
            }

            // Update database
            $category->update([
                'preference_type' =>  $request->input('job_preference_type'),
                'category_nm' => $request->input('category_nm'),
                'image' => $file_name, // store just the filename
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Category Update Successfully.');


            return response()->json([
                'status' => 1,
                'message' => 'Job category updated successfully.',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update category.',
                'error' => $e->getMessage()
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
            $category = JobCategory::findOrFail($id);

            // Define image path
            $imagePath = public_path('uploads/category_img/' . $category->image);

            // Delete image file if it exists
            if ($category->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the database record
            $category->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Category Delete Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Job category deleted successfully.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete job category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCategoryRequestsTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = CategorySubcategoryRequest::select([
                    'tbl_category_subcategory_requests.id',
                    'tbl_category_subcategory_requests.requested_name',
                    'tbl_category_subcategory_requests.status',
                    'tbl_category_subcategory_requests.created_at',
                    'users.name as company_name',
                    'users.email as company_email',
                ])
                ->leftJoin('users', 'users.id', '=', 'tbl_category_subcategory_requests.user_id')
                ->where('tbl_category_subcategory_requests.request_type', 'category')
                ->where('tbl_category_subcategory_requests.status', CategorySubcategoryRequest::STATUS_PENDING);

            return DataTables::of($data)
                ->addIndexColumn()
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
                        <button type="button" class="btn btn-sm btn-success approve-category-request-btn" data-id="' . $row->id . '">Approve</button>
                        <button type="button" class="btn btn-sm btn-danger reject-category-request-btn" data-id="' . $row->id . '">Reject</button>
                    ';
                })
                ->filterColumn('requested_name', function ($query, $keyword) {
                    $query->where('tbl_category_subcategory_requests.requested_name', 'like', "%$keyword%");
                })
                ->filterColumn('company_name', function ($query, $keyword) {
                    $query->where('users.name', 'like', "%$keyword%");
                })
                ->rawColumns(['status_label', 'action'])
                ->make(true);
        }

        return abort(403, 'Unauthorized');
    }

    public function approveCategoryRequest($id)
    {
        try {
            $requestRecord = CategorySubcategoryRequest::where('id', $id)
                ->where('request_type', 'category')
                ->where('status', CategorySubcategoryRequest::STATUS_PENDING)
                ->firstOrFail();

            $category = JobCategory::create([
                'preference_type' => 2,
                'category_nm' => $requestRecord->requested_name,
            ]);

            $requestRecord->update([
                'status' => CategorySubcategoryRequest::STATUS_APPROVED,
                'approved_id' => $category->category_id,
            ]);

            if ($requestRecord->internship_id) {
                Internship::where('id', $requestRecord->internship_id)
                    ->update(['category' => $category->category_id]);
            }

            $approvedSubCount = $this->autoApproveRelatedSubcategoryRequests($requestRecord, $category);

            StaffActivityController::insertActivity(Auth::user()->id, 'Category request approved: ' . $requestRecord->requested_name);

            $message = 'Category request approved successfully.';
            if ($approvedSubCount > 0) {
                $message = 'Category request approved successfully. Related subcategory request(s) were also approved.';
            }

            return response()->json([
                'status' => 1,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to approve category request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function autoApproveRelatedSubcategoryRequests($categoryRequest, $category)
    {
        $query = CategorySubcategoryRequest::where('request_type', 'subcategory')
            ->where('status', CategorySubcategoryRequest::STATUS_PENDING);

        if ($categoryRequest->internship_id) {
            $query->where('internship_id', $categoryRequest->internship_id);
        } else {
            $query->where('user_id', $categoryRequest->user_id)
                ->where(function ($q) use ($categoryRequest) {
                    $q->where('parent_category_name', $categoryRequest->requested_name)
                        ->orWhereNull('category_id');
                });
        }

        $subRequests = $query->get();
        $approvedCount = 0;

        foreach ($subRequests as $subRequest) {
            $subcategory = Jobsubcategory::create([
                'category_id' => $category->category_id,
                'sub_category_nm' => $subRequest->requested_name,
            ]);

            $subRequest->update([
                'status' => CategorySubcategoryRequest::STATUS_APPROVED,
                'approved_id' => $subcategory->sub_category_id,
                'category_id' => $category->category_id,
                'parent_category_name' => $subRequest->parent_category_name ?: $categoryRequest->requested_name,
            ]);

            if ($subRequest->internship_id) {
                $internship = Internship::find($subRequest->internship_id);
                if ($internship) {
                    $subCategories = is_array($internship->sub_categories) ? $internship->sub_categories : [];
                    $subCategories[] = (int) $subcategory->sub_category_id;
                    $internship->update([
                        'category' => $category->category_id,
                        'sub_categories' => array_values(array_unique($subCategories)),
                    ]);
                }
            }

            $approvedCount++;
        }

        if ($approvedCount > 0) {
            StaffActivityController::insertActivity(
                Auth::id(),
                'Auto-approved ' . $approvedCount . ' subcategory request(s) with category: ' . $categoryRequest->requested_name
            );
        }

        return $approvedCount;
    }

    public function rejectCategoryRequest($id)
    {
        try {
            $requestRecord = CategorySubcategoryRequest::where('id', $id)
                ->where('request_type', 'category')
                ->where('status', CategorySubcategoryRequest::STATUS_PENDING)
                ->firstOrFail();

            $requestRecord->update([
                'status' => CategorySubcategoryRequest::STATUS_REJECTED,
            ]);

            // Reject related pending subcategory requests as well
            $subQuery = CategorySubcategoryRequest::where('request_type', 'subcategory')
                ->where('status', CategorySubcategoryRequest::STATUS_PENDING);

            if ($requestRecord->internship_id) {
                $subQuery->where('internship_id', $requestRecord->internship_id);
            } else {
                $subQuery->where('user_id', $requestRecord->user_id)
                    ->where(function ($q) use ($requestRecord) {
                        $q->where('parent_category_name', $requestRecord->requested_name)
                            ->orWhereNull('category_id');
                    });
            }

            $rejectedSubCount = $subQuery->update([
                'status' => CategorySubcategoryRequest::STATUS_REJECTED,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Category request rejected: ' . $requestRecord->requested_name);

            $message = 'Category request rejected successfully.';
            if ($rejectedSubCount > 0) {
                StaffActivityController::insertActivity(
                    Auth::id(),
                    'Auto-rejected ' . $rejectedSubCount . ' subcategory request(s) with category: ' . $requestRecord->requested_name
                );
                $message = 'Category request rejected successfully. Related subcategory request(s) were also rejected.';
            }

            return response()->json([
                'status' => 1,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to reject category request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
