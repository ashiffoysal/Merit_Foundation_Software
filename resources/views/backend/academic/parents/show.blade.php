@extends('backend.academic.layout')
@section('page')
@php
    $actions = '<a href="' . route('admin.students.create', ['parent_id' => $parent->id]) . '" class="btn-outline-sm"><i class="fas fa-plus"></i> Add Child</a>'
             . '<a href="' . route('admin.parents.edit', $parent) . '" class="btn-gold-sm"><i class="fas fa-edit"></i> Edit</a>';
    {
        $actions .= '<button type="button" class="btn-danger-sm" data-delete="' . route('admin.parents.destroy', $parent) . '" data-redirect="' . route('admin.parents.index') . '" data-title="Delete ' . e($parent->full_name) . '?"><i class="fas fa-trash"></i> Delete</button>';
    }
@endphp
@include('backend.academic.partials.page-header', ['title' => $parent->full_name, 'subtitle' => ($parent->relationship_label ?: 'Parent') . ' · ' . $parent->students->count() . ' student(s)', 'actions' => $actions])

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-id-card"></i> Contact</div><x-academic.yesno :value="$parent->is_active" yes="Active" no="Inactive" /></div>
            <div class="card-body-custom">
                <dl class="ac-dl">
                    <dt>Phone</dt><dd><a href="tel:{{ $parent->phone }}">{{ $parent->phone }}</a></dd>
                    <dt>Email</dt><dd>{{ $parent->email ?: '—' }}</dd>
                    <dt>Address</dt><dd>{{ $parent->address ?: '—' }} {{ $parent->postcode }}</dd>
                    <dt>Profession</dt><dd>{{ $parent->profession ?: '—' }}</dd>
                    <dt>Emergency</dt><dd>{{ $parent->emergency_contact_name ?: '—' }}<br>{{ $parent->emergency_phone }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-graduate"></i> Children / Students</div></div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>Student</th><th>Level</th><th>Branches</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                    @forelse($parent->students as $s)
                        <tr>
                            <td><a href="{{ route('admin.students.show', $s) }}"><strong>{{ $s->full_name }}</strong></a>
                                @if($s->pivot->is_primary)<span class="badge bg-light text-dark border ms-1">Primary contact</span>@endif</td>
                            <td>{{ $s->level->name ?? '—' }}</td>
                            <td>{{ $s->branches->pluck('name')->implode(', ') ?: '—' }}</td>
                            <td>@if($s->status)<span class="badge bg-{{ $s->status->color }}">{{ $s->status->name }}</span>@endif</td>
                            <td class="text-end"><a href="{{ route('admin.students.edit', $s) }}" class="btn-outline-sm"><i class="fas fa-edit"></i></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center ac-muted py-4">No students linked yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card" id="documents-card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-file-alt"></i> Documents</div></div>
            <div class="card-body-custom" id="documents">
                @include('backend.academic.partials.documents', ['owner' => 'parents', 'model' => $parent, 'types' => \App\Models\Guardian::DOCUMENT_TYPES])
            </div>
        </div>
    </div>
</div>
@endsection
