<?php

namespace App\Http\Requests\Academic;

use Illuminate\Foundation\Http\FormRequest;

abstract class AcademicRequest extends FormRequest
{
    /** checkbox / switch fields that must become real booleans */
    protected array $booleans = [];

    /** plain-text fields: trimmed + tags stripped */
    protected array $plainText = [];

    public function authorize(): bool
    {
        return true; // no permission checks – routes are already limited to logged-in admins
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        foreach ($this->booleans as $field) {
            // only cast when sent (switches always send 0/1); absent = keep the model default / current value
            if ($this->has($field)) {
                $merge[$field] = $this->boolean($field);
            }
        }
        foreach ($this->plainText as $field) {
            if (is_string($this->input($field))) {
                $merge[$field] = trim(strip_tags($this->input($field)));
            }
        }
        $this->merge($merge);
        $this->prepare();
    }

    protected function prepare(): void
    {
    }

    protected function fileRules(bool $image = false): array
    {
        return $image
            ? ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp', 'max:2048']
            : ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp,doc,docx',
               'mimetypes:application/pdf,image/jpeg,image/png,image/webp,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
               'max:5120'];
    }

    public function messages(): array
    {
        return [
            '*.max'       => 'The :attribute is too large.',
            '*.mimes'     => 'The :attribute must be a file of type: :values.',
            '*.mimetypes' => 'The :attribute file type is not allowed.',
        ];
    }
}
