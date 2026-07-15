<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Merit Admin — Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet"/>
 <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
:root{
  --s50:#07102A; --s100:#0B1940; --s200:#0F2157; --s300:#152C73;
  --gold:#C9A84C; --gold2:#E2C56A; --goldp:rgba(201,168,76,.12);
  --teal:#0C7A70; --red:#E53935;
  --bg:#F0F2F8; --card:#FFFFFF; --border:#E2E6F0;
  --txt:#0F1A3E; --muted:#6B7399;
  --r:12px;
}
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
body{font-family:'DM Sans',sans-serif;background:var(--s50);overflow:hidden}

/* ── Login Screen */
#login-screen{
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  position:relative;
  overflow:hidden;
}
.login-bg-mesh{
  position:absolute;inset:0;
  background:
    radial-gradient(ellipse 70% 60% at 20% 30%,rgba(21,44,115,.7),transparent 60%),
    radial-gradient(ellipse 50% 50% at 80% 70%,rgba(12,122,112,.2),transparent 55%),
    radial-gradient(ellipse 40% 40% at 70% 10%,rgba(201,168,76,.06),transparent);
}
.login-grid{
  position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
                   linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
  background-size:48px 48px;
}
.login-orb{position:absolute;border-radius:50%;filter:blur(80px);animation:orb 14s ease-in-out infinite}
.login-orb-1{width:400px;height:400px;background:rgba(201,168,76,.055);right:-100px;top:-100px}
.login-orb-2{width:300px;height:300px;background:rgba(12,122,112,.08);left:-60px;bottom:5%;animation-delay:-6s}
@keyframes orb{0%,100%{transform:translate(0,0)}50%{transform:translate(20px,-15px)}}

