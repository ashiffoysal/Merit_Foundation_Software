@extends('layouts.backend')
@section('content')
@php
    $companyInformation = \App\Models\CompanyInformation::first();
    $admin = Auth::user();
@endphp

{{-- Toast Notification --}}
<div id="toast" class="toast-notify" style="display:none">
    <span id="toast-icon"></span>
    <span id="toast-msg"></span>
</div>

<div class="container">
    <div class="page-header">
        <h1>Settings</h1>
        <p>Manage system, account and organisation preferences</p>
    </div>

    <div class="row g-4">
        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- ===== COMPANY INFORMATION CARD ===== --}}
            <div class="card mb-4">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-building"></i> Organisation Details</div>
                    <button class="btn-prim" id="saveCompanyBtn" onclick="saveCompanyInfo()">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
                <div class="card-body-custom">
                    <form id="companyForm" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Organisation Name <span class="req">*</span></label>
                                    <input type="text" name="organisation_name" id="organisation_name" class="f-input"
                                        value="{{ $companyInformation->organisation_name ?? 'Merit Education Foundation' }}"
                                        placeholder="Organisation Name">
                                    <span class="err-msg" id="err-organisation_name"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Charity Number</label>
                                    <input type="text" name="charity_number" id="charity_number" class="f-input"
                                        value="{{ $companyInformation->charity_number ?? '1234567' }}"
                                        placeholder="Charity Number">
                                    <span class="err-msg" id="err-charity_number"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Primary Email <span class="req">*</span></label>
                                    <input type="email" name="primary_email" id="primary_email" class="f-input"
                                        value="{{ $companyInformation->primary_email ?? 'info@meriteducation.org' }}"
                                        placeholder="Primary Email">
                                    <span class="err-msg" id="err-primary_email"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Safeguarding Email <span class="req">*</span></label>
                                    <input type="email" name="safeguarding_email" id="safeguarding_email" class="f-input"
                                        value="{{ $companyInformation->safeguarding_email ?? 'safeguarding@meriteducation.org' }}"
                                        placeholder="Safeguarding Email">
                                    <span class="err-msg" id="err-safeguarding_email"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Office Hours</label>
                                    <input type="text" name="office_hours" id="office_hours" class="f-input"
                                        value="{{ $companyInformation->office_hours ?? '9:00 AM - 5:00 PM' }}"
                                        placeholder="e.g. 9:00 AM - 5:00 PM">
                                    <span class="err-msg" id="err-office_hours"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Phone <span class="req">*</span></label>
                                    <input type="tel" name="phone" id="phone" class="f-input"
                                        value="{{ $companyInformation->phone ?? '+44 20 0000 0000' }}"
                                        placeholder="+44 20 0000 0000">
                                    <span class="err-msg" id="err-phone"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="f-group">
                                    <label class="f-label">Address <span class="req">*</span></label>
                                    <textarea name="address" id="address" class="f-textarea" rows="2"
                                        placeholder="Full address">{{ $companyInformation->address ?? 'Merit House, London, United Kingdom' }}</textarea>
                                    <span class="err-msg" id="err-address"></span>
                                </div>
                            </div>

                            {{-- Logo --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Logo</label>
                                    <div class="file-upload-wrap">
                                        @if(!empty($companyInformation->logo))
                                            <div class="file-preview mb-2">
                                                <img id="logoPreview" src="{{ asset('storage/' . $companyInformation->logo) }}"
                                                    alt="Logo" style="height:48px;object-fit:contain;border-radius:6px;border:1px solid var(--border)">
                                            </div>
                                        @else
                                            <div class="file-preview mb-2" id="logoPreviewWrap" style="display:none">
                                                <img id="logoPreview" src="" alt="Logo"
                                                    style="height:48px;object-fit:contain;border-radius:6px;border:1px solid var(--border)">
                                            </div>
                                        @endif
                                        <label class="file-input-label">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span id="logoFileName">{{ $companyInformation->logo ? basename($companyInformation->logo) : 'Choose Logo' }}</span>
                                            <input type="file" name="logo" id="logo" class="f-file-input"
                                                accept="image/*" onchange="previewFile(this,'logoPreview','logoFileName','logoPreviewWrap')">
                                        </label>
                                        <span class="err-msg" id="err-logo"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Favicon --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Favicon</label>
                                    <div class="file-upload-wrap">
                                        @if(!empty($companyInformation->favicon))
                                            <div class="file-preview mb-2">
                                                <img id="faviconPreview" src="{{ asset('storage/' . $companyInformation->favicon) }}"
                                                    alt="Favicon" style="height:48px;object-fit:contain;border-radius:6px;border:1px solid var(--border)">
                                            </div>
                                        @else
                                            <div class="file-preview mb-2" id="faviconPreviewWrap" style="display:none">
                                                <img id="faviconPreview" src="" alt="Favicon"
                                                    style="height:48px;object-fit:contain;border-radius:6px;border:1px solid var(--border)">
                                            </div>
                                        @endif
                                        <label class="file-input-label">
                                            <i class="fas fa-image"></i>
                                            <span id="faviconFileName">{{ $companyInformation->favicon ? basename($companyInformation->favicon) : 'Choose Favicon' }}</span>
                                            <input type="file" name="favicon" id="favicon" class="f-file-input"
                                                accept="image/*" onchange="previewFile(this,'faviconPreview','faviconFileName','faviconPreviewWrap')">
                                        </label>
                                        <span class="err-msg" id="err-favicon"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== ADMIN PROFILE CARD ===== --}}
            <div class="card">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-user-shield"></i> Admin Profile</div>
                    <button class="btn-gold-sm" id="saveAdminBtn" onclick="saveAdminProfile()">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
                <div class="card-body-custom">
                    <form id="adminForm" enctype="multipart/form-data" novalidate>
                        @csrf
                        {{-- Avatar Preview --}}
                        <div class="d-flex align-items-center gap-4 mb-4">
                            <div class="av-wrap">
                                @if($admin->profile_image)
                                    <img id="adminAvatarImg" src="{{ asset('storage/public/' . $admin->profile_image) }}"
                                        alt="Avatar" class="av-img" style="width:64px;height:64px;border-radius:50%;object-fit:cover">
                                @else
                                    <div class="av av-initials" id="adminAvatarInitials"
                                        style="width:64px;height:64px;font-size:1.4rem;background:linear-gradient(135deg,var(--gold),var(--s200))">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}{{ strtoupper(substr(strstr($admin->name, ' ') ?: '', 1, 1)) }}
                                    </div>
                                    <img id="adminAvatarImg" src="" alt="Avatar"
                                        class="av-img" style="width:64px;height:64px;border-radius:50%;object-fit:cover;display:none">
                                @endif
                            </div>
                            <div>
                                <label class="btn-outline-sm btn-sm" style="cursor:pointer">
                                    <i class="fas fa-upload"></i> Upload Photo
                                    <input type="file" name="profile_image" id="adminPhoto" class="f-file-input"
                                        accept="image/*" onchange="previewAdminPhoto(this)">
                                </label>
                                <span class="err-msg d-block mt-1" id="err-profile_image"></span>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Full Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="admin_name" class="f-input"
                                        value="{{ $admin->name }}" placeholder="Full Name">
                                    <span class="err-msg" id="err-name"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Email <span class="req">*</span></label>
                                    <input type="email" name="email" id="admin_email" class="f-input"
                                        value="{{ $admin->email }}" placeholder="Email">
                                    <span class="err-msg" id="err-email"></span>
                                </div>
                            </div>
                            <div class="col-12"><div class="settings-divider"><span>Change Password <small>(leave blank to keep current)</small></span></div></div>
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Current Password</label>
                                    <div class="pw-wrap">
                                        <input type="password" name="current_password" id="current_password"
                                            class="f-input" placeholder="••••••••">
                                        <button type="button" class="pw-toggle" onclick="togglePw('current_password',this)"><i class="fas fa-eye"></i></button>
                                    </div>
                                    <span class="err-msg" id="err-current_password"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">New Password</label>
                                    <div class="pw-wrap">
                                        <input type="password" name="password" id="new_password"
                                            class="f-input" placeholder="••••••••">
                                        <button type="button" class="pw-toggle" onclick="togglePw('new_password',this)"><i class="fas fa-eye"></i></button>
                                    </div>
                                    <span class="err-msg" id="err-password"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Confirm Password</label>
                                    <div class="pw-wrap">
                                        <input type="password" name="password_confirmation" id="confirm_password"
                                            class="f-input" placeholder="••••••••">
                                        <button type="button" class="pw-toggle" onclick="togglePw('confirm_password',this)"><i class="fas fa-eye"></i></button>
                                    </div>
                                    <span class="err-msg" id="err-password_confirmation"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header-custom"><div class="card-title"><i class="fas fa-info-circle"></i> System Info</div></div>
                <div class="card-body-custom">
                    <div class="setting-row" style="padding:10px 0"><div class="sr-info"><h6>Version</h6><p>Merit Admin v2.4.1</p></div></div>
                    <div class="setting-row" style="padding:10px 0">
                        <div class="sr-info"><h6>Last Backup</h6><p>Today, 03:00 AM</p></div>
                        <span class="badge-mini badge-green">OK</span>
                    </div>
                    <div class="setting-row" style="padding:10px 0">
                        <div class="sr-info"><h6>GDPR Status</h6><p>UK GDPR Compliant</p></div>
                        <span class="badge-mini badge-green">Active</span>
                    </div>
                    <div class="setting-row" style="padding:10px 0">
                        <div class="sr-info"><h6>SSL Certificate</h6><p>Expires 1 June 2026</p></div>
                        <span class="badge-mini badge-green">Valid</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-user-shield"></i> Admin Users</div>
                    <button class="btn-gold-sm btn-sm" onclick="openModal('add-admin')"><i class="fas fa-plus"></i> Add</button>
                </div>
                <div class="card-body-custom" id="adminUsersList">
                     {{-- 
                    @foreach(\App\Models\User::where('role', 'admin')->orWhere('role', 'super_admin')->orWhere('role', 'manager')->orWhere('role', 'staff')->get() as $u)
                    <div class="d-flex align-items-center gap-3 p-2 border-bottom admin-user-row" style="border-color:var(--border)!important;margin-bottom:10px" id="user-row-{{ $u->id }}">
                        <div class="av" style="background:{{ $u->id == Auth::id() ? 'linear-gradient(135deg,var(--gold),var(--s200))' : 'var(--teal)' }};color:var(--s50)">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div style="flex:1">
                            <div style="font-size:.82rem;font-weight:600">{{ $u->name }}</div>
                            <div style="font-size:.68rem;color:var(--muted)">{{ ucfirst(str_replace('_',' ',$u->role ?? 'Admin')) }}</div>
                        </div>
                        @if($u->id == Auth::id())
                            <span class="badge-status bs-active" style="font-size:.6rem">You</span>
                        @else
                            <button class="btn-danger-sm" style="padding:3px 8px;font-size:.62rem"
                                onclick="banUser({{ $u->id }})"><i class="fas fa-ban"></i></button>
                        @endif
                    </div>
                    @endforeach
                     --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========== STYLES ========== --}}
