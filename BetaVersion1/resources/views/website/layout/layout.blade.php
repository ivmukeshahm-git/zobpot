  @php
      $states = App\Models\State::select('state_id', 'state_name')->get();
      $Setting = App\Models\Setting::where('id', 1)->first();
  @endphp

  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="msapplication-TileColor" content="#0E0E0E">
      <meta name="template-color" content="#0E0E0E">

      <meta name="author" content="">
      <link rel="shortcut icon" type="image/x-icon"
          href="{{ $Setting ?? $Setting->favicon ? asset('uploads/logo_img/' . $Setting->favicon) : asset('assets/imgs/logo/favicon1.png') }}">
      <link href="{{ asset('assets/css/stylecd4e.css?version=4.1?id=2') }}" rel="stylesheet">

      <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


      <title>{{ $Setting->web_title }}</title>

      <meta name="description" content="{{ $Setting ? $Setting->web_description : '' }}">
      <meta name="keywords" content="{{ $Setting ? $Setting->web_keyword : '' }}">

      <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  @stack('css')
  <script>
      var page_active_id = "Home";
  </script>
  <style>
      .work-experience-add-box {
          border: 1px solid #e0e6f6;
          background-color: #fff;
          padding: 10px;
          box-shadow: 4px 5px 10px #00000045;
          border-radius: 10px;
      }

      .work-desc {
          font-size: 15px;
          line-height: 27px;
          font-weight: 500;
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-line-clamp: 5;
          -webkit-box-orient: vertical;
      }


      .about-desc {
          font-size: 15px;
          line-height: 27px;
          font-weight: 500;
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-line-clamp: 8;
          -webkit-box-orient: vertical;
      }

      .candidates-about-desc {
          font-size: 15px;
          line-height: 27px;
          font-weight: 500;
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-line-clamp: 3;
          -webkit-box-orient: vertical;
      }

      .button-work-experience-row-edit {
          float: right;
      }

      .main-button-file-upload-box {
          border: 1px solid #e0e6f6;
          padding: 10px;
          height: 140px;
          border-radius: 12px;
          box-shadow: 12px 4px 5px #eee;
          background: #ffffff;
          align-content: center;
      }

      #WorkExperienceAdd {
          display: none;
      }

      #EducationAdd {
          display: none;
      }

      .suggestions {
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          border: 1px solid #ccc;
          background-color: #fff;
          z-index: 10;
          max-height: 200px;
          overflow-y: auto;
      }

      .suggestion-item {
          padding: 8px;
          cursor: pointer;
      }

      .suggestion-item:hover {
          background-color: #f0f0f0;
      }

      #Statesuggestions {
          display: none;
      }

      #Citysuggestions {
          display: none;
      }

      #Areasuggestions {
          display: none;
      }

      #Pincodesuggestions {
          display: none;
      }

      .active-tab {
          background: #242a62 !important;
          color: #fff !important;
      }

      .color-red {
          color: red;
      }

      .user-profile .main-menu li.has-children>a::after {
          content: none
      }

      .user-profile .main-menu li a:hover::before {
          background: none !important;
      }

      .user-profile .main-menu li ul li a::after {
          content: none;
      }

      .user-profile .main-menu li ul li a {
          font-size: 15px;
          padding: 13px 18px 10px 20px !important;
      }

      .user-profile .main-menu li ul li a i {
          font-size: 15px;
      }
  </style>
  <style>
      .selected_area {
          display: flex;
          flex-wrap: wrap;
          gap: 8px;
          margin-top: 10px;
      }

      .badge-item {
          background-color: #4e4e4e;
          color: white;
          padding: 0 9px;
          border-radius: 10px;
          font-size: 12px;
          display: inline-flex;
          align-items: center;
          white-space: nowrap;
          font-weight: 600;
          cursor: pointer;
      }
  </style>

  <body>
      @php
          $user = auth()->user();
      @endphp

      <div id="preloader-active">
          <div class="preloader d-flex align-items-center justify-content-center">
              <div class="preloader-inner position-relative">
                  <div class="text-center"><img src="{{ asset('assets/imgs/template/loading.gif') }}" alt="Loader">
                  </div>
              </div>
          </div>
      </div>

      <header class="header sticky-bar">
          <div class="container">
              <div class="main-header">
                  <div class="header-left">
                      <div class="header-logo">
                          <a class="d-flex" href="{{ route('home') }}"><img alt="jobBox"
                                  src="{{ $Setting ?? $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}"
                                  class="logo"></a>
                      </div>
                  </div>
                  <div class="header-nav">
                      <!-- <nav class="nav-main-menu">
                          <ul class="main-menu">
                              <li><a id="Home" href="{{ route('home') }}">Home</a></li>
                              <li><a id="About" href="{{ route('about') }}">About us</a></li>
                              <li><a id="Job" href="{{ route('job') }}">Find a Job</a></li>
                              @if ($user && $user->profile_type == 'Employee')
                                  <li><a id="Companies" href="{{ route('find-companies') }}">Recruiters</a></li>
                              @else
                                  <li><a id="Candidates" href="{{ route('find-candidates') }}">Hire</a></li>
                              @endif

                              <li><a id="Blog" href="{{ route('blog') }}">Blog</a></li>
                              <li><a id="Contact" href="{{ route('contact') }}">Contact us</a></li>
                          </ul>
                      </nav> -->
                              <!-- <li class="dashboard"><a href="http://wp.alithemes.com/html/jobbox/demos/dashboard" target="_blank">Dashboard</a></li> -->
                    <nav class="nav-main-menu">
                        <ul class="main-menu">
                            <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                            <li><a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About us</a></li>
                            @if ($user && $user->profile_type != 'Company')
                            <li><a class="{{ request()->routeIs('job') ? 'active' : '' }}" href="{{ route('job') }}">Find a Job</a></li>
                            @endif
                            @if ($user && $user->profile_type == 'Employee')
                                <li><a class="{{ request()->routeIs('find-companies') ? 'active' : '' }}" href="{{ route('find-companies') }}">Recruiters</a></li>
                            @else
                                <li><a class="{{ request()->routeIs('find-candidates') ? 'active' : '' }}" href="{{ route('find-candidates') }}">Hire</a></li>
                            @endif

                            <li><a class="{{ request()->routeIs('skillthon') ? 'active' : '' }}" href="{{ route('skillthon') }}">Skillothon</a></li>                            
                            <li><a class="{{ request()->routeIs('internship') ? 'active' : '' }}" href="{{ route('internship') }}">Internship</a></li>
                            
                            <li><a class="{{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">Blog & Tips</a></li>
                            <li><a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact us</a></li>
                        </ul>
                    </nav>
                      <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span
                              class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                  </div>


                  <div class="header-right">
                      <nav class="nav-main-menu user-profile">
                          <ul class="main-menu">
                              @if ($user)
                                  <li class="has-children">
                                      <a href="javascript:void(0);"
                                          style="display: flex; align-items: center; gap: 10px;">
                                          {{-- <img src="{{ $user->profile_img ? asset('uploads/profile/' . $user->profile_img) : asset('uploads/profile/candidate.jpg') }}"
                                              style="max-width: 40px; border-radius: 100%;" alt="Profile"> --}}
                                            @php
                                                $img = 'uploads/profile/candidate.jpg';
                                                if (!empty($user->profile_img) && file_exists(public_path('uploads/profile/'.$user->profile_img))) {
                                                    $img = 'uploads/profile/'.$user->profile_img;
                                                }
                                            @endphp

                                            <img src="{{ asset($img) }}" style="max-width:40px;border-radius:100%;" alt="Profile">

                                          <div>
                                              <strong>{{ $user->profile_type }}</strong><br>
                                              <small>{{ $user->name }}</small>
                                          </div>
                                      </a>
                                      <ul class="sub-menu">
                                          @if ($user->profile_type == 'Employee')
                                              <li><a href="{{ route('candidate-profile') }}"><i
                                                          class="fa fa-user"></i>&nbsp; Profile</a>
                                              </li>
                                          @else
                                              <li><a href="{{ route('company-profile') }}"><i
                                                          class="fa fa-user"></i>&nbsp; Profile</a></li>
                                          @endif


                                          <li><a href="{{ route('logout') }}"
                                                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                      class="fa fa-sign-out"></i>&nbsp; Logout</a>
                                          </li>
                                      </ul>
                                  </li>

                                  <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                      @csrf
                                  </form>
                              @else
                                  <li class="has-children">
                                      <a href="{{ route('login') }}"
                                          style="display: flex; align-items: center; gap: 10px;">
                                          <div>
                                              <strong>Login</strong><br>
                                          </div>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </nav>
                  </div>
              </div>
          </div>
      </header>


      <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
          <div class="mobile-header-wrapper-inner">
              <div class="mobile-header-content-area">
                  <div class="perfect-scroll">
                      <div class="mobile-search mobile-header-border mb-30">
                          <form action="#">
                              <input type="text" placeholder="Search…"><i class="fi-rr-search"></i>
                          </form>
                      </div>
                      <div class="mobile-menu-wrap mobile-header-border">
                          <!-- mobile menu start-->
                           
                          <nav>
                              <ul class="mobile-menu font-heading">
                                  <li><a href="{{ route('home') }}">Home</a></li>
                                  <li><a href="{{ route('about') }}">About us</a></li>
                                  <li><a href="{{ route('job') }}">Find a Job</a></li>
                                  @if ($user && $user->profile_type == 'Employee')
                                      <li><a href="{{ route('find-companies') }}">Recruiters</a></li>
                                  @else
                                      <li><a href="{{ route('find-candidates') }}">Hire</a></li>
                                  @endif
                                  <li><a href="{{ route('blog') }}">Blog</a></li>
                                  <li><a href="{{ route('contact') }}">Contact us</a></li>
                              </ul>
                          </nav>
                      </div>
                      <div class="mobile-account">
                          @if ($user)
                              <h6 class="mb-10">Your Account</h6>
                              <ul class="mobile-menu font-heading">
                                  @if ($user && $user->profile_type == 'Employee')
                                      <li><a href="{{ route('candidate-profile') }}">Profile</a>
                                      </li>
                                  @else
                                      <li><a href="{{ route('company-profile') }}">Profile</a></li>
                                  @endif

                                  <li><a href="{{ route('logout') }}"
                                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                  </li>
                              </ul>


                              <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                  @csrf
                              </form>
                          @else
                              <h6 class="mb-10">Login Account</h6>
                              <ul class="mobile-menu font-heading">
                                  <li><a href="{{ route('login') }}">Login</a></li>
                              </ul>
                          @endif
                      </div>
                      <div class="site-copyright">©
                          <script>
                              document.write(new Date().getFullYear());
                          </script>2025 Zobpot All rights reserved. Designed and developed by 
                          {{-- <a href="https://ivinfotech.com/" target="_blank">IV Infotech.</a> --}}
                          <a href="javascript:void(0)">Zobpot.</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
          <div class="mobile-header-wrapper-inner">
              <div class="mobile-header-content-area">
                  <div class="perfect-scroll">
                      <div class="mobile-search mobile-header-border mb-30">
                          <form action="#">
                              <input type="text" placeholder="Search…"><i class="fi-rr-search"></i>
                          </form>
                      </div>
                      <div class="mobile-menu-wrap mobile-header-border">
                          <!-- mobile menu start-->
                          <nav>
                              <ul class="mobile-menu font-heading">
                                  <li><a href="{{ route('home') }}">Home</a></li>
                                  <li><a href="{{ route('about') }}">About us</a></li>
                                  <li><a href="{{ route('job') }}">Find a Job</a></li>
                                  @if ($user && $user->profile_type == 'Employee')
                                      <li><a href="{{ route('find-companies') }}">Recruiters</a></li>
                                  @else
                                      <li><a href="{{ route('find-candidates') }}">Hire</a></li>
                                  @endif
                                  <li><a href="{{ route('blog') }}">Blog</a></li>
                                  <li><a href="{{ route('contact') }}">Contact us</a></li>
                              </ul>
                          </nav>
                      </div>
                      <div class="mobile-account">
                          @if ($user)
                              <h6 class="mb-10">Your Account</h6>
                              <ul class="mobile-menu font-heading">
                                  @if ($user->profile_type == 'Employee')
                                      <li><a href="{{ route('candidate-profile') }}">Profile</a></li>
                                  @else
                                      <li><a href="{{ route('company-profile') }}">Profile</a></li>
                                  @endif

                                  <li><a href="{{ route('logout') }}"
                                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                  </li>
                              </ul>


                              <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                  @csrf
                              </form>
                          @else
                              <h6 class="mb-10">Login Account</h6>
                              <ul class="mobile-menu font-heading">
                                  <li><a href="{{ route('login') }}">Login</a></li>
                              </ul>
                          @endif
                      </div>
                      <div class="site-copyright">©
                          <script>
                              document.write(new Date().getFullYear());
                          </script>2025 Zobpot All rights reserved. Designed and developed by 
                          {{-- <a href="https://ivinfotech.com/" target="_blank">IV Infotech.</a> --}}
                          <a href="javascript:void(0)">Zobpot.</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      @yield('website-content')


<footer class="footer pt-70" style="background:#f47d420d;position:relative;">
    <!-- Left: Company Buildings | Right: Candidate Tools Only -->
        {{-- <svg class="footer-skyline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none" style="position: absolute; top: -99px; left: 0; width: 100%; height: 100px; display: block;">
            <g fill="#f47d420d">
                <!-- LEFT SIDE - COMPANY BUILDINGS ONLY (0-900px) -->
                <rect x="0" y="50" width="28" height="50"/>
                <rect x="28" y="45" width="32" height="55"/>
                <rect x="55" y="42" width="10" height="8"/>
                <rect x="60" y="55" width="24" height="45"/>
                <rect x="84" y="38" width="38" height="62"/>
                <rect x="106" y="32" width="12" height="8"/>
                <rect x="122" y="52" width="26" height="48"/>
                <rect x="148" y="48" width="30" height="52"/>
                <rect x="170" y="44" width="9" height="10"/>
                <rect x="178" y="45" width="34" height="55"/>
                <rect x="204" y="38" width="11" height="9"/>
                <rect x="212" y="56" width="24" height="44"/>
                <rect x="236" y="35" width="40" height="65"/>
                <rect x="258" y="28" width="12" height="9"/>
                <rect x="276" y="50" width="28" height="50"/>
                <rect x="304" y="44" width="34" height="56"/>
                <rect x="330" y="40" width="10" height="10"/>
                <rect x="338" y="52" width="26" height="48"/>
                <rect x="364" y="40" width="38" height="60"/>
                <rect x="388" y="34" width="11" height="8"/>
                <rect x="402" y="48" width="30" height="52"/>
                <rect x="432" y="30" width="44" height="70"/>
                <rect x="458" y="24" width="13" height="8"/>
                <rect x="460" y="18" width="9" height="8"/>
                <rect x="476" y="54" width="25" height="46"/>
                <rect x="501" y="46" width="32" height="54"/>
                <rect x="525" y="42" width="9" height="11"/>
                <rect x="533" y="50" width="28" height="50"/>
                <rect x="561" y="36" width="36" height="64"/>
                <rect x="583" y="30" width="11" height="8"/>
                <rect x="597" y="52" width="26" height="48"/>
                <rect x="623" y="44" width="34" height="56"/>
                <rect x="650" y="40" width="10" height="10"/>
                <rect x="657" y="48" width="30" height="52"/>
                <rect x="687" y="32" width="42" height="68"/>
                <rect x="712" y="26" width="12" height="8"/>
                <rect x="730" y="50" width="28" height="50"/>
                <rect x="758" y="45" width="32" height="55"/>
                <rect x="785" y="42" width="10" height="10"/>
                <rect x="790" y="55" width="24" height="45"/>
                <rect x="814" y="38" width="38" height="62"/>
                <rect x="836" y="32" width="12" height="8"/>
                <rect x="852" y="52" width="26" height="48"/>
                <rect x="878" y="48" width="30" height="52"/>
               
                <!-- RIGHT SIDE - CANDIDATE TOOLS ONLY (NO BUILDINGS) -->
               
                <!-- Big Laptop -->
                <g transform="translate(950, 35)">
                    <rect x="0" y="30" width="90" height="50" rx="3"/>
                    <rect x="5" y="35" width="80" height="38" fill="#ffffff" opacity="0.3"/>
                    <rect x="-5" y="80" width="100" height="5" rx="2"/>
                    <polygon points="10,80 80,80 85,75 5,75"/>
                    <circle cx="45" cy="83" r="2"/>
                </g>
               
                <!-- Big Smartphone -->
                <g transform="translate(1080, 30)">
                    <rect x="0" y="0" width="50" height="70" rx="5"/>
                    <rect x="5" y="8" width="40" height="50" fill="#ffffff" opacity="0.3"/>
                    <circle cx="25" cy="63" r="3"/>
                    <rect x="18" y="3" width="14" height="2" rx="1"/>
                </g>
               
                <!-- Big Graduation Cap -->
                <g transform="translate(1180, 40)">
                    <polygon points="0,15 50,5 100,15 100,18 0,18"/>
                    <rect x="45" y="18" width="10" height="25"/>
                    <circle cx="50" cy="45" r="4"/>
                    <line x1="54" y1="45" x2="75" y2="35" stroke="#f47d420d" stroke-width="2"/>
                    <circle cx="75" cy="35" r="3"/>
                </g>
               
                <!-- Big Briefcase -->
                <g transform="translate(1320, 50)">
                    <rect x="0" y="10" width="80" height="40" rx="3"/>
                    <rect x="20" y="5" width="40" height="8" rx="2"/>
                    <rect x="35" y="0" width="10" height="5"/>
                    <rect x="5" y="20" width="70" height="3"/>
                    <circle cx="40" cy="30" r="5"/>
                </g>
            </g>
        </svg> --}}
        <!-- SVG City Skyline - Professional Dense Design like Reference -->
        {{-- <svg class="footer-wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none" style="position: absolute; top: -79px; left: 0; width: 100%; height: 80px; display: block;">
            <g fill="#f47d420d">
                <!-- Dense Professional Skyline with Lots of Variation -->
                <rect x="0" y="45" width="28" height="35"/>
                <rect x="28" y="50" width="22" height="30"/>
                <rect x="50" y="42" width="32" height="38"/>
                <rect x="77" y="40" width="8" height="8"/>
                <rect x="82" y="55" width="24" height="25"/>
                <rect x="106" y="38" width="35" height="42"/>
                <rect x="124" y="32" width="10" height="6"/>
                <rect x="141" y="52" width="26" height="28"/>
                <rect x="167" y="48" width="28" height="32"/>
                <rect x="185" y="43" width="8" height="10"/>
                <rect x="195" y="45" width="30" height="35"/>
                <rect x="218" y="38" width="9" height="7"/>
                <rect x="225" y="56" width="22" height="24"/>
                <rect x="247" y="35" width="38" height="45"/>
                <rect x="268" y="28" width="11" height="7"/>
                <rect x="285" y="50" width="25" height="30"/>
                <rect x="310" y="44" width="32" height="36"/>
                <rect x="330" y="40" width="9" height="8"/>
                <rect x="342" y="52" width="24" height="28"/>
                <rect x="366" y="40" width="36" height="40"/>
                <rect x="387" y="34" width="10" height="6"/>
                <rect x="402" y="48" width="27" height="32"/>
                <rect x="429" y="30" width="42" height="50"/>
                <rect x="453" y="24" width="12" height="6"/>
                <rect x="455" y="18" width="8" height="6"/>
                <rect x="471" y="54" width="23" height="26"/>
                <rect x="494" y="46" width="29" height="34"/>
                <rect x="513" y="42" width="8" height="9"/>
                <rect x="523" y="50" width="26" height="30"/>
                <rect x="549" y="36" width="34" height="44"/>
                <rect x="569" y="30" width="10" height="6"/>
                <rect x="583" y="52" width="24" height="28"/>
                <rect x="607" y="44" width="31" height="36"/>
                <rect x="628" y="40" width="9" height="8"/>
                <rect x="638" y="48" width="28" height="32"/>
                <rect x="666" y="32" width="40" height="48"/>
                <rect x="690" y="26" width="11" height="6"/>
                <rect x="706" y="55" width="22" height="25"/>
                <rect x="728" y="50" width="26" height="30"/>
                <rect x="754" y="45" width="30" height="35"/>
                <rect x="776" y="41" width="8" height="9"/>
                <rect x="784" y="38" width="36" height="42"/>
                <rect x="806" y="32" width="10" height="6"/>
                <rect x="820" y="53" width="24" height="27"/>
                <rect x="844" y="46" width="29" height="34"/>
                <rect x="863" y="42" width="9" height="8"/>
                <rect x="873" y="35" width="38" height="45"/>
                <rect x="896" y="28" width="11" height="7"/>
                <rect x="911" y="51" width="25" height="29"/>
                <rect x="936" y="44" width="32" height="36"/>
                <rect x="957" y="40" width="8" height="8"/>
                <rect x="968" y="48" width="27" height="32"/>
                <rect x="995" y="30" width="42" height="50"/>
                <rect x="1019" y="24" width="12" height="6"/>
                <rect x="1021" y="18" width="8" height="6"/>
                <rect x="1037" y="54" width="23" height="26"/>
                <rect x="1060" y="46" width="30" height="34"/>
                <rect x="1080" y="42" width="9" height="9"/>
                <rect x="1090" y="38" width="36" height="42"/>
                <rect x="1112" y="32" width="10" height="6"/>
                <rect x="1126" y="52" width="25" height="28"/>
                <rect x="1151" y="45" width="31" height="35"/>
                <rect x="1172" y="41" width="8" height="8"/>
                <rect x="1182" y="50" width="27" height="30"/>
                <rect x="1209" y="36" width="38" height="44"/>
                <rect x="1232" y="30" width="11" height="6"/>
                <rect x="1247" y="53" width="24" height="27"/>
                <rect x="1271" y="47" width="29" height="33"/>
                <rect x="1290" y="43" width="9" height="8"/>
                <rect x="1300" y="40" width="35" height="40"/>
                <rect x="1321" y="34" width="10" height="6"/>
                <rect x="1335" y="51" width="26" height="29"/>
                <rect x="1361" y="46" width="30" height="34"/>
                <rect x="1381" y="42" width="8" height="9"/>
                <rect x="1391" y="48" width="25" height="32"/>
                <rect x="1416" y="52" width="24" height="28"/>
            </g>
        </svg> --}}
        </svg>
 
    <!-- #f47d420d -->
    <div class="container">
        <div class="row">
