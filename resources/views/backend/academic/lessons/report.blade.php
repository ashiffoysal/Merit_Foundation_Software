@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', [
    'title' => ($session->lesson->name ?? 'Lesson') . ' — class report',
    'actions' => '<a href="' . route('admin.lessons.show', $session->lesson_id) . '" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back to lesson</a>',
])
@php $ov = $session->edit_override; @endphp
<div class="card mb-4 p-3 d-flex flex-row flex-wrap align-items-center gap-2">
    <span class="me-2"><i class="fas fa-user-lock me-1"></i> Teacher editing:
        <strong>{{ $ov === 'allow' ? 'Allowed (override)' : ($ov === 'lock' ? 'Locked (override)' : 'Follows report settings') }}</strong>
        <span class="ac-muted">— {{ app(\App\Services\Academic\ReportEditPolicy::class)->explain($session) }}</span></span>
    @foreach(['allow' => ['Allow editing', 'fa-unlock'], 'lock' => ['Lock', 'fa-lock'], 'default' => ['Use settings', 'fa-undo']] as $val => [$label, $icon])
        @continue(($ov ?? 'default') === $val)
        <form method="POST" action="{{ route('admin.progress.edit-access', $session) }}" data-ajax-form>
            @csrf @method('PATCH')
            <input type="hidden" name="edit_override" value="{{ $val }}">
            <button class="btn-outline-sm"><i class="fas {{ $icon }}"></i> {{ $label }}</button>
        </form>
    @endforeach
</div>
@include('backend.academic.partials.session-report')
@endsection
