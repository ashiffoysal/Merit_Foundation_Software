<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Teacher Login — Merit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,600&display=swap">
    <link rel="stylesheet" href="{{ asset('backend/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/academic/teacher.css') }}?v=1">
</head>
<body>
<div class="tp-login px-3">
    <div class="card">
        <div class="text-center mb-4">
            <span class="tp-logo mb-3" style="width:52px;height:52px;font-size:1.4rem">M</span>
            <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.4rem" class="mb-1">Teacher Login</h1>
            <p class="ac-muted mb-0" style="color:var(--muted);font-size:.85rem">See your classes and submit class reports</p>
        </div>

        @if(session('status'))<div class="alert alert-info py-2 small">{{ session('status') }}</div>@endif

        <form method="POST" action="{{ route('teacher.login.submit') }}" novalidate>
            @csrf
            <div class="mb-3">
                <label class="f-label" for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="f-input @error('email') is-invalid @enderror" autocomplete="username" autofocus required>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="f-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="f-input @error('password') is-invalid @enderror" autocomplete="current-password" required>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
                <label class="form-check-label small" for="remember">Keep me logged in</label>
            </div>
            <button class="btn-gold-sm w-100 justify-content-center py-3"><i class="fas fa-sign-in-alt"></i> Log in</button>
        </form>
        <p class="text-center small mt-4 mb-0" style="color:var(--muted)">Forgot your password? Ask the office to reset it.</p>
    </div>
</div>
</body>
</html>
