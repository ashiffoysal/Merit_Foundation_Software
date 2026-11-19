<?php

namespace App\Http\Requests\Academic;

use App\Models\Guardian;
use App\Models\Teacher;
use Illuminate\Validation\Rule;

class DocumentRequest extends AcademicRequest
{
    protected array $plainText = ['title'];

    public function rules(): array
    {
        $types = $this->route('owner') === 'teachers' ? Teacher::DOCUMENT_TYPES : Guardian::DOCUMENT_TYPES;
        $file  = $this->fileRules();
        $file[0] = 'required';

        return [
            'type'  => ['required', Rule::in(array_keys($types))],
            'title' => 'nullable|string|max:150',
            'file'  => $file,
        ];
    }
}
