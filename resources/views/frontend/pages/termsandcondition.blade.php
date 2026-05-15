@extends('layouts.frontend')
@section('title', 'Terms and Conditions - Merit Education Foundation')
@section('content')
<style>
/* ═══════════════════════════════════════
   DESIGN TOKENS — matches Merit premium
═══════════════════════════════════════ */
:root {
  --navy:   #0F1F5C;
  --navy2:  #1A2E7A;
  --gold:   #C9A84C;
  --gold2:  #E8C96B;
  --teal:   #0D6B63;
  --cream:  #FAF8F3;
  --light:  #F4F2ED;
  --muted:  #7A7A8C;
  --border: #E2DDD4;
  --white:  #FFFFFF;
  --dark:   #080E2B;
  --txt:    #1C1C2E;
  --red:    #DC2626;
  --green:  #15803D;
}

*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth;font-size:16px}
body{font-family:'DM Sans',sans-serif;color:var(--txt);background:var(--white);overflow-x:hidden}

/* ── PAGE SYSTEM */
.page{display:none}
.page.active{display:block;animation:pgIn .4s ease}
@keyframes pgIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}

/* ── REVEAL */
[data-r]{opacity:0;transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
[data-r="up"]{transform:translateY(40px)}
[data-r="left"]{transform:translateX(-50px)}
[data-r="right"]{transform:translateX(50px)}
[data-r="fade"]{transform:scale(.97)}
[data-r].on{opacity:1;transform:none}

/* ══════════════════════════════════════
   NAVBAR
══════════════════════════════════════ */
#nav{
  position:fixed;top:0;left:0;right:0;z-index:1000;
  transition:all .5s cubic-bezier(.16,1,.3,1);
}
.nav-inner{
  display:flex;align-items:center;justify-content:space-between;
  padding:22px 44px;transition:all .5s;
}
#nav.scrolled .nav-inner{
  background:rgba(8,14,43,.97);
  backdrop-filter:blur(20px);
  padding:14px 44px;
  box-shadow:0 2px 40px rgba(0,0,0,.3);
}
.brand{display:flex;align-items:center;gap:14px;cursor:pointer;text-decoration:none}
.brand-icon{
  width:46px;height:46px;
  border:1.5px solid rgba(201,168,76,.5);
  border-radius:12px;
  display:flex;align-items:center;justify-content:center;
  background:rgba(201,168,76,.08);transition:.3s;
}
.brand-icon i{color:var(--gold);font-size:1.05rem}
.brand:hover .brand-icon{background:rgba(201,168,76,.2);border-color:var(--gold)}
.brand-title{
  font-family:'Cormorant Garamond',serif;
  font-size:1.45rem;font-weight:700;
  color:var(--white);letter-spacing:3px;line-height:1;
}
.brand-sub{font-size:.55rem;letter-spacing:2px;color:var(--gold);display:block;margin-top:3px}
.nav-links{display:flex;align-items:center;gap:4px}
.nav-lnk{
  color:rgba(255,255,255,.72);font-size:.75rem;font-weight:500;
  letter-spacing:1.5px;text-transform:uppercase;
  padding:8px 14px;border-radius:8px;cursor:pointer;transition:.3s;position:relative;
}
.nav-lnk::after{
  content:'';position:absolute;bottom:4px;left:14px;right:14px;
  height:1px;background:var(--gold);transform:scaleX(0);transition:.3s;
}
.nav-lnk:hover{color:var(--white)}
.nav-lnk:hover::after,.nav-lnk.active::after{transform:scaleX(1)}
.nav-lnk.active{color:var(--gold)}
.nav-ctas{display:flex;gap:9px;margin-left:12px}
.btn-gold-nav{
  display:inline-flex;align-items:center;gap:8px;
  background:var(--gold);color:var(--navy);
  padding:10px 24px;border-radius:8px;
  font-weight:700;font-size:.75rem;letter-spacing:1.5px;text-transform:uppercase;
  border:none;cursor:pointer;transition:.3s;
  box-shadow:0 5px 20px rgba(201,168,76,.28);
}
.btn-gold-nav:hover{background:var(--gold2);transform:translateY(-2px)}
.btn-ghost-nav{
  display:inline-flex;align-items:center;gap:8px;
  border:1.5px solid rgba(255,255,255,.22);color:rgba(255,255,255,.8);
  padding:9px 22px;border-radius:8px;
  font-size:.75rem;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;
  cursor:pointer;transition:.3s;background:transparent;
}
.btn-ghost-nav:hover{border-color:var(--gold);color:var(--gold)}
.nav-toggle{
  display:none;background:none;
  border:1.5px solid rgba(255,255,255,.18);
  border-radius:8px;padding:7px 11px;color:var(--white);cursor:pointer;font-size:.9rem;
}
.mob-menu{
  display:none;position:absolute;top:100%;left:0;right:0;
  background:rgba(8,14,43,.98);backdrop-filter:blur(20px);
  padding:16px;border-top:1px solid rgba(255,255,255,.06);
}
.mob-menu.open{display:block}
.mob-lnk{
  display:block;color:rgba(255,255,255,.65);
  padding:12px 16px;border-radius:8px;font-size:.8rem;
  letter-spacing:1.5px;text-transform:uppercase;font-weight:500;
  cursor:pointer;transition:.3s;margin-bottom:3px;
}
.mob-lnk:hover{color:var(--gold);background:rgba(201,168,76,.08)}
@media(max-width:1100px){.nav-links,.nav-ctas{display:none}.nav-toggle{display:block}}

