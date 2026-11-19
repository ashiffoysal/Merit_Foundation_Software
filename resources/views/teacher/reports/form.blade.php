@extends('teacher.layout')
@section('title', 'Class report')
@section('content')
@php
    use App\Models\LessonSessionStudent as R;
    use App\Models\LessonSession as LS;
    $completion = old('completion_status', $session->completion_status ?? 'completed');
@endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h1>{{ $session ? 'Edit class report' : 'Class report' }}</h1>
        <p class="mb-0"><strong>{{ $lesson->name }}</strong> · {{ $lesson->level->name ?? 'No level' }} · {{ $lesson->subject->name ?? 'No subject' }} · {{ $occurrence->start->format('l d F Y') }} · {{ $occurrence->start->format('H:i') }} – {{ $occurrence->end->format('H:i') }}</p>
        @if($editNote)<p class="ac-muted small mb-0 mt-1"><i class="fas fa-info-circle me-1"></i>{{ $editNote }}</p>@endif
    </div>
    <a href="{{ route('teacher.lessons.show', $lesson) }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('teacher.reports.update', [$lesson, $occurrence->date()]) }}" data-ajax-form novalidate id="report-form">
    @csrf @method('PUT')

    <div class="card mb-4">
        <div class="card-header-custom"><div class="card-title"><i class="fas fa-sticky-note"></i> Class notes</div></div>
        <div class="card-body-custom">
            <div class="row g-3">
                <div class="col-12">
                    <label class="f-label">Lesson status *</label>
                    <div class="btn-group flex-wrap" role="group">
                        @foreach(LS::COMPLETION as $k => $label)
                            <input type="radio" class="btn-check" name="completion_status" id="cs-{{ $k }}" value="{{ $k }}" @checked($completion === $k)>
                            <label class="btn btn-outline-{{ LS::COMPLETION_COLORS[$k] }}" for="cs-{{ $k }}">{{ $label }}</label>
                        @endforeach
                    </div>
                    <div class="ac-help">"Not completed" = the lesson didn't take place (attendance is not recorded).</div>
                    <div class="invalid-feedback" data-error-for="completion_status"></div>
                </div>
                <x-academic.input name="topic" label="Lesson topic / unit *" :value="$session->topic ?? null" col="col-12 held-only" maxlength="255" placeholder="e.g. Unit 4 – Quadratic equations" />
                <x-academic.textarea name="topics_covered" label="Topics covered" :value="$session->topics_covered ?? null" rows="3" col="col-md-6 held-only" placeholder="What was actually covered in this lesson" />
                <x-academic.textarea name="homework" label="Homework assigned" :value="$session->homework ?? null" rows="3" col="col-md-6 held-only" />
                <x-academic.textarea name="notes" label="Additional comments" :value="$session->notes ?? null" rows="3" placeholder="Anything else the office should know (required when the lesson was not completed: give the reason)" />
            </div>
        </div>
    </div>

    <div class="card mb-4 held-only">
        <div class="card-header-custom flex-wrap gap-2">
            <div class="card-title"><i class="fas fa-user-check"></i> Attendance & progress ({{ $students->count() }})</div>
            <button type="button" class="btn-outline-sm" id="all-present"><i class="fas fa-check-double"></i> Mark all present</button>
        </div>
        @if($students->isEmpty())
            <p class="ac-muted px-4 pb-4 mb-0">No students are enrolled in this lesson.</p>
        @else
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Student</th><th>Attendance</th><th>Progress &amp; understanding</th><th style="width:90px">Score /10</th><th>Homework done</th><th style="min-width:220px">Challenges / to improve</th><th style="min-width:220px">Comment</th></tr></thead>
                <tbody>
                @foreach($students as $st)
                    @php $r = $records->get($st->id); $base = "students[{$st->id}]"; $key = "students.{$st->id}"; @endphp
                    <tr class="tp-student-row">
                        <td>
                            <div class="d-flex align-items-center gap-2"><x-academic.avatar :model="$st" />
                                <div><strong>{{ $st->full_name }}</strong><div class="ac-muted">{{ $st->level->name ?? '' }}</div></div></div>
                        </td>
                        <td>
                            <div class="btn-group tp-att flex-wrap" role="group">
                                @foreach(R::ATTENDANCE as $k => $label)
                                    <input type="radio" class="btn-check att" name="{{ $base }}[attendance]" id="att-{{ $st->id }}-{{ $k }}" value="{{ $k }}" @checked(old("$key.attendance", $r->attendance ?? null) === $k)>
                                    <label class="btn btn-outline-{{ R::ATTENDANCE_COLORS[$k] }}" for="att-{{ $st->id }}-{{ $k }}">{{ $label }}</label>
                                @endforeach
                            </div>
                            <div class="invalid-feedback" data-error-for="{{ $key }}.attendance"></div>
                        </td>
                        <td>
                            <select name="{{ $base }}[progress]" class="f-input progress-field" style="min-width:150px">
                                <option value="">—</option>
                                @foreach(R::PROGRESS as $k => $label)<option value="{{ $k }}" @selected(($r->progress ?? null) === $k)>{{ $label }}</option>@endforeach
                            </select>
                            <div class="invalid-feedback" data-error-for="{{ $key }}.progress"></div>
                            <select name="{{ $base }}[understanding]" class="f-input progress-field mt-1" style="min-width:150px" title="Understanding">
                                <option value="">Understanding —</option>
                                @foreach(R::UNDERSTANDING as $k => $label)<option value="{{ $k }}" @selected(($r->understanding ?? null) === $k)>{{ $label }}</option>@endforeach
                            </select>
                            <div class="invalid-feedback" data-error-for="{{ $key }}.understanding"></div>
                        </td>
                        <td>
                            <input type="number" min="1" max="10" name="{{ $base }}[score]" value="{{ $r->score ?? '' }}" class="f-input progress-field">
                            <div class="invalid-feedback" data-error-for="{{ $key }}.score"></div>
                        </td>
                        <td>
                            <select name="{{ $base }}[homework_done]" class="f-input" style="min-width:90px">
                                <option value="">—</option>
                                <option value="1" @selected(($r->homework_done ?? null) === true)>Yes</option>
                                <option value="0" @selected(($r->homework_done ?? null) === false)>No</option>
                            </select>
                        </td>
                        <td>
                            <textarea name="{{ $base }}[challenges]" rows="2" class="f-input" maxlength="1000" placeholder="Difficulties, areas to work on">{{ $r->challenges ?? '' }}</textarea>
                            <div class="invalid-feedback" data-error-for="{{ $key }}.challenges"></div>
                        </td>
                        <td>
                            <textarea name="{{ $base }}[comment]" rows="2" class="f-input" maxlength="1000" placeholder="Progress note for this student">{{ $r->comment ?? '' }}</textarea>
                            <div class="invalid-feedback" data-error-for="{{ $key }}.comment"></div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="ac-sticky-actions" style="border-top:none">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-paper-plane"></i> {{ $session ? 'Update report' : 'Submit report' }}</button>
            <a href="{{ route('teacher.lessons.show', $lesson) }}" class="btn-outline-sm">Cancel</a>
            @if($session)<span class="ac-muted align-self-center">First submitted {{ $session->submitted_at?->format('d M Y H:i') }}</span>@endif
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('report-form');
    // hide attendance/topic when the class was cancelled
    const sync = () => {
        const held = form.querySelector('[name="completion_status"]:checked')?.value !== 'not_completed';
        form.querySelectorAll('.held-only').forEach(el => el.classList.toggle('d-none', !held));
    };
    form.querySelectorAll('[name="completion_status"]').forEach(r => r.addEventListener('change', sync));
    sync();

    // absent / excused students: progress & score don't apply
    const rowSync = row => {
        const v = row.querySelector('.att:checked')?.value;
        row.querySelectorAll('.progress-field').forEach(f => { f.disabled = v === 'absent' || v === 'excused'; });
    };
    form.querySelectorAll('.tp-student-row').forEach(row => {
        row.querySelectorAll('.att').forEach(r => r.addEventListener('change', () => rowSync(row)));
        rowSync(row);
    });

    document.getElementById('all-present')?.addEventListener('click', () => {
        form.querySelectorAll('.tp-student-row').forEach(row => {
            const p = row.querySelector('.att[value="present"]');
            if (!row.querySelector('.att:checked')) { p.checked = true; rowSync(row); }
        });
    });
})();
</script>
@endpush
