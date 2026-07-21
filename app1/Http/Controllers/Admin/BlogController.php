<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\StaffActivityController;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.blog');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::select(['id', 'title', 'desc', 'image', 'status', DB::raw('DATE(datetime) as add_date'), 'desc']);

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Image column
                ->addColumn('images', function ($row) {
                    $imgUrl = asset('uploads/blog_img/' . ($row->image ? $row->image : 'default.png'));
                    return '<img src="' . $imgUrl . '" alt="Blog Image" style="max-width: 150px;">';
                })

                // ✅ Status column
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge rounded-pill bg-success">Published</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-danger">Draft</span>';
                    }
                })

                // ✅ Action buttons
                ->addColumn('action', function ($row) {
                    return '
                    <button type="button" data-id="' . $row->id . '" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
                    <button type="button" data-id="' . $row->id . '" class="btn delete-blog-btn btn-sm rounded-pill btn-icon btn-danger">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>
                ';
                })
                ->filterColumn('title', function ($query, $keyword) {
                    $query->where('title', 'like', "%$keyword%");
                })

                // ✅ Custom search for formatted date
                ->filterColumn('add_date', function ($query, $keyword) {
                    $query->whereRaw("DATE(datetime) like ?", ["%$keyword%"]);
                })
                // ✅ Make sure raw HTML is rendered properly
                ->rawColumns(['action', 'status', 'images'])

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
            'blog_title'          => 'required|string',
            'blog_img_upload' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            $file_name = null;
            if ($request->hasFile('blog_img_upload')) {
                $image = $request->file('blog_img_upload');
                $ext = $image->getClientOriginalExtension();
                $file_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/blog_img');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                // Just move without Intervention
                Image::make($image->getRealPath())
                    ->fit(1000, 500)
                    ->save($uploadPath . '/' . $file_name, 60);
            }

            // ✅ 3. Save blog data
            $blog = Blog::create([
                'title'  => $request->input('blog_title'),
                'desc'   => $request->input('description'),
                'image'  => $file_name,
                'status' => $request->input('action_type'), // default active
                'datetime' => now(),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Blog Added Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Blog created successfully.',
                'data'    => $blog
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 0,
                'message' => 'Something went wrong while creating the blog.'
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

        $validator = Validator::make($request->all(), [
            'blog_title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }

        try {
            $blog = Blog::findOrFail($id);
            $file_name = $blog->image;

            // ✅ Handle file upload
            if ($request->hasFile('blog_img_upload')) {

                $oldFile = public_path('uploads/blog_img/' . $file_name);
                if ($file_name && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                $image = $request->file('blog_img_upload');
                $ext = $image->getClientOriginalExtension();
                $file_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/blog_img');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                Image::make($image->getRealPath())
                    // ->fit(1600, 500)
                    ->fit(900, 500)
                    ->save($uploadPath . '/' . $file_name, 60);
            }

            // ✅ Update model
            $blog->update([
                'title'  => $request->input('blog_title'),
                'desc'   => $request->input('description'),
                'image'  => $file_name,
                'status' => $request->input('action_type'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Blog updated Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Blog updated successfully.',
                'data' => $blog,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update blog.',
                'error' => $th->getMessage() // <— optional during development
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
        try {
            $blog = Blog::findOrFail($id);

            // Delete image from storage
            if ($blog->image) {
                $file = public_path('uploads/blog_img/' . $blog->image);
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $blog->delete(); // Soft delete if model uses SoftDeletes

            StaffActivityController::insertActivity(Auth::user()->id, 'Blog Delete Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Blog deleted successfully.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete blog.'
            ]);
        }
    }
}
