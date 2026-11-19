@extends('backend.academic.layout')
@section('page')
@php
    $actions = '<a href="' . route('admin.lessons.create', ['teacher_id' => $teacher->id]) . '" class="btn-outline-sm"><i class="fas fa-plus"></i> Lesson</a>'
             . '<a href="' . route('admin.teachers.edit', $teacher) . '" class="btn-gold-sm"><i class="fas fa-edit"></i> Edit</a>';
    {
        $actions .= '<button type="button" class="btn-danger-sm" data-delete="' . route('admin.teachers.destroy', $teacher) . '" data-redirect="' . route('admin.teachers.index') . '" data-title="Delete ' . e($teacher->full_name) . '?" data-text="Teachers with lessons cannot be deleted."><i class="fas fa-trash"></i> Delete</button>';
    }
@endphp
@include('backend.academic.partials.page-header', ['title' => 'Teacher Profile', 'actions' => $actions])

<div class="card mb-4">
    <div class="p-4 d-flex align-items-center gap-4 flex-wrap">
        <x-academic.avatar :model="$teacher" size="lg" />
        <div class="flex-grow-1">
            <h3 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:800">{{ $teacher->full_name }}</h3>
            <div class="ac-muted mb-2">{{ $teacher->job_title ?: 'Teacher' }} @if($teacher->branch) · {{ $teacher->branch->name }} @endif</div>
            @if($teacher->resignation_date)<span class="badge bg-dark">Resigned {{ $teacher->resignation_date->format('d M Y') }}</span>
            @else<x-academic.yesno :value="$teacher->is_active" yes="Active" no="Inactive" />@endif
            <x-academic.yesno :value="$teacher->has_dbs" yes="DBS ✓" no="No DBS" no-class="bg-warning text-dark" />
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="card ac-stat"><div class="v">{{ $lessons->where('is_active', true)->count() }}</div><div class="l">Active lessons</div></div>
            <div class="card ac-stat"><div class="v">{{ round($weeklyMinutes / 60, 1) }}h</div><div class="l">Per week</div></div>
            <div class="card ac-stat"><div class="v">£{{ number_format($weeklyPay, 2) }}</div><div class="l">Weekly pay</div></div>
        </div>
    </div>
</div>

@if($teacher->levels->isEmpty() || $teacher->subjects->isEmpty())
    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-1"></i> This teacher has no {{ $teacher->levels->isEmpty() ? 'levels' : 'subjects' }} assigned, so they will not see any learning resources. <a href="{{ route('admin.teachers.edit', $teacher) }}#t-employment">Assign them</a>.</div>
@endif
<div class="card">
    <ul class="nav ac-tabs" role="tablist">
        <x-academic.tab id="p-overview" label="Personal" icon="fa-user" active />
        <x-academic.tab id="p-employment" label="Employment" icon="fa-briefcase" />
        <x-academic.tab id="p-lessons" label="Lessons ({{ $lessons->count() }})" icon="fa-calendar-alt" />
        <x-academic.tab id="documents" label="Documents ({{ $teacher->documents->count() }})" icon="fa-file-alt" />
        <x-academic.tab id="p-history" label="Employment History" icon="fa-history" />
    </ul>
    <div class="tab-content ac-tab-body">
        <div class="tab-pane fade show active" id="p-overview">
            <dl class="ac-dl">
                <dt>Phone</dt><dd><a href="tel:{{ $teacher->phone }}">{{ $teacher->phone }}</a></dd>
                <dt>Email</dt><dd>@if($teacher->email)<a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>@else — @endif</dd>
                <dt>Address</dt><dd>{{ $teacher->address ?: '—' }} {{ $teacher->postcode }}</dd>
                <dt>Date of Birth</dt><dd>{{ $teacher->date_of_birth?->format('d M Y') ?? '—' }} @if($teacher->date_of_birth)<span class="ac-muted">({{ $teacher->date_of_birth->age }} yrs)</span>@endif</dd>
                <dt>Gender</dt><dd>{{ \App\Models\Teacher::GENDERS[$teacher->gender] ?? '—' }}</dd>
                <dt>Teacher panel</dt><dd>@if($teacher->email)Logs in at <a href="{{ route('teacher.login') }}" target="_blank">{{ route('teacher.login') }}</a> with {{ $teacher->email }} · last login {{ $teacher->last_login_at?->diffForHumans() ?? 'never' }}@else<span class="text-danger">Add an email so this teacher can log in.</span>@endif</dd>
                <dt>Next of Kin</dt><dd>{{ $teacher->next_of_kin ?: '—' }} {{ $teacher->next_of_kin_phone ? '· ' . $teacher->next_of_kin_phone : '' }}</dd>
            </dl>
        </div>
        <div class="tab-pane fade" id="p-employment">
            <dl class="ac-dl">
                <dt>Branch</dt><dd>{{ $teacher->branch->name ?? '—' }}</dd>
                <dt>Job Title</dt><dd>{{ $teacher->job_title ?: '—' }}</dd>
                <dt>NI Number</dt><dd>{{ $teacher->ni_number ?: '—' }}</dd>
                <dt>Hourly Rate</dt><dd>£{{ number_format($teacher->hourly_rate, 2) }}</dd>
                <dt>Subjects</dt><dd>@forelse($teacher->subjects as $s)<span class="badge bg-light text-dark border me-1">{{ $s->name }}</span>@empty — @endforelse</dd>
                <dt>Levels</dt><dd>@forelse($teacher->levels as $l)<span class="badge bg-light text-dark border me-1">{{ $l->name }}</span>@empty — @endforelse</dd>
                <dt>Joining Date</dt><dd>{{ $teacher->joining_date?->format('d M Y') ?? '—' }}</dd>
                <dt>Resignation Date</dt><dd>{{ $teacher->resignation_date?->format('d M Y') ?? '—' }}</dd>
                <dt>Skills</dt><dd style="white-space:pre-line">{{ $teacher->skills ?: '—' }}</dd>
                <dt>Certifications</dt><dd style="white-space:pre-line">{{ $teacher->certifications ?: '—' }}</dd>
            </dl>
        </div>
        <div class="tab-pane fade" id="p-lessons">
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Lesson</th><th>When</th><th>Room</th><th>Students</th><th>Pay / session</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($lessons as $l)
                        <tr>
                            <td><a href="{{ route('admin.lessons.show', $l) }}"><strong>{{ $l->name }}</strong></a><div class="ac-muted">{{ $l->subject->name ?? '' }}</div></td>
                            <td>{{ $l->weekday_name }} {{ $l->time_range }}</td>
                            <td>{{ $l->classroom->name ?? '—' }}<div class="ac-muted">{{ $l->branch->name ?? '' }}</div></td>
                            <td>{{ $l->students_count }}/{{ $l->capacity }}</td>
                            <td>£{{ number_format($l->teacher_pay_per_session, 2) }}</td>
                            <td><x-academic.yesno :value="$l->is_active" yes="Active" no="Inactive" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center ac-muted py-4">No lessons assigned.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="documents">
            @include('backend.academic.partials.documents', ['owner' => 'teachers', 'model' => $teacher, 'types' => \App\Models\Teacher::DOCUMENT_TYPES])
        </div>
        <div class="tab-pane fade" id="p-history">
            @include('backend.academic.partials.history', ['items' => $teacher->histories])
        </div>
    </div>
</div>
@endsection
