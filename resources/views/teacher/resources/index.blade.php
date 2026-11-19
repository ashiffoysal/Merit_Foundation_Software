@extends('teacher.layout')
@section('title', 'Resources')
@section('content')
<div class="page-header"><h1>Learning Resources</h1>
    <p class="mb-0">Materials for your levels ({{ $levels->pluck('name')->implode(', ') ?: 'none' }}) and subjects ({{ $subjects->pluck('name')->implode(', ') ?: 'none' }}).</p></div>

@if($levels->isEmpty() || $subjects->isEmpty())
    <div class="alert alert-warning"><i class="fas fa-info-circle me-1"></i> You don't have any {{ $levels->isEmpty() ? 'levels' : 'subjects' }} assigned yet, so no resources can be shown. Please ask the office to update your profile.</div>
@endif

<div class="card mb-3">
    <form class="ac-filters" method="GET">
        <div class="row g-2">
            <div class="col-md-4"><input type="search" name="search" value="{{ request('search') }}" class="f-input" placeholder="Search title or topic…"></div>
            <div class="col-md-2 col-6"><select name="level_id" class="f-input" onchange="this.form.submit()"><option value="">All my levels</option>@foreach($levels as $l)<option value="{{ $l->id }}" @selected(request('level_id') == $l->id)>{{ $l->name }}</option>@endforeach</select></div>
            <div class="col-md-2 col-6"><select name="subject_id" class="f-input" onchange="this.form.submit()"><option value="">All my subjects</option>@foreach($subjects as $s)<option value="{{ $s->id }}" @selected(request('subject_id') == $s->id)>{{ $s->name }}</option>@endforeach</select></div>
            <div class="col-md-2 col-6"><select name="category_id" class="f-input" onchange="this.form.submit()"><option value="">All categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-2 col-6 d-flex gap-2"><button class="btn-gold-sm"><i class="fas fa-search"></i></button><a href="{{ route('teacher.resources.index') }}" class="btn-outline-sm"><i class="fas fa-undo"></i></a></div>
        </div>
    </form>
</div>

<div class="row g-3">
    @forelse($resources as $r)
        <div class="col-xl-4 col-md-6">
            <div class="card h-100 p-3 d-flex flex-column">
                <div class="d-flex gap-3 align-items-start mb-2">
                    <i class="fas {{ $r->icon }} fa-2x"></i>
                    <div class="flex-grow-1">
                        <strong>{{ $r->title }}</strong>
                        <div class="ac-muted">{{ $r->category->name ?? '' }}{{ $r->topic ? ' · ' . $r->topic : '' }}</div>
                    </div>
                </div>
                @if($r->description)<p class="small mb-2" style="color:var(--muted)">{{ \Illuminate\Support\Str::limit($r->description, 140) }}</p>@endif
                <div class="mb-3">
                    @foreach($r->levels as $l)<span class="badge bg-light text-dark border me-1">{{ $l->name }}</span>@endforeach
                    @foreach($r->subjects as $s)<span class="badge bg-light text-dark border me-1">{{ $s->name }}</span>@endforeach
                </div>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <span class="ac-muted"></span>
                    <div class="d-flex gap-2">
                        @if($r->isPreviewable())<a href="{{ route('teacher.resources.download', $r) }}?inline=1" target="_blank" rel="noopener" class="btn-outline-sm" title="Open"><i class="fas fa-eye"></i></a>@endif
                        <a href="{{ route('teacher.resources.download', $r) }}" class="btn-gold-sm"><i class="fas fa-download"></i> Download</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="card p-5 text-center ac-muted">No resources available for your levels and subjects yet.</div></div>
    @endforelse
</div>
@if($resources->hasPages())<div class="mt-3">{{ $resources->links('pagination::bootstrap-5') }}</div>@endif
@endsection
