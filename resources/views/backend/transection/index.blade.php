@extends('layouts.backend')

@section('title', 'Transactions')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .card-header h4 { margin-bottom: 0; }
    #transactionsTable thead th { white-space: nowrap; }
    .badge { font-size: 0.8rem; padding: 0.4em 0.7em; }
</style>


@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h4><i class="bi bi-receipt me-2"></i>Transactions</h4>
            <span class="text-muted small">All payment transactions with user &amp; plan details</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="transactionsTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Invoice ID</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Populated entirely via AJAX / server-side DataTables --}}
                    </tbody>
                </table>
            </div>
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
    // Attach CSRF token to all AJAX requests (needed for POST-based DataTables
    // config, and good practice generally even though this endpoint is GET).
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#transactionsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('transactions.data') }}",
            type: 'GET'
        },
        order: [[10, 'desc']], // newest first
        columns: [
            { data: 'id', name: 'transactions.id' },
            { data: 'user_full_name', name: 'user_full_name', orderable: false },
            { data: 'user_email', name: 'users.email' },
            { data: 'plan_name', name: 'plan_name', orderable: false, searchable: false },
            { data: 'amount', name: 'transactions.amount' },
            { data: 'currency', name: 'transactions.currency' },
            { data: 'status_badge', name: 'transactions.status', orderable: false },
            { data: 'payment_method', name: 'payment_method', orderable: false, searchable: false },
            { data: 'stripe_invoice_id', name: 'transactions.stripe_invoice_id' },
            { data: 'description', name: 'transactions.description' },
            { data: 'created_at', name: 'transactions.created_at' },
        ],
        language: {
            search: "",
            searchPlaceholder: "Search transactions...",
            processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...'
        },
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100]
    });
});
</script>
@endsection