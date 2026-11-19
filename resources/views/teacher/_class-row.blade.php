{{-- $o = ClassOccurrence, $now, $showDate (bool) --}}
@php $state = $o->state($now); $l = $o->lesson; @endphp
<li>
    <div class="tp-time">
        @if($showDate ?? false){{ $o->start->format('D d M') }}<small>{{ $o->start->format('H:i') }} – {{ $o->end->format('H:i') }}</small>
        @else{{ $o->start->format('H:i') }}<small>to {{ $o->end->format('H:i') }}</small>@endif
    </div>
    <div class="flex-grow-1">
        <a href="{{ route('teacher.lessons.show', $l) }}" class="fw-bold text-decoration-none" style="color:var(--txt)">{{ $l->name }}</a>
        <div class="ac-muted">{{ $l->subject->name ?? '' }} · {{ $l->classroom->name ?? 'No room' }}{{ $l->branch ? ' · ' . $l->branch->name : '' }} · {{ $l->students_count }} student(s)</div>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        @if($state === 'live')<span class="badge bg-success"><span class="tp-dot"></span>Live</span>
        @elseif($state === 'upcoming')<span class="badge bg-light text-dark border">Upcoming</span>
        @else<span class="badge bg-secondary">Finished</span>@endif

        @if($o->reported())
            <a href="{{ route('teacher.reports.show', $o->session) }}" class="btn-outline-sm"><i class="fas fa-check text-success"></i> Report</a>
        @elseif($state !== 'upcoming' || $o->date() === $now->toDateString())
            @if($o->date() <= $now->toDateString())
                <a href="{{ route('teacher.reports.edit', [$l, $o->date()]) }}" class="{{ $state === 'finished' ? 'btn-gold-sm' : 'btn-outline-sm' }}"><i class="fas fa-pen"></i> {{ $state === 'finished' ? 'Submit report' : 'Notes' }}</a>
            @endif
        @endif
    </div>
</li>
