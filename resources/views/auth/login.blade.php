@extends('layouts.frontend')
@section('content')

<div class="login-page">

  {{-- ── Left Panel ────────────────────────────────────────────────────────── --}}
  <div class="login-left">
    <div class="ll-brand" onclick="showPage('news')">
      <div class="ll-brand-ic"><i class="fas fa-book-open"></i></div>
      <div><div class="ll-brand-t">MERIT</div><span class="ll-brand-s">Education Foundation</span></div>
    </div>
    <h2 class="ll-h">Welcome<br>Back to <em>Merit</em></h2>
    <p class="ll-p">Sign in to manage your lessons, track your child's progress, and support our mission to educate every child.</p>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-graduation-cap"></i></div><div><div class="ll-feat-t">Manage Your Lessons</div><div class="ll-feat-s">Book, reschedule and review your session history</div></div></div>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-chart-line"></i></div><div><div class="ll-feat-t">Track Progress</div><div class="ll-feat-s">Follow your child's Quran learning journey with detailed reports</div></div></div>
    <div class="ll-feat"><div class="ll-feat-ic"><i class="fas fa-heart"></i></div><div><div class="ll-feat-t">Manage Donations</div><div class="ll-feat-s">View your donation history and Gift Aid declarations</div></div></div>
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

      {{-- ── Tabs ──────────────────────────────────────────────────────────── --}}
      <div class="login-tab-wrap">
        <button class="login-tab active" onclick="switchLoginTab(this,'login')">Sign In</button>
        <button class="login-tab" onclick="switchLoginTab(this,'register')">Register</button>
      </div>

      {{-- ════════════════════════════════════════════════════════════════════ --}}
      {{-- Sign In Panel                                                        --}}
      {{-- ════════════════════════════════════════════════════════════════════ --}}
      <div id="signin-panel">
        <h2 class="login-form-title">Sign In</h2>
        <p class="login-form-sub">Welcome back. Enter your credentials to access your account.</p>

        <form id="login-form" novalidate>
          @csrf

          <div class="field-group">
            <label class="field-label" for="login-email">Email Address</label>
            <input type="email" id="login-email" name="email" class="field-input" placeholder="you@email.com" autocomplete="email">
            <span class="field-error" id="err-login-email"></span>
          </div>

          <div class="field-group">
            <label class="field-label" for="pw1">Password</label>
            <div class="pass-toggle">
              <input type="password" class="field-input" placeholder="Enter password" id="pw1" name="password" autocomplete="current-password">
              <span class="pt-eye" onclick="togglePw('pw1',this)"><i class="fas fa-eye"></i></span>
            </div>
            <span class="field-error" id="err-login-password"></span>
          </div>

          <div class="remember-row">
            <label><input type="checkbox" name="remember"> Remember me</label>
            <span class="forgot-link" onclick="showForgotModal()">Forgot password?</span>
          </div>

          <button type="submit" class="btn-gold" id="login-btn" style="width:100%;justify-content:center;padding:15px;font-size:.82rem">
            <span class="btn-label"><i class="fas fa-sign-in-alt"></i> Sign In</span>
            <span class="btn-spinner" style="display:none"><i class="fas fa-circle-notch fa-spin"></i> Signing in…</span>
          </button>
        </form>

        <div class="divider-or"><span>or continue with</span></div>
        <div class="social-login-btn"><i class="fab fa-google" style="color:#EA4335"></i>Continue with Google</div>

        {{-- Resend verification (shown only when needed) --}}
        <div id="resend-wrap" style="display:none;margin-top:14px">
          <p style="font-size:.76rem;color:var(--muted);margin-bottom:8px">Didn't receive the email?</p>
          <button class="btn-outline-sm" id="resend-btn" onclick="resendVerification()">
            <i class="fas fa-paper-plane"></i> Resend Verification Email
          </button>
        </div>
      </div>

      {{-- ════════════════════════════════════════════════════════════════════ --}}
      {{-- Register Panel                                                       --}}
      {{-- ════════════════════════════════════════════════════════════════════ --}}
      <div id="register-panel" style="display:none">
        <h2 class="login-form-title">Create Account</h2>
        <p class="login-form-sub">Join Merit Education Foundation today — for you and your child.</p>

        <form id="register-form" novalidate>
          @csrf

          <div class="row g-3">
            <div class="col-6">
              <div class="field-group">
                <label class="field-label" for="reg-first">First Name</label>
                <input type="text" id="reg-first" name="first_name" class="field-input" placeholder="First name" autocomplete="given-name">
                <span class="field-error" id="err-reg-first_name"></span>
              </div>
            </div>
            <div class="col-6">
              <div class="field-group">
                <label class="field-label" for="reg-last">Last Name</label>
                <input type="text" id="reg-last" name="last_name" class="field-input" placeholder="Last name" autocomplete="family-name">
                <span class="field-error" id="err-reg-last_name"></span>
              </div>
            </div>
          </div>

          <div class="field-group">
            <label class="field-label" for="reg-email">Email Address</label>
            <input type="email" id="reg-email" name="email" class="field-input" placeholder="you@email.com" autocomplete="email">
            <span class="field-error" id="err-reg-email"></span>
          </div>

          <div class="field-group">
            <label class="field-label" for="reg-phone">Phone Number</label>
            <input type="tel" id="reg-phone" name="phone" class="field-input" placeholder="+44 7000 000000" autocomplete="tel">
            <span class="field-error" id="err-reg-phone"></span>
          </div>

          <div class="field-group">
            <label class="field-label" for="pw2">Password</label>
            <div class="pass-toggle">
              <input type="password" class="field-input" placeholder="Create password (min 8 chars)" id="pw2" name="password" autocomplete="new-password">
              <span class="pt-eye" onclick="togglePw('pw2',this)"><i class="fas fa-eye"></i></span>
            </div>
            <span class="field-error" id="err-reg-password"></span>
          </div>

          <div class="field-group">
            <label class="field-label" for="pw3">Confirm Password</label>
            <div class="pass-toggle">
              <input type="password" class="field-input" placeholder="Confirm password" id="pw3" name="password_confirmation" autocomplete="new-password">
              <span class="pt-eye" onclick="togglePw('pw3',this)"><i class="fas fa-eye"></i></span>
            </div>
            <span class="field-error" id="err-reg-password_confirmation"></span>
          </div>

          <div class="field-group" style="margin-bottom:20px">
            <label style="font-size:.78rem;color:var(--muted);display:flex;align-items:flex-start;gap:9px;line-height:1.5;cursor:pointer">
              <input type="checkbox" name="terms" id="reg-terms" style="accent-color:var(--navy);width:15px;height:15px;margin-top:2px;flex-shrink:0">
              I agree to the
              <span style="color:var(--gold);cursor:pointer" onclick="showPage('privacy')">Privacy Policy</span> and Terms &amp; Conditions
            </label>
            <span class="field-error" id="err-reg-terms"></span>
          </div>

          <button type="submit" class="btn-gold" id="register-btn" style="width:100%;justify-content:center;padding:15px;font-size:.82rem">
            <span class="btn-label"><i class="fas fa-user-plus"></i> Create Account</span>
            <span class="btn-spinner" style="display:none"><i class="fas fa-circle-notch fa-spin"></i> Creating account…</span>
          </button>
        </form>
      </div>

      {{-- ── Success Screen (shown after register) ───────────────────────── --}}
      <div id="success-panel" style="display:none;text-align:center;padding:40px 0">
        <div style="font-size:3rem;color:var(--gold);margin-bottom:16px"><i class="fas fa-envelope-open-text"></i></div>
        <h2 class="login-form-title" style="margin-bottom:10px">Check Your Inbox</h2>
        <p class="login-form-sub" id="success-msg">We've sent a verification link to your email address.</p>
        <p style="font-size:.76rem;color:var(--muted);margin-top:18px">
          Didn't receive it?
          <span style="color:var(--gold);cursor:pointer;font-weight:600" onclick="switchLoginTab(document.querySelectorAll('.login-tab')[0],'login')">Sign in to resend</span>
        </p>
      </div>

      <div class="login-back" onclick="showPage('news')"><i class="fas fa-arrow-left"></i>Back to website</div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- Styles                                                                     --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<style>
