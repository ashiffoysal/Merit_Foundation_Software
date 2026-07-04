@extends('layouts.backend')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container">
    <div class="row">
        <div class="col-12">

   
{{-- ── Page Header ──────────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-0 fw-bold text-dark">User Management</h4>
        <small class="text-muted">All registered users</small>
    </div>
    <span class="badge bg-primary fs-6" id="total-count">Loading...</span>
</div>

{{-- ── Stats Cards ──────────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-primary" id="stat-total">—</div>
            <div class="text-muted small">Total Users</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-success" id="stat-active">—</div>
            <div class="text-muted small">Active</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-warning" id="stat-verified">—</div>
            <div class="text-muted small">Verified</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-danger" id="stat-deleted">—</div>
            <div class="text-muted small">Deleted</div>
        </div>
    </div>
</div>

{{-- ── Table Card ───────────────────────────────────────────────────────────── --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
        <h6 class="mb-0 fw-semibold">All Users</h6>
        <div class="d-flex gap-2">
            {{-- Search --}}
            <div class="input-group input-group-sm" style="width:240px">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="search-input"
                       class="form-control border-start-0 bg-light"
                       placeholder="Search name, email, phone…">
            </div>
            {{-- Filter --}}
            <select id="filter-status" class="form-select form-select-sm" style="width:130px">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="verified">Verified</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="users-table">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:50px">#</th>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Student Info</th>
                        <th>Stripe</th>
                        <th>Status</th>
                        <th class="text-center" style="width:130px">Manage</th>
                    </tr>
                </thead>
                <tbody id="users-tbody">
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <div class="spinner-border spinner-border-sm me-2"></div>
                            Loading users…
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Pagination ──────────────────────────────────────────────────────── --}}
    <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between py-3">
        <div class="text-muted small" id="pagination-info">—</div>
        <nav>
            <ul class="pagination pagination-sm mb-0" id="pagination-links"></ul>
        </nav>
    </div>
</div>

     </div>
    </div>
</div>
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- VIEW DETAILS MODAL                                                        --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-circle me-2"></i>User Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="view-modal-body">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- MANAGE MODAL                                                              --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="manageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="bi bi-gear me-2"></i>Manage User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="manage-modal-body">
                <div class="text-center py-4">
                    <div class="spinner-border text-dark"></div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ── Styles ───────────────────────────────────────────────────────────────── --}}
<style>
    #users-table thead th {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6c757d;
        border-bottom: 1px solid #dee2e6;
        white-space: nowrap;
    }
    #users-table tbody tr { transition: background .15s; }
    .avatar-circle {
        width: 36px; height: 36px; border-radius: 50%;
        object-fit: cover; background: #e9ecef;
        display: inline-flex; align-items: center;
        justify-content: center; font-weight: 600;
        font-size: .8rem; color: #495057;
        flex-shrink: 0;
    }
    .detail-label {
        font-size: .7rem; font-weight: 600;
        text-transform: uppercase; letter-spacing: .05em;
        color: #adb5bd; margin-bottom: 2px;
    }
    .detail-value { font-size: .9rem; color: #212529; }
    .stripe-badge {
        font-size: .65rem; font-family: monospace;
        background: #f0f4ff; color: #3d5afe;
        border-radius: 4px; padding: 2px 6px;
    }
    .pagination .page-link { font-size: .8rem; }
</style>


{{-- ── JavaScript ──────────────────────────────────────────────────────────── --}}
<script>
(function () {
    /* ── State ─────────────────────────────────────────────────────────────── */
    let currentPage   = 1;
    let searchQuery   = '';
    let filterStatus  = '';
    let searchTimer   = null;
    const perPage     = 10;

    /* ── Fetch users via AJAX ──────────────────────────────────────────────── */
    function fetchUsers(page = 1) {
        currentPage = page;

        const params = new URLSearchParams({
            page:   page,
            search: searchQuery,
            status: filterStatus,
        });

        fetch(`{{ route('admin.users.data') }}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            renderRows(data.data);
            renderPagination(data);
            renderStats(data.stats);
        })
        .catch(() => {
            document.getElementById('users-tbody').innerHTML =
                `<tr><td colspan="7" class="text-center text-danger py-4">
                    Failed to load users. Please refresh.
                 </td></tr>`;
        });
    }

    /* ── Render table rows ─────────────────────────────────────────────────── */
    function renderRows(users) {
        const tbody = document.getElementById('users-tbody');

        if (!users || users.length === 0) {
            tbody.innerHTML =
                `<tr><td colspan="7" class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>No users found.
                 </td></tr>`;
            return;
        }

        tbody.innerHTML = users.map((u, i) => {
            const initials = ((u.name || '?')[0] + (u.last_name || '?')[0]).toUpperCase();
            const avatarHtml = u.avatar
                ? `<img src="${u.avatar}" class="avatar-circle" alt="">`
                : `<span class="avatar-circle bg-primary bg-opacity-10 text-primary">${initials}</span>`;

            const stripeHtml = u.stripe_id
                ? `<span class="stripe-badge">${u.stripe_id.substring(0, 14)}…</span>`
                : `<span class="text-muted small">—</span>`;

            return `
            <tr>
                <td class="ps-3 text-muted small">${(currentPage - 1) * perPage + i + 1}</td>

                <td>
                    <div class="d-flex align-items-center gap-2">
                        ${avatarHtml}
                        <div>
                            <div class="fw-semibold text-dark" style="font-size:.88rem">
                                ${esc(u.name || '')} ${esc(u.last_name || '')}
                            </div>
                            <div class="text-muted" style="font-size:.76rem">${esc(u.email)}</div>
                        </div>
                    </div>
                </td>

                <td>
                    <div style="font-size:.82rem">${esc(u.phone || '—')}</div>
                    <div class="text-muted" style="font-size:.74rem">${esc(u.country || '—')}</div>
                </td>

                <td>
                    <div style="font-size:.82rem">${esc(u.student_name || '—')}</div>
                    <div class="text-muted" style="font-size:.74rem">${esc(u.quran_level || '—')}</div>
                </td>

                <td>${stripeHtml}</td>

                <td>
                    ${statusBadge(u)}
                </td>

                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary py-0 px-2 me-1"
                            onclick="viewUser(${u.id})" title="View Details">
                       View
                    </button>
                    <button class="btn btn-sm btn-outline-dark py-0 px-2"
                            onclick="manageUser(${u.id})" title="Manage">
                        Manage
                    </button>
                </td>
            </tr>`;
        }).join('');
    }

    function statusBadge(u) {
        if (u.is_deleted) return `<span class="badge bg-danger">Deleted</span>`;
        if (!u.is_active) return `<span class="badge bg-secondary">Inactive</span>`;
        if (u.email_verified_at) return `<span class="badge bg-success">Verified</span>`;
        return `<span class="badge bg-warning text-dark">Unverified</span>`;
    }

    /* ── Render pagination ─────────────────────────────────────────────────── */
    function renderPagination(data) {
        document.getElementById('total-count').textContent = data.total + ' Users';
        document.getElementById('pagination-info').textContent =
            `Showing ${data.from ?? 0}–${data.to ?? 0} of ${data.total} users`;

        const ul   = document.getElementById('pagination-links');
        const last = data.last_page;
        ul.innerHTML = '';

        const addBtn = (label, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = `page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${label}</a>`;
            if (!disabled) li.querySelector('a').addEventListener('click', e => {
                e.preventDefault(); fetchUsers(page);
            });
            ul.appendChild(li);
        };

        addBtn('«', 1, currentPage === 1);
        addBtn('‹', currentPage - 1, currentPage === 1);

        let start = Math.max(1, currentPage - 2);
        let end   = Math.min(last, currentPage + 2);
        if (start > 1)    { addBtn('1', 1); if (start > 2) addBtn('…', null, true); }
        for (let p = start; p <= end; p++) addBtn(p, p, false, p === currentPage);
        if (end < last)   { if (end < last - 1) addBtn('…', null, true); addBtn(last, last); }

        addBtn('›', currentPage + 1, currentPage === last);
        addBtn('»', last, currentPage === last);
    }

    /* ── Render stat cards ─────────────────────────────────────────────────── */
    function renderStats(stats) {
        if (!stats) return;
        document.getElementById('stat-total').textContent    = stats.total    ?? '—';
        document.getElementById('stat-active').textContent   = stats.active   ?? '—';
        document.getElementById('stat-verified').textContent = stats.verified ?? '—';
        document.getElementById('stat-deleted').textContent  = stats.deleted  ?? '—';
    }

    /* ── XSS escape helper ─────────────────────────────────────────────────── */
    function esc(str) {
        return String(str ?? '')
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ── Search ────────────────────────────────────────────────────────────── */
    document.getElementById('search-input').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            searchQuery = this.value.trim();
            fetchUsers(1);
        }, 400);
    });

    document.getElementById('filter-status').addEventListener('change', function () {
        filterStatus = this.value;
        fetchUsers(1);
    });

    /* ── VIEW USER MODAL ───────────────────────────────────────────────────── */
    window.viewUser = function (id) {
        const modal = new bootstrap.Modal(document.getElementById('viewModal'));
        document.getElementById('view-modal-body').innerHTML =
            `<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>`;
        modal.show();

        fetch(`{{ url('admin/users') }}/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(u => {
            document.getElementById('view-modal-body').innerHTML = `
            <div class="row g-4">
                {{-- Avatar & name --}}
                <div class="col-12 d-flex align-items-center gap-3 pb-3 border-bottom">
                    ${u.avatar
                        ? `<img src="${esc(u.avatar)}" class="rounded-circle" style="width:64px;height:64px;object-fit:cover">`
                        : `<div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:64px;height:64px;font-size:1.4rem;font-weight:700;color:#3d5afe">
                                ${(u.name||'?')[0].toUpperCase()}${(u.last_name||'?')[0].toUpperCase()}
                           </div>`
                    }
                    <div>
                        <h5 class="mb-0">${esc(u.name||'')} ${esc(u.last_name||'')}</h5>
                        <div class="text-muted">${esc(u.email)}</div>
                    </div>
                </div>

                {{-- Personal info --}}
                <div class="col-12"><p class="fw-semibold mb-2 text-dark">Personal Info</p></div>

                <div class="col-6 col-md-4">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value">${esc(u.phone||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Gender</div>
                    <div class="detail-value">${esc(u.gender||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Date of Birth</div>
                    <div class="detail-value">${esc(u.date_of_birth||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Age</div>
                    <div class="detail-value">${esc(u.age||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Country</div>
                    <div class="detail-value">${esc(u.country||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">City</div>
                    <div class="detail-value">${esc(u.city||'—')}</div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">
                        ${esc(u.address_line_1||'')} ${esc(u.address_line_2||'')}
                        ${u.postcode ? '— ' + esc(u.postcode) : ''}
                    </div>
                </div>

                {{-- Student info --}}
                <div class="col-12 border-top pt-3"><p class="fw-semibold mb-2 text-dark">Student Info</p></div>

                <div class="col-6 col-md-4">
                    <div class="detail-label">Student Name</div>
                    <div class="detail-value">${esc(u.student_name||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Quran Level</div>
                    <div class="detail-value">${esc(u.quran_level||'—')}</div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="detail-label">Learning Goals</div>
                    <div class="detail-value">${esc(u.learning_goals||'—')}</div>
                </div>

                {{-- Stripe / Payment --}}
                <div class="col-12 border-top pt-3"><p class="fw-semibold mb-2 text-dark">Payment</p></div>

                <div class="col-6 col-md-4">
                    <div class="detail-label">Stripe ID</div>
                    <div class="detail-value">
                        ${u.stripe_id ? `<span class="stripe-badge">${esc(u.stripe_id)}</span>` : '—'}
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Card Type</div>
                    <div class="detail-value">${esc(u.pm_type||'—')}</div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="detail-label">Card Last 4</div>
                    <div class="detail-value">${u.pm_last_four ? '•••• ' + esc(u.pm_last_four) : '—'}</div>
                </div>

                {{-- Account --}}
                <div class="col-12 border-top pt-3"><p class="fw-semibold mb-2 text-dark">Account</p></div>

                <div class="col-6 col-md-3">
                    <div class="detail-label">Verified</div>
                    <div>${u.email_verified_at
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-warning text-dark">No</span>'}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="detail-label">Active</div>
                    <div>${u.is_active
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-secondary">No</span>'}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="detail-label">Deleted</div>
                    <div>${u.is_deleted
                        ? '<span class="badge bg-danger">Yes</span>'
                        : '<span class="badge bg-light text-dark">No</span>'}</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="detail-label">Joined</div>
                    <div class="detail-value small">${esc(u.created_at?.substring(0,10)||'—')}</div>
                </div>
            </div>`;
        });
    };

    /* ── MANAGE USER MODAL ─────────────────────────────────────────────────── */
    window.manageUser = function (id) {
        const modal = new bootstrap.Modal(document.getElementById('manageModal'));
        document.getElementById('manage-modal-body').innerHTML =
            `<div class="text-center py-4"><div class="spinner-border"></div></div>`;
        modal.show();

        fetch(`{{ url('admin/users') }}/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(u => {
            document.getElementById('manage-modal-body').innerHTML = `
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="rounded-circle bg-dark bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:48px;height:48px;font-weight:700;font-size:1.1rem">
                    ${(u.name||'?')[0].toUpperCase()}${(u.last_name||'?')[0].toUpperCase()}
                </div>
                <div>
                    <div class="fw-semibold">${esc(u.name||'')} ${esc(u.last_name||'')}</div>
                    <div class="text-muted small">${esc(u.email)}</div>
                </div>
            </div>

            <div class="d-grid gap-2">

                {{-- Active toggle --}}
                <form method="POST" action="{{ url('admin/users') }}/${u.id}/toggle-active">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn w-100 ${u.is_active ? 'btn-outline-warning' : 'btn-outline-success'}">
                        <i class="bi bi-${u.is_active ? 'pause-circle' : 'play-circle'} me-2"></i>
                        ${u.is_active ? 'Deactivate User' : 'Activate User'}
                    </button>
                </form>

                {{-- Email verify --}}
                ${!u.email_verified_at ? `
                <form method="POST" action="{{ url('admin/users') }}/${u.id}/verify-email">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-envelope-check me-2"></i>Mark Email Verified
                    </button>
                </form>` : `
                <button class="btn btn-outline-secondary w-100" disabled>
                    <i class="bi bi-envelope-check me-2"></i>Email Already Verified
                </button>`}

                {{-- View subscriptions --}}
                <a href="{{ url('admin/users') }}/${u.id}/subscriptions"
                   class="btn btn-outline-info">
                    <i class="bi bi-credit-card me-2"></i>View Subscriptions
                </a>

                {{-- Soft delete --}}
                ${!u.is_deleted ? `
                <form method="POST" action="{{ url('admin/users') }}/${u.id}"
                      onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Delete User
                    </button>
                </form>` : `
                <form method="POST" action="{{ url('admin/users') }}/${u.id}/restore">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-success w-100">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Restore User
                    </button>
                </form>`}
            </div>`;
        });
    };

    /* ── Boot ──────────────────────────────────────────────────────────────── */
    fetchUsers(1);
})();
</script>

@endsection