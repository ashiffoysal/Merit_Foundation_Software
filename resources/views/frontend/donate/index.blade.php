@extends('layouts.frontend')
@section('content')
  <div class="donate-hero">
    <div class="container position-relative" style="z-index:2">
      <div class="page-hero-badge"><span>Support a Child</span></div>
      <h1 class="page-hero-h mb-3">Support a Child's<br><em>Education</em></h1>
      <p class="page-hero-p">Your contribution helps provide education to disadvantaged and orphaned children who cannot afford it. Every pound makes a real difference.</p>
    </div>
  </div>

  <section class="section-cream">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6" data-r="left">
          <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Your Impact</span></div>
          <h2 class="sec-h">Every Pound<br><em>Changes a Life</em></h2>
          <div class="divider-gold"></div>
          <p class="sec-p mb-4">We believe in complete transparency. Here's exactly what your donation provides:</p>
          <div class="impact-amount-card"><div class="iac-amt">£5</div><i class="fas fa-arrow-right iac-arrow"></i><div class="iac-text"><h6>Provides Learning Materials</h6><p>Covers essential books, worksheets and digital resources for one student for a week.</p></div></div>
          <div class="impact-amount-card"><div class="iac-amt">£20</div><i class="fas fa-arrow-right iac-arrow"></i><div class="iac-text"><h6>Supports One Child for a Month</h6><p>Funds a full month of basic educational support for one disadvantaged child.</p></div></div>
          <div class="impact-amount-card"><div class="iac-amt">£50</div><i class="fas fa-arrow-right iac-arrow"></i><div class="iac-text"><h6>Funds a Full Learning Programme</h6><p>Covers a complete structured programme including tutor time, materials and assessment.</p></div></div>
          <div class="impact-amount-card"><div class="iac-amt">£150</div><i class="fas fa-arrow-right iac-arrow"></i><div class="iac-text"><h6>Sponsors a Child for a Term</h6><p>Provides comprehensive education support for an orphaned or disadvantaged child for one school term.</p></div></div>
        </div>
        <div class="col-lg-6" data-r="right">
          <div class="book-form-wrap">
            <div id="donate-form-body">
              <div class="eyebrow"><div class="eyebrow-line"></div><span class="eyebrow-txt">Make a Donation</span></div>
              <h3 class="sec-h mb-3" style="font-size:1.7rem">Donate <em>Today</em></h3>
              <div class="donate-tabs-wrap">
                <button class="donate-tab active" onclick="setDonateTab(this,'one')">One-Time</button>
                {{-- <button class="donate-tab" onclick="setDonateTab(this,'monthly')">Monthly</button> --}}
              </div>
              <p style="font-size:.78rem;color:var(--muted);margin-bottom:16px">Select an amount or enter your own:</p>
              <div class="row g-2 mb-4">
                <div class="col-4"><button class="donate-option-btn" onclick="selectDonateAmt(this,'£5')">£5</button></div>
                <div class="col-4"><button class="donate-option-btn selected" onclick="selectDonateAmt(this,'£20')">£20</button></div>
                <div class="col-4"><button class="donate-option-btn" onclick="selectDonateAmt(this,'£50')">£50</button></div>
                <div class="col-4"><button class="donate-option-btn" onclick="selectDonateAmt(this,'£100')">£100</button></div>
                <div class="col-4"><button class="donate-option-btn" onclick="selectDonateAmt(this,'£150')">£150</button></div>
                <div class="col-4"><button class="donate-option-btn" onclick="selectDonateAmt(this,'other')">Other</button></div>
              </div>
              <div class="field-group" id="other-amt-wrap" style="display:none"><label class="field-label">Enter Amount (£)</label><input type="number" class="field-input" placeholder="Enter amount" id="other-amt-input"></div>
              <div class="field-group"><label class="field-label">Full Name *</label><input type="text" class="field-input" placeholder="Your full name"></div>
              <div class="field-group"><label class="field-label">Email Address *</label><input type="email" class="field-input" placeholder="you@email.com"></div>
              <div class="field-group"><label class="field-label">Address (for Gift Aid)</label><textarea class="field-textarea" rows="2" placeholder="Your UK address"></textarea></div>
              <div class="gift-aid-box mb-4">
                <div style="display:flex;align-items:flex-start;gap:12px">
                  <i class="fas fa-hand-holding-heart" style="color:var(--teal);font-size:1.1rem;margin-top:2px"></i>
                  <div>
                    <h6 style="font-size:.85rem;font-weight:700;color:var(--navy);margin-bottom:5px">Boost Your Donation by 25% — Free!</h6>
                    <p style="font-size:.78rem;color:var(--muted);margin:0;line-height:1.65">If you are a UK taxpayer, we can claim Gift Aid on your donation — adding 25p for every £1 <strong>at no extra cost to you</strong>. Simply confirm you pay UK income tax below.</p>
                  </div>
                </div>
                <div style="margin-top:14px;display:flex;align-items:center;gap:10px">
                  <input type="checkbox" id="gift-aid-check" style="accent-color:var(--teal);width:16px;height:16px">
                  <label for="gift-aid-check" style="font-size:.8rem;color:var(--navy);font-weight:600;cursor:pointer">Yes, I am a UK taxpayer and consent to Gift Aid</label>
                </div>
              </div>
              <button class="btn-gold" style="width:100%;justify-content:center;padding:16px" onclick="submitDonateForm()"><i class="fas fa-heart"></i>Donate Now</button>
            </div>
            <div class="success-msg" id="donate-success">
              <i class="fas fa-heart" style="color:var(--gold)"></i>
              <h5>Thank You!</h5>
              <p>Your donation makes a real difference. We'll send confirmation to your email shortly. May Allah reward you immensely.</p>
              <button class="btn-navy mt-3" onclick="showPage('home')">Return Home</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Transparency -->
      <div class="mt-5 pt-3" data-r="up">
        <div class="text-center mb-4">
          <div class="eyebrow justify-content-center"><div class="eyebrow-line"></div><span class="eyebrow-txt">Transparency</span><div class="eyebrow-line"></div></div>
          <h2 class="sec-h">How We Use <em>Your Donation</em></h2>
        </div>
        <div class="row g-3 justify-content-center">
          <div class="col-lg-8">
            <div class="transparency-item"><div class="ti-label">Student Education Programmes</div><div class="ti-bar-wrap"><div class="ti-bar" style="width:70%"></div></div><div class="ti-pct">70%</div></div>
            <div class="transparency-item"><div class="ti-label">Learning Materials & Resources</div><div class="ti-bar-wrap"><div class="ti-bar" style="width:15%"></div></div><div class="ti-pct">15%</div></div>
            <div class="transparency-item"><div class="ti-label">Administration & Oversight</div><div class="ti-bar-wrap"><div class="ti-bar" style="width:10%"></div></div><div class="ti-pct">10%</div></div>
            <div class="transparency-item"><div class="ti-label">Emergency Welfare Support</div><div class="ti-bar-wrap"><div class="ti-bar" style="width:5%"></div></div><div class="ti-pct">5%</div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection