@extends('layouts.frontend')
@section('title', 'Refund Policy - Merit Education Foundation')
@section('content')
<style>
/* ═══════════════════════════════════════
   DESIGN TOKENS — matches Merit premium
═══════════════════════════════════════ */

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
     PAGE 2 — REFUND POLICY
════════════════════════════════════════════════ -->
<div id="" class="">

  <div class="page-hero" style="background:linear-gradient(to bottom right,var(--dark),#0a1535)">
    <div class="container ph-inner">
      <div class="ph-badge"><span><i class="fas fa-undo me-1"></i>Legal Document</span></div>
      <h1 class="ph-h">Refund <em>Policy</em></h1>
      <p class="ph-p">We want every family to feel confident when booking lessons with Merit. This policy explains clearly when and how refunds are issued for lesson fees and, in exceptional cases, donations.</p>
      <div class="ph-meta">
        <div class="ph-meta-item"><i class="fas fa-calendar"></i><strong>Effective Date:</strong> 1 November 2025</div>
        <div class="ph-meta-item"><i class="fas fa-sync"></i><strong>Last Updated:</strong> 1 November 2025</div>
        <div class="ph-meta-item"><i class="fas fa-clock"></i><strong>Reading Time:</strong> ~8 minutes</div>
        <div class="ph-meta-item"><i class="fas fa-shield-alt"></i><strong>Version:</strong> 2.3</div>
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
              <div class="toc-item active" onclick="scrollTo('r1',this)"><span class="toc-item-num">1</span>Overview</div>
              <div class="toc-item" onclick="scrollTo('r2',this)"><span class="toc-item-num">2</span>Lesson Cancellations</div>
              <div class="toc-item" onclick="scrollTo('r3',this)"><span class="toc-item-num">3</span>Refund Eligibility</div>
              <div class="toc-item" onclick="scrollTo('r4',this)"><span class="toc-item-num">4</span>Refund Timeline</div>
              <div class="toc-item" onclick="scrollTo('r5',this)"><span class="toc-item-num">5</span>Non-Refundable Items</div>
              <div class="toc-item" onclick="scrollTo('r6',this)"><span class="toc-item-num">6</span>Donation Refunds</div>
              <div class="toc-item" onclick="scrollTo('r7',this)"><span class="toc-item-num">7</span>How to Request</div>
              <div class="toc-item" onclick="scrollTo('r8',this)"><span class="toc-item-num">8</span>Contact</div>
            </div>
            <div class="toc-meta-box">
              <div class="tmb-row"><span class="tmb-label">Refund window</span><span class="tmb-val">Up to 14 days</span></div>
              <div class="tmb-row"><span class="tmb-label">Processing time</span><span class="tmb-val">5–10 working days</span></div>
              <div class="tmb-row"><span class="tmb-label">Contact</span><span class="tmb-val">refunds@merit.org</span></div>
            </div>
            <div class="switch-doc-card">
              <div class="sdc-title">Other Legal Pages</div>
              <div class="sdc-link" onclick="showPage('terms')"><i class="fas fa-chevron-right"></i>Terms & Conditions</div>
              <div class="sdc-link" onclick="showPage('cookie')"><i class="fas fa-chevron-right"></i>Cookie Policy</div>
              <div class="sdc-link"><i class="fas fa-chevron-right"></i>Privacy Policy</div>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
          <div class="legal-content">

            <div class="hl-box hl-green mb-4" data-r="up">
              <i class="fas fa-check-circle" style="color:var(--green)"></i>
              <div class="hl-text"><p><strong>Our Commitment:</strong> We believe in fairness and transparency. If you cancel a lesson within the permitted period or Merit cancels a session, you will receive a full refund or credit. We make the process simple and hassle-free.</p></div>
            </div>

            <!-- Eligibility Grid -->
            <div class="row g-3 mb-4" data-r="up">
              <div class="col-md-4">
                <div class="elig-card eligible">
                  <div class="elig-head"><div class="elig-ic" style="background:rgba(21,128,61,.1)"><i class="fas fa-check" style="color:var(--green)"></i></div><div class="elig-label">Fully Refundable</div></div>
                  <ul class="elig-list">
                    <li><i class="fas fa-check" style="color:var(--green)"></i>Cancelled 24+ hours before</li>
                    <li><i class="fas fa-check" style="color:var(--green)"></i>Merit-cancelled sessions</li>
                    <li><i class="fas fa-check" style="color:var(--green)"></i>Technical failure by Merit</li>
                    <li><i class="fas fa-check" style="color:var(--green)"></i>Tutor no-show</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="elig-card partial">
                  <div class="elig-head"><div class="elig-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-adjust" style="color:var(--gold)"></i></div><div class="elig-label">Partial / Credit</div></div>
                  <ul class="elig-list">
                    <li><i class="fas fa-adjust" style="color:var(--gold)"></i>Cancelled 6–24 hrs before</li>
                    <li><i class="fas fa-adjust" style="color:var(--gold)"></i>Medical emergency (evidence)</li>
                    <li><i class="fas fa-adjust" style="color:var(--gold)"></i>Mid-block cancellation</li>
                    <li><i class="fas fa-adjust" style="color:var(--gold)"></i>Bereavement (discretion)</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="elig-card not-eligible">
                  <div class="elig-head"><div class="elig-ic" style="background:rgba(220,38,38,.08)"><i class="fas fa-times" style="color:var(--red)"></i></div><div class="elig-label">Not Refundable</div></div>
                  <ul class="elig-list">
                    <li><i class="fas fa-times" style="color:var(--red)"></i>Less than 6 hrs' notice</li>
                    <li><i class="fas fa-times" style="color:var(--red)"></i>Student no-show</li>
                    <li><i class="fas fa-times" style="color:var(--red)"></i>Completed lessons</li>
                    <li><i class="fas fa-times" style="color:var(--red)"></i>Free trial sessions</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- R1 -->
            <div class="legal-section" id="r1" data-r="up">
              <div class="ls-header">
                <div class="ls-num">01</div>
                <div class="ls-icon"><i class="fas fa-info-circle"></i></div>
                <h2 class="ls-title">Overview</h2>
              </div>
              <div class="ls-body">
                <p>This Refund Policy applies exclusively to lesson fees paid to Merit Education Foundation for one-to-one Quran teaching sessions. It does not apply to charitable donations (which are governed by separate terms outlined in Section 6 below).</p>
                <p>Merit Education Foundation is committed to providing a fair, transparent, and family-friendly refund process. We understand that life circumstances change, and we aim to handle all refund requests with empathy and common sense within the framework below.</p>
              </div>
            </div>

            <!-- R2 -->
            <div class="legal-section" id="r2" data-r="up">
              <div class="ls-header">
                <div class="ls-num">02</div>
                <div class="ls-icon"><i class="fas fa-calendar-times"></i></div>
                <h2 class="ls-title">Lesson Cancellation Policy</h2>
              </div>
              <div class="ls-body">
                <div class="ls-sub"><i class="fas fa-user"></i>Cancellation by the Student / Parent</div>
                <table class="policy-table">
                  <thead><tr><th>Notice Given</th><th>Outcome</th><th>Refund / Credit</th></tr></thead>
                  <tbody>
                    <tr><td>24+ hours before lesson</td><td>Full refund or lesson credit</td><td>100% refund</td></tr>
                    <tr><td>6–24 hours before lesson</td><td>Lesson credit only (no cash refund)</td><td>100% credit</td></tr>
                    <tr><td>Under 6 hours / no-show</td><td>Session forfeited</td><td>0% — no refund or credit</td></tr>
                  </tbody>
                </table>
                <div class="ls-sub"><i class="fas fa-chalkboard-teacher"></i>Cancellation by Merit / Tutor</div>
                <p>If Merit Education Foundation or your assigned tutor cancels a lesson for any reason, you will receive a full refund of the lesson fee or a lesson credit — whichever you prefer. We will notify you as early as possible and offer alternative times where available.</p>
              </div>
            </div>

            <!-- R3 -->
            <div class="legal-section" id="r3" data-r="up">
              <div class="ls-header">
                <div class="ls-num">03</div>
                <div class="ls-icon"><i class="fas fa-clipboard-check"></i></div>
                <h2 class="ls-title">Refund Eligibility Conditions</h2>
              </div>
              <div class="ls-body">
                <p>In addition to the standard cancellation policy, refunds may be issued in the following circumstances at Merit's discretion:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-check"></i><span><strong>Technical Failure:</strong> If a lesson cannot proceed due to a verified technical failure on Merit's platform or tutor side, a full refund or rescheduled session will be offered.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Medical Emergency:</strong> If a student or immediate family member experiences a medical emergency, we will consider a lesson credit upon receipt of appropriate evidence.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Bereavement:</strong> In cases of bereavement affecting the student or their immediate family, Merit will handle requests with sensitivity and discretion.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>Unsatisfactory Service:</strong> If you believe a lesson was significantly substandard, please contact us within 48 hours with specific details. We will investigate and, where appropriate, offer a credit or partial refund.</span></li>
                  <li><i class="fas fa-check"></i><span><strong>14-Day Cooling-Off Period:</strong> For new students, if you cancel all future lessons within 14 days of your first paid (non-trial) session, you may request a full refund of any unused pre-paid lessons.</span></li>
                </ul>
              </div>
            </div>

            <!-- R4 -->
            <div class="legal-section" id="r4" data-r="up">
              <div class="ls-header">
                <div class="ls-num">04</div>
                <div class="ls-icon"><i class="fas fa-clock"></i></div>
                <h2 class="ls-title">Refund Timeline</h2>
              </div>
              <div class="ls-body">
                <p>Once a refund is approved, here is what to expect:</p>
                <div class="refund-timeline">
                  <div class="rt-item">
                    <div class="rt-dot"><i class="fas fa-envelope"></i></div>
                    <div class="rt-title">Step 1 — Submit Request</div>
                    <div class="rt-desc">Email refunds@meriteducation.org with your full name, lesson date(s), and reason for refund. Include any supporting evidence if applicable.</div>
                    <span class="rt-tag tag-navy">Day 0</span>
                  </div>
                  <div class="rt-item">
                    <div class="rt-dot"><i class="fas fa-search"></i></div>
                    <div class="rt-title">Step 2 — Review</div>
                    <div class="rt-desc">Our team will review your request and confirm eligibility within 2 working days. We may contact you for additional information.</div>
                    <span class="rt-tag tag-amber">Within 2 working days</span>
                  </div>
                  <div class="rt-item">
                    <div class="rt-dot"><i class="fas fa-check"></i></div>
                    <div class="rt-title">Step 3 — Approval Notification</div>
                    <div class="rt-desc">You will receive a confirmation email stating whether your refund has been approved, the amount, and the refund method.</div>
                    <span class="rt-tag tag-amber">Days 2–4</span>
                  </div>
                  <div class="rt-item">
                    <div class="rt-dot"><i class="fas fa-pound-sign"></i></div>
                    <div class="rt-title">Step 4 — Refund Processed</div>
                    <div class="rt-desc">Approved refunds are returned to the original payment method. Bank transfers may take additional time depending on your bank's processing schedule.</div>
                    <span class="rt-tag tag-green">5–10 working days</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- R5 -->
            <div class="legal-section" id="r5" data-r="up">
              <div class="ls-header">
                <div class="ls-num">05</div>
                <div class="ls-icon"><i class="fas fa-ban"></i></div>
                <h2 class="ls-title">Non-Refundable Items</h2>
              </div>
              <div class="ls-body">
                <p>The following are not eligible for refund under any circumstances:</p>
                <ul class="policy-list">
                  <li><i class="fas fa-times" style="color:var(--red)"></i><span><strong>Completed lessons:</strong> Any lesson that has taken place, regardless of outcome or satisfaction, is non-refundable.</span></li>
                  <li><i class="fas fa-times" style="color:var(--red)"></i><span><strong>Free trial sessions:</strong> No financial consideration is exchanged for trial lessons, therefore no refund applies.</span></li>
                  <li><i class="fas fa-times" style="color:var(--red)"></i><span><strong>Lessons cancelled with less than 6 hours' notice without exceptional circumstance.</strong></span></li>
                  <li><i class="fas fa-times" style="color:var(--red)"></i><span><strong>Student no-shows:</strong> If a student fails to attend a scheduled lesson without prior notice, the session fee is forfeited.</span></li>
                  <li><i class="fas fa-times" style="color:var(--red)"></i><span><strong>Accounts suspended due to conduct violations:</strong> No refund is issued where access is revoked due to breach of our Terms & Conditions or Safeguarding Policy.</span></li>
                </ul>
              </div>
            </div>

            <!-- R6 -->
            <div class="legal-section" id="r6" data-r="up">
              <div class="ls-header">
                <div class="ls-num">06</div>
                <div class="ls-icon"><i class="fas fa-heart"></i></div>
                <h2 class="ls-title">Donation Refunds</h2>
              </div>
              <div class="ls-body">
                <p>Charitable donations made to Merit Education Foundation are generally <strong>non-refundable</strong>, as they are immediately allocated to fund children's education programmes upon receipt.</p>
                <div class="hl-box hl-gold">
                  <i class="fas fa-star" style="color:var(--gold)"></i>
                  <div class="hl-text"><p><strong>Exceptional Circumstances Only:</strong> In rare cases — such as a demonstrably fraudulent transaction, duplicate payment, or verifiable processing error — Merit Education Foundation will consider a donation refund on a case-by-case basis. Please contact <a href="mailto:donations@meriteducation.org">donations@meriteducation.org</a> within 7 days of the transaction.</p></div>
                </div>
                <ul class="policy-list">
                  <li><i class="fas fa-circle"></i><span>Donations processed via Gift Aid cannot be refunded once submitted to HMRC.</span></li>
                  <li><i class="fas fa-circle"></i><span>Monthly donation subscriptions can be cancelled at any time, but amounts already collected are non-refundable.</span></li>
                  <li><i class="fas fa-circle"></i><span>Zakat donations are subject to Islamic jurisprudence and cannot be redirected once allocated to eligible recipients.</span></li>
                </ul>
              </div>
            </div>

            <!-- R7 -->
            <div class="legal-section" id="r7" data-r="up">
              <div class="ls-header">
                <div class="ls-num">07</div>
                <div class="ls-icon"><i class="fas fa-paper-plane"></i></div>
                <h2 class="ls-title">How to Request a Refund</h2>
              </div>
              <div class="ls-body">
                <p>To request a refund, please contact us using one of the following methods:</p>
                <div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;margin-top:16px">
                  <div class="row g-3">
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-envelope" style="color:var(--gold);font-size:.8rem"></i></div><div><div style="font-size:.7rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Email (preferred)</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">refunds@meriteducation.org</div><div style="font-size:.72rem;color:var(--muted);margin-top:3px">Response within 2 working days</div></div></div></div>
                    <div class="col-md-6"><div style="display:flex;gap:12px;align-items:flex-start"><div style="width:36px;height:36px;border-radius:9px;background:rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-phone" style="color:var(--gold);font-size:.8rem"></i></div><div><div style="font-size:.7rem;color:var(--muted);letter-spacing:1px;margin-bottom:3px">Phone</div><div style="font-size:.85rem;font-weight:600;color:var(--navy)">+44 20 0000 0000</div><div style="font-size:.72rem;color:var(--muted);margin-top:3px">Mon–Fri, 9am–6pm GMT</div></div></div></div>
                  </div>
                  <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border)">
                    <div style="font-size:.72rem;font-weight:700;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-bottom:8px">Please include in your request:</div>
                    <ul class="policy-list" style="margin:0">
                      <li><i class="fas fa-circle"></i>Your full name and registered email address</li>
                      <li><i class="fas fa-circle"></i>The date(s) of the lesson(s) in question</li>
                      <li><i class="fas fa-circle"></i>Your reason for requesting a refund</li>
                      <li><i class="fas fa-circle"></i>Any supporting evidence (medical note, etc.) if applicable</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- R8 -->
            <div class="legal-section" id="r8" data-r="up">
              <div class="ls-header">
                <div class="ls-num">08</div>
                <div class="ls-icon"><i class="fas fa-headset"></i></div>
                <h2 class="ls-title">Disputes & Further Assistance</h2>
              </div>
              <div class="ls-body">
                <p>If you are unhappy with the outcome of your refund request, you may escalate the matter to our senior management team at <a href="mailto:info@meriteducation.org">info@meriteducation.org</a>, marked "Refund Dispute".</p>
                <p>If you remain unsatisfied, you may seek independent advice from Citizens Advice (citizensadvice.org.uk) or the Charity Commission if the matter relates to a donation. UK consumer rights under the Consumer Rights Act 2015 are not affected by this policy.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="cta-strip"><div class="container"><div class="inner"><div class="row align-items-center g-4">
    <div class="col-lg-7"><h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.7rem,3.5vw,2.5rem);font-weight:700;color:var(--navy)">Need Help With a Refund?</h2><p style="color:rgba(15,31,92,.6);margin-top:8px;font-size:.92rem">Our team responds within 2 working days and will always treat your request fairly.</p></div>
    <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end">
      <button class="btn-gold-nav" style="background:var(--navy);color:#fff"><i class="fas fa-envelope"></i>Email Us</button>
      <button class="btn-ghost-nav" style="border-color:rgba(15,31,92,.3);color:var(--navy)">Book a Lesson</button>
    </div>
  </div></div></div></div>

</div><!-- end refund -->






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