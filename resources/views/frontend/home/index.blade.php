@extends('layouts.frontend')
@section('title', 'Home - Merit Education Foundation')
@section('content')
  <!-- Hero -->
  {{-- <section class="hero">
    <div class="hero-mesh"></div><div class="hero-grid"></div>
    <div class="hero-orb hero-orb-1"></div><div class="hero-orb hero-orb-2"></div>
    <div class="container" style="padding-bottom:130px;padding-top:60px">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="hero-pill" data-r="up"><div class="hero-pill-dot"></div><span>UK-Based · Safeguarding Focused · Qualified Tutors</span></div>
          <h1 class="hero-h" data-r="up" style="transition-delay:.08s">Education<br>for <em>Every</em><br>Child</h1>
          <p class="hero-sub" data-r="up" style="transition-delay:.15s">Opportunity knows no boundaries</p>
          <div class="hero-rule" data-r="fade" style="transition-delay:.2s"><div class="hero-rl"></div><div class="hero-diamond"></div></div>
          <p class="hero-p" data-r="up" style="transition-delay:.22s">Merit Education Foundation offers expert online Quran lessons and educational support — while funding places for children who cannot afford them. Every lesson fee helps a child in need.</p>
          <div class="hero-btns" data-r="up" style="transition-delay:.3s">
            <a class="btn-gold" href="{{ url('/prices') }}"><i class="fas fa-graduation-cap"></i>Book a Lesson</a>
         
          </div>
          <div class="hero-trust" data-r="fade" style="transition-delay:.38s">
            <span class="trust-item"><i class="fas fa-shield-alt"></i>UK-Based Organisation</span>
            <span class="trust-item"><i class="fas fa-user-shield"></i>Safeguarding First</span>
            <span class="trust-item"><i class="fas fa-certificate"></i>Qualified Tutors</span>
            <span class="trust-item"><i class="fas fa-check-circle"></i>Transparent Funds</span>
          </div>
        </div>
        <div class="col-lg-6" data-r="right" style="transition-delay:.15s">
          <div class="hero-right-card">
            <div class="hero-right-title">What We Offer</div>
            <div class="hero-feat"><div class="hero-feat-ic"><i class="fas fa-quran"></i></div><div><div class="hero-feat-t">1-to-1 Online Quran Lessons</div><div class="hero-feat-s">Expert tutors, flexible scheduling, structured learning from Qaida to Tajweed</div></div></div>
            <div class="hero-feat"><div class="hero-feat-ic"><i class="fas fa-book-reader"></i></div><div><div class="hero-feat-t">Educational Support Programmes</div><div class="hero-feat-s">Literacy, numeracy and academic support for children who need it most</div></div></div>
            <div class="hero-feat"><div class="hero-feat-ic"><i class="fas fa-hand-holding-heart"></i></div><div><div class="hero-feat-t">Charity-Funded Places</div><div class="hero-feat-s">Your lesson fee helps fund free education for disadvantaged & orphaned children</div></div></div>
            <div class="hero-feat"><div class="hero-feat-ic"><i class="fas fa-globe"></i></div><div><div class="hero-feat-t">Global Impact</div><div class="hero-feat-s">Supporting students across 30+ countries through our charity programmes</div></div></div>
            <div class="hero-mini-cta">
              <div class="hero-mini-stat"><strong>5,000+</strong><span>Children Supported</span></div>
              <a class="btn-sm-gold" href="{{ url('/about') }}">Our Story <i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-stat-bar">
      <div class="container"><div class="row text-center">
        <div class="col-6 col-md-3"><div class="hero-stat"><div class="hero-stat-n">5,000+</div><div class="hero-stat-l">Students Helped</div></div></div>
        <div class="col-6 col-md-3"><div class="hero-stat"><div class="hero-stat-n">120+</div><div class="hero-stat-l">Schools Supported</div></div></div>
        <div class="col-6 col-md-3"><div class="hero-stat"><div class="hero-stat-n">30+</div><div class="hero-stat-l">Countries</div></div></div>
        <div class="col-6 col-md-3"><div class="hero-stat"><div class="hero-stat-n">15+</div><div class="hero-stat-l">Years of Impact</div></div></div>
      </div></div>
    </div>
  </section> --}}
{{-- <style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@400;500;600&display=swap');

  * { box-sizing: border-box; }

  .mef-hero {
    font-family: 'DM Sans', sans-serif;
    background: #FAFAF7;
    padding: 0;
    min-height: 580px;
    position: relative;
    overflow: hidden;
  }

  .mef-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 80px 32px 48px;
    align-items: center;
  }

  .mef-left { min-width: 0; }

  .mef-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #E8F4ED;
    color: #1a3a2a;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 20px;
    margin-bottom: 20px;
    letter-spacing: 0.3px;
  }

  .mef-pill-dot {
    width: 6px;
    height: 6px;
    background: #d4a84b;
    border-radius: 50%;
  }

  .mef-h1 {
    font-family: 'Playfair Display', serif;
    font-size: 48px;
    font-weight: 700;
    color: #1a2a18;
    line-height: 1.12;
    margin: 0 0 6px;
  }

  .mef-h1 em {
    font-style: italic;
    color: #d4a84b;
  }

  .mef-tagline {
    font-size: 14px;
    color: #7a7a6a;
    font-weight: 500;
    margin: 0 0 20px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .mef-divider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 20px;
  }

  .mef-divider-line {
    flex: 1;
    max-width: 60px;
    height: 1.5px;
    background: linear-gradient(90deg, #d4a84b, transparent);
  }

  .mef-divider-diamond {
    width: 7px;
    height: 7px;
    background: #d4a84b;
    transform: rotate(45deg);
    flex-shrink: 0;
  }

  .mef-desc {
    font-size: 15px;
    line-height: 1.7;
    color: #4a4a3a;
    max-width: 440px;
    margin: 0 0 28px;
  }

  .mef-btns {
    display: flex;
    gap: 12px;
    margin-bottom: 32px;
    flex-wrap: wrap;
  }

  .mef-btn-primary,
  .mef-btn-price {
    border: none;
    padding: 13px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    flex: 1 1 200px;
    white-space: nowrap;
  }

  .mef-btn-primary {
    background: #1a3a2a;
    color: #fff;
    transition: background 0.2s;
  }

  .mef-btn-price {
    background: #d4a84b;
    color: #fff;
  }

  .mef-price-badge {
    background: #fff3;
    padding: 1px 7px;
    border-radius: 5px;
    font-size: 13px;
  }

  .mef-trust {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 16px;
  }

  .mef-trust-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #5a5a4a;
    font-weight: 500;
  }

  .mef-trust-icon {
    width: 16px;
    height: 16px;
    background: #E8F4ED;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .mef-right {
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-width: 0;
  }

  .mef-card-main {
    background: #fff;
    border: 1px solid #e8e4db;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 16px rgba(26,58,42,0.06);
  }

  .mef-card-title {
    font-size: 11px;
    font-weight: 600;
    color: #7a7a6a;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
  }

  .mef-pricing-hero {
    background: linear-gradient(135deg, #1a3a2a 0%, #2a5a3a 100%);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }

  .mef-price-main {
    color: #fff;
  }

  .mef-price-amount {
    font-family: 'Playfair Display', serif;
    font-size: 42px;
    font-weight: 700;
    color: #d4a84b;
    line-height: 1;
  }

  .mef-price-per {
    font-size: 13px;
    color: #a0c8b0;
    margin-top: 4px;
  }

  .mef-price-label {
    font-size: 16px;
    color: #fff;
    font-weight: 600;
    text-align: right;
    line-height: 1.3;
  }

  .mef-feat-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .mef-feat {
    display: flex;
    align-items: flex-start;
    gap: 10px;
  }

  .mef-feat-ic {
    width: 32px;
    height: 32px;
    background: #E8F4ED;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
  }

  .mef-feat-t {
    font-size: 13px;
    font-weight: 600;
    color: #1a2a18;
    margin-bottom: 1px;
  }

  .mef-feat-s {
    font-size: 11px;
    color: #7a7a6a;
    line-height: 1.5;
  }

  .mef-charity-strip {
    background: #fffbf0;
    border: 1px solid #f0dea0;
    border-radius: 10px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: #7a5a00;
    font-weight: 500;
    line-height: 1.5;
  }

  .mef-charity-icon {
    font-size: 18px;
    flex-shrink: 0;
  }

  .mef-stat-bar {
    background: #1a3a2a;
    padding: 20px 32px;
  }

  .mef-stats {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    text-align: center;
  }

  .mef-stat-item {
    padding: 0 16px;
    border-right: 1px solid rgba(255,255,255,0.1);
  }

  .mef-stat-item:last-child { border-right: none; }

  .mef-stat-n {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    font-weight: 700;
    color: #d4a84b;
  }

  .mef-stat-l {
    font-size: 11px;
    color: #a0c8b0;
    font-weight: 500;
    letter-spacing: 0.3px;
    margin-top: 2px;
  }

  /* ===== Tablet ===== */
  @media (max-width: 900px) {
    .mef-main {
      grid-template-columns: 1fr;
      padding: 56px 24px 40px;
      gap: 40px;
    }
    .mef-right { padding-left: 0; }
    .mef-h1 { font-size: 40px; }
    .mef-desc { max-width: 100%; }
  }

  /* ===== Mobile ===== */
  @media (max-width: 600px) {
    .mef-main { padding: 40px 16px 32px; }
    .mef-h1 { font-size: 32px; }
    .mef-tagline { font-size: 12px; }
    .mef-desc { font-size: 14px; }
    .mef-btns { flex-direction: column; }
    .mef-btn-primary, .mef-btn-price { flex: 1 1 auto; width: 100%; }
    .mef-pricing-hero { flex-direction: column; align-items: flex-start; }
    .mef-price-label { text-align: left; }
    .mef-card-main { padding: 18px; }
    .mef-stat-bar { padding: 20px 16px; }
    .mef-stats {
      grid-template-columns: repeat(2, 1fr);
      row-gap: 20px;
    }
    .mef-stat-item:nth-child(2) { border-right: none; }
    .mef-stat-item:nth-child(1),
    .mef-stat-item:nth-child(2) {
      border-bottom: 1px solid rgba(255,255,255,0.1);
      padding-bottom: 16px;
    }
    .mef-stat-n { font-size: 22px; }
  }

  @media (max-width: 380px) {
    .mef-h1 { font-size: 28px; }
    .mef-trust { gap: 8px 12px; }
  }
</style> --}}

