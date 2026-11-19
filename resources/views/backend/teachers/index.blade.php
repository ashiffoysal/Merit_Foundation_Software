@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>Teachers</h1><p>All teachers listed below</p></div>
        <a href="{{ route('admin.teachers.create') }}" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Teacher</a>
    </div>

    @include('backend.include.flash')

    <form method="GET" class="card mb-3 p-3">
        <div class="row g-2">
            <div class="col-md-6"><input type="text" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search name, email, phone"></div>
            <div class="col-md-3">
                <select name="status" class="f-input">
                    <option value="">All status</option>
                    <option value="active" @selected(request('status')=='active')>Active</option>
                    <option value="inactive" @selected(request('status')=='inactive')>Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn-gold-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn-outline-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr><th>#</th><th>Teacher</th><th>Contact</th><th>Specialization</th><th>Students</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teachers->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($teacher->photo)
                                    <img src="{{ asset($teacher->photo) }}" width="36" height="36" style="border-radius:50%;object-fit:cover">
                                @endif
                                <div><strong>{{ $teacher->name }}</strong><br><small class="text-muted">{{ ucfirst($teacher->gender) }}</small></div>
                            </div>
                        </td>
                        <td>{{ $teacher->email }}<br><small class="text-muted">{{ $teacher->phone }}</small></td>
                        <td>{{ $teacher->specialization ?: '—' }}</td>
                        <td><span class="badge bg-primary">{{ $teacher->students_count }}</span></td>
                        <td><span class="badge {{ $teacher->status=='active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($teacher->status) }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn-outline-sm"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Delete this teacher?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger-sm"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No teachers found. <a href="{{ route('admin.teachers.create') }}">Add one</a></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($teachers->hasPages())<div class="p-3">{{ $teachers->links() }}</div>@endif
    </div>
</div>
@endsection
