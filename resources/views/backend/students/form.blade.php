@extends('layouts.backend')
@section('content')
@php $editing = $student->exists; @endphp
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>{{ $editing ? 'Edit Student' : 'Add Student' }}</h1><p>{{ $editing ? $student->full_name : 'Create a new student' }}</p></div>
        <a href="{{ route('admin.students.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    @include('backend.include.flash')

    <form action="{{ $editing ? route('admin.students.update', $student) : route('admin.students.store') }}" method="POST">
        @csrf
        @if($editing) @method('PUT') @endif
        <input type="hidden" name="book_lesson_id" value="{{ old('book_lesson_id', $student->book_lesson_id) }}">

        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-graduate"></i> Student Information</div></div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="f-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="f-input @error('first_name') is-invalid @enderror" value="{{ old('first_name', $student->first_name) }}">
                        @error('first_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="f-label">Last Name</label>
                        <input type="text" name="last_name" class="f-input" value="{{ old('last_name', $student->last_name) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Gender</label>
                        <select name="gender" class="f-input">
                            <option value="">—</option>
                            <option value="male" @selected(old('gender',$student->gender)=='male')>Male</option>
                            <option value="female" @selected(old('gender',$student->gender)=='female')>Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="f-input @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}">
                        @error('date_of_birth')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Current Level</label>
                        <select name="current_level" class="f-input">
                            <option value="">—</option>
                            @foreach($levels as $lv)<option value="{{ $lv }}" @selected(old('current_level',$student->current_level)==$lv)>{{ $lv }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Assigned Teacher</label>
                        <select name="teacher_id" class="f-input @error('teacher_id') is-invalid @enderror">
                            <option value="">Not assigned</option>
                            @foreach($teachers as $t)<option value="{{ $t->id }}" @selected(old('teacher_id',$student->teacher_id)==$t->id)>{{ $t->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Enrolled Date</label>
                        <input type="date" name="enrolled_at" class="f-input" value="{{ old('enrolled_at', optional($student->enrolled_at)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="f-input">
                            @foreach(['active','paused','left'] as $s)<option value="{{ $s }}" @selected(old('status',$student->status)==$s)>{{ ucfirst($s) }}</option>@endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-friends"></i> Parent / Guardian</div></div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="f-label">Parent Name</label>
                        <input type="text" name="parent_name" class="f-input" value="{{ old('parent_name', $student->parent_name) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Parent Email</label>
                        <input type="email" name="parent_email" class="f-input @error('parent_email') is-invalid @enderror" value="{{ old('parent_email', $student->parent_email) }}">
                        @error('parent_email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Parent Phone</label>
                        <input type="text" name="parent_phone" class="f-input" value="{{ old('parent_phone', $student->parent_phone) }}">
                    </div>
                    <div class="col-12">
                        <label class="f-label">Notes</label>
                        <textarea name="notes" rows="3" class="f-input">{{ old('notes', $student->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-5">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update' : 'Save' }} Student</button>
            <a href="{{ route('admin.students.index') }}" class="btn-outline-sm"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection
