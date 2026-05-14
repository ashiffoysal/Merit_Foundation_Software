@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1>Blog Categories</h1>
            <p>All categories listed below</p>
        </div>
        <a href="{{ route('admin.category.create') }}" class="btn-gold-sm">
            <i class="fas fa-plus"></i> New Category
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $category->category_name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ $category->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.category.edit', $category->id) }}"
                                       class="btn-outline-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.category.destroy', $category->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No categories found. <a href="{{ route('admin.category.create') }}">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($categories->hasPages())
            <div class="p-3">{{ $categories->links() }}</div>
        @endif
    </div>
</div>

@endsection