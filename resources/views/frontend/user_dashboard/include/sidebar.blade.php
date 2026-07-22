 <aside class="dash-sidebar" id="dash-sidebar">
      <div class="dash-sidebar-inner">
        <div class="dash-user-block">
          <div class="dash-av-wrap">
            <div class="dash-av" id="dash-av-main">A</div>
            <div class="dash-av-edit" onclick="switchDash('profile')"><i class="fas fa-pencil-alt"></i></div>
          </div>
          <div class="dash-user-name">{{ Auth::user()->name }}</div>
          <div class="dash-user-email">{{ Auth::user()->email }}</div>
          {{-- <div class="dash-user-badge"><i class="fas fa-star" style="font-size:.55rem"></i>Active Sponsor</div> --}}
        </div>
        <div class="dash-nav-section">Main</div>
        <div class="dash-nav-item active" onclick="switchDash('overview')"><i class="fas fa-th-large"></i>Dashboard</div>
        <div class="dash-nav-item" onclick="switchDash('profile')"><i class="fas fa-user"></i>My Profile</div>
        
        <div class="dash-nav-item" onclick="switchDash('documents')"><i class="fas fa-file-alt"></i>My Plans</div>
        <div class="dash-nav-item" href="{{ url('/invoice') }}"><i class="fas fa-cog"></i>Invoice</div>
        <div class="dash-logout">
          <a class="dash-logout-btn" href="{{ url('userlogout') }}"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
        </div>
      </div>
    </aside>