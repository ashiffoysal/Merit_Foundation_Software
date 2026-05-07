<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Merit Admin — Control Panel</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('backend/backend.css') }}"/>
</head>
<body>

<!-- Loader -->
<div id="pg-loader">
  <div class="pl-brand">MERIT ADMIN</div>
  <div class="pl-track"><div class="pl-bar"></div></div>
</div>

<!-- ════════════ LOGIN SCREEN ════════════ -->


<!-- ════════════ ADMIN SHELL ════════════ -->
<div id="">

  <!-- SIDEBAR -->
  @include('backend.include.sidebar')

  <!-- TOPBAR -->
  @include('backend.include.topbar')

  <!-- NOTIFICATION PANEL -->
  @include('backend.include.notification')

  <!-- MAIN CONTENT -->
    <main id="main-content">
        @yield('content')
    </main>

  <!-- MODAL -->
  <div class="modal-overlay" id="modal-overlay" onclick="closeModal(event)">
    <div class="modal-box" id="modal-box">
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
      <div class="modal-title" id="modal-title">Add Student</div>
      <div class="modal-sub" id="modal-sub">Fill in the details below</div>
      <div id="modal-body"></div>
    </div>
  </div>

</div><!-- admin-shell -->

<script>
/* ── Loader */
window.addEventListener('load',()=>setTimeout(()=>{document.getElementById('pg-loader').classList.add('done')},1200));

