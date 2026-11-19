<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Teacher</th><th>Contact</th><th>Branch</th><th>Subjects</th><th>Rate</th><th>DBS</th><th>Lessons</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($teachers as $t)
            <tr data-row>
                <td>
                    <a href="{{ route('admin.teachers.show', $t) }}" class="d-flex align-items-center gap-2 text-decoration-none text-reset">
                        <x-academic.avatar :model="$t" />
                        <div><strong>{{ $t->full_name }}</strong><div class="ac-muted">{{ $t->job_title ?: '—' }}</div></div>
                    </a>
                </td>
                <td>{{ $t->phone }}<div class="ac-muted">{{ $t->email }}</div></td>
                <td>{{ $t->branch->name ?? '—' }}</td>
                <td style="max-width:200px">
                    @foreach($t->subjects->take(3) as $s)<span class="badge bg-light text-dark border me-1">{{ $s->name }}</span>@endforeach
                    @if($t->subjects->count() > 3)<span class="ac-muted">+{{ $t->subjects->count() - 3 }}</span>@endif
                </td>
                <td>£{{ number_format($t->hourly_rate, 2) }}</td>
                <td><x-academic.yesno :value="$t->has_dbs" no-class="bg-warning text-dark" /></td>
                <td><span class="badge bg-primary">{{ $t->lessons_count }}</span></td>
                <td>
                    @if($t->resignation_date)<span class="badge bg-dark">Resigned</span>
                    @else<x-academic.yesno :value="$t->is_active" yes="Active" no="Inactive" />@endif
                </td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.teachers.show', $t) }}" class="btn-outline-sm" title="View"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.teachers.edit', $t) }}" class="btn-outline-sm" title="Edit"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn-danger-sm" title="Delete" data-delete="{{ route('admin.teachers.destroy', $t) }}" data-reload="#teachers-table"
                            data-title="Delete {{ $t->full_name }}?" data-text="Teachers with lessons cannot be deleted."><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="9" class="text-center ac-muted py-5">No teachers found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="ac-muted">{{ $teachers->total() }} teacher(s)</span>
    {{ $teachers->links('pagination::bootstrap-5') }}
</div>
