
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- FORGOT PASSWORD PAGE                                                        --}}
{{-- Usage: resources/views/auth/forgot-password.blade.php                      --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
@extends('layouts.frontend')
@section('content')

<div class="login-page">

  {{-- ── Left Panel ────────────────────────────────────────────────────────── --}}
  <div class="login-left">
    <div class="ll-brand" onclick="showPage('news')">
      <div class="ll-brand-ic"><i class="fas fa-book-open"></i></div>
      <div><div class="ll-brand-t">MERIT</div><span class="ll-brand-s">Education Foundation</span></div>
    </div>
    <h2 class="ll-h">Forgot Your<br><em>Password?</em></h2>
    <p class="ll-p">No worries — it happens to the best of us. Enter your email and we'll send you a secure link to reset your password.</p>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-envelope"></i></div><div><div class="ll-feat-t">Check Your Inbox</div><div class="ll-feat-s">A reset link will arrive within a few minutes</div></div></div>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-lock"></i></div><div><div class="ll-feat-t">Secure Reset Process</div><div class="ll-feat-s">Links expire after 60 minutes for your protection</div></div></div>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-shield-alt"></i></div><div><div class="ll-feat-t">Safe &amp; Secure</div><div class="ll-feat-s">Your data is protected under UK GDPR standards</div></div></div>
    <div class="ll-footer">Merit Education Foundation · UK Registered Charity · Safeguarding First</div>
  </div>

  {{-- ── Right Panel ───────────────────────────────────────────────────────── --}}
  <div class="login-right">
    <div class="login-right-inner">

      {{-- Global Flash Alert --}}
      <div id="auth-alert" class="auth-alert" style="display:none" role="alert">
        <i class="auth-alert-icon fas fa-info-circle"></i>
        <span id="auth-alert-msg"></span>
        <button class="auth-alert-close" onclick="closeAlert()" aria-label="Close">&times;</button>
      </div>

      {{-- ── Step 1: Email Entry ──────────────────────────────────────────── --}}
      <div id="forgot-panel">

        {{-- Icon badge --}}
        <div class="fp-icon-wrap">
          <div class="fp-icon"><i class="fas fa-key"></i></div>
        </div>

        <h2 class="login-form-title" style="text-align:center">Reset Password</h2>
        <p class="login-form-sub" style="text-align:center">Enter the email address linked to your account and we'll send you a reset link.</p>

        <form id="forgot-form" novalidate>
          @csrf

          <div class="field-group">
            <label class="field-label" for="forgot-email">Email Address</label>
            <input type="email" id="forgot-email" name="email" class="field-input"
                   placeholder="you@email.com" autocomplete="email">
            <span class="field-error" id="err-forgot-email"></span>
          </div>

          <button type="submit" class="btn-gold" id="forgot-btn"
                  style="width:100%;justify-content:center;padding:15px;font-size:.82rem;margin-top:6px">
            <span class="btn-label"><i class="fas fa-paper-plane"></i> Send Reset Link</span>
            <span class="btn-spinner" style="display:none"><i class="fas fa-circle-notch fa-spin"></i> Sending…</span>
          </button>
        </form>
      </div>

      {{-- ── Step 2: Success Screen ───────────────────────────────────────── --}}
      <div id="forgot-success" style="display:none;text-align:center;padding:30px 0">
        <div class="fp-icon-wrap">
          <div class="fp-icon fp-icon--success"><i class="fas fa-envelope-open-text"></i></div>
        </div>
        <h2 class="login-form-title" style="margin-bottom:10px">Check Your Inbox</h2>
        <p class="login-form-sub" id="forgot-success-msg">
          We've sent a password reset link to your email address.
        </p>
        <div class="fp-info-box">
          <i class="fas fa-clock" style="color:var(--gold)"></i>
          The link will expire in <strong>60 minutes</strong>. Check your spam folder if you don't see it.
        </div>
        <p style="font-size:.76rem;color:var(--muted);margin-top:20px">
          Didn't receive it?
          <span class="fp-resend-link" id="resend-trigger" onclick="resetForgotForm()">Try again</span>
        </p>
      </div>

      <div class="login-back" onclick="window.location.href='{{ route('login') }}'">
        <i class="fas fa-arrow-left"></i>Back to Sign In
      </div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- Shared Styles (add once to your main CSS, or keep here)                   --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<style>
/* ── Field errors ── */
.field-error{display:block;font-size:.73rem;color:#e74c3c;margin-top:5px;min-height:16px;transition:all .2s}
.field-input.is-invalid{border-color:#e74c3c!important;box-shadow:0 0 0 3px rgba(231,76,60,.10)!important}
.field-input.is-valid{border-color:#27ae60!important}

/* ── Global alert ── */
.auth-alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:10px;font-size:.79rem;line-height:1.5;margin-bottom:18px;animation:slideDown .3s ease}
.auth-alert.is-error{background:#fdf0ef;border:1px solid #f5c6c1;color:#c0392b}
.auth-alert.is-success{background:#edfaf3;border:1px solid #a9dfbf;color:#1e8449}
.auth-alert.is-info{background:#eaf4fd;border:1px solid #a9cce3;color:#1a5276}
.auth-alert-icon{flex-shrink:0;margin-top:1px}
.auth-alert-close{margin-left:auto;background:none;border:none;cursor:pointer;font-size:1.1rem;color:inherit;opacity:.6;padding:0 0 0 6px}
.auth-alert-close:hover{opacity:1}
@keyframes slideDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}

/* ── Spinner button ── */
.btn-gold:disabled{opacity:.7;cursor:not-allowed}

/* ── Icon badge ── */
.fp-icon-wrap{display:flex;justify-content:center;margin-bottom:22px}
.fp-icon{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--navy,#1a2e4a),#2d4a6e);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--gold,#c9a84c);box-shadow:0 8px 24px rgba(26,46,74,.25),0 0 0 8px rgba(201,168,76,.08)}
.fp-icon--success{background:linear-gradient(135deg,#1e8449,#27ae60);color:#fff;box-shadow:0 8px 24px rgba(30,132,73,.25),0 0 0 8px rgba(39,174,96,.08)}

/* ── Info box ── */
.fp-info-box{background:var(--light-bg,#f8f6f1);border:1px solid rgba(201,168,76,.3);border-radius:10px;padding:14px 18px;font-size:.78rem;color:var(--muted,#6b7280);line-height:1.6;display:flex;align-items:flex-start;gap:10px;margin-top:18px;text-align:left}

/* ── Resend link ── */
.fp-resend-link{color:var(--gold,#c9a84c);cursor:pointer;font-weight:600}
.fp-resend-link:hover{text-decoration:underline}
</style>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- JavaScript                                                                 --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function showAlert(msg, type = 'error') {
  const box = document.getElementById('auth-alert');
  box.className = 'auth-alert is-' + type;
  document.getElementById('auth-alert-msg').textContent = msg;
  box.querySelector('.auth-alert-icon').className = 'auth-alert-icon fas ' + {
    error:'fa-exclamation-circle', success:'fa-check-circle', info:'fa-info-circle'
  }[type];
  box.style.display = 'flex';
  box.scrollIntoView({behavior:'smooth',block:'nearest'});
}
function closeAlert() { document.getElementById('auth-alert').style.display = 'none'; }

function setFieldError(field, msg) {
  const errEl = document.getElementById('err-forgot-' + field);
  const input = document.querySelector('[name="' + field + '"]');
  if (errEl) errEl.textContent = msg || '';
  if (input) { input.classList.toggle('is-invalid', !!msg); input.classList.toggle('is-valid', !msg && input.value.trim() !== ''); }
}
function clearErrors() {
  document.querySelectorAll('[id^="err-forgot-"]').forEach(el => el.textContent = '');
  document.querySelectorAll('#forgot-panel .field-input').forEach(el => el.classList.remove('is-invalid','is-valid'));
}

function setBtnLoading(btn, loading) {
  btn.disabled = loading;
  btn.querySelector('.btn-label').style.display  = loading ? 'none' : '';
  btn.querySelector('.btn-spinner').style.display = loading ? ''     : 'none';
}

async function ajaxPost(url, data) {
  const fd = new FormData();
  fd.append('_token', CSRF());
  Object.entries(data).forEach(([k,v]) => fd.append(k,v));
  const res = await fetch(url, { method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}, body:fd });
  return { ok: res.ok, status: res.status, data: await res.json() };
}

function resetForgotForm() {
  closeAlert();
  clearErrors();
  document.getElementById('forgot-email').value = '';
  document.getElementById('forgot-panel').style.display  = '';
  document.getElementById('forgot-success').style.display = 'none';
}

// ── Forgot password submit ───────────────────────────────────────────────────
document.getElementById('forgot-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  closeAlert(); clearErrors();

  const btn   = document.getElementById('forgot-btn');
  const email = document.getElementById('forgot-email').value.trim();
  setBtnLoading(btn, true);

  try {
    const { ok, data } = await ajaxPost('{{ route("ajax.forgot-password") }}', { email });

    if (ok && data.success) {
      document.getElementById('forgot-panel').style.display  = 'none';
      document.getElementById('forgot-success').style.display = '';
      document.getElementById('forgot-success-msg').textContent = data.message
        || 'We\'ve sent a password reset link to ' + email;
    } else if (data.errors) {
      Object.entries(data.errors).forEach(([f,msgs]) => setFieldError(f, Array.isArray(msgs) ? msgs[0] : msgs));
    } else {
      showAlert(data.message || 'Something went wrong. Please try again.', 'error');
    }
  } catch (err) {
    showAlert('Network error. Please check your connection and try again.', 'error');
  } finally {
    setBtnLoading(btn, false);
  }
});
</script>

@endsection




{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- RESET PASSWORD PAGE                                                         --}}
{{-- Usage: resources/views/auth/reset-password.blade.php                       --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
@extends('layouts.frontend')
@section('content')

<div class="login-page">

  {{-- ── Left Panel ────────────────────────────────────────────────────────── --}}
  <div class="login-left">
    <div class="ll-brand" onclick="showPage('news')">
      <div class="ll-brand-ic"><i class="fas fa-book-open"></i></div>
      <div><div class="ll-brand-t">MERIT</div><span class="ll-brand-s">Education Foundation</span></div>
    </div>
    <h2 class="ll-h">Create a<br><em>New Password</em></h2>
    <p class="ll-p">Choose a strong password to keep your account secure. You'll use it to access your lessons, progress reports, and donation history.</p>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-lock"></i></div><div><div class="ll-feat-t">Strong Password Tips</div><div class="ll-feat-s">Use 8+ characters with a mix of letters, numbers and symbols</div></div></div>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-shield-alt"></i></div><div><div class="ll-feat-t">Safe &amp; Secure</div><div class="ll-feat-s">Your data is protected under UK GDPR standards</div></div></div>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-graduation-cap"></i></div><div><div class="ll-feat-t">Back to Learning</div><div class="ll-feat-s">Reset your password and get straight back to your lessons</div></div></div>
    <div class="ll-footer">Merit Education Foundation · UK Registered Charity · Safeguarding First</div>
  </div>

  {{-- ── Right Panel ───────────────────────────────────────────────────────── --}}
  <div class="login-right">
    <div class="login-right-inner">

      {{-- Global Flash Alert --}}
      <div id="auth-alert" class="auth-alert" style="display:none" role="alert">
        <i class="auth-alert-icon fas fa-info-circle"></i>
        <span id="auth-alert-msg"></span>
        <button class="auth-alert-close" onclick="closeAlert()" aria-label="Close">&times;</button>
      </div>

      {{-- ── Reset Form ───────────────────────────────────────────────────── --}}
      <div id="reset-panel">

        <div class="fp-icon-wrap">
          <div class="fp-icon"><i class="fas fa-lock-open"></i></div>
        </div>

        <h2 class="login-form-title" style="text-align:center">Set New Password</h2>
        <p class="login-form-sub" style="text-align:center">Your reset link is valid. Please enter and confirm your new password below.</p>

        <form id="reset-form" novalidate>
          @csrf
          {{-- Hidden fields passed from the signed URL --}}
          {{-- <input type="hidden" name="token" value="{{ $token }}">
          <input type="hidden" name="email" value="{{ $email ?? '' }}" id="reset-email"> --}}

          <div class="field-group">
            <label class="field-label" for="rp-email">Email Address</label>
            <input type="email" id="rp-email-display" name="_email_display" class="field-input"
                   value="{{ $email ?? '' }}" readonly
                   style="background:var(--light-bg,#f8f6f1);cursor:default;color:var(--muted,#6b7280)">
          </div>

          <div class="field-group">
            <label class="field-label" for="rp-pw1">New Password</label>
            <div class="pass-toggle">
              <input type="password" class="field-input" placeholder="Create password (min 8 chars)"
                     id="rp-pw1" name="password" autocomplete="new-password">
              <span class="pt-eye" onclick="togglePw('rp-pw1',this)"><i class="fas fa-eye"></i></span>
            </div>
            <span class="field-error" id="err-reset-password"></span>

            {{-- Password strength bar --}}
            <div class="pw-strength-wrap" id="pw-strength-wrap" style="display:none">
              <div class="pw-strength-bar">
                <div class="pw-strength-fill" id="pw-strength-fill"></div>
              </div>
              <span class="pw-strength-label" id="pw-strength-label">Weak</span>
            </div>
          </div>

          <div class="field-group">
            <label class="field-label" for="rp-pw2">Confirm New Password</label>
            <div class="pass-toggle">
              <input type="password" class="field-input" placeholder="Confirm new password"
                     id="rp-pw2" name="password_confirmation" autocomplete="new-password">
              <span class="pt-eye" onclick="togglePw('rp-pw2',this)"><i class="fas fa-eye"></i></span>
            </div>
            <span class="field-error" id="err-reset-password_confirmation"></span>
          </div>

          {{-- Password rules checklist --}}
          <div class="pw-rules">
            <div class="pw-rule" id="rule-len"><i class="fas fa-circle"></i> At least 8 characters</div>
            <div class="pw-rule" id="rule-upper"><i class="fas fa-circle"></i> One uppercase letter</div>
            <div class="pw-rule" id="rule-num"><i class="fas fa-circle"></i> One number</div>
            <div class="pw-rule" id="rule-sym"><i class="fas fa-circle"></i> One special character</div>
          </div>

          <button type="submit" class="btn-gold" id="reset-btn"
                  style="width:100%;justify-content:center;padding:15px;font-size:.82rem;margin-top:18px">
            <span class="btn-label"><i class="fas fa-check-circle"></i> Reset Password</span>
            <span class="btn-spinner" style="display:none"><i class="fas fa-circle-notch fa-spin"></i> Resetting…</span>
          </button>
        </form>
      </div>

      {{-- ── Success Screen ───────────────────────────────────────────────── --}}
      <div id="reset-success" style="display:none;text-align:center;padding:30px 0">
        <div class="fp-icon-wrap">
          <div class="fp-icon fp-icon--success"><i class="fas fa-check-double"></i></div>
        </div>
        <h2 class="login-form-title" style="margin-bottom:10px">Password Reset!</h2>
        <p class="login-form-sub">Your password has been successfully updated. You can now sign in with your new password.</p>
        <div class="fp-info-box" style="margin-top:18px;justify-content:center">
          <i class="fas fa-shield-alt" style="color:var(--gold)"></i>
          For your security, all other sessions have been logged out.
        </div>
        <button class="btn-gold" onclick="window.location.href='{{ route('login') }}'"
                style="width:100%;justify-content:center;padding:15px;font-size:.82rem;margin-top:24px">
          <i class="fas fa-sign-in-alt"></i> Sign In Now
        </button>
      </div>

      {{-- ── Invalid / Expired Token Screen ─────────────────────────────── --}}
      <div id="reset-expired" style="display:{{ isset($expired) && $expired ? '' : 'none' }};text-align:center;padding:30px 0">
        <div class="fp-icon-wrap">
          <div class="fp-icon" style="background:linear-gradient(135deg,#922b21,#c0392b);color:#fff;box-shadow:0 8px 24px rgba(192,57,43,.25),0 0 0 8px rgba(192,57,43,.08)">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
        </div>
        <h2 class="login-form-title" style="margin-bottom:10px">Link Expired</h2>
        <p class="login-form-sub">This password reset link has expired or already been used. Reset links are only valid for 60 minutes.</p>
        <button class="btn-gold" onclick="window.location.href='{{ route('password.request') }}'"
                style="width:100%;justify-content:center;padding:15px;font-size:.82rem;margin-top:20px">
          <i class="fas fa-redo"></i> Request New Link
        </button>
      </div>

      <div class="login-back" onclick="window.location.href='{{ route('login') }}'">
        <i class="fas fa-arrow-left"></i>Back to Sign In
      </div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- Styles                                                                     --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<style>
/* ── Field errors ── */
.field-error{display:block;font-size:.73rem;color:#e74c3c;margin-top:5px;min-height:16px;transition:all .2s}
.field-input.is-invalid{border-color:#e74c3c!important;box-shadow:0 0 0 3px rgba(231,76,60,.10)!important}
.field-input.is-valid{border-color:#27ae60!important}

/* ── Global alert ── */
.auth-alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:10px;font-size:.79rem;line-height:1.5;margin-bottom:18px;animation:slideDown .3s ease}
.auth-alert.is-error{background:#fdf0ef;border:1px solid #f5c6c1;color:#c0392b}
.auth-alert.is-success{background:#edfaf3;border:1px solid #a9dfbf;color:#1e8449}
.auth-alert.is-info{background:#eaf4fd;border:1px solid #a9cce3;color:#1a5276}
.auth-alert-icon{flex-shrink:0;margin-top:1px}
.auth-alert-close{margin-left:auto;background:none;border:none;cursor:pointer;font-size:1.1rem;color:inherit;opacity:.6;padding:0 0 0 6px}
.auth-alert-close:hover{opacity:1}
@keyframes slideDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.btn-gold:disabled{opacity:.7;cursor:not-allowed}

/* ── Icon badge ── */
.fp-icon-wrap{display:flex;justify-content:center;margin-bottom:22px}
.fp-icon{width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--navy,#1a2e4a),#2d4a6e);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--gold,#c9a84c);box-shadow:0 8px 24px rgba(26,46,74,.25),0 0 0 8px rgba(201,168,76,.08)}
.fp-icon--success{background:linear-gradient(135deg,#1e8449,#27ae60);color:#fff;box-shadow:0 8px 24px rgba(30,132,73,.25),0 0 0 8px rgba(39,174,96,.08)}

/* ── Info box ── */
.fp-info-box{background:var(--light-bg,#f8f6f1);border:1px solid rgba(201,168,76,.3);border-radius:10px;padding:14px 18px;font-size:.78rem;color:var(--muted,#6b7280);line-height:1.6;display:flex;align-items:flex-start;gap:10px;margin-top:18px;text-align:left}

/* ── Resend link ── */
.fp-resend-link{color:var(--gold,#c9a84c);cursor:pointer;font-weight:600}
.fp-resend-link:hover{text-decoration:underline}

/* ── Password strength bar ── */
.pw-strength-wrap{display:flex;align-items:center;gap:10px;margin-top:8px}
.pw-strength-bar{flex:1;height:5px;background:rgba(0,0,0,.08);border-radius:99px;overflow:hidden}
.pw-strength-fill{height:100%;border-radius:99px;transition:width .4s ease, background .4s ease;width:0}
.pw-strength-label{font-size:.71rem;font-weight:600;min-width:44px;text-align:right}

/* ── Password rules ── */
.pw-rules{display:grid;grid-template-columns:1fr 1fr;gap:5px 12px;margin-top:12px}
.pw-rule{font-size:.73rem;color:var(--muted,#9ca3af);display:flex;align-items:center;gap:6px;transition:color .2s}
.pw-rule .fas{font-size:.55rem;transition:all .2s}
.pw-rule.met{color:#27ae60}
.pw-rule.met .fas{color:#27ae60}
</style>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- JavaScript                                                                 --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function showAlert(msg, type = 'error') {
  const box = document.getElementById('auth-alert');
  box.className = 'auth-alert is-' + type;
  document.getElementById('auth-alert-msg').textContent = msg;
  box.querySelector('.auth-alert-icon').className = 'auth-alert-icon fas ' + {
    error:'fa-exclamation-circle', success:'fa-check-circle', info:'fa-info-circle'
  }[type];
  box.style.display = 'flex';
  box.scrollIntoView({behavior:'smooth',block:'nearest'});
}
function closeAlert() { document.getElementById('auth-alert').style.display = 'none'; }

function togglePw(id, el) {
  const input = document.getElementById(id);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  el.querySelector('i').className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
}

function setFieldError(field, msg) {
  const errEl = document.getElementById('err-reset-' + field);
  const input = document.querySelector('[name="' + field + '"]');
  if (errEl) errEl.textContent = msg || '';
  if (input) { input.classList.toggle('is-invalid', !!msg); input.classList.toggle('is-valid', !msg && input.value.trim() !== ''); }
}
function clearErrors() {
  document.querySelectorAll('[id^="err-reset-"]').forEach(el => el.textContent = '');
  document.querySelectorAll('#reset-panel .field-input').forEach(el => el.classList.remove('is-invalid','is-valid'));
}

function setBtnLoading(btn, loading) {
  btn.disabled = loading;
  btn.querySelector('.btn-label').style.display  = loading ? 'none' : '';
  btn.querySelector('.btn-spinner').style.display = loading ? ''     : 'none';
}

async function ajaxPost(url, data) {
  const fd = new FormData();
  fd.append('_token', CSRF());
  Object.entries(data).forEach(([k,v]) => fd.append(k,v));
  const res = await fetch(url, { method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}, body:fd });
  return { ok: res.ok, status: res.status, data: await res.json() };
}

// ── Password strength meter ──────────────────────────────────────────────────
const strengthColors = ['#e74c3c','#e67e22','#f1c40f','#27ae60'];
const strengthLabels = ['Weak','Fair','Good','Strong'];

document.getElementById('rp-pw1').addEventListener('input', function() {
  const val = this.value;
  const wrap = document.getElementById('pw-strength-wrap');

  if (!val) { wrap.style.display = 'none'; return; }
  wrap.style.display = 'flex';

  const rules = [
    { id:'rule-len',   met: val.length >= 8 },
    { id:'rule-upper', met: /[A-Z]/.test(val) },
    { id:'rule-num',   met: /[0-9]/.test(val) },
    { id:'rule-sym',   met: /[^A-Za-z0-9]/.test(val) },
  ];
  let score = rules.filter(r => r.met).length;

  rules.forEach(r => {
    const el = document.getElementById(r.id);
    el.classList.toggle('met', r.met);
    el.querySelector('i').className = r.met ? 'fas fa-check-circle' : 'fas fa-circle';
  });

  const fill  = document.getElementById('pw-strength-fill');
  const label = document.getElementById('pw-strength-label');
  fill.style.width      = (score * 25) + '%';
  fill.style.background = strengthColors[score - 1] || strengthColors[0];
  label.textContent     = strengthLabels[score - 1] || 'Weak';
  label.style.color     = strengthColors[score - 1] || strengthColors[0];
});

// ── Confirm password live validation ────────────────────────────────────────
document.getElementById('rp-pw2').addEventListener('input', function() {
  const pw1 = document.getElementById('rp-pw1').value;
  if (this.value && pw1 !== this.value) {
    setFieldError('password_confirmation', 'Passwords do not match');
  } else {
    setFieldError('password_confirmation', '');
  }
});

// ── Reset password submit ────────────────────────────────────────────────────
document.getElementById('reset-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  closeAlert(); clearErrors();

  const btn = document.getElementById('reset-btn');
  const pw1 = document.getElementById('rp-pw1').value;
  const pw2 = document.getElementById('rp-pw2').value;

  if (pw1 !== pw2) {
    setFieldError('password_confirmation', 'Passwords do not match');
    return;
  }

  setBtnLoading(btn, true);

  try {
    const { ok, data } = await ajaxPost('{{ route("ajax.reset-password") }}', {
      token:                 document.querySelector('[name="token"]').value,
      email:                 document.getElementById('reset-email').value,
      password:              pw1,
      password_confirmation: pw2,
    });

    if (ok && data.success) {
      document.getElementById('reset-panel').style.display  = 'none';
      document.getElementById('reset-success').style.display = '';
    } else if (data.errors) {
      Object.entries(data.errors).forEach(([f,msgs]) => setFieldError(f, Array.isArray(msgs) ? msgs[0] : msgs));
    } else if (data.expired) {
      document.getElementById('reset-panel').style.display  = 'none';
      document.getElementById('reset-expired').style.display = '';
    } else {
      showAlert(data.message || 'Something went wrong. Please try again.', 'error');
    }
  } catch (err) {
    showAlert('Network error. Please check your connection and try again.', 'error');
  } finally {
    setBtnLoading(btn, false);
  }
});
</script>

@endsection