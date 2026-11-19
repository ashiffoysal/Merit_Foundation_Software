<?php

namespace App\Http\Requests\Academic;

use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Services\Academic\LessonScheduler;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class LessonRequest extends AcademicRequest
{
    protected array $booleans = ['is_active', 'is_one_to_one'];

    protected array $plainText = ['name'];

    protected function prepare(): void
    {
        if ($this->boolean('is_one_to_one')) {
            $this->merge(['capacity' => 1]);
        }
        foreach (['teacher_hourly_rate', 'hourly_rate'] as $f) {
            if ($this->input($f) === null) {
                $this->merge([$f => 0]);
            }
        }
        // default the teacher's rate from the teacher profile
        if (! $this->filled('teacher_hourly_rate') || (float) $this->teacher_hourly_rate === 0.0) {
            if ($this->filled('teacher_id') && $t = Teacher::find($this->teacher_id)) {
                $this->merge(['teacher_hourly_rate' => $t->hourly_rate]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'name'                => 'required|string|max:150',
            'branch_id'           => 'nullable|exists:branches,id',
            'subject_id'          => 'nullable|exists:subjects,id',
            'level_id'            => 'nullable|exists:levels,id',
            'teacher_id'          => ['nullable', Rule::exists('teachers', 'id')->whereNull('deleted_at')],
            'classroom_id'        => 'nullable|exists:classrooms,id',
            'weekday'             => ['required', 'integer', Rule::in(array_keys(Lesson::WEEKDAYS))],
            'start_time'          => 'required|date_format:H:i',
            'duration_minutes'    => 'required|integer|min:15|max:480',
            'capacity'            => 'required|integer|min:1|max:500',
            'start_date'          => 'required|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
            'gender'              => ['required', Rule::in(array_keys(Lesson::GENDERS))],
            'teacher_hourly_rate' => 'required|numeric|min:0|max:9999.99',
            'hourly_rate'         => 'required|numeric|min:0|max:9999.99',
            'is_active'           => 'boolean',
            'is_one_to_one'       => 'boolean',
        ];
    }

    public function after(): array
    {
        return [function (Validator $v) {
            if ($v->errors()->isNotEmpty()) {
                return;
            }
            $data     = $this->only(array_keys($this->rules()));
            $lesson   = $this->route('lesson');
            $ignoreId = $lesson?->id;

            // lesson must end the same day
            $end = LessonScheduler::endTime(LessonScheduler::normaliseTime($data['start_time']), (int) $data['duration_minutes']);
            if ($end === '23:59:59') {
                $v->errors()->add('duration_minutes', 'The lesson must finish before midnight.');
            }

            if (! ($data['is_active'] ?? true)) {
                return; // inactive lessons don't block anything
            }

            $scheduler = app(LessonScheduler::class);

            if ($data['teacher_id'] ?? null) {
                $teacher = Teacher::find($data['teacher_id']);
                if ($teacher && ! $teacher->is_active) {
                    $v->errors()->add('teacher_id', 'This teacher is not active.');
                }
                if ($teacher?->resignation_date && $teacher->resignation_date->lt($data['start_date'])) {
                    $v->errors()->add('teacher_id', 'This teacher resigned before the lesson start date.');
                }
                $clash = $scheduler->teacherConflicts($data, $ignoreId);
                if ($clash->isNotEmpty()) {
                    $v->errors()->add('teacher_id', 'Teacher is already teaching at this time: ' . LessonScheduler::describe($clash) . '.');
                }
            }

            if ($data['classroom_id'] ?? null) {
                $room = Classroom::find($data['classroom_id']);
                if ($room && ($data['branch_id'] ?? null) && $room->branch_id && $room->branch_id != $data['branch_id']) {
                    $v->errors()->add('classroom_id', 'This classroom belongs to a different branch.');
                }
                if ($room?->capacity && $data['capacity'] > $room->capacity) {
                    $v->errors()->add('capacity', "Classroom {$room->name} only holds {$room->capacity} students.");
                }
                $clash = $scheduler->classroomConflicts($data, $ignoreId);
                if ($clash->isNotEmpty()) {
                    $v->errors()->add('classroom_id', 'Classroom is already booked: ' . LessonScheduler::describe($clash) . '.');
                }
            }

            if ($lesson) {
                $enrolled = $lesson->students()->count();
                if ($data['capacity'] < $enrolled) {
                    $v->errors()->add('capacity', "{$enrolled} students are already enrolled; capacity cannot be lower than that.");
                }
            }
        }];
    }

    public function attributes(): array
    {
        return ['teacher_id' => 'teacher', 'classroom_id' => 'classroom', 'duration_minutes' => 'duration'];
    }
}
