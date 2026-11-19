@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => 'Weekly Timetable', 'subtitle' => 'Saturday to Friday · click a lesson to open it',
    'actions' => '<a href="' . route('admin.lessons.create') . '" class="btn-gold-sm"><i class="fas fa-plus"></i> Create Lesson</a>',
])
<div class="card mb-3">@include('backend.academic.lessons._filters', ['target' => '#timetable', 'withSearch' => false, 'withWeekday' => false])</div>
<div class="card p-3" id="timetable" data-ajax-table data-url="{{ route('admin.lessons.timetable') }}">
    @include('backend.academic.lessons._timetable_grid')
</div>
@endsection
