<?php

namespace App\Http\Requests\Academic;

use App\Models\LearningResource;

class ResourceRequest extends AcademicRequest
{
    protected array $booleans = ['is_active'];

    protected array $plainText = ['title', 'description', 'topic'];

    public function rules(): array
    {
        $editing = (bool) $this->route('resource');

        return [
            'title'                => 'required|string|max:200',
            'description'          => 'nullable|string|max:5000',
            'resource_category_id' => 'nullable|exists:resource_categories,id',
            'topic'                => 'nullable|string|max:200',
            'level_ids'            => 'required|array|min:1',
            'level_ids.*'          => 'integer|distinct|exists:levels,id',
            'subject_ids'          => 'required|array|min:1',
            'subject_ids.*'        => 'integer|distinct|exists:subjects,id',
            'is_active'            => 'boolean',
            'file'                 => [$editing ? 'nullable' : 'required', 'file', 'max:' . LearningResource::MAX_KB,
                                       // checked against the file's real content type, so a renamed .php/.exe is rejected
                                       'mimes:' . implode(',', LearningResource::EXTENSIONS)],
        ];
    }

    public function attributes(): array
    {
        return ['level_ids' => 'levels', 'subject_ids' => 'subjects', 'resource_category_id' => 'category'];
    }

    public function messages(): array
    {
        return parent::messages() + [
            'level_ids.required'   => 'Choose at least one level.',
            'subject_ids.required' => 'Choose at least one subject.',
            'file.required'        => 'Choose a file to upload.',
            'file.max'             => 'The file may not be larger than ' . (LearningResource::MAX_KB / 1024) . ' MB.',
        ];
    }
}
