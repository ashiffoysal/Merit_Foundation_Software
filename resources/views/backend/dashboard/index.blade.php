@extends('layouts.backend')
@section('content')
    <main class="main-content">
    <div class="main-inner">
      <!-- ═══════ DASHBOARD ═══════ -->
      <div id="" class="">
        <div class="page-header">
          <h1>Dashboard Overview</h1>
          <p>Welcome back, Super Admin. Here's what's happening at Merit today.</p>
        </div>

        <!-- Alert -->
        <div class="alert-custom alert-gold mb-4">
          <i class="fas fa-exclamation-triangle" style="color:var(--gold)"></i>
          <p><strong>Action Required:</strong> Ustadh Mohammed's DBS check expires in 14 days. <span style="color:var(--gold);cursor:pointer;font-weight:700">Renew now →</span></p>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-1">
              <div class="sc-icon" style="background:var(--goldp)"><i class="fas fa-user-graduate" style="color:var(--gold)"></i></div>
              <div class="sc-val">124</div>
              <div class="sc-lbl">Active Students</div>
              <div class="sc-change up"><i class="fas fa-arrow-up"></i>+12 this month</div>
            </div>
          </div>
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-2">
              <div class="sc-icon" style="background:rgba(12,122,112,.1)"><i class="fas fa-heart" style="color:var(--teal)"></i></div>
              <div class="sc-val">£4,820</div>
              <div class="sc-lbl">Donations This Month</div>
              <div class="sc-change up"><i class="fas fa-arrow-up"></i>+18% vs last month</div>
            </div>
          </div>
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-3">
              <div class="sc-icon" style="background:var(--redp)"><i class="fas fa-graduation-cap" style="color:var(--red)"></i></div>
              <div class="sc-val">247</div>
              <div class="sc-lbl">Lessons This Month</div>
              <div class="sc-change up"><i class="fas fa-arrow-up"></i>+34 vs last month</div>
            </div>
          </div>
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-4">
              <div class="sc-icon" style="background:var(--blup)"><i class="fas fa-chalkboard-teacher" style="color:var(--blu)"></i></div>
              <div class="sc-val">18</div>
              <div class="sc-lbl">Active Tutors</div>
              <div class="sc-change dn"><i class="fas fa-arrow-down"></i>-2 pending DBS</div>
            </div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <!-- Revenue Chart -->
          <div class="col-lg-7">
            <div class="card">
              <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-chart-bar"></i>Monthly Donations & Revenue</div>
                <div class="d-flex gap-2">
                  <span style="font-size:.65rem;background:var(--goldp);color:var(--gold);padding:4px 10px;border-radius:20px;font-weight:700">Donations</span>
                  <span style="font-size:.65rem;background:rgba(12,122,112,.1);color:var(--teal);padding:4px 10px;border-radius:20px;font-weight:700">Lessons</span>
                </div>
              </div>
              <div class="card-body-custom">
                <div class="bar-chart" id="bar-chart">
                  <!-- filled by JS -->
                </div>
              </div>
            </div>
          </div>
          <!-- Distribution -->
          <div class="col-lg-5">
            <div class="card h-100">
              <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-chart-pie"></i>Fund Allocation</div>
              </div>
              <div class="card-body-custom">
                <div class="d-flex align-items-center gap-4 mb-4">
                  <div class="donut-wrap">
                    <svg class="donut-svg" width="100" height="100" viewBox="0 0 100 100">
                      <circle class="donut-circle-bg" cx="50" cy="50" r="44"/>
                      <circle class="donut-circle" cx="50" cy="50" r="44" stroke="var(--gold)" stroke-dasharray="195 282" stroke-dashoffset="0"/>
                    </svg>
                    <div class="donut-label"><div class="donut-pct">70%</div><div class="donut-sub">Education</div></div>
                  </div>
                  <div style="flex:1">
                    <div class="d-flex align-items-center gap-2 mb-2"><div style="width:10px;height:10px;border-radius:3px;background:var(--gold);flex-shrink:0"></div><span style="font-size:.78rem;color:var(--txt);flex:1">Student Programmes</span><span style="font-size:.78rem;font-weight:700;color:var(--txt)">70%</span></div>
                    <div class="d-flex align-items-center gap-2 mb-2"><div style="width:10px;height:10px;border-radius:3px;background:var(--teal);flex-shrink:0"></div><span style="font-size:.78rem;color:var(--txt);flex:1">Materials & Resources</span><span style="font-size:.78rem;font-weight:700;color:var(--txt)">15%</span></div>
                    <div class="d-flex align-items-center gap-2 mb-2"><div style="width:10px;height:10px;border-radius:3px;background:var(--blu);flex-shrink:0"></div><span style="font-size:.78rem;color:var(--txt);flex:1">Administration</span><span style="font-size:.78rem;font-weight:700;color:var(--txt)">10%</span></div>
                    <div class="d-flex align-items-center gap-2"><div style="width:10px;height:10px;border-radius:3px;background:var(--red);flex-shrink:0"></div><span style="font-size:.78rem;color:var(--txt);flex:1">Emergency Welfare</span><span style="font-size:.78rem;font-weight:700;color:var(--txt)">5%</span></div>
                  </div>
                </div>
                <div style="background:var(--bg);border-radius:10px;padding:14px 16px">
                  <div style="display:flex;justify-content:space-between;font-size:.75rem;margin-bottom:6px"><span style="color:var(--muted)">Total Donations 2025</span><span style="font-weight:700;color:var(--txt)">£42,310</span></div>
                  <div style="display:flex;justify-content:space-between;font-size:.75rem"><span style="color:var(--muted)">Gift Aid Claimed</span><span style="font-weight:700;color:var(--grn)">+£8,462</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4">
          <!-- Recent Students -->
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-user-graduate"></i>Recent Registrations</div>
                <button class="btn-prim" onclick="showView('students',null)"><i class="fas fa-arrow-right"></i>View All</button>
              </div>
              <div class="card-body-custom">
                <div class="table-wrap">
                  <table class="data-table">
                    <thead><tr><th>Student</th><th>Level</th><th>Tutor</th><th>Status</th><th>Joined</th><th></th></tr></thead>
                    <tbody>
                      <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--gold);color:var(--s50)">A</div><div><div style="font-weight:600;font-size:.82rem">Amina Yusuf</div><div style="font-size:.68rem;color:var(--muted)">amina@email.com</div></div></div></td><td><span style="font-size:.78rem">Basic Qaida</span></td><td><span style="font-size:.78rem">Ustadha Fatima</span></td><td><span class="badge-status bs-new"><span class="bs-dot"></span>New</span></td><td><span style="font-size:.73rem;color:var(--muted)">Today</span></td><td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td></tr>
                      <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--teal)">I</div><div><div style="font-weight:600;font-size:.82rem">Ibrahim Malik</div><div style="font-size:.68rem;color:var(--muted)">via parent portal</div></div></div></td><td><span style="font-size:.78rem">Tajweed</span></td><td><span style="font-size:.78rem">Ustadh Bilal</span></td><td><span class="badge-status bs-active"><span class="bs-dot"></span>Active</span></td><td><span style="font-size:.73rem;color:var(--muted)">2 days ago</span></td><td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td></tr>
                      <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--blu)">S</div><div><div style="font-weight:600;font-size:.82rem">Sara Ahmed</div><div style="font-size:.68rem;color:var(--muted)">sara.a@email.com</div></div></div></td><td><span style="font-size:.78rem">Quran Reading</span></td><td><span style="font-size:.78rem">Ustadh Hassan</span></td><td><span class="badge-status bs-active"><span class="bs-dot"></span>Active</span></td><td><span style="font-size:.73rem;color:var(--muted)">4 days ago</span></td><td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td></tr>
                      <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:#7c3aed">O</div><div><div style="font-weight:600;font-size:.82rem">Omar Khan</div><div style="font-size:.68rem;color:var(--muted)">Charity-funded place</div></div></div></td><td><span style="font-size:.78rem">Hifz</span></td><td><span style="font-size:.78rem">Ustadh Mohammed</span></td><td><span class="badge-status bs-active"><span class="bs-dot"></span>Active</span></td><td><span style="font-size:.73rem;color:var(--muted)">1 week ago</span></td><td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td></tr>
                      <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--red)">Z</div><div><div style="font-weight:600;font-size:.82rem">Zara Patel</div><div style="font-size:.68rem;color:var(--muted)">zara.p@email.com</div></div></div></td><td><span style="font-size:.78rem">Basic Qaida</span></td><td><span style="font-size:.78rem">Ustadha Fatima</span></td><td><span class="badge-status bs-pending"><span class="bs-dot"></span>Trial</span></td><td><span style="font-size:.73rem;color:var(--muted)">1 week ago</span></td><td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- Quick Actions + Activity -->
          <div class="col-lg-4">
            <div class="card mb-4">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-bolt"></i>Quick Actions</div></div>
              <div class="card-body-custom">
                <div class="row g-2">
                  <div class="col-6"><div class="qa-btn" onclick="openModal('add-student')"><div class="qa-ic" style="background:var(--goldp)"><i class="fas fa-user-plus" style="color:var(--gold)"></i></div><div class="qa-lbl">Add Student</div></div></div>
                  <div class="col-6"><div class="qa-btn" onclick="openModal('add-lesson')"><div class="qa-ic" style="background:rgba(12,122,112,.1)"><i class="fas fa-plus-circle" style="color:var(--teal)"></i></div><div class="qa-lbl">Book Lesson</div></div></div>
                  <div class="col-6"><div class="qa-btn" onclick="showView('donations',null)"><div class="qa-ic" style="background:var(--grnp)"><i class="fas fa-heart" style="color:var(--grn)"></i></div><div class="qa-lbl">Add Donation</div></div></div>
                  <div class="col-6"><div class="qa-btn" onclick="showView('news',null)"><div class="qa-ic" style="background:var(--blup)"><i class="fas fa-edit" style="color:var(--blu)"></i></div><div class="qa-lbl">Post Article</div></div></div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-history"></i>Activity Feed</div></div>
              <div class="card-body-custom">
                <div class="activity-row"><div class="ar-ic" style="background:var(--grnp)"><i class="fas fa-user-plus" style="color:var(--grn)"></i></div><div><div class="ar-txt"><strong>Amina Yusuf</strong> registered</div><div class="ar-time">2 min ago</div></div></div>
                <div class="activity-row"><div class="ar-ic" style="background:var(--goldp)"><i class="fas fa-pound-sign" style="color:var(--gold)"></i></div><div><div class="ar-txt"><strong>£150 donation</strong> from James Mitchell</div><div class="ar-time">14 min ago</div></div></div>
                <div class="activity-row"><div class="ar-ic" style="background:var(--blup)"><i class="fas fa-graduation-cap" style="color:var(--blu)"></i></div><div><div class="ar-txt"><strong>Lesson completed</strong> — Ibrahim & Ustadh Bilal</div><div class="ar-time">1 hr ago</div></div></div>
                <div class="activity-row"><div class="ar-ic" style="background:var(--redp)"><i class="fas fa-shield-alt" style="color:var(--red)"></i></div><div><div class="ar-txt"><strong>Safeguarding form</strong> submitted — Tutor #14</div><div class="ar-time">2 hr ago</div></div></div>
                <div class="activity-row"><div class="ar-ic" style="background:var(--ambp)"><i class="fas fa-edit" style="color:var(--amb)"></i></div><div><div class="ar-txt"><strong>Article published</strong> — 5,000 Students milestone</div><div class="ar-time">3 hr ago</div></div></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ STUDENTS ═══════ -->
      <div id="view-students" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>Students</h1><p>Manage all enrolled and charity-funded students</p></div>
          <button class="btn-gold-sm" onclick="openModal('add-student')"><i class="fas fa-plus"></i>Add Student</button>
        </div>
        <!-- Filter Bar -->
        <div class="card mb-4">
          <div class="card-body-custom pt-3">
            <div class="row g-3 align-items-end">
              <div class="col-md-3"><div class="f-group mb-0"><label class="f-label">Search</label><div style="position:relative"><i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.78rem"></i><input type="text" class="f-input" placeholder="Name, email..." style="padding-left:34px"></div></div></div>
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Level</label><select class="f-select"><option>All Levels</option><option>Beginner/Qaida</option><option>Quran Reading</option><option>Tajweed</option><option>Hifz</option></select></div></div>
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Status</label><select class="f-select"><option>All Status</option><option>Active</option><option>Trial</option><option>Inactive</option><option>Charity-funded</option></select></div></div>
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Tutor</label><select class="f-select"><option>All Tutors</option><option>Ustadh Bilal</option><option>Ustadha Fatima</option><option>Ustadh Hassan</option></select></div></div>
              <div class="col-md-3 d-flex gap-2"><button class="btn-prim" style="flex:1"><i class="fas fa-filter"></i>Filter</button><button class="btn-outline-sm"><i class="fas fa-download"></i>Export</button></div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header-custom">
            <div class="card-title"><i class="fas fa-user-graduate"></i>All Students <span style="font-size:.72rem;background:var(--bg);color:var(--muted);padding:3px 10px;border-radius:20px;margin-left:8px;font-weight:600">124 total</span></div>
            <div class="tab-bar" style="margin:0;width:auto">
              <button class="tab-btn active" style="padding:6px 16px;font-size:.72rem">All</button>
              <button class="tab-btn" style="padding:6px 16px;font-size:.72rem">Paying</button>
              <button class="tab-btn" style="padding:6px 16px;font-size:.72rem">Charity</button>
            </div>
          </div>
          <div class="card-body-custom">
            <div class="table-wrap">
              <table class="data-table">
                <thead><tr><th><input type="checkbox" style="accent-color:var(--gold)"></th><th>Student</th><th>Age</th><th>Level</th><th>Tutor</th><th>Type</th><th>Progress</th><th>Status</th><th>Next Lesson</th><th>Actions</th></tr></thead>
                <tbody id="students-tbody">
                  <!-- rendered by JS -->
                </tbody>
              </table>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2" style="border-top:1px solid var(--border)">
              <span style="font-size:.75rem;color:var(--muted)">Showing 1–10 of 124 students</span>
              <div class="d-flex gap-2">
                <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem"><i class="fas fa-chevron-left"></i></button>
                <button class="btn-prim" style="padding:6px 14px;font-size:.72rem">1</button>
                <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem">2</button>
                <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem">3</button>
                <button class="btn-outline-sm" style="padding:6px 14px;font-size:.72rem"><i class="fas fa-chevron-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ DONATIONS ═══════ -->
      <div id="view-donations" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>Donations</h1><p>Track all donations, Gift Aid and fund allocation</p></div>
          <button class="btn-gold-sm" onclick="openModal('add-donation')"><i class="fas fa-plus"></i>Record Donation</button>
        </div>
        <div class="row g-3 mb-4">
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--goldp)"><i class="fas fa-pound-sign" style="color:var(--gold)"></i></div><div class="sc-val">£42,310</div><div class="sc-lbl">Total 2025</div><div class="sc-change up"><i class="fas fa-arrow-up"></i>+23% vs 2024</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--grnp)"><i class="fas fa-gift" style="color:var(--grn)"></i></div><div class="sc-val">£8,462</div><div class="sc-lbl">Gift Aid Claimed</div><div class="sc-change up"><i class="fas fa-arrow-up"></i>Q3 submitted</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--blup)"><i class="fas fa-sync" style="color:var(--blu)"></i></div><div class="sc-val">87</div><div class="sc-lbl">Monthly Donors</div><div class="sc-change up"><i class="fas fa-arrow-up"></i>+6 this month</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:rgba(12,122,112,.1)"><i class="fas fa-hand-holding-heart" style="color:var(--teal)"></i></div><div class="sc-val">156</div><div class="sc-lbl">Total Donors</div><div class="sc-change neu"><i class="fas fa-minus"></i>All time</div></div></div>
        </div>
        <div class="card">
          <div class="card-header-custom">
            <div class="card-title"><i class="fas fa-heart"></i>Donation Records</div>
            <div class="d-flex gap-2">
              <button class="btn-outline-sm"><i class="fas fa-file-export"></i>Gift Aid Report</button>
              <button class="btn-outline-sm"><i class="fas fa-download"></i>Export CSV</button>
            </div>
          </div>
          <div class="card-body-custom">
            <div class="table-wrap">
              <table class="data-table">
                <thead><tr><th>Donor</th><th>Amount</th><th>Type</th><th>Gift Aid</th><th>Date</th><th>Purpose</th><th>Status</th><th>Receipt</th></tr></thead>
                <tbody>
                  <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--s200)">J</div><div><div style="font-weight:600;font-size:.82rem">James Mitchell</div><div style="font-size:.68rem;color:var(--muted)">Champion Donor</div></div></div></td><td><span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">£150</span></td><td><span style="font-size:.75rem">One-time</span></td><td><span class="badge-status bs-active"><i class="fas fa-check"></i>Applied</span></td><td><span style="font-size:.73rem;color:var(--muted)">Today</span></td><td><span style="font-size:.75rem">Student sponsorship</span></td><td><span class="badge-status bs-completed"><span class="bs-dot"></span>Paid</span></td><td><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-download"></i></button></td></tr>
                  <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--gold);color:var(--s50)">A</div><div><div style="font-weight:600;font-size:.82rem">Ayesha Malik</div><div style="font-size:.68rem;color:var(--muted)">Monthly donor</div></div></div></td><td><span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">£20</span></td><td><span style="font-size:.75rem">Monthly</span></td><td><span class="badge-status bs-active"><i class="fas fa-check"></i>Applied</span></td><td><span style="font-size:.73rem;color:var(--muted)">1 Nov</span></td><td><span style="font-size:.75rem">General fund</span></td><td><span class="badge-status bs-completed"><span class="bs-dot"></span>Paid</span></td><td><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-download"></i></button></td></tr>
                  <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--teal)">L</div><div><div style="font-weight:600;font-size:.82rem">Linda Wang</div><div style="font-size:.68rem;color:var(--muted)">Corporate partner</div></div></div></td><td><span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">£500</span></td><td><span style="font-size:.75rem">Corporate</span></td><td><span class="badge-status bs-pending"><i class="fas fa-clock"></i>Pending</span></td><td><span style="font-size:.73rem;color:var(--muted)">28 Oct</span></td><td><span style="font-size:.75rem">Classroom sponsor</span></td><td><span class="badge-status bs-completed"><span class="bs-dot"></span>Paid</span></td><td><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-download"></i></button></td></tr>
                  <tr><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:#7c3aed)">M</div><div><div style="font-weight:600;font-size:.82rem">Mohammed Hussain</div><div style="font-size:.68rem;color:var(--muted)">Zakat donation</div></div></div></td><td><span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">£75</span></td><td><span style="font-size:.75rem">One-time</span></td><td><span class="badge-status bs-inactive">N/A</span></td><td><span style="font-size:.73rem;color:var(--muted)">25 Oct</span></td><td><span style="font-size:.75rem">Orphan support</span></td><td><span class="badge-status bs-completed"><span class="bs-dot"></span>Paid</span></td><td><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-download"></i></button></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ LESSONS ═══════ -->
      <div id="view-lessons" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>Lessons</h1><p>Schedule, manage and track all one-to-one sessions</p></div>
          <button class="btn-gold-sm" onclick="openModal('add-lesson')"><i class="fas fa-plus"></i>Schedule Lesson</button>
        </div>
        <div class="row g-3 mb-4">
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--goldp)"><i class="fas fa-calendar-check" style="color:var(--gold)"></i></div><div class="sc-val">247</div><div class="sc-lbl">This Month</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--grnp)"><i class="fas fa-check-circle" style="color:var(--grn)"></i></div><div class="sc-val">231</div><div class="sc-lbl">Completed</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--ambp)"><i class="fas fa-clock" style="color:var(--amb)"></i></div><div class="sc-val">8</div><div class="sc-lbl">Upcoming Today</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--redp)"><i class="fas fa-times-circle" style="color:var(--red)"></i></div><div class="sc-val">8</div><div class="sc-lbl">Cancelled</div></div></div>
        </div>
        <div class="card">
          <div class="card-header-custom">
            <div class="card-title"><i class="fas fa-graduation-cap"></i>Today's Schedule</div>
            <div class="d-flex gap-2 align-items-center">
              <span style="font-size:.75rem;color:var(--muted)">Monday, 18 Nov 2025</span>
              <button class="btn-outline-sm"><i class="fas fa-calendar"></i>Calendar View</button>
            </div>
          </div>
          <div class="card-body-custom">
            <div class="table-wrap">
              <table class="data-table">
                <thead><tr><th>Time</th><th>Student</th><th>Tutor</th><th>Subject</th><th>Duration</th><th>Platform</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                  <tr><td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:.82rem">09:00 AM</span></td><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--gold);color:var(--s50);width:26px;height:26px;font-size:.7rem">Z</div>Zara Patel</div></td><td>Ustadha Fatima</td><td><span style="font-size:.78rem">Basic Qaida</span></td><td><span style="font-size:.75rem">30 min</span></td><td><span style="font-size:.75rem"><i class="fas fa-video" style="color:var(--blu)"></i> Zoom</span></td><td><span class="badge-status bs-completed"><span class="bs-dot"></span>Completed</span></td><td><button class="btn-outline-sm" style="padding:5px 10px;font-size:.68rem">Report</button></td></tr>
                  <tr><td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:.82rem">11:00 AM</span></td><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--teal);width:26px;height:26px;font-size:.7rem">I</div>Ibrahim Malik</div></td><td>Ustadh Bilal</td><td><span style="font-size:.78rem">Tajweed — Noon Sakinah</span></td><td><span style="font-size:.75rem">45 min</span></td><td><span style="font-size:.75rem"><i class="fas fa-video" style="color:var(--blu)"></i> Zoom</span></td><td><span class="badge-status bs-upcoming"><span class="bs-dot"></span>In Progress</span></td><td><button class="btn-success-sm" style="font-size:.68rem">Join</button></td></tr>
                  <tr><td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:.82rem">02:00 PM</span></td><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--blu);width:26px;height:26px;font-size:.7rem">S</div>Sara Ahmed</div></td><td>Ustadh Hassan</td><td><span style="font-size:.78rem">Quran Reading</span></td><td><span style="font-size:.75rem">45 min</span></td><td><span style="font-size:.75rem"><i class="fas fa-video" style="color:var(--blu)"></i> Teams</span></td><td><span class="badge-status bs-new"><span class="bs-dot"></span>Scheduled</span></td><td><button class="btn-outline-sm" style="padding:5px 10px;font-size:.68rem">Manage</button></td></tr>
                  <tr><td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:.82rem">04:00 PM</span></td><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:#7c3aed;width:26px;height:26px;font-size:.7rem">O</div>Omar Khan</div></td><td>Ustadh Mohammed</td><td><span style="font-size:.78rem">Hifz — Juz 1</span></td><td><span style="font-size:.75rem">60 min</span></td><td><span style="font-size:.75rem"><i class="fas fa-video" style="color:var(--blu)"></i> Zoom</span></td><td><span class="badge-status bs-new"><span class="bs-dot"></span>Scheduled</span></td><td><button class="btn-outline-sm" style="padding:5px 10px;font-size:.68rem">Manage</button></td></tr>
                  <tr><td><span style="font-family:'Syne',sans-serif;font-weight:700;font-size:.82rem">06:00 PM</span></td><td><div class="d-flex align-items-center gap-2"><div class="av" style="background:var(--red);width:26px;height:26px;font-size:.7rem">A</div>Amina Yusuf</div></td><td>Ustadha Fatima</td><td><span style="font-size:.78rem">Intro Qaida — Trial</span></td><td><span style="font-size:.75rem">30 min</span></td><td><span style="font-size:.75rem"><i class="fas fa-video" style="color:var(--blu)"></i> Zoom</span></td><td><span class="badge-status bs-new"><span class="bs-dot"></span>Scheduled</span></td><td><button class="btn-outline-sm" style="padding:5px 10px;font-size:.68rem">Manage</button></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ TUTORS ═══════ -->
      <div id="view-tutors" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>Tutors</h1><p>Manage tutor profiles, DBS checks and assignments</p></div>
          <button class="btn-gold-sm" onclick="openModal('add-tutor')"><i class="fas fa-plus"></i>Add Tutor</button>
        </div>
        <div class="row g-4">
          <div class="col-lg-4 col-md-6">
            <div class="card">
              <div class="card-body-custom pt-3">
                <div class="d-flex gap-3 align-items-start mb-3">
                  <div class="av" style="width:52px;height:52px;font-size:1.15rem;background:var(--gold);color:var(--s50);flex-shrink:0">B</div>
                  <div style="flex:1">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">Ustadh Bilal Ahmad</div>
                    <div style="font-size:.72rem;color:var(--muted)">bilal@meriteducation.org</div>
                    <div class="d-flex gap-2 mt-2"><span class="badge-status bs-active"><span class="bs-dot"></span>Active</span><span style="font-size:.65rem;background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-weight:700"><i class="fas fa-shield-alt"></i> DBS Valid</span></div>
                  </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
                  <div style="background:var(--bg);border-radius:8px;padding:10px;text-align:center"><div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--txt)">24</div><div style="font-size:.65rem;color:var(--muted)">Students</div></div>
                  <div style="background:var(--bg);border-radius:8px;padding:10px;text-align:center"><div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--txt)">4.9★</div><div style="font-size:.65rem;color:var(--muted)">Rating</div></div>
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:8px">Specialties</div>
                <div class="d-flex flex-wrap gap-1 mb-3"><span style="background:var(--goldp);color:var(--gold);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Tajweed</span><span style="background:var(--blup);color:var(--blu);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Hifz</span><span style="background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Arabic</span></div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:4px">DBS Expiry</div>
                <div style="font-size:.8rem;font-weight:600;color:var(--grn)">15 March 2027 <i class="fas fa-check-circle ms-1"></i></div>
                <div class="d-flex gap-2 mt-3"><button class="btn-prim btn-sm" style="flex:1">View Profile</button><button class="btn-outline-sm btn-sm">Assign</button></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card">
              <div class="card-body-custom pt-3">
                <div class="d-flex gap-3 align-items-start mb-3">
                  <div class="av" style="width:52px;height:52px;font-size:1.15rem;background:var(--teal);flex-shrink:0">F</div>
                  <div style="flex:1">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">Ustadha Fatima Noor</div>
                    <div style="font-size:.72rem;color:var(--muted)">fatima@meriteducation.org</div>
                    <div class="d-flex gap-2 mt-2"><span class="badge-status bs-active"><span class="bs-dot"></span>Active</span><span style="font-size:.65rem;background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-weight:700"><i class="fas fa-shield-alt"></i> DBS Valid</span></div>
                  </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
                  <div style="background:var(--bg);border-radius:8px;padding:10px;text-align:center"><div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--txt)">18</div><div style="font-size:.65rem;color:var(--muted)">Students</div></div>
                  <div style="background:var(--bg);border-radius:8px;padding:10px;text-align:center"><div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--txt)">4.8★</div><div style="font-size:.65rem;color:var(--muted)">Rating</div></div>
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:8px">Specialties</div>
                <div class="d-flex flex-wrap gap-1 mb-3"><span style="background:var(--goldp);color:var(--gold);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Qaida</span><span style="background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Sisters</span></div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:4px">DBS Expiry</div>
                <div style="font-size:.8rem;font-weight:600;color:var(--grn)">20 June 2026 <i class="fas fa-check-circle ms-1"></i></div>
                <div class="d-flex gap-2 mt-3"><button class="btn-prim btn-sm" style="flex:1">View Profile</button><button class="btn-outline-sm btn-sm">Assign</button></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card" style="border-color:rgba(229,57,53,.25)">
              <div class="card-body-custom pt-3">
                <div class="alert-custom alert-red mb-3" style="padding:8px 12px"><i class="fas fa-exclamation-triangle" style="color:var(--red);font-size:.8rem"></i><p style="font-size:.73rem">DBS expires in <strong>14 days</strong> — action required</p></div>
                <div class="d-flex gap-3 align-items-start mb-3">
                  <div class="av" style="width:52px;height:52px;font-size:1.15rem;background:#7c3aed;flex-shrink:0">M</div>
                  <div style="flex:1">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">Ustadh Mohammed Ali</div>
                    <div style="font-size:.72rem;color:var(--muted)">mohammed@meriteducation.org</div>
                    <div class="d-flex gap-2 mt-2"><span class="badge-status bs-active"><span class="bs-dot"></span>Active</span><span style="font-size:.65rem;background:var(--ambp);color:var(--amb);padding:3px 9px;border-radius:10px;font-weight:700"><i class="fas fa-exclamation"></i> DBS Expiring</span></div>
                  </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
                  <div style="background:var(--bg);border-radius:8px;padding:10px;text-align:center"><div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--txt)">31</div><div style="font-size:.65rem;color:var(--muted)">Students</div></div>
                  <div style="background:var(--bg);border-radius:8px;padding:10px;text-align:center"><div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--txt)">5.0★</div><div style="font-size:.65rem;color:var(--muted)">Rating</div></div>
                </div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:4px">DBS Expiry</div>
                <div style="font-size:.8rem;font-weight:600;color:var(--red)">2 December 2025 <i class="fas fa-exclamation-circle ms-1"></i></div>
                <div class="d-flex gap-2 mt-3"><button class="btn-danger-sm" style="flex:1"><i class="fas fa-shield-alt"></i>Renew DBS</button><button class="btn-outline-sm btn-sm">Profile</button></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ NEWS / ARTICLES ═══════ -->
      <div id="view-news" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>News & Articles</h1><p>Publish and manage website content</p></div>
          <button class="btn-gold-sm" onclick="openModal('add-article')"><i class="fas fa-pen"></i>New Article</button>
        </div>
        <div class="card">
          <div class="card-header-custom"><div class="card-title"><i class="fas fa-newspaper"></i>All Articles</div>
            <div class="tab-bar" style="margin:0;width:auto"><button class="tab-btn active" style="padding:6px 16px;font-size:.72rem">All</button><button class="tab-btn" style="padding:6px 16px;font-size:.72rem">Published</button><button class="tab-btn" style="padding:6px 16px;font-size:.72rem">Drafts</button></div>
          </div>
          <div class="card-body-custom">
            <div class="table-wrap">
              <table class="data-table">
                <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>Views</th><th>Status</th><th>Published</th><th>Actions</th></tr></thead>
                <tbody>
                  <tr><td><div style="font-weight:600;font-size:.82rem;max-width:280px">5,000 Students Reached: Merit Celebrates Major Milestone</div></td><td><span style="background:var(--goldp);color:var(--gold);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Impact</span></td><td><span style="font-size:.78rem">Dr. Aisha Rahman</span></td><td><span style="font-size:.78rem">2,340</span></td><td><span class="badge-status bs-active"><span class="bs-dot"></span>Published</span></td><td><span style="font-size:.73rem;color:var(--muted)">15 Nov 2025</span></td><td><div class="d-flex gap-1"><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-edit"></i></button><button class="btn-danger-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-trash"></i></button></div></td></tr>
                  <tr><td><div style="font-weight:600;font-size:.82rem;max-width:280px">New Tajweed Programme Launches for Advanced Students</div></td><td><span style="background:var(--blup);color:var(--blu);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Quran</span></td><td><span style="font-size:.78rem">Mohammed Hassan</span></td><td><span style="font-size:.78rem">876</span></td><td><span class="badge-status bs-active"><span class="bs-dot"></span>Published</span></td><td><span style="font-size:.73rem;color:var(--muted)">28 Sep 2025</span></td><td><div class="d-flex gap-1"><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-edit"></i></button><button class="btn-danger-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-trash"></i></button></div></td></tr>
                  <tr><td><div style="font-weight:600;font-size:.82rem;max-width:280px">Ramadan Campaign 2025 — Draft</div></td><td><span style="background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-size:.65rem;font-weight:700">Charity</span></td><td><span style="font-size:.78rem">Zara Ahmed</span></td><td><span style="font-size:.78rem">—</span></td><td><span class="badge-status bs-pending"><span class="bs-dot"></span>Draft</span></td><td><span style="font-size:.73rem;color:var(--muted)">Not published</span></td><td><div class="d-flex gap-1"><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-edit"></i></button><button class="btn-success-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-globe"></i></button></div></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ SETTINGS ═══════ -->
      <div id="view-settings" class="view">
        <div class="page-header"><h1>Settings</h1><p>Manage system, account and organisation preferences</p></div>
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="card mb-4">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-building"></i>Organisation Details</div><button class="btn-prim"><i class="fas fa-save"></i>Save</button></div>
              <div class="card-body-custom">
                <div class="row g-3">
                  <div class="col-md-6"><div class="f-group"><label class="f-label">Organisation Name</label><input type="text" class="f-input" value="Merit Education Foundation"></div></div>
                  <div class="col-md-6"><div class="f-group"><label class="f-label">Charity Number</label><input type="text" class="f-input" value="1234567"></div></div>
                  <div class="col-md-6"><div class="f-group"><label class="f-label">Primary Email</label><input type="email" class="f-input" value="info@meriteducation.org"></div></div>
                  <div class="col-md-6"><div class="f-group"><label class="f-label">Phone</label><input type="tel" class="f-input" value="+44 20 0000 0000"></div></div>
                  <div class="col-12"><div class="f-group"><label class="f-label">Address</label><textarea class="f-textarea" rows="2">Merit House, London, United Kingdom</textarea></div></div>
                </div>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-bell"></i>Notification Preferences</div></div>
              <div class="card-body-custom">
                <div class="setting-row"><div class="sr-info"><h6>New Student Registration</h6><p>Alert when a new student signs up</p></div><label class="toggle-sw"><input type="checkbox" checked><span class="toggle-sl"></span></label></div>
                <div class="setting-row"><div class="sr-info"><h6>Donation Received</h6><p>Notify on every new donation</p></div><label class="toggle-sw"><input type="checkbox" checked><span class="toggle-sl"></span></label></div>
                <div class="setting-row"><div class="sr-info"><h6>Safeguarding Alerts</h6><p>Immediate notification on safeguarding submissions</p></div><label class="toggle-sw"><input type="checkbox" checked><span class="toggle-sl"></span></label></div>
                <div class="setting-row"><div class="sr-info"><h6>DBS Expiry Warnings</h6><p>Remind 30 days and 7 days before expiry</p></div><label class="toggle-sw"><input type="checkbox" checked><span class="toggle-sl"></span></label></div>
                <div class="setting-row"><div class="sr-info"><h6>Weekly Summary Report</h6><p>Email digest every Monday morning</p></div><label class="toggle-sw"><input type="checkbox"><span class="toggle-sl"></span></label></div>
              </div>
            </div>
            <div class="card">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-shield"></i>Admin Profile</div><button class="btn-gold-sm"><i class="fas fa-save"></i>Update</button></div>
              <div class="card-body-custom">
                <div class="d-flex align-items-center gap-4 mb-4">
                  <div class="av" style="width:64px;height:64px;font-size:1.4rem;background:linear-gradient(135deg,var(--gold),var(--s200))">SA</div>
                  <div><button class="btn-outline-sm btn-sm"><i class="fas fa-upload"></i>Upload Photo</button></div>
                </div>
                <div class="row g-3">
                  <div class="col-md-6"><div class="f-group"><label class="f-label">Full Name</label><input type="text" class="f-input" value="Super Admin"></div></div>
                  <div class="col-md-6"><div class="f-group"><label class="f-label">Email</label><input type="email" class="f-input" value="admin@meriteducation.org"></div></div>
                  <div class="col-md-4"><div class="f-group"><label class="f-label">Current Password</label><input type="password" class="f-input" placeholder="••••••••"></div></div>
                  <div class="col-md-4"><div class="f-group"><label class="f-label">New Password</label><input type="password" class="f-input" placeholder="••••••••"></div></div>
                  <div class="col-md-4"><div class="f-group"><label class="f-label">Confirm Password</label><input type="password" class="f-input" placeholder="••••••••"></div></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card mb-4">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-info-circle"></i>System Info</div></div>
              <div class="card-body-custom">
                <div class="setting-row" style="padding:10px 0"><div class="sr-info"><h6>Version</h6><p>Merit Admin v2.4.1</p></div></div>
                <div class="setting-row" style="padding:10px 0"><div class="sr-info"><h6>Last Backup</h6><p>Today, 03:00 AM</p></div><span style="font-size:.65rem;background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-weight:700">OK</span></div>
                <div class="setting-row" style="padding:10px 0"><div class="sr-info"><h6>GDPR Status</h6><p>UK GDPR Compliant</p></div><span style="font-size:.65rem;background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-weight:700">Active</span></div>
                <div class="setting-row" style="padding:10px 0"><div class="sr-info"><h6>SSL Certificate</h6><p>Expires 1 June 2026</p></div><span style="font-size:.65rem;background:var(--grnp);color:var(--grn);padding:3px 9px;border-radius:10px;font-weight:700">Valid</span></div>
              </div>
            </div>
            <div class="card">
              <div class="card-header-custom"><div class="card-title"><i class="fas fa-user-shield"></i>Admin Users</div><button class="btn-gold-sm btn-sm" onclick="openModal('add-admin')"><i class="fas fa-plus"></i>Add</button></div>
              <div class="card-body-custom">
                <div class="d-flex align-items-center gap-3 p-2 border-bottom" style="border-color:var(--border)!important;margin-bottom:10px">
                  <div class="av" style="background:linear-gradient(135deg,var(--gold),var(--s200));color:var(--s50)">SA</div>
                  <div style="flex:1"><div style="font-size:.82rem;font-weight:600">Super Admin</div><div style="font-size:.68rem;color:var(--muted)">Super Admin</div></div>
                  <span class="badge-status bs-active" style="font-size:.6rem">You</span>
                </div>
                <div class="d-flex align-items-center gap-3 p-2 border-bottom" style="border-color:var(--border)!important;margin-bottom:10px">
                  <div class="av" style="background:var(--teal)">Z</div>
                  <div style="flex:1"><div style="font-size:.82rem;font-weight:600">Zara Ahmed</div><div style="font-size:.68rem;color:var(--muted)">Manager</div></div>
                  <button class="btn-danger-sm" style="padding:3px 8px;font-size:.62rem"><i class="fas fa-ban"></i></button>
                </div>
                <div class="d-flex align-items-center gap-3 p-2">
                  <div class="av" style="background:var(--blu)">K</div>
                  <div style="flex:1"><div style="font-size:.82rem;font-weight:600">Khalid Osei</div><div style="font-size:.68rem;color:var(--muted)">Staff</div></div>
                  <button class="btn-danger-sm" style="padding:3px 8px;font-size:.62rem"><i class="fas fa-ban"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PLACEHOLDER VIEWS -->
      <div id="view-donors" class="view"><div class="page-header"><h1>Donors</h1><p>Manage donor profiles and communication</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Donor management module — 156 donors registered. Filter, export, and manage Gift Aid declarations from this panel.</p></div></div>
      <div id="view-users" class="view"><div class="page-header"><h1>All Users</h1><p>Manage all registered users (parents, students, donors)</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>User management module — 342 total registered accounts across all roles.</p></div></div>
      <div id="view-bookings" class="view"><div class="page-header"><h1>Bookings</h1><p>Manage lesson booking requests and approvals</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>3 new booking requests awaiting approval. Review each request before confirming tutor assignment.</p></div></div>
      <div id="view-reports" class="view"><div class="page-header"><h1>Reports & Analytics</h1><p>Detailed impact reports, financial summaries and Gift Aid tracking</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Generate monthly impact reports, financial statements, and HMRC Gift Aid submissions from this module.</p></div></div>
      <div id="view-safeguarding" class="view"><div class="page-header"><h1>Safeguarding</h1><p>Review incidents, DBS status and safeguarding submissions</p></div><div class="alert-custom alert-red"><i class="fas fa-shield-alt" style="color:var(--red)"></i><p><strong>1 new safeguarding submission</strong> requires review by the DSL within 24 hours.</p></div></div>
      <div id="view-messages" class="view"><div class="page-header"><h1>Messages</h1><p>Enquiries, contact forms and internal communications</p></div><div class="alert-custom alert-gold"><i class="fas fa-envelope" style="color:var(--gold)"></i><p>5 unread messages from the contact form. Respond within 24 hours as per policy.</p></div></div>
      <div id="view-admins" class="view"><div class="page-header"><h1>Admin Users</h1><p>Manage admin accounts and role permissions</p></div><div class="alert-custom alert-gold"><i class="fas fa-user-shield" style="color:var(--gold)"></i><p>3 active admin accounts. Assign roles, manage permissions and monitor activity logs.</p></div></div>

    </div><!-- main-inner -->
  </main>
@endsection