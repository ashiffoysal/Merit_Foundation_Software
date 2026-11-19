@extends('layouts.backend')
@section('content')
@php
    $editing = $lesson->exists;
    $topicRows = old('topics', $editing ? $lesson->topics->map->only(['id','title','description'])->values()->all() : [['id'=>null,'title'=>'','description'=>'']]);
@endphp
<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div><h1>{{ $editing ? 'Edit Lesson' : 'Create Lesson' }}</h1><p>Add the lesson and its topics</p></div>
        <a href="{{ route('admin.lessons.index') }}" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    @include('backend.include.flash')

    <form action="{{ $editing ? route('admin.lessons.update', $lesson) : route('admin.lessons.store') }}" method="POST">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-book-open"></i> Lesson</div></div>
            <div class="card-body-custom">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="f-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="f-input @error('title') is-invalid @enderror" value="{{ old('title', $lesson->title) }}" placeholder="e.g. Qaida Lesson 3 – Joined Letters">
                        @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Level</label>
                        <select name="level" class="f-input">
                            <option value="">—</option>
                            @foreach($levels as $lv)<option value="{{ $lv }}" @selected(old('level',$lesson->level)==$lv)>{{ $lv }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Sort Order</label>
                        <input type="number" min="0" name="sort_order" class="f-input" value="{{ old('sort_order', $lesson->sort_order ?? 0) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="f-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="f-input">
                            <option value="active" @selected(old('status',$lesson->status)=='active')>Active</option>
                            <option value="inactive" @selected(old('status',$lesson->status)=='inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="f-label">Description</label>
                        <textarea name="description" rows="3" class="f-input">{{ old('description', $lesson->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div class="card-title"><i class="fas fa-list-ol"></i> Topics</div>
                <button type="button" class="btn-outline-sm" id="addTopic"><i class="fas fa-plus"></i> Add Topic</button>
            </div>
            <div class="card-body-custom">
                <div id="topicRows">
                    @foreach($topicRows as $i => $t)
                        <div class="row g-2 mb-2 topic-row">
                            <input type="hidden" name="topics[{{ $i }}][id]" value="{{ $t['id'] ?? '' }}">
                            <div class="col-md-5"><input type="text" name="topics[{{ $i }}][title]" class="f-input" value="{{ $t['title'] ?? '' }}" placeholder="Topic title"></div>
                            <div class="col-md-6"><input type="text" name="topics[{{ $i }}][description]" class="f-input" value="{{ $t['description'] ?? '' }}" placeholder="Short description (optional)"></div>
                            <div class="col-md-1"><button type="button" class="btn-danger-sm remove-topic"><i class="fas fa-times"></i></button></div>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Topics are saved in this order. Removing a row deletes that topic when you save.</small>
            </div>
        </div>

        <div class="d-flex gap-2 mb-5">
            <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update' : 'Save' }} Lesson</button>
            <a href="{{ route('admin.lessons.index') }}" class="btn-outline-sm"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    const wrap = document.getElementById('topicRows');
    let idx = {{ count($topicRows) }};
    document.getElementById('addTopic').addEventListener('click', function () {
        wrap.insertAdjacentHTML('beforeend', `
            <div class="row g-2 mb-2 topic-row">
                <input type="hidden" name="topics[${idx}][id]" value="">
                <div class="col-md-5"><input type="text" name="topics[${idx}][title]" class="f-input" placeholder="Topic title"></div>
                <div class="col-md-6"><input type="text" name="topics[${idx}][description]" class="f-input" placeholder="Short description (optional)"></div>
                <div class="col-md-1"><button type="button" class="btn-danger-sm remove-topic"><i class="fas fa-times"></i></button></div>
            </div>`);
        idx++;
    });
    wrap.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-topic');
        if (btn) btn.closest('.topic-row').remove();
    });
})();
</script>
@endsection
