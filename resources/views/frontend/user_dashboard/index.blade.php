@extends('layouts.frontend')
@section('title', 'Privacy Policy - Merit Education Foundation')
@section('content')
<!-- jQuery (load BEFORE your script) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

{{-- ══════════════════════════════════════════════
     MOBILE RESPONSIVE STYLES
     (Add these to your main stylesheet, or keep here.
      Uses the SAME CSS variables your markup already
      relies on: --navy, --gold, --teal, --cream,
      --border, --muted, --red, --amber)
════════════════════════════════════════════════ --}}
<style>
  /* ══════════════════════════════════════════════
     DASHBOARD MOBILE RESPONSIVE FIX
     Root cause: .dashboard-layout / .dash-sidebar /
     .dash-main in style.css have NO media queries —
     the sidebar is permanently position:fixed;width:270px
     and .dash-main is permanently margin-left:270px.
     This patch collapses the sidebar into an off-canvas
     drawer below 991px (matches your existing site
     breakpoint used by .nav-toggle) and — critically —
     resets .dash-main's margin-left, which the last
     patch missed.
  ════════════════════════════════════════════════ */

  /* Hamburger toggle button — fixed, top-left, mobile only */
  .dash-menu-btn {
    display: none;
    position: fixed;
    top: 82px;
    left: 16px;
    z-index: 900;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    background: var(--navy);
    color: var(--gold);
    border: 1.5px solid var(--gold);
    border-radius: 10px;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: var(--shadow-md);
  }

  /* Overlay behind the drawer */
  .dash-sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,20,20,.55);
    z-index: 799;
  }
  .dash-sidebar-overlay.active { display: block; }

  /* ================= TABLET & MOBILE (matches site breakpoint) ================= */
  @media (max-width: 991px) {

    .dash-menu-btn { display: flex; }

    .dashboard-layout {
      display: block !important;
    }

    /* Sidebar becomes an off-canvas drawer, hidden by default */
    .dash-sidebar {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      height: 100vh !important;
      width: 270px !important;
      max-width: 82vw;
      z-index: 900;
      transform: translateX(-100%);
      transition: transform .32s cubic-bezier(.4,0,.2,1);
      box-shadow: 8px 0 32px rgba(0,0,0,.3);
    }
    .dash-sidebar.mobile-open {
      transform: translateX(0);
    }

    /* THE FIX: main content must reclaim the 270px the sidebar
       normally reserves, or everything shifts off-screen */
    .dash-main {
      margin-left: 0 !important;
      width: 100% !important;
      padding: 76px 18px 32px !important;
      min-height: auto;
    }

    /* Header row: stack title/breadcrumb above the action button */
    .dash-main > div[style*="justify-content:space-between"] {
      flex-direction: column;
      align-items: flex-start !important;
      gap: 14px;
      margin-bottom: 22px !important;
    }
    .dash-main > div[style*="justify-content:space-between"] > div.d-flex.gap-2 {
      width: 100%;
    }
    .dash-main > div[style*="justify-content:space-between"] > div.d-flex.gap-2 a {
      width: 100%;
      justify-content: center;
    }

    .dash-h1 { font-size: 1.45rem !important; }
    .dash-sub { font-size: .8rem; }

    /* Save bar (sticky) needs room below the hamburger button */
    .save-bar {
      top: 68px;
      flex-wrap: wrap;
      gap: 12px;
      padding: 14px 16px;
    }
    .save-bar .d-flex.gap-2 { width: 100%; }
    .save-bar button { width: 100%; justify-content: center; }

    .profile-section { padding: 22px 18px; }

    /* Subscriptions table: scroll horizontally instead of crushing columns */
    #dash-documents table.table {
      display: block;
      width: 100%;
      overflow-x: auto;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
      border-radius: 10px;
    }

    /* Document/teacher info cards: stack full width */
    #dash-documents .col-md-6 {
      max-width: 100%;
      flex: 0 0 100%;
      margin-bottom: 12px;
    }
  }

  /* ================= SMALL PHONES ================= */
  @media (max-width: 575px) {
    .ds-stat { padding: 16px 14px; }
    .ds-stat-val { font-size: 1.6rem; }
    .dash-h1 { font-size: 1.25rem !important; }
    .dash-main { padding: 76px 14px 28px !important; }

    #dash-profile > .d-flex.gap-3.mt-2 { flex-direction: column; }
    #dash-profile > .d-flex.gap-3.mt-2 > button {
      width: 100%;
      justify-content: center;
    }

    .lesson-card, .don-row, .notification-item { flex-wrap: wrap; }
  }
</style>

