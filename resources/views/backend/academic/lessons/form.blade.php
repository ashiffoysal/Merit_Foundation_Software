@extends('backend.academic.layout')
@section('page')
@php $editing = $lesson->exists; @endphp
@include('backend.academic.partials.page-header', [
    'title' => $editing ? 'Edit Lesson' : 'Create Lesson',
    'subtitle' => $editing ? $lesson->name : 'Teacher and classroom clashes are checked automatically',
    'actions' => '<a href="' . ($editing ? route('admin.lessons.show', $lesson) : route('admin.lessons.index')) . '" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>',
])

<form method="POST" action="{{ $editing ? route('admin.lessons.update', $lesson) : route('admin.lessons.store') }}" data-ajax-form novalidate id="lesson-form">
    @csrf
    @if($editing) @method('PUT') @endif
    <div class="card">
        <ul class="nav ac-tabs" role="tablist">
            <x-academic.tab id="l-info" label="Lesson Information" icon="fa-book-open" active />
            <x-academic.tab id="l-schedule" label="Schedule" icon="fa-clock" />
            <x-academic.tab id="l-teacher" label="Teacher & Fees" icon="fa-chalkboard-teacher" />
            <x-academic.tab id="l-config" label="Configuration" icon="fa-cog" />
        </ul>
        <div class="tab-content ac-tab-body">
            <div class="tab-pane fade show active" id="l-info">
                <div class="row g-3">
                    <x-academic.input name="name" label="Name" :value="$lesson->name" required col="col-12" placeholder="e.g. GCSE Maths – Higher, Group A" />
                    <x-academic.select name="subject_id" label="Subject" :options="$subjects->pluck('name', 'id')" :value="$lesson->subject_id" col="col-md-6" />
                    <x-academic.select name="level_id" label="Level" :options="$levels->pluck('name', 'id')" :value="$lesson->level_id" col="col-md-6" />
                    <x-academic.select name="branch_id" label="Branch" :options="$branches->pluck('name', 'id')" :value="$lesson->branch_id" col="col-md-6" />
                    <div class="col-md-6">
                        <label class="f-label" for="f-classroom_id">Classroom</label>
                        <select name="classroom_id" id="f-classroom_id" class="f-input">
                            <option value="">— No classroom / online —</option>
                            @foreach($classrooms as $c)
                                <option value="{{ $c->id }}" data-branch="{{ $c->branch_id }}" data-capacity="{{ $c->capacity }}" @selected($lesson->classroom_id == $c->id)>{{ $c->label }}{{ $c->capacity ? " (max {$c->capacity})" : '' }}</option>
                            @endforeach
                        </select>
                        <div class="ac-help">Filtered by the selected branch.</div>
                        <div class="invalid-feedback" data-error-for="classroom_id"></div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="l-schedule">
                <div class="row g-3">
                    <x-academic.select name="weekday" label="Weekday" :options="\App\Models\Lesson::WEEKDAYS" :value="$lesson->weekday" required :search="false" col="col-md-4" placeholder="— Day —" />
                    <x-academic.input name="start_time" label="Start Time" type="time" :value="$lesson->start_time ? substr($lesson->start_time, 0, 5) : '16:00'" required col="col-md-4" />
                    <x-academic.input name="duration_minutes" label="Duration (minutes)" type="number" min="15" max="480" step="5" :value="$lesson->duration_minutes" required col="col-md-4" help="Ends at —" />
                    <x-academic.input name="capacity" label="Capacity" type="number" min="1" max="500" :value="$lesson->capacity" required col="col-md-4" />
                    <x-academic.input name="start_date" label="Start Date" type="date" :value="$lesson->start_date" required col="col-md-4" />
                    <x-academic.input name="end_date" label="End Date" type="date" :value="$lesson->end_date" col="col-md-4" help="Leave empty if ongoing" />
                </div>
            </div>

            <div class="tab-pane fade" id="l-teacher">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="f-label" for="f-teacher_id">Teacher</label>
                        <select name="teacher_id" id="f-teacher_id" class="f-input" data-ts>
                            <option value="">— Not assigned —</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" data-rate="{{ $t->hourly_rate }}" @selected($lesson->teacher_id == $t->id)>{{ $t->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" data-error-for="teacher_id"></div>
                    </div>
                    <x-academic.input name="teacher_hourly_rate" label="Teacher Hourly Rate (£)" type="number" step="0.01" min="0" :value="$lesson->teacher_hourly_rate" col="col-md-3" help="Defaults to the teacher's rate" />
                    <x-academic.input name="hourly_rate" label="Hourly Rate — student fee (£)" type="number" step="0.01" min="0" :value="$lesson->hourly_rate" col="col-md-3" />
                    <div class="col-12">
                        <div class="row g-2">
                            <div class="col-md-4"><div class="card ac-stat"><div class="v" id="pay-session">£0.00</div><div class="l">Teacher pay / session</div></div></div>
                            <div class="col-md-4"><div class="card ac-stat"><div class="v" id="pay-total">—</div><div class="l">Teacher pay for date range</div></div></div>
                            <div class="col-md-4"><div class="card ac-stat"><div class="v" id="fee-session">£0.00</div><div class="l">Fee per student / session</div></div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="l-config">
                <div class="row g-3">
                    <x-academic.select name="gender" label="Gender" :options="\App\Models\Lesson::GENDERS" :value="$lesson->gender" required :search="false" col="col-md-4" />
                    <x-academic.switch name="is_one_to_one" label="Is One-to-One?" :checked="$lesson->is_one_to_one" help="Sets capacity to 1" />
                    <x-academic.switch name="is_active" label="Is Active?" :checked="$lesson->is_active" help="Inactive lessons don't block the timetable" />
                </div>
            </div>
        </div>

        <div class="px-4 pb-3"><div id="availability" class="alert d-none mb-0 py-2" style="font-size:.84rem"></div></div>

        <div class="ac-sticky-actions">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update Lesson' : 'Save Lesson' }}</button>
            <a href="{{ $editing ? route('admin.lessons.show', $lesson) : route('admin.lessons.index') }}" class="btn-outline-sm">Cancel</a>
        </div>
    </div>
</form>
@endsection

@push('academic-scripts')
<script>
(function () {
    const f = document.getElementById('lesson-form');
    const $ = n => f.querySelector(`[name="${n}"]:not([type="hidden"])`) || f.querySelector(`[name="${n}"]`);
    const money = v => '£' + (Math.round(v * 100) / 100).toFixed(2);
    const room = $('classroom_id'), branch = $('branch_id'), teacher = $('teacher_id');
    const allRooms = [...room.options].map(o => o.cloneNode(true));

    // classrooms filtered by branch
    function filterRooms() {
        const b = branch.value, keep = room.value;
        room.innerHTML = '';
        allRooms.forEach(o => { if (!o.value || !b || !o.dataset.branch || o.dataset.branch === b) room.add(o.cloneNode(true)); });
        room.value = [...room.options].some(o => o.value === keep) ? keep : '';
    }
    branch.addEventListener('change', () => { filterRooms(); check(); });
    filterRooms();

    // teacher rate default
    teacher.addEventListener('change', () => {
        const opt = teacher.querySelector(`option[value="${teacher.value}"]`);
        const rate = $('teacher_hourly_rate');
        if (opt?.dataset.rate && (!rate.value || +rate.value === 0)) rate.value = opt.dataset.rate;
        calc(); check();
    });

    // one-to-one => capacity 1
    const oto = $('is_one_to_one');
    function syncOto() { const c = $('capacity'); if (oto.checked) { c.value = 1; c.readOnly = true; } else { c.readOnly = false; } }
    oto.addEventListener('change', syncOto); syncOto();

    // pay calculator (mirrors Lesson::countSessions)
    function sessions() {
        const s = $('start_date').value, e = $('end_date').value, wd = $('weekday').value;
        if (!s || !e || wd === '') return null;
        const target = (+wd + 6) % 7;                      // Sat=0 → JS day 6
        let d = new Date(s + 'T00:00:00'); const end = new Date(e + 'T00:00:00');
        while (d.getDay() !== target) d.setDate(d.getDate() + 1);
        return d > end ? 0 : Math.floor((end - d) / 864e5 / 7) + 1;
    }
    function calc() {
        const mins = +$('duration_minutes').value || 0;
        const pay = (+$('teacher_hourly_rate').value || 0) * mins / 60;
        document.getElementById('pay-session').textContent = money(pay);
        document.getElementById('fee-session').textContent = money((+$('hourly_rate').value || 0) * mins / 60);
        const n = sessions();
        document.getElementById('pay-total').textContent = n === null ? 'Ongoing' : `${money(pay * n)} (${n} sessions)`;
    }

    // live clash check
    const box = document.getElementById('availability');
    let timer;
    function check() {
        clearTimeout(timer);
        timer = setTimeout(async () => {
            const p = new URLSearchParams();
            ['weekday', 'start_time', 'duration_minutes', 'start_date', 'end_date', 'teacher_id', 'classroom_id'].forEach(n => p.set(n, $(n).value || ''));
            @if($editing) p.set('ignore', '{{ $lesson->id }}'); @endif
            if (!p.get('weekday') || !p.get('start_time') || !p.get('duration_minutes') || !p.get('start_date')) return;
            const r = await Academic.request('{{ route('admin.lessons.availability') }}?' + p);
            if (!r.ok) return;
            const help = f.querySelector('#f-duration_minutes').parentElement.querySelector('.ac-help');
            if (help) help.textContent = 'Ends at ' + r.data.end_time;
            const issues = [];
            r.data.teacher.forEach(l => issues.push(`Teacher busy: <b>${l.name}</b> (${l.when})`));
            r.data.classroom.forEach(l => issues.push(`Classroom booked: <b>${l.name}</b> (${l.when})`));
            box.classList.remove('d-none', 'alert-success', 'alert-danger');
            if (!$('is_active').checked) { box.classList.add('d-none'); return; }
            box.classList.add(issues.length ? 'alert-danger' : 'alert-success');
            box.innerHTML = issues.length ? '<i class="fas fa-exclamation-triangle me-1"></i> ' + issues.join('<br>') : '<i class="fas fa-check-circle me-1"></i> No teacher or classroom conflicts.';
        }, 350);
    }

    f.addEventListener('input', calc);
    f.addEventListener('change', e => { calc(); if (['weekday','start_time','duration_minutes','start_date','end_date','teacher_id','classroom_id','is_active'].includes(e.target.name)) check(); });
    calc(); check();
})();
</script>
@endpush
