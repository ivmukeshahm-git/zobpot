<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;

use App\Http\Controllers\StaffActivityController;

class AdbannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.adbanner.ad-banner');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = AdBanner::select(['id', 'page_nm', 'ad_link', 'img_nm', 'start_date', 'end_date', 'status']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('page', function ($row) {
                    $pageMap = [
                        1 => 'Home Page',
                        2 => 'Job View Page',
                        3 => 'Company Profile Page',
                        4 => 'Candidate Profile Page',
                    ];

                    return $pageMap[$row->page_nm] ?? 'Unknown';
                })
                ->filterColumn('page', function ($query, $keyword) {
                    $pageMap = [
                        1 => 'Home Page',
                        2 => 'Job View Page',
                        3 => 'Company Profile Page',
                        4 => 'Candidate Profile Page',
                    ];

                    $matchedKeys = [];

                    // Match keyword against readable names (case-insensitive, partial)
                    foreach ($pageMap as $key => $label) {
                        if (stripos($label, $keyword) !== false) {
                            $matchedKeys[] = $key;
                        }
                    }

                    if (!empty($matchedKeys)) {
                        $query->whereIn('page_nm', $matchedKeys);
                    } else {
                        $query->whereRaw('1=0'); // No match = no rows
                    }
                })
                // ✅ Corrected 'status' column with variable use
                ->addColumn('status_row', function ($row) {
                    if ($row->status == 1) {
                        return '<span style="font-size: 12px;" class="badge bg-success">Published</span>';
                    } else {
                        return '<span style="font-size: 12px;" class="badge bg-danger">Draft</span>';
                    }
                })

                // ✅ Image column with fallback
                ->addColumn('images', function ($row) {
                    $imgUrl = asset('uploads/ad_banner_img/' . ($row->img_nm ?? 'default.png'));
                    return '<img src="' . $imgUrl . '" alt="Banner Image" class="img-fluid " style="width: 50px;">';
                })

                // ✅ Action buttons with data-id for JS
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('AdBanner-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
        ';
                    }

                    if (auth()->user()->can('AdBanner-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-ad-banner-btn btn-sm rounded-pill btn-icon btn-danger" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>
        ';
                    }

                    return $actions;
                })



                // ✅ Let HTML be rendered
                ->rawColumns(['status_row', 'images', 'action', 'page'])
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
        // 🧪 Step 1: Validate Inputs
        $validator = Validator::make($request->all(), [
            'page_name'   => 'required|string|max:255|unique:tbl_ad_banner,page_nm',
            'ad_link'     => 'nullable|url',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'banner_img'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }

        try {
            $fileName = null;

            if ($request->hasFile('banner_img')) {
                $image = $request->file('banner_img');
                $ext = $image->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $ext;

                $img_width = $request->input('img_width');
                $img_height = $request->input('img_height');

                $uploadPath = public_path('uploads/ad_banner_img');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                // Just move without Intervention
                Image::make($image->getRealPath())
                    ->fit($img_width, $img_height)
                    ->save($uploadPath . '/' . $fileName, 60);
            }


            // 💾 Step 3: Store data
            AdBanner::create([
                'page_nm'    => $request->input('page_name'),
                'ad_link'    => $request->input('ad_link'),
                'img_nm'     => $fileName,
                'start_date' => $request->input('start_date'),
                'end_date'   => $request->input('end_date'),
                'status'   => $request->input('status'),
                'datetime'   => now()
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Website Ad Banner Added Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Ad banner created successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 0,
                'message' => $th->getMessage(),
            ], 200);
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
        // ✅ Step 1: Validation
        $validator = Validator::make($request->all(), [
            'page_name'   => 'required|string|max:255',
            'ad_link'     => 'nullable|url',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'required|in:0,1',
            'banner_img'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            // ✅ Step 2: Find the Ad Banner
            $adBanner = AdBanner::findOrFail($id);
            $fileName = $adBanner->img_nm; // fallback to existing image
            $oldImagePath = $adBanner->img_nm; // Save old image path

            // ✅ Step 3: Handle image upload (if exists)
            if ($request->hasFile('banner_img')) {
                $image = $request->file('banner_img');
                $ext = $image->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $ext;

                // Remove old image if it exists
                if ($oldImagePath && file_exists(public_path('uploads/ad_banner_img/' . $oldImagePath))) {
                    unlink(public_path('uploads/ad_banner_img/' . $oldImagePath));
                }

                // Dimensions (optional)
                $img_width = $request->input('img_width') ?? 800;
                $img_height = $request->input('img_height') ?? 400;

                // Upload directory
                $uploadPath = public_path('uploads/ad_banner_img');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                // Overwrite or Resize image
                Image::make($image->getRealPath())
                    ->fit($img_width, $img_height)
                    ->save($uploadPath . '/' . $fileName, 70); // 70% quality
            }

            // ✅ Step 4: Update Record
            $adBanner->update([
                'page_nm'    => $request->input('page_name'),
                'ad_link'    => $request->input('ad_link'),
                'img_nm'     => $fileName,
                'start_date' => $request->input('start_date'),
                'end_date'   => $request->input('end_date'),
                'status'     => $request->input('status'),
            ]);


            StaffActivityController::insertActivity(Auth::user()->id, 'Website Ad Banner Update Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Ad banner updated successfully.'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status'  => 0,
                'message' => 'An error occurred: ' . $th->getMessage()
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
            // ✅ Find the banner or fail (404)
            $banner = AdBanner::findOrFail($id);

            // Define image path
            $imagePath = public_path('uploads/ad_banner_img/' . $banner->img_nm);

            // Delete image file if it exists
            if ($banner->img_nm && file_exists($imagePath)) {
                unlink($imagePath);
            }

            // ✅ Soft delete the record
            $banner->delete();

             StaffActivityController::insertActivity(Auth::user()->id, 'Website Ad Banner Delete Successfully.');


            return response()->json([
                'status' => 1,
                'message' => 'Ad banner deleted successfully.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete ad banner.',
                'error' => $e->getMessage() // optional, remove in production
            ], 500);
        }
    }
}
