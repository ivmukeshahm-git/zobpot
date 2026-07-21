<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

use App\Http\Controllers\StaffActivityController;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Setting = Setting::where('id', 1)->first();
        return view('admin.setting.setting', compact('Setting'));
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
        //
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
        try {
            $setting = Setting::findOrFail($id);

            $favicon_name = $setting->favicon;
            $header_logo_name = $setting->header_logo;
            $footer_logo_name = $setting->footer_logo;

            // ✅ Handle file upload
            if ($request->hasFile('favicon_img_upload')) {

                $oldFile = public_path('uploads/logo_img/' . $favicon_name);
                if ($favicon_name && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                $image = $request->file('favicon_img_upload');
                $ext = $image->getClientOriginalExtension();
                $favicon_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/logo_img');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                Image::make($image->getRealPath())
                    ->save($uploadPath . '/' . $favicon_name, 100);
            }


            // ✅ Handle file upload
            if ($request->hasFile('header_logo_img_upload')) {

                $oldFile = public_path('uploads/logo_img/' . $header_logo_name);
                if ($header_logo_name && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                $image = $request->file('header_logo_img_upload');
                $ext = $image->getClientOriginalExtension();
                $header_logo_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/logo_img');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                Image::make($image->getRealPath())
                    ->save($uploadPath . '/' . $header_logo_name, 100);
            }



            // ✅ Handle file upload
            if ($request->hasFile('footer_logo_img_upload')) {

                $oldFile = public_path('uploads/logo_img/' . $footer_logo_name);
                if ($footer_logo_name && file_exists($oldFile)) {
                    unlink($oldFile);
                }

                $image = $request->file('footer_logo_img_upload');
                $ext = $image->getClientOriginalExtension();
                $footer_logo_name = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/logo_img');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                Image::make($image->getRealPath())->save($uploadPath . '/' . $footer_logo_name, 100);
            }


            $setting->update([
                'web_title'       => $request->input('website_title'),
                'web_meta'        => $request->input('website_meta_title'),
                'web_keyword'     => $request->input('website_keyword'),
                'web_description' => $request->input('website_description'),
                'contact_1'       => $request->input('contact_1'),
                'contact_2'       => $request->input('contact_2'),
                'email_1'         => $request->input('email_1'),
                'email_2'         => $request->input('email_2'),
                'Address'         => $request->input('address'),
                'play_store_link' => $request->input('play_store_link'),
                'app_store_link'  => $request->input('app_store_link'),
                 'corporate_address'  => $request->input('corporate_address'),
                'header_logo' => $header_logo_name,
                'footer_logo' => $footer_logo_name,
                'favicon' => $favicon_name,
                'ShowCompanyDetails' => $request->has('ShowCompanyDetails') ? 1 : 0,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Settings Update Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Settings updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => $e->getMessage(),
                'error'   => $e->getMessage() // remove in production
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
        //
    }
}
