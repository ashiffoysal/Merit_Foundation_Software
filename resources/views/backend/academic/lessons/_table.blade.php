<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Lesson</th><th>Schedule</th><th>Teacher</th><th>Room / Branch</th><th>Seats</th><th>Teacher pay</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($lessons as $l)
            <tr data-row>
                <td>
                    <a href="{{ route('admin.lessons.show', $l) }}"><strong>{{ $l->name }}</strong></a>
                    <div class="ac-muted">{{ $l->subject->name ?? '—' }} · {{ $l->level->name ?? '—' }} · {{ \App\Models\Lesson::GENDERS[$l->gender] }}</div>
                </td>
                <td><strong>{{ $l->weekday_name }}</strong> {{ $l->time_range }}<div class="ac-muted">{{ $l->start_date->format('d M Y') }} → {{ $l->end_date?->format('d M Y') ?? 'ongoing' }}</div></td>
                <td>{{ $l->teacher->full_name ?? '—' }}</td>
                <td>{{ $l->classroom->name ?? '—' }}<div class="ac-muted">{{ $l->branch->name ?? '' }}</div></td>
                <td>
                    @php $full = $l->students_count >= $l->capacity; @endphp
                    <span class="badge {{ $full ? 'bg-danger' : 'bg-primary' }}">{{ $l->students_count }}/{{ $l->capacity }}</span>
                    @if($l->is_one_to_one)<span class="badge bg-info text-dark">1-to-1</span>@endif
                </td>
                <td>£{{ number_format($l->teacher_pay_per_session, 2) }}<div class="ac-muted">per session</div></td>
                <td><x-academic.yesno :value="$l->is_active" yes="Active" no="Inactive" /></td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.lessons.show', $l) }}" class="btn-outline-sm"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.lessons.edit', $l) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.lessons.destroy', $l) }}" data-reload="#lessons-table" data-title="Delete {{ $l->name }}?" data-text="Enrolled students will be removed from this lesson."><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center ac-muted py-5">No lessons found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="ac-muted">{{ $lessons->total() }} lesson(s)</span>
    {{ $lessons->links('pagination::bootstrap-5') }}
</div>
