<nav id="nav">
  <div class="nav-wrap">
    <a href="{{ url('/') }}" class="nav-brand">
      <div class="nav-brand-icon"><i class="fas fa-book-open"></i></div>
      <div>
        <div class="nav-brand-title">MERIT</div>
        <span class="nav-brand-sub">Education Foundation</span>
      </div>
    </a>
    <div class="nav-links-wrap">
     <a href="{{ url('/') }}" > <span class="nav-link-item">Home</span></a>
      <a href="{{ url('/about') }}" ><span class="nav-link-item">About Us</span></a>
      <a href="{{ url('/news') }}" ><span class="nav-link-item">News</span></a>
      <a href="{{ url('/book-lesson') }}" ><span class="nav-link-item">Book Lesson</span></a>
      <a href="{{ url('/donate') }}" ><span class="nav-link-item">Donate</span></a>
      <a href="{{ url('/safeguarding-policy') }}" ><span class="nav-link-item">Safeguarding</span></a>
      <a href="{{ url('/contact') }}" ><span class="nav-link-item">Contact</span></a>
    </div>
    <div class="nav-cta-wrap">
      <a class="btn-outline-white" href="{{ url('/book-lesson') }}" style="padding:9px 20px;font-size:.72rem;">Book Lesson</a>
      <a class="btn-gold" href="{{ url('/login') }}" style="padding:9px 20px;font-size:.72rem;"><i class="fas fa-heart"></i>Login</a>
    </div>
    <button class="nav-toggle" onclick="document.querySelector('.mobile-menu').classList.toggle('open')"><i class="fas fa-bars"></i></button>
  </div>
  <div class="mobile-menu">
    <a href="{{ url('/') }}" ><span class="mobile-link">Home</span></a>
    <a href="{{ url('/about') }}" ><span class="mobile-link">About Us</span></a>
    <a href="{{ url('/news') }}" ><span class="mobile-link">News</span></a>
    <a href="{{ url('/book-lesson') }}" ><span class="mobile-link">Book Lesson</span></a>
    <a href="{{ url('/donate') }}" ><span class="mobile-link">Donate</span></a>
    <a href="{{ url('/safeguarding-policy') }}" ><span class="mobile-link">Safeguarding</span></a>
    <a href="{{ url('/contact') }}" ><span class="mobile-link">Contact</span></a>
    <div style="display:flex;gap:8px;margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,.07)">
      <a href="{{ url('/book-lesson') }}" class="btn-gold"  style="flex:1;justify-content:center;">Book Lesson</a>
      <a href="{{ url('/donate') }}"  class="btn-navy"  style="flex:1;justify-content:center;"><i class="fas fa-heart"></i>Donate</a>
    </div>
  </div>
</nav>