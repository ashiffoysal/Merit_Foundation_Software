@extends('layouts.frontend') 
@section('title', 'Book a Lesson - Merit Education Foundation') 
 @section('content') 

<style>


*,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth;font-size:16px}
body{font-family:'DM Sans',sans-serif;color:var(--txt);background:var(--white);overflow-x:hidden}
a{text-decoration:none;color:inherit}

/* ── Scroll reveal */
[data-r]{opacity:0;transition:opacity .75s cubic-bezier(.16,1,.3,1),transform .75s cubic-bezier(.16,1,.3,1)}
[data-r="up"]{transform:translateY(40px)}
[data-r="left"]{transform:translateX(-45px)}
[data-r="right"]{transform:translateX(45px)}
[data-r="fade"]{transform:scale(.96)}
[data-r].on{opacity:1;transform:none}

/* ═══════════════════════════════
   SHARED COMPONENTS
═══════════════════════════════ */
section{padding:90px 0}
.section-cream{background:var(--cream)}
.section-light{background:var(--light)}
.eyebrow{display:inline-flex;align-items:center;gap:10px;margin-bottom:16px}
.eyebrow-line{width:28px;height:1.5px;background:var(--gold)}
.eyebrow-txt{font-size:.68rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold)}
.sec-h{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(1.9rem,4vw,3rem);font-weight:700;line-height:1.1;color:var(--navy);
}
.sec-h em{font-style:italic;color:var(--gold)}
.sec-p{color:var(--muted);font-size:.95rem;line-height:1.85;font-weight:300}
.divider-gold{
  width:52px;height:2.5px;background:linear-gradient(to right,var(--gold),var(--gold2));
  border-radius:2px;margin:18px 0;
}
.divider-gold.center{margin:18px auto}

/* Buttons */
.btn-gold{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--gold);color:var(--navy);
  padding:14px 34px;border-radius:9px;font-weight:700;font-size:.8rem;
  letter-spacing:1.8px;text-transform:uppercase;border:none;cursor:pointer;
  transition:all .3s;box-shadow:0 6px 24px rgba(201,168,76,.3);
}
.btn-gold:hover{background:var(--gold2);transform:translateY(-2px);box-shadow:0 12px 36px rgba(201,168,76,.4);color:var(--navy)}
.btn-navy{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--navy);color:var(--white);
  padding:14px 34px;border-radius:9px;font-weight:700;font-size:.8rem;
  letter-spacing:1.8px;text-transform:uppercase;border:none;cursor:pointer;transition:all .3s;
}
.btn-navy:hover{background:var(--navy2);transform:translateY(-2px);box-shadow:0 12px 36px rgba(15,31,92,.25);color:var(--white)}

/* Form fields */
.field-label{
  font-size:.68rem;font-weight:700;letter-spacing:1.8px;
  text-transform:uppercase;color:var(--navy);margin-bottom:8px;display:block;
}
.field-input,.field-select,.field-textarea{
  width:100%;padding:13px 16px;border:1.5px solid var(--border);
  border-radius:9px;font-family:'DM Sans',sans-serif;font-size:.9rem;
  color:var(--txt);background:var(--cream);outline:none;transition:all .3s;
}
.field-input:focus,.field-select:focus,.field-textarea:focus{
  border-color:var(--gold);background:var(--white);
  box-shadow:0 0 0 4px rgba(201,168,76,.1);
}
.field-input::placeholder,.field-textarea::placeholder{color:rgba(124,124,144,.45)}
.field-textarea{resize:none}
.field-group{margin-bottom:20px}

/* ═══════════════════════════════
   BOOK HERO
═══════════════════════════════ */
.book-hero{
  padding:150px 0 80px;
  background:var(--dark);
  position:relative;overflow:hidden;
}
.book-hero::before{
  content:'';position:absolute;inset:0;
  background:
    radial-gradient(ellipse 100% 80% at 30% 60%,rgba(26,46,122,.85),transparent 65%),
    radial-gradient(ellipse 50% 50% at 80% 20%,rgba(201,168,76,.06),transparent);
}
.book-hero::after{
  content:'';position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),
                   linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);
  background-size:64px 64px;
}
.book-hero .container{position:relative;z-index:2}
.page-hero-badge{
  display:inline-flex;align-items:center;gap:8px;
  background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.28);
  border-radius:30px;padding:6px 18px;margin-bottom:18px;
}
.page-hero-badge span{font-size:.68rem;color:var(--gold);letter-spacing:2.5px;text-transform:uppercase;font-weight:600}
.page-hero-h{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(2.4rem,5.5vw,4rem);font-weight:700;
  color:var(--white);line-height:1;
}
.page-hero-h em{font-style:italic;color:var(--gold)}
.page-hero-p{
  font-size:.95rem;color:rgba(255,255,255,.48);
  line-height:1.8;font-weight:300;max-width:530px;
}
.hero-trust{display:flex;flex-wrap:wrap;gap:20px}
.trust-item{
  display:flex;align-items:center;gap:8px;
  font-size:.75rem;color:rgba(255,255,255,.45);letter-spacing:.5px;
}
.trust-item i{color:var(--gold);font-size:.7rem}

/* ═══════════════════════════════
   OFFER CARDS
═══════════════════════════════ */
.offer-card{
  background:var(--white);border:1px solid var(--border);
  border-radius:var(--r);padding:30px 24px;text-align:center;
  height:100%;transition:.35s;
}
.offer-card:hover{
  border-color:var(--gold);box-shadow:var(--shadow-md);transform:translateY(-6px);
}
.offer-ic{
  width:58px;height:58px;border-radius:50%;
  background:var(--gold-pale);border:2px solid rgba(201,168,76,.2);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 18px;font-size:1.2rem;color:var(--gold);transition:.3s;
}
.offer-card:hover .offer-ic{background:var(--gold);color:var(--navy);border-color:var(--gold)}
.offer-card h5{
  font-family:'Cormorant Garamond',serif;font-size:1.15rem;
  font-weight:700;color:var(--navy);margin-bottom:10px;
}
.offer-card p{font-size:.84rem;color:var(--muted);line-height:1.75}

/* ═══════════════════════════════════════════════
   CATEGORY TABS + SUBSCRIPTION PLANS (NEW)
═══════════════════════════════════════════════ */

/* ── Billing Toggle */
.billing-toggle-wrap{
  display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:40px;
}
.billing-lbl{font-size:.82rem;font-weight:600;color:var(--muted);letter-spacing:.5px}
.billing-lbl.active{color:var(--navy)}
.billing-switch{
  position:relative;width:52px;height:28px;flex-shrink:0;cursor:pointer;
}
.billing-switch input{opacity:0;width:0;height:0}
.billing-track{
  position:absolute;inset:0;background:var(--border);
  border-radius:28px;transition:.3s;
}
.billing-track::before{
  content:'';position:absolute;width:22px;height:22px;
  left:3px;bottom:3px;background:var(--white);border-radius:50%;
  transition:.3s;box-shadow:0 2px 6px rgba(0,0,0,.15);
}
.billing-switch input:checked+.billing-track{background:var(--navy)}
.billing-switch input:checked+.billing-track::before{transform:translateX(24px)}
.save-badge{
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(13,107,99,.1);border:1px solid rgba(13,107,99,.2);
  border-radius:20px;padding:3px 10px;
  font-size:.65rem;font-weight:700;color:var(--teal);
}

/* ── Category Filter Tabs */
.cat-tabs-outer{
  display:flex;justify-content:center;margin-bottom:36px;
}
.cat-tabs{
  display:inline-flex;align-items:center;gap:6px;
  background:var(--white);border:1px solid var(--border);
  border-radius:50px;padding:5px;
  box-shadow:var(--shadow-sm);
  flex-wrap:wrap;
  justify-content:center;
}
.cat-tab{
  display:flex;align-items:center;gap:7px;
  padding:9px 22px;border-radius:50px;border:none;background:transparent;
  font-family:'DM Sans',sans-serif;font-size:.78rem;font-weight:600;
  letter-spacing:.8px;color:var(--muted);cursor:pointer;transition:all .3s;
  white-space:nowrap;
}
.cat-tab i{font-size:.8rem}
.cat-tab:hover{color:var(--navy)}
.cat-tab.active{
  background:var(--navy);color:var(--white);
  box-shadow:0 4px 16px rgba(15,31,92,.2);
}
.cat-tab.active i{color:var(--gold)}

