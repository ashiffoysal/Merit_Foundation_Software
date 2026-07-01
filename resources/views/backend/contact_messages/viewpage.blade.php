@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-start justify-content-between">
        <div>
            <h1>Contact Messages</h1>
            <p>All incoming enquiries and contact submissions</p>
        </div>
        
    </div>

    {{-- Stats Row --}}
  

    <div class="card">
        <div class="card-header-custom">
            <div class="card-title">
                <i class="fas fa-comments"></i> View Messages
                {{-- <span class="count-badge" id="totalBadge">0 total</span> --}}
            </div>
        </div>

        {{-- Search & Filter Bar --}}
    
        <div class="card-body-custom">
            <div class="table-wrap">
                <table class="data-table" id="messagesTable">
                    <thead>
                        <tr>
                            <th style="width:36px">
                                <input type="checkbox" id="selectAll" style="accent-color:var(--gold)" onchange="toggleSelectAll(this)">
                            </th>
                            <th class="sortable" data-col="first_name" onclick="sortBy('first_name')">
                                Name <i class="fas fa-sort sort-ico" id="sort-first_name"></i>
                            </th>
                            <th class="sortable" data-col="email" onclick="sortBy('email')">
                                Email <i class="fas fa-sort sort-ico" id="sort-email"></i>
                            </th>
                            <th>Phone</th>
                            <th class="sortable" data-col="subject" onclick="sortBy('subject')">
                                Subject <i class="fas fa-sort sort-ico" id="sort-subject"></i>
                            </th>
                            <th>Message</th>
                            <th class="sortable" data-col="status" onclick="sortBy('status')">
                                Status <i class="fas fa-sort sort-ico" id="sort-status"></i>
                            </th>
                            <th class="sortable" data-col="created_at" onclick="sortBy('created_at')">
                                Date <i class="fas fa-sort-down sort-ico active" id="sort-created_at"></i>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr><td colspan="9" class="tbl-loading"><span class="spinner-ring"></span> Loading...</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- Bulk Actions --}}
            <div id="bulkBar" class="bulk-bar" style="display:none">
                <span id="bulkCount">0 selected</span>
                <button class="btn-outline-sm btn-sm" onclick="bulkAction('read')"><i class="fas fa-check"></i> Mark Read</button>
                <button class="btn-outline-sm btn-sm" onclick="bulkAction('pending')"><i class="fas fa-clock"></i> Mark Pending</button>
                <button class="btn-danger-sm btn-sm" onclick="bulkAction('delete')"><i class="fas fa-trash"></i> Delete</button>
            </div>

            {{-- Pagination --}}
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2" style="border-top:1px solid var(--border)">
                <span style="font-size:.75rem;color:var(--muted)" id="paginationInfo">—</span>
                <div class="d-flex gap-1 flex-wrap" id="paginationLinks"></div>
            </div>
        </div>
    </div>
</div>
@endsection