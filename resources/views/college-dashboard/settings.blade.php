@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeSettings";
</script>

<div class="container-xxl flex-grow-1 container-p-y">
    @include('admin.layout.partials.college-page-banner', [
        'emoji' => '⚙️',
        'title' => 'College Settings',
        'subtitle' => 'Update college profile details and certificate branding images.',
        'illustration' => 'settings',
        'crumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.college.dashboard')],
            ['label' => 'Settings'],
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form id="college-settings-form" enctype="multipart/form-data">
                @csrf

                <h6 class="text-primary mb-3">Profile Details</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">College Name</label>
                        <input type="text" class="form-control" value="{{ $college->college_name }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">College Code</label>
                        <input type="text" class="form-control" value="{{ $college->college_code ?? 'N/A' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $college->email }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ $college->phone }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">University</label>
                        <input type="text" class="form-control" value="{{ $college->university->university_name ?? 'N/A' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" value="{{ $college->website }}" placeholder="https://example.com">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2">{{ $college->address }}</textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ $college->city }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ $college->state }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" class="form-control" name="pincode" value="{{ $college->pincode }}">
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="text-primary mb-3">Certificate Images</h6>
                <p class="text-muted small mb-3">
                    These images are used on the <strong>College Certificate</strong> (left logo and authorized signatory).
                </p>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">Certificate Logo</label>
                        <p class="text-muted small mb-2">Recommended size: <strong>150 × 150 px</strong> (PNG/JPG, max 2MB)</p>
                        <div class="border rounded p-3 text-center bg-light">
                            <img id="certificateLogoPreview"
                                 src="{{ (!empty($college->certificate_logo) && file_exists(public_path('uploads/college/'.$college->certificate_logo)))
                                    ? asset('uploads/college/'.$college->certificate_logo)
                                    : ((!empty($college->logo) && file_exists(public_path(ltrim($college->logo, '/'))))
                                        ? asset(ltrim($college->logo, '/'))
                                        : asset('assets/imgs/logo/logo1.png')) }}"
                                 alt="Certificate Logo"
                                 style="max-width: 100%; max-height: 80px; object-fit: contain;">
                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-primary" onclick="$('#certificate_logo').click()">
                                    <i class="bx bx-upload"></i> Upload Logo
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCertificateLogo()">
                                    <i class="bx bx-trash"></i> Remove
                                </button>
                            </div>
                            <input type="file" name="certificate_logo" id="certificate_logo" accept="image/png,image/jpeg,image/jpg" class="d-none" onchange="previewCertificateLogo(this)">
                            <input type="hidden" name="remove_certificate_logo" id="remove_certificate_logo" value="0">
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">College Authorized Signatory</label>
                        <p class="text-muted small mb-2">Recommended size: <strong>300 × 80 px</strong> (PNG/JPG, max 2MB)</p>
                        <div class="border rounded p-3 text-center bg-light">
                            <img id="collegeSignaturePreview"
                                 src="{{ (!empty($college->college_signature) && file_exists(public_path('uploads/college/'.$college->college_signature)))
                                    ? asset('uploads/college/'.$college->college_signature)
                                    : asset('assets/imgs/logo/logo1.png') }}"
                                 alt="College Signature"
                                 style="max-width: 100%; max-height: 60px; object-fit: contain;">
                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-primary" onclick="$('#college_signature').click()">
                                    <i class="bx bx-upload"></i> Upload Signature
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCollegeSignature()">
                                    <i class="bx bx-trash"></i> Remove
                                </button>
                            </div>
                            <input type="file" name="college_signature" id="college_signature" accept="image/png,image/jpeg,image/jpg" class="d-none" onchange="previewCollegeSignature(this)">
                            <input type="hidden" name="remove_college_signature" id="remove_college_signature" value="0">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info py-2 small mb-4">
                    <i class="bx bx-info-circle"></i>
                    On the college certificate, the logo appears at the top-left and the signatory image appears above
                    <em>College Authorized Signatory</em>. Use a transparent PNG for best results.
                </div>

                <button type="submit" class="btn btn-primary" id="saveSettingsBtn">
                    <i class="bx bx-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
var defaultLogoSrc = @json(asset('assets/imgs/logo/logo1.png'));

function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewCertificateLogo(input) {
    document.getElementById('remove_certificate_logo').value = '0';
    previewImage(input, 'certificateLogoPreview');
}

function previewCollegeSignature(input) {
    document.getElementById('remove_college_signature').value = '0';
    previewImage(input, 'collegeSignaturePreview');
}

function removeCertificateLogo() {
    document.getElementById('remove_certificate_logo').value = '1';
    document.getElementById('certificate_logo').value = '';
    document.getElementById('certificateLogoPreview').src = defaultLogoSrc;
}

function removeCollegeSignature() {
    document.getElementById('remove_college_signature').value = '1';
    document.getElementById('college_signature').value = '';
    document.getElementById('collegeSignaturePreview').src = defaultLogoSrc;
}

$(function () {
    $('#college-settings-form').on('submit', function (e) {
        e.preventDefault();
        var btn = $('#saveSettingsBtn');
        btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Saving...');

        var formData = new FormData(this);

        $.ajax({
            url: @json(route('admin.college.settings.update')),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (res) {
                if (res.status == 1) {
                    toastr.success(res.message);
                    setTimeout(function () { location.reload(); }, 800);
                } else {
                    toastr.error(res.message || 'Failed to save settings.');
                }
            },
            error: function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong.';
                toastr.error(msg);
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="bx bx-save"></i> Save Settings');
            }
        });
    });
});
</script>
@endpush
