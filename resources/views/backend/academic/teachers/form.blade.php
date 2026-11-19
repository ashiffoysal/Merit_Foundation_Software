@extends('backend.academic.layout')
@section('page')
@php $editing = $teacher->exists; @endphp
@include('backend.academic.partials.page-header', [
    'title' => $editing ? 'Edit Teacher' : 'Add Teacher',
    'subtitle' => $editing ? $teacher->full_name : 'Fields marked * are required',
    'actions' => '<a href="' . ($editing ? route('admin.teachers.show', $teacher) : route('admin.teachers.index')) . '" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>',
])

<form method="POST" action="{{ $editing ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" enctype="multipart/form-data" data-ajax-form novalidate>
    @csrf
    @if($editing) @method('PUT') @endif

    <div class="card">
        <ul class="nav ac-tabs" role="tablist">
            <x-academic.tab id="t-personal" label="Personal Information" icon="fa-user" active />
            <x-academic.tab id="t-employment" label="Employment Information" icon="fa-briefcase" />
            <x-academic.tab id="t-documents" label="Documents" icon="fa-file-alt" />
            <x-academic.tab id="t-account" label="Account Information" icon="fa-key" />
        </ul>

        <div class="tab-content ac-tab-body">
            {{-- 1. Personal --}}
            <div class="tab-pane fade show active" id="t-personal" role="tabpanel">
                <div class="row g-3">
                    <div class="col-12 d-flex align-items-center gap-3">
                        @if($teacher->photo_url)
                            <img src="{{ $teacher->photo_url }}" id="photo-preview" class="ac-avatar lg" alt="">
                        @else
                            <img id="photo-preview" class="ac-avatar lg d-none" alt="">
                        @endif
                        <div class="flex-grow-1 row g-2">
                            <x-academic.file name="photo" label="Photo" accept=".jpg,.jpeg,.png,.webp" help="JPG, PNG or WEBP — max 2 MB" col="col-md-8" data-preview="#photo-preview" />
                            @if($teacher->photo_path)
                                <x-academic.switch name="remove_photo" label="Remove current photo" col="col-md-4 align-self-center" />
                            @endif
                        </div>
                    </div>
                    <x-academic.input name="first_name" label="First Name" :value="$teacher->first_name" required maxlength="100" />
                    <x-academic.input name="last_name" label="Last Name" :value="$teacher->last_name" required maxlength="100" />
                    <x-academic.input name="phone" label="Phone" type="tel" :value="$teacher->phone" required />
                    <x-academic.input name="email" label="Email" type="email" :value="$teacher->email" />
                    <x-academic.input name="address" label="Address" :value="$teacher->address" col="col-md-8" />
                    <x-academic.input name="postcode" label="Postcode" :value="$teacher->postcode" col="col-md-4" />
                    <x-academic.input name="date_of_birth" label="Date of Birth" type="date" :value="$teacher->date_of_birth" col="col-md-6" />
                    <x-academic.select name="gender" label="Gender" :options="\App\Models\Teacher::GENDERS" :value="$teacher->gender" :search="false" />
                </div>
            </div>

            {{-- 2. Employment --}}
            <div class="tab-pane fade" id="t-employment" role="tabpanel">
                <div class="row g-3">
                    <x-academic.select name="branch_id" label="Branch" :options="$branches->pluck('name', 'id')" :value="$teacher->branch_id" />
                    <x-academic.input name="job_title" label="Job Title" :value="$teacher->job_title" placeholder="e.g. Maths Tutor" />
                    <x-academic.input name="ni_number" label="National Insurance Number" :value="$teacher->ni_number" placeholder="AB123456C" autocomplete="off" />
                    <x-academic.input name="hourly_rate" label="Hourly Rate (£)" type="number" step="0.01" min="0" :value="$teacher->hourly_rate" />
                    <x-academic.input name="next_of_kin" label="Next of Kin" :value="$teacher->next_of_kin" />
                    <x-academic.input name="next_of_kin_phone" label="Next of Kin Phone" type="tel" :value="$teacher->next_of_kin_phone" />
                    <x-academic.select name="subject_ids" label="Subjects" multiple placeholder="Choose subjects…" :options="$subjects->pluck('name', 'id')" :value="$teacher->subjects->pluck('id')->all()" />
                    <x-academic.select name="level_ids" label="Levels" multiple placeholder="Choose levels…" :options="$levels->pluck('name', 'id')" :value="$teacher->levels->pluck('id')->all()" />
                    <x-academic.textarea name="skills" label="Skills" :value="$teacher->skills" col="col-md-6" />
                    <x-academic.textarea name="certifications" label="Certifications" :value="$teacher->certifications" col="col-md-6" />
                    <x-academic.input name="joining_date" label="Joining Date" type="date" :value="$teacher->joining_date" col="col-md-4" />
                    <x-academic.input name="resignation_date" label="Resignation Date" type="date" :value="$teacher->resignation_date" col="col-md-4" />
                    <div class="col-md-4"></div>
                    <x-academic.switch name="has_dbs" label="Has DBS?" :checked="$teacher->has_dbs" />
                    <x-academic.switch name="is_active" label="Is Active?" :checked="$teacher->is_active" />
                </div>
            </div>

            {{-- 3. Documents --}}
            <div class="tab-pane fade" id="t-documents" role="tabpanel">
                <div class="row g-3">
                    <x-academic.file name="proof_of_address" label="Proof of Address" />
                    <x-academic.file name="proof_of_id" label="Proof of ID" />
                    <div class="col-12 ac-muted"><i class="fas fa-lock me-1"></i> Files are stored in private storage. More document types (DBS, contract…) can be added from the teacher profile.</div>
                    @if($editing && $teacher->documents->isNotEmpty())
                        <div class="col-12">
                            <label class="f-label">Existing documents</label>
                            <ul class="list-unstyled mb-0">
                                @foreach($teacher->documents as $d)
                                    <li class="mb-1"><i class="fas fa-file me-1 text-muted"></i> {{ $d->type_label }} — <a href="{{ route('admin.documents.download', ['teachers', $d->id]) }}">{{ $d->original_name }}</a> <span class="ac-muted">({{ $d->created_at->format('d M Y') }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 4. Account --}}
            <div class="tab-pane fade" id="t-account" role="tabpanel">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="alert alert-info mb-0 py-2" style="font-size:.84rem">
                            <i class="fas fa-info-circle me-1"></i>
                            @if($editing) Leave the password blank to keep the existing password.
                            @else Leave the password blank and a secure random password will be generated and shown once after saving. @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="f-label" for="f-password">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="f-password" class="f-input" autocomplete="new-password" style="border-top-right-radius:0;border-bottom-right-radius:0">
                            <button type="button" class="btn btn-outline-secondary" data-toggle-password="#f-password" title="Show"><i class="fas fa-eye"></i></button>
                            <button type="button" class="btn btn-outline-secondary" data-generate-password="#f-password,#f-password_confirmation" title="Generate"><i class="fas fa-dice"></i></button>
                        </div>
                        <div class="ac-help">Min 8 characters with letters and numbers.</div>
                        <div class="invalid-feedback" data-error-for="password"></div>
                    </div>
                    <x-academic.input name="password_confirmation" label="Confirm Password" type="password" autocomplete="new-password" />
                </div>
            </div>
        </div>

        <div class="ac-sticky-actions">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update Teacher' : 'Save Teacher' }}</button>
            <a href="{{ $editing ? route('admin.teachers.show', $teacher) : route('admin.teachers.index') }}" class="btn-outline-sm">Cancel</a>
        </div>
    </div>
</form>
@endsection
