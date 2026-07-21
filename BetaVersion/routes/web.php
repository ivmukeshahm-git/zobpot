<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AdbannerController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CandidateprofileController;
use App\Http\Controllers\Admin\CandidateregisterlistController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyprofileController;
use App\Http\Controllers\Admin\CompanyregisterlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ExpireplanController;
use App\Http\Controllers\Admin\FreeplanController;
use App\Http\Controllers\Admin\InternshipController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\ManageGradeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\College\CollegeDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\JobcategoryController;
use App\Http\Controllers\Admin\JobTitleController;
use App\Http\Controllers\Admin\JoblevelController;
use App\Http\Controllers\Admin\JobsubcategoryController;
use App\Http\Controllers\Admin\JobtypeController;
use App\Http\Controllers\Admin\PaidcandidateController;
use App\Http\Controllers\Admin\PaidcompanyController;
use App\Http\Controllers\Admin\PincodeController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillsController;
use App\Http\Controllers\Admin\StaffactivityhistoryContoller;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WorktypeController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Website\EducationController;
use App\Http\Controllers\Website\JobController;
use App\Http\Controllers\Website\ProfileController;
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\WorkExperienceController;
    use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode2 = Artisan::call('route:clear');
    $exitCode3 = Artisan::call('view:clear');
    $exitCode4 = Artisan::call('config:cache');
    $exitCode5 = Artisan::call('config:clear');
    return 'All cache cleared';
});


Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "✅ Storage link created successfully!";
});



Route::get('/pricing-plan-list', [WebsiteController::class, 'frontPlan'])->name('frontPlan');

// Internship Application History
Route::get('/my-internship-applications', [WebsiteController::class, 'internshipApplicationHistory'])->name('internship.application.history');

Route::get('/', [WebsiteController::class, 'index'])->name('/');
Route::get('/sendsms', [AuthController::class, 'sendsms'])->name('sendsms');


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/forget-password', [ForgotPasswordController::class, 'forget_password'])->name('forget-password');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'submitForgetPasswordForm'])
    ->name('forget.password.post');

// Step 2 → Verify OTP
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('forgot.otp.post');

// Step 2 → Resend OTP
Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])
    ->name('forgot.otp.resend');

// Step 3 → Save new password
Route::post('/forgot-password/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])
    ->name('forgot.password.save');
    
Route::get('emp-type/{login_type}', [AuthController::class, 'emp_type'])->name('emp-type');
Route::get('preference/{login_type}/{type}', [AuthController::class, 'preference'])->name('preference');
Route::get('register/{preference_type}/{type}', [AuthController::class, 'register'])->name('register');
Route::get('company-register', [AuthController::class, 'companyregister'])->name('company-register');

Route::get('pricing/{user_id}', [AuthController::class, 'pricing'])->name('pricing');

Route::get('otp-verify/{user_id}', [AuthController::class, 'otpverify'])->name('otp-verify');
Route::get('/about', [WebsiteController::class, 'about'])->name('about');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact'); // default
Route::get('/blog', [WebsiteController::class, 'blog'])->name('blog'); // default
Route::get('/blog-detail/{id}', [WebsiteController::class, 'blog_detail'])->name('blog-detail'); // default

Route::get('/job', [WebsiteController::class, 'job'])->name('job'); // default
Route::get('/find-candidates', [WebsiteController::class, 'find_candidates'])->name('find-candidates'); // default
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); // default

Route::get('company-profile', [WebsiteController::class, 'company_profile'])->name('company-profile')->middleware('auth','role.user');
Route::get('candidate-profile', [WebsiteController::class, 'candidate_profile'])->name('candidate-profile')->middleware('auth','role.user');

Route::get('job-detail/{job_id}', [WebsiteController::class, 'job_detail'])->name('job-detail')->middleware('auth','role.user');

Route::get('candidate-profile-detail/{id}', [WebsiteController::class, 'candidate_profile_detail'])->name('candidate-profile-detail')->middleware('auth','role.user');
Route::get('company-profile-detail/{id}', [WebsiteController::class, 'company_profile_detail'])->name('company-profile-detail')->middleware('auth','role.user');

