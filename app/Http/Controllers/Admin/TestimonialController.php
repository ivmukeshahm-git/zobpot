<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
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


class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.testimonial.testimonial');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimonial::select(['id', 'username', 'designation', 'description', 'profile_img']);

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Image column
                ->addColumn('images', function ($row) {
                    $imgUrl = asset('uploads/testimonial_img/' . ($row->profile_img ? $row->profile_img : 'default.png'));
                    return '<img src="' . $imgUrl . '" alt="Blog Image" style="max-width: 150px;">';
                })
                // ✅ Action buttons
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('Testimonial-Edit')) {
                        $actions .= '
            <button type="button" data-id="' . $row->id . '" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
        ';
                    }

                    if (auth()->user()->can('Testimonial-Delete')) {
                        $actions .= '
            <button type="button" data-id="' . $row->id . '" class="btn delete-testimonial-btn btn-sm rounded-pill btn-icon btn-danger">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('username', function ($query, $keyword) {
                    $query->where('username', 'like', "%$keyword%");
                })

                // ✅ Custom search for formatted date
                ->filterColumn('designation', function ($query, $keyword) {
                    $query->where('designation', 'like', "%$keyword%");
                })
                // ✅ Make sure raw HTML is rendered properly
                ->rawColumns(['action', 'images'])

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
            'username'      => 'required|string|max:255',
            'designation'   => 'required|string|max:255',
            'description'   => 'required|string',
            'profile_img_upload' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            $fileName = null;

            if ($request->hasFile('profile_img_upload')) {
                $image = $request->file('profile_img_upload');
                $ext = $image->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/testimonial_img');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }
                Image::make($image->getRealPath())->fit(100, 100)->save($uploadPath . '/' . $fileName, 75);
            }

            $testimonial = Testimonial::create([
                'username'    => $request->input('username'),
                'designation' => $request->input('designation'),
                'description' => $request->input('description'),
                'profile_img' => $fileName,
                'status'      => 1,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Testimonial Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Testimonial created successfully.',
                'data' => $testimonial
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => $th->getMessage()
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
            'username'      => 'required|string|max:255',
            'designation'   => 'required|string|max:255',
            'description'   => 'required|string',
            'profile_img_upload' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try {
            $testimonial = Testimonial::findOrFail($id);
            $fileName = $testimonial->profile_img;

            if ($request->hasFile('profile_img_upload')) {
                if ($fileName && file_exists(public_path('uploads/testimonial_img/' . $fileName))) {
                    unlink(public_path('uploads/testimonial_img/' . $fileName));
                }

                $image = $request->file('profile_img_upload');
                $ext = $image->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/testimonial_img');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }
                \Image::make($image->getRealPath())->fit(300, 300)->save($uploadPath . '/' . $fileName, 75);
            }

            $testimonial->update([
                'username'    => $request->input('username'),
                'designation' => $request->input('designation'),
                'description' => $request->input('description'),
                'profile_img' => $fileName,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Testimonial Update Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Testimonial updated successfully.',
                'data' => $testimonial
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update testimonial.'
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
            $testimonial = Testimonial::findOrFail($id);

            if ($testimonial->profile_img && file_exists(public_path('uploads/testimonial_img/' . $testimonial->profile_img))) {
                unlink(public_path('uploads/testimonial_img/' . $testimonial->profile_img));
            }

            $testimonial->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Testimonial Delete Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Testimonial deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete testimonial.'
            ]);
        }
    }
}
