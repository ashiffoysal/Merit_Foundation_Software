<?php

namespace App\Http\Requests\Academic;

use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentRequest extends AcademicRequest
{
    protected array $booleans = ['childcare', 'is_fee_delayed', 'is_active'];

    protected array $plainText = ['first_name', 'last_name', 'note'];

    protected function prepare(): void
    {
        // money fields default as specified when left empty
        foreach (['registration_fee' => 0, 'refundable_deposit' => 50, 'hourly_fee' => 0] as $f => $default) {
            if ($this->input($f) === null || $this->input($f) === '') {
                $this->merge([$f => $default]);
            }
        }
        // the primary parent must also be in the linked list
        $ids = array_values(array_filter((array) $this->input('parent_ids', [])));
        if ($this->filled('primary_parent_id') && ! in_array($this->primary_parent_id, $ids)) {
            $ids[] = $this->primary_parent_id;
        }
        $this->merge(['parent_ids' => $ids]);
    }

    public function rules(): array
    {
        return [
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'date_of_birth'      => 'nullable|date|before:today|after:-30 years',
            'gender'             => ['nullable', Rule::in(array_keys(Student::GENDERS))],
            'photo'              => $this->fileRules(true),
            // Parents
            'parent_ids'         => 'nullable|array|max:6',
            'parent_ids.*'       => 'integer|distinct|exists:parents,id',
            'primary_parent_id'  => 'nullable|integer|exists:parents,id',
            // Academic
            'branch_ids'         => 'nullable|array',
            'branch_ids.*'       => 'integer|distinct|exists:branches,id',
            'level_id'           => 'nullable|exists:levels,id',
            'school_id'          => 'nullable|exists:schools,id',
            'year_group_id'      => 'nullable|exists:year_groups,id',
            // Fees & assessment
            'registration_fee'   => 'required|numeric|min:0|max:99999.99',
            'refundable_deposit' => 'required|numeric|min:0|max:99999.99',
            'hourly_fee'         => 'required|numeric|min:0|max:9999.99',
            'assessment_date'    => 'nullable|date',
            'assessment_time'    => 'nullable|date_format:H:i',
            'student_status_id'  => 'nullable|exists:student_statuses,id',
            // Additional
            'note'               => 'nullable|string|max:5000',
            'childcare'          => 'boolean',
            'is_fee_delayed'     => 'boolean',
            'due_date_extended'  => 'nullable|date|required_if:is_fee_delayed,true',
            'is_active'          => 'boolean',
        ];
    }

    public function attributes(): array
    {
        return ['parent_ids.*' => 'parent', 'branch_ids.*' => 'branch', 'student_status_id' => 'status', 'year_group_id' => 'year group'];
    }

    public function messages(): array
    {
        return parent::messages() + [
            'due_date_extended.required_if' => 'Set the extended due date when the fee is delayed.',
            'date_of_birth.after'           => 'Please check the date of birth.',
        ];
    }
}
