<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\JobCategory;
use App\Models\State;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session;
use App\Models\User;
use App\Models\CompanyBranch;
use App\Models\PlanHistory;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\Jobsubcategory;
use App\Models\PlanPricing;
use App\Models\Skills;
use App\Models\Zipcode;
use  App\Helpers\SmsHelper;
use App\Helpers\PaymentHelper;

use Illuminate\Support\Facades\DB;
//use Razorpay\Api\Api;

use App\Http\Controllers\StaffActivityController;


use Illuminate\Support\Facades\Password;

use Carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        return view('website.auth.login');
    }

    public function sendsms()
    {
        $apiKey     = "b3951f18b943b8aa873e271fc1f1e02a";
        $route      = "4";
        $sender     = "ZOBPOT";
        $templateId = "1207175611041347237";

        $message = "Welcome to Zobpot. Hey, Harshil patel Your OTP is 11111 Team - Zobpot";

        $response = Http::withOptions([
            'verify' => false, // disable SSL verification
        ])->get("https://bulksms.ivinfotech.in/api/smsapi", [
            'key'        => $apiKey,
            'route'      => $route,
            'sender'     => $sender,
            'number'     => "7874440972",
            'sms'        => $message,
            'templateid' => $templateId,
        ]);


    }

    public function emp_type($login_type)
    {
        $url = "";
        if ($login_type == "login") {
            $url = "login";
        } else if ($login_type == "register") {
            $url = "register";
        }
        return view('website.auth.emp-type', compact('url'));
    }

    public function preference($preference_type, $type)
    {
        return view('website.auth.preference', compact('type'));
    }

    public function companyregister()
    {
        $CategoryData = JobCategory::orderBy('category_nm','asc')->get();
        $states = State::select('state_id', 'state_name')->get(); // replace with your table column names
        return view('website.auth.company-register', compact('CategoryData', 'states'));
    }


    public function register($preference_type)
    {
        if ($preference_type == "non-skill") {
            $states = State::select('state_id', 'state_name')->get(); // replace with your table column names
            return view('website.auth.non-skilled-register', compact('states'));
        } else if ($preference_type == "skill") {
            $states = State::select('state_id', 'state_name')->get(); // replace with your table column names
            $CategoryData = JobCategory::get();
            return view('website.auth.skilled-register', compact('CategoryData', 'states'));
        }
    }


    public function otpverify($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            abort(404, 'User not found.');
        }

        if ($user->verify_status == 0) {
            return view('website.auth.otp-verify', compact('user'));
        }

        return redirect()->route('emp-type', ['login_type' => 'login']);
    }


    public function ResendOtp(Request $request)
    {
        // Validate input (user_id must exist in users table)
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::find($request->user_id);

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP to user
        $user->otp = $otp;
        $user->save();

        SmsHelper::sendOtp($user->contact_no, $user->otp, $name = $user->name);

        return response()->json([
            'status' => 1,
            'message' => 'OTP Sent Successfully.',
            'otp' => $otp
        ]);
    }



    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = $request->input("login_type");
        $login = $request->input("email"); // This can be email or contact_no
        $password = $request->input("password");
        $remember = $request->has('remember');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'contact_no';
        $user = User::where($field, $login)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Check login type match
            if ($loginType === "User" && $user->role === "User") {

                if ($user->verify_status != 1) {
                    SmsHelper::sendOtp($user->contact_no, $user->otp, $name = $user->name);
                    return redirect()->route('otp-verify', ['user_id' => $user->id]);
                }

                if ($user->active_status != 1) {
                    return back()->withErrors(['email' => 'This account is deactivated. Please reach out to the support team.'])->withInput();
                }

                Auth::login($user, $remember);
                return redirect()->route('home')->with('success', 'You have successfully logged in.');
            } elseif ($loginType !== "User" && ($user->role === "Admin" || $user->role === "Staff")) {

                StaffActivityController::insertActivity($user->id, 'Login Successfully');


                if ($user->active_status != 1) {
                    return back()->withErrors(['email' => 'This account is deactivated. Please reach out to the support team.'])->withInput();
                }

                Auth::login($user, $remember);
                return redirect()->route('admin.dashboard');
            }

            // Role mismatch
            return back()->withErrors(['email' => 'Invalid login type for this account.'])->withInput();
        }

        // Invalid credentials
        return back()->withErrors(['email' => 'Invalid email/contact number or password.'])->withInput();
    }



    public function postRegister(Request $request)
    {
        // FIRST: Check only request from step-1
    if ($request->has('check_only') && $request->check_only == 'true') {

        if (User::where('contact_no', $request->contact_no)->exists()) {
            return response()->json([
                'status' => 0,
                'message' => 'This mobile number is already registered.'
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'OK'
        ]);
    }

        $validator = Validator::make($request->all(), [
            'full_name'        => 'required|string|max:255',
            'contact_no'       => 'required|string|max:20|unique:users,contact_no',
            'email'            => 'nullable|email|unique:users,email',
            'city_id'          => 'nullable',
            'state_id'         => 'nullable',
            'zipcode'          => 'nullable|string|max:10',
            'password'         => 'required|string|min:6',
            'address'          => 'nullable|string',
            'role'             => 'nullable|string', // optional, default is 'User'
            'category_id'      => 'nullable|integer',
            'sub_category_id'  => 'nullable|integer',
            'skills_id'        => 'nullable|integer',
            'company_desc'     => 'nullable|string',
            'about'            => 'nullable|string',
            'preference_type'  => 'nullable|in:1,2' // 1=Skill, 2=Non-Skill

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message'  => $validator->errors()->first()
            ], 200);
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


                if ($request->pincode_id_hidden != null) {
                    $AddZip = Zipcode::create([
                        'zipcode'  => $request->zipcode,
                        'city_id'  => $city_id,
                        'area_id'  => $area_id,
                        'state_id' => $state_id,
                    ]);
                    $zipcode_id = $AddZip->zipcode_id;
                }
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

            $skillsArray = array_map('trim', explode(',', $request->selectedSkills));
            $Skill_jsonEncode = json_encode($skillsArray);


            // ✅ USER REGISTRATION
            $user = User::create([
                'name'                     => $request->full_name,
                'email'                    => $request->email,
                'contact_no'               => $request->contact_no,
                'state_id'                 => $state_id,
                'city_id'                  => $city_id,
                'zipcode_id'               => $zipcode_id,
                'area_id'                  => $area_id,
                'password'                 => Hash::make($request->password),
                'address'                  => $request->address,
                'category_id'              => $request->category_id,
                'sub_category_id'          => $request->sub_category_id,
                'skills_id'                => $Skill_jsonEncode,
                'company_desc'             => $request->company_desc,
                'about'                    => $request->about,
                'preference_type'          => $request->preference_type,
                'personal_name'            => $request->personal_name,
                'contact_person_nm'        => $request->contact_person_nm,
                'contact_person_phone_no'  => $request->contact_person_phone_no,
                'average_salary'           => $request->average_salary,
                'company_size'             => $request->company_size,
                'company_since'            => $request->company_since,
                'role'                     => "User",
                'verify_status'            => 0,
                'profile_type'             => $request->profile_type,
                'active_status'            => 1,
                'profile_img'              => 'profile.png'
            ]);


            // Now save multiple branches if available
            $companyNames    = $request->company_nm ?? [];
            $companyAddresses = $request->company_address ?? [];

            foreach ($companyNames as $index => $name) {
                if (!empty($name) && !empty($companyAddresses[$index])) {
                    CompanyBranch::create([
                        'user_id'         => $user->id,
                        'company_nm'      => $name,
                        'company_address' => $companyAddresses[$index],
                        'status'          => 1
                    ]);
                }
            }

            // ✅ OTP
            $user->otp = rand(100000, 999999);
            $user->save();


            SmsHelper::sendOtp($request->contact_no, $user->otp, $name = $request->full_name);

            return response()->json([
                'status'  => 1,
                'message' => 'User registered successfully.',
                'data'    => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => $e->getMessage(),
                'error'   => $e->getMessage()
            ]);
        }
    }


    public function otpVerifyAction(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }

        // Find user
        $user = User::where('email', $request->email)->first();

        // Check if OTP matches
        if ($user && $user->otp == $request->otp) {
            // Mark user as verified
            $user->verify_status = 1;
            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'OTP verified successfully.',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid OTP.',
            ], 200);
        }
    }

    public function SubCategory(Request $request)
    {
        $category_id = $request->input('category_id');

        // Fetch all subcategories where category_id matches
        $subcategories = Jobsubcategory::where('category_id', $category_id)
        ->orderBy('sub_category_nm', 'asc')
        ->get();

        if ($subcategories->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No subcategories found for this category.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Subcategories fetched successfully.',
            'data' => $subcategories
        ], 200);
    }

    public function SkillsFetch(Request $request)
    {

        $category_id = $request->input('category_id');
        $sub_category_id = $request->input('sub_category_id');

        // Fetch all subcategories where category_id matches
        $skills = Skills::where('sub_category_id', $sub_category_id)->where('category_id', $category_id)->get();

        if ($skills->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No Skill found for this Sub Category.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Skill fetched successfully.',
            'data' => $skills
        ], 200);
    }

    // Admin Login
    public function admin_login()
    {
        return view('admin.auth.login');
    }

    public function pricing($user_id)
    {
        $user = User::findOrFail($user_id); // Will 404 if not found

        $profile_type = $user->profile_type;

        $pricing = PlanPricing::where('plan_for', $profile_type)->get();
        return view('website.auth.pricing', compact('pricing', 'user_id'));
    }


    public function ChoosePlan(Request $request)
    {
    //        $request->validate([
    //            'plan_id' => 'required|exists:tbl_plan_pricing,plan_id',
    //        ]);

        if ($request->flag=="A"){
            try {
                $user_id = $request->input('user_id');
                $plan = PlanPricing::findOrFail($request->plan_id);
                $user = User::findOrFail($user_id); // Get the actual User model

                // Calculate expiry date (only date part)
                $Timeduration = (int) $plan->plan_time . "" . $plan->plan_duration;
                $duration = (int) $plan->plan_time;
                $startDate = Carbon::now();
                $expireDate = match ($plan->plan_duration) {
                'M' => $startDate->copy()->addMonths($duration),
                'Y' => $startDate->copy()->addYears($duration),
                'D' => $startDate->copy()->addDays($duration),
                default => $startDate->copy()->addDays($duration),
            };

            $expireDate = $expireDate->toDateString(); // Format as YYYY-MM-DD

            //  $order = PaymentHelper::createOrder($plan->plan_price, 'plan_'.$plan->plan_id);
            $basePrice = $plan->plan_price;   // existing price

            $gstAmount = round($basePrice * 0.18, 2); // 18% GST
            $finalAmount = $basePrice + $gstAmount;   // GST included price

            $order = PaymentHelper::createOrder($finalAmount, 'plan_'.$plan->plan_id);


                if (isset($order['error'])) {
                    return response()->json(['status' => 'failed', 'error' => $order['error']], 400);
                }


            // Store in tbl_plan_history
            $planHistory = PlanHistory::create([
                'plan_id'       => $plan->plan_id,
                'user_id'       => $user_id,
                'purchase_date' => $startDate->toDateString(),
                'expire_date'   => $expireDate,
                'duration'      => $Timeduration,
                // 'status'        => 1,
                'status'        => 0,
            ]);

            // Update user's active_plan_id
            // $user->update([
            //     'active_plan_id' => $plan->plan_id,
            // ]);

            Auth::login($user);
            // return redirect('home');

             return response()->json([
                 'order_id' => $order['id'],
                //  'key'      => "rzp_test_RHlEZntD6oCrP6",
                'key'      => "rzp_live_RyDOBxkxJtrIzG",
                 'amount'   => $order['amount'],
                 'currency' => $order['currency'],
                 'plan'     => $plan->plan_id,
                 "history_id"=>$planHistory->id
             ]);
//            return response()->json([
//                'status'  => 1,
//                'message' => 'Plan selected and activated successfully.',
//                'data'    => $planHistory,
//            ]);
        } catch (\Exception $e) {
                return response()->json([
                    'status'  => 0,
                    'message' => 'Failed to choose plan.',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        }else if ($request->flag == "FREE") {
            $user_id = $request->input('user_id');
            $plan = PlanPricing::findOrFail($request->plan_id);
            $user = User::findOrFail($user_id); // Get the actual User model

            // Calculate expiry date (only date part)
            $Timeduration = (int) $plan->plan_time . "" . $plan->plan_duration;
            $duration = (int) $plan->plan_time;
            $startDate = Carbon::now();
            $expireDate = match ($plan->plan_duration) {
                'M' => $startDate->copy()->addMonths($duration),
                'Y' => $startDate->copy()->addYears($duration),
                'D' => $startDate->copy()->addDays($duration),
                default => $startDate->copy()->addDays($duration),
            };

            $expireDate = $expireDate->toDateString(); // Format as YYYY-MM-DD


            // Store in tbl_plan_history
            $planHistory = PlanHistory::create([
                'plan_id'       => $plan->plan_id,
                'user_id'       => $user_id,
                'purchase_date' => $startDate->toDateString(),
                'expire_date'   => $expireDate,
                'duration'      => $Timeduration,
                'status'        => 1,
            ]);

            // Update user's active_plan_id
            $user->update([
                'active_plan_id' => $plan->plan_id,
            ]);

            Auth::login($user);


            return response()->json([
                'status'      => 1,
                'plan'     => $plan->plan_id,
                "history_id" => $planHistory->id
            ]);
        }else{
//            dd('dsdsdsd');
            $isValid = PaymentHelper::verifyPayment([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            $history_id = $request->hid;

            if ($isValid){
                $planHistory = PlanHistory::find($history_id);

                $planHistory->update([
                    'payment_id' => $request->razorpay_payment_id,
                    'order_id' => $request->razorpay_order_id,
                    'status'     => 1,  
                ]);
                // Update user's active_plan_id
                $user= User::find($planHistory->user_id);
                $user->update([
                    'active_plan_id' => $planHistory->plan_id ,
                ]);
                return   response()->json(['status' => 'success']);
            }else{
                $planHistory = PlanHistory::find($history_id);

                $planHistory->update([
                    // 'payment_id' => $request->razorpay_payment_id,
                    // 'order_id' => $request->razorpay_order_id,
                    // 'status' => 0,
                    'payment_id' => null,
                    'order_id'   => null,
                    'status'     => 2, 
                ]);
                // Update user's active_plan_id
                $user= User::find($planHistory->user_id);
                $user->update([
                    'active_plan_id' => 0,
                ]);

                $lastSuccess = PlanHistory::where('user_id', $user->id)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($lastSuccess) {
                    $user->update([
                        'active_plan_id' => $lastSuccess->plan_id,
                    ]);
                } else {
                    // optional: clear active_plan_id if no successful plan exists
                    $user->update([
                        'active_plan_id' => 0,
                    ]);
                }
                return  response()->json(['status' => 'failed'], 400);
            }
//            return $isValid
//                ? response()->json(['status' => 'success'])
//                : response()->json(['status' => 'failed'], 400);
        }

    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 0,
                'message' => 'Current password is incorrect.'
            ]);
        }

        $user->password = Hash::make($request->new_password_confirmation);
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => 'Password changed successfully.'
        ]);
    }

    public function CityFetch(Request $request)
    {
        $stateId = $request->input('state_id');

        if (!$stateId) {
            return response()->json([
                'status' => 0,
                'message' => 'State ID is required.'
            ]);
        }

        $cities = City::where('state_id', $stateId)
            ->select('city_id', 'city_nm')
            ->orderBy('city_nm')
            ->get();

        return response()->json([
            'status' => 1,
            'message' => 'City list fetched successfully.',
            'data' => $cities
        ]);
    }


    public function AreaFetch(Request $request)
    {
        $cityId = $request->input('city_id');
        $stateId = $request->input('state_id');

        if (!$cityId) {
            return response()->json([
                'status' => 0,
                'message' => 'City ID is required.'
            ]);
        }

        $areas = Area::where('city_id', $cityId)->where('state_id', $stateId)
            ->select('area_id', 'area_nm')
            ->orderBy('area_nm')
            ->get();

        return response()->json([
            'status' => 1,
            'message' => 'Areas fetched successfully.',
            'data' => $areas
        ]);
    }


    public function PincodeFetch(Request $request)
    {
        $areaId = $request->input('area_id');
        $cityId = $request->input('city_id');
        $stateId = $request->input(key: 'state_id');


        if (!$areaId) {
            return response()->json([
                'status' => 0,
                'message' => 'Area ID is required.'
            ]);
        }

        $zipcode = Zipcode::where('area_id', $areaId)->where('city_id', $cityId)->where('state_id', $stateId)->select('zipcode_id', 'zipcode')->get();

        return response()->json([
            'status' => 1,
            'message' => 'Zipcode fetched successfully.',
            'data' => $zipcode
        ]);
    }


    public function CheckLocationZipcode(Request $request)
    {
        $zipcode = $request->input('zipcode');

        // Get location info using joins
        $location = DB::table('tbl_zipcode as z')
            ->join('tbl_area as a', 'z.area_id', '=', 'a.area_id')
            ->join('tbl_city as c', 'z.city_id', '=', 'c.city_id')
            ->join('tbl_state as s', 'z.state_id', '=', 's.state_id')
            ->where('z.zipcode', $zipcode)
            ->whereNull('z.deleted_at')
            ->select([
                'z.zipcode',
                'z.zipcode_id',
                'a.area_id',
                'a.area_nm',
                'c.city_id',
                'c.city_nm',
                's.state_id',
                's.state_name',
            ])
            ->first();

        $areas = DB::table('tbl_zipcode as a')
            ->join('tbl_area as b', 'a.area_id', '=', 'b.area_id')
            ->select('a.area_id', 'b.area_nm')
            ->where('a.zipcode', $zipcode)
            ->groupBy('a.area_id', 'b.area_nm')
            ->whereNull('a.deleted_at')
            ->get();

        if ($location) {
            return response()->json([
                'status' => true,
                'data' => $location,
                'areas' => $areas
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Zipcode not found'
            ]);
        }
    }


    public function ActiveDeactiveAccount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sts'     => 'required|in:0,1', // Only allow 0 or 1
        ]);

        $user = User::find($request->input('user_id'));

        $user->active_status = $request->input('sts');
        $user->save();

        StaffActivityController::insertActivity(Auth::user()->id, 'User account status updated successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'User account status updated successfully.',
        ]);
    }


    public function ApproveDisapproveProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sts'     => 'required|in:0,1,2', // assuming 0 = pending, 1 = approved, 2 = disapproved
            'type'    => 'required|string'   // if you’re using `type` for any condition
        ]);

        $user = User::find($request->input('user_id'));

        $user->profile_status = $request->input('sts');
        $user->save();

        StaffActivityController::insertActivity(Auth::user()->id, 'User profile status updated successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'User profile status updated successfully.',
        ]);
    }
}
