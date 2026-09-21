{{-- College Admin horizontal top navigation (UI only) --}}
@php
    $isCollegeAdmin = auth()->guard('college')->check();
    $isCollegeStaffUser = auth()->guard('college_staff')->check();
    $logoSrc = ($Setting && $Setting->header_logo)
        ? asset('uploads/logo_img/' . $Setting->header_logo)
        : asset('assets/imgs/logo/logo1.png');
@endphp

<nav class="layout-navbar college-topnav" id="college-topnav" aria-label="College navigation">
    <div class="college-topnav-inner">
        <button type="button" class="college-topnav-toggle" id="collegeNavToggle" aria-label="Open menu">
            <i class="bx bx-menu" style="font-size:22px;"></i>
        </button>

        <a href="{{ route('admin.college.dashboard') }}" class="college-topnav-brand">
            <img src="{{ $logoSrc }}" alt="Zobpot">
        </a>

        <ul class="college-topnav-menu desktop-only menu-inner">
            <li class="menu-item" title="College Dashboard" id="College-Dashboard">
                <a href="{{ route('admin.college.dashboard') }}" class="menu-link college-nav-link">
                    <i class="bx bx-home-smile"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if($isCollegeAdmin)
            <li class="menu-item" title="Manage Staff" id="CollegeStaff">
                <a href="{{ route('admin.college.staff.index') }}" class="menu-link college-nav-link">
                    <i class="bx bx-group"></i>
                    <span>Staff</span>
                </a>
            </li>
            <li class="menu-item" title="Manage Roles" id="CollegeRoles">
                <a href="{{ route('admin.college.roles.index') }}" class="menu-link college-nav-link">
                    <i class="bx bx-shield-quarter"></i>
                    <span>Roles</span>
                </a>
            </li>
            @endif

            <li class="menu-item" title="Registration List" id="CollegeRegistration">
                <a href="{{ route('admin.college.registration-list') }}" class="menu-link college-nav-link">
                    <i class="bx bx-user"></i>
                    <span>Students</span>
                </a>
            </li>

            <li class="menu-item" title="College Marks" id="CollegeMarks">
                <a href="{{ route('admin.internship.college-marks') }}" class="menu-link college-nav-link">
                    <i class="bx bx-edit"></i>
                    <span>Marks</span>
                </a>
            </li>

            <li class="menu-item" title="Marks History" id="CollegeMarksHistory">
                <a href="{{ route('admin.internship.college-marks-history') }}" class="menu-link college-nav-link">
                    <i class="bx bx-history"></i>
                    <span>History</span>
                </a>
            </li>

            @if($isCollegeAdmin || ($isCollegeStaffUser && auth()->guard('college_staff')->user()->can('ManageGrade-View')))
            <li class="menu-item" title="Manage Grade" id="ManageGrade">
                <a href="{{ route('admin.manage-grade.index') }}" class="menu-link college-nav-link">
                    <i class="bx bx-medal"></i>
                    <span>Grade</span>
                </a>
            </li>
            @endif

            <li class="menu-item" title="My Internships" id="CollegeInternship">
                <a href="{{ route('admin.college.dashboard') }}#college-internship-section" class="menu-link college-nav-link">
                    <i class="bx bx-briefcase"></i>
                    <span>Internships</span>
                </a>
            </li>

            @if($isCollegeAdmin)
            <li class="menu-item" title="Settings" id="CollegeSettings">
                <a href="{{ route('admin.college.settings') }}" class="menu-link college-nav-link">
                    <i class="bx bx-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            @endif
        </ul>

        <div class="college-topnav-actions">
            <div class="dropdown">
                <a class="college-notify-btn" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                    <i class="bx bx-bell" style="font-size:20px;"></i>
                    <span class="college-notify-badge">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end college-dropdown-menu">
                    <li class="px-3 py-2">
                        <strong style="font-size:13px;">Notifications</strong>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.college.pending-marks') }}">
                            <i class="bx bx-time me-2 text-warning"></i> Pending marks review
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.college.dashboard') }}#college-internship-section">
                            <i class="bx bx-briefcase me-2 text-primary"></i> Internship updates
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.college.registration-list') }}">
                            <i class="bx bx-user-plus me-2 text-success"></i> New student registrations
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown">
                <a class="college-profile-toggle dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('admin-assets/img/user.png') }}" alt="Profile">
                    <span class="college-profile-meta">
                        <strong>{{ $userName }}</strong>
                        <small>{{ $userRole }}</small>
                    </span>
                    <i class="bx bx-chevron-down" style="font-size:16px;color:#9CA3AF;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end college-dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('admin-assets/img/user.png') }}" alt="" width="36" height="36" class="rounded-circle">
                                <div>
                                    <div style="font-weight:600;font-size:13px;">{{ $userName }}</div>
                                    <small class="text-muted">{{ $userRole }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    @if($isCollegeAdmin)
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.college.settings') }}">
                            <i class="bx bx-cog me-2"></i> Settings
                        </a>
                    </li>
                    @endif
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.login') }}"
                           onclick="event.preventDefault(); var f=document.getElementById('logout-form'); if(f){ f.submit(); } else { window.location.href=this.href; }">
                            <i class="bx bx-power-off me-2"></i> Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- Mobile drawer — duplicates links; uses data-menu-id (not duplicate HTML ids) --}}
<div class="college-mobile-drawer" id="collegeMobileDrawer" aria-hidden="true">
    <div class="college-mobile-drawer-panel">
        <a href="{{ route('admin.college.dashboard') }}" class="menu-link college-nav-link" data-menu-id="College-Dashboard">
            <i class="bx bx-home-smile"></i> Dashboard
        </a>
        @if($isCollegeAdmin)
        <a href="{{ route('admin.college.staff.index') }}" class="menu-link college-nav-link" data-menu-id="CollegeStaff">
            <i class="bx bx-group"></i> Staff
        </a>
        <a href="{{ route('admin.college.roles.index') }}" class="menu-link college-nav-link" data-menu-id="CollegeRoles">
            <i class="bx bx-shield-quarter"></i> Roles
        </a>
        @endif
        <a href="{{ route('admin.college.registration-list') }}" class="menu-link college-nav-link" data-menu-id="CollegeRegistration">
            <i class="bx bx-user"></i> Students
        </a>
        <a href="{{ route('admin.internship.college-marks') }}" class="menu-link college-nav-link" data-menu-id="CollegeMarks">
            <i class="bx bx-edit"></i> Marks
        </a>
        <a href="{{ route('admin.internship.college-marks-history') }}" class="menu-link college-nav-link" data-menu-id="CollegeMarksHistory">
            <i class="bx bx-history"></i> History
        </a>
        @if($isCollegeAdmin || ($isCollegeStaffUser && auth()->guard('college_staff')->user()->can('ManageGrade-View')))
        <a href="{{ route('admin.manage-grade.index') }}" class="menu-link college-nav-link" data-menu-id="ManageGrade">
            <i class="bx bx-medal"></i> Grade
        </a>
        @endif
        <a href="{{ route('admin.college.dashboard') }}#college-internship-section" class="menu-link college-nav-link" data-menu-id="CollegeInternship">
            <i class="bx bx-briefcase"></i> Internships
        </a>
        @if($isCollegeAdmin)
        <a href="{{ route('admin.college.settings') }}" class="menu-link college-nav-link" data-menu-id="CollegeSettings">
            <i class="bx bx-cog"></i> Settings
        </a>
        @endif
    </div>
</div>
