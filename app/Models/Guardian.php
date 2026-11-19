<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A student's parent / guardian. ("Parent" is a reserved word in PHP, so the class is Guardian;
 * the table is `parents` as specified.)
 */
class Guardian extends Model
{
    use SoftDeletes;

    protected $table = 'parents';

    public const RELATIONSHIPS = [
        'mother' => 'Mother', 'father' => 'Father', 'guardian' => 'Legal Guardian', 'grandparent' => 'Grandparent',
        'step_parent' => 'Step-parent', 'sibling' => 'Sibling', 'carer' => 'Carer', 'other' => 'Other',
    ];

    public const DOCUMENT_TYPES = [
        'proof_of_address' => 'Proof of Address',
        'proof_of_id'      => 'Proof of ID',
        'consent'          => 'Consent Form',
        'agreement'        => 'Agreement',
        'other'            => 'Other',
    ];

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'postcode', 'emergency_phone',
        'emergency_contact_name', 'relationship', 'profession', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getRelationshipLabelAttribute(): ?string
    {
        return self::RELATIONSHIPS[$this->relationship] ?? $this->relationship;
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_parent', 'parent_id', 'student_id')
            ->withPivot('is_primary')->withTimestamps();
    }

    public function documents()
    {
        return $this->hasMany(ParentDocument::class, 'parent_id')->latest();
    }
}
