@extends('layouts.backend')

@section('title', 'Subscriptions')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .card-header h4 { margin-bottom: 0; }
    #subscriptionsTable thead th { white-space: nowrap; }
    .badge { font-size: 0.8rem; padding: 0.4em 0.7em; }
</style>


@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4><i class="bi bi-arrow-repeat me-2"></i>Subscriptions</h4>
            <span class="text-muted small">All user subscriptions and their Stripe status</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="subscriptionsTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Stripe Subscription ID</th>
                            <th>Status</th>
                            <th>Trial Ends</th>
                            <th>End Date</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Populated entirely via AJAX / server-side DataTables --}}
                    </tbody>
                </table>
            </div>
            <p class="text-muted small mt-2 mb-0">
                * The schema doesn't store a separate "next billing date" — the <code>ends_at</code> column
                is shown as the End Date and doubles as the implied renewal/expiry reference for active subscriptions.
            </p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#subscriptionsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('subscriptions.data') }}",
            type: 'GET'
        },
        order: [[8, 'desc']], // newest first
        columns: [
            { data: 'id', name: 'subscriptions.id' },
            { data: 'user_full_name', name: 'user_full_name', orderable: false },
            { data: 'user_email', name: 'users.email' },
            { data: 'plan_name', name: 'plan_name', orderable: false, searchable: false },
            { data: 'stripe_id', name: 'subscriptions.stripe_id' },
            { data: 'status_badge', name: 'subscriptions.stripe_status', orderable: false },
            { data: 'trial_ends_at', name: 'subscriptions.trial_ends_at' },
            { data: 'ends_at', name: 'subscriptions.ends_at' },
            { data: 'created_at', name: 'subscriptions.created_at' },
        ],
        language: {
            search: "",
            searchPlaceholder: "Search subscriptions...",
            processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...'
        },
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100]
    });
});
</script>

@endsection