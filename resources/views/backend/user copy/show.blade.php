@extends('layouts.backend')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">User Details</h2>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">&larr; Back to list</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <div class="col-auto">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle"
                             width="80" height="80" style="object-fit: cover;" alt="Avatar">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="width: 80px; height: 80px; font-size: 28px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h4 class="mb-0">{{ $user->name }} {{ $user->last_name }}</h4>
                    <div class="text-muted">{{ $user->email }}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Account Info</h5>
                    <table class="table table-sm">
                        <tr><th>ID</th><td>{{ $user->id }}</td></tr>
                        <tr><th>Phone</th><td>{{ $user->phone ?? '—' }}</td></tr>
                        <tr><th>Email Verified</th><td>{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'No' }}</td></tr>
                        <tr><th>Active</th><td>{{ $user->is_active ? 'Yes' : 'No' }}</td></tr>
                        <tr><th>Verified (KYC)</th><td>{{ $user->is_verified ? 'Yes' : 'No' }}</td></tr>
                        <tr><th>Google ID</th><td>{{ $user->google_id ?? '—' }}</td></tr>
                        <tr><th>Joined</th><td>{{ optional($user->created_at)->format('d M Y H:i') }}</td></tr>
                        <tr><th>Last Updated</th><td>{{ optional($user->updated_at)->format('d M Y H:i') }}</td></tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Address</h5>
                    <table class="table table-sm">
                        <tr><th>Address Line 1</th><td>{{ $user->address_line_1 ?? '—' }}</td></tr>
                        <tr><th>Address Line 2</th><td>{{ $user->address_line_2 ?? '—' }}</td></tr>
                        <tr><th>City</th><td>{{ $user->city ?? '—' }}</td></tr>
                        <tr><th>Postcode</th><td>{{ $user->postcode ?? '—' }}</td></tr>
                        <tr><th>Country</th><td>{{ $user->country ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Student / Learning Info</h5>
                    <table class="table table-sm">
                        <tr><th>Student Name</th><td>{{ $user->student_name ?? '—' }}</td></tr>
                        <tr><th>Age</th><td>{{ $user->age ?? '—' }}</td></tr>
                        <tr><th>Date of Birth</th><td>{{ $user->date_of_birth ?? '—' }}</td></tr>
                        <tr><th>Gender</th><td>{{ $user->gender ?? '—' }}</td></tr>
                        <tr><th>Quran Level</th><td>{{ $user->quran_level ?? '—' }}</td></tr>
                        <tr><th>Learning Goals</th><td>{{ $user->learning_goals ?? '—' }}</td></tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3">Billing</h5>
                    <table class="table table-sm">
                        <tr><th>Stripe ID</th><td>{{ $user->stripe_id ?? '—' }}</td></tr>
                        <tr><th>Payment Type</th><td>{{ $user->pm_type ?? '—' }}</td></tr>
                        <tr><th>Card Last 4</th><td>{{ $user->pm_last_four ?? '—' }}</td></tr>
                        <tr><th>Trial Ends At</th><td>{{ $user->trial_ends_at ?? '—' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                      onsubmit="return confirm('Delete this user? This will soft-delete them.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection