@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', ['title' => 'Report Settings', 'subtitle' => 'Control when teachers may edit a progress report after submitting it'])
<div class="row g-4">
    <div class="col-lg-7">
        <form class="card" method="POST" action="{{ route('admin.report-settings.update') }}" data-ajax-form novalidate>
            @csrf @method('PUT')
            <div class="card-body-custom pt-4">
                <label class="f-label">Teacher editing</label>
                @foreach($modes as $key => $label)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="report_edit_mode" id="m-{{ $key }}" value="{{ $key }}" @checked($mode === $key)>
                        <label class="form-check-label" for="m-{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                <div class="invalid-feedback" data-error-for="report_edit_mode"></div>
                <div class="row mt-3"><x-academic.input name="report_edit_days" label="Number of days" type="number" min="1" max="365" :value="$days" col="col-md-4" help="Used with the second option" /></div>
            </div>
            <div class="ac-sticky-actions"><button class="btn-gold-sm"><i class="fas fa-save"></i> Save</button></div>
        </form>
    </div>
    <div class="col-lg-5">
        <div class="card p-4 small">
            <strong class="d-block mb-2"><i class="fas fa-info-circle text-primary me-1"></i> Per-report override</strong>
            On any report (Progress Reports → open report) you can <b>Allow editing</b> or <b>Lock</b> that single report. The override wins over this setting.
            <hr>First submission is always allowed; these rules only apply to changing a report afterwards.
        </div>
    </div>
</div>
@endsection
