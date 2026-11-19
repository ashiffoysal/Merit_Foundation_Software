<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Http\Requests\Academic\ParentRequest;
use App\Models\Guardian;
use App\Services\Academic\SecureFileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    use RespondsToAjax;

    public function __construct(private SecureFileStore $files)
    {
    }

    public function index(Request $request)
    {
        $parents = Guardian::query()
            ->withCount('students')
            ->when($request->search, fn ($q, $s) => $this->searchWords($q, $s, ['first_name', 'last_name', 'email', 'phone', 'emergency_phone', 'postcode']))
            ->when($request->filled('status'), fn ($q) => $q->where('is_active', $request->status === 'active'))
            ->when($request->relationship, fn ($q, $v) => $q->where('relationship', $v))
            ->orderBy('first_name')->orderBy('last_name')
            ->paginate(15)->withQueryString();

        return $this->listing($request, 'backend.academic.parents.index', 'backend.academic.parents._table', compact('parents'));
    }

    public function create()
    {
        return view('backend.academic.parents.form', ['parent' => new Guardian(['is_active' => true])]);
    }

    public function store(ParentRequest $request)
    {
        $parent = DB::transaction(function () use ($request) {
            $parent = Guardian::create($request->safe()->except(['proof_of_address', 'proof_of_id']));
            $this->saveUploads($request, $parent);

            return $parent;
        });

        return $this->done($request, 'Parent added successfully.', route('admin.parents.show', $parent), [
            'id' => $parent->id, 'text' => "{$parent->full_name} — {$parent->phone}", // used by the "quick add" modal on the student form
        ]);
    }

    public function show(Guardian $parent)
    {
        $parent->load(['documents', 'students' => fn ($q) => $q->with(['level:id,name', 'status', 'branches:id,name'])]);

        return view('backend.academic.parents.show', compact('parent'));
    }

    public function edit(Guardian $parent)
    {
        return view('backend.academic.parents.form', ['parent' => $parent->load('documents')]);
    }

    public function update(ParentRequest $request, Guardian $parent)
    {
        DB::transaction(function () use ($request, $parent) {
            $parent->update($request->safe()->except(['proof_of_address', 'proof_of_id']));
            $this->saveUploads($request, $parent);
        });

        return $this->done($request, 'Parent updated successfully.', route('admin.parents.show', $parent));
    }

    public function destroy(Request $request, Guardian $parent)
    {

        $orphans = $parent->students()->whereDoesntHave('parents', fn ($q) => $q->whereKeyNot($parent->id))->count();
        if ($orphans > 0) {
            return $this->fail($request, "{$orphans} student(s) have no other parent linked. Link another parent to them before deleting this one.");
        }

        $parent->delete();

        return $this->done($request, 'Parent deleted.', route('admin.parents.index'));
    }

    private function saveUploads(Request $request, Guardian $parent): void
    {
        foreach (['proof_of_address', 'proof_of_id'] as $type) {
            if ($request->hasFile($type)) {
                $meta = $this->files->store($request->file($type), "parents/{$parent->id}/documents");
                $parent->documents()->create($meta + [
                    'type' => $type, 'title' => Guardian::DOCUMENT_TYPES[$type], 'uploaded_by' => auth('admin')->id(),
                ]);
            }
        }
    }
}