/* ── Plans Grid Container */
.plans-category{display:none}
.plans-category.active{display:block;animation:plansIn .4s ease}
@keyframes plansIn{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}

/* ── Session info row */
.session-info-row{
  display:flex;align-items:center;justify-content:center;gap:24px;
  flex-wrap:wrap;margin-bottom:32px;
}
.si-item{
  display:flex;align-items:center;gap:8px;
  font-size:.78rem;color:var(--muted);
}
.si-item i{color:var(--gold);font-size:.72rem}
.si-sep{width:1px;height:18px;background:var(--border)}

/* ── Plan Card */
.plan-card{
  background:var(--white);border:1.5px solid var(--border);
  border-radius:20px;padding:0;height:100%;
  position:relative;overflow:hidden;
  transition:all .4s cubic-bezier(.16,1,.3,1);
  cursor:pointer;
}
.plan-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:var(--border);transition:background .3s;
}
.plan-card:hover{
  transform:translateY(-8px);
  box-shadow:var(--shadow-lg);
  border-color:rgba(201,168,76,.4);
}
.plan-card:hover::before{background:linear-gradient(to right,var(--gold),var(--gold2))}
.plan-card.featured{
  background:linear-gradient(160deg,var(--navy) 0%,var(--navy2) 100%);
  border-color:var(--gold);
  box-shadow:0 16px 60px rgba(15,31,92,.25);
}
.plan-card.featured::before{background:linear-gradient(to right,var(--gold),var(--gold2))}
.plan-card.featured:hover{transform:translateY(-10px)}
.plan-card.selected{
  border-color:var(--gold);
  box-shadow:0 0 0 3px rgba(201,168,76,.25),var(--shadow-md);
}
.plan-card.selected::before{background:linear-gradient(to right,var(--gold),var(--gold2))}

/* ── Plan Header */
.plan-header{padding:28px 26px 0}
.plan-ribbon{
  position:absolute;top:-1px;left:50%;transform:translateX(-50%);
  background:var(--gold);color:var(--navy);
  font-size:.6rem;font-weight:800;letter-spacing:2.5px;text-transform:uppercase;
  padding:5px 18px;border-radius:0 0 10px 10px;
  box-shadow:0 4px 12px rgba(201,168,76,.35);
}
.plan-days-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.25);
  border-radius:20px;padding:4px 12px;margin-bottom:16px;
}
.plan-card.featured .plan-days-badge{
  background:rgba(201,168,76,.15);border-color:rgba(201,168,76,.35);
}
.plan-days-badge span{font-size:.65rem;font-weight:700;color:var(--gold);letter-spacing:1.5px;text-transform:uppercase}
.plan-name{
  font-family:'Cormorant Garamond',serif;
  font-size:1.3rem;font-weight:700;color:var(--navy);margin-bottom:6px;line-height:1.1;
}
.plan-card.featured .plan-name{color:var(--white)}
.plan-subtitle{
  font-size:.78rem;color:var(--muted);line-height:1.5;margin-bottom:20px;
}
.plan-card.featured .plan-subtitle{color:rgba(255,255,255,.5)}

/* ── Price Block */
.plan-price-block{
  padding:20px 26px;
  border-top:1px solid var(--border);border-bottom:1px solid var(--border);
  background:var(--cream);margin:0;
}
.plan-card.featured .plan-price-block{
  background:rgba(255,255,255,.06);
  border-color:rgba(255,255,255,.1);
}
.plan-price-amount{
  display:flex;align-items:flex-start;gap:4px;
  font-family:'Cormorant Garamond',serif;line-height:1;
}
.plan-currency{
  font-size:1.3rem;font-weight:700;color:var(--navy);
  margin-top:8px;
}
.plan-card.featured .plan-currency{color:var(--gold)}
.plan-amount{font-size:3rem;font-weight:700;color:var(--navy)}
.plan-card.featured .plan-amount{color:var(--white)}
.plan-period{
  display:flex;flex-direction:column;justify-content:flex-end;
  padding-bottom:6px;
}
.plan-period-main{font-size:.78rem;color:var(--muted);font-family:'DM Sans',sans-serif;font-weight:400}
.plan-period-interval{font-size:.68rem;color:var(--muted);font-family:'DM Sans',sans-serif}
.plan-card.featured .plan-period-main,
.plan-card.featured .plan-period-interval{color:rgba(255,255,255,.45)}
.plan-original-price{
  font-size:.75rem;color:var(--muted);text-decoration:line-through;margin-left:4px;margin-top:6px;
}
.plan-card.featured .plan-original-price{color:rgba(255,255,255,.3)}
.plan-sessions-info{
  margin-top:10px;font-size:.75rem;color:var(--muted);
  display:flex;align-items:center;gap:6px;
}
.plan-card.featured .plan-sessions-info{color:rgba(255,255,255,.45)}
.plan-sessions-info i{color:var(--teal);font-size:.65rem}
.plan-card.featured .plan-sessions-info i{color:var(--gold)}

/* ── Features */
.plan-features{padding:20px 26px}
.plan-feat{
  display:flex;align-items:flex-start;gap:10px;
  margin-bottom:11px;font-size:.82rem;
  color:var(--txt);line-height:1.5;
}
.plan-feat:last-child{margin-bottom:0}
.plan-feat i{
  font-size:.72rem;color:var(--teal);
  margin-top:3px;flex-shrink:0;
}
.plan-card.featured .plan-feat{color:rgba(255,255,255,.78)}
.plan-card.featured .plan-feat i{color:var(--gold)}
.plan-feat.disabled{opacity:.38}
.plan-feat.disabled i{color:var(--muted) !important}

/* ── CTA */
.plan-cta{padding:0 26px 26px}
.btn-plan{
  display:flex;align-items:center;justify-content:center;gap:10px;
  width:100%;padding:14px;border-radius:10px;
  font-family:'DM Sans',sans-serif;font-size:.78rem;font-weight:700;
  letter-spacing:1.8px;text-transform:uppercase;
  cursor:pointer;transition:all .3s;border:none;
}
.btn-plan-outline{
  background:transparent;color:var(--navy);
  border:2px solid var(--navy);
}
.btn-plan-outline:hover{background:var(--navy);color:var(--white);transform:translateY(-2px)}
.btn-plan-gold{
  background:var(--gold);color:var(--navy);
  box-shadow:0 6px 20px rgba(201,168,76,.35);
}
.btn-plan-gold:hover{background:var(--gold2);transform:translateY(-2px);box-shadow:0 10px 28px rgba(201,168,76,.45)}

/* ── Scale featured plan */
.col-scale .plan-card.featured{transform:scale(1.03)}
.col-scale .plan-card.featured:hover{transform:scale(1.03) translateY(-10px)}

/* ── Category description */
.cat-description{
  background:var(--white);border:1px solid var(--border);border-radius:14px;
  padding:20px 24px;margin-bottom:28px;
  display:flex;align-items:flex-start;gap:14px;
}
.cat-desc-ic{
  width:42px;height:42px;border-radius:11px;
  background:var(--gold-pale);display:flex;align-items:center;justify-content:center;
  font-size:1rem;color:var(--gold);flex-shrink:0;
}
.cat-desc-t{font-size:.88rem;font-weight:600;color:var(--navy);margin-bottom:4px}
.cat-desc-p{font-size:.78rem;color:var(--muted);margin:0;line-height:1.6}

/* ── Plan comparison note */
.plan-note{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--cream);border:1px solid var(--border);
  border-radius:10px;padding:12px 20px;margin-top:28px;
}
.plan-note p{font-size:.8rem;color:var(--muted);margin:0}
.plan-note i{color:var(--gold);flex-shrink:0}

