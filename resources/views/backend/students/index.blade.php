@extends('layouts.backend')
@section('content')
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>Students</h1><p>All students listed below</p></div>
        <a href="{{ route('admin.students.create') }}" class="btn-gold-sm"><i class="fas fa-plus"></i> Add Student</a>
    </div>

    @include('backend.include.flash')

    <form method="GET" class="card mb-3 p-3">
        <div class="row g-2">
            <div class="col-md-4"><input type="text" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search student / parent"></div>
            <div class="col-md-3">
                <select name="teacher_id" class="f-input">
                    <option value="">All teachers</option>
                    @foreach($teachers as $t)<option value="{{ $t->id }}" @selected(request('teacher_id')==$t->id)>{{ $t->name }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="f-input">
                    <option value="">All status</option>
                    @foreach(['active','paused','left'] as $s)<option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn-gold-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('admin.students.index') }}" class="btn-outline-sm">Reset</a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>#</th><th>Student</th><th>Level</th><th>Teacher</th><th>Parent</th><th>Records</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $students->firstItem() + $loop->index }}</td>
                        <td><a href="{{ route('admin.students.show', $student) }}"><strong>{{ $student->full_name }}</strong></a></td>
                        <td>{{ $student->current_level ?: '—' }}</td>
                        <td>{{ $student->teacher->name ?? '—' }}</td>
                        <td>{{ $student->parent_name }}<br><small class="text-muted">{{ $student->parent_phone }}</small></td>
                        <td><span class="badge bg-primary">{{ $student->lesson_records_count }}</span></td>
                        <td>
                            @php $c = ['active'=>'bg-success','paused'=>'bg-warning text-dark','left'=>'bg-secondary'][$student->status] ?? 'bg-light'; @endphp
                            <span class="badge {{ $c }}">{{ ucfirst($student->status) }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No students found. <a href="{{ route('admin.students.create') }}">Add one</a></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())<div class="p-3">{{ $students->links() }}</div>@endif
    </div>
</div>
@endsection
