@extends('layouts.frontend')
@section('content')

  <!-- Hero -->
  <div class="page-hero" style="background:linear-gradient(160deg,var(--dark) 0%,var(--navy2) 100%)">
    <div class="page-hero::after" style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.022) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.022) 1px,transparent 1px);background-size:64px 64px"></div>
    <div class="container position-relative" style="z-index:2">
      <div class="ph-badge"><span>Latest News</span></div>
      <h1 class="ph-h">News &amp; <em>Impact Stories</em></h1>
      <p class="ph-p">Stay informed on our programmes, student success stories, charity updates and educational insights from around the world.</p>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="news-filter-bar" id="filter-bar">
    <div class="container">
      <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="d-flex gap-2 flex-wrap">
          <button class="filter-pill active" onclick="setFilter(this,'all')">All</button>
          <button class="filter-pill" onclick="setFilter(this,'impact')"><i class="fas fa-heart"></i>Impact Stories</button>
          <button class="filter-pill" onclick="setFilter(this,'education')"><i class="fas fa-book-open"></i>Education</button>
          <button class="filter-pill" onclick="setFilter(this,'charity')"><i class="fas fa-hand-holding-heart"></i>Charity</button>
          <button class="filter-pill" onclick="setFilter(this,'quran')"><i class="fas fa-star-and-crescent"></i>Quran</button>
          <button class="filter-pill" onclick="setFilter(this,'announcement')"><i class="fas fa-bullhorn"></i>Announcements</button>
        </div>
        <div class="ms-auto search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search articles...">
        </div>
      </div>
    </div>
  </div>

  <section style="padding:60px 0 100px;background:var(--cream)">
    <div class="container">
      <div class="row g-4">

        <!-- Main Content -->
        <div class="col-lg-8">

          <!-- Featured -->
          <div class="news-featured mb-4" data-r="up" onclick="showPage('news-detail')">
            <div class="nf-cat"><i class="fas fa-star"></i>Featured Story</div>
            <h2 class="nf-h">5,000 Students Reached: Merit Foundation Celebrates Major Milestone</h2>
            <p class="nf-p">This year marks a monumental achievement for Merit Education Foundation as we surpass 5,000 students supported across 30 countries — a journey that began with a single lesson in 2009.</p>
            <div class="nf-meta">
              <div class="nf-meta-item"><i class="fas fa-calendar"></i>15 November 2025</div>
              <div class="nf-meta-item"><i class="fas fa-user"></i>Dr. Aisha Rahman, Founder</div>
              <div class="nf-meta-item"><i class="fas fa-clock"></i>8 min read</div>
              <div class="nf-meta-item"><i class="fas fa-eye"></i>2,340 views</div>
            </div>
            <button class="btn-gold btn-sm mt-4" style="pointer-events:none"><i class="fas fa-arrow-right"></i>Read Full Story</button>
          </div>

          <!-- News Grid -->
          <div class="row g-4">
            <div class="col-md-6" data-r="up">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:linear-gradient(135deg,#0D6B63,#0F1F5C);position:absolute;inset:0"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag">Impact</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>5 min</div>
                  <i class="fas fa-graduation-cap" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">12 Oct 2025</div>
                  <h4 class="nc-h">Fatima's Story: From Orphan to Medical Student</h4>
                  <p class="nc-p">How a Merit scholarship transformed the life of a young Nigerian girl who had no hope of continuing her education...</p>
                  <div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:var(--teal)">SR</div><span class="nc-author-name">Sara Rahman</span></div>
                    <span class="nc-read-more">Read <i class="fas fa-arrow-right"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" data-r="up" style="transition-delay:.1s">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:linear-gradient(135deg,#C9A84C,#0F1F5C);position:absolute;inset:0"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag" style="background:var(--navy);color:var(--gold)">Quran</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>4 min</div>
                  <i class="fas fa-quran" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">28 Sep 2025</div>
                  <h4 class="nc-h">New Tajweed Programme Launches for Advanced Students</h4>
                  <p class="nc-p">Merit Education Foundation announces its most comprehensive Quran recitation programme to date, designed for students ready to master Tajweed...</p>
                  <div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:var(--gold);color:var(--navy)">MH</div><span class="nc-author-name">Mohammed Hassan</span></div>
                    <span class="nc-read-more">Read <i class="fas fa-arrow-right"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" data-r="up" style="transition-delay:.1s">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:linear-gradient(135deg,#1A2E7A,#0D6B63);position:absolute;inset:0"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag" style="background:var(--teal)">Charity</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>6 min</div>
                  <i class="fas fa-hand-holding-heart" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">3 Sep 2025</div>
                  <h4 class="nc-h">Ramadan Campaign Raises £32,000 for Orphaned Students</h4>
                  <p class="nc-p">This year's Ramadan donation drive exceeded all expectations, with supporters from 18 countries contributing to fund 160 new sponsored students...</p>
                  <div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:var(--navy)">ZA</div><span class="nc-author-name">Zara Ahmed</span></div>
                    <span class="nc-read-more">Read <i class="fas fa-arrow-right"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" data-r="up" style="transition-delay:.2s">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:linear-gradient(135deg,#0F1F5C,#C9A84C55);position:absolute;inset:0"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag" style="background:#7c3aed">Education</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>3 min</div>
                  <i class="fas fa-chalkboard-teacher" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">18 Aug 2025</div>
                  <h4 class="nc-h">Digital Literacy Programme Expands to Sub-Saharan Africa</h4>
                  <p class="nc-p">Merit's pioneering digital skills programme now reaches students in Kenya, Uganda and Tanzania — opening doors to remote employment and opportunity...</p>
                  <div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:#7c3aed">KO</div><span class="nc-author-name">Kwame Osei</span></div>
                    <span class="nc-read-more">Read <i class="fas fa-arrow-right"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" data-r="up">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:linear-gradient(135deg,#DC2626,#0F1F5C);position:absolute;inset:0;opacity:.6"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag" style="background:#DC2626">Announcement</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>2 min</div>
                  <i class="fas fa-bullhorn" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">5 Aug 2025</div>
                  <h4 class="nc-h">Merit Foundation Achieves Registered Charity Status</h4>
                  <p class="nc-p">We are delighted to announce that Merit Education Foundation has been officially registered as a charity, enabling Gift Aid on all donations...</p>
                  <div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:var(--gold);color:var(--navy)">AR</div><span class="nc-author-name">Dr. Aisha Rahman</span></div>
                    <span class="nc-read-more">Read <i class="fas fa-arrow-right"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6" data-r="up" style="transition-delay:.1s">
              <div class="news-card" onclick="showPage('news-detail')">
                <div class="news-card-img">
                  <div class="news-card-img-bg" style="background:linear-gradient(135deg,#0D6B63,#1A2E7A);position:absolute;inset:0"></div>
                  <div class="news-card-img-overlay"></div>
                  <div class="nc-cat-tag" style="background:var(--teal)">Impact</div>
                  <div class="nc-read-time"><i class="fas fa-clock"></i>5 min</div>
                  <i class="fas fa-school" style="font-size:3rem;color:rgba(255,255,255,.15);position:relative;z-index:1"></i>
                </div>
                <div class="news-card-body">
                  <div class="nc-date">22 Jul 2025</div>
                  <h4 class="nc-h">New School Partnership in Bangladesh Supports 200 Children</h4>
                  <p class="nc-p">A landmark partnership with three community schools in Dhaka brings Merit's educational resources to over 200 underprivileged children...</p>
                  <div class="nc-footer">
                    <div class="nc-author"><div class="nc-av" style="background:var(--navy2)">RK</div><span class="nc-author-name">Rahul Kumar</span></div>
                    <span class="nc-read-more">Read <i class="fas fa-arrow-right"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div class="d-flex align-items-center justify-content-between mt-5" data-r="up">
            <span style="font-size:.78rem;color:var(--muted)">Showing 7 of 34 articles</span>
            <div class="d-flex gap-2">
              <div class="pag-btn"><i class="fas fa-chevron-left"></i></div>
              <div class="pag-btn active">1</div>
              <div class="pag-btn">2</div>
              <div class="pag-btn">3</div>
              <div class="pag-btn" style="width:auto;padding:0 14px">...</div>
              <div class="pag-btn">6</div>
              <div class="pag-btn"><i class="fas fa-chevron-right"></i></div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4" data-r="right">
          <div class="sidebar-widget">
            <div class="sw-title">Recent Articles</div>
            <div class="recent-item" onclick="showPage('news-detail')">
              <div class="ri-img" style="background:linear-gradient(135deg,var(--navy),var(--navy2))"><i class="fas fa-graduation-cap" style="color:rgba(255,255,255,.3)"></i></div>
              <div><div class="ri-date">12 Oct 2025</div><div class="ri-h">Fatima's Story: From Orphan to Medical Student</div></div>
            </div>
            <div class="recent-item" onclick="showPage('news-detail')">
              <div class="ri-img" style="background:linear-gradient(135deg,var(--gold),var(--navy))"><i class="fas fa-quran" style="color:rgba(255,255,255,.3)"></i></div>
              <div><div class="ri-date">28 Sep 2025</div><div class="ri-h">New Tajweed Programme Launches for Advanced Students</div></div>
            </div>
            <div class="recent-item" onclick="showPage('news-detail')">
              <div class="ri-img" style="background:linear-gradient(135deg,var(--teal),var(--navy))"><i class="fas fa-heart" style="color:rgba(255,255,255,.3)"></i></div>
              <div><div class="ri-date">3 Sep 2025</div><div class="ri-h">Ramadan Campaign Raises £32,000 for Orphaned Students</div></div>
            </div>
            <div class="recent-item" onclick="showPage('news-detail')">
              <div class="ri-img" style="background:linear-gradient(135deg,#7c3aed,var(--navy))"><i class="fas fa-laptop" style="color:rgba(255,255,255,.3)"></i></div>
              <div><div class="ri-date">18 Aug 2025</div><div class="ri-h">Digital Literacy Programme Expands to Sub-Saharan Africa</div></div>
            </div>
          </div>

          <div class="sidebar-widget">
            <div class="sw-title">Categories</div>
            <div class="cat-item"><span class="cat-name"><i class="fas fa-heart me-2" style="color:var(--gold)"></i>Impact Stories</span><span class="cat-count">14</span></div>
            <div class="cat-item"><span class="cat-name"><i class="fas fa-book-open me-2" style="color:var(--teal)"></i>Education</span><span class="cat-count">9</span></div>
            <div class="cat-item"><span class="cat-name"><i class="fas fa-hand-holding-heart me-2" style="color:var(--navy)"></i>Charity</span><span class="cat-count">7</span></div>
            <div class="cat-item"><span class="cat-name"><i class="fas fa-star-and-crescent me-2" style="color:var(--gold)"></i>Quran</span><span class="cat-count">5</span></div>
            <div class="cat-item"><span class="cat-name"><i class="fas fa-bullhorn me-2" style="color:var(--red)"></i>Announcements</span><span class="cat-count">4</span></div>
          </div>

          <div class="sidebar-widget">
            <div class="sw-title">Popular Tags</div>
            <div class="tag-cloud">
              <span class="tag">Scholarship</span><span class="tag">Quran Learning</span><span class="tag">UK Charity</span><span class="tag">Gift Aid</span><span class="tag">Tajweed</span><span class="tag">Orphan Support</span><span class="tag">Education</span><span class="tag">Impact</span><span class="tag">Bangladesh</span><span class="tag">Nigeria</span><span class="tag">Ramadan</span>
            </div>
          </div>

          <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));border-radius:16px;padding:28px 22px;position:relative;overflow:hidden">
            <div style="position:absolute;inset:0;background:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.025'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E\")"></div>
            <div style="position:relative">
              <div style="font-size:.65rem;font-weight:700;letter-spacing:2.5px;color:var(--gold);text-transform:uppercase;margin-bottom:12px">Newsletter</div>
              <h5 class="serif" style="font-size:1.15rem;color:var(--white);margin-bottom:10px">Stay Updated</h5>
              <p style="font-size:.78rem;color:rgba(255,255,255,.45);margin-bottom:18px;line-height:1.6">Get monthly impact reports and news delivered to your inbox.</p>
              <input type="email" class="field-input" placeholder="your@email.com" style="margin-bottom:10px;background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.12);color:var(--white)">
              <button class="btn-gold" style="width:100%;justify-content:center">Subscribe</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="d-flex align-items-center gap-3 mb-2">
            <div style="width:40px;height:40px;background:rgba(201,168,76,.1);border:1.5px solid rgba(201,168,76,.28);border-radius:10px;display:flex;align-items:center;justify-content:center"><i class="fas fa-book-open" style="color:var(--gold);font-size:.88rem"></i></div>
            <div><div class="sf-brand-n">MERIT</div><div class="sf-brand-s">Education Foundation</div></div>
          </div>
          <p style="font-size:.78rem;color:rgba(255,255,255,.3);line-height:1.75;margin:12px 0">UK-based education charity combining online Quran teaching with a global mission.</p>
          <div class="sf-soc"><div class="sf-soc-btn"><i class="fab fa-facebook-f"></i></div><div class="sf-soc-btn"><i class="fab fa-instagram"></i></div><div class="sf-soc-btn"><i class="fab fa-twitter"></i></div><div class="sf-soc-btn"><i class="fab fa-linkedin-in"></i></div></div>
        </div>
        <div class="col-lg-2 col-6"><div style="font-size:.62rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:18px">Quick Links</div><span class="sf-link" onclick="showPage('news')">News</span><span class="sf-link" onclick="showPage('login')">Login</span><span class="sf-link" onclick="showPage('privacy')">Privacy Policy</span><span class="sf-link" onclick="showPage('dashboard')">Dashboard</span></div>
        <div class="col-lg-2 col-6"><div style="font-size:.62rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:18px">Organisation</div><span class="sf-link">About Us</span><span class="sf-link">Book a Lesson</span><span class="sf-link">Donate</span><span class="sf-link">Safeguarding</span></div>
        <div class="col-lg-4"><div style="font-size:.62rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold);margin-bottom:18px">Contact</div><p style="font-size:.78rem;color:rgba(255,255,255,.3);margin-bottom:8px;display:flex;gap:9px"><i class="fas fa-envelope" style="color:var(--gold);margin-top:2px;font-size:.7rem"></i>info@meriteducation.org</p><p style="font-size:.78rem;color:rgba(255,255,255,.3);display:flex;gap:9px"><i class="fas fa-phone" style="color:var(--gold);margin-top:2px;font-size:.7rem"></i>+44 20 0000 0000</p></div>
      </div>
    </div>
    <div class="sf-bottom"><div class="container"><div class="d-flex justify-content-between align-items-center flex-wrap gap-2"><p class="sf-bot-txt">© 2025 Merit Education Foundation. Registered Charity. All Rights Reserved.</p><div class="d-flex gap-3"><span class="sf-bot-txt" style="cursor:pointer;transition:.3s" onmouseover="this.style.color='#C9A84C'" onmouseout="this.style.color=''">Privacy Policy</span><span class="sf-bot-txt" style="cursor:pointer;transition:.3s" onmouseover="this.style.color='#C9A84C'" onmouseout="this.style.color=''">Terms</span></div></div></div></div>
  </footer>
@endsection