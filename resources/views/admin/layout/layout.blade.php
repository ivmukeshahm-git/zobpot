  @php
      $Setting = App\Models\Setting::where('id', 1)->first();
      $isCollegePortal = auth()->guard('college')->check() || auth()->guard('college_staff')->check();
  @endphp

  <!doctype html>

  <html lang="en" class="light-style {{ $isCollegePortal ? 'college-saas-html' : 'layout-navbar-fixed layout-menu-fixed' }} layout-compact" dir="ltr"
      data-theme="theme-default" data-assets-path="{{ asset('admin-assets') }}/" data-template="{{ $isCollegePortal ? 'horizontal-menu-template' : 'vertical-menu-template' }}"
      data-style="light">

  <head>
      <meta charset="utf-8" />
      <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>Zobpot - {{ $isCollegePortal ? 'College Admin' : 'Admin' }}</title>

      <!-- Favicon -->
      <link rel="icon" type="image/x-icon"
          href="{{ $Setting ?? $Setting->favicon ? asset('uploads/logo_img/' . $Setting->favicon) : asset('assets/imgs/logo/favicon1.png') }}" />

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
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
      @if($isCollegePortal)
      <link rel="stylesheet" href="{{ asset('admin-assets/css/college-saas.css') }}" />
      @endif
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
  
  <style>
    /* Tab Navigation Styles */
    .opportunity-tabs {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .nav-pills-custom {
        display: flex;
        gap: 12px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0;
    }

    .nav-pills-custom .nav-link {
        background: transparent;
        color: #666;
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-pills-custom .nav-link:hover {
        color: #f26e2c;
        background: #fff5f0;
    }

    .nav-pills-custom .nav-link.active {
        color: #242a62;
        background: transparent;
        border-bottom-color: #f26e2c;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }

    .status-badge.new {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.processing {
        background: #cfe2ff;
        color: #084298;
    }

    .status-badge.complete {
        background: #d1e7dd;
        color: #0f5132;
    }

    /* Action Buttons */
    .btn-action {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-accept {
        background: #28a745;
        color: white;
        border: none;
    }

    .btn-accept:hover {
        background: #218838;
        color: white;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        border: none;
    }

    .btn-reject:hover {
        background: #c82333;
        color: white;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
        border: none;
    }

    .btn-view:hover {
        background: #138496;
        color: white;
    }

    /* Modal Styles */
    .modal-header-custom {
        background: #242a62;
        color: white;
        border-radius: 0;
        padding: 20px 30px;
    }

    .modal-header-custom h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-custom .btn-close {
        background: #fff;
        border: none;
        font-size: 24px;
        color: white;
        opacity: 1;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-header-custom .btn-close:hover {
        opacity: 0.8;
        background: #fff;
        border-radius: 4px;
    }

    .detail-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .detail-section h6 {
        color: #242a62;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #242a62;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
    }

    .detail-value {
        color: #212529;
        font-size: 13px;
    }

    .form-section {
        background: white;
        border: 2px solid #e7e7ff;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }

    .form-section h6 {
        color: #696cff;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .form-label-required::after {
        content: " *";
        color: #dc3545;
    }

    /* Table Styles */
    .table-hover tbody tr:hover {
        background-color: #f5f5ff;
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #d9d9e3;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        border: 1px solid #d9d9e3;
        padding: 6px 12px;
    }
</style>  


  @stack('css')
  <script>
      var page_active_id = "Home";
  </script>

  <body class="{{ $isCollegePortal ? 'college-saas-mode' : '' }}">
      @php
          $user = auth()->user() ?? auth()->guard('college')->user() ?? auth()->guard('college_staff')->user();

          // College login: show college_name from tbl_college
          if (auth()->guard('college')->check()) {
              $userName = auth()->guard('college')->user()->college_name ?? 'College';
              $userRole = 'College';
          } elseif (auth()->guard('college_staff')->check()) {
              $staffUser = auth()->guard('college_staff')->user();
              $userName = $staffUser->name ?? 'Staff';
              $userRole = optional($staffUser->role)->name ?? 'College Staff';
          } else {
              // Admin login: show name from users table
              $userName = optional(auth()->user())->name ?? 'Zobpot';
              $rawRole  = optional(auth()->user())->role;
              $userRole = is_string($rawRole) ? $rawRole : (optional(optional(auth()->user())->roles->first())->name ?? 'Admin');
          }
          // Assign Opportunity menu: super admin only (admin panel login with Admin role or Assign-Internship permission)
          $canAssign = false;
          try {
              if (auth()->check() && auth()->user() && method_exists(auth()->user(), 'can')) {
                  $authUser = auth()->user();
                  $isAdminRole = ($authUser->role === 'Admin') || (optional($authUser->roles->first())->name === 'Admin');
                  if ($isAdminRole || $authUser->can('Assign-Internship')) {
                      $canAssign = true;
                  }
              }
          } catch (\Throwable $ex) {
              $canAssign = false;
          }
      @endphp
      <div class="preloader" id="Loader">
          <span class="loader"></span>
      </div>


      <!-- Layout wrapper -->
      @if($isCollegePortal)
          @include('admin.layout.partials.college-topnav')
      @endif
      <div class="layout-wrapper layout-content-navbar">
          <div class="layout-container">
              <!-- Menu -->
              <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme {{ $isCollegePortal ? 'd-none' : '' }}">
                  <div class="app-brand demo">
                      <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                          <!-- <img src="{{ $Setting ?? $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}"
                              alt="Logo" style="max-width: 100%;"> -->
                              <img src="{{ $Setting ?? $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}"
                              alt="Logo" style="max-width: 40%;">
                      </a>

                      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                          <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
                      </a>
                  </div>

                  <div class="menu-inner-shadow"></div>

                  <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                      @if(auth()->guard('college')->check() || auth()->guard('college_staff')->check())
                          <li class="menu-item" title="College Dashboard" id="College-Dashboard">
                              <a href="{{ route('admin.college.dashboard') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-home-smile"></i>
                                  <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                              </a>
                          </li>
                          @if(auth()->guard('college')->check())
                          <li class="menu-item" title="Manage Staff" id="CollegeStaff">
                              <a href="{{ route('admin.college.staff.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-group"></i>
                                  <div class="text-truncate" data-i18n="Manage Staff">Manage Staff</div>
                              </a>
                          </li>
                          <li class="menu-item" title="Manage Roles" id="CollegeRoles">
                              <a href="{{ route('admin.college.roles.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                                  <div class="text-truncate" data-i18n="Manage Roles">Manage Roles</div>
                              </a>
                          </li>
                          @endif
                          
                          <li class="menu-item" title="Registration List" id="CollegeRegistration">
                              <a href="{{ route('admin.college.registration-list') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-list-ul"></i>
                                  <div class="text-truncate" data-i18n="Registration List">Registration List</div>
                              </a>
                          </li>
                          <li class="menu-item" title="College Marks" id="CollegeMarks">
                              <a href="{{ route('admin.internship.college-marks') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-edit"></i>
                                  <div class="text-truncate" data-i18n="College Marks">College Marks</div>
                              </a>
                          </li>
                          <li class="menu-item" title="Marks History" id="CollegeMarksHistory">
                              <a href="{{ route('admin.internship.college-marks-history') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-history"></i>
                                  <div class="text-truncate" data-i18n="Marks History">Marks History</div>
                              </a>
                          </li>
                          @if(auth()->guard('college')->check() || (auth()->guard('college_staff')->check() && auth()->guard('college_staff')->user()->can('ManageGrade-View')))
                          <li class="menu-item" title="Manage Grade" id="ManageGrade">
                              <a href="{{ route('admin.manage-grade.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-medal"></i>
                                  <div class="text-truncate" data-i18n="Manage Grade">Manage Grade</div>
                              </a>
                          </li>
                          @endif
                          @if(auth()->guard('college')->check())
                          <li class="menu-item" title="Settings" id="CollegeSettings">
                              <a href="{{ route('admin.college.settings') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-cog"></i>
                                  <div class="text-truncate" data-i18n="Settings">Settings</div>
                              </a>
                          </li>
                          @endif
                      @else
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
                      @endif

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
                              </ul>
                          </li>
                      @endcanany
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
                      
                       @canany(['Internship-Add', 'Internship-Edit', 'Internship-Delete', 'Internship-Approve', 'Internship-Reject', 'Internship-View'])
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
                              {{-- moved College Marks, College Marks History and Opportunity Reviews to top-level menu --}}
                          </ul>
                      </li>
                      @endcanany
                      
                      
                       @canany(['Internship-Add', 'Internship-Edit', 'Internship-Delete', 'Internship-Approve', 'Internship-Reject', 'Internship-View'])
                          <li class="menu-item" title="Update College Marks" id="CollegeMarks">
                              <a href="{{ route('admin.internship.college-marks') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-edit"></i>
                                  <div class="text-truncate" data-i18n="College Marks">Update College Marks</div>
                              </a>
                          </li>
                          <li class="menu-item" title="College Marks History" id="CollegeMarksHistory">
                              <a href="{{ route('admin.internship.college-marks-history') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-history"></i>
                                  <div class="text-truncate" data-i18n="Marks History">Marks History</div>
                              </a>
                          </li>
                          <li class="menu-item" title="Internship Reviews" id="InternshipReviews">
                              <a href="{{ route('admin.internship.reviews') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-comment-dots"></i>
                                  <div class="text-truncate" data-i18n="Internship Reviews">Internship Reviews</div>
                              </a>
                          </li>
                      @endcanany

                      @if(auth()->guard('college')->check() || auth()->guard('college_staff')->check() || (auth()->check() && auth()->user()->college_id))
                      <li class="menu-item" title="My Internships" id="CollegeInternship">
                          <a href="{{ route('admin.college.dashboard') }}#college-internship-section" class="menu-link">
                              <i class="menu-icon tf-icons bx bx-briefcase"></i>
                              <div class="text-truncate" data-i18n="My Internships">My Internships</div>
                          </a>
                      </li>
                      @endif
                      @if($canAssign)
                      <!--<li class="menu-item" title="Assign Opportunity" id="AssignInternship">-->
                      <!--    <a href="{{ route('admin.staff.assign-internship-super') }}" class="menu-link">-->
                      <!--        <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>-->
                      <!--        <div class="text-truncate" data-i18n="Assign Internship">Assign Opportunity</div>-->
                      <!--    </a>-->
                      <!--</li>-->
                      @endif
                      @canany(['Degree_Level-Add', 'Degree_Level-Edit', 'Degree_Level-Delete', 'Degree_Level-Approve', 'Degree_Level-Reject', 'Degrees-Add', 'Degrees-Edit', 'Degrees-Delete', 'Degrees-Approve', 'Degrees-Reject', 'Major-Add', 'Major-Edit', 'Major-Delete', 'Major-Approve', 'Major-Reject'])
                      <li class="menu-item has-sub" title="Degrees" id="Degrees">
                          <a href="javascript:void(0);" class="menu-link menu-toggle">
                              <i class="menu-icon tf-icons bx bx-book"></i>
                              <div class="text-truncate" data-i18n="Degrees">Degrees</div>
                          </a>
                          <ul class="menu-sub">
                              @canany(['Degree_Level-Add', 'Degree_Level-Edit', 'Degree_Level-Delete', 'Degree_Level-Approve', 'Degree_Level-Reject'])
                              <li class="menu-item sub-menu" id="DegreeLevel">
                                  <a href="{{ route('admin.degree-level.index') }}" class="menu-link">
                                      <div class="text-truncate" data-i18n="Degree Level">Degree Level</div>
                                  </a>
                              </li>
                              @endcanany
                              @canany(['Degrees-Add', 'Degrees-Edit', 'Degrees-Delete', 'Degrees-Approve', 'Degrees-Reject'])
                              <li class="menu-item sub-menu" id="Degree">
                                  <a href="{{ route('admin.degree.index') }}" class="menu-link">
                                      <div class="text-truncate" data-i18n="Degree">Degree</div>
                                  </a>
                              </li>
                              @endcanany
                              @canany(['Major-Add', 'Major-Edit', 'Major-Delete', 'Major-Approve', 'Major-Reject'])
                              <li class="menu-item sub-menu" id="Major">
                                  <a href="{{ route('admin.major.index') }}" class="menu-link">
                                      <div class="text-truncate" data-i18n="Major">Major</div>
                                  </a>
                              </li>
                              @endcanany
                          </ul>
                      </li>
                      @endcanany

                      @canany(['University-Add', 'University-Edit', 'University-Delete', 'University-Approve', 'University-Reject'])
                      <li class="menu-item" title="University" id="University">
                          <a href="{{ route('admin.university.index') }}" class="menu-link">
                              <i class="menu-icon tf-icons bx bxs-building"></i>
                              <div class="text-truncate" data-i18n="University">University</div>
                          </a>
                      </li>
                      @endcanany

                      @canany(['College-Add', 'College-Edit', 'College-Delete', 'College-Approve', 'College-Reject', 'College-View'])
                      <li class="menu-item" title="College" id="College">
                          <a href="{{ route('admin.college.index') }}" class="menu-link">
                              <i class="menu-icon tf-icons bx bxs-school"></i>
                              <div class="text-truncate" data-i18n="College">College</div>
                          </a>
                      </li>
                      @endcanany

                      @can('Manage_Grade-Add')
                      <li class="menu-item" title="Manage Grade" id="ManageGrade">
                          <a href="{{ route('admin.manage-grade.index') }}" class="menu-link">
                              <i class="menu-icon tf-icons bx bx-medal"></i>
                              <div class="text-truncate" data-i18n="Manage Grade">Manage Grade</div>
                          </a>
                      </li>
                      @endcan
                      
                      

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
@if ($user->role == 'Admin')
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
                                              <div class="text-truncate" data-i18n="Internship List">Internship Directory
                                              </div>
                                          </a>
                                      </li>
                                  <!-- @endcan -->
                              </ul>
                          </li>
                          @endif

                      @canany(['About-Update', 'Blog-Add', 'Blog-Edit', 'Blog-Delete', 'InterviewTips-Add',
                          'InterviewTips-Edit', 'InterviewTips-Delete', 'Testimonial-Add',
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
                      @canany(['InterviewTips-Add', 'InterviewTips-Edit', 'InterviewTips-Delete'])
                          <li class="menu-item" title="Interview Tips" id="InterviewTips">
                              <a href="{{ route('admin.interview-tips.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-bulb"></i>
                                  <div class="text-truncate" data-i18n="Interview Tips">Interview Tips</div>
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
                       @if ($user->role == 'Admin')
                          <li class="menu-item" title="Partners" id="Partners">
                              <a href="{{ route('admin.partners.index') }}" class="menu-link">
                                  <i class="menu-icon tf-icons bx bx-group"></i>
                                  <div class="text-truncate" data-i18n="Partners">Partners</div>
                              </a>
                          </li>
                      @endif
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
                  @if(!$isCollegePortal)
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
                                                      <h6 class="mb-0">{{ $userName }}</h6>
                                                      <small class="text-muted">{{ $userRole }}</small>
                                                  </div>
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <div class="dropdown-divider my-1"></div>
                                      </li>
                                      @can('Setting-Update')
                                          <li>
                                              <a class="dropdown-item" href="{{ route('admin.setting.index') }}">
                                                  <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                                              </a>
                                          </li>
                                      @endcan
                                      @if(auth()->guard('college')->check())
                                          <li>
                                              <a class="dropdown-item" href="{{ route('admin.college.settings') }}">
                                                  <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                                              </a>
                                          </li>
                                      @endif

                                      <li>
                                          <a class="dropdown-item" href="{{ route('admin.login') }}"
                                              onclick="event.preventDefault(); var f=document.getElementById('logout-form'); if(f){ f.submit(); } else { window.location.href=this.href; }">
                                              <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                                          </a>
                                      </li>

                                      <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                          @csrf
                                          <input type="hidden" name="admin" value="1">
                                      </form>
                                  </ul>
                              </li>
                          </ul>
                      </div>


                  </nav>
                  @else
                  {{-- College portal uses horizontal topnav; keep logout form for profile dropdown --}}
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                      <input type="hidden" name="admin" value="1">
                  </form>
                  <div id="layout-navbar" class="d-none"></div>
                  <div id="navbar-collapse" class="d-none"></div>
                  @endif

                  <!-- / Navbar -->

                  <!-- Content wrapper -->
                  <div class="content-wrapper">
                      <!-- Content -->

                      @yield('content')
                      <!-- / Content -->

                      <!-- Footer -->
                      <footer class="content-footer footer bg-footer-theme {{ $isCollegePortal ? 'college-saas-footer' : '' }}">
                          <div class="container-xxl">
                              @if($isCollegePortal)
                              <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column gap-2">
                                  <div class="text-body">© 2026 Zobpot</div>
                                  <div class="college-footer-links">
                                      <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a>
                                      <a href="{{ route('term-and-conditions') }}" target="_blank">Terms</a>
                                      <a href="{{ route('contact') }}" target="_blank">Support</a>
                                  </div>
                              </div>
                              @else
                              <div
                                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                  <div class="text-body">
                                      <script>
                                          document.write(new Date().getFullYear());
                                      </script> Zobpot All Rights Reserved. Designed and developed by
                                      <a href="https://ivinfotech.com/" target="_blank">IV Infotech.</a>
                                  </div>
                              </div>
                              @endif
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

          // Open Accept Modal
    function openAcceptModal(internshipId) {
        // Fetch opportunity details
        $.ajax({
            url: '{{ url("admin/internship/details") }}/' + internshipId,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    // Populate modal with opportunity details
                    $('#internshipTitle').text(data.internship_title || '-');
                    $('#category').text(data.category_name || '-');
                    $('#subcategory').text(data.subcategory_names || 'N/A');
                    $('#companyName').text(data.company_name || '-');
                    $('#companyWebsite').text(data.company_website || '-');
                    $('#workMode').text(data.mode || '-');
                    $('#location').text(data.location || '-');
                    $('#duration').text(data.duration || '-');
                    $('#totalWeeks').text((data.total_weeks || 0) + ' Weeks');
                    $('#totalHours').text((data.total_hours || 0) + ' Hours');
                    $('#startDate').text(data.formatted_start_date || '-');
                    $('#endDate').text(data.formatted_end_date || '-');
                    $('#stipend').text(data.stipend ? '₹' + data.stipend : 'Not specified');
                    $('#openings').text((data.openings || 0) + ' Positions');
                    $('#applicationDeadline').text(data.formatted_deadline || '-');
                    
                    // Populate date inputs in configuration form
                    if (data.start_date) {
                        $('#modalStartDate').val(data.start_date);
                    }
                    if (data.end_date) {
                        $('#modalEndDate').val(data.end_date);
                    }

                    // Store application deadline for last-registration date bounds
                    $('#acceptInternshipModal').data('application-deadline', data.application_deadline || '');
                    
                    // Batch Days
                    if (data.batch_days && Object.keys(data.batch_days).length > 0) {
                        const days = Object.keys(data.batch_days).join(', ');
                        $('#batchDays').text(days);
                        
                        let timeSlotsHtml = '';
                        Object.keys(data.batch_days).forEach(day => {
                            const dayData = data.batch_days[day];
                            timeSlotsHtml += `${day}: ${dayData.start_time || '-'} - ${dayData.end_time || '-'}<br>`;
                        });
                        $('#timeSlots').html(timeSlotsHtml);
                    } else {
                        $('#batchDays').text('Not specified');
                        $('#timeSlots').text('Not specified');
                    }
                    
                    // Skills
                    if (data.skills) {
                        let skills = [];
                        try {
                            // Try to parse as JSON array first
                            skills = JSON.parse(data.skills);
                        } catch (e) {
                            // If not JSON, split by comma
                            skills = data.skills.split(',');
                        }
                        let skillsHtml = '';
                        skills.forEach(skill => {
                            skillsHtml += `<span class="badge bg-light text-dark me-1">${skill.trim()}</span>`;
                        });
                        $('#requiredSkills').html(skillsHtml);
                    } else {
                        $('#requiredSkills').text('Not specified');
                    }
                    
                    // Eligibility Criteria
                    if (data.eligibility_criteria) {
                        let criteria = [];
                        try {
                            // Try to parse as JSON array first
                            criteria = JSON.parse(data.eligibility_criteria);
                        } catch (e) {
                            // If not JSON, split by comma
                            criteria = data.eligibility_criteria.split(',');
                        }
                        let criteriaHtml = '';
                        criteria.forEach(c => {
                            criteriaHtml += `<span class="badge bg-light text-dark me-1">${c.trim()}</span>`;
                        });
                        $('#eligibilityCriteria').html(criteriaHtml);
                    } else {
                        $('#eligibilityCriteria').text('Not specified');
                    }
                    
                    // Descriptions
                    $('#internshipDescription').html(data.internship_description || '-');
                    $('#moduleDescription').html(data.module_brief_description || '-');
                    $('#internshipObjective').html(data.internship_objective || '-');
                    $('#internshipOutcome').html(data.internship_outcome || '-');
                    
                    // Store opportunity ID for accept action
                    $('#acceptInternshipModal').data('opportunity-id', internshipId);

                    // Category / Subcategory approval handling
                    const categoryApproved = data.category_approved;
                    const subcategoriesApproved = data.subcategories_approved;
                    const categoryRejected = data.category_request_status === 'rejected';
                    const subcategoryRejected = data.subcategory_request_status === 'rejected';
                    const categoryPending = data.category_request_status === 'pending';
                    const subcategoryPending = data.subcategory_request_status === 'pending';

                    const acceptBtn = $('#acceptApproveBtn');
                    const noteBox = $('#categoryApprovalNote');
                    const noteText = $('#categoryApprovalNoteText');
                    const reselectSection = $('#categoryReselectSection');

                    // Reset re-select controls (destroy Select2 first if initialized)
                    if ($('#reselectCategory').hasClass('select2-hidden-accessible')) {
                        $('#reselectCategory').select2('destroy');
                    }
                    if ($('#reselectSubcategory').hasClass('select2-hidden-accessible')) {
                        $('#reselectSubcategory').select2('destroy');
                    }
                    $('#reselectCategory').empty().append('<option value="">Select Category</option>');
                    $('#reselectSubcategory').empty();

                    let noteMsg = '';
                    let showReselect = false;

                    if (!categoryApproved || !subcategoriesApproved) {
                        // Disable Accept & Approve until category/subcategory is resolved
                        acceptBtn.prop('disabled', true).css({ 'opacity': '0.6', 'cursor': 'not-allowed' });

                        if (categoryRejected || subcategoryRejected) {
                            showReselect = true;
                            noteMsg = 'The requested Category/Subcategory was rejected. Select a different Category & Subcategory below to enable approval.';
                        } else if (categoryPending || subcategoryPending) {
                            noteMsg = 'Category/Subcategory request is still pending. Approve the Category & Subcategory request from Master first.';
                        } else {
                            noteMsg = 'This internship has no approved Category/Subcategory. Approve the Category & Subcategory request from Master first.';
                        }
                    } else {
                        acceptBtn.prop('disabled', false).css({ 'opacity': '1', 'cursor': 'pointer' });
                    }

                    noteText.text(noteMsg);
                    noteBox.toggle(noteMsg !== '');
                    reselectSection.toggle(showReselect);

                    if (showReselect) {
                        const $catSelect = $('#reselectCategory');
                        (data.categories || []).forEach(c => {
                            $catSelect.append(`<option value="${c.id}">${c.name}</option>`);
                        });
                        window.__internshipSubcategories = data.subcategories || [];

                        // Initialize Select2 on both dropdowns
                        $catSelect.select2({
                            placeholder: 'Select Category',
                            allowClear: true,
                            width: '100%',
                            dropdownParent: $('#acceptInternshipModal')
                        });
                        $('#reselectSubcategory').select2({
                            placeholder: 'Select Sub Category',
                            allowClear: true,
                            width: '100%',
                            dropdownParent: $('#acceptInternshipModal')
                        });

                        // Focus the category select once the modal is visible
                        $('#acceptInternshipModal').off('shown.bs.modal.reselect').one('shown.bs.modal.reselect', function() {
                            setTimeout(() => $catSelect.select2('open'), 400);
                        });
                    }

                    // Default: Associate with College + Enable Task Management
                    $('#internshipType').val('1');
                    $('#manageTaskStatus').prop('checked', true);
                    $('#registrationFees').val(data.registration_fees != null ? data.registration_fees : ($('#registrationFees').val() || '1000'));
                    $('#lastRegistrationDate').val(data.last_registration_date || '');
                    $('#lateRegistrationFee').val(data.late_registration_fee != null ? data.late_registration_fee : 0);
                    if (typeof window.updateAcceptModalDateConstraints === 'function') {
                        window.updateAcceptModalDateConstraints();
                    }
                    $('#registrationFees').trigger('input');
                    
                    // Show modal
                    $('#acceptInternshipModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to load Internship details'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to load Internship details'
                });
            }
        });
    }

    // Populate subcategories based on selected category (re-selection after rejection)
    $(document).on('change', '#reselectCategory', function() {
        const categoryId = $(this).val();
        const $subSelect = $('#reselectSubcategory');
        $subSelect.empty();
        const subs = (window.__internshipSubcategories || []).filter(s => String(s.category_id) === String(categoryId));
        subs.forEach(s => {
            $subSelect.append(`<option value="${s.id}">${s.name}</option>`);
        });
        $subSelect.trigger('change.select2');
        // Enable/disable Approve button based on selection
        updateAcceptButtonState();
    });
    $(document).on('change', '#reselectSubcategory', function() {
        updateAcceptButtonState();
    });

    function updateAcceptButtonState() {
        if (!$('#categoryReselectSection').is(':visible')) return;
        const catId = $('#reselectCategory').val();
        const subIds = $('#reselectSubcategory').val() || [];
        const $btn = $('#acceptApproveBtn');
        if (catId && subIds.length > 0) {
            $btn.prop('disabled', false).css({ 'opacity': '1', 'cursor': 'pointer' });
        } else {
            $btn.prop('disabled', true).css({ 'opacity': '0.6', 'cursor': 'not-allowed' });
        }
    }

    // Update Opportunity - Redirect to edit page
    function editInternship() {
        const internshipId = $('#acceptInternshipModal').data('opportunity-id');
        
        if (!internshipId) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Internship ID not found'
            });
            return;
        }
        
        // Store that we came from modal (for redirect back after update)
        sessionStorage.setItem('returnToModal', internshipId);
        
        // Redirect to edit page
        window.location.href = '{{ url("admin/internship/edit") }}/' + internshipId;
    }

    // Confirm Accept Opportunity
    function confirmAcceptInternship() {
        const internshipId = $('#acceptInternshipModal').data('opportunity-id');
        
        if (!internshipId) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Internship ID not found'
            });
            return;
        }
        
        // Validate form before proceeding
        if (!$('#internshipConfigForm').valid()) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please fill in all required fields correctly'
            });
            return;
        }
        
        // Get form values
        const startDate = $('#modalStartDate').val();
        const endDate = $('#modalEndDate').val();
        const registrationFees = $('#registrationFees').val();
        const internshipType = parseInt($('#internshipType').val(), 10);
        
        if (![1, 2].includes(internshipType)) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please select program type'
            });
            return;
        }
        
        // Additional validation: Check if end date is after start date
        if (new Date(endDate) <= new Date(startDate)) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Dates',
                text: 'End date must be after start date'
            });
            return;
        }
        
        // Validate re-selected Category/Subcategory when visible (after rejection)
        let reselectedCategoryId = null;
        let reselectedSubIds = [];
        if ($('#categoryReselectSection').is(':visible')) {
            reselectedCategoryId = $('#reselectCategory').val();
            reselectedSubIds = $('#reselectSubcategory').val() || [];
            
            if (!reselectedCategoryId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Category Required',
                    text: 'Please select a Category to proceed with approval'
                });
                return;
            }
            if (reselectedSubIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sub Category Required',
                    text: 'Please select at least one Sub Category to proceed with approval'
                });
                return;
            }
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this Internship with the configured fees?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Collect form data — save admin-edited fee configuration
                const baseFee = parseFloat(registrationFees) || 0;
                const lateFee = parseFloat($('#lateRegistrationFee').val()) || 0;
                const lastRegDate = $('#lastRegistrationDate').val() || '';
                const gstPct = 18;
                // Store opportunity base fee + GST (late fee applied dynamically at student apply time)
                const baseGst = (baseFee * gstPct) / 100;
                const formData = {
                    start_date: startDate,
                    end_date: endDate,
                    registration_fees: baseFee,
                    last_registration_date: lastRegDate,
                    late_registration_fee: lateFee,
                    gst_percentage: gstPct,
                    gst_amount: parseFloat(baseGst.toFixed(2)),
                    final_amount: parseFloat((baseFee + baseGst).toFixed(2)),
                    manage_task_status: $('#manageTaskStatus').is(':checked') ? 1 : 0,
                    internship_type: internshipType
                };
                
                // Attach re-selected category/subcategory if chosen
                if (reselectedCategoryId) {
                    formData.category_id = reselectedCategoryId;
                    formData.sub_category_ids = reselectedSubIds;
                }
                
                $.ajax({
                    url: '{{ url("admin/internship/accept") }}/' + internshipId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            
                            $('#acceptInternshipModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: response.message || 'Internship approved successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // Reload tables
                            if ($.fn.DataTable.isDataTable('#NewRequestsTable')) {
                                $('#NewRequestsTable').DataTable().ajax.reload();
                            }

                             // Reload tables
                            if ($.fn.DataTable.isDataTable('#NewInternshipRequestsTable')) {
                                $('#NewInternshipRequestsTable').DataTable().ajax.reload();
                            }
                            
                            if ($.fn.DataTable.isDataTable('#ApprovedTable')) {
                                $('#ApprovedTable').DataTable().ajax.reload();
                            }
                            updateCounts();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to approve Internship'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to approve Internship';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    }


           // Reject Opportunity
    function rejectInternship(internshipId) {
        Swal.fire({
            title: 'Reject Internship',
            html: `
                <p>Are you sure you want to reject this Internship?</p>
                <textarea id="rejectionReason" class="form-control mt-3" rows="3" placeholder="Enter rejection reason (optional)"></textarea>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, reject it!',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                return {
                    reason: document.getElementById('rejectionReason').value
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/internship/reject") }}/' + internshipId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        rejection_reason: result.value.reason
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rejected!',
                                text: response.message || 'Internship rejected successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // Reload tables
                            if ($.fn.DataTable.isDataTable('#NewRequestsTable')) {
                                $('#NewRequestsTable').DataTable().ajax.reload();
                            }
                            if ($.fn.DataTable.isDataTable('#RejectedTable')) {
                                $('#RejectedTable').DataTable().ajax.reload();
                            }
                            updateCounts();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to reject Internship'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to reject Internship';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    }
      </script>
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
              $(".college-nav-link").removeClass("active");

              // Prefer exact id match (College-Dashboard, CollegeStaff, etc.)
              if ($(".menu-item#" + page_active_id).length) {
                  $(".menu-item#" + page_active_id).addClass("active open");
              } else {
                  $(".menu-inner .menu-item#" + parts[0]).addClass("active open");
              }

              // Optional: Check if parts[1] exists before applying submenu highlight
              if (parts.length > 1 && parts[1] && !$(".menu-item#" + page_active_id).length) {
                  $(".menu-inner .menu-sub .sub-menu").removeClass("active open");
                  $(".menu-inner .menu-sub .sub-menu#" + parts[1]).addClass("active open");
              }

              // Mobile drawer active state
              $('.college-nav-link[data-menu-id="' + page_active_id + '"]').addClass('active');
          }


          setActive();

          // College mobile hamburger
          (function () {
              var toggle = document.getElementById('collegeNavToggle');
              var drawer = document.getElementById('collegeMobileDrawer');
              if (!toggle || !drawer) return;
              toggle.addEventListener('click', function () {
                  drawer.classList.toggle('open');
                  drawer.setAttribute('aria-hidden', drawer.classList.contains('open') ? 'false' : 'true');
              });
              drawer.addEventListener('click', function (e) {
                  if (e.target === drawer) {
                      drawer.classList.remove('open');
                      drawer.setAttribute('aria-hidden', 'true');
                  }
              });
          })();
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
      
       <!-- GST Calculation and Validation Script for Accept Modal -->
  <script>
      // Global validation variable
      var internshipConfigValidator;

      $(document).ready(function() {
          // Last Date of Registration: between Application Deadline and Start Date
          window.updateAcceptModalDateConstraints = function() {
              const $start = $('#modalStartDate');
              const $lastReg = $('#lastRegistrationDate');
              if (!$lastReg.length) return;

              const startDate = $start.val() || '';
              const appDeadline = $('#acceptInternshipModal').data('application-deadline') || '';

              if (appDeadline) {
                  $lastReg.attr('min', appDeadline);
              } else {
                  $lastReg.removeAttr('min');
              }
              if (startDate) {
                  $lastReg.attr('max', startDate);
              } else {
                  $lastReg.removeAttr('max');
              }

              const lastVal = $lastReg.val() || '';
              if (lastVal) {
                  if (appDeadline && lastVal < appDeadline) {
                      $lastReg.val('');
                  } else if (startDate && lastVal > startDate) {
                      $lastReg.val('');
                  }
              }
          };

          $(document).on('change input', '#modalStartDate', function() {
              window.updateAcceptModalDateConstraints();
          });

          // Calculate GST + total. Late fee is included in preview when today is past last registration date.
          function calculateGST() {
              const registrationFees = parseFloat($('#registrationFees').val()) || 0;
              const lateFeeConfigured = parseFloat($('#lateRegistrationFee').val()) || 0;
              const lastDate = $('#lastRegistrationDate').val();
              const gstPercentage = 18; // Fixed 18% GST

              let isLate = false;
              if (lastDate) {
                  const today = new Date();
                  today.setHours(0, 0, 0, 0);
                  const deadline = new Date(lastDate + 'T00:00:00');
                  isLate = !isNaN(deadline.getTime()) && today > deadline;
              }

              const appliedLateFee = isLate ? lateFeeConfigured : 0;
              const subtotal = registrationFees + appliedLateFee;
              const gstAmount = (subtotal * gstPercentage) / 100;
              const finalAmount = subtotal + gstAmount;

              $('#gstPercentage').val(gstPercentage);
              $('#gstAmount').val(gstAmount.toFixed(2));
              $('#finalAmount').val(finalAmount.toFixed(2));

              $('#summaryRegFees').text(registrationFees.toFixed(2));
              $('#summaryLateFee').text(appliedLateFee.toFixed(2));
              $('#summaryGstPct').text(gstPercentage);
              $('#summaryGst').text(gstAmount.toFixed(2));
              $('#summaryTotal').text(finalAmount.toFixed(2));

              // Always keep late fee input visible for admin editing
              $('#lateRegistrationFeeWrap').show();

              if (appliedLateFee > 0) {
                  $('#summaryLateWrap').show();
              } else {
                  $('#summaryLateWrap').hide();
              }
          }
          
          // Recalculate when any fee/date field changes
          $('#registrationFees, #lateRegistrationFee, #lastRegistrationDate').on('input change', function() {
              calculateGST();
          });
          
          // Initial calculation when page loads
          calculateGST();

          // Custom validation method: End date must be after start date
          $.validator.addMethod("greaterThan", function(value, element, param) {
              if (!value || !$(param).val()) return true;
              return new Date(value) > new Date($(param).val());
          }, "End date must be after start date");

          // Initialize validation when modal is shown
          $('#acceptInternshipModal').on('shown.bs.modal', function() {
              // Destroy existing validator if any
              if (opportunityConfigValidator) {
                  opportunityConfigValidator.destroy();
              }

              // Initialize jQuery Validation for Opportunity Config Form
              opportunityConfigValidator = $('#internshipConfigForm').validate({
                  rules: {
                      internship_type: {
                          required: true
                      },
                      start_date: {
                          required: true
                      },
                      end_date: {
                          required: true,
                          greaterThan: '#modalStartDate'
                      },
                      registration_fees: {
                          required: true,
                          number: true,
                          min: 0
                      },
                      late_registration_fee: {
                          number: true,
                          min: 0
                      },
                      last_registration_date: {
                          date: false
                      }
                  },
                  messages: {
                      internship_type: {
                          required: "Please select program type"
                      },
                      start_date: {
                          required: "Please select start date"
                      },
                      end_date: {
                          required: "Please select end date",
                          greaterThan: "End date must be after start date"
                      },
                      registration_fees: {
                          required: "Please enter registration fees",
                          number: "Please enter a valid number",
                          min: "Registration fees must be at least 0"
                      },
                      late_registration_fee: {
                          number: "Please enter a valid late fee",
                          min: "Late registration fee must be at least 0"
                      }
                  },
                  errorElement: 'div',
                  errorClass: 'invalid-feedback',
                  errorPlacement: function (error, element) {
                      error.addClass('d-block');
                      element.closest('.mb-3').append(error);
                  },
                  highlight: function (element) {
                      $(element).addClass('is-invalid').removeClass('is-valid');
                  },
                  unhighlight: function (element) {
                      $(element).removeClass('is-invalid').addClass('is-valid');
                  },
                  submitHandler: function(form) {
                      // This won't be called as we handle submission manually
                      return false;
                  }
              });

              // Trigger GST calculation
              calculateGST();
              if (typeof window.updateAcceptModalDateConstraints === 'function') {
                  window.updateAcceptModalDateConstraints();
              }
          });

          // Reset validation when modal is hidden
          $('#acceptInternshipModal').on('hidden.bs.modal', function() {
              if (opportunityConfigValidator) {
                  opportunityConfigValidator.resetForm();
                  $('#internshipConfigForm').find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                  $('#internshipConfigForm').find('.invalid-feedback').remove();
              }
              // Reset form
              $('#internshipConfigForm')[0].reset();
              $('#registrationFees').val('1000');
              $('#lastRegistrationDate').val('');
              $('#lateRegistrationFee').val('0');
              $('#internshipType').val('1');
              $('#manageTaskStatus').prop('checked', true);
              $('#acceptInternshipModal').removeData('application-deadline');
              $('#lastRegistrationDate').removeAttr('min').removeAttr('max');
              // Reset category/subcategory approval UI
              $('#categoryReselectSection').hide();
              $('#categoryApprovalNote').hide();
              $('#categoryApprovalNoteText').text('');
              if ($('#reselectCategory').hasClass('select2-hidden-accessible')) {
                  $('#reselectCategory').select2('destroy');
              }
              if ($('#reselectSubcategory').hasClass('select2-hidden-accessible')) {
                  $('#reselectSubcategory').select2('destroy');
              }
              $('#reselectCategory').empty().append('<option value="">Select Category</option>');
              $('#reselectSubcategory').empty();
              window.__internshipSubcategories = [];
              $('#acceptApproveBtn').prop('disabled', false).css({ 'opacity': '1', 'cursor': 'pointer' });
              calculateGST();
          });
      });
  </script>

  <!-- Accept Opportunity Modal (Common for all pages) -->
  <div class="modal fade" id="acceptInternshipModal" tabindex="-1" aria-labelledby="acceptInternshipModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white;">
                  <div>
                      <h5 class="modal-title" id="acceptInternshipModalLabel" style="color:#fff;">
                          <i class="bx bx-check-circle"></i> Accept Internship Application
                      </h5>
                      <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Review Internship details before approval</p>
                  </div>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" style="padding: 30px;">
                  <!-- Category/Subcategory Re-selection (shown when request rejected) -->
                  <div class="detail-section" id="categoryReselectSection" style="display: none; background: #fff8e6; border: 2px solid #ffc107; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                      <h6 style="color: #856404; font-weight: 700; font-size: 14px; text-transform: uppercase; margin-bottom: 5px;">
                          <i class="bx bx-refresh"></i> Update Category & Sub Category
                      </h6>
                      <p style="font-size: 12px; color: #856404; margin-bottom: 15px;">
                          The requested Category/Subcategory was <strong>rejected</strong>. Please select an approved Category and Sub Category below — the Accept &amp; Approve button will be enabled after selection.
                      </p>
                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label for="reselectCategory" class="form-label" style="font-weight: 600;">Category <span class="text-danger">*</span></label>
                              <select class="form-control" id="reselectCategory" name="reselect_category" style="width: 100%;">
                                  <option value="">Select Category</option>
                              </select>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label for="reselectSubcategory" class="form-label" style="font-weight: 600;">Sub Category <span class="text-danger">*</span></label>
                              <select class="form-control" id="reselectSubcategory" name="reselect_subcategory[]" multiple style="width: 100%;">
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="detail-section" style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                          <h6 style="color: #242a62; font-weight: 700; font-size: 14px; text-transform: uppercase; margin: 0; padding-bottom: 10px; border-bottom: 2px solid #242a62; flex-grow: 1;">
                              <i class="bx bx-briefcase"></i> Internship Details
                          </h6>
                          <button type="button" class="btn btn-sm btn-outline-primary ms-3" onclick="editInternship()" style="white-space: nowrap;">
                              <i class="bx bx-edit"></i> Edit
                          </button>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Internship Title:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="internshipTitle">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Category:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="category">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Sub Category:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="subcategory">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Company Name:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="companyName">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Mode:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="workMode">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Location:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="location">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Duration:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="duration">-</span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Start Date:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="startDate">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">End Date:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="endDate">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Stipend:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="stipend">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Openings:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="openings">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #dee2e6;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Batch Days:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="batchDays">-</span>
                              </div>
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Time Slots:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="timeSlots">-</span>
                              </div>
                          </div>
                      </div>

                      <!-- Skills & Eligibility -->
                      <div class="row mt-3">
                          <div class="col-12">
                              <h6 class="text-primary mb-2" style="font-size: 13px;"><i class="bx bx-cog"></i> Skills & Requirements</h6>
                          </div>
                          <div class="col-md-6">
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Required Skills:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="requiredSkills">-</span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="detail-row" style="display: flex; justify-content: space-between; padding: 10px 0;">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Eligibility Criteria:</span>
                                  <span class="detail-value" style="color: #212529; font-size: 13px;" id="eligibilityCriteria">-</span>
                              </div>
                          </div>
                      </div>

                      <!-- Descriptions -->
                      <div class="row mt-3">
                          <div class="col-12 mb-2">
                              <h6 class="text-primary mb-2" style="font-size: 13px;"><i class="bx bx-detail"></i> Description Details</h6>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="detail-row">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Program Overview:</span>
                              </div>
                              <div class="detail-value" id="internshipDescription" style="padding: 10px; background: #fff; border-radius: 6px; font-size: 12px; border: 1px solid #dee2e6; margin-top: 5px;">-</div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="detail-row">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Module Brief:</span>
                              </div>
                              <div class="detail-value" id="moduleDescription" style="padding: 10px; background: #fff; border-radius: 6px; font-size: 12px; border: 1px solid #dee2e6; margin-top: 5px;">-</div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="detail-row">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Learning Objectives:</span>
                              </div>
                              <div class="detail-value" id="internshipObjective" style="padding: 10px; background: #fff; border-radius: 6px; font-size: 12px; border: 1px solid #dee2e6; margin-top: 5px;">-</div>
                          </div>
                          <div class="col-12 mb-2">
                              <div class="detail-row">
                                  <span class="detail-label" style="font-weight: 600; color: #495057; font-size: 13px;">Skills You'll Gain:</span>
                              </div>
                              <div class="detail-value" id="internshipOutcome" style="padding: 10px; background: #fff; border-radius: 6px; font-size: 12px; border: 1px solid #dee2e6; margin-top: 5px;">-</div>
                          </div>
                      </div>
                  </div>

                  <!-- Registration Fee Configuration -->
                  <div class="detail-section" style="background: #fff; border: 2px solid #e7e7ff; border-radius: 10px; padding: 20px;">
                      <h6 style="color: #696cff; font-weight: 700; font-size: 14px; text-transform: uppercase; margin-bottom: 15px;">
                          <i class="bx bx-money"></i> Internship Configuration
                      </h6>
                      <form id="internshipConfigForm">
                          <div class="row">
                            <div class="col-md-4 mb-3">
                                   <label for="opportunityType" class="form-label" style="font-weight: 600;">
                                        Program Type <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control" id="internshipType" name="internship_type" required>
                                        <option value="">Select Program Type</option>
                                        <option value="1" selected>Associate with College</option>
                                        <option value="2">Industry Partnership Program</option>
                                    </select>
                              </div>
                              <div class="col-md-4 mb-3">
                                  <label for="modalStartDate" class="form-label" style="font-weight: 600;">Program Start Date <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" id="modalStartDate" name="start_date" required>
                              </div>
                              <div class="col-md-4 mb-3">
                                  <label for="modalEndDate" class="form-label" style="font-weight: 600;">Program End Date <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" id="modalEndDate" name="end_date" required>
                              </div>
                          </div>
                          
                          <div class="row">
                              <div class="col-md-4 mb-3">
                                  <label for="registrationFees" class="form-label" style="font-weight: 600;">Registration Fees (₹) <span class="text-danger">*</span></label>
                                  <input type="number" class="form-control" id="registrationFees" name="registration_fees" placeholder="Enter amount" value="1000" min="0" step="0.01" required>
                                  <small class="text-muted">Base registration fee</small>
                              </div>

                              <div class="col-md-4 mb-3">
                                  <label for="lastRegistrationDate" class="form-label" style="font-weight: 600;">Last Date of Registration</label>
                                  <input type="date" class="form-control" id="lastRegistrationDate" name="last_registration_date">
                                  <small class="text-muted">After this date, late fee applies</small>
                              </div>

                              <div class="col-md-4 mb-3" id="lateRegistrationFeeWrap">
                                  <label for="lateRegistrationFee" class="form-label" style="font-weight: 600;">Late Registration Fee (₹)</label>
                                  <input type="number" class="form-control" id="lateRegistrationFee" name="late_registration_fee" value="0" min="0" step="0.01" placeholder="Enter late fee">
                                  <small class="text-muted">Charged only after last registration date</small>
                              </div>
                              
                              <div class="col-md-4 mb-3">
                                  <label for="gstPercentage" class="form-label" style="font-weight: 600;">GST Percentage (%)</label>
                                  <input type="number" class="form-control" id="gstPercentage" name="gst_percentage" value="18" readonly disabled style="background-color: #e9ecef; cursor: not-allowed;">
                                  <small class="text-muted">Fixed at 18%</small>
                              </div>
                              
                              <div class="col-md-4 mb-3">
                                  <label for="gstAmount" class="form-label" style="font-weight: 600;">GST Amount (₹)</label>
                                  <input type="number" class="form-control" id="gstAmount" name="gst_amount" placeholder="Auto calculated" readonly style="background-color: #fff3cd; font-weight: 600;">
                                  <small class="text-muted">Calculated automatically</small>
                              </div>
                              <div class="col-md-4 mb-3">
                                  <label class="form-label" style="font-weight: 600;">Enable Task Management?</label>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" id="manageTaskStatus" name="manage_task_status" value="1" checked>
                                      <label class="form-check-label" for="manageTaskStatus">Enable task management for this Internship</label>
                                  </div>
                                  <small class="text-muted">If enabled, Internship tasks feature will be active for this Internship.</small>
                              </div>
                          </div>
                          
                          <div class="row">
                              <div class="col-md-12 mb-3">
                                  <label for="finalAmount" class="form-label" style="font-weight: 600; font-size: 15px;">Total Pay Amount (₹) <span class="text-danger">*</span></label>
                                  <input type="number" class="form-control" id="finalAmount" name="final_amount" placeholder="Total amount with GST" readonly style="background-color: #d1e7dd; font-weight: 700; font-size: 18px; color: #0f5132; border: 2px solid #28a745;">
                                  <small class="text-success"><i class="bx bx-info-circle"></i> Includes GST. Late fee is added automatically if today is after the last registration date.</small>
                              </div>
                          </div>

                          <!-- Calculation Summary Box -->
                          <div class="row">
                              <div class="col-12">
                                  <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 15px; border-left: 4px solid #696cff;">
                                      <div class="d-flex justify-content-between align-items-center">
                                          <div>
                                              <small style="color: #6c757d; font-weight: 600; text-transform: uppercase; font-size: 11px;">Calculation Summary</small>
                                              <div style="margin-top: 8px;">
                                                  <span style="color: #495057; font-size: 13px;">
                                                      Registration Fees: <strong style="color: #242a62;">₹<span id="summaryRegFees">1000.00</span></strong>
                                                  </span>
                                                  <span id="summaryLateWrap" style="color: #495057; font-size: 13px; margin-left: 15px; display:none;">
                                                      + Late Fee: <strong style="color: #dc3545;">₹<span id="summaryLateFee">0.00</span></strong>
                                                  </span>
                                                  <span style="color: #495057; font-size: 13px; margin-left: 15px;">
                                                      + GST (<span id="summaryGstPct">18</span>%): <strong style="color: #ff9800;">₹<span id="summaryGst">180.00</span></strong>
                                                  </span>
                                                  <span style="color: #495057; font-size: 13px; margin-left: 15px;">
                                                      = Total: <strong style="color: #28a745; font-size: 15px;">₹<span id="summaryTotal">1180.00</span></strong>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
              <div id="categoryApprovalNote" style="display: none; background: #fff3cd; border: 1px solid #ffc107; color: #856404; border-radius: 8px; padding: 10px 15px; margin: 0 30px 10px 30px; font-size: 13px; font-weight: 600;">
                  <i class="bx bx-info-circle"></i> <span id="categoryApprovalNoteText"></span>
              </div>
              <div class="modal-footer" style="background: #f8f9fa; padding: 20px 30px;">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      <i class="bx bx-x"></i> Cancel
                  </button>
                  <button type="button" id="acceptApproveBtn" class="btn" onclick="confirmAcceptInternship()" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3); display: inline-flex; align-items: center;">
                      <i class="bx bx-check-circle"></i> Accept & Approve Internship
                  </button>
              </div>
          </div>
      </div>
  </div>

  <style>
      #categoryReselectSection .select2-container--default .select2-selection--single {
          height: 38px;
          border: 1px solid #ced4da;
          border-radius: 6px;
          padding: 5px 10px;
      }
      #categoryReselectSection .select2-container--default .select2-selection--single .select2-selection__rendered {
          line-height: 26px;
          color: #212529;
          font-size: 13px;
      }
      #categoryReselectSection .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 36px;
      }
      #categoryReselectSection .select2-container--default .select2-selection--multiple {
          min-height: 38px;
          border: 1px solid #ced4da;
          border-radius: 6px;
          padding: 4px 8px;
      }
      #categoryReselectSection .select2-container--default .select2-selection--multiple .select2-selection__choice {
          background: #696cff;
          color: #fff;
          border: none;
          border-radius: 4px;
          padding: 2px 8px;
          margin: 2px;
          font-size: 12px;
      }
      #categoryReselectSection .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
          color: #fff;
          margin-right: 4px;
      }
      #categoryReselectSection .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
          color: #ffcdd2;
      }
      #categoryReselectSection .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
          color: #6c757d;
          font-size: 13px;
      }
      #categoryReselectSection .select2-container--default.select2-container--focus .select2-selection--multiple,
      #categoryReselectSection .select2-container--default.select2-container-open .select2-selection--multiple {
          border-color: #696cff;
          box-shadow: 0 0 0 0.15rem rgba(105, 108, 255, 0.25);
      }
      /* Ensure Select2 dropdowns render above modal scrollable body */
      #acceptInternshipModal .select2-dropdown {
          z-index: 9999 !important;
      }
      #acceptInternshipModal .select2-container--open {
          z-index: 9999 !important;
      }
  </style>

  </body>

  </html>
