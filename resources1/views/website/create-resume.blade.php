@extends('website.layout.layout')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <style>
        #resumePreview {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2,
        h4 {
            margin-bottom: 10px;
        }

        .section-title {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }

        #previewPhotoFinal {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .watermark-container {
            position: relative;
            padding: 15px;
            flex: 1;
            z-index: 1;
            height: 100%
        }

        .watermark-container::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            height: 300px;
            background-image: url('{{ $Setting && $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}');
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            /* Adjust transparency */
            z-index: 0;
        }

        .watermark-container>* {
            position: relative;
            z-index: 2;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: #fff;
            }

            #resumePreview {
                width: 210mm;
                height: 297mm;
                padding: 20mm;
                box-sizing: border-box;
                page-break-after: avoid;
                border-radius: 0 !important;
                box-shadow: none !important;
            }

            .watermark-container {
                background-image: url('{{ $Setting && $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('assets/imgs/logo/logo1.png') }}');
                background-repeat: no-repeat;
                background-position: center center;
                background-size: 200px;
                opacity: 0.1;
            }

            /* Hide everything except the resume */
            body * {
                visibility: hidden;
            }

            #resumePreview,
            #resumePreview * {
                visibility: visible;
            }

            #resumePreview {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endpush

@section('website-content')
    <main class="main">
        <section class="section-box">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="mb-10">Zobpot</h2>
                            <!-- <h2 class="mb-10">Zobpot Resume Builder</h2> -->
                            <p class="font-lg color-text-paragraph-2">Build a Professional Resume</p>
                        </div>
                        <!-- <div class="col-lg-6 text-lg-end">
                            <ul class="breadcrumbs mt-40">
                                <li><a class="home-icon" href="{{ route('home') }}">Home</a></li>
                                <li>Zobpot Resume Builder</li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box mt-50 mb-50">
            <div class="container">
                <div class="post-loop-grid">
                    <div class="text-center mb-50">
          
                        <!-- <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp mb-20" style="border: none;">Resume Builder</h2> -->
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp mb-20" style="border: none;"> Resume Templates</h2>
                        <p class="font-sm color-text-paragraph wow animate__animated animate__fadeInUp w-100 mx-auto">
                            Our Resume Builder is a powerful and easy-to-use tool designed to help job seekers create
                            professional resumes in minutes. Whether you're a fresher or an experienced professional, you
                            can quickly enter your details, preview your resume in real time, and download it as a
                            high-quality PDF. Customize your information, highlight your skills and experience, and stand
                            out in today's competitive job market with a polished and modern resume.</p>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <form id="resumeForm" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="user_id" name="user_id"
                                        value="{{ $user ? $user->id : '' }}">
                                    <input type="hidden" id="row_id" name="row_id"
                                        value="{{ $ResumeData ? $ResumeData->id : '' }}">
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <img id="previewPhoto" src="{{ asset('assets/imgs/profile.png') }}" alt="Profile" class="mt-2" width="80">
                                        </div>
                                    </div>

                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                            <label>Profile Photo</label>
                                            <input type="file" class="form-control" id="profileImage" accept="image/*">

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" id="fullName"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->full_name : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" id="designation" name="designation"
                                                value="{{ $ResumeData ? $ResumeData->designation : '' }}"
                                                oninput="updatePreview()" @if ($ResumeData && $ResumeData->designation == 'Fresher') readonly @endif>

                                            <span class="d-flex align-items-center mt-2">
                                                <input type="checkbox" id="is_fresher" name="is_fresher"
                                                    style="max-width: 15px;" onclick="handleFresherCheckbox()"
                                                    @if ($ResumeData && $ResumeData->designation == 'Fresher') checked @endif>
                                                <label for="is_fresher" class="mb-0 ms-1">Are you a fresher?</label>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="email"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->email : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" id="phone"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->phone : '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label>DOB</label>
                                            <input type="date" class="form-control" id="dob"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->dob : '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label>Marital status</label>
                                            <select name="marital_status" onchange="updatePreview()" class="form-select form-control"  id="marital_status">
                                                <option value="Unmarried" @if ($ResumeData && $ResumeData->marital_status == 'Unmarried') selected @endif>Unmarried</option>
                                                <option value="Married" @if ($ResumeData && $ResumeData->marital_status == 'Married') selected @endif>Married</option>
                                                <option value="Widow" @if ($ResumeData && $ResumeData->marital_status == 'Widow') selected @endif>Widow</option>
                                                <option value="Widower" @if ($ResumeData && $ResumeData->marital_status == 'Widower') selected @endif>Widower</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label>Address</label> 
                                            <input type="text" class="form-control"  id="address"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->address : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label>languages Known</label> 
                                            <input type="text" class="form-control" id="language_known"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->language_known : '' }}">
                                        </div>
                                    </div>
                                    
                                     <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label>Gender</label>
                                            <select name="gender" id="gender" onchange="updatePreview()" class="form-select form-control" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male" @if ($ResumeData && $ResumeData->gender == 'Male') selected @endif>Male</option>
                                            <option value="Female" @if ($ResumeData && $ResumeData->gender == 'Female') selected @endif>Female</option>
                                            <option value="Other" @if ($ResumeData && $ResumeData->gender == 'Other') selected @endif>Other</option>
                                        </select>

                                        </div>
                                    </div>
                                    
                                    

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Skills (comma separated)</label>
                                            <input type="text" class="form-control" id="skills"
                                                oninput="updatePreview()"
                                                value="{{ $ResumeData ? $ResumeData->skills : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Summary/Objective</label>
                                            <textarea style="height: 150px;" class="form-control" id="summary" rows="6" oninput="updatePreview()">{{ $ResumeData ? $ResumeData->summary : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Experience</label>
                                            <textarea style="height: 150px;" class="form-control" id="experience" rows="6" oninput="updatePreview()">{{ $ResumeData ? $ResumeData->experience : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label>Education</label>
                                            <textarea style="height: 150px;" class="form-control" id="education" rows="6" oninput="updatePreview()">{{ $ResumeData ? $ResumeData->education : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-success mt-3"
                                            onclick="downloadPDF()">Download as PDF</button>

                                        <button type="button" class="btn btn-success mt-3" onclick="SaveResume()">Update & Save Resume</button>
                                        {{-- <button type="button" class="btn btn-primary mt-3"
                                            onclick="downloadImage()">Download
                                            as Image</button> --}}
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 mt-20">
                            <div id="pdfPreviewHtml">
                                <div id="resumePreview"
                                    style=" width: 210mm;
                                box-sizing: border-box;
                                page-break-after: avoid;
                                box-shadow: none !important;display: flex;padding:7px;     border: 3px solid #eee;
    border-radius: 19px;
">
                                    <div
                                        style="position: relative; width: 235px; background: #242a62; color: #fff; border-radius: 12px 0 0 12px; padding: 15px; box-sizing: border-box; min-height: 100%;">

                                        <div style="text-align: center; margin-bottom: 28px;">
                                            <img id="previewPhotoFinal" src="{{ asset('assets/imgs/profile.png') }}"
                                                alt="Photo"
                                                style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 4px solid #f26824; box-shadow: 0 2px 8px rgba(0,0,0,0.08);" />
                                            <h3 id="previewName"
                                                style="margin-top: 14px; font-size: 1.6rem; color: #fff;">
                                                Your
                                                Name
                                            </h3>
                                        </div>

                                        <div style="margin-bottom: 24px;">
                                            <strong style="font-size: 15px;">Contact</strong>
                                            <div style="font-size: 0.95em; margin-top: 8px;">
                                                <div id="previewEmail"><i class="fa fa-envelope"></i>&nbsp;
                                                    email@example.com
                                                </div>
                                                <div id="previewPhone"><i class="fa fa-phone"></i>&nbsp; 123-456-7890
                                                </div>
                                                
                                               
                                            </div>
                                        </div>
                                        
                                        <div style="margin-bottom: 24px;">
                                            <strong style="font-size: 15px;">Personal information</strong>
                                            <div style="font-size: 0.95em; margin-top: 8px;">
                                                <div id="previewDob"><i class="fa fa-calendar"></i>&nbsp; 123-456-7890
                                                </div>
                                                
                                                <div id="previewMaritalStatus"><i class="fa fa-circle-o"></i>&nbsp; 123-456-7890
                                                </div>
                                                
                                                 <div id="previewGender"><i class="fa fa-solid fa-mars-stroke"></i>&nbsp; 123-456-7890
                                                </div>
                                                
                                                
                                                 <div id="previewLanguageKnown"><i class="fa fa-solid fa-globe"></i>&nbsp; 123-456-7890
                                                </div>
                                                
                                                 <div id="previewLocation"><i class="fa fa-map-marker"></i>&nbsp; 123-456-7890
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        <div style="margin-bottom: 24px;">
                                            <strong>Skills</strong>
                                            <ul id="previewSkills" style="margin-top: 8px; padding-left: 0px;">
                                                <li><i class="fa fa-check"
                                                        style="color: #4caf50; margin-right: 6px;"></i></li>
                                                <li><i class="fa fa-check"
                                                        style="color: #4caf50; margin-right: 6px;"></i>
                                                </li>
                                                <li><i class="fa fa-check"
                                                        style="color: #4caf50; margin-right: 6px;"></i>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Copyright fixed at bottom center -->
                                        <div
                                            style="position: absolute;bottom: 12px;left: 50%;transform: translateX(-50%);font-size: 0.8rem;text-align: center;color: #ccc;width: 100%;margin-top:30px;">
                                            © Designed by Zobpot
                                        </div>
                                    </div>


                                    <div style="flex:1; padding: 10px;">
                                        <div class="watermark-container">
                                            <div style="padding-bottom: 18px; margin-bottom: 32px;">
                                                <h2 id="previewNameMain"
                                                    style="margin-bottom: 0.2em; font-size: 2.3rem; font-weight: bold; color: #22304a;">
                                                    Your Name</h2>
                                                <div style="color: #6c7a89; font-size: 1.15rem;" id="previewDesignation">
                                                    Designation</div>
                                            </div>
                                            <div class="section" style="margin-bottom: 28px;">
                                                <h4 class="section-title"
                                                    style="color: #305094; margin-bottom: 8px; font-size: 1.14rem; font-weight: 700;">
                                                    Summary</h4>
                                                <p id="previewSummary"
                                                    style="font-size: 14px;font-weight: 500;color: #787878;">A
                                                    brief summary about yourself...
                                                </p>
                                            </div>
                                            <div class="section" style="margin-bottom: 28px;">
                                                <h4 class="section-title"
                                                    style="color: #305094; margin-bottom: 8px; font-size: 1.14rem; font-weight: 700;">
                                                    Experience</h4>
                                                <p id="previewExperience"
                                                    style="font-size: 14px;font-weight: 500;color: #787878;">Job experience
                                                    goes
                                                    here...</p>
                                            </div>

                                            <div class="section" style="margin-bottom: 28px;">
                                                <h4 class="section-title"
                                                    style="color: #305094; margin-bottom: 8px; font-size: 1.14rem; font-weight: 700;">
                                                    Education</h4>
                                                <p id="previewEducation"
                                                    style="font-size: 14px;font-weight: 500;color: #787878;">
                                                    Education goes here...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="modal fade" id="cropperModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class="modal-title">Crop Profile Photo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="cropImage" class="img-fluid" style="max-height:400px;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cropAndSave" class="btn btn-primary">Crop & Use</button>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </main>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        let cropper;
        document.getElementById('profileImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('cropImage').src = event.target.result;
                const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
                modal.show();
                setTimeout(() => {
                    cropper = new Cropper(document.getElementById('cropImage'), {
                        aspectRatio: 1,
                        viewMode: 1
                    });
                }, 200);
            };
            reader.readAsDataURL(file);
        });



        function SaveResume() {
            var image_src = document.getElementById("previewPhotoFinal");
            var image = compress_org(image_src, 100, 'image/webp').src;
            image = image.split(",")[1];

            var fullName = $("#fullName").val();
            var designation = $("#designation").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var skills = $("#skills").val();
            var summary = $("#summary").val();
            var experience = $("#experience").val();
            var education = $("#education").val();

            var user_id = $("#user_id").val();
            var row_id = $("#row_id").val();

            var ResumeHtml = $("#pdfPreviewHtml").html();

            // console.log(ResumeHtml);


            // ✅ Use FormData instead of plain object
            var formData = new FormData();
            formData.append('row_id', row_id);
            formData.append('user_id', user_id);
            formData.append('image', image);
            formData.append('full_name', fullName);
            formData.append('designation', designation);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('skills', skills);
            formData.append('summary', summary);
            formData.append('experience', experience);
            formData.append('education', education);
            formData.append('resume', ResumeHtml); // make sure HTML is valid

const dob = document.getElementById('dob').value;
const mstatus = document.getElementById('marital_status').value;
const address = document.getElementById('address').value;
const languageKnown = document.getElementById('language_known').value;
const gender = document.getElementById('gender').value;
//new fields

            formData.append('dob', dob);
            formData.append('marital_status', mstatus);
            formData.append('language_known', languageKnown);
            formData.append('gender', gender);
            formData.append('address', address);
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            $.ajax({
                type: "POST",
                url: "{{ route('create-resume-action') }}",
                data: formData,
                processData: false, // ✅ for FormData
                contentType: false, // ✅ for FormData
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
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
                    let errorMsg = "Something went wrong";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        errorMsg = res.message || errorMsg;
                    } catch (e) {}
                    console.log(errorMsg);
                    // ErrorMsg(errorMsg);
                }
            });
        }


        document.getElementById('cropAndSave').addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas({
                width: 100,
                height: 100
            });
            const base64Image = canvas.toDataURL('image/png');
            document.getElementById('previewPhoto').src = base64Image;
            document.getElementById('previewPhotoFinal').src = base64Image;
            bootstrap.Modal.getInstance(document.getElementById('cropperModal')).hide();
            cropper.destroy();
        });

        function updatePreview() {
            const name = document.getElementById('fullName').value || 'Your Name';
            const email = document.getElementById('email').value || 'email@example.com';
            const phone = document.getElementById('phone').value || '123-456-7890';
            const designation = document.getElementById('designation').value || 'Designation';
            const summary = document.getElementById('summary').value || 'A brief summary about yourself...';
            const experience = document.getElementById('experience').value || 'Job experience goes here...';
            const education = document.getElementById('education').value || 'Education goes here...';
            const skills = document.getElementById('skills').value;

// new fields

// const dob = document.getElementById('dob').value;
const mstatus = document.getElementById('marital_status').value;
const address = document.getElementById('address').value;
const languageKnown = document.getElementById('language_known').value;
const gender = document.getElementById('gender').value;

const dobInput = document.getElementById('dob').value;

// Format date to DD/MM/YYYY
let dob = "";
if (dobInput) {
    const dateObj = new Date(dobInput);
    const day = String(dateObj.getDate()).padStart(2, '0');
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const year = dateObj.getFullYear();
    dob = `${day}/${month}/${year}`;
}
// previewDob ,previewMaritalStatus,previewGender,previewLanguageKnown,previewLocation
// dob,marital_status,address,language_known,gender
            // ✅ Store in sessionStorage
            sessionStorage.setItem('resumeData', JSON.stringify({
                name,
                email,
                phone,
                designation,
                summary,
                experience,
                education,
                skills,
                dob,
                mstatus,
                address,
                languageKnown,
                gender
            }));

            // Update preview UI
            document.getElementById('previewDesignation').innerText = designation;
            document.getElementById('previewName').innerText = name;
            document.getElementById('previewNameMain').innerText = name;
            document.getElementById('previewEmail').innerHTML = `<i class="fa fa-envelope"></i>&nbsp; ${email}`;
            document.getElementById('previewPhone').innerHTML = `<i class="fa fa-phone"></i>&nbsp; ${phone}`;
            document.getElementById('previewSummary').innerText = summary;
            
            
              // New Update preview UIs
            document.getElementById('previewDob').innerHTML = `<i class="fa fa-calendar"></i>&nbsp; ${dob}`;
            document.getElementById('previewMaritalStatus').innerHTML =`<i class="fa fa-circle-o"></i>&nbsp; ${mstatus}`;
            document.getElementById('previewGender').innerHTML = `<i class="fa fa-solid fa-mars-stroke"></i>&nbsp; ${gender}`;
            document.getElementById('previewLanguageKnown').innerHTML = `<i class="fa fa-solid fa-globe"></i>&nbsp; ${languageKnown}`;
            document.getElementById('previewLocation').innerHTML = `<i class="fa fa-map-marker"></i>&nbsp; ${address}`;
          
            

            const skillArray = skills.split(',').filter(s => s.trim() !== '');
            document.getElementById('previewSkills').innerHTML = skillArray.map(s =>
                `<li><i class="fa fa-check" style="color: #4caf50; margin-right: 6px;"></i> ${s.trim()}</li>`
            ).join('') || '<li></li>';

            document.getElementById('previewExperience').innerText = experience;
            document.getElementById('previewEducation').innerText = education;
        }


        window.onload = function() {
            const saved = sessionStorage.getItem('resumeData');
            if (saved) {
                const data = JSON.parse(saved);

                document.getElementById('fullName').value = data.name;
                document.getElementById('email').value = data.email;
                document.getElementById('phone').value = data.phone;
                document.getElementById('designation').value = data.designation;
                document.getElementById('summary').value = data.summary;
                document.getElementById('experience').value = data.experience;
                document.getElementById('education').value = data.education;
                document.getElementById('skills').value = data.skills;

                updatePreview(); // Update the preview section with restored values
            }
        };

        function downloadPDF() {
            const element = document.getElementById('resumePreview');

            const opt = {
                margin: 0,
                filename: 'resume.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    scrollY: 0
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                },
                pagebreak: {
                    mode: ['css', 'legacy'] // Allows automatic page breaks
                }
            };

            html2pdf().set(opt).from(element).save();
        }


        function triggerPDF() {
            html2pdf().from(document.getElementById('resumePreview')).set({
                margin: 0.5,
                filename: 'resume.pdf',
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            }).save();
        }

        function downloadImage() {
            const node = document.getElementById('resumePreview');
            html2canvas(node, {
                scale: 2,
                useCORS: true
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'resume.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }


        function handleFresherCheckbox() {
            const checkbox = document.getElementById('is_fresher');
            const designationInput = document.getElementById('designation');
            const experienceInput = document.getElementById('experience');
            // const educationInput = document.getElementById('education');

            if (checkbox.checked) {
                designationInput.value = 'Fresher';
                designationInput.readOnly = true;

                experienceInput.readOnly = true;
                // educationInput.readOnly = true;

                experienceInput.value = '';
                // educationInput.value = '';


            } else {
                designationInput.value = '';
                designationInput.readOnly = false;
                experienceInput.readOnly = false;
                // educationInput.readOnly = false;

            }

            updatePreview()
        }

        // Optional: Keep checkbox checked if value was already 'Fresher'
        document.addEventListener("DOMContentLoaded", function() {
            const designationInput = document.getElementById('designation');
            const checkbox = document.getElementById('is_fresher');
            if (designationInput.value === 'Fresher') {
                checkbox.checked = true;
                designationInput.readOnly = true;
            }
        });
    </script>
@endpush