/* ── Selected plan indicator */
.selected-plan-bar{
  display:none;
  background:linear-gradient(135deg,var(--navy),var(--navy2));
  border-radius:12px;padding:16px 22px;margin-top:28px;
  align-items:center;justify-content:space-between;
  gap:12px;flex-wrap:wrap;
}
.selected-plan-bar.show{display:flex;animation:slideUp .35s ease}
@keyframes slideUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
.spb-info{font-size:.85rem;font-weight:600;color:var(--white)}
.spb-info span{color:var(--gold)}
.spb-actions{display:flex;gap:8px}

/* ═══════════════════════════════
   BOOK FORM
═══════════════════════════════ */
.book-form-wrap{
  background:var(--white);border:1px solid var(--border);
  border-radius:20px;padding:48px 42px;box-shadow:var(--shadow-md);
}
.book-form-intro{font-size:.8rem;color:var(--muted);margin-bottom:28px;line-height:1.6}
.gift-aid-note{
  background:linear-gradient(135deg,rgba(201,168,76,.08),rgba(201,168,76,.04));
  border:1px solid rgba(201,168,76,.25);border-radius:10px;
  padding:14px 18px;display:flex;align-items:flex-start;gap:12px;margin-top:8px;
}
.gift-aid-note i{color:var(--gold);margin-top:2px;font-size:.85rem}
.gift-aid-note p{font-size:.78rem;color:var(--txt);margin:0;line-height:1.6}
.success-msg{display:none;text-align:center;padding:40px 20px}
.success-msg i.fa-check-circle{font-size:3rem;color:var(--teal);margin-bottom:14px;display:block}
.success-msg h5{
  font-family:'Cormorant Garamond',serif;font-size:1.6rem;
  color:var(--navy);margin-bottom:10px;
}
.success-msg p{font-size:.88rem;color:var(--muted)}

/* ── Selected plan summary in form */
.selected-plan-summary{
  background:linear-gradient(135deg,var(--navy),var(--navy2));
  border-radius:12px;padding:18px 22px;margin-bottom:24px;
  display:none;
}
.selected-plan-summary.show{display:block;animation:slideUp .35s ease}
.sps-label{font-size:.65rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:8px}
.sps-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
.sps-plan-name{font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:700;color:var(--white)}
.sps-plan-price{font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:var(--gold)}
.sps-details{margin-top:8px;display:flex;gap:14px;flex-wrap:wrap}
.sps-detail{font-size:.72rem;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:5px}
.sps-detail i{color:rgba(201,168,76,.6);font-size:.62rem}
.sps-change{
  font-size:.68rem;color:var(--gold);cursor:pointer;
  text-decoration:underline;margin-top:10px;display:inline-block;
}
.sps-change:hover{color:var(--gold2)}

/* ═══════════════════════════════
   PROCESS STEPS
═══════════════════════════════ */
.step-card{text-align:center;padding:32px 20px;position:relative}
.step-num{
  font-family:'Cormorant Garamond',serif;font-size:4rem;
  font-weight:700;color:rgba(15,31,92,.06);line-height:1;margin-bottom:-8px;
}
.step-ic{
  width:60px;height:60px;border-radius:50%;
  background:var(--gold-pale);border:2px solid rgba(201,168,76,.25);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 16px;font-size:1.2rem;color:var(--gold);transition:.3s;
}
.step-card:hover .step-ic{background:var(--gold);color:var(--navy);border-color:var(--gold)}
.step-card h5{
  font-family:'Cormorant Garamond',serif;font-size:1.1rem;
  font-weight:700;color:var(--navy);margin-bottom:8px;
}
.step-card p{font-size:.82rem;color:var(--muted);line-height:1.7}
.step-connector{
  position:absolute;top:84px;right:-28px;
  width:56px;height:2px;
  background:linear-gradient(to right,var(--gold),rgba(201,168,76,.2));
  z-index:1;
}

/* ═══════════════════════════════
   CTA BLOCK
═══════════════════════════════ */
.cta-block{
  background:var(--gold);padding:70px 0;position:relative;overflow:hidden;
}
.cta-block::before{
  content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.06'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
}
.cta-block .inner{position:relative}

/* ═══════════════════════════════
   FOOTER
═══════════════════════════════ */
.site-footer{background:var(--dark);padding:80px 0 0}
.footer-brand-n{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;color:var(--white);letter-spacing:2.5px}
.footer-brand-s{font-size:.55rem;letter-spacing:2.5px;color:var(--gold);text-transform:uppercase}
.footer-col-title{font-size:.65rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:22px}
.footer-link{display:flex;align-items:center;gap:9px;color:rgba(255,255,255,.38);font-size:.8rem;margin-bottom:11px;cursor:pointer;transition:.3s}
.footer-link i{font-size:.52rem;color:rgba(201,168,76,.45)}
.footer-link:hover{color:var(--gold);padding-left:4px}
.footer-soc{display:flex;gap:8px;margin-top:18px}
.footer-soc-btn{width:36px;height:36px;border:1px solid rgba(255,255,255,.1);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.38);font-size:.78rem;cursor:pointer;transition:.3s}
.footer-soc-btn:hover{border-color:var(--gold);color:var(--gold);transform:translateY(-3px)}
.footer-bottom{border-top:1px solid rgba(255,255,255,.055);padding:26px 0;margin-top:60px}
.footer-bot-txt{font-size:.75rem;color:rgba(255,255,255,.22)}

/* ── Loader */
#loader{position:fixed;inset:0;background:var(--dark);z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;transition:opacity .5s,visibility .5s}
#loader.done{opacity:0;visibility:hidden}
.loader-t{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:var(--white);letter-spacing:5px;margin-bottom:16px}
.loader-track{width:140px;height:2px;background:rgba(255,255,255,.1);border-radius:2px;overflow:hidden}
.loader-fill{height:100%;width:0;background:var(--gold);border-radius:2px;animation:lf 1.2s ease forwards}
@keyframes lf{to{width:100%}}

#btt{position:fixed;bottom:28px;right:28px;width:46px;height:46px;background:var(--navy);border:1.5px solid var(--gold);border-radius:11px;display:flex;align-items:center;justify-content:center;color:var(--gold);cursor:pointer;z-index:800;opacity:0;pointer-events:none;transition:.4s;box-shadow:0 6px 20px rgba(15,31,92,.25)}
#btt.show{opacity:1;pointer-events:all}
#btt:hover{background:var(--gold);color:var(--navy);transform:translateY(-3px)}

@media(max-width:991px){
  section{padding:70px 0}
  .book-form-wrap{padding:32px 20px}
  .col-scale .plan-card.featured{transform:none}
}
@media(max-width:576px){
  .cat-tabs{gap:4px}
  .cat-tab{padding:8px 14px;font-size:.72rem}
}
</style>



<!-- ═══════════════ HERO ═══════════════ -->
<div class="book-hero">
  <div class="container">
    <div class="page-hero-badge"><span>Book a Lesson</span></div>
    <h1 class="page-hero-h mb-3">
      Start Your Child's<br><em>Learning Journey</em> Today
    </h1>
    <p class="page-hero-p mb-4">
      Expert 1-to-1 online Quran lessons — flexible, structured, and taught by qualified tutors. Begin with a free trial lesson, no commitment required.
    </p>
    <div class="hero-trust mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,.08)">
      <span class="trust-item"><i class="fas fa-shield-alt"></i>DBS Checked Tutors</span>
      <span class="trust-item"><i class="fas fa-video"></i>Lessons via Zoom / Teams</span>
      <span class="trust-item"><i class="fas fa-gift"></i>Free Trial Lesson</span>
      <span class="trust-item"><i class="fas fa-clock"></i>Flexible Scheduling</span>
      <span class="trust-item"><i class="fas fa-certificate"></i>Qualified Tutors</span>
    </div>
  </div>
</div>

