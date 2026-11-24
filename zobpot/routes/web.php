<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AdbannerController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TipsController;
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
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PartnerController;

use App\Http\Controllers\Admin\InternshipController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\ManageGradeController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\College\CollegeDashboardController;


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

// Route::get('/cache-clear', function () {
//     $exitCode = Artisan::call('cache:clear');
//     $exitCode2 = Artisan::call('route:clear');
//     $exitCode3 = Artisan::call('view:clear');
//     $exitCode4 = Artisan::call('config:cache');
//     $exitCode5 = Artisan::call('config:clear');
//     return 'All cache cleared';
// });


Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "✅ Storage link created successfully!";
});


// Internship Application History
Route::get('/my-internship-applications/{slug}', [WebsiteController::class, 'internshipApplicationHistory'])->name('internship.application.history');



// Internship Website route
Route::get('internship', [WebsiteController::class, 'internship'])->name('internship');
Route::get('internship-detail/{slugOrId}', [WebsiteController::class, 'internshipDetail'])->name('internship.detail');
Route::post('internship/wishlist/toggle', [WebsiteController::class, 'toggleWishlist'])->name('internship.wishlist.toggle');
Route::get('internship/wishlist/check', [WebsiteController::class, 'checkWishlist'])->name('internship.wishlist.check');
Route::post('internship/payment-data', [WebsiteController::class, 'getInternshipPaymentData'])->name('internship.payment.data');


// Internship College Info - AJAX endpoints
Route::get('get-universities', [WebsiteController::class, 'getUniversities'])->name('get.universities');
Route::post('get-colleges-by-university', [WebsiteController::class, 'getCollegesByUniversity'])->name('get.colleges.by.university');
Route::get('get-degree-levels', [WebsiteController::class, 'getDegreeLevels'])->name('get.degree.levels');
Route::post('get-degrees-by-level', [WebsiteController::class, 'getDegreesByLevel'])->name('get.degrees.by.level');
Route::post('get-majors-by-degree', [WebsiteController::class, 'getMajorsByDegree'])->name('get.majors.by.degree');
// Degrees filtered by college (used on internship college modal)
Route::post('get-degrees-by-college', [WebsiteController::class, 'getDegreesByCollege'])->name('get.degrees.by.college');
Route::post('get-majors-by-degree-and-college', [WebsiteController::class, 'getMajorsByDegreeAndCollege'])->name('get.majors.by.degree.and.college');
Route::post('submit-college-info', [WebsiteController::class, 'submitCollegeInfo'])->name('submit.college.info');
// Create internship application (called before initiating payment)
Route::post('internship/application/create', [WebsiteController::class, 'createInternshipApplication'])->name('internship.application.create');
Route::post('internship/razorpay/create-order', [WebsiteController::class, 'createInternshipRazorpayOrder'])->name('internship.razorpay.create-order');
Route::post('internship/razorpay/verify', [WebsiteController::class, 'verifyInternshipRazorpayPayment'])->name('internship.razorpay.verify');


Route::get('/my-internship-details/{slug}', [WebsiteController::class, 'my_internship_details'])->name('my-internship-details')->middleware('auth','role.user');

Route::get('/my-internship-certificate/{applicationId}/{type}/download', [WebsiteController::class, 'downloadMyCertificate'])
    ->middleware('auth', 'role.user')
    ->where(['applicationId' => '[0-9]+', 'type' => 'company|college'])
    ->name('my-internship-certificate.download');

Route::get('/my-internship-certificate/{applicationId}/{type}/preview', [WebsiteController::class, 'previewMyCertificate'])
    ->middleware('auth', 'role.user')
    ->where(['applicationId' => '[0-9]+', 'type' => 'company|college'])
    ->name('my-internship-certificate.preview');

// Company: download/preview student certificates from internship applications page
Route::get('/company-internship-certificate/{applicationId}/{type}/download', [WebsiteController::class, 'downloadCompanyStudentCertificate'])
    ->middleware('auth', 'role.user')
    ->where(['applicationId' => '[0-9]+', 'type' => 'company|college'])
    ->name('company-internship-certificate.download');

Route::get('/company-internship-certificate/{applicationId}/{type}/preview', [WebsiteController::class, 'previewCompanyStudentCertificate'])
    ->middleware('auth', 'role.user')
    ->where(['applicationId' => '[0-9]+', 'type' => 'company|college'])
    ->name('company-internship-certificate.preview');


// Submit internship task (student submission)
Route::post('internship/task/submit', [WebsiteController::class, 'submitTask'])->name('internship.task.submit')->middleware('auth','role.user');



Route::get('/pricing-plan-list', [WebsiteController::class, 'frontPlan'])->name('frontPlan');


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
Route::get('home', [WebsiteController::class, 'index'])->name('home');

Route::get('create-resume', [WebsiteController::class, 'create_resume'])->name('create-resume')->middleware('auth','role.user');

