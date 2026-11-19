<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Http\Requests\Academic\DocumentRequest;
use App\Models\Guardian;
use App\Models\ParentDocument;
use App\Models\Teacher;
use App\Models\TeacherDocument;
use App\Services\Academic\SecureFileStore;
use Illuminate\Http\Request;

/** Upload / view / download / delete private documents for teachers and parents. */
class DocumentController extends Controller
{
    use RespondsToAjax;

    private const OWNERS = [
        'teachers' => ['owner' => Teacher::class, 'doc' => TeacherDocument::class, 'fk' => 'teacher_id', 'show' => 'admin.teachers.show'],
        'parents'  => ['owner' => Guardian::class, 'doc' => ParentDocument::class, 'fk' => 'parent_id', 'show' => 'admin.parents.show'],
    ];

    public function __construct(private SecureFileStore $files)
    {
    }

    public function store(DocumentRequest $request, string $owner, int $id)
    {
        $cfg   = $this->cfg($owner);
        $model = $cfg['owner']::findOrFail($id);

        $meta = $this->files->store($request->file('file'), "{$owner}/{$model->id}/documents");
        $model->documents()->create($meta + [
            'type'        => $request->type,
            'title'       => $request->title ?: null,
            'uploaded_by' => auth('admin')->id(),
        ]);

        return $this->done($request, 'Document uploaded.', route($cfg['show'], $model) . '#documents');
    }

    public function download(Request $request, string $owner, int $document)
    {
        $doc = $this->cfg($owner)['doc']::findOrFail($document);

        $inline = $request->boolean('inline') && (str_starts_with($doc->mime_type, 'image/') || $doc->mime_type === 'application/pdf');

        return $this->files->respond($doc->path, $doc->original_name, $inline);
    }

    public function destroy(Request $request, string $owner, int $document)
    {
        $cfg = $this->cfg($owner);
        $doc = $cfg['doc']::findOrFail($document);

        $this->files->delete($doc->path);
        $doc->delete();

        return $this->done($request, 'Document deleted.', route($cfg['show'], $doc->{$cfg['fk']}) . '#documents');
    }

    private function cfg(string $owner): array
    {
        abort_unless(isset(self::OWNERS[$owner]), 404);

        return self::OWNERS[$owner];
    }
}