<div>
  {{-- Hamburger toggle for the sidebar drawer (mobile only) --}}
  <button class="dash-menu-btn" id="dash-menu-toggle" aria-label="Open menu">
    <i class="fas fa-bars"></i>
  </button>

  {{-- Overlay for mobile drawer --}}
  <div class="dash-sidebar-overlay" id="dash-sidebar-overlay"></div>

  <div class="dashboard-layout">
    <!-- Sidebar -->
    {{-- @include('frontend.user_dashboard.include.sidebar')
    --}}
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
        {{-- <div class="dash-nav-item" onclick="switchDash('settings')"><i class="fas fa-cog"></i>Settings</div> --}}
        <div class="dash-nav-item" onclick="switchDash('documents')"><i class="fas fa-file-alt"></i>My Plans</div>
        <div class="dash-logout">
          <a class="dash-logout-btn" href="{{ url('userlogout') }}"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="dash-main">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px">
        <div>
          <div class="dash-breadcrumb"><span>Merit</span><i class="fas fa-chevron-right"></i><span id="breadcrumb-txt">Dashboard</span></div>
          <h1 class="dash-h1" id="dash-main-title">@php echo date('g:i A'); @endphp, <em style="font-style:italic;color:var(--gold)">{{ Auth::user()->name }}</em> 👋</h1>
          <p class="dash-sub">Here's an overview of your account and recent activity.</p>
        </div>
        <div class="d-flex gap-2">
          <a class="btn-outline-navy btn-sm" href="{{ url('/book-lesson') }}"><i class="fas fa-plus"></i>Book Lesson</a>
          {{-- <button class="btn-gold btn-sm" onclick="switchDash('donations')"><i class="fas fa-heart"></i>Donate</button> --}}
        </div>
      </div>

      <!-- OVERVIEW PANEL -->
      <div id="dash-overview" class="dash-panel active">
        <!-- Stats -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(201,168,76,.1)"><i class="fas fa-graduation-cap" style="color:var(--gold)"></i></div><div class="ds-stat-val"></div><div class="ds-stat-lbl">Total Lessons</div><div class="ds-stat-change change-up"><i class="fas fa-arrow-up"></i></div></div></div>
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(13,107,99,.1)"><i class="fas fa-heart" style="color:var(--teal)"></i></div><div class="ds-stat-val"></div><div class="ds-stat-lbl">Total Donated</div><div class="ds-stat-change change-up"><i class="fas fa-arrow-up"></i></div></div></div>
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(15,31,92,.07)"><i class="fas fa-child" style="color:var(--navy)"></i></div><div class="ds-stat-val"></div><div class="ds-stat-lbl">Child Sponsored</div><div class="ds-stat-change change-neu"><i class="fas fa-minus"></i></div></div></div>
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(201,168,76,.1)"><i class="fas fa-star" style="color:var(--gold)"></i></div><div class="ds-stat-val"></div><div class="ds-stat-lbl">Quran Progress</div><div class="ds-stat-change change-up"><i class="fas fa-arrow-up"></i></div></div></div>
        </div>

        <div class="row g-4">
          <div class="col-lg-12">
            <!-- Upcoming Lessons -->
            {{-- <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-calendar-alt"></i>Upcoming Lessons</div>
              <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">18</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Surah Al-Baqarah — Tajweed Session</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00 PM – 4:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span><span><i class="fas fa-video"></i> Zoom</span></div></div><div class="lc-status status-upcoming"><i class="fas fa-clock"></i>Upcoming</div></div>
              <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">20</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Qaida Revision &amp; Reading Practice</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 5:00 PM – 5:30 PM</span><span><i class="fas fa-user"></i> Ustadha Fatima</span><span><i class="fas fa-video"></i> Zoom</span></div></div><div class="lc-status status-upcoming"><i class="fas fa-clock"></i>Upcoming</div></div>
              <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">15</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Surah Yasin — Memorisation</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00 PM – 4:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span></div></div><div class="lc-status status-done"><i class="fas fa-check"></i>Completed</div></div>
              <button class="btn-outline-navy btn-sm mt-2" style="font-size:.72rem" onclick="switchDash('lessons')"><i class="fas fa-list"></i>View All Lessons</button>
            </div> --}}
            <!-- Progress -->
            <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-chart-line"></i>Learning Progress</div>
              <div style="margin-bottom:16px"><div style="display:flex;justify-content:space-between;margin-bottom:6px"><span style="font-size:.8rem;font-weight:600;color:var(--navy)">Quran Recitation</span><span style="font-size:.8rem;color:var(--gold);font-weight:700">68%</span></div><div class="prog-bar-wrap"><div class="prog-bar" style="width:68%"></div></div></div>
              <div style="margin-bottom:16px"><div style="display:flex;justify-content:space-between;margin-bottom:6px"><span style="font-size:.8rem;font-weight:600;color:var(--navy)">Tajweed Rules</span><span style="font-size:.8rem;color:var(--gold);font-weight:700">42%</span></div><div class="prog-bar-wrap"><div class="prog-bar" style="width:42%"></div></div></div>
              <div><div style="display:flex;justify-content:space-between;margin-bottom:6px"><span style="font-size:.8rem;font-weight:600;color:var(--navy)">Memorisation (Hifz)</span><span style="font-size:.8rem;color:var(--gold);font-weight:700">25%</span></div><div class="prog-bar-wrap"><div class="prog-bar" style="width:25%"></div></div></div>
            </div>
          </div>

        </div>
      </div>
        {{--
      <!-- LESSONS PANEL -->
      <div id="dash-lessons" class="dash-panel">
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-graduation-cap"></i>All Lessons</div>
          <div class="d-flex gap-2 mb-3 flex-wrap">
            <button class="filter-pill active btn-sm">All</button>
            <button class="filter-pill btn-sm">Upcoming</button>
            <button class="filter-pill btn-sm">Completed</button>
            <button class="filter-pill btn-sm">Cancelled</button>
            <button class="btn-gold btn-sm ms-auto"><i class="fas fa-plus"></i>Book Lesson</button>
          </div>
          <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">18</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Surah Al-Baqarah — Tajweed Session</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00–4:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span><span><i class="fas fa-video"></i> Zoom</span><span><i class="fas fa-pound-sign"></i> £25</span></div></div><div class="d-flex gap-2 align-items-center"><div class="lc-status status-upcoming"><i class="fas fa-clock"></i>Upcoming</div><button class="btn-outline-navy" style="padding:6px 14px;font-size:.7rem;border-radius:7px">Reschedule</button></div></div>
          <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">20</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Qaida Revision &amp; Reading Practice</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 5:00–5:30 PM</span><span><i class="fas fa-user"></i> Ustadha Fatima</span><span><i class="fas fa-video"></i> Zoom</span><span><i class="fas fa-pound-sign"></i> £15</span></div></div><div class="d-flex gap-2 align-items-center"><div class="lc-status status-upcoming"><i class="fas fa-clock"></i>Upcoming</div><button class="btn-outline-navy" style="padding:6px 14px;font-size:.7rem;border-radius:7px">Reschedule</button></div></div>
          <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">15</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Surah Yasin — Memorisation</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00–4:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span><span><i class="fas fa-pound-sign"></i> £25</span></div></div><div class="d-flex gap-2 align-items-center"><div class="lc-status status-done"><i class="fas fa-check"></i>Completed</div><button class="btn-outline-navy" style="padding:6px 14px;font-size:.7rem;border-radius:7px">View Report</button></div></div>
          <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">10</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Tajweed Rules — Noon Sakinah</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 3:00–3:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span><span><i class="fas fa-pound-sign"></i> £25</span></div></div><div class="lc-status status-done"><i class="fas fa-check"></i>Completed</div></div>
          <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">5</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Introductory Tajweed</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00–4:30 PM</span><span><i class="fas fa-user"></i> Ustadha Fatima</span><span><i class="fas fa-pound-sign"></i> £15</span></div></div><div class="lc-status status-cancelled"><i class="fas fa-times"></i>Cancelled</div></div>
        </div>
      </div>

      <!-- DONATIONS PANEL -->
      <div id="dash-donations" class="dash-panel">
        <div class="row g-4">
          <div class="col-lg-7">
            <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-heart"></i>Donation History</div>
              <div class="don-row"><div class="don-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-heart" style="color:var(--gold)"></i></div><div class="don-info"><h6>Monthly Donation</h6><p>1 Nov 2025 · Gift Aid applied</p></div><div class="don-amt">£20<span class="don-status ds-paid">Paid</span></div></div>
              <div class="don-row"><div class="don-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-heart" style="color:var(--gold)"></i></div><div class="don-info"><h6>Monthly Donation</h6><p>1 Oct 2025 · Gift Aid applied</p></div><div class="don-amt">£20<span class="don-status ds-paid">Paid</span></div></div>
              <div class="don-row"><div class="don-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-star" style="color:var(--teal)"></i></div><div class="don-info"><h6>Ramadan Campaign</h6><p>10 Apr 2025 · One-time</p></div><div class="don-amt">£50<span class="don-status ds-paid">Paid</span></div></div>
              <div class="don-row"><div class="don-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-heart" style="color:var(--gold)"></i></div><div class="don-info"><h6>Monthly Donation</h6><p>1 Sep 2025 · Gift Aid applied</p></div><div class="don-amt">£20<span class="don-status ds-paid">Paid</span></div></div>
              <div class="don-row"><div class="don-ic" style="background:rgba(217,119,6,.1)"><i class="fas fa-clock" style="color:var(--amber)"></i></div><div class="don-info"><h6>December Sponsorship</h6><p>Due 1 Dec 2025</p></div><div class="don-amt">£20<span class="don-status ds-pending">Pending</span></div></div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-chart-pie"></i>Giving Summary</div>
              <div style="text-align:center;padding:20px 0">
                <div style="font-family:'Cormorant Garamond',serif;font-size:3rem;font-weight:700;color:var(--gold);line-height:1">£185</div>
                <div style="font-size:.75rem;color:var(--muted);letter-spacing:1px;margin-top:5px">Total Donated (2025)</div>
                <div style="margin-top:16px;display:inline-flex;align-items:center;gap:7px;background:rgba(13,107,99,.08);border:1px solid rgba(13,107,99,.2);border-radius:20px;padding:6px 14px">
                  <i class="fas fa-gift" style="color:var(--teal);font-size:.8rem"></i>
                  <span style="font-size:.75rem;color:var(--teal);font-weight:600">+£46.25 Gift Aid Added</span>
                </div>
              </div>
              <div style="background:var(--cream);border-radius:10px;padding:16px;margin-top:8px">
                <p style="font-size:.75rem;color:var(--muted);line-height:1.6;margin:0">Your monthly £20 donation is set to continue. <strong style="color:var(--navy)">Gift Aid</strong> has been applied — adding 25% at no extra cost to you.</p>
              </div>
              <button class="btn-gold btn-sm mt-3" style="width:100%;justify-content:center"><i class="fas fa-heart"></i>Make a Donation</button>
              <button class="btn-outline-navy btn-sm mt-2" style="width:100%;justify-content:center"><i class="fas fa-file-download"></i>Download Receipts</button>
            </div>
          </div>
        </div>
      </div>
       --}}
      <!-- PROFILE PANEL -->
      {{-- resources/views/dashboard/profile.blade.php --}}