<!-- ═══════════════ WHAT WE OFFER ═══════════════ -->
<section class="section-cream">
  <div class="container">
    <div class="text-center mb-5" data-r="up">
      <div class="eyebrow justify-content-center">
        <div class="eyebrow-line"></div>
        <span class="eyebrow-txt">What We Offer</span>
        <div class="eyebrow-line"></div>
      </div>
      <h2 class="sec-h">Structured, Expert <em>Quran Learning</em></h2>
      <div class="divider-gold center"></div>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-r="up">
        <div class="offer-card">
          <div class="offer-ic"><i class="fas fa-user-graduate"></i></div>
          <h5>1-to-1 Online Lessons</h5>
          <p>Personal attention from a qualified tutor — no classes, no distractions. Just your child and their dedicated teacher.</p>
        </div>
      </div>
      <div class="col-md-4" data-r="up" style="transition-delay:.1s">
        <div class="offer-card">
          <div class="offer-ic"><i class="fas fa-calendar-alt"></i></div>
          <h5>Flexible Timings</h5>
          <p>Morning, afternoon or evening slots — 7 days a week. Choose what works for your family's schedule.</p>
        </div>
      </div>
      <div class="col-md-4" data-r="up" style="transition-delay:.2s">
        <div class="offer-card">
          <div class="offer-ic"><i class="fas fa-layer-group"></i></div>
          <h5>Structured Learning</h5>
          <p>From Qaida for beginners to full Quran recitation and Tajweed — a clear progression for every student.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════
     PRICING WITH CATEGORY TABS (UPDATED)
═══════════════════════════════════════════ -->
<section id="pricing-section">
  <div class="container">

    <!-- Section Header -->
    <div class="text-center mb-2" data-r="up">
      <div class="eyebrow justify-content-center">
        <div class="eyebrow-line"></div>
        <span class="eyebrow-txt">Subscription Plans</span>
        <div class="eyebrow-line"></div>
      </div>
      <h2 class="sec-h">Choose Your <em>Learning Plan</em></h2>
      <div class="divider-gold center"></div>
      <p class="sec-p mx-auto" style="max-width:520px">
        Select a plan category that fits your child's learning needs. All plans include a free trial lesson with no commitment required.
      </p>
    </div>

    <!-- Billing Toggle -->
    <div class="billing-toggle-wrap mt-4" data-r="up">
      <span class="billing-lbl active" id="lbl-monthly">Pay Monthly</span>
      <label class="billing-switch">
        <input type="checkbox" id="billing-toggle" onchange="toggleBilling(this)">
        <span class="billing-track"></span>
      </label>
      <span class="billing-lbl" id="lbl-annual">Pay Annually</span>
      <span class="save-badge"><i class="fas fa-tag"></i>Save up to 20%</span>
    </div>

    <!-- Category Tabs -->
    <div class="cat-tabs-outer" data-r="fade">
      <div class="cat-tabs" id="cat-tabs">
        <!-- Tabs rendered by JS — mirrors admin Category model -->
        <button class="cat-tab active" onclick="switchCat('30min',this)" data-cat="30min">
          <i class="fas fa-clock"></i>30 Minutes Plans
        </button>
        <button class="cat-tab" onclick="switchCat('45min',this)" data-cat="45min">
          <i class="fas fa-hourglass-half"></i>45 Minutes Plans
        </button>
        <button class="cat-tab" onclick="switchCat('60min',this)" data-cat="60min">
          <i class="fas fa-hourglass-end"></i>60 Minutes Plans
        </button>
        <button class="cat-tab" onclick="switchCat('hifz',this)" data-cat="hifz">
          <i class="fas fa-quran"></i>Hifz Programme
        </button>
        <button class="cat-tab" onclick="switchCat('tajweed',this)" data-cat="tajweed">
          <i class="fas fa-star-and-crescent"></i>Tajweed Intensive
        </button>
      </div>
    </div>

    <!-- ── CATEGORY: 30 MINUTES ── -->
    <div class="plans-category active" id="cat-30min">
      <div class="cat-description" data-r="up">
        <div class="cat-desc-ic"><i class="fas fa-clock"></i></div>
        <div>
          <div class="cat-desc-t">30-Minute Lesson Plans</div>
          <p class="cat-desc-p">Ideal for beginners, younger students (ages 4–10), and those who learn better in shorter, focused sessions. 2–3 sessions per week is recommended for consistent progress.</p>
        </div>
      </div>
      <div class="session-info-row" data-r="up">
        <div class="si-item"><i class="fas fa-clock"></i>30 min / session</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-video"></i>Zoom or Teams</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-user-shield"></i>DBS-checked tutors</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-gift"></i>Free trial included</div>
      </div>
      <div class="row g-4 align-items-stretch col-scale">
        <!-- Plan: 2 days/week -->
        <div class="col-lg-4 col-md-6" data-r="up">
          <div class="plan-card" onclick="selectPlan(this,'2 days/week — 30 Min','£6.00','monthly','30 min','2 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>2 days / week</span></div>
              <div class="plan-name">2 days/week</div>
              <div class="plan-subtitle">Ideal for beginners and younger students. 2–3 sessions per week recommended.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">6<span style="font-size:1.5rem">.00</span></span>
                <span class="plan-amount plan-annual-price" style="display:none">5<span style="font-size:1.5rem">.00</span></span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info">
                <i class="fas fa-info-circle"></i>
                <span class="plan-monthly-text">8 sessions/month</span>
                <span class="plan-annual-text" style="display:none">96 sessions/year</span>
              </div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Progress tracking</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>8 Classes per month</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Parent feedback session</div>
            </div>
            <div class="plan-cta">
              <button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button>
            </div>
          </div>
        </div>
        <!-- Plan: 3 days/week — FEATURED -->
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.1s">
          <div class="plan-card featured" onclick="selectPlan(this,'3 days/week — 30 Min','£9.00','monthly','30 min','3 days/week')">
            <div class="plan-ribbon">✦ Most Popular</div>
            <div class="plan-header" style="padding-top:38px">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>3 days / week</span></div>
              <div class="plan-name">3 days/week</div>
              <div class="plan-subtitle">Best for steady progress. Most families choose this for consistent Quran learning.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">9<span style="font-size:1.5rem">.00</span></span>
                <span class="plan-amount plan-annual-price" style="display:none">7<span style="font-size:1.5rem">.50</span></span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info">
                <i class="fas fa-info-circle"></i>
                <span class="plan-monthly-text">12 sessions/month</span>
                <span class="plan-annual-text" style="display:none">144 sessions/year</span>
              </div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Progress tracking</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>12 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Parent feedback session</div>
            </div>
            <div class="plan-cta">
              <button class="btn-plan btn-plan-gold"><i class="fas fa-graduation-cap"></i>Choose Plan</button>
            </div>
          </div>
        </div>
        <!-- Plan: 5 days/week -->
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.2s">
          <div class="plan-card" onclick="selectPlan(this,'5 days/week — 30 Min','£14.00','monthly','30 min','5 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>5 days / week</span></div>
              <div class="plan-name">5 days/week</div>
              <div class="plan-subtitle">For accelerated learners who want to progress rapidly through the Quran.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">14<span style="font-size:1.5rem">.00</span></span>
                <span class="plan-amount plan-annual-price" style="display:none">11<span style="font-size:1.5rem">.50</span></span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info">
                <i class="fas fa-info-circle"></i>
                <span class="plan-monthly-text">20 sessions/month</span>
                <span class="plan-annual-text" style="display:none">240 sessions/year</span>
              </div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Progress tracking</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>20 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Parent feedback session</div>
            </div>
            <div class="plan-cta">
              <button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Selected plan bar -->
      <div class="selected-plan-bar" id="selected-bar-30min">
        <div class="spb-info">
          Selected: <span id="selected-name-30min">—</span> &nbsp;·&nbsp;
          <span id="selected-price-30min" style="color:var(--gold2)">—</span>
        </div>
        <div class="spb-actions">
          <button class="btn-gold" style="padding:10px 24px;font-size:.75rem" onclick="scrollToForm()">
            <i class="fas fa-arrow-down"></i>Continue to Booking
          </button>
        </div>
      </div>
    </div>

    <!-- ── CATEGORY: 45 MINUTES ── -->
    <div class="plans-category" id="cat-45min">
      <div class="cat-description" data-r="up">
        <div class="cat-desc-ic"><i class="fas fa-hourglass-half"></i></div>
        <div>
          <div class="cat-desc-t">45-Minute Lesson Plans</div>
          <p class="cat-desc-p">The most popular choice for students aged 8–14. Longer sessions allow more Quran coverage, Tajweed correction, and deeper engagement with the material.</p>
        </div>
      </div>
      <div class="session-info-row" data-r="up">
        <div class="si-item"><i class="fas fa-clock"></i>45 min / session</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-video"></i>Zoom or Teams</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-chart-line"></i>Monthly reports</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-gift"></i>Free trial included</div>
      </div>
      <div class="row g-4 align-items-stretch col-scale">
        <div class="col-lg-4 col-md-6" data-r="up">
          <div class="plan-card" onclick="selectPlan(this,'2 days/week — 45 Min','£25.00','monthly','45 min','2 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>2 days / week</span></div>
              <div class="plan-name">2 days/week</div>
              <div class="plan-subtitle">A great starting point for students moving beyond the basics into Quran reading.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">25</span>
                <span class="plan-amount plan-annual-price" style="display:none">20</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i><span class="plan-monthly-text">8 sessions/month</span><span class="plan-annual-text" style="display:none">96 sessions/year</span></div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Progress tracking</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>8 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Parent feedback session</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.1s">
          <div class="plan-card featured" onclick="selectPlan(this,'3 days/week — 45 Min','£35.00','monthly','45 min','3 days/week')">
            <div class="plan-ribbon">✦ Best Value</div>
            <div class="plan-header" style="padding-top:38px">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>3 days / week</span></div>
              <div class="plan-name">3 days/week</div>
              <div class="plan-subtitle">Excellent for students progressing through Quran reading into Tajweed rules.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">35</span>
                <span class="plan-amount plan-annual-price" style="display:none">28</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i><span class="plan-monthly-text">12 sessions/month</span><span class="plan-annual-text" style="display:none">144 sessions/year</span></div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Progress tracking</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>12 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Parent feedback session</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-gold"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.2s">
          <div class="plan-card" onclick="selectPlan(this,'5 days/week — 45 Min','£55.00','monthly','45 min','5 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>5 days / week</span></div>
              <div class="plan-name">5 days/week</div>
              <div class="plan-subtitle">Intensive study for determined students who want to complete the Quran efficiently.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">55</span>
                <span class="plan-amount plan-annual-price" style="display:none">44</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i><span class="plan-monthly-text">20 sessions/month</span><span class="plan-annual-text" style="display:none">240 sessions/year</span></div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Priority tutor matching</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Progress tracking</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>20 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Parent feedback session</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
      </div>
      <div class="selected-plan-bar" id="selected-bar-45min">
        <div class="spb-info">Selected: <span id="selected-name-45min">—</span> &nbsp;·&nbsp; <span id="selected-price-45min" style="color:var(--gold2)">—</span></div>
        <div class="spb-actions"><button class="btn-gold" style="padding:10px 24px;font-size:.75rem" onclick="scrollToForm()"><i class="fas fa-arrow-down"></i>Continue to Booking</button></div>
      </div>
    </div>

    <!-- ── CATEGORY: 60 MINUTES ── -->
    <div class="plans-category" id="cat-60min">
      <div class="cat-description" data-r="up">
        <div class="cat-desc-ic"><i class="fas fa-hourglass-end"></i></div>
        <div>
          <div class="cat-desc-t">60-Minute Lesson Plans</div>
          <p class="cat-desc-p">For advanced students and older learners (14+). Longer sessions allow in-depth coverage of Tajweed rules, Hifz review, and more. Also ideal for adult learners wanting intensive study.</p>
        </div>
      </div>
      <div class="session-info-row" data-r="up">
        <div class="si-item"><i class="fas fa-clock"></i>60 min / session</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-star"></i>Advanced learners</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-user-tie"></i>Senior tutors</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-file-alt"></i>Custom learning plan</div>
      </div>
      <div class="row g-4 align-items-stretch col-scale">
        <div class="col-lg-4 col-md-6" data-r="up">
          <div class="plan-card" onclick="selectPlan(this,'2 days/week — 60 Min','£40.00','monthly','60 min','2 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>2 days / week</span></div>
              <div class="plan-name">2 days/week</div>
              <div class="plan-subtitle">For advanced students or those with specific Tajweed / Hifz goals.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">40</span>
                <span class="plan-amount plan-annual-price" style="display:none">33</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i><span class="plan-monthly-text">8 sessions/month</span><span class="plan-annual-text" style="display:none">96 sessions/year</span></div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Senior qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Advanced Tajweed / Hifz</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>8 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Custom learning plan</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Priority tutor matching</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.1s">
          <div class="plan-card featured" onclick="selectPlan(this,'3 days/week — 60 Min','£55.00','monthly','60 min','3 days/week')">
            <div class="plan-ribbon">✦ Recommended</div>
            <div class="plan-header" style="padding-top:38px">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>3 days / week</span></div>
              <div class="plan-name">3 days/week</div>
              <div class="plan-subtitle">The gold standard for serious students seeking to master Tajweed or advance their Hifz.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">55</span>
                <span class="plan-amount plan-annual-price" style="display:none">44</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i><span class="plan-monthly-text">12 sessions/month</span><span class="plan-annual-text" style="display:none">144 sessions/year</span></div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Senior qualified tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Advanced Tajweed / Hifz</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>12 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Custom learning plan</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Priority tutor matching</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-gold"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.2s">
          <div class="plan-card" onclick="selectPlan(this,'5 days/week — 60 Min','£85.00','monthly','60 min','5 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-alt me-1"></i>5 days / week</span></div>
              <div class="plan-name">5 days/week</div>
              <div class="plan-subtitle">Maximum immersion — for those fully committed to completing Hifz or mastering Tajweed.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">85</span>
                <span class="plan-amount plan-annual-price" style="display:none">68</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">billed monthly</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i><span class="plan-monthly-text">20 sessions/month</span><span class="plan-annual-text" style="display:none">240 sessions/year</span></div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>1-to-1 personal lesson</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Senior tutor — priority match</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Advanced Tajweed / Hifz</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>20 Classes per month</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Custom learning plan</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Weekly parent report</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
      </div>
      <div class="selected-plan-bar" id="selected-bar-60min">
        <div class="spb-info">Selected: <span id="selected-name-60min">—</span> &nbsp;·&nbsp; <span id="selected-price-60min" style="color:var(--gold2)">—</span></div>
        <div class="spb-actions"><button class="btn-gold" style="padding:10px 24px;font-size:.75rem" onclick="scrollToForm()"><i class="fas fa-arrow-down"></i>Continue to Booking</button></div>
      </div>
    </div>

    <!-- ── CATEGORY: HIFZ ── -->
    <div class="plans-category" id="cat-hifz">
      <div class="cat-description" data-r="up">
        <div class="cat-desc-ic"><i class="fas fa-quran"></i></div>
        <div>
          <div class="cat-desc-t">Hifz Memorisation Programme</div>
          <p class="cat-desc-p">A specialised programme for students committed to memorising the Holy Quran. Our experienced Hafiz tutors follow a structured, proven method with daily revision and tracking.</p>
        </div>
      </div>
      <div class="session-info-row" data-r="up">
        <div class="si-item"><i class="fas fa-quran"></i>Hifz specialists</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-calendar-check"></i>Daily revision included</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-chart-line"></i>Structured Hifz plan</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-medal"></i>Certified Hafiz tutors</div>
      </div>
      <div class="row g-4 align-items-stretch col-scale">
        <div class="col-lg-4 col-md-6" data-r="up">
          <div class="plan-card" onclick="selectPlan(this,'Hifz Starter','£45.00','monthly','45 min','3 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-seedling me-1"></i>Starter</span></div>
              <div class="plan-name">Hifz Starter</div>
              <div class="plan-subtitle">For students just beginning their memorisation journey. Solid foundations with a Hafiz tutor.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">45</span>
                <span class="plan-amount plan-annual-price" style="display:none">37</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">3 days/week · 45 min</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i>12 sessions/month</div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Certified Hafiz tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Structured Hifz plan</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Daily revision guidance</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Weekly Sabaq review</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Parent progress calls</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.1s">
          <div class="plan-card featured" onclick="selectPlan(this,'Hifz Advanced','£75.00','monthly','60 min','5 days/week')">
            <div class="plan-ribbon">✦ Most Effective</div>
            <div class="plan-header" style="padding-top:38px">
              <div class="plan-days-badge"><span><i class="fas fa-fire me-1"></i>Advanced</span></div>
              <div class="plan-name">Hifz Advanced</div>
              <div class="plan-subtitle">The complete Hifz solution. Intensive daily sessions designed to complete memorisation efficiently.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">75</span>
                <span class="plan-amount plan-annual-price" style="display:none">60</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">5 days/week · 60 min</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i>20 sessions/month</div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Senior Hafiz tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Intensive Hifz plan</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Daily Sabaq + Manzil</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Weekly progress reports</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Weekly Sabaq review</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Parent progress calls</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-gold"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.2s">
          <div class="plan-card" onclick="selectPlan(this,'Hifz Weekend','£35.00','monthly','60 min','Weekend only')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-calendar-week me-1"></i>Weekend</span></div>
              <div class="plan-name">Hifz Weekend</div>
              <div class="plan-subtitle">For busy students who can only commit to weekends. Slower pace, long-term commitment.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">35</span>
                <span class="plan-amount plan-annual-price" style="display:none">28</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">Weekends · 60 min</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i>8 sessions/month</div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Certified Hafiz tutor</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Weekend scheduling</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Structured revision plan</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Daily Sabaq review</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Parent progress calls</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
      </div>
      <div class="selected-plan-bar" id="selected-bar-hifz">
        <div class="spb-info">Selected: <span id="selected-name-hifz">—</span> &nbsp;·&nbsp; <span id="selected-price-hifz" style="color:var(--gold2)">—</span></div>
        <div class="spb-actions"><button class="btn-gold" style="padding:10px 24px;font-size:.75rem" onclick="scrollToForm()"><i class="fas fa-arrow-down"></i>Continue to Booking</button></div>
      </div>
    </div>

    <!-- ── CATEGORY: TAJWEED ── -->
    <div class="plans-category" id="cat-tajweed">
      <div class="cat-description" data-r="up">
        <div class="cat-desc-ic"><i class="fas fa-star-and-crescent"></i></div>
        <div>
          <div class="cat-desc-t">Tajweed Intensive Programme</div>
          <p class="cat-desc-p">For students who can already read the Quran and want to perfect their recitation according to the rules of Tajweed. Delivered by experienced, certified Tajweed teachers.</p>
        </div>
      </div>
      <div class="session-info-row" data-r="up">
        <div class="si-item"><i class="fas fa-star-and-crescent"></i>Tajweed specialists</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-microphone"></i>Pronunciation focus</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-certificate"></i>Completion certificate</div>
        <div class="si-sep"></div>
        <div class="si-item"><i class="fas fa-book-open"></i>Rule-by-rule structure</div>
      </div>
      <div class="row g-4 align-items-stretch col-scale">
        <div class="col-lg-4 col-md-6" data-r="up">
          <div class="plan-card" onclick="selectPlan(this,'Tajweed Foundation','£30.00','monthly','45 min','2 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-layer-group me-1"></i>Foundation</span></div>
              <div class="plan-name">Tajweed Foundation</div>
              <div class="plan-subtitle">Learn the essential Tajweed rules with a structured, beginner-friendly curriculum.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">30</span>
                <span class="plan-amount plan-annual-price" style="display:none">24</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">2 days/week · 45 min</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i>8 sessions/month</div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Certified Tajweed teacher</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Makharij & Sifaat rules</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Nun sakinah & Tanwin</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Full Tajweed certificate</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Audio recording review</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.1s">
          <div class="plan-card featured" onclick="selectPlan(this,'Tajweed Intensive','£55.00','monthly','60 min','3 days/week')">
            <div class="plan-ribbon">✦ Full Programme</div>
            <div class="plan-header" style="padding-top:38px">
              <div class="plan-days-badge"><span><i class="fas fa-fire me-1"></i>Intensive</span></div>
              <div class="plan-name">Tajweed Intensive</div>
              <div class="plan-subtitle">The complete Tajweed programme from Makharij to Waqf — earn your Tajweed certificate.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">55</span>
                <span class="plan-amount plan-annual-price" style="display:none">44</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">3 days/week · 60 min</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i>12 sessions/month</div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Senior Tajweed specialist</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Complete Tajweed curriculum</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>All rules with practice</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Weekly progress reports</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Full Tajweed certificate</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Audio recording review</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-gold"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-r="up" style="transition-delay:.2s">
          <div class="plan-card" onclick="selectPlan(this,'Tajweed Express','£20.00','monthly','30 min','2 days/week')">
            <div class="plan-header">
              <div class="plan-days-badge"><span><i class="fas fa-bolt me-1"></i>Express</span></div>
              <div class="plan-name">Tajweed Express</div>
              <div class="plan-subtitle">Short, focused sessions for students who want to polish specific rules and Surahs.</div>
            </div>
            <div class="plan-price-block">
              <div class="plan-price-amount">
                <span class="plan-currency">£</span>
                <span class="plan-amount plan-monthly-price">20</span>
                <span class="plan-amount plan-annual-price" style="display:none">16</span>
                <div class="plan-period">
                  <span class="plan-period-main">/month</span>
                  <span class="plan-period-interval plan-monthly-text">2 days/week · 30 min</span>
                  <span class="plan-period-interval plan-annual-text" style="display:none">billed annually</span>
                </div>
              </div>
              <div class="plan-sessions-info"><i class="fas fa-info-circle"></i>8 sessions/month</div>
            </div>
            <div class="plan-features">
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Tajweed teacher</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Targeted rule correction</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Specific Surah focus</div>
              <div class="plan-feat"><i class="fas fa-check-circle"></i>Monthly progress report</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Full Tajweed certificate</div>
              <div class="plan-feat disabled"><i class="fas fa-times-circle"></i>Audio recording review</div>
            </div>
            <div class="plan-cta"><button class="btn-plan btn-plan-outline"><i class="fas fa-graduation-cap"></i>Choose Plan</button></div>
          </div>
        </div>
      </div>
      <div class="selected-plan-bar" id="selected-bar-tajweed">
        <div class="spb-info">Selected: <span id="selected-name-tajweed">—</span> &nbsp;·&nbsp; <span id="selected-price-tajweed" style="color:var(--gold2)">—</span></div>
        <div class="spb-actions"><button class="btn-gold" style="padding:10px 24px;font-size:.75rem" onclick="scrollToForm()"><i class="fas fa-arrow-down"></i>Continue to Booking</button></div>
      </div>
    </div>

    <!-- Disclaimer note -->
    <div class="text-center mt-4" data-r="up">
      <div class="plan-note">
        <i class="fas fa-info-circle" style="color:var(--gold);flex-shrink:0"></i>
        <p><strong style="color:var(--navy)">Lesson fee = Service only.</strong> Add an optional donation alongside your booking to support a child in need — Gift Aid eligible for UK taxpayers.</p>
      </div>
    </div>

  </div>
