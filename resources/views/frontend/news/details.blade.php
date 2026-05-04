@extends('layouts.frontend')
@section('content')

  <div class="article-hero">
    <div class="container position-relative" style="z-index:2">
      <div class="d-flex align-items-center gap-3 mb-4">
        <span style="font-size:.75rem;color:rgba(255,255,255,.4);display:flex;align-items:center;gap:8px;cursor:pointer" onclick="showPage('news')"><i class="fas fa-arrow-left" style="color:var(--gold)"></i>Back to News</span>
        <i class="fas fa-chevron-right" style="font-size:.55rem;color:rgba(255,255,255,.2)"></i>
        <span style="font-size:.75rem;color:rgba(255,255,255,.4)">Impact Stories</span>
      </div>
      <div class="article-cat"><i class="fas fa-star"></i>Featured Story</div>
      <h1 class="article-h1">5,000 Students Reached: Merit Foundation Celebrates Major Milestone in Global Education</h1>
      <div class="article-meta-bar">
        <div class="am-item"><i class="fas fa-calendar"></i><strong>15 November 2025</strong></div>
        <div class="am-item"><i class="fas fa-user"></i><strong>Dr. Aisha Rahman</strong></div>
        <div class="am-item"><i class="fas fa-clock"></i><strong>8 min read</strong></div>
        <div class="am-item"><i class="fas fa-eye"></i><strong>2,340 views</strong></div>
        <div class="article-share">
          <div class="share-btn"><i class="fab fa-twitter"></i></div>
          <div class="share-btn"><i class="fab fa-facebook-f"></i></div>
          <div class="share-btn"><i class="fab fa-linkedin-in"></i></div>
          <div class="share-btn"><i class="fas fa-link"></i></div>
        </div>
      </div>
    </div>
  </div>

  <section style="padding:60px 0 100px;background:var(--cream)">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-8">

          <!-- Article Body -->
          <div class="article-content" data-r="up">
            <p>When Merit Education Foundation opened its doors in 2009 with a single tutor and three students meeting via a dial-up internet connection, nobody could have imagined that sixteen years later, we would be celebrating the support of over <strong>5,000 students across 30 countries</strong>. Today, that milestone is not just a number — it represents 5,000 individual stories of hope, perseverance, and transformation.</p>

            <div class="article-image-block">
              <i class="fas fa-graduation-cap" style="font-size:5rem;color:rgba(255,255,255,.12);position:relative;z-index:1"></i>
            </div>
            <p class="article-image-caption">Students from the Merit 2025 cohort during a virtual graduation ceremony. Over 800 students completed full programmes this year alone.</p>

            <h2>How We Got Here</h2>
            <p>The journey from three students to five thousand has never been linear. There were years of struggle, of fundraising campaigns that fell short, of infrastructure challenges in regions with limited connectivity. But the constant thread running through every year of our existence has been the <strong>determination of the children we serve</strong> — children like Fatima from Nigeria, Ahmed from Somalia, and Priya from Bangladesh.</p>

            <blockquote>"Education gave me back my future when I thought it had been taken from me forever. Merit didn't just teach me to read — they taught me that I was worth something." — Fatima Al-Hassan, now a second-year Medical Student</blockquote>

            <h3>The Dual-Impact Model That Changed Everything</h3>
            <p>One of the most significant innovations in our approach has been the development of our dual-impact model: <strong>lesson fees funding charity places</strong>. For every paying student who books a Quran lesson through our platform, a portion of that revenue cross-subsidises education for a child who cannot afford it. This self-sustaining cycle has allowed us to grow without being entirely dependent on donations.</p>

            <div class="highlight-box">
              <h4><i class="fas fa-chart-line me-2"></i>2025 Impact Summary</h4>
              <p>This year we supported 892 new students through charitable funding, delivered 14,200 individual Quran lessons, trained 47 new tutors, and expanded our digital literacy programme to three new countries. Every metric represents a real child whose life has been changed.</p>
            </div>

            <h2>Looking Ahead: Our 10,000 Student Goal</h2>
            <p>Reaching 5,000 students is a milestone — but it is also a starting point. Our next target is to <strong>double our reach by 2028</strong>, with specific expansions planned for Sub-Saharan Africa, South Asia, and the Middle East. We are also investing in tutor training infrastructure, digital resources, and community partnerships that will allow us to scale sustainably.</p>

            <ul>
              <li>Expand to 50+ countries by 2027</li>
              <li>Launch a dedicated girls' education programme in 2026</li>
              <li>Build partnerships with 200 community schools globally</li>
              <li>Introduce monthly impact reporting for all sponsors</li>
              <li>Launch a mobile app for seamless lesson booking and tracking</li>
            </ul>

            <p>None of this is possible without the extraordinary generosity of our donors, the commitment of our tutors, and most importantly — the courage of the children and families who trust us with their futures. To every single one of you: <strong>thank you</strong>.</p>
          </div>

          <!-- Tags -->
          <div class="mt-4" data-r="up">
            <p style="font-size:.7rem;font-weight:700;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:12px">Tags</p>
            <span class="tag-article"><i class="fas fa-tag"></i>Milestone</span>
            <span class="tag-article"><i class="fas fa-tag"></i>Impact</span>
            <span class="tag-article"><i class="fas fa-tag"></i>Education</span>
            <span class="tag-article"><i class="fas fa-tag"></i>Charity</span>
            <span class="tag-article"><i class="fas fa-tag"></i>Students</span>
            <span class="tag-article"><i class="fas fa-tag"></i>Global</span>
          </div>

          <!-- Author -->
          <div class="author-card mt-4" data-r="up">
            <div class="author-av-lg" style="background:linear-gradient(135deg,var(--gold),var(--navy))">A</div>
            <div>
              <div class="author-name-lg">Dr. Aisha Rahman</div>
              <div class="author-role">Founder & Executive Director</div>
              <p class="author-bio">Dr. Aisha Rahman founded Merit Education Foundation in 2009 with a mission to make quality education accessible to every child. With a doctorate in Educational Policy from the University of London, she has spent 20 years working at the intersection of education and social impact.</p>
            </div>
          </div>

          <!-- Related -->
          <div class="mt-5" data-r="up">
            <h4 class="serif" style="font-size:1.4rem;font-weight:700;color:var(--navy);margin-bottom:24px">Related Articles</h4>
            <div class="row g-3">
              <div class="col-md-4"><div class="related-card" onclick="showPage('news-detail')"><div class="related-img" style="background:linear-gradient(135deg,var(--teal),var(--navy))"><i class="fas fa-heart" style="font-size:2.5rem;color:rgba(255,255,255,.12)"></i></div><div class="related-body"><div class="related-cat">Impact</div><div class="related-h">Fatima's Story: From Orphan to Medical Student</div></div></div></div>
              <div class="col-md-4"><div class="related-card" onclick="showPage('news-detail')"><div class="related-img" style="background:linear-gradient(135deg,var(--gold),var(--navy))"><i class="fas fa-quran" style="font-size:2.5rem;color:rgba(255,255,255,.12)"></i></div><div class="related-body"><div class="related-cat">Quran</div><div class="related-h">New Tajweed Programme Launches for Advanced Students</div></div></div></div>
              <div class="col-md-4"><div class="related-card" onclick="showPage('news-detail')"><div class="related-img" style="background:linear-gradient(135deg,var(--navy),#7c3aed)"><i class="fas fa-laptop" style="font-size:2.5rem;color:rgba(255,255,255,.12)"></i></div><div class="related-body"><div class="related-cat">Education</div><div class="related-h">Digital Literacy Expands to Sub-Saharan Africa</div></div></div></div>
            </div>
          </div>
        </div>

        <!-- Sticky Sidebar -->
        <div class="col-lg-4">
          <div style="position:sticky;top:100px">
            <div class="sidebar-widget mb-4">
              <div class="sw-title">Table of Contents</div>
              <div style="font-size:.82rem;color:var(--muted);line-height:1.5">
                <div style="padding:8px 0;border-bottom:1px solid var(--border);display:flex;gap:10px;cursor:pointer" class="toc-row"><span style="color:var(--gold);font-size:.65rem">01</span>How We Got Here</div>
                <div style="padding:8px 0;border-bottom:1px solid var(--border);display:flex;gap:10px;cursor:pointer" class="toc-row"><span style="color:var(--gold);font-size:.65rem">02</span>The Dual-Impact Model</div>
                <div style="padding:8px 0;display:flex;gap:10px;cursor:pointer" class="toc-row"><span style="color:var(--gold);font-size:.65rem">03</span>Our 10,000 Student Goal</div>
              </div>
            </div>
            <div style="background:linear-gradient(135deg,var(--navy),var(--navy2));border-radius:16px;padding:28px 22px;position:relative;overflow:hidden">
              <div style="position:absolute;inset:0;background:url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.025'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E\")"></div>
              <div style="position:relative">
                <i class="fas fa-heart" style="font-size:1.5rem;color:var(--gold);margin-bottom:14px;display:block"></i>
                <h5 class="serif" style="font-size:1.2rem;color:var(--white);margin-bottom:10px">Help Us Reach 10,000</h5>
                <p style="font-size:.78rem;color:rgba(255,255,255,.45);margin-bottom:18px;line-height:1.65">Your donation today contributes to our next milestone — double the lives changed.</p>
                <button class="btn-gold" style="width:100%;justify-content:center"><i class="fas fa-heart"></i>Donate Now</button>
                <button class="btn-outline-white" style="width:100%;justify-content:center;margin-top:10px;font-size:.72rem;padding:10px">Book a Lesson</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection