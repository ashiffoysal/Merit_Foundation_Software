@extends('layouts.backend')
@section('content')
@php $editing = $record->exists; @endphp
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>{{ $editing ? 'Edit Lesson Record' : 'Add Lesson Record' }}</h1><p>Record a class session for a student</p></div>
        <a href="{{ route('admin.lesson-records.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    @include('backend.include.flash')

    <div class="card">
        <div class="card-header-custom"><div class="card-title"><i class="fas fa-clipboard-check"></i> Session Details</div></div>
        <div class="card-body-custom">
            <form action="{{ $editing ? route('admin.lesson-records.update', $record) : route('admin.lesson-records.store') }}" method="POST">
                @csrf
                @if($editing) @method('PUT') @endif
                <input type="hidden" name="redirect_to" value="{{ request('redirect_to', request('student_id') ? 'student' : '') }}">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="f-label">Student <span class="text-danger">*</span></label>
                        <select name="student_id" id="student_id" class="f-input @error('student_id') is-invalid @enderror">
                            <option value="">Select student</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" data-teacher="{{ $s->teacher_id }}" @selected(old('student_id',$record->student_id)==$s->id)>{{ $s->full_name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="f-label">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="f-input">
                            <option value="">—</option>
                            @foreach($teachers as $t)<option value="{{ $t->id }}" @selected(old('teacher_id',$record->teacher_id)==$t->id)>{{ $t->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="f-label">Lesson <span class="text-danger">*</span></label>
                        <select name="lesson_id" id="lesson_id" class="f-input @error('lesson_id') is-invalid @enderror">
                            <option value="">Select lesson</option>
                            @foreach($lessons as $l)<option value="{{ $l->id }}" @selected(old('lesson_id',$record->lesson_id)==$l->id)>{{ $l->title }}{{ $l->level ? ' ('.$l->level.')' : '' }}</option>@endforeach
                        </select>
                        @error('lesson_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="f-label">Topic</label>
                        <select name="lesson_topic_id" id="lesson_topic_id" class="f-input @error('lesson_topic_id') is-invalid @enderror"
                                data-selected="{{ old('lesson_topic_id', $record->lesson_topic_id) }}">
                            <option value="">Select lesson first</option>
                        </select>
                        @error('lesson_topic_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="lesson_date" class="f-input @error('lesson_date') is-invalid @enderror" value="{{ old('lesson_date', optional($record->lesson_date)->format('Y-m-d')) }}">
                        @error('lesson_date')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="f-input">
                            @foreach($statuses as $k => $v)<option value="{{ $k }}" @selected(old('status',$record->status)==$k)>{{ $v }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Score (1–10)</label>
                        <input type="number" min="1" max="10" name="score" class="f-input @error('score') is-invalid @enderror" value="{{ old('score', $record->score) }}">
                        @error('score')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="f-label">Teacher Comment</label>
                        <textarea name="teacher_comment" rows="3" class="f-input">{{ old('teacher_comment', $record->teacher_comment) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="f-label">Homework</label>
                        <textarea name="homework" rows="3" class="f-input">{{ old('homework', $record->homework) }}</textarea>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update' : 'Save' }} Record</button>
                        <a href="{{ route('admin.lesson-records.index') }}" class="btn-outline-sm"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    const lessonSel  = document.getElementById('lesson_id');
    const topicSel   = document.getElementById('lesson_topic_id');
    const studentSel = document.getElementById('student_id');
    const teacherSel = document.getElementById('teacher_id');
    const topicsUrl  = @json(url('admin/lessons')) + '/';

    function loadTopics(selected) {
        const id = lessonSel.value;
        topicSel.innerHTML = '<option value="">' + (id ? 'Loading…' : 'Select lesson first') + '</option>';
        if (!id) return;
        fetch(topicsUrl + id + '/topics', { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(topics => {
                topicSel.innerHTML = '<option value="">— No specific topic —</option>';
                topics.forEach(t => {
                    const o = new Option(t.title, t.id);
                    if (String(t.id) === String(selected)) o.selected = true;
                    topicSel.add(o);
                });
            });
    }

    lessonSel.addEventListener('change', () => loadTopics(null));
    loadTopics(topicSel.dataset.selected);

    // auto-pick the student's assigned teacher
    studentSel.addEventListener('change', function () {
        const t = this.selectedOptions[0]?.dataset.teacher;
        if (t) teacherSel.value = t;
    });
})();
</script>
@endsection