{{-- <div class="mef-hero">
  <div class="mef-main">
    <div class="mef-left">
      <div class="mef-pill">
        <div class="mef-pill-dot"></div>
        UK Registered Charity
      </div>

      <h1 class="mef-h1">Education<br>for <em>Every</em><br>Child</h1>
      <p class="mef-tagline">Opportunity knows no boundaries</p>

      <div class="mef-divider">
        <div class="mef-divider-line"></div>
        <div class="mef-divider-diamond"></div>
      </div>

      <p class="mef-desc">
        Expert 1-to-1 online Quran lessons from qualified tutors — starting at just <strong style="color:#1a3a2a">£5 per lesson</strong>. Every fee you pay helps fund a free place for an orphaned or disadvantaged child.
      </p>

      <div class="mef-btns">
        <a href="#" class="mef-btn-primary">
          <i class="ti ti-school" aria-hidden="true" style="font-size:16px"></i>
          Book a Lesson
        </a>
        <a href="#" class="mef-btn-price">
          <i class="ti ti-star" aria-hidden="true" style="font-size:16px"></i>
          From
          <span class="mef-price-badge">£5</span>
          per session
        </a>
      </div>

      <div class="mef-trust">
        <div class="mef-trust-item">
          <div class="mef-trust-icon"><i class="ti ti-shield" aria-hidden="true" style="font-size:10px; color:#1a3a2a"></i></div>
          UK-Based Organisation
        </div>
        <div class="mef-trust-item">
          <div class="mef-trust-icon"><i class="ti ti-user-check" aria-hidden="true" style="font-size:10px; color:#1a3a2a"></i></div>
          Safeguarding First
        </div>
        <div class="mef-trust-item">
          <div class="mef-trust-icon"><i class="ti ti-certificate" aria-hidden="true" style="font-size:10px; color:#1a3a2a"></i></div>
          Qualified Tutors
        </div>
        <div class="mef-trust-item">
          <div class="mef-trust-icon"><i class="ti ti-eye" aria-hidden="true" style="font-size:10px; color:#1a3a2a"></i></div>
          Transparent Funds
        </div>
      </div>
    </div>

    <div class="mef-right">
      <div class="mef-card-main">
        <div class="mef-card-title">Quran Learning · Starting from</div>

        <div class="mef-pricing-hero">
          <div class="mef-price-main">
            <div class="mef-price-amount">£5</div>
            <div class="mef-price-per">per lesson · no hidden fees</div>
          </div>
          <div class="mef-price-label">1-to-1<br>Online Quran<br>Lessons</div>
        </div>

        <div class="mef-feat-list">
          <div class="mef-feat">
            <div class="mef-feat-ic">📖</div>
            <div>
              <div class="mef-feat-t">Qaida to Tajweed</div>
              <div class="mef-feat-s">Structured progression for all levels, beginners to advanced</div>
            </div>
          </div>
          <div class="mef-feat">
            <div class="mef-feat-ic">🕐</div>
            <div>
              <div class="mef-feat-t">Flexible scheduling</div>
              <div class="mef-feat-s">Book sessions around your family — evenings, weekends available</div>
            </div>
          </div>
          <div class="mef-feat">
            <div class="mef-feat-ic">📚</div>
            <div>
              <div class="mef-feat-t">Educational support</div>
              <div class="mef-feat-s">Literacy & numeracy programmes alongside Quran studies</div>
            </div>
          </div>
        </div>
      </div>

      <div class="mef-charity-strip">
        <div class="mef-charity-icon">🤲</div>
        <div>Your £5 lesson fee funds a <strong>free place for an orphaned child</strong> in one of our 30+ supported countries. Every lesson is sadaqah in action.</div>
      </div>
    </div>
  </div>

  <div class="mef-stat-bar">
    <div class="mef-stats">
      <div class="mef-stat-item">
        <div class="mef-stat-n">5,000+</div>
        <div class="mef-stat-l">Students Helped</div>
      </div>
      <div class="mef-stat-item">
        <div class="mef-stat-n">120+</div>
        <div class="mef-stat-l">Schools Supported</div>
      </div>
      <div class="mef-stat-item">
        <div class="mef-stat-n">30+</div>
        <div class="mef-stat-l">Countries</div>
      </div>
      <div class="mef-stat-item">
        <div class="mef-stat-n">15+</div>
        <div class="mef-stat-l">Years of Impact</div>
      </div>
    </div>
  </div>
</div> --}}
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

<div class="mef-hero" style="padding-top: 50px;">
  <div class="mef-topbar">
    <div class="mef-topbar-row">
      <div class="mef-topbar-reg"></div>
      <div class="mef-topbar-links"></div>
    </div>
  </div>

  <div class="mef-main">
    <div class="mef-left">
      <div class="mef-pill">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6v6c0 5 3.5 8.5 8 9 4.5-.5 8-4 8-9V6l-8-3Z"/></svg>
        Regulated charity, established 2011
      </div>

      <h1 class="mef-h1">Quran education, funding a free place for a child in need</h1>

      <p class="mef-desc">
        One-to-one online Quran lessons from qualified, DBS-checked tutors, starting at <strong>£5 per lesson</strong>. Every fee paid by a student directly funds a place at school for an orphaned or disadvantaged child.
      </p>

      <div class="mef-btns">
        <a href="{{ url('/prices') }}" class="mef-btn-primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
          Book a lesson
        </a>
        <a href="{{ url('/prices') }}" class="mef-btn-secondary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 21h20L12 2Z"/><path d="M12 9v5M12 17h.01"/></svg>
          View pricing
        </a>
      </div>

      <div class="mef-trust">
        <div class="mef-trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-6 8-6s8 2 8 6"/><path d="m9 10.5 1.5 1.5L15 8"/></svg>
          Safeguarding-first policy, all tutors DBS-checked
        </div>
        <div class="mef-trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="m8.5 12.5-1.5 7 5-2 5 2-1.5-7"/></svg>
          Qualified tutors, structured curriculum
        </div>
        <div class="mef-trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v18H6.5A2.5 2.5 0 0 0 4 22.5v-18Z"/><path d="M4 17.5A2.5 2.5 0 0 1 6.5 15H20"/></svg>
          Independently audited accounts, published annually
        </div>
        <div class="mef-trust-item">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"/><circle cx="12" cy="12" r="2.5"/></svg>
          Full transparency on where funds go
        </div>
      </div>
    </div>

    <div class="mef-right">
      <div class="mef-stage">
        <div class="mef-blob b1"></div>
        <div class="mef-blob b2"></div>
        <div class="mef-blob b3"></div>
        <div class="mef-orbit"></div>

        <div class="mef-frame">
          <div class="mef-frame-top">
            <div class="mef-frame-eyebrow">Learning at home</div>
            <div class="mef-frame-dots"><span></span><span></span><span></span></div>
          </div>

          <div class="mef-image-wrap">
            <img src="{{ asset('frontend/images/banner.jpg') }}">
              <div class="mef-chip-ic">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
              </div>
              {{-- DBS-checked tutors --}}
            </div>

            <div class="mef-chip c2">
              <div class="mef-chip-ic">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 13V7a2 2 0 0 1 4 0"/><path d="M12 13V6a2 2 0 0 1 4 0v7"/><path d="M16 13V8a2 2 0 0 1 4 0v6c0 4-3 7-7 7h-1c-4 0-7-2-7-5v-3a1.5 1.5 0 0 1 3 0"/></svg>
              </div>
              5,000+ students helped
            </div>
          </div>

          <div class="mef-caption">Ages 3+ · <strong>Qaida to Tajweed</strong> · fun, guided family learning</div>
        </div>
      </div>
    </div>
  </div>

  <div class="mef-stat-bar">
    <div class="mef-stats">
      <div class="mef-stat-item">
        <div class="mef-stat-n">5,000+</div>
        <div class="mef-stat-l">Students helped</div>
      </div>
      <div class="mef-stat-item">
        <div class="mef-stat-n">120+</div>
        <div class="mef-stat-l">Schools supported</div>
      </div>
      <div class="mef-stat-item">
        <div class="mef-stat-n">30+</div>
        <div class="mef-stat-l">Countries</div>
      </div>
      <div class="mef-stat-item">
        <div class="mef-stat-n">15+</div>
        <div class="mef-stat-l">Years of impact</div>
      </div>
    </div>
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
  @include('frontend.include.lessonplan')
  <!-- What We Do -->
  <section class="section-light">
    <div class="container">
      <div class="text-center mb-5" data-r="up">
        <div class="eyebrow justify-content-center"><div class="eyebrow-line"></div><span class="eyebrow-txt">What We Do</span><div class="eyebrow-line"></div></div>
        <h2 class="sec-h">Three Pillars of <em>Impact</em></h2>
        <div class="divider-gold center"></div>
        <p class="sec-p mx-auto" style="max-width:520px">Every action we take is built around education, support and charity — working together to change lives.</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-4" data-r="up"><div class="wwd-card"><div class="wwd-num">01</div><div class="wwd-ic-wrap"><i class="fas fa-quran"></i></div><h5>Online Quran Teaching</h5><p>One-to-one online Quran lessons with qualified, vetted tutors. From beginners to advanced Tajweed — tailored to every student's level and pace.</p><a class="wwd-link" href="{{ url('/prices') }}">Book a Lesson <i class="fas fa-arrow-right"></i></a></div></div>
        <div class="col-lg-4" data-r="up" style="transition-delay:.1s"><div class="wwd-card"><div class="wwd-num">02</div><div class="wwd-ic-wrap"><i class="fas fa-book-reader"></i></div><h5>Educational Support</h5><p>Structured academic support programmes for disadvantaged children — covering literacy, numeracy, and general learning tailored to need.</p><a class="wwd-link" href="{{ url('/about') }}">Learn More <i class="fas fa-arrow-right"></i></a></div></div>
        <div class="col-lg-4" data-r="up" style="transition-delay:.2s"><div class="wwd-card"><div class="wwd-num">03</div><div class="wwd-ic-wrap"><i class="fas fa-hand-holding-heart"></i></div><h5>Charity & Sponsorship</h5><p>Funding free education for orphaned and disadvantaged children globally. Every pound donated is tracked, reported, and used with full accountability.</p><a class="wwd-link" href="{{ url('/donate') }}">Donate Now <i class="fas fa-arrow-right"></i></a></div></div>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="section-cream">
    <div class="container">
      <div class="text-center mb-5" data-r="up">
        <div class="eyebrow justify-content-center"><div class="eyebrow-line"></div><span class="eyebrow-txt">Simple Process</span><div class="eyebrow-line"></div></div>
        <h2 class="sec-h">How It <em>Works</em></h2>
        <div class="divider-gold center"></div>
      </div>
      <div class="row g-4 justify-content-center">
        <div class="col-lg-3 col-6 position-relative" data-r="up">
          <div class="step-card"><div class="step-num">01</div><div class="step-ic"><i class="fas fa-file-alt"></i></div><h5>Fill Enquiry Form</h5><p>Complete our short form with your child's details and preferred schedule.</p></div>
          <div class="step-connector d-none d-lg-block"></div>
        </div>
        <div class="col-lg-3 col-6 position-relative" data-r="up" style="transition-delay:.1s">
          <div class="step-card"><div class="step-num">02</div><div class="step-ic"><i class="fas fa-comments"></i></div><h5>Free Consultation</h5><p>We'll contact you to discuss your child's needs and offer a free trial lesson.</p></div>
          <div class="step-connector d-none d-lg-block"></div>
        </div>
        <div class="col-lg-3 col-6 position-relative" data-r="up" style="transition-delay:.2s">
          <div class="step-card"><div class="step-num">03</div><div class="step-ic"><i class="fas fa-chalkboard-teacher"></i></div><h5>Trial Session</h5><p>Your child meets their tutor and experiences a taster lesson — completely free.</p></div>
          <div class="step-connector d-none d-lg-block"></div>
        </div>
        <div class="col-lg-3 col-6" data-r="up" style="transition-delay:.3s">
          <div class="step-card"><div class="step-num">04</div><div class="step-ic"><i class="fas fa-rocket"></i></div><h5>Begin Learning</h5><p>Start your regular lessons and watch your child's knowledge and confidence grow.</p></div>
        </div>
      </div>
      <div class="text-center mt-5" data-r="up">
        <a class="btn-gold" href="{{ url('/prices') }}"><i class="fas fa-graduation-cap"></i>Book a Lesson Today</a>
      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section class="section-light">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-5" data-r="left">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Why Choose Us</span></div>
          <h2 class="sec-h">The Merit<br><em>Difference</em></h2>
          <div class="divider-gold"></div>
          <p class="sec-p mb-4">We're not just a tutoring service. Every lesson you pay for contributes to a child who cannot afford one — making us unique in the education charity space.</p>
          <div style="background:var(--gold-pale);border:1px solid rgba(201,168,76,.25);border-radius:12px;padding:18px 20px;display:flex;align-items:flex-start;gap:12px">
            <i class="fas fa-quote-left" style="color:var(--gold);font-size:1.2rem;margin-top:3px"></i>
            <p style="font-size:.85rem;font-style:italic;color:var(--navy);margin:0;line-height:1.7">"Every lesson booked is a lesson donated. Education for the few funds education for all."</p>
          </div>
        </div>
        <div class="col-lg-7" data-r="right">
          <div class="why-row"><div class="why-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-user-shield" style="color:var(--gold)"></i></div><div><h6>Safeguarding at Every Level</h6><p>All tutors are DBS checked. Our full safeguarding policy protects every child in our programmes. Parents have full oversight.</p></div></div>
          <div class="why-row"><div class="why-ic" style="background:rgba(15,31,92,.07)"><i class="fas fa-certificate" style="color:var(--navy)"></i></div><div><h6>Qualified, Vetted Tutors</h6><p>Our tutors hold recognised Quranic qualifications and undergo rigorous screening before joining the Merit team.</p></div></div>
          <div class="why-row"><div class="why-ic" style="background:rgba(13,107,99,.1)"><i class="fas fa-clock" style="color:var(--teal)"></i></div><div><h6>Flexible Scheduling</h6><p>Lessons are available 7 days a week with morning, afternoon and evening slots — designed around your family's life.</p></div></div>
          <div class="why-row"><div class="why-ic" style="background:rgba(201,168,76,.1)"><i class="fas fa-chart-pie" style="color:var(--gold)"></i></div><div><h6>Education + Charity Combined</h6><p>Your lesson fee covers the service. Optional donations (Gift Aid eligible) go directly to supporting disadvantaged children.</p></div></div>
          <div class="why-row"><div class="why-ic" style="background:rgba(15,31,92,.07)"><i class="fas fa-globe" style="color:var(--navy)"></i></div><div><h6>Global Impact, Local Standards</h6><p>UK-based and UK-regulated, with programmes reaching children across 30+ countries worldwide.</p></div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Safeguarding Highlight -->
  <section>
    <div class="container">
      <div class="safeguard-box" data-r="up">
        <div class="row align-items-center g-4 position-relative">
          <div class="col-lg-8">
            <div class="safeguard-badge"><i class="fas fa-shield-alt"></i>Safeguarding Commitment</div>
            <h2 class="display-h" style="font-size:clamp(1.8rem,3.5vw,2.6rem);color:var(--white);margin-bottom:16px">Your Child's Safety<br>is Our <em>Top Priority</em></h2>
            <p style="font-size:.9rem;color:rgba(255,255,255,.6);line-height:1.8;max-width:580px;font-weight:300">All Merit tutors are DBS checked, and our platform operates under a robust safeguarding policy. Parents can observe lessons at any time. We follow UK safeguarding guidelines strictly — because trust is everything.</p>
          </div>
          <div class="col-lg-4 text-lg-end">
            <a class="btn-gold" href="{{ url('/safeguarding-policy') }}"><i class="fas fa-shield-alt"></i>Read Our Policy</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- CTA -->
  <div class="cta-block">
    <div class="container"><div class="inner">
      <div class="row align-items-center g-4">
        <div class="col-lg-7" data-r="left">
          <h2 class="display-h" style="font-size:clamp(1.8rem,4vw,2.8rem);color:var(--navy)">Ready to Begin Your Child's<br>Learning Journey?</h2>
          <p style="color:rgba(15,31,92,.6);font-size:.95rem;margin-top:10px;font-weight:300;max-width:440px">Join hundreds of families who trust Merit Education Foundation for quality Quran teaching — and help us change a life along the way.</p>
        </div>
        <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end" data-r="right">
          <a class="btn-navy" href="{{ url('/prices') }}"><i class="fas fa-graduation-cap"></i>Book a Lesson</a>
          <a class="btn-outline-gold" href="{{ url('/donate') }}"><i class="fas fa-heart"></i>Donate Now</a>
        </div>
      </div>
    </div></div>
  </div>