/* ══════════════════════════════════════
   PAGE HERO — shared
══════════════════════════════════════ */
.page-hero{
  padding:148px 0 80px;
  background:var(--dark);
  position:relative;overflow:hidden;
}
.page-hero::before{
  content:'';position:absolute;inset:0;
  background:
    radial-gradient(ellipse 80% 80% at 50% 40%,rgba(26,46,122,.88),transparent 66%),
    radial-gradient(ellipse 40% 40% at 85% 15%,rgba(201,168,76,.06),transparent);
}
.page-hero::after{
  content:'';position:absolute;inset:0;
  background-image:
    linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),
    linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);
  background-size:64px 64px;
}
.ph-inner{position:relative;z-index:1}
.ph-badge{
  display:inline-flex;align-items:center;gap:9px;
  background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.28);
  border-radius:30px;padding:6px 18px;margin-bottom:20px;
}
.ph-badge span{font-size:.68rem;color:var(--gold);letter-spacing:2.5px;text-transform:uppercase;font-weight:600}
.ph-h{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(2.6rem,6vw,4.5rem);font-weight:700;
  color:var(--white);line-height:.98;margin-bottom:18px;
}
.ph-h em{font-style:italic;color:var(--gold)}
.ph-p{
  font-size:.95rem;color:rgba(255,255,255,.48);
  line-height:1.82;font-weight:300;max-width:560px;
}
.ph-meta{
  display:flex;align-items:center;gap:28px;flex-wrap:wrap;
  margin-top:24px;padding-top:22px;
  border-top:1px solid rgba(255,255,255,.08);
}
.ph-meta-item{
  display:flex;align-items:center;gap:8px;
  font-size:.73rem;color:rgba(255,255,255,.38);
}
.ph-meta-item i{color:var(--gold);font-size:.65rem}
.ph-meta-item strong{color:rgba(255,255,255,.65);font-weight:600}

/* ══════════════════════════════════════
   LEGAL PAGE LAYOUT
══════════════════════════════════════ */
.legal-body{padding:72px 0 110px;background:var(--cream)}

/* Sticky TOC */
.toc-sidebar{position:sticky;top:100px}
.toc-card{
  background:var(--white);border:1px solid var(--border);
  border-radius:16px;padding:26px 22px;
}
.toc-title{
  font-size:.65rem;font-weight:700;letter-spacing:3px;
  text-transform:uppercase;color:var(--gold);
  margin-bottom:18px;padding-bottom:12px;
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;gap:8px;
}
.toc-title i{font-size:.75rem}
.toc-item{
  display:flex;align-items:center;gap:10px;
  padding:9px 12px;border-radius:9px;font-size:.8rem;
  color:var(--muted);cursor:pointer;transition:.3s;margin-bottom:3px;
  border:1px solid transparent;
}
.toc-item:hover{background:rgba(201,168,76,.06);color:var(--navy);border-color:rgba(201,168,76,.15)}
.toc-item.active{background:rgba(201,168,76,.08);color:var(--navy);font-weight:600;border-color:rgba(201,168,76,.2)}
.toc-item i{font-size:.6rem;color:var(--gold);flex-shrink:0;width:12px}
.toc-item-num{
  font-family:'Cormorant Garamond',serif;
  font-size:.78rem;font-weight:700;color:var(--gold);
  flex-shrink:0;width:18px;
}

.toc-meta-box{
  background:var(--navy);border-radius:12px;padding:20px;margin-top:16px;
}
.tmb-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:9px}
.tmb-row:last-child{margin-bottom:0}
.tmb-label{font-size:.68rem;color:rgba(255,255,255,.38);letter-spacing:.5px}
.tmb-val{font-size:.75rem;font-weight:600;color:rgba(255,255,255,.75)}

.switch-doc-card{
  background:linear-gradient(135deg,var(--navy),var(--navy2));
  border-radius:12px;padding:20px;margin-top:16px;position:relative;overflow:hidden;
}
.switch-doc-card::before{
  content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.025'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
}
.switch-doc-card>*{position:relative;z-index:1}
.sdc-title{font-size:.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:12px}
.sdc-link{
  display:flex;align-items:center;gap:9px;
  font-size:.78rem;color:rgba(255,255,255,.55);
  cursor:pointer;transition:.3s;padding:7px 0;
  border-bottom:1px solid rgba(255,255,255,.07);
}
.sdc-link:last-child{border-bottom:none;padding-bottom:0}
.sdc-link:hover{color:var(--gold)}
.sdc-link i{font-size:.6rem;color:rgba(201,168,76,.5)}

/* Content Area */
.legal-content{}
.legal-section{
  margin-bottom:54px;
  scroll-margin-top:110px;
}
.ls-header{
  display:flex;align-items:center;gap:14px;
  margin-bottom:22px;padding-bottom:16px;
  border-bottom:2px solid var(--border);
}
.ls-num{
  font-family:'Cormorant Garamond',serif;
  font-size:2.2rem;font-weight:700;color:rgba(201,168,76,.2);
  line-height:1;flex-shrink:0;min-width:40px;
}
.ls-icon{
  width:42px;height:42px;border-radius:11px;
  background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.2);
  display:flex;align-items:center;justify-content:center;
  color:var(--gold);font-size:.9rem;flex-shrink:0;
}
.ls-title{
  font-family:'Cormorant Garamond',serif;
  font-size:1.45rem;font-weight:700;color:var(--navy);line-height:1.15;
}
.ls-body p{
  font-size:.88rem;color:var(--muted);
  line-height:1.9;margin-bottom:16px;font-weight:300;
}
.ls-body p:last-child{margin-bottom:0}
.ls-body strong{color:var(--txt);font-weight:600}
.ls-body a{color:var(--gold);text-decoration:none;font-weight:600;transition:.2s}
.ls-body a:hover{color:var(--navy)}