</section>

<!-- ═══════════════ HOW IT WORKS ═══════════════ -->
<section class="section-cream">
  <div class="container">
    <div class="text-center mb-5" data-r="up">
      <div class="eyebrow justify-content-center">
        <div class="eyebrow-line"></div><span class="eyebrow-txt">Simple Process</span><div class="eyebrow-line"></div>
      </div>
      <h2 class="sec-h">How It <em>Works</em></h2>
      <div class="divider-gold center"></div>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-lg-3 col-6 position-relative" data-r="up">
        <div class="step-card"><div class="step-num">01</div><div class="step-ic"><i class="fas fa-mouse-pointer"></i></div><h5>Choose a Plan</h5><p>Select the lesson category and plan that best suits your child's age, level and schedule.</p></div>
        <div class="step-connector d-none d-lg-block"></div>
      </div>
      <div class="col-lg-3 col-6 position-relative" data-r="up" style="transition-delay:.1s">
        <div class="step-card"><div class="step-num">02</div><div class="step-ic"><i class="fas fa-file-alt"></i></div><h5>Fill Enquiry Form</h5><p>Complete our short form with your child's details, learning level and preferred time slot.</p></div>
        <div class="step-connector d-none d-lg-block"></div>
      </div>
      <div class="col-lg-3 col-6 position-relative" data-r="up" style="transition-delay:.2s">
        <div class="step-card"><div class="step-num">03</div><div class="step-ic"><i class="fas fa-comments"></i></div><h5>Free Trial Lesson</h5><p>We'll match your child with a tutor and arrange a completely free trial session — no obligation.</p></div>
        <div class="step-connector d-none d-lg-block"></div>
      </div>
      <div class="col-lg-3 col-6" data-r="up" style="transition-delay:.3s">
        <div class="step-card"><div class="step-num">04</div><div class="step-ic"><i class="fas fa-rocket"></i></div><h5>Begin Learning</h5><p>Start your regular lessons and watch your child's Quran knowledge grow week by week.</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════ BOOKING FORM ═══════════════ -->
