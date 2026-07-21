  @php
      $Setting = App\Models\Setting::where('id', 1)->first();
  @endphp

  <!doctype html>

  <html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-theme="theme-default" data-assets-path="{{ asset('admin-assets') }}/" data-template="vertical-menu-template"
      data-style="light">

  <head>
      <meta charset="utf-8" />
      <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>Zobpot - Admin</title>

      <!-- Favicon -->
      <link rel="icon" type="image/x-icon"
          href="{{ $Setting ?? $Setting->favicon ? asset('uploads/logo_img/' . $Setting->favicon) : asset('assets/imgs/logo/favicon1.png') }}" />

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
          href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet" />

      <!-- Icons -->
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/boxicons.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/fontawesome.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/flag-icons.css') }}" />

      <!-- Core CSS -->
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/core.css') }}"
          class="template-customizer-core-css" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme-default.css?id=4') }}"
          class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{ asset('admin-assets/css/demo.css') }}" />

      <!-- Vendors CSS -->
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/apex-charts/apex-charts.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
      <link rel="stylesheet"
          href="{{ asset('admin-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
      <link rel="stylesheet"
          href="{{ asset('admin-assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/@form-validation/form-validation.css') }}" />



      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/animate-css/animate.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />


      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/select2/select2.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/tagify/tagify.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

      <!-- Helpers -->
      <script src="{{ asset('admin-assets/vendor/js/helpers.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/js/template-customizer.js') }}"></script>
      <script src="{{ asset('admin-assets/js/config.js') }}"></script>

      <link rel="stylesheet" href="{{ asset('admin-assets/css/toastr.css') }}" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <style>
      .table th {
          text-transform: capitalize !important;
      }

      .template-customizer-open-btn {
          display: none !important;
      }

      .ck-editor__editable_inline {
          height: 300px;
      }

      .color-red {
          color: red;
      }

      .loader {
          font-size: 48px;
          color: #FFF;
          display: inline-block;
          font-family: Arial, Helvetica, sans-serif;
          font-weight: 400;
          position: relative;
          left: 45%;
          top: 44%;
      }

      .loader:before {
          content: '';
          animation: 5s print linear alternate infinite;
      }

      .loader:after {
          content: '';
          position: absolute;
          right: -4px;
          top: 50%;
          transform: translatey(-45%);
          width: 2px;
          height: 1.3em;
          background: currentColor;
          opacity: 0.8;
          animation: 1s blink steps(2) infinite;
      }

      @keyframes blink {
          0% {
              visibility: hidden;
          }

          100% {
              visibility: visible;
          }
      }

      @keyframes print {
          0% {
              content: 'L'
          }

          10% {
              content: 'Lo'
          }

          20% {
              content: 'Loa'
          }

          30% {
              content: 'Load'
          }

          40% {
              content: 'Loadi'
          }

          50% {
              content: 'Loadin'
          }

          60% {
              content: 'Loading'
          }

          70% {
              content: 'Loading.'
          }

          80% {
              content: 'Loading..'
          }

          90%,
          100% {
              content: 'Loading...'
          }
      }

      .preloader {
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #000000c9;
          z-index: 9999;
      }

      #Loader {
          display: none;
      }
  </style>
  @stack('css')
  <script>
      var page_active_id = "Home";
  </script>

  <body>
      @php
          use Illuminate\Support\Facades\Auth;
          $user = Auth::user();
      @endphp
      <div class="preloader" id="Loader">
          <span class="loader"></span>
      </div>


      <!-- Layout wrapper -->
      <div class="layout-wrapper layout-content-navbar">
          <div class="layout-container">
              <!-- Menu -->
              <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                  <div class="app-brand demo">
                      <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                          <img src="{{ $Setting ?? $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}"
                              alt="Logo" style="max-width: 100%;">
                      </a>

                      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                          <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
                      </a>
                  </div>

                  <div class="menu-inner-shadow"></div>

                  <ul class="menu-inner py-1">
                      <!-- Dashboards -->
                      @canany(['Dashboard-today_candidates_register_list', 'Dashboard-today_company_register_list',
                          'Dashboard-paid_company', 'Dashboard-paid_candidates', 'Dashboard-free_company_Candidates',
                          'Dashboard-staff_activity_history', 'Dashboard-expired_plan_month'])
                          <li class="menu-item" title="Dashboard" id="Home">
                              <a href="{{ route('admin.dashboard') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-home-smile"></i>
                                  <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                              </a>
                          </li>
                      @endcanany

                      @canany(['Category-Add', 'Category-Edit', 'Category-Delete', 'SubCategory-Add',
                          'SubCategory-Edit', 'SubCategory-Delete', 'JobType-Add', 'JobType-Edit', 'JobType-Delete',
                          'JobLevel-Add', 'JobLevel-Edit', 'JobLevel-Delete', 'WorkType-Add', 'WorkType-Edit',
                          'WorkType-Delete', 'MinimumQualification-Add', 'MinimumQualification-Edit',
                          'MinimumQualification-Delete', 'ExperienceRequired-Add', 'ExperienceRequired-Edit',
                          'ExperienceRequired-Delete', 'Skills-Add', 'Skills-Edit', 'Skills-Delete'])
                          <li class="menu-item" title="Master" id="Master">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-layout"></i>
                                  <div class="text-truncate" data-i18n="Master">Master</div>
                              </a>

                              <ul class="menu-sub">
                                  @canany(['Category-Add', 'Category-Edit', 'Category-Delete'])
                                      <li class="menu-item sub-menu" id="Category">
                                          <a href="{{ route('admin.job-category.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Job Category">Job Category</div>
                                          </a>
                                      </li>
                                  @endcanany

                                  @canany(['SubCategory-Add', 'SubCategory-Edit', 'SubCategory-Delete'])
                                      <li class="menu-item sub-menu" id="SubCategory">
                                          <a href="{{ route('admin.job-sub-category.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Job Sub Category">Job Sub Category</div>
                                          </a>
                                      </li>
                                  @endcanany

                                  @canany(['JobType-Add', 'JobType-Edit', 'JobType-Delete'])
                                      <li class="menu-item sub-menu" id="JobType">
                                          <a href="{{ route('admin.job-type.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Job Type">Job Type</div>
                                          </a>
                                      </li>
                                  @endcanany

                                  @canany(['JobLevel-Add', 'JobLevel-Edit', 'JobLevel-Delete'])
                                      <li class="menu-item sub-menu" id="JobLevel">
                                          <a href="{{ route('admin.job-level.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Job Level">Job Level</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['JobTitle-Add', 'JobTitle-Edit', 'JobTitle-Delete'])
                                      <li class="menu-item sub-menu" id="JobTitle">
                                          <a href="{{ route('admin.job-title.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Job Title">Job Title</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['WorkType-Add', 'WorkType-Edit', 'WorkType-Delete'])
                                      <li class="menu-item sub-menu" id="WorkType">
                                          <a href="{{ route('admin.work-type.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Work Type">Work Type</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['MinimumQualification-Add', 'MinimumQualification-Edit',
                                      'MinimumQualification-Delete'])
                                      <li class="menu-item sub-menu" id="Qualification">
                                          <a href="{{ route('admin.min-qualification.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Minimum Qualification">Minimum
                                                  Qualification
                                              </div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['ExperienceRequired-Add', 'ExperienceRequired-Edit',
                                      'ExperienceRequired-Delete'])
                                      <li class="menu-item sub-menu" id="Experience">
                                          <a href="{{ route('admin.work-experience.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Experience Required">Experience Required
                                              </div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['Skills-Add', 'Skills-Edit', 'Skills-Delete'])
                                      <li class="menu-item sub-menu" id="Skill">
                                          <a href="{{ route('admin.skills.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Skills">Skills</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  <li class="menu-item sub-menu" id="GradeMaster">
                                      <a href="{{ route('admin.grade-master.index') }}" class="menu-link">
                                          <div class="text-truncate" data-i18n="Grade Master">Grade Master</div>
                                      </a>
                                  </li>
                                  <li class="menu-item sub-menu" id="University">
                                      <a href="{{ route('admin.university.index') }}" class="menu-link">
                                          <div class="text-truncate" data-i18n="University">University</div>
                                      </a>
                                  </li>
                                  <li class="menu-item sub-menu" id="College">
                                      <a href="{{ route('admin.college.index') }}" class="menu-link">
                                          <div class="text-truncate" data-i18n="College">College</div>
                                      </a>
                                  </li>
                              </ul>
                          </li>
                      @endcanany

                      <!-- Verification Menu -->
                      <li class="menu-item" title="Verification" id="Verification">
                          <a href="javascript:void(0);" class="menu-link menu-toggle">
                              <i class="menu-icon tf-icons bx bx-check-shield"></i>
                              <div class="text-truncate" data-i18n="Verification">Verification</div>
                          </a>
                          <ul class="menu-sub">
                              <li class="menu-item sub-menu" id="VerifyInstitutions">
                                  <a href="{{ route('admin.verification.institutions') }}" class="menu-link">
                                      <div class="text-truncate" data-i18n="Institutions">Institutions</div>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      @canany(['State-Add', 'State-Edit', 'State-Delete', 'City-Add', 'City-Edit', 'City-Delete',
                          'Area-Add', 'Area-Edit', 'Area-Delete', 'Zipcode-Add', 'Zipcode-Edit', 'Zipcode-Delete'])
                          <li class="menu-item" title="Location" id="Location">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-location-plus"></i>
                                  <div class="text-truncate" data-i18n="Location">Location</div>
                              </a>

                              <ul class="menu-sub">
                                  @canany(['State-Add', 'State-Edit', 'State-Delete'])
                                      <li class="menu-item sub-menu" id="State">
                                          <a href="{{ route('admin.state.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="State">State</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['City-Add', 'City-Edit', 'City-Delete'])
                                      <li class="menu-item sub-menu" id="City">
                                          <a href="{{ route('admin.city.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="City">City</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['Area-Add', 'Area-Edit', 'Area-Delete'])
                                      <li class="menu-item sub-menu" id="Area">
                                          <a href="{{ route('admin.area.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Area">Area</div>
                                          </a>
                                      </li>
                                  @endcanany
                                  @canany(['Zipcode-Add', 'Zipcode-Edit', 'Zipcode-Delete'])
                                      <li class="menu-item sub-menu" id="PinCode">
                                          <a href="{{ route('admin.pincode.index') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Pin Code">Pin Code</div>
                                          </a>
                                      </li>
                                  @endcanany
                              </ul>
                          </li>
                      @endcanany

                       @if ($user->role == 'Admin')
                          <li class="menu-item" title="Roles & Permissions" id="Role">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-check-shield"></i>
                                  <div class="text-truncate" data-i18n="Roles & Permissions">Roles & Permissions</div>
                              </a>
                              <ul class="menu-sub">
                                  <li class="menu-item sub-menu" id="Roles">
                                      <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                          <div class="text-truncate" data-i18n="Roles">Roles</div>
                                      </a>
                                  </li>
                                  {{-- <li class="menu-item sub-menu" id="Permission">
                                    <a href="{{ route('admin.permission.index') }}" class="menu-link">
                                        <div class="text-truncate" data-i18n="Permission">Permission</div>
                                    </a>
                                </li> --}}
                              </ul>
                           </li>

                          <li class="menu-item" title="Staff" id="Staff">
                              <a href="{{ route('admin.staff.index') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bx-group"></i>
                                  <div class="text-truncate" data-i18n="Staff">Staff</div>
                              </a>
                          </li>
                       @endif


                      @canany(['Candidate-skill_register', 'Candidate-non_skill_register'])
                          <li class="menu-item has-sub" id="Candidate">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-user"></i>
                                  <div class="text-truncate" data-i18n="Candidates">Candidates</div>
                              </a>

                              <ul class="menu-sub">
                                  @can('Candidate-non_skill_register')
                                      <li class="menu-item sub-menu" id="NonSkill">
                                          <a href="{{ route('admin.candidate-none-skill') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Non-Skilled">Non-Skilled</div>
                                          </a>
                                      </li>
                                  @endcan

                                  @can('Candidate-skill_register')
                                      <li class="menu-item sub-menu" id="Skill">
                                          <a href="{{ route('admin.candidate-skill') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Skilled">Skilled</div>
                                          </a>
                                      </li>
                                  @endcan
                              </ul>
                          </li>
                      @endcanany
                      <!-- Front Pages -->
                      @can('Company-company_list')
                          <li class="menu-item" title="Company" id="Company">
                              <a href="{{ route('admin.company-list') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-store"></i>
                                  <div class="text-truncate" data-i18n="Company">Company</div>
                              </a>
                          </li>
                      @endcan

                      <li class="menu-item has-sub" title="Internship" id="Internship">
                          <a href="javascript:void(0);" class="menu-link menu-toggle">
                              <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                              <div class="text-truncate" data-i18n="Internship">Internship</div>
                          </a>
                          <ul class="menu-sub">
                              <li class="menu-item sub-menu" id="InternshipManagement">
                                  <a href="{{ route('admin.internship.management') }}" class="menu-link">
                                      <div class="text-truncate" data-i18n="Internships">Internships</div>
                                  </a>
                              </li>
                              <li class="menu-item sub-menu" id="InternshipCertificates">
                                  <a href="{{ route('admin.internship.certificates') }}" class="menu-link">
                                      <div class="text-truncate" data-i18n="Certificates">Certificates</div>
                                  </a>
                              </li>
                          </ul>
                      </li>

                      <li class="menu-item" title="College" id="College">
                          <a href="{{ route('admin.college.index') }}" class="menu-link">
                              <i class="menu-icon tf-icons bx bxs-school"></i>
                              <div class="text-truncate" data-i18n="College">College</div>
                          </a>
                      </li>

                      <li class="menu-item" title="Manage Grade" id="ManageGrade">
                          <a href="{{ route('admin.manage-grade.index') }}" class="menu-link">
                              <i class="menu-icon tf-icons bx bx-medal"></i>
                              <div class="text-truncate" data-i18n="Manage Grade">Manage Grade</div>
                          </a>
                      </li>

                      @canany(['Candidate-candidate_register_list', 'Company-company_register_list',
                          'Company-paid_company', 'Candidate-paid_candidate', 'Candidate-free_candidate',
                          'Company-free_company', 'Candidate-candidate_expire_plan', 'Company-company_expire_plan'])
                          <li class="menu-header small text-uppercase">
                              <span class="menu-header-text" data-i18n="Manage Website Users">Manage Website Users</span>
                          </li>
                      @endcanany

                      @can('Candidate-candidate_register_list')
                          <li class="menu-item" title="Candidates Register List" id="CandidatesRegisterList">
                              <a href="{{ route('admin.candidates-register-list.index') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                                  <div class="text-truncate" data-i18n="Candidates Register List">Candidates Register List
                                  </div>
                              </a>
                          </li>
                      @endcan
                      @can('Company-company_register_list')
                          <li class="menu-item" title="Company Register List" id="CompanyRegisterList">
                              <a href="{{ route('admin.company-register-list.index') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bxs-building"></i>
                                  <div class="text-truncate" data-i18n="Company Register List">Company Register List</div>
                              </a>
                          </li>
                      @endcan

                      @can('Company-paid_company')
                          <li class="menu-item" title="Paid Company" id="PaidCompany">
                              <a href="{{ route('admin.paid-company.index') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bx-briefcase-alt"></i>
                                  <div class="text-truncate" data-i18n="Paid Company">Paid Company</div>
                              </a>
                          </li>
                      @endcan
                      @can('Candidate-paid_candidate')
                          <li class="menu-item" title="Paid Candidates" id="PaidCandidates">
                              <a href="{{ route('admin.paid-candidate.index') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bx-user-check"></i>
                                  <div class="text-truncate" data-i18n="Paid Candidates">Paid Candidates</div>
                              </a>
                          </li>
                      @endcan
                      @canany(['Candidate-free_candidate', 'Company-free_company'])
                          <li class="menu-item has-sub" id="FreeCompanyCandidates">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-user-minus"></i>
                                  <div class="text-truncate" data-i18n="Free Plans">Free Plans</div>
                              </a>

                              <ul class="menu-sub">
                                  @can('Company-free_company')
                                      <li class="menu-item sub-menu" id="Companys">
                                          <a href="{{ route('admin.free-company-plan') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Free Company Plan">Free Company Plan</div>
                                          </a>
                                      </li>
                                  @endcan

                                  @can('Candidate-free_candidate')
                                      <li class="menu-item sub-menu" id="Candidates">
                                          <a href="{{ route('admin.free-candidate-plan') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Free Candidate Plan">Free Candidate Plan
                                              </div>
                                          </a>
                                      </li>
                                  @endcan
                              </ul>
                          </li>
                      @endcanany
                
                      @if ($user->role == 'Admin')
                          <li class="menu-item" title="Staff Activity History">
                              <a href="{{ route('admin.staff-activity-history') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bx-history"></i>
                                  <div class="text-truncate" data-i18n="Staff Activity History">Staff Activity History
                                  </div>
                              </a>
                          </li>
                      @endif

                      @canany(['Candidate-candidate_expire_plan', 'Company-company_expire_plan'])
                          <li class="menu-item has-sub" id="ExpiredPlan">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-calendar-x"></i>
                                  <div class="text-truncate" data-i18n="Expired Plans">Expired Plans</div>
                              </a>

                              <ul class="menu-sub">
                                  @can('Company-company_expire_plan')
                                      <li class="menu-item sub-menu" id="Company">
                                          <a href="{{ route('admin.expire-company-plan') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Expired Company Plan">Expired Company Plan
                                              </div>
                                          </a>
                                      </li>
                                  @endcan

                                  @can('Candidate-candidate_expire_plan')
                                      <li class="menu-item sub-menu" id="Candidate">
                                          <a href="{{ route('admin.expire-candidates-plan') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Expired Candidate Plan">Expired Candidate
                                                  Plan</div>
                                          </a>
                                      </li>
                                  @endcan
                              </ul>
                          </li>
                      @endcanany

                      <li class="menu-item has-sub" id="RegistrationList">
                              <a href="javascript:void(0);" class="menu-link menu-toggle">
                                  <i class="menu-icon tf-icons bx bx-user"></i>
                                  <div class="text-truncate" data-i18n="Registration List">Registration List</div>
                              </a>

                              <ul class="menu-sub">
                                  <!-- @can('Company-free_company') -->
                                      <!-- <li class="menu-item sub-menu" id="skillthon">
                                          <a href="{{ route('admin.skillthon.list') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Skillthon List">Skillthon List</div>
                                          </a>
                                      </li> -->
                                      <li class="menu-item sub-menu" id="skillthon">
                                            <a href="{{ route('admin.skillthon') }}" class="menu-link">
                                                <div class="text-truncate" data-i18n="Skillthon List">Skillthon List</div>
                                            </a>
                                     </li>

                                  <!-- @endcan -->

                                  <!-- @can('Candidate-free_candidate') -->
                                      <li class="menu-item sub-menu" id="Internship">
                                          <a href="{{ route('admin.internship') }}" class="menu-link">
                                              <div class="text-truncate" data-i18n="Internship List">Internship List
                                              </div>
                                          </a>
                                      </li>
                                  <!-- @endcan -->
                              </ul>
                          </li>

                      @canany(['About-Update', 'Blog-Add', 'Blog-Edit', 'Blog-Delete', 'Testimonial-Add',
                          'Testimonial-Edit', 'Testimonial-Delete', 'AdBanner-Add', 'AdBanner-Edit', 'AdBanner-Delete',
                          'PlanPricing-Add', 'PlanPricing-Edit', 'PlanPricing-Delete', 'Achievement-Update'])
                          <li class="menu-header small text-uppercase">
                              <span class="menu-header-text" data-i18n="Manage Website">Manage Website</span>
                          </li>
                      @endcanany

                      @can('About-Update')
                          <li class="menu-item" title="About" id="About">
                              <a href="{{ route('admin.about.index') }}" class="menu-link ">
                                  <i class="menu-icon tf-icons bx bx-info-circle"></i>
                                  <div class="text-truncate" data-i18n="About">About</div>
                              </a>
                          </li>
                      @endcan

                      @canany(['Blog-Add', 'Blog-Edit', 'Blog-Delete'])
                          <li class="menu-item" title="Blog" id="Blog">
                              <a href="{{ route('admin.blog.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-notepad"></i>
                                  <div class="text-truncate" data-i18n="Blog">Blog</div>
                              </a>
                          </li>
                      @endcanany
                      @canany(['Testimonial-Add', 'Testimonial-Edit', 'Testimonial-Delete'])
                          <li class="menu-item" title="Testimonials" id="Testimonials">
                              <a href="{{ route('admin.testimonial.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-comment-detail"></i>
                                  <div class="text-truncate" data-i18n="Testimonials">Testimonials</div>
                              </a>
                          </li>
                      @endcanany
                      @canany(['AdBanner-Add', 'AdBanner-Edit', 'AdBanner-Delete'])
                          <li class="menu-item" title="Ad Banner" id="AdvertisementBanner">
                              <a href="{{ route('admin.ad-banner.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-tv"></i>
                                  <div class="text-truncate" data-i18n="Ad Banner">Ad Banner</div>
                              </a>
                          </li>
                      @endcanany
                      @canany(['PlanPricing-Add', 'PlanPricing-Edit', 'PlanPricing-Delete'])
                          <li class="menu-item" title="Plan & Pricing" id="PlanPricing">
                              <a href="{{ route('admin.pricing.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-money"></i>
                                  <div class="text-truncate" data-i18n="Plan & Pricing">Plan & Pricing</div>
                              </a>
                          </li>
                      @endcanany
                      @can('Achievement-Update')
                          <li class="menu-item" title="Achievements" id="Achievements">
                              <a href="{{ route('admin.achievements.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-trophy"></i>
                                  <div class="text-truncate" data-i18n="Achievements">Achievements</div>
                              </a>
                          </li>
                      @endcan
                  </ul>
              </aside>
              <!-- / Menu -->

              <!-- Layout container -->
              <div class="layout-page">
                  <!-- Navbar -->
                  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                      id="layout-navbar">
                      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                          <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                              <i class="bx bx-menu bx-md"></i>
                          </a>
                      </div>

                      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                          <!-- Search -->
                          <div class="navbar-nav align-items-center">
                              <div class="nav-item navbar-search-wrapper mb-0">
                                  <a href="#" style="font-size: 20px;font-weight: 600;color: #f26824;"><i
                                          class="bx bx-home-smile"></i> Dashboard</a>
                              </div>
                          </div>


                          <ul class="navbar-nav flex-row align-items-center ms-auto">
                              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                      data-bs-toggle="dropdown">
                                      <div class="avatar avatar-online">
                                          <img src="{{ asset('admin-assets/img/user.png') }}" alt
                                              class="w-px-40 h-auto rounded-circle" />
                                      </div>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                      <li>
                                          <a class="dropdown-item" href="#">
                                              <div class="d-flex">
                                                  <div class="flex-shrink-0 me-3">
                                                      <div class="avatar avatar-online">
                                                          <img src="{{ asset('admin-assets/img/user.png') }}" alt
                                                              class="w-px-40 h-auto rounded-circle" />
                                                      </div>
                                                  </div>
                                                  <div class="flex-grow-1">
                                                      <h6 class="mb-0">{{ $user ? $user->name : 'Zobpot' }}</h6>
                                                      <small
                                                          class="text-muted">{{ $user ? $user->role : 'Admin' }}</small>
                                                  </div>
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <div class="dropdown-divider my-1"></div>
                                      </li>
                                      {{-- <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                                        </a>
                                    </li> --}}
                                      @can('Setting-Update')
                                          <li>
                                              <a class="dropdown-item" href="{{ route('admin.setting.index') }}">
                                                  <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                                              </a>
                                          </li>
                                      @endcan

                                      <li>
                                          <a class="dropdown-item" href="{{ route('logout') }}"
                                              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                              <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                                          </a>
                                      </li>

                                      <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                          @csrf
                                      </form>
                                  </ul>
                              </li>
                          </ul>
                      </div>


                  </nav>

                  <!-- / Navbar -->

                  <!-- Content wrapper -->
                  <div class="content-wrapper">
                      <!-- Content -->

                      @yield('content')
                      <!-- / Content -->

                      <!-- Footer -->
                      <footer class="content-footer footer bg-footer-theme">
                          <div class="container-xxl">
                              <div
                                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                  <div class="text-body">
                                      <script>
                                          document.write(new Date().getFullYear());
                                      </script> Zobpot All Rights Reserved. Designed and developed by
                                      <a href="https://ivinfotech.com/" target="_blank">IV Infotech.</a>
                                  </div>
                              </div>
                          </div>
                      </footer>
                      <!-- / Footer -->

                      <div class="content-backdrop fade"></div>
                  </div>
                  <!-- Content wrapper -->
              </div>
              <!-- / Layout page -->
          </div>

          <div class="layout-overlay layout-menu-toggle"></div>

          <div class="drag-target"></div>
      </div>
      <!-- / Layout wrapper -->

      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      {{-- <script src="{{ asset('admin-assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
      <script src="{{ asset('admin-assets/vendor/libs/popper/popper.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/js/bootstrap.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/hammer/hammer.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/i18n/i18n.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/js/menu.js') }}"></script>

      <!-- endbuild -->
      <script src="{{ asset('admin-assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
      <script src="{{ asset('admin-assets/js/extended-ui-sweetalert2.js') }}"></script>


      <script src="{{ asset('admin-assets/vendor/libs/select2/select2.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/tagify/tagify.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>


      <!-- Vendors JS -->
      <script src="{{ asset('admin-assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

      <script src="{{ asset('admin-assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

      <script src="{{ asset('admin-assets/vendor/libs/@form-validation/popular.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

      <!-- Page JS -->
      {{-- <script src="{{ asset('admin-assets/js/dashboards-analytics.js') }}"></script> --}}

      <script src="{{ asset('admin-assets/js/app-access-permission.js') }}"></script>
      <script src="{{ asset('admin-assets/js/modal-add-permission.js') }}"></script>
      <script src="{{ asset('admin-assets/js/modal-edit-permission.js') }}"></script>

      <!-- Main JS -->
      <script src="{{ asset('admin-assets/js/main.js') }}"></script>


      <script src="{{ asset('admin-assets/js/toastr.js') }}"></script>

      <script src="{{ asset('admin-assets/js/forms-selects.js') }}"></script>
      {{-- <script src="{{ asset('admin-assets/js/forms-tagify.js') }}"></script> --}}
      <script src="{{ asset('admin-assets/js/forms-typeahead.js') }}"></script>



      <!-- jQuery and DataTables JS -->

      <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
      <!-- ckeditor -->
      <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>


      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.js"></script>

      @stack('script')

      <script>
          let editorInstanceProject;

          ClassicEditor.create(document.querySelector('#full-editor'))
              .then(editor => {
                  editorInstanceProject = editor; // Store the editor instance
                  editor.ui.view.editable.element.style.height = '550px!important';
              })
              .catch(error => {
                  console.error(error);
              });
      </script>
      <script>
          //set active menu
          function setActive() {
              if (!page_active_id || typeof page_active_id !== 'string') return;

              let parts = page_active_id.split("-");

              // Validate parts[0] exists and is not empty
              if (!parts[0]) return;

              // Clear previous active/open classes
              $(".menu-inner .menu-item").removeClass("active open");
              $(".menu-inner .menu-item#" + parts[0]).addClass("active open");

              // Optional: Check if parts[1] exists before applying submenu highlight
              if (parts.length > 1 && parts[1]) {
                  $(".menu-inner .menu-sub .sub-menu").removeClass("active open");
                  $(".menu-inner .menu-sub .sub-menu#" + parts[1]).addClass("active open");
              }
          }


          setActive();
      </script>
      <script>
          const suggestions = ['Frontend Developer', 'Backend Developer', 'UI/UX Designer', 'Laravel Developer',
              'Project Manager'
          ];

          function handleSearch() {
              const input = document.getElementById('nameBackdrop');
              const dropdown = document.getElementById('searchDropdown');
              const clearIcon = document.getElementById('clearIcon');
              const query = input.value.trim().toLowerCase();

              clearIcon.style.display = query ? 'block' : 'none';
              dropdown.innerHTML = '';

              if (query === '') {
                  dropdown.style.display = 'none';
                  return;
              }

              const filtered = suggestions.filter(item => item.toLowerCase().includes(query));

              if (filtered.length === 0) {
                  dropdown.innerHTML = `<li class="dropdown-item disabled">No results found</li>`;
              } else {
                  filtered.forEach(item => {
                      dropdown.innerHTML += `<li class="dropdown-item">${item}</li>`;
                  });
              }

              dropdown.style.display = 'block';
          }

          function clearSearch() {
              const input = document.getElementById('nameBackdrop');
              const dropdown = document.getElementById('searchDropdown');
              const clearIcon = document.getElementById('clearIcon');

              input.value = '';
              clearIcon.style.display = 'none';
              dropdown.style.display = 'none';
          }

          // Optional: Hide dropdown when clicking outside
        //   document.addEventListener('click', function(event) {
        //       const isClickInside = document.querySelector('.position-relative').contains(event.target);
        //       if (!isClickInside) {
        //           document.getElementById('searchDropdown').style.display = 'none';
        //       }
        //   });
        document.addEventListener('click', function (event) {

    const container = document.querySelector('.position-relative');
    const dropdown = document.getElementById('searchDropdown');

    if (!container || !dropdown) return; // ✅ safety guard

    const isClickInside = container.contains(event.target);

    if (!isClickInside) {
        dropdown.style.display = 'none';
    }
});



          function toggleClearIcon() {
              const input = document.getElementById('nameBackdrop');
              const icon = document.getElementById('clearIcon');
              icon.style.display = input.value ? 'block' : 'none';
          }

          function ActiveDeactiveAccount(sts, user_id) {
              var msg = "";
              if (sts == 1) {
                  msg = "Are you sure you want to Active the Account?";
              } else {
                  msg = "Are you sure you want to Deactive the Account?";
              }
              Swal.fire({
                  title: 'Are you sure?',
                  text: msg,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, confirm!',
                  customClass: {
                      confirmButton: 'btn btn-primary me-3',
                      cancelButton: 'btn btn-label-secondary'
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      var data = {
                          'sts': sts,
                          'user_id': user_id
                      }

                      let url = "{{ route('admin.active-deactive-account-active') }}";

                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });

                      $.ajax({
                          type: "POST",
                          url: url,
                          data: data,
                          success: function(response) {
                              if (response.status === 1) {
                                  toastr.success(response.message, 'Success');

                                  setTimeout(function() {
                                      location.reload();
                                  }, 1000)
                              } else {
                                  toastr.error(response.message, 'Error');
                              }
                          },
                          error: function(xhr) {
                              console.log(xhr.responseText);

                              let errorMsg = "Something went wrong";
                              try {
                                  const res = JSON.parse(xhr.responseText);
                                  errorMsg = res.message || errorMsg;
                              } catch (e) {}
                          }
                      });
                      return false;
                  }
              });

          }


          function ApproveDisapproveProfile(sts, type, user_id) {
              var msg = "";
              if (sts == 1) {
                  msg = "Are you sure you want to Approve the Account?";
              } else {
                  msg = "Are you sure you want to Disapprove the Account?";
              }
              Swal.fire({
                  title: 'Are you sure?',
                  text: msg,
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Yes, confirm!',
                  customClass: {
                      confirmButton: 'btn btn-primary me-3',
                      cancelButton: 'btn btn-label-secondary'
                  }
              }).then((result) => {
                  if (result.isConfirmed) {
                      var data = {
                          'sts': sts,
                          'type':type,
                          'user_id': user_id
                      }

                      let url = "{{ route('admin.approve-disapprove-profile-active') }}";

                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });

                      $.ajax({
                          type: "POST",
                          url: url,
                          data: data,
                          success: function(response) {
                              if (response.status === 1) {
                                  toastr.success(response.message, 'Success');

                                  setTimeout(function() {
                                      location.reload();
                                  }, 1000)
                              } else {
                                  toastr.error(response.message, 'Error');
                              }
                          },
                          error: function(xhr) {
                              console.log(xhr.responseText);

                              let errorMsg = "Something went wrong";
                              try {
                                  const res = JSON.parse(xhr.responseText);
                                  errorMsg = res.message || errorMsg;
                              } catch (e) {}
                          }
                      });
                      return false;
                  }
              });
          }


          function LoaderShow() {
              document.getElementById("Loader").style.display = "block";
          }

          function LoaderHide() {
              document.getElementById("Loader").style.display = "none";
          }
      </script>

  </body>

  </html>