<style>
/* Toast */
.toast-notify {
    position: fixed; top: 24px; right: 24px; z-index: 9999;
    display: flex; align-items: center; gap: 10px;
    padding: 13px 20px; border-radius: 10px;
    font-size: .84rem; font-weight: 600;
    box-shadow: 0 8px 30px rgba(0,0,0,.18);
    animation: slideIn .3s ease;
    min-width: 260px; max-width: 380px;
}
.toast-success { background: var(--grn, #22c55e); color: #fff; }
.toast-error   { background: #ef4444; color: #fff; }
.toast-warning { background: var(--gold, #f59e0b); color: #fff; }
@keyframes slideIn { from { opacity:0; transform:translateX(60px); } to { opacity:1; transform:none; } }
@keyframes slideOut { from { opacity:1; transform:none; } to { opacity:0; transform:translateX(60px); } }

/* Error messages */
.err-msg { color: #ef4444; font-size: .72rem; margin-top: 4px; display: block; min-height: 16px; }
.f-input.is-invalid, .f-textarea.is-invalid { border-color: #ef4444 !important; }
.req { color: #ef4444; margin-left: 2px; }

/* File upload */
.file-upload-wrap { display: flex; flex-direction: column; gap: 6px; }
.file-input-label {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 14px; border: 1.5px dashed var(--border, #334155);
    border-radius: 8px; cursor: pointer; font-size: .78rem;
    transition: border-color .2s;
}
.file-input-label:hover { border-color: var(--gold, #f59e0b); }
.file-input-label i { color: var(--gold, #f59e0b); }
.f-file-input { display: none; }

/* Password wrapper */
.pw-wrap { position: relative; }
.pw-wrap .f-input { padding-right: 38px; }
.pw-toggle {
    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: var(--muted); cursor: pointer; padding: 0;
    font-size: .8rem;
}

/* Settings divider */
.settings-divider {
    border-top: 1px solid var(--border, #334155);
    margin: 8px 0 4px; position: relative;
}
.settings-divider span {
    background: var(--card-bg, #1e293b); padding: 0 10px;
    font-size: .72rem; color: var(--muted);
    position: relative; top: -10px;
}

/* Badge mini */
.badge-mini { font-size: .65rem; padding: 3px 9px; border-radius: 10px; font-weight: 700; }
.badge-green { background: var(--grnp, #dcfce7); color: var(--grn, #16a34a); }

/* Button spinner */
.btn-spinner { display: inline-block; width: 12px; height: 12px; border: 2px solid rgba(255,255,255,.4); border-top-color: #fff; border-radius: 50%; animation: spin .7s linear infinite; margin-right: 6px; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>

{{-- ========== SCRIPTS ========== --}}
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

/* ---- Toast ---- */
function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    const icons = { success: '✓', error: '✕', warning: '⚠' };
    t.className = `toast-notify toast-${type}`;
    document.getElementById('toast-icon').textContent = icons[type] || '•';
    document.getElementById('toast-msg').textContent = msg;
    t.style.display = 'flex';
    clearTimeout(t._timer);
    t._timer = setTimeout(() => {
        t.style.animation = 'slideOut .3s ease forwards';
        setTimeout(() => { t.style.display = 'none'; t.style.animation = ''; }, 300);
    }, 4000);
}

/* ---- Clear errors ---- */
function clearErrors(formId) {
    document.querySelectorAll(`#${formId} .err-msg`).forEach(el => el.textContent = '');
    document.querySelectorAll(`#${formId} .is-invalid`).forEach(el => el.classList.remove('is-invalid'));
}

/* ---- Show errors ---- */
function showErrors(errors) {
    Object.entries(errors).forEach(([field, msgs]) => {
        const errEl = document.getElementById(`err-${field}`);
        const inputEl = document.querySelector(`[name="${field}"]`);
        if (errEl) errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
        if (inputEl) inputEl.classList.add('is-invalid');
    });
}

/* ---- File preview ---- */
function previewFile(input, previewId, nameId, wrapId) {
    const file = input.files[0];
    if (!file) return;
    document.getElementById(nameId).textContent = file.name;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        if (wrapId) {
            const wrap = document.getElementById(wrapId);
            if (wrap) wrap.style.display = 'block';
        }
    };
    reader.readAsDataURL(file);
}

/* ---- Admin photo preview ---- */
function previewAdminPhoto(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('adminAvatarImg');
        const initials = document.getElementById('adminAvatarInitials');
        img.src = e.target.result;
        img.style.display = 'block';
        if (initials) initials.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

/* ---- Toggle password ---- */
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    btn.innerHTML = isText ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
}

/* ---- Set button loading state ---- */
function setLoading(btn, loading, label) {
    if (loading) {
        btn.disabled = true;
        btn.dataset.orig = btn.innerHTML;
        btn.innerHTML = `<span class="btn-spinner"></span>${label || 'Saving...'}`;
    } else {
        btn.disabled = false;
        btn.innerHTML = btn.dataset.orig;
    }
}

/* ======================================================
   SAVE COMPANY INFORMATION
====================================================== */
function saveCompanyInfo() {
    clearErrors('companyForm');
    const btn = document.getElementById('saveCompanyBtn');
    setLoading(btn, true, 'Saving...');

    const formData = new FormData(document.getElementById('companyForm'));
    formData.append('_method', 'POST'); // or PUT if updating

    fetch('{{ route("admin.company-information.index") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        setLoading(btn, false);
        if (data.success) {
            showToast(data.message || 'Organisation details saved!', 'success');
            // Update logo/favicon if returned
            if (data.logo) {
                const img = document.getElementById('logoPreview');
                if (img) img.src = data.logo;
            }
            if (data.favicon) {
                const img = document.getElementById('faviconPreview');
                if (img) img.src = data.favicon;
            }
        } else if (data.errors) {
            showErrors(data.errors);
            showToast('Please fix the errors below.', 'error');
        } else {
            showToast(data.message || 'Something went wrong.', 'error');
        }
    })
    .catch(() => {
        setLoading(btn, false);
        showToast('Network error. Please try again.', 'error');
    });
}

/* ======================================================
   SAVE ADMIN PROFILE
====================================================== */
function saveAdminProfile() {
    clearErrors('adminForm');
    const btn = document.getElementById('saveAdminBtn');
    setLoading(btn, true, 'Updating...');

    const formData = new FormData(document.getElementById('adminForm'));

    fetch('{{ route("settings.admin.save") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        setLoading(btn, false);
        if (data.success) {
            showToast(data.message || 'Profile updated successfully!', 'success');
            // Update name display if changed
            if (data.user) {
                document.getElementById('admin_name').value = data.user.name;
                document.getElementById('admin_email').value = data.user.email;
                // Clear password fields
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('confirm_password').value = '';
                // Update avatar if image returned
                if (data.user.profile_image) {
                    const img = document.getElementById('adminAvatarImg');
                    if (img) { img.src = data.user.profile_image_url; img.style.display = 'block'; }
                    const initials = document.getElementById('adminAvatarInitials');
                    if (initials) initials.style.display = 'none';
                }
            }
        } else if (data.errors) {
            showErrors(data.errors);
            showToast('Please fix the errors below.', 'error');
        } else {
            showToast(data.message || 'Something went wrong.', 'error');
        }
    })
    .catch(() => {
        setLoading(btn, false);
        showToast('Network error. Please try again.', 'error');
    });
}

/* ======================================================
   BAN ADMIN USER
====================================================== */
function banUser(userId) {
    if (!confirm('Are you sure you want to disable this user?')) return;

    fetch(`/settings/admin-users/${userId}/ban`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify({ _method: 'PATCH' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById(`user-row-${userId}`);
            if (row) row.remove();
            showToast(data.message || 'User disabled.', 'warning');
        } else {
            showToast(data.message || 'Could not disable user.', 'error');
        }
    })
    .catch(() => showToast('Network error.', 'error'));
}
</script>
@endsection
