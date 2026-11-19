<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Models\Classroom;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

/** JSON endpoints for the AJAX searchable dropdowns (Tom Select). Returns [{id, text, sub}] */
class SearchController extends Controller
{
    use RespondsToAjax;

    public function __invoke(Request $request, string $type)
    {
        $term = (string) $request->input('q', '');

        $results = match ($type) {
            'parents' => $this->searchWords(Guardian::query()->where('is_active', true), $term, ['first_name', 'last_name', 'phone', 'email'])
                ->orderBy('first_name')->limit(20)->get()
                ->map(fn ($p) => ['id' => $p->id, 'text' => $p->full_name, 'sub' => trim("{$p->phone} {$p->email}")]),

            'students' => $this->searchWords(Student::query()->with('level:id,name')->where('is_active', true), $term, ['first_name', 'last_name'])
                ->when($request->exclude_lesson, fn ($q, $l) => $q->whereDoesntHave('lessons', fn ($q) => $q->whereKey($l)))
                ->orderBy('first_name')->limit(20)->get()
                ->map(fn ($s) => ['id' => $s->id, 'text' => $s->full_name,
                    'sub' => trim(($s->level?->name ?? '') . ' ' . ($s->gender ? '· ' . ucfirst($s->gender) : ''))]),

            'teachers' => $this->searchWords(Teacher::query()->where('is_active', true), $term, ['first_name', 'last_name', 'email', 'phone'])
                ->orderBy('first_name')->limit(20)->get()
                ->map(fn ($t) => ['id' => $t->id, 'text' => $t->full_name, 'sub' => $t->phone, 'rate' => $t->hourly_rate]),

            'classrooms' => Classroom::query()->with('branch:id,name')->where('is_active', true)
                ->when($request->branch_id, fn ($q, $b) => $q->where('branch_id', $b))
                ->when($term, fn ($q) => $q->where('name', 'like', '%' . addcslashes($term, '%_') . '%'))
                ->ordered()->limit(50)->get()
                ->map(fn ($c) => ['id' => $c->id, 'text' => $c->label, 'sub' => $c->capacity ? "Capacity {$c->capacity}" : '']),

            default => abort(404),
        };

        return response()->json($results->values());
    }
}
