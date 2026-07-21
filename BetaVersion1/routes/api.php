<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GetController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\CompanyController;
use App\Models\Setting;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/companyregister', [AuthController::class, 'companyregister']);
Route::post('/branches/add', [AuthController::class, 'addBranches']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
// Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/change-password', [AuthController::class, 'changePassword']);
Route::post('/find-user-forgot-password', [AuthController::class, 'findUserForForgotPassword']);
Route::post('/edit-profile', [AuthController::class, 'editProfile']);
Route::post('/edit-aboutskill', [AuthController::class, 'editAboutSkill']);
Route::get('/pricing-plans', [AuthController::class, 'getPricingPlans']);
Route::post('/update-active-plan', [AuthController::class, 'updateActivePlan']);
Route::post('/handle-payment-status', [AuthController::class, 'handlePaymentStatus']);
Route::post('/check-plan-status', [AuthController::class, 'checkPlanStatus']);
Route::delete('/resume/delete', [AuthController::class, 'deleteResume']);

Route::get('/states', [AuthController::class, 'getStates']);
Route::get('/cities/{state_id}', [AuthController::class, 'getCitiesByState']);
Route::get('/area-list', [AuthController::class, 'getAreaList']);
Route::post('/zipcodes', [AuthController::class, 'getZipcodes']);
// Route::post('/upload-resume', [AuthController::class, 'uploadResume']);

Route::get('/user-details/{usert_id}', [GetController::class, 'getUserDetails']);
Route::get('/job-categories', [GetController::class, 'getAllCategories']);
Route::get('/sub-categories/{category_id}', [GetController::class, 'getByCategory']);
Route::get('/skills', [GetController::class, 'getSkills']);
Route::get('/work-types', [GetController::class, 'getWorkTypes']);
Route::get('/job-types', [GetController::class, 'getJobTypes']);
Route::get('/job-levels', [GetController::class, 'getAllJobLevels']);
// Route::post('/add-experience', [GetController::class, 'addExperience']);
Route::post('/add-update-experience', [GetController::class, 'addOrUpdateExperience']);
Route::post('/remove-work-experience', [GetController::class, 'removeWorkExperience']);
Route::post('/get-homedata', [GetController::class, 'getHomeScreenData']);
Route::post('/jobs-list', [GetController::class, 'getJobsList']);
// Route::get('/get-jobdata', [GetController::class, 'getJobScreendata']);
Route::post('/get-jobdata', [GetController::class, 'getJobScreendata']);
Route::get('/min-qualifications', [GetController::class, 'getMinQualificationList']);
Route::get('/experience-list', [GetController::class, 'getExperienceList']);
Route::get('/get-all-job-titles', [GetController::class, 'getAllJobTitles']);

Route::get('/get-education', [AuthController::class, 'getEducation']);
Route::post('/add-education', [AuthController::class, 'addEducation']);

Route::post('/apply-job', [JobController::class, 'applyJob']);
Route::post('/fetch-resume-data', [JobController::class, 'fetchResumeData']);
Route::post('/upload-resume', [JobController::class, 'uploadResume']);
// Route::post('/save-job-post', [JobController::class, 'saveJobPost']);
// Route::post('/remove-saved-job-post', [JobController::class, 'removeSavedJobPost']);
Route::post('/toggle-savedpost', [JobController::class, 'toggleSavedJobPost']);
// Route::post('/fetch-my-saved-posts', [JobController::class, 'fetchMySavedPosts']);
Route::get('/fetch-my-saved-posts', [JobController::class, 'fetchMySavedPosts']);
Route::get('/get-jobs', [JobController::class, 'getJobList']);
Route::post('/get-jobdetails', [JobController::class, 'getJobDetails']);
Route::post('/search-filter-job-list', [JobController::class, 'searchAndFilterJobList']);
Route::post('/store-resume-data', [JobController::class, 'storeResumeData']);
Route::post("/mark-as-read", [JobController::class, "markJobAsRead"]);

Route::post('/post-job', [JobController::class, 'postJob']);
Route::post('/getAppliedJobs', [JobController::class, 'getAppliedJobs']);
Route::post('/getSavedJobs', [JobController::class, 'getSavedJobs']);
Route::post('/job/toggle-status', [JobController::class, 'toggleJobStatus']);

//company api url
Route::post('/get-my-uploaded-jobs', [CompanyController::class, 'getMyUploadedJobs']);
Route::post('/search-employees', [CompanyController::class, 'searchAndFilterEmployeeList']);
Route::get('/company/details/{user_id}', [CompanyController::class, 'getCompanyDetails']);
// Route::get('/job/details/{job_id}', [CompanyController::class, 'getPostedJobDetails']);
Route::post('job/details-with-applications', [CompanyController::class, 'getJobDetailsWithApplications']);
// ✅ Get only applied users for a job
Route::post('/get-applied-users', [CompanyController::class, 'getAppliedUsersForJob']);
Route::post('/mark-round-complete', [CompanyController::class, 'markRoundComplete']);
Route::post('/job/accept', [CompanyController::class, 'acceptJob']);
Route::post('/job/reject', [CompanyController::class, 'rejectJob']);
Route::post('/shortlist-candidate', [CompanyController::class, 'shortlistCandidate']);
Route::post('/schedule-user-round', [CompanyController::class, 'scheduleUserRound']);
Route::post('/get-hr-details', [CompanyController::class, 'getHrDetails']);
Route::post("check-company-profile", [CompanyController::class, "checkCompanyProfileCompletion"]);

Route::post('/delete-account', [AuthController::class, 'deleteAccount']);


Route::get("get-setting", function (){
    $setting = Setting::first();
    return response()->json(["success"=>true,"data"=>$setting]);
});

