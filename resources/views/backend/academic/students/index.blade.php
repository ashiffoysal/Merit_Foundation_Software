@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => 'Students', 'subtitle' => 'Registration, parents, fees and assessment',
    'actions' => '<a href="' . route('admin.students.create') . '" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Student</a>',
])
<div class="card mb-3">
    <form class="ac-filters" data-filter-for="#students-table">
        <div class="row g-2">
            <div class="col-lg-4 col-md-12"><input type="search" name="search" value="{{ request('search') }}" class="f-input" placeholder="Student name, or parent name / phone / email…"></div>
            @foreach([['branch_id', 'All branches', $branches], ['level_id', 'All levels', $levels], ['school_id', 'All schools', $schools], ['year_group_id', 'All year groups', $yearGroups], ['student_status_id', 'All statuses', $statuses]] as [$f, $ph, $opts])
                <div class="col-lg-{{ $f === 'student_status_id' ? 2 : ($loop->first ? 2 : 2) }} col-md-4 col-6">
                    <select name="{{ $f }}" class="f-input"><option value="">{{ $ph }}</option>
                        @foreach($opts as $o)<option value="{{ $o->id }}" @selected(request($f) == $o->id)>{{ $o->name }}</option>@endforeach
                    </select>
                </div>
            @endforeach
            <div class="col-lg-2 col-md-4 col-6">
                <select name="active" class="f-input"><option value="">Active + inactive</option><option value="yes" @selected(request('active') == 'yes')>Active only</option><option value="no" @selected(request('active') == 'no')>Inactive only</option></select>
            </div>
            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center">
                <div class="form-check"><input class="form-check-input" type="checkbox" name="fee_delayed" value="1" id="fd" @checked(request('fee_delayed'))><label class="form-check-label ac-muted" for="fd">Fee delayed</label></div>
            </div>
            <div class="col-lg-1 col-md-2 col-6"><button class="btn-outline-sm w-100 justify-content-center" data-reset><i class="fas fa-undo"></i></button></div>
        </div>
    </form>
</div>
<div class="card" id="students-table" data-ajax-table data-url="{{ route('admin.students.index') }}">
    @include('backend.academic.students._table')
</div>
@endsection
