<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Http\Requests\Academic\ResourceRequest;
use App\Models\LearningResource;
use App\Models\Level;
use App\Models\ResourceCategory;
use App\Models\Subject;
use App\Services\Academic\SecureFileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Admin: learning resources for teachers */
class ResourceController extends Controller
{
    use RespondsToAjax;

    public function __construct(private SecureFileStore $files)
    {
    }

    public function index(Request $request)
    {
        $resources = LearningResource::query()
            ->with(['levels:id,name', 'subjects:id,name', 'category:id,name'])
            ->when($request->search, fn ($q, $s) => $this->searchWords($q, $s, ['title', 'topic', 'description', 'original_name']))
            ->when($request->level_id, fn ($q, $v) => $q->whereHas('levels', fn ($l) => $l->whereKey($v)))
            ->when($request->subject_id, fn ($q, $v) => $q->whereHas('subjects', fn ($s) => $s->whereKey($v)))
            ->when($request->category_id, fn ($q, $v) => $q->where('resource_category_id', $v))
            ->when($request->filled('active'), fn ($q) => $q->where('is_active', $request->active === 'yes'))
            ->latest()
            ->paginate(20)->withQueryString();

        return $this->listing($request, 'backend.academic.resources.index', 'backend.academic.resources._table', [
            'resources'  => $resources,
            'levels'     => Level::ordered()->get(['id', 'name']),
            'subjects'   => Subject::ordered()->get(['id', 'name']),
            'categories' => ResourceCategory::ordered()->get(['id', 'name']),
        ]);
    }

    public function create()
    {
        $resource = new LearningResource();
        $resource->setRelation('levels', collect());
        $resource->setRelation('subjects', collect());

        return view('backend.academic.resources.form', $this->formData($resource));
    }

    public function store(ResourceRequest $request)
    {
        $resource = DB::transaction(function () use ($request) {
            $meta = $this->files->store($request->file('file'), 'resources');
            $resource = LearningResource::create($request->safe()->except(['file', 'level_ids', 'subject_ids']) + [
                'file_path'   => $meta['path'],
                'original_name' => $meta['original_name'],
                'mime_type'   => $meta['mime_type'],
                'size'        => $meta['size'],
                'uploaded_by' => auth('admin')->id(),
            ]);
            $resource->levels()->sync($request->input('level_ids'));
            $resource->subjects()->sync($request->input('subject_ids'));

            return $resource;
        });

        return $this->done($request, 'Resource uploaded.', route('admin.resources.edit', $resource));
    }

    public function edit(LearningResource $resource)
    {
        $resource->load(['levels:id', 'subjects:id']);

        return view('backend.academic.resources.form', $this->formData($resource) + [
            'teachers'  => $resource->eligibleTeachers()->get(['id', 'first_name', 'last_name']),
            'downloads' => $resource->downloads()->with('teacher:id,first_name,last_name')->latest('downloaded_at')->take(10)->get(),
        ]);
    }

    public function update(ResourceRequest $request, LearningResource $resource)
    {
        DB::transaction(function () use ($request, $resource) {
            $data = $request->safe()->except(['file', 'level_ids', 'subject_ids']);
            $old  = null;
            if ($request->hasFile('file')) {
                $meta = $this->files->store($request->file('file'), 'resources');
                $old  = $resource->file_path;
                $data += ['file_path' => $meta['path'], 'original_name' => $meta['original_name'], 'mime_type' => $meta['mime_type'], 'size' => $meta['size']];
            }
            $resource->update($data);
            $resource->levels()->sync($request->input('level_ids'));
            $resource->subjects()->sync($request->input('subject_ids'));

            DB::afterCommit(fn () => $this->files->delete($old));
        });

        return $this->done($request, 'Resource updated.', route('admin.resources.edit', $resource));
    }

    public function destroy(Request $request, LearningResource $resource)
    {
        $path = $resource->file_path;
        $resource->delete();
        $this->files->delete($path);

        return $this->done($request, 'Resource deleted.', route('admin.resources.index'));
    }

    public function download(Request $request, LearningResource $resource)
    {
        $resource->downloads()->create(['admin_id' => auth('admin')->id(), 'downloaded_at' => now()]);

        return $this->files->respond($resource->file_path, $resource->original_name, $request->boolean('inline') && $resource->isPreviewable());
    }

    private function formData(LearningResource $resource): array
    {
        return [
            'resource'   => $resource,
            'levels'     => Level::options($resource->levels->pluck('id')->all()),
            'subjects'   => Subject::options($resource->subjects->pluck('id')->all()),
            'categories' => ResourceCategory::options($resource->resource_category_id),
        ];
    }
}
