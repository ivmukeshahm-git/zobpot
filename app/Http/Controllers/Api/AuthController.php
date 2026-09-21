<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;
use DateInterval;
use App\Helpers\PaymentHelper;
use Illuminate\Support\Facades\Http;
use App\Helpers\SmsHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Step 1: Validate the incoming request
        $request->validate([
            "name" => "required",
            "contact_no" => "required",
            "email" => "required|email",
            "city_id" => "nullable",
            "state_id" => "nullable",
            "area_id" => "nullable",
            "zipcode" => "required",
            "password" => "required",
            "state_name" => "required",
            "city_name" => "required",
            "preference_type" => "required",
            'file_nm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            "address" => "nullable|string",
            "category_id" => "nullable",
            "sub_category_id" => "nullable",
            "area_name" => "required", // New area field
        ]);

        // dd($request->profile_type);

        // Step 2: Check if email already exists
        // $existingUser = DB::table("users")
        //     ->where("email", $request->email)
        //     ->first();
        // if ($existingUser) {
        //     return response()->json(
        //         [
        //             "status" => false,
        //             "message" => "User already registered with this email.",
        //         ],
        //         409
        //     );
        // }

        // Step 2: Check if email or contact number already exists
        $existingUser = DB::table("users")
            ->where(function ($query) use ($request) {
                $query
                    ->where("email", $request->email)
                    ->orWhere("contact_no", $request->contact_no);
            })
            ->first();

        if ($existingUser) {
            if ($existingUser->email === $request->email) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "User already registered with this email.",
                    ],
                    409
                );
            }

            if ($existingUser->contact_no === $request->contact_no) {
                return response()->json(
                    [
                        "status" => false,
                        "message" =>
                            "User already registered with this contact number.",
                    ],
                    409
                );
            }
        }

        // Step 3: Handle state
        $state_id = DB::table("tbl_state")
            ->where("state_name", $request->state_name)
            ->value("state_id");

        if (!$state_id) {
            $state_id = DB::table("tbl_state")->insertGetId([
                "state_name" => $request->state_name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Step 4: Handle city
        $city_id = DB::table("tbl_city")
            ->where("city_nm", $request->city_name)
            ->where("state_id", $state_id)
            ->value("city_id");

        if (!$city_id) {
            $city_id = DB::table("tbl_city")->insertGetId([
                "state_id" => $state_id,
                "city_nm" => $request->city_name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Step 6: Handle area
        $area_id = DB::table("tbl_area")
            ->where("area_nm", $request->area_name)
            ->where("city_id", $city_id)
            ->where("state_id", $state_id)
            ->value("area_id");

        if (!$area_id) {
            $area_id = DB::table("tbl_area")->insertGetId([
                "area_nm" => $request->area_name,
                "city_id" => $city_id,
                "state_id" => $state_id,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Step 5: Handle zipcode logic
        $zipcode_id = null;

        if (!empty($request->zipcode_id)) {
            // Check if passed zipcode_id is valid
            $existingZip = DB::table("tbl_zipcode")
                ->where("zipcode_id", $request->zipcode_id)
                ->first();

            if ($existingZip) {
                $zipcode_id = $existingZip->zipcode_id;
            }
        }

        // If no valid zipcode_id found, check if zipcode value exists
        if (!$zipcode_id) {
            $zipcode_id = DB::table("tbl_zipcode")
                ->where("zipcode", $request->zipcode)
                ->where("city_id", $city_id)
                ->where("state_id", $state_id)
                ->value("zipcode_id");

            // If still not found, insert new zipcode
            if (!$zipcode_id) {
                $zipcode_id = DB::table("tbl_zipcode")->insertGetId([
                    "zipcode" => $request->zipcode,
                    "city_id" => $city_id,
                    "state_id" => $state_id,
                    "area_id" => $area_id, // update after area
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }



        // Step 7: Generate OTP
        $otp = rand(100000, 999999);

        // Step 8: Prepare insert data
        $data = $request->all();
        $data["password"] = Hash::make($request->password);
        $data["profile_type"] = "Employee"; // ✅ Always force-set profile_type for candidate registration
        $data["state_id"] = $state_id;
        $data["city_id"] = $city_id;
        $data["zipcode"] = $zipcode_id;
        $data["area_id"] = $area_id;
        $data["role"] = "User";
        $data["otp"] = $otp;
        $data["verify_status"] = 0;
        $data["active_status"] = 1;
        $data["created_at"] = now();
        $data["updated_at"] = now();

        // Remove fields not in `users` table
        unset(
            $data["state_name"],
            $data["city_name"],
            $data["zipcode"],
            $data["area_name"],
            $data["file_nm"]
        );

        // Step 9: Insert user
        $user_id = DB::table("users")->insertGetId($data);

        if ($request->hasFile("file_nm")) {
            $file = $request->file("file_nm");
            $fileName = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            
            // Ensure public/storage is a valid directory (remove legacy flat file if present)
            $publicStorage = public_path("storage");
            if (file_exists($publicStorage) && !is_dir($publicStorage)) {
                @unlink($publicStorage);
            }

            $resumePath = public_path("storage/resumes");
            if (!file_exists($resumePath) || !is_dir($resumePath)) {
                @mkdir($resumePath, 0777, true);
            }

            try {
                $file->move($resumePath, $fileName);
            } catch (\Exception $e) {
                $fallbackPath = storage_path("app/public/resumes");
                if (!file_exists($fallbackPath) || !is_dir($fallbackPath)) {
                    @mkdir($fallbackPath, 0777, true);
                }
                $file->move($fallbackPath, $fileName);
            }

            DB::table("tbl_resume")->insert([
                "user_id" => $user_id,
                "file_nm" => $fileName,
                "resume_type" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        SmsHelper::sendOtp($request->contact_no, $otp, $name = $request->name);

        // Step 10: Return success response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully. Please verify OTP.",
            "user_id" => $user_id,
            "email" => $request->email,
            "contact_no" => $request->contact_no,
        ]);
    }

    public function companyregister(Request $request)
    {
        // Step 1: Validate the incoming request
        $request->validate([
            "name" => "required",
            "contact_no" => "required",
            "email" => "required|email",
            "city_id" => "nullable",
            "state_id" => "nullable",
            "area_id" => "nullable",
            "zipcode" => "required",
            "password" => "required",
            "state_name" => "required",
            "city_name" => "required",
            "preference_type" => "nullable",
            "address" => "nullable|string",
            "category_id" => "nullable",
            "sub_category_id" => "nullable",
            "area_name" => "required", // New area field
        ]);

        // Step 2: Check if email already exists
        $existingUser = DB::table("users")
            ->where("email", $request->email)
            ->orWhere("contact_no", $request->contact_no)
            ->first();
        // if ($existingUser) {
        //     return response()->json(
        //         [
        //             "status" => false,
        //             "message" => "User already registered with this email.",
        //         ],
        //         409
        //     );
        // }

        if ($existingUser) {
            if ($existingUser->email === $request->email) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "User already registered with this email.",
                    ],
                    409
                );
            }

            if ($existingUser->contact_no === $request->contact_no) {
                return response()->json(
                    [
                        "status" => false,
                        "message" =>
                            "User already registered with this contact number.",
                    ],
                    409
                );
            }
        }

        // Step 3: Handle state
        $state_id = DB::table("tbl_state")
            ->where("state_name", $request->state_name)
            ->value("state_id");

        if (!$state_id) {
            $state_id = DB::table("tbl_state")->insertGetId([
                "state_name" => $request->state_name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Step 4: Handle city
        $city_id = DB::table("tbl_city")
            ->where("city_nm", $request->city_name)
            ->where("state_id", $state_id)
            ->value("city_id");

        if (!$city_id) {
            $city_id = DB::table("tbl_city")->insertGetId([
                "state_id" => $state_id,
                "city_nm" => $request->city_name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Step 6: Handle area
        $area_id = DB::table("tbl_area")
            ->where("area_nm", $request->area_name)
            ->where("city_id", $city_id)
            ->where("state_id", $state_id)
            ->value("area_id");

        if (!$area_id) {
            $area_id = DB::table("tbl_area")->insertGetId([
                "area_nm" => $request->area_name,
                "city_id" => $city_id,
                "state_id" => $state_id,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // Step 5: Handle zipcode logic
        $zipcode_id = null;

        if (!empty($request->zipcode_id)) {
            $existingZip = DB::table("tbl_zipcode")
                ->where("zipcode_id", $request->zipcode_id)
                ->first();

            if ($existingZip) {
                $zipcode_id = $existingZip->zipcode_id;
            }
        }

        if (!$zipcode_id) {
            $zipcode_id = DB::table("tbl_zipcode")
                ->where("zipcode", $request->zipcode)
                ->where("city_id", $city_id)
                ->where("state_id", $state_id)
                ->value("zipcode_id");

            if (!$zipcode_id) {
                $zipcode_id = DB::table("tbl_zipcode")->insertGetId([
                    "zipcode" => $request->zipcode,
                    "city_id" => $city_id,
                    "state_id" => $state_id,
                    "area_id" => $area_id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }

        // Step 7: Generate OTP
        $otp = rand(100000, 999999);

        // Step 8: Prepare insert data
        $data = $request->all();
        $data["password"] = Hash::make($request->password);
        $data["profile_type"] = "Company"; // ✅ Always force-set profile_type for company registration
        $data["state_id"] = $state_id;
        $data["city_id"] = $city_id;
        $data["zipcode"] = $zipcode_id;
        $data["area_id"] = $area_id;
        $data["otp"] = $otp;
        $data["verify_status"] = 0;
        $data["active_status"] = 1;
        $data["created_at"] = now();
        $data["updated_at"] = now();

        unset(
            $data["state_name"],
            $data["city_name"],
            $data["zipcode"],
            $data["area_name"]
        );

        // Step 9: Insert user
        $user_id = DB::table("users")->insertGetId($data);

        SmsHelper::sendOtp($request->contact_no, $otp, $name = $request->name);

        // Step 11: Return success response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully. Please verify OTP.",
            "user_id" => $user_id,
            "email" => $request->email,
            "contact_no" => $request->contact_no,
        ]);
    }

    public function addBranches(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "branches" => "required|array|min:1",
            "branches.*.company_nm" => "required|string",
            "branches.*.company_address" => "required|string",
        ]);

        $branches = [];
        foreach ($request->branches as $branch) {
            $branches[] = [
                "user_id" => $request->user_id,
                "company_nm" => $branch["company_nm"],
                "company_address" => $branch["company_address"],
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }

        // dd($branches);

        DB::table("tbl_company_branches")->insert($branches);

        return response()->json([
            "status" => true,
            "message" => "Branches added successfully",
            "count" => count($branches),
        ]);
    }

    // public function login(Request $request)
    // {
    //     // Validate request
    //     $request->validate([
    //         "identifier" => "required", // Can be email or contact_no
    //         "password" => "required",
    //     ]);

    //     // Find user by email OR contact_no
    //     $user = DB::table("users")
    //         ->where("email", $request->identifier)
    //         ->orWhere("contact_no", $request->identifier)
    //         ->first();

    //     if (!$user) {
    //         return response()->json(
    //             [
    //                 "status" => false,
    //                 "message" => "Email or contact number not found",
    //             ],
    //             404
    //         );
    //     }

    //     // Check password
    //     if (!Hash::check($request->password, $user->password)) {
    //         return response()->json(
    //             [
    //                 "status" => false,
    //                 "message" => "Incorrect password",
    //             ],
    //             401
    //         );
    //     }

    //     // Check if user is active
    //     if ($user->active_status == 0) {
    //         return response()->json(
    //             [
    //                 "status" => false,
    //                 "message" => "Account is inactive. Please contact support.",
    //             ],
    //             403
    //         );
    //     }

    //     // Check if OTP is verified
    //     if ($user->verify_status != 1) {
    //         SmsHelper::sendOtp(
    //             $request->contact_no,
    //             $user->otp,
    //             $name = $request->name
    //         );

    //         return response()->json(
    //             [
    //                 "status" => false,
    //                 "message" => "OTP not verified",
    //                 "data" => [
    //                     "id" => $user->id,
    //                     "name" => $user->name,
    //                     "contact_no" => $user->contact_no,
    //                     "email" => $user->email,
    //                     "profileType" => $user->profile_type,
    //                     "otp" => $user->otp,
    //                 ],
    //             ],
    //             200
    //         );
    //     }

    //     // Successful login - return full user data
    //     return response()->json(
    //         [
    //             "status" => true,
    //             "message" => "Login successful",
    //             "data" => $user,
    //         ],
    //         200
    //     );
    // }

    public function login(Request $request)
    {
        // Validate request
        $request->validate([
            "identifier" => "required", // Can be email or contact_no
            "password" => "required",
        ]);

        // Find user by email OR contact_no
        $user = DB::table("users")
            ->where("email", $request->identifier)
            ->orWhere("contact_no", $request->identifier)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Email or contact number not found",
                ],
                404
            );
        }

        // 🔥 NEW CHECK: If account deleted, block login
        if (!empty($user->deleted_at)) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "This account has been deleted.",
                ],
                403
            );
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Incorrect password",
                ],
                401
            );
        }

        // Check if user is active
        if ($user->active_status == 0) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Account is inactive. Please contact support.",
                ],
                403
            );
        }

        // Check if OTP is verified
        if ($user->verify_status != 1) {
            SmsHelper::sendOtp(
                $request->contact_no,
                $user->otp,
                $name = $request->name
            );

            return response()->json(
                [
                    "status" => false,
                    "message" => "OTP not verified",
                    "data" => [
                        "id" => $user->id,
                        "name" => $user->name,
                        "contact_no" => $user->contact_no,
                        "email" => $user->email,
                        "profileType" => $user->profile_type,
                    ],
                ],
                200
            );
        }

        // Successful login
        return response()->json(
            [
                "status" => true,
                "message" => "Login successful",
                "data" => $user,
            ],
            200
        );
    }

    //     public function updateActivePlan(Request $request)
//     {
//         // var_dump($request->user_id);
//         // $request->validate([
//         //     'user_id' => 'required|exists:users,id',
//         //     'active_plan_id' => 'required|exists:tbl_plan_pricing,plan_id',
//         // ]);

    //         DB::beginTransaction();

    //         try {
//             // Step 1: Fetch plan details
//             $plan = DB::table("tbl_plan_pricing")
//                 ->where("plan_id", $request->active_plan_id)
//                 ->first();

    //             if (!$plan) {
//                 return response()->json(
//                     [
//                         "status" => false,
//                         "message" => "Invalid plan selected",
//                     ],
//                     400
//                 );
//             }

    //             // Step 2: Dates
//             $purchaseDate = date("Y-m-d");
//             $expireDate = $purchaseDate;

    //             // Step 3: Expire date calculation
//             $timeValue = intval($plan->plan_time);
//             $timeUnit = strtoupper(trim($plan->plan_duration));

    //             switch ($timeUnit) {
//                 case "D":
//                     $expireDate = date(
//                         "Y-m-d",
//                         strtotime($purchaseDate . " +{$timeValue} days")
//                     );
//                     break;
//                 case "M":
//                     $expireDate = date(
//                         "Y-m-d",
//                         strtotime($purchaseDate . " +{$timeValue} months")
//                     );
//                     break;
//                 case "Y":
//                     $expireDate = date(
//                         "Y-m-d",
//                         strtotime($purchaseDate . " +{$timeValue} years")
//                     );
//                     break;
//                 default:
//                     return response()->json(
//                         [
//                             "status" => false,
//                             "message" =>
//                                 "Invalid plan duration unit: " .
//                                 $plan->plan_duration,
//                         ],
//                         400
//                     );
//             }

    //             $durationText = $timeValue . $timeUnit;

    //             $status = ($plan->plan_price == 0.0) ? 1 : 0;

    //             // Step 4: Insert into plan history
//             $planHistoryId = DB::table("tbl_plan_history")->insertGetId([
//                 "plan_id" => $request->active_plan_id,
//                 "user_id" => $request->user_id,
//                 "purchase_date" => $purchaseDate,
//                 "expire_date" => $expireDate,
//                 "duration" => $durationText,
//                 // "status" => 1,
//                 // "status" => 0, // Pending payment
//                 'status' => $status,
//                 "created_at" => now(),
//                 "updated_at" => now(),
//             ]);

    //             // Step 5: Handle free vs paid plans
//             // if ($plan->plan_price == 0.0) {
//             //     // dd('test');
//             //     // Free plan → no Razorpay order
//             //     DB::commit();

    //             //     return response()->json(
//             //         [
//             //             "status" => true,
//             //             "message" => "Free plan purchased successfully",
//             //             "plan" => $plan->plan_id,
//             //             "history_id" => $planHistoryId,
//             //         ],
//             //         200
//             //     );
//             // } 
//             if ((float)$plan->plan_price == 0.0) {

    //     // ✅ Update user's active plan immediately for FREE plan
//     DB::table("users")
//         ->where("id", $request->user_id)
//         ->update([
//             "active_plan_id" => $request->active_plan_id, // OR $planHistoryId if you prefer
//             "updated_at" => now(),
//         ]);

    //     DB::commit();

    //     return response()->json(
//         [
//             "status" => true,
//             "message" => "Free plan activated successfully",
//             "plan" => $plan->plan_id,
//             "history_id" => $planHistoryId,
//         ],
//         200
//     );
// }
//             else {
//                 // Paid plan → Create Razorpay order
//                 // $order = PaymentHelper::createOrder(
//                 //     $plan->plan_price,
//                 //     "plan_" . $plan->plan_id
//                 // );
//                 $basePrice = $plan->plan_price;   // existing price

    //                 $gstAmount = round($basePrice * 0.18, 2); // 18% GST
//                 $finalAmount = $basePrice + $gstAmount;   // GST included price

    //                 $order = PaymentHelper::createOrder($finalAmount, 'plan_'.$plan->plan_id);


    //                 if (isset($order["error"])) {
//                     return response()->json(
//                         ["status" => "failed", "error" => $order["error"]],
//                         400
//                     );
//                 }

    //                 DB::commit();

    //                 return response()->json(
//                     [
//                         "order_id" => $order["id"],
//                         // "key" => "rzp_test_RHlEZntD6oCrP6",
//                         'key'      => "rzp_live_RyDOBxkxJtrIzG",
//                         "amount" => $order["amount"],
//                         "currency" => $order["currency"],
//                         "plan" => $plan->plan_id,
//                         "history_id" => $planHistoryId,
//                     ],
//                     200
//                 );
//             }
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json(
//                 [
//                     "status" => false,
//                     "message" => "Failed to update plan: " . $e->getMessage(),
//                 ],
//                 500
//             );
//         }
//     }

    public function updateActivePlan(Request $request)
    {
        DB::beginTransaction();

        try {

            $userId = $request->user_id;
            $planId = $request->active_plan_id;

            if (!$userId || !$planId) {
                return response()->json([
                    "status" => false,
                    "message" => "User ID and Plan ID are required"
                ], 400);
            }

            // ✅ STEP 1: Fetch selected plan
            $plan = DB::table("tbl_plan_pricing")
                ->where("plan_id", $planId)
                ->first();

            if (!$plan) {
                return response()->json([
                    "status"  => false,
                    "message" => "Invalid plan selected"
                ], 400);
            }

            // ✅ STEP 2: Fetch user and validate plan_for matches profile_type
            $user = DB::table("users")->where("id", $userId)->first();

            if (!$user) {
                return response()->json([
                    "status"  => false,
                    "message" => "User not found"
                ], 404);
            }

            // Determine expected plan category based on user's profile_type
            $expectedPlanFor = (strtolower($user->profile_type ?? '') === 'company') ? 'Company' : 'Employee';

            // Block if plan_for doesn't match the user's profile type
            if (!empty($plan->plan_for) && strtolower($plan->plan_for) !== strtolower($expectedPlanFor)) {
                DB::rollBack();
                return response()->json([
                    "status"  => false,
                    "message" => "This plan is not available for your profile type.",
                ], 403);
            }

            // ✅ STEP 3: CHECK IF USER ALREADY USED A FREE PLAN OF THE SAME TYPE
            if ((float) $plan->plan_price == 0.0) {

                $alreadyUsedFree = DB::table("tbl_plan_history as h")
                    ->join("tbl_plan_pricing as p", "h.plan_id", "=", "p.plan_id")
                    ->where("h.user_id", $userId)
                    ->where("p.plan_for", $expectedPlanFor)
                    ->whereRaw("p.plan_price = 0")
                    ->exists();

                if ($alreadyUsedFree) {
                    DB::rollBack();
                    return response()->json([
                        "status"  => false,
                        "message" => "You have already used the free plan"
                    ], 200);
                }
            }

            // ✅ STEP 4: Date calculation
            $purchaseDate = date("Y-m-d");
            $expireDate = $purchaseDate;

            $timeValue = intval($plan->plan_time);
            $timeUnit = strtoupper(trim($plan->plan_duration));

            switch ($timeUnit) {
                case "D":
                    $expireDate = date("Y-m-d", strtotime("+{$timeValue} days"));
                    break;
                case "M":
                    $expireDate = date("Y-m-d", strtotime("+{$timeValue} months"));
                    break;
                case "Y":
                    $expireDate = date("Y-m-d", strtotime("+{$timeValue} years"));
                    break;
                default:
                    return response()->json([
                        "status" => false,
                        "message" => "Invalid plan duration unit"
                    ], 400);
            }

            $durationText = $timeValue . $timeUnit;
            $status = ((float) $plan->plan_price == 0.0) ? 1 : 0;

            // ✅ STEP 5: Insert Plan History
            $planHistoryId = DB::table("tbl_plan_history")->insertGetId([
                "plan_id" => $planId,
                "user_id" => $userId,
                "purchase_date" => $purchaseDate,
                "expire_date" => $expireDate,
                "duration" => $durationText,
                "status" => $status,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            // ✅ STEP 6: FREE PLAN — Activate immediately + reset usage
            if ((float) $plan->plan_price == 0.0) {

                DB::table("tbl_plan_history")
                    ->where("user_id", $userId)
                    ->where("id", "!=", $planHistoryId)
                    ->where("status", 1)
                    ->update([
                        "status" => 0,
                        "updated_at" => now(),
                    ]);

                $userModel = \App\Models\User::find($userId);
                \App\Models\PlanPricing::activatePlanForUser($userModel, $plan);

                DB::commit();

                return response()->json([
                    "status" => true,
                    "message" => "Free plan activated successfully",
                    "plan" => $planId,
                    "history_id" => $planHistoryId,
                ], 200);
            }

            // ✅ STEP 7: PAID PLAN → Create Razorpay Order
            $basePrice = $plan->plan_price;
            $gstAmount = round($basePrice * 0.18, 2);
            $finalAmount = $basePrice + $gstAmount;

            $order = PaymentHelper::createOrder($finalAmount, 'plan_' . $planId);

            if (isset($order["error"])) {
                DB::rollBack();
                return response()->json([
                    "status" => false,
                    "error" => $order["error"]
                ], 400);
            }

            DB::commit();

            return response()->json([
                "order_id" => $order["id"],
                "key" => "rzp_live_RyDOBxkxJtrIzG",
                "amount" => $order["amount"],
                "currency" => $order["currency"],
                "plan" => $planId,
                "history_id" => $planHistoryId,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => "Failed to update plan: " . $e->getMessage(),
            ], 500);
        }
    }

    public function handlePaymentStatus(Request $request)
    {
        $request->validate([
            "history_id" => "required|exists:tbl_plan_history,id",
            "flag" => "required|in:success,failed",
            "payment_id" => "nullable|string",
            "order_id" => "nullable|string",
            "user_id" => "required|exists:users,id",
        ]);

        try {
            $updateData = [
                "order_id" => $request->order_id,
                "payment_id" => $request->payment_id,
                "updated_at" => now(),
            ];

            if ($request->flag === "success") {
                $updateData["status"] = 1; // ✅ Payment success

                // ───── Step 1: Fetch current new plan from history_id ─────
                $newPlanHistory = DB::table("tbl_plan_history")
                    ->where("id", $request->history_id)
                    ->first();

                if ($newPlanHistory) {
                    $newExpireDate = new DateTime($newPlanHistory->expire_date);

                    // ───── Step 2: Check if user already has an active plan ─────
                    $activePlan = DB::table("tbl_plan_history")
                        ->where("user_id", $request->user_id)
                        ->where("status", 1)
                        ->where("id", "!=", $request->history_id) // exclude current
                        ->orderBy("id", "desc")
                        ->first();

                    if ($activePlan) {
                        $now = new DateTime();
                        $oldExpireDate = new DateTime($activePlan->expire_date);

                        // ───── Step 3: If old plan still has remaining days ─────
                        if ($oldExpireDate > $now) {
                            $remainingDays = $now->diff($oldExpireDate)->days;

                            // Add remaining days to new plan's expiry
                            $newExpireDate->modify("+{$remainingDays} days");

                            // Update new plan expiry date
                            DB::table("tbl_plan_history")
                                ->where("id", $request->history_id)
                                ->update([
                                    "expire_date" => $newExpireDate->format(
                                        "Y-m-d H:i:s"
                                    ),
                                    "updated_at" => now(),
                                ]);
                        }

                        // Mark old plan inactive
                        DB::table("tbl_plan_history")
                            ->where("id", $activePlan->id)
                            ->update([
                                "status" => 0,
                                "updated_at" => now(),
                            ]);
                    }

                    // ───── Step 4: Update active_plan_id + reset usage counters ─────
                    $userModel = \App\Models\User::find($request->user_id);
                    $planModel = \App\Models\PlanPricing::find($newPlanHistory->plan_id);
                    \App\Models\PlanPricing::activatePlanForUser($userModel, $planModel ?: $newPlanHistory->plan_id);
                }
            } else {
                $updateData["status"] = 2; // ❌ Payment failed
            }

            // ───── Update payment history record ─────
            DB::table("tbl_plan_history")
                ->where("id", $request->history_id)
                ->update($updateData);

            return response()->json([
                "status" => true,
                "message" =>
                    $request->flag === "success"
                    ? "Payment recorded successfully"
                    : "Payment failed and recorded",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Error updating payment: " . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function checkJobPostEligibility(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json([
                "status" => false,
                "message" => "User ID is required"
            ], 400);
        }

        try {

            // ✅ Step 1: Get user's active plan
            $user = DB::table("users")
                ->where("id", $userId)
                ->first();

            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "User not found"
                ], 200);
            }

            if (!$user->active_plan_id || $user->active_plan_id == 0) {
                return response()->json([
                    "status" => false,
                    "message" => "No active plan found. Please upgrade your plan."
                ], 200);
            }

            // ✅ Step 2: Get plan details
            $plan = DB::table("tbl_plan_pricing")
                ->where("plan_id", $user->active_plan_id)
                ->first();

            if (!$plan) {
                return response()->json([
                    "status" => false,
                    "message" => "Plan not found"
                ], 200);
            }

            // ✅ Step 3: Use plan service_limit + usage counters
            $userModel = \App\Models\User::find($userId);
            if (!$userModel || ($userModel->profile_type ?? '') !== 'Company') {
                return response()->json([
                    "status" => false,
                    "message" => "Only company accounts can post jobs"
                ], 200);
            }

            if (!\App\Models\PlanPricing::companyCanPost($userModel, 'job')) {
                return response()->json([
                    "status" => false,
                    "message" => "Your current plan does not include Job service. Please upgrade your plan."
                ], 200);
            }

            $limitCheck = \App\Models\PlanPricing::checkServiceLimit($userModel, 'job', 'create');
            if (!$limitCheck['allowed']) {
                return response()->json([
                    "status" => false,
                    "message" => $limitCheck['message'],
                    "job_limit" => $limitCheck['limit'],
                    "jobs_used" => $limitCheck['used']
                ], 200);
            }

            return response()->json([
                "status" => true,
                "message" => $limitCheck['limit'] === null
                    ? "You can post jobs"
                    : "You can post jobs (" . $limitCheck['remaining'] . " remaining)",
                "job_limit" => $limitCheck['limit'] === null ? "unlimited" : $limitCheck['limit'],
                "jobs_used" => $limitCheck['used'],
                "jobs_remaining" => $limitCheck['remaining']
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                "status" => false,
                "message" => "Something went wrong: " . $e->getMessage()
            ], 500);
        }
    }

    public function checkInternshipPostEligibility(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json([
                "status" => false,
                "message" => "User ID is required"
            ], 400);
        }

        try {

            // ✅ Step 1: Get user's active plan
            $user = DB::table("users")
                ->where("id", $userId)
                ->first();

            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "User not found"
                ], 200);
            }

            if (!$user->active_plan_id || $user->active_plan_id == 0) {
                return response()->json([
                    "status" => false,
                    "message" => "No active plan found. Please upgrade your plan."
                ], 200);
            }

            // ✅ Step 2: Get plan details
            $plan = DB::table("tbl_plan_pricing")
                ->where("plan_id", $user->active_plan_id)
                ->first();

            if (!$plan) {
                return response()->json([
                    "status" => false,
                    "message" => "Plan not found"
                ], 200);
            }

            // ✅ Step 3: Use plan service_limit + usage counters
            $userModel = \App\Models\User::find($userId);
            if (!$userModel || ($userModel->profile_type ?? '') !== 'Company') {
                return response()->json([
                    "status" => false,
                    "message" => "Only company accounts can post internships"
                ], 200);
            }

            if (!\App\Models\PlanPricing::companyCanPost($userModel, 'internship')) {
                return response()->json([
                    "status" => false,
                    "message" => "Your current plan does not include Internship service. Please upgrade your plan."
                ], 200);
            }

            $limitCheck = \App\Models\PlanPricing::checkServiceLimit($userModel, 'internship', 'create');
            if (!$limitCheck['allowed']) {
                return response()->json([
                    "status" => false,
                    "message" => $limitCheck['message'],
                    "internship_limit" => $limitCheck['limit'],
                    "internships_used" => $limitCheck['used']
                ], 200);
            }

            return response()->json([
                "status" => true,
                "message" => $limitCheck['limit'] === null
                    ? "You can post internships"
                    : "You can post internships (" . $limitCheck['remaining'] . " remaining)",
                "internship_limit" => $limitCheck['limit'] === null ? "unlimited" : $limitCheck['limit'],
                "internships_used" => $limitCheck['used'],
                "internships_remaining" => $limitCheck['remaining']
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                "status" => false,
                "message" => "Something went wrong: " . $e->getMessage()
            ], 500);
        }
    }

    // Fetch all active states
    public function getStates()
    {
        $states = DB::table("tbl_state")
            ->whereNull("deleted_at")
            ->select("state_id", "state_name")
            ->orderBy("state_name", "asc")
            ->get();

        return response()->json([
            "status" => true,
            "message" => "State list fetched successfully",
            "data" => $states,
        ]);
    }

    // Fetch cities and zipcodes based on state_id
    public function getCitiesByState($state_id)
    {
        // Fetch cities
        $cities = DB::table("tbl_city")
            ->where("state_id", $state_id)
            ->whereNull("deleted_at")
            ->select("city_id", "city_nm")
            ->orderBy("city_nm", "asc")
            ->get();

        return response()->json([
            "status" => true,
            "message" => "City list fetched successfully",
            "data" => $cities,
        ]);
    }

    public function getAreaList(Request $request)
    {
        $request->validate([
            "state_id" => "required|integer",
            "city_id" => "required|integer",
        ]);

        $areas = DB::table("tbl_area")
            ->where("state_id", $request->state_id)
            ->where("city_id", $request->city_id)
            ->select("area_id", "area_nm")
            ->get();

        if ($areas->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "No areas found for the given state and city.",
                "data" => [],
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Area list fetched successfully",
            "data" => $areas,
        ]);
    }

    public function getZipcodes(Request $request)
    {
        $zipcode = $request->input("zipcode"); // search
        $zipcodeId = $request->input("zipcode_id"); // selected zip
        $stateId = $request->input("state_id"); // location filter
        $cityId = $request->input("city_id");
        $areaId = $request->input("area_id");

        // //If only zipcode search is provided
        // if ($zipcode && !$zipcodeId && !$stateId && !$cityId && !$areaId) {
        //     $zipcodes = DB::table("tbl_zipcode")
        //         ->where("zipcode", "like", "%$zipcode%")
        //         ->whereNull("deleted_at")
        //         ->select("zipcode_id", "zipcode")
        //         ->orderBy("zipcode", "asc")
        //         ->get();

        //     if ($zipcodes->isEmpty()) {
        //         return response()->json([
        //             "status" => false,
        //             "message" => "No matching zipcodes found.",
        //             "data" => [],
        //         ]);
        //     }

        //     return response()->json([
        //         "status" => true,
        //         "message" => "Zipcodes fetched based on search.",
        //         "data" => $zipcodes,
        //     ]);
        // }

        // If only zipcode search is provided
        if ($zipcode && !$zipcodeId && !$stateId && !$cityId && !$areaId) {
            $zipcodes = DB::table("tbl_zipcode as z")
                ->leftJoin("tbl_state as s", "z.state_id", "=", "s.state_id")
                ->leftJoin("tbl_city as c", "z.city_id", "=", "c.city_id")
                ->leftJoin("tbl_area as a", "z.area_id", "=", "a.area_id")
                ->where("z.zipcode", "like", "%$zipcode%")
                ->whereNull("z.deleted_at")
                ->select(
                    "z.zipcode_id",
                    "z.zipcode",
                    "z.state_id",
                    "s.state_name",
                    "z.city_id",
                    "c.city_nm as city_name",
                    "z.area_id",
                    "a.area_nm as area_name"
                )
                ->orderBy("z.zipcode", "asc")
                ->get();

            if ($zipcodes->isEmpty()) {
                return response()->json([
                    "status" => false,
                    "message" => "No matching zipcodes found.",
                    "data" => [],
                ]);
            }

            return response()->json([
                "status" => true,
                "message" => "Zipcodes fetched based on search.",
                "data" => $zipcodes,
            ]);
        }

        // If only zipcode_id is provided
        if ($zipcodeId && !$stateId && !$cityId && !$areaId) {
            $location = DB::table("tbl_zipcode")
                ->where("zipcode_id", $zipcodeId)
                ->whereNull("deleted_at")
                ->select("zipcode", "state_id", "city_id", "area_id")
                ->first();

            if (!$location) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid zipcode ID.",
                    "data" => [],
                ]);
            }

            $state = DB::table("tbl_state")
                ->where("state_id", $location->state_id)
                ->whereNull("deleted_at")
                ->value("state_name");
            $city = DB::table("tbl_city")
                ->where("city_id", $location->city_id)
                ->whereNull("deleted_at")
                ->value("city_nm");
            $area = DB::table("tbl_area")
                ->where("area_id", $location->area_id)
                ->value("area_nm");

            return response()->json([
                "status" => true,
                "message" =>
                    "Location fetched successfully for selected zipcode.",
                "location" => [
                    "zipcode_id" => $zipcodeId,
                    "zipcode" => $location->zipcode,
                    "state_id" => $location->state_id,
                    "state_name" => $state,
                    "city_id" => $location->city_id,
                    "city_name" => $city,
                    "area_id" => $location->area_id,
                    "area_name" => $area,
                ],
            ]);
        }

        //If state_id, city_id, area_id are provided
        if ($stateId && $cityId && $areaId) {
            $zipcodes = DB::table("tbl_zipcode")
                ->where("state_id", $stateId)
                ->where("city_id", $cityId)
                ->where("area_id", $areaId)
                ->whereNull("deleted_at")
                ->select("zipcode_id", "zipcode")
                ->orderBy("zipcode", "asc")
                ->get();

            if ($zipcodes->isEmpty()) {
                return response()->json([
                    "status" => false,
                    "message" => "No zipcodes found for the selected location.",
                    "data" => [],
                ]);
            }

            $state = DB::table("tbl_state")
                ->where("state_id", $stateId)
                ->whereNull("deleted_at")
                ->value("state_name");
            $city = DB::table("tbl_city")
                ->where("city_id", $cityId)
                ->whereNull("deleted_at")
                ->value("city_nm");
            $area = DB::table("tbl_area")
                ->where("area_id", $areaId)
                ->value("area_nm");

            return response()->json([
                "status" => true,
                "message" =>
                    "Zipcodes for the selected location fetched successfully.",
                "location" => [
                    "state_id" => $stateId,
                    "state_name" => $state,
                    "city_id" => $cityId,
                    "city_name" => $city,
                    "area_id" => $areaId,
                    "area_name" => $area,
                ],
                "data" => $zipcodes,
            ]);
        }

        //No valid input
        return response()->json([
            "status" => false,
            "message" =>
                "Invalid input. Please provide either 'zipcode' to search, 'zipcode_id' to fetch location, or state/city/area IDs to fetch zipcodes.",
            "data" => [],
        ]);
    }

    public function changePassword(Request $request)
    {
        // Validate input
        $request->validate([
            "user_id" => "required|exists:users,id",
            "old_password" => "required",
            "new_password" => "required",
        ]);

        // Fetch user
        $user = DB::table("users")
            ->where("id", $request->user_id)
            ->first();

        // Check if old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Old password is incorrect",
                ],
                401
            );
        }

        // Update password
        DB::table("users")
            ->where("id", $request->user_id)
            ->update([
                "password" => Hash::make($request->new_password),
                "updated_at" => now(),
            ]);

        return response()->json([
            "status" => true,
            "message" => "Password changed successfully",
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "otp" => "required",
        ]);

        $user = DB::table("users")
            ->where("id", $request->user_id)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "User not found",
                ],
                404
            );
        }

        if ($user->otp != $request->otp) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Invalid OTP",
                ],
                401
            );
        }

        DB::table("users")
            ->where("id", $request->user_id)
            ->update([
                "verify_status" => 1,
                "otp" => null,
                "updated_at" => now(),
            ]);

        // Fetch updated user details (without OTP)
        $updatedUser = DB::table("users")
            ->where("id", $request->user_id)
            ->select("id", "name", "email", "contact_no", "verify_status", "profile_type", "active_plan_id")
            ->first();

        return response()->json([
            "status" => true,
            "message" => "OTP verified successfully",
            "user" => $updatedUser, // 👈 include user details in response
        ]);
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
        ]);

        $user = DB::table("users")
            ->where("id", $request->user_id)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "User not found",
                ],
                404
            );
        }

        // Generate new OTP
        $newOtp = rand(100000, 999999);

        DB::table("users")
            ->where("id", $request->user_id)
            ->update([
                "otp" => $newOtp,
                "updated_at" => now(),
            ]);

        Log::info("New OTP=>" . $newOtp);

        // Optional: Trigger SMS or Email send here
        $sms = SmsHelper::sendOtp(
            $user->contact_no,
            $newOtp,
            $name = $user->name
        );

        Log::info("New SMS HELPR=>" . $sms);

        Log::info(
            "New SMS Details=>" .
            $user->contact_no .
            "=>" .
            $newOtp .
            "=>" .
            ($name = $user->name)
        );

        return response()->json([
            "status" => true,
            "message" => "OTP resent successfully",
        ]);
    }

    public function findUserForForgotPassword(Request $request)
    {

        $request->validate([
            "identifier" => "required", // Can be email or contact_no
        ]);

        // Find user by email OR contact_no
        $user = DB::table("users")
            ->where("email", $request->identifier)
            ->orWhere("contact_no", $request->identifier)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Account not found",
                ],
                404
            );
        }

        // Generate new OTP
        $newOtp = rand(100000, 999999);

        // Update otp_verified = 0 and set new OTP
        DB::table("users")
            ->where("id", $user->id)
            ->update([
                "verify_status" => 0,
                "otp" => $newOtp,
                "updated_at" => now(),
            ]);

        //     file_put_contents(
        //     storage_path('logs/custom-log.log'),
        //     print_r($user,true) . "Your log text here" . PHP_EOL,
        //     FILE_APPEND
        // );

        SmsHelper::sendOtp($user->contact_no, $newOtp, $name = $user->name);

        return response()->json([
            "status" => true,
            "message" => "User found. OTP has been reset.",
            "data" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "contact_no" => $user->contact_no,
                "profile_type" => $user->profile_type,
                "otp" => $newOtp
            ],
        ]);

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "new_password" => "required",
        ]);

        // Fetch user
        $user = DB::table("users")
            ->where("id", $request->user_id)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "User not found",
                ],
                404
            );
        }

        // Update password and mark verify_status
        DB::table("users")
            ->where("id", $request->user_id)
            ->update([
                "password" => Hash::make($request->new_password),
                "verify_status" => 1,
                "updated_at" => now(),
            ]);

        // Fetch updated user info
        $updatedUser = DB::table("users")
            ->select("id as user_id", "contact_no", "email")
            ->where("id", $request->user_id)
            ->first();

        return response()->json([
            "status" => true,
            "message" => "Password reset successfully",
            "data" => $updatedUser,
        ]);
    }

    public function editProfile(Request $request)
    {
        $user = DB::table('users')
            ->where('id', $request->user_id)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if (empty($user->contact_no) && empty($request->contact_no)) {
            return response()->json([
                'status' => false,
                'message' => 'Contact number is required.'
            ], 422);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'contact_no' => 'nullable|string|max:20',
        ]);

        // Step 3: Handle state
        $state_id = DB::table("tbl_state")
            ->where("state_name", $request->state_name)
            ->value("state_id");
 
        if (!$state_id) {
            $state_id = DB::table("tbl_state")->insertGetId([
                "state_name" => $request->state_name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
 
        // Step 4: Handle city
        $city_id = DB::table("tbl_city")
            ->where("city_nm", $request->city_name)
            ->where("state_id", $state_id)
            ->value("city_id");
 
        if (!$city_id) {
            $city_id = DB::table("tbl_city")->insertGetId([
                "state_id" => $state_id,
                "city_nm" => $request->city_name,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
 
        // Step 5: Handle area
        $area_id = DB::table("tbl_area")
            ->where("area_nm", $request->area_name)
            ->where("city_id", $city_id)
            ->where("state_id", $state_id)
            ->value("area_id");
 
        if (!$area_id) {
            $area_id = DB::table("tbl_area")->insertGetId([
                "area_nm" => $request->area_name,
                "city_id" => $city_id,
                "state_id" => $state_id,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
 
        // Step 6: Handle zipcode logic
        $zipcode_id = null;

        if (!empty($request->zipcode_id)) {
            $existingZip = DB::table("tbl_zipcode")
                ->where("zipcode_id", $request->zipcode_id)
                ->first();

            if ($existingZip) {
                $zipcode_id = $existingZip->zipcode_id;
            }
        }
 
        if (!$zipcode_id) {
            $zipcode_id = DB::table("tbl_zipcode")
                ->where("zipcode", $request->zipcode)
                ->where("city_id", $city_id)
                ->where("state_id", $state_id)
                ->value("zipcode_id");
 
            if (!$zipcode_id) {
                $zipcode_id = DB::table("tbl_zipcode")->insertGetId([
                    "zipcode" => $request->zipcode,
                    "city_id" => $city_id,
                    "state_id" => $state_id,
                    "area_id" => $area_id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }
 
        // Step 7: Handle profile image upload
        $profileImgPath = null;
        if ($request->hasFile("profile_img")) {
            $file = $request->file("profile_img");
            $fileName = time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/profile"), $fileName);
            $profileImgPath = $fileName;
        }
 
        // Step 7b: Handle cover image upload
        $coverImgPath = null;

        if ($request->hasFile("cover_img")) {
            $file = $request->file("cover_img");
            $fileName = time() . "_cover." . $file->getClientOriginalExtension();

            $file->move(public_path("uploads/profile"), $fileName);
            $coverImgPath = $fileName;
        }
 
        // Handle company signature image upload


        $signatureImgPath = null;


        if ($request->hasFile("company_signature")) {
            $file = $request->file("company_signature");
            $fileName = time() . "_signature." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/profile"), $fileName);
            $signatureImgPath = $fileName;
        }
 
        // Handle certificate logo image upload
        $certLogoImgPath = null;

        if ($request->hasFile("certificate_logo")) {
            $file = $request->file("certificate_logo");
            $fileName = time() . "_cert_logo." . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/profile"), $fileName);
            $certLogoImgPath = $fileName;
        }
 
        // Step 8: Prepare update data
        $updateData = [
            "designation" => $request->designation,
            "name" => $request->name,
            "specialties" => $request->specialties,
            "contact_no" => $request->contact_no,
            "state_id" => $state_id,
            "city_id" => $city_id,
            "area_id" => $area_id,
            "gender" => $request->gender,
            // "expected_salary" => $request->expected_salary,
            "zipcode_id" => $zipcode_id,
            // "preference_type" => $request->preference_type,
            "address" => $request->address,
            "about" => $request->about,
            "company_size" => $request->company_size,
            "company_since" => $request->company_since,
            "company_desc" => $request->company_desc,
            "personal_website" => $request->personal_website,
            "updated_at" => now(),
        ];
 
        // Only update profile_img if provided
        if ($profileImgPath !== null) {
            $updateData["profile_img"] = $profileImgPath;
        }
 
        // Only update cover_img if provided
        if ($coverImgPath !== null) {
            $updateData["cover_img"] = $coverImgPath;
        }
 
        // Only update company_signature if provided
        if ($signatureImgPath !== null) {
            $updateData["company_signature"] = $signatureImgPath;
        }
 
        // Only update certificate_logo if provided
        if ($certLogoImgPath !== null) {
            $updateData["certificate_logo"] = $certLogoImgPath;
        }
 
        // Step 9: Update user
        DB::table("users")
            ->where("id", $request->user_id)
            ->update($updateData);
 
        // Step 10: Return success response
        return response()->json([
            "status" => true,
            "message" => "Profile updated successfully.",
            "data" => $updateData,
        ], 200);
    }

    public function editAboutSkill(Request $request)
    {
        // dd($request->all());

        $update = DB::table("users")
            ->where("id", $request->user_id)
            ->update([
                "about" => $request->about,
                "category_id" => $request->category_id,
                "sub_category_id" => $request->sub_category_id,
                "skills_id" => $request->skills_id,
                "languages" => $request->languages,
                "expected_salary" => $request->expected_salary
            ]);

        $user = DB::table("users")
            ->where("id", $request->user_id)
            ->first();
        // Step 9: Return success response
        return response()->json([
            "status" => true,
            "message" => "About and skills updated successfully.",
            "data" => $user,
        ]);
    }

    public function getEducation(Request $request)
    {
        $user_id = $request->user_id;
        $education = DB::table("tbl_education")
            ->where("user_id", $user_id)
            ->get();

        return response()->json([
            "msg" => "successFully Fetched Education Data",
            "data" => $education,
            "status" => 200,
        ]);
    }

    public function addEducation(Request $request)
    {
        $user_id = $request->user_id;

        // Soft Delete
        if (
            $request->has("id") &&
            $request->has("remove_flag") &&
            $request->remove_flag == 1
        ) {
            $deleted = DB::table("tbl_education")
                ->where("id", $request->id)
                ->update([
                    "deleted_at" => now(),
                    "updated_at" => now(),
                ]);

            if ($deleted) {
                return response()->json([
                    "msg" => "Successfully Soft Deleted Education Data",
                    "status" => 200,
                ]);
            } else {
                return response()->json([
                    "msg" => "Invalid ID or already deleted",
                    "status" => 400,
                ]);
            }
        }

        // Update
        if ($request->has("id") && $request->id != null) {
            $data = [
                "school_name" => $request->school_name,
                "user_id" => $user_id,
                "degree" => $request->degree,
                "field_of_study" => $request->field_of_study,
                "grade" => $request->grade,
                // "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "description" => $request->description,
                "updated_at" => now(),
            ];

            $updated = DB::table("tbl_education")
                ->where("id", $request->id)
                ->update($data);

            if ($updated) {
                return response()->json([
                    "msg" => "Successfully Updated Education Data",
                    "status" => 200,
                ]);
            } else {
                return response()->json([
                    "msg" => "No changes made or invalid ID",
                    "status" => 400,
                ]);
            }
        }

        // Insert (with validation)
        $request->validate([
            "school_name" => "required",
            "degree" => "required",
            // "start_date" => "required",
            "user_id" => "required|exists:users,id",
            "field_of_study" => "nullable",
            "grade" => "nullable",
            // "end_date" => "nullable",
            "end_date" => "required",
            "description" => "nullable",
        ]);

        $data = [
            "school_name" => $request->school_name,
            "user_id" => $user_id,
            "degree" => $request->degree,
            "field_of_study" => $request->field_of_study,
            "grade" => $request->grade,
            // "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "description" => $request->description,
            "created_at" => now(),
            "updated_at" => now(),
            "deleted_at" => null,
        ];

        $id = DB::table("tbl_education")->insertGetId($data);

        return response()->json([
            "msg" => "Successfully Inserted Education Data",
            "id" => $id,
            "status" => 200,
        ]);
    }

    public function getPricingPlans(Request $request)
    {
        $planFor = $request->input("plan_for"); // 'Employee' or 'Company'

        $query = DB::table("tbl_plan_pricing")
            ->whereNull("deleted_at")
            ->where("status", 1)
            ->orderBy("plan_price", "asc")
            ->select([
                "plan_id",
                "plan_name",
                "plan_price",
                "plan_description",
                "plan_for",
                "benefits",
                "plan_duration",
                "plan_time",
                "status",
                "created_at",
                "updated_at",
            ]);

        if (!empty($planFor)) {
            $query->where("plan_for", $planFor);
        }

        $plans = $query->get();

        return response()->json(
            [
                "status" => true,
                "message" => "Pricing plans fetched successfully",
                "data" => $plans,
            ],
            200
        );
    }

    // public function checkPlanStatus(Request $request)
    // {
    //     $userId = $request->user_id;

    //     if (!$userId) {
    //         return response()->json(
    //             ["status" => false, "message" => "User ID is required"],
    //             400
    //         );
    //     }

    //     // Step 1: Fetch the latest ACTIVE plan history for this user
    //     $planHistory = DB::table("tbl_plan_history")
    //         ->where("user_id", $userId)
    //         ->where("status", 1) // only active plan
    //         ->orderBy("id", "desc")
    //         ->first();

    //     // If no active plan found → fallback to latest plan (even if expired/inactive)
    //     if (!$planHistory) {
    //         $planHistory = DB::table("tbl_plan_history")
    //             ->where("user_id", $userId)
    //             ->orderBy("id", "desc")
    //             ->first();
    //     }

    //     if (!$planHistory) {
    //         return response()->json(
    //             ["status" => false, "message" => "No plan purchased"],
    //             200
    //         );
    //     }

    //     // Step 2: Fetch full plan details
    //     $plan = DB::table("tbl_plan_pricing")
    //         ->where("plan_id", $planHistory->plan_id)
    //         ->whereNull("deleted_at")
    //         ->first();

    //     if (!$plan) {
    //         return response()->json(
    //             ["status" => false, "message" => "Plan not found or deleted"],
    //             200
    //         );
    //     }

    //     // Step 3: If plan or planHistory is inactive
    //     if ($plan->status != 1 || $planHistory->status != 1) {
    //         return response()->json(
    //             ["status" => false, "message" => "Plan is inactive"],
    //             200
    //         );
    //     }

    //     // Step 4: Dates from history
    //     $activationDate = new DateTime($planHistory->purchase_date);
    //     $endDate = new DateTime($planHistory->expire_date);
    //     $now = new DateTime();

    //     // Step 5: Expired check
    //     if ($now > $endDate) {
    //         // update active_plan_id and plan_history status
    //         DB::table("users")
    //             ->where("id", $userId)
    //             ->update(["active_plan_id" => 0]);

    //         DB::table("tbl_plan_history")
    //             ->where("id", $planHistory->id)
    //             ->update(["status" => 0]);

    //         return response()->json(
    //             [
    //                 "status" => false,
    //                 "message" => "Plan expired",
    //                 "expired_on" => $endDate->format("Y-m-d"),
    //                 "plan_details" => $plan,
    //             ],
    //             200
    //         );
    //     }

    //     // Step 6: Calculate remaining time
    //     $diff = $now->diff($endDate);
    //     $years = $diff->y;
    //     $months = $diff->m;
    //     $days = $diff->d;

    //     // Step 7: Notify if <= 15 days left
    //     $daysLeft = $now->diff($endDate)->days;
    //     $notify =
    //         $daysLeft <= 15 ? "Your plan will expire in $daysLeft days" : null;

    //     // Step 8: Final response
    //     return response()->json(
    //         [
    //             "status" => true,
    //             "message" => "Plan is active",
    //             "plan_expires_on" => $endDate->format("Y-m-d"),
    //             "remaining_years" => $years,
    //             "remaining_months" => $months,
    //             "remaining_days" => $days,
    //             "notify" => $notify,
    //             "plan_details" => $plan,
    //         ],
    //         200
    //     );
    // }

    public function checkPlanStatus(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json(
                ["status" => false, "message" => "User ID is required"],
                400
            );
        }

        // Step 0: Check user exists
        $user = DB::table("users")
            ->where("id", $userId)
            ->first();

        if (!$user) {
            return response()->json(
                ["status" => false, "message" => "User not found"],
                200
            );
        }

        // ✅ Step 1: Check active_plan_id
        if (empty($user->active_plan_id) || $user->active_plan_id == 0) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Plan expired",
                ],
                200
            );
        }

        // Step 2: Fetch latest ACTIVE plan history
        $planHistory = DB::table("tbl_plan_history")
            ->where("user_id", $userId)
            ->where("status", 1)
            ->orderBy("id", "desc")
            ->first();

        // If no active plan found → fallback to latest plan
        if (!$planHistory) {
            $planHistory = DB::table("tbl_plan_history")
                ->where("user_id", $userId)
                ->orderBy("id", "desc")
                ->first();
        }

        if (!$planHistory) {
            return response()->json(
                ["status" => false, "message" => "No plan purchased"],
                200
            );
        }

        // Step 3: Fetch plan details
        $plan = DB::table("tbl_plan_pricing")
            ->where("plan_id", $planHistory->plan_id)
            ->whereNull("deleted_at")
            ->first();

        if (!$plan) {
            return response()->json(
                ["status" => false, "message" => "Plan not found or deleted"],
                200
            );
        }

        // Step 4: If plan or history inactive
        if ($plan->status != 1 || $planHistory->status != 1) {
            return response()->json(
                ["status" => false, "message" => "Plan is inactive"],
                200
            );
        }

        // Step 5: Date calculations
        try {
            $activationDate = new DateTime($planHistory->purchase_date);
            $endDate = new DateTime($planHistory->expire_date);
            $now = new DateTime();
        } catch (Exception $e) {
            return response()->json(
                ["status" => false, "message" => "Invalid date format"],
                200
            );
        }

        // Step 6: Expired check
        if ($now > $endDate) {

            // Update user active_plan_id and clear plan service + usage
            $userModel = \App\Models\User::find($userId);
            if ($userModel) {
                \App\Models\PlanPricing::clearPlanForUser($userModel);
            } else {
                DB::table("users")
                    ->where("id", $userId)
                    ->update([
                        "active_plan_id" => 0,
                        "plan_service" => null,
                        "plan_job_used" => 0,
                        "plan_internship_used" => 0,
                    ]);
            }

            // Update plan history status
            DB::table("tbl_plan_history")
                ->where("id", $planHistory->id)
                ->update(["status" => 0]);

            return response()->json(
                [
                    "status" => false,
                    "message" => "Plan expired",
                    "expired_on" => $endDate->format("Y-m-d"),
                    "plan_details" => $plan,
                ],
                200
            );
        }

        // Step 7: Calculate remaining time
        $diff = $now->diff($endDate);
        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $daysLeft = $now->diff($endDate)->days;

        // Step 8: Notify if <= 15 days left
        $notify = null;
        if ($daysLeft <= 15) {
            $notify = "Your plan will expire in $daysLeft days";
        }

        // Step 9: Final response
        return response()->json(
            [
                "status" => true,
                "message" => "Plan is active",
                "plan_expires_on" => $endDate->format("Y-m-d"),
                "remaining_years" => $years,
                "remaining_months" => $months,
                "remaining_days" => $days,
                "notify" => $notify,
                "plan_details" => $plan,
            ],
            200
        );
    }

    public function deleteResume(Request $request)
    {
        $request->validate([
            "resume_id" => "required|exists:tbl_resume,resume_id",
            "user_id" => "required",
        ]);

        $resume_id = $request->resume_id;
        $user_id = $request->user_id;

        // Fetch resume details
        $resume = DB::table("tbl_resume")
            ->where("resume_id", $resume_id)
            ->where("user_id", $user_id)
            ->first();

        if (!$resume) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Resume not found.",
                ],
                404
            );
        }

        // Delete file from server if exists
        if (!empty($resume->file_nm)) {
            $filePath = public_path("storage/resumes/" . $resume->file_nm);
            if (file_exists($filePath)) {
                @unlink($filePath); // Suppress errors in case file already deleted
            }
        }

        // Delete from resume builder if resume_type = 2
        if ($resume->resume_type == 2) {
            DB::table("tbl_resume_builder")
                ->where("resume_id", $resume_id)
                ->where("user_id", $user_id)
                ->delete();
        }

        // Delete resume entry
        DB::table("tbl_resume")
            ->where("resume_id", $resume_id)
            ->where("user_id", $user_id)
            ->delete();

        return response()->json(
            [
                "status" => true,
                "message" => "Resume deleted successfully.",
            ],
            200
        );
    }

    public function deleteAccount(Request $request)
    {
        // Validate user_id
        $request->validate([
            "user_id" => "required"
        ]);

        // Check if user exists
        $user = DB::table("users")
            ->where("id", $request->user_id)
            ->first();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User not found."
            ], 404);
        }

        // Update deleted_at timestamp
        DB::table("users")
            ->where("id", $request->user_id)
            ->update([
                "deleted_at" => now(),
                "updated_at" => now()
            ]);

        return response()->json([
            "status" => true,
            "message" => "Account deleted successfully."
        ]);
    }

}