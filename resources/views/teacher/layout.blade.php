<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Teacher Panel') — Merit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap">
    <link rel="stylesheet" href="{{ asset('backend/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/academic/academic.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('backend/academic/teacher.css') }}?v=1">
</head>
<body class="tp-body">
@php $me = auth('teacher')->user(); @endphp
<nav class="navbar navbar-expand-lg tp-nav">
    <div class="container-xl">
        <a class="navbar-brand tp-brand" href="{{ route('teacher.dashboard') }}"><span class="tp-logo">M</span> MERIT <small>Teacher</small></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#tpNav"><i class="fas fa-bars text-white"></i></button>
        <div class="collapse navbar-collapse" id="tpNav">
            <ul class="navbar-nav me-auto">
                @foreach([['teacher.dashboard', 'teacher.dashboard', 'fa-th-large', 'Dashboard'], ['teacher.lessons.index', 'teacher.lessons.*', 'fa-book-open', 'My Lessons'], ['teacher.reports.index', 'teacher.reports.*', 'fa-clipboard-check', 'Progress Reports'], ['teacher.resources.index', 'teacher.resources.*', 'fa-folder-open', 'Resources']] as [$r, $m, $i, $l])
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs($m) ? 'active' : '' }}" href="{{ route($r) }}"><i class="fas {{ $i }} me-1"></i>{{ $l }}</a></li>
                @endforeach
            </ul>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <x-academic.avatar :model="$me" />
                    <span class="small">{{ $me->full_name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('teacher.profile') }}"><i class="fas fa-user me-2"></i>My Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('teacher.logout') }}">@csrf
                            <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Log out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main class="container-xl py-4">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('warning'))<div class="alert alert-warning"><i class="fas fa-lock me-1"></i> {{ session('warning') }}</div>@endif
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="{{ asset('backend/academic/academic.js') }}?v=2"></script>
@stack('scripts')
</body>
</html>