Route::get('privacy-policy', [WebsiteController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('term-and-conditions', [WebsiteController::class, 'term_and_conditions'])->name('term-and-conditions');


Route::get('faq', [WebsiteController::class, 'faq'])->name('faq');

Route::get('skillthon', [WebsiteController::class, 'skillthon'])->name('skillthon');
Route::post('/skillthon-store', [WebsiteController::class, 'skillthonStore'])->name('skillthon.store');
Route::post('/internship-store', [WebsiteController::class, 'internshipStore'])->name('internship.store');


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


// Company Internship Management Routes
Route::post('company/internship/store', [WebsiteController::class, 'companyInternshipStore'])->name('company.internship.store')->middleware('auth','role.user');
Route::post('company/category-subcategory-request', [WebsiteController::class, 'submitCategorySubcategoryRequest'])->name('company.category-subcategory.request')->middleware('auth','role.user');
Route::post('company/internship/update/{id}', [WebsiteController::class, 'companyInternshipUpdate'])->name('company.internship.update')->middleware('auth','role.user');
Route::delete('company/internship/delete/{id}', [WebsiteController::class, 'companyInternshipDestroy'])->name('company.internship.destroy')->middleware('auth','role.user');
Route::get('company/internship/edit/{id}', [WebsiteController::class, 'companyInternshipEdit'])->name('company.internship.edit')->middleware('auth','role.user');
Route::post('company/internship/change-status/{id}', [WebsiteController::class, 'companyInternshipChangeStatus'])->name('company.internship.change-status')->middleware('auth','role.user');


// Website Internship Completion & Grading Routes (company frontend)
Route::post('internship/website/save-marks', [WebsiteController::class, 'saveInternshipMarks'])->name('website.internship.save-marks')->middleware('auth','role.user');
Route::post('internship/website/save-feedback', [WebsiteController::class, 'saveInternshipFeedback'])->name('website.internship.save-feedback')->middleware('auth','role.user');
Route::get('internship/website/fetch-marks/{id}', [WebsiteController::class, 'fetchInternshipMarks'])->name('website.internship.fetch-marks')->middleware('auth','role.user');
Route::post('internship/website/submit-completion', [WebsiteController::class, 'submitInternshipCompletion'])->name('website.internship.submit-completion')->middleware('auth','role.user');
Route::get('internship/complete/{id}', [WebsiteController::class, 'internshipCompletePage'])->name('website.internship.complete')->middleware('auth','role.user');
Route::post('internship/website/instructions/{id}', [WebsiteController::class, 'saveInstructions'])->name('website.internship.instructions.save')->middleware('auth','role.user');


// Return JSON details for a single internship task
Route::get('internship/task/{id}/json', [WebsiteController::class, 'getTaskJson'])->name('internship.task.json')->middleware('auth','role.user');
// Return all student submissions for a master task
Route::get('internship/task/{id}/submissions', [WebsiteController::class, 'getTaskSubmissions'])->name('internship.task.submissions')->middleware('auth','role.user');
// Get student task note details
Route::get('internship/task/{taskId}/student/{studentId}/note', [WebsiteController::class, 'getStudentTaskNote'])->name('internship.task.student.note')->middleware('auth','role.user');
// Save task feedback
Route::post('internship/task/feedback', [WebsiteController::class, 'saveTaskFeedback'])->name('internship.task.feedback.save')->middleware('auth','role.user');
// Get task feedback
Route::get('internship/task/{taskId}/student/{studentId}/feedback', [WebsiteController::class, 'getTaskFeedback'])->name('internship.task.feedback.get')->middleware('auth','role.user');
// Update task (website-facing)
Route::post('internship/task/{taskId}/update', [WebsiteController::class, 'updateTask'])->name('internship.task.update')->middleware('auth','role.user');
// Delete task (website-facing)
Route::delete('internship/task/{taskId}/delete', [WebsiteController::class, 'deleteTask'])->name('internship.task.delete')->middleware('auth','role.user');

// Save internship review
Route::post('internship/review', [WebsiteController::class, 'saveInternshipReview'])->name('internship.review')->middleware('auth','role.user');




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

// job title csv upload mate 
// Route::get('import-job-titles', function () {

//     $csvPath = base_path('job_titles.csv');

//     if (!file_exists($csvPath)) {
//         return "CSV file not found!";
//     }

//     $file = fopen($csvPath, 'r');

//     $headers = fgetcsv($file);

//     while (($row = fgetcsv($file)) !== false) {

//         if (!isset($row[0])) {
//             continue;
//         }

//         $title = trim($row[0]);

//         // remove special / invisible chars
//         $title = preg_replace('/[^A-Za-z0-9\s\-]/', '', $title);

//         // skip empty
//         if ($title == '') {
//             continue;
//         }

//         // limit length (IMPORTANT)
//         $title = substr($title, 0, 255);

//         try {
//             DB::table('tbl_job_title')->insert([
//                 'title_name' => $title,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//         } catch (\Exception $e) {
//             continue; // skip error row
//         }
//         // dd($row);
//     }

//     fclose($file);

//     return "CSV Imported Successfully!";
// });

// 'middleware' => ['auth', 'is_admin']
Route::group(['middleware' => ['admin.auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {


    Route::get('login', [AuthController::class, 'admin_login'])->name('login');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('canany:Dashboard-today_candidates_register_list,Dashboard-today_company_register_list,Dashboard-paid_company,Dashboard-paid_candidates,Dashboard-free_company_Candidates,Dashboard-staff_activity_history,Dashboard-expired_plan_month,Dashboard-New_Internship_Requests,Dashboard-today_candidates_internship_list,Dashboard-today_candidates_skillothon_list');


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
    Route::post('job-category-requests-datatable', [JobcategoryController::class, 'getCategoryRequestsTableData'])
        ->name('job-category.requests.gettabledata');
    Route::post('job-category-requests/{id}/approve', [JobcategoryController::class, 'approveCategoryRequest'])
        ->name('job-category.requests.approve');
    Route::post('job-category-requests/{id}/reject', [JobcategoryController::class, 'rejectCategoryRequest'])
        ->name('job-category.requests.reject');


    // Master Sub Category Addd
    Route::resource('job-sub-category', JobsubcategoryController::class)->middleware('canany:SubCategory-Add,SubCategory-Edit,SubCategory-Delete');
    Route::post('job-sub-category-datatable', [JobsubcategoryController::class, 'GetTableData'])->name('job-sub-category-datatable.gettabledata');
    Route::post('job-sub-category-requests-datatable', [JobsubcategoryController::class, 'getSubcategoryRequestsTableData'])
        ->name('job-sub-category.requests.gettabledata');
    Route::post('job-sub-category-requests/{id}/approve', [JobsubcategoryController::class, 'approveSubcategoryRequest'])
        ->name('job-sub-category.requests.approve');
    Route::post('job-sub-category-requests/{id}/reject', [JobsubcategoryController::class, 'rejectSubcategoryRequest'])
        ->name('job-sub-category.requests.reject');

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
        
         Route::post('pricing-status', [PricingController::class, 'updateStatus'])
        ->name('pricing.status');


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


    // Interview Tips
    Route::resource('interview-tips', TipsController::class)->middleware('canany:InterviewTips-Add,InterviewTips-Edit,InterviewTips-Delete');
    Route::post('interview-tips-action', [TipsController::class, 'GetTableData'])
        ->name('interview-tips.gettabledata');


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
    Route::post('get-candidates-update-plan-data', [CandidateregisterlistController::class, 'getUpdatePlanData'])->name('get-candidates-update-plan-data');
    Route::post('update-candidates-plan', [CandidateregisterlistController::class, 'updatePlan'])->name('update-candidates-plan');

   


    // Company-register-list
    Route::resource('company-register-list', CompanyregisterlistController::class)->middleware('can:Company-company_register_list');
    Route::post('company-register-list-action', [CompanyregisterlistController::class, 'GetTableData'])
        ->name('company-register-list.gettabledata');
    Route::post('view-company-plan-history', [CompanyregisterlistController::class, 'ViewCompanyPlanHistory'])->name('view-company-plan-history');
    Route::post('get-company-update-plan-data', [CompanyregisterlistController::class, 'getUpdatePlanData'])->name('get-company-update-plan-data');
    Route::post('update-company-plan', [CompanyregisterlistController::class, 'updatePlan'])->name('update-company-plan');

Route::delete('/company/delete/{id}', [CompanyregisterlistController::class, 'delete'])->name('company.delete');


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
    // Route::resource('partners', PartnersController::class)->middleware('canany:Testimonial-AddX,Testimonial-Edit,Testimonial-Delete');
    Route::post('testimonial-action', [TestimonialController::class, 'GetTableData'])
        ->name('testimonial.gettabledata');

    Route::resource('partners', PartnerController::class);
    Route::post('partner-action', [PartnerController::class, 'GetTableData'])
    ->name('partner.gettabledata');



    Route::resource('setting', SettingController::class)->middleware('can:Setting-Update');


      // staff — specific routes must be registered before the resource route
    Route::get('add-staff', [StaffController::class, 'add_staff'])->name('add-staff');
    Route::post('staff-table-action', [StaffController::class, 'GetTableData'])->name('staff.gettabledata');
    Route::get('staff/assign-internship', [StaffController::class, 'assignInternship'])->name('staff.assign-internship');
    Route::get('staff/assign-internship-super', [StaffController::class, 'assignInternshipSuper'])->name('staff.assign-internship-super');
    Route::post('staff/assign-internship-super-data', [StaffController::class, 'assignInternshipSuperData'])->name('staff.assign-internship-super-data');
    Route::resource('staff', StaffController::class);


    Route::get('assign-role-super-admin', [StaffController::class, 'RoleAssignSuperAdmin'])
        ->name('assign-role-super-admin');



    // Staff Activity History
    Route::get('staff-activity-history', [StaffactivityhistoryContoller::class, 'index'])
        ->name('staff-activity-history');

    Route::post('staff-activity-history-action', [StaffactivityhistoryContoller::class, 'getTableData'])
        ->name('staff-activity-history-action.gettabledata');


        
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
    
    
     // Internship Management Routes
    Route::get('internship-management', [InternshipController::class, 'index'])->name('internship.management')->middleware('canany:Internship-Add,Internship-Edit,Internship-Delete,Internship-Approve,Internship-Reject,Internship-View');

    Route::get('internship/applied-internships', [InternshipController::class, 'appliedInternships'])
        ->name('internship.applied-internships')
        ->middleware('can:Internship-Application-View');

    Route::get('internship/applied-internships-data', [InternshipController::class, 'appliedInternshipsData'])
        ->name('internship.applied-internships.data')
        ->middleware('can:Internship-Application-View');

    Route::delete('internship/applied-internships/{id}', [InternshipController::class, 'deleteApplication'])
        ->name('internship.applied-internships.delete')
        ->middleware('can:Internship-Application-Delete');
    
    Route::get('internship/create', [InternshipController::class, 'create'])->name('internship.create')->middleware('can:Internship-Add');
    
    Route::get('internship/view/{id}', [InternshipController::class, 'view'])->name('internship.view')->middleware('can:Internship-View');
    
    Route::post('internship/store', [InternshipController::class, 'store'])->name('internship.store')->middleware('can:Internship-Add');
    
    Route::get('internship/edit/{id}', [InternshipController::class, 'edit'])->name('internship.edit')->middleware('can:Internship-Edit');
    
    Route::put('internship/update/{id}', [InternshipController::class, 'update'])->name('internship.update')->middleware('can:Internship-Edit');
    
    Route::delete('internship/{id}', [InternshipController::class, 'destroy'])->name('internship.destroy')->middleware('can:Internship-Delete');
    
    Route::post('internship/update-instructions/{id}', [InternshipController::class, 'updateInstructions'])->name('internship.updateInstructions');
    
    Route::post('internship/new-requests', [InternshipController::class, 'getNewRequestsData'])->name('internship.new-requests-data');
    
    Route::post('internship/approved', [InternshipController::class, 'getApprovedData'])->name('internship.approved-data');
    
    
    // Staff list & bulk assign for internships
    Route::get('internship/staff-list', [InternshipController::class, 'getStaffList'])->name('internship.staff-list');
    Route::post('internship/assign-staff', [InternshipController::class, 'bulkAssignToStaff'])->name('internship.assign-staff')->middleware('can:Internship-Edit');
    
    Route::post('internship/rejected', [InternshipController::class, 'getRejectedData'])->name('internship.rejected-data');
    
    Route::post('internship/processing', [InternshipController::class, 'getProcessingData'])->name('internship.processing-data');
    
    Route::post('internship/completed', [InternshipController::class, 'getCompletedData'])->name('internship.completed-data');
    
    Route::get('internship/details/{id}', [InternshipController::class, 'getInternshipDetails'])->name('internship.details');
    
    Route::post('internship/accept/{id}', [InternshipController::class, 'acceptInternship'])->name('internship.accept')->middleware('can:Internship-Approve');
    
    Route::post('internship/reject/{id}', [InternshipController::class, 'rejectInternship'])->name('internship.reject')->middleware('can:Internship-Reject');
    
    Route::post('internship/update-progress', [InternshipController::class, 'updateProgress'])->name('internship.update.progress');
    
    Route::get('internship/statistics', [InternshipController::class, 'getStatistics'])->name('internship.statistics');

    // Students for an internship (applied students list for DataTables)
    Route::post('internship/students-data', [InternshipController::class, 'getStudentsData'])->name('internship.students-data');
    Route::get('internship/student-academic/{applicationId}', [InternshipController::class, 'getEnrolledStudentAcademic'])->name('internship.student-academic.get')->middleware('can:Internship-View');
    Route::post('internship/student-academic/{applicationId}', [InternshipController::class, 'updateEnrolledStudentAcademic'])->name('internship.student-academic.update')->middleware('can:Internship-Edit');

    // Certificate Management Routes
    Route::get('internship/certificates', [InternshipController::class, 'certificates'])->name('internship.certificates');

    Route::get('internship/certificate-settings', [\App\Http\Controllers\Admin\CertificateSettingController::class, 'index'])
        ->name('internship.certificate-settings')
        ->middleware('canany:Internship-Add,Internship-Edit,Internship-View');
    Route::post('internship/certificate-settings', [\App\Http\Controllers\Admin\CertificateSettingController::class, 'update'])
        ->name('internship.certificate-settings.update')
        ->middleware('canany:Internship-Add,Internship-Edit');
    
    Route::get('internship/certificates/students/{id}', [InternshipController::class, 'getCertificateStudents'])->name('internship.certificates.students');
    
    Route::get('internship/certificates/download/{studentId}', [InternshipController::class, 'downloadCertificate'])->name('internship.certificates.download');
    
    Route::get('internship/certificates/download-all/{internshipId}', [InternshipController::class, 'downloadAllCertificates'])->name('internship.certificates.download.all');
    
    Route::get('internship/certificates/export', [InternshipController::class, 'exportCertificates'])->name('internship.certificates.export');

    // Student certificate preview & PDF download (company / college)
    Route::get('internship/certificate/{applicationId}/{type}/preview', [InternshipController::class, 'previewStudentCertificate'])
        ->where(['applicationId' => '[0-9]+', 'type' => 'company|college'])
        ->name('internship.certificate.preview');
    Route::get('internship/certificate/{applicationId}/{type}/download', [InternshipController::class, 'downloadStudentCertificate'])
        ->where(['applicationId' => '[0-9]+', 'type' => 'company|college'])
        ->name('internship.certificate.download');

    // Internship Task Management Routes
    Route::post('internship/{id}/tasks/store', [InternshipController::class, 'storeTask'])->name('internship.tasks.store');
    // Website: get/save general instructions via AJAX
    Route::get('internship/{id}/instructions', [WebsiteController::class, 'getInstructions'])->name('internship.instructions.get');
    Route::post('internship/{id}/instructions', [WebsiteController::class, 'saveInstructions'])->name('internship.instructions.save');
    
    Route::get('internship/{id}/tasks', [InternshipController::class, 'getTasks'])->name('internship.tasks.get');
    
    Route::put('internship/tasks/{taskId}', [InternshipController::class, 'updateTask'])->name('internship.tasks.update');
    
    Route::delete('internship/tasks/{taskId}', [InternshipController::class, 'deleteTask'])->name('internship.tasks.delete');

    // Task Submissions, Notes & Feedback (Admin)
    Route::get('internship/task/{id}/submissions', [InternshipController::class, 'getTaskSubmissions'])->name('internship.task.submissions');
    Route::get('internship/task/{taskId}/student/{studentId}/note', [InternshipController::class, 'getStudentTaskNote'])->name('internship.task.student.note');
    Route::get('internship/task/{taskId}/student/{studentId}/feedback', [InternshipController::class, 'getTaskFeedback'])->name('internship.task.feedback.get');
    Route::post('internship/task/feedback', [InternshipController::class, 'saveTaskFeedback'])->name('internship.task.feedback.save');

    // Payments Data for an internship (Admin)
    Route::post('internship/{id}/payments-data', [InternshipController::class, 'getPaymentsData'])->name('internship.payments-data');

    // Single payment details and receipt PDF
    Route::get('internship/payment/{txn}/details', [InternshipController::class, 'getPaymentDetails'])->name('internship.payment.details');
    Route::get('internship/payment/{txn}/receipt', [InternshipController::class, 'downloadReceiptPDF'])->name('internship.payment.receipt');

    // Internship Completion & Grading Routes
    Route::post('internship/save-marks', [InternshipController::class, 'saveMarks'])->name('internship.save-marks');
    Route::post('internship/save-feedback', [InternshipController::class, 'saveFeedback'])->name('internship.save-feedback');
    Route::get('internship/fetch-marks/{id}', [InternshipController::class, 'fetchMarks'])->name('internship.fetch-marks');
    Route::post('internship/submit-completion', [InternshipController::class, 'submitInternship'])->name('internship.submit-completion');

    // College Marks Update Routes
    Route::get('internship/college-marks', [InternshipController::class, 'collegeMarksPage'])->name('internship.college-marks');
    Route::get('internship/colleges-by-university', [InternshipController::class, 'getCollegesByUniversity'])->name('internship.colleges-by-university');
    Route::get('internship/courses-by-college', [InternshipController::class, 'getCoursesByCollege'])->name('internship.courses-by-college');
    Route::post('internship/college-marks-data', [InternshipController::class, 'getCollegeMarksData'])->name('internship.college-marks-data');
    Route::post('internship/save-college-marks', [InternshipController::class, 'saveCollegeMarks'])->name('internship.save-college-marks');
    Route::post('internship/save-college-feedback', [InternshipController::class, 'saveCollegeFeedback'])->name('internship.save-college-feedback');
    Route::post('internship/submit-college-completion', [InternshipController::class, 'submitCollegeMarks'])->name('internship.submit-college-completion');
    Route::post('internship/mark-college-pending/{id}', [InternshipController::class, 'markCollegePending'])->name('internship.mark-college-pending');
    Route::post('internship/college-pending-data', [InternshipController::class, 'getCollegePendingData'])->name('internship.college-pending-data');

    // College Marks History (Card View + Detail Page)
    Route::post('internship/college-marks-history/update-row', [InternshipController::class, 'updateMarksHistoryRow'])->name('internship.marks-history-update-row');
    Route::get('internship/college-marks-history', [InternshipController::class, 'collegeMarksHistoryCards'])->name('internship.college-marks-history');
    Route::get('internship/college-marks-history/{id}', [InternshipController::class, 'collegeMarksHistoryDetail'])->name('internship.college-marks-history-detail');
    Route::get('internship/export-marks-history/{id}', [InternshipController::class, 'exportMarksHistory'])->name('internship.export-marks-history');

    // Internship Review Management
    Route::get('internship/reviews', [InternshipController::class, 'reviewManagementPage'])->name('internship.reviews');
    Route::get('internship/reviews-data', [InternshipController::class, 'getReviewsData'])->name('internship.reviews-data');
    Route::post('internship/review/{id}/status', [InternshipController::class, 'updateReviewStatus'])->name('internship.review-status');
    Route::get('internship/reviews-stats', [InternshipController::class, 'getReviewStats'])->name('internship.reviews-stats');

    // University Management
    Route::get('university', [UniversityController::class, 'index'])->name('university.index')->middleware('canany:University-Add,University-Edit,University-Delete,University-Approve,University-Reject');
    Route::get('university/data', [UniversityController::class, 'getData'])->name('university.data');
    Route::post('university', [UniversityController::class, 'store'])->name('university.store')->middleware('can:University-Add');
    Route::get('university/{id}/edit', [UniversityController::class, 'edit'])->name('university.edit')->middleware('can:University-Edit');
    Route::put('university/{id}', [UniversityController::class, 'update'])->name('university.update')->middleware('can:University-Edit');
    Route::post('university/{id}/approve', [UniversityController::class, 'approve'])->name('university.approve')->middleware('can:University-Approve');
    Route::post('university/{id}/reject', [UniversityController::class, 'reject'])->name('university.reject')->middleware('can:University-Reject');
    Route::post('university/check-exists', [UniversityController::class, 'checkExists'])->name('university.checkExists');
    Route::delete('university/{id}', [UniversityController::class, 'destroy'])->name('university.destroy')->middleware('can:University-Delete');
    Route::get('university/all', [UniversityController::class, 'getAll'])->name('university.all');
    Route::post('university/{id}/replace', [UniversityController::class, 'replaceUniversity'])->name('university.replace');

    // College Management
    Route::get('college', [CollegeController::class, 'index'])->name('college.index')->middleware('canany:College-Add,College-Edit,College-Delete,College-Approve,College-Reject,College-View');
    Route::get('college/data', [CollegeController::class, 'getData'])->name('college.data');
    Route::post('college', [CollegeController::class, 'store'])->name('college.store')->middleware('can:College-Add');
    Route::get('college/{id}/edit', [CollegeController::class, 'edit'])->name('college.edit')->middleware('can:College-Edit');
    Route::get('college/{id}/show', [CollegeController::class, 'show'])->name('college.show')->middleware('can:College-View');
    Route::post('college/{id}/update', [CollegeController::class, 'update'])->name('college.update')->middleware('can:College-Edit');
    Route::post('college/{id}/approve', [CollegeController::class, 'approve'])->name('college.approve')->middleware('can:College-Approve');
    Route::post('college/{id}/reject', [CollegeController::class, 'reject'])->name('college.reject')->middleware('can:College-Reject');
    Route::post('college/check-exists', [CollegeController::class, 'checkExists'])->name('college.checkExists');
    Route::get('college/all', [CollegeController::class, 'getAllColleges'])->name('college.all');
    Route::post('college/{id}/replace', [CollegeController::class, 'replaceCollege'])->name('college.replace');
    Route::delete('college/{id}', [CollegeController::class, 'destroy'])->name('college.destroy')->middleware('can:College-Delete');

    // College Profile Module
    Route::get('college-profile/{id}', [App\Http\Controllers\Admin\CollegeprofileController::class, 'index'])->name('college-profile');
    Route::post('college-profile/update', [App\Http\Controllers\Admin\CollegeprofileController::class, 'updateProfile'])->name('college-profile.update');
    Route::post('college-profile/students-data', [App\Http\Controllers\Admin\CollegeprofileController::class, 'getStudentsData'])->name('college-profile.students-data');
    Route::post('college-profile/internships-data', [App\Http\Controllers\Admin\CollegeprofileController::class, 'getInternshipsData'])->name('college-profile.internships-data');
    Route::post('college-profile/deactivate', [App\Http\Controllers\Admin\CollegeprofileController::class, 'deactivate'])->name('college-profile.deactivate');
    
    
    
    
    // Degree Level Routes
    Route::get('degree-level', [App\Http\Controllers\Admin\DegreeLevelController::class, 'index'])->name('degree-level.index')->middleware('canany:Degree_Level-Add,Degree_Level-Edit,Degree_Level-Delete,Degree_Level-Approve,Degree_Level-Reject');
    Route::get('degree-level/data', [App\Http\Controllers\Admin\DegreeLevelController::class, 'getData'])->name('degree-level.data');
    Route::post('degree-level', [App\Http\Controllers\Admin\DegreeLevelController::class, 'store'])->name('degree-level.store')->middleware('can:Degree_Level-Add');
    Route::get('degree-level/{id}/edit', [App\Http\Controllers\Admin\DegreeLevelController::class, 'edit'])->name('degree-level.edit')->middleware('can:Degree_Level-Edit');
    Route::get('degree-level/{id}/details', [App\Http\Controllers\Admin\DegreeLevelController::class, 'details'])->name('degree-level.details');
    Route::put('degree-level/{id}', [App\Http\Controllers\Admin\DegreeLevelController::class, 'update'])->name('degree-level.update')->middleware('can:Degree_Level-Edit');
    Route::delete('degree-level/{id}', [App\Http\Controllers\Admin\DegreeLevelController::class, 'destroy'])->name('degree-level.destroy')->middleware('can:Degree_Level-Delete');
    Route::post('degree-level/{id}/approve', [App\Http\Controllers\Admin\DegreeLevelController::class, 'approve'])->name('degree-level.approve')->middleware('can:Degree_Level-Approve');
    Route::post('degree-level/{id}/reject', [App\Http\Controllers\Admin\DegreeLevelController::class, 'reject'])->name('degree-level.reject')->middleware('can:Degree_Level-Reject');
    
    
     // Degree Routes
    Route::get('degree', [App\Http\Controllers\Admin\DegreeController::class, 'index'])->name('degree.index')->middleware('canany:Degrees-Add,Degrees-Edit,Degrees-Delete,Degrees-Approve,Degrees-Reject');
    Route::get('degree/data', [App\Http\Controllers\Admin\DegreeController::class, 'getData'])->name('degree.data');
    Route::post('degree', [App\Http\Controllers\Admin\DegreeController::class, 'store'])->name('degree.store')->middleware('can:Degrees-Add');
    Route::get('degree/{id}/edit', [App\Http\Controllers\Admin\DegreeController::class, 'edit'])->name('degree.edit')->middleware('can:Degrees-Edit');
    Route::put('degree/{id}', [App\Http\Controllers\Admin\DegreeController::class, 'update'])->name('degree.update')->middleware('can:Degrees-Edit');
    Route::delete('degree/{id}', [App\Http\Controllers\Admin\DegreeController::class, 'destroy'])->name('degree.destroy')->middleware('can:Degrees-Delete');
    Route::post('degree/{id}/approve', [App\Http\Controllers\Admin\DegreeController::class, 'approve'])->name('degree.approve')->middleware('can:Degrees-Approve');
    Route::post('degree/{id}/reject', [App\Http\Controllers\Admin\DegreeController::class, 'reject'])->name('degree.reject')->middleware('can:Degrees-Reject');
    Route::get('degree/{id}/details', [App\Http\Controllers\Admin\DegreeController::class, 'details'])->name('degree.details');
    Route::post('degree/by-level', [App\Http\Controllers\Admin\DegreeController::class, 'getDegreesByLevel'])->name('degree.by-level');
    Route::get('degree/all', [App\Http\Controllers\Admin\DegreeController::class, 'getAllDegrees'])->name('degree.all');
    
    
    
    // Major Routes
    Route::get('major', [App\Http\Controllers\Admin\MajorController::class, 'index'])->name('major.index')->middleware('canany:Major-Add,Major-Edit,Major-Delete,Major-Approve,Major-Reject');
    Route::get('major/data', [App\Http\Controllers\Admin\MajorController::class, 'getData'])->name('major.data');
    Route::post('major', [App\Http\Controllers\Admin\MajorController::class, 'store'])->name('major.store')->middleware('can:Major-Add');
    Route::get('major/{id}/edit', [App\Http\Controllers\Admin\MajorController::class, 'edit'])->name('major.edit')->middleware('can:Major-Edit');
    Route::put('major/{id}', [App\Http\Controllers\Admin\MajorController::class, 'update'])->name('major.update')->middleware('can:Major-Edit');
    Route::delete('major/{id}', [App\Http\Controllers\Admin\MajorController::class, 'destroy'])->name('major.destroy')->middleware('can:Major-Delete');
    Route::post('major/{id}/approve', [App\Http\Controllers\Admin\MajorController::class, 'approve'])->name('major.approve')->middleware('can:Major-Approve');
    Route::post('major/{id}/reject', [App\Http\Controllers\Admin\MajorController::class, 'reject'])->name('major.reject')->middleware('can:Major-Reject');
    Route::get('major/{id}/details', [App\Http\Controllers\Admin\MajorController::class, 'details'])->name('major.details');
    Route::get('major/all', [App\Http\Controllers\Admin\MajorController::class, 'getAllMajors'])->name('major.all');
    
    
       // Manage Grade Routes
    Route::get('manage-grade', [ManageGradeController::class, 'index'])->name('manage-grade.index');
    
    Route::get('manage-grade/add/{id}', [ManageGradeController::class, 'add'])->name('manage-grade.add');
    
    Route::post('manage-grade/fetch-data', [ManageGradeController::class, 'fetchGradeData'])->name('manage-grade.fetch-data');
    
    Route::post('manage-grade/store', [ManageGradeController::class, 'store'])->name('manage-grade.store');
    
    Route::get('manage-grade/edit/{id}', [ManageGradeController::class, 'edit'])->name('manage-grade.edit');
    
    Route::post('manage-grade/update/{id}', [ManageGradeController::class, 'update'])->name('manage-grade.update');
    
    
    
    // College Dashboard Routes
    Route::get('college-dashboard', [CollegeDashboardController::class, 'index'])->name('college.dashboard');
    Route::get('college-settings', [\App\Http\Controllers\College\CollegeSettingsController::class, 'index'])->name('college.settings');
    Route::post('college-settings/update', [\App\Http\Controllers\College\CollegeSettingsController::class, 'update'])->name('college.settings.update');
    Route::get('college-registration-list', [CollegeDashboardController::class, 'registrationList'])->name('college.registration-list');
    Route::post('college-registration-list/data', [CollegeDashboardController::class, 'getRegistrationData'])->name('college.registration-list.data');
    Route::post('college-staff-dashboard/assigned-students', [CollegeDashboardController::class, 'getAssignedStudentsData'])->name('college.staff-dashboard.assigned-students');
    Route::post('college-staff-dashboard/internships', [CollegeDashboardController::class, 'getStaffInternshipsData'])->name('college.staff-dashboard.internships');
    Route::get('college-pending-marks', [CollegeDashboardController::class, 'pendingMarks'])->name('college.pending-marks');
    Route::post('college-pending-marks/data', [CollegeDashboardController::class, 'getPendingMarksData'])->name('college.pending-marks.data');
    
    
    // College Staff Management Routes
    Route::get('college-staff', [\App\Http\Controllers\College\CollegeStaffController::class, 'index'])->name('college.staff.index');
    Route::post('college-staff/data', [\App\Http\Controllers\College\CollegeStaffController::class, 'getStaffData'])->name('college.staff.data');
    Route::post('college-staff/store', [\App\Http\Controllers\College\CollegeStaffController::class, 'store'])->name('college.staff.store');
    Route::get('college-staff/roles-list', [\App\Http\Controllers\College\CollegeStaffController::class, 'getRolesList'])->name('college.staff.roles-list');
    Route::get('college-staff/{id}/edit', [\App\Http\Controllers\College\CollegeStaffController::class, 'edit'])->name('college.staff.edit');
    Route::match(['PUT','POST'], 'college-staff/{id}/update', [\App\Http\Controllers\College\CollegeStaffController::class, 'update'])->name('college.staff.update');
    Route::match(['DELETE','POST'], 'college-staff/{id}/delete', [\App\Http\Controllers\College\CollegeStaffController::class, 'destroy'])->name('college.staff.destroy');

    // College Role Management Routes
    Route::get('college-roles', [\App\Http\Controllers\College\CollegeStaffController::class, 'roles'])->name('college.roles.index');
    Route::post('college-roles/data', [\App\Http\Controllers\College\CollegeStaffController::class, 'getRolesData'])->name('college.roles.data');
    Route::post('college-roles/store', [\App\Http\Controllers\College\CollegeStaffController::class, 'storeRole'])->name('college.roles.store');
    Route::get('college-roles/{id}/permissions', [\App\Http\Controllers\College\CollegeStaffController::class, 'getRolePermissions'])->name('college.roles.permissions');
    Route::match(['PUT','POST'], 'college-roles/{id}/update', [\App\Http\Controllers\College\CollegeStaffController::class, 'updateRole'])->name('college.roles.update');
    Route::match(['DELETE','POST'], 'college-roles/{id}/delete', [\App\Http\Controllers\College\CollegeStaffController::class, 'destroyRole'])->name('college.roles.destroy');

    // College Internship Management Routes
    Route::post('college-internship/processing-data', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getProcessingData'])->name('college-internship.processing-data');
    Route::post('college-internship/completed-data', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getCompletedData'])->name('college-internship.completed-data');
    Route::get('college-internship/view/{id}', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'view'])->name('college-internship.view');
    Route::post('college-internship/applied-students', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getAppliedStudents'])->name('college-internship.applied-students');
    Route::get('college-internship/staff-list', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getStaffList'])->name('college-internship.staff-list');
    Route::post('college-internship/assign-staff', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'assignStaff'])->name('college-internship.assign-staff');
    Route::get('college-internship/task/{id}/submissions', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getTaskSubmissions'])->name('college-internship.task.submissions');
    Route::get('college-internship/task/{taskId}/student/{studentId}/note', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getStudentTaskNote'])->name('college-internship.task.student.note');
    Route::get('college-internship/task/{taskId}/student/{studentId}/feedback', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getTaskFeedback'])->name('college-internship.task.feedback.get');
    Route::post('college-internship/staff-internships', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getStaffInternships'])->name('college-internship.staff-internships');
    Route::get('college-internship/statistics', [\App\Http\Controllers\Admin\CollegeInternshipController::class, 'getStatistics'])->name('college-internship.statistics');


});
