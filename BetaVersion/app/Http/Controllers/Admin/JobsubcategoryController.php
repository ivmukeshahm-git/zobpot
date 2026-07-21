<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobCategory;
use App\Models\Jobsubcategory;
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
}
