{{-- Shared by the teacher panel and admin: one submitted class report. $session (with lesson, records.student) --}}
@php use App\Models\LessonSessionStudent as R; @endphp
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v" style="font-size:1rem">{{ $session->session_date->format('D d M Y') }}</div><div class="l">{{ $session->time_range }}</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v" style="font-size:1rem"><span class="badge bg-{{ \App\Models\LessonSession::COMPLETION_COLORS[$session->completion_status] ?? 'light' }}">{{ \App\Models\LessonSession::COMPLETION[$session->completion_status] ?? $session->completion_status }}</span></div><div class="l">Lesson status</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v">{{ $session->status === 'held' ? $session->attendance_summary : '—' }}</div><div class="l">Attended</div></div></div>
    <div class="col-md-3 col-6"><div class="card ac-stat"><div class="v" style="font-size:1rem">{{ $session->submitted_at?->format('d M H:i') }}</div><div class="l">Submitted{{ $session->teacher ? ' by ' . $session->teacher->full_name : '' }}</div></div></div>
</div>

<div class="card mb-4">
    <div class="card-header-custom"><div class="card-title"><i class="fas fa-sticky-note"></i> Class notes</div></div>
    <div class="card-body-custom">
        <dl class="ac-dl">
            <dt>Level · Subject</dt><dd>{{ $session->level->name ?? '—' }} · {{ $session->subject->name ?? '—' }}</dd>
            <dt>Lesson topic / unit</dt><dd>{{ $session->topic ?: '—' }}</dd>
            <dt>Topics covered</dt><dd style="white-space:pre-line">{{ $session->topics_covered ?: '—' }}</dd>
            <dt>Homework assigned</dt><dd style="white-space:pre-line">{{ $session->homework ?: '—' }}</dd>
            <dt>Teacher's comments</dt><dd style="white-space:pre-line">{{ $session->notes ?: '—' }}</dd>
        </dl>
    </div>
</div>

@if($session->status === 'held')
<div class="card">
    <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-check"></i> Attendance & progress</div></div>
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Student</th><th>Attendance</th><th>Progress</th><th>Understanding</th><th>Score</th><th>Homework</th><th>Challenges / to improve</th><th>Comment</th></tr></thead>
            <tbody>
            @forelse($session->records->sortBy(fn ($r) => $r->student->first_name ?? '') as $r)
                <tr>
                    <td><strong>{{ $r->student->full_name ?? 'Removed student' }}</strong></td>
                    <td><span class="badge bg-{{ R::ATTENDANCE_COLORS[$r->attendance] }}">{{ R::ATTENDANCE[$r->attendance] }}</span></td>
                    <td>@if($r->progress)<span class="badge bg-{{ R::PROGRESS_COLORS[$r->progress] }}">{{ R::PROGRESS[$r->progress] }}</span>@else — @endif</td>
                    <td>@if($r->understanding)<span class="badge bg-{{ R::UNDERSTANDING_COLORS[$r->understanding] }}">{{ R::UNDERSTANDING[$r->understanding] }}</span>@else — @endif</td>
                    <td>{{ $r->score ? $r->score . '/10' : '—' }}</td>
                    <td>{{ $r->homework_done === null ? '—' : ($r->homework_done ? 'Yes' : 'No') }}</td>
                    <td style="white-space:pre-line;max-width:240px">{{ $r->challenges ?: '—' }}</td>
                    <td style="white-space:pre-line;max-width:240px">{{ $r->comment ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center ac-muted py-4">No students recorded.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
