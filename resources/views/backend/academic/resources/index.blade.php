@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => 'Learning Resources', 'subtitle' => 'Teachers only see resources that match their assigned levels AND subjects',
    'actions' => '<a href="' . route('admin.resources.create') . '" class="btn-gold-sm"><i class="fas fa-upload"></i> Upload Resource</a>',
])
<div class="card mb-3">
    <form class="ac-filters" data-filter-for="#resources-table">
        <div class="row g-2">
            <div class="col-lg-4 col-md-12"><input type="search" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search title, topic, file name…"></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="level_id" class="f-input"><option value="">All levels</option>@foreach($levels as $l)<option value="{{ $l->id }}" @selected(request('level_id') == $l->id)>{{ $l->name }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="subject_id" class="f-input"><option value="">All subjects</option>@foreach($subjects as $s)<option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="category_id" class="f-input"><option value="">All categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-lg-1 col-md-6 col-6"><select name="active" class="f-input"><option value="">Any</option><option value="yes" @selected(request('active') == 'yes')>Active</option><option value="no" @selected(request('active') == 'no')>Hidden</option></select></div>
            <div class="col-lg-1 col-md-6"><button class="btn-outline-sm w-100 justify-content-center" data-reset><i class="fas fa-undo"></i></button></div>
        </div>
    </form>
</div>
<div class="card" id="resources-table" data-ajax-table data-url="{{ route('admin.resources.index') }}">
    @include('backend.academic.resources._table')
</div>
@endsection
