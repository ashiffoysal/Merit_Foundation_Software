{{-- $owner = 'teachers'|'parents', $model, $types --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <span class="ac-muted"><i class="fas fa-lock me-1"></i> Stored privately — only logged-in admins can open these files.</span>
    <button type="button" class="btn-gold-sm" data-bs-toggle="modal" data-bs-target="#docModal"><i class="fas fa-upload"></i> Upload Document</button>
</div>

<div class="table-wrap">
    <table class="data-table">
        <thead><tr><th>Type</th><th>Title / File</th><th>Size</th><th>Uploaded</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse($model->documents as $doc)
            <tr data-row>
                <td><span class="badge bg-light text-dark border">{{ $doc->type_label }}</span></td>
                <td><strong>{{ $doc->title ?: $doc->type_label }}</strong><div class="ac-muted">{{ $doc->original_name }}</div></td>
                <td>{{ \Illuminate\Support\Number::fileSize($doc->size) }}</td>
                <td>{{ $doc->created_at->format('d M Y') }}</td>
                <td class="text-end text-nowrap">
                    @if(str_starts_with($doc->mime_type, 'image/') || $doc->mime_type === 'application/pdf')
                        <a href="{{ route('admin.documents.download', [$owner, $doc->id]) }}?inline=1" target="_blank" rel="noopener" class="btn-outline-sm" title="View"><i class="fas fa-eye"></i></a>
                    @endif
                    <a href="{{ route('admin.documents.download', [$owner, $doc->id]) }}" class="btn-outline-sm" title="Download"><i class="fas fa-download"></i></a>
                        <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.documents.destroy', [$owner, $doc->id]) }}" data-title="Delete this document?"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center ac-muted py-4">No documents uploaded yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="docModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST" action="{{ route('admin.documents.store', [$owner, $model->id]) }}" enctype="multipart/form-data" data-ajax-form novalidate>
            @csrf
            <div class="modal-header"><h5 class="modal-title">Upload Document</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <x-academic.select name="type" label="Document type" :options="$types" col="col-12" required :search="false" />
                    <x-academic.input name="title" label="Title (optional)" col="col-12" maxlength="150" />
                    <x-academic.file name="file" label="File *" col="col-12" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-gold-sm"><i class="fas fa-upload"></i> Upload</button>
            </div>
        </form>
    </div>
</div>
