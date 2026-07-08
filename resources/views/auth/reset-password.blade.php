{{-- resources/views/auth/reset-password.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Reset Password - Merit Education Foundation')
@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@400;500;600&display=swap');
* { box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: #FAFAF7; }

.rp-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 32px 16px; position: relative; overflow: hidden; }
.rp-orb1 { position: fixed; width: 320px; height: 320px; background: radial-gradient(circle, #E8F4ED 0%, transparent 70%); top: -80px; left: -80px; border-radius: 50%; pointer-events: none; }
.rp-orb2 { position: fixed; width: 260px; height: 260px; background: radial-gradient(circle, #fffbf0 0%, transparent 70%); bottom: -60px; right: -60px; border-radius: 50%; pointer-events: none; }

.rp-card { background: #fff; border: 1px solid #e8e4db; border-radius: 20px; box-shadow: 0 4px 32px rgba(26,58,42,0.08); width: 100%; max-width: 460px; overflow: hidden; position: relative; z-index: 1; }
.rp-top { background: linear-gradient(135deg, #1a3a2a 0%, #2a5a3a 100%); padding: 32px 36px 28px; text-align: center; }
.rp-logo-ring { width: 64px; height: 64px; background: rgba(212,168,75,0.15); border: 2px solid rgba(212,168,75,0.35); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.rp-logo-inner { width: 44px; height: 44px; background: #d4a84b; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.rp-h1 { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 700; color: #fff; margin-bottom: 6px; }
.rp-sub { font-size: 13px; color: #a0c8b0; line-height: 1.6; max-width: 320px; margin: 0 auto; }
.rp-divider { display: flex; align-items: center; gap: 8px; justify-content: center; margin-top: 18px; }
.rp-div-line { width: 40px; height: 1px; background: rgba(212,168,75,0.4); }
.rp-div-diamond { width: 6px; height: 6px; background: #d4a84b; transform: rotate(45deg); }

.rp-body { padding: 32px 36px 28px; }

.alert-success { background: #E8F4ED; color: #1a5a2a; border: 1px solid #b0dcc0; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; margin-bottom: 20px; display: none; align-items: center; gap: 8px; }
.alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; margin-bottom: 20px; display: none; align-items: center; gap: 8px; }
.alert-success.show, .alert-error.show { display: flex; }

.rp-label { display: block; font-size: 12px; font-weight: 600; color: #5a5a4a; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 7px; }
.rp-input-wrap { position: relative; margin-bottom: 18px; }
.rp-input { width: 100%; padding: 12px 44px 12px 16px; border: 1.5px solid #e8e4db; border-radius: 10px; font-size: 14px; font-family: 'DM Sans', sans-serif; color: #1a2a18; background: #FAFAF7; transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
.rp-input:focus { border-color: #1a3a2a; box-shadow: 0 0 0 3px rgba(26,58,42,0.08); background: #fff; }
.rp-input.is-error { border-color: #f87171; }
.rp-input-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #a0a090; font-size: 16px; pointer-events: none; }
.rp-toggle { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #a0a090; font-size: 16px; cursor: pointer; background: none; border: none; padding: 0; }

.rp-strength { display: flex; gap: 4px; margin-top: 8px; margin-bottom: 4px; }
.rp-sb { flex: 1; height: 3px; border-radius: 2px; background: #e8e4db; transition: background 0.3s; }
.rp-sb.weak { background: #f87171; } .rp-sb.fair { background: #f59e0b; } .rp-sb.good { background: #34d399; } .rp-sb.strong { background: #1a3a2a; }
.rp-strength-label { font-size: 11px; font-weight: 500; color: #7a7a6a; margin-bottom: 16px; min-height: 14px; }

.rp-btn { width: 100%; padding: 14px; background: #1a3a2a; color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s; margin-bottom: 16px; }
.rp-btn:hover { background: #1f4a34; } .rp-btn:disabled { background: #7aaa8a; cursor: not-allowed; }
.rp-spinner { width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; display: none; animation: spin 0.7s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.rp-links { display: flex; justify-content: center; gap: 20px; }
.rp-link { font-size: 13px; color: #7a7a6a; font-weight: 500; cursor: pointer; text-decoration: none; }
.rp-link:hover { color: #1a3a2a; }
.rp-link-gold { color: #d4a84b; } .rp-link-gold:hover { color: #b8862e; }

.rp-foot { border-top: 1px solid #f0ede6; padding: 14px 36px; display: flex; align-items: center; justify-content: space-between; background: #FAFAF7; }
.rp-trust { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #9a9a8a; font-weight: 500; }
</style>

<div class="rp-wrap">
  <div class="rp-orb1"></div>
  <div class="rp-orb2"></div>
  <div class="rp-card">

    {{-- Header --}}
    <div class="rp-top">
      <div class="rp-logo-ring">
        <div class="rp-logo-inner">
          <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
            <path d="M11 2C7.5 2 4.5 5 4.5 9c0 3 1.5 5.5 3.5 6.5V18h6v-2.5c2-1 3.5-3.5 3.5-6.5C17.5 5 14.5 2 11 2z" fill="#fff" opacity="0.9"/>
            <rect x="8" y="18" width="6" height="2" rx="1" fill="rgba(255,255,255,0.5)"/>
          </svg>
        </div>
      </div>
      <h1 class="rp-h1">Reset Password</h1>
      <p class="rp-sub">Create a new secure password for your Merit Education account</p>
      <div class="rp-divider">
        <div class="rp-div-line"></div>
        <div class="rp-div-diamond"></div>
        <div class="rp-div-line"></div>
      </div>
    </div>

    {{-- Body --}}
    <div class="rp-body">
      <div class="alert-success" id="alert-success">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#1a5a2a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span id="success-msg">Password reset successfully! Redirecting…</span>
      </div>
      <div class="alert-error" id="alert-error">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#991b1b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span id="error-msg">Something went wrong.</span>
      </div>

      <form id="reset-form" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <label class="rp-label" for="email">Email Address</label>
        <div class="rp-input-wrap">
          <input class="rp-input" type="email" id="email" name="email"
            value="{{ old('email', $request->email) }}"
            placeholder="you@example.com" autocomplete="email" required>
          <span class="rp-input-icon">✉</span>
        </div>

        <label class="rp-label" for="password">New Password</label>
        <div class="rp-input-wrap">
          <input class="rp-input" type="password" id="password" name="password"
            placeholder="Min. 8 characters" autocomplete="new-password" required>
          <button type="button" class="rp-toggle" onclick="togglePw('password','eye1')" aria-label="Show password">
            <span id="eye1">👁</span>
          </button>
        </div>
        <div class="rp-strength">
          <div class="rp-sb" id="sb1"></div><div class="rp-sb" id="sb2"></div>
          <div class="rp-sb" id="sb3"></div><div class="rp-sb" id="sb4"></div>
        </div>
        <div class="rp-strength-label" id="str-label"></div>

        <label class="rp-label" for="password_confirmation">Confirm New Password</label>
        <div class="rp-input-wrap">
          <input class="rp-input" type="password" id="password_confirmation"
            name="password_confirmation" placeholder="Re-enter password" required>
          <button type="button" class="rp-toggle" onclick="togglePw('password_confirmation','eye2')" aria-label="Show password">
            <span id="eye2">👁</span>
          </button>
        </div>

        <button class="rp-btn" type="submit" id="submit-btn">
          <div class="rp-spinner" id="spinner"></div>
          <span id="btn-text">Reset Password</span>
        </button>

        <div class="rp-links">
          <a href="{{ route('login') }}" class="rp-link">← Back to Login</a>
          <a href="#" class="rp-link rp-link-gold">Need help?</a>
        </div>
      </form>
    </div>

    <div class="rp-foot">
      <div class="rp-trust">🛡 Safeguarding First</div>
      <div class="rp-trust">🔒 256-bit Encrypted</div>
      <div class="rp-trust" style="color:#d4a84b">✓ UK Registered</div>
    </div>

  </div>
</div>

<script>
function togglePw(id, eyeId) {
  var inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  document.getElementById(eyeId).textContent = inp.type === 'password' ? '👁' : '🙈';
}

document.getElementById('password').addEventListener('input', function() {
  var v = this.value, s = 0;
  if (v.length >= 8) s++;
  if (/[A-Z]/.test(v)) s++;
  if (/[0-9]/.test(v)) s++;
  if (/[^A-Za-z0-9]/.test(v)) s++;
  if (!v.length) s = 0;
  var cls = ['','weak','fair','good','strong'][s];
  var labels = ['','Weak','Fair','Good','Strong'];
  [1,2,3,4].forEach(function(i) {
    var el = document.getElementById('sb'+i);
    el.className = 'rp-sb';
    if (s >= i && v.length) el.classList.add(cls);
  });
  document.getElementById('str-label').textContent = v.length ? labels[s] : '';
});

document.getElementById('reset-form').addEventListener('submit', function(e) {
  e.preventDefault();
  hideAlerts();

  var email = document.getElementById('email').value.trim();
  var pw = document.getElementById('password').value;
  var pwc = document.getElementById('password_confirmation').value;

  if (!email || !pw || !pwc) return showError('Please fill in all fields.');
  if (pw.length < 8) return showError('Password must be at least 8 characters.');
  if (pw !== pwc) return showError('Passwords do not match.');

  setLoading(true);

  var form = this;
  fetch('{{ route("password.store") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      token: document.querySelector('input[name="token"]').value,
      email: email,
      password: pw,
      password_confirmation: pwc
    })
  })
  .then(function(r) { return r.json().then(function(d) { return { status: r.status, data: d }; }); })
  .then(function(r) {
    setLoading(false);
    if (r.status === 200) {
      showSuccess('Password reset! Redirecting to login…');
      setTimeout(function() { window.location.href = '{{ route("login") }}'; }, 2000);
    } else {
      var msg = r.data && r.data.errors
        ? Object.values(r.data.errors).flat()[0]
        : (r.data.message || 'Reset failed. Please try again.');
      showError(msg);
    }
  })
  .catch(function() { setLoading(false); showError('Network error. Please try again.'); });
});

function setLoading(on) {
  var btn = document.getElementById('submit-btn');
  btn.disabled = on;
  document.getElementById('spinner').style.display = on ? 'block' : 'none';
  document.getElementById('btn-text').textContent = on ? 'Resetting…' : 'Reset Password';
}
function showSuccess(msg) {
  var el = document.getElementById('alert-success');
  document.getElementById('success-msg').textContent = msg;
  el.classList.add('show');
}
function showError(msg) {
  var el = document.getElementById('alert-error');
  document.getElementById('error-msg').textContent = msg;
  el.classList.add('show');
}
function hideAlerts() {
  document.getElementById('alert-success').classList.remove('show');
  document.getElementById('alert-error').classList.remove('show');
  document.querySelectorAll('.rp-input').forEach(function(i){ i.classList.remove('is-error'); });
}
</script>
@endsection