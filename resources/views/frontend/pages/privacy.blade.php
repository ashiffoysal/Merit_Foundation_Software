@extends('layouts.frontend')
@section('content')
<style>
.page-hero{padding:145px 0 75px;background:var(--dark);position:relative;overflow:hidden}
.page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 80% at 50% 40%,rgba(26,46,122,.85),transparent 65%)}
.page-hero::after{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);background-size:64px 64px}
.ph-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(201,168,76,.12);border:1px solid rgba(201,168,76,.28);border-radius:30px;padding:6px 18px;margin-bottom:18px;position:relative;z-index:1}
.ph-badge span{font-size:.68rem;color:var(--gold);letter-spacing:2.5px;text-transform:uppercase;font-weight:600}
.ph-h{font-family:'Cormorant Garamond',serif;font-size:clamp(2.4rem,5.5vw,4rem);font-weight:700;color:var(--white);line-height:1;position:relative;z-index:1}
.ph-h em{font-style:italic;color:var(--gold)}
.ph-p{font-size:.95rem;color:rgba(255,255,255,.48);line-height:1.8;font-weight:300;position:relative;z-index:1;max-width:530px;margin-top:14px}
/* ════════════════════════════════════════
   PRIVACY POLICY
════════════════════════════════════════ */
.policy-nav{position:sticky;top:86px;z-index:700}
.pn-item{display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:9px;font-size:.8rem;color:var(--muted);cursor:pointer;transition:.3s;margin-bottom:4px}
.pn-item:hover,.pn-item.active{background:var(--gold-pale);color:var(--navy);font-weight:600}
.pn-item i{font-size:.7rem;color:var(--gold)}
.policy-section{margin-bottom:48px;scroll-margin-top:120px}
.ps-h{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:12px}
.ps-h i{font-size:1.1rem;color:var(--gold)}
.ps-p,.ps-li{font-size:.88rem;color:var(--muted);line-height:1.85}
.ps-li{margin-bottom:10px;display:flex;align-items:flex-start;gap:9px}
.ps-li i{color:var(--gold);font-size:.65rem;margin-top:5px;flex-shrink:0}
.ps-box{background:var(--cream);border:1px solid var(--border);border-left:3px solid var(--gold);border-radius:0 10px 10px 0;padding:18px 20px;margin:20px 0}
.ps-box p{font-size:.83rem;color:var(--txt);margin:0;line-height:1.75}
.toc-meta{background:var(--navy);border-radius:14px;padding:24px 22px}
.toc-meta p{font-size:.78rem;color:rgba(255,255,255,.4);margin-bottom:8px;line-height:1.5}
.toc-meta p strong{color:var(--gold)}
</style>


<!-- ════════════════════════════════════════
     PRIVACY POLICY PAGE
