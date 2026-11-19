@extends('backend.academic.layout')
@section('page')
@php use App\Models\LessonSession as LS; use App\Models\LessonSessionStudent as R; @endphp
@include('backend.academic.partials.page-header', [
    'title' => 'Progress Reports', 'subtitle' => 'Lesson completion and student progress submitted by teachers',
    'actions' => '<a href="' . route('admin.report-settings.edit') . '" class="btn-outline-sm"><i class="fas fa-cog"></i> Report settings</a>',
])

<div class="card mb-3">
    <form class="ac-filters" method="GET" id="progress-filters">
        <div class="row g-2">
            <div class="col-lg-3 col-md-6">
                <select name="student_id" placeholder="Any student" data-ts-remote="{{ route('admin.academic.search', 'students') }}">
                    @if($studentOption)<option value="{{ $studentOption->id }}" selected>{{ $studentOption->full_name }}</option>@endif
                </select>
            </div>
            <div class="col-lg-2 col-md-6 col-6"><select name="teacher_id" class="f-input"><option value="">All teachers</option>@foreach($teachers as $t)<option value="{{ $t->id }}" @selected(request('teacher_id') == $t->id)>{{ $t->full_name }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="level_id" class="f-input"><option value="">All levels</option>@foreach($levels as $l)<option value="{{ $l->id }}" @selected(request('level_id') == $l->id)>{{ $l->name }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="subject_id" class="f-input"><option value="">All subjects</option>@foreach($subjects as $s)<option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-lg-3 col-md-4 col-6"><select name="completion_status" class="f-input"><option value="">Any lesson status</option>@foreach(LS::COMPLETION as $k => $v)<option value="{{ $k }}" @selected(request('completion_status') == $k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="progress" class="f-input"><option value="">Any progress</option>@foreach(R::PROGRESS as $k => $v)<option value="{{ $k }}" @selected(request('progress') == $k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><select name="attendance" class="f-input"><option value="">Any attendance</option>@foreach(R::ATTENDANCE as $k => $v)<option value="{{ $k }}" @selected(request('attendance') == $k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-lg-2 col-md-4 col-6"><input type="date" name="from" value="{{ request('from') }}" class="f-input" title="From"></div>
            <div class="col-lg-2 col-md-4 col-6"><input type="date" name="to" value="{{ request('to') }}" class="f-input" title="To"></div>
            <div class="col-lg-4 col-md-8 d-flex gap-2">
                <button class="btn-gold-sm"><i class="fas fa-filter"></i> Apply</button>
                <a href="{{ route('admin.progress.index') }}" class="btn-outline-sm"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md col-6"><div class="card ac-stat"><div class="v">{{ $stats['sessions'] }}</div><div class="l">Lessons reported</div></div></div>
    @foreach(LS::COMPLETION as $k => $v)
        <div class="col-md col-6"><div class="card ac-stat"><div class="v text-{{ LS::COMPLETION_COLORS[$k] }}">{{ $stats['completion'][$k] ?? 0 }}</div><div class="l">{{ $v }}</div></div></div>
    @endforeach
    <div class="col-md col-6"><div class="card ac-stat"><div class="v">{{ $stats['attendance'] !== null ? $stats['attendance'] . '%' : '—' }}</div><div class="l">Attendance</div></div></div>
    <div class="col-md col-6"><div class="card ac-stat"><div class="v">{{ $stats['avg_score'] ?? '—' }}</div><div class="l">Avg score /10</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-clipboard-list"></i> Student reports</div><span class="ac-muted">{{ $stats['reports'] }} row(s)</span></div>
            <div id="progress-table" data-ajax-table data-url="{{ route('admin.progress.index') }}">
                @include('backend.academic.progress._table')
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-hands-helping" style="color:var(--red)"></i> May need support</div>@if($support->count())<span class="badge bg-danger">{{ $support->count() }}</span>@endif</div>
            <div class="card-body-custom">
                <p class="ac-muted small">Since {{ \Carbon\Carbon::parse($support->first()->since ?? now()->subDays(30))->format('d M Y') }}: ≥2 weak reports (needs improvement / poor understanding), average score below 5, or ≥3 absences.</p>
                @forelse($support as $s)
                    <div class="d-flex justify-content-between align-items-start border-top pt-2 mt-2">
                        <div><a href="{{ route('admin.students.show', $s->student) }}"><strong>{{ $s->student->full_name }}</strong></a>
                            <div class="small text-danger">{{ implode(' · ', $s->reasons) }}</div></div>
                        <a href="{{ route('admin.progress.index', array_merge(request()->except('page'), ['student_id' => $s->student->id])) }}" class="btn-outline-sm" title="See reports"><i class="fas fa-search"></i></a>
                    </div>
                @empty
                    <p class="mb-0 small"><i class="fas fa-check-circle text-success me-1"></i> No students flagged.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
