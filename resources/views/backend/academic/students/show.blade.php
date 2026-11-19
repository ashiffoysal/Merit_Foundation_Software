@extends('backend.academic.layout')
@section('page')
@php
    $actions = '<a href="' . route('admin.students.edit', $student) . '" class="btn-gold-sm"><i class="fas fa-edit"></i> Edit</a>';
    {
        $actions .= '<button type="button" class="btn-danger-sm" data-delete="' . route('admin.students.destroy', $student) . '" data-redirect="' . route('admin.students.index') . '" data-title="Delete ' . e($student->full_name) . '?"><i class="fas fa-trash"></i> Delete</button>';
    }
    $weekly = $student->lessons->where('is_active', true)->sum(fn ($l) => $student->hourly_fee * $l->duration_minutes / 60);
@endphp
@include('backend.academic.partials.page-header', ['title' => 'Student Profile', 'actions' => $actions])

<div class="card mb-4">
    <div class="p-4 d-flex align-items-center gap-4 flex-wrap">
        <x-academic.avatar :model="$student" size="lg" />
        <div class="flex-grow-1">
            <h3 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:800">{{ $student->full_name }}</h3>
            <div class="ac-muted mb-2">{{ $student->level->name ?? 'No level' }} · {{ $student->yearGroup->name ?? 'No year group' }} · {{ $student->school->name ?? 'No school' }}</div>
            @if($student->status)<span class="badge bg-{{ $student->status->color }}">{{ $student->status->name }}</span>@endif
            <x-academic.yesno :value="$student->is_active" yes="Active" no="Inactive" />
            @if($student->is_fee_delayed)<span class="badge bg-danger">Fee delayed{{ $student->due_date_extended ? ' → ' . $student->due_date_extended->format('d M Y') : '' }}</span>@endif
            @if($student->childcare)<span class="badge bg-info text-dark">Childcare</span>@endif
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="card ac-stat"><div class="v">{{ $student->lessons->count() }}</div><div class="l">Lessons</div></div>
            <div class="card ac-stat"><div class="v">£{{ number_format($weekly, 2) }}</div><div class="l">Est. weekly fee</div></div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-user"></i> Personal & Academic</div></div>
            <div class="card-body-custom">
                <dl class="ac-dl">
                    <dt>Date of Birth</dt><dd>{{ $student->date_of_birth?->format('d M Y') ?? '—' }} @if($student->age !== null)<span class="ac-muted">({{ $student->age }} yrs)</span>@endif</dd>
                    <dt>Gender</dt><dd>{{ \App\Models\Student::GENDERS[$student->gender] ?? '—' }}</dd>
                    <dt>Branches</dt><dd>@forelse($student->branches as $b)<span class="badge bg-light text-dark border me-1">{{ $b->name }}</span>@empty — @endforelse</dd>
                    <dt>Level</dt><dd>{{ $student->level->name ?? '—' }}</dd>
                    <dt>School</dt><dd>{{ $student->school->name ?? '—' }}</dd>
                    <dt>Year Group</dt><dd>{{ $student->yearGroup->name ?? '—' }}</dd>
                    <dt>Note</dt><dd style="white-space:pre-line">{{ $student->note ?: '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-pound-sign"></i> Fees & Assessment</div></div>
            <div class="card-body-custom">
                <dl class="ac-dl">
                    <dt>Registration Fee</dt><dd>£{{ number_format($student->registration_fee, 2) }}</dd>
                    <dt>Refundable Deposit</dt><dd>£{{ number_format($student->refundable_deposit, 2) }}</dd>
                    <dt>Hourly Fee</dt><dd>£{{ number_format($student->hourly_fee, 2) }}</dd>
                    <dt>Fee Delayed</dt><dd><x-academic.yesno :value="$student->is_fee_delayed" yes-class="bg-danger" /></dd>
                    <dt>Due Date Extended</dt><dd>{{ $student->due_date_extended?->format('d M Y') ?? '—' }}</dd>
                    <dt>Assessment</dt><dd>{{ $student->assessment_date?->format('d M Y') ?? '—' }} {{ $student->assessment_time_short }}</dd>
                    <dt>Childcare</dt><dd><x-academic.yesno :value="$student->childcare" /></dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-friends"></i> Parents / Guardians</div></div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Name</th><th>Relationship</th><th>Phone</th><th>Email</th><th>Emergency</th></tr></thead>
                    <tbody>
                    @forelse($student->parents as $p)
                        <tr>
                            <td><a href="{{ route('admin.parents.show', $p) }}"><strong>{{ $p->full_name }}</strong></a> @if($p->pivot->is_primary)<span class="badge bg-light text-dark border">Primary</span>@endif</td>
                            <td>{{ $p->relationship_label ?: '—' }}</td>
                            <td><a href="tel:{{ $p->phone }}">{{ $p->phone }}</a></td>
                            <td>{{ $p->email ?: '—' }}</td>
                            <td>{{ $p->emergency_phone ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center ac-muted py-4">No parent linked. <a href="{{ route('admin.students.edit', $student) }}#s-parents">Link one</a></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-calendar-alt"></i> Lessons</div></div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Lesson</th><th>When</th><th>Teacher</th><th>Since</th></tr></thead>
                    <tbody>
                    @forelse($student->lessons as $l)
                        <tr>
                            <td><a href="{{ route('admin.lessons.show', $l) }}"><strong>{{ $l->name }}</strong></a><div class="ac-muted">{{ $l->subject->name ?? '' }}</div></td>
                            <td>{{ $l->weekday_name }} {{ $l->time_range }}</td>
                            <td>{{ $l->teacher->full_name ?? '—' }}</td>
                            <td>{{ $l->pivot->enrolled_at ? \Carbon\Carbon::parse($l->pivot->enrolled_at)->format('d M Y') : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center ac-muted py-4">Not enrolled in any lesson. Enrol from a lesson page.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-history"></i> Registration History</div></div>
            <div class="card-body-custom" style="max-height:420px;overflow:auto">
                @include('backend.academic.partials.history', ['items' => $student->histories])
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header-custom"><div class="card-title"><i class="fas fa-chart-line"></i> Progress reports (from teachers)</div><span class="ac-muted">latest 30</span></div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Date</th><th>Lesson</th><th>Attendance</th><th>Progress</th><th>Score</th><th>Homework</th><th>Comment</th><th></th></tr></thead>
            <tbody>
            @php use App\Models\LessonSessionStudent as R; @endphp
            @forelse($reports as $r)
                <tr>
                    <td><strong>{{ $r->session->session_date->format('d M Y') }}</strong><div class="ac-muted">{{ $r->session->teacher->full_name ?? '' }}</div></td>
                    <td>{{ $r->session->lesson->name ?? '—' }}<div class="ac-muted">{{ $r->session->topic }}</div></td>
                    <td><span class="badge bg-{{ R::ATTENDANCE_COLORS[$r->attendance] }}">{{ R::ATTENDANCE[$r->attendance] }}</span></td>
                    <td>@if($r->progress)<span class="badge bg-{{ R::PROGRESS_COLORS[$r->progress] }}">{{ R::PROGRESS[$r->progress] }}</span>@else — @endif</td>
                    <td>{{ $r->score ? $r->score . '/10' : '—' }}</td>
                    <td>{{ $r->homework_done === null ? '—' : ($r->homework_done ? 'Yes' : 'No') }}</td>
                    <td style="max-width:260px">{{ $r->comment ?: '—' }}</td>
                    <td class="text-end"><a href="{{ route('admin.lessons.report', $r->lesson_session_id) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center ac-muted py-4">No progress reports yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
