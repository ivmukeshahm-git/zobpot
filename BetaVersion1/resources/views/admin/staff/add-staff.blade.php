@push('css')
    <style>
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

        .suggestions {
            /* position: absolute; */
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
@endpush


@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Staff";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Add Staff</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="backtoList()"><i
                                class='fa fa-long-arrow-left'></i>&nbsp; Back</button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <form id="staff-form" onsubmit="return false;" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-6">
                                <label class="form-label" for="staff_name">Staff Name</label>
                                <input type="text" class="form-control" id="staff_name" name="staff_name"
                                    placeholder="Enter Staff Name" value="{{ $flag == 'U' ? $users->name : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-6">
                                <label class="form-label" for="staff_email">Email</label>
                                <input type="text" class="form-control" id="staff_email" name="staff_email"
                                    placeholder="Enter Staff EMail" value="{{ $flag == 'U' ? $users->email : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-6">
                                <label class="form-label" for="staff_contact">Contact No.</label>
                                <input type="text" class="form-control" id="staff_contact" name="staff_contact"
                                    placeholder="Enter Contact No.." value="{{ $flag == 'U' ? $users->contact_no : '' }}">
                            </div>
                        </div>

                        @if ($flag == 'A')
                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="staff_password">Password</label>
                                    <input type="password" class="form-control" id="staff_password" name="staff_password"
                                        placeholder="Enter Password">
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="staff_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="staff_confirm_password"
                                        name="staff_confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                        @endif


                        <div class="col-lg-3">
                            <div class="mb-6">
                                <label class="form-label" for="staff_role">Staff Role</label>
                                <select class="form-select" id="staff_role" name="staff_role">
                                    <option value="" selected>-Select Role-</option>
                                    @foreach ($Roles as $row)
                                        <option {{ $flag == 'U' && $userRole == $row->id ? 'selected' : '' }}
                                            value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Type</label>
                                <select class="form-select" id="staff_type" name="staff_type">
                                    <option value="1"
                                        {{ $flag == 'U' && $users->active_status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0"
                                        {{ $flag == 'U' && $users->active_status == 0 ? 'selected' : '' }}>Deactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-6">
                                <div class="form-group">
                                    <label class="form-label" for="input-5">Pincode</label>
                                    <input class="form-control" id="zipcode" type="text" required="" name="zipcode"
                                        placeholder="Enter Zipcode" autocomplete="off" autocorrect="off"
                                        autocapitalize="off" value="{{ $flag == 'U' ? $users->zipcode : '' }}">

                                    <div id="Pincodesuggestions" class="suggestions"></div>
                                    <input type="hidden" name="pincode_id_hidden" id="pincode_id_hidden"
                                        value="{{ $flag == 'U' ? $users->zipcode_id : '' }}">
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="mb-6">
                                <div class="form-group">
                                    <label class="form-label" for="input-5">State</label>
                                    <input class="form-control" id="state_id" type="text" required=""
                                        name="state_id" placeholder="Enter State" autocomplete="off" autocorrect="off"
                                        autocapitalize="off" value="{{ $flag == 'U' ? $users->state_name : '' }}">

                                    <div id="Statesuggestions" class="suggestions"></div>
                                    <input type="hidden" name="state_id_hidden" id="state_id_hidden"
                                        value="{{ $flag == 'U' ? $users->state_id : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-6">
                                <div class="form-group">
                                    <label class="form-label" for="city_id">City</label>
                                    <input class="form-control" id="city_id" type="text" required=""
                                        name="city_id" placeholder="Enter City" autocomplete="off" autocorrect="off"
                                        autocapitalize="off" value="{{ $flag == 'U' ? $users->city_nm : '' }}">

                                    <div id="Citysuggestions" class="suggestions"></div>
                                    <input type="hidden" name="city_id_hidden" id="city_id_hidden"
                                        value="{{ $flag == 'U' ? $users->city_id : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-6">
                                <div class="form-group">
                                    <label class="form-label" for="area_id">Area</label>
                                    <input class="form-control" id="area_id" type="text" required=""
                                        name="area_id" placeholder="Enter Area" autocomplete="off" autocorrect="off"
                                        autocapitalize="off" value="{{ $flag == 'U' ? $users->area_nm : '' }}">

                                    <div class="selected_area mt-2" id="AreaSuggestBox">

                                    </div>


                                    <div id="Areasuggestions" class="suggestions"></div>
                                    <input type="hidden" name="area_id_hidden" id="area_id_hidden"
                                        value="{{ $flag == 'U' ? $users->area_id : '' }}">
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-12">
                            <div class="mb-6">
                                <label class="form-label" for="staff_address">Address</label>
                                <textarea name="staff_address" class="form-control" id="staff_address" rows="4">{{ $flag == 'U' ? $users->address : '' }}</textarea>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <input type="hidden" id="_method" name="_method" value="{{ $method }}">
                            <input type="hidden" id="flag" name="flag" value="{{ $flag }}">
                            <input type="hidden" id="row_id" name="row_id" value="{{ $row_id }}">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let flag = $('#flag').val();

        if (flag == "A") {
            var rule = {
                staff_name: {
                    required: true
                },
                staff_email: {
                    required: true,
                    email: true
                },
                staff_contact: {
                    required: true
                },
                staff_password: {
                    required: true,
                    minlength: 6
                },
                staff_confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#staff_password"
                },
                staff_role: {
                    required: true
                },
                staff_type: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                area_id: {
                    required: true
                },
                zipcode: {
                    required: true
                },
                staff_address: {
                    required: true
                }
            };

            var msg = {
                staff_name: {
                    required: "Please enter the staff name"
                },
                staff_email: {
                    required: "Please enter the email address",
                    email: "Please enter a valid email address"
                },
                staff_contact: {
                    required: "Please enter the contact number"
                },
                staff_password: {
                    required: "Please enter the password",
                    minlength: "Password must be at least 6 characters long"
                },
                staff_confirm_password: {
                    required: "Please confirm the password",
                    minlength: "Confirm password must be at least 6 characters long",
                    equalTo: "Password and confirm password must match"
                },
                staff_role: {
                    required: "Please select the staff role"
                },
                staff_type: {
                    required: "Please select the staff type"
                },
                state_id: {
                    required: "Please select a state"
                },
                city_id: {
                    required: "Please select a city"
                },
                area_id: {
                    required: "Please select an area"
                },
                zipcode: {
                    required: "Please enter the zipcode"
                },
                staff_address: {
                    required: "Please enter the address"
                }
            };
        } else {
            var rule = {
                staff_name: {
                    required: true
                },
                staff_email: {
                    required: true,
                    email: true
                },
                staff_contact: {
                    required: true
                },
                staff_role: {
                    required: true
                },
                staff_type: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                area_id: {
                    required: true
                },
                zipcode: {
                    required: true
                },
                staff_address: {
                    required: true
                }
            };

            var msg = {
                staff_name: {
                    required: "Please enter the staff name"
                },
                staff_email: {
                    required: "Please enter the email address",
                    email: "Please enter a valid email address"
                },
                staff_contact: {
                    required: "Please enter the contact number"
                },
                staff_role: {
                    required: "Please select the staff role"
                },
                staff_type: {
                    required: "Please select the staff type"
                },
                state_id: {
                    required: "Please select a state"
                },
                city_id: {
                    required: "Please select a city"
                },
                area_id: {
                    required: "Please select an area"
                },
                zipcode: {
                    required: "Please enter the zipcode"
                },
                staff_address: {
                    required: "Please enter the address"
                }
            };
        }

        let validator = $("#staff-form").validate({
            rules: rule, // ✅ Pass as variable
            messages: msg, // ✅ Pass as variable
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




        // ✅ Final Blog Form Submit Handler
        $("#staff-form").submit(function(e) {
            e.preventDefault();

            // ✅ Check validation using jQuery Validation Plugin (if used)
            if (!$("#staff-form").valid()) {
                return;
            }

            // Get CKEditor description (from instance)

            // ✅ Prepare FormData object
            let form = this;
            let formData = new FormData(form);

            // ✅ Add _method if updating (PUT)
            var flag = $("#flag").val(); // "A" or "E"
            var id = $("#row_id").val();
            var url = "";
            var type = "POST";

            if (flag === "A") {
                url = "{{ route('admin.staff.store') }}";
            } else {
                url = "{{ url('admin/staff') }}/" + id;
            }

            // ✅ CSRF token for Laravel
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            LoaderShow()

            // ✅ Make AJAX request
            $.ajax({
                type: "POST", // Always POST (PUT is spoofed)
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        toastr.success(response.message, "Success");
                        setTimeout(() => {
                            window.location.href = "{{ route('admin.staff.index') }}";
                        }, 800);
                    } else {
                        toastr.warning(response.message, "Warning");
                    }
                },
                error: function(xhr) {
                    LoaderHide()
                    console.error(xhr.responseText);
                    toastr.error("An error occurred. Please try again.", "Error");
                }
            });
        });
    </script>
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
                                    ErrorMsg(response.message);
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
                                    ErrorMsg(response.message);
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
                                    ErrorMsg(response.message);
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
                        console.log();
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
@endpush
