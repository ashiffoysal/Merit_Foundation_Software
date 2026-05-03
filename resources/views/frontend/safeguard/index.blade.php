@extends('layouts.frontend')
@section('content')

  <div class="safe-hero">
    <div class="container position-relative" style="z-index:2">
      <div class="page-hero-badge"><span>Safeguarding</span></div>
      <h1 class="page-hero-h mb-3"><em>Safeguarding</em> Policy</h1>
      <p class="page-hero-p">The safety and wellbeing of every child in our care is non-negotiable. Read our full commitment to safeguarding below.</p>
    </div>
  </div>
  <section class="section-cream">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-8" data-r="left">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Our Policy</span></div>
          <h2 class="sec-h mb-4">Child Safety <em>First</em></h2>

          <div class="policy-block"><h4><i class="fas fa-shield-alt"></i>Statement of Commitment</h4><p>Merit Education Foundation is committed to safeguarding the welfare of all children and young people who participate in our programmes. We believe every child deserves to learn in a safe, respectful environment free from harm, abuse or exploitation. This policy applies to all staff, volunteers, tutors and anyone acting on behalf of the Foundation.</p></div>

          <div class="policy-block"><h4><i class="fas fa-users-cog"></i>Tutor Screening & DBS Checks</h4><p>All tutors and staff undergo the following before working with children:</p><ul><li>Enhanced DBS (Disclosure and Barring Service) check</li><li>Identity and qualification verification</li><li>Reference checks from previous employers or educators</li><li>Safeguarding training and induction</li><li>Ongoing monitoring and annual review</li></ul></div>

          <div class="policy-block"><h4><i class="fas fa-video"></i>Online Lesson Safety</h4><p>All lessons are conducted via approved, secure video platforms. The following safeguards are in place:</p><ul><li>All sessions are recorded with parent consent</li><li>No private messaging between tutor and student</li><li>Parents may observe any lesson at any time</li><li>Cameras must remain on during lessons</li><li>No personal information shared outside the platform</li></ul></div>

          <div class="policy-block"><h4><i class="fas fa-exclamation-triangle"></i>Reporting Concerns</h4><p>Any concern relating to a child's safety must be reported immediately. Staff and tutors are trained to recognise signs of abuse or neglect. If you have a concern as a parent or member of the public:</p><ul><li>Contact our Designated Safeguarding Lead (DSL) directly</li><li>Email: safeguarding@meriteducation.org</li><li>Phone: +44 20 0000 0000 (Mon–Fri, 9am–6pm)</li><li>In an emergency, always contact local police or social services first</li></ul></div>

          <div class="policy-block"><h4><i class="fas fa-file-contract"></i>GDPR & Data Protection</h4><p>All personal data relating to children and families is handled in accordance with the UK GDPR and Data Protection Act 2018. Data is stored securely, used only for educational purposes, and never shared with third parties without explicit consent.</p></div>
        </div>
        <div class="col-lg-4" data-r="right">
          <div class="concern-box mb-4">
            <div style="position:relative;z-index:1">
              <div class="safeguard-badge" style="margin-bottom:16px"><i class="fas fa-phone-alt"></i>Report a Concern</div>
              <h4 class="serif" style="font-size:1.3rem;color:var(--white);margin-bottom:12px">Have a Safeguarding Concern?</h4>
              <p style="font-size:.82rem;color:rgba(255,255,255,.55);margin-bottom:20px;line-height:1.7">Contact our Designated Safeguarding Lead immediately. All reports are treated confidentially and seriously.</p>
              <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:16px;margin-bottom:12px"><div style="font-size:.65rem;letter-spacing:2px;color:rgba(255,255,255,.35);margin-bottom:4px;text-transform:uppercase">DSL Email</div><div style="font-size:.85rem;color:var(--white);font-weight:500">safeguarding@meriteducation.org</div></div>
              <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:16px;margin-bottom:16px"><div style="font-size:.65rem;letter-spacing:2px;color:rgba(255,255,255,.35);margin-bottom:4px;text-transform:uppercase">Phone</div><div style="font-size:.85rem;color:var(--white);font-weight:500">+44 20 0000 0000</div></div>
              <button class="btn-gold" style="width:100%;justify-content:center" onclick="showPage('contact')"><i class="fas fa-envelope"></i>Contact Us</button>
            </div>
          </div>
          <div style="background:var(--white);border:1px solid var(--border);border-radius:14px;padding:24px">
            <h5 style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;color:var(--navy);margin-bottom:16px">Quick Summary for Parents</h5>
            <ul style="list-style:none;padding:0">
              <li style="font-size:.8rem;color:var(--muted);margin-bottom:10px;display:flex;gap:9px;align-items:flex-start"><i class="fas fa-check-circle" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>All tutors are DBS checked</li>
              <li style="font-size:.8rem;color:var(--muted);margin-bottom:10px;display:flex;gap:9px;align-items:flex-start"><i class="fas fa-check-circle" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>Lessons are recorded (with consent)</li>
              <li style="font-size:.8rem;color:var(--muted);margin-bottom:10px;display:flex;gap:9px;align-items:flex-start"><i class="fas fa-check-circle" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>You can observe any lesson, any time</li>
              <li style="font-size:.8rem;color:var(--muted);margin-bottom:10px;display:flex;gap:9px;align-items:flex-start"><i class="fas fa-check-circle" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>No private tutor–student messaging</li>
              <li style="font-size:.8rem;color:var(--muted);margin-bottom:10px;display:flex;gap:9px;align-items:flex-start"><i class="fas fa-check-circle" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>GDPR-compliant data handling</li>
              <li style="font-size:.8rem;color:var(--muted);display:flex;gap:9px;align-items:flex-start"><i class="fas fa-check-circle" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>Any concern is taken seriously and acted upon immediately</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection