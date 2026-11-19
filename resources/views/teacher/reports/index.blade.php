@extends('teacher.layout')
@section('title', 'Class Reports')
@section('content')
<div class="page-header"><h1>Progress Reports</h1><p>Your lesson reporting history</p></div>

@if($pending->isNotEmpty())
    <div class="card mb-4">
        <div class="card-header-custom"><div class="card-title"><i class="fas fa-exclamation-circle" style="color:var(--red)"></i> Waiting for your report</div><span class="badge bg-danger">{{ $pending->count() }}</span></div>
        <ul class="tp-list">
            @foreach($pending as $o)
                <li>
                    <div class="tp-time">{{ $o->start->format('D d M') }}<small>{{ $o->start->format('H:i') }} – {{ $o->end->format('H:i') }}</small></div>
                    <div class="flex-grow-1"><strong>{{ $o->lesson->name }}</strong><div class="ac-muted">{{ $o->lesson->students_count }} student(s)</div></div>
                    <a href="{{ route('teacher.reports.edit', [$o->lesson, $o->date()]) }}" class="btn-gold-sm"><i class="fas fa-pen"></i> Submit</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form class="ac-filters" method="GET">
        <div class="row g-2">
            <div class="col-md-4"><select name="lesson_id" class="f-input" onchange="this.form.submit()">
                <option value="">All lessons</option>
                @foreach($lessons as $l)<option value="{{ $l->id }}" @selected(request('lesson_id') == $l->id)>{{ $l->name }}</option>@endforeach
            </select></div>
            <div class="col-md-3"><select name="completion_status" class="f-input" onchange="this.form.submit()"><option value="">Any status</option>@foreach(\App\Models\LessonSession::COMPLETION as $k => $v)<option value="{{ $k }}" @selected(request('completion_status') == $k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-md-2 col-6"><input type="date" name="from" value="{{ request('from') }}" class="f-input" onchange="this.form.submit()"></div>
            <div class="col-md-2 col-6"><input type="date" name="to" value="{{ request('to') }}" class="f-input" onchange="this.form.submit()"></div>
            <div class="col-md-1"><a href="{{ route('teacher.reports.index') }}" class="btn-outline-sm w-100 justify-content-center"><i class="fas fa-undo"></i></a></div>
        </div>
    </form>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Date</th><th>Lesson</th><th>Level · Subject</th><th>Topic</th><th>Status</th><th>Attendance</th><th>Submitted</th><th></th></tr></thead>
            <tbody>
            @forelse($sessions as $s)
                <tr>
                    <td><strong>{{ $s->session_date->format('D d M Y') }}</strong><div class="ac-muted">{{ $s->time_range }}</div></td>
                    <td>{{ $s->lesson->name ?? '—' }}</td>
                    <td>{{ $s->level->name ?? '—' }}<div class="ac-muted">{{ $s->subject->name ?? '' }}</div></td>
                    <td>{{ \Illuminate\Support\Str::limit($s->topic, 50) ?: '—' }}</td>
                    <td><span class="badge bg-{{ \App\Models\LessonSession::COMPLETION_COLORS[$s->completion_status] ?? 'light' }}">{{ \App\Models\LessonSession::COMPLETION[$s->completion_status] ?? '' }}</span></td>
                    <td>{{ $s->status === 'held' ? $s->present_count . '/' . $s->records_count : '—' }}</td>
                    <td class="ac-muted">{{ $s->submitted_at?->format('d M H:i') }}@if($s->updated_at->gt($s->submitted_at->addMinute()))<br>edited {{ $s->updated_at->format('d M H:i') }}@endif</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('teacher.reports.show', $s) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                        @if($policy->teacherCanEdit($s))<a href="{{ route('teacher.reports.edit', [$s->lesson_id, $s->session_date->toDateString()]) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                        @else<span class="btn-outline-sm" title="Locked" style="cursor:default"><i class="fas fa-lock"></i></span>@endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center ac-muted py-5">No reports submitted yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($sessions->hasPages())<div class="p-3">{{ $sessions->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
