@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => 'Teachers', 'subtitle' => 'Manage teachers, their documents and employment',
    'actions' => '<a href="' . route('admin.teachers.create') . '" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Teacher</a>',
])

<div class="card mb-3">
    <form class="ac-filters" data-filter-for="#teachers-table">
        <div class="row g-2">
            <div class="col-lg-4 col-md-6"><input type="search" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search name, email or phone…"></div>
            <div class="col-lg-2 col-md-6">
                <select name="branch_id" class="f-input"><option value="">All branches</option>
                    @foreach($branches as $b)<option value="{{ $b->id }}" @selected(request('branch_id') == $b->id)>{{ $b->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <select name="subject_id" class="f-input"><option value="">All subjects</option>
                    @foreach($subjects as $s)<option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <select name="status" class="f-input"><option value="">Any status</option>
                    @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'resigned' => 'Resigned'] as $k => $v)<option value="{{ $k }}" @selected(request('status') == $k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-lg-1 col-md-2 col-6">
                <select name="dbs" class="f-input"><option value="">DBS</option><option value="yes" @selected(request('dbs') == 'yes')>Yes</option><option value="no" @selected(request('dbs') == 'no')>No</option></select>
            </div>
            <div class="col-lg-1 col-md-2 col-6"><button class="btn-outline-sm w-100 justify-content-center" data-reset title="Reset"><i class="fas fa-undo"></i></button></div>
        </div>
    </form>
</div>

<div class="card" id="teachers-table" data-ajax-table data-url="{{ route('admin.teachers.index') }}">
    @include('backend.academic.teachers._table')
</div>
@endsection
