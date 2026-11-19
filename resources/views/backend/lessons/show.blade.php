@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>{{ $lesson->title }}</h1><p>{{ $lesson->level ?: 'No level' }} · {{ $lesson->topics->count() }} topics · {{ $lesson->records_count }} records</p></div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn-gold-sm"><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('admin.lessons.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @include('backend.include.flash')

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header-custom"><div class="card-title"><i class="fas fa-list-ol"></i> Topics</div></div>
                <div class="card-body-custom">
                    @if($lesson->description)<p>{{ $lesson->description }}</p>@endif
                    <ol class="mb-0">
                        @forelse($lesson->topics as $topic)
                            <li class="mb-1"><strong>{{ $topic->title }}</strong>@if($topic->description)<br><small class="text-muted">{{ $topic->description }}</small>@endif</li>
                        @empty
                            <p class="text-muted">No topics yet.</p>
                        @endforelse
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header-custom"><div class="card-title"><i class="fas fa-history"></i> Recent Records</div></div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead><tr><th>Date</th><th>Student</th><th>Topic</th><th>Status</th></tr></thead>
                        <tbody>
                        @forelse($recentRecords as $r)
                            <tr>
                                <td>{{ $r->lesson_date->format('d M Y') }}</td>
                                <td><a href="{{ route('admin.students.show', $r->student_id) }}">{{ $r->student->full_name ?? '—' }}</a></td>
                                <td>{{ $r->topic->title ?? '—' }}</td>
                                <td><span class="badge {{ $r->status_badge }}">{{ \App\Models\LessonRecord::STATUSES[$r->status] }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No records yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