/* Highlight box */
.hl-box{
  border-radius:12px;padding:20px 22px;margin:20px 0;
  display:flex;align-items:flex-start;gap:14px;
}
.hl-navy{background:rgba(15,31,92,.05);border:1px solid rgba(15,31,92,.1);border-left:3px solid var(--navy)}
.hl-gold{background:rgba(201,168,76,.07);border:1px solid rgba(201,168,76,.2);border-left:3px solid var(--gold)}
.hl-teal{background:rgba(13,107,99,.07);border:1px solid rgba(13,107,99,.18);border-left:3px solid var(--teal)}
.hl-red{background:rgba(220,38,38,.05);border:1px solid rgba(220,38,38,.15);border-left:3px solid var(--red)}
.hl-green{background:rgba(21,128,61,.06);border:1px solid rgba(21,128,61,.15);border-left:3px solid var(--green)}
.hl-box i{font-size:1rem;margin-top:2px;flex-shrink:0}
.hl-box .hl-text p{font-size:.84rem;color:var(--txt);margin:0;line-height:1.75}
.hl-box .hl-text strong{display:block;margin-bottom:4px;font-size:.86rem}

/* List styles */
.policy-list{list-style:none;padding:0;margin:14px 0}
.policy-list li{
  display:flex;align-items:flex-start;gap:11px;
  font-size:.86rem;color:var(--muted);
  line-height:1.78;margin-bottom:11px;font-weight:300;
}
.policy-list li i{
  font-size:.6rem;color:var(--gold);
  margin-top:6px;flex-shrink:0;width:10px;
}
.policy-list li strong{color:var(--txt);font-weight:600}

/* Subsection */
.ls-sub{
  font-family:'Cormorant Garamond',serif;
  font-size:1.1rem;font-weight:700;color:var(--navy);
  margin:28px 0 12px;display:flex;align-items:center;gap:10px;
}
.ls-sub i{font-size:.85rem;color:var(--gold)}

/* Table */
.policy-table{width:100%;border-collapse:collapse;margin:18px 0;border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(15,31,92,.06)}
.policy-table thead{background:var(--navy)}
.policy-table thead th{
  padding:12px 16px;font-size:.68rem;font-weight:700;
  letter-spacing:1.5px;text-transform:uppercase;color:var(--gold);text-align:left;
}
.policy-table tbody tr{background:var(--white);transition:.2s}
.policy-table tbody tr:nth-child(even){background:var(--cream)}
.policy-table tbody tr:hover{background:rgba(201,168,76,.05)}
.policy-table td{
  padding:12px 16px;font-size:.82rem;color:var(--muted);
  border-bottom:1px solid var(--border);vertical-align:top;line-height:1.6;
}
.policy-table td:first-child{font-weight:600;color:var(--navy)}

/* Cookie toggle row */
.cookie-toggle-row{
  background:var(--white);border:1px solid var(--border);
  border-radius:12px;padding:18px 20px;margin-bottom:12px;
  display:flex;align-items:flex-start;gap:16px;transition:.3s;
}
.cookie-toggle-row:hover{border-color:rgba(201,168,76,.3);box-shadow:0 4px 20px rgba(15,31,92,.06)}
.ct-info{flex:1}
.ct-title{font-size:.88rem;font-weight:600;color:var(--navy);margin-bottom:4px;display:flex;align-items:center;gap:8px}
.ct-badge{font-size:.58rem;font-weight:800;padding:2px 8px;border-radius:10px;letter-spacing:.5px}
.ct-required{background:rgba(15,31,92,.08);color:var(--navy)}
.ct-optional{background:rgba(201,168,76,.12);color:var(--gold)}
.ct-desc{font-size:.78rem;color:var(--muted);line-height:1.6}
.toggle-sw{position:relative;width:42px;height:23px;flex-shrink:0;margin-top:2px}
.toggle-sw input{opacity:0;width:0;height:0}
.toggle-sl{position:absolute;inset:0;background:var(--border);border-radius:23px;cursor:pointer;transition:.3s}
.toggle-sl::before{content:'';position:absolute;width:17px;height:17px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s;box-shadow:0 1px 4px rgba(0,0,0,.15)}
.toggle-sw input:checked+.toggle-sl{background:var(--navy)}
.toggle-sw input:checked+.toggle-sl::before{transform:translateX(19px)}
.toggle-sw input:disabled+.toggle-sl{opacity:.6;cursor:not-allowed}

