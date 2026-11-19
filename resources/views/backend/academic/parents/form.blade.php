@extends('backend.academic.layout')
@section('page')
@php $editing = $parent->exists; @endphp
@include('backend.academic.partials.page-header', [
    'title' => $editing ? 'Edit Parent' : 'Add Parent',
    'subtitle' => $editing ? $parent->full_name : 'Fields marked * are required',
    'actions' => '<a href="' . ($editing ? route('admin.parents.show', $parent) : route('admin.parents.index')) . '" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>',
])
<form method="POST" action="{{ $editing ? route('admin.parents.update', $parent) : route('admin.parents.store') }}" enctype="multipart/form-data" data-ajax-form novalidate>
    @csrf
    @if($editing) @method('PUT') @endif
    <div class="card">
        <ul class="nav ac-tabs" role="tablist">
            <x-academic.tab id="pt-personal" label="Personal Information" icon="fa-user" active />
            <x-academic.tab id="pt-emergency" label="Emergency Contact" icon="fa-phone-alt" />
            <x-academic.tab id="pt-documents" label="Documents" icon="fa-file-alt" />
        </ul>
        <div class="tab-content ac-tab-body">
            <div class="tab-pane fade show active" id="pt-personal">
                <div class="row g-3">
                    @include('backend.academic.parents._fields')
                    <x-academic.input name="address" label="Address" :value="$parent->address" col="col-md-8" />
                    <x-academic.input name="postcode" label="Postcode" :value="$parent->postcode" col="col-md-4" />
                    <x-academic.switch name="is_active" label="Is Active?" :checked="$parent->is_active" />
                </div>
            </div>
            <div class="tab-pane fade" id="pt-emergency">
                <div class="row g-3">
                    <x-academic.input name="emergency_contact_name" label="Emergency Contact Name" :value="$parent->emergency_contact_name" />
                    <x-academic.input name="emergency_phone" label="Emergency Phone" type="tel" :value="$parent->emergency_phone" />
                </div>
            </div>
            <div class="tab-pane fade" id="pt-documents">
                <div class="row g-3">
                    <x-academic.file name="proof_of_address" label="Proof of Address" />
                    <x-academic.file name="proof_of_id" label="Proof of ID" />
                    <div class="col-12 ac-muted"><i class="fas fa-lock me-1"></i> Stored privately. Other documents can be uploaded, viewed and deleted from the parent profile.</div>
                    @if($editing && $parent->documents->isNotEmpty())
                        <div class="col-12">
                            <label class="f-label">Existing documents</label>
                            @foreach($parent->documents as $d)
                                <div class="mb-1"><i class="fas fa-file me-1 text-muted"></i> {{ $d->type_label }} — <a href="{{ route('admin.documents.download', ['parents', $d->id]) }}">{{ $d->original_name }}</a></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="ac-sticky-actions">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update Parent' : 'Save Parent' }}</button>
            <a href="{{ $editing ? route('admin.parents.show', $parent) : route('admin.parents.index') }}" class="btn-outline-sm">Cancel</a>
        </div>
    </div>
</form>
@endsection
