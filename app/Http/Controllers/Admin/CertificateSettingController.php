<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StaffActivityController;
use App\Models\CertificateSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CertificateSettingController extends Controller
{
    public function index()
    {
        $company = CertificateSetting::forType('company');
        $college = CertificateSetting::forType('college');

        return view('admin.internship.certificate-settings', compact('company', 'college'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cert_type' => 'required|in:company,college',
            'brand_title' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_label' => 'nullable|string|max:255',
            'certify_text' => 'nullable|string|max:255',
            'student_of_text' => 'nullable|string|max:255',
            'pursuing_text' => 'nullable|string|max:255',
            'completed_text' => 'nullable|string|max:255',
            'conducted_by_text' => 'nullable|string|max:255',
            'association_text' => 'nullable|string|max:255',
            'awarded_by_text' => 'nullable|string|max:255',
            'disclaimer_text' => 'nullable|string|max:2000',
            'left_signatory_role' => 'nullable|string|max:255',
            'platform_director_name' => 'nullable|string|max:255',
            'platform_director_role' => 'nullable|string|max:255',
            'seal_line1' => 'nullable|string|max:50',
            'seal_line2' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', $request->input('cert_type', 'company'));
        }

        $type = $request->input('cert_type');

        CertificateSetting::updateOrCreate(
            ['cert_type' => $type],
            [
                'cert_type' => $type,
                'brand_title' => $request->input('brand_title'),
                'heading' => $request->input('heading'),
                'subtitle' => $request->input('subtitle'),
                'badge_label' => $request->input('badge_label'),
                'certify_text' => $request->input('certify_text'),
                'student_of_text' => $request->input('student_of_text'),
                'pursuing_text' => $request->input('pursuing_text'),
                'completed_text' => $request->input('completed_text'),
                'conducted_by_text' => $request->input('conducted_by_text'),
                'association_text' => $request->input('association_text'),
                'awarded_by_text' => $request->input('awarded_by_text'),
                'disclaimer_text' => $request->input('disclaimer_text'),
                'left_signatory_role' => $request->input('left_signatory_role'),
                'platform_director_name' => $request->input('platform_director_name'),
                'platform_director_role' => $request->input('platform_director_role'),
                'seal_line1' => $request->input('seal_line1'),
                'seal_line2' => $request->input('seal_line2'),
            ]
        );

        if (Auth::check()) {
            StaffActivityController::insertActivity(
                Auth::id(),
                'Updated ' . ucfirst($type) . ' certificate settings'
            );
        }

        return redirect()
            ->route('admin.internship.certificate-settings')
            ->with('success', ucfirst($type) . ' certificate settings saved successfully.')
            ->with('active_tab', $type);
    }
}
