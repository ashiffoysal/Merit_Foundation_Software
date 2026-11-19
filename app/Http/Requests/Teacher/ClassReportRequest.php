<?php

namespace App\Http\Requests\Teacher;

use App\Models\LessonSession;
use App\Models\LessonSessionStudent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('teacher')->check(); // lesson ownership is checked in the controller
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        // lesson status drives whether the class was held (older clients may still send status=held|cancelled)
        $completion = $this->input('completion_status')
            ?? ($this->input('status') === 'cancelled' ? 'not_completed' : ($this->input('status') === 'held' ? 'completed' : null));
        $merge['completion_status'] = $completion;
        $merge['status'] = $completion === 'not_completed' ? 'cancelled' : 'held';

        foreach (['topic', 'topics_covered', 'notes', 'homework'] as $f) {
            if (is_string($this->input($f))) {
                $merge[$f] = trim(strip_tags($this->input($f)));
            }
        }
        $students = [];
        foreach ((array) $this->input('students', []) as $id => $row) {
            $row = (array) $row;
            foreach (['comment', 'challenges'] as $f) {
                if (isset($row[$f])) {
                    $row[$f] = trim(strip_tags($row[$f]));
                }
            }
            if (isset($row['homework_done']) && $row['homework_done'] === '') {
                unset($row['homework_done']);
            }
            $students[$id] = $row;
        }
        $merge['students'] = $students;
        $this->merge($merge);
    }

    public function rules(): array
    {
        return [
            'completion_status'         => ['required', Rule::in(array_keys(LessonSession::COMPLETION))],
            'status'                    => ['required', Rule::in(['held', 'cancelled'])],
            'topic'                     => 'required_if:status,held|nullable|string|max:255',
            'topics_covered'            => 'nullable|string|max:3000',
            'notes'                     => 'required_if:status,cancelled|nullable|string|max:5000',
            'homework'                  => 'nullable|string|max:2000',
            'students'                  => 'array',
            'students.*.attendance'     => ['required_if:status,held', 'nullable', Rule::in(array_keys(LessonSessionStudent::ATTENDANCE))],
            'students.*.progress'       => ['nullable', Rule::in(array_keys(LessonSessionStudent::PROGRESS))],
            'students.*.understanding'  => ['nullable', Rule::in(array_keys(LessonSessionStudent::UNDERSTANDING))],
            'students.*.challenges'     => 'nullable|string|max:1000',
            'students.*.score'          => 'nullable|integer|min:1|max:10',
            'students.*.homework_done'  => 'nullable|boolean',
            'students.*.comment'        => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'completion_status.required'       => 'Choose the lesson status.',
            'topic.required_if'                => 'Write the lesson topic / unit.',
            'notes.required_if'                => 'Explain why the lesson was not completed.',
            'students.*.attendance.required_if' => 'Mark attendance for every student.',
            'students.*.score.max'             => 'Score must be between 1 and 10.',
            'students.*.score.min'             => 'Score must be between 1 and 10.',
        ];
    }
}