</div><!-- end home -->

<!-- ══════════════ FOOTER ══════════════ -->
    <script>
        /* ── Loader */
        window.addEventListener('load', () => setTimeout(() => document.getElementById('loader').classList.add('done'),
            1000));

        /* ── Navbar scroll */
        window.addEventListener('scroll', () => {
            document.getElementById('nav').classList.toggle('scrolled', scrollY > 50);
            document.getElementById('btt').classList.toggle('show', scrollY > 350);
        });

        /* ── Mobile nav */
        document.querySelectorAll('.mob-lnk').forEach(l => l.addEventListener('click', () => document.querySelector(
            '.mob-menu').classList.remove('open')));

        /* ── Scroll reveal */
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('on');
                    io.unobserve(e.target)
                }
            });
        }, {
            threshold: .08
        });
        document.querySelectorAll('[data-r]').forEach(el => io.observe(el));

        /* ────────────────────────────
           CATEGORY TABS
        ──────────────────────────── */
        let activeCat = '30min';

        function switchCat(cat, btn) {
            // Hide all categories
            document.querySelectorAll('.plans-category').forEach(c => c.classList.remove('active'));
            // Show target
            document.getElementById('cat-' + cat).classList.add('active');
            // Update tab buttons
            document.querySelectorAll('.cat-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCat = cat;
        }

        /* ────────────────────────────
           BILLING TOGGLE
        ──────────────────────────── */
        function toggleBilling(chk) {
            const isAnnual = chk.checked;
            document.getElementById('lbl-monthly').classList.toggle('active', !isAnnual);
            document.getElementById('lbl-annual').classList.toggle('active', isAnnual);
            // Toggle price displays
            document.querySelectorAll('.plan-monthly-price').forEach(el => el.style.display = isAnnual ? 'none' : '');
            document.querySelectorAll('.plan-annual-price').forEach(el => el.style.display = isAnnual ? '' : 'none');
            document.querySelectorAll('.plan-monthly-text').forEach(el => el.style.display = isAnnual ? 'none' : '');
            document.querySelectorAll('.plan-annual-text').forEach(el => el.style.display = isAnnual ? '' : 'none');
        }

        /* ────────────────────────────
           PLAN SELECTION
        ──────────────────────────── */
        let selectedPlan = {
            name: '',
            price: '',
            duration: '',
            days: '',
            billing: 'monthly'
        };

        function selectPlan(card, name, price, billing, duration, days) {
            // Deselect all in current category
            const cat = document.getElementById('cat-' + activeCat);
            cat.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
            // Select this card
            card.classList.add('selected');
            // Billing adjust for annual toggle
            const isAnnual = document.getElementById('billing-toggle').checked;
            const priceNum = parseFloat(price.replace('£', ''));
            const finalPrice = isAnnual ? '£' + (priceNum * .8).toFixed(2) + '/mo' : price + '/mo';
            // Store
            selectedPlan = {
                name,
                price: finalPrice,
                duration,
                days,
                billing: isAnnual ? 'annually' : 'monthly'
            };
            // Update selected bar for this category
            const bar = document.getElementById('selected-bar-' + activeCat);
            if (bar) {
                bar.classList.add('show');
                document.getElementById('selected-name-' + activeCat).textContent = name;
                document.getElementById('selected-price-' + activeCat).textContent = finalPrice;
            }
            // Update form summary hidden fields
            document.getElementById('selected_plan_name').value = name;
            document.getElementById('selected_plan_price').value = finalPrice;
            document.getElementById('selected_plan_duration').value = duration;
            document.getElementById('selected_plan_days').value = days;
            document.getElementById('selected_plan_billing').value = selectedPlan.billing;
            // Update form plan summary
            const summary = document.getElementById('form-plan-summary');
            summary.classList.add('show');
            document.getElementById('form-plan-name').textContent = name;
            document.getElementById('form-plan-price').textContent = finalPrice;
            document.getElementById('form-plan-duration').textContent = duration;
            document.getElementById('form-plan-days').textContent = days;
            document.getElementById('form-plan-billing').textContent = 'Billed ' + selectedPlan.billing;
            // Update CTA buttons in all plan cards
            const allBtns = document.getElementById('cat-' + activeCat).querySelectorAll('.btn-plan');
            allBtns.forEach(b => {
                b.innerHTML = b.closest('.plan-card') === card ?
                    '<i class="fas fa-check"></i>Plan Selected' :
                    '<i class="fas fa-graduation-cap"></i>Choose Plan';
            });
        }

        function scrollToForm() {
            document.getElementById('booking-form-section').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function scrollToPricing() {
            document.getElementById('pricing-section').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        /* ── Form Submit */
        function submitBookForm() {
            // Basic validation
            const required = ['parent_name', 'student_name', 'student_age', 'preferred_time', 'location', 'email'];
            let valid = true;
            required.forEach(name => {
                const el = document.querySelector('[name="' + name + '"]');
                if (el && !el.value.trim()) {
                    el.style.borderColor = 'var(--red)';
                    valid = false;
                } else if (el) {
                    el.style.borderColor = 'var(--border)';
                }
            });
            if (!valid) {
                alert('Please fill in all required fields.');
                return;
            }
            document.getElementById('book-form-body').style.display = 'none';
            document.getElementById('book-success').style.display = 'block';
        }
    </script>
    @if(url()->current() == url('/'))
    @include('frontend.partials.trial-modal')
@endif
    <script>
document.addEventListener("DOMContentLoaded", function () {

    if (!localStorage.getItem("trial_popup_shown")) {

        setTimeout(function () {
            document.getElementById("trialModal").style.display = "flex";
            localStorage.setItem("trial_popup_shown", "yes");
        }, 10000);

    }

    document.getElementById("closeTrialModal").onclick = function () {
        document.getElementById("trialModal").style.display = "none";
    };

    document.getElementById("trialModal").onclick = function (e) {
        if (e.target === this) {
            this.style.display = "none";
        }
    };

});
</script>
@endsection