@php $user = Auth::user(); @endphp

<div id="dash-profile" class="dash-panel">

  {{-- ── Save Bar ── --}}
  <div class="save-bar">
    <div class="save-bar-msg">
      <strong>Profile Settings</strong> — Keep your information up to date
    </div>
    <div class="d-flex gap-2">
      {{-- <button class="btn-outline-navy btn-sm" id="cancel-btn">Cancel</button> --}}
      <button class="btn-gold btn-sm" id="save-btn-top" onclick="saveProfile()">
        <i class="fas fa-save"></i> Save Changes
      </button>
    </div>
  </div>

  {{-- ── Avatar ── --}}
  {{-- <div class="profile-section">
    <div class="profile-section-title"><i class="fas fa-user-circle"></i> Profile Photo</div>
    <div class="profile-av-section">
      <div class="profile-av-lg" id="profile-av-display">
        {{ strtoupper(substr($user->name, 0, 1)) }}
      </div>
      <div class="profile-av-info">
        <h5>{{ $user->name }} {{ $user->last_name }}</h5>
        <p>JPG, PNG or GIF · Max 2MB</p>
        <div class="d-flex gap-2 flex-wrap">
          <button class="btn-gold btn-sm"><i class="fas fa-upload"></i> Upload Photo</button>
          <button class="btn-outline-navy btn-sm"><i class="fas fa-trash"></i> Remove</button>
        </div>
      </div>
    </div>
  </div> --}}

  {{-- ── Personal Information ── --}}
  <div class="profile-section">
    <div class="profile-section-title"><i class="fas fa-id-card"></i> Personal Information</div>
    <div class="row g-3">

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">First Name *</label>
          <input type="text" class="field-input" id="prof-fname" value="{{ $user->name }}">
          <p class="field-hint">Your legal first name as on official documents</p>
          <div class="field-error" id="err-name"></div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">Last Name *</label>
          <input type="text" class="field-input" id="prof-lname" value="{{ $user->last_name }}">
          <div class="field-error" id="err-last_name"></div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">Email Address *</label>
          <input type="email" class="field-input" id="prof-email" value="{{ $user->email }}">
          <p class="field-hint">Used for login and lesson notifications</p>
          <div class="field-error" id="err-email"></div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">Phone Number</label>
          <input type="tel" class="field-input" id="prof-phone" value="{{ $user->phone }}">
          <div class="field-error" id="err-phone"></div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── Address ── --}}
  <div class="profile-section">
    <div class="profile-section-title"><i class="fas fa-map-marker-alt"></i> Address</div>
    <div class="row g-3">

      <div class="col-12">
        <div class="field-group">
          <label class="field-label">Address Line 1</label>
          <input type="text" name="address_line_1" class="field-input" value="{{ $user->address_line_1 }}">
          <div class="field-error" id="err-address_line_1"></div>
        </div>
      </div>

      <div class="col-12">
        <div class="field-group">
          <label class="field-label">Address Line 2</label>
          <input type="text" name="address_line_2" class="field-input" value="{{ $user->address_line_2 }}">
          <div class="field-error" id="err-address_line_2"></div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">City</label>
          <input type="text" name="city" class="field-input" value="{{ $user->city }}">
          <div class="field-error" id="err-city"></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="field-group">
          <label class="field-label">Postcode</label>
          <input type="text" name="postcode" class="field-input" value="{{ $user->postcode }}">
          <div class="field-error" id="err-postcode"></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="field-group">
          <label class="field-label">Country</label>
          <select name="country" class="field-select">
            <option @selected($user->country == 'United Kingdom')>United Kingdom</option>
            <option @selected($user->country == 'Other')>Other</option>
          </select>
          <div class="field-error" id="err-country"></div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── Student Information ── --}}
  <div class="profile-section">
    <div class="profile-section-title"><i class="fas fa-child"></i> Student Information</div>
    <div class="row g-3">

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">Student Name</label>
          <input type="text" name="student_name" class="field-input" value="{{ $user->student_name }}">
          <div class="field-error" id="err-student_name"></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="field-group">
          <label class="field-label">Age</label>
          <input type="number" name="age" class="field-input" value="{{ $user->age }}">
          <div class="field-error" id="err-age"></div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="field-group">
          <label class="field-label">Current Level</label>
          <select name="quran_level" class="field-select">
            <option @selected($user->quran_level == 'Beginner')>Beginner</option>
            <option @selected($user->quran_level == 'Qaida')>Qaida</option>
            <option @selected($user->quran_level == 'Reading Quran')>Reading Quran</option>
            <option @selected($user->quran_level == 'Tajweed')>Tajweed</option>
          </select>
          <div class="field-error" id="err-quran_level"></div>
        </div>
      </div>

      <div class="col-12">
        <div class="field-group">
          <label class="field-label">Learning Goals / Notes</label>
          <textarea name="learning_goals" class="field-textarea" rows="3">{{ $user->learning_goals }}</textarea>
          <div class="field-error" id="err-learning_goals"></div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">Date of Birth</label>
          <input type="date" name="date_of_birth" class="field-input" value="{{ $user->date_of_birth }}">
          <div class="field-error" id="err-date_of_birth"></div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="field-group">
          <label class="field-label">Gender</label>
          <select name="gender" class="field-select">
            <option @selected($user->gender == 'Female')>Female</option>
            <option @selected($user->gender == 'Male')>Male</option>
            <option @selected($user->gender == 'Prefer not to say')>Prefer not to say</option>
          </select>
          <div class="field-error" id="err-gender"></div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── Change Password ── --}}
  {{--  <div class="profile-section">
    <div class="profile-section-title"><i class="fas fa-lock"></i> Change Password</div>
    <div class="row g-3">

      <div class="col-md-4">
        <div class="field-group">
          <label class="field-label">Current Password</label>
          <input type="password" id="pwd-current" class="field-input" placeholder="Current password">
          <div class="field-error" id="err-current_password"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="field-group">
          <label class="field-label">New Password</label>
          <input type="password" id="pwd-new" class="field-input" placeholder="New password">
          <div class="field-error" id="err-new_password"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="field-group">
          <label class="field-label">Confirm New Password</label>
          <input type="password" id="pwd-confirm" class="field-input" placeholder="Confirm">
          <div class="field-error" id="err-pwd-confirm"></div>
        </div>
      </div>

    </div>
    <button class="btn-outline-navy btn-sm mt-3" id="update-pwd-btn">
      <i class="fas fa-key"></i> Update Password
    </button>
  </div> --}}

  {{-- ── Bottom Action Bar ── --}}
  <div class="d-flex gap-3 mt-2">
    <button class="btn-gold" id="save-btn-bottom" onclick="saveProfile()">
      <i class="fas fa-save"></i> Save All Changes
    </button>
    {{-- <button class="btn-outline-navy" id="cancel-btn-bottom">Cancel</button> --}}
  </div>

