@push('css')
    <style>
        .Achievements-count-box {
            border: 1px solid #e6e6e6;
            padding: 10px;
            border-radius: 7px;
            background-color: #e9e9e9;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Achievements";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="card-title">Achievements</h5>
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body p-4">
                <form id="achievement-form" onsubmit="return false;">
                    <div class="row">
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($AchievementData as $row)
                            <div class="col-lg-6 col-md-12 col-12 mb-3">
                                <label class="form-label mb-2">Achievements {{ $i }}</label>
                                <div class="Achievements-count-box">
                                    <input type="hidden" name="achievements[{{ $i }}][id]"
                                        value="{{ $row->id }}">
                                    <div class="mb-3">
                                        <label for="achvCount{{ $i }}" class="form-label mb-2">Count In Number
                                            <span style="color:red;">*</span></label>
                                        <input type="text" id="achvCount{{ $i }}" class="form-control"
                                            name="achievements[{{ $i }}][count]" placeholder="Enter Number"
                                            value="{{ $row->id }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="achvTitle{{ $i }}" class="form-label mb-2">Achievements Title
                                            <span style="color:red;">*</span></label>
                                        <input type="text" id="achvTitle{{ $i }}" class="form-control"
                                            name="achievements[{{ $i }}][title]" placeholder="Enter Title"
                                            maxlength="25" value="{{ $row->title }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="achvDesc{{ $i }}" class="form-label mb-2">Achievements
                                            Description (15 Words) <span style="color:red;">*</span></label>
                                        <input type="text" id="achvDesc{{ $i }}"
                                            class="form-control achv-desc" name="achievements[{{ $i }}][desc]"
                                            placeholder="Enter Description" maxlength="110"
                                            value="{{ $row->description }}">
                                    </div>
                                </div>
                            </div>

                            @php
                                $i++;
                            @endphp
                        @endforeach
                        <div class="col-lg-6 col-md-12 col-12 mt-5">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        let validator = $("#achievement-form").validate({
            rules: {
                "achievements[1][count]": {
                    required: true,
                    number: true
                },
                "achievements[1][title]": {
                    required: true,
                    maxlength: 25
                },
                "achievements[1][desc]": {
                    required: true,
                    maxlength: 110
                },


                "achievements[2][count]": {
                    required: true,
                    number: true
                },
                "achievements[2][title]": {
                    required: true,
                    maxlength: 25
                },
                "achievements[2][desc]": {
                    required: true,
                    maxlength: 110
                },



                "achievements[3][count]": {
                    required: true,
                    number: true
                },
                "achievements[3][title]": {
                    required: true,
                    maxlength: 25
                },
                "achievements[3][desc]": {
                    required: true,
                    maxlength: 110
                },



                "achievements[4][count]": {
                    required: true,
                    number: true
                },
                "achievements[4][title]": {
                    required: true,
                    maxlength: 25
                },
                "achievements[4][desc]": {
                    required: true,
                    maxlength: 110
                },
            },
            messages: {
                "achievements[1][count]": {
                    required: "Please enter count",
                    number: "Only numbers allowed"
                },
                "achievements[1][title]": {
                    required: "Please enter title",
                    maxlength: "Maximum 25 characters allowed"
                },
                "achievements[1][desc]": {
                    required: "Please enter description",
                    maxlength: "Maximum 110 characters allowed"
                },



                "achievements[2][count]": {
                    required: "Please enter count",
                    number: "Only numbers allowed"
                },
                "achievements[2][title]": {
                    required: "Please enter title",
                    maxlength: "Maximum 25 characters allowed"
                },
                "achievements[2][desc]": {
                    required: "Please enter description",
                    maxlength: "Maximum 110 characters allowed"
                },


                "achievements[3][count]": {
                    required: "Please enter count",
                    number: "Only numbers allowed"
                },
                "achievements[3][title]": {
                    required: "Please enter title",
                    maxlength: "Maximum 25 characters allowed"
                },
                "achievements[3][desc]": {
                    required: "Please enter description",
                    maxlength: "Maximum 110 characters allowed"
                },




                "achievements[4][count]": {
                    required: "Please enter count",
                    number: "Only numbers allowed"
                },
                "achievements[4][title]": {
                    required: "Please enter title",
                    maxlength: "Maximum 25 characters allowed"
                },
                "achievements[4][desc]": {
                    required: "Please enter description",
                    maxlength: "Maximum 110 characters allowed"
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
                $(element).removeClass("is-invalid");
            }
        });

        $("#achievement-form").submit(function(e) {
            e.preventDefault();

            if (!$("#achievement-form").valid()) return;

            let form = $(this);
            let formData = form.serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = "{{ route('admin.achievements.update-achievements') }}";

            LoaderShow()

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        toastr.success(response.message, 'Success');
                        form[0].reset();
                        validator.resetForm();
                        location.reload();
                    } else {
                        toastr.warning(response.message, 'Warning');
                    }
                },
                error: function(xhr) {
                    LoaderHide()
                    console.log(xhr.responseText);
                    toastr.error("Something went wrong", 'Error');
                }
            });
        });
    </script>
@endpush
