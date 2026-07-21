@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="pt-50 login-register" id="RegisterEmployeeArea1">
            <div class="container">
                <div class="row  pb-50" id="NonSkilledSelectForm">
                    <div class="col-lg-12 col-md-6 col-sm-12 mx-auto">
                        <div class="text-center">
                            <!-- <p class="font-sm text-brand-2">Register </p> -->
                            <h2 class="mt-10 mb-5 text-brand-1">Register Employee</h2>

                        </div>
                        <form id="non-skill-register-form" class="login-register text-start mt-50" onsubmit="return false;">
                            <div id="CompanyRegisterStep1">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full_name">Full Name <span
                                                    style="color: red"><b>*</b></span> </label>
                                            <input class="form-control" id="full_name" type="text" required=""
                                                name="full_name" placeholder="Enter First Name"
                                                onkeypress="return SpecialCharNotAllow(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="input-4">Email </label>
                                            <input class="form-control" id="email" type="email" name="email"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="contact_no">Contact No. <span
                                                    style="color: red"><b>*</b></span></label>
                                            <input class="form-control" id="contact_no" type="text"
                                                onkeypress="return isNumber(event);" maxlength="10" minlength="10" required=""
                                                name="contact_no" placeholder="Enter Contact No.">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="input-5">Pincode </label>
                                            <input class="form-control" id="zipcode" type="text" name="zipcode"
                                                placeholder="Enter Zipcode" autocomplete="off" autocorrect="off"
                                                autocapitalize="off">

                                            <div id="Pincodesuggestions" class="suggestions"></div>
                                            <input type="hidden" name="pincode_id_hidden" id="pincode_id_hidden">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="input-5">State </label>
                                            <input class="form-control" id="state_id" type="text" name="state_id"
                                                placeholder="Enter State" autocomplete="off" autocorrect="off"
                                                autocapitalize="off">

                                            <div id="Statesuggestions" class="suggestions"></div>
                                            <input type="hidden" name="state_id_hidden" id="state_id_hidden">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="city_id">District / City</label>
                                            <input class="form-control" id="city_id" type="text" name="city_id"
                                                placeholder="Enter District / City" autocomplete="off" autocorrect="off"
                                                autocapitalize="off">

                                            <div id="Citysuggestions" class="suggestions"></div>
                                            <input type="hidden" name="city_id_hidden" id="city_id_hidden">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="area_id">Area / Village </label>
                                            <input class="form-control" id="area_id" type="text" name="area_id"
                                                placeholder="Enter Area" autocomplete="off" autocorrect="off"
                                                autocapitalize="off">

                                            <div class="selected_area mt-2" id="AreaSuggestBox">

                                            </div>

                                            <div id="Areasuggestions" class="suggestions"></div>
                                            <input type="hidden" name="area_id_hidden" id="area_id_hidden">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group position-relative">
                                        <label class="form-label" for="password">Password <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="password" type="password" name="password" required placeholder="************">
                                            <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                        <!--<div class="form-group">-->
                                        <!--    <label class="form-label" for="password">Password <span-->
                                        <!--            style="color: red"><b>*</b></span></label>-->
                                        <!--    <input class="form-control" id="password" type="password" required=""-->
                                        <!--        name="password" placeholder="Enter Password">-->
                                        <!--</div>-->
                                    </div>

                                    <div class="col-lg-6">
                                          <div class="form-group position-relative">
                                        <label class="form-label" for="confirm_password">Confirm Password <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="confirm_password" type="password" name="confirm_password" required placeholder="************">
                                            <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword2">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                        <!--<div class="form-group">-->
                                        <!--    <label class="form-label" for="input-5">Confirm Password <span-->
                                        <!--            style="color: red"><b>*</b></span></label>-->
                                        <!--    <input class="form-control" id="confirm_password" type="password"-->
                                        <!--        required="" name="confirm_password" placeholder="Confirm Password">-->
                                        <!--</div>-->
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="address">Address</label>
                                            <input class="form-control" id="address" type="text" name="address"
                                                placeholder="Enter Address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-30">
                                <div class="col-lg-12 mx-auto text-center">
                                    <a class="btn btn-brand-1 hover-up"
                                        href="{{ route('preference', ['login_type' => 'register', 'type' => 'employee']) }}">Back</a>
                                    <input type="hidden" id="preference_type" name="preference_type" value="2">
                                    <input type="hidden" id="_method" name="_method" value="POST">

                                    <input type="hidden" id="profile_type" name="profile_type" value="Employee">
                                    <button class="btn btn-brand-1 hover-up" type="submit">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('script')
    <script>
        const states = @json($states); // contains [{ state_id: 1, state_name: "Rajasthan" }, ...]
        var cities = [];
        var areas = [];
        var pincodes = [];


        const StateSelect = document.getElementById('state_id');
        const suggestionsBox = document.getElementById('Statesuggestions');
        const stateIdhidden = document.getElementById('state_id_hidden');


        StateSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            suggestionsBox.innerHTML = '';

            if (query.length === 0) {
                suggestionsBox.style.display = 'none';
                return;
            }

            const filteredStates = states.filter(state =>
                state.state_name.toLowerCase().includes(query)
            );

            if (filteredStates.length > 0) {
                suggestionsBox.style.display = 'block';
                filteredStates.forEach(state => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = state.state_name;
                    div.addEventListener('click', () => {
                        StateSelect.value = state.state_name;
                        stateIdhidden.value = state.state_id;
                        suggestionsBox.innerHTML = '';
                        suggestionsBox.style.display = 'none';

                        var data = {
                            'state_id': state.state_id
                        }

                        let url = "{{ route('city-fetch-action') }}";

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
                                    window.cities = response.data;


                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
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
                    });
                    suggestionsBox.appendChild(div);
                });
            } else {
                suggestionsBox.style.display = 'none';
            }

            // Reset state_id on every input (if user types manually)
            stateIdhidden.value = '';
        });



        const CitySelect = document.getElementById('city_id'); // Text input
        const CitysuggestionsBox = document.getElementById('Citysuggestions'); // Suggestion box
        const CityIdhidden = document.getElementById('city_id_hidden'); // Hidden input for selected city_id


        CitySelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            CitysuggestionsBox.innerHTML = '';

            if (query.length === 0) {
                CitysuggestionsBox.style.display = 'none';
                return;
            }

            const filteredCities = cities.filter(city =>
                city.city_nm.toLowerCase().includes(query)
            );

            if (filteredCities.length > 0) {
                CitysuggestionsBox.style.display = 'block';
                filteredCities.forEach(city => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = city.city_nm;
                    div.addEventListener('click', () => {
                        CitySelect.value = city.city_nm;
                        CityIdhidden.value = city.city_id;
                        CitysuggestionsBox.innerHTML = '';
                        CitysuggestionsBox.style.display = 'none';

                        var state_id = $("#state_id_hidden").val();

                        var data = {
                            'state_id': state_id,
                            'city_id': city.city_id,
                        }

                        let url = "{{ route('area-fetch-action') }}";

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
                                    window.areas = response.data;
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
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
                    });
                    CitysuggestionsBox.appendChild(div);
                });
            } else {
                CitysuggestionsBox.style.display = 'none';
            }

            // Reset city_id if user types manually
            CityIdhidden.value = '';
        });


        const AreaSelect = document.getElementById('area_id'); // Text input
        const AreasuggestionsBox = document.getElementById('Areasuggestions'); // Suggestion box
        const AreaIdhidden = document.getElementById('area_id_hidden'); // Hidden input for selected city_id


        AreaSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            AreasuggestionsBox.innerHTML = '';

            if (query.length === 0) {
                AreasuggestionsBox.style.display = 'none';
                return;
            }

            const filteredAreas = areas.filter(area =>
                area.area_nm.toLowerCase().includes(query)
            );

            if (filteredAreas.length > 0) {
                AreasuggestionsBox.style.display = 'block';
                filteredAreas.forEach(area => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = area.area_nm;
                    div.addEventListener('click', () => {
                        AreaSelect.value = area.area_nm;
                        AreaIdhidden.value = area.area_id;
                        AreasuggestionsBox.innerHTML = '';
                        AreasuggestionsBox.style.display = 'none';

                        var state_id = $("#state_id_hidden").val();
                        var city_id = $("#city_id_hidden").val();

                        var data = {
                            'state_id': state_id,
                            'city_id': city_id,
                            'area_id': area.area_id
                        }

                        let url = "{{ route('pincode-fetch-action') }}";

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
                                    window.pincodes = response.data;
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
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
                    });
                    AreasuggestionsBox.appendChild(div);
                });
            } else {
                AreasuggestionsBox.style.display = 'none';
            }

            // Reset city_id if user types manually
            AreaIdhidden.value = '';
        });


        const PincodeSelect = document.getElementById('zipcode'); // Text input
        const PincodeSuggestionsBox = document.getElementById('Pincodesuggestions'); // Suggestion box
        const PincodeIdHidden = document.getElementById('pincode_id_hidden'); // Hidden input
        const AreaSuggestBox = document.getElementById('AreaSuggestBox'); // Area suggestion box

        // Prevent form submission on Enter key in pincode field
        PincodeSelect.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                return false;
            }
        });

        PincodeSelect.addEventListener('input', function() {
            const query = this.value.trim();
            PincodeSuggestionsBox.innerHTML = '';
            AreaSuggestBox.innerHTML = ''; // Clear previous area suggestions

            if (query.length === 0 || !Array.isArray(window.pincodes)) {
                PincodeSuggestionsBox.style.display = 'none';
                return;
            }

            const filteredPincodes = pincodes.filter(pincode =>
                pincode.zipcode.includes(query)
            );

            if (filteredPincodes.length > 0) {
                PincodeSuggestionsBox.style.display = 'block';
                filteredPincodes.forEach(pincode => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = pincode.zipcode;
                    div.addEventListener('click', () => {
                        PincodeSelect.value = pincode.zipcode;
                        PincodeIdHidden.value = pincode.zipcode_id;
                        PincodeSuggestionsBox.innerHTML = '';
                        PincodeSuggestionsBox.style.display = 'none';
                        
                        // Clear area suggestions when pincode is selected
                        AreaSuggestBox.innerHTML = '';
                        
                        // Load areas for selected pincode
                        loadAreasForPincode(pincode.zipcode_id);
                    });
                    PincodeSuggestionsBox.appendChild(div);
                });
            } else {
                PincodeSuggestionsBox.style.display = 'none';
            }

            // Reset hidden ID on manual input
            PincodeIdHidden.value = '';
        });

        // Function to load areas for selected pincode
        function loadAreasForPincode(pincodeId) {
            AreaSuggestBox.innerHTML = ''; // Clear before loading new data
            
            var data = {
                'pincode_id': pincodeId,
                'state_id': $("#state_id_hidden").val(),
                'city_id': $("#city_id_hidden").val(),
                'area_id': $("#area_id_hidden").val()
            };

            // Add your AJAX call here if needed to fetch areas based on pincode
            // For now, just clearing the suggestion box
        }

        // Optional: hide suggestions when clicked outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.autocomplete-container')) {
                PincodeSuggestionsBox.innerHTML = '';
                PincodeSuggestionsBox.style.display = 'none';

                AreasuggestionsBox.innerHTML = '';
                AreasuggestionsBox.style.display = 'none';

                CitysuggestionsBox.innerHTML = '';
                CitysuggestionsBox.style.display = 'none';

                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
            }
        });
    </script>

    <script>
        let validator = $("#non-skill-register-form").validate({
            rules: {
                full_name: {
                    required: true
                },
                contact_no: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                // city_id: {
                //     required: true
                // },
                // state_id: {
                //     required: true
                // },
                // zipcode: {
                //     required: true
                // },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password" // 🔁 match with password field
                },
                // address: {
                //     required: true
                // },
            },
            messages: {
                full_name: {
                    required: "Please Enter Your Full Name"
                },
                contact_no: {
                    required: "Enter Contact No."
                },
                email: {
                    required: "Enter Email Address",
                    email: "Enter a valid Email (example@example.com)"
                },
                // state_id: {
                //     required: "Select Select State"
                // },
                // city_id: {
                //     required: "Please Select City"
                // },
                // zipcode: {
                //     required: "Please Select Pincode"
                // },
                password: {
                    required: "Enter Password"
                },
                confirm_password: {
                    required: "Please Confirm Password",
                    equalTo: "Password and Confirm Password do not match"
                },
                // address: {
                //     required: "Please Enter Address"
                // },
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                // error.insertAfter(element);
                
                if (element.attr('type') === "password" && element.closest('.input-group').length) {
                    // console.log('incdoition');
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });

        // ✅ Final submission with AJAX
        $("#non-skill-register-form").submit(function(e) {
            e.preventDefault();

            if (!$("#non-skill-register-form").valid()) {
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
            var url = "{{ route('post-register') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    console.log(response);
                    LoaderHide();
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "User Register Successfully!",
                        });
                        var otpVerifyBaseUrl = @json(route('otp-verify', ['user_id' => 'ID_PLACEHOLDER']));

                        var data = response.data;
                        // console.log(data);
                        // if (data.verify_status == 0) {
                        var redirectUrl = otpVerifyBaseUrl.replace('ID_PLACEHOLDER', data.id);
                        window.location.href = redirectUrl;
                        // } else {
                        //     window.location.href = "{{ route('emp-type', ['login_type' => 'login']) }}";
                        // }
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
                    // alert(response.message);
                }
            });
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

document.getElementById("togglePassword2").addEventListener("click", function() {
    const passwordInput = document.getElementById("confirm_password");
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