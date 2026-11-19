@extends('layouts.backend')
@section('content')
@php $editing = $teacher->exists; @endphp
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>{{ $editing ? 'Edit Teacher' : 'Add Teacher' }}</h1><p>{{ $editing ? $teacher->name : 'Create a new teacher profile' }}</p></div>
        <a href="{{ route('admin.teachers.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    @include('backend.include.flash')

    <div class="card">
        <div class="card-header-custom"><div class="card-title"><i class="fas fa-chalkboard-teacher"></i> Teacher Details</div></div>
        <div class="card-body-custom">
            <form action="{{ $editing ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($editing) @method('PUT') @endif

                <div class="row g-3">
                    @foreach([
                        ['name','Full Name','text',true],
                        ['email','Email','email',true],
                        ['phone','Phone','text',false],
                        ['specialization','Specialization (e.g. Qaida, Tajweed, Hifz)','text',false],
                    ] as [$field,$label,$type,$req])
                        <div class="col-md-6">
                            <div class="f-group">
                                <label class="f-label">{{ $label }} @if($req)<span class="text-danger">*</span>@endif</label>
                                <input type="{{ $type }}" name="{{ $field }}" class="f-input @error($field) is-invalid @enderror" value="{{ old($field, $teacher->$field) }}">
                                @error($field)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    @endforeach

                    <div class="col-md-4">
                        <div class="f-group">
                            <label class="f-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="f-input @error('gender') is-invalid @enderror">
                                <option value="">Select</option>
                                <option value="male" @selected(old('gender',$teacher->gender)=='male')>Male</option>
                                <option value="female" @selected(old('gender',$teacher->gender)=='female')>Female</option>
                            </select>
                            @error('gender')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="f-group">
                            <label class="f-label">Joined Date</label>
                            <input type="date" name="joined_at" class="f-input" value="{{ old('joined_at', optional($teacher->joined_at)->format('Y-m-d')) }}">
                            @error('joined_at')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="f-group">
                            <label class="f-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="f-input">
                                <option value="active" @selected(old('status',$teacher->status ?? 'active')=='active')>Active</option>
                                <option value="inactive" @selected(old('status',$teacher->status)=='inactive')>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="f-group">
                            <label class="f-label">Photo</label>
                            <input type="file" name="photo" accept="image/*" class="f-input @error('photo') is-invalid @enderror">
                            @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            @if($teacher->photo)<img src="{{ asset($teacher->photo) }}" class="mt-2" width="70" style="border-radius:8px">@endif
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="f-group">
                            <label class="f-label">Bio</label>
                            <textarea name="bio" rows="4" class="f-input">{{ old('bio', $teacher->bio) }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update' : 'Save' }} Teacher</button>
                        <a href="{{ route('admin.teachers.index') }}" class="btn-outline-sm"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
