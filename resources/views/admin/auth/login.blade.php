  @php
      $Setting = App\Models\Setting::where('id', 1)->first();
  @endphp

  <!doctype html>

  <html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
      data-assets-path="{{ asset('admin-assets') }}/" data-template="vertical-menu-template" data-style="light">

  <head>
      <meta charset="utf-8" />
      <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>Zobpot - Admin Login</title>

      <meta name="description" content="" />

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
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/rtl/theme-default.css') }}"
          class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{ asset('admin-assets/css/demo.css') }}" />

      <!-- Vendors CSS -->
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/typeahead-js/typeahead.css') }}" />
      <!-- Vendor -->
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/@form-validation/form-validation.css') }}" />

      <!-- Page CSS -->
      <!-- Page -->
      <link rel="stylesheet" href="{{ asset('admin-assets/vendor/css/pages/page-auth.css') }}" />

      <!-- Helpers -->
      <script src="{{ asset('admin-assets/vendor/js/helpers.js') }}"></script>

      <script src="{{ asset('admin-assets/vendor/js/template-customizer.js') }}"></script>

      <script src="{{ asset('admin-assets/js/config.js') }}"></script>
  </head>
  <style>
      .card-layout {
          background-color: #000000bd;
      }

      .authentication-wrapper.authentication-basic .authentication-inner:before {
          content: none;
      }

      .light-style .authentication-wrapper.authentication-basic .authentication-inner:after {
          content: none;
      }

      /* Refined Login type toggle styles (card style) */
      :root {
          --card-radius: 12px;
          --card-bg: rgba(255, 255, 255, 0.03);
          --muted: #9aa0c7;
          --text: #e6e9f5;
          --accent-start: #2b2f63;
          --accent-end: #5a56a6;
      }

      /* Container */
      .login-type-toggle {
          display: flex;
          gap: 12px;
      }

      /* Login Boxes */
      .login-card {
          flex: 1;
          /* equal width */
          height: 80px;
          /* same height */
          display: flex;
          align-items: center;
          justify-content: flex-start;
          gap: 12px;
          padding: 16px;
          border-radius: 12px;
          border: 1px solid #cccccc;
          background: #fff;
          cursor: pointer;
          transition: all .25s ease;
      }

      /* Active Box */
      .login-card.active {
          background: linear-gradient(135deg, #5a57d1, #242a62);
          color: #fff;
          border: 2px solid #2d3174;
      }

      /* Icon Box */
      .login-card .icon {
          width: 40px;
          height: 40px;
          border-radius: 10px;
          display: flex;
          align-items: center;
          justify-content: center;
          background: #242a62;
          font-size: 20px;
      }

      /* Check icon */
      .login-card .check {
          position: absolute;
          right: 12px;
          top: 12px;
      }

      /* Ensure position works */
      .login-card {
          position: relative;
      }
  </style>

  <body
      style="background-image: url({{ asset('admin-assets/img/bg.jpg') }});background-size: cover;background-attachment: fixed;background-repeat: no-repeat;">

      <div class="card-layout">
          <div class="container-xxl">
              <div class="authentication-wrapper authentication-basic container-p-y">
                  <div class="authentication-inner">
                      <!-- Register -->
                      <div class="card px-sm-6 px-0">
                          <div class="card-body">
                              <!-- Logo -->
                              <div class="app-brand justify-content-center">
                                  <a href="#" class="app-brand-link gap-2">
                                      <img src="{{ $Setting ?? $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}"
                                          style="max-width: 150px;" alt="Logo">
                                  </a>
                              </div>
                              <!-- /Logo -->
                              <p class="mb-6">Please sign-in to your account and start the adventure</p>
                              @if ($errors->has('email'))
                                  <div class="alert alert-danger">
                                      {{ $errors->first('email') }}
                                  </div>
                              @endif

                              <form id="login-form" class="mb-6" action="{{ route('post-login') }}" method="POST">
                                  @csrf
                                  <input type="hidden" id="login_type" name="login_type" value="Admin">
                                  <div class="mb-5">
                                      <label class="form-label" style="font-weight: 600;">Login As</label>
                                      <div class="login-type-toggle compact d-flex gap-2" role="tablist"
                                          aria-label="Login Type">
                                          <div class="login-card login-box active" data-value="Admin" role="button"
                                              tabindex="0" aria-pressed="true">
                                              <input type="radio" name="login_type_radio" value="Admin" hidden
                                                  checked>
                                              <div class="card-left">
                                                  <div class="icon"><i class="bx bx-user-circle"
                                                          aria-hidden="true"></i></div>
                                              </div>
                                              <div class="card-body">
                                                  <div class="title" style="font-weight: 600;">Admin / Staff</div>
                                              </div>
                                          </div>

                                          <div class="login-card login-box" data-value="College" role="button"
                                              tabindex="0" aria-pressed="false">
                                              <input type="radio" name="login_type_radio" value="College" hidden>
                                              <div class="card-left">
                                                  <div class="icon"><i class="bx bx-building" aria-hidden="true"></i>
                                                  </div>
                                              </div>
                                              <div class="card-body">
                                                  <div class="title" style="font-weight: 600;">College / Staff</div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="mb-6">
                                      <label for="email" class="form-label" id="email_label"
                                          style="font-weight: 600;">Email or Username</label>
                                      <input type="text" class="form-control" id="email" name="email"
                                          placeholder="Enter your email or username" autofocus />
                                  </div>
                                  <div class="mb-6 form-password-toggle">
                                      <label class="form-label" for="password"
                                          style="font-weight: 600;">Password</label>
                                      <div class="input-group input-group-merge">
                                          <input type="password" id="password" class="form-control" name="password"
                                              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                              aria-describedby="password" />
                                          <span class="input-group-text cursor-pointer"><i
                                                  class="bx bx-hide"></i></span>
                                      </div>
                                  </div>
                                  <div class="mb-5">
                                      <div class="d-flex justify-content-between mt-3">
                                          <div class="form-check mb-0 ms-2">
                                              <input class="form-check-input" type="checkbox" id="remember-me" />
                                              <label class="form-check-label" for="remember-me"> Remember Me </label>
                                          </div>
                                          {{-- <a href="auth-forgot-password-basic.html">
                                              <span>Forgot Password?</span>
                                          </a> --}}
                                      </div>
                                  </div>
                                  <div class="mb-6">
                                      <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                                  </div>
                              </form>



                          </div>
                      </div>
                      <!-- /Register -->
                  </div>
              </div>
          </div>
      </div>

      <!-- / Content -->

      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->

      <script src="{{ asset('admin-assets/vendor/libs/jquery/jquery.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/popper/popper.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/js/bootstrap.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/hammer/hammer.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/i18n/i18n.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/js/menu.js') }}"></script>

      <!-- endbuild -->

      <!-- Vendors JS -->
      <script src="{{ asset('admin-assets/vendor/libs/@form-validation/popular.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
      <script src="{{ asset('admin-assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

      <!-- Main JS -->
      <script src="{{ asset('admin-assets/js/main.js') }}"></script>

      <!-- Page JS -->
      <script src="{{ asset('admin-assets/js/pages-auth.js') }}"></script>

      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.js"></script>

      <script>
          let validator = $("#login-form").validate({
              // Validation rules
              rules: {
                  email: {
                      required: true
                  },
                  password: {
                      required: true,
                      // minlength: 6,
                      // maxlength: 6,
                      // digits: true
                  },

              },
              messages: {
                  email: {
                      required: "Please Enter Email Address"
                  },
                  password: {
                      required: "Please Enter Password"
                  },

              },
              errorElement: "div",
              errorPlacement: function(error, element) {
                  error.addClass("invalid-feedback");
                  // console.log(element);

                  error.insertAfter(element);

              },
              highlight: function(element) {
                  $(element).addClass("is-invalid").removeClass("is-valid");
              },
              unhighlight: function(element) {
                  $(element).removeClass("is-invalid");
              }
          });
          // Final submission
          $("#login-form").submit(function(e) {
              if (!$("#login-form").valid()) {
                  e.preventDefault();
              }
          });

          // Switch login type behavior (two-box UI)
          $(function() {
              // initialize based on hidden input
              var initVal = $('#login_type').val() || 'Admin';
              $('.login-card').removeClass('active');
              var $init = $('.login-card[data-value="' + initVal + '"]');
              $init.addClass('active').attr('aria-pressed', 'true').find('input[name="login_type_radio"]').prop(
                  'checked', true);

              // helper to update email label/placeholder
              function updateEmailPlaceholder(val) {
                  if (val === 'College') {
                      $('#email_label').text('College / Staff Email or Phone');
                      $('#email').attr('placeholder', 'Enter college or staff email/phone');
                  } else {
                      $('#email_label').text('Email or Username');
                      $('#email').attr('placeholder', 'Enter your email or username');
                  }
              }
              updateEmailPlaceholder(initVal);

              // click / keyboard handlers with micro-interaction
              $('.login-card').on('click', function() {
                  var $el = $(this);
                  var val = $el.data('value');
                  $('#login_type').val(val);
                  $('.login-card').removeClass('active').attr('aria-pressed', 'false');
                  $el.addClass('active').attr('aria-pressed', 'true');
                  $el.find('input[name="login_type_radio"]').prop('checked', true);
                  updateEmailPlaceholder(val);
                  // micro interaction
                  $el.addClass('touch');
                  setTimeout(function() {
                      $el.removeClass('touch');
                  }, 260);
              }).on('keydown', function(e) {
                  if (e.key === 'Enter' || e.key === ' ') {
                      e.preventDefault();
                      $(this).trigger('click');
                  }
              });
          });
      </script>
  </body>

  </html>
