@extends('layouts.frontend')
@section('content')
  <!-- Hero -->
  <section class="hero">
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
            <button class="btn-gold" onclick="showPage('book')"><i class="fas fa-graduation-cap"></i>Book a Lesson</button>
            <button class="btn-outline-white" onclick="showPage('donate')"><i class="fas fa-heart"></i>Donate</button>
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
              <button class="btn-sm-gold" onclick="showPage('about')">Our Story <i class="fas fa-arrow-right"></i></button>
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
  </section>
  <!-- About Summary -->
  <section class="section-cream">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-5" data-r="left">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Who We Are</span></div>
          <h2 class="sec-h">Education &<br><em>Charity Combined</em></h2>
          <div class="divider-gold"></div>
          <p class="sec-p mb-4">Merit Education Foundation is a UK-based non-profit combining premium online Quran teaching with a charitable mission. Lesson fees directly fund free education for children who cannot afford it — creating a self-sustaining cycle of impact.</p>
          <button class="btn-navy" onclick="showPage('about')">Learn More <i class="fas fa-arrow-right ms-1"></i></button>
        </div>
        <div class="col-lg-7" data-r="right">
          <div class="row g-3">
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
        <div class="col-lg-4" data-r="up"><div class="wwd-card"><div class="wwd-num">01</div><div class="wwd-ic-wrap"><i class="fas fa-quran"></i></div><h5>Online Quran Teaching</h5><p>One-to-one online Quran lessons with qualified, vetted tutors. From beginners to advanced Tajweed — tailored to every student's level and pace.</p><span class="wwd-link" onclick="showPage('book')">Book a Lesson <i class="fas fa-arrow-right"></i></span></div></div>
        <div class="col-lg-4" data-r="up" style="transition-delay:.1s"><div class="wwd-card"><div class="wwd-num">02</div><div class="wwd-ic-wrap"><i class="fas fa-book-reader"></i></div><h5>Educational Support</h5><p>Structured academic support programmes for disadvantaged children — covering literacy, numeracy, and general learning tailored to need.</p><span class="wwd-link" onclick="showPage('about')">Learn More <i class="fas fa-arrow-right"></i></span></div></div>
        <div class="col-lg-4" data-r="up" style="transition-delay:.2s"><div class="wwd-card"><div class="wwd-num">03</div><div class="wwd-ic-wrap"><i class="fas fa-hand-holding-heart"></i></div><h5>Charity & Sponsorship</h5><p>Funding free education for orphaned and disadvantaged children globally. Every pound donated is tracked, reported, and used with full accountability.</p><span class="wwd-link" onclick="showPage('donate')">Donate Now <i class="fas fa-arrow-right"></i></span></div></div>
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
        <button class="btn-gold" onclick="showPage('book')"><i class="fas fa-graduation-cap"></i>Book a Lesson Today</button>
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
            <button class="btn-gold" onclick="showPage('safeguarding')"><i class="fas fa-shield-alt"></i>Read Our Policy</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Impact Numbers -->
  <div class="impact-strip">
    <div class="container">
      <div class="row align-items-center justify-content-between g-4 position-relative">
        <div class="col text-center" data-r="up"><div class="impact-num">5,000+</div><div class="impact-lbl">Students Helped</div></div>
        <div class="col-auto d-none d-md-block"><div class="impact-sep"></div></div>
        <div class="col text-center" data-r="up" style="transition-delay:.1s"><div class="impact-num">£250K+</div><div class="impact-lbl">Scholarships Funded</div></div>
        <div class="col-auto d-none d-md-block"><div class="impact-sep"></div></div>
        <div class="col text-center" data-r="up" style="transition-delay:.2s"><div class="impact-num">30+</div><div class="impact-lbl">Countries Reached</div></div>
        <div class="col-auto d-none d-md-block"><div class="impact-sep"></div></div>
        <div class="col text-center" data-r="up" style="transition-delay:.3s"><div class="impact-num">100%</div><div class="impact-lbl">Donation Transparency</div></div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="cta-block">
    <div class="container"><div class="inner">
      <div class="row align-items-center g-4">
        <div class="col-lg-7" data-r="left">
          <h2 class="display-h" style="font-size:clamp(1.8rem,4vw,2.8rem);color:var(--navy)">Ready to Begin Your Child's<br>Learning Journey?</h2>
          <p style="color:rgba(15,31,92,.6);font-size:.95rem;margin-top:10px;font-weight:300;max-width:440px">Join hundreds of families who trust Merit Education Foundation for quality Quran teaching — and help us change a life along the way.</p>
        </div>
        <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end" data-r="right">
          <button class="btn-navy" onclick="showPage('book')"><i class="fas fa-graduation-cap"></i>Book a Lesson</button>
          <button class="btn-outline-gold" onclick="showPage('donate')"><i class="fas fa-heart"></i>Donate Now</button>
        </div>
      </div>
    </div></div>
  </div>
</div><!-- end home -->

<!-- ══════════════════════════════════════
   ABOUT PAGE
══════════════════════════════════════ -->
@include('frontend.include.about')

<!-- ══════════════════════════════════════
   BOOK LESSON PAGE
══════════════════════════════════════ -->
@include('frontend.include.booklesson')
<!-- ══════════════════════════════════════
   DONATE PAGE
══════════════════════════════════════ -->
@include('frontend.include.donate')

<!-- ══════════════════════════════════════
   SAFEGUARDING PAGE
══════════════════════════════════════ -->
@include('frontend.include.safeguarding')
<!-- ══════════════════════════════════════
   CONTACT PAGE
══════════════════════════════════════ -->
@include('frontend.include.contact')
<!-- ══════════════ FOOTER ══════════════ -->
@endsection