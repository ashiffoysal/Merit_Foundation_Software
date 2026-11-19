@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => 'Lessons', 'subtitle' => 'Group and one-to-one lessons',
    'actions' => '<a href="' . route('admin.lessons.timetable') . '" class="btn-outline-sm"><i class="fas fa-calendar-week"></i> Timetable</a><a href="' . route('admin.lessons.create') . '" class="btn-gold-sm"><i class="fas fa-plus"></i> Create Lesson</a>',
])
<div class="card mb-3">@include('backend.academic.lessons._filters', ['target' => '#lessons-table'])</div>
<div class="card" id="lessons-table" data-ajax-table data-url="{{ route('admin.lessons.index') }}">
    @include('backend.academic.lessons._table')
</div>
@endsection