/* ── Login */
let selectedRole='Super Admin';
function setRole(btn,role){
  document.querySelectorAll('.role-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  selectedRole=role;
}
function toggleLPw(){
  const inp=document.getElementById('lpw');
  const ic=document.getElementById('lpe-icon');
  inp.type=inp.type==='password'?'text':'password';
  ic.className=inp.type==='text'?'fas fa-eye-slash':'fas fa-eye';
}
function doLogin(){
  document.getElementById('login-screen').classList.remove('active');
  document.getElementById('admin-shell').classList.add('active');
  document.getElementById('admin-shell').style.display='flex';
}
function doLogout(){
  document.getElementById('admin-shell').classList.remove('active');
  document.getElementById('admin-shell').style.display='none';
  document.getElementById('login-screen').classList.add('active');
}

/* ── Sidebar */
let sbCollapsed=false;
function toggleSidebar(){
  sbCollapsed=!sbCollapsed;
  document.getElementById('sidebar').classList.toggle('collapsed',sbCollapsed);
  document.getElementById('topbar').classList.toggle('collapsed-offset',sbCollapsed);
  document.getElementById('main-content').classList.toggle('collapsed-offset',sbCollapsed);
}

/* ── Views */
function showView(id,el){
  document.querySelectorAll('.view').forEach(v=>v.classList.remove('active'));
  const v=document.getElementById('view-'+id);
  if(v)v.classList.add('active');
  document.querySelectorAll('.sb-item').forEach(i=>i.classList.remove('active'));
  if(el)el.classList.add('active');
  document.getElementById('breadcrumb').textContent=id.charAt(0).toUpperCase()+id.slice(1).replace(/-/g,' ');
  document.getElementById('notif-panel').classList.remove('open');
  document.querySelector('.mob-menu')?.classList?.remove('mob-open');
}

/* ── Notifications */
function toggleNotif(){
  document.getElementById('notif-panel').classList.toggle('open');
}

/* ── Dark mode */
let dark=false;
function toggleDark(){
  dark=!dark;
  document.documentElement.style.setProperty('--bg',dark?'#111827':'#F0F2F8');
  document.documentElement.style.setProperty('--card',dark?'#1F2937':'#FFFFFF');
  document.documentElement.style.setProperty('--border',dark?'#374151':'#E2E6F0');
  document.documentElement.style.setProperty('--txt',dark?'#F9FAFB':'#0F1A3E');
  document.documentElement.style.setProperty('--muted',dark?'#9CA3AF':'#6B7399');
  document.getElementById('dark-btn').querySelector('i').className=dark?'fas fa-sun':'fas fa-moon';
}

/* ── Bar Chart */
const months=['Jul','Aug','Sep','Oct','Nov'];
const donations=[2200,3100,2800,3900,4820];
const lessons=[3200,3800,4100,4500,4820];
const maxVal=Math.max(...donations,...lessons);
function buildChart(){
  const el=document.getElementById('bar-chart');
  if(!el)return;
  el.innerHTML='';
  months.forEach((m,i)=>{
    const col=document.createElement('div');
    col.className='bar-col';
    col.innerHTML=`
      <div class="bar-val" style="font-size:.6rem">£${(donations[i]/1000).toFixed(1)}k</div>
      <div style="display:flex;gap:4px;align-items:flex-end;flex:1;width:100%">
        <div class="bar-fill" style="background:var(--gold);height:${(donations[i]/maxVal)*100}%;flex:1"></div>
        <div class="bar-fill" style="background:var(--teal);height:${(lessons[i]/maxVal)*100}%;flex:1;opacity:.6"></div>
      </div>
      <div class="bar-lbl">${m}</div>`;
    el.appendChild(col);
  });
}

/* ── Students Table */
const studs=[
  {name:'Amina Yusuf',email:'amina@email.com',age:9,level:'Basic Qaida',tutor:'Ustadha Fatima',type:'Paying',prog:15,status:'new'},
  {name:'Ibrahim Malik',email:'via parent',age:9,level:'Tajweed',tutor:'Ustadh Bilal',type:'Paying',prog:68,status:'active'},
  {name:'Sara Ahmed',email:'sara.a@email.com',age:12,level:'Quran Reading',tutor:'Ustadh Hassan',type:'Paying',prog:42,status:'active'},
  {name:'Omar Khan',email:'Charity place',age:8,level:'Hifz',tutor:'Ustadh Mohammed',type:'Charity',prog:25,status:'active'},
  {name:'Zara Patel',email:'zara.p@email.com',age:7,level:'Basic Qaida',tutor:'Ustadha Fatima',type:'Paying',prog:8,status:'pending'},
  {name:'Fatima Al-Hassan',email:'f.alhassan@email.com',age:16,level:'Tajweed',tutor:'Ustadh Bilal',type:'Charity',prog:88,status:'active'},
  {name:'Yusuf Rahman',email:'y.rahman@email.com',age:11,level:'Quran Reading',tutor:'Ustadh Hassan',type:'Paying',prog:55,status:'active'},
];
const colors=['var(--gold)','var(--teal)','var(--blu)','#7c3aed','var(--red)','var(--amb)','var(--grn)'];
function buildStudents(){
  const tb=document.getElementById('students-tbody');
  if(!tb)return;
  tb.innerHTML=studs.map((s,i)=>`
    <tr>
      <td><input type="checkbox" style="accent-color:var(--gold)"></td>
      <td><div class="d-flex align-items-center gap-2"><div class="av" style="background:${colors[i%colors.length]};color:${i===0||i===5?'var(--s50)':'#fff'}">${s.name[0]}</div><div><div style="font-weight:600;font-size:.82rem">${s.name}</div><div style="font-size:.68rem;color:var(--muted)">${s.email}</div></div></div></td>
      <td><span style="font-size:.82rem">${s.age}</span></td>
      <td><span style="font-size:.78rem">${s.level}</span></td>
      <td><span style="font-size:.78rem">${s.tutor}</span></td>
      <td><span style="font-size:.7rem;padding:3px 9px;border-radius:10px;font-weight:700;background:${s.type==='Charity'?'var(--blup)':'var(--goldp)'};color:${s.type==='Charity'?'var(--blu)':'var(--gold)'}">${s.type}</span></td>
      <td style="min-width:100px"><div style="font-size:.7rem;font-weight:700;color:var(--txt);margin-bottom:4px">${s.prog}%</div><div class="mini-prog"><div class="mini-prog-fill" style="width:${s.prog}%"></div></div></td>
      <td><span class="badge-status bs-${s.status==='active'?'active':s.status==='new'?'new':'pending'}"><span class="bs-dot"></span>${s.status==='active'?'Active':s.status==='new'?'New':'Trial'}</span></td>
      <td><span style="font-size:.72rem;color:var(--muted)">18 Nov</span></td>
      <td><div class="d-flex gap-1"><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem" onclick="openModal('student')"><i class="fas fa-eye"></i></button><button class="btn-outline-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-edit"></i></button><button class="btn-danger-sm" style="padding:4px 10px;font-size:.68rem"><i class="fas fa-trash"></i></button></div></td>
    </tr>`).join('');
}

/* ── Modals */
const modalContent={
  'student':{title:'Student Profile',sub:'View and manage student details',body:`
    <div class="row g-3">
      <div class="col-md-6"><div class="f-group"><label class="f-label">Full Name</label><input type="text" class="f-input" value="Ibrahim Malik"></div></div>
      <div class="col-md-3"><div class="f-group"><label class="f-label">Age</label><input type="number" class="f-input" value="9"></div></div>
      <div class="col-md-3"><div class="f-group"><label class="f-label">Level</label><select class="f-select"><option>Tajweed</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Assigned Tutor</label><select class="f-select"><option>Ustadh Bilal</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Status</label><select class="f-select"><option>Active</option><option>Trial</option><option>Inactive</option></select></div></div>
      <div class="col-12"><div class="f-group"><label class="f-label">Notes</label><textarea class="f-textarea" rows="2">Progressing well with Tajweed. Parents very supportive.</textarea></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-save"></i>Save Changes</button></div>
    </div>`},
  'add-student':{title:'Add New Student',sub:'Register a student on the system',body:`
    <div class="row g-3">
      <div class="col-md-6"><div class="f-group"><label class="f-label">Student Name *</label><input type="text" class="f-input" placeholder="Full name"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Age *</label><input type="number" class="f-input" placeholder="Age"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Parent/Guardian Name</label><input type="text" class="f-input" placeholder="Parent name"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Contact Email</label><input type="email" class="f-input" placeholder="email@example.com"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Level</label><select class="f-select"><option>Beginner/Qaida</option><option>Quran Reading</option><option>Tajweed</option><option>Hifz</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Type</label><select class="f-select"><option>Paying Student</option><option>Charity-funded</option></select></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-plus"></i>Add Student</button></div>
    </div>`},
  'add-lesson':{title:'Schedule Lesson',sub:'Book a new one-to-one session',body:`
    <div class="row g-3">
      <div class="col-md-6"><div class="f-group"><label class="f-label">Student</label><select class="f-select"><option>Ibrahim Malik</option><option>Zara Patel</option><option>Sara Ahmed</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Tutor</label><select class="f-select"><option>Ustadh Bilal</option><option>Ustadha Fatima</option><option>Ustadh Hassan</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Date</label><input type="date" class="f-input"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Time</label><input type="time" class="f-input" value="16:00"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Duration</label><select class="f-select"><option>30 minutes</option><option>45 minutes</option><option>60 minutes</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Platform</label><select class="f-select"><option>Zoom</option><option>Microsoft Teams</option><option>Google Meet</option></select></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-calendar-check"></i>Schedule Lesson</button></div>
    </div>`},
  'add-donation':{title:'Record Donation',sub:'Add a manually recorded donation',body:`
    <div class="row g-3">
      <div class="col-md-6"><div class="f-group"><label class="f-label">Donor Name</label><input type="text" class="f-input" placeholder="Full name"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Amount (£)</label><input type="number" class="f-input" placeholder="0.00"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Type</label><select class="f-select"><option>One-time</option><option>Monthly</option><option>Corporate</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Gift Aid Eligible</label><select class="f-select"><option>Yes — UK taxpayer</option><option>No</option></select></div></div>
      <div class="col-12"><div class="f-group"><label class="f-label">Purpose</label><input type="text" class="f-input" placeholder="e.g. Student sponsorship, General fund"></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-heart"></i>Record Donation</button></div>
    </div>`},
  'add-article':{title:'New Article',sub:'Publish content to the website',body:`
    <div class="row g-3">
      <div class="col-12"><div class="f-group"><label class="f-label">Title *</label><input type="text" class="f-input" placeholder="Article title..."></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Category</label><select class="f-select"><option>Impact Story</option><option>Education</option><option>Charity</option><option>Quran</option><option>Announcement</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Status</label><select class="f-select"><option>Draft</option><option>Published</option></select></div></div>
      <div class="col-12"><div class="f-group"><label class="f-label">Summary</label><textarea class="f-textarea" rows="3" placeholder="Brief summary..."></textarea></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-pen"></i>Create Article</button></div>
    </div>`},
  'add-tutor':{title:'Add Tutor',sub:'Register a new tutor on the system',body:`
    <div class="row g-3">
      <div class="col-md-6"><div class="f-group"><label class="f-label">Full Name</label><input type="text" class="f-input" placeholder="Tutor name"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Email</label><input type="email" class="f-input" placeholder="email@merit.org"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Speciality</label><select class="f-select"><option>Qaida/Beginner</option><option>Quran Reading</option><option>Tajweed</option><option>Hifz</option><option>Arabic</option></select></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">DBS Expiry Date</label><input type="date" class="f-input"></div></div>
      <div class="col-12"><div class="f-group"><label class="f-label">Qualification Notes</label><textarea class="f-textarea" rows="2" placeholder="Ijaza, qualifications, experience..."></textarea></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-plus"></i>Add Tutor</button></div>
    </div>`},
  'add-admin':{title:'Add Admin User',sub:'Create a new admin account',body:`
    <div class="row g-3">
      <div class="col-md-6"><div class="f-group"><label class="f-label">Full Name</label><input type="text" class="f-input" placeholder="Admin name"></div></div>
      <div class="col-md-6"><div class="f-group"><label class="f-label">Email</label><input type="email" class="f-input" placeholder="email@merit.org"></div></div>
      <div class="col-12"><div class="f-group"><label class="f-label">Role</label><select class="f-select"><option>Manager</option><option>Staff</option><option>Super Admin</option></select></div></div>
      <div class="col-12"><button class="btn-gold-sm" style="width:100%;justify-content:center"><i class="fas fa-user-plus"></i>Create Admin</button></div>
    </div>`},
};
function openModal(key){
  const c=modalContent[key]||{title:'Modal',sub:'',body:''};
  document.getElementById('modal-title').textContent=c.title;
  document.getElementById('modal-sub').textContent=c.sub;
  document.getElementById('modal-body').innerHTML=c.body;
  document.getElementById('modal-overlay').classList.add('open');
}
function closeModal(e){
  if(!e||e.target===document.getElementById('modal-overlay'))
    document.getElementById('modal-overlay').classList.remove('open');
}

/* ── Init */
window.addEventListener('load',()=>{
  buildChart();
  buildStudents();
});
</script>
</body>
</html>