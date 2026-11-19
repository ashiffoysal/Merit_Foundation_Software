@extends('backend.academic.layout')
@section('page')
@php $editing = $resource->exists; @endphp
@include('backend.academic.partials.page-header', [
    'title' => $editing ? 'Edit Resource' : 'Upload Resource',
    'subtitle' => $editing ? $resource->title : 'Choose who can see it with Levels and Subjects',
    'actions' => '<a href="' . route('admin.resources.index') . '" class="btn-outline-sm"><i class="fas fa-arrow-left"></i> Back</a>',
])
<div class="row g-4">
    <div class="{{ $editing ? 'col-lg-8' : 'col-lg-9' }}">
        <form method="POST" action="{{ $editing ? route('admin.resources.update', $resource) : route('admin.resources.store') }}" enctype="multipart/form-data" data-ajax-form novalidate>
            @csrf
            @if($editing) @method('PUT') @endif
            <div class="card">
                <div class="card-body-custom pt-4">
                    <div class="row g-3">
                        <x-academic.input name="title" label="Title" :value="$resource->title" required col="col-12" maxlength="200" />
                        <x-academic.textarea name="description" label="Description" :value="$resource->description" rows="3" />
                        <x-academic.select name="level_ids" label="Levels *" multiple placeholder="Choose one or more levels…" :options="$levels->pluck('name', 'id')" :value="$resource->levels->pluck('id')->all()" />
                        <x-academic.select name="subject_ids" label="Subjects *" multiple placeholder="Choose one or more subjects…" :options="$subjects->pluck('name', 'id')" :value="$resource->subjects->pluck('id')->all()" />
                        <x-academic.select name="resource_category_id" label="Category" :options="$categories->pluck('name', 'id')" :value="$resource->resource_category_id" help="Manage categories in Settings → Resource Categories" />
                        <x-academic.input name="topic" label="Topic / Unit" :value="$resource->topic" placeholder="e.g. Fractions, Unit 3" />
                        <x-academic.file name="file" :label="$editing ? 'Replace file (optional)' : 'File *'" col="col-md-8"
                            :accept="'.' . implode(',.', \App\Models\LearningResource::EXTENSIONS)"
                            :help="'PDF, Word, PowerPoint, Excel, text, images, audio/video — max ' . (\App\Models\LearningResource::MAX_KB / 1024) . ' MB'">
                            @if($editing)
                                <div class="mt-2 small"><i class="fas {{ $resource->icon }} me-1"></i> Current: <a href="{{ route('admin.resources.download', $resource) }}">{{ $resource->original_name }}</a> ({{ \App\Support\FileSize::human($resource->size) }})</div>
                            @endif
                        </x-academic.file>
                        <x-academic.switch name="is_active" label="Visible to teachers" :checked="$resource->is_active" col="col-md-4 align-self-center" />
                    </div>
                </div>
                <div class="ac-sticky-actions">
                    <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> {{ $editing ? 'Update Resource' : 'Upload Resource' }}</button>
                    <a href="{{ route('admin.resources.index') }}" class="btn-outline-sm">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    @if($editing)
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-eye"></i> Teachers who can see this</div><span class="badge bg-primary">{{ $teachers->count() }}</span></div>
            <div class="card-body-custom" style="max-height:300px;overflow:auto">
                @if(! $resource->is_active)<p class="text-danger small">Hidden — no teacher can see it right now.</p>@endif
                @forelse($teachers as $t)
                    <div class="small mb-1"><a href="{{ route('admin.teachers.show', $t) }}">{{ $t->full_name }}</a></div>
                @empty
                    <p class="ac-muted small mb-0">No active teacher has a matching level <b>and</b> subject. Assign levels/subjects on the teacher profile.</p>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="card-header-custom"><div class="card-title"><i class="fas fa-download"></i> Recent downloads</div><span class="ac-muted">{{ $resource->download_count }} by teachers</span></div>
            <div class="card-body-custom">
                @forelse($downloads as $d)
                    <div class="small mb-1">{{ $d->teacher->full_name ?? 'Admin' }} <span class="ac-muted">· {{ $d->downloaded_at->format('d M Y H:i') }}</span></div>
                @empty
                    <p class="ac-muted small mb-0">Not downloaded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
    @else
    <div class="col-lg-3">
        <div class="card p-3 small">
            <strong class="mb-2 d-block"><i class="fas fa-info-circle text-primary me-1"></i> Who will see it?</strong>
            A teacher sees a resource when one of its <b>levels</b> is in the teacher's levels <b>and</b> one of its <b>subjects</b> is in the teacher's subjects.
            <hr>Example: a resource for <i>KS2 + Maths</i> is shown to a teacher assigned KS2 and Maths — not to a GCSE English teacher.
        </div>
    </div>
    @endif
</div>
@endsection
