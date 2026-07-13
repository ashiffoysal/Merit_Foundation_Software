@extends('layouts.backend')

@section('title', 'All Book Lesson Leads')


<style>
    .badge-pink {
        background-color: #e83e8c;
        color: #fff;
    }
    .card-soft {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.06);
    }
    .page-header-title {
        font-weight: 600;
    }
    .page-header-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
    }
    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
    }
    table.dataTable thead th {
        white-space: nowrap;
    }
</style>


@section('content')
<div class="container py-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-header-title mb-1">All Book Lesson Leads</h3>
            <p class="page-header-subtitle mb-0">Manage all lesson enquiries from parents.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.book-lessons.export') }}" class="btn btn-success rounded-3 shadow-sm">
                <i class="fa-solid fa-file-csv me-1"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="card card-soft">
        <div class="card-body">
            <div class="table-responsive">
                <table id="bookLessonsTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Parent Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Current Level</th>
                            <th>Preferred Tutor</th>
                            <th>Preferred Time</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allleads as $lead)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $lead->student_first_name }} {{ $lead->student_last_name }}
                                    </span>
                                </td>
                                <td>{{ $lead->parent_name }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>{{ $lead->current_level ?? '-' }}</td>
                                <td>
                                    @if($lead->preferred_tutor == 'Male Tutor')
                                        <span class="badge bg-primary rounded-pill">Male Tutor</span>
                                    @elseif($lead->preferred_tutor == 'Female Tutor')
                                        <span class="badge badge-pink rounded-pill">Female Tutor</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Not Specified</span>
                                    @endif
                                </td>
                                <td>{{ $lead->preferred_time ?? '-' }}</td>
                                <td>
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
                                </td>
                                <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- View --}}
                                        <a href="{{ route('admin.book-lessons.show', $lead->id) }}"
                                           class="action-btn btn btn-outline-primary"
                                           title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        {{-- Edit Status --}}
                                        <a href="{{ route('admin.book-lessons.edit', $lead->id) }}"
                                           class="action-btn btn btn-outline-warning"
                                           title="Edit Status">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.book-lessons.destroy', $lead->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this lead?');"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn btn-outline-danger" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4 text-muted">
                                    No lesson enquiries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



{{-- DataTables + Buttons (CSS/JS assumed loaded globally in admin layout, links listed below for reference) --}}
{{--
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
--}}
<script>
    $(function () {
        $('#bookLessonsTable').DataTable({
            responsive: true,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            order: [[9, 'desc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search leads...",
                lengthMenu: "Show _MENU_ entries",
            },
            dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>

@endsection