@push('css')
    <style>
        .multi-select-button {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            padding: 8px;
            border: 1px solid #e0e6f7;
            border-radius: 4px;
            cursor: pointer;
            background: white;
            min-height: 48px;
            align-content: center;
        }

        .multi-select-button .selected-tag {
            background-color: #f26824;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            margin: 2px;
            font-size: 12px;
        }

        .multi-select-dropdown {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            width: 14rem;
            margin-top: 4px;
            display: none;
            z-index: 100;
        }

        .multi-select-option {
            padding: 8px 12px;
            cursor: pointer;
        }

        .multi-select-option:hover {
            background: #f0f0f0;
        }

        .multi-select-option.selected {
            background-color: #e0e7ff;
            font-weight: bold;
        }

        .placeholder {
            color: #999;
        }

        #output {
            margin-top: 20px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        button.submit-btn {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button.submit-btn:hover {
            background-color: #3730a3;
        }

        #EmployeeRegisterStep2 {
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
        <section class="pt-50 login-register">
            <div class="container">
                <div class="col-lg-12 col-md-6 col-sm-12 mx-auto">
                    <div class="text-center">
                        <!-- <p class="font-sm text-brand-2">Register</p> -->
                        <h2 class="mt-10 mb-5 text-brand-1">Register Employee</h2>
                    </div>
                    <form id="skilled-form" class="login-register text-start mt-50" enctype="multipart/form-data" onsubmit="return false;">
                        <div id="EmployeeRegisterStep1">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full_name">Full Name <span
                                                class="color-red"><b>*</b></span> </label>
                                        <input class="form-control" id="full_name" type="text" required=""
                                            name="full_name" placeholder="Enter Full Name"
                                            onkeypress="return SpecialCharNotAllow(event);">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="contact_no">Contact No. <span
                                                class="color-red"><b>*</b></span></label>
                                        <input class="form-control" id="contact_no" type="text" required=""
                                            name="contact_no" placeholder="Enter Contact No."
                                            onkeypress="return isNumber(event);" onpaste="return false" maxlength="10" minlength="10">
                                    </div>
                                </div>
                                

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email <span
                                                class="color-red"><b>*</b></span></label>
                                        <input class="form-control" id="email" type="email" required=""
                                            name="email" placeholder="Enter Email">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="input-5">Pincode <span class="color-red"><b>*</b></span></label>
                                        <input class="form-control" id="zipcode" type="text" required="" name="zipcode" placeholder="Enter Zipcode" autocomplete="off" autocorrect="off" autocapitalize="off">

                                        <div id="Pincodesuggestions" class="suggestions"></div>
                                        <input type="hidden" name="pincode_id_hidden" id="pincode_id_hidden">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="input-5">State <span
                                                class="color-red"><b>*</b></span></label>
                                        <input class="form-control" id="state_id" type="text" required=""
                                            name="state_id" placeholder="Enter State" autocomplete="off" autocorrect="off"
                                            autocapitalize="off">

                                        <div id="Statesuggestions" class="suggestions"></div>
                                        <input type="hidden" name="state_id_hidden" id="state_id_hidden">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="city_id">District / City <span
                                                class="color-red"><b>*</b></span></label>
                                        <input class="form-control" id="city_id" type="text" required=""
                                            name="city_id" placeholder="Enter District / City" autocomplete="off" autocorrect="off"
                                            autocapitalize="off">

                                        <div id="Citysuggestions" class="suggestions"></div>
                                        <input type="hidden" name="city_id_hidden" id="city_id_hidden">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="area_id">Area / Village<span
                                                class="color-red"><b>*</b></span></label>
                                        <input class="form-control" id="area_id" type="text" required=""
                                            name="area_id" placeholder="Enter Area" autocomplete="off" autocorrect="off"
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
                                    <!--            class="color-red"><b>*</b></span></label>-->
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
                                    <!--    <label class="form-label" for="confirm_password">Confirm Password <span-->
                                    <!--            class="color-red"><b>*</b></span></label>-->
                                    <!--    <input class="form-control" id="confirm_password" type="password" required=""-->
                                    <!--        name="confirm_password" placeholder="Confirm Password">-->
                                    <!--</div>-->
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="address">Address <span
                                                class="color-red"></span></label>
                                        <input class="form-control" id="address" type="text"
                                            name="address" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="EmployeeRegisterStep2">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="input-1">Category <span
                                                class="color-red"><b>*</b></span></label>
                                        <select name="category_id" class="form-control" id="category_id">
                                            <option value="">-Select Category-</option>
                                            {{-- @foreach ($CategoryData as $row)
                                                <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>
                                            @endforeach --}}
                                            @foreach ($CategoryData->where('preference_type', 1)->sortBy('category_nm') as $row)
                                                <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="input-2">Sub Category <span
                                                class="color-red"><b>*</b></span></label>
                                        <select name="sub_category_id" class="form-control" id="sub_category_id">
                                            <option value="">-Select Sub Category-</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label" for="input-3">Select Skills</label>
                                    <div id="multiSelectBtn" class="multi-select-button">
                                        <span class="placeholder">Choose Skills</span>
                                    </div>
                                    <div id="multiSelectDropdown" class="multi-select-dropdown">

                                    </div>

                                    <input type="hidden" id="selectedSkills" name="selectedSkills" />
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="input-5">About Description</label>
                                        <textarea name="about" rows="5" class="form-control" style="height: 150px;" id="about"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="file_nm">Upload Resume</label>
                                        <input class="form-control" id="file_nm" type="file" name="file_nm" accept=".pdf,.doc,.docx">
                                    </div>
                                </div>



                                {{-- <div class="col-lg-12">
                                    <label class="form-label" for="input-5">Education Info</label>
                                    <div id="EducationRow">
                                        <div class="row product-row">
                                            <div class="col-lg-12">
                                                <div class="branch-box">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="input-3">SSC</label>
                                                                <input class="form-control" id="input-3" type="text"
                                                                    name="username" placeholder="Enter Company Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <div class="form-group">
                                                                <label class="form-label" for="input-3">Date</label>
                                                                <input class="form-control" id="input-3" type="date"
                                                                    name="username"
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
                                </div> --}}


                            </div>
                        </div>

                        <div class="row pt-30">
                            <div class="col-lg-12 mx-auto" style="text-align: center">
                                <div class="form-group">
                                    <div id="BackButton">
                                        <a class="btn btn-brand-1 hover-up mx-2"
                                            href="{{ route('preference', ['login_type' => 'register', 'type' => 'employee']) }}">Back</a>
                                        <button class="btn btn-brand-1 hover-up" type="submit">Register</button>
                                    </div>

                                    <input type="hidden" id="form_screen" name="form_screen" value="0">
                                    <input type="hidden" id="preference_type" name="preference_type" value="1">
                                    <input type="hidden" id="_method" name="_method" value="POST">
                                    <input type="hidden" id="profile_type" name="profile_type" value="Employee">

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
    </script>
    <script>
        const btn = document.getElementById('multiSelectBtn');
        const dropdown = document.getElementById('multiSelectDropdown');
        const hiddenInput = document.getElementById('selectedSkills');
        const placeholder = btn.querySelector('.placeholder');
        let selectedValues = [];

        function resetSkills() {
            selectedValues = [];
            hiddenInput.value = '';
            btn.innerHTML = `<span class="placeholder">Choose Skills</span>`;
            dropdown.innerHTML = '';
        }


        btn.addEventListener('click', () => {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        dropdown.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('multi-select-option')) {
                const value = e.target.getAttribute('data-value');
                const index = selectedValues.indexOf(value);

                if (index > -1) {
                    selectedValues.splice(index, 1);
                    e.target.classList.remove('selected');
                } else {
                    selectedValues.push(value);
                    e.target.classList.add('selected');
                }

                updateTags();
            }
        });

        // function updateTags() {
        //     btn.innerHTML = '';
        //     if (selectedValues.length === 0) {
        //         btn.innerHTML = `<span class="placeholder">Choose Skills</span>`;
        //     } else {
        //         selectedValues.forEach(val => {
        //             const tag = document.createElement('span');
        //             tag.className = 'selected-tag';
        //             tag.innerText = val;
        //             btn.appendChild(tag);
        //         });
        //     }
        //     hiddenInput.value = selectedValues.join(',');
        // }
        function updateTags() {
            btn.innerHTML = '';

            if (selectedValues.length === 0) {
                btn.innerHTML = `<span class="placeholder">Choose Skills</span>`;
            } else {
                selectedValues.forEach((val, index) => {
                    const tag = document.createElement('span');
                    tag.className = 'selected-tag d-flex align-items-center gap-1';
                    tag.innerHTML = `
                        ${val}
                        <span class="remove-skill" data-index="${index}" style="cursor:pointer;font-weight:bold;">×</span>
                    `;
                    btn.appendChild(tag);
                });
            }

            hiddenInput.value = selectedValues.join(',');
        }
        btn.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-skill')) {
                const index = e.target.getAttribute('data-index');

                selectedValues.splice(index, 1);
                updateTags();

                // dropdown ma thi selected class pan remove
                const options = dropdown.querySelectorAll('.multi-select-option');
                options.forEach(opt => {
                    if (opt.getAttribute('data-value') === e.target.parentElement.textContent.trim()) {
                        opt.classList.remove('selected');
                    }
                });
            }
        });


        function submitSkills() {
            const output = document.getElementById('output');
            const selected = hiddenInput.value;
            output.innerHTML = selected ?
                `<strong>Selected Skills:</strong> ${selected}` :
                `<span style="color:red">No skills selected.</span>`;
        }

        window.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
        <script>
            $(document).ready(function() {
                $('#category_id').on('change', function() {

                    resetSkills();
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
                    resetSkills();
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

                                let optionHtml = ``;

                                // Use Set to prevent duplicate entries
                                let skillSet = new Set();

                                console.log(skillData);
                                skillData.forEach(item => {
                                    if (item.skill_nm) {
                                        let skills = item.skill_nm.split(',');
                                        skills.forEach(skill => {
                                            skill = skill
                                                .trim(); // Trim extra whitespace
                                            if (skill) {
                                                skillSet.add(skill);
                                            }
                                        });
                                    }
                                });

                                // Append each unique skill to the dropdown
                                skillSet.forEach(skill => {
                                    optionHtml +=
                                        `<div class="multi-select-option" data-value="${skill}">${skill}</div>`;
                                });


                                $('#multiSelectDropdown').html(optionHtml);
                            } else {
                                $("#multiSelectDropdown").html(
                                    `<div class="multi-select-option">No Skills</div>`);
                            }
                        },
                        error: function() {
                            toastr.error("Something went wrong while fetching Skills.",
                                "Error");
                        }
                    });
                });
            });


            function BackToForm() {
                // If Step 1 is done, go to Step 2
                let currentStep = $("#form_screen").val();
                if (currentStep === '1') {
                    $("#EmployeeRegisterStep1").show();
                    $("#EmployeeRegisterStep2").hide();
                    $("#form_screen").val('0');

                    $("#BackButton").html(
                        "<a class='btn btn-brand-1 hover-up mx-5' href='{{ route('preference', ['login_type' => 'register', 'type' => 'employee']) }}'>Back</a><button class='btn btn-brand-1 hover-up' type='submit'>Register</button>"
                    )
                    return;
                }
            }


            // 🔥 Step-1 ma j check karo ke mobile already registered chhe ke nahi
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



            let form_screen = $("#form_screen").val();

            let validationRules = {};
            let validationMessages = {};

            // Step 1 Validation Rules
            if (form_screen === '0') {
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
                    city_id: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    zipcode: {
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
                    // address: {
                    //     required: true
                    // }
                };

                validationMessages = {
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
                    city_id: {
                        required: "Please Select City"
                    },
                    state_id: {
                        required: "Please Select State"
                    },
                    zipcode: {
                        required: "Please Select Pincode"
                    },
                    password: {
                        required: "Enter Password"
                    },
                    confirm_password: {
                        required: "Please Confirm Password",
                        equalTo: "Password and Confirm Password do not match"
                    },
                    // address: {
                    //     required: "Please Enter Address"
                    // }
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
                    // skill_ids: {
                    //     required: true
                    // }
                };

                validationMessages = {
                    category_id: {
                        required: "Please Select Category"
                    },
                    sub_category_id: {
                        required: "Please Select Sub Category"
                    },
                    // skill_ids: {
                    //     required: "Please Select Skill"
                    // }
                };
            }

            // Initialize Validator
            let validator = $("#skilled-form").validate({
                rules: validationRules,
                messages: validationMessages,
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    if (element.attr('type') === "password" && element.closest('.input-group').length) {
                        // console.log('incdoition');
                            error.insertAfter(element.closest('.input-group'));
                        } else {
                            error.insertAfter(element);
                        }
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
            $("#skilled-form").submit(function(e) {
                e.preventDefault();

                if (!$("#skilled-form").valid()) return;

                // If Step 1 is done, go to Step 2
                let currentStep = $("#form_screen").val();
                if (currentStep === '0') {
                        if (window.mobileExists === true) {
                            toastr.error("This mobile number is already registered.");
                            return; // ❌ Step-2 ma na jai
                        }
                    $("#EmployeeRegisterStep1").hide();
                    $("#EmployeeRegisterStep2").show();
                    $("#form_screen").val('1');

                    $("#BackButton").html(
                        "<button type='button' class='btn btn-brand-1 hover-up mx-5' onclick='BacktoFirstScreen()'>Back</button><button class='btn btn-brand-1 hover-up' type='submit'>Register</button>"
                    )
                    return;
                }

                // Final form submission
                let form = $(this);
                let formData = new FormData(form[0]);

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
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        LoaderHide();
                        if (response.status === 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'User Register Successfully!',
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
                        let errorMsg = "Something went wrong. Please try again.";

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                const res = JSON.parse(xhr.responseText);
                                errorMsg = res.message || errorMsg;
                            } catch (e) {}
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMsg,
                        });
                    }
                });
            });


            //  Add Estimated Time Row Loop
            const EducationRow = document.getElementById('EducationRow');

            var count = 1;
            EducationRow.addEventListener('click', (event) => {
                if (event.target.classList.contains('add-row')) {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'product-row', 'm-0', 'mt-3');

                    const rowTemplate = `
                    <div class="col-lg-12 p-0">
                        <div class="branch-box">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label class="form-label" for="input-3">SSC</label>
                                <input class="form-control" id="input-3" type="text" required="" name="username" placeholder="Enter Company Name">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                <label class="form-label" for="input-3">Date</label>
                                <input class="form-control" id="input-3" type="date" required="" name="username" placeholder="Enter Company Address....">
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
                    EducationRow.appendChild(newRow);
                    count++;
                }

                // Remove row functionality
                if (event.target.classList.contains('remove-row')) {
                    const row = event.target.closest('.product-row');
                    if (row) row.remove();
                }
            });





            function BacktoFirstScreen() {
                document.getElementById("EmployeeRegisterStep1").style.display = "block";
                document.getElementById("EmployeeRegisterStep2").style.display = "none";
            }
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
