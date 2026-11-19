<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Student</th><th>Parent</th><th>Branches</th><th>Level / Year</th><th>Assessment</th><th>Hourly fee</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($students as $s)
            @php $p = $s->parents->first(); @endphp
            <tr data-row>
                <td>
                    <a href="{{ route('admin.students.show', $s) }}" class="d-flex align-items-center gap-2 text-decoration-none text-reset">
                        <x-academic.avatar :model="$s" />
                        <div><strong>{{ $s->full_name }}</strong><div class="ac-muted">{{ $s->age ? $s->age . ' yrs' : '' }} {{ $s->lessons_count }} lesson(s)</div></div>
                    </a>
                </td>
                <td>@if($p)<a href="{{ route('admin.parents.show', $p) }}">{{ $p->full_name }}</a><div class="ac-muted">{{ $p->phone }}</div>@else<span class="ac-muted">Not linked</span>@endif</td>
                <td style="max-width:180px">@foreach($s->branches as $b)<span class="badge bg-light text-dark border me-1 mb-1">{{ $b->name }}</span>@endforeach</td>
                <td>{{ $s->level->name ?? '—' }}<div class="ac-muted">{{ $s->yearGroup->name ?? '' }}</div></td>
                <td>{{ $s->assessment_date?->format('d M Y') ?? '—' }}<div class="ac-muted">{{ $s->assessment_time_short }}</div></td>
                <td>£{{ number_format($s->hourly_fee, 2) }} @if($s->is_fee_delayed)<span class="badge bg-danger" title="Due {{ $s->due_date_extended?->format('d M Y') }}">Delayed</span>@endif</td>
                <td>
                    @if($s->status)<span class="badge bg-{{ $s->status->color }}">{{ $s->status->name }}</span>@endif
                    @unless($s->is_active)<span class="badge bg-secondary">Inactive</span>@endunless
                </td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.students.show', $s) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.students.edit', $s) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.students.destroy', $s) }}" data-reload="#students-table" data-title="Delete {{ $s->full_name }}?" data-text="The student will also be removed from their lessons."><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center ac-muted py-5">No students found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="ac-muted">{{ $students->total() }} student(s)</span>
    {{ $students->links('pagination::bootstrap-5') }}
</div>
