@push('css')
    <style>
        #CompanyRegisterStep2 {
            display: none;
        }

        .branch-box {
            border: 1px solid #d4d4d4;
            padding: 10px;
            background: #ffffff;
            border-radius: 12px;
        }
    </style>
@endpush


@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="pt-50 login-register" id="RegisterCompanyArea1">
            <div class="container">
                <div class="row pb-50">
                    <div class="col-lg-12 col-md-6 col-sm-12 mx-auto">
                        <div class="text-center">
                            <!-- <p class="font-sm text-brand-2">Register </p> -->
                            <h2 class="mt-10 mb-5 text-brand-1">Register Company</h2>
                        </div>
                        <form id="company-register" class=" text-start mt-50" onsubmit="return false;">
                            <div id="CompanyRegisterStep1">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="full_name">Company Name <span
                                                    class="color-red"><b>*</b></span> </label>
                                            <input class="form-control" id="full_name" type="text" required
                                                name="full_name" placeholder="Enter Company Name"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="contact_no">Company Contact No. <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="contact_no" type="text" required
                                                name="contact_no" placeholder="Enter Company Contact No."
                                                onkeypress="return isNumber(event);" maxlength="10" minlength="10">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="email">Company Email <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="email" type="email" required
                                                name="email" placeholder="Enter Company Email">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="personal_name">Personal Name <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="personal_name" type="text" required
                                                name="personal_name" placeholder="Enter Personal Name"
                                                onkeypress="return SpecialCharNotAllow(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="contact_person_nm">Contact Person Name</label>
                                            <input class="form-control" id="contact_person_nm" type="text"
                                                name="contact_person_nm" placeholder="Enter Contact Person Name"
                                                onkeypress="return SpecialCharNotAllow(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="contact_person_phone_no">Contact Person Phone
                                                No.</label>
                                            <input class="form-control" id="contact_person_phone_no" type="text"
                                                name="contact_person_phone_no" placeholder="Enter Contact Person Phone No."
                                                onkeypress="return isNumber(event);" maxlength="10" minlength="10">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="address">Company Address <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="address" type="text" required
                                                name="address" placeholder="Enter Company Address">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <!--<div class="form-group">-->
                                        <!--    <label class="form-label" for="password">Password <span-->
                                        <!--            class="color-red"><b>*</b></span></label>-->
                                        <!--    <input class="form-control" id="password" type="password" required-->
                                        <!--        name="password" placeholder="Enter Password">-->
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
                                    </div>

                                    <div class="col-lg-6">
                                        <!--<div class="form-group">-->
                                        <!--    <label class="form-label" for="confirm_password">Confirm Password <span-->
                                        <!--            class="color-red"><b>*</b></span></label>-->
                                        <!--    <input class="form-control" id="confirm_password" type="password" required-->
                                        <!--        name="confirm_password" placeholder="Confirm Password">-->
                                        <!--</div>-->
                                        
                                        <div class="form-group position-relative">
                                        <label class="form-label" for="password">Confirm Password <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="confirm_password" type="password" name="confirm_password" required placeholder="************">
                                            <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword2">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="input-5">Pincode <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="zipcode" type="text" required=""
                                                name="zipcode" placeholder="Enter Zipcode" autocomplete="off"
                                                autocorrect="off" autocapitalize="off">

                                            <div id="Pincodesuggestions" class="suggestions"></div>
                                            <input type="hidden" name="pincode_id_hidden" id="pincode_id_hidden">
                                        </div>
                                    </div>


                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="input-5">State <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="state_id" type="text" required=""
                                                name="state_id" placeholder="Enter State" autocomplete="off"
                                                autocorrect="off" autocapitalize="off">

                                            <div id="Statesuggestions" class="suggestions"></div>
                                            <input type="hidden" name="state_id_hidden" id="state_id_hidden">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="city_id">District / City <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="city_id" type="text" required=""
                                                name="city_id" placeholder="Enter District / City" autocomplete="off"
                                                autocorrect="off" autocapitalize="off">

                                            <div id="Citysuggestions" class="suggestions"></div>
                                            <input type="hidden" name="city_id_hidden" id="city_id_hidden">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="area_id">Area / Village <span
                                                    class="color-red"><b>*</b></span></label>
                                            <input class="form-control" id="area_id" type="text" required=""
                                                name="area_id" placeholder="Enter Area" autocomplete="off"
                                                autocorrect="off" autocapitalize="off">

                                            <div class="selected_area mt-2" id="AreaSuggestBox">

                                            </div>

                                            <div id="Areasuggestions" class="suggestions"></div>
                                            <input type="hidden" name="area_id_hidden" id="area_id_hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="CompanyRegisterStep2">
                                <div class="row">
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="category_id">Category <span
                                                    class="color-red"><b>*</b></span></label>
                                            <select name="category_id" class="form-control" id="category_id" required>
                                                <option value="">-Select Category-</option>
                                                @foreach ($CategoryData as $row)
                                                    <option value="{{ $row->category_id }}">{{ $row->category_nm }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="sub_category_id">Sub Category <span
                                                    class="color-red"><b>*</b></span></label>
                                            <select name="sub_category_id" class="form-control" id="sub_category_id"
                                                required>
                                                <option value="">-Select Sub Category-</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 d-none">
                                        <div class="form-group">
                                            <label class="form-label" for="average_salary">Average Salary</label>
                                            <input class="form-control" id="average_salary" type="text"
                                                name="average_salary" placeholder="Enter Average Salary">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="company_size">Size Of Company</label>
                                            <input class="form-control" id="company_size" type="text"
                                                name="company_size" placeholder="Enter Size Of Company">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="company_since">Company Since From</label>
                                            <input class="form-control" id="company_since" type="text"
                                                name="company_since" placeholder="Enter Company Since From">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="company_desc">Company Description</label>
                                            <textarea name="company_desc" rows="5" class="form-control" style="height: 150px;" id="company_desc"></textarea>
                                        </div>
                                    </div>



                                    <div class="col-lg-12">
                                        <label class="form-label" for="input-5">Company Branches</label>
                                        <div id="CompanyBrnchRow">
                                            <div class="row product-row">
                                                <div class="col-lg-12">
                                                    <div class="branch-box">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="company_nm">Company
                                                                        Name</label>
                                                                    <input class="form-control" id="company_nm"
                                                                        type="text" name="company_nm[]"
                                                                        placeholder="Enter Company Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="company_address">Company
                                                                        Address</label>
                                                                    <input class="form-control" id="company_address"
                                                                        type="text" name="company_address[]"
                                                                        placeholder="Enter Company Address....">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1">
                                                                <button class="btn btn-brand-1 hover-up mt-4 add-row"
                                                                    style="padding: 18px 21px;" type="button"><i
                                                                        class="fa fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row pt-30">
                                <div class="col-lg-2 mx-auto">
                                    <div class="form-group">
                                        <a class="btn btn-brand-1 hover-up" href="javascript::void(0)" id="backtofirststep">Back</a>

                                        <input type="hidden" id="form_screen" name="form_screen" value="0">
                                        <input type="hidden" id="profile_type" name="profile_type" value="Company">
                                        <input type="hidden" id="_method" name="_method" value="POST">
                                        <button class="btn btn-brand-1 hover-up" type="submit"
                                            id="CompanyRegisterBtn">Next</button>
                                    </div>
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
    {{-- <script>
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

        PincodeSelect.addEventListener('input', function() {
            const query = this.value.trim();
            PincodeSuggestionsBox.innerHTML = '';

            if (query.length === 0 || !Array.isArray(window.areas)) {
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
                    });
                    PincodeSuggestionsBox.appendChild(div);
                });
            } else {
                PincodeSuggestionsBox.style.display = 'none';
            }

            // Reset hidden ID on manual input
            PincodeIdHidden.value = '';
        });

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
    </script> --}}
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
                        console.log("Something went wrong while fetching sub categories.",
                            "Error");
                    }
                });
            });

        });

        

        let form_screen = $("#form_screen").val();



