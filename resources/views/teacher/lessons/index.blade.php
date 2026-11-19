@extends('teacher.layout')
@section('title', 'My Lessons')
@section('content')
<div class="page-header"><h1>My Lessons</h1><p>Classes assigned to you</p></div>
<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>Lesson</th><th>Schedule</th><th>Room / Branch</th><th>Students</th><th>Next class</th><th>Reports</th><th></th></tr></thead>
            <tbody>
            @forelse($lessons as $l)
                @php $n = $nextByLesson[$l->id]; @endphp
                <tr>
                    <td><a href="{{ route('teacher.lessons.show', $l) }}"><strong>{{ $l->name }}</strong></a>
                        <div class="ac-muted">{{ $l->subject->name ?? '—' }} · {{ $l->level->name ?? '—' }} @if($l->is_one_to_one)· 1-to-1 @endif</div></td>
                    <td><strong>{{ $l->weekday_name }}</strong> {{ $l->time_range }}<div class="ac-muted">{{ $l->start_date->format('d M Y') }} → {{ $l->end_date?->format('d M Y') ?? 'ongoing' }}</div></td>
                    <td>{{ $l->classroom->name ?? '—' }}<div class="ac-muted">{{ $l->branch->name ?? '' }}</div></td>
                    <td>{{ $l->students_count }}/{{ $l->capacity }}</td>
                    <td>@if(! $l->is_active)<span class="badge bg-secondary">Inactive</span>@elseif($n){{ $n->start->format('D d M, H:i') }}@else<span class="ac-muted">—</span>@endif</td>
                    <td>{{ $l->sessions_count }}</td>
                    <td class="text-end"><a href="{{ route('teacher.lessons.show', $l) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center ac-muted py-5">No lessons are assigned to you yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
