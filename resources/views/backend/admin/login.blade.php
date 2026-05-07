<div id="login-screen" class="active">
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

    <div class="login-role-selector">
      <button class="role-btn active" onclick="setRole(this,'Super Admin')"><i class="fas fa-crown me-1"></i>Super Admin</button>
      <button class="role-btn" onclick="setRole(this,'Manager')"><i class="fas fa-user-tie me-1"></i>Manager</button>
      <button class="role-btn" onclick="setRole(this,'Staff')"><i class="fas fa-user me-1"></i>Staff</button>
    </div>

    <div class="lf-group">
      <label class="lf-label">Email Address</label>
      <input type="email" class="lf-input" placeholder="admin@meriteducation.org" value="admin@meriteducation.org">
    </div>
    <div class="lf-group">
      <label class="lf-label">Password</label>
      <input type="password" class="lf-input" placeholder="••••••••••••" id="lpw" value="admin123">
      <span class="lf-eye" onclick="toggleLPw()"><i class="fas fa-eye" id="lpe-icon"></i></span>
    </div>
    <div class="login-remember">
      <label><input type="checkbox" checked>Remember this device</label>
      <span class="login-forgot">Forgot password?</span>
    </div>
    <button class="btn-login" onclick="doLogin()">
      <i class="fas fa-sign-in-alt"></i>Access Admin Panel
    </button>
    <div class="login-security"><i class="fas fa-shield-alt"></i>256-bit SSL encrypted · UK GDPR compliant</div>
  </div>
</div>