<section id="booking-form-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-r="up">
        <div class="book-form-wrap">
          <div id="book-form-body">
            <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Enquiry Form</span></div>
            <h2 class="sec-h mb-2">Book a Lesson <em>Now</em></h2>
            <p class="book-form-intro">
              Fill in the details below and we'll be in touch within 24 hours to arrange your free trial lesson. No commitment required.
            </p>

            <!-- Selected Plan Summary (shows when a plan is chosen) -->
            <div class="selected-plan-summary" id="form-plan-summary">
              <div class="sps-label">Your Selected Plan</div>
              <div class="sps-row">
                <div class="sps-plan-name" id="form-plan-name">—</div>
                <div class="sps-plan-price" id="form-plan-price">—</div>
              </div>
              <div class="sps-details">
                <div class="sps-detail"><i class="fas fa-clock"></i><span id="form-plan-duration">—</span></div>
                <div class="sps-detail"><i class="fas fa-calendar-alt"></i><span id="form-plan-days">—</span></div>
                <div class="sps-detail"><i class="fas fa-sync"></i><span id="form-plan-billing">—</span></div>
              </div>
              <span class="sps-change" onclick="scrollToPricing()"><i class="fas fa-edit me-1"></i>Change plan</span>
            </div>

            <!-- Hidden inputs for selected plan (for Laravel backend) -->
            <input type="hidden" id="selected_plan_name" name="selected_plan_name">
            <input type="hidden" id="selected_plan_price" name="selected_plan_price">
            <input type="hidden" id="selected_plan_duration" name="selected_plan_duration">
            <input type="hidden" id="selected_plan_days" name="selected_plan_days">
            <input type="hidden" id="selected_plan_billing" name="selected_plan_billing">

            <div class="row g-3">
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Parent / Guardian Name *</label>
                  <input type="text" class="field-input" name="parent_name" placeholder="Your full name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Student Name *</label>
                  <input type="text" class="field-input" name="student_name" placeholder="Child's name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Student Age *</label>
                  <input type="number" class="field-input" name="student_age" placeholder="e.g. 8" min="4" max="18" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Current Quran Level</label>
                  <select class="field-select" name="current_level">
                    <option value="">Select level...</option>
                    <option>Complete Beginner</option>
                    <option>Qaida / Basics</option>
                    <option>Reading Quran</option>
                    <option>Tajweed</option>
                    <option>Hifz (Memorisation)</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Preferred Time *</label>
                  <select class="field-select" name="preferred_time" required>
                    <option value="">Select preference...</option>
                    <option>Morning (8am–12pm)</option>
                    <option>Afternoon (12pm–5pm)</option>
                    <option>Evening (5pm–9pm)</option>
                    <option>Weekend only</option>
                    <option>Flexible — any time</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Your Location / Country *</label>
                  <input type="text" class="field-input" name="location" placeholder="e.g. London, UK" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Email Address *</label>
                  <input type="email" class="field-input" name="email" placeholder="you@email.com" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="field-group">
                  <label class="field-label">Phone Number</label>
                  <input type="tel" class="field-input" name="phone" placeholder="+44 7000 000000">
                </div>
              </div>
              <div class="col-12">
                <div class="field-group">
                  <label class="field-label">Additional Notes</label>
                  <textarea class="field-textarea" rows="3" name="notes" placeholder="Any specific goals, requirements, or questions about the plan..."></textarea>
                </div>
              </div>
              <div class="col-12">
                <div class="gift-aid-note">
                  <i class="fas fa-gift"></i>
                  <p>
                    Would you like to add an <strong>optional donation</strong> alongside your lesson booking? Donations are separate from lesson fees and are <strong>Gift Aid eligible</strong> if you're a UK taxpayer.
                    <a href="/donate" style="color:var(--gold);font-weight:600">Visit our Donate page →</a>
                  </p>
                </div>
              </div>
              <div class="col-12 mt-2">
                <button type="button" class="btn-gold" style="width:100%;justify-content:center;padding:16px;font-size:.85rem" onclick="submitBookForm()">
                  <i class="fas fa-graduation-cap"></i>Book a Lesson Now
                </button>
              </div>
              <div class="col-12">
                <p style="font-size:.72rem;color:var(--muted);text-align:center;margin-top:4px">
                  <i class="fas fa-shield-alt" style="color:var(--gold);margin-right:5px"></i>
                  By submitting, you agree to our <a href="/terms" style="color:var(--gold)">Terms & Conditions</a> and <a href="/privacy" style="color:var(--gold)">Privacy Policy</a>.
                </p>
              </div>
            </div>
          </div>
          <div class="success-msg" id="book-success">
            <i class="fas fa-check-circle"></i>
            <h5>Enquiry Received!</h5>
            <p>Thank you for reaching out. We'll contact you within 24 hours to confirm your free trial lesson. Jazakallah Khair.</p>
            <button class="btn-navy mt-3" onclick="window.location.href='/'"><i class="fas fa-home"></i>Return Home</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════ CTA ═══════════════ -->
<div class="cta-block">
  <div class="container"><div class="inner">
    <div class="row align-items-center g-4">
      <div class="col-lg-7" data-r="left">
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;color:var(--navy)">
          Questions About Our Plans?
        </h2>
        <p style="color:rgba(15,31,92,.65);font-size:.92rem;margin-top:10px;font-weight:300;max-width:440px">
          Not sure which plan is right for your child? Our team is happy to guide you — contact us for a free consultation.
        </p>
      </div>
      <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end" data-r="right">
        <button class="btn-navy" onclick="window.location.href='/contact'"><i class="fas fa-comments"></i>Talk to Us</button>
        <button class="btn-gold" onclick="scrollToForm()"><i class="fas fa-graduation-cap"></i>Book a Free Trial</button>
      </div>
    </div>
  </div></div>
</div>

<!-- ═══════════════ FOOTER ═══════════════ -->
<footer class="site-footer">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div style="width:42px;height:42px;background:rgba(201,168,76,.1);border:1.5px solid rgba(201,168,76,.28);border-radius:10px;display:flex;align-items:center;justify-content:center">
            <i class="fas fa-book-open" style="color:var(--gold);font-size:.9rem"></i>
          </div>
          <div>
            <div class="footer-brand-n">MERIT</div>
            <div class="footer-brand-s">Education Foundation</div>
          </div>
        </div>
        <p style="font-family:'Cormorant Garamond',serif;font-style:italic;color:rgba(255,255,255,.3);font-size:.9rem;margin-bottom:14px">"Education for All, Opportunity for Every Child"</p>
        <p style="font-size:.8rem;color:rgba(255,255,255,.32);line-height:1.75;max-width:290px">A UK-based education charity combining expert online Quran teaching with a global mission to fund education for disadvantaged children.</p>
        <div class="footer-soc">
          <div class="footer-soc-btn"><i class="fab fa-facebook-f"></i></div>
          <div class="footer-soc-btn"><i class="fab fa-instagram"></i></div>
          <div class="footer-soc-btn"><i class="fab fa-twitter"></i></div>
          <div class="footer-soc-btn"><i class="fab fa-linkedin-in"></i></div>
          <div class="footer-soc-btn"><i class="fab fa-youtube"></i></div>
        </div>
      </div>
      <div class="col-lg-2 col-6">
        <div class="footer-col-title">Navigate</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Home</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>About Us</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Book a Lesson</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Donate</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Safeguarding</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Contact</div>
      </div>
      <div class="col-lg-2 col-6">
        <div class="footer-col-title">Legal</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Privacy Policy</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Terms & Conditions</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Refund Policy</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Cookie Policy</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Safeguarding Policy</div>
      </div>
      <div class="col-lg-4">
        <div class="footer-col-title">Contact</div>
        <p style="font-size:.8rem;color:rgba(255,255,255,.35);margin-bottom:8px;display:flex;gap:10px">
          <i class="fas fa-envelope" style="color:var(--gold);margin-top:3px;font-size:.75rem"></i>info@meriteducation.org
        </p>
        <p style="font-size:.8rem;color:rgba(255,255,255,.35);margin-bottom:18px;display:flex;gap:10px">
          <i class="fas fa-phone" style="color:var(--gold);margin-top:3px;font-size:.75rem"></i>+44 20 0000 0000
        </p>
        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:12px;padding:22px 18px">
          <div style="font-size:.8rem;font-weight:600;color:var(--white);margin-bottom:4px">Newsletter</div>
          <div style="font-size:.72rem;color:rgba(255,255,255,.35);margin-bottom:12px;line-height:1.5">Monthly impact reports delivered to your inbox.</div>
          <div style="display:flex;gap:7px">
            <input type="email" placeholder="Your email address" style="flex:1;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:7px;padding:10px 13px;color:var(--white);font-family:'DM Sans',sans-serif;font-size:.8rem;outline:none">
            <button style="background:var(--gold);color:var(--navy);border:none;border-radius:7px;padding:10px 16px;font-size:.75rem;font-weight:700;cursor:pointer">Subscribe</button>
          </div>
        </div>
      </div>
    </div>
    <div style="background:rgba(201,168,76,.07);border:1px solid rgba(201,168,76,.14);border-radius:10px;padding:14px 20px;margin-top:40px;display:flex;align-items:flex-start;gap:12px">
      <i class="fas fa-info-circle" style="color:var(--gold);margin-top:2px;font-size:.9rem;flex-shrink:0"></i>
      <p style="font-size:.74rem;color:rgba(255,255,255,.38);margin:0;line-height:1.65">
        <strong style="color:rgba(255,255,255,.55)">Important:</strong> Lesson fees are a service payment and are not charitable donations. Donations are voluntary, separate, and Gift Aid eligible for UK taxpayers.
      </p>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6"><p class="footer-bot-txt">© 2025 Merit Education Foundation. Registered Charity. All Rights Reserved.</p></div>
        <div class="col-md-6 text-md-end">
          <div class="footer-bot-links justify-content-md-end d-flex gap-3 flex-wrap">
            <span style="font-size:.72rem;color:rgba(255,255,255,.22);cursor:pointer">Privacy Policy</span>
            <span style="font-size:.72rem;color:rgba(255,255,255,.22);cursor:pointer">Terms</span>
            <span style="font-size:.72rem;color:rgba(255,255,255,.22);cursor:pointer">Refund Policy</span>
            <span style="font-size:.72rem;color:rgba(255,255,255,.22);cursor:pointer">Cookies</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <i class="fas fa-chevron-up"></i>
</button>

<script>
/* ── Loader */
window.addEventListener('load',()=>setTimeout(()=>document.getElementById('loader').classList.add('done'),1000));

/* ── Navbar scroll */
window.addEventListener('scroll',()=>{
  document.getElementById('nav').classList.toggle('scrolled',scrollY>50);
  document.getElementById('btt').classList.toggle('show',scrollY>350);
});

/* ── Mobile nav */
document.querySelectorAll('.mob-lnk').forEach(l=>l.addEventListener('click',()=>document.querySelector('.mob-menu').classList.remove('open')));

/* ── Scroll reveal */
const io=new IntersectionObserver(entries=>{
  entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target)}});
},{threshold:.08});
document.querySelectorAll('[data-r]').forEach(el=>io.observe(el));

/* ────────────────────────────
   CATEGORY TABS
──────────────────────────── */
let activeCat='30min';

function switchCat(cat, btn){
  // Hide all categories
  document.querySelectorAll('.plans-category').forEach(c=>c.classList.remove('active'));
  // Show target
  document.getElementById('cat-'+cat).classList.add('active');
  // Update tab buttons
  document.querySelectorAll('.cat-tab').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  activeCat=cat;
}

/* ────────────────────────────
   BILLING TOGGLE
──────────────────────────── */
function toggleBilling(chk){
  const isAnnual=chk.checked;
  document.getElementById('lbl-monthly').classList.toggle('active',!isAnnual);
  document.getElementById('lbl-annual').classList.toggle('active',isAnnual);
  // Toggle price displays
  document.querySelectorAll('.plan-monthly-price').forEach(el=>el.style.display=isAnnual?'none':'');
  document.querySelectorAll('.plan-annual-price').forEach(el=>el.style.display=isAnnual?'':'none');
  document.querySelectorAll('.plan-monthly-text').forEach(el=>el.style.display=isAnnual?'none':'');
  document.querySelectorAll('.plan-annual-text').forEach(el=>el.style.display=isAnnual?'':'none');
}

/* ────────────────────────────
   PLAN SELECTION
──────────────────────────── */
let selectedPlan={name:'',price:'',duration:'',days:'',billing:'monthly'};

function selectPlan(card, name, price, billing, duration, days){
  // Deselect all in current category
  const cat=document.getElementById('cat-'+activeCat);
  cat.querySelectorAll('.plan-card').forEach(c=>c.classList.remove('selected'));
  // Select this card
  card.classList.add('selected');
  // Billing adjust for annual toggle
  const isAnnual=document.getElementById('billing-toggle').checked;
  const priceNum=parseFloat(price.replace('£',''));
  const finalPrice=isAnnual?'£'+(priceNum*.8).toFixed(2)+'/mo':price+'/mo';
  // Store
  selectedPlan={name,price:finalPrice,duration,days,billing:isAnnual?'annually':'monthly'};
  // Update selected bar for this category
  const bar=document.getElementById('selected-bar-'+activeCat);
  if(bar){
    bar.classList.add('show');
    document.getElementById('selected-name-'+activeCat).textContent=name;
    document.getElementById('selected-price-'+activeCat).textContent=finalPrice;
  }
  // Update form summary hidden fields
  document.getElementById('selected_plan_name').value=name;
  document.getElementById('selected_plan_price').value=finalPrice;
  document.getElementById('selected_plan_duration').value=duration;
  document.getElementById('selected_plan_days').value=days;
  document.getElementById('selected_plan_billing').value=selectedPlan.billing;
  // Update form plan summary
  const summary=document.getElementById('form-plan-summary');
  summary.classList.add('show');
  document.getElementById('form-plan-name').textContent=name;
  document.getElementById('form-plan-price').textContent=finalPrice;
  document.getElementById('form-plan-duration').textContent=duration;
  document.getElementById('form-plan-days').textContent=days;
  document.getElementById('form-plan-billing').textContent='Billed '+selectedPlan.billing;
  // Update CTA buttons in all plan cards
  const allBtns=document.getElementById('cat-'+activeCat).querySelectorAll('.btn-plan');
  allBtns.forEach(b=>{
    b.innerHTML=b.closest('.plan-card')===card
      ?'<i class="fas fa-check"></i>Plan Selected'
      :'<i class="fas fa-graduation-cap"></i>Choose Plan';
  });
}

function scrollToForm(){
  document.getElementById('booking-form-section').scrollIntoView({behavior:'smooth',block:'start'});
}

function scrollToPricing(){
  document.getElementById('pricing-section').scrollIntoView({behavior:'smooth',block:'start'});
}

/* ── Form Submit */
function submitBookForm(){
  // Basic validation
  const required=['parent_name','student_name','student_age','preferred_time','location','email'];
  let valid=true;
  required.forEach(name=>{
    const el=document.querySelector('[name="'+name+'"]');
    if(el&&!el.value.trim()){el.style.borderColor='var(--red)';valid=false;}
    else if(el){el.style.borderColor='var(--border)';}
  });
  if(!valid){
    alert('Please fill in all required fields.');
    return;
  }
  document.getElementById('book-form-body').style.display='none';
  document.getElementById('book-success').style.display='block';
}
</script>

{{-- @endsection --}}
@endsection