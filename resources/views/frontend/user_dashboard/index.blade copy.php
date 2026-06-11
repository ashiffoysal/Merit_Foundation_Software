
@extends('layouts.frontend')
@section('title', 'Privacy Policy - Merit Education Foundation')
@section('content')

<div>
  <div class="dashboard-layout">
    <!-- Sidebar -->
   @include('frontend.user_dashboard.include.sidebar')

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
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(201,168,76,.1)"><i class="fas fa-graduation-cap" style="color:var(--gold)"></i></div><div class="ds-stat-val">12</div><div class="ds-stat-lbl">Total Lessons</div><div class="ds-stat-change change-up"><i class="fas fa-arrow-up"></i>+2 this month</div></div></div>
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(13,107,99,.1)"><i class="fas fa-heart" style="color:var(--teal)"></i></div><div class="ds-stat-val">£185</div><div class="ds-stat-lbl">Total Donated</div><div class="ds-stat-change change-up"><i class="fas fa-arrow-up"></i>£20 this month</div></div></div>
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(15,31,92,.07)"><i class="fas fa-child" style="color:var(--navy)"></i></div><div class="ds-stat-val">1</div><div class="ds-stat-lbl">Child Sponsored</div><div class="ds-stat-change change-neu"><i class="fas fa-minus"></i>Active</div></div></div>
          <div class="col-6 col-xl-3"><div class="ds-stat"><div class="ds-stat-icon" style="background:rgba(201,168,76,.1)"><i class="fas fa-star" style="color:var(--gold)"></i></div><div class="ds-stat-val">68%</div><div class="ds-stat-lbl">Quran Progress</div><div class="ds-stat-change change-up"><i class="fas fa-arrow-up"></i>+8% this week</div></div></div>
        </div>

        <div class="row g-4">
          <div class="col-lg-7">
            <!-- Upcoming Lessons -->
            <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-calendar-alt"></i>Upcoming Lessons</div>
              <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">18</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Surah Al-Baqarah — Tajweed Session</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00 PM – 4:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span><span><i class="fas fa-video"></i> Zoom</span></div></div><div class="lc-status status-upcoming"><i class="fas fa-clock"></i>Upcoming</div></div>
              <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">20</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Qaida Revision &amp; Reading Practice</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 5:00 PM – 5:30 PM</span><span><i class="fas fa-user"></i> Ustadha Fatima</span><span><i class="fas fa-video"></i> Zoom</span></div></div><div class="lc-status status-upcoming"><i class="fas fa-clock"></i>Upcoming</div></div>
              <div class="lesson-card"><div class="lc-day"><div class="lc-day-n">15</div><div class="lc-day-m">NOV</div></div><div class="lc-info"><div class="lc-title">Surah Yasin — Memorisation</div><div class="lc-meta"><span><i class="fas fa-clock"></i> 4:00 PM – 4:45 PM</span><span><i class="fas fa-user"></i> Ustadh Bilal</span></div></div><div class="lc-status status-done"><i class="fas fa-check"></i>Completed</div></div>
              <button class="btn-outline-navy btn-sm mt-2" style="font-size:.72rem" onclick="switchDash('lessons')"><i class="fas fa-list"></i>View All Lessons</button>
            </div>
            <!-- Progress -->
            <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-chart-line"></i>Learning Progress</div>
              <div style="margin-bottom:16px"><div style="display:flex;justify-content:space-between;margin-bottom:6px"><span style="font-size:.8rem;font-weight:600;color:var(--navy)">Quran Recitation</span><span style="font-size:.8rem;color:var(--gold);font-weight:700">68%</span></div><div class="prog-bar-wrap"><div class="prog-bar" style="width:68%"></div></div></div>
              <div style="margin-bottom:16px"><div style="display:flex;justify-content:space-between;margin-bottom:6px"><span style="font-size:.8rem;font-weight:600;color:var(--navy)">Tajweed Rules</span><span style="font-size:.8rem;color:var(--gold);font-weight:700">42%</span></div><div class="prog-bar-wrap"><div class="prog-bar" style="width:42%"></div></div></div>
              <div><div style="display:flex;justify-content:space-between;margin-bottom:6px"><span style="font-size:.8rem;font-weight:600;color:var(--navy)">Memorisation (Hifz)</span><span style="font-size:.8rem;color:var(--gold);font-weight:700">25%</span></div><div class="prog-bar-wrap"><div class="prog-bar" style="width:25%"></div></div></div>
            </div>
          </div>
          <div class="col-lg-5">
            <!-- Recent Activity -->
            <div class="profile-section">
              <div class="profile-section-title"><i class="fas fa-history"></i>Recent Activity</div>
              <div class="activity-item"><div class="ai-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-check" style="color:var(--teal)"></i></div><div><div class="ai-txt"><strong>Lesson Completed</strong> — Surah Yasin memorisation with Ustadh Bilal</div><div class="ai-time">15 Nov · 4:00 PM</div></div></div>
              <div class="activity-item"><div class="ai-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-heart" style="color:var(--gold)"></i></div><div><div class="ai-txt"><strong>Donation Processed</strong> — £20 monthly donation confirmed</div><div class="ai-time">1 Nov · 9:00 AM</div></div></div>
              <div class="activity-item"><div class="ai-ic" style="background:rgba(15,31,92,.07)"><i class="fas fa-user" style="color:var(--navy)"></i></div><div><div class="ai-txt"><strong>Profile Updated</strong> — Contact details changed</div><div class="ai-time">28 Oct · 2:30 PM</div></div></div>
              <div class="activity-item"><div class="ai-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-star" style="color:var(--gold)"></i></div><div><div class="ai-txt"><strong>Progress Report</strong> — October report available to download</div><div class="ai-time">25 Oct · 11:00 AM</div></div></div>
              <div class="activity-item"><div class="ai-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-graduation-cap" style="color:var(--teal)"></i></div><div><div class="ai-txt"><strong>Lesson Booked</strong> — 3 sessions for November scheduled</div><div class="ai-time">22 Oct · 6:00 PM</div></div></div>
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
      <div id="dash-profile" class="dash-panel">
        <div class="save-bar"><div class="save-bar-msg"><strong>Profile Settings</strong> — Keep your information up to date</div><div class="d-flex gap-2"><button class="btn-outline-navy btn-sm">Cancel</button><button class="btn-gold btn-sm" onclick="saveProfile()"><i class="fas fa-save"></i>Save Changes</button></div></div>

        <!-- Avatar -->
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-user-circle"></i>Profile Photo</div>
          <div class="profile-av-section">
            <div class="profile-av-lg" id="profile-av-display">A</div>
            <div class="profile-av-info">
              <h5>Ayesha Malik</h5>
              <p>JPG, PNG or GIF · Max 2MB</p>
              <div class="d-flex gap-2 flex-wrap">
                <button class="btn-gold btn-sm"><i class="fas fa-upload"></i>Upload Photo</button>
                <button class="btn-outline-navy btn-sm"><i class="fas fa-trash"></i>Remove</button>
              </div>
            </div>
          </div>
        </div>
        @php
          $user=Auth::user();
        @endphp
        <!-- Personal Info -->
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-id-card"></i>Personal Information</div>
          <div class="row g-3">
            <div class="col-md-6"><div class="field-group"><label class="field-label">First Name *</label><input name="name" type="text" class="field-input" value="{{ $user->name }}" id="prof-fname"><p class="field-hint">Your legal first name as on official documents</p></div></div>
            <div class="col-md-6"><div class="field-group"><label class="field-label">Last Name *</label><input name="last_name" type="text" class="field-input" value="{{ $user->last_name }}" id="prof-lname"></div></div>
            <div class="col-md-6"><div class="field-group"><label class="field-label">Email Address *</label><input name="email" type="email" class="field-input" value="{{ $user->email }}" id="prof-email"><p class="field-hint">Used for login and lesson notifications</p></div></div>
            <div class="col-md-6"><div class="field-group"><label class="field-label">Phone Number</label><input name="phone" type="tel" class="field-input" value="{{ $user->phone }}" id="prof-phone"></div></div>
              </div>
        </div>

        <!-- Address -->
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-map-marker-alt"></i>Address</div>
          <div class="row g-3">
            <div class="col-12"><div class="field-group"><label class="field-label">Address Line 1</label><input name="address_line_1" type="text" class="field-input" value="{{ $user->address_line_1 }}"></div></div>
            <div class="col-12"><div class="field-group"><label class="field-label">Address Line 2</label><input name="address_line_2" type="text" class="field-input" value="{{ $user->address_line_2 }}"></div></div>
            <div class="col-md-6"><div class="field-group"><label class="field-label">City</label><input name="city" type="text" class="field-input" value="{{ $user->city }}"></div></div>
            <div class="col-md-3"><div class="field-group"><label class="field-label">Postcode</label><input name="postcode" type="text" class="field-input" value="{{ $user->postcode }}"></div></div>
            <div class="col-md-3"><div class="field-group"><label class="field-label">Country</label><select class="field-select" name="country"><option @if($user->country=='United Kingdom') selected @endif>United Kingdom</option><option @if($user->country=='Other') selected @endif>Other</option></select></div></div>
          </div>
        </div>

        <!-- Student Info -->
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-child"></i>Student Information</div>
          <div class="row g-3">
            <div class="col-md-6"><div class="field-group"><label class="field-label">Student Name</label><input type="text" name="student_name" class="field-input" value="{{ $user->student_name }}"></div></div>
            <div class="col-md-3"><div class="field-group"><label class="field-label">Age</label><input type="number" name="age" class="field-input" value="{{ $user->age }}"></div></div>
            <div class="col-md-3"><div class="field-group"><label class="field-label">Current Level</label><select name="quran_level" class="field-select"><option @if($user->quran_level=='Beginner') selected @endif>Beginner</option><option @if($user->quran_level=='Qaida') selected @endif >Qaida</option><option @if($user->quran_level=='Reading Quran') selected @endif >Reading Quran</option><option @if($user->quran_level=='Tajweed') selected @endif >Tajweed</option></select></div></div>
            <div class="col-12"><div class="field-group"><label class="field-label">Learning Goals / Notes</label><textarea name="learning_goals" class="field-textarea" rows="3">{{ $user->learning_goals }}</textarea></div></div>
           <div class="col-md-6"><div class="field-group"><label class="field-label">Date of Birth</label><input type="date" name="date_of_birth" class="field-input" value="{{ $user->date_of_birth }}"></div></div>
            <div class="col-md-6"><div class="field-group"><label class="field-label">Gender</label><select name="gender" class="field-select"><option @if($user->gender=='Female') selected @endif >Female</option><option @if($user->gender=='Male') selected @endif >Male</option><option @if($user->gender=='Prefer not to say') selected @endif >Prefer not to say</option></select></div></div>
       
          </div>
        </div>

        <!-- Password -->
        <div class="profile-section">
          <div class="profile-section-title"><i class="fas fa-lock"></i>Change Password</div>
          <div class="row g-3">
            <div class="col-md-4"><div class="field-group"><label class="field-label">Current Password</label><input type="password" class="field-input" placeholder="Current password"></div></div>
            <div class="col-md-4"><div class="field-group"><label class="field-label">New Password</label><input type="password" class="field-input" placeholder="New password"></div></div>
            <div class="col-md-4"><div class="field-group"><label class="field-label">Confirm New Password</label><input type="password" class="field-input" placeholder="Confirm"></div></div>
          </div>
          <button class="btn-outline-navy btn-sm"><i class="fas fa-key"></i>Update Password</button>
        </div>
        <div class="d-flex gap-3 mt-2">
          <button class="btn-gold" onclick="saveProfile()"><i class="fas fa-save"></i>Save All Changes</button>
          <button class="btn-outline-navy">Cancel</button>
        </div>
      </div>

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
          <div class="profile-section-title"><i class="fas fa-file-alt"></i>My Documents</div>
          <div class="row g-3">
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(201,168,76,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-pdf" style="color:var(--gold)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">October Progress Report</div><div style="font-size:.72rem;color:var(--muted)">PDF · 25 Oct 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(201,168,76,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-pdf" style="color:var(--gold)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">September Progress Report</div><div style="font-size:.72rem;color:var(--muted)">PDF · 25 Sep 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(13,107,99,.1);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-file-invoice" style="color:var(--teal)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">Donation Receipt — Nov 2025</div><div style="font-size:.72rem;color:var(--muted)">PDF · 1 Nov 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
            <div class="col-md-6"><div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:20px;display:flex;align-items:center;gap:14px;transition:.3s;cursor:pointer" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="width:42px;height:42px;background:rgba(15,31,92,.07);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-certificate" style="color:var(--navy)"></i></div><div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">Gift Aid Declaration</div><div style="font-size:.72rem;color:var(--muted)">PDF · 1 Jan 2025</div></div><i class="fas fa-download" style="color:var(--muted);margin-left:auto"></i></div></div>
          </div>
        </div>
      </div>

    </main>
  </div>
</div><!-- end dashboard -->
@endsection