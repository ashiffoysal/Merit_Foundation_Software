@extends('teacher.layout')
@section('title', 'Dashboard')
@section('content')
<div class="tp-hello d-flex justify-content-between align-items-end flex-wrap gap-2 mb-4">
    <div>
        <p class="ac-muted mb-1">{{ $now->format('l, d F Y') }} · {{ $now->format('H:i') }} ({{ $now->getTimezone()->getName() }})</p>
        <h1>Welcome back, {{ $teacher->first_name }}</h1>
    </div>
    <a href="{{ route('teacher.lessons.index') }}" class="btn-outline-sm"><i class="fas fa-book-open"></i> My lessons</a>
</div>

{{-- Live now --}}
@foreach($live as $o)
    <div class="card tp-live mb-3 p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="small mb-1"><span class="tp-dot"></span>CLASS IN PROGRESS · ends {{ $o->end->format('H:i') }} ({{ $o->end->diffForHumans($now, ['parts' => 2, 'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]) }})</div>
                <h3 class="mb-1" style="font-family:'Syne',sans-serif;font-weight:800">{{ $o->lesson->name }}</h3>
                <div class="ac-muted">{{ $o->start->format('H:i') }} – {{ $o->end->format('H:i') }} · {{ $o->lesson->classroom->name ?? 'No room' }} · {{ $o->lesson->students_count }} student(s)</div>
            </div>
            <a href="{{ route('teacher.reports.edit', [$o->lesson, $o->date()]) }}" class="btn-gold-sm"><i class="fas fa-clipboard-check"></i> {{ $o->reported() ? 'Edit attendance & notes' : 'Take attendance & notes' }}</a>
        </div>
    </div>
