@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="pt-50 login-register">
            <div class="container">
                <form id="otpForm" onsubmit="return false;">
                    <div class="row pb-50">
                        <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                            <div class="text-center">
                                <p class="font-sm text-brand-2">OTP Verification </p>
                                <h3 class="mt-10 mb-5 text-brand-1">We’ve sent a 6-digit verification code to your registered email/phone number.</h3>
                                <p class="font-sm text-muted mb-30">Please enter it below to continue.</p>

                                <h5 class="mb-5 d-none" id="ViewOtp">OTP - {{ $user->otp }}</h5>
                            </div>
                            <div id="OtpResendSendMsg">

                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                    <div class="otp-box mb-4">
                                        <input type="text" class="form-control otp-input" id="otp1" name="otp1"
                                            maxlength="1" required>
                                        <input type="text" class="form-control otp-input" id="otp2" name="otp2"
                                            maxlength="1" required>
                                        <input type="text" class="form-control otp-input" id="otp3" name="otp3"
                                            maxlength="1" required>
                                        <input type="text" class="form-control otp-input" id="otp4" name="otp4"
                                            maxlength="1" required>
                                        <input type="text" class="form-control otp-input" id="otp5" name="otp5"
                                            maxlength="1" required>
                                        <input type="text" class="form-control otp-input" id="otp6" name="otp6"
                                            maxlength="1" required>

                                        <input type="hidden" id="otp" name="otp">
                                        <input type="hidden" id="email" name="email" value="{{ $user->email }}">

                                    </div>
                                    <input type="hidden" id="_method" name="_method" value="POST">

                                </div>

                                <p class="mt-3 mb-4 text-center" id="resend-section">
                                    Didn’t receive the code?
                                    <span id="countdown" style="color: gray;">Resend in 60s</span>
                                    <a href="#" id="resendBtn" style="display: none;">Resend
                                        OTP</a>

                                    <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                                </p>
                            </div>



                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                    <button class="btn btn-brand-1 hover-up w-100" type="submit">Verify OTP</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script>
        let timer = 60;
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        function startCountdown() {
            countdownEl.style.display = 'inline';
            resendBtn.style.display = 'none';

            const countdown = setInterval(() => {
                timer--;
                countdownEl.textContent = `Resend in ${timer}s`;

                if (timer <= 0) {
                    clearInterval(countdown);
                    countdownEl.style.display = 'none';
                    resendBtn.style.display = 'inline';
                    resendBtn.classList.remove('disabled');
                }
            }, 1000);
        }

        // Call on page load or after sending OTP
        startCountdown();

        // Optional: Handle resend button click
        resendBtn.addEventListener('click', function(e) {
            e.preventDefault();
            resendBtn.classList.add('disabled');
            resendBtn.style.display = 'none';
            timer = 60;
            startCountdown();

            // You can add your actual OTP resend logic here (API call, etc.)
            ResendOtp()
        });


        function ResendOtp() {
            var user_id = $("#user_id").val();

            var data = {
                user_id: user_id
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            var url = "{{ route('resend-action') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: data, // Send as standard form data (not JSON)
                success: function(response) {
                    LoaderHide();

                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });

                        location.reload();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                    console.log('Something went wrong. Please try again!');
                }
            });
        }



        const inputs = document.querySelectorAll('.otp-input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const otp = Array.from(inputs).map(input => input.value).join('');
            $("#otp").val(otp);
            // Add your verification logic here
        });

        let validator = $("#otpForm").validate({
            rules: {
                otp1: {
                    required: true
                },
                otp2: {
                    required: true
                },
                otp3: {
                    required: true
                },
                otp4: {
                    required: true
                },
                otp5: {
                    required: true
                },
                otp6: {
                    required: true
                },
            },
            messages: {
                otp1: {
                    required: "Please Enter Otp"
                },
                otp2: {
                    required: "Please Enter Otp"
                },
                otp3: {
                    required: "Please Enter Otp"
                },
                otp4: {
                    required: "Please Enter Otp"
                },
                otp5: {
                    required: "Please Enter Otp"
                },
                otp6: {
                    required: "Please Enter Otp"
                },
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
                $(element).removeClass("is-invalid");
            }
        });

        // ✅ Final submission with AJAX
        $("#otpForm").submit(function(e) {
            e.preventDefault();

            if (!$("#otpForm").valid()) {
                return;
            }

            let form = $(this);
            // let url = form.attr('action');
            let formData = form.serialize(); // Use FormData for file uploads

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();


            var url = "{{ route('otp-verify-action') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        var data = response.data;

                        let pricingUrl = "{{ route('pricing', ['user_id' => '__USER_ID__']) }}";

                        // Replace the placeholder with the actual JS variable
                        pricingUrl = pricingUrl.replace('__USER_ID__', data.id);

                        // Redirect based on condition
                        if (data.active_plan_id == null || data.active_plan_id == '0') {
                            window.location.href = pricingUrl;
                        } else {
                            window.location.href = "{{ route('emp-type', ['login_type' => 'login']) }}";
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                    console.log(xhr.responseText);
                    // toastr.error(response.message, 'Error');
                    console.log(response.message);
                }
            });
        });
    </script>
@endpush
