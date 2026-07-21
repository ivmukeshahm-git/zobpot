@extends('website.layout.layout')
@section('website-content')
<main class="main">
    <section class="pt-50 login-register">
        <div class="container">
            <div class="row login-register-cover">
                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">

                    <div class="text-center">
                        <h2 class="mt-10 mb-5 text-brand-1">Forget Password</h2>
                        <p class="font-sm text-muted mb-30">Reset your password using mobile OTP.</p>
                    </div>

                    {{-- STEP 1: ENTER PHONE --}}
                    <div id="step1">
                        <form id="step1Form">

                            <label class="form-label">Mobile Number <span style="color:red">*</span></label>
                            <input class="form-control" id="phone" name="phone" type="text" maxlength="10"
                                   onkeypress="return isNumber(event);" placeholder="Enter mobile number">

                            <div class="form-group mt-3">
                                <button class="btn btn-brand-1 hover-up w-100" type="submit">Send OTP</button>
                            </div>

                            <div class="login_footer form-group d-flex justify-content-between">
                                <a class="text-muted" href="{{ route('login') }}">Login</a>
                            </div>

                        </form>
                    </div>


                    {{-- STEP 2: VERIFY OTP --}}
                    <div id="step2" style="display:none;">

                        <form id="step2Form">
                            <input type="hidden" id="user_id">

                            <label class="form-label">Enter OTP</label>
                            <input class="form-control" id="otp" type="text" maxlength="6" placeholder="Enter OTP">

                            <button class="btn btn-brand-1 hover-up w-100 mt-3" type="submit">Verify OTP</button>

                            <a href="javascript:void(0)" id="resendOtp" class="text-muted mt-3 d-block">Resend OTP</a>
                        </form>

                    </div>


                    {{-- STEP 3: NEW PASSWORD --}}
                    <div id="step3" style="display:none;">

                        <form id="step3Form">
                            <input type="hidden" id="user_id2">

                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password">
                                <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword1">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>

                            <label class="form-label mt-3">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation">
                                <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword2">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>

                            <button class="btn btn-brand-1 hover-up w-100 mt-3" type="submit">
                                Reset Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>


@push('script')
<script>
let timerInterval;

// GLOBAL Swal ERROR (center)
function showError(msg) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: msg,
        confirmButtonText: 'OK'
    });
}

// GLOBAL Swal SUCCESS (center)
function showSuccess(msg) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: msg,
        confirmButtonText: 'OK'
    });
}

/***************************
 STEP 1 → SEND OTP
****************************/
$("#step1Form").submit(function(e){
    e.preventDefault();

    $.post("{{ route('forget.password.post') }}", {
        phone: $("#phone").val(),
        _token: "{{ csrf_token() }}"
    })
    .done(function(res){

        if(res.status === 1){
            showSuccess("OTP Sent Successfully!");

            $("#user_id").val(res.user_id);

            $("#step1").hide();
            $("#step2").show();

            startResendTimer();
        } 
    })
    .fail(function(xhr){

        // Catch validation errors
        if(xhr.responseJSON && xhr.responseJSON.errors){
            let msg = xhr.responseJSON.errors.phone[0];
            showError(msg); // SWEET ALERT POPUP
        } else {
            showError("Something went wrong");
        }

    });
});


/***************************
 STEP 2 → VERIFY OTP
****************************/
$("#step2Form").submit(function(e){
    e.preventDefault();

    $.post("{{ route('forgot.otp.post') }}", {
        user_id: $("#user_id").val(),
        otp: $("#otp").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){

        if(res.status === 1){
            showSuccess("OTP Verified!");

            $("#user_id2").val($("#user_id").val());

            $("#step2").hide();
            $("#step3").show();

            clearInterval(timerInterval);
        } else {
            showError(res.message);
        }
    });
});


/***************************
 RESEND OTP + TIMER
****************************/
function startResendTimer() {
    let remaining = 30;

    $("#resendOtp").text("Resend OTP in 30s");
    $("#resendOtp").css("pointer-events", "none").css("opacity", "0.5");

    timerInterval = setInterval(() => {
        remaining--;
        $("#resendOtp").text("Resend OTP in " + remaining + "s");

        if (remaining <= 0) {
            clearInterval(timerInterval);
            $("#resendOtp").text("Resend OTP");
            $("#resendOtp").css("pointer-events", "auto").css("opacity", "1");
        }
    }, 1000);
}

$("#resendOtp").click(function(){

    $.post("{{ route('forgot.otp.resend') }}", {
        user_id: $("#user_id").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){

        if(res.status === 1){
            showSuccess("OTP Resent");
            startResendTimer();
        } else {
            showError(res.message);
        }
    });
});


/***************************
 STEP 3 → RESET PASSWORD
****************************/
$("#step3Form").submit(function(e){
    e.preventDefault();

    $.post("{{ route('forgot.password.save') }}", {
        user_id: $("#user_id2").val(),
        password: $("#password").val(),
        password_confirmation: $("#password_confirmation").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){

        if(res.status === 1){

            Swal.fire({
                icon: 'success',
                title: "Password Changed!",
                text: "Login with your new password",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "{{ route('login') }}";
            });

        } else {
            showError(res.message);
        }

    });
});
function togglePassword(inputId, toggleBtnId) {
    document.getElementById(toggleBtnId).addEventListener("click", function(){
        const field = document.getElementById(inputId);
        const icon = this.querySelector("i");

        field.type = field.type === "password" ? "text" : "password";
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
    });
}

togglePassword("password", "togglePassword1");
togglePassword("password_confirmation", "togglePassword2");

</script>

<!-- <script>
/***************************
 STEP 1 → SEND OTP
****************************/
$("#step1Form").submit(function(e){
    e.preventDefault();

    $.post("{{ route('forget.password.post') }}", {
        phone: $("#phone").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){

        if(res.status === 1){
            $("#user_id").val(res.user_id);

            $("#step1").hide();
            $("#step2").show();
        } else {
            alert(res.message);
        }
    });
});


/***************************
 STEP 2 → VERIFY OTP
****************************/
$("#step2Form").submit(function(e){
    e.preventDefault();

    $.post("{{ route('forgot.otp.post') }}", {
        user_id: $("#user_id").val(),
        otp: $("#otp").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){

        if(res.status === 1){
            $("#user_id2").val($("#user_id").val());

            $("#step2").hide();
            $("#step3").show();
        } else {
            alert(res.message);
        }
    });
});


/***************************
 RESEND OTP
****************************/
$("#resendOtp").click(function(){
    $.post("{{ route('forgot.otp.resend') }}", {
        user_id: $("#user_id").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){
        alert(res.message);
    });
});


/***************************
 STEP 3 → RESET PASSWORD
****************************/
$("#step3Form").submit(function(e){
    e.preventDefault();

    $.post("{{ route('forgot.password.save') }}", {
        user_id: $("#user_id2").val(),
        password: $("#password").val(),
        password_confirmation: $("#password_confirmation").val(),
        _token: "{{ csrf_token() }}"
    }, function(res){

        if(res.status === 1){
            alert("Password changed successfully!");
            window.location.href = "{{ route('login') }}";
        } else {
            alert(res.message);
        }

    });
});
</script> -->
@endpush
@endsection