/* Refund timeline */
.refund-timeline{position:relative;padding-left:32px;margin:20px 0}
.refund-timeline::before{
  content:'';position:absolute;left:10px;top:0;bottom:0;
  width:2px;background:linear-gradient(to bottom,var(--gold),rgba(201,168,76,.1));
}
.rt-item{position:relative;margin-bottom:28px}
.rt-dot{
  position:absolute;left:-28px;top:3px;
  width:18px;height:18px;border-radius:50%;
  border:2px solid var(--gold);background:var(--white);
  display:flex;align-items:center;justify-content:center;
}
.rt-dot i{font-size:.48rem;color:var(--gold)}
.rt-title{font-size:.9rem;font-weight:700;color:var(--navy);margin-bottom:5px}
.rt-desc{font-size:.82rem;color:var(--muted);line-height:1.7}
.rt-tag{
  display:inline-flex;align-items:center;gap:5px;
  font-size:.65rem;font-weight:700;padding:3px 10px;border-radius:10px;
  margin-top:8px;letter-spacing:.5px;
}
.tag-green{background:rgba(21,128,61,.1);color:var(--green)}
.tag-amber{background:rgba(245,158,11,.1);color:#B45309}
.tag-red{background:rgba(220,38,38,.08);color:var(--red)}
.tag-navy{background:rgba(15,31,92,.08);color:var(--navy)}

/* Eligibility grid */
.elig-card{
  background:var(--white);border:1px solid var(--border);
  border-radius:14px;padding:22px 18px;height:100%;
  transition:.3s;border-top:3px solid transparent;
}
.elig-card:hover{box-shadow:0 8px 32px rgba(15,31,92,.08);transform:translateY(-3px)}
.elig-card.eligible{border-top-color:var(--green)}
.elig-card.not-eligible{border-top-color:var(--red)}
.elig-card.partial{border-top-color:var(--gold)}
.elig-head{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.elig-ic{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0}
.elig-label{font-size:.85rem;font-weight:700;color:var(--navy)}
.elig-list{list-style:none;padding:0}
.elig-list li{display:flex;align-items:flex-start;gap:8px;font-size:.78rem;color:var(--muted);margin-bottom:7px;line-height:1.5}
.elig-list li i{font-size:.6rem;margin-top:4px;flex-shrink:0}

/* Back to top */
#btt{
  position:fixed;bottom:28px;right:28px;width:46px;height:46px;
  background:var(--navy);border:1.5px solid var(--gold);border-radius:11px;
  display:flex;align-items:center;justify-content:center;
  color:var(--gold);cursor:pointer;z-index:800;
  opacity:0;pointer-events:none;transition:.4s;
  box-shadow:0 6px 20px rgba(15,31,92,.25);
}
#btt.show{opacity:1;pointer-events:all}
#btt:hover{background:var(--gold);color:var(--navy);transform:translateY(-3px)}

/* Page nav bar between legal pages */
.legal-page-nav{
  background:var(--navy);padding:14px 0;position:sticky;top:70px;z-index:900;
}
.lpn-inner{display:flex;align-items:center;gap:4px;overflow-x:auto;scrollbar-width:none}
.lpn-inner::-webkit-scrollbar{display:none}
.lpn-btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 20px;border-radius:8px;font-size:.73rem;font-weight:600;
  letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:.3s;
  color:rgba(255,255,255,.5);background:transparent;border:none;white-space:nowrap;
}
.lpn-btn:hover{color:rgba(255,255,255,.85);background:rgba(255,255,255,.06)}
.lpn-btn.active{background:rgba(201,168,76,.15);color:var(--gold);border:1px solid rgba(201,168,76,.25)}
.lpn-sep{color:rgba(255,255,255,.15);font-size:.8rem;flex-shrink:0}

/* CTA strip */
.cta-strip{
  background:var(--gold);padding:64px 0;position:relative;overflow:hidden;
}
.cta-strip::before{
  content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.06'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
}
.cta-strip .inner{position:relative}

/* FOOTER */
.site-footer{background:var(--dark);padding:70px 0 0}
.sf-brand-n{font-family:'Cormorant Garamond',serif;font-size:1.35rem;font-weight:700;color:var(--white);letter-spacing:2.5px}
.sf-brand-s{font-size:.54rem;letter-spacing:2px;color:var(--gold);text-transform:uppercase}
.sf-col-title{font-size:.63rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:20px}
.sf-link{font-size:.8rem;color:rgba(255,255,255,.36);cursor:pointer;transition:.3s;display:block;margin-bottom:10px}
.sf-link:hover{color:var(--gold)}
.sf-soc{display:flex;gap:8px;margin-top:16px}
.sf-soc-btn{width:34px;height:34px;border:1px solid rgba(255,255,255,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.35);font-size:.75rem;cursor:pointer;transition:.3s}
.sf-soc-btn:hover{border-color:var(--gold);color:var(--gold)}
.sf-bottom{border-top:1px solid rgba(255,255,255,.055);padding:24px 0;margin-top:55px}
.sf-bot-txt{font-size:.73rem;color:rgba(255,255,255,.22)}

/* loader */
#loader{position:fixed;inset:0;background:var(--dark);z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;transition:opacity .5s,visibility .5s}
#loader.done{opacity:0;visibility:hidden}
.loader-t{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:700;color:var(--white);letter-spacing:5px;margin-bottom:16px}
.loader-track{width:130px;height:2px;background:rgba(255,255,255,.1);border-radius:2px;overflow:hidden}
.loader-fill{height:100%;width:0;background:var(--gold);border-radius:2px;animation:lfill 1.2s ease forwards}
@keyframes lfill{to{width:100%}}

@media(max-width:991px){
  .toc-sidebar{position:relative;top:auto;margin-bottom:32px}
  .legal-body{padding:48px 0 80px}
}
</style>

