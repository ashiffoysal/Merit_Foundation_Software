@extends('layouts.frontend')
@section('title', 'Cancelled – Merit Education Foundation')
@section('content')
{{-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"> --}}
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --navy:     #1a2e4a;
    --navy-d:   #0f1d30;
    --navy-l:   #243d5e;
    --gold:     #c9a84c;
    --gold-l:   #e0c068;
    --gold-pale:#faf6ec;
    --light-bg: #f7f5f0;
    --white:    #ffffff;
    --muted:    #7a7a7a;
    --text:     #1c1c1c;
    --border:   #e4e0d8;
    --cancel-bg:#fff9f0;
    --cancel-b: rgba(201,168,76,.2);
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--light-bg);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    position: relative;
    overflow-x: hidden;
  }

  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
      radial-gradient(circle at 15% 25%, rgba(201,168,76,.05) 0%, transparent 50%),
      radial-gradient(circle at 85% 75%, rgba(26,46,74,.06) 0%, transparent 50%);
    pointer-events: none;
  }

  /* ── Nav bar ── */
  .topbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 60px;
    background: var(--navy);
    display: flex;
    align-items: center;
    padding: 0 32px;
    z-index: 100;
    box-shadow: 0 2px 16px rgba(0,0,0,.18);
  }
  .topbar-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
  .topbar-ic    {
    width: 34px; height: 34px;
    background: var(--gold);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: var(--navy); font-size: .85rem;
  }
  .topbar-name { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; font-weight: 600; letter-spacing: .04em; }
  .topbar-sub  { color: rgba(255,255,255,.55); font-size: .67rem; letter-spacing: .08em; text-transform: uppercase; }
  .topbar-secure { margin-left: auto; display: flex; align-items: center; gap: 7px; font-size: .72rem; color: rgba(255,255,255,.55); }
  .topbar-secure i { color: var(--gold); }

  /* ── Main card ── */
  .page-wrap {
    width: 100%;
    max-width: 640px;
    margin-top: 80px;
  }

  /* ── Cancel hero ── */
  .cancel-hero {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 48px rgba(26,46,74,.10), 0 2px 8px rgba(26,46,74,.06);
    margin-bottom: 20px;
  }

  .hero-header {
    background: linear-gradient(135deg, var(--navy) 0%, #1e3a58 100%);
    padding: 48px 40px 52px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .hero-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(201,168,76,.05);
  }
  .hero-header::after {
    content: '';
    position: absolute;
    bottom: -50px; left: -30px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(201,168,76,.04);
  }

  /* Cancel icon — softer, not alarming */
  .cancel-icon-wrap {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 22px;
  }
  .cancel-ring {
    width: 88px; height: 88px;
    border-radius: 50%;
    background: rgba(201,168,76,.10);
    display: flex; align-items: center; justify-content: center;
    animation: popIn .5s cubic-bezier(.34,1.56,.64,1) both;
  }
  .cancel-inner {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,.10);
    border: 2px solid rgba(201,168,76,.50);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    color: var(--gold-l);
  }
  @keyframes popIn {
    from { opacity:0; transform:scale(.6); }
    to   { opacity:1; transform:scale(1); }
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: #fff;
    font-weight: 600;
    margin-bottom: 10px;
    position: relative; z-index: 1;
  }
  .hero-sub {
    font-size: .84rem;
    color: rgba(255,255,255,.62);
    line-height: 1.6;
    max-width: 360px;
    margin: 0 auto;
    position: relative; z-index: 1;
  }

  /* ── Gold divider strip ── */
  .gold-strip {
    height: 4px;
    background: linear-gradient(90deg, var(--gold), var(--gold-l), var(--gold));
  }

  /* ── Body content ── */
  .hero-body {
    padding: 36px 40px 40px;
  }

  /* No-charge notice */
  .nocharge-box {
    display: flex; align-items: flex-start; gap: 14px;
    background: var(--cancel-bg);
    border: 1px solid var(--cancel-b);
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 24px;
  }
  .nocharge-icon { font-size: 1.3rem; color: var(--gold); flex-shrink: 0; margin-top: 2px; }
  .nocharge-title{ font-size: .85rem; font-weight: 600; color: var(--navy); margin-bottom: 4px; }
  .nocharge-text { font-size: .77rem; color: var(--muted); line-height: 1.6; }

  /* Divider */
  .divider-label {
    display: flex; align-items: center; gap: 12px;
    font-size: .72rem; color: var(--muted);
    text-transform: uppercase; letter-spacing: .09em;
    margin-bottom: 20px;
  }
  .divider-label::before,
  .divider-label::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  /* Why donate reasons */
  .reasons { display: flex; flex-direction: column; gap: 12px; margin-bottom: 28px; }
  .reason  {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 16px;
    background: var(--light-bg);
    border-radius: 10px;
    border: 1px solid var(--border);
    transition: border-color .2s;
  }
  .reason:hover { border-color: rgba(201,168,76,.4); }
  .reason-ic {
    width: 36px; height: 36px; flex-shrink: 0;
    background: var(--navy);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: .85rem;
  }
  .reason-title { font-size: .83rem; font-weight: 600; color: var(--navy); margin-bottom: 2px; }
  .reason-text  { font-size: .76rem; color: var(--muted); line-height: 1.5; }

  /* Amount quick-select */
  .amount-section { margin-bottom: 28px; }
  .amount-lbl { font-size: .75rem; font-weight: 500; color: var(--navy); margin-bottom: 10px; text-transform: uppercase; letter-spacing: .07em; }
  .amount-pills { display: flex; gap: 8px; flex-wrap: wrap; }
  .pill {
    padding: 9px 20px;
    border-radius: 99px;
    border: 1.5px solid rgba(26,46,74,.2);
    font-size: .82rem;
    font-weight: 500;
    color: var(--navy);
    background: transparent;
    cursor: pointer;
    transition: all .2s;
    font-family: 'DM Sans', sans-serif;
  }
  .pill:hover, .pill.active {
    background: var(--navy);
    color: var(--gold);
    border-color: var(--navy);
  }
  .pill.featured {
    background: var(--gold-pale);
    border-color: var(--gold);
    color: var(--navy);
  }
  .pill.featured:hover { background: var(--gold); color: var(--navy); }

  /* CTAs */
  .btn-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .btn-gold {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 14px 20px;
    background: linear-gradient(135deg, var(--gold), var(--gold-l));
    color: var(--navy);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; font-weight: 600;
    cursor: pointer; text-decoration: none;
    transition: all .2s;
    box-shadow: 0 4px 16px rgba(201,168,76,.30);
  }
  .btn-gold:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(201,168,76,.40); }
  .btn-outline {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 14px 20px;
    background: transparent;
    color: var(--navy);
    border: 1.5px solid rgba(26,46,74,.25);
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; font-weight: 500;
    cursor: pointer; text-decoration: none;
    transition: all .2s;
  }
  .btn-outline:hover { background: var(--navy); color: #fff; border-color: var(--navy); }

  /* ── Impact stats card ── */
  .impact-card {
    background: var(--navy);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
  }
  .impact-card::after {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(201,168,76,.06);
  }
  .impact-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    color: rgba(255,255,255,.75);
    font-weight: 600;
    margin-bottom: 6px;
  }
  .impact-subtitle { font-size: .76rem; color: rgba(255,255,255,.45); margin-bottom: 20px; line-height: 1.5; }
  .impact-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
  .impact-stat { text-align: center; }
  .impact-num  {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem; font-weight: 600;
    color: var(--gold);
    line-height: 1;
    margin-bottom: 4px;
  }
  .impact-desc { font-size: .70rem; color: rgba(255,255,255,.50); line-height: 1.4; }
  .impact-divider { border: none; border-top: 1px solid rgba(255,255,255,.08); margin: 20px 0; }

  /* ── Footer ── */
  .page-footer {
    text-align: center;
    font-size: .72rem;
    color: var(--muted);
    line-height: 1.8;
    padding-top: 8px;
  }
  .page-footer a { color: var(--gold); text-decoration: none; }

  /* Responsive */
  @media (max-width: 560px) {
    .hero-header { padding: 36px 24px 40px; }
    .hero-body   { padding: 28px 24px 32px; }
    .btn-row     { grid-template-columns: 1fr; }
    .impact-card { padding: 22px 20px; }
    .impact-stats{ grid-template-columns: 1fr 1fr; }
    .hero-title  { font-size: 1.5rem; }
    .topbar      { padding: 0 20px; }
    .amount-pills{ gap: 6px; }
  }