</div>{{-- end #dash-profile --}}


{{-- ══════════════════════════════════════════════
     JQUERY AJAX — Validation & Profile Update
════════════════════════════════════════════════ --}}


{{-- ── Inline styles for error states (add to your main CSS if preferred) ── --}}
<style>
  .field-error {
    color: #c0392b;
    font-size: .78rem;
    margin-top: 4px;
    min-height: 1rem;
  }
  .input-error {
    border-color: #c0392b !important;
    box-shadow: 0 0 0 2px rgba(192,57,43,.15) !important;
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }
</style>

      <!-- NOTIFICATIONS PANEL -->
      <div id="dash-notifications" class="dash-panel">
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-bell"></i>Notifications <span style="background:var(--gold);color:var(--navy);font-size:.65rem;font-weight:800;padding:3px 10px;border-radius:20px;margin-left:8px">5 New</span></div>
          <div class="notification-item"><div class="ni-dot"></div><div class="ni-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-check" style="color:var(--teal)"></i></div><div style="flex:1"><div class="ni-title">Lesson Completed Successfully</div><div class="ni-body">Your session with Ustadh Bilal on Surah Yasin was completed. Your progress report is now available.</div><div class="ni-time"><i class="fas fa-clock"></i>15 Nov 2025 · 4:50 PM</div></div></div>
          <div class="notification-item"><div class="ni-dot"></div><div class="ni-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-heart" style="color:var(--gold)"></i></div><div style="flex:1"><div class="ni-title">Monthly Donation Processed</div><div class="ni-body">Your £20 monthly donation has been processed and Gift Aid applied. Receipt emailed to you.</div><div class="ni-time"><i class="fas fa-clock"></i>1 Nov 2025 · 9:00 AM</div></div></div>
          <div class="notification-item"><div class="ni-dot"></div><div class="ni-ic" style="background:rgba(15,31,92,.07)"><i class="fas fa-calendar" style="color:var(--navy)"></i></div><div style="flex:1"><div class="ni-title">Lesson Reminder — Tomorrow</div><div class="ni-body">You have a Tajweed session with Ustadh Bilal tomorrow at 4:00 PM. Check your Zoom link below.</div><div class="ni-time"><i class="fas fa-clock"></i>17 Nov 2025 · 8:00 AM</div></div></div>
          <div class="notification-item"><div class="ni-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-star" style="color:var(--gold)"></i></div><div style="flex:1"><div class="ni-title">October Progress Report Ready</div><div class="ni-body">Ibrahim's October learning report is available. He has shown excellent improvement in Tajweed rules.</div><div class="ni-time"><i class="fas fa-clock"></i>25 Oct 2025 · 11:00 AM</div></div></div>
          <div class="notification-item"><div class="ni-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-newspaper" style="color:var(--teal)"></i></div><div style="flex:1"><div class="ni-title">New Article: 5,000 Students Reached</div><div class="ni-body">Merit Education Foundation has reached a major milestone. Read the full story on our News page.</div><div class="ni-time"><i class="fas fa-clock"></i>15 Nov 2025 · 10:00 AM</div></div></div>
        </div>
      </div>

      <!-- SETTINGS PANEL -->
      <div id="dash-settings" class="dash-panel">
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-bell"></i>Notification Preferences</div>
          <div class="toggle-row"><div class="toggle-info"><h6>Email — Lesson Reminders</h6><p>Receive 24-hour reminders before your lessons</p></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
          <div class="toggle-row"><div class="toggle-info"><h6>Email — Donation Receipts</h6><p>Receive email receipts for every donation</p></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
          <div class="toggle-row"><div class="toggle-info"><h6>Email — Progress Reports</h6><p>Monthly summaries of your child's learning progress</p></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
          <div class="toggle-row"><div class="toggle-info"><h6>Email — Newsletter</h6><p>News, impact stories and updates from Merit Foundation</p></div><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></div>
          <div class="toggle-row"><div class="toggle-info"><h6>SMS — Lesson Reminders</h6><p>Text message reminders to your registered phone</p></div><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></div>
        </div>
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-shield-alt"></i>Privacy &amp; Security</div>
          <div class="toggle-row"><div class="toggle-info"><h6>Two-Factor Authentication</h6><p>Add an extra layer of security to your account</p></div><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></div>
          <div class="toggle-row"><div class="toggle-info"><h6>Public Profile</h6><p>Allow tutors to see your profile information</p></div><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></div>
          <div class="mt-4 pt-2">
            <button class="btn-outline-navy btn-sm me-2"><i class="fas fa-download"></i>Download My Data</button>
            <button style="display:inline-flex;align-items:center;gap:8px;background:transparent;color:var(--red);padding:9px 20px;border-radius:9px;font-weight:700;font-size:.72rem;letter-spacing:1.5px;text-transform:uppercase;border:2px solid var(--red);cursor:pointer;transition:.3s" onmouseover="this.style.background='var(--red)';this.style.color='white'" onmouseout="this.style.background='transparent';this.style.color='var(--red)'"><i class="fas fa-trash"></i>Delete Account</button>
          </div>
        </div>
      </div>

      <!-- DOCUMENTS PANEL -->
      <div id="dash-documents" class="dash-panel">
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-file-alt"></i>My Plans</div>
          <div class="row g-3">

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Plan Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($subscriptions as $subscription)
        <tr>
          @php
          $planName = App\Models\Plan::where('stripe_price_id', $subscription->stripe_price)->first();
          @endphp
            {{-- Plan Name --}}
            <td>{{  $planName->name ?? 'Plan Not Found' }}</td>

            {{-- Start Date --}}
            <td>
                {{ $subscription->created_at
                    ? $subscription->created_at->format('d M Y')
                    : '—' }}
            </td>

            {{-- End Date --}}
            <td>
                @if($subscription->ends_at)
                    {{ $subscription->ends_at->format('d M Y') }}
                @elseif($subscription->trial_ends_at)
                    Trial ends {{ $subscription->trial_ends_at->format('d M Y') }}
                @else
                    Ongoing
                @endif
            </td>
@php $status = $subscription->stripe_status; @endphp
            {{-- Status Badge --}}
            <td>

                @if($subscription->onGracePeriod())
                    <span class="badge bg-warning text-dark">Cancels Soon</span>
                @elseif($subscription->stripe_status === 'paused')
                    <span class="badge bg-secondary">Paused</span>
                @elseif($subscription->active())
                    <span class="badge bg-success">Active</span>
                @elseif($subscription->canceled())
                    <span class="badge bg-danger">Cancelled</span>
                @else
                    <span class="badge bg-light text-dark">{{ $subscription->stripe_status }}</span>
                @endif

            </td>

            {{-- Action Buttons --}}
            <td>
                @if($subscription->stripe_status === 'paused')
                    {{-- RESUME --}}
                    <form method="POST" action="{{ route('subscriptions.resume', $subscription->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success"
                                onclick="return confirm('Resume this subscription?')">
                            ▶ Resume
                        </button>
                    </form>

                @elseif($subscription->active() && !$subscription->onGracePeriod())
                    {{-- PAUSE --}}
                    <form method="POST" action="{{ route('subscriptions.pause', $subscription->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-warning"
                                onclick="return confirm('Pause this subscription?')">
                            ⏸ Pause
                        </button>
                    </form>

                    {{-- CANCEL AT END --}}
                    <form method="POST" action="{{ route('subscriptions.cancel', $subscription->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-secondary"
                                onclick="return confirm('Cancel at period end?')">
                            Cancel
                        </button>
                    </form>

                    {{-- CANCEL NOW --}}
                    <form method="POST" action="{{ route('subscriptions.cancelNow', $subscription->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Cancel IMMEDIATELY? This cannot be undone!')">
                            Cancel Now
                        </button>
                    </form>

                @elseif($subscription->onGracePeriod())
                    {{-- UNDO CANCEL (resume during grace period) --}}
                    <form method="POST" action="{{ route('subscriptions.resume', $subscription->id) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-success"
                                onclick="return confirm('Undo cancellation and reactivate?')">
                            ↩ Undo Cancel
                        </button>
                    </form>
                    <span class="text-muted small ms-1">
                        Ends {{ $subscription->ends_at->format('d M Y') }}
                    </span>

                @else
                    <span class="text-muted small">No actions available</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted py-4">
                No subscriptions found. Subscribe above to get started.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

             <div class="profile-section-title"><i class="fas fa-file-alt"></i>My Class Time and Date</div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(201,168,76,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-pdf" style="color:var(--gold)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">October Progress Report</div><div style="font-size:.72rem;color:var(--muted)">PDF · 25 Oct 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
            {{-- <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(201,168,76,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-pdf" style="color:var(--gold)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">September Progress Report</div><div style="font-size:.72rem;color:var(--muted)">PDF · 25 Sep 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(13,107,99,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-invoice" style="color:var(--teal)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">Donation Receipt — Nov 2025</div><div style="font-size:.72rem;color:var(--muted)">PDF · 1 Nov 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(15,31,92,.07);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-certificate" style="color:var(--navy)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">Gift Aid Declaration</div><div style="font-size:.72rem;color:var(--muted)">PDF · 1 Jan 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div> --}}
              <div class="profile-section-title"><i class="fas fa-file-alt"></i>My Teacher Name</div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(201,168,76,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-pdf" style="color:var(--gold)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">October Progress Report</div><div style="font-size:.72rem;color:var(--muted)">PDF · 25 Oct 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div><!-- end dashboard -->


<script>
// ── Mobile sidebar drawer toggle ────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('dash-menu-toggle');
    const sidebar = document.getElementById('dash-sidebar');
    const overlay = document.getElementById('dash-sidebar-overlay');

    function openSidebar() {
        sidebar.classList.add('mobile-open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (menuBtn) {
        menuBtn.addEventListener('click', function () {
            sidebar.classList.contains('mobile-open') ? closeSidebar() : openSidebar();
        });
    }
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close the drawer automatically when a nav item is tapped (mobile only)
    document.querySelectorAll('.dash-nav-item').forEach(function (item) {
        item.addEventListener('click', function () {
            if (window.innerWidth <= 991) closeSidebar();
        });
    });

    // Close drawer if the viewport is resized back up to desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) closeSidebar();
    });
});

function saveProfile() {
    // Clear previous errors
    $('.field-input, .field-select, .field-textarea').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // Gather data
    const data = {
        _token: '{{ csrf_token() }}',
        name:           $('#prof-fname').val().trim(),
        last_name:      $('#prof-lname').val().trim(),
        email:          $('#prof-email').val().trim(),
        phone:          $('#prof-phone').val().trim(),
        address_line_1: $('input[name="address_line_1"]').val().trim(),  // keep name attrs
        address_line_2: $('input[name="address_line_2"]').val().trim(),
        city:           $('input[name="city"]').val().trim(),
        postcode:       $('input[name="postcode"]').val().trim(),
        country:        $('select[name="country"]').val(),
        student_name:   $('input[name="student_name"]').val().trim(),
        age:            $('input[name="age"]').val().trim(),
        quran_level:    $('select[name="quran_level"]').val(),
        learning_goals: $('textarea[name="learning_goals"]').val().trim(),
        date_of_birth:  $('input[name="date_of_birth"]').val(),
        gender:         $('select[name="gender"]').val(),
    };

    // Client-side quick checks before hitting server
    let hasError = false;

    if (!data.name) {
        showError('#prof-fname', 'First name is required.');
        hasError = true;
    }
    if (!data.last_name) {
        showError('#prof-lname', 'Last name is required.');
        hasError = true;
    }
    if (!data.email) {
        showError('#prof-email', 'Email address is required.');
        hasError = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
        showError('#prof-email', 'Please enter a valid email address.');
        hasError = true;
    }

    if (hasError) return;

    // Disable save buttons during request
    const $saveBtns = $('button[onclick="saveProfile()"]');
    $saveBtns.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving…');

    $.ajax({
        url: '{{ route("profile.update") }}',
        method: 'POST',
        data: data,
        success: function (res) {
            if (res.success) {
                showToast('success', res.message || 'Profile updated successfully.');
            } else {
                showToast('error', res.message || 'Something went wrong.');
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                // Laravel validation errors
                const errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    const fieldMap = {
                        name:           '#prof-fname',
                        last_name:      '#prof-lname',
                        email:          '#prof-email',
                        phone:          '#prof-phone',
                        address_line_1: 'input[name="address_line_1"]',
                        address_line_2: 'input[name="address_line_2"]',
                        city:           'input[name="city"]',
                        postcode:       'input[name="postcode"]',
                        country:        'select[name="country"]',
                        student_name:   'input[name="student_name"]',
                        age:            'input[name="age"]',
                        quran_level:    'select[name="quran_level"]',
                        learning_goals: 'textarea[name="learning_goals"]',
                        date_of_birth:  'input[name="date_of_birth"]',
                        gender:         'select[name="gender"]',
                    };
                    if (fieldMap[field]) {
                        showError(fieldMap[field], messages[0]);
                    }
                });
            } else {
                showToast('error', 'Server error. Please try again.');
            }
        },
        complete: function () {
            $saveBtns.prop('disabled', false).html('<i class="fas fa-save"></i> Save Changes');
        }
    });
}

// ── Password Update ──────────────────────────────────────────────
$('.btn-outline-navy:contains("Update Password")').on('click', function () {
    const current  = $('input[placeholder="Current password"]').val();
    const newPass  = $('input[placeholder="New password"]').val();
    const confirm  = $('input[placeholder="Confirm"]').val();

    $('input[type="password"]').removeClass('is-invalid');
    $('.pwd-error').remove();

    let hasError = false;
    if (!current) { showPasswordError(0, 'Enter your current password.'); hasError = true; }
    if (!newPass || newPass.length < 8) { showPasswordError(1, 'Min 8 characters.'); hasError = true; }
    if (newPass !== confirm) { showPasswordError(2, 'Passwords do not match.'); hasError = true; }
    if (hasError) return;

    const $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating…');

    $.ajax({
        url: '{{ route("profile.password") }}',
        method: 'POST',
        data: {
            _token:                  '{{ csrf_token() }}',
            current_password:        current,
            new_password:            newPass,
            new_password_confirmation: confirm,
        },
        success: function (res) {
            if (res.success) {
                showToast('success', res.message || 'Password updated.');
                $('input[type="password"]').val('');
            } else {
                showToast('error', res.message || 'Could not update password.');
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                const pwdInputs = $('input[type="password"]');
                if (errors.current_password) showPasswordError(0, errors.current_password[0]);
                if (errors.new_password)     showPasswordError(1, errors.new_password[0]);
            } else {
                showToast('error', 'Server error. Please try again.');
            }
        },
        complete: function () {
            $btn.prop('disabled', false).html('<i class="fas fa-key"></i> Update Password');
        }
    });
});

// ── Helpers ──────────────────────────────────────────────────────
function showError(selector, message) {
    const $el = $(selector);
    $el.addClass('is-invalid');
    $el.closest('.field-group').append(
        `<div class="invalid-feedback d-block" style="color:#dc3545;font-size:.8rem;margin-top:4px;">${message}</div>`
    );
}

function showPasswordError(index, message) {
    const $inputs = $('input[type="password"]');
    $inputs.eq(index).addClass('is-invalid')
        .closest('.field-group').append(
            `<div class="invalid-feedback pwd-error d-block" style="color:#dc3545;font-size:.8rem;margin-top:4px;">${message}</div>`
        );
}

function showToast(type, message) {
    const bg    = type === 'success' ? '#28a745' : '#dc3545';
    const icon  = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    const toast = $(`
        <div style="
            position:fixed;bottom:24px;right:24px;z-index:9999;
            background:${bg};color:#fff;padding:14px 20px;border-radius:8px;
            box-shadow:0 4px 12px rgba(0,0,0,.2);display:flex;align-items:center;gap:10px;
            font-size:.9rem;min-width:260px;max-width:380px;
        ">
            <i class="fas ${icon}"></i><span>${message}</span>
        </div>
    `);
    $('body').append(toast);
    setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3500);
}
</script>
@endsection