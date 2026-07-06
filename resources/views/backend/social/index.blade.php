@extends('layouts.backend')
@section('content')

{{-- Toast --}}
<div id="toast" style="display:none;position:fixed;top:22px;right:22px;z-index:9999;min-width:260px;max-width:380px;padding:13px 18px;border-radius:12px;align-items:center;gap:10px;font-size:.83rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.22)">
    <i id="toast-icon"></i>
    <span id="toast-msg"></span>
</div>

<style>
.social-page { max-width: 860px; margin: 0 auto; padding-bottom: 60px; }

.social-ph { display:flex; align-items:flex-end; justify-content:space-between; margin-top:100px; margin-bottom:28px; gap:16px; flex-wrap:wrap; }
.social-ph-left h1 { font-size:1.45rem; font-weight:700; margin:0 0 4px; }
.social-ph-left p  { font-size:.8rem; color:var(--muted,#94a3b8); margin:0; }

.btn-social-save {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 24px; border-radius:10px; border:none;
    background:#f59e0b; color:#000; font-size:.82rem; font-weight:700;
    cursor:pointer; transition:opacity .2s, transform .1s;
    white-space:nowrap;
}
.btn-social-save:hover   { opacity:.88; }
.btn-social-save:active  { transform:scale(.97); }
.btn-social-save:disabled{ opacity:.55; cursor:not-allowed; }

.seo-block {
    background:var(--card-bg,#ffffff);
    border:1px solid var(--border,#334155);
    border-radius:16px; overflow:hidden;
}
.seo-block-head {
    display:flex; align-items:center; gap:10px;
    padding:14px 22px;
    border-bottom:1px solid var(--border,#010202);
    background:rgba(255,255,255,.025);
}
.seo-block-icon {
    width:32px; height:32px; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    font-size:.9rem; flex-shrink:0;
}
.ico-rose { background:rgba(244,63,94,.15); color:#fb7185; }
.seo-block-title { font-size:.84rem; font-weight:700; flex:1; }
.seo-block-sub   { font-size:.7rem; color:var(--muted,#94a3b8); }
.seo-block-body { padding:22px; }

/* ── Social item rows (icon + input combined) ── */
.social-list { display:flex; flex-direction:column; gap:16px; }
.social-item { display:flex; align-items:flex-start; gap:14px; }
.social-icon-badge {
    width:42px; height:42px; border-radius:11px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:1.1rem; margin-top:1px;
}
.social-icon-facebook { background:rgba(59,130,246,.14); color:#3b82f6; }
.social-icon-twitter  { background:rgba(45,212,191,.14); color:#2dd4bf; }
.social-icon-linkedin { background:rgba(96,165,250,.14); color:#60a5fa; }

.social-item-body { flex:1; display:flex; flex-direction:column; gap:5px; min-width:0; }
.f-label {
    font-size:.68rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:var(--muted,#94a3b8);
    display:flex; align-items:center; justify-content:space-between;
}
.f-label-hint { font-weight:400; text-transform:none; letter-spacing:0; font-size:.67rem; }

.f-input {
    background:var(--input-bg,#0f172a);
    border:1.5px solid var(--border,#334155);
    border-radius:9px; color:var(--text,#f1f5f9);
    font-size:.82rem; padding:9px 12px;
    transition:border-color .18s, box-shadow .18s;
    width:100%; box-sizing:border-box;
}
.f-input:focus {
    outline:none; border-color:#f59e0b;
    box-shadow:0 0 0 3px rgba(245,158,11,.13);
}
.f-input.is-invalid {
    border-color:#ef4444 !important;
    box-shadow:0 0 0 3px rgba(239,68,68,.12) !important;
}
.err-msg { color:#ef4444; font-size:.69rem; display:block; min-height:14px; }

.social-divider { border:none; border-top:1px solid var(--border,#334155); margin:2px 0; }

/* ── Footer actions ── */
.social-actions { display:flex; justify-content:flex-end; margin-top:20px; }

/* ── Spinner ── */
.sp { display:inline-block; width:13px; height:13px; border:2px solid rgba(0,0,0,.25); border-top-color:#000; border-radius:50%; animation:spin .65s linear infinite; }
@keyframes spin { to{transform:rotate(360deg)} }

@keyframes tIn  { from{opacity:0;transform:translateX(50px)} to{opacity:1;transform:none} }
@keyframes tOut { from{opacity:1;transform:none} to{opacity:0;transform:translateX(50px)} }

@media(max-width:640px){
    .social-item { flex-direction:column; }
    .social-icon-badge { margin-bottom:2px; }
}
</style>

<div class="social-page">

    {{-- Header --}}
    <div class="social-ph">
        <div class="social-ph-left">
            <h1><i class="fas fa-share-alt" style="color:#f59e0b;margin-right:8px"></i>Social Media Links</h1>
            <p>Manage the profile links used across your site's footer, header and share buttons</p>
        </div>
    </div>

    <div class="seo-block">
        <div class="seo-block-head">
            <div class="seo-block-icon ico-rose"><i class="fas fa-link"></i></div>
            <div>
                <div class="seo-block-title">Profile URLs</div>
                <div class="seo-block-sub">Facebook, Twitter (X) &amp; LinkedIn</div>
            </div>
        </div>
        <div class="seo-block-body">
            <form id="socialForm" novalidate>
                @csrf
                <div class="social-list">

                    <div class="social-item">
                        <div class="social-icon-badge social-icon-facebook"><i class="fab fa-facebook-f"></i></div>
                        <div class="social-item-body">
                            <label class="f-label">Facebook URL</label>
                            <input type="url" name="facebook" class="f-input"
                                value="{{ $social->facebook ?? '' }}" placeholder="https://facebook.com/yourpage">
                            <span class="err-msg" id="err-facebook"></span>
                        </div>
                    </div>

                    <hr class="social-divider">

                    <div class="social-item">
                        <div class="social-icon-badge social-icon-twitter"><i class="fab fa-twitter"></i></div>
                        <div class="social-item-body">
                            <label class="f-label">Twitter / X URL</label>
                            <input type="url" name="twitter" class="f-input"
                                value="{{ $social->twitter ?? '' }}" placeholder="https://twitter.com/yourhandle">
                            <span class="err-msg" id="err-twitter"></span>
                        </div>
                    </div>

                    <hr class="social-divider">

                    <div class="social-item">
                        <div class="social-icon-badge social-icon-instagram"><i class="fab fa-instagram"></i></div>
                        <div class="social-item-body">
                            <label class="f-label">Instagram URL</label>
                            <input type="url" name="instagram" class="f-input"
                                value="{{ $social->instagram ?? '' }}" placeholder="https://instagram.com/yourhandle">
                            <span class="err-msg" id="err-instagram"></span>
                        </div>
                    </div>
                    <hr class="social-divider">

                    <div class="social-item">
                        <div class="social-icon-badge social-icon-linkedin"><i class="fab fa-linkedin-in"></i></div>
                        <div class="social-item-body">
                            <label class="f-label">LinkedIn URL</label>
                            <input type="url" name="linkedin" class="f-input"
                                value="{{ $social->linkedin ?? '' }}" placeholder="https://linkedin.com/company/yourcompany">
                            <span class="err-msg" id="err-linkedin"></span>
                        </div>
                    </div>

                      <hr class="social-divider">

                    <div class="social-item">
                        <div class="social-icon-badge social-icon-youtube"><i class="fab fa-youtube"></i></div>
                        <div class="social-item-body">
                            <label class="f-label">YouTube URL</label>
                            <input type="url" name="youtube" class="f-input"
                                value="{{ $social->youtube ?? '' }}" placeholder="https://youtube.com/@yourchannel">
                            <span class="err-msg" id="err-youtube"></span>
                        </div>
                    </div>
                </div>

                <div class="social-actions">
                    <button type="button" class="btn-social-save" id="saveSocialBtn" onclick="saveSocialInfo()">
                        <span id="social-btn-text"><i class="fas fa-save"></i> Save Social Links</span>
                        <span id="social-btn-spin" style="display:none"><span class="sp"></span> Saving…</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>{{-- /social-page --}}

<script>
function toast(msg, type) {
    const t = document.getElementById('toast');
    const icons = {success:'fas fa-check-circle',error:'fas fa-times-circle',warning:'fas fa-exclamation-triangle'};
    const bgs   = {success:'#16a34a',error:'#dc2626',warning:'#f59e0b'};
    const colors= {success:'#fff',error:'#fff',warning:'#000'};
    t.style.cssText = `display:flex;align-items:center;gap:10px;padding:13px 18px;border-radius:12px;font-size:.83rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.22);position:fixed;top:22px;right:22px;z-index:9999;min-width:260px;max-width:380px;animation:tIn .3s ease;background:${bgs[type]};color:${colors[type]}`;
    document.getElementById('toast-icon').className = icons[type] || icons.success;
    document.getElementById('toast-msg').textContent = msg;
    clearTimeout(t._t);
    t._t = setTimeout(() => {
        t.style.animation = 'tOut .3s ease forwards';
        setTimeout(() => t.style.display='none', 300);
    }, 3800);
}

function clearSocialErrs() {
    document.querySelectorAll('#socialForm .err-msg').forEach(el => el.textContent = '');
    document.querySelectorAll('#socialForm .is-invalid').forEach(el => el.classList.remove('is-invalid'));
}
function showSocialErrs(errors) {
    Object.entries(errors).forEach(([field, msgs]) => {
        const e = document.getElementById('err-'+field);
        if (e) e.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
        const inp = document.querySelector('#socialForm [name="'+field+'"]');
        if (inp) inp.classList.add('is-invalid');
    });
}
function setSocialLoading(on) {
    const btn = document.getElementById('saveSocialBtn');
    btn.disabled = on;
    document.getElementById('social-btn-text').style.display = on ? 'none' : '';
    document.getElementById('social-btn-spin').style.display = on ? 'inline-flex' : 'none';
}

async function saveSocialInfo() {
    clearSocialErrs();
    setSocialLoading(true);
    const form = document.getElementById('socialForm');
    const fd = new FormData(form);
    try {
        const res = await fetch('{{ route("admin.settings.social.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('#socialForm [name="_token"]').value,
                'Accept': 'application/json'
            },
            body: fd
        });
        const json = await res.json();
        if (res.ok && json.success) {
            toast(json.message || 'Social links updated.', 'success');
        } else if (res.status === 422 && json.errors) {
            showSocialErrs(json.errors);
            toast('Please fix the highlighted errors.', 'error');
        } else {
            toast(json.message || 'Something went wrong.', 'error');
        }
    } catch (e) {
        toast('Network error – please try again.', 'error');
    } finally {
        setSocialLoading(false);
    }
}
</script>
@endsection