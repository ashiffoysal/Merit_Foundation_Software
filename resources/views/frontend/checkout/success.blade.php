@extends('layouts.frontend')
@section('title', 'Success- Merit Education Foundation')
@section('content')
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
    --success:  #1e8449;
    --success-l:#edfaf3;
    --success-b:#a9dfbf;
    --border:   #e4e0d8;
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

  /* Background pattern matching login page feel */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
      radial-gradient(circle at 10% 20%, rgba(201,168,76,.06) 0%, transparent 50%),
      radial-gradient(circle at 90% 80%, rgba(26,46,74,.07) 0%, transparent 50%);
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
  .topbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }
  .topbar-ic {
    width: 34px; height: 34px;
    background: var(--gold);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: var(--navy);
    font-size: .85rem;
  }
  .topbar-name { font-family: 'Playfair Display', serif; color: #fff; font-size: 1rem; font-weight: 600; letter-spacing: .04em; }
  .topbar-sub  { color: rgba(255,255,255,.55); font-size: .67rem; letter-spacing: .08em; text-transform: uppercase; }
  .topbar-secure {
    margin-left: auto;
    display: flex; align-items: center; gap: 7px;
    font-size: .72rem; color: rgba(255,255,255,.55);
  }
  .topbar-secure i { color: var(--gold); }

  /* ── Main card ── */
  .page-wrap {
    width: 100%;
    max-width: 680px;
    margin-top: 80px;
  }

  /* ── Success hero ── */
  .success-hero {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 48px rgba(26,46,74,.10), 0 2px 8px rgba(26,46,74,.06);
    margin-bottom: 20px;
  }

  .hero-header {
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy-l) 100%);
    padding: 48px 40px 56px;
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
    background: rgba(201,168,76,.07);
  }
  .hero-header::after {
    content: '';
    position: absolute;
    bottom: -50px; left: -30px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(201,168,76,.05);
  }

  .checkmark-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 22px;
  }
  .checkmark-ring {
    width: 88px; height: 88px;
    border-radius: 50%;
    background: rgba(201,168,76,.12);
    display: flex; align-items: center; justify-content: center;
    animation: popIn .5s cubic-bezier(.34,1.56,.64,1) both;
  }
  .checkmark-inner {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), var(--gold-l));
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    color: var(--navy);
    box-shadow: 0 6px 24px rgba(201,168,76,.40);
  }
  @keyframes popIn {
    from { opacity:0; transform:scale(.6); }
    to   { opacity:1; transform:scale(1); }
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem;
    color: #fff;
    font-weight: 600;
    margin-bottom: 10px;
    position: relative; z-index: 1;
  }
  .hero-sub {
    font-size: .85rem;
    color: rgba(255,255,255,.65);
    line-height: 1.6;
    max-width: 380px;
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

  /* Amount display */
  .amount-block {
    text-align: center;
    padding: 24px;
    background: var(--gold-pale);
    border: 1px solid rgba(201,168,76,.25);
    border-radius: 14px;
    margin-bottom: 28px;
  }
  .amount-label { font-size: .72rem; color: var(--muted); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 6px; }
  .amount-value {
    font-family: 'Playfair Display', serif;
    font-size: 2.6rem;
    color: var(--navy);
    font-weight: 600;
    line-height: 1;
  }
  .amount-desc { font-size: .78rem; color: var(--muted); margin-top: 6px; }

  /* Detail rows */
  .detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 28px;
  }
  .detail-item {
    background: var(--light-bg);
    border-radius: 10px;
    padding: 14px 16px;
    border: 1px solid var(--border);
  }
  .detail-lbl { font-size: .69rem; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px; }
  .detail-val { font-size: .88rem; color: var(--navy); font-weight: 500; }

  /* Gift Aid callout */
  .giftaid-box {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: linear-gradient(135deg, #eaf4fd, #e8f5fe);
    border: 1px solid #a9cce3;
    border-radius: 12px;
    padding: 16px 18px;
    margin-bottom: 28px;
  }
  .giftaid-icon { font-size: 1.3rem; color: #1a5276; flex-shrink: 0; margin-top: 2px; }
  .giftaid-title { font-size: .82rem; font-weight: 600; color: #1a5276; margin-bottom: 3px; }
  .giftaid-text  { font-size: .76rem; color: #2471a3; line-height: 1.5; }

  /* Confirmation notice */
  .confirm-notice {
    display: flex; align-items: flex-start; gap: 10px;
    background: var(--success-l);
    border: 1px solid var(--success-b);
    border-radius: 10px;
    padding: 13px 16px;
    font-size: .78rem;
    color: var(--success);
    line-height: 1.5;
    margin-bottom: 28px;
  }
  .confirm-notice i { flex-shrink:0; margin-top:1px; }

  /* CTA buttons */
  .btn-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  .btn-gold {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 14px 20px;
    background: linear-gradient(135deg, var(--gold), var(--gold-l));
    color: var(--navy);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
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
    font-size: .82rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
  }
  .btn-outline:hover { background: var(--navy); color: #fff; border-color: var(--navy); }

  /* ── What happens next ── */
  .next-card {
    background: var(--white);
    border-radius: 16px;
    padding: 28px 32px;
    box-shadow: 0 4px 20px rgba(26,46,74,.07);
    margin-bottom: 20px;
  }
  .next-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: var(--navy);
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border);
  }
  .next-steps { list-style: none; display: flex; flex-direction: column; gap: 14px; }
  .next-step  { display: flex; align-items: flex-start; gap: 14px; }
  .step-num   {
    width: 28px; height: 28px; flex-shrink: 0;
    border-radius: 50%;
    background: var(--navy);
    color: var(--gold);
    font-size: .73rem; font-weight: 600;
    display: flex; align-items: center; justify-content: center;
    margin-top: 1px;
  }
  .step-text  { font-size: .82rem; color: var(--text); line-height: 1.6; }
  .step-text strong { color: var(--navy); }

  /* ── Footer ── */
  .page-footer {
    text-align: center;
    font-size: .72rem;
    color: var(--muted);
    line-height: 1.8;
    padding-top: 8px;
  }
  .page-footer a { color: var(--gold); text-decoration: none; }
 footer.site-footer {
    width: 100%;
}
  /* Responsive */
  @media (max-width: 560px) {
    .hero-header { padding: 36px 24px 44px; }
    .hero-body   { padding: 28px 24px 32px; }
    .detail-grid { grid-template-columns: 1fr; }
    .btn-row     { grid-template-columns: 1fr; }
    .next-card   { padding: 22px 20px; }
    .hero-title  { font-size: 1.5rem; }
    .amount-value{ font-size: 2rem; }
    .topbar      { padding: 0 20px; }
  }
</style>




<div class="page-wrap">

  <!-- ── Success Card ── -->
  <div class="success-hero">

    <div class="hero-header">
      <div class="checkmark-wrap">
        <div class="checkmark-ring">
          <div class="checkmark-inner"><i class="fas fa-check"></i></div>
        </div>
      </div>
      <h1 class="hero-title">Payment Successful!</h1>
      <p class="hero-sub">Thank you for your generous donation to Merit Education Foundation. Your contribution makes a real difference.</p>
    </div>

    <div class="gold-strip"></div>

    <div class="hero-body">

      <!-- Amount -->
      {{-- <div class="amount-block">
        <div class="amount-label">Amount Donated</div>
        <div class="amount-value">£25.00</div>
        <div class="amount-desc">One-time donation · UK Gift Aid eligible</div>
      </div> --}}

      <!-- Detail rows -->
      {{-- <div class="detail-grid">
        <div class="detail-item">
          <div class="detail-lbl">Reference</div>
          <div class="detail-val">#MEF-2024-00847</div>
        </div>
        <div class="detail-item">
          <div class="detail-lbl">Date</div>
          <div class="detail-val" id="pay-date">—</div>
        </div>
        <div class="detail-item">
          <div class="detail-lbl">Payment Method</div>
          <div class="detail-val"><i class="fab fa-cc-visa" style="color:#1a1f71;margin-right:5px"></i>Visa •••• 4242</div>
        </div>
        <div class="detail-item">
          <div class="detail-lbl">Status</div>
          <div class="detail-val" style="color:var(--success)"><i class="fas fa-circle" style="font-size:.5rem;vertical-align:2px;margin-right:5px"></i>Confirmed</div>
        </div>
      </div> --}}

      <!-- Gift Aid -->
     

      <!-- Email notice -->
      <div class="confirm-notice">
        <i class="fas fa-envelope-open-text"></i>
        <span>A confirmation receipt has been sent to your registered email address. Please keep it for your records and tax purposes.</span>
      </div>

      <!-- CTAs -->
      <div class="btn-row">
        <a href="#" class="btn-gold"><i class="fas fa-tachometer-alt"></i> Go to Dashboard</a>
        <a href="#" class="btn-outline"><i class="fas fa-download"></i> Download Receipt</a>
      </div>
    </div>
  </div>

  <!-- ── What happens next ── -->
  <div class="next-card">
    <div class="next-title"><i class="fas fa-route" style="color:var(--gold);margin-right:10px"></i>What Happens Next</div>
    <ul class="next-steps">
      <li class="next-step">
        <div class="step-num">1</div>
        <div class="step-text"><strong>Receipt email</strong> — A detailed receipt will arrive in your inbox within the next few minutes. Check your spam folder if you don't see it.</div>
      </li>
      <li class="next-step">
        <div class="step-num">2</div>
        <div class="step-text"><strong>Gift Aid declaration</strong> — If you're a UK taxpayer, we'll contact you within 48 hours to confirm your Gift Aid declaration and maximise your donation's impact.</div>
      </li>
      <li class="next-step">
        <div class="step-num">3</div>
        <div class="step-text"><strong>Impact report</strong> — Every quarter we send donors a report showing exactly how contributions like yours have supported Quran education and lessons across the UK.</div>
      </li>
    </ul>
  </div>

  <!-- Footer -->

</div>

<script>
  document.getElementById('pay-date').textContent = new Date().toLocaleDateString('en-GB', {
    day: '2-digit', month: 'short', year: 'numeric'
  });
</script>
@endsection