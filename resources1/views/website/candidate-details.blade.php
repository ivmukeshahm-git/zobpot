  @php
      $Setting = App\Models\Setting::where('id', 1)->first();
  @endphp
@if(!Auth::check())
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
@endif
@push('css')
<style>
    .read-more-btn {
    color: #f36825;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}

.read-more-btn:hover {
    text-decoration: underline;
}

.show-less {
    max-height: 70px;
    overflow: hidden;
}

</style>
@endpush
@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="section-box-2">
            <div class="container">
                <div class="banner-hero banner-image-single">
                    
                    <img
                        src="{{ asset('uploads/profile/candidate.jpeg')}}"
                        alt="jobbox">
                          
                </div>
                <div class="box-company-profile" @if($userData->cover_img == "") style="margin-top:30px;"  @endif>
                    <div class="image-compay">
                        @php
                        $profileImg = (!empty($userData->profile_img)
                            && file_exists(public_path('uploads/profile/'.$userData->profile_img)))
                            ? $userData->profile_img
                            : 'candidate.jpg';
                        @endphp

                        <img src="{{ asset('uploads/profile/'.$profileImg) }}"
                            style="max-width:100px;height:100px;object-fit:cover;"
                            alt="jobbox">
                        </div>
                    <div class="row mt-10">
                        <div class="col-lg-8 col-md-12">
                            <h5 class="f-18 mb-5">{{ $userData->name }} <span class="card-location font-regular ml-20"
                                    style="font-size: 14px;">{{ $userData->address }}</span></h5>
                            <p class="mt-0 mb-1 font-md color-text-paragraph-2">{{ $userData->designation }}</p>
                            @if($userData->gender)
                                <p class="mt-0 mb-1 font-bold color-text-paragraph-2 fw-semibold"
                                style="font-size: 14px;">
                                    @if($userData->gender == '1')
                                        <i class="fa fa-mars text-primary me-1"></i> Male
                                    @elseif($userData->gender == '2')
                                        <i class="fa fa-venus text-danger me-1"></i> Female
                                    @else
                                        <i class="fa fa-genderless text-secondary me-1"></i> Other
                                    @endif
                                </p>
                            @endif

                            <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-phone"
                                    aria-hidden="true"></i>&nbsp; Phone: {{ $userData->contact_no }} &nbsp;|&nbsp;
                                {{ $userData->city_nm }} &nbsp;|&nbsp; {{ $userData->state_name }} &nbsp;|&nbsp; India
                                &nbsp;|&nbsp; {{ $userData->zipcode }}</p>
                            <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-envelope"
                                    aria-hidden="true"></i>&nbsp; Email: {{ $userData->email }}</p>
                            <div class="box-tags mt-15">
                                <a style="font-weight: 600;">Skill :</a>
                                @php
                                    $Skill = [];

                                    if (!empty($userData->skills_id)) {
                                        $data = $userData->skills_id;

                                        // First decode
                                        $decoded = json_decode($data, true);

                                        // If still string (escaped JSON), decode again
                                        if (is_string($decoded)) {
                                            $decoded = json_decode($decoded, true);
                                        }

                                        $Skill = is_array($decoded) ? $decoded : [];
                                    }
                                @endphp


                                @foreach ($Skill as $row)
                                    <a class="btn btn-grey-small" style="font-weight: 600;">{{ $row }}</a>
                                @endforeach
                            </div>
                        </div>
                        @if (!empty($Resume?->file_nm))
                            <div class="col-lg-4 col-md-12 text-lg-end"><a download
                                    class="btn btn-download-icon btn-apply btn-apply-big"
                                    href="{{ asset('storage/resumes/' . $Resume->file_nm) }}">Download CV</a></div>
                        @endif
                    </div>
                </div>
                <div class="box-nav-tabs mt-40 mb-5">
                    <ul class="nav" role="tablist">
                        <li><a class="btn btn-border resume-icon mr-15 mb-5 active" style="padding: 12px 42px!important;"
                                href="#tab-resume" data-bs-toggle="tab" role="tab" aria-controls="tab-resume"
                                aria-selected="true">Resume</a></li>
                        <li><a class="btn btn-border aboutus-icon mr-15 mb-5" style="padding: 12px 42px!important;"
                                href="#tab-short-bio" data-bs-toggle="tab" role="tab" aria-controls="tab-short-bio"
                                aria-selected="true">About</a></li>
                        <li><a class="btn btn-border recruitment-icon mr-15 mb-5" style="padding: 12px 42px!important;"
                                href="#tab-skills" data-bs-toggle="tab" role="tab" aria-controls="tab-skills"
                                aria-selected="false">Work Experience</a></li>
                        <li><a class="btn btn-border people-icon mb-5" style="padding: 12px 42px!important;"
                                href="#tab-work-experience" data-bs-toggle="tab" role="tab"
                                aria-controls="tab-work-experience" aria-selected="false">Education</a></li>
                    </ul>
                </div>
                <div class="border-bottom pt-10 pb-10"></div>
            </div>
        </section>


        <section class="section-box mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="content-single">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-resume" role="tabpanel"
                                    aria-labelledby="tab-resume">
                                    <h4>Resume</h4>
                                    @if (!empty($Resume?->file_nm))
                                        <div class="table-responsive mt-20">
                                            <table class="table table-bordered align-middle">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 90px;">Sr No</th>
                                                        <th>Name</th>
                                                        <th style="width: 130px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ $Resume->file_nm }}</td>
                                                        <td>
                                                            <a class="btn btn-sm btn-outline-primary me-1 p-2" target="_blank"
                                                                href="{{ asset('storage/resumes/' . $Resume->file_nm) }}" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-outline-success p-2" download
                                                                href="{{ asset('storage/resumes/' . $Resume->file_nm) }}" title="Download">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="col-xl-12 col-12 mt-20">
                                            <h4 style="text-align: center;background: #eee;padding: 23px;">Resume Not Found</h4>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="tab-short-bio" role="tabpanel"
                                    aria-labelledby="tab-short-bio">
                                    <h4>About Me</h4>
                                    <p>{{ $userData->about }}</p>
                                </div>
                                <div class="tab-pane fade" id="tab-skills" role="tabpanel" aria-labelledby="tab-skills">
                                    <h4>Work Experience</h4>
                                    <div class="row form-contact mt-20">
                                        @if (count($WorkExperienceData) > 0)
                                            @foreach ($WorkExperienceData as $row)
                                                <div class="col-xl-12 col-12">
                                                    <div class="card-grid-2 hover-up">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="card-grid-2-image-left">
                                                                    <div class="image-box"><img
                                                                            src="{{ asset('assets/imgs/building.png') }}"
                                                                            style="max-width: 50px;" alt="jobBox"></div>
                                                                    <div class="right-info">
                                                                        <a class="name-job"
                                                                            href="javascript:void(0)">{{ $row->company }}</a>
                                                                        <span
                                                                            class="location-small">{{ $row->location }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-block-info">
                                                            <h4><a href="javascript:void(0)">{{ $row->title }}</a></h4>
                                                            <div class="mt-5">
                                                                <span
                                                                    class="card-briefcase">{{ $row->work_type_name }}</span>
                                                                <span class="card-time">
                                                                    <span>{{ \Carbon\Carbon::parse($row->start_date)->format('M Y') }}
                                                                        -
                                                                        {{ $row->working_status == '1' ? 'Present' : \Carbon\Carbon::parse($row->end_date)->format('M Y') }}
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <!-- <p class="work-desc font-sm color-text-paragraph mt-10">
                                                                {{ $row->role_responsibility }}
                                                            </p> -->
                                                            <p class="font-sm color-text-paragraph mt-10 show-less" data-fulltext="{{ $row->role_responsibility }}">
                                                                {{ $row->role_responsibility }}
                                                            </p>

                                                            <button type="button" class="read-more-btn p-0 mt-2" style="background:none;border:none;font-weight:600;color:#05264E ;">
                                                                Read More...
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-xl-12 col-12">
                                                <h4 style="text-align: center;background: #eee;padding: 23px;">Work
                                                    Experience Not Found</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-work-experience" role="tabpanel"
                                    aria-labelledby="tab-work-experience">
                                    <h4>Education</h4>
                                    <div class="row form-contact mt-20">
                                        @if (count($EducationData) > 0)
                                            @foreach ($EducationData as $row)
                                                <div class="col-xl-12 col-12">
                                                    <div class="card-grid-2 hover-up">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="card-grid-2-image-left">
                                                                    <div class="image-box"><img
                                                                            src="{{ asset('assets/imgs/school.png') }}"
                                                                            style="max-width: 50px;" alt="jobBox"></div>
                                                                    <div class="right-info"><a class="name-job"
                                                                            href="#">{{ $row->school_name }}</a><span
                                                                            class="location-small"></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-block-info">
                                                            <h4 class="mt-5 mb-5"><a
                                                                    href="javascript:void(0);">{{ $row->degree }} -
                                                                    {{ $row->field_of_study }}</a></h4>
                                                            <div class="mt-5"><span
                                                                    class="card-briefcase">{{ $row->grade }}</span><span
                                                                    class="card-time"><span>{{ $row->end_date }}</span></span>
                                                            </div>
                                                            <div class="mt-5">
                                                                <p class="show-less"data-fulltext="{{ $row->description }}">
                                                                    {{ $row->description }}
                                                                </p>

                                                                <button type="button" class="read-more-btn p-0 mt-2" style="background:none;border:none;font-weight:600;color:#05264E ;">
                                                                    Read More...
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-xl-12 col-12">
                                                <h4 style="text-align: center;background: #eee;padding: 23px;">Education
                                                    Not Found</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
                        @if ($userData->experience || $userData->expected_salary || $userData->languages)
                            <div class="sidebar-border">
                                <h5 class="f-18">Overview</h5>
                                <div class="sidebar-list-job">
                                    <ul>
                                        @if ($userData->experience)
                                            <li>
                                                <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                                                <div class="sidebar-text-info"><span
                                                        class="text-description">Experience</span><strong
                                                        class="small-heading">{{ $userData->experience }}</strong>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($userData->expected_salary)
                                            <li>
                                                <div class="sidebar-icon-item"><i class="fi-rr-dollar"></i></div>
                                                <div class="sidebar-text-info"><span class="text-description">Expected
                                                        Salary</span><strong
                                                        class="small-heading">{{ $userData->expected_salary }}</strong>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($userData->languages)
                                            <li>
                                                <div class="sidebar-icon-item"><i class="fa fa-language"></i></div>
                                                <div class="sidebar-text-info"><span
                                                        class="text-description">Language</span><strong
                                                        class="small-heading">{{ implode(', ', json_decode($userData->languages ?? '[]')) }}</strong>
                                                </div>
                                            </li>
                                        @endif


                                    </ul>
                                    {{-- <div class="mt-30">
                                        <a target="_blank" href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $userData->email }}" class="btn btn-send-message">
                                            Send Message
                                        </a>
                                    </div> --}}
                                    <div class="mt-5">
                                        <a class="btn btn-send-message"
                                        target="_blank"
                                        href="https://wa.me/{{ preg_replace('/\D/', '', $Setting ? $Setting->contact_2 : '') }}">
                                            <i class="fa fa-whatsapp"></i>
                                            Send Message
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($adBanner)
                            <div class="sidebar-border-bg bg-right" style="padding: 3px!important;">
                                <a href="{{ $adBanner->ad_link }}" target="_blank">
                                    <img src="{{ asset('uploads/ad_banner_img/' . $adBanner->img_nm) }}" alt="img">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
@push('script')

<script>
document.querySelectorAll('.read-more-btn').forEach((btn) => {
    btn.addEventListener('click', function () {
        const descEl = this.previousElementSibling;
        const fullText = descEl.getAttribute('data-fulltext');

        if (descEl.classList.contains('show-less')) {
            
            descEl.classList.remove('show-less');
            descEl.innerText = fullText;
            this.textContent = "Read Less";

        } else {

            const shortText = fullText.substring(0, 90);
            descEl.classList.add('show-less');
            descEl.innerHTML = shortText + '<span class="dots">...</span>';
            this.textContent = "Read More";
        }
    });
});

</script>

@endpush