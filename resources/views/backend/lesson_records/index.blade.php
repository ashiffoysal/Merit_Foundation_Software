@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>Lesson Records</h1><p>Track which topic each student covered, and how it went</p></div>
        <a href="{{ route('admin.lesson-records.create') }}" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Record</a>
    </div>

    @include('backend.include.flash')

    <form method="GET" class="card mb-3 p-3">
        <div class="row g-2">
            <div class="col-md-3">
                <select name="student_id" class="f-input">
                    <option value="">All students</option>
                    @foreach($students as $s)<option value="{{ $s->id }}" @selected(request('student_id')==$s->id)>{{ $s->full_name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="teacher_id" class="f-input">
                    <option value="">All teachers</option>
                    @foreach($teachers as $t)<option value="{{ $t->id }}" @selected(request('teacher_id')==$t->id)>{{ $t->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="lesson_id" class="f-input">
                    <option value="">All lessons</option>
                    @foreach($lessons as $l)<option value="{{ $l->id }}" @selected(request('lesson_id')==$l->id)>{{ $l->title }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="f-input">
                    <option value="">All status</option>
                    @foreach($statuses as $k => $v)<option value="{{ $k }}" @selected(request('status')==$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <input type="date" name="from" value="{{ request('from') }}" class="f-input" title="From">
                <input type="date" name="to" value="{{ request('to') }}" class="f-input" title="To">
            </div>
            <div class="col-12 d-flex gap-2">
                <button class="btn-gold-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('admin.lesson-records.index') }}" class="btn-outline-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Student</th><th>Teacher</th><th>Lesson</th><th>Topic</th><th>Status</th><th>Score</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($records as $r)
                    <tr>
                        <td>{{ $r->lesson_date->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.students.show', $r->student_id) }}">{{ $r->student->full_name ?? '—' }}</a></td>
                        <td>{{ $r->teacher->name ?? '—' }}</td>
                        <td>{{ $r->lesson->title ?? '—' }}</td>
                        <td>{{ $r->topic->title ?? '—' }}</td>
                        <td><span class="badge {{ $r->status_badge }}">{{ $statuses[$r->status] }}</span></td>
                        <td>{{ $r->score ? $r->score.'/10' : '—' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.lesson-records.edit', $r) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.lesson-records.destroy', $r) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No records found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())<div class="p-3">{{ $records->links() }}</div>@endif
    </div>
</div>
@endsection
