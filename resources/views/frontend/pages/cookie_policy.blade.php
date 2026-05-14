@extends('layouts.frontend')
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




<!-- ════════════════════════════════════════════════
     PAGE 3 — COOKIE POLICY
════════════════════════════════════════════════ -->
<div id="" class="">

  <div class="page-hero" style="background:linear-gradient(135deg,var(--dark) 0%,#091030 50%,#05201a 100%)">
    <div class="container ph-inner">
      <div class="ph-badge"><span><i class="fas fa-cookie-bite me-1"></i>Legal Document</span></div>
      <h1 class="ph-h">Cookie <em>Policy</em></h1>
      <p class="ph-p">This policy explains what cookies are, which cookies Merit Education Foundation uses, and how you can control them. We are committed to being clear and honest about how we use tracking technologies.</p>
      <div class="ph-meta">
        <div class="ph-meta-item"><i class="fas fa-calendar"></i><strong>Effective Date:</strong> 1 November 2025</div>
        <div class="ph-meta-item"><i class="fas fa-sync"></i><strong>Last Updated:</strong> 1 November 2025</div>
        <div class="ph-meta-item"><i class="fas fa-clock"></i><strong>Reading Time:</strong> ~7 minutes</div>
        <div class="ph-meta-item"><i class="fas fa-shield-alt"></i><strong>UK GDPR Compliant</strong></div>
      </div>
    </div>
  </div>

  <section class="legal-body">
    <div class="container">
      <div class="row g-5">

        <!-- TOC -->
        <div class="col-lg-3">
          <div class="toc-sidebar">
            <div class="toc-card">
              <div class="toc-title"><i class="fas fa-list"></i>Contents</div>
              <div class="toc-item active" onclick="scrollTo('c1',this)"><span class="toc-item-num">1</span>What Are Cookies?</div>
              <div class="toc-item" onclick="scrollTo('c2',this)"><span class="toc-item-num">2</span>How We Use Cookies</div>
              <div class="toc-item" onclick="scrollTo('c3',this)"><span class="toc-item-num">3</span>Types of Cookies</div>
              <div class="toc-item" onclick="scrollTo('c4',this)"><span class="toc-item-num">4</span>Cookie Details</div>
              <div class="toc-item" onclick="scrollTo('c5',this)"><span class="toc-item-num">5</span>Your Preferences</div>
              <div class="toc-item" onclick="scrollTo('c6',this)"><span class="toc-item-num">6</span>Third-Party Cookies</div>
              <div class="toc-item" onclick="scrollTo('c7',this)"><span class="toc-item-num">7</span>Browser Controls</div>
              <div class="toc-item" onclick="scrollTo('c8',this)"><span class="toc-item-num">8</span>Updates</div>
              <div class="toc-item" onclick="scrollTo('c9',this)"><span class="toc-item-num">9</span>Contact</div>
            </div>
            <div class="toc-meta-box">
              <div class="tmb-row"><span class="tmb-label">Essential cookies</span><span class="tmb-val">Always on</span></div>
              <div class="tmb-row"><span class="tmb-label">Optional cookies</span><span class="tmb-val">Your choice</span></div>
              <div class="tmb-row"><span class="tmb-label">Regulation</span><span class="tmb-val">UK GDPR / PECR</span></div>
            </div>
            <div class="switch-doc-card">
              <div class="sdc-title">Other Legal Pages</div>
              <div class="sdc-link" onclick="showPage('terms')"><i class="fas fa-chevron-right"></i>Terms & Conditions</div>
              <div class="sdc-link" onclick="showPage('refund')"><i class="fas fa-chevron-right"></i>Refund Policy</div>
              <div class="sdc-link"><i class="fas fa-chevron-right"></i>Privacy Policy</div>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
          <div class="legal-content">

            <div class="hl-box hl-teal mb-4" data-r="up">
              <i class="fas fa-info-circle" style="color:var(--teal)"></i>
              <div class="hl-text"><p><strong>Plain English Summary:</strong> We use a small number of cookies to make our website work properly and to understand how people use it. We never use cookies to sell your data or for intrusive advertising. You can choose which optional cookies to allow at any time.</p></div>
            </div>

            <!-- C1 -->
            <div class="legal-section" id="c1" data-r="up">
              <div class="ls-header">
                <div class="ls-num">01</div>
                <div class="ls-icon"><i class="fas fa-cookie"></i></div>
                <h2 class="ls-title">What Are Cookies?</h2>
              </div>
              <div class="ls-body">
                <p>Cookies are small text files that are placed on your device (computer, tablet, or smartphone) when you visit a website. They are widely used to make websites work more efficiently, to provide a better user experience, and to give website owners useful information about how their sites are used.</p>
                <p>Cookies are not harmful. They cannot execute programmes or deliver viruses. A cookie is simply a piece of data — it may contain information like your session ID, preferences, or anonymous usage data.</p>
                <div class="hl-box hl-navy">
                  <i class="fas fa-balance-scale" style="color:var(--navy)"></i>
                  <div class="hl-text"><p><strong>Legal Basis:</strong> Merit Education Foundation uses cookies in accordance with the UK General Data Protection Regulation (UK GDPR) and the Privacy and Electronic Communications Regulations (PECR). We obtain your consent before placing any non-essential cookies on your device.</p></div>
                </div>
              </div>
            </div>

            <!-- C2 -->
            <div class="legal-section" id="c2" data-r="up">
              <div class="ls-header">
                <div class="ls-num">02</div>
                <div class="ls-icon"><i class="fas fa-cogs"></i></div>
                <h2 class="ls-title">How We Use Cookies</h2>
              </div>
              <div class="ls-body">
                <p>Merit Education Foundation uses cookies for the following purposes:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-check"></i><span><strong>Essential functionality:</strong> To keep you logged in to your account, maintain your session security, and remember your preferences during a visit.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Performance & analytics:</strong> To understand how visitors interact with our website so we can improve it. We use anonymised data only — we never track individuals.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Communication preferences:</strong> To remember whether you have accepted or declined our cookie notice, so we don't show it repeatedly.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Payment security:</strong> Our payment provider (Stripe) places cookies to prevent fraud and ensure secure transactions.</span></li>
                </ul>
                <p>We do <strong>not</strong> use cookies for targeted advertising, profiling, or to sell your data to third parties.</p>
              </div>
            </div>

            <!-- C3 -->
            <div class="legal-section" id="c3" data-r="up">
              <div class="ls-header">
                <div class="ls-num">03</div>
                <div class="ls-icon"><i class="fas fa-layer-group"></i></div>
                <h2 class="ls-title">Types of Cookies We Use</h2>
              </div>
              <div class="ls-body">
                <p>We categorise our cookies into four types. Essential cookies are always active. All others require your consent.</p>
                <table class="policy-table">
                  <thead><tr><th>Category</th><th>Consent Required?</th><th>Can Be Disabled?</th><th>Retention</th></tr></thead>
                  <tbody>
                    <tr><td>Essential / Strictly Necessary</td><td>No — legally required to function</td><td>No</td><td>Session or up to 1 year</td></tr>
                    <tr><td>Performance / Analytics</td><td>Yes</td><td>Yes</td><td>Up to 2 years</td></tr>
                    <tr><td>Functional / Preferences</td><td>Yes</td><td>Yes</td><td>Up to 1 year</td></tr>
                    <tr><td>Marketing / Tracking</td><td>Yes</td><td>Yes</td><td>Up to 90 days</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- C4 -->
            <div class="legal-section" id="c4" data-r="up">
              <div class="ls-header">
                <div class="ls-num">04</div>
                <div class="ls-icon"><i class="fas fa-table"></i></div>
                <h2 class="ls-title">Cookie Details</h2>
              </div>
              <div class="ls-body">
                <p>Below is a detailed breakdown of the specific cookies we use:</p>
                <div class="ls-sub"><i class="fas fa-lock"></i>Essential Cookies</div>
                <table class="policy-table">
                  <thead><tr><th>Cookie Name</th><th>Purpose</th><th>Duration</th><th>Source</th></tr></thead>
                  <tbody>
                    <tr><td>merit_session</td><td>Maintains your logged-in session and keeps you authenticated on the platform</td><td>Session (cleared on browser close)</td><td>Merit</td></tr>
                    <tr><td>csrf_token</td><td>Protects against cross-site request forgery attacks — a security measure</td><td>Session</td><td>Merit</td></tr>
                    <tr><td>cookie_consent</td><td>Stores your cookie consent preferences so we don't ask you repeatedly</td><td>12 months</td><td>Merit</td></tr>
                    <tr><td>__stripe_mid</td><td>Fraud detection and secure payment processing</td><td>12 months</td><td>Stripe</td></tr>
                    <tr><td>__stripe_sid</td><td>Fraud detection during active payment sessions</td><td>30 minutes</td><td>Stripe</td></tr>
                  </tbody>
                </table>
                <div class="ls-sub mt-4"><i class="fas fa-chart-bar"></i>Analytics Cookies (Optional)</div>
                <table class="policy-table">
                  <thead><tr><th>Cookie Name</th><th>Purpose</th><th>Duration</th><th>Source</th></tr></thead>
                  <tbody>
                    <tr><td>_ga</td><td>Distinguishes users for Google Analytics. Data is anonymised — no personal details are stored.</td><td>2 years</td><td>Google Analytics</td></tr>
                    <tr><td>_ga_[ID]</td><td>Maintains session state for Google Analytics 4</td><td>2 years</td><td>Google Analytics</td></tr>
                    <tr><td>_gid</td><td>Distinguishes users for Google Analytics — expires after 24 hours</td><td>24 hours</td><td>Google Analytics</td></tr>
                  </tbody>
                </table>
                <div class="ls-sub mt-4"><i class="fas fa-sliders-h"></i>Functional Cookies (Optional)</div>
                <table class="policy-table">
                  <thead><tr><th>Cookie Name</th><th>Purpose</th><th>Duration</th></tr></thead>
                  <tbody>
                    <tr><td>merit_lang</td><td>Remembers your preferred language setting</td><td>12 months</td></tr>
                    <tr><td>merit_theme</td><td>Stores your display preference (light/dark mode)</td><td>6 months</td></tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- C5 -->
            <div class="legal-section" id="c5" data-r="up">
              <div class="ls-header">
                <div class="ls-num">05</div>
                <div class="ls-icon"><i class="fas fa-sliders-h"></i></div>
                <h2 class="ls-title">Manage Your Cookie Preferences</h2>
              </div>
              <div class="ls-body">
                <p>You can control your cookie preferences below. Please note that disabling certain cookies may affect the functionality of our website.</p>

                <div class="cookie-toggle-row">
                  <div class="ct-info">
                    <div class="ct-title"><i class="fas fa-lock" style="color:var(--navy);font-size:.8rem"></i>Essential Cookies<span class="ct-badge ct-required">Always On</span></div>
                    <div class="ct-desc">These cookies are strictly necessary for the website to function. They enable core services such as account login, security (CSRF protection), and payment processing. They cannot be disabled.</div>
                  </div>
                  <label class="toggle-sw"><input type="checkbox" checked disabled><span class="toggle-sl"></span></label>
                </div>

                <div class="cookie-toggle-row">
                  <div class="ct-info">
                    <div class="ct-title"><i class="fas fa-chart-line" style="color:var(--teal);font-size:.8rem"></i>Analytics Cookies<span class="ct-badge ct-optional">Optional</span></div>
                    <div class="ct-desc">Help us understand how visitors interact with our website using Google Analytics. All data is anonymised — we use this to improve our content and user experience. No personal data is collected.</div>
                  </div>
                  <label class="toggle-sw"><input type="checkbox" id="analytics-toggle" checked><span class="toggle-sl"></span></label>
                </div>

                <div class="cookie-toggle-row">
                  <div class="ct-info">
                    <div class="ct-title"><i class="fas fa-sliders-h" style="color:var(--gold);font-size:.8rem"></i>Functional Cookies<span class="ct-badge ct-optional">Optional</span></div>
                    <div class="ct-desc">Remember your preferences such as your language setting and display theme (light/dark mode) to provide a personalised experience across visits.</div>
                  </div>
                  <label class="toggle-sw"><input type="checkbox" id="func-toggle" checked><span class="toggle-sl"></span></label>
                </div>

                <div class="cookie-toggle-row">
                  <div class="ct-info">
                    <div class="ct-title"><i class="fas fa-bullhorn" style="color:var(--muted);font-size:.8rem"></i>Marketing Cookies<span class="ct-badge ct-optional">Optional</span></div>
                    <div class="ct-desc">We do not currently use marketing or advertising cookies. If this changes in future, we will seek your consent explicitly before placing any such cookies. Currently disabled by default.</div>
                  </div>
                  <label class="toggle-sw"><input type="checkbox" id="mkt-toggle"><span class="toggle-sl"></span></label>
                </div>

                <div style="margin-top:20px;display:flex;gap:12px;flex-wrap:wrap">
                  <button onclick="saveCookiePrefs()" style="display:inline-flex;align-items:center;gap:8px;background:var(--navy);color:#fff;padding:12px 28px;border-radius:9px;font-weight:700;font-size:.78rem;letter-spacing:1px;border:none;cursor:pointer;transition:.3s" onmouseover="this.style.background='var(--navy2)'" onmouseout="this.style.background='var(--navy)'"><i class="fas fa-save"></i>Save Preferences</button>
                  <button onclick="acceptAllCookies()" style="display:inline-flex;align-items:center;gap:8px;background:var(--gold);color:var(--navy);padding:12px 28px;border-radius:9px;font-weight:700;font-size:.78rem;letter-spacing:1px;border:none;cursor:pointer;transition:.3s"><i class="fas fa-check"></i>Accept All</button>
                  <button onclick="rejectOptional()" style="display:inline-flex;align-items:center;gap:8px;background:transparent;color:var(--muted);padding:12px 22px;border-radius:9px;font-weight:600;font-size:.78rem;border:1.5px solid var(--border);cursor:pointer;transition:.3s"><i class="fas fa-times"></i>Essential Only</button>
                </div>

                <div id="cookie-pref-saved" style="display:none;margin-top:14px" class="hl-box hl-green">
                  <i class="fas fa-check-circle" style="color:var(--green)"></i>
                  <div class="hl-text"><p><strong>Preferences Saved!</strong> Your cookie settings have been updated. Changes take effect immediately.</p></div>
                </div>
              </div>
            </div>

            <!-- C6 -->
            <div class="legal-section" id="c6" data-r="up">
              <div class="ls-header">
                <div class="ls-num">06</div>
                <div class="ls-icon"><i class="fas fa-share-alt"></i></div>
                <h2 class="ls-title">Third-Party Cookies</h2>
              </div>
              <div class="ls-body">
                <p>Some cookies are placed by trusted third-party services that we use on our website. We only work with trusted partners who comply with UK GDPR and PECR:</p>
                <table class="policy-table">
                  <thead><tr><th>Provider</th><th>Purpose</th><th>Cookie Category</th><th>Privacy Policy</th></tr></thead>
                  <tbody>
                    <tr><td>Google Analytics</td><td>Anonymous website usage statistics</td><td>Analytics</td><td>policies.google.com/privacy</td></tr>
                    <tr><td>Stripe</td><td>Secure payment processing & fraud prevention</td><td>Essential</td><td>stripe.com/gb/privacy</td></tr>
                    <tr><td>Zoom</td><td>Video lesson delivery (embedded on lesson pages)</td><td>Functional</td><td>zoom.us/privacy</td></tr>
                  </tbody>
                </table>
                <p>We do not have control over third-party cookies. Please refer to each provider's privacy policy for full details of their data practices.</p>
              </div>
            </div>

            <!-- C7 -->
            <div class="legal-section" id="c7" data-r="up">
              <div class="ls-header">
                <div class="ls-num">07</div>
                <div class="ls-icon"><i class="fas fa-browser"></i></div>
                <h2 class="ls-title">Managing Cookies Through Your Browser</h2>
              </div>
              <div class="ls-body">
                <p>In addition to using our preference centre above, you can manage cookies directly through your browser settings. All major browsers allow you to view, delete, and block cookies:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span><strong>Google Chrome:</strong> Settings → Privacy and security → Cookies and other site data</span></li>
                  <li><i class="fas fa-circle"></i><span><strong>Mozilla Firefox:</strong> Settings → Privacy & Security → Cookies and Site Data</span></li>
                  <li><i class="fas fa-circle"></i><span><strong>Safari (Mac/iOS):</strong> Preferences → Privacy → Manage Website Data</span></li>
                  <li><i class="fas fa-circle"></i><span><strong>Microsoft Edge:</strong> Settings → Cookies and Site Permissions → Cookies and Site Data</span></li>
                </ul>
                <div class="hl-box hl-gold">
                  <i class="fas fa-exclamation-triangle" style="color:var(--gold)"></i>
                  <div class="hl-text"><p><strong>Please Note:</strong> Blocking all cookies, including essential ones, may prevent you from logging into your Merit account, completing lesson bookings, or processing payments. We recommend enabling essential cookies at minimum.</p></div>
                </div>
                <p>You can also opt out of Google Analytics tracking across all websites by installing the Google Analytics Opt-Out Browser Add-on: <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">tools.google.com/dlpage/gaoptout</a></p>
              </div>
            </div>

            <!-- C8 -->
            <div class="legal-section" id="c8" data-r="up">
              <div class="ls-header">
                <div class="ls-num">08</div>
                <div class="ls-icon"><i class="fas fa-sync"></i></div>
                <h2 class="ls-title">Updates to This Policy</h2>
              </div>
              <div class="ls-body">
                <p>We may update this Cookie Policy from time to time to reflect changes in the cookies we use, legal requirements, or improvements to our services. When we make significant changes, we will:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-check"></i><span>Update the "Last Updated" date at the top of this page</span></li>
                  <li><i class="fas fa-check"></i><span>Notify registered users via email where changes materially affect them</span></li>
                  <li><i class="fas fa-check"></i><span>Re-request consent via our cookie banner if new optional cookies are introduced</span></li>
                </ul>
                <p>We encourage you to review this page periodically to stay informed about how we use cookies.</p>
              </div>
            </div>

            <!-- C9 -->
            <div class="legal-section" id="c9" data-r="up">
              <div class="ls-header">
                <div class="ls-num">09</div>
                <div class="ls-icon"><i class="fas fa-envelope"></i></div>
                <h2 class="ls-title">Contact & Further Information</h2>
              </div>
              <div class="ls-body">
                <p>If you have any questions about our use of cookies or wish to exercise your rights under UK GDPR, please contact our Data Protection Officer:</p>
                <div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;margin-top:16px">
                  <div class="row g-3">
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(13,107,99,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-user-shield" style="color:var(--teal);font-size:.8rem"></i></div><div><div style="font-size:.7rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Data Protection Officer</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">dpo@meriteducation.org</div></div></div></div>
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(13,107,99,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-globe" style="color:var(--teal);font-size:.8rem"></i></div><div><div style="font-size:.7rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Regulator</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">ICO — ico.org.uk</div></div></div></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="cta-strip"><div class="container"><div class="inner"><div class="row align-items-center g-4">
    <div class="col-lg-7"><h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.7rem,3.5vw,2.5rem);font-weight:700;color:var(--navy)">Questions About Our Cookies?</h2><p style="color:rgba(15,31,92,.6);margin-top:8px;font-size:.92rem">Contact our Data Protection Officer for any privacy or cookie-related concerns.</p></div>
    <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end">
      <button class="btn-gold-nav" style="background:var(--navy);color:#fff"><i class="fas fa-envelope"></i>Contact DPO</button>
      <button class="btn-ghost-nav" style="border-color:rgba(15,31,92,.3);color:var(--navy)">Privacy Policy</button>
    </div>
  </div></div></div></div>

</div><!-- end cookie -->




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