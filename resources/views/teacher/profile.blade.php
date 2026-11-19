@extends('teacher.layout')
@section('title', 'My Profile')
@section('content')
<div class="page-header"><h1>My Profile</h1><p>To change your details, contact the office.</p></div>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="p-4 d-flex align-items-center gap-3">
                <x-academic.avatar :model="$teacher" size="lg" />
                <div><h4 class="mb-0 fw-bold">{{ $teacher->full_name }}</h4><div class="ac-muted">{{ $teacher->job_title ?: 'Teacher' }}{{ $teacher->branch ? ' · ' . $teacher->branch->name : '' }}</div></div>
            </div>
            <div class="card-body-custom">
                <dl class="ac-dl">
                    <dt>Email</dt><dd>{{ $teacher->email }}</dd>
                    <dt>Phone</dt><dd>{{ $teacher->phone }}</dd>
                    <dt>Subjects</dt><dd>{{ $teacher->subjects->pluck('name')->implode(', ') ?: '—' }}</dd>
                    <dt>Levels</dt><dd>{{ $teacher->levels->pluck('name')->implode(', ') ?: '—' }}</dd>
                    <dt>Joined</dt><dd>{{ $teacher->joining_date?->format('d M Y') ?? '—' }}</dd>
                    <dt>Last login</dt><dd>{{ $teacher->last_login_at?->format('d M Y H:i') ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-key"></i> Change password</div></div>
            <div class="card-body-custom">
                <form method="POST" action="{{ route('teacher.password.update') }}" data-ajax-form novalidate>
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <x-academic.input name="current_password" label="Current password" type="password" col="col-12" autocomplete="current-password" />
                        <x-academic.input name="password" label="New password" type="password" col="col-12" autocomplete="new-password" help="At least 8 characters, letters and numbers." />
                        <x-academic.input name="password_confirmation" label="Confirm new password" type="password" col="col-12" autocomplete="new-password" />
                        <div class="col-12"><button class="btn-gold-sm"><i class="fas fa-save"></i> Change password</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
