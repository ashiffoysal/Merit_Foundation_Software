@extends('layouts.backend')
@section('Title', 'Lead Details')
@section('content')
<style>
    .card-soft {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.06);
    }
    .info-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.15rem;
    }
    .info-value {
        font-weight: 500;
        font-size: 0.98rem;
    }
    .section-title {
        font-weight: 600;
        border-bottom: 2px solid #f1f1f4;
        padding-bottom: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .badge-pink {
        background-color: #e83e8c;
        color: #fff;
    }
</style>



<div class="container py-4" style="max-width: 1200px; margin-top: 100px;">
    {{-- Flash Messages --}}


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-semibold mb-1">Lead Details</h3>
            <p class="text-muted mb-0">Full enquiry information for {{ $lead->parent_name }}.</p>
        </div>
        <a href="{{ route('admin.book-lessons.index') }}" class="btn btn-outline-secondary rounded-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row g-4">
        {{-- Student Information --}}
        <div class="col-md-6">
            <div class="card card-soft h-100">
                <div class="card-body">
                    <h5 class="section-title"><i class="fa-solid fa-user-graduate me-2 text-primary"></i>Student Information</h5>

                    <div class="mb-3">
                        <div class="info-label">Student Name</div>
                        <div class="info-value">{{ $lead->student_first_name }} {{ $lead->student_last_name }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Current Level</div>
                        <div class="info-value">{{ $lead->current_level ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Package</div>
                        <div class="info-value">{{ $lead->package_id ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Preferred Tutor</div>
                        <div class="info-value">
                            @if($lead->preferred_tutor == 'Male Tutor')
                                <span class="badge bg-primary rounded-pill">Male Tutor</span>
                            @elseif($lead->preferred_tutor == 'Female Tutor')
                                <span class="badge badge-pink rounded-pill">Female Tutor</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Not Specified</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-0">
                        <div class="info-label">Preferred Time</div>
                        <div class="info-value">{{ $lead->preferred_time ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Parent Information --}}
        <div class="col-md-6">
            <div class="card card-soft h-100">
                <div class="card-body">
                    <h5 class="section-title"><i class="fa-solid fa-people-roof me-2 text-primary"></i>Parent Information</h5>

                    <div class="mb-3">
                        <div class="info-label">Parent Name</div>
                        <div class="info-value">{{ $lead->parent_name }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $lead->phone }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Emergency Phone</div>
                        <div class="info-value">{{ $lead->emergency_phone ?? '-' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $lead->email }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $lead->address ?? '-' }}</div>
                    </div>

                    <div class="mb-0">
                        <div class="info-label">Post Code</div>
                        <div class="info-value">{{ $lead->post_code ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Other Information --}}
        <div class="col-12">
            <div class="card card-soft">
                <div class="card-body">
                    <h5 class="section-title"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Other Information</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-label">Notes</div>
                            <div class="info-value">{{ $lead->notes ?? '-' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-label">Admin Notes</div>
                            <div class="info-value">{{ $lead->admin_notes ?? '-' }}</div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="info-label">Donation Interest</div>
                            <div class="info-value">
                                @if($lead->donation_interest)
                                    <span class="badge bg-success rounded-pill">Yes</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">No</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                @switch($lead->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                        @break
                                    @case('contacted')
                                        <span class="badge bg-info text-dark rounded-pill">Contacted</span>
                                        @break
                                    @case('trial_booked')
                                        <span class="badge bg-primary rounded-pill">Trial Booked</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-success rounded-pill">Confirmed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger rounded-pill">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary rounded-pill">{{ ucfirst($lead->status) }}</span>
                                @endswitch
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="info-label">Contacted At</div>
                            <div class="info-value">
                                {{ $lead->contacted_at ? \Carbon\Carbon::parse($lead->contacted_at)->format('d M Y, h:i A') : '-' }}
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="info-label">Created At</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y, h:i A') }}</div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="info-label">Updated At</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($lead->updated_at)->format('d M Y, h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