</style>



<div class="page-wrap">

  <!-- ── Cancel Card ── -->
  <div class="cancel-hero">

    <div class="hero-header">
      <div class="cancel-icon-wrap">
        <div class="cancel-ring">
          <div class="cancel-inner"><i class="fas fa-times"></i></div>
        </div>
      </div>
      <h1 class="hero-title">Payment Cancelled</h1>
      <p class="hero-sub">No payment has been taken. You can return to your dashboard or try donating again whenever you're ready.</p>
    </div>

    <div class="gold-strip"></div>

    <div class="hero-body">

      <!-- No charge assurance -->
      <div class="nocharge-box">
        <i class="fas fa-shield-check nocharge-icon"></i>
        <div>
          <div class="nocharge-title">You have not been charged</div>
          <div class="nocharge-text">Your payment was cancelled before it was processed. No funds have been taken from your account and no transaction has been recorded.</div>
        </div>
      </div>

      <!-- Why donate -->
      <div class="divider-label">Would you like to try again?</div>

      <div class="reasons">
        <div class="reason">
          <div class="reason-ic"><i class="fas fa-graduation-cap"></i></div>
          <div>
            <div class="reason-title">Directly fund Quran lessons</div>
            <div class="reason-text">Your donation pays for qualified teachers, lesson materials, and safeguarding-compliant sessions for children across the UK.</div>
          </div>
        </div>
        <div class="reason">
          <div class="reason-ic"><i class="fas fa-heart"></i></div>
          <div>
            <div class="reason-title">Every £1 is Gift Aid boosted to £1.25</div>
            <div class="reason-text">As a UK taxpayer, your donation is automatically worth 25% more through Gift Aid — at no extra cost to you.</div>
          </div>
        </div>
        <div class="reason">
          <div class="reason-ic"><i class="fas fa-users"></i></div>
          <div>
            <div class="reason-title">Join 1,200+ supporters</div>
            <div class="reason-text">Your contribution joins a community of families and supporters helping us reach more children with quality Islamic education.</div>
          </div>
        </div>
      </div>

      <!-- Amount quick-pick -->
      <div class="amount-section">
        <div class="amount-lbl">Choose a donation amount</div>
        <div class="amount-pills">
          <button class="pill" onclick="selectPill(this)">£5</button>
          <button class="pill featured" onclick="selectPill(this)">£10</button>
          <button class="pill" onclick="selectPill(this)">£25</button>
          <button class="pill" onclick="selectPill(this)">£50</button>
          <button class="pill" onclick="selectPill(this)">£100</button>
        </div>
      </div>

      <!-- CTAs -->
      <div class="btn-row">
        <a href="#" class="btn-gold"><i class="fas fa-redo"></i> Try Again</a>
        <a href="#" class="btn-outline"><i class="fas fa-home"></i> Back to Dashboard</a>
      </div>

    </div>
  </div>

  <!-- ── Impact stats ── -->
  <div class="impact-card">
    <div class="impact-title">Your donation makes a real difference</div>
    <div class="impact-subtitle">Every contribution — however small — directly funds quality Islamic education for children across the UK.</div>
    <div class="impact-stats">
      <div class="impact-stat">
        <div class="impact-num">847</div>
        <div class="impact-desc">Children supported this year</div>
      </div>
      <div class="impact-stat">
        <div class="impact-num">£62k</div>
        <div class="impact-desc">Raised through Gift Aid alone</div>
      </div>
      <div class="impact-stat">
        <div class="impact-num">98%</div>
        <div class="impact-desc">Goes directly to lessons</div>
      </div>
    </div>
    <hr class="impact-divider">
    <div style="font-size:.74rem;color:rgba(255,255,255,.4);text-align:center">Merit Education Foundation · UK Registered Charity · Safeguarding First</div>
  </div>

  <!-- Footer -->
  <div class="page-footer">
    Merit Education Foundation · UK Registered Charity No. 000000<br>
    <a href="#">Privacy Policy</a> &nbsp;·&nbsp; <a href="#">Contact Us</a> &nbsp;·&nbsp; <a href="#">Terms &amp; Conditions</a>
  </div>
</div>

<script>
  function selectPill(el) {
    document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
  }
</script>
@endsection