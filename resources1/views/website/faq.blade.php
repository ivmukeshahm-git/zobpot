@extends('website.layout.layout')
@section('website-content')
    <script>
        page_active_id = "About";
    </script>

    <main class="main">
        <!-- 🧾 Terms and Conditions Section -->
        <section class="section-box">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="mb-10">FAQ</h2>
                           
                        </div>
                        <div class="col-lg-6 text-lg-end">
                            <ul class="breadcrumbs mt-40">
                                <li><a class="home-icon" href="{{ route('home') }}">Home</a></li>
                                <li>FAQ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

   
        <!-- 💡 FAQ Section -->
        <section class="section-box mt-50">
            <div class="container">
                <div class="text-center mb-50">
                    <h2 class="section-title wow animate__animated animate__fadeInUp">ZOBPOT FAQ</h2>
                    <p class="color-text-paragraph">Find answers to common questions about Zobpot.</p>
                </div>

                <div class="row mb-70">
                    <div class="col-lg-12">
                        <!-- FIND A JOB -->
                        <h4 class="mt-20">🔹 FIND A JOB</h4>

                        <h6 class="mt-15">1. What is Zobpot?</h6>
                        <p class="font-sm color-text-paragraph">
                            Zobpot is an online job portal that connects job seekers with employers. It helps candidates
                            find suitable job opportunities based on their skills, experience, and preferences. At the
                            same time, it allows companies to post job openings and find the right talent efficiently.
                        </p>

                        <h6 class="mt-15">2. How can I find a job on Zobpot?</h6>
                        <ul class="font-sm color-text-paragraph">
                            <li><strong>Create an Account:</strong> Sign up with your email and basic details.</li>
                            <li><strong>Complete Your Profile:</strong> Add your resume, skills, experience, and preferences.</li>
                            <li><strong>Search For Jobs:</strong> Use filters like location, industry, job type, and experience level.</li>
                            <li><strong>Apply Easily:</strong> Click on the job you like and apply directly through Zobpot.</li>
                        </ul>

                        <h6 class="mt-15">3. Do I need to create an account to apply for a job?</h6>
                        <p class="font-sm color-text-paragraph">
                            Yes, you need to create an account on Zobpot to apply for jobs. This allows you to:
                        </p>
                        <ul class="font-sm color-text-paragraph">
                            <li>Apply for jobs quickly and easily</li>
                            <li>Save your profile and resume</li>
                            <li>Get personalized job recommendations</li>
                        </ul>

                        <h6 class="mt-15">4. How do I know if my job application was accepted?</h6>
                        <p class="font-sm color-text-paragraph">
                            Log in to your Zobpot account and go to your dashboard or "My Applications" section.
                        </p>

                        <h6 class="mt-15">5. Can employers contact me directly?</h6>
                        <p class="font-sm color-text-paragraph">
                            Yes, employers can contact you directly through Zobpot if your profile matches their job
                            requirements. They can send you messages, invite you to interviews, or ask for more
                            information.
                        </p>

                        <!-- HIRE -->
                        <h4 class="mt-30">🔹 HIRE</h4>

                        <h6 class="mt-15">1. How can I post a job on Zobpot?</h6>
                        <p class="font-sm color-text-paragraph">
                            Create an employer account by signing up as an employer on Zobpot.
                        </p>

                        <!-- <h6 class="mt-15">2. Is posting a job free on Zobpot?</h6>
                        <p class="font-sm color-text-paragraph">
                            Yes, basic job posting is free for employers. Premium options are available for higher reach and visibility.
                        </p> -->

                        <h6 class="mt-15">2. Can I Post a Job For Free?</h6>
                        <p class="font-sm color-text-paragraph">
                            No,Job Posting Requires a Paid Service Package.
                        </p>

                        <h6 class="mt-15">3. Can I edit or update my job post after posting?</h6>
                        <p class="font-sm color-text-paragraph">
                            Yes, you can easily edit or update your job post anytime from your employer dashboard.
                        </p>

                        <!-- ABOUT US -->
                        <h4 class="mt-30">🔹 ABOUT US</h4>

                        <h6 class="mt-15">1. Who can use Zobpot?</h6>
                        <p class="font-sm color-text-paragraph">
                            Anyone looking for a job or an employee can use Zobpot – from freshers to experienced
                            professionals, and from small businesses to large companies.
                        </p>

                        <h6 class="mt-15">2. Is Zobpot free to use?</h6>
                        <p class="font-sm color-text-paragraph">
                            Yes, Zobpot is completely free for job seekers. Employers can post jobs for free with basic
                            features, while premium plans offer more visibility and reach.
                        </p>

                        <h6 class="mt-15">3. When was Zobpot founded?</h6>
                        <p class="font-sm color-text-paragraph">
                            Zobpot was founded in 2025 with a vision to simplify the job search and hiring process by
                            connecting people and businesses efficiently.
                        </p>

                        <h6 class="mt-15">4. How does Zobpot help companies?</h6>
                        <p class="font-sm color-text-paragraph">
                            Zobpot helps employers find the right talent quickly and efficiently by offering tools to
                            post jobs, review applications, and connect directly with qualified candidates.
                        </p>

                        <h6 class="mt-15">5. How can I contact Zobpot?</h6>
                        <p class="font-sm color-text-paragraph">
                            📧 <strong>Email:</strong> support@zobpot.com<br>
                            📞 <strong>Contact Form:</strong> Available on the “Contact Us” page<br>
                            🌐 <strong>Social Media:</strong> Facebook, Instagram, LinkedIn<br>
                            ⏰ <strong>Support Hours:</strong> Monday to Saturday, 10:00 AM – 6:00 PM
                        </p>
                        
                        
                         <p class="font-sm color-text-paragraph">
                           Our team is available Monday to Saturday, 10:00 am – 6:00 pm, to assist you with any queries.  
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