<div id="" class="">

  <!-- Hero -->
  <div class="page-hero">
    <div class="container ph-inner">
      <div class="ph-badge"><span><i class="fas fa-file-contract me-1"></i>Legal Document</span></div>
      <h1 class="ph-h">Terms &amp; <em>Conditions</em></h1>
      <p class="ph-p">Please read these terms carefully before booking a lesson, making a donation, or using any Merit Education Foundation service. By accessing our services, you agree to be bound by these terms.</p>
      <div class="ph-meta">
        <div class="ph-meta-item"><i class="fas fa-calendar"></i><strong>Effective Date:</strong> 1 November 2025</div>
        <div class="ph-meta-item"><i class="fas fa-sync"></i><strong>Last Updated:</strong> 1 November 2025</div>
        <div class="ph-meta-item"><i class="fas fa-clock"></i><strong>Reading Time:</strong> ~14 minutes</div>
        <div class="ph-meta-item"><i class="fas fa-shield-alt"></i><strong>Version:</strong> 4.1</div>
      </div>
    </div>
  </div>

  <!-- Body -->
  <section class="legal-body">
    <div class="container">
      <div class="row g-5">

        <!-- TOC Sidebar -->
        <div class="col-lg-3">
          <div class="toc-sidebar">
            <div class="toc-card">
              <div class="toc-title"><i class="fas fa-list"></i>Contents</div>
              <div class="toc-item active" onclick="scrollTo('t1',this)"><span class="toc-item-num">1</span>About Us</div>
              <div class="toc-item" onclick="scrollTo('t2',this)"><span class="toc-item-num">2</span>Acceptance of Terms</div>
              <div class="toc-item" onclick="scrollTo('t3',this)"><span class="toc-item-num">3</span>Our Services</div>
              <div class="toc-item" onclick="scrollTo('t4',this)"><span class="toc-item-num">4</span>Lesson Bookings</div>
              <div class="toc-item" onclick="scrollTo('t5',this)"><span class="toc-item-num">5</span>Fees & Payments</div>
              <div class="toc-item" onclick="scrollTo('t6',this)"><span class="toc-item-num">6</span>Donations</div>
              <div class="toc-item" onclick="scrollTo('t7',this)"><span class="toc-item-num">7</span>Safeguarding</div>
              <div class="toc-item" onclick="scrollTo('t8',this)"><span class="toc-item-num">8</span>User Conduct</div>
              <div class="toc-item" onclick="scrollTo('t9',this)"><span class="toc-item-num">9</span>Intellectual Property</div>
              <div class="toc-item" onclick="scrollTo('t10',this)"><span class="toc-item-num">10</span>Liability</div>
              <div class="toc-item" onclick="scrollTo('t11',this)"><span class="toc-item-num">11</span>Termination</div>
              <div class="toc-item" onclick="scrollTo('t12',this)"><span class="toc-item-num">12</span>Governing Law</div>
              <div class="toc-item" onclick="scrollTo('t13',this)"><span class="toc-item-num">13</span>Contact</div>
            </div>
            <div class="toc-meta-box">
              <div class="tmb-row"><span class="tmb-label">Document</span><span class="tmb-val">Terms & Conditions</span></div>
              <div class="tmb-row"><span class="tmb-label">Jurisdiction</span><span class="tmb-val">England & Wales</span></div>
              <div class="tmb-row"><span class="tmb-label">Charity No.</span><span class="tmb-val">1234567</span></div>
              <div class="tmb-row"><span class="tmb-label">Registered</span><span class="tmb-val">England & Wales</span></div>
            </div>
            <div class="switch-doc-card">
              <div class="sdc-title">Other Legal Pages</div>
              <div class="sdc-link" onclick="showPage('refund')"><i class="fas fa-chevron-right"></i>Refund Policy</div>
              <div class="sdc-link" onclick="showPage('cookie')"><i class="fas fa-chevron-right"></i>Cookie Policy</div>
              <div class="sdc-link"><i class="fas fa-chevron-right"></i>Privacy Policy</div>
              <div class="sdc-link"><i class="fas fa-chevron-right"></i>Safeguarding Policy</div>
            </div>
          </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
          <div class="legal-content">

            <div class="hl-box hl-gold mb-4" data-r="up">
              <i class="fas fa-info-circle" style="color:var(--gold)"></i>
              <div class="hl-text"><p><strong>Summary for Parents:</strong> Merit Education Foundation provides online Quran lessons as a paid service and separately accepts charitable donations. Lesson fees and donations are always kept distinct — lesson fees are not donations and are not Gift Aid eligible. Please read this document in full before using our services.</p></div>
            </div>

            <!-- S1 -->
            <div class="legal-section" id="t1" data-r="up">
              <div class="ls-header">
                <div class="ls-num">01</div>
                <div class="ls-icon"><i class="fas fa-building"></i></div>
                <h2 class="ls-title">About Merit Education Foundation</h2>
              </div>
              <div class="ls-body">
                <p>Merit Education Foundation (referred to as "Merit", "we", "us" or "our") is a registered charity operating in England and Wales (Charity Registration Number: 1234567), with its principal place of business at Merit House, London, United Kingdom.</p>
                <p>Merit Education Foundation operates with a dual purpose: (1) providing premium one-to-one online Quran teaching as a paid educational service, and (2) running charitable programmes to fund education for disadvantaged, orphaned, and underprivileged children worldwide. These two activities are operated separately, with distinct financial streams, in accordance with UK charity law.</p>
                <p>For all enquiries: <a href="mailto:info@meriteducation.org">info@meriteducation.org</a> | +44 20 0000 0000</p>
              </div>
            </div>

            <!-- S2 -->
            <div class="legal-section" id="t2" data-r="up">
              <div class="ls-header">
                <div class="ls-num">02</div>
                <div class="ls-icon"><i class="fas fa-handshake"></i></div>
                <h2 class="ls-title">Acceptance of Terms</h2>
              </div>
              <div class="ls-body">
                <p>By accessing our website (meriteducation.org), booking a lesson, making a donation, creating an account, or using any of our services, you confirm that you have read, understood, and agree to be legally bound by these Terms and Conditions.</p>
                <p>If you are booking on behalf of a minor (a person under 18), you confirm that you are the parent or legal guardian of that child and that you accept these terms on their behalf. You are responsible for ensuring your child complies with all applicable terms during lessons.</p>
                <div class="hl-box hl-navy">
                  <i class="fas fa-user-shield" style="color:var(--navy)"></i>
                  <div class="hl-text"><p><strong>Age Requirement:</strong> You must be 18 years of age or older to create an account, book lessons, or make a donation. Lessons for children must be booked by a parent or legal guardian.</p></div>
                </div>
                <p>We reserve the right to update these Terms at any time. We will notify registered users of material changes via email. Continued use of our services after notification constitutes acceptance of the revised Terms.</p>
              </div>
            </div>

            <!-- S3 -->
            <div class="legal-section" id="t3" data-r="up">
              <div class="ls-header">
                <div class="ls-num">03</div>
                <div class="ls-icon"><i class="fas fa-graduation-cap"></i></div>
                <h2 class="ls-title">Our Services</h2>
              </div>
              <div class="ls-body">
                <p>Merit Education Foundation provides the following services:</p>
                <div class="ls-sub"><i class="fas fa-quran"></i>Educational Services (Paid)</div>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span>One-to-one online Quran lessons via secure video platforms (Zoom, Microsoft Teams)</span></li>
                  <li><i class="fas fa-circle"></i><span>Structured learning programmes including Qaida, Quran Reading, Tajweed and Hifz</span></li>
                  <li><i class="fas fa-circle"></i><span>Progress reports, tutor feedback and parent consultations</span></li>
                  <li><i class="fas fa-circle"></i><span>Digital skills and educational support programmes</span></li>
                </ul>
                <div class="ls-sub"><i class="fas fa-heart"></i>Charitable Services (Donation-funded)</div>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span>Free education for sponsored, orphaned, and disadvantaged children</span></li>
                  <li><i class="fas fa-circle"></i><span>Scholarship programmes funded entirely by charitable donations</span></li>
                  <li><i class="fas fa-circle"></i><span>Community education outreach in 30+ countries</span></li>
                </ul>
                <div class="hl-box hl-teal">
                  <i class="fas fa-exclamation-circle" style="color:var(--teal)"></i>
                  <div class="hl-text"><p><strong>Important Distinction:</strong> Lesson fees are charged as a commercial service. Charitable donations are entirely separate and voluntary. This distinction is required by UK charity law and affects Gift Aid eligibility.</p></div>
                </div>
              </div>
            </div>

            <!-- S4 -->
            <div class="legal-section" id="t4" data-r="up">
              <div class="ls-header">
                <div class="ls-num">04</div>
                <div class="ls-icon"><i class="fas fa-calendar-check"></i></div>
                <h2 class="ls-title">Lesson Bookings</h2>
              </div>
              <div class="ls-body">
                <p>All lesson bookings are subject to the following terms:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-check"></i><span><strong>Booking Confirmation:</strong> A booking is only confirmed upon receipt of payment or written confirmation from Merit staff. Enquiry form submissions do not constitute a confirmed booking.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Free Trial:</strong> We offer one complimentary trial lesson per new student. This cannot be transferred or exchanged for credit.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Rescheduling:</strong> You may reschedule a lesson by providing at least 24 hours' notice. Rescheduling with less than 24 hours' notice may result in forfeiture of the session fee.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Cancellations:</strong> Please refer to our Refund Policy for full details on cancellations and refunds.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Tutor Assignment:</strong> Merit reserves the right to assign or reassign tutors based on availability, subject specialism, and student needs. We will always notify parents of tutor changes in advance.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Recording:</strong> Lessons are recorded for safeguarding purposes with the consent of the parent/guardian. Recordings are stored securely and not shared publicly.</span></li>
                </ul>
              </div>
            </div>

            <!-- S5 -->
            <div class="legal-section" id="t5" data-r="up">
              <div class="ls-header">
                <div class="ls-num">05</div>
                <div class="ls-icon"><i class="fas fa-pound-sign"></i></div>
                <h2 class="ls-title">Fees & Payments</h2>
              </div>
              <div class="ls-body">
                <p>Lesson fees are charged as follows and are subject to change with 30 days' prior notice to existing students:</p>
                <table class="policy-table">
                  <thead><tr><th>Session Type</th><th>Duration</th><th>Fee</th><th>Notes</th></tr></thead>
                  <tbody>
                    <tr><td>Standard</td><td>30 minutes</td><td>£15 per session</td><td>Ideal for younger students & beginners</td></tr>
                    <tr><td>Popular</td><td>45 minutes</td><td>£25 per session</td><td>Most popular — regular learners</td></tr>
                    <tr><td>Intensive</td><td>60 minutes</td><td>£40 per session</td><td>Advanced Tajweed & Hifz students</td></tr>
                  </tbody>
                </table>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span><strong>Payment Methods:</strong> We accept all major credit/debit cards, PayPal, and bank transfer (BACS). All payments are processed via secure, encrypted payment gateways.</span></li>
                  <li><i class="fas fa-circle"></i><span><strong>VAT:</strong> All prices stated are inclusive of any applicable taxes. Merit Education Foundation's educational services may be exempt from VAT under UK law.</span></li>
                  <li><i class="fas fa-circle"></i><span><strong>Lesson Fees are NOT donations:</strong> Payment for lessons does not qualify as a charitable donation and is not Gift Aid eligible. A separate voluntary donation can be made via our Donate page.</span></li>
                  <li><i class="fas fa-circle"></i><span><strong>Late Payment:</strong> We reserve the right to suspend access to lessons if payment is 7 or more days overdue.</span></li>
                </ul>
              </div>
            </div>

            <!-- S6 -->
            <div class="legal-section" id="t6" data-r="up">
              <div class="ls-header">
                <div class="ls-num">06</div>
                <div class="ls-icon"><i class="fas fa-heart"></i></div>
                <h2 class="ls-title">Donations</h2>
              </div>
              <div class="ls-body">
                <p>Donations to Merit Education Foundation are entirely voluntary, separate from lesson fees, and governed by the following terms:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-check"></i><span><strong>Voluntary Nature:</strong> No donation is required to access lesson services. All charitable giving is entirely at your discretion.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Gift Aid:</strong> If you are a UK taxpayer, you may consent to Gift Aid, allowing Merit to reclaim 25p per £1 donated from HMRC at no additional cost to you. You must notify us if you stop paying sufficient UK income tax.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Use of Funds:</strong> 70% of donations fund student programmes, 15% fund materials and resources, 10% cover administration, and 5% support emergency welfare. Annual impact reports are published on our website.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Non-refundable:</strong> Donations are generally non-refundable. In exceptional circumstances, please see our Refund Policy.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Zakat &amp; Sadaqah:</strong> We accept Zakat and Sadaqah donations. Zakat donations are ring-fenced for eligible recipients as per Islamic jurisprudence and will be confirmed on request.</span></li>
                </ul>
              </div>
            </div>

            <!-- S7 -->
            <div class="legal-section" id="t7" data-r="up">
              <div class="ls-header">
                <div class="ls-num">07</div>
                <div class="ls-icon"><i class="fas fa-shield-alt"></i></div>
                <h2 class="ls-title">Safeguarding</h2>
              </div>
              <div class="ls-body">
                <p>The safety of every child in our care is our highest priority. By booking lessons, you agree to and acknowledge the following safeguarding terms:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-shield-alt"></i><span>All Merit tutors are DBS (Disclosure and Barring Service) checked before working with any student.</span></li>
                  <li><i class="fas fa-shield-alt"></i><span>Lessons are conducted via approved, secure video platforms. No private messaging between tutor and student is permitted.</span></li>
                  <li><i class="fas fa-shield-alt"></i><span>Parents and guardians may observe any lesson at any time without prior notice.</span></li>
                  <li><i class="fas fa-shield-alt"></i><span>All sessions are recorded with parental consent and retained for a maximum of 90 days for safeguarding review purposes.</span></li>
                  <li><i class="fas fa-shield-alt"></i><span>Any safeguarding concern must be reported immediately to our Designated Safeguarding Lead (DSL) at <a href="mailto:safeguarding@meriteducation.org">safeguarding@meriteducation.org</a>.</span></li>
                </ul>
                <div class="hl-box hl-red">
                  <i class="fas fa-exclamation-triangle" style="color:var(--red)"></i>
                  <div class="hl-text"><p><strong>Safeguarding Breach:</strong> Any breach of our safeguarding policy — by a tutor, student, or parent — will result in immediate suspension from all Merit services, and may be reported to relevant authorities in accordance with our legal obligations.</p></div>
                </div>
              </div>
            </div>

            <!-- S8 -->
            <div class="legal-section" id="t8" data-r="up">
              <div class="ls-header">
                <div class="ls-num">08</div>
                <div class="ls-icon"><i class="fas fa-user-check"></i></div>
                <h2 class="ls-title">User Conduct</h2>
              </div>
              <div class="ls-body">
                <p>All users of Merit Education Foundation's services (parents, students, tutors, donors, and visitors) must adhere to the following standards of conduct:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-times"></i><span>You must not use our services for any unlawful, fraudulent, or harmful purpose.</span></li>
                  <li><i class="fas fa-times"></i><span>You must not harass, abuse, or intimidate tutors, staff, or other users in any form, including via our platform, email, or social media.</span></li>
                  <li><i class="fas fa-times"></i><span>You must not record, screenshot, or redistribute lesson content without prior written consent from Merit Education Foundation.</span></li>
                  <li><i class="fas fa-times"></i><span>You must not attempt to contact assigned tutors directly outside the Merit platform, or solicit tutors for private lessons without Merit's knowledge.</span></li>
                  <li><i class="fas fa-times"></i><span>You must not provide false, misleading, or inaccurate information when registering, booking, or donating.</span></li>
                </ul>
                <p>Violation of these conduct standards may result in immediate termination of your account and services, without refund.</p>
              </div>
            </div>

            <!-- S9 -->
            <div class="legal-section" id="t9" data-r="up">
              <div class="ls-header">
                <div class="ls-num">09</div>
                <div class="ls-icon"><i class="fas fa-copyright"></i></div>
                <h2 class="ls-title">Intellectual Property</h2>
              </div>
              <div class="ls-body">
                <p>All content on our website, including but not limited to text, graphics, logos, lesson materials, progress reports, videos, and course structures, is the intellectual property of Merit Education Foundation or its licensed partners and is protected under UK and international copyright law.</p>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span>You may not reproduce, distribute, or commercially exploit any Merit content without prior written authorisation.</span></li>
                  <li><i class="fas fa-circle"></i><span>Lesson materials shared with students are for personal educational use only and may not be resold, redistributed, or published.</span></li>
                  <li><i class="fas fa-circle"></i><span>The "Merit Education Foundation" name, logo, and associated branding are registered trademarks. Unauthorised use is prohibited.</span></li>
                </ul>
              </div>
            </div>

            <!-- S10 -->
            <div class="legal-section" id="t10" data-r="up">
              <div class="ls-header">
                <div class="ls-num">10</div>
                <div class="ls-icon"><i class="fas fa-balance-scale"></i></div>
                <h2 class="ls-title">Limitation of Liability</h2>
              </div>
              <div class="ls-body">
                <p>To the maximum extent permitted by applicable law, Merit Education Foundation shall not be liable for any indirect, incidental, special, consequential or punitive damages, including but not limited to loss of profits, data, goodwill, or other intangible losses.</p>
                <p>Our total liability to you for any claim arising from these Terms or our services shall not exceed the total fees paid by you to Merit Education Foundation in the 12 months preceding the claim.</p>
                <div class="hl-box hl-navy">
                  <i class="fas fa-info-circle" style="color:var(--navy)"></i>
                  <div class="hl-text"><p>Nothing in these Terms shall limit or exclude our liability for death or personal injury caused by our negligence, fraud or fraudulent misrepresentation, or any other liability that cannot be limited or excluded under English law.</p></div>
                </div>
              </div>
            </div>

            <!-- S11 -->
            <div class="legal-section" id="t11" data-r="up">
              <div class="ls-header">
                <div class="ls-num">11</div>
                <div class="ls-icon"><i class="fas fa-ban"></i></div>
                <h2 class="ls-title">Termination</h2>
              </div>
              <div class="ls-body">
                <p>Either party may terminate this agreement by providing written notice. Merit Education Foundation reserves the right to suspend or terminate your access to our services immediately, without notice or refund, in cases of:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span>Breach of these Terms & Conditions or our Safeguarding Policy</span></li>
                  <li><i class="fas fa-circle"></i><span>Non-payment of lesson fees for 14 days or more</span></li>
                  <li><i class="fas fa-circle"></i><span>Abusive, threatening, or inappropriate conduct toward staff, tutors, or other users</span></li>
                  <li><i class="fas fa-circle"></i><span>Fraudulent activity or misrepresentation</span></li>
                </ul>
                <p>Upon termination, all outstanding lesson fees become immediately payable. Pre-paid lessons may be subject to our Refund Policy.</p>
              </div>
            </div>

            <!-- S12 -->
            <div class="legal-section" id="t12" data-r="up">
              <div class="ls-header">
                <div class="ls-num">12</div>
                <div class="ls-icon"><i class="fas fa-landmark"></i></div>
                <h2 class="ls-title">Governing Law</h2>
              </div>
              <div class="ls-body">
                <p>These Terms and Conditions are governed by and construed in accordance with the laws of England and Wales. Any disputes arising from these Terms shall be subject to the exclusive jurisdiction of the courts of England and Wales.</p>
                <p>For disputes relating to charitable donations or fundraising activities, we are also subject to the oversight of the Charity Commission for England and Wales.</p>
              </div>
            </div>

            <!-- S13 -->
            <div class="legal-section" id="t13" data-r="up">
              <div class="ls-header">
                <div class="ls-num">13</div>
                <div class="ls-icon"><i class="fas fa-envelope"></i></div>
                <h2 class="ls-title">Contact Us</h2>
              </div>
              <div class="ls-body">
                <p>If you have any questions about these Terms and Conditions, please contact us:</p>
                <div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px 22px;margin-top:16px">
                  <div class="row g-3">
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-building" style="color:var(--gold);font-size:.8rem"></i></div><div><div style="font-size:.72rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Organisation</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">Merit Education Foundation</div></div></div></div>
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-envelope" style="color:var(--gold);font-size:.8rem"></i></div><div><div style="font-size:.72px;color:var(--muted);letter-spacing:1px;margin-bottom:3px;font-size:.72rem">Email</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">legal@meriteducation.org</div></div></div></div>
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-phone" style="color:var(--gold);font-size:.8rem"></i></div><div><div style="font-size:.72rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Phone</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">+44 20 0000 0000</div></div></div></div>
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-map-marker-alt" style="color:var(--gold);font-size:.8rem"></i></div><div><div style="font-size:.72rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Address</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">Merit House, London, United Kingdom</div></div></div></div>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- legal-content -->
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <div class="cta-strip"><div class="container"><div class="inner"><div class="row align-items-center g-4">
    <div class="col-lg-7"><h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.7rem,3.5vw,2.5rem);font-weight:700;color:var(--navy)">Questions About Our Terms?</h2><p style="color:rgba(15,31,92,.6);margin-top:8px;font-size:.92rem">Our team is happy to clarify anything. Reach out before booking or donating.</p></div>
    <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end">
      <button class="btn-gold-nav" style="background:var(--navy);color:#fff"><i class="fas fa-envelope"></i>Contact Us</button>
      <button class="btn-ghost-nav" style="border-color:rgba(15,31,92,.3);color:var(--navy)">Book a Lesson</button>
    </div>
  </div></div></div></div>

