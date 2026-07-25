@extends('layouts.frontend')
@section('title', 'About Us - Merit Education Foundation')
@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600&family=Inter:wght@400;500;600;700&display=swap');

  .mef-hero * { box-sizing: border-box; }

  .mef-hero {
    --ink: #14261C;
    --ink-2: #1F3B2A;
    --paper: #FFFFFF;
    --panel: #F6F5F0;
    --gold: #96751F;
    --gold-tint: #F3EDDC;
    --line: #E2E0D6;
    --text: #1C231E;
    --text-soft: #5B5F55;
    --plum: #6C4E8E;
    --plum-tint: #EFE7F5;
    --leaf: #2F6B45;
    --leaf-tint: #E7F1E9;

    font-family: 'Inter', sans-serif;
    background: var(--paper);
  }

  .mef-topbar {
    background: var(--ink);
    padding: 9px 32px;
  }

  .mef-topbar-row {
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 12px;
    color: #B9C7BC;
    font-weight: 500;
  }

  .mef-topbar-reg { letter-spacing: 0.2px; }

  .mef-topbar-links { display: flex; gap: 20px; }
  .mef-topbar-links span { color: #E4E9E2; }

  .mef-main {
    display: grid;
    grid-template-columns: 1.08fr 0.92fr;
    gap: 56px;
    max-width: 1180px;
    margin: 0 auto;
    padding: 64px 32px 64px;
    align-items: start;
  }

  .mef-left { min-width: 0; padding-top: 8px; }

  .mef-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--gold-tint);
    color: var(--gold);
    font-size: 12px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 4px;
    margin-bottom: 24px;
    letter-spacing: 0.2px;
  }

  .mef-h1 {
    font-family: 'Inter', sans-serif;
    font-size: 46px;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.14;
    letter-spacing: -1.1px;
    margin: 0 0 16px;
  }
  .mef-h1 span { color: var(--gold); }

  .mef-desc {
    font-size: 16px;
    line-height: 1.7;
    color: var(--text-soft);
    max-width: 480px;
    margin: 0 0 32px;
  }
  .mef-desc strong { color: var(--ink); font-weight: 600; }

  .mef-btns { display: flex; gap: 12px; margin-bottom: 40px; flex-wrap: wrap; }

  .mef-btn-primary, .mef-btn-secondary {
    border: 1px solid transparent;
    padding: 13px 22px;
    border-radius: 6px;
    font-size: 14.5px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: 'Inter', sans-serif;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.15s ease, border-color 0.15s ease;
  }
  .mef-btn-primary { background: var(--ink); color: #fff; }
  .mef-btn-primary:hover { background: var(--ink-2); }
  .mef-btn-secondary { background: transparent; color: var(--ink); border-color: var(--line); }
  .mef-btn-secondary:hover { border-color: var(--ink); }
  .mef-btn-secondary svg { color: var(--gold); }

  .mef-trust {
    display: grid;
    grid-template-columns: repeat(2, auto);
    row-gap: 14px;
    column-gap: 28px;
    padding-top: 28px;
    border-top: 1px solid var(--line);
  }
  .mef-trust-item {
    display: flex; align-items: flex-start; gap: 9px;
    font-size: 13px; color: var(--text-soft); font-weight: 500;
  }
  .mef-trust-item svg { flex-shrink: 0; color: var(--gold); margin-top: 1px; }

  /* ===================== RIGHT SIDE — IMAGE SHOWCASE ===================== */

  .mef-right {
    min-width: 0;
    position: relative;
  }

  .mef-stage {
    position: relative;
    padding: 30px;
    isolation: isolate;
  }

  /* soft ambient blobs picking up the illustration's palette */
  .mef-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(2px);
    z-index: 0;
    opacity: 0.55;
    animation: mef-drift 9s ease-in-out infinite;
  }
  .mef-blob.b1 {
    width: 190px; height: 190px;
    background: radial-gradient(circle at 35% 35%, var(--leaf-tint), transparent 70%);
    top: -30px; left: -20px;
    animation-delay: 0s;
  }
  .mef-blob.b2 {
    width: 160px; height: 160px;
    background: radial-gradient(circle at 60% 40%, var(--plum-tint), transparent 70%);
    bottom: -20px; right: -10px;
    animation-delay: 1.4s;
  }
  .mef-blob.b3 {
    width: 90px; height: 90px;
    background: radial-gradient(circle at 50% 50%, var(--gold-tint), transparent 70%);
    top: 40%; right: -30px;
    animation-delay: 2.6s;
  }

  @keyframes mef-drift {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-8px, 10px) scale(1.05); }
  }

  /* dotted orbit ring, nods to geometric border-work without literal pattern copying */
  .mef-orbit {
    position: absolute;
    inset: 6px;
    border: 1.5px dashed rgba(150, 117, 31, 0.35);
    border-radius: 28px;
    z-index: 0;
    animation: mef-rotate 40s linear infinite;
  }
  @keyframes mef-rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }

  .mef-frame {
    position: relative;
    z-index: 1;
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 20px;
    padding: 22px;
    box-shadow: 0 30px 60px -25px rgba(20, 38, 28, 0.28);
    opacity: 0;
    transform: translateY(18px);
    animation: mef-rise 0.7s cubic-bezier(.22,.61,.36,1) 0.05s forwards;
  }

  @keyframes mef-rise {
    to { opacity: 1; transform: translateY(0); }
  }

  .mef-frame-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }

  .mef-frame-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.1px;
    text-transform: uppercase;
    color: var(--gold);
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .mef-frame-eyebrow::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--gold);
    display: inline-block;
    animation: mef-blink 2.2s ease-in-out infinite;
  }
  @keyframes mef-blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.25; }
  }

  .mef-frame-dots { display: flex; gap: 5px; }
  .mef-frame-dots span {
    width: 6px; height: 6px; border-radius: 50%; background: var(--line);
  }
  .mef-frame-dots span:nth-child(1) { background: var(--leaf); opacity: 0.5; }
  .mef-frame-dots span:nth-child(2) { background: var(--plum); opacity: 0.5; }
  .mef-frame-dots span:nth-child(3) { background: var(--gold); opacity: 0.5; }

  .mef-image-wrap {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    line-height: 0;
  }

  .mef-image-wrap img {
    width: 100%;
    height: auto;
    display: block;
    animation: mef-float 6s ease-in-out infinite;
    transform-origin: center;
  }

  @keyframes mef-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-9px) scale(1.012); }
  }

  .mef-image-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 14px;
    box-shadow: inset 0 0 0 1px rgba(20,38,28,0.06);
    pointer-events: none;
  }

  /* floating credential chips */
  .mef-chip {
    position: absolute;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 9px 14px 9px 10px;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ink);
    box-shadow: 0 12px 24px -12px rgba(20,38,28,0.35);
    opacity: 0;
    animation: mef-chip-in 0.6s cubic-bezier(.22,.61,.36,1) forwards, mef-chip-float 5s ease-in-out infinite;
  }

  .mef-chip .mef-chip-ic {
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .mef-chip.c1 {
    top: 6%;
    left: -8%;
    animation-delay: 0.5s, 1s;
  }
  .mef-chip.c1 .mef-chip-ic { background: var(--leaf-tint); color: var(--leaf); }

  .mef-chip.c2 {
    bottom: 8%;
    right: -9%;
    animation-delay: 0.75s, 2.2s;
  }
  .mef-chip.c2 .mef-chip-ic { background: var(--plum-tint); color: var(--plum); }

  @keyframes mef-chip-in {
    from { opacity: 0; transform: translateY(10px) scale(0.94); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  @keyframes mef-chip-float {
    0%, 100% { margin-top: 0; }
    50% { margin-top: -6px; }
  }

  .mef-caption {
    margin-top: 16px;
    text-align: center;
    font-size: 12.5px;
    color: var(--text-soft);
    font-weight: 500;
  }
  .mef-caption strong { color: var(--ink); }

  @media (prefers-reduced-motion: reduce) {
    .mef-blob, .mef-orbit, .mef-frame, .mef-image-wrap img,
    .mef-chip, .mef-frame-eyebrow::before {
      animation: none !important;
      opacity: 1 !important;
      transform: none !important;
    }
  }

  @media (max-width: 900px) {
    .mef-main { grid-template-columns: 1fr; padding: 48px 24px 48px; gap: 40px; }
    .mef-h1 { font-size: 38px; }
    .mef-desc { max-width: 100%; }
    .mef-topbar-links { display: none; }
    .mef-chip.c1 { left: 2%; top: -4%; }
    .mef-chip.c2 { right: 2%; bottom: -4%; }
  }

  @media (max-width: 600px) {
    .mef-main { padding: 36px 16px 36px; }
    .mef-h1 { font-size: 30px; letter-spacing: -0.6px; }
    .mef-desc { font-size: 14.5px; }
    .mef-btns { flex-direction: column; }
    .mef-btn-primary, .mef-btn-secondary { width: 100%; }
    .mef-trust { grid-template-columns: 1fr; }
    .mef-stage { padding: 14px; }
    .mef-chip { font-size: 11px; padding: 7px 11px 7px 8px; }
    .mef-chip.c1 { top: -10px; left: 0; }
    .mef-chip.c2 { bottom: -10px; right: 0; }
  }

  .mef-stat-bar { background: var(--ink-2); padding: 30px 32px; border-top: 1px solid rgba(255,255,255,0.08); }
  .mef-stats {
    max-width: 1180px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(4, 1fr); text-align: left;
  }
  .mef-stat-item { padding: 0 24px; border-left: 1px solid rgba(255,255,255,0.14); }
  .mef-stat-item:first-child { border-left: none; }
  .mef-stat-n { font-family: 'Source Serif 4', serif; font-size: 28px; font-weight: 600; color: #fff; }
  .mef-stat-l { font-size: 12px; color: #A9BFAF; font-weight: 500; margin-top: 4px; }

  @media (max-width: 600px) {
    .mef-stat-bar { padding: 24px 16px; }
    .mef-stats { grid-template-columns: repeat(2, 1fr); row-gap: 22px; }
    .mef-stat-item:nth-child(1), .mef-stat-item:nth-child(2) { border-left: none; }
    .mef-stat-n { font-size: 23px; }
  }
</style>
  <div class="about-hero">
    <div class="container position-relative" style="z-index:2">
      <div class="page-hero-badge"><span>About Us</span></div>
      <h1 class="page-hero-h mb-3">Our Mission,<br><em>Your Child's Future</em></h1>
      <p class="page-hero-p">Building a world where every child has access to quality education — regardless of financial or social background.</p>
    </div>
  </div>
  <!-- About Summary -->
  <section class="section-cream">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-5" data-r="left">
          {{--  --}}

      <div class="mef-stage">
        <div class="mef-blob b1"></div>
        <div class="mef-blob b2"></div>
        <div class="mef-blob b3"></div>
        <div class="mef-orbit"></div>

        <div class="mef-frame">
          <div class="mef-frame-top">
            <div class="mef-frame-eyebrow">100% Online</div>
            <div class="mef-frame-dots"><span></span><span></span><span></span></div>
          </div>

          <div class="mef-image-wrap">
            <img src="{{ asset('frontend/images/banner2.jpg') }}">
              <div class="mef-chip-ic">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
              </div>
              {{-- DBS-checked tutors --}}
            </div>

            <div class="mef-chip c2">
              <div class="mef-chip-ic">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 13V7a2 2 0 0 1 4 0"/><path d="M12 13V6a2 2 0 0 1 4 0v7"/><path d="M16 13V8a2 2 0 0 1 4 0v6c0 4-3 7-7 7h-1c-4 0-7-2-7-5v-3a1.5 1.5 0 0 1 3 0"/></svg>
              </div>
              any one can join
            </div>
          </div>

          <div class="mef-caption">Ages 3+ · <strong>Qaida to Tajweed</strong> · fun, guided family learning</div>
        </div>
     
          {{--  --}}
        </div>
        <div class="col-lg-7" data-r="right">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Who We Are</span></div>
          <h2 class="sec-h">Education &<br><em>Charity Combined</em></h2>
          <div class="divider-gold"></div>
          <p class="sec-p mb-4">Merit Education Foundation is a UK-based non-profit combining premium online Quran teaching with a charitable mission. Lesson fees directly fund free education for children who cannot afford it — creating a self-sustaining cycle of impact.</p>
          <button class="btn-navy" href="{{ url('/about') }}">Learn More <i class="fas fa-arrow-right ms-1"></i></button>
          <div class="row g-3 mt-2">
            <div class="col-6">
              <div class="about-sum-badge"><div class="about-sum-badge-ic" style="background:rgba(201,168,76,.12)"><i class="fas fa-quran" style="color:var(--gold)"></i></div><div><h6>Quran Teaching</h6><p>Expert 1-to-1 online lessons</p></div></div>
              <div class="about-sum-badge"><div class="about-sum-badge-ic" style="background:rgba(15,31,92,.07)"><i class="fas fa-heart" style="color:var(--navy)"></i></div><div><h6>Charity Mission</h6><p>Funding disadvantaged students</p></div></div>
            </div>
            <div class="col-6">
              <div class="about-sum-badge"><div class="about-sum-badge-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-shield-alt" style="color:var(--teal)"></i></div><div><h6>Safeguarding</h6><p>Child safety is our priority</p></div></div>
              <div class="about-sum-badge"><div class="about-sum-badge-ic" style="background:rgba(201,168,76,.12)"><i class="fas fa-chart-pie" style="color:var(--gold)"></i></div><div><h6>Transparent Funds</h6><p>Clear fee vs donation split</p></div></div>
            </div>
            <div class="col-12">
              <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));border-radius:14px;padding:20px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                <div><div style="font-family:'Cormorant Garamond',serif;font-size:1rem;color:rgba(255,255,255,.5);font-style:italic">Key distinction</div><div style="font-size:.88rem;font-weight:600;color:var(--white);margin-top:4px">Lesson Fee = Service &nbsp;|&nbsp; <span style="color:var(--gold)">Donation = Charity (Gift Aid eligible)</span></div></div>
                <i class="fas fa-info-circle" style="color:rgba(201,168,76,.4);font-size:1.2rem"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Mission & Vision -->
  <section class="section-cream">
    <div class="container">
      <div class="text-center mb-5" data-r="up">
        <div class="eyebrow justify-content-center"><div class="eyebrow-line"></div><span class="eyebrow-txt">Foundation</span><div class="eyebrow-line"></div></div>
        <h2 class="sec-h">Mission & <em>Vision</em></h2><div class="divider-gold center"></div>
      </div>
      <div class="row g-4 mb-5">
        <div class="col-md-6" data-r="up"><div class="mission-card"><div class="mc-ic"><i class="fas fa-bullseye"></i></div><h4>Our Mission</h4><p>Merit Education Foundation is committed to advancing education and supporting disadvantaged and orphaned students through accessible learning opportunities — combining premium online Quran teaching with a transparent charitable model.</p></div></div>
        <div class="col-md-6" data-r="up" style="transition-delay:.1s"><div class="mission-card"><div class="mc-ic"><i class="fas fa-eye"></i></div><h4>Our Vision</h4><p>A world where every child has access to quality education, regardless of their financial or social background. We envision an equitable future built on knowledge, compassion and community.</p></div></div>
      </div>

      <!-- What Makes Us Different -->
      <div class="row align-items-center g-5">
        <div class="col-lg-5" data-r="left">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">What Makes Us Different</span></div>
          <h2 class="sec-h">Education +<br><em>Charity Combined</em></h2>
          <div class="divider-gold"></div>
          <p class="sec-p">We operate at the intersection of education and charity — ensuring that every paying student indirectly supports a child who cannot afford to learn. This self-sustaining model is what sets Merit apart.</p>
        </div>
        <div class="col-lg-7" data-r="right">
          <div class="row g-3">
            <div class="col-6"><div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;text-align:center;transition:.3s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><i class="fas fa-layer-group" style="font-size:1.6rem;color:var(--gold);margin-bottom:12px"></i><div style="font-size:.9rem;font-weight:700;color:var(--navy);margin-bottom:6px">Education + Charity</div><div style="font-size:.78rem;color:var(--muted)">A unique dual-impact model</div></div></div>
            <div class="col-6"><div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;text-align:center;transition:.3s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><i class="fas fa-search-dollar" style="font-size:1.6rem;color:var(--teal);margin-bottom:12px"></i><div style="font-size:.9rem;font-weight:700;color:var(--navy);margin-bottom:6px">Transparent Funds</div><div style="font-size:.78rem;color:var(--muted)">Every penny accounted for</div></div></div>
            <div class="col-6"><div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;text-align:center;transition:.3s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><i class="fas fa-globe" style="font-size:1.6rem;color:var(--navy);margin-bottom:12px"></i><div style="font-size:.9rem;font-weight:700;color:var(--navy);margin-bottom:6px">Global Impact</div><div style="font-size:.78rem;color:var(--muted)">30+ countries supported</div></div></div>
            <div class="col-6"><div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;text-align:center;transition:.3s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><i class="fas fa-user-shield" style="font-size:1.6rem;color:var(--gold);margin-bottom:12px"></i><div style="font-size:.9rem;font-weight:700;color:var(--navy);margin-bottom:6px">Safeguarding</div><div style="font-size:.78rem;color:var(--muted)">Child safety standards</div></div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Values -->
  <section>
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-r="left">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Our Values</span></div>
          <h2 class="sec-h">What We <em>Stand For</em></h2>
          <div class="divider-gold"></div>
          <div class="value-item"><div class="value-ic" style="background:rgba(201,168,76,.12)"><i class="fas fa-handshake" style="color:var(--gold)"></i></div><div><h6>Integrity</h6><p>We operate with honesty and transparency in everything we do — from our finances to our tutoring standards.</p></div></div>
          <div class="value-item"><div class="value-ic" style="background:rgba(15,31,92,.07)"><i class="fas fa-book-open" style="color:var(--navy)"></i></div><div><h6>Education for All</h6><p>No child should be denied education because of poverty. Access to learning is a right, not a privilege.</p></div></div>
          <div class="value-item"><div class="value-ic" style="background:rgba(201,168,76,.12)"><i class="fas fa-heart" style="color:var(--gold)"></i></div><div><h6>Compassion</h6><p>We approach every student, family and donor with genuine care, warmth and understanding.</p></div></div>
          <div class="value-item"><div class="value-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-balance-scale" style="color:var(--teal)"></i></div><div><h6>Accountability</h6><p>We are answerable to our students, donors and the communities we serve — always.</p></div></div>
        </div>
        <div class="col-lg-6" data-r="right">
          <div class="trust-highlight">
            <div class="eyebrow mb-3" style="filter:brightness(1.2)"><div class="eyebrow-line" style="background:rgba(201,168,76,.4)"></div><span class="eyebrow-txt" style="color:rgba(255,255,255,.45)">Trust & Transparency</span></div>
            <h3 class="serif" style="font-size:1.6rem;font-weight:700;color:var(--white);margin-bottom:8px">How Your Money <em style="color:var(--gold)">Works</em></h3>
            <p style="font-size:.82rem;color:rgba(255,255,255,.45);margin-bottom:24px;line-height:1.7">We keep our lesson fees and donations completely separate — so you always know what you're contributing to.</p>
            <div class="trust-row"><div class="trust-row-ic"><i class="fas fa-pound-sign"></i></div><div><h6>Lesson Fees = Service</h6><p>These cover tutor pay, platform costs and administration. Not charity-eligible, but 100% value for your child.</p></div></div>
            <div class="trust-row"><div class="trust-row-ic"><i class="fas fa-heart"></i></div><div><h6>Donations = Charity (Gift Aid eligible)</h6><p>Donations go directly to funding education for disadvantaged children. UK taxpayers can boost by 25% via Gift Aid.</p></div></div>
            <div class="trust-row"><div class="trust-row-ic"><i class="fas fa-chart-bar"></i></div><div><h6>Annual Impact Reports</h6><p>We publish detailed reports showing exactly how every donated pound was used to change lives.</p></div></div>
            <div class="trust-row"><div class="trust-row-ic"><i class="fas fa-shield-alt"></i></div><div><h6>Registered & Regulated</h6><p>Merit Education Foundation operates under UK charity law with full transparency to our board and donors.</p></div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="cta-block"><div class="container"><div class="inner">
    <div class="row align-items-center g-4">
      <div class="col-lg-7"><h2 class="display-h" style="font-size:clamp(1.7rem,3.5vw,2.5rem);color:var(--navy)">Ready to Make a Difference?</h2><p style="color:rgba(15,31,92,.6);margin-top:10px;font-size:.92rem">Book a lesson or donate today and become part of something bigger.</p></div>
      <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end">
        <button class="btn-navy" ><i class="fas fa-graduation-cap"></i>Book a Lesson</button>
      
      </div>
    </div>
  </div></div></div>
</div><!-- end about -->

@endsection