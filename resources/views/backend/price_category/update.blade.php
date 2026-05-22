@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1>Edit Price Category</h1>
            <p>Update  price category details</p>
        </div>
        <a href="{{ route('admin.fees-category.index') }}" class="btn-outline-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header-custom">
                    <div class="card-title">
                        <i class="fas fa-folder-open"></i> Edit Price Category — <span class="text-muted fw-normal">{{ $category->category_name }}</span>
                    </div>
                </div>
                <div class="card-body-custom">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-3">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.fees-category.update', $category->id) }}" method="POST">
                        @csrf
                      
                        <div class="row g-3">

                            {{-- Category Name --}}
                            <div class="col-md-8">
                                <div class="f-group">
                                    <label class="f-label">
                                        Category Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           name="category_name"
                                           id="category_name"
                                           class="f-input @error('category_name') is-invalid @enderror"
                                           value="{{ old('category_name', $category->category_name) }}"
                                           placeholder="e.g. Technology">
                                    @error('category_name')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Slug preview (read-only) --}}
                            <div class="col-md-8">
                                <div class="f-group">
                                    <label class="f-label">Slug Preview</label>
                                    <input type="text"
                                           id="slug_preview"
                                           class="f-input"
                                           value="{{ $category->slug }}"
                                           readonly
                                           style="opacity:.6;cursor:not-allowed">
                                    <small class="text-muted" style="font-size:.72rem">
                                        Auto-generated from category name
                                    </small>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-md-8">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn-gold-sm">
                                        <i class="fas fa-save"></i> Update Price Category
                                    </button>
                                    <a href="{{ route('admin.fees-category.index') }}" class="btn-outline-sm">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Info sidebar --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-info-circle"></i> Category Info</div>
                </div>
                <div class="card-body-custom">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <div class="f-label mb-1">Current Slug</div>
                            <code style="font-size:.8rem;color:var(--teal)">{{ $category->slug }}</code>
                        </div>
                        <div>
                            <div class="f-label mb-1">Created At</div>
                            <span style="font-size:.82rem">{{ $category->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        {{-- <div>
                            <div class="f-label mb-1">Last Updated</div>
                            <span style="font-size:.82rem">{{ $category->updated_at->format('d M Y, h:i A') ?? ''}}</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Live slug preview --}}
<script>
document.getElementById('category_name').addEventListener('input', function () {
    const slug = this.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('slug_preview').value = slug;
});
</script>

@endsection