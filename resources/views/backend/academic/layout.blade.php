@extends('layouts.backend')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('backend/academic/academic.css') }}?v=1">
@endpush

@section('content')
<div class="container-fluid px-0">
    <nav class="ac-subnav">
        @php $nav = [
            ['admin.teachers.index', 'admin.teachers.*', 'fa-chalkboard-teacher', 'Teachers'],
            ['admin.parents.index', 'admin.parents.*', 'fa-user-friends', 'Parents'],
            ['admin.students.index', 'admin.students.*', 'fa-user-graduate', 'Students'],
            ['admin.lessons.index', 'admin.lessons.index|admin.lessons.create|admin.lessons.edit|admin.lessons.show', 'fa-book-open', 'Lessons'],
            ['admin.lessons.timetable', 'admin.lessons.timetable', 'fa-calendar-week', 'Timetable'],
            ['admin.progress.index', 'admin.progress.*|admin.lessons.report|admin.report-settings.*', 'fa-chart-line', 'Progress Reports'],
            ['admin.resources.index', 'admin.resources.*', 'fa-folder-open', 'Resources'],
        ]; @endphp
        @foreach($nav as [$route, $match, $icon, $label])
            <a href="{{ route($route) }}" class="{{ request()->routeIs(...explode('|', $match)) ? 'active' : '' }}"><i class="fas {{ $icon }}"></i>{{ $label }}</a>
        @endforeach
        <a href="{{ route('admin.lookups.index', 'branches') }}" class="{{ request()->routeIs('admin.lookups.*') ? 'active' : '' }}"><i class="fas fa-sliders-h"></i>Settings</a>
    </nav>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('generated_password'))
        <div class="alert alert-warning">Generated password: <code>{{ session('generated_password') }}</code> — copy it now, it will not be shown again.</div>
    @endif

    @yield('page')
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('backend/academic/academic.js') }}?v=1"></script>
    @if(session('success'))
        <script>Academic.toast(@json(session('success')));</script>
    @endif
    @stack('academic-scripts')
@endpush
