@extends('backend.academic.layout')
@section('page')
@php
    $editing = $student->exists;
    $primary = optional($student->parents->firstWhere('pivot.is_primary', true) ?? $student->parents->first())->id;
@endphp
@include('backend.academic.partials.page-header', [
    'title' => $editing ? 'Edit Student' : 'Add Student',
    'subtitle' => $editing ? $student->full_name : 'Fields marked * are required',
    'actions' => '<a href="' . ($editing ? route('admin.students.show', $student) : route('admin.students.index')) . '" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>',
])

<form method="POST" action="{{ $editing ? route('admin.students.update', $student) : route('admin.students.store') }}" enctype="multipart/form-data" data-ajax-form novalidate id="student-form">
    @csrf
    @if($editing) @method('PUT') @endif
    <div class="card">
        <ul class="nav ac-tabs" role="tablist">
            <x-academic.tab id="s-personal" label="Personal Information" icon="fa-user" active />
            <x-academic.tab id="s-parents" label="Parent Information" icon="fa-user-friends" />
            <x-academic.tab id="s-academic" label="Academic Information" icon="fa-graduation-cap" />
            <x-academic.tab id="s-fees" label="Fees & Assessment" icon="fa-pound-sign" />
            <x-academic.tab id="s-additional" label="Additional Information" icon="fa-sticky-note" />
        </ul>
        <div class="tab-content ac-tab-body">
            {{-- 1. Personal --}}
            <div class="tab-pane fade show active" id="s-personal">
                <div class="row g-3">
                    <div class="col-12 d-flex align-items-center gap-3">
                        @if($student->photo_url)<img src="{{ $student->photo_url }}" id="photo-preview" class="ac-avatar lg" alt="">
                        @else<img id="photo-preview" class="ac-avatar lg d-none" alt="">@endif
                        <div class="flex-grow-1 row g-2">
                            <x-academic.file name="photo" label="Photo" accept=".jpg,.jpeg,.png,.webp" help="JPG, PNG or WEBP — max 2 MB" col="col-md-8" data-preview="#photo-preview" />
                            @if($student->photo_path)<x-academic.switch name="remove_photo" label="Remove photo" col="col-md-4 align-self-center" />@endif
                        </div>
                    </div>
                    <x-academic.input name="first_name" label="First Name" :value="$student->first_name" required />
                    <x-academic.input name="last_name" label="Last Name" :value="$student->last_name" required />
                    <x-academic.input name="date_of_birth" label="Date of Birth" type="date" :value="$student->date_of_birth" />
                    <x-academic.select name="gender" label="Gender" :options="\App\Models\Student::GENDERS" :value="$student->gender" :search="false" />
                </div>
            </div>

            {{-- 2. Parents --}}
            <div class="tab-pane fade" id="s-parents">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="f-label" for="f-parent_ids">Parents / Guardians</label>
                        <select name="parent_ids[]" id="f-parent_ids" multiple placeholder="Type a name, phone or email to search…" data-ts-remote="{{ route('admin.academic.search', 'parents') }}">
                            @foreach($student->parents as $p)
                                <option value="{{ $p->id }}" selected>{{ $p->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="ac-help">A student can have several parents, and a parent can have several children.</div>
                        <div class="invalid-feedback" data-error-for="parent_ids"></div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn-outline-sm w-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#quickParent"><i class="fas fa-user-plus"></i> New parent</button>
                    </div>
                    <div class="col-md-8">
                        <label class="f-label" for="f-primary_parent_id">Primary contact</label>
                        <select name="primary_parent_id" id="f-primary_parent_id" class="f-input">
                            @foreach($student->parents as $p)
                                <option value="{{ $p->id }}" @selected($p->id === $primary)>{{ $p->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" data-error-for="primary_parent_id"></div>
                    </div>
                </div>
            </div>

            {{-- 3. Academic --}}
            <div class="tab-pane fade" id="s-academic">
                <div class="row g-3">
                    <x-academic.select name="branch_ids" label="Branches" multiple placeholder="Choose one or more branches…" col="col-12"
                        :options="$branches->pluck('name', 'id')" :value="$student->branches->pluck('id')->all()" />
                    <x-academic.select name="level_id" label="Level" :options="$levels->pluck('name', 'id')" :value="$student->level_id" col="col-md-4" />
                    <x-academic.select name="school_id" label="School" :options="$schools->pluck('name', 'id')" :value="$student->school_id" col="col-md-4" />
                    <x-academic.select name="year_group_id" label="Year Group" :options="$yearGroups->pluck('name', 'id')" :value="$student->year_group_id" col="col-md-4" />
                    <div class="col-12 ac-muted">Missing a school, level or year group? Add it under <a href="{{ route('admin.lookups.index', 'schools') }}" target="_blank">Settings</a>.</div>
                </div>
            </div>

            {{-- 4. Fees & assessment --}}
            <div class="tab-pane fade" id="s-fees">
                <div class="row g-3">
                    <x-academic.input name="registration_fee" label="Registration Fee (£)" type="number" step="0.01" min="0" :value="$student->registration_fee" col="col-md-4" />
                    <x-academic.input name="refundable_deposit" label="Refundable Deposit (£)" type="number" step="0.01" min="0" :value="$student->refundable_deposit" col="col-md-4" />
                    <x-academic.input name="hourly_fee" label="Hourly Fee (£)" type="number" step="0.01" min="0" :value="$student->hourly_fee" col="col-md-4" />
                    <x-academic.input name="assessment_date" label="Assessment Date" type="date" :value="$student->assessment_date" col="col-md-4" />
                    <x-academic.input name="assessment_time" label="Assessment Time" type="time" :value="$student->assessment_time_short" col="col-md-4" />
                    <x-academic.select name="student_status_id" label="Status" :options="$statuses->pluck('name', 'id')" :value="$student->student_status_id" col="col-md-4" />
                </div>
            </div>

            {{-- 5. Additional --}}
            <div class="tab-pane fade" id="s-additional">
                <div class="row g-3">
                    <x-academic.switch name="childcare" label="Childcare" :checked="$student->childcare" />
                    <x-academic.switch name="is_fee_delayed" label="Is fee delayed?" :checked="$student->is_fee_delayed" />
                    <x-academic.switch name="is_active" label="Is active?" :checked="$student->is_active" />
                    <x-academic.input name="due_date_extended" label="Due Date Extended To" type="date" :value="$student->due_date_extended" col="col-md-4" help="Required when the fee is delayed." />
                    <x-academic.textarea name="note" label="Note" :value="$student->note" rows="4" />
                </div>
            </div>
        </div>
        <div class="ac-sticky-actions">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update Student' : 'Save Student' }}</button>
            <a href="{{ $editing ? route('admin.students.show', $student) : route('admin.students.index') }}" class="btn-outline-sm">Cancel</a>
        </div>
    </div>
</form>

{{-- Quick add parent (separate form, posts to parents.store and adds the result to the dropdown) --}}
<div class="modal fade" id="quickParent" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" method="POST" action="{{ route('admin.parents.store') }}" data-ajax-form data-success-event="parent:created" novalidate>
            @csrf
            <input type="hidden" name="is_active" value="1">
            <div class="modal-header"><h5 class="modal-title">New Parent</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body"><div class="row g-3">@include('backend.academic.parents._fields', ['parent' => new \App\Models\Guardian()])</div></div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> Save & link</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('academic-scripts')
<script>
(function () {
    const parents = document.getElementById('f-parent_ids');
    const primary = document.getElementById('f-primary_parent_id');

    // keep the "primary contact" dropdown in sync with the chosen parents
    function syncPrimary() {
        const ts = parents.tomselect;
        const keep = primary.value;
        primary.innerHTML = '';
        ts.items.forEach(id => {
            const o = new Option(ts.options[id]?.text || id, id);
            if (id === keep) o.selected = true;
            primary.add(o);
        });
        if (!ts.items.length) primary.add(new Option('— Link a parent first —', ''));
    }
    parents.tomselect.on('change', syncPrimary);
    syncPrimary();

    // quick add parent
    document.addEventListener('parent:created', e => {
        const ts = parents.tomselect;
        ts.addOption({ id: String(e.detail.id), text: e.detail.text });
        ts.addItem(String(e.detail.id));
    });
})();
</script>
@endpush