════════════════════════════════════════ -->
<div>

  <div class="page-hero">
    <div class="container position-relative" style="z-index:2">
      <div class="ph-badge"><span>Legal</span></div>
      <h1 class="ph-h">Privacy <em>Policy</em></h1>
      <p class="ph-p">How Merit Education Foundation collects, uses, and protects your personal data — in plain English.</p>
      <div style="display:flex;align-items:center;gap:20px;margin-top:20px;position:relative;z-index:1;flex-wrap:wrap">
        <span style="font-size:.73rem;color:rgba(255,255,255,.38);display:flex;align-items:center;gap:7px"><i class="fas fa-calendar" style="color:var(--gold)"></i>Last updated: 1 November 2025</span>
        <span style="font-size:.73rem;color:rgba(255,255,255,.38);display:flex;align-items:center;gap:7px"><i class="fas fa-shield-alt" style="color:var(--gold)"></i>UK GDPR Compliant</span>
        <span style="font-size:.73rem;color:rgba(255,255,255,.38);display:flex;align-items:center;gap:7px"><i class="fas fa-file-alt" style="color:var(--gold)"></i>~12 min read</span>
      </div>
    </div>
  </div>

  <section style="padding:70px 0 100px;background:var(--cream)">
    <div class="container">
      <div class="row g-5">

        <!-- Sticky TOC -->
        <div class="col-lg-3 d-none d-lg-block">
          <div class="policy-nav">
            <div style="font-size:.62rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:14px;padding:0 14px">Contents</div>
            <div class="pn-item active" onclick="scrollToSection('overview')"><i class="fas fa-info-circle"></i>Overview</div>
            <div class="pn-item" onclick="scrollToSection('collect')"><i class="fas fa-database"></i>Data We Collect</div>
            <div class="pn-item" onclick="scrollToSection('use')"><i class="fas fa-cogs"></i>How We Use Data</div>
            <div class="pn-item" onclick="scrollToSection('share')"><i class="fas fa-share-alt"></i>Sharing Data</div>
            <div class="pn-item" onclick="scrollToSection('cookies')"><i class="fas fa-cookie-bite"></i>Cookies</div>
            <div class="pn-item" onclick="scrollToSection('rights')"><i class="fas fa-user-check"></i>Your Rights</div>
            <div class="pn-item" onclick="scrollToSection('children')"><i class="fas fa-child"></i>Children's Privacy</div>
            <div class="pn-item" onclick="scrollToSection('security')"><i class="fas fa-lock"></i>Security</div>
            <div class="pn-item" onclick="scrollToSection('contact-priv')"><i class="fas fa-envelope"></i>Contact DPO</div>
            <div class="toc-meta mt-3">
              <p><strong>Version:</strong> 3.2</p>
              <p><strong>Effective:</strong> 1 Nov 2025</p>
              <p><strong>Next review:</strong> 1 Nov 2026</p>
            </div>
          </div>
        </div>

        <!-- Policy Content -->
        <div class="col-lg-9">

          <div class="policy-section" id="overview" data-r="up">
            <h3 class="ps-h"><i class="fas fa-info-circle"></i>1. Overview</h3>
            <p class="ps-p">Merit Education Foundation ("we", "our", "us") is committed to protecting the privacy of all individuals who interact with our website, services and charitable programmes. This Privacy Policy explains what personal data we collect, why we collect it, how we use it, and your rights regarding that data.</p>
            <div class="ps-box mt-3"><p>This policy applies to all users of meriteducation.org, parents and guardians who book lessons, donors, volunteers, and students enrolled in our programmes. It complies with the <strong>UK General Data Protection Regulation (UK GDPR)</strong> and the <strong>Data Protection Act 2018</strong>.</p></div>
          </div>

          <div class="policy-section" id="collect" data-r="up">
            <h3 class="ps-h"><i class="fas fa-database"></i>2. Data We Collect</h3>
            <p class="ps-p mb-3">We collect different types of personal data depending on your interaction with us:</p>
            <p class="ps-p"><strong style="color:var(--navy)">Account & Registration Data:</strong></p>
            <div class="ps-li"><i class="fas fa-circle"></i>Name, email address, phone number and address</div>
            <div class="ps-li"><i class="fas fa-circle"></i>Password (stored in encrypted form only — we cannot see it)</div>
            <div class="ps-li"><i class="fas fa-circle"></i>Profile photo (optional)</div>
            <p class="ps-p mt-3"><strong style="color:var(--navy)">Student Data (collected from parents/guardians):</strong></p>
            <div class="ps-li"><i class="fas fa-circle"></i>Student name and age</div>
            <div class="ps-li"><i class="fas fa-circle"></i>Current learning level and academic history</div>
            <div class="ps-li"><i class="fas fa-circle"></i>Progress reports and lesson notes</div>
            <p class="ps-p mt-3"><strong style="color:var(--navy)">Donation & Financial Data:</strong></p>
            <div class="ps-li"><i class="fas fa-circle"></i>Donation amounts and frequency</div>
            <div class="ps-li"><i class="fas fa-circle"></i>Gift Aid declarations (UK taxpayer status)</div>
            <div class="ps-li"><i class="fas fa-circle"></i>Payment information (processed by secure third-party providers — we do not store card details)</div>
          </div>

          <div class="policy-section" id="use" data-r="up">
            <h3 class="ps-h"><i class="fas fa-cogs"></i>3. How We Use Your Data</h3>
            <p class="ps-p mb-3">We use your personal data only for legitimate purposes, including:</p>
            <div class="ps-li"><i class="fas fa-check"></i>Providing and managing lesson bookings</div>
            <div class="ps-li"><i class="fas fa-check"></i>Processing donations and issuing Gift Aid declarations</div>
            <div class="ps-li"><i class="fas fa-check"></i>Communicating lesson schedules, updates and reports</div>
            <div class="ps-li"><i class="fas fa-check"></i>Ensuring safeguarding compliance for all students</div>
            <div class="ps-li"><i class="fas fa-check"></i>Sending newsletters (only where you have consented)</div>
            <div class="ps-li"><i class="fas fa-check"></i>Improving our services and website</div>
            <div class="ps-box mt-3"><p><strong>Legal basis:</strong> We rely on <em>contract performance, legitimate interests, legal obligation, and consent</em> as our legal bases for processing data under UK GDPR Article 6.</p></div>
          </div>

          <div class="policy-section" id="share" data-r="up">
            <h3 class="ps-h"><i class="fas fa-share-alt"></i>4. Sharing Your Data</h3>
            <p class="ps-p">We do not sell, rent or trade your personal data. We may share your data only in the following limited circumstances:</p>
            <div class="ps-li"><i class="fas fa-circle"></i><strong>Tutors:</strong> Assigned tutors receive student names, learning level and lesson schedules only</div>
            <div class="ps-li"><i class="fas fa-circle"></i><strong>Payment processors:</strong> Stripe or PayPal for secure payment processing</div>
            <div class="ps-li"><i class="fas fa-circle"></i><strong>HMRC:</strong> For Gift Aid claims (name and address only, with your declaration)</div>
            <div class="ps-li"><i class="fas fa-circle"></i><strong>Legal authorities:</strong> Only where required by law or to protect child safety</div>
          </div>

          <div class="policy-section" id="cookies" data-r="up">
            <h3 class="ps-h"><i class="fas fa-cookie-bite"></i>5. Cookies</h3>
            <p class="ps-p mb-3">We use cookies to improve your experience on our website. You can manage your preferences at any time.</p>
            <div style="background:var(--white);border:1px solid var(--border);border-radius:12px;overflow:hidden">
              <div style="display:grid;grid-template-columns:1fr 1fr 2fr;background:var(--navy);padding:12px 16px">
                <span style="font-size:.7rem;font-weight:700;color:var(--gold);letter-spacing:1px">TYPE</span>
                <span style="font-size:.7rem;font-weight:700;color:var(--gold);letter-spacing:1px">PURPOSE</span>
                <span style="font-size:.7rem;font-weight:700;color:var(--gold);letter-spacing:1px">DURATION</span>
              </div>
              <div style="display:grid;grid-template-columns:1fr 1fr 2fr;padding:12px 16px;border-bottom:1px solid var(--border)"><span style="font-size:.8rem;color:var(--navy);font-weight:600">Essential</span><span style="font-size:.8rem;color:var(--muted)">Login sessions</span><span style="font-size:.8rem;color:var(--muted)">Session</span></div>
              <div style="display:grid;grid-template-columns:1fr 1fr 2fr;padding:12px 16px;border-bottom:1px solid var(--border)"><span style="font-size:.8rem;color:var(--navy);font-weight:600">Analytics</span><span style="font-size:.8rem;color:var(--muted)">Usage tracking</span><span style="font-size:.8rem;color:var(--muted)">2 years</span></div>
              <div style="display:grid;grid-template-columns:1fr 1fr 2fr;padding:12px 16px"><span style="font-size:.8rem;color:var(--navy);font-weight:600">Marketing</span><span style="font-size:.8rem;color:var(--muted)">Campaign tracking</span><span style="font-size:.8rem;color:var(--muted)">90 days</span></div>
            </div>
          </div>

          <div class="policy-section" id="rights" data-r="up">
            <h3 class="ps-h"><i class="fas fa-user-check"></i>6. Your Rights</h3>
            <p class="ps-p mb-3">Under UK GDPR, you have the following rights regarding your personal data:</p>
            <div class="ps-li"><i class="fas fa-check"></i><strong>Right of access</strong> — request a copy of your data</div>
            <div class="ps-li"><i class="fas fa-check"></i><strong>Right to rectification</strong> — correct inaccurate data</div>
            <div class="ps-li"><i class="fas fa-check"></i><strong>Right to erasure</strong> — request deletion of your data</div>
            <div class="ps-li"><i class="fas fa-check"></i><strong>Right to restrict processing</strong></div>
            <div class="ps-li"><i class="fas fa-check"></i><strong>Right to data portability</strong></div>
            <div class="ps-li"><i class="fas fa-check"></i><strong>Right to object</strong> to processing based on legitimate interests</div>
            <p class="ps-p mt-3">To exercise any of these rights, contact our Data Protection Officer at <strong style="color:var(--gold)">dpo@meriteducation.org</strong>. We will respond within 30 days.</p>
          </div>

          <div class="policy-section" id="children" data-r="up">
            <h3 class="ps-h"><i class="fas fa-child"></i>7. Children's Privacy</h3>
            <p class="ps-p">We take children's privacy extremely seriously. All student data is provided by a parent or legal guardian — we do not collect data directly from children under 16. Student data is used solely for educational purposes and is never shared with third parties without parental consent.</p>
            <div class="ps-box mt-3"><p>All tutors are DBS checked and operate under our Safeguarding Policy. Parents can request deletion of their child's data at any time by contacting us at <strong>safeguarding@meriteducation.org</strong>.</p></div>
          </div>

          <div class="policy-section" id="security" data-r="up">
            <h3 class="ps-h"><i class="fas fa-lock"></i>8. Security</h3>
            <p class="ps-p">We use industry-standard security measures to protect your personal data, including SSL encryption, access controls, and regular security audits. In the unlikely event of a data breach, we will notify affected users and the ICO within 72 hours as required by UK GDPR.</p>
          </div>

          <div class="policy-section" id="contact-priv" data-r="up">
            <h3 class="ps-h"><i class="fas fa-envelope"></i>9. Contact Our DPO</h3>
            <p class="ps-p">If you have any questions, concerns, or wish to exercise your data rights:</p>
            <div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px;margin-top:20px;display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap">
              <div style="flex:1"><h6 style="font-size:.85rem;font-weight:700;color:var(--navy);margin-bottom:12px">Data Protection Officer</h6><p style="font-size:.82rem;color:var(--muted);margin-bottom:6px;display:flex;gap:9px;align-items:center"><i class="fas fa-envelope" style="color:var(--gold)"></i>dpo@meriteducation.org</p><p style="font-size:.82rem;color:var(--muted);display:flex;gap:9px;align-items:center"><i class="fas fa-map-marker-alt" style="color:var(--gold)"></i>Merit Education Foundation, London, UK</p></div>
              <button class="btn-navy btn-sm" onclick="showPage('page-contact')"><i class="fas fa-paper-plane"></i>Send Message</button>
            </div>
            <p class="ps-p mt-3">You also have the right to lodge a complaint with the <strong>Information Commissioner's Office (ICO)</strong> at ico.org.uk if you are unhappy with how we handle your data.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div><!-- end privacy -->


@endsection