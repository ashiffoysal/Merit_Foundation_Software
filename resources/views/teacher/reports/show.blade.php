@extends('teacher.layout')
@section('title', 'Class report')
@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h1>{{ $session->lesson->name }}</h1><p class="mb-0">Lesson progress report · <span class="ac-muted">{{ $editNote }}</span></p></div>
    <div class="d-flex gap-2">
        @if($canEdit)<a href="{{ route('teacher.reports.edit', [$session->lesson, $session->session_date->toDateString()]) }}" class="btn-gold-sm"><i class="fas fa-edit"></i> Edit</a>
        @else<span class="btn-outline-sm" style="cursor:default"><i class="fas fa-lock"></i> Locked</span>@endif
        <a href="{{ route('teacher.reports.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> All reports</a>
    </div>
</div>
@include('backend.academic.partials.session-report')
@endsection