</div><!-- end terms -->
<script>
/* ── Loader */
window.addEventListener('load',()=>setTimeout(()=>document.getElementById('loader').classList.add('done'),1200));

/* ── Page Router */
function showPage(id){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.getElementById('page-'+id)?.classList.add('active');

  /* legal page nav bar */
  document.getElementById('legal-page-nav').style.display='block';
  document.querySelectorAll('.lpn-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById('lpn-'+id)?.classList.add('active');

  /* nav underline */
  document.querySelectorAll('.nav-lnk').forEach(l=>l.classList.remove('active'));
  const map={terms:0,refund:1,cookie:2};
  if(map[id]!==undefined) document.querySelectorAll('.nav-lnk')[map[id]]?.classList.add('active');

  document.querySelector('.mob-menu')?.classList.remove('open');
  window.scrollTo({top:0,behavior:'smooth'});
  setTimeout(initReveal,100);
}

/* ── Scroll Reveal */
function initReveal(){
  const io=new IntersectionObserver(entries=>{
    entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target)}});
  },{threshold:.1});
  document.querySelectorAll('[data-r]:not(.on)').forEach(el=>io.observe(el));
}
window.addEventListener('load',initReveal);

/* ── Scroll + navbar */
window.addEventListener('scroll',()=>{
  document.getElementById('nav').classList.toggle('scrolled',scrollY>50);
  document.getElementById('btt').classList.toggle('show',scrollY>400);
  /* highlight TOC item */
  updateActiveTOC();
});