Route::get('/my-internship-details', function() {
    return view('website.my-internship-details');
})->name('my-internship-details')->middleware('auth','role.user');

Route::get('home', [WebsiteController::class, 'index'])->name('home');

Route::get('create-resume', [WebsiteController::class, 'create_resume'])->name('create-resume')->middleware('auth','role.user');

Route::get('privacy-policy', [WebsiteController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('term-and-conditions', [WebsiteController::class, 'term_and_conditions'])->name('term-and-conditions');


Route::get('faq', [WebsiteController::class, 'faq'])->name('faq');

Route::get('skillthon', [WebsiteController::class, 'skillthon'])->name('skillthon');
Route::post('/skillthon-store', [WebsiteController::class, 'skillthonStore'])->name('skillthon.store');
Route::post('/internship-store', [WebsiteController::class, 'internshipStore'])->name('internship.store');
Route::get('internship', [WebsiteController::class, 'internship'])->name('internship');
Route::get('internship-detail', [WebsiteController::class, 'internshipDetail'])->name('internship.detail');


// Fetch Location
Route::post('city-fetch-action', [AuthController::class, 'CityFetch'])->name('city-fetch-action');
Route::post('area-fetch-action', [AuthController::class, 'AreaFetch'])->name('area-fetch-action');
Route::post('pincode-fetch-action', [AuthController::class, 'PincodeFetch'])->name('pincode-fetch-action');
Route::post('check-location', [AuthController::class, 'CheckLocationZipcode'])->name('check-location');


Route::post('forget-password-action', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::post('/fetch-user-job-round', [ProfileController::class, 'FetchUserJobRound'])->name('fetch.user.job.round');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::post('post-login', [AuthController::class, 'postLogin'])->name('post-login');
Route::post('post-register', [AuthController::class, 'postRegister'])->name('post-register');
Route::post('otp-verify-action', [AuthController::class, 'otpVerifyAction'])->name('otp-verify-action');
Route::post('resend-action', [AuthController::class, 'ResendOtp'])->name('resend-action');


Route::post('filter-job', [WebsiteController::class, 'filter_job'])->name('filter-job'); // default
Route::post('apply-job', [WebsiteController::class, 'apply_job'])->name('apply-job'); // default




Route::post('filter-candidates', [WebsiteController::class, 'filter_candidates'])->name('filter-candidates'); // default

Route::get('/find-companies', [WebsiteController::class, 'find_companies'])->name('find-companies'); // default
Route::post('filter-companies', [WebsiteController::class, 'filter_companies'])->name('filter-companies'); // default

Route::post('sub-category-action', [AuthController::class, 'SubCategory'])->name('sub-category-action');
Route::post('skill-fetch-action', [AuthController::class, 'SkillsFetch'])->name('skill-fetch-action');


Route::post('choose-plan-action', [AuthController::class, 'ChoosePlan'])->name('choose-plan-action');

Route::post('create-resume-action', [WebsiteController::class, 'create_resume_action'])->name('create-resume-action');


// Route::get('candidates', [WebsiteController::class, 'candidates'])->name('candidates');


Route::post('candidate-profile-action/{id}', [ProfileController::class, 'CandidateProfile'])->name('candidate.profile.action');
Route::post('candidate-profile-about-skill/{id}', [ProfileController::class, 'CandidateProfileAboutSkill'])->name('candidate.profile.about.skill.action');

Route::post('company-profile-action/{id}', [ProfileController::class, 'CompanyProfile'])->name('company.profile.action');
Route::post('company-profile-about-action/{id}', [ProfileController::class, 'CompanyProfileAbout'])->name('company.profile.about.action');

Route::post('view-candidate-job-detail-action', [ProfileController::class, 'MyJobCandidateViewDetail'])->name('view-candidate-job-detail-action');
// Route::post('view-apply-job-history-action', [ProfileController::class, 'MyJobApplyHistoryCompany'])->name('view-apply-job-history-action');
Route::match(['get', 'post'],'view-apply-job-history-action',[ProfileController::class, 'MyJobApplyHistoryCompany'])->name('view-apply-job-history-action');

Route::post('apply-job-application-reject-action', [ProfileController::class, 'ApplyApplicationRejectUpdate'])->name('apply-job-application-reject-action');
Route::post('apply-job-application-schedule-interview-action', [ProfileController::class, 'ScheduleInterview'])->name('apply-job-application-schedule-interview-action');
Route::post('apply-job-application-status-action', [ProfileController::class, 'UpdateApplicationStatus'])->name('apply-job-application-status-action');
Route::post('apply-job-add-to-shortlist-action', [ProfileController::class, 'ApplicationAddtoshortlist'])->name('apply-job-add-to-shortlist-action');

Route::post('save-job-action', [WebsiteController::class, 'save_job'])->name('save-job-action');
Route::post('remove-job-action', [WebsiteController::class, 'remove_save_job'])->name('remove-job-action');

Route::resource('job-action', JobController::class);

Route::resource('work-experience-action', WorkExperienceController::class);
Route::resource('education-action', EducationController::class);

Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

Route::post('job-status-change', [ProfileController::class, 'changeJobStatus'])
     ->name('job-status-change');

Route::post('job-categories-by-preference', [WebsiteController::class, 'getCategoriesByPreference'])->name('job-categories-by-preference');

Route::post('fetch-job-titles', [JobController::class, 'fetchTitles'])->name('fetch-job-titles');

Route::post('/resume-delete', [WebsiteController::class, 'deleteResume'])->name('resume.delete');

Route::get('/app-download', function () {
    return view('website.app-download');
});

// 'middleware' => ['auth', 'is_admin']
Route::group(['middleware' => ['admin.auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {


// Route::get('import-job-titles', function () {

//     $csvPath = base_path('job_titles.csv'); // file Laravel root ma chhe

//     if (!file_exists($csvPath)) {
//         return "CSV file not found!";
//     }

//     $file = fopen($csvPath, 'r');

//     // First line -> column name
//     $headers = fgetcsv($file);

//     while (($row = fgetcsv($file)) !== false) {
//         DB::table('tbl_job_title')->insert([
//             'title_name' => $row[0], // 1st column
//             'created_at'  => now(),    // 🔥 Auto add current timestamp
//             'updated_at'  => now(),  
//         ]);
//     }

//     fclose($file);

//     return "CSV Imported Successfully!";
// });


    Route::get('login', [AuthController::class, 'admin_login'])->name('login');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('canany:Dashboard-today_candidates_register_list,Dashboard-today_company_register_list,Dashboard-paid_company,Dashboard-paid_candidates,Dashboard-free_company_Candidates,Dashboard-staff_activity_history,Dashboard-expired_plan_month');


    Route::post('active-deactive-account-active', [AuthController::class, 'ActiveDeactiveAccount'])
        ->name('active-deactive-account-active');

    Route::post('approve-disapprove-profile-active', [AuthController::class, 'ApproveDisapproveProfile'])
        ->name('approve-disapprove-profile-active');

    Route::post('dashboard-candidate-action', [DashboardController::class, 'TodayCandidatesRegisterLIst'])
        ->name('dashboard.gettodaycandidatesregistertabledata');


    Route::post('dashboard-candidate-approve-action', [DashboardController::class, 'TodayApproveCandidatesRegisterLIst'])
        ->name('dashboard.gettodayapprovecandidatesregistertabledata');


    Route::post('dashboard-company-action', [DashboardController::class, 'TodayCompanyRegisterLIst'])
        ->name('dashboard.gettodaycompanyregistertabledata');


    Route::post('dashboard-company-approve-action', [DashboardController::class, 'TodayApproveCompanyRegisterLIst'])
        ->name('dashboard.gettodayapprovecompanyregistertabledata');
    
    Route::get('dashboard-hackathon-list', [RegisterController::class, 'TodaySkillthonRegisterList'])
    ->name('dashboard.hackathon.list');

    Route::get('dashboard-internship-list', [RegisterController::class, 'TodayInternshipRegisterList'])
    ->name('dashboard.internship.list');



    // Master Category Addd
    Route::resource('job-category', JobcategoryController::class)->middleware('canany:Category-Add,Category-Edit,Category-Delete');
    Route::post('category-action', [JobcategoryController::class, 'GetTableData'])
        ->name('job-category.gettabledata');


    // Master Sub Category Addd
    Route::resource('job-sub-category', JobsubcategoryController::class)->middleware('canany:SubCategory-Add,SubCategory-Edit,SubCategory-Delete');
    Route::post('job-sub-category-datatable', [JobsubcategoryController::class, 'GetTableData'])->name('job-sub-category-datatable.gettabledata');

    // Job Type Addd
    Route::resource('job-type', JobtypeController::class)->middleware('canany:JobType-Add,JobType-Edit,JobType-Delete');
    Route::post('job-type-action', [JobtypeController::class, 'GetTableData'])
        ->name('job-type.gettabledata');

    //Job title
    Route::resource('job-title', JobTitleController::class)
        ->middleware('canany:JobTitle-Add,JobTitle-Edit,JobTitle-Delete');
    Route::post('job-title-action', [JobTitleController::class, 'GetTableData'])
        ->name('job-title.gettabledata');




    // Job Level Addd
    Route::resource('job-level', JoblevelController::class)->middleware('canany:JobLevel-Add,JobLevel-Edit,JobLevel-Delete');
    Route::post('job-level-action', [JoblevelController::class, 'GetTableData'])
        ->name('job-level.gettabledata');


    // Work type Addd
    Route::resource('work-type', WorktypeController::class)->middleware('canany:WorkType-Add,WorkType-Edit,WorkType-Delete');
    Route::post('work-type-action', [WorktypeController::class, 'GetTableData'])
        ->name('work-type.gettabledata');


    // Qualification Addd
    Route::resource('min-qualification', QualificationController::class)->middleware('canany:MinimumQualification-Add,MinimumQualification-Edit,MinimumQualification-Delete');
    Route::post('min-qualification-action', [QualificationController::class, 'GetTableData'])
        ->name('min-qualification.gettabledata');


    // Experience Addd
    Route::resource('work-experience', ExperienceController::class)->middleware('canany:ExperienceRequired-Add,ExperienceRequired-Edit,ExperienceRequired-Delete');
    Route::post('work-experience-action', [ExperienceController::class, 'GetTableData'])
        ->name('work-experience.gettabledata');


    // Skill Addd
    Route::resource('skills', SkillsController::class)->middleware('canany:Skills-Add,Skills-Edit,Skills-Delete');
    Route::post('skills-action', [SkillsController::class, 'GetTableData'])
        ->name('skills.gettabledata');
    Route::post('sub-category-action', [SkillsController::class, 'get_sub_category'])
        ->name('skills.get_sub_category');

    // Grade Master
    Route::get('grade-master', function() {
        return view('admin.grade-master.index');
    })->name('grade-master.index');

    Route::post('grade-master/store', function() {
        // Handle grade master store
        return response()->json(['success' => true, 'message' => 'Grade added successfully']);
    })->name('grade-master.store');

    Route::put('grade-master/update/{id}', function($id) {
        // Handle grade master update
        return response()->json(['success' => true, 'message' => 'Grade updated successfully']);
    })->name('grade-master.update');

    Route::delete('grade-master/delete/{id}', function($id) {
        // Handle grade master delete
        return response()->json(['success' => true, 'message' => 'Grade deleted successfully']);
    })->name('grade-master.delete');

    // University Management
    Route::get('university', function() {
        return view('admin.university.index');
    })->name('university.index');

    Route::post('university/store', function() {
        // Handle university store
        return response()->json(['success' => true, 'message' => 'University added successfully']);
    })->name('university.store');

    Route::put('university/update/{id}', function($id) {
        // Handle university update
        return response()->json(['success' => true, 'message' => 'University updated successfully']);
    })->name('university.update');

    Route::delete('university/delete/{id}', function($id) {
        // Handle university delete
        return response()->json(['success' => true, 'message' => 'University deleted successfully']);
    })->name('university.delete');

    // College Management
    Route::get('college', function() {
        return view('admin.college.index');
    })->name('college.index');

    Route::post('college/store', function() {
        // Handle college store
        return response()->json(['success' => true, 'message' => 'College added successfully']);
    })->name('college.store');

    Route::put('college/update/{id}', function($id) {
        // Handle college update
        return response()->json(['success' => true, 'message' => 'College updated successfully']);
    })->name('college.update');

    Route::delete('college/delete/{id}', function($id) {
        // Handle college delete
        return response()->json(['success' => true, 'message' => 'College deleted successfully']);
    })->name('college.delete');

    // Verification & Approval
    Route::get('verification/institutions', function() {
        return view('admin.verification.institutions');
    })->name('verification.institutions');

    Route::post('verification/approve/{type}/{id}', function($type, $id) {
        // Handle institution approval (type: university or college)
        return response()->json(['success' => true, 'message' => ucfirst($type) . ' approved successfully']);
    })->name('verification.approve');

    Route::post('verification/reject/{type}/{id}', function($type, $id) {
        // Handle institution rejection (type: university or college)
        return response()->json(['success' => true, 'message' => ucfirst($type) . ' rejected successfully']);
    })->name('verification.reject');

    // State Addd
    Route::resource('state', StateController::class)->middleware('canany:State-Add,State-Edit,State-Delete');
    Route::post('state-action', [StateController::class, 'GetTableData'])
        ->name('state.gettabledata');

    // State Addd
    Route::resource('city', CityController::class)->middleware('canany:City-Add,City-Edit,City-Delete');
    Route::post('city-action', [CityController::class, 'GetTableData'])
        ->name('city.gettabledata');

    // Area Addd
    Route::resource('area', AreaController::class)->middleware('canany:Area-Add,Area-Edit,Area-Delete');
    Route::post('area-action', [AreaController::class, 'GetTableData'])->name('area.gettabledata');

    Route::post('state-get-action', [AreaController::class, 'get_state'])->name('area.get_state');


    // Pincode Addd
    Route::resource('pincode', PincodeController::class)->middleware('canany:Zipcode-Add,Zipcode-Edit,Zipcode-Delete');
    Route::post('pincode-action', [PincodeController::class, 'GetTableData'])->name('pincode.gettabledata');


    Route::post('pincode-state-get-action', [PincodeController::class, 'get_city'])
        ->name('pincode.get_city');

    Route::post('area-city-get-action', [PincodeController::class, 'get_area'])
        ->name('pincode.get_area');

    // Permission Addd
    Route::resource('permission', PermissionController::class);
    Route::post('permission-action', [PermissionController::class, 'GetTableData'])
        ->name('permission.gettabledata');

    // Role Addd
    Route::resource('roles', RolesController::class);
    Route::post('roles-action', [RolesController::class, 'GetTableData'])
        ->name('roles.gettabledata');

    Route::post('admin/roles/{id}/permissions', [RolesController::class, 'getRolePermissions']);




    // Candidate
    Route::get('candidate-none-skill', [CandidateController::class, 'NonSkillCandidate'])->name('candidate-none-skill')->middleware('can:Candidate-non_skill_register');
    Route::get('candidate-skill', [CandidateController::class, 'SkillCandidate'])->name('candidate-skill')->middleware('can:Candidate-skill_register');;

    Route::post('candidate-skill-action', [CandidateController::class, 'SkillDataTable'])
        ->name('skill.gettabledata');

    Route::post('candidate-none-skill-action', [CandidateController::class, 'NoneSkillDataTable'])
        ->name('none-skill.gettabledata');

    Route::post('none-skill-user-status', [CandidateController::class, 'NoneSkillUserStatus'])->name('none-skill-user-status');
    Route::post('skill-user-status', [CandidateController::class, 'SkillUserStatus'])->name('skill-user-status');



    // company list
    Route::get('company-list', [CompanyController::class, 'CompanyList'])->name('company-list')->middleware('can:Company-company_list');

    Route::post('company-list-action', [CompanyController::class, 'CompanyDataTable'])
        ->name('company.gettabledata');

    Route::post('upload-company-kyc/{id}', [CompanyprofileController::class, 'kycStore'])
    ->name('upload-company-kyc');



    // Pricing Addd
    Route::resource('pricing', PricingController::class)->middleware('canany:PlanPricing-Add,PlanPricing-Edit,PlanPricing-Delete');
    Route::post('pricing-action', [PricingController::class, 'GetTableData'])
        ->name('pricing.gettabledata');


    // candidate profile
    Route::get('candidate-profile/{id}', [CandidateprofileController::class, 'index'])->name('candidate-profile');

    Route::post('candidate-profile-update', [CandidateprofileController::class, 'CandidateProfile'])->name('candidate-profile-update');
    Route::post('candidate-profile-about-skill-update', [CandidateprofileController::class, 'CandidateProfileAboutSkill'])->name('candidate-profile-about-skill-update');
    Route::post('candidate-work-experience-update', [CandidateprofileController::class, 'CandidateWorkExperience'])->name('candidate-work-experience-update');
    Route::post('candidate-education-update', [CandidateprofileController::class, 'CandidateEducation'])->name('candidate-education-update');
    Route::post('candidate-remove-job', [CandidateprofileController::class, 'CandidateRemoveJob'])->name('candidate-remove-job');
    // Route::resource('candidate-profile', CandidateprofileController::class);


    Route::get('company-profile/{id}', [CompanyprofileController::class, 'index'])->name('company-profile');
    Route::post('company-profile-update', [CompanyprofileController::class, 'UpdateCompanyProfile'])->name('company-profile-update');
    Route::post('company-profile-about-update', [CompanyprofileController::class, 'UpdateCompanyAbout'])->name('company-profile-about-update');

    // Blog
    Route::resource('blog', BlogController::class)->middleware('canany:Blog-Add,Blog-Edit,Blog-Delete');
    Route::post('blog-action', [BlogController::class, 'GetTableData'])
        ->name('blog.gettabledata');


    // Achievements
    Route::resource('achievements', AchievementController::class)->middleware('can:Achievement-Update');
    Route::post('update-achievements', [AchievementController::class, 'update_achievements'])
        ->name('achievements.update-achievements');



    // Ad Banner
    Route::resource('ad-banner', AdbannerController::class)->middleware('canany:AdBanner-Add,AdBanner-Edit,AdBanner-Delete');
    Route::post('ad-banner-action', [AdbannerController::class, 'GetTableData'])
        ->name('adbanner.gettabledata');


    // candidates-register-list
    Route::resource('candidates-register-list', CandidateregisterlistController::class)->middleware('can:Candidate-candidate_register_list');
    Route::post('candidates-register-list-action', [CandidateregisterlistController::class, 'GetTableData'])
        ->name('candidates-register-list.gettabledata');
    Route::post('view-candidates-plan-history', [CandidateregisterlistController::class, 'ViewCandidatesPlanHistory'])->name('view-candidates-plan-history');



    // Company-register-list
    Route::resource('company-register-list', CompanyregisterlistController::class)->middleware('can:Company-company_register_list');
    Route::post('company-register-list-action', [CompanyregisterlistController::class, 'GetTableData'])
        ->name('company-register-list.gettabledata');
    Route::post('view-company-plan-history', [CompanyregisterlistController::class, 'ViewCompanyPlanHistory'])->name('view-company-plan-history');



    // Paid Company
    Route::resource('paid-company', PaidcompanyController::class)->middleware('can:Company-paid_company');
    Route::post('paid-company-action', [PaidcompanyController::class, 'GetTableData'])
        ->name('paid-company-action.gettabledata');


    // Paid Company
    Route::resource('paid-candidate', PaidcandidateController::class)->middleware('can:Candidate-paid_candidate');
    Route::post('paid-candidate-action', [PaidcandidateController::class, 'GetTableData'])
        ->name('paid-candidate-action.gettabledata');


    // Expired Plan
    // Route::resource('paid-candidate', PaidcandidateController::class);

    Route::get('expire-company-plan', [ExpireplanController::class, 'ExpireCompanyPlanIndex'])
        ->name('expire-company-plan')->middleware('can:Company-company_expire_plan');

    Route::get('expire-candidates-plan', [ExpireplanController::class, 'ExpireCandidatePlanIndex'])
        ->name('expire-candidates-plan')->middleware('can:Candidate-candidate_expire_plan');

    Route::post('expire-company-action', [ExpireplanController::class, 'CompanygetTableData'])
        ->name('expire-company-action.getcompanytabledata');

    Route::post('expire-candidate-action', [ExpireplanController::class, 'CandidategetTableData'])
        ->name('expire-candidate-action.getcompanytabledata');


    Route::post('expired-plan-history', [ExpireplanController::class, 'ViewPlanHistory'])->name('expired-plan-history');



    // Free Plan

    Route::get('free-company-plan', [FreeplanController::class, 'FreeCompanyPlanIndex'])
        ->name('free-company-plan')->middleware('can:Company-free_company');

    Route::post('free-company-plan-action', [FreeplanController::class, 'FreeCompanygetTableData'])
        ->name('free-company-plan-action.getcompanytabledata');

    Route::get('free-candidate-plan', [FreeplanController::class, 'FreeCandidatePlanIndex'])
        ->name('free-candidate-plan')->middleware('can:Candidate-free_candidate');

    Route::post('free-candidate-plan-action', [FreeplanController::class, 'FreeCandidategetTableData'])
        ->name('free-candidate-plan-action.getcandidatetabledata');

    // Registrtion List
    Route::get('skillthon',[RegisterController::class, 'skillthonIndex'])->name('skillthon');
    Route::get('internship',[RegisterController::class, 'InternshipIndex'])->name('internship');
    Route::POST('skillthon-list', [RegisterController::class, 'SkillthonRegisterList'])->name('skillthon.list');
    Route::POST('internship-list', [RegisterController::class, 'InternshipRegisterList'])->name('internship.list');
    Route::post('skillthon-status-update',[RegisterController::class, 'updateSkillthonStatus'])->name('skillthon.status.update'); 
    Route::post('internship-status-update',[RegisterController::class, 'updateInternshipStatus'])->name('internship.status.update'); 


    // About
    Route::resource('about', AboutController::class);


    // testimonial
    Route::resource('testimonial', TestimonialController::class)->middleware('canany:Testimonial-AddX,Testimonial-Edit,Testimonial-Delete');
    Route::post('testimonial-action', [TestimonialController::class, 'GetTableData'])
        ->name('testimonial.gettabledata');



    Route::resource('setting', SettingController::class)->middleware('can:Setting-Update');


    // staff
    Route::resource('staff', StaffController::class);
    Route::get('add-staff', [StaffController::class, 'add_staff'])->name('add-staff');
    Route::post('staff-table-action', [StaffController::class, 'GetTableData'])
        ->name('staff.gettabledata');


    Route::get('assign-role-super-admin', [StaffController::class, 'RoleAssignSuperAdmin'])
        ->name('assign-role-super-admin');



    // Staff Activity History
    Route::get('staff-activity-history', [StaffactivityhistoryContoller::class, 'index'])
        ->name('staff-activity-history');

    Route::post('staff-activity-history-action', [StaffactivityhistoryContoller::class, 'getTableData'])
        ->name('staff-activity-history-action.gettabledata');




    // Internship Management Routes
    Route::get('internship-management', [InternshipController::class, 'index'])
        ->name('internship.management');
    
    Route::get('internship/create', [InternshipController::class, 'create'])
        ->name('internship.create');
    
    Route::get('internship/view/{id}', [InternshipController::class, 'view'])
        ->name('internship.view');
    
    Route::post('internship/store', [InternshipController::class, 'store'])
        ->name('internship.store');
    
    Route::post('internship/new-requests', [InternshipController::class, 'getNewRequestsData'])
        ->name('internship.new.requests.data');
    
    Route::post('internship/processing', [InternshipController::class, 'getProcessingData'])
        ->name('internship.processing.data');
    
    Route::post('internship/completed', [InternshipController::class, 'getCompletedData'])
        ->name('internship.completed.data');
    
    Route::get('internship/details/{id}', [InternshipController::class, 'getInternshipDetails'])
        ->name('internship.details');
    
    Route::post('internship/accept', [InternshipController::class, 'acceptInternship'])
        ->name('internship.accept');
    
    Route::post('internship/reject', [InternshipController::class, 'rejectInternship'])
        ->name('internship.reject');
    
    Route::post('internship/update-progress', [InternshipController::class, 'updateProgress'])
        ->name('internship.update.progress');
    
    Route::get('internship/statistics', [InternshipController::class, 'getStatistics'])
        ->name('internship.statistics');

    // Certificate Management Routes
    Route::get('internship/certificates', [InternshipController::class, 'certificates'])
        ->name('internship.certificates');
    
    Route::get('internship/certificates/students/{id}', [InternshipController::class, 'getCertificateStudents'])
        ->name('internship.certificates.students');
    
    Route::get('internship/certificates/download/{studentId}', [InternshipController::class, 'downloadCertificate'])
        ->name('internship.certificates.download');
    
    Route::get('internship/certificates/download-all/{internshipId}', [InternshipController::class, 'downloadAllCertificates'])
        ->name('internship.certificates.download.all');
    
    Route::get('internship/certificates/export', [InternshipController::class, 'exportCertificates'])
        ->name('internship.certificates.export');

    // Manage Grade Routes
    Route::get('manage-grade', [ManageGradeController::class, 'index'])
        ->name('manage-grade.index');
    
    Route::get('manage-grade/add/{id}', [ManageGradeController::class, 'addGrade'])
        ->name('manage-grade.add');
    
    Route::post('manage-grade/store', [ManageGradeController::class, 'store'])
        ->name('manage-grade.store');
    
    Route::get('manage-grade/edit/{id}', [ManageGradeController::class, 'edit'])
        ->name('manage-grade.edit');
    
    Route::post('manage-grade/update/{id}', [ManageGradeController::class, 'update'])
        ->name('manage-grade.update');

    // College Management Routes
    Route::get('college', [CollegeController::class, 'index'])
        ->name('college.index');
    
    Route::post('college/data', [CollegeController::class, 'getCollegesData'])
        ->name('college.data');
    
    Route::post('college/store', [CollegeController::class, 'store'])
        ->name('college.store');
    
    Route::get('college/edit/{id}', [CollegeController::class, 'edit'])
        ->name('college.edit');
    
    Route::post('college/update', [CollegeController::class, 'update'])
        ->name('college.update');
    
    Route::delete('college/delete/{id}', [CollegeController::class, 'destroy'])
        ->name('college.destroy');
    
    Route::get('college/statistics', [CollegeController::class, 'getStatistics'])
        ->name('college.statistics');

    // College Dashboard Routes
    Route::get('college-dashboard', [CollegeDashboardController::class, 'index'])
        ->name('college.dashboard');
    
    Route::get('college-dashboard/students', [CollegeDashboardController::class, 'students'])
        ->name('college.students');
    
    Route::get('college-dashboard/applications', [CollegeDashboardController::class, 'applications'])
        ->name('college.applications');
    
    Route::post('college-dashboard/students/data', [CollegeDashboardController::class, 'getStudentsData'])
        ->name('college.students.data');
    
    Route::post('college-dashboard/applications/data', [CollegeDashboardController::class, 'getApplicationsData'])
        ->name('college.applications.data');
    
    Route::post('college-dashboard/students/store', [CollegeDashboardController::class, 'storeStudent'])
        ->name('college.students.store');
    
    Route::put('college-dashboard/students/{id}/status', [CollegeDashboardController::class, 'updateStudentStatus'])
        ->name('college.students.status');
    
    Route::put('college-dashboard/applications/{id}/status', [CollegeDashboardController::class, 'updateApplicationStatus'])
        ->name('college.applications.status');
    
    Route::delete('college-dashboard/students/{id}', [CollegeDashboardController::class, 'deleteStudent'])
        ->name('college.students.delete');
    
    Route::get('college-dashboard/students/export', [CollegeDashboardController::class, 'exportStudents'])
        ->name('college.students.export');
    
    Route::get('college-dashboard/applications/export', [CollegeDashboardController::class, 'exportApplications'])
        ->name('college.applications.export');

});
