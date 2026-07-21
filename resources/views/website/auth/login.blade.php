@extends('website.layout.layout')
@section('website-content')
<style>
.cb-container .checkmark:after {
    content: "✔";
    position: absolute;
    color: #fff;
    font-size: 14px;
    display: none !important;  /* default hide */
    justify-content: center;
}
.cb-container input:checked ~ .checkmark:after {
    display: flex !important; /* show only after checked */
}
</style>
    <main class="main">
        <section class="pt-50 login-register">
            <div class="container">
                <div class="row login-register-cover">
                    <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                        <div class="text-center">
                            <h2 class="mt-10 mb-5 text-brand-1">Welcome back!</h2>
                            <p class="font-sm text-muted mb-30">Login to access thousands job opportunities.</p>

                            @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif

                            @if ($errors->has('error'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('error') }}
                                </div>
                            @endif


                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <form id="login-form" class="login-register text-start mt-20" action="{{ route('post-login') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" id="login_type" name="login_type" value="User">
                            <div class="form-group">
                                <label class="form-label" for="input-1">Contact No. / Email Address <span
                                        style="color: red;">*</span></label>
                                <input class="form-control" id="email" type="text" required="" name="email"
                                    placeholder="Enter Contact Or Email Address">
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label class="form-label" for="input-4">Password <span style="color: red;">*</span></label>-->
                            <!--    <input class="form-control" id="password" type="password" required="" name="password"-->
                            <!--        placeholder="************">-->
                            <!--</div>-->
                            <div class="form-group position-relative">
                                <label class="form-label" for="password">Password <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input class="form-control" id="password" type="password" name="password" required placeholder="************">
                                    <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="login_footer form-group d-flex justify-content-between">
                                <label class="cb-container">
                                    <input type="checkbox" id="remember" name="remember"><span class="text-small">Remember me</span><span
                                        class="checkmark"></span>
                                </label><a class="text-muted" href="{{ route('forget-password') }}">Forgot Password</a>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-brand-1 hover-up w-100" type="submit">Login</button>
                            </div>
                            <div class="text-muted text-center">Don't have an Account?
                                 {{-- <a href="{{ route('emp-type', ['login_type' => 'register']) }}">Sign up</a></div> --}}
                                 <a href="{{ route('emp-type', ['login_type' => 'register']) }}">Create An Account</a></div>
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
            let validator = $("#login-form").validate({
                // Validation rules
                rules: {
                    email: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
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
        </script>
        
        <script>
            document.getElementById("togglePassword").addEventListener("click", function() {
                const passwordInput = document.getElementById("password");
                const icon = this.querySelector("i");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });
        </script>
    @endpush
@endsection
