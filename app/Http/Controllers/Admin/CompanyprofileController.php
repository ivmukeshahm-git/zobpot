<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use App\Models\Zipcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\JobCategory;
use App\Models\Minqualification;
use App\Models\Joblevel;
use App\Models\Experiencereq;
use App\Models\Jobtype;
use App\Models\Worktype;


use App\Http\Controllers\StaffActivityController;


class CompanyprofileController extends Controller
{
    public function index(Request $request, $id)
    {
        $userData = DB::table('users')
            ->select([
                'users.*',
                'tbl_state.state_name',
                'tbl_state.state_id',
                'tbl_city.city_nm',
                'tbl_city.city_id',
                'tbl_area.area_nm',
                'tbl_area.area_id',
                'tbl_zipcode.zipcode',
                'tbl_zipcode.zipcode_id',
                'tbl_job_category.category_nm',
                'tbl_sub_category.sub_category_nm',
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
            ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'users.category_id') // <-- New join
            ->leftJoin('tbl_sub_category', 'tbl_sub_category.sub_category_id', '=', 'users.sub_category_id') // <-- New join
            ->where('users.id', $id)
            ->where('users.profile_type', 'Company')
            ->whereNull('users.deleted_at')
            ->first();

        $states = State::select('state_id', 'state_name')->get(); // replace with your table column names
        $user = Auth::user($id); // Or User::find($id)
        $CompanyProfileComplete = $this->calculateProfileCompletion($user);

        $JobData = DB::table('tbl_job')
            ->select([
                'tbl_job.*',
                'tbl_work_type.type_nm as work_type_name',
            ])
            ->leftJoin('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_job.work_type_id')
            ->where('tbl_job.user_id', $id)
            ->whereNull('tbl_job.deleted_at') // ✅ Correct way to check for null
            ->orderBy('tbl_job.job_id', 'desc')
            ->get(); // 👈 Change 6 to how many per page


        $PlanHistoryData = DB::table('tbl_plan_history as a')
            ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
            ->leftJoin('users as c', 'a.user_id', '=', 'c.id')
            ->where('a.user_id', $id)
            ->select([
                'a.*',
                'b.plan_name',
                'b.plan_price',
                DB::raw("CASE WHEN a.plan_id = c.active_plan_id THEN 'Active' ELSE 'Inactive' END as status")
            ])
            ->get();

            $CompanyKycData = DB::table('tbl_company_kyc')
            ->where('company_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $CategoryData = JobCategory::get();
        $MinqualificationData = Minqualification::get();
            $JoblevelData = Joblevel::get();
    $ExperiencereqData = Experiencereq::get();
        $JobtypeData = Jobtype::get();
         $WorktypeData = Worktype::get();

        return view('admin.companyprofile.company-profile', compact('userData', 'states', 'CompanyProfileComplete', 'JobData','PlanHistoryData','CompanyKycData','CategoryData','MinqualificationData','JoblevelData','JoblevelData','JobtypeData','WorktypeData','ExperiencereqData'));
    }


    public function calculateProfileCompletion($user)
    {
        $fields = [
            'designation',
            'name',
            'email',
            'contact_no',
            'city_id',
            'area_id',
            'state_id',
            'zipcode_id',
            'address',
        ];

        $filled = 0;

        foreach ($fields as $field) {
            $value = $user->{$field};

            // Consider as filled if not null and not an empty string (""), even if it's 0
            if (!is_null($value) && $value !== '') {
                $filled++;
            }
        }

        $total = count($fields);
        $completion = round(($filled / $total) * 100);

        return $completion;
    }

    public function UpdateCompanyProfile(Request $request)
    {
        $rules = [
            'company_nm' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_no' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $state_id = 0;
            $city_id = 0;
            $area_id = 0;
            $zipcode_id = 0;

            // STATE
            if ($request->state_id_hidden != null) {
                $CheckState = State::find($request->state_id_hidden);
                if ($CheckState) {
                    $state_id = $CheckState->state_id;
                }
            } elseif ($request->state_id) {
                $AddState = State::create([
                    'state_name' => $request->state_id,
                    'country_id' => 1 // default country ID if applicable
                ]);
                $state_id = $AddState->state_id;
            }

            // CITY
            if ($request->city_id_hidden != null) {
                $CheckCity = City::find($request->city_id_hidden);
                if ($CheckCity) {
                    $city_id = $CheckCity->city_id;
                }
            } elseif ($request->city_id) {
                $AddCity = City::create([
                    'city_nm' => $request->city_id,
                    'state_id'  => $state_id
                ]);
                $city_id = $AddCity->city_id;
            }

            // AREA
            if ($request->area_id_hidden != null) {
                $CheckArea = Area::find($request->area_id_hidden);
                if ($CheckArea) {
                    $area_id = $CheckArea->area_id;
                }
            } elseif ($request->area_id) {
                $AddArea = Area::create([
                    'area_nm' => $request->area_id,
                    'city_id'   => $city_id,
                    'state_id' => $state_id,
                ]);
                $area_id = $AddArea->area_id;
            }

            // PINCODE
            if ($request->pincode_id_hidden != null) {
                $CheckZip = Zipcode::find($request->pincode_id_hidden);
                if ($CheckZip) {
                    $zipcode_id = $CheckZip->zipcode_id;
                }
            } elseif ($request->zipcode) {
                $AddZip = Zipcode::create([
                    'zipcode'  => $request->zipcode,
                    'city_id'  => $city_id,
                    'area_id'  => $area_id,
                    'state_id' => $state_id,
                ]);
                $zipcode_id = $AddZip->zipcode_id;
            }

            $user_id = $request->user_id;
            $user = User::findOrFail($user_id); // ❌ No creation, only update

 $updaterId = Auth::id();
            $user->last_update = $updaterId;
            
            
            $user->name = $request->company_nm;
            $user->email = $request->email;
            $user->contact_no = $request->contact_no;
            $user->state_id = $state_id;
            $user->city_id = $city_id;
            $user->area_id = $area_id;
            $user->zipcode_id = $zipcode_id;
            $user->address = $request->address;
            $user->personal_website = $request->company_website;
            $user->designation = $request->designation;


            $user->save();
            
            if ($updaterId) {
                DB::table('users')->where('id', $user->id)->update(['last_update' => $updaterId]);
            }


            StaffActivityController::insertActivity(Auth::user()->id, 'Company Profile update successfully.');


            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function UpdateCompanyAbout(Request $request)
    {
        $rules = [
            'company_desc' => 'required|string',
            'specialties'  => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        try {
            $id = $request->input('about_row_id');


            $user = User::findOrFail($id);
                        $updaterId = Auth::id();
            $user->last_update = $updaterId;

            $user->company_desc = $request->input('company_desc');
    
            if ($request->filled('specialties')) {
                $specialties = array_filter(
                    array_map('trim', explode(',', $request->specialties))
                );
                $user->specialties = implode(',', $specialties);
            } else {
                $user->specialties = null;
            }
            
            $user->save();
            if ($updaterId) {
                DB::table('users')->where('id', $user->id)->update(['last_update' => $updaterId]);
            }

            StaffActivityController::insertActivity(Auth::user()->id, 'Company About update successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Company profile updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }
    public function kycStore(Request $request, $id)
    {
        // Validate
        $request->validate([
            'title' => 'required',
            'file'  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Check if record exists
        $exist = DB::table('tbl_company_kyc')
                    ->where('company_id', $id)
                    ->first();

        $filename = $exist->document ?? null;

        // Check if existing file should be removed
        $removeExisting = $request->has('remove_existing_file') && $request->remove_existing_file == '1';

        if ($removeExisting && $filename) {
            // Delete old file
            if (file_exists(public_path('uploads/company_kyc/'.$filename))) {
                unlink(public_path('uploads/company_kyc/'.$filename));
            }
            $filename = null;
        }

        // If new file uploaded
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filename && file_exists(public_path('uploads/company_kyc/'.$filename))) {
                unlink(public_path('uploads/company_kyc/'.$filename));
            }

            // Upload new file
            $file = $request->file('file');
            $filename = time().'_'.rand(1111,9999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/company_kyc'), $filename);
        }

        // Check if we have at least one file (either existing or new)
        if (!$filename && !$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Please upload a document.');
        }

        // Insert or Update
        if ($exist) {
            DB::table('tbl_company_kyc')
                ->where('company_id', $id)
                ->update([
                    'title'       => $request->title,
                    'document'    => $filename,
                    'created_by'  => Auth::id(),
                    'status'      => 1,
                    'updated_at'  => now(),
                ]);
        } else {
            DB::table('tbl_company_kyc')->insert([
                'company_id'  => $id,
                'title'       => $request->title,
                'document'    => $filename,
                'created_by'  => Auth::id(),
                'status'      => 1,
                'created_at'  => now(),
            ]);
        }

        return redirect()->back()->with('success', 'KYC Saved Successfully!');
    }

}
