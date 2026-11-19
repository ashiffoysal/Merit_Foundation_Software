@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>Lessons</h1><p>Lessons and their topics (syllabus)</p></div>
        <a href="{{ route('admin.lessons.create') }}" class="btn-gold-sm"><i class="fas fa-plus"></i> Create Lesson</a>
    </div>

    @include('backend.include.flash')

    <form method="GET" class="card mb-3 p-3">
        <div class="row g-2">
            <div class="col-md-5"><input type="text" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search lesson title"></div>
            <div class="col-md-4">
                <select name="level" class="f-input">
                    <option value="">All levels</option>
                    @foreach($levels as $lv)<option value="{{ $lv }}" @selected(request('level')==$lv)>{{ $lv }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn-gold-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('admin.lessons.index') }}" class="btn-outline-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Order</th><th>Lesson</th><th>Level</th><th>Topics</th><th>Records</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->sort_order }}</td>
                        <td><a href="{{ route('admin.lessons.show', $lesson) }}"><strong>{{ $lesson->title }}</strong></a></td>
                        <td>{{ $lesson->level ?: '—' }}</td>
                        <td><span class="badge bg-primary">{{ $lesson->topics_count }}</span></td>
                        <td><span class="badge bg-info text-dark">{{ $lesson->records_count }}</span></td>
                        <td><span class="badge {{ $lesson->status=='active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($lesson->status) }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.lessons.show', $lesson) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Delete this lesson?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No lessons yet. <a href="{{ route('admin.lessons.create') }}">Create one</a></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($lessons->hasPages())<div class="p-3">{{ $lessons->links() }}</div>@endif
    </div>
</div>
@endsection
