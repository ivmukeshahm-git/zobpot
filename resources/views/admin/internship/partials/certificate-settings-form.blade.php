@php
    $isCollege = $type === 'college';
@endphp

<form action="{{ route('admin.internship.certificate-settings.update') }}" method="POST">
    @csrf
    <input type="hidden" name="cert_type" value="{{ $type }}">

    <div class="mb-4">
        <span class="cert-preview-chip">{{ $isCollege ? 'College Certificate' : 'Company Certificate' }}</span>
        <p class="cert-settings-hint mb-0 mt-2">
            Placeholders like student name, opportunity title, company/college name, dates and certificate number are filled automatically from the student record.
        </p>
    </div>

    <h6 class="mb-3 text-primary">Header</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label">Brand Title</label>
            <input type="text" name="brand_title" class="form-control" value="{{ old('brand_title', $data['brand_title'] ?? '') }}" placeholder="ZobPot Opportunity Portal">
        </div>
        <div class="col-md-6">
            <label class="form-label">Badge Label</label>
            <input type="text" name="badge_label" class="form-control" value="{{ old('badge_label', $data['badge_label'] ?? '') }}" placeholder="{{ $isCollege ? 'College Certificate' : 'Company Certificate' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Main Heading</label>
            <input type="text" name="heading" class="form-control" value="{{ old('heading', $data['heading'] ?? '') }}" placeholder="Certificate">
        </div>
        <div class="col-md-6">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $data['subtitle'] ?? '') }}" placeholder="Of Program Completion">
        </div>
    </div>

    <h6 class="mb-3 text-primary">Body Text</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label">Certify Prefix</label>
            <input type="text" name="certify_text" class="form-control" value="{{ old('certify_text', $data['certify_text'] ?? '') }}" placeholder="This is to certify that">
            <div class="cert-settings-hint">Shown above the student name</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Completed Text</label>
            <input type="text" name="completed_text" class="form-control" value="{{ old('completed_text', $data['completed_text'] ?? '') }}" placeholder="has successfully completed the opportunity programme">
            <div class="cert-settings-hint">Shown below student name (before opportunity title)</div>
        </div>

        @if($isCollege)
            <div class="col-md-6">
                <label class="form-label">Student Of Text</label>
                <input type="text" name="student_of_text" class="form-control" value="{{ old('student_of_text', $data['student_of_text'] ?? '') }}" placeholder="a student of">
                <div class="cert-settings-hint">Before college / university name</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Pursuing Text</label>
                <input type="text" name="pursuing_text" class="form-control" value="{{ old('pursuing_text', $data['pursuing_text'] ?? '') }}" placeholder="pursuing">
                <div class="cert-settings-hint">Before degree name</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Association Text</label>
                <input type="text" name="association_text" class="form-control" value="{{ old('association_text', $data['association_text'] ?? '') }}" placeholder="in association with">
                <div class="cert-settings-hint">Before company name</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Awarded By Text</label>
                <input type="text" name="awarded_by_text" class="form-control" value="{{ old('awarded_by_text', $data['awarded_by_text'] ?? '') }}" placeholder="and is hereby awarded this certificate by">
                <div class="cert-settings-hint">Before college name at the end of the sentence</div>
            </div>
            <input type="hidden" name="conducted_by_text" value="">
        @else
            <div class="col-md-6">
                <label class="form-label">Conducted By Text</label>
                <input type="text" name="conducted_by_text" class="form-control" value="{{ old('conducted_by_text', $data['conducted_by_text'] ?? '') }}" placeholder="conducted by">
                <div class="cert-settings-hint">Before company name</div>
            </div>
            <input type="hidden" name="student_of_text" value="">
            <input type="hidden" name="pursuing_text" value="">
            <input type="hidden" name="association_text" value="">
            <input type="hidden" name="awarded_by_text" value="">
        @endif

        <div class="col-12">
            <label class="form-label">Disclaimer / Closing Statement</label>
            <textarea name="disclaimer_text" class="form-control" rows="3" placeholder="The intern has demonstrated...">{{ old('disclaimer_text', $data['disclaimer_text'] ?? '') }}</textarea>
        </div>
    </div>

    <h6 class="mb-3 text-primary">Signatures &amp; Seal Text</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label">Left Signatory Role</label>
            <input type="text" name="left_signatory_role" class="form-control" value="{{ old('left_signatory_role', $data['left_signatory_role'] ?? '') }}" placeholder="{{ $isCollege ? 'College Authorized Signatory' : 'Authorized Company Signatory' }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Platform Director Name</label>
            <input type="text" name="platform_director_name" class="form-control" value="{{ old('platform_director_name', $data['platform_director_name'] ?? '') }}" placeholder="ZobPot">
            <div class="cert-settings-hint">Used when director signature image is not uploaded</div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Platform Director Role</label>
            <input type="text" name="platform_director_role" class="form-control" value="{{ old('platform_director_role', $data['platform_director_role'] ?? '') }}" placeholder="Platform Director">
        </div>
        <div class="col-md-3">
            <label class="form-label">Seal Line 1</label>
            <input type="text" name="seal_line1" class="form-control" value="{{ old('seal_line1', $data['seal_line1'] ?? '') }}" placeholder="OFFICIAL">
        </div>
        <div class="col-md-3">
            <label class="form-label">Seal Line 2</label>
            <input type="text" name="seal_line2" class="form-control" value="{{ old('seal_line2', $data['seal_line2'] ?? '') }}" placeholder="SEAL">
            <div class="cert-settings-hint">Year is added automatically</div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Save {{ $isCollege ? 'College' : 'Company' }} Settings
        </button>
    </div>
</form>
