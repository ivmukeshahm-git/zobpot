<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CollegeSettingsController extends Controller
{
    private function getCollegeId(): ?int
    {
        if (Auth::guard('college')->check()) {
            return (int) Auth::guard('college')->id();
        }

        return null;
    }

    private function getCollege(): ?College
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return null;
        }

        return College::with('university')->find($collegeId);
    }

    public function index()
    {
        $college = $this->getCollege();
        if (!$college) {
            return redirect()->route('admin.college.dashboard')
                ->with('error', 'Only college accounts can access settings.');
        }

        return view('college-dashboard.settings', compact('college'));
    }

    public function update(Request $request)
    {
        $college = $this->getCollege();
        if (!$college) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized access.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'certificate_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'college_signature' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $college->phone = $request->input('phone');
            $college->website = $request->input('website');
            $college->address = $request->input('address');
            $college->city = $request->input('city');
            $college->state = $request->input('state');
            $college->pincode = $request->input('pincode');

            $uploadPath = public_path('uploads/college');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            if ($request->hasFile('certificate_logo')) {
                $image = $request->file('certificate_logo');
                $logoName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                Image::make($image->getRealPath())->save($uploadPath . '/' . $logoName, 100);

                if (!empty($college->certificate_logo) && file_exists($uploadPath . '/' . $college->certificate_logo)) {
                    @unlink($uploadPath . '/' . $college->certificate_logo);
                }

                $college->certificate_logo = $logoName;
            }

            if ($request->input('remove_certificate_logo') == 1 && !empty($college->certificate_logo)) {
                if (file_exists($uploadPath . '/' . $college->certificate_logo)) {
                    @unlink($uploadPath . '/' . $college->certificate_logo);
                }
                $college->certificate_logo = null;
            }

            if ($request->hasFile('college_signature')) {
                $image = $request->file('college_signature');
                $sigName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                Image::make($image->getRealPath())->save($uploadPath . '/' . $sigName, 100);

                if (!empty($college->college_signature) && file_exists($uploadPath . '/' . $college->college_signature)) {
                    @unlink($uploadPath . '/' . $college->college_signature);
                }

                $college->college_signature = $sigName;
            }

            if ($request->input('remove_college_signature') == 1 && !empty($college->college_signature)) {
                if (file_exists($uploadPath . '/' . $college->college_signature)) {
                    @unlink($uploadPath . '/' . $college->college_signature);
                }
                $college->college_signature = null;
            }

            $college->save();

            return response()->json([
                'status' => 1,
                'message' => 'College settings updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong while saving settings.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