$('#backtofirststep').on('click',function(){
    
             let currentStep = $("#form_screen").val();
            if (currentStep === '1') {
                $("#CompanyRegisterStep1").show();
                $("#CompanyRegisterStep2").hide();
                $("#form_screen").val('0');

                $("#CompanyRegisterBtn").html("Next")
                return;
            }
})
        

        let validationRules = {};
        let validationMessages = {};

        // Step 1 Validation Rules
        if (form_screen == '0') {
            validationRules = {
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
                personal_name: {
                    required: true
                },
                address: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password" // 🔁 match with password field
                },
                area_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                state_id: {
                    required: true
                },
                zipcode: {
                    required: true
                },

            };

            validationMessages = {
                full_name: {
                    required: "Please Enter Company Name"
                },
                contact_no: {
                    required: "Enter Contact No."
                },
                email: {
                    required: "Enter Email Address",
                    email: "Enter a valid Email (example@example.com)"
                },
                personal_name: {
                    required: "Enter Personal Name"
                },

                address: {
                    required: "Please Enter Company Address"
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Password must be at least 6 characters long"
                },
                confirm_password: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
                area_id: {
                    required: "Please Select Area / Village"
                },
                city_id: {
                    required: "Please Select City"
                },
                state_id: {
                    required: "Please Select State"
                },
                zipcode: {
                    required: "Please Select Pincode"
                },


            };
        }
        // Step 2 Validation Rules
        else {
            validationRules = {
                category_id: {
                    required: true
                },
                sub_category_id: {
                    required: true
                },
            };

            validationMessages = {
                category_id: {
                    required: "Please Select Category"
                },
                sub_category_id: {
                    required: "Please Select Sub Category"
                },
            };
        }

        // Initialize Validator
        let validator = $("#company-register").validate({
            rules: validationRules,
            messages: validationMessages,
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                
                // console.log(element.attr('type'));
                // console.log(element.closest('.input-group').length);
                
                if (element.attr('type') === "password" && element.closest('.input-group').length) {
                    // console.log('incdoition');
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                console.log(element)
                // error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });

        // Submit Handler
        $("#company-register").submit(function(e) {
            e.preventDefault();

            if (!$("#company-register").valid()) return;

            // If Step 1 is done, go to Step 2
            let currentStep = $("#form_screen").val();
            if (currentStep === '0') {
                $("#CompanyRegisterStep1").hide();
                $("#CompanyRegisterStep2").show();
                $("#form_screen").val('1');

                $("#CompanyRegisterBtn").html("Register")
                return;
            }

            // Final form submission
            let form = $(this);
            let formData = form.serialize();

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
                    LoaderHide();
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "Company Register Successfully!",
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

        $("#contact_no").on("blur", function () {

                    let mobile = $(this).val().trim();

                    if (mobile.length !== 10) {
                        window.mobileExists = false;
                        return; // 10 digit na hoy to check nathi karta
                    }

                    $.ajax({
                        url: "{{ route('post-register') }}",
                        type: "POST",
                        data: {
                            contact_no: mobile,
                            check_only: true,  
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res){

                            if(res.status === 0){
                                // Already registered
                                $("#contact_no").addClass("is-invalid");
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'This mobile number is already registered.'
                                });

                                // ❌ Blur ma step change na karo
                                window.mobileExists = true;

                            } else {
                                // Valid new number
                                $("#contact_no").removeClass("is-invalid").addClass("is-valid");

                                window.mobileExists = false;
                            }
                        }
                    });

                });



        function BacktoFirst() {
            document.getElementById("").style.display = "block";
            document.getElementById("").style.display = "none";
        }

        function NextInfoCompanyRegister() {
            document.getElementById("CompanyRegisterStep1").style.display = "none";
            document.getElementById("CompanyRegisterStep2").style.display = "block";
        }
        //  Add Estimated Time Row Loop
        const CompanyBrnchRow = document.getElementById('CompanyBrnchRow');

        var count = 1;
        CompanyBrnchRow.addEventListener('click', (event) => {
            if (event.target.classList.contains('add-row')) {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'product-row', 'm-0', 'mt-3');

                const rowTemplate = `
                    <div class="col-lg-12 p-0">
                      <div class="branch-box">
                        <div class="row">
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label class="form-label" for="company_nm">Company Name</label>
                              <input class="form-control" id="company_nm" type="text" required="" name="company_nm[]" placeholder="Enter Company Name">
                            </div>
                          </div>
                          <div class="col-lg-8">
                            <div class="form-group">
                              <label class="form-label" for="company_address">Company Address....</label>
                              <input class="form-control" id="company_address" type="text" required="" name="company_address[]" placeholder="Enter Company Address....">
                            </div>
                          </div>

                          <div class="col-lg-1">
                            <button class="btn btn-brand-1 hover-up mt-4 remove-row" style="padding: 18px 21px;background: #cb0000;" type="button"><i class="fa fa-trash remove-row"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>`;


                newRow.innerHTML = rowTemplate;
                CompanyBrnchRow.appendChild(newRow);
                count++;
            }

            // Remove row functionality
            if (event.target.classList.contains('remove-row')) {
                const row = event.target.closest('.product-row');
                if (row) row.remove();
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
