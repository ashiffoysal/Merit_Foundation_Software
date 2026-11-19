@php use App\Models\LessonSession as LS; use App\Models\LessonSessionStudent as R; @endphp
<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Date</th><th>Student</th><th>Lesson / Teacher</th><th>Level · Subject</th><th>Status</th><th>Attendance</th><th>Progress</th><th>Understanding</th><th>Score</th><th></th></tr></thead>
        <tbody>
        @forelse($rows as $r)
            @php $s = $r->session; @endphp
            <tr>
                <td class="text-nowrap"><strong>{{ $s->session_date->format('d M Y') }}</strong></td>
                <td><a href="{{ route('admin.students.show', $r->student_id) }}">{{ $r->student->full_name ?? '—' }}</a></td>
                <td>{{ $s->lesson->name ?? '—' }}<div class="ac-muted">{{ $s->teacher->full_name ?? '' }}</div></td>
                <td>{{ $s->level->name ?? '—' }}<div class="ac-muted">{{ $s->subject->name ?? '' }}</div></td>
                <td><span class="badge bg-{{ LS::COMPLETION_COLORS[$s->completion_status] ?? 'light' }}">{{ LS::COMPLETION[$s->completion_status] ?? $s->completion_status }}</span></td>
                <td><span class="badge bg-{{ R::ATTENDANCE_COLORS[$r->attendance] }}">{{ R::ATTENDANCE[$r->attendance] }}</span></td>
                <td>@if($r->progress)<span class="badge bg-{{ R::PROGRESS_COLORS[$r->progress] }}">{{ R::PROGRESS[$r->progress] }}</span>@else — @endif</td>
                <td>@if($r->understanding)<span class="badge bg-{{ R::UNDERSTANDING_COLORS[$r->understanding] }}">{{ R::UNDERSTANDING[$r->understanding] }}</span>@else — @endif</td>
                <td>{{ $r->score ? $r->score . '/10' : '—' }}</td>
                <td class="text-end"><a href="{{ route('admin.lessons.report', $s) }}" class="btn-outline-sm" title="Open report"><i class="fas fa-eye"></i></a></td>
            </tr>
        @empty
            <tr><td colspan="10" class="text-center ac-muted py-5">No reports match these filters.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@if($rows->hasPages())<div class="p-3">{{ $rows->links('pagination::bootstrap-5') }}</div>@endif
