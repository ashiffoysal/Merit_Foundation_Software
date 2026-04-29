<nav id="nav">
  <div class="nav-wrap">
    <div class="nav-brand" onclick="showPage('home')">
      <div class="nav-brand-icon"><i class="fas fa-book-open"></i></div>
      <div>
        <div class="nav-brand-title">MERIT</div>
        <span class="nav-brand-sub">Education Foundation</span>
      </div>
    </div>
    <div class="nav-links-wrap">
      <span class="nav-link-item" onclick="showPage('home')">Home</span>
      <span class="nav-link-item" onclick="showPage('about')">About Us</span>
      <span class="nav-link-item" onclick="showPage('book')">Book Lesson</span>
      <span class="nav-link-item" onclick="showPage('donate')">Donate</span>
      <span class="nav-link-item" onclick="showPage('safeguarding')">Safeguarding</span>
      <span class="nav-link-item" onclick="showPage('contact')">Contact</span>
    </div>
    <div class="nav-cta-wrap">
      <button class="btn-outline-white" onclick="showPage('book')" style="padding:9px 20px;font-size:.72rem;">Book Lesson</button>
      <button class="btn-gold" onclick="showPage('donate')" style="padding:9px 20px;font-size:.72rem;"><i class="fas fa-heart"></i>Donate</button>
    </div>
    <button class="nav-toggle" onclick="document.querySelector('.mobile-menu').classList.toggle('open')"><i class="fas fa-bars"></i></button>
  </div>
  <div class="mobile-menu">
    <span class="mobile-link" onclick="showPage('home')">Home</span>
    <span class="mobile-link" onclick="showPage('about')">About Us</span>
    <span class="mobile-link" onclick="showPage('book')">Book Lesson</span>
    <span class="mobile-link" onclick="showPage('donate')">Donate</span>
    <span class="mobile-link" onclick="showPage('safeguarding')">Safeguarding</span>
    <span class="mobile-link" onclick="showPage('contact')">Contact</span>
    <div style="display:flex;gap:8px;margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,.07)">
      <button class="btn-gold" onclick="showPage('book')" style="flex:1;justify-content:center;">Book Lesson</button>
      <button class="btn-navy" onclick="showPage('donate')" style="flex:1;justify-content:center;"><i class="fas fa-heart"></i>Donate</button>
    </div>
  </div>
</nav>