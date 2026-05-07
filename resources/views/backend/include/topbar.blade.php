  <header class="topbar" id="topbar">
    <div class="topbar-left">
      <button class="tb-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <div class="tb-breadcrumb">
        <span>Merit Admin</span>
        <i class="fas fa-chevron-right" style="font-size:.5rem"></i>
        <span class="bc-cur" id="breadcrumb">Dashboard</span>
      </div>
    </div>
    <div class="topbar-right">
      <div class="tb-search d-none d-md-flex">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search anything...">
      </div>
      <div class="tb-icon-btn" onclick="toggleNotif()"><i class="fas fa-bell"></i><div class="tb-notif-dot"></div></div>
      <div class="tb-icon-btn" id="dark-btn" onclick="toggleDark()" title="Toggle theme"><i class="fas fa-moon"></i></div>
      <div class="tb-icon-btn" onclick="showView('settings',null)"><i class="fas fa-cog"></i></div>
      <div class="tb-profile" onclick="showView('settings',null)">
        <div class="tb-av">SA</div>
        <div class="d-none d-lg-block"><div class="tb-profile-name">Super Admin</div><div class="tb-profile-role">Administrator</div></div>
        <i class="fas fa-chevron-down" style="font-size:.6rem;color:var(--muted)"></i>
      </div>
    </div>
  </header>