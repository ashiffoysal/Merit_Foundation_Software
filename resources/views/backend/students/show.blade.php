@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>{{ $student->full_name }}</h1><p>{{ $student->current_level ?: 'Level not set' }} · Teacher: {{ $student->teacher->name ?? 'Not assigned' }}</p></div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.lesson-records.create', ['student_id' => $student->id]) }}" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Lesson Record</a>
            <a href="{{ route('admin.students.edit', $student) }}" class="btn-outline-sm"><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('admin.students.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @include('backend.include.flash')

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header-custom"><div class="card-title"><i class="fas fa-id-card"></i> Profile</div></div>
                <div class="card-body-custom" style="font-size:.9rem">
                    <p><strong>Status:</strong> {{ ucfirst($student->status) }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($student->gender ?? '—') }}</p>
                    <p><strong>DOB:</strong> {{ optional($student->date_of_birth)->format('d M Y') ?? '—' }}</p>
                    <p><strong>Enrolled:</strong> {{ optional($student->enrolled_at)->format('d M Y') ?? '—' }}</p>
                    <hr>
                    <p><strong>Parent:</strong> {{ $student->parent_name ?? '—' }}</p>
                    <p><strong>Email:</strong> {{ $student->parent_email ?? '—' }}</p>
                    <p><strong>Phone:</strong> {{ $student->parent_phone ?? '—' }}</p>
                    @if($student->notes)<hr><p class="mb-0">{{ $student->notes }}</p>@endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header-custom"><div class="card-title"><i class="fas fa-chart-line"></i> Lesson Progress</div></div>
                <div class="card-body-custom">
                    @forelse($progress as $lesson)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between" style="font-size:.9rem">
                                <strong>{{ $lesson->title }}</strong>
                                <span>{{ $lesson->done_count }} / {{ $lesson->topics_count }} topics</span>
                            </div>
                            <div class="progress" style="height:8px">
                                <div class="progress-bar bg-success" style="width: {{ $lesson->percent }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No lesson records yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header-custom"><div class="card-title"><i class="fas fa-history"></i> Lesson History</div></div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Date</th><th>Lesson</th><th>Topic</th><th>Teacher</th><th>Status</th><th>Score</th><th>Comment / Homework</th><th></th></tr></thead>
                <tbody>
                @forelse($records as $r)
                    <tr>
                        <td>{{ $r->lesson_date->format('d M Y') }}</td>
                        <td>{{ $r->lesson->title ?? '—' }}</td>
                        <td>{{ $r->topic->title ?? '—' }}</td>
                        <td>{{ $r->teacher->name ?? '—' }}</td>
                        <td><span class="badge {{ $r->status_badge }}">{{ \App\Models\LessonRecord::STATUSES[$r->status] }}</span></td>
                        <td>{{ $r->score ? $r->score.'/10' : '—' }}</td>
                        <td style="max-width:260px">
                            {{ $r->teacher_comment }}
                            @if($r->homework)<br><small class="text-muted"><i class="fas fa-book"></i> {{ $r->homework }}</small>@endif
                        </td>
                        <td>
                            <a href="{{ route('admin.lesson-records.edit', [$r, 'redirect_to' => 'student']) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No records yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())<div class="p-3">{{ $records->links() }}</div>@endif
    </div>
</div>
@endsection
