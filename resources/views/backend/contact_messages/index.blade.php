@extends('layouts.backend')
@section('content')

{{-- Toast --}}
<div id="toast" class="toast-notify" style="display:none">
    <span id="toast-icon"></span><span id="toast-msg"></span>
</div>

{{-- View Message Modal --}}
<div id="modal-view-message" class="modal-backdrop" style="display:none" onclick="closeModalOutside(event,'modal-view-message')">
    <div class="modal-box" style="max-width:560px">
        <div class="modal-header-custom">
            <div class="card-title"><i class="fas fa-envelope-open-text"></i> Message Detail</div>
            <button class="modal-close-btn" onclick="closeModal('modal-view-message')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body-custom" id="messageDetailBody">
            <div class="msg-detail-row"><span class="msg-label">Name</span><span id="md-name" class="msg-val"></span></div>
            <div class="msg-detail-row"><span class="msg-label">Email</span><span id="md-email" class="msg-val"></span></div>
            <div class="msg-detail-row"><span class="msg-label">Phone</span><span id="md-phone" class="msg-val"></span></div>
            <div class="msg-detail-row"><span class="msg-label">Subject</span><span id="md-subject" class="msg-val"></span></div>
            <div class="msg-detail-row"><span class="msg-label">Status</span><span id="md-status" class="msg-val"></span></div>
            <div class="msg-detail-row"><span class="msg-label">Date</span><span id="md-date" class="msg-val"></span></div>
            <div class="msg-detail-row msg-detail-msg"><span class="msg-label">Message</span><div id="md-message" class="msg-val msg-body-text"></div></div>
        </div>
        <div class="modal-footer-custom d-flex justify-content-between align-items-center">
            <div class="d-flex gap-2">
                <button class="btn-prim btn-sm" id="md-mark-read" onclick="markStatus(currentMsgId,'read')"><i class="fas fa-check"></i> Mark Read</button>
                <button class="btn-outline-sm btn-sm" id="md-mark-pending" onclick="markStatus(currentMsgId,'pending')"><i class="fas fa-clock"></i> Pending</button>
            </div>
            <button class="btn-danger-sm btn-sm" onclick="deleteMessage(currentMsgId)"><i class="fas fa-trash"></i> Delete</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="page-header d-flex align-items-start justify-content-between">
        <div>
            <h1>Contact Messages</h1>
            <p>All incoming enquiries and contact submissions</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-outline-sm" onclick="exportData('csv')"><i class="fas fa-file-csv"></i> CSV</button>
            <button class="btn-outline-sm" onclick="exportData('excel')"><i class="fas fa-file-excel"></i> Excel</button>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4" id="statsRow">
        <div class="col-6 col-md-3">
            <div class="mini-stat-card">
                <div class="msc-icon msc-total"><i class="fas fa-envelope"></i></div>
                <div><div class="msc-val" id="stat-total">—</div><div class="msc-lbl">Total</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="mini-stat-card">
                <div class="msc-icon msc-new"><i class="fas fa-star"></i></div>
                <div><div class="msc-val" id="stat-new">—</div><div class="msc-lbl">New</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="mini-stat-card">
                <div class="msc-icon msc-pending"><i class="fas fa-clock"></i></div>
                <div><div class="msc-val" id="stat-pending">—</div><div class="msc-lbl">Pending</div></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="mini-stat-card">
                <div class="msc-icon msc-read"><i class="fas fa-check-circle"></i></div>
                <div><div class="msc-val" id="stat-read">—</div><div class="msc-lbl">Read</div></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header-custom">
            <div class="card-title">
                <i class="fas fa-comments"></i> All Messages
                <span class="count-badge" id="totalBadge">0 total</span>
            </div>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="filter-bar">
            <div class="filter-search-wrap">
                <i class="fas fa-search filter-search-ico"></i>
                <input type="text" id="searchInput" class="f-input filter-search-input"
                    placeholder="Search name, email, subject...">
                <button class="filter-clear-btn" id="clearSearch" onclick="clearSearch()" style="display:none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <select class="f-select filter-select" id="statusFilter" onchange="loadTable()">
                <option value="">All Status</option>
                <option value="new">New</option>
                <option value="read">Read</option>
                <option value="pending">Pending</option>
            </select>
            <select class="f-select filter-select" id="perPageSelect" onchange="loadTable()">
                <option value="10">10 / page</option>
                <option value="25">25 / page</option>
                <option value="50">50 / page</option>
                <option value="100">100 / page</option>
            </select>
        </div>

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