function updateActiveTOC(){
  const sections=document.querySelectorAll('.legal-section');
  sections.forEach(sec=>{
    const rect=sec.getBoundingClientRect();
    if(rect.top<=130&&rect.bottom>=130){
      document.querySelectorAll('.toc-item').forEach(t=>t.classList.remove('active'));
      const matching=document.querySelector(`.toc-item[onclick*="${sec.id}"]`);
      if(matching)matching.classList.add('active');
    }
  });
}

/* ── TOC scroll */
function scrollTo(id,el){
  const target=document.getElementById(id);
  if(target){
    const offset=140;
    const y=target.getBoundingClientRect().top+window.scrollY-offset;
    window.scrollTo({top:y,behavior:'smooth'});
  }
  document.querySelectorAll('.toc-item').forEach(t=>t.classList.remove('active'));
  if(el)el.classList.add('active');
}

/* ── Cookie preference actions */
function saveCookiePrefs(){
  document.getElementById('cookie-pref-saved').style.display='flex';
  setTimeout(()=>document.getElementById('cookie-pref-saved').style.display='none',4000);
}
function acceptAllCookies(){
  ['analytics-toggle','func-toggle','mkt-toggle'].forEach(id=>{
    document.getElementById(id).checked=true;
  });
  saveCookiePrefs();
}
function rejectOptional(){
  ['analytics-toggle','func-toggle','mkt-toggle'].forEach(id=>{
    document.getElementById(id).checked=false;
  });
  saveCookiePrefs();
}

/* ── Init */
showPage('terms');
</script>



@endsection