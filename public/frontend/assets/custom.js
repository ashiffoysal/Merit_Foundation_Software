
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

/* ── Init */
showPage('home');