.login-card{
  position:relative;z-index:2;
  width:100%;max-width:460px;
  background:rgba(255,255,255,.04);
  border:1px solid rgba(255,255,255,.08);
  border-radius:24px;
  padding:52px 48px;
  backdrop-filter:blur(24px);
  box-shadow:0 32px 80px rgba(0,0,0,.3);
}
.login-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(to right,transparent,var(--gold),transparent);
  border-radius:24px 24px 0 0;
}
.login-logo{display:flex;align-items:center;gap:14px;margin-bottom:40px;justify-content:center}
.login-logo-ic{
  width:50px;height:50px;border-radius:14px;
  background:rgba(201,168,76,.12);border:1.5px solid rgba(201,168,76,.35);
  display:flex;align-items:center;justify-content:center;
}
.login-logo-ic i{color:var(--gold);font-size:1.1rem}
.login-logo-name{font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:#fff;letter-spacing:2px}
.login-logo-sub{font-size:.55rem;letter-spacing:2.5px;color:var(--gold);text-transform:uppercase;display:block;margin-top:1px}
.login-title{font-family:'Syne',sans-serif;font-size:1.7rem;font-weight:700;color:#fff;text-align:center;margin-bottom:6px}
.login-sub{text-align:center;font-size:.82rem;color:rgba(255,255,255,.38);margin-bottom:32px}

/* Fields */
.lf-group{margin-bottom:20px;position:relative}
.lf-label{font-size:.65rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:8px;display:block}
.lf-input{
  width:100%;padding:13px 16px;
  background:rgba(255,255,255,.07);border:1.5px solid rgba(255,255,255,.1);
  border-radius:10px;font-family:'DM Sans',sans-serif;font-size:.9rem;
  color:#fff;outline:none;transition:.3s;
}
.lf-input:focus{border-color:var(--gold);background:rgba(255,255,255,.1);box-shadow:0 0 0 4px rgba(201,168,76,.12)}
.lf-input::placeholder{color:rgba(255,255,255,.22)}
.lf-input.is-invalid{border-color:var(--red)!important;box-shadow:0 0 0 4px rgba(229,57,53,.12)!important}
.lf-input.is-valid{border-color:#2E7D32!important;}
.field-error{font-size:.68rem;color:#f87171;margin-top:6px;display:none;padding-left:2px}
.field-error.show{display:block}
.lf-eye{position:absolute;right:14px;top:38px;color:rgba(255,255,255,.3);cursor:pointer;font-size:.85rem;transition:.3s}
.lf-eye:hover{color:var(--gold)}

/* Alert banner */
.login-alert{
  padding:11px 14px;border-radius:10px;
  font-size:.78rem;display:none;align-items:center;gap:10px;
  margin-bottom:18px;animation:fadeIn .3s ease;
}
.login-alert.show{display:flex}
.login-alert.error{background:rgba(229,57,53,.12);border:1px solid rgba(229,57,53,.3);color:#fca5a5}
.login-alert.success{background:rgba(46,125,50,.12);border:1px solid rgba(46,125,50,.3);color:#86efac}
@keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:none}}

.login-remember{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
.login-remember label{font-size:.78rem;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px;cursor:pointer}
.login-remember input[type=checkbox]{accent-color:var(--gold);width:14px;height:14px}
.login-forgot{font-size:.75rem;color:var(--gold);cursor:pointer;transition:.3s;font-weight:600}
.login-forgot:hover{color:var(--gold2)}

/* Button */
.btn-login{
  width:100%;padding:14px;border:none;border-radius:10px;
  background:var(--gold);color:var(--s50);
  font-family:'Syne',sans-serif;font-size:.85rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;
  cursor:pointer;transition:all .3s;box-shadow:0 6px 24px rgba(201,168,76,.3);
  display:flex;align-items:center;justify-content:center;gap:10px;
  position:relative;overflow:hidden;
}
.btn-login:hover:not(:disabled){background:var(--gold2);transform:translateY(-2px);box-shadow:0 12px 32px rgba(201,168,76,.4)}
.btn-login:disabled{opacity:.65;cursor:not-allowed;transform:none}
.btn-login .btn-spinner{display:none;width:16px;height:16px;border:2px solid rgba(7,16,42,.3);border-top-color:var(--s50);border-radius:50%;animation:spin .6s linear infinite}
.btn-login.loading .btn-spinner{display:block}
.btn-login.loading .btn-text{opacity:.7}
@keyframes spin{to{transform:rotate(360deg)}}

.login-security{text-align:center;margin-top:20px;font-size:.7rem;color:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;gap:7px}

/* Redirect overlay */
#redirect-overlay{
  position:fixed;inset:0;background:var(--s50);z-index:9999;
  display:none;flex-direction:column;align-items:center;justify-content:center;
  gap:20px;
}
#redirect-overlay.show{display:flex;animation:fadeIn .4s ease}
.ro-brand{font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:800;color:#fff;letter-spacing:3px}
.ro-msg{font-size:.8rem;color:rgba(255,255,255,.4);margin-top:-12px}
.ro-loader{width:160px;height:2px;background:rgba(255,255,255,.1);border-radius:2px;overflow:hidden}
.ro-bar{height:100%;width:0;background:linear-gradient(to right,var(--gold),var(--gold2));border-radius:2px;animation:loadBar 1.4s ease forwards}
@keyframes loadBar{0%{width:0}60%{width:75%}100%{width:100%}}
</style>
</head>
<body>

<!-- ── Login Screen ── -->
<div id="login-screen">
  <div class="login-bg-mesh"></div>
  <div class="login-grid"></div>
  <div class="login-orb login-orb-1"></div>
  <div class="login-orb login-orb-2"></div>

  <div class="login-card">
    <div class="login-logo">
      <div class="login-logo-ic"><i class="fas fa-book-open"></i></div>
      <div>
        <div class="login-logo-name">MERIT</div>
        <span class="login-logo-sub">Admin Portal</span>
      </div>
    </div>

    <h2 class="login-title">Welcome Back</h2>
    <p class="login-sub">Sign in to the Merit Education administration panel</p>

    <!-- Server / AJAX error alert -->
    <div class="login-alert error" id="login-alert">
      <i class="fas fa-exclamation-circle"></i>
      <span id="login-alert-msg">Invalid credentials. Please try again.</span>
    </div>

    <form id="login-form" novalidate>
      <!-- Email -->
      <div class="lf-group">
        <label class="lf-label" for="email">Email Address</label>
        <input type="email" id="email" name="email" class="lf-input"
               placeholder="admin@meriteducation.org" autocomplete="username">
        <div class="field-error" id="email-error"></div>
      </div>

      <!-- Password -->
      <div class="lf-group">
        <label class="lf-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="lf-input"
               placeholder="••••••••••••" autocomplete="current-password">
        <span class="lf-eye" onclick="togglePw()">
          <i class="fas fa-eye" id="pw-icon"></i>
        </span>
        <div class="field-error" id="password-error"></div>
      </div>

      <div class="login-remember">
        <label><input type="checkbox" id="remember" name="remember" checked> Remember this device</label>
        {{-- <span class="login-forgot">Forgot password?</span> --}}
      </div>

      <button type="submit" class="btn-login" id="login-btn">
        <div class="btn-spinner"></div>
        <span class="btn-text"><i class="fas fa-sign-in-alt"></i> Access Admin Panel</span>
      </button>
    </form>

    <div class="login-security"><i class="fas fa-shield-alt"></i>Activity is monitored and logged</div>
  </div>
</div>

<!-- ── Redirect Overlay ── -->
<div id="redirect-overlay">
  <div class="ro-brand">MERIT</div>
  <div class="ro-msg">Loading dashboard…</div>
  <div class="ro-loader"><div class="ro-bar"></div></div>
</div>

<script>
/* ══════════════════════════════════
   CONFIG  — adjust these as needed
══════════════════════════════════ */
const LOGIN_URL      = 'admin/login';       // POST endpoint
const DASHBOARD_URL  = 'admin/dashboard';   // redirect target after success
const CSRF_TOKEN     = document.querySelector('meta[name="csrf-token"]')
                         ?.getAttribute('content') ?? '';

/* ══════════════════════════════════
   UTILS
══════════════════════════════════ */
const $  = id => document.getElementById(id);
const el = id => document.getElementById(id);

function showFieldError(fieldId, errorId, msg) {
  el(fieldId).classList.add('is-invalid');
  el(fieldId).classList.remove('is-valid');
  el(errorId).textContent = msg;
  el(errorId).classList.add('show');
}
function clearFieldError(fieldId, errorId) {
  el(fieldId).classList.remove('is-invalid');
  el(errorId).classList.remove('show');
}
function markValid(fieldId) {
  el(fieldId).classList.add('is-valid');
  el(fieldId).classList.remove('is-invalid');
}

function showAlert(msg, type = 'error') {
  const a = el('login-alert');
  el('login-alert-msg').textContent = msg;
  a.className = `login-alert ${type} show`;
}
function hideAlert() {
  el('login-alert').classList.remove('show');
}

function setLoading(on) {
  const btn = el('login-btn');
  btn.disabled = on;
  btn.classList.toggle('loading', on);
}

function togglePw() {
  const inp = el('password');
  const ic  = el('pw-icon');
  const isText = inp.type === 'text';
  inp.type = isText ? 'password' : 'text';
  ic.className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
}

/* ══════════════════════════════════
   VALIDATION
══════════════════════════════════ */
function validate() {
  let valid = true;

  const email    = el('email').value.trim();
  const password = el('password').value;

  // Email
  clearFieldError('email', 'email-error');
  if (!email) {
    showFieldError('email', 'email-error', 'Email address is required.');
    valid = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showFieldError('email', 'email-error', 'Please enter a valid email address.');
    valid = false;
  } else {
    markValid('email');
  }

  // Password
  clearFieldError('password', 'password-error');
  if (!password) {
    showFieldError('password', 'password-error', 'Password is required.');
    valid = false;
  } else if (password.length < 6) {
    showFieldError('password', 'password-error', 'Password must be at least 6 characters.');
    valid = false;
  } else {
    markValid('password');
  }

  return valid;
}

/* ══════════════════════════════════
   INLINE VALIDATION (on blur)
══════════════════════════════════ */
el('email').addEventListener('blur', () => {
  const v = el('email').value.trim();
  clearFieldError('email', 'email-error');
  if (!v) {
    showFieldError('email', 'email-error', 'Email address is required.');
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
    showFieldError('email', 'email-error', 'Please enter a valid email address.');
  } else {
    markValid('email');
  }
});

el('password').addEventListener('blur', () => {
  const v = el('password').value;
  clearFieldError('password', 'password-error');
  if (!v) {
    showFieldError('password', 'password-error', 'Password is required.');
  } else if (v.length < 6) {
    showFieldError('password', 'password-error', 'Password must be at least 6 characters.');
  } else {
    markValid('password');
  }
});

/* ══════════════════════════════════
   AJAX LOGIN
══════════════════════════════════ */
el('login-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  hideAlert();

  if (!validate()) return;

  setLoading(true);

  const payload = {
    email:    el('email').value.trim(),
    password: el('password').value,
    remember: el('remember').checked,
  };

  try {
    const res = await fetch(LOGIN_URL, {
      method:  'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept':        'application/json',
        // Include CSRF token if using Laravel / similar framework
        ...(CSRF_TOKEN ? { 'X-CSRF-TOKEN': CSRF_TOKEN } : {}),
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload),
    });

    const data = await res.json().catch(() => ({}));

    if (res.ok && (data.success !== false)) {
      /* ── SUCCESS: show redirect overlay, then navigate ── */
      showRedirect();
      setTimeout(() => {
        window.location.href = data.redirect ?? DASHBOARD_URL;
      }, 1500);
    } else {
      /* ── SERVER-SIDE ERROR ── */
      setLoading(false);
      const msg = data.message
               ?? data.error
               ?? 'Invalid credentials. Please try again.';
      showAlert(msg, 'error');

      // Highlight which fields the server flagged (Laravel-style errors object)
      if (data.errors) {
        if (data.errors.email)
          showFieldError('email', 'email-error', data.errors.email[0] ?? data.errors.email);
        if (data.errors.password)
          showFieldError('password', 'password-error', data.errors.password[0] ?? data.errors.password);
      }
    }

  } catch (err) {
    setLoading(false);
    showAlert('Network error — please check your connection and try again.', 'error');
    console.error('Login error:', err);
  }
});

/* ══════════════════════════════════
   REDIRECT OVERLAY
══════════════════════════════════ */
function showRedirect() {
  setLoading(false);
  el('redirect-overlay').classList.add('show');
}
</script>
</body>
</html>