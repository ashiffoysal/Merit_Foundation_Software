<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Parent</th><th>Phone</th><th>Email</th><th>Relationship</th><th>Students</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($parents as $p)
            <tr data-row>
                <td><a href="{{ route('admin.parents.show', $p) }}"><strong>{{ $p->full_name }}</strong></a><div class="ac-muted">{{ $p->postcode }}</div></td>
                <td>{{ $p->phone }}</td>
                <td>{{ $p->email ?: '—' }}</td>
                <td>{{ $p->relationship_label ?: '—' }}</td>
                <td><span class="badge bg-primary">{{ $p->students_count }}</span></td>
                <td><x-academic.yesno :value="$p->is_active" yes="Active" no="Inactive" /></td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.parents.show', $p) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.parents.edit', $p) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.parents.destroy', $p) }}" data-reload="#parents-table" data-title="Delete {{ $p->full_name }}?"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center ac-muted py-5">No parents found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="ac-muted">{{ $parents->total() }} parent(s)</span>
    {{ $parents->links('pagination::bootstrap-5') }}
</div>
