<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobCategory;
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
}
