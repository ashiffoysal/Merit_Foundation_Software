
/* ── Loader */
window.addEventListener('load',()=>{setTimeout(()=>document.getElementById('loader').classList.add('done'),1400)});

/* ── Page Router */
function showPage(id){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.getElementById('page-'+id).classList.add('active');
  document.querySelectorAll('.nav-link-item').forEach(l=>l.classList.remove('active-nav'));
  const map={home:0,about:1,book:2,donate:3,safeguarding:4,contact:5};
  const items=document.querySelectorAll('.nav-link-item');
  if(map[id]!==undefined && items[map[id]]) items[map[id]].classList.add('active-nav');
  document.querySelector('.mobile-menu').classList.remove('open');
  window.scrollTo({top:0,behavior:'smooth'});
  setTimeout(initReveals,100);
}

/* ── Scroll Reveals */
function initReveals(){
  const io=new IntersectionObserver(entries=>{
    entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target)}});
  },{threshold:.1});
  document.querySelectorAll('[data-r]:not(.on)').forEach(el=>io.observe(el));
}
window.addEventListener('load',initReveals);
window.addEventListener('scroll',()=>{
  document.getElementById('nav').classList.toggle('scrolled',scrollY>50);
  document.getElementById('btt').classList.toggle('show',scrollY>350);
});

/* ── Donate helpers */
function selectDonateAmt(btn,val){
  document.querySelectorAll('.donate-option-btn').forEach(b=>b.classList.remove('selected'));
  btn.classList.add('selected');
  document.getElementById('other-amt-wrap').style.display=val==='other'?'block':'none';
}
function setDonateTab(btn,type){
  document.querySelectorAll('.donate-tab').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
}

/* ── Form submits */
function submitBookForm(){
  document.getElementById('book-form-body').style.display='none';
  document.getElementById('book-success').style.display='block';
}
function submitDonateForm(){
  document.getElementById('donate-form-body').style.display='none';
  document.getElementById('donate-success').style.display='block';
}
function submitContactForm(){
  document.getElementById('contact-form-body').style.display='none';
  document.getElementById('contact-success').style.display='block';
}

/* ── News filter */
function setFilter(btn,cat){
  document.querySelectorAll('.filter-pill').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
}

/* ── Login tabs */
function switchLoginTab(btn,type){
  document.querySelectorAll('.login-tab').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('signin-panel').style.display=type==='login'?'block':'none';
  document.getElementById('register-panel').style.display=type==='register'?'block':'none';
}

/* ── Password toggle */
function togglePw(id,icon){
  const inp=document.getElementById(id);
  const isText=inp.type==='text';
  inp.type=isText?'password':'text';
  icon.querySelector('i').className=isText?'fas fa-eye':'fas fa-eye-slash';
}

/* ── Dashboard panels */
const dashTitles={overview:'Dashboard Overview',lessons:'My Lessons',donations:'Donations & Giving',profile:'My Profile',settings:'Account Settings',notifications:'Notifications',documents:'My Documents'};
function switchDash(id){
  document.querySelectorAll('.dash-panel').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.dash-nav-item').forEach(n=>n.classList.remove('active'));
  const panel=document.getElementById('dash-'+id);
  if(panel)panel.classList.add('active');
  const navItems=document.querySelectorAll('.dash-nav-item');
  navItems.forEach(n=>{if(n.textContent.toLowerCase().includes(id.substring(0,5)))n.classList.add('active')});
  document.getElementById('breadcrumb-txt').textContent=dashTitles[id]||id;
  if(id==='overview')document.getElementById('dash-main-title').innerHTML='Good Morning, <em style="font-style:italic;color:var(--gold)">Ayesha</em> 👋';
  else document.getElementById('dash-main-title').innerHTML=dashTitles[id]||id;
}

/* ── Profile save */
function saveProfile(){
  const fname=document.getElementById('prof-fname')?.value||'A';
  const av=document.getElementById('dash-av-main');
  const pav=document.getElementById('profile-av-display');
  const initial=fname.charAt(0).toUpperCase();
  if(av)av.textContent=initial;
  if(pav)pav.textContent=initial;
  const bar=document.createElement('div');
  bar.style.cssText='position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:var(--teal);color:white;padding:12px 28px;border-radius:10px;font-size:.82rem;font-weight:600;z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,.2);animation:pgIn .3s ease';
  bar.innerHTML='<i class="fas fa-check-circle me-2"></i>Profile saved successfully!';
  document.body.appendChild(bar);
  setTimeout(()=>bar.remove(),3000);
}

/* ── Policy scroll highlight */
function scrollToSection(id){
  const el=document.getElementById(id);
  if(el){el.scrollIntoView({behavior:'smooth',block:'start'});}
  document.querySelectorAll('.pn-item').forEach(p=>p.classList.remove('active'));
  event.target.closest('.pn-item')?.classList.add('active');
}

/* ── Init */
showPage('home');
