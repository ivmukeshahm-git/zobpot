<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\StaffActivityController;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.partners.index');
    }

    // ================= DATATABLE =================
    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {

            $data = Partner::select(['id','name','image','status'])
            ->whereNull('deleted_at');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('images', function ($row) {
                    $img = $row->image ? $row->image : 'noimage.png';
                    $url = asset('uploads/partner_img/'.$img);
                    return '<img src="'.$url.'" style="height:60px;">';
                })

                ->addColumn('status_label', function ($row) {
                    return $row->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {

                    $btn = '';

                    if(Auth::user()->can('Partner-Edit')){
                        $btn .= '
                        <button class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning me-1">
                            <i class="bx bx-edit"></i>
                        </button>';
                    }

                    if(Auth::user()->can('Partner-Delete')){
                        $btn .= '
                        <button class="btn delete-partner-btn btn-sm rounded-pill btn-icon btn-danger">
                            <i class="bx bx-trash"></i>
                        </button>';
                    }

                    return $btn;
                })

                ->rawColumns(['images','action','status_label'])
                ->make(true);
        }
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'profile_img_upload' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>0,
                'message'=>$validator->errors()->first()
            ]);
        }

        try{
            $fileName = null;

            if($request->hasFile('profile_img_upload')){
                $img = $request->file('profile_img_upload');
                $fileName = time().'.'.$img->getClientOriginalExtension();

                $path = public_path('uploads/partner_img');
                if(!file_exists($path)){
                    mkdir($path,0777,true);
                }

                // Image::make($img)->fit(100,100)->save($path.'/'.$fileName);
                Image::make($img)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path.'/'.$fileName);
            }

            Partner::create([
                'name'=>$request->username,
                'image'=>$fileName,
                'status'=>$request->status,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id,'Partner Added');

            return response()->json([
                'status'=>1,
                'message'=>'Partner Added Successfully'
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status'=>0,
                'message'=>$th->getMessage()
            ]);
        }
    }

    // ================= UPDATE =================
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'profile_img_upload' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>0,
                'message'=>$validator->errors()->first()
            ]);
        }

        try{
            $partner = Partner::findOrFail($id);
            $fileName = $partner->image;

            if($request->hasFile('profile_img_upload')){

                if($fileName && file_exists(public_path('uploads/partner_img/'.$fileName))){
                    unlink(public_path('uploads/partner_img/'.$fileName));
                }

                $img = $request->file('profile_img_upload');
                $fileName = time().'.'.$img->getClientOriginalExtension();

                $path = public_path('uploads/partner_img');
                if(!file_exists($path)){
                    mkdir($path,0777,true);
                }

                // Image::make($img)->fit(100,100)->save($path.'/'.$fileName);
                Image::make($img)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($path.'/'.$fileName);
            }

            $partner->update([
                'name'=>$request->username,
                'image'=>$fileName,
                'status'=>$request->status,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id,'Partner Updated');

            return response()->json([
                'status'=>1,
                'message'=>'Partner Updated Successfully'
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status'=>0,
                'message'=>'Update Failed'
            ]);
        }
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        try{
            $partner = Partner::findOrFail($id);

            $partner->delete();

            StaffActivityController::insertActivity(Auth::user()->id,'Partner Soft Deleted');

            return response()->json([
                'status'=>1,
                'message'=>'Partner Deleted Successfully'
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'status'=>0,
                'message'=>'Delete Failed'
            ]);
        }
    }
}