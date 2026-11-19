<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Models\Branch;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\School;
use App\Models\StudentStatus;
use App\Models\Subject;
use App\Models\YearGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * One controller manages every admin-editable dropdown (Branch, Subject, Level, Classroom,
 * School, Year Group, Student Status) through a modal form.
 */
class LookupController extends Controller
{
    use RespondsToAjax;

    public static function types(): array
    {
        return [
            'branches' => [
                'model' => Branch::class, 'title' => 'Branches', 'singular' => 'Branch', 'icon' => 'fa-code-branch',
                'fields' => ['code' => 'Code', 'phone' => 'Phone', 'address' => 'Address'],
                'counts' => ['teachers', 'lessons', 'students', 'classrooms'],
            ],
            'subjects' => [
                'model' => Subject::class, 'title' => 'Subjects', 'singular' => 'Subject', 'icon' => 'fa-book',
                'fields' => [], 'counts' => ['lessons', 'teachers', 'learningResources'],
            ],
            'levels' => [
                'model' => Level::class, 'title' => 'Levels', 'singular' => 'Level', 'icon' => 'fa-layer-group',
                'fields' => [], 'counts' => ['lessons', 'students', 'teachers', 'learningResources'],
            ],
            'classrooms' => [
                'model' => Classroom::class, 'title' => 'Classrooms', 'singular' => 'Classroom', 'icon' => 'fa-door-open',
                'fields' => ['branch_id' => 'Branch', 'capacity' => 'Capacity'], 'counts' => ['lessons'],
            ],
            'schools' => [
                'model' => School::class, 'title' => 'Schools', 'singular' => 'School', 'icon' => 'fa-school',
                'fields' => [], 'counts' => ['students'],
            ],
            'year-groups' => [
                'model' => YearGroup::class, 'title' => 'Year Groups', 'singular' => 'Year Group', 'icon' => 'fa-users-rectangle',
                'fields' => [], 'counts' => ['students'],
            ],
            'resource-categories' => [
                'model' => \App\Models\ResourceCategory::class, 'title' => 'Resource Categories', 'singular' => 'Category', 'icon' => 'fa-folder-open',
                'fields' => [], 'counts' => ['resources'],
            ],
            'student-statuses' => [
                'model' => StudentStatus::class, 'title' => 'Student Statuses', 'singular' => 'Status', 'icon' => 'fa-tags',
                'fields' => ['color' => 'Badge colour'], 'counts' => ['students'],
            ],
        ];
    }

    public function index(Request $request, string $type)
    {
        $cfg   = $this->config($type);
        $model = $cfg['model'];
        $q     = $model::query()->withCount($this->countRelations($model, $cfg['counts']));
        if ($model === Classroom::class) {
            $q->with('branch:id,name');
        }

        $items = $q->when($request->search, fn ($q, $s) => $q->where('name', 'like', '%' . addcslashes($s, '%_') . '%'))
            ->ordered()->paginate(25)->withQueryString();

        return $this->listing($request, 'backend.academic.lookups.index', 'backend.academic.lookups._table', [
            'type' => $type, 'cfg' => $cfg, 'items' => $items, 'types' => self::types(),
            'branches' => $type === 'classrooms' ? Branch::ordered()->get(['id', 'name']) : collect(),
        ]);
    }

    public function store(Request $request, string $type)
    {
        $cfg  = $this->config($type);
        $item = $cfg['model']::create($this->validated($request, $type));

        return $this->done($request, "{$cfg['singular']} added.", null, ['item' => $item]);
    }

    public function update(Request $request, string $type, int $id)
    {
        $cfg  = $this->config($type);
        $item = $cfg['model']::findOrFail($id);
        $item->update($this->validated($request, $type, $id));

        return $this->done($request, "{$cfg['singular']} updated.", null, ['item' => $item]);
    }

    public function destroy(Request $request, string $type, int $id)
    {
        $cfg  = $this->config($type);
        $item = $cfg['model']::withCount($this->countRelations($cfg['model'], $cfg['counts']))->findOrFail($id);

        $used = collect($cfg['counts'])->sum(fn ($rel) => (int) $item->{\Illuminate\Support\Str::snake($rel) . '_count'});
        if ($used > 0) {
            return $this->fail($request, "“{$item->name}” is in use by {$used} record(s). Mark it inactive instead of deleting it.");
        }

        $item->delete();

        return $this->done($request, "{$cfg['singular']} deleted.");
    }

    // ───────────────────────── helpers

    private function config(string $type): array
    {
        abort_unless(isset(self::types()[$type]), 404);

        return self::types()[$type];
    }

    /** relation names to count (soft-deleted records are excluded automatically) */
    private function countRelations(string $model, array $rels): array
    {
        return $rels;
    }

    private function validated(Request $request, string $type, ?int $id = null): array
    {
        $request->merge(['is_active' => $request->boolean('is_active'), 'name' => trim(strip_tags((string) $request->name))]);
        $table = (new (self::types()[$type]['model']))->getTable();

        $unique = Rule::unique($table, 'name')->ignore($id);
        if ($type === 'classrooms') {
            $unique = Rule::unique($table, 'name')->ignore($id)->where('branch_id', $request->input('branch_id'));
        }

        $rules = [
            'name'       => ['required', 'string', 'max:150', $unique],
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active'  => 'boolean',
        ];

        $rules += match ($type) {
            'branches'         => ['code' => 'nullable|string|max:30', 'phone' => 'nullable|string|max:30', 'address' => 'nullable|string|max:255'],
            'classrooms'       => ['branch_id' => 'nullable|exists:branches,id', 'capacity' => 'nullable|integer|min:1|max:1000'],
            'student-statuses' => ['color' => ['required', Rule::in(StudentStatus::COLORS)]],
            default            => [],
        };

        $data = $request->validate($rules, ['name.unique' => 'This name already exists.']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
