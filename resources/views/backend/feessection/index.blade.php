@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1>Price Plans</h1>
            <p>All plans listed below</p>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="btn-gold-sm">
            <i class="fas fa-plus"></i> New Price Plan
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
                        <th>Plan Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $plan->name }}</strong></td>
                            <td>{{ $plan->category->category_name ?? 'N/A' }}</td>
                            <td>{{ $plan->monthly_price }}</td>
                            <td>{{ $plan->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}"
                                       class="btn-outline-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.plans.destroy', $plan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this plan?')">
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
                                No price plans found. <a href="{{ route('admin.fees-plan.create') }}">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
    
           
      
    </div>
</div>

@endsection