{{-- ==================== STYLES ==================== --}}
<style>
/* Toast */
.toast-notify{position:fixed;top:24px;right:24px;z-index:9999;display:flex;align-items:center;gap:10px;padding:13px 20px;border-radius:10px;font-size:.84rem;font-weight:600;box-shadow:0 8px 30px rgba(0,0,0,.18);animation:slideIn .3s ease;min-width:260px;max-width:380px}
.toast-success{background:var(--grn,#22c55e);color:#fff}.toast-error{background:#ef4444;color:#fff}.toast-warning{background:var(--gold,#f59e0b);color:#fff}
@keyframes slideIn{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:none}}
@keyframes slideOut{from{opacity:1;transform:none}to{opacity:0;transform:translateX(60px)}}

/* Mini stats */
.mini-stat-card{display:flex;align-items:center;gap:14px;padding:14px 18px;background:var(--card-bg,#1e293b);border:1px solid var(--border,#334155);border-radius:12px}
.msc-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.9rem}
.msc-total{background:rgba(99,102,241,.15);color:#818cf8}.msc-new{background:rgba(245,158,11,.15);color:var(--gold,#f59e0b)}
.msc-pending{background:rgba(251,146,60,.15);color:#fb923c}.msc-read{background:rgba(34,197,94,.15);color:var(--grn,#22c55e)}
.msc-val{font-size:1.3rem;font-weight:700;line-height:1}.msc-lbl{font-size:.68rem;color:var(--muted);margin-top:2px}

/* Count badge */
.count-badge{font-size:.72rem;background:var(--bg,#0f172a);color:var(--muted);padding:3px 10px;border-radius:20px;margin-left:8px;font-weight:600}

/* Filter bar */
.filter-bar{display:flex;align-items:center;gap:10px;padding:14px 20px;border-bottom:1px solid var(--border,#334155);flex-wrap:wrap}
.filter-search-wrap{position:relative;flex:1;min-width:200px}
.filter-search-ico{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.75rem;pointer-events:none}
.filter-search-input{padding-left:32px!important;padding-right:32px!important}
.filter-clear-btn{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;font-size:.75rem;padding:0}
.filter-select{width:auto;min-width:120px}

/* Sortable */
.sortable{cursor:pointer;user-select:none}.sortable:hover{color:var(--gold,#f59e0b)}
.sort-ico{margin-left:4px;font-size:.65rem;opacity:.4;transition:opacity .2s}.sort-ico.active{opacity:1;color:var(--gold,#f59e0b)}

/* Loading / empty */
.tbl-loading,.tbl-empty{text-align:center;padding:40px 0;color:var(--muted);font-size:.82rem}
.spinner-ring{display:inline-block;width:18px;height:18px;border:2px solid var(--border);border-top-color:var(--gold,#f59e0b);border-radius:50%;animation:spin .7s linear infinite;margin-right:8px;vertical-align:middle}
@keyframes spin{to{transform:rotate(360deg)}}

/* Bulk bar */
.bulk-bar{display:flex;align-items:center;gap:10px;padding:10px 16px;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.2);border-radius:8px;margin-top:12px;font-size:.78rem;flex-wrap:wrap}
.bulk-bar span{font-weight:600;color:var(--gold,#f59e0b);margin-right:4px}

/* Pagination */
.pg-btn{padding:5px 12px;font-size:.72rem;border-radius:6px;border:1px solid var(--border,#334155);background:var(--card-bg,#1e293b);color:var(--text,#e2e8f0);cursor:pointer;transition:.2s}
.pg-btn:hover{border-color:var(--gold,#f59e0b);color:var(--gold,#f59e0b)}
.pg-btn.active{background:var(--gold,#f59e0b);color:#000;border-color:var(--gold,#f59e0b);font-weight:700}
.pg-btn:disabled{opacity:.4;cursor:not-allowed}

/* Modal */
.modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:1050;display:flex;align-items:center;justify-content:center;padding:20px}
.modal-box{background:var(--card-bg,#1e293b);border:1px solid var(--border,#334155);border-radius:16px;width:100%;overflow:hidden}
.modal-header-custom,.modal-footer-custom{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border,#334155)}
.modal-footer-custom{border-bottom:none;border-top:1px solid var(--border,#334155)}
.modal-close-btn{background:none;border:none;color:var(--muted);cursor:pointer;font-size:.9rem;padding:4px 8px;border-radius:6px;transition:.2s}
.modal-close-btn:hover{background:var(--bg);color:var(--text)}
.modal-body-custom{padding:20px}
.msg-detail-row{display:flex;gap:12px;padding:9px 0;border-bottom:1px solid var(--border,#334155);align-items:flex-start}
.msg-detail-row:last-child{border-bottom:none}
.msg-label{font-size:.72rem;font-weight:700;color:var(--muted);min-width:70px;padding-top:2px;text-transform:uppercase;letter-spacing:.04em}
.msg-val{font-size:.82rem;flex:1}
.msg-body-text{font-size:.82rem;line-height:1.7;color:var(--text)}
.msg-detail-msg{align-items:flex-start}
</style>

{{-- ==================== SCRIPTS ==================== --}}
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
let currentPage = 1;
let currentSort = 'created_at';
let currentDir  = 'desc';
let searchTimer = null;
let currentMsgId = null;

/* ---- Toast ---- */
function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.className = `toast-notify toast-${type}`;
    document.getElementById('toast-icon').textContent = {success:'✓',error:'✕',warning:'⚠'}[type]||'•';
    document.getElementById('toast-msg').textContent = msg;
    t.style.display = 'flex'; t.style.animation = 'slideIn .3s ease';
    clearTimeout(t._t);
    t._t = setTimeout(() => {
        t.style.animation = 'slideOut .3s ease forwards';
        setTimeout(() => { t.style.display = 'none'; t.style.animation = ''; }, 300);
    }, 4000);
}

/* ---- Modal ---- */
function openModal(id) { document.getElementById(`modal-${id}`).style.display = 'flex'; }
function closeModal(id) { document.getElementById(`modal-${id}`).style.display = 'none'; }
function closeModalOutside(e, id) { if (e.target.id === `modal-${id}`) closeModal(id); }

/* ---- Load Table ---- */
function loadTable(page = 1) {
    currentPage = page;
    const search  = document.getElementById('searchInput').value;
    const status  = document.getElementById('statusFilter').value;
    const perPage = document.getElementById('perPageSelect').value;

    document.getElementById('tableBody').innerHTML =
        '<tr><td colspan="9" class="tbl-loading"><span class="spinner-ring"></span> Loading...</td></tr>';

    const params = new URLSearchParams({
        page, search, status, per_page: perPage,
        sort: currentSort, dir: currentDir
    });

    fetch(`{{ route('contact-messages.data') }}?${params}`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(data => {
        renderTable(data.data);
        renderPagination(data.meta);
        updateStats(data.stats);
        document.getElementById('totalBadge').textContent = `${data.meta.total} total`;
        document.getElementById('selectAll').checked = false;
        updateBulkBar();
    })
    .catch(() => {
        document.getElementById('tableBody').innerHTML =
            '<tr><td colspan="9" class="tbl-empty"><i class="fas fa-exclamation-triangle"></i> Failed to load data.</td></tr>';
    });
}

/* ---- Render Table Rows ---- */
function renderTable(rows) {
    if (!rows.length) {
        document.getElementById('tableBody').innerHTML =
            '<tr><td colspan="9" class="tbl-empty"><i class="fas fa-inbox"></i> No messages found.</td></tr>';
        return;
    }
    const statusMap = {
        new:     `<span class="badge-status bs-new"><span class="bs-dot"></span>New</span>`,
        read:    `<span class="badge-status bs-active"><span class="bs-dot"></span>Read</span>`,
        pending: `<span class="badge-status bs-pending"><span class="bs-dot"></span>Pending</span>`,
    };
    document.getElementById('tableBody').innerHTML = rows.map(r => `
        <tr id="row-${r.id}">
            <td><input type="checkbox" class="row-cb" data-id="${r.id}" style="accent-color:var(--gold)" onchange="updateBulkBar()"></td>
            <td><div style="font-weight:600;font-size:.82rem">${esc(r.first_name)} ${esc(r.last_name)}</div></td>
            <td><span style="font-size:.8rem">${esc(r.email)}</span></td>
            <td><span style="font-size:.78rem">${esc(r.phone||'—')}</span></td>
            <td><span style="font-size:.78rem;max-width:140px;display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis" title="${esc(r.enquiry_type||'')}">${esc(r.enquiry_type||'—')}</span></td>
            <td><span style="font-size:.78rem;max-width:200px;display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis" title="${esc(r.message||'')}">${esc(r.message||'').substring(0,80)}${(r.message||'').length>80?'…':''}</span></td>
            <td>${statusMap[r.status] || statusMap['new']}</td>
            <td><span style="font-size:.72rem;color:var(--muted)">${formatDate(r.created_at)}</span></td>
            <td>
                <div class="d-flex gap-1">
                    <button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem" onclick="viewMessage(${r.id})" title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn-danger-sm" style="padding:4px 10px;font-size:.68rem" onclick="deleteMessage(${r.id})" title="Delete"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('');
}

/* ---- Render Pagination ---- */
function renderPagination(meta) {
    const { current_page, last_page, from, to, total } = meta;
    document.getElementById('paginationInfo').textContent =
        total ? `Showing ${from}–${to} of ${total} messages` : 'No results';

    if (last_page <= 1) { document.getElementById('paginationLinks').innerHTML = ''; return; }

    let html = `<button class="pg-btn" onclick="loadTable(${current_page-1})" ${current_page===1?'disabled':''}><i class="fas fa-chevron-left"></i></button>`;

    const pages = pagesToShow(current_page, last_page);
    let prev = null;
    pages.forEach(p => {
        if (prev !== null && p - prev > 1) html += `<button class="pg-btn" disabled>…</button>`;
        html += `<button class="pg-btn${p===current_page?' active':''}" onclick="loadTable(${p})">${p}</button>`;
        prev = p;
    });

    html += `<button class="pg-btn" onclick="loadTable(${current_page+1})" ${current_page===last_page?'disabled':''}><i class="fas fa-chevron-right"></i></button>`;
    document.getElementById('paginationLinks').innerHTML = html;
}

function pagesToShow(cur, last) {
    const pages = new Set([1, last, cur, cur-1, cur+1, cur-2, cur+2]);
    return [...pages].filter(p => p >= 1 && p <= last).sort((a,b) => a-b);
}

/* ---- Stats ---- */
function updateStats(stats) {
    if (!stats) return;
    document.getElementById('stat-total').textContent   = stats.total   ?? '—';
    document.getElementById('stat-new').textContent     = stats.new     ?? '—';
    document.getElementById('stat-pending').textContent = stats.pending ?? '—';
    document.getElementById('stat-read').textContent    = stats.read    ?? '—';
}

/* ---- Sort ---- */
function sortBy(col) {
    if (currentSort === col) {
        currentDir = currentDir === 'asc' ? 'desc' : 'asc';
    } else {
        currentSort = col; currentDir = 'asc';
    }
    document.querySelectorAll('.sort-ico').forEach(el => { el.className = 'fas fa-sort sort-ico'; });
    const ico = document.getElementById(`sort-${col}`);
    if (ico) {
        ico.className = `fas fa-sort-${currentDir==='asc'?'up':'down'} sort-ico active`;
    }
    loadTable(1);
}

/* ---- Search with debounce ---- */
document.getElementById('searchInput').addEventListener('input', function() {
    document.getElementById('clearSearch').style.display = this.value ? 'block' : 'none';
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadTable(1), 400);
});

function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('clearSearch').style.display = 'none';
    loadTable(1);
}

/* ---- Select All ---- */
function toggleSelectAll(cb) {
    document.querySelectorAll('.row-cb').forEach(el => { el.checked = cb.checked; });
    updateBulkBar();
}

function updateBulkBar() {
    const selected = document.querySelectorAll('.row-cb:checked');
    const bar = document.getElementById('bulkBar');
    if (selected.length > 0) {
        bar.style.display = 'flex';
        document.getElementById('bulkCount').textContent = `${selected.length} selected`;
    } else {
        bar.style.display = 'none';
    }
}

function getSelectedIds() {
    return [...document.querySelectorAll('.row-cb:checked')].map(el => el.dataset.id);
}

/* ---- View Message ---- */
function viewMessage(id) {
    currentMsgId = id;
    fetch(`{{ url('admin/contact-messages') }}/${id}`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(d => {
        const m = d.message;
        console.log(m.first_name);
        document.getElementById('md-name').textContent    = `${m.first_name} ${m.last_name}`;
        document.getElementById('md-email').textContent   = m.email;
        document.getElementById('md-phone').textContent   = m.phone || '—';
        document.getElementById('md-subject').textContent = m.enquiry_type || '—';
        document.getElementById('md-date').textContent    = formatDate(m.created_at);
        document.getElementById('md-message').textContent = m.message;
        const sMap = { new:'<span class="badge-status bs-new"><span class="bs-dot"></span>New</span>', read:'<span class="badge-status bs-active"><span class="bs-dot"></span>Read</span>', pending:'<span class="badge-status bs-pending"><span class="bs-dot"></span>Pending</span>' };
        document.getElementById('md-status').innerHTML = sMap[m.status] || sMap['new'];
        openModal('modal-view-message');
        // Auto-mark as read
        if (m.status === 'new') markStatus(id, 'read', false);
    })
    .catch(() => showToast('Could not load message.', 'error'));
}

/* ---- Mark Status ---- */
function markStatus(id, status, reload = true) {
    fetch(`{{ url('admin/contact-messages') }}/${id}/status`, {
        method: 'PATCH',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ status })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success && reload) { closeModal('view-message'); loadTable(currentPage); showToast(d.message, 'success'); }
    });
}

/* ---- Delete ---- */
function deleteMessage(id) {
    if (!confirm('Delete this message? This cannot be undone.')) return;
    fetch(`{{ url('admin/contact-messages') }}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            closeModal('view-message');
            const row = document.getElementById(`row-${id}`);
            if (row) { row.style.opacity = '0'; row.style.transition = 'opacity .3s'; setTimeout(() => loadTable(currentPage), 300); }
            showToast(d.message, 'success');
        } else showToast(d.message || 'Delete failed.', 'error');
    });
}

/* ---- Bulk Actions ---- */
function bulkAction(action) {
    const ids = getSelectedIds();
    if (!ids.length) return;
    if (action === 'delete' && !confirm(`Delete ${ids.length} message(s)?`)) return;

    fetch(`{{ route('contact-messages.bulk') }}`, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ ids, action })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) { loadTable(currentPage); showToast(d.message, 'success'); }
        else showToast(d.message || 'Action failed.', 'error');
    });
}

/* ---- Export ---- */
function exportData(type) {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const url = `{{ route('contact-messages.export') }}?type=${type}&search=${encodeURIComponent(search)}&status=${status}&sort=${currentSort}&dir=${currentDir}`;
    window.open(url, '_blank');
}

/* ---- Helpers ---- */
function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function formatDate(str) {
    if (!str) return '—';
    const d = new Date(str);
    return d.toLocaleDateString('en-GB', { day:'numeric', month:'short', year:'numeric' });
}

// Initial load
document.addEventListener('DOMContentLoaded', () => loadTable(1));
</script>
@endsection