@endforeach

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card tp-next h-100 p-4">
            <div class="ac-muted text-uppercase fw-bold mb-2" style="letter-spacing:1.5px;font-size:.7rem">Next class</div>
            @if($next)
                <h4 class="mb-1 fw-bold">{{ $next->lesson->name }}</h4>
                <div class="mb-2">{{ $next->start->isToday() ? 'Today' : ($next->start->isTomorrow() ? 'Tomorrow' : $next->start->format('l d M')) }}, {{ $next->start->format('H:i') }} – {{ $next->end->format('H:i') }}</div>
                <div class="ac-muted mb-3">{{ $next->lesson->subject->name ?? '' }} · {{ $next->lesson->classroom->name ?? 'No room' }}{{ $next->lesson->branch ? ' · ' . $next->lesson->branch->name : '' }} · {{ $next->lesson->students_count }} student(s)</div>
                <div class="tp-countdown" data-countdown="{{ $next->start->toIso8601String() }}">starts {{ $next->start->diffForHumans($now, ['parts' => 2, 'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]) }}</div>
            @else
                <p class="ac-muted mb-0">No upcoming classes scheduled.</p>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row g-3 h-100">
            <div class="col-6"><div class="card ac-stat h-100"><div class="v">{{ $lessons->count() }}</div><div class="l">Active lessons</div></div></div>
            <div class="col-6"><div class="card ac-stat h-100"><div class="v">{{ $studentCount }}</div><div class="l">Students</div></div></div>
            <div class="col-6"><div class="card ac-stat h-100"><div class="v">{{ $week->count() }}</div><div class="l">Classes this week</div></div></div>
            <div class="col-6"><div class="card ac-stat h-100"><div class="v" style="{{ $pending->count() ? 'color:var(--red)' : '' }}">{{ $pending->count() }}</div><div class="l">Reports due</div></div></div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-calendar-day"></i> Today's classes</div><span class="ac-muted">{{ $today->count() }}</span></div>
            @if($today->isEmpty())
                <p class="ac-muted px-4 pb-4 mb-0">No classes today.</p>
            @else
                <ul class="tp-list">@foreach($today as $o)@include('teacher._class-row', ['o' => $o])@endforeach</ul>
            @endif
        </div>

        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-calendar-week"></i> Upcoming (next 7 days)</div></div>
            @if($upcoming->isEmpty())
                <p class="ac-muted px-4 pb-4 mb-0">Nothing in the next 7 days.</p>
            @else
                <ul class="tp-list">@foreach($upcoming->take(15) as $o)@include('teacher._class-row', ['o' => $o, 'showDate' => true])@endforeach</ul>
            @endif
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-exclamation-circle" style="color:var(--red)"></i> Reports to submit</div>
                @if($pending->count())<span class="badge bg-danger">{{ $pending->count() }}</span>@endif</div>
            @if($pending->isEmpty())
                <p class="ac-muted px-4 pb-4 mb-0"><i class="fas fa-check-circle text-success me-1"></i> All caught up.</p>
            @else
                <ul class="tp-list">
                    @foreach($pending->take(8) as $o)
                        <li>
                            <div class="flex-grow-1"><strong>{{ $o->lesson->name }}</strong><div class="ac-muted">{{ $o->start->format('D d M, H:i') }}</div></div>
                            <a href="{{ route('teacher.reports.edit', [$o->lesson, $o->date()]) }}" class="btn-gold-sm"><i class="fas fa-pen"></i> Submit</a>
                        </li>
                    @endforeach
                </ul>
                @if($pending->count() > 8)<div class="px-4 pb-3"><a href="{{ route('teacher.reports.index') }}">See all {{ $pending->count() }}</a></div>@endif
            @endif
        </div>

        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-folder-open"></i> Resources</div><a href="{{ route('teacher.resources.index') }}" class="small">{{ $resourceCount }} available</a></div>
            @if($newResources->isEmpty())
                <p class="ac-muted px-4 pb-4 mb-0">No new resources in the last 2 weeks.</p>
            @else
                <ul class="tp-list">
                    @foreach($newResources as $r)
                        <li><i class="fas {{ $r->icon }} fa-lg"></i><div class="flex-grow-1"><strong>{{ $r->title }}</strong><div class="ac-muted">New · {{ $r->created_at->format('d M') }}</div></div>
                            <a href="{{ route('teacher.resources.download', $r) }}" class="btn-outline-sm"><i class="fas fa-download"></i></a></li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-history"></i> Recent reports</div><a href="{{ route('teacher.reports.index') }}" class="small">All</a></div>
            @if($recent->isEmpty())
                <p class="ac-muted px-4 pb-4 mb-0">No reports yet.</p>
            @else
                <ul class="tp-list">
                    @foreach($recent as $s)
                        <li>
                            <div class="flex-grow-1"><a href="{{ route('teacher.reports.show', $s) }}" class="fw-bold text-decoration-none" style="color:var(--txt)">{{ $s->lesson->name ?? '—' }}</a>
                                <div class="ac-muted">{{ $s->session_date->format('D d M') }} · {{ $s->topic ?: \App\Models\LessonSession::COMPLETION[$s->completion_status] ?? '' }}</div></div>
                            @if($s->status === 'cancelled')<span class="badge bg-secondary">Cancelled</span>@else<span class="badge bg-light text-dark border">{{ $s->records_count }} students</span>@endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// live countdown to the next class
(function () {
    const el = document.querySelector('[data-countdown]');
    if (!el) return;
    const target = new Date(el.dataset.countdown).getTime();
    const tick = () => {
        let s = Math.round((target - Date.now()) / 1000);
        if (s <= 0) { el.textContent = 'starting now'; setTimeout(() => location.reload(), 5000); return; }
        const d = Math.floor(s / 86400); s %= 86400;
        const h = Math.floor(s / 3600); s %= 3600;
        const m = Math.floor(s / 60);
        el.textContent = 'starts in ' + (d ? d + 'd ' : '') + (d || h ? h + 'h ' : '') + m + 'm';
    };
    tick(); setInterval(tick, 30000);
})();
</script>
@endpush
