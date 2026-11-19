@extends('backend.academic.layout')
@section('page')
@php
    $actions = '<a href="' . route('admin.lessons.edit', $lesson) . '" class="btn-gold-sm"><i class="fas fa-edit"></i> Edit</a>';
    {
        $actions .= '<button type="button" class="btn-danger-sm" data-delete="' . route('admin.lessons.destroy', $lesson) . '" data-redirect="' . route('admin.lessons.index') . '" data-title="Delete ' . e($lesson->name) . '?"><i class="fas fa-trash"></i> Delete</button>';
    }
    $enrolled = $lesson->students_count;
    $full = $enrolled >= $lesson->capacity;
@endphp
@include('backend.academic.partials.page-header', [
    'title' => $lesson->name,
    'subtitle' => $lesson->weekday_name . ' ' . $lesson->time_range . ' · ' . ($lesson->subject->name ?? 'No subject') . ' · ' . ($lesson->level->name ?? 'No level'),
    'actions' => $actions,
])

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">{{ $enrolled }}/{{ $lesson->capacity }}</div><div class="l">Seats filled</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">£{{ number_format($lesson->teacher_pay_per_session, 2) }}</div><div class="l">Teacher pay / session</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">{{ $lesson->sessions_count ?? '∞' }}</div><div class="l">Sessions in range</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">{{ $lesson->teacher_pay_total !== null ? '£' . number_format($lesson->teacher_pay_total, 2) : 'Ongoing' }}</div><div class="l">Total teacher pay</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-info-circle"></i> Details</div><x-academic.yesno :value="$lesson->is_active" yes="Active" no="Inactive" /></div>
            <div class="card-body-custom">
                <dl class="ac-dl">
                    <dt>Teacher</dt><dd>@if($lesson->teacher)<a href="{{ route('admin.teachers.show', $lesson->teacher) }}">{{ $lesson->teacher->full_name }}</a>@else — @endif</dd>
                    <dt>Branch</dt><dd>{{ $lesson->branch->name ?? '—' }}</dd>
                    <dt>Classroom</dt><dd>{{ $lesson->classroom->name ?? '—' }}</dd>
                    <dt>Schedule</dt><dd>{{ $lesson->weekday_name }}, {{ $lesson->time_range }} ({{ $lesson->duration_minutes }} min)</dd>
                    <dt>Dates</dt><dd>{{ $lesson->start_date->format('d M Y') }} → {{ $lesson->end_date?->format('d M Y') ?? 'ongoing' }}</dd>
                    <dt>Type</dt><dd>{{ $lesson->is_one_to_one ? 'One-to-one' : 'Group' }} · {{ \App\Models\Lesson::GENDERS[$lesson->gender] }}</dd>
                    <dt>Teacher rate</dt><dd>£{{ number_format($lesson->teacher_hourly_rate, 2) }} / hour</dd>
                    <dt>Student fee</dt><dd>£{{ number_format($lesson->hourly_rate, 2) }} / hour · £{{ number_format($lesson->fee_per_session, 2) }} / session</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header-custom flex-wrap gap-2">
                <div class="card-title"><i class="fas fa-user-graduate"></i> Students</div>
                @if($full)<span class="badge bg-danger">Full</span>@else<span class="badge bg-success">{{ $lesson->capacity - $enrolled }} seat(s) left</span>@endif
            </div>
            @unless($full)
                <form class="px-4 pb-3 d-flex gap-2 flex-wrap" method="POST" action="{{ route('admin.lessons.enroll', $lesson) }}" data-ajax-form novalidate>
                    @csrf
                    <div class="flex-grow-1" style="min-width:240px">
                        <select name="student_id" placeholder="Search a student to enrol…" data-ts-remote="{{ route('admin.academic.search', 'students') }}" data-param-exclude-lesson="{{ $lesson->id }}"></select>
                        <div class="invalid-feedback" data-error-for="student_id"></div>
                    </div>
                    <button class="btn-gold-sm"><i class="fas fa-plus"></i> Enrol</button>
                </form>
            @endunless
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Student</th><th>Level</th><th>Parent</th><th>Enrolled</th><th></th></tr></thead>
                    <tbody>
                    @forelse($lesson->students as $s)
                        @php $p = $s->parents->first(); @endphp
                        <tr data-row>
                            <td><a href="{{ route('admin.students.show', $s) }}"><strong>{{ $s->full_name }}</strong></a><div class="ac-muted">{{ \App\Models\Student::GENDERS[$s->gender] ?? '' }}</div></td>
                            <td>{{ $s->level->name ?? '—' }}</td>
                            <td>{{ $p?->full_name ?? '—' }}<div class="ac-muted">{{ $p?->phone }}</div></td>
                            <td>{{ $s->pivot->enrolled_at ? \Carbon\Carbon::parse($s->pivot->enrolled_at)->format('d M Y') : '—' }}</td>
                            <td class="text-end">
                                <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.lessons.unenroll', [$lesson, $s]) }}" data-redirect="{{ route('admin.lessons.show', $lesson) }}" data-title="Remove {{ $s->full_name }}?" data-text="They will be unenrolled from this lesson."><i class="fas fa-user-minus"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center ac-muted py-4">No students enrolled yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header-custom"><div class="card-title"><i class="fas fa-clipboard-list"></i> Class reports (from teacher)</div><span class="ac-muted">latest 20</span></div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Date</th><th>Topic</th><th>Attendance</th><th>Teacher</th><th>Submitted</th><th></th></tr></thead>
            <tbody>
            @forelse($sessions as $s)
                <tr>
                    <td><strong>{{ $s->session_date->format('D d M Y') }}</strong></td>
                    <td>@if($s->status === 'cancelled')<span class="badge bg-secondary">Cancelled</span> {{ \Illuminate\Support\Str::limit($s->notes, 50) }}@else{{ $s->topic }}@endif</td>
                    <td>{{ $s->status === 'held' ? $s->present_count . '/' . $s->records_count : '—' }}</td>
                    <td>{{ $s->teacher->full_name ?? '—' }}</td>
                    <td class="ac-muted">{{ $s->submitted_at?->format('d M H:i') }}</td>
                    <td class="text-end"><a href="{{ route('admin.lessons.report', $s) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center ac-muted py-4">The teacher hasn't submitted any class reports yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
