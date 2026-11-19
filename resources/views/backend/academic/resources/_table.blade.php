<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Resource</th><th>Levels</th><th>Subjects</th><th>Category / Topic</th><th>File</th><th>Downloads</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($resources as $r)
            <tr data-row>
                <td style="max-width:280px">
                    <div class="d-flex gap-2 align-items-start">
                        <i class="fas {{ $r->icon }} fa-lg mt-1"></i>
                        <div><a href="{{ route('admin.resources.edit', $r) }}"><strong>{{ $r->title }}</strong></a>
                            @if($r->description)<div class="ac-muted">{{ \Illuminate\Support\Str::limit($r->description, 80) }}</div>@endif</div>
                    </div>
                </td>
                <td>@foreach($r->levels as $l)<span class="badge bg-light text-dark border me-1 mb-1">{{ $l->name }}</span>@endforeach</td>
                <td>@foreach($r->subjects as $s)<span class="badge bg-light text-dark border me-1 mb-1">{{ $s->name }}</span>@endforeach</td>
                <td>{{ $r->category->name ?? '—' }}<div class="ac-muted">{{ $r->topic }}</div></td>
                <td class="ac-muted">{{ strtoupper($r->extension) }} · {{ \App\Support\FileSize::human($r->size) }}</td>
                <td>{{ $r->download_count }}</td>
                <td><x-academic.yesno :value="$r->is_active" yes="Active" no="Hidden" /></td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.resources.download', $r) }}" class="btn-outline-sm" title="Download"><i class="fas fa-download"></i></a>
                    <a href="{{ route('admin.resources.edit', $r) }}" class="btn-outline-sm" title="Edit"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.resources.destroy', $r) }}" data-reload="#resources-table" data-title="Delete “{{ $r->title }}”?" data-text="The file will be removed and teachers will no longer see it."><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center ac-muted py-5">No resources yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="ac-muted">{{ $resources->total() }} resource(s)</span>
    {{ $resources->links('pagination::bootstrap-5') }}
</div>
