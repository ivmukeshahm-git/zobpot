@extends('website.layout.layout')

@section('website-content')
<script>
    page_active_id = "skillthon";
</script>

<main class="main">
        <section class="section-box ">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="mb-10">Skillothon</h2>
                            <p class="font-lg color-text-paragraph-2">Get the latest news, updates and tips</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 mb-40 d-flex justify-content-center">
                        <img class="img-job-1" src="{{ asset('assets/imgs/page/homepage1/Skillothon.jpeg') }}" alt="skillthon Image" height="400" width="300">
                    </div>

                    <div class="col-lg-7 mb-40">
                        <!-- <span class="font-md color-brand-2 mt-20 d-inline-block">Contact us</span> -->
                  
                        <h2 class="mt-5 mb-10">Pre-Registration Skillothon</h2>
                        <p class="font-md color-text-paragraph-2">“Real power lies in skills, not titles.”<br class="d-none d-lg-block">Pre book  your seat with skillothon by Zobpot and grab the Perfect Opportunity.</p>
                       <form class="contact-form-style mt-30" id="hackathon-form" action="#">
                            @csrf
                            <input type="hidden" name="type" value="1"> <!-- Hackathon -->

                            <div class="row wow animate__animated animate__fadeInUp" data-wow-delay=".1s">

                                <div class="col-lg-12 col-md-12">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="name"
                                            placeholder="Enter your Full Name" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="email"
                                            placeholder="Email" type="email">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="phone_no"
                                            placeholder="Phone number" type="tel">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="city"
                                            placeholder="City/Village" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="pincode"
                                            placeholder="Pincode" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="university"
                                            placeholder="University" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="college"
                                            placeholder="College" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="degree"
                                            placeholder="Degree/Course" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">---Select Gender---</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                            <option value="3">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 d-flex justify-content-end">
                                    <button class="submit btn btn-send-message" type="button" id="submitHackathon">
                                        Send message
                                    </button>
                                </div>

                            </div>
                        </form>

                        <p class="form-messege"></p>
                    </div>
                </div>
            </div>
           
        </section>
</main>

@endsection

@push('script')

<script>
$(document).on('click', '#submitHackathon', function () {

    $.ajax({
        url: "{{ route('skillthon.store') }}",
        method: "POST",
        data: $('#hackathon-form').serialize(),
        success: function (res) {
            if (res.status === 1) {
                // alert('Registration Successful ✅');
                swal.fire(
                    'Thank you for your response',
                    'Our team will connect you shortly',
                    'success'
                );
                $('#hackathon-form')[0].reset();
            } else {
                alert(res.message);
            }
        },
        error: function () {
            alert('Server Error ❌');
        }
    });

});
</script>

@endpush