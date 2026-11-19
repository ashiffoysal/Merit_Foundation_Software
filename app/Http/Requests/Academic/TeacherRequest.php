<?php

namespace App\Http\Requests\Academic;

use App\Models\Teacher;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class TeacherRequest extends AcademicRequest
{
    protected array $booleans = ['has_dbs', 'is_active'];

    protected array $plainText = ['first_name', 'last_name', 'phone', 'address', 'postcode', 'job_title', 'next_of_kin', 'next_of_kin_phone', 'skills', 'certifications'];

    protected function prepare(): void
    {
        if ($this->filled('ni_number')) {
            $this->merge(['ni_number' => strtoupper(preg_replace('/\s+/', '', $this->ni_number))]);
        }
        if ($this->filled('email')) {
            $this->merge(['email' => strtolower(trim($this->email))]);
        }
    }

    public function rules(): array
    {
        $id = $this->route('teacher')?->id;

        return [
            // Personal
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'phone'             => ['required', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{6,30}$/'],
            'email'             => ['nullable', 'email:rfc', 'max:255', Rule::unique('teachers', 'email')->ignore($id)],
            'address'           => 'nullable|string|max:255',
            'postcode'          => 'nullable|string|max:20',
            'date_of_birth'     => 'nullable|date|before:-16 years',
            'gender'            => ['nullable', Rule::in(array_keys(Teacher::GENDERS))],
            'photo'             => $this->fileRules(true),
            'proof_of_address'  => $this->fileRules(),
            'proof_of_id'       => $this->fileRules(),
            // Employment
            'branch_id'         => 'nullable|exists:branches,id',
            'job_title'         => 'nullable|string|max:150',
            'ni_number'         => ['nullable', 'string', 'max:20', 'regex:/^[A-Z]{2}\d{6}[A-D]?$/'],
            'next_of_kin'       => 'nullable|string|max:150',
            'next_of_kin_phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{6,30}$/'],
            'skills'            => 'nullable|string|max:2000',
            'certifications'    => 'nullable|string|max:2000',
            'subject_ids'       => 'nullable|array',
            'subject_ids.*'     => 'integer|exists:subjects,id',
            'level_ids'         => 'nullable|array',
            'level_ids.*'       => 'integer|exists:levels,id',
            'hourly_rate'       => 'nullable|numeric|min:0|max:9999.99',
            'joining_date'      => 'nullable|date',
            'resignation_date'  => 'nullable|date|after_or_equal:joining_date',
            'has_dbs'           => 'boolean',
            'is_active'         => 'boolean',
            // Account
            'password'          => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ];
    }

    public function attributes(): array
    {
        return [
            'ni_number'        => 'NI number',
            'proof_of_address' => 'proof of address',
            'proof_of_id'      => 'proof of ID',
            'subject_ids.*'    => 'subject',
            'level_ids.*'      => 'level',
        ];
    }

    public function messages(): array
    {
        return parent::messages() + [
            'ni_number.regex'      => 'NI number must look like AB123456C.',
            'phone.regex'          => 'Enter a valid phone number.',
            'next_of_kin_phone.regex' => 'Enter a valid phone number.',
            'date_of_birth.before' => 'Teacher must be at least 16 years old.',
        ];
    }
}
