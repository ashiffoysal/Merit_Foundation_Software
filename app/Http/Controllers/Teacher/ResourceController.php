<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LearningResource;
use App\Models\ResourceCategory;
use App\Services\Academic\SecureFileStore;
use Illuminate\Http\Request;

/** Teacher: only resources matching the teacher's assigned levels AND subjects. */
class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $teacher  = auth('teacher')->user()->load(['levels:id,name', 'subjects:id,name']);
        $levels   = $teacher->levels;
        $subjects = $teacher->subjects;

        $resources = LearningResource::query()
            ->visibleTo($teacher)
            ->with(['levels:id,name', 'subjects:id,name', 'category:id,name'])
            ->when($request->search, function ($q, $s) {
                $like = '%' . addcslashes($s, '%_') . '%';
                $q->where(fn ($q) => $q->where('title', 'like', $like)->orWhere('topic', 'like', $like)->orWhere('description', 'like', $like));
            })
            // filters can only narrow inside the teacher's own levels/subjects
            ->when($levels->contains('id', (int) $request->level_id), fn ($q) => $q->whereHas('levels', fn ($l) => $l->whereKey($request->level_id)))
            ->when($subjects->contains('id', (int) $request->subject_id), fn ($q) => $q->whereHas('subjects', fn ($l) => $l->whereKey($request->subject_id)))
            ->when($request->category_id, fn ($q, $v) => $q->where('resource_category_id', $v))
            ->latest()
            ->paginate(18)->withQueryString();

        return view('teacher.resources.index', [
            'resources'  => $resources,
            'levels'     => $levels,
            'subjects'   => $subjects,
            'categories' => ResourceCategory::ordered()->get(['id', 'name']),
            'teacher'    => $teacher,
        ]);
    }

    public function download(Request $request, LearningResource $resource, SecureFileStore $files)
    {
        $teacher = auth('teacher')->user();

        // backend check – the same rule as the list, so guessing an id doesn't work
        abort_unless($resource->isVisibleTo($teacher), 404);

        $resource->downloads()->create(['teacher_id' => $teacher->id, 'downloaded_at' => now()]);
        $resource->increment('download_count');

        return $files->respond($resource->file_path, $resource->original_name, $request->boolean('inline') && $resource->isPreviewable());
    }
}