<!-- Right Side - Logo and Social Icons in One Line -->
            <div class="col-md-4 col-sm-12 col-12">
                <div>
                    <!-- Logo -->
                    <a href="{{ route('home') }}">
                        <img alt="jobBox" src="{{ $Setting ?? $Setting->footer_logo ? asset('uploads/logo_img/' . $Setting->footer_logo) : asset('assets/imgs/logo/logo1.png') }}" class="logo" style="margin-bottom: 20px;">
                    </a>
                    
                    <!-- Social Icons in One Line -->
                    <h6 style="color: #05264E; margin-bottom: 15px;">Follow Us</h6>
                    <div class="footer-social" style="display: flex; gap: 10px; flex-wrap: wrap;margin-bottom:3rem;">
                        <a href="https://www.facebook.com/share/1CSt4R5rv2/" target="_blank" class="social-icon" style="background: #f36825; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; color: white; font-size: 20px;">
                            <i class="fa fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/zobpot" target="_blank" class="social-icon" style="background: #f36825; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; color: white; font-size: 20px;">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com//zobpot/" target="_blank" class="social-icon" style="background: #f36825; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; color: white; font-size: 20px;">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/uas/login?session_redirect=https%3A%2F%2Fwww.linkedin.com%2Fmynetwork%2Fdiscovery-see-all%3Fusecase%3DPEOPLE_FOLLOWS%26followMember%3Dzob-pot-219b17373" target="_blank" class="social-icon" style="background: #f36825; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; color: white; font-size: 20px;">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </div>

                    <!-- Sales Contact -->
                    <div class="sales-contact mb-4 mt-4">
                        <h6 style="color:#05264E; margin-bottom: 10px;">Sales Contact</h6>

                        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                            
                            <!-- Phone -->
                            <a href="tel:{{ $Setting ? $Setting->contact_1 : '' }}"
                            style="display:flex; align-items:center; gap:10px; text-decoration:none;">
                                <div style="
                                    width:45px;
                                    height:45px;
                                    border-radius:50%;
                                    background:#f36825;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#fff;
                                    font-size:18px;">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <span style="color:#05264E; font-weight:600;">
                                    {{ $Setting ? $Setting->contact_1 : '' }}
                                </span>
                            </a>


                        </div>
                    </div>

                </div>
            </div>
            <!-- Center - Resources & Community Links -->
            <div class="col-md-4 col-sm-12 col-12">
                <div class="row">
                    <div class="col-6 text-center">
                        <h6 class="mb-20" style="color: #05264E;">Resources</h6>
                        <ul class="menu-footer">
                            <li><a href="{{route('about')}}">About us</a></li>
                            <li><a href="{{ route('job') }}">Find a Job</a></li>
                            @if ($user && $user->profile_type == 'Employee')
                                <li><a href="{{ route('find-companies') }}">Recruiters</a></li>
                            @else
                            <li><a href="{{ route('find-candidates') }}">Hire</a></li>
                            @endif
                            <li><a href="{{ route('blog') }}">Blogs & Tips</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-6 text-center">
                        <h6 class="mb-20" style="color: #05264E;">Community</h6>
                        <ul class="menu-footer">
                            <!--<li><a href="#">Feature</a></li>-->
                            <li><a href="{{route('frontPlan')}}">Pricing</a></li>
                            <!--<li><a href="#">Credit</a></li>-->
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Left Side - Two QR Codes (Android & iOS) -->
            <div class="col-md-4 col-sm-12 col-12">
                <div class="text-center">
                    <h6 style="color: #05264E; margin-bottom: 20px;">Download Our App</h6>
                    <!-- <div class="row">
                        <div class="col-6">
                            <div style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 15px;">
                                <img src="{{ asset('assets/imgs/template/icons/AndroidQR.png') }}" alt="Android QR" style="width: 120px; height: 120px; border-radius: 10px;">
                                <p style="color: #242b62; font-weight: 600; margin-top: 10px; margin-bottom: 5px;">Android App</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="background: white;  border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 15px;">
                                <img src="{{ asset('assets/imgs/template/icons/IOSQR.png') }}" alt="iOS QR" style="width: 120px; height: 120px; border-radius: 10px;">
                                <p style="color: #242b62; font-weight: 600; margin-top: 10px; margin-bottom: 5px;">iOS App</p>
                            </div>
                        </div>
                    </div> -->
                    <div class="row d-flex justify-content-center">
                        {{-- <div class="col-6">
                            <div style="
                                background: linear-gradient(135deg, #ffffff, #f8f9fa);
                                border-radius: 20px;
                                box-shadow: 0 10px 30px rgba(36, 43, 98, 0.15);
                                margin-bottom: 15px;
                                padding: 20px 15px;
                                text-align: center;
                                border: 2px solid transparent;
                                background-clip: padding-box;
                                position: relative;
                                overflow: hidden;
                                transition: all 0.3s ease;
                            " class="qr-card">
                                <!-- Gradient Border Effect -->
                                <div style="
                                    position: absolute;
                                    top: -2px;
                                    left: -2px;
                                    right: -2px;
                                    bottom: -2px;
                                    background: linear-gradient(45deg, #242b62, #f36825);
                                    border-radius: 22px;
                                    z-index: -1;
                                "></div>
                                
                                <img src="{{ asset('assets/imgs/template/icons/AndroidQR.png') }}" alt="Android QR" 
                                    style="width: 120px; height: 120px; border-radius: 12px; margin-bottom: 10px;">
                                
                                <p style="color: #242b62; font-weight: 700; margin-top: 10px; margin-bottom: 5px; font-size: 16px;">
                                    📱 Android App
                                </p>
                                <p style="color: #f36825; font-size: 12px; margin: 0; font-weight: 600;">
                                    Scan & Download
                                </p>
                            </div>
                        </div> --}}
                        <div class="col-6">
                            <div style="
                                background: linear-gradient(135deg, #ffffff, #f8f9fa);
                                border-radius: 20px;
                                box-shadow: 0 10px 30px rgba(36, 43, 98, 0.15);
                                margin-bottom: 15px;
                                padding: 20px 15px;
                                text-align: center;
                                border: 2px solid transparent;
                                background-clip: padding-box;
                                position: relative;
                                overflow: hidden;
                                transition: all 0.3s ease;
                                 " class="qr-card">
                                <!-- Gradient Border Effect -->
                                <div style="
                                    position: absolute;
                                    top: -2px;
                                    left: -2px;
                                    right: -2px;
                                    bottom: -2px;
                                    background: linear-gradient(45deg, #f36825, #242b62);
                                    border-radius: 22px;
                                    z-index: -1;
                                "></div>
                                
                                <img src="{{ asset('assets/imgs/template/icons/download-app.jpeg') }}" alt="iOS QR" 
                                    style="width: 120px; height: 120px; border-radius: 12px; margin-bottom: 10px;">
                                
                                <p style="color: #242b62; font-weight: 700; margin-top: 10px; margin-bottom: 5px; font-size: 16px;">
                                    📱Android & iOS App
                                </p>
                                <p style="color: #f36825; font-size: 12px; margin: 0; font-weight: 600;">
                                    Scan & Download
                                </p>
                            </div>
                        </div>
                    </div>

                    <style>
                    .qr-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 15px 40px rgba(36, 43, 98, 0.25);
                    }
                    </style>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom" style="border-top: 1px solid #05264E; padding-top: 20px;">
            <div class="row">
                <div class="col-md-6">
                    <span class="font-xs">
                        © <script>document.write(new Date().getFullYear());</script> Zobpot All Rights Reserved. 
                        Designed and developed by 
                        {{-- <a href="https://ivinfotech.com/" target="_blank" style="color: #f36825;">IV Infotech.</a> --}}
                        <a href="javascript:void(0)" style="color: #f36825;">Zobpot.</a>
                    </span>
                </div>
                <div class="col-md-6 text-md-end text-start">
                    <div class="footer-social">
                        <a class="font-xs color-text-paragraph" href="{{ route('privacy-policy') }}">Privacy Policy</a>
                        <a class="font-xs color-text-paragraph mr-30 ml-30" href="{{ route('term-and-conditions') }}">Terms & Conditions</a>
                        <a class="font-xs color-text-paragraph" href="#">Security</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.social-icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
    text-align: center;
    line-height: 40px;
    transition: all 0.3s ease;
}

.social-icon:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(36, 43, 98, 0.3);
}

.menu-footer li {
    margin-bottom: 10px;
}

.menu-footer li a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.menu-footer li a:hover {
    color: #f36825;
}
</style>


      {{-- Delete Modal --}}
      <div class="modal fade" id="DeleteItemModal" data-bs-backdrop="static" data-bs-keyboard="false"
          tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-lg-12 col-md-12 col-12 mb-3" style="text-align: center;">
                              <img src="{{ asset('assets/imgs/delete-img.png') }}" alt="Delete"
                                  style="max-width: 40%;">
                          </div>
                          <div class="col-lg-12 col-md-12 col-12 mb-3" style="text-align: center;">
                              <h5 id="DeleteTitle"></h5>
                          </div>
                          <div class="col-lg-12 col-md-12 col-12" style="text-align: center;">
                              <input type="hidden" id="delete_id" name="delete_id">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" id="DeleteConfirmBtn"></button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      {{-- Success Modal --}}
      <div class="modal fade" id="SuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-lg-12 col-md-12 col-12 mb-3" style="text-align: center;">
                              <img id="SuccessImage" src="{{ asset('assets/imgs/sucess-img.png') }}"
                                  alt="Success Image" style="max-width: 40%;">
                          </div>
                          <div class="col-lg-12 col-md-12 col-12 mb-3" style="text-align: center;">
                              <h5 id="SuccessTitle"></h5>
                          </div>
                          <div class="col-lg-12 col-md-12 col-12" style="text-align: center;">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      {{-- Error Modal --}}
      <div class="modal fade" id="ErrorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-lg-12 col-md-12 col-12 mb-3" style="text-align: center;">
                              <img id="ErrorImage" src="{{ asset('assets/imgs/error-img.png') }}" alt="Error Image"
                                  style="max-width: 40%;">
                          </div>
                          <div class="col-lg-12 col-md-12 col-12 mb-3" style="text-align: center;">
                              <h5 id="ErrorTitle"></h5>
                          </div>
                          <div class="col-lg-12 col-md-12 col-12" style="text-align: center;">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
      <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
      <script src="{{ asset('assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
      <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/waypoints.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/wow.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/isotope.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/scrollup.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}"></script>
      <script src="{{ asset('assets/js/plugins/counterup.js') }}"></script>
      <script src="{{ asset('assets/js/main8c94.js?v=4.1') }}"></script>


      {{-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1/.11.0/jquery.validate.min.js"></script>
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.js"></script> --}}
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.min.js"></script>


      <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>


      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      @stack('script')

      <script>
          function setupLoadMore(buttonId, itemClass) {
    const items = document.querySelectorAll(itemClass);
    let visibleCount = 12;

    document.getElementById(buttonId).addEventListener('click', function () {
        let nextItems = Array.from(items).slice(visibleCount, visibleCount + 12);
        nextItems.forEach(item => item.style.display = 'block');
        visibleCount += 12;

        if (visibleCount >= items.length) {
            this.style.display = 'none'; // hide button
        }
    });
}

setupLoadMore('loadMoreBtnSkill', '.category-item-skill');
setupLoadMore('loadMoreBtnNonSkill', '.category-item-nonskill');


          sessionStorage.setItem('job_category_id', '');

          sessionStorage.setItem('job_category', '');
          sessionStorage.setItem('job_location', '');
          sessionStorage.setItem('job_title', '');


          $(document).ready(function() {
              // Load last active tab from localStorage
              const activeTab = localStorage.getItem('lastActiveTab');
              if (activeTab) {
                  $('a[href="' + activeTab + '"]').tab('show');
              }

              // Save active tab to localStorage on tab change
              $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                  const tabId = $(e.target).attr('href');
                  localStorage.setItem('lastActiveTab', tabId);
              });
          });


          // THE VALIDATION SCRIPT USE FOR ONLY ENTER NUMERIC VALUE IN AMOUNT.
          function isNumber(evt) {
              var iKeyCode = (evt.which) ? evt.which : evt.keyCode
              if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
                  return false;
              } else {
                  return true;
              }
          }

          // THE VALIDATION SCRIPT USE FOR ONLY ENTER LETTERS.
          function SpecialCharNotAllow(evt) {
              var iKeyCode = (evt.which) ? evt.which : evt.keyCode
              if ((iKeyCode > 64 && iKeyCode < 91) || (iKeyCode > 96 && iKeyCode < 123) || iKeyCode == 8 || iKeyCode ==
                  32 || (iKeyCode >= 48 && iKeyCode <= 57)) {
                  return true;
              } else {
                  return false;
              }
          }

          $(document).ready(function() {
              $('#category_id').on('change', function() {
                  let category_id = $("#category_id").val();


                  if (!category_id) return;

                  // Prepare request data
                  let data = {
                      category_id: category_id
                  };

                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $.ajax({
                      type: "POST",
                      url: "{{ route('sub-category-action') }}",
                      data: data,
                      dataType: "json",
                      success: function(response) {
                          if (response.status === 1) {

                              let subcategory = response.data;

                              console.log(subcategory);

                              // Start with default option (corrected quotes)
                              let optionHtml = `<option value="">Select Sub Category</option>`;

                              // Append subcategory options
                              subcategory.forEach(val => {
                                  optionHtml +=
                                      `<option value="${val.sub_category_id}">${val.sub_category_nm}</option>`;
                              });

                              // Populate dropdown
                              $("#sub_category_id").html(optionHtml);
                          } else {
                              console.log(response.message);
                              $("#sub_category_id").html(
                                  `<option value="">No Sub Category Found</option>`);
                          }
                      },
                      error: function() {
                          toastr.error("Something went wrong while fetching sub categories.",
                              "Error");
                      }
                  });
              });

              $('#sub_category_id').on('change', function() {
                  let category_id = $("#category_id").val();
                  let sub_category_id = $("#sub_category_id").val();

                  $('#multiSelectDropdown').html("");
                  $("#multiSelectBtn").html("<span class='placeholder'>Choose Skills</span>");

                  if (!sub_category_id) return;

                  // Prepare request data
                  let data = {
                      sub_category_id: sub_category_id,
                      category_id: category_id
                  };

                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });

                  $.ajax({
                      type: "POST",
                      url: "{{ route('skill-fetch-action') }}",
                      data: data,
                      dataType: "json",
                      success: function(response) {
                          if (response.status === 1) {

                              let skillData = response.data;

                              skillData.forEach(item => {
                                  if (item.skill_nm) {
                                      let skills = item.skill_nm.split(',');
                                      window.skills_arr = skills;

                                      console.log(skills_arr);
                                  }
                              });
                          } else {
                              console.log(response.message);
                          }
                      },
                      error: function() {
                          toastr.error("Something went wrong while fetching Skills.",
                              "Error");
                      }
                  });
              });
          });


          function SuccessMsg(title) {
              // $("#SuccessImage").attr("src", img);
              $("#SuccessTitle").text(title);
              $("#SuccessModal").modal("show");
          }

          function ErrorMsg(title) {
              // $("#ErrorImage").attr("src", img);
              $("#ErrorTitle").text(title);
              $("#ErrorModal").modal("show");
          }

          function LoaderShow() {
              document.getElementById("preloader-active").style.display = "block"
          }

          function LoaderHide() {
              document.getElementById("preloader-active").style.display = "none"
          }

          //set active menu
          function setActive() {
              $(".main-menu a").removeClass("active");
              $(".main-menu a#" + page_active_id).addClass("active");
          }

          setActive();

          function compress(src, cmp_value, img_type, img_width, img_height) {
              img_type = 'image/webp';
              var r = document.createElement("canvas");
              //orignal image size
              //  (r.width = t.naturalWidth), (r.height = t.naturalHeight);
              (r.width = img_width), (r.height = img_height);
              //var o = (r.getContext("2d").drawImage(t, 0, 0), r.toDataURL(a, e / 100)),s = new Image();
              var o = (r.getContext("2d").drawImage(src, 0, 0, img_width, img_height), r.toDataURL(img_type, cmp_value /
                      100)),
                  s = new Image();
              return (s.src = o), s;
          }

          function compress_org(src, cmp_value, img_type) {
              img_type = 'image/webp';
              var r = document.createElement("canvas");
              //orignal image size
              (r.width = src.naturalWidth), (r.height = src.naturalHeight);
              var o = (r.getContext("2d").drawImage(src, 0, 0), r.toDataURL(img_type, cmp_value / 100)),
                  s = new Image();
              return (s.src = o), s;
          }
      </script>

      <script>
          function SelectAreaBo(areaId, areaName) {
              // Set the selected area name in the visible input
              $('#area_id').val(areaName);

              // Set the selected area ID in the hidden input
              $('#area_id_hidden').val(areaId);

              // Optionally, you can hide suggestions or add visual feedback here
              $('#AreaSuggestBox').empty(); // Clears badges if needed
          }


          document.addEventListener("DOMContentLoaded", function() {
              const zipcodeInput = document.getElementById("zipcode");

              // Trigger on 'change' or 'Enter key press'
              zipcodeInput.addEventListener("change", handleZipcodeLookup);
              zipcodeInput.addEventListener("keypress", function(e) {
                  if (e.key === "Enter") {
                      e.preventDefault(); // Prevent form submit if inside a form
                      handleZipcodeLookup();
                  }
              });

              function handleZipcodeLookup() {
                  $("#state_id_hidden").val("");
                  $("#state_id").val("");

                  $("#city_id_hidden").val("");
                  $("#city_id").val("");

                  $("#area_id_hidden").val("");
                  $("#area_id").val("");

                //   $("#pincode_id_hidden").val("");
                //   $("#zipcode").val("");

                  const zipcode = zipcodeInput.value.trim();

                  const data = {
                      zipcode: zipcode
                  };

                  const url = "{{ route('check-location') }}"; // ✅ Correct usage

                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                              'content')
                      }
                  });

                  $.ajax({
                      type: "POST",
                      url: url,
                      data: data,
                      success: function(response) {
                          console.log(response);
                          if (response.status === true) {
                              var location = response.data;
                              var areas = response.areas;

                              var AreaSuggestBadge = ''
                              areas.forEach(val => {
                                  AreaSuggestBadge += `<span class="badge-item me-1 mb-1"
                                onclick="SelectAreaBo(${val.area_id}, '${val.area_nm}')">
                            ${val.area_nm}
                         </span>`;
                              });

                              $("#AreaSuggestBox").append(AreaSuggestBadge);

                              $("#state_id_hidden").val(location.state_id);
                              $("#state_id").val(location.state_name);

                              $("#city_id_hidden").val(location.city_id);
                              $("#city_id").val(location.city_nm);

                              $("#area_id_hidden").val(location.area_id);
                              $("#area_id").val(location.area_nm);

                              $("#pincode_id_hidden").val(location.zipcode_id);
                              $("#zipcode").val(location.zipcode);

                          }
                      },
                      error: function(xhr) {
                          console.error(xhr.responseText);
                          let errorMsg = "Something went wrong";
                          try {
                              const res = JSON.parse(xhr.responseText);
                              errorMsg = res.message || errorMsg;
                          } catch (e) {}
                          alert(errorMsg);
                      }
                  });
              }
          });
   



    </script>
   
    @stack('scripts')

  </body>

  </html>
