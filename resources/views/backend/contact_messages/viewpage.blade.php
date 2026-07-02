@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-start justify-content-between">
        <div>
            <h1>Contact Message #{{ $message->id }}</h1>
            <p>Submitted on {{ optional($message->created_at)->format('d M Y, h:i A') ?? '—' }}</p>
        </div>
        <div>
            <a href="{{ route('contact-messages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Messages
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Main message details --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header-custom">
                    <div class="card-title">
                        <i class="fas fa-envelope-open-text"></i> Message Details
                    </div>
                </div>
                <div class="card-body-custom">

                    <table class="table table-borderless mb-4">
                        <tr>
                            <th style="width:180px;">Full Name</th>
                            <td>{{ trim(($message->first_name ?? '').' '.($message->last_name ?? '')) ?: '—' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                @if($message->email)
                                    <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>
                                @if($message->phone)
                                    <a href="tel:{{ $message->phone }}">{{ $message->phone }}</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Enquiry Type</th>
                            <td>
                                @if($message->enquiry_type)
                                    <span class="badge bg-info text-dark">{{ $message->enquiry_type }}</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td>{{ $message->is_ip ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $message->status == 'new' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ ucfirst($message->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <h6 class="text-muted mb-2">Message</h6>
                    <div class="p-3" style="background:var(--bg-light,#f8f9fa); border-radius:6px; white-space:pre-wrap;">
                        {{ $message->message ?? 'No message content.' }}
                    </div>
                </div>
            </div>

            {{-- Internal notes --}}
            <div class="card mt-3">
                <div class="card-header-custom">
                    <div class="card-title">
                        <i class="fas fa-sticky-note"></i> Internal Notes
                    </div>
                </div>
                <div class="card-body-custom">
                    <form method="POST" action="{{ route('backend.contact_messages.notes', $message->id) }}">
                        @csrf
                        <textarea name="notes" rows="4" class="form-control mb-2" placeholder="Add internal notes...">{{ old('notes', $message->notes) }}</textarea>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Save Notes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar: status & actions --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-info-circle"></i> Status</div>
                </div>
                <div class="card-body-custom">
                    <p class="mb-2">
                        <strong>Read:</strong>
                        @if($message->is_read)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-warning text-dark">No</span>
                        @endif
                    </p>
                    <p class="mb-2">
                        <strong>Spam:</strong>
                        @if($message->is_spam)
                            <span class="badge bg-danger">Yes</span>
                        @else
                            <span class="badge bg-success">No</span>
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong>Seen By:</strong> {{ $message->seen_by ?? '—' }}
                    </p>
                    <hr>
                    <p class="mb-0" style="font-size:.8rem;color:var(--muted)">
                        Last updated: {{ optional($message->updated_at)->diffForHumans() ?? '—' }}
                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-bolt"></i> Actions</div>
                </div>
                <div class="card-body-custom d-flex flex-column gap-2">

                    {{-- <form method="POST" action="{{ route('backend.contact_messages.toggleRead', $message->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-primary w-100 btn-sm">
                            <i class="fas fa-envelope"></i>
                            {{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}
                        </button>
                    </form> --}}

                    {{-- <form method="POST" action="{{ route('backend.contact_messages.toggleSpam', $message->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-warning w-100 btn-sm">
                            <i class="fas fa-ban"></i>
                            {{ $message->is_spam ? 'Unmark Spam' : 'Mark as Spam' }}
                        </button>
                    </form> --}}

                    <form method="POST" action=""
                          onsubmit="return confirm('Delete this message permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                            <i class="fas fa-trash"></i> Delete Message
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection