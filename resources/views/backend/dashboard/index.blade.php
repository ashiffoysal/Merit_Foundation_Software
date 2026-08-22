@extends('layouts.backend')
@section('content')

    <div class="main-inner">
      <!-- ═══════ DASHBOARD ═══════ -->
      <div id="" class="">
        <div class="page-header">
          <h1>Dashboard Overview</h1>
          <p>Welcome back, Super Admin. Here's what's happening at Merit today.</p>
        </div>

        {{-- DBS alert: no `tutors`/DBS table exists in the schema, so this
             stays static. Wire it up once a tutors table with a dbs_expiry
             column is added. --}}
        <div class="alert-custom alert-gold mb-4">
          <i class="fas fa-exclamation-triangle" style="color:var(--gold)"></i>
          <p><strong>Action Required:</strong> Ustadh Mohammed's DBS check expires in 14 days. <span style="color:var(--gold);cursor:pointer;font-weight:700">Renew now →</span></p>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-1">
              <div class="sc-icon" style="background:var(--goldp)"><i class="fas fa-user-graduate" style="color:var(--gold)"></i></div>
              <div class="sc-val">{{ number_format($activeStudents) }}</div>
              <div class="sc-lbl">Active Students</div>
              <div class="sc-change {{ $newStudentsThisMonth >= 0 ? 'up' : 'dn' }}">
                <i class="fas fa-arrow-{{ $newStudentsThisMonth >= 0 ? 'up' : 'down' }}"></i>+{{ $newStudentsThisMonth }} this month
              </div>
            </div>
          </div>
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-2">
              <div class="sc-icon" style="background:rgba(12,122,112,.1)"><i class="fas fa-heart" style="color:var(--teal)"></i></div>
              <div class="sc-val">£{{ number_format($donationsThisMonth, 0) }}</div>
              <div class="sc-lbl">Donations This Month</div>
              @if(is_null($donationsChangePct))
                <div class="sc-change neu"><i class="fas fa-minus"></i>No prior month to compare</div>
              @else
                <div class="sc-change {{ $donationsChangePct >= 0 ? 'up' : 'dn' }}">
                  <i class="fas fa-arrow-{{ $donationsChangePct >= 0 ? 'up' : 'down' }}"></i>{{ $donationsChangePct >= 0 ? '+' : '' }}{{ $donationsChangePct }}% vs last month
                </div>
              @endif
            </div>
          </div>
          {{-- Lessons: no `lessons` table exists in the schema. Left static.
               Add a lessons table (student_id, tutor_id, status, scheduled_at)
               to make this dynamic. --}}
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-3">
              <div class="sc-icon" style="background:var(--redp)"><i class="fas fa-graduation-cap" style="color:var(--red)"></i></div>
              <div class="sc-val">—</div>
              <div class="sc-lbl">Lessons This Month</div>
              <div class="sc-change neu"><i class="fas fa-minus"></i>No lessons table in schema</div>
            </div>
          </div>
          {{-- Tutors: no `tutors` table exists in the schema. Left static.
               Add a tutors table to make this dynamic. --}}
          <div class="col-6 col-xl-3">
            <div class="stat-card stat-card-4">
              <div class="sc-icon" style="background:var(--blup)"><i class="fas fa-chalkboard-teacher" style="color:var(--blu)"></i></div>
              <div class="sc-val">—</div>
              <div class="sc-lbl">Active Tutors</div>
              <div class="sc-change neu"><i class="fas fa-minus"></i>No tutors table in schema</div>
            </div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <!-- Revenue Chart (transactions table, last 6 months) -->
          <div class="col-lg-7">
            <div class="card">
              <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-chart-bar"></i>Monthly Donations & Revenue</div>
                <div class="d-flex gap-2">
                  <span style="font-size:.65rem;background:var(--goldp);color:var(--gold);padding:4px 10px;border-radius:20px;font-weight:700">Donations</span>
                </div>
              </div>
              <div class="card-body-custom">
                <div class="bar-chart" id="bar-chart" style="display:flex;align-items:flex-end;gap:10px;height:180px">
                  @foreach($monthlyRevenue as $m)
                    @php $heightPct = $maxMonthlyRevenue > 0 ? max(4, ($m['value'] / $maxMonthlyRevenue) * 100) : 4; @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;height:100%;justify-content:flex-end">
                      <span style="font-size:.65rem;color:var(--muted);font-weight:700">£{{ number_format($m['value'], 0) }}</span>
                      <div style="width:100%;max-width:34px;height:{{ $heightPct }}%;background:var(--gold);border-radius:6px 6px 0 0" title="£{{ number_format($m['value'], 2) }}"></div>
                      <span style="font-size:.7rem;color:var(--muted)">{{ $m['label'] }}</span>
                    </div>
                  @endforeach
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
                {{-- Fund Allocation %: transactions has no "purpose"/category
                     column, so these percentages are static placeholders.
                     Add a `category` column to `transactions` to make this
                     dynamic. --}}
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
                  <div style="display:flex;justify-content:space-between;font-size:.75rem;margin-bottom:6px">
                    <span style="color:var(--muted)">Total Donations {{ now()->year }}</span>
                    <span style="font-weight:700;color:var(--txt)">£{{ number_format($totalDonationsThisYear, 0) }}</span>
                  </div>
                  {{-- Gift Aid: no gift_aid column/table exists in the schema. --}}
                  <div style="display:flex;justify-content:space-between;font-size:.75rem">
                    <span style="color:var(--muted)">Gift Aid Claimed</span>
                    <span style="font-weight:700;color:var(--muted)">N/A</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4">
          <!-- Recent Students (users table) -->
          <div class="col-lg-8">
            <div class="card">
              <div class="card-header-custom">
                <div class="card-title"><i class="fas fa-user-graduate"></i>Recent Registrations</div>
                <button class="btn-prim" onclick="showView('students',null)"><i class="fas fa-arrow-right"></i>View All</button>
              </div>
              <div class="card-body-custom">
                <div class="table-wrap">
                  <table class="data-table">
                    <thead><tr><th>Student</th><th>Level</th><th>Status</th><th>Joined</th><th></th></tr></thead>
                    <tbody>
                      @forelse($recentUsers as $u)
                        @php
                          $initial = strtoupper(substr($u->name ?: 'U', 0, 1));
                          $avatarColors = ['var(--gold)', 'var(--teal)', 'var(--blu)', '#7c3aed', 'var(--red)'];
                          $avatarColor = $avatarColors[$u->id % count($avatarColors)];
                        @endphp
                        <tr>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <div class="av" style="background:{{ $avatarColor }};color:var(--s50)">{{ $initial }}</div>
                              <div>
                                <div style="font-weight:600;font-size:.82rem">{{ trim("{$u->name} {$u->last_name}") }}</div>
                                <div style="font-size:.68rem;color:var(--muted)">{{ $u->email }}</div>
                              </div>
                            </div>
                          </td>
                          <td><span style="font-size:.78rem">{{ $u->quran_level ?: 'Not set' }}</span></td>
                          <td>
                            @if($u->is_active)
                              <span class="badge-status bs-active"><span class="bs-dot"></span>Active</span>
                            @else
                              <span class="badge-status bs-pending"><span class="bs-dot"></span>Inactive</span>
                            @endif
                          </td>
                          <td><span style="font-size:.73rem;color:var(--muted)">{{ $u->created_at->diffForHumans() }}</span></td>
                          <td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td>
                        </tr>
                      @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">No students registered yet.</td></tr>
                      @endforelse
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
                @forelse($activity as $a)
                  <div class="activity-row">
                    <div class="ar-ic" style="background:{{ $a['icon_bg'] }}"><i class="fas {{ $a['icon'] }}" style="color:{{ $a['icon_col'] }}"></i></div>
                    <div>
                      <div class="ar-txt">{!! $a['text'] !!}</div>
                      <div class="ar-time">{{ $a['time']->diffForHumans() }}</div>
                    </div>
                  </div>
                @empty
                  <p class="text-muted small mb-0">No recent activity.</p>
                @endforelse
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
              <div class="col-md-2"><div class="f-group mb-0"><label class="f-label">Tutor</label><select class="f-select"><option>All Tutors</option></select></div></div>
              <div class="col-md-3 d-flex gap-2"><button class="btn-prim" style="flex:1"><i class="fas fa-filter"></i>Filter</button><button class="btn-outline-sm"><i class="fas fa-download"></i>Export</button></div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header-custom">
            <div class="card-title">
              <i class="fas fa-user-graduate"></i>All Students
              <span style="font-size:.72rem;background:var(--bg);color:var(--muted);padding:3px 10px;border-radius:20px;margin-left:8px;font-weight:600">{{ number_format($students->total()) }} total</span>
            </div>
          </div>
          <div class="card-body-custom">
            <div class="table-wrap">
              {{-- "Tutor", "Progress" and "Next Lesson" have no backing
                   column/table in the current schema — shown as N/A rather
                   than invented. "Type" is inferred from whether the user
                   has an active subscription. --}}
              <table class="data-table">
                <thead><tr><th><input type="checkbox" style="accent-color:var(--gold)"></th><th>Student</th><th>Age</th><th>Level</th><th>Tutor</th><th>Type</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
                <tbody id="students-tbody">
                  @forelse($students as $s)
                    @php $initial = strtoupper(substr($s->name ?: 'U', 0, 1)); @endphp
                    <tr>
                      <td><input type="checkbox" style="accent-color:var(--gold)"></td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="av" style="background:var(--gold);color:var(--s50)">{{ $initial }}</div>
                          <div>
                            <div style="font-weight:600;font-size:.82rem">{{ trim("{$s->name} {$s->last_name}") }}</div>
                            <div style="font-size:.68rem;color:var(--muted)">{{ $s->email }}</div>
                          </div>
                        </div>
                      </td>
                      <td><span style="font-size:.78rem">{{ $s->age ?: '—' }}</span></td>
                      <td><span style="font-size:.78rem">{{ $s->quran_level ?: 'Not set' }}</span></td>
                      <td><span style="font-size:.78rem;color:var(--muted)">N/A</span></td>
                      <td><span style="font-size:.78rem">{{ $s->pm_type ? 'Paying' : 'Unassigned' }}</span></td>
                      <td>
                        @if($s->is_active)
                          <span class="badge-status bs-active"><span class="bs-dot"></span>Active</span>
                        @else
                          <span class="badge-status bs-pending"><span class="bs-dot"></span>Inactive</span>
                        @endif
                      </td>
                      <td><span style="font-size:.73rem;color:var(--muted)"></span></td>
                      <td><button class="btn-outline-sm" style="padding:5px 12px;font-size:.7rem" onclick="openModal('student')">View</button></td>
                    </tr>
                  @empty
                    <tr><td colspan="9" class="text-center text-muted py-3">No students found.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2" style="border-top:1px solid var(--border)">
              <span style="font-size:.75rem;color:var(--muted)">
                Showing {{ $students->firstItem() ?? 0 }}–{{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
              </span>
              <div class="d-flex gap-2">
                {{ $students->onEachSide(1)->links() }}
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
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--goldp)"><i class="fas fa-pound-sign" style="color:var(--gold)"></i></div><div class="sc-val">£{{ number_format($totalDonationsThisYear, 0) }}</div><div class="sc-lbl">Total {{ now()->year }}</div></div></div>
          {{-- Gift Aid has no data source in this schema --}}
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--grnp)"><i class="fas fa-gift" style="color:var(--grn)"></i></div><div class="sc-val">N/A</div><div class="sc-lbl">Gift Aid Claimed</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:var(--blup)"><i class="fas fa-sync" style="color:var(--blu)"></i></div><div class="sc-val">{{ number_format($monthlyDonorsCount) }}</div><div class="sc-lbl">Monthly Donors</div></div></div>
          <div class="col-6 col-lg-3"><div class="stat-card"><div class="sc-icon" style="background:rgba(12,122,112,.1)"><i class="fas fa-hand-holding-heart" style="color:var(--teal)"></i></div><div class="sc-val">{{ number_format($totalDonorsCount) }}</div><div class="sc-lbl">Total Donors</div></div></div>
        </div>
        <div class="card">
          <div class="card-header-custom">
            <div class="card-title"><i class="fas fa-heart"></i>Donation Records</div>
            <div class="d-flex gap-2">
              <button class="btn-outline-sm"><i class="fas fa-download"></i>Export CSV</button>
            </div>
          </div>
          <div class="card-body-custom">
            <div class="table-wrap">
              {{-- "Gift Aid" and "Purpose" columns have no data source in
                   the schema; "Type" is not distinguished from one-off vs
                   recurring in `transactions`, so it's omitted rather than
                   guessed. --}}
              <table class="data-table">
                <thead><tr><th>Donor</th><th>Amount</th><th>Currency</th><th>Date</th><th>Status</th><th>Invoice</th></tr></thead>
                <tbody>
                  @forelse($donations as $d)
                    @php
                      $donorName = $d->user ? trim("{$d->user->name} {$d->user->last_name}") : 'Unknown';
                      $initial = strtoupper(substr($donorName, 0, 1));
                      $badgeMap = ['paid' => 'bs-completed', 'pending' => 'bs-pending', 'failed' => 'bs-inactive'];
                      $badgeClass = $badgeMap[strtolower($d->status)] ?? 'bs-pending';
                    @endphp
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="av" style="background:var(--s200)">{{ $initial }}</div>
                          <div>
                            <div style="font-weight:600;font-size:.82rem">{{ $donorName }}</div>
                            <div style="font-size:.68rem;color:var(--muted)">{{ $d->user->email ?? '—' }}</div>
                          </div>
                        </div>
                      </td>
                      <td><span style="font-family:'Syne',sans-serif;font-weight:700;color:var(--txt)">£{{ number_format($d->amount, 2) }}</span></td>
                      <td><span style="font-size:.75rem">{{ $d->currency }}</span></td>
                      <td><span style="font-size:.73rem;color:var(--muted)">{{ $d->created_at->format('d M Y') }}</span></td>
                      <td><span class="badge-status {{ $badgeClass }}"><span class="bs-dot"></span>{{ ucfirst($d->status) }}</span></td>
                      <td><span style="font-size:.72rem;color:var(--muted)">{{ $d->stripe_invoice_id }}</span></td>
                    </tr>
                  @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">No donations recorded yet.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3 pt-2" style="border-top:1px solid var(--border)">
              <span style="font-size:.75rem;color:var(--muted)">
                Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }} donations
              </span>
              <div class="d-flex gap-2">
                {{ $donations->onEachSide(1)->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ LESSONS ═══════ (no `lessons` table in schema — left static) -->
      <div id="view-lessons" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>Lessons</h1><p>Schedule, manage and track all one-to-one sessions</p></div>
        </div>
        <div class="alert-custom alert-gold">
          <i class="fas fa-info-circle" style="color:var(--gold)"></i>
          <p>Lesson scheduling requires a <code>lessons</code> table (student_id, tutor_id, subject, scheduled_at, status) which doesn't exist in the current schema yet. Add it to make this view dynamic.</p>
        </div>
      </div>

      <!-- ═══════ TUTORS ═══════ (no `tutors` table in schema — left static) -->
      <div id="view-tutors" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>Tutors</h1><p>Manage tutor profiles, DBS checks and assignments</p></div>
        </div>
        <div class="alert-custom alert-gold">
          <i class="fas fa-info-circle" style="color:var(--gold)"></i>
          <p>Tutor profiles, ratings, specialties and DBS tracking require a <code>tutors</code> table which doesn't exist in the current schema yet. Add it to make this view dynamic.</p>
        </div>
      </div>

      <!-- ═══════ NEWS / ARTICLES ═══════ (no `articles` table in schema — left static) -->
      <div id="view-news" class="view">
        <div class="page-header d-flex align-items-start justify-content-between">
          <div><h1>News & Articles</h1><p>Publish and manage website content</p></div>
        </div>
        <div class="alert-custom alert-gold">
          <i class="fas fa-info-circle" style="color:var(--gold)"></i>
          <p>Articles require an <code>articles</code> table (title, category, author, status, published_at) which doesn't exist in the current schema yet. Add it to make this view dynamic.</p>
        </div>
      </div>

      <!-- ═══════ SETTINGS ═══════ (organisation/admin data not in schema — left static) -->
      <div id="view-settings" class="view">
        <div class="page-header"><h1>Settings</h1><p>Manage system, account and organisation preferences</p></div>
        <div class="alert-custom alert-gold">
          <i class="fas fa-info-circle" style="color:var(--gold)"></i>
          <p>Organisation details, notification preferences and admin roles need a dedicated <code>settings</code>/<code>organisations</code> table — none exists in the current schema. Wire this view up once that table is added.</p>
        </div>
      </div>

      <!-- PLACEHOLDER VIEWS -->
      <div id="view-donors" class="view"><div class="page-header"><h1>Donors</h1><p>Manage donor profiles and communication</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>{{ number_format($totalDonorsCount) }} distinct donors on record (users with at least one transaction).</p></div></div>
      <div id="view-users" class="view"><div class="page-header"><h1>All Users</h1><p>Manage all registered users</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>{{ number_format(\App\Models\User::count()) }} total registered accounts.</p></div></div>
      <div id="view-bookings" class="view"><div class="page-header"><h1>Bookings</h1><p>Manage lesson booking requests and approvals</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Requires a bookings/lessons table — not present in the current schema.</p></div></div>
      <div id="view-reports" class="view"><div class="page-header"><h1>Reports & Analytics</h1><p>Detailed impact reports, financial summaries and Gift Aid tracking</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Financial summaries can be built from <code>transactions</code>; Gift Aid/impact reporting needs additional tables.</p></div></div>
      <div id="view-safeguarding" class="view"><div class="page-header"><h1>Safeguarding</h1><p>Review incidents, DBS status and safeguarding submissions</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Requires a safeguarding/incidents table — not present in the current schema.</p></div></div>
      <div id="view-messages" class="view"><div class="page-header"><h1>Messages</h1><p>Enquiries, contact forms and internal communications</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Requires a messages table — not present in the current schema.</p></div></div>
      <div id="view-admins" class="view"><div class="page-header"><h1>Admin Users</h1><p>Manage admin accounts and role permissions</p></div><div class="alert-custom alert-gold"><i class="fas fa-info-circle" style="color:var(--gold)"></i><p>Requires an admin roles/permissions table — not present in the current schema.</p></div></div>

    </div><!-- main-inner -->
@endsection