@extends('layouts.backend')

@section('title', 'Edit Lead Status')

@section('content')
<div class="container py-4 py-12" >
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-semibold mb-1">Edit Lead Status</h3>
            <p class="text-muted mb-0">{{ $lead->student_first_name }} {{ $lead->student_last_name }} &mdash; {{ $lead->parent_name }}</p>
        </div>
        <a href="{{ route('admin.book-lessons.index') }}" class="btn btn-outline-secondary rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="card" style="border:none;border-radius:1rem;box-shadow:0 0.25rem 1rem rgba(0,0,0,0.06);">
        <div class="card-body">
            <form action="{{ route('admin.book-lessons.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select rounded-3" required>
                        @foreach(['pending', 'contacted', 'trial_booked', 'confirmed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected($lead->status == $status)>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Contacted At</label>
                    <input type="datetime-local" name="contacted_at" class="form-control rounded-3"
                           value="{{ $lead->contacted_at ? \Carbon\Carbon::parse($lead->contacted_at)->format('Y-m-d\TH:i') : '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Admin Notes</label>
                    <textarea name="admin_notes" rows="4" class="form-control rounded-3">{{ $lead->admin_notes }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary rounded-3">
                    <i class="fa-solid fa-check me-1"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
