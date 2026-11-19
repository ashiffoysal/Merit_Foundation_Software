@extends('teacher.layout')
@section('title', $lesson->name)
@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h1>{{ $lesson->name }}</h1><p class="mb-0">{{ $lesson->weekday_name }} {{ $lesson->time_range }} · {{ $lesson->subject->name ?? '' }} · {{ $lesson->level->name ?? '' }}</p></div>
    <div class="d-flex gap-2 flex-wrap">
        @if($last)
            <a href="{{ route('teacher.reports.edit', [$lesson, $last->date()]) }}" class="btn-gold-sm"><i class="fas fa-clipboard-check"></i> Report for {{ $last->start->format('D d M') }}</a>
        @endif
        <a href="{{ route('teacher.lessons.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">{{ $lesson->students_count }}/{{ $lesson->capacity }}</div><div class="l">Students</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v" style="font-size:1rem">{{ $next ? $next->start->format('D d M, H:i') : '—' }}</div><div class="l">Next class</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v" style="font-size:1rem">{{ $lesson->classroom->name ?? '—' }}</div><div class="l">{{ $lesson->branch->name ?? 'Room' }}</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">{{ $sessions->total() }}</div><div class="l">Reports submitted</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-graduate"></i> Students</div></div>
            <ul class="tp-list">
                @forelse($lesson->students as $s)
                    <li>
                        <x-academic.avatar :model="$s" />
                        <div class="flex-grow-1"><strong>{{ $s->full_name }}</strong><div class="ac-muted">{{ $s->level->name ?? '' }} {{ $s->age ? '· ' . $s->age . ' yrs' : '' }}</div></div>
                    </li>
                @empty
                    <li class="ac-muted">No students enrolled yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-clipboard-list"></i> Class reports</div></div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Date</th><th>Topic</th><th>Attendance</th><th></th></tr></thead>
                    <tbody>
                    @forelse($sessions as $s)
                        <tr>
                            <td>{{ $s->session_date->format('D d M Y') }}</td>
                            <td>{{ $s->topic ?: '—' }} <span class="badge bg-{{ \App\Models\LessonSession::COMPLETION_COLORS[$s->completion_status] ?? 'light' }}">{{ \App\Models\LessonSession::COMPLETION[$s->completion_status] ?? '' }}</span></td>
                            <td>{{ $s->status === 'held' ? $s->attendance_summary : '—' }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('teacher.reports.show', $s) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center ac-muted py-4">No reports yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($sessions->hasPages())<div class="p-3">{{ $sessions->links('pagination::bootstrap-5') }}</div>@endif
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header-custom"><div class="card-title"><i class="fas fa-folder-open"></i> Resources for this lesson</div><a href="{{ route('teacher.resources.index', ['level_id' => $lesson->level_id, 'subject_id' => $lesson->subject_id]) }}" class="small">See all</a></div>
    <ul class="tp-list">
        @forelse($resources as $r)
            <li><i class="fas {{ $r->icon }} fa-lg"></i>
                <div class="flex-grow-1"><strong>{{ $r->title }}</strong><div class="ac-muted">{{ $r->topic }}</div></div>
                <a href="{{ route('teacher.resources.download', $r) }}" class="btn-outline-sm"><i class="fas fa-download"></i></a></li>
        @empty
            <li class="ac-muted">No resources for {{ $lesson->level->name ?? 'this level' }} {{ $lesson->subject->name ?? '' }} yet.</li>
        @endforelse
    </ul>
</div>
@endsection
