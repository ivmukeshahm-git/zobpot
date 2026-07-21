@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="pt-50 login-register">
            <div class="container">
                <div class="row login-register-cover">
                    <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                        <div class="text-center">
                            <h2 class="mt-10 mb-5 text-brand-1">Forget Password</h2>
                            <p class="font-sm text-muted mb-30">Login to access thousands job opportunities.</p>

                            @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <form id="reset-password-email-form" class="login-register text-start mt-20"
                            action="{{ route('reset.password.post') }}" method="POST">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label class="form-label" for="email">Email address <span
                                        style="color: red;">*</span></label>
                                <input class="form-control" id="email" type="email" name="email" required
                                    placeholder="example@email.com" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">New Password <span
                                        style="color: red;">*</span></label>
                                <input class="form-control" id="password" type="password" name="password" required
                                    placeholder="Enter new password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Confirm New Password <span
                                        style="color: red;">*</span></label>
                                <input class="form-control" id="password_confirmation" type="password"
                                    name="password_confirmation" required placeholder="Re-enter new password">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="login_footer form-group d-flex justify-content-between">
                                <a class="text-muted" href="{{ route('login') }}">Login</a>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-brand-1 hover-up w-100" type="submit">Reset Password</button>
                            </div>

                            <div class="text-muted text-center">
                                Don't have an account?
                                <a href="{{ route('emp-type', ['login_type' => 'register']) }}">Sign up</a>
                            </div>
                        </form>


                    </div>
                    <div class="img-1 d-none d-lg-block"><img class="shape-1"
                            src="{{ asset('assets/imgs/page/login-register/img-4.svg') }}" alt="JobBox"></div>
                    <div class="img-2"><img src="{{ asset('assets/imgs/page/login-register/img-3.svg') }}" alt="JobBox">
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('script')
        <script>
            let validator = $("#reset-password-email-form").validate({
                // Validation rules
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password" // Must match password field
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter a new password",
                        minlength: "Password must be at least 6 characters"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                }
            });

            // Final submission
            $("#reset-password-email-form").submit(function(e) {
                if (!$("#reset-password-email-form").valid()) {
                    if (!$(this).valid()) {
                        e.preventDefault(); // prevent submit if invalid
                    } else {
                        LoaderShow(); // show loader if form is valid
                    }
                }
            });
        </script>
    @endpush
@endsection
