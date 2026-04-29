<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Merit Education Foundation</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('frontend/assets/style.css') }}"/>
</head>
<body>

<!-- ── Loader ── -->
{{-- <div id="loader"><div class="loader-t">MERIT</div><div class="loader-track"><div class="loader-fill"></div></div></div> --}}

<!-- ══════════════ NAVBAR ══════════════ -->
@include('frontend.include.header')

<!-- ══════════════════════════════════════
   HOME PAGE
══════════════════════════════════════ -->

@yield('content')

<footer class="site-footer">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-3 mb-2" style="cursor:pointer" onclick="showPage('home')">
          <div style="width:42px;height:42px;background:rgba(201,168,76,.1);border:1.5px solid rgba(201,168,76,.28);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-book-open" style="color:var(--gold);font-size:.9rem"></i></div>
          <div><div class="footer-brand-n">MERIT</div><div class="footer-brand-s">Education Foundation</div></div>
        </div>
        <p class="footer-tagline">"Education for All, Opportunity for Every Child"</p>
        <p class="footer-desc">A UK-based education charity combining expert online Quran teaching with a global mission to fund education for disadvantaged children.</p>
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
        <div class="footer-link" onclick="showPage('home')"><i class="fas fa-chevron-right"></i>Home</div>
        <div class="footer-link" onclick="showPage('about')"><i class="fas fa-chevron-right"></i>About Us</div>
        <div class="footer-link" onclick="showPage('book')"><i class="fas fa-chevron-right"></i>Book Lesson</div>
        <div class="footer-link" onclick="showPage('donate')"><i class="fas fa-chevron-right"></i>Donate</div>
        <div class="footer-link" onclick="showPage('safeguarding')"><i class="fas fa-chevron-right"></i>Safeguarding</div>
        <div class="footer-link" onclick="showPage('contact')"><i class="fas fa-chevron-right"></i>Contact</div>
      </div>
      <div class="col-lg-2 col-6">
        <div class="footer-col-title">Legal</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Privacy Policy</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Terms & Conditions</div>
        <div class="footer-link" onclick="showPage('safeguarding')"><i class="fas fa-chevron-right"></i>Safeguarding Policy</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Cookie Policy</div>
        <div class="footer-link"><i class="fas fa-chevron-right"></i>Gift Aid Declaration</div>
      </div>
      <div class="col-lg-4">
        <div class="footer-col-title">Contact & Newsletter</div>
        <div style="font-size:.8rem;color:rgba(255,255,255,.35);display:flex;align-items:flex-start;gap:10px;margin-bottom:10px"><i class="fas fa-envelope" style="color:var(--gold);margin-top:3px;font-size:.75rem"></i><span>info@meriteducation.org</span></div>
        <div style="font-size:.8rem;color:rgba(255,255,255,.35);display:flex;align-items:flex-start;gap:10px;margin-bottom:10px"><i class="fas fa-phone" style="color:var(--gold);margin-top:3px;font-size:.75rem"></i><span>+44 20 0000 0000</span></div>
        <div style="font-size:.8rem;color:rgba(255,255,255,.35);display:flex;align-items:flex-start;gap:10px;margin-bottom:20px"><i class="fas fa-map-marker-alt" style="color:var(--gold);margin-top:3px;font-size:.75rem"></i><span>London, United Kingdom</span></div>
        <div class="footer-newsletter">
          <div class="footer-nl-title">Stay Updated</div>
          <div class="footer-nl-sub">Monthly impact reports and updates from our programmes worldwide.</div>
          <div class="footer-nl-row"><input type="email" placeholder="Your email address"><button>Subscribe</button></div>
        </div>
      </div>
    </div>
    <!-- Key disclaimer -->
    <div style="background:rgba(201,168,76,.07);border:1px solid rgba(201,168,76,.15);border-radius:10px;padding:14px 20px;margin-top:40px;display:flex;align-items:flex-start;gap:12px">
      <i class="fas fa-info-circle" style="color:var(--gold);margin-top:2px;font-size:.9rem;flex-shrink:0"></i>
      <p style="font-size:.75rem;color:rgba(255,255,255,.4);margin:0;line-height:1.65"><strong style="color:rgba(255,255,255,.6)">Important:</strong> Lesson fees are charged as a service and are not donations. Donations are separate, voluntary and Gift Aid eligible for UK taxpayers. Merit Education Foundation operates transparently and in accordance with UK charity law.</p>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6"><p class="footer-bot-txt">© 2025 Merit Education Foundation. Registered Charity. All Rights Reserved.</p></div>
        <div class="col-md-6"><div class="footer-bot-links"><span>Privacy Policy</span><span>Terms</span><span>Safeguarding</span><span>Cookies</span></div></div>
      </div>
    </div>
  </div>
</footer>


<button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="fas fa-chevron-up"></i></button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/assets/custom.js') }}"></script>
</body>
</html>
