@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">User Subscriptions</h2>
   
{{-- ── Page Header ──────────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url('admin/users') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="mb-0 fw-bold text-dark">Subscriptions</h4>
            <small class="text-muted">
                {{ $user->name }} {{ $user->last_name }} &mdash; {{ $user->email }}
            </small>
        </div>
    </div>
    {{-- Stripe customer link --}}
    @if($user->stripe_id)
        <a href="https://dashboard.stripe.com/customers/{{ $user->stripe_id }}"
           target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-stripe me-1"></i>View in Stripe
        </a>
    @endif
</div>

{{-- ── Flash messages ───────────────────────────────────────────────────────── --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ── User Summary Card ────────────────────────────────────────────────────── --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="row g-3 align-items-center">

            {{-- Avatar + name --}}
            <div class="col-12 col-md-4 d-flex align-items-center gap-3">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}"
                         class="rounded-circle" style="width:52px;height:52px;object-fit:cover" alt="">
                @else
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;font-size:1.2rem;font-weight:700;color:#3d5afe;flex-shrink:0">
                        {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '?', 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="fw-semibold">{{ $user->name }} {{ $user->last_name }}</div>
                    <div class="text-muted small">{{ $user->email }}</div>
                </div>
            </div>

            {{-- Stripe ID --}}
            <div class="col-6 col-md-2">
                <div class="sub-label">Stripe ID</div>
                @if($user->stripe_id)
                    <code class="small text-primary">{{ Str::limit($user->stripe_id, 20) }}</code>
                @else
                    <span class="text-muted small">—</span>
                @endif
            </div>

            {{-- Payment method --}}
            <div class="col-6 col-md-2">
                <div class="sub-label">Payment Method</div>
                @if($user->pm_type)
                    <span class="card-brand">
                        @if(strtolower($user->pm_type) === 'visa')
                            <i class="bi bi-credit-card-fill text-primary me-1"></i>
                        @elseif(strtolower($user->pm_type) === 'mastercard')
                            <i class="bi bi-credit-card-2-front-fill text-warning me-1"></i>
                        @else
                            <i class="bi bi-credit-card me-1"></i>
                        @endif
                        {{ ucfirst($user->pm_type) }}
                        @if($user->pm_last_four)
                            •••• {{ $user->pm_last_four }}
                        @endif
                    </span>
                @else
                    <span class="text-muted small">No card on file</span>
                @endif
            </div>

            {{-- Total subs --}}
            <div class="col-6 col-md-2 text-center">
                <div class="sub-label">Total Subscriptions</div>
                <div class="fs-4 fw-bold text-dark">{{ $subscriptions->count() }}</div>
            </div>

            {{-- Active subs --}}
            <div class="col-6 col-md-2 text-center">
                <div class="sub-label">Active Now</div>
                <div class="fs-4 fw-bold text-success">
                    {{ $subscriptions->where('stripe_status', 'active')->count() }}
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Subscriptions ─────────────────────────────────────────────────────────── --}}
@forelse ($subscriptions as $sub)

@php
    $status   = $sub->stripe_status ?? 'unknown';
    $isActive = $status === 'active';
    $isPaused = $status === 'paused';
    $isCancelled = in_array($status, ['canceled', 'cancelled']);
    $onGrace  = $sub->ends_at && $sub->ends_at->isFuture() && $isCancelled;
@endphp

<div class="card border-0 shadow-sm mb-3 sub-card sub-card--{{ $isPaused ? 'paused' : ($isCancelled && !$onGrace ? 'cancelled' : ($onGrace ? 'grace' : 'active')) }}">

    {{-- Card top stripe (colour coded) --}}
    <div class="sub-card__stripe"></div>

    <div class="card-body p-4">
        <div class="row g-3 align-items-start">

            {{-- ── Left: plan + status ──────────────────────────────────────── --}}
            <div class="col-12 col-md-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="sub-type-badge">{{ strtoupper($sub->type ?? 'DEFAULT') }}</span>
                    @if($onGrace)
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-hourglass-split me-1"></i>Grace Period
                        </span>
                    @elseif($isPaused)
                        <span class="badge bg-secondary">
                            <i class="bi bi-pause-fill me-1"></i>Paused
                        </span>
                    @elseif($isActive)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>Active
                        </span>
                    @elseif($isCancelled)
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle-fill me-1"></i>Cancelled
                        </span>
                    @else
                        <span class="badge bg-light text-dark">{{ ucfirst($status) }}</span>
                    @endif
                </div>

                <div class="sub-label mt-2">Stripe Price ID</div>
                <code class="small text-muted">{{ $sub->stripe_price ?? '—' }}</code>

                <div class="sub-label mt-2">Stripe Subscription ID</div>
                <code class="small text-muted">{{ Str::limit($sub->stripe_id ?? '—', 30) }}</code>
            </div>

            {{-- ── Middle: dates ───────────────────────────────────────────── --}}
            <div class="col-6 col-md-2">
                <div class="sub-label">Started</div>
                <div class="sub-value">
                    {{ $sub->created_at?->format('d M Y') ?? '—' }}
                </div>

                <div class="sub-label mt-2">Quantity</div>
                <div class="sub-value">{{ $sub->quantity ?? 1 }}</div>
            </div>

            <div class="col-6 col-md-2">
                <div class="sub-label">
                    @if($onGrace) Cancels On
                    @elseif($isCancelled) Ended On
                    @else Renews / Ends
                    @endif
                </div>
                <div class="sub-value {{ $onGrace ? 'text-warning fw-semibold' : '' }}">
                    {{ $sub->ends_at?->format('d M Y') ?? 'Ongoing' }}
                </div>

                @if($sub->trial_ends_at)
                <div class="sub-label mt-2">Trial Ends</div>
                <div class="sub-value text-info">
                    {{ $sub->trial_ends_at->format('d M Y') }}
                </div>
                @endif
            </div>

            {{-- ── Subscription items ───────────────────────────────────────── --}}
            <div class="col-12 col-md-2">
                <div class="sub-label mb-1">Plan Items</div>
                @forelse($sub->items ?? [] as $item)
                    <div class="item-chip mb-1">
                        <div style="font-size:.7rem;color:#6c757d">{{ $item->stripe_price }}</div>
                        <div style="font-size:.75rem">Qty: {{ $item->quantity }}</div>
                    </div>
                @empty
                    <span class="text-muted small">No items</span>
                @endforelse
            </div>

            {{-- ── Actions ──────────────────────────────────────────────────── --}}
            <div class="col-12 col-md-2">
                <div class="sub-label mb-2">Actions</div>
                <div class="d-grid gap-2">

                    @if($isPaused)
                        {{-- Resume from paused --}}
                        <form method="POST"
                              action="{{ route('admin.subscriptions.resume', $sub->id) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success w-100"
                                    onclick="return confirm('Resume this subscription?')">
                                <i class="bi bi-play-fill me-1"></i>Resume
                            </button>
                        </form>

                    @elseif($isActive && !$onGrace)
                        {{-- Pause --}}
                        <form method="POST"
                              action="{{ route('admin.subscriptions.pause', $sub->id) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-warning w-100"
                                    onclick="return confirm('Pause this subscription?')">
                                <i class="bi bi-pause-fill me-1"></i>Pause
                            </button>
                        </form>

                        {{-- Cancel at period end --}}
                        <form method="POST"
                              action="{{ route('admin.subscriptions.cancel', $sub->id) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-secondary w-100"
                                    onclick="return confirm('Cancel at period end?')">
                                <i class="bi bi-calendar-x me-1"></i>Cancel
                            </button>
                        </form>

                        {{-- Cancel immediately --}}
                        <form method="POST"
                              action="{{ route('admin.subscriptions.cancelNow', $sub->id) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-danger w-100"
                                    onclick="return confirm('Cancel IMMEDIATELY? This cannot be undone!')">
                                <i class="bi bi-x-circle me-1"></i>Cancel Now
                            </button>
                        </form>

                    @elseif($onGrace)
                        {{-- Undo cancel (resume during grace period) --}}
                        <form method="POST"
                              action="{{ route('admin.subscriptions.resume', $sub->id) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-success w-100"
                                    onclick="return confirm('Reactivate subscription?')">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Undo Cancel
                            </button>
                        </form>

                    @else
                        <span class="text-muted small">No actions available</span>
                    @endif

                    {{-- Always: Stripe dashboard link --}}
                    @if($sub->stripe_id)
                        <a href="https://dashboard.stripe.com/subscriptions/{{ $sub->stripe_id }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Stripe
                        </a>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@empty

{{-- ── Empty state ──────────────────────────────────────────────────────────── --}}
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-credit-card text-muted" style="font-size:3rem"></i>
        <h5 class="mt-3 text-muted">No subscriptions found</h5>
        <p class="text-muted small">This user has not subscribed to any plan yet.</p>
        <a href="{{ url('admin/users') }}" class="btn btn-outline-secondary btn-sm mt-2">
            <i class="bi bi-arrow-left me-1"></i>Back to Users
        </a>
    </div>
</div>

@endforelse


{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- STYLES                                                                     --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<style>
    /* Labels */
    .sub-label {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #adb5bd;
        margin-bottom: 2px;
    }
    .sub-value {
        font-size: .88rem;
        color: #212529;
    }

    /* Subscription card colour stripe on left */
    .sub-card { border-left: 4px solid #dee2e6 !important; overflow: hidden; }
    .sub-card__stripe { display: none; }

    .sub-card--active   { border-left-color: #198754 !important; }
    .sub-card--paused   { border-left-color: #6c757d !important; }
    .sub-card--grace    { border-left-color: #ffc107 !important; }
    .sub-card--cancelled { border-left-color: #dc3545 !important; }

    /* Plan type badge */
    .sub-type-badge {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .08em;
        background: #f0f4ff;
        color: #3d5afe;
        border-radius: 4px;
        padding: 2px 8px;
    }

    /* Item chip */
    .item-chip {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 4px 8px;
        border: 1px solid #e9ecef;
        font-family: monospace;
    }

    /* Card brand */
    .card-brand {
        font-size: .85rem;
        font-weight: 500;
    }

    /* User summary labels */
    .sub-label { margin-bottom: 2px; }
</style>
     </div>
    </div>
</div>
@endsection