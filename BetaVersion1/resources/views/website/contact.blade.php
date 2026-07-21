@extends('website.layout.layout')
@section('website-content')

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        page_active_id = "Contact";
    </script>
    <main class="main">
        <section class="section-box">
            <div class="breacrumb-cover bg-img-contact">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- <h2 class="mb-10">Contact Us</h2>
                            <p class="font-lg color-text-paragraph-2">Get in touch</p> -->
                        </div>
                        <div class="col-lg-6 text-lg-end">
                            <ul class="breadcrumbs mt-40">
                                <li><a class="home-icon" href="{{ route('home') }}">Home</a></li>
                                <li>Contact Us</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box mt-50">
            <div class="container">

                    <div class="row d-none" style="background: linear-gradient(135deg, #242b62, #f36825); padding: 7px; border-radius: 15px; margin: 20px 0;">
                        <!-- Left - Customer Support -->
                        <div class="col-md-4 mb-3 text-center">
                            <div style="background: white; padding: 9px; border-radius: 12px; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                <div style="background: #242b62; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fa fa-user" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h5 style="color: #242b62; margin-bottom: 10px; font-weight: 700;">Customer Support</h5>
                                <p style="color: #f36825; margin: 0; font-weight: 600; font-size: 15px;">
                                    Monday to Friday<br>
                                    <span style="color: #242b62;font-weight:800;">11:00 AM - 6:00 PM</span>
                                </p>
                            </div>
                        </div>

                        <!-- Center - Phone Support -->
                        <div class="col-md-4 mb-3 text-center">
                            <div style="background: white; padding: 9px; border-radius: 12px; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                <div style="background: #f36825; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fa fa-phone" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h5 style="color: #242b62; margin-bottom: 10px; font-weight: 700;">Phone Support</h5>
                                <p style="color: #f36825; margin: 0; font-weight: 600; font-size: 15px;">
                                    Monday to Sunday<br>
                                    <span style="color: #242b62;font-weight:800;">10:00 AM - 6:00 PM</span>
                                </p>
                            </div>
                        </div>

                        <!-- Right - WhatsApp Support -->
                        <div class="col-md-4 mb-3 text-center">
                            <div style="background: white; padding: 9px; border-radius: 12px; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                <div style="background: #25D366; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fa fa-whatsapp" style="color: white; font-size: 28px;"></i>
                                </div>
                                <h5 style="color: #242b62; margin-bottom: 10px; font-weight: 700;">WhatsApp Support</h5>
                                <p style="color: #f36825; margin: 0; font-weight: 600; font-size: 15px;">
                                    Quick Response<br>
                                </p>
                                    <span style="color: #242b62;font-weight:800;">10:00 AM - 6:00 PM</span>
                            </div>
                        </div>
                    </div>

                <div class="row">


                     <div class="col-md-12 mb-20">
                        <!-- Header -->
                        <div style="margin-bottom: 20px;background: #f8f9fa;padding: 15px;border-radius: 10px;">
                            <h4 style="color: #242b62;">📍 Find Us</h4>
                            <p style="color: #f36825; margin: 0;">Visit our office for in-person meetings and consultations</p>
                        </div>

                        <!-- Tabs for Office Addresses -->
                        <div class="office-tabs" style="margin-bottom: 20px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="display: flex; gap: 10px; border-bottom: 2px solid #e0e0e0;">
                                        <button class="tab-button active" onclick="showTab('registered')" style="
                                            background: #242b62;
                                            color: white;
                                            border: none;
                                            padding: 12px 25px;
                                            border-radius: 8px 8px 0 0;
                                            font-weight: 600;
                                            cursor: pointer;
                                        ">Registered Office</button>
                                        <button class="tab-button" onclick="showTab('corporate')" style="
                                            background: #f8f9fa;
                                            color: #242b62;
                                            border: none;
                                            padding: 12px 25px;
                                            border-radius: 8px 8px 0 0;
                                            font-weight: 600;
                                            cursor: pointer;
                                        ">Corporate Office</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Registered Office Tab Content -->
                        <div id="registered" class="tab-content" style="display: block;">
                            <div class="row">
                                <!-- Map Section - col-md-8 -->
                                <div class="col-md-8">
                                    <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); height: 400px;">
                                        <iframe 
                                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3655.606471395998!2d72.34751617533185!3d23.618442378760644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjPCsDM3JzA2LjQiTiA3MsKwMjEnMDAuMyJF!5e0!3m2!1sen!2sin!4v1759917466096!5m2!1sen!2sin"
                                            width="100%" 
                                            height="100%" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>

                                <!-- Office Details - col-md-4 -->
                                <div class="col-md-4">
                                    <div style="
                                        background: linear-gradient(135deg, #ffffff, #f8f9fa);
                                        padding: 20px;
                                        border-radius: 15px;
                                        box-shadow: 0 5px 20px rgba(36, 43, 98, 0.15);
                                        height: 400px;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: space-between;
                                    ">
                                        <!-- Header -->
                                        <div>
                                            <h5 style="color: #242b62; margin-bottom: 15px; border-bottom: 2px solid #f36825; padding-bottom: 8px; font-size: 18px;">
                                                🏢 Registered Office
                                            </h5>
                                            
                                            <!-- Address -->
                                            <div style="margin-bottom: 15px;">
                                                <div style="display: flex; align-items: flex-start;">
                                                    <div style="color: #f36825; margin-right: 10px; font-size: 16px;">📍</div>
                                                    <p style="margin: 0; color: #242b62; font-weight: 800; line-height: 1.4; font-size: 17px;">
                                                        {{ $Setting ? $Setting->Address : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <div>
                                            <!-- Phone 1 -->
                                            {{-- <!-- <div style="display: flex; align-items: center; margin-bottom: 12px;">
                                                <div style="background: #242b62; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                                    <i class="fa fa-phone" style="font-size: 15px;"></i>
                                                </div>
                                                <div>
                                                    <p style="margin: 0; color: #242b62; font-weight: 800; font-size: 17px;">
                                                        {{ $Setting ? $Setting->contact_1 : '+91-XXXXXXXXXX' }}
                                                    </p>
                                                </div>
                                            </div> --> --}}
                                            
                                            <!-- Phone 2 -->
                                            <div style="display: flex; align-items: center; margin-bottom: 12px;">
                                                <div style="background: #242b62; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                                    <i class="fa fa-phone" style="font-size: 15px;"></i>
                                                </div>
                                                <div>
                                                    <p style="margin: 0; color: #242b62: ; font-weight: 800; font-size: 17px;">
                                                        {{ $Setting ? $Setting->contact_2 : '+91-XXXXXXXXXX' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <!-- Email -->
                                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                                <div style="background: #f36825; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                                    <i class="fa fa-envelope" style="font-size: 15px;"></i>
                                                </div>
                                                <div>
                                                    <p style="margin: 0; color: #f36825; font-weight: 800; font-size: 17px;">
                                                        {{ $Setting ? $Setting->email_1 : 'info@company.com' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Office Hours -->
                                        <div style="padding: 12px; background: linear-gradient(45deg, #242b62, #f36825); border-radius: 10px; text-align: center;">
                                            <p style="margin: 0; color: white; font-size: 13px; font-weight: 800;">
                                                <i class="fa fa-clock" style="margin-right: 6px;"></i>
                                                <strong>Office Hours:</strong> Mon - Sat: 11AM - 6PM
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Corporate Office Tab Content -->
                        <div id="corporate" class="tab-content" style="display: none;">
                            <div class="row">
                                <!-- Map Section - col-md-8 -->
                                <div class="col-md-8">
                                    <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); height: 400px;">
                                        <iframe 
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14682.219793639908!2d72.5005970866847!3d23.076772506963046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e8564ec18df43%3A0x1fb0faf27165bbee!2s1008%2C%20I%20SQUARE%20CORPORATE%20PARK!5e0!3m2!1sen!2sin!4v1759913683705!5m2!1sen!2sin" 
                                            width="100%" 
                                            height="100%" 
                                            style="border:0;" 
                                            allowfullscreen="" 
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                </div>

                                <!-- Office Details - col-md-4 -->
                                <div class="col-md-4">
                                    <div style="
                                        background: linear-gradient(135deg, #ffffff, #f8f9fa);
                                        padding: 20px;
                                        border-radius: 15px;
                                        box-shadow: 0 5px 20px rgba(36, 43, 98, 0.15);
                                        height: 400px;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: space-between;
                                    ">
                                        <!-- Header -->
                                        <div>
                                            <h5 style="color: #242b62; margin-bottom: 15px; border-bottom: 2px solid #f36825; padding-bottom: 8px; font-size: 18px;">
                                                🏢 Corporate Office
                                            </h5>
                                            
                                            <!-- Address -->
                                            <div style="margin-bottom: 15px;">
                                                <div style="display: flex; align-items: flex-start;">
                                                    <div style="color: #f36825; margin-right: 10px; font-size: 16px;">📍</div>
                                                    <p style="margin: 0; color: #242b62; font-weight: 800; line-height: 1.4; font-size: 17px;">
                                                        {{ $Setting ? $Setting->corporate_address : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <div>
                                            <!-- Phone 1 -->
                                            <div style="display: flex; align-items: center; margin-bottom: 12px;">
                                                <div style="background: #242b62; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                                    <i class="fa fa-phone" style="font-size: 15px;"></i>
                                                </div>
                                                <div>
                                                    <p style="margin: 0; color: #242b62; font-weight: 800; font-size: 17px;">
                                                        {{ $Setting ? $Setting->contact_2 : '+91-XXXXXXXXXX' }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <!-- Phone 2 -->
                                            <!-- <div style="display: flex; align-items: center; margin-bottom: 12px;">
                                                <div style="background: #f36825; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                                    <i class="fa fa-phone" style="font-size: 15px;"></i>
                                                </div>
                                                <div>
                                                    <p style="margin: 0; color: #f36825; font-weight: 800; font-size: 17px;">
                                                        {{ $Setting ? $Setting->contact_2 : '+91-XXXXXXXXXX' }}
                                                    </p>
                                                </div>
                                            </div> -->
                                            
                                            <!-- Email -->
                                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                                <div style="background: #f36825; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                                    <i class="fa fa-envelope" style="font-size: 12px;"></i>
                                                </div>
                                                <div>
                                                    <p style="margin: 0; color: #f36825; font-weight: 600; font-size: 14px;">
                                                        {{ $Setting ? $Setting->email_1 : 'corporate@company.com' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Office Hours -->
                                        <div style="padding: 12px; background: linear-gradient(45deg, #242b62, #f36825); border-radius: 10px; text-align: center;">
                                            <p style="margin: 0; color: white; font-size: 13px; font-weight: 600;">
                                                <i class="fa fa-clock" style="margin-right: 6px;"></i>
                                                <strong>Office Hours:</strong> Mon - Sat: 11AM - 6PM
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12 mb-40">
                        <!-- <span class="font-md color-brand-2 mt-20 d-inline-block">Contact us</span> -->
                  
                        <h2 class="mt-5 mb-10">Get in touch</h2>
                        <p class="font-md color-text-paragraph-2">The right move at the right time saves your investment. live<br class="d-none d-lg-block"> the dream of expanding your business.</p>
                        <form class="contact-form-style mt-30" id="contact-form" action="#">
                            <div class="row wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="name"
                                            placeholder="Enter your name" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="company"
                                            placeholder="Company (optioanl)" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="email"
                                            placeholder="Your email" type="email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="input-style mb-20">
                                        <input class="font-sm color-text-paragraph-2" name="phone"
                                            placeholder="Phone number" type="tel">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="textarea-style mb-30">
                                        <textarea class="font-sm color-text-paragraph-2" name="message" placeholder="Tell us about yourself"></textarea>
                                    </div>
                                    <button class="submit btn btn-send-message" type="button">Send message</button>
                                    <label class="ml-20">
                                        <input class="float-start mr-5 mt-6" type="checkbox"> By clicking contact us button,
                                        you agree our terms and policy,
                                    </label>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>

                </div>
            </div>
        </section>

        @if (!$Blog->isEmpty())
            <!--<section class="section-box mt-50 mb-50">-->
            <!--    <div class="container">-->
            <!--        <div class="text-start">-->
            <!--            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Blog</h2>-->
            <!--            <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Get the latest updates and tips</p>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="container">-->
            <!--        <div class="mt-50">-->
            <!--            <div class="box-swiper style-nav-top">-->
            <!--                <div class="swiper-container swiper-group-3 swiper">-->
            <!--                    <div class="swiper-wrapper pb-70 pt-5">-->
            <!--                        @foreach ($Blog as $row)-->
            <!--                            <div class="swiper-slide">-->
            <!--                                <div class="card-grid-3 hover-up wow animate__animated animate__fadeIn">-->
            <!--                                    <div class="text-center card-grid-3-image"><a href="{{ route('blog-detail', $row->id) }}">-->
            <!--                                            <figure><img alt="jobBox" src="{{ asset('uploads/blog_img/' . $row->image) }}"></figure>-->
            <!--                                        </a>-->
            <!--                                    </div>-->
            <!--                                    <div class="card-block-info">-->
            <!--                                        <div class="tags mb-15"><a class="btn btn-tag"-->
            <!--                                                href="{{ route('blog-detail', $row->id) }}">Blog</a>-->
            <!--                                        </div>-->
            <!--                                        <h5><a href="{{ route('blog-detail', $row->id) }}">{{ $row->title }}</a></h5>-->
            <!--                                        <div class="card-2-bottom mt-20">-->
            <!--                                            <div class="row">-->
            <!--                                                <div class="col-lg-6 col-6">-->
            <!--                                                    <div class="d-flex"><img class="img-rounded" src="{{ asset('assets/imgs/profile.png') }}">-->
            <!--                                                        <div class="info-right-img"><span-->
            <!--                                                                class="font-sm font-bold color-brand-1 op-70">Zobpot</span><br><span-->
            <!--                                                                class="font-xs color-text-paragraph-2">-->
            <!--                                                                {{ \Carbon\Carbon::parse($row->datetime)->format('d F') }}-->
            <!--                                                                {{ \Carbon\Carbon::parse($row->datetime)->format('Y') }}-->
            <!--                                                            </span>-->
            <!--                                                        </div>-->
            <!--                                                    </div>-->
            <!--                                                </div>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        @endforeach-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="swiper-button-next"></div>-->
            <!--                <div class="swiper-button-prev"></div>-->
            <!--            </div>-->

            <!--        </div>-->
            <!--    </div>-->
            <!--</section>-->
        @endif

        @if (!$Testimonial->isEmpty())
            <section class="section-box mt-30 mb-40">
                <div class="container">
                    <h2 class="text-center mb-15 wow animate__animated animate__fadeInUp">Our Happy Customer</h2>
                    <div class="font-lg color-text-paragraph-2 text-center wow animate__animated animate__fadeInUp">When it comes to choosing the right web hosting provider, we know how easy it<br class="d-none d-lg-block"> is to get overwhelmed with the number.</div>
                    <div class="row mt-50">
                        <div class="box-swiper">
                            <div class="swiper-container swiper-group-3 swiper">
                                <div class="swiper-wrapper pb-70 pt-5">
                                    @foreach ($Testimonial as $row)
                                        <div class="swiper-slide">
                                            <div class="card-grid-6 hover-up">
                                                <div class="card-text-desc mt-10">
                                                    <p class="font-md color-text-paragraph">{{ $row->description }}</p>
                                                </div>
                                                <div class="card-image">
                                                    <div class="image">
                                                        <figure><img alt="jobBox"
                                                                src="{{ asset('uploads/testimonial_img/' . $row->profile_img) }}">
                                                        </figure>
                                                    </div>
                                                    <div class="card-profile">
                                                        <h6>{{ $row->username }}</h6><span>{{ $row->designation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="swiper-pagination swiper-pagination3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        @endif
<a href="https://wa.me/919512383123?text=Hello%20I%20want%20to%20know%20about%20Zobpot"
   class="whatsapp-float"
   target="_blank"
   rel="noopener">
    <i class="fa fa-whatsapp whatsapp-icon"></i>
</a>
<style>

    .whatsapp-float {
    position: fixed;
    width: 55px;
    height: 55px;
    bottom: 100px;
    right: 27px;
    background-color: #25D366;
    color: #fff;
    border-radius: 50%;
    text-align: center;
    font-size: 28px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform .2s ease, box-shadow .2s ease;
}

.whatsapp-float:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 16px rgba(0,0,0,0.35);
}

.whatsapp-icon {
    line-height: 1;
}

/* Mobile adjust */
@media (max-width: 576px) {
    .whatsapp-float {
        width: 50px;
        height: 50px;
        bottom: 15px;
        right: 15px;
        font-size: 24px;
    }
}

</style>
    </main>
@endsection
@push('script')
<script>
function showTab(tabName) {
    // Hide all tab contents
    var tabContents = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = 'none';
    }
    
    // Remove active class from all buttons
    var tabButtons = document.getElementsByClassName('tab-button');
    for (var i = 0; i < tabButtons.length; i++) {
        tabButtons[i].style.background = '#f8f9fa';
        tabButtons[i].style.color = '#242b62';
    }
    
    // Show selected tab and activate button
    document.getElementById(tabName).style.display = 'block';
    event.currentTarget.style.background = '#242b62';
    event.currentTarget.style.color = 'white';
}
</script>
@endpush