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
        <a href="{{ route('home') }}" class="footer-link" ><i class="fas fa-chevron-right"></i>Home</a>
        <a href="{{ route('about') }}" class="footer-link" ><i class="fas fa-chevron-right"></i>About Us</a>
        <a href="{{ route('book.lesson') }}" class="footer-link" ><i class="fas fa-chevron-right"></i>Book Lesson</a>
        <a href="{{ route('donate') }}" class="footer-link" ><i class="fas fa-chevron-right"></i>Donate</a>
        <a href="{{ route('safeguard') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Safeguarding</a>
        <a href="{{ route('contact') }}" class="footer-link" ><i class="fas fa-chevron-right"></i>Contact</a>
      </div>
      <div class="col-lg-2 col-6">
        <div class="footer-col-title">Legal</div>
        <a href="{{ route('privacy.policy') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Privacy Policy</a>
        <a href="{{ route('terms.and.conditions') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Terms & Conditions</a>
        <a href="{{ route('safeguard') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Safeguarding Policy</a>
        <a href="{{ route('cookie.policy') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Cookie Policy</a>
        {{-- <div class="footer-link"><i class="fas fa-chevron-right"></i>Gift Aid Declaration</div> --}}
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
        <div class="col-md-6"><p class="footer-bot-txt">© {{ \Carbon\Carbon::now()->year }} Merit Education Foundation. Registered Charity. All Rights Reserved.</p></div>
        {{-- <div class="col-md-6"><div class="footer-bot-links"><span><a href="{{ route('privacy.policy') }}" class="text-decoration-underline">Privacy Policy</a></span><span><a href="{{ route('terms.and.conditions') }}" class="text-decoration-underline">Terms</a></span><span><a href="{{ route('safeguard') }}" class="text-decoration-underline">Safeguarding</a></span><span><a href="{{ route('cookie.policy') }}" class="text-decoration-underline">Cookies</a></span></div></div> --}}
      </div>
    </div>
  </div>
</footer>