/* Field errors */
.field-error {
  display: block;
  font-size: .73rem;
  color: #e74c3c;
  margin-top: 5px;
  min-height: 16px;
  transition: all .2s;
}
.field-input.is-invalid {
  border-color: #e74c3c !important;
  box-shadow: 0 0 0 3px rgba(231,76,60,.10) !important;
}
.field-input.is-valid {
  border-color: #27ae60 !important;
}

/* Global alert */
.auth-alert {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 13px 16px;
  border-radius: 10px;
  font-size: .79rem;
  line-height: 1.5;
  margin-bottom: 18px;
  animation: slideDown .3s ease;
}
.auth-alert.is-error   { background:#fdf0ef; border:1px solid #f5c6c1; color:#c0392b; }
.auth-alert.is-success { background:#edfaf3; border:1px solid #a9dfbf; color:#1e8449; }
.auth-alert.is-info    { background:#eaf4fd; border:1px solid #a9cce3; color:#1a5276; }
.auth-alert-icon { flex-shrink:0; margin-top:1px; }
.auth-alert-close { margin-left:auto; background:none; border:none; cursor:pointer; font-size:1.1rem; color:inherit; opacity:.6; padding:0 0 0 6px; }
.auth-alert-close:hover { opacity:1; }
@keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }

/* Spinner button states */
.btn-gold:disabled { opacity:.7; cursor:not-allowed; }

/* Resend / outline btn */
.btn-outline-sm {
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 18px;border-radius:8px;font-size:.77rem;font-weight:600;
  border:1.5px solid var(--gold,#c9a84c);color:var(--gold,#c9a84c);
  background:transparent;cursor:pointer;transition:all .2s;
}
.btn-outline-sm:hover { background:var(--gold,#c9a84c);color:#fff; }
</style>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- JavaScript                                                                 --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<script>
// ── CSRF helper ─────────────────────────────────────────────────────────────
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// Keep track of unverified email for resend
let _unverifiedEmail = '';

// ── Tab switcher ─────────────────────────────────────────────────────────────
function switchLoginTab(btn, tab) {
  document.querySelectorAll('.login-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('signin-panel').style.display   = tab === 'login'    ? '' : 'none';
  document.getElementById('register-panel').style.display = tab === 'register' ? '' : 'none';
  document.getElementById('success-panel').style.display  = 'none';
  closeAlert();
  clearAllErrors();
}

// ── Password toggle ──────────────────────────────────────────────────────────
function togglePw(id, el) {
  const input = document.getElementById(id);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  el.querySelector('i').className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
}

// ── Alert helpers ─────────────────────────────────────────────────────────────
function showAlert(msg, type = 'error') {
  const box = document.getElementById('auth-alert');
  const msgEl = document.getElementById('auth-alert-msg');
  const iconEl = box.querySelector('.auth-alert-icon');
  box.className = 'auth-alert is-' + type;
  msgEl.textContent = msg;
  iconEl.className = 'auth-alert-icon fas ' + {
    error:   'fa-exclamation-circle',
    success: 'fa-check-circle',
    info:    'fa-info-circle',
  }[type];
  box.style.display = 'flex';
  box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
function closeAlert() {
  document.getElementById('auth-alert').style.display = 'none';
}

// ── Field error helpers ──────────────────────────────────────────────────────
function setFieldError(prefix, field, msg) {
  const errEl = document.getElementById('err-' + prefix + '-' + field);
  const inputSel = '[name="' + field + '"]';
  const panel = document.getElementById(prefix === 'login' ? 'signin-panel' : 'register-panel');
  const input = panel ? panel.querySelector(inputSel) : null;
  if (errEl) errEl.textContent = msg || '';
  if (input) {
    input.classList.toggle('is-invalid', !!msg);
    input.classList.toggle('is-valid',   !msg && input.value.trim() !== '');
  }
}
function clearErrors(prefix) {
  document.querySelectorAll('[id^="err-' + prefix + '-"]').forEach(el => el.textContent = '');
  const panel = document.getElementById(prefix === 'login' ? 'signin-panel' : 'register-panel');
  if (panel) panel.querySelectorAll('.field-input').forEach(el => {
    el.classList.remove('is-invalid', 'is-valid');
  });
}
function clearAllErrors() { clearErrors('login'); clearErrors('register'); }

function showErrors(prefix, errors) {
  Object.entries(errors).forEach(([field, msgs]) => {
    setFieldError(prefix, field, Array.isArray(msgs) ? msgs[0] : msgs);
  });
}

// ── Button loading state ──────────────────────────────────────────────────────
function setBtnLoading(btn, loading) {
  btn.disabled = loading;
  btn.querySelector('.btn-label').style.display  = loading ? 'none'  : '';
  btn.querySelector('.btn-spinner').style.display = loading ? ''      : 'none';
}

// ── AJAX helper ───────────────────────────────────────────────────────────────
async function ajaxPost(url, data) {
  const formData = new FormData();
  formData.append('_token', CSRF());
  Object.entries(data).forEach(([k, v]) => formData.append(k, v));

  const res = await fetch(url, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
    body: formData,
  });
  const json = await res.json();
  return { ok: res.ok, status: res.status, data: json };
}

// ══════════════════════════════════════════════════════════════════════════════
// LOGIN FORM SUBMIT
// ══════════════════════════════════════════════════════════════════════════════
document.getElementById('login-form').addEventListener('submit', async function (e) {
  e.preventDefault();
  closeAlert();
  clearErrors('login');
  document.getElementById('resend-wrap').style.display = 'none';

  const btn = document.getElementById('login-btn');
  setBtnLoading(btn, true);

  const email    = document.getElementById('login-email').value.trim();
  const password = document.getElementById('pw1').value;
  const remember = this.querySelector('[name="remember"]').checked;

  try {
    const { ok, status, data } = await ajaxPost('{{ route("ajax.login") }}', {
      email, password, remember: remember ? 1 : 0,
    });

    if (ok && data.success) {
      showAlert('✔ ' + data.message, 'success');
      setTimeout(() => { window.location.href = data.redirect; }, 900);
    } else if (data.errors) {
      showErrors('login', data.errors);
      // Unverified user — show resend button
      if (data.unverified) {
        _unverifiedEmail = data.email || email;
        document.getElementById('resend-wrap').style.display = '';
      }
    } else {
      showAlert(data.message || 'Something went wrong. Please try again.', 'error');
    }
  } catch (err) {
    showAlert('Network error. Please check your connection and try again.', 'error');
  } finally {
    setBtnLoading(btn, false);
  }
});

// ══════════════════════════════════════════════════════════════════════════════
// REGISTER FORM SUBMIT
// ══════════════════════════════════════════════════════════════════════════════
document.getElementById('register-form').addEventListener('submit', async function (e) {
  e.preventDefault();
  closeAlert();
  clearErrors('reg');

  const btn = document.getElementById('register-btn');
  setBtnLoading(btn, true);

  const payload = {
    first_name:            document.getElementById('reg-first').value.trim(),
    last_name:             document.getElementById('reg-last').value.trim(),
    email:                 document.getElementById('reg-email').value.trim(),
    phone:                 document.getElementById('reg-phone').value.trim(),
    password:              document.getElementById('pw2').value,
    password_confirmation: document.getElementById('pw3').value,
    terms:                 document.getElementById('reg-terms').checked ? '1' : '0',
  };

  try {
    const { ok, data } = await ajaxPost('{{ route("ajax.register") }}', payload);

    if (ok && data.success) {
      // Hide form, show success screen
      document.getElementById('register-panel').style.display = 'none';
      document.getElementById('success-panel').style.display  = '';
      document.getElementById('success-msg').textContent = data.message;
      _unverifiedEmail = payload.email;
    } else if (data.errors) {
      showErrors('reg', data.errors);
      showAlert('Please fix the errors below and try again.', 'error');
    } else {
      showAlert(data.message || 'Something went wrong. Please try again.', 'error');
    }
  } catch (err) {
    showAlert('Network error. Please check your connection and try again.', 'error');
  } finally {
    setBtnLoading(btn, false);
  }
});

// ══════════════════════════════════════════════════════════════════════════════
// RESEND VERIFICATION EMAIL
// ══════════════════════════════════════════════════════════════════════════════
async function resendVerification() {
  const btn = document.getElementById('resend-btn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Sending…';
  closeAlert();

  const email = _unverifiedEmail || document.getElementById('login-email').value.trim();

  try {
    const { ok, data } = await ajaxPost('{{ route("ajax.resend-verification") }}', { email });
    if (ok && data.success) {
      showAlert(data.message, 'success');
    } else if (data.errors) {
      showErrors('login', data.errors);
    } else {
      showAlert(data.message || 'Could not resend email. Please try again.', 'error');
    }
  } catch (err) {
    showAlert('Network error. Please try again.', 'error');
  } finally {
    // Cooldown 30s
    let seconds = 30;
    const tick = setInterval(() => {
      seconds--;
      btn.innerHTML = `<i class="fas fa-clock"></i> Resend in ${seconds}s`;
      if (seconds <= 0) {
        clearInterval(tick);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Resend Verification Email';
      }
    }, 1000);
  }
}
</script>

@endsection
