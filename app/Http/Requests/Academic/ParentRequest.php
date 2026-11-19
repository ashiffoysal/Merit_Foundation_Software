<?php

namespace App\Http\Requests\Academic;

use App\Models\Guardian;
use Illuminate\Validation\Rule;

class ParentRequest extends AcademicRequest
{
    protected array $booleans = ['is_active'];

    protected array $plainText = ['first_name', 'last_name', 'phone', 'address', 'postcode', 'emergency_phone', 'emergency_contact_name', 'profession'];

    protected function prepare(): void
    {
        if ($this->filled('email')) {
            $this->merge(['email' => strtolower(trim($this->email))]);
        }
    }

    public function rules(): array
    {
        $phone = ['string', 'max:30', 'regex:/^[0-9+()\-\s]{6,30}$/'];

        return [
            'first_name'             => 'required|string|max:100',
            'last_name'              => 'required|string|max:100',
            'phone'                  => array_merge(['required'], $phone),
            'email'                  => 'nullable|email:rfc|max:255',
            'address'                => 'nullable|string|max:255',
            'postcode'               => 'nullable|string|max:20',
            'emergency_phone'        => array_merge(['nullable'], $phone),
            'emergency_contact_name' => 'nullable|string|max:150',
            'relationship'           => ['nullable', Rule::in(array_keys(Guardian::RELATIONSHIPS))],
            'profession'             => 'nullable|string|max:150',
            'is_active'              => 'boolean',
            'proof_of_address'       => $this->fileRules(),
            'proof_of_id'            => $this->fileRules(),
        ];
    }

    public function messages(): array
    {
        return parent::messages() + [
            'phone.regex'           => 'Enter a valid phone number.',
            'emergency_phone.regex' => 'Enter a valid phone number.',
        ];
    }
}
