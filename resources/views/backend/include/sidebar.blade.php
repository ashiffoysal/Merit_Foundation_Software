<aside class="sidebar" id="sidebar">
    <div class="sidebar-top">
      <div class="sb-brand">
        <div class="sb-brand-ic"><i class="fas fa-book-open"></i></div>
        <div>
          <div class="sb-brand-text">MERIT</div>
          <span class="sb-brand-sub">Admin Portal</span>
        </div>
      </div>
    </div>
    <div class="sidebar-body">
      <div class="sb-section">Main</div>
      <div class="sb-item active" onclick="showView('dashboard',this)"><i class="fas fa-th-large"></i><span>Dashboard</span></div>
      <div class="sb-section">People</div>
      <div class="sb-item" onclick="showView('students',this)"><i class="fas fa-user-graduate"></i><span>Students</span><span class="sb-badge">124</span></div>
      <div class="sb-item" onclick="showView('tutors',this)"><i class="fas fa-chalkboard-teacher"></i><span>Tutors</span></div>
      <div class="sb-item" onclick="showView('donors',this)"><i class="fas fa-hand-holding-heart"></i><span>Donors</span></div>
      <div class="sb-item" onclick="showView('users',this)"><i class="fas fa-users"></i><span>All Users</span></div>
      <div class="sb-section">Operations</div>
      <div class="sb-item" onclick="showView('lessons',this)"><i class="fas fa-graduation-cap"></i><span>Lessons</span><span class="sb-badge">8</span></div>
      <div class="sb-item" onclick="showView('donations',this)"><i class="fas fa-heart"></i><span>Donations</span></div>
      <div class="sb-item" onclick="showView('bookings',this)"><i class="fas fa-calendar-check"></i><span>Bookings</span><span class="sb-badge">3</span></div>
      <div class="sb-item" onclick="showView('reports',this)"><i class="fas fa-chart-bar"></i><span>Reports</span></div>
      <div class="sb-section">Content</div>
      <div class="sb-item" onclick="showView('news',this)"><i class="fas fa-newspaper"></i><span>News & Articles</span></div>
      <div class="sb-item" onclick="showView('safeguarding',this)"><i class="fas fa-shield-alt"></i><span>Safeguarding</span></div>
      <div class="sb-item" onclick="showView('messages',this)"><i class="fas fa-envelope"></i><span>Messages</span><span class="sb-badge">5</span></div>
      <div class="sb-section">System</div>
      <div class="sb-item" onclick="showView('admins',this)"><i class="fas fa-user-shield"></i><span>Admin Users</span></div>
      <div class="sb-item" onclick="showView('settings',this)"><i class="fas fa-cog"></i><span>Settings</span></div>
    </div>
    <div class="sidebar-footer">
      <div class="sb-admin-row">
        <div class="sb-admin-av">SA</div>
        <div><div class="sb-admin-name">Super Admin</div><div class="sb-admin-role">admin@meriteducation.org</div></div>
      </div>
      <div class="sb-logout-btn" onclick="doLogout()"><i class="fas fa-sign-out-alt"></i><span class="sb-logout-text">Sign Out</span></div>
    </div>
  </aside>