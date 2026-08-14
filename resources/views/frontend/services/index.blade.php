@extends('layouts.frontend')
@section('title', 'Service - Merit Education Foundation')
@section('content')
<style>
  :root{
    --green-950:#142B20;
    --green-800:#1E4433;
    --green-600:#2F5D45;
    --green-tint:#EDF2EC;
    --gold-500:#C6952F;
    --gold-300:#E4C077;
    --gold-100:#F6E8C9;
    --cream-100:#F7F2E7;
    --cream-50:#FCFAF4;
    --ink-900:#20261F;
    --ink-500:#726F60;
    --line:#E4DCC8;
    --radius:14px;
  }
  *{box-sizing:border-box;}
  html{scroll-behavior:smooth;}
  body{
    margin:0;
    font-family:'Inter',sans-serif;
    color:var(--ink-900);
    background:var(--cream-50);
    -webkit-font-smoothing:antialiased;
  }
  h1,h2,h3,h4{
    font-family:'Fraunces',serif;
    font-weight:500;
    line-height:1.15;
    margin:0;
    color:var(--green-950);
  }
  em{
    font-style:italic;
    color:var(--gold-500);
  }
  p{ line-height:1.7; color:var(--ink-500); margin:0; }
  a{ color:inherit; text-decoration:none; }
  img{ max-width:100%; display:block; }
  .wrap{ max-width:1160px; margin:0 auto; padding:0 32px; }
  .eyebrow{
    display:flex; align-items:center; gap:10px;
    font-size:12px; letter-spacing:.14em; text-transform:uppercase;
    color:var(--gold-500); font-weight:600; margin-bottom:14px;
  }
  .eyebrow::before{ content:""; width:22px; height:1px; background:var(--gold-500); }
  .btn{
    display:inline-flex; align-items:center; gap:8px;
    padding:14px 26px; border-radius:8px; font-size:14px; font-weight:600;
    letter-spacing:.03em; border:1px solid transparent; cursor:pointer;
    font-family:'Inter',sans-serif; transition:all .2s ease;
  }
  .btn-gold{ background:var(--gold-500); color:var(--green-950); }
  .btn-gold:hover{ background:var(--gold-300); }
  .btn-outline{ background:transparent; border-color:var(--green-950); color:var(--green-950); }
  .btn-outline:hover{ background:var(--green-950); color:var(--cream-50); }
  .btn-ghost-light{ background:transparent; border-color:rgba(255,255,255,.35); color:var(--cream-50); }
  .btn-ghost-light:hover{ background:rgba(255,255,255,.1); }

  /* NAV */
  header.site{
    background:var(--green-950); position:sticky; top:0; z-index:50;
  }
  .nav{ display:flex; align-items:center; justify-content:space-between; padding:18px 32px; max-width:1160px; margin:0 auto; }
  .logo{ display:flex; align-items:center; gap:10px; color:var(--cream-50); }
  .logo .mark{
    width:34px;height:34px;border:1px solid var(--gold-300); border-radius:8px;
    display:flex;align-items:center;justify-content:center; color:var(--gold-300); font-family:'Fraunces',serif; font-size:16px;
  }
  .logo .name{ font-family:'Fraunces',serif; font-size:17px; line-height:1.1; }
  .logo .name small{ display:block; font-family:'Inter',sans-serif; font-size:10px; letter-spacing:.12em; color:var(--gold-300); text-transform:uppercase; }
  nav.links{ display:flex; gap:30px; }
  nav.links a{ font-size:13.5px; color:#D7DBD3; font-weight:500; letter-spacing:.02em; }
  nav.links a:hover{ color:var(--gold-300); }
  .nav-cta{ display:flex; gap:12px; align-items:center; }
  .nav-cta .btn{ padding:11px 20px; font-size:13px; }
  @media (max-width:900px){ nav.links{ display:none; } }

  /* BREADCRUMB HERO */
  .service-hero{
    background:var(--cream-100);
    padding:64px 0 56px;
    border-bottom:1px solid var(--line);
  }
  .service-hero .crumb{ font-size:13px; color:var(--ink-500); margin-bottom:18px; }
  .service-hero .crumb span{ color:var(--gold-500); }
  .service-hero h1{ font-size:44px; max-width:640px; }
  .service-hero p.lead{ max-width:560px; margin-top:16px; font-size:16px; }
  .service-hero .cta-row{ display:flex; gap:14px; margin-top:28px; }

  /* SECTION generic */
  section{ padding:88px 0; }
  .section-head{ max-width:600px; margin:0 auto 48px; text-align:center; }
  .section-head h2{ font-size:34px; }
  .section-head p{ margin-top:14px; font-size:15.5px; }
  .center{ text-align:center; }
  .band-cream{ background:var(--cream-100); }
  .band-green{ background:var(--green-950); color:var(--cream-50); }
  .band-green p{ color:#B9C4B7; }
  .band-green h2, .band-green h3{ color:var(--cream-50); }

  /* LEARNING PATH — signature element */
  .path-section{ padding:96px 0 108px; background:var(--cream-50); }
  .path-rail{
    position:relative; margin-top:64px;
  }
  .path-line{
    position:absolute; top:34px; left:0; right:0; height:2px;
    background:repeating-linear-gradient(90deg,var(--gold-300) 0 10px, transparent 10px 18px);
  }
  .path-steps{
    display:grid; grid-template-columns:repeat(5,1fr); gap:18px; position:relative;
  }
  .path-step{ text-align:center; padding:0 6px; }
  .path-node{
    width:68px; height:68px; border-radius:50%; background:var(--cream-50);
    border:2px solid var(--gold-500); display:flex; align-items:center; justify-content:center;
    margin:0 auto 20px; font-family:'Fraunces',serif; font-size:20px; color:var(--green-950);
    position:relative; z-index:2;
  }
  .path-step h4{ font-size:16px; margin-bottom:8px; }
  .path-step p{ font-size:13px; }
  .path-step .lvl{ display:inline-block; margin-top:10px; font-size:11px; letter-spacing:.1em; text-transform:uppercase; color:var(--gold-500); font-weight:600; }
  @media (max-width:900px){
    .path-steps{ grid-template-columns:1fr; gap:36px; }
    .path-line{ display:none; }
  }

  /* SERVICE DETAIL ROWS */
  .service-row{
    display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center;
    padding:64px 0; border-bottom:1px solid var(--line);
  }
  .service-row:last-child{ border-bottom:none; }
  .service-row.reverse .media{ order:2; }
  .media{
    background:var(--green-tint); border-radius:var(--radius); padding:34px;
    border:1px solid var(--line); position:relative;
  }
  .media .tag{
    position:absolute; top:18px; left:18px; background:var(--green-950); color:var(--gold-300);
    font-size:11px; letter-spacing:.08em; text-transform:uppercase; padding:6px 12px; border-radius:20px;
  }
  .media ul.points{ list-style:none; margin:26px 0 0; padding:0; display:grid; gap:14px; }
  .media ul.points li{
    background:var(--cream-50); border:1px solid var(--line); border-radius:10px;
    padding:14px 16px; font-size:13.5px; color:var(--ink-900); display:flex; gap:10px; align-items:flex-start;
  }
  .media ul.points li::before{ content:"✓"; color:var(--gold-500); font-weight:700; }
  .content h3{ font-size:28px; margin-bottom:14px; }
  .content .desc{ font-size:15px; margin-bottom:22px; }
  .content ul.feat{ list-style:none; padding:0; margin:0 0 26px; display:grid; gap:12px; }
  .content ul.feat li{ font-size:14.5px; color:var(--ink-900); padding-left:22px; position:relative; }
  .content ul.feat li::before{
    content:""; position:absolute; left:0; top:7px; width:8px; height:8px; border-radius:2px;
    background:var(--gold-500);
  }
  .content ul.feat li strong{ color:var(--green-950); }

  /* PILLARS / WHY CHOOSE */
  .pillars{ display:grid; grid-template-columns:repeat(4,1fr); gap:22px; margin-top:48px; }
  .pillar{ background:var(--cream-50); border:1px solid var(--line); border-radius:var(--radius); padding:28px 24px; }
  .pillar .icon{
    width:44px;height:44px;border-radius:10px;background:var(--gold-100);
    display:flex;align-items:center;justify-content:center; margin-bottom:18px; color:var(--gold-500); font-size:18px;
  }
  .pillar h4{ font-size:16px; margin-bottom:8px; }
  .pillar p{ font-size:13.5px; }
  @media (max-width:900px){ .pillars{ grid-template-columns:1fr 1fr; } }
  @media (max-width:560px){ .pillars{ grid-template-columns:1fr; } }

  /* PRICING */
  .price-toggle{ display:flex; justify-content:center; gap:8px; margin:36px 0 44px; }
  .price-toggle span{
    padding:10px 20px; border-radius:30px; font-size:13px; font-weight:600; color:var(--ink-500);
    border:1px solid var(--line); background:var(--cream-50);
  }
  .price-toggle span.active{ background:var(--green-950); color:var(--gold-300); border-color:var(--green-950); }
  .price-grid{ display:grid; grid-template-columns:repeat(5,1fr); gap:18px; }
  .price-card{
    background:var(--cream-50); border:1px solid var(--line); border-radius:var(--radius);
    padding:26px 20px; text-align:left;
  }
  .price-card .plan{ font-size:14px; font-weight:600; color:var(--green-950); margin-bottom:14px; font-family:'Fraunces',serif; }
  .price-card .amount{ font-family:'Fraunces',serif; font-size:30px; color:var(--gold-500); margin-bottom:2px; }
  .price-card .per{ font-size:11.5px; color:var(--ink-500); margin-bottom:18px; display:block; }
  .price-card ul{ list-style:none; padding:0; margin:0 0 20px; display:grid; gap:9px; }
  .price-card ul li{ font-size:12.5px; color:var(--ink-900); padding-left:16px; position:relative; }
  .price-card ul li::before{ content:"–"; position:absolute; left:0; color:var(--gold-500); }
  .price-card .btn{ width:100%; justify-content:center; padding:11px; font-size:12.5px; }
  .price-note{ text-align:center; font-size:13px; margin-top:30px; color:var(--ink-500); }
  @media (max-width:1000px){ .price-grid{ grid-template-columns:repeat(2,1fr);} }
  @media (max-width:560px){ .price-grid{ grid-template-columns:1fr;} }

  /* PROCESS */
  .process{ display:grid; grid-template-columns:repeat(4,1fr); gap:30px; margin-top:56px; position:relative; }
  .process::before{
    content:""; position:absolute; top:26px; left:12%; right:12%; height:1px;
    background:rgba(198,149,47,.4);
  }
  .proc-step{ text-align:center; position:relative; }
  .proc-num{
    width:52px;height:52px;border-radius:50%; background:var(--green-950); color:var(--gold-300);
    display:flex;align-items:center;justify-content:center; margin:0 auto 20px; font-family:'Fraunces',serif;
    font-size:17px; position:relative; z-index:2; border:4px solid var(--green-950);
  }
  .band-green .proc-num{ background:var(--gold-500); color:var(--green-950); border-color:var(--green-950); }
  .band-green .process::before{ background:rgba(255,255,255,.18); }
  .proc-step h4{ font-size:15.5px; margin-bottom:8px; }
  .proc-step p{ font-size:13px; }
  @media (max-width:900px){ .process{ grid-template-columns:1fr 1fr; } .process::before{ display:none; } }
  @media (max-width:560px){ .process{ grid-template-columns:1fr; } }

  /* CTA BAND */
  .cta-band{
    background:linear-gradient(120deg,var(--gold-500),var(--gold-300));
    padding:56px 0; 
  }
  .cta-inner{ display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap; }
  .cta-inner h2{ font-size:28px; max-width:480px; }
  .cta-inner p{ color:#5B4715; margin-top:8px; max-width:480px; }
  .cta-inner .btn-outline{ border-color:var(--green-950); }

  /* FOOTER */
  footer{ background:var(--green-950); color:#C6CBC1; padding:72px 0 26px; }
  .foot-grid{ display:grid; grid-template-columns:1.6fr 1fr 1fr 1.2fr; gap:40px; padding-bottom:48px; border-bottom:1px solid rgba(255,255,255,.08); }
  .foot-grid h5{ color:var(--cream-50); font-family:'Inter',sans-serif; font-size:13px; letter-spacing:.08em; text-transform:uppercase; margin-bottom:18px; }
  .foot-grid ul{ list-style:none; padding:0; margin:0; display:grid; gap:11px; }
  .foot-grid ul a{ font-size:13.5px; color:#B9C4B7; }
  .foot-grid ul a:hover{ color:var(--gold-300); }
  .foot-brand p{ font-size:13.5px; color:#9FA99B; margin-top:14px; max-width:280px; }
  .foot-bottom{ display:flex; justify-content:space-between; padding-top:26px; font-size:12.5px; color:#8B9587; flex-wrap:wrap; gap:10px; }
  @media (max-width:900px){ .foot-grid{ grid-template-columns:1fr 1fr; } }

  @media (max-width:900px){
    .service-row{ grid-template-columns:1fr; gap:36px; }
    .service-row.reverse .media{ order:0; }
    .service-hero h1{ font-size:32px; }
  }
</style>
<section class="service-hero">
  <div class="wrap">
    <div class="crumb">Home / <span>Our Services</span></div>
    <h1>One path, five stages — <em>from first letter to Ijazah</em></h1>
    <p class="lead">Every service we offer sits on the same certified curriculum, taught one-to-one by qualified tutors. Start wherever your journey begins, and progress at your own pace toward mastery of the Qur'an and Arabic language.</p>
    <div class="cta-row">
      <a class="btn btn-gold" href="{{ url('/book-free-trial') }}">Book A Free Trial</a>
      <a class="btn btn-outline" href="{{ url('/prices') }}">View Pricing</a>
    </div>
  </div>
</section>

<!-- SIGNATURE: LEARNING PATH -->
<section class="path-section">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" style="justify-content:center">The Al Noor Curriculum</div>
      <h2>A structured <em>learning path</em>, not a class list</h2>
      <p>Each course builds on the one before it. Most students move through these stages in order — though you're welcome to join at whichever point matches your current level.</p>
    </div>
    <div class="path-rail">
      <div class="path-line"></div>
      <div class="path-steps">
        <div class="path-step">
          <div class="path-node">١</div>
          <h4>Noorani Qaida</h4>
          <p>Arabic letters, harakat &amp; first reading</p>
          <span class="lvl">Stage 1</span>
        </div>
        <div class="path-step">
          <div class="path-node">٢</div>
          <h4>Tajweed Qur'an</h4>
          <p>Correct articulation &amp; recitation rules</p>
          <span class="lvl">Stage 2</span>
        </div>
        <div class="path-step">
          <div class="path-node">٣</div>
          <h4>Hifz-ul-Qur'an</h4>
          <p>Structured memorisation with revision</p>
          <span class="lvl">Stage 3</span>
        </div>
        <div class="path-step">
          <div class="path-node">٤</div>
          <h4>Arabic Language</h4>
          <p>Conversational, MSA &amp; Qur'anic Arabic</p>
          <span class="lvl">Runs alongside</span>
        </div>
        <div class="path-step">
          <div class="path-node">٥</div>
          <h4>Ijazah Course</h4>
          <p>Certified authorisation to teach</p>
          <span class="lvl">Stage 4</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE 1: NOORANI QAIDA -->
<section class="band-cream" id="noorani-qaida">
  <div class="wrap">
    <div class="service-row">
      <div class="media">
        <span class="tag">Stage 1 · Beginners</span>
        <h3 style="margin-top:20px;">What you'll learn</h3>
        <ul class="points">
          <li>All 28 Arabic letters, in every written form</li>
          <li>Harakat — Fatha, Kasra, Damma &amp; vowel signs</li>
          <li>Joining letters into words &amp; syllables</li>
          <li>Guided reading practice with sample verses</li>
        </ul>
      </div>
      <div class="content">
        <div class="eyebrow">Foundation Course</div>
        <h3>Noorani Qaida</h3>
        <p class="desc">The first step for absolute beginners of any age. Noorani Qaida breaks the Arabic alphabet and Qur'anic reading rules into simple, guided steps — preparing every student for Tajweed and Hifz with a strong, confident foundation.</p>
        <ul class="feat">
          <li><strong>Who it's for:</strong> Children starting their Qur'an journey, adults refreshing their reading, and non-Arabic speakers seeking authentic pronunciation.</li>
          <li><strong>Format:</strong> One-to-one live online classes, with downloadable PDFs and practice exercises.</li>
          <li><strong>Progression:</strong> Regular assessments track readiness to move into Tajweed.</li>
        </ul>
        {{-- <a class="btn btn-outline" href="#">Learn About Noorani Qaida</a> --}}
      </div>
    </div>
  </div>
</section>

<!-- SERVICE 2: TAJWEED -->
<section id="tajweed">
  <div class="wrap">
    <div class="service-row reverse">
      <div class="content">
        <div class="eyebrow">Stage 2 · Kids &amp; Adults</div>
        <h3>Tajweed Qur'an</h3>
        <p class="desc">Learn to recite the Qur'an with precision and confidence. Our Tajweed course covers articulation points, pronunciation rules, and the unique characteristics of every sound — essential for reciting correctly and preserving meaning.</p>
        <ul class="feat">
          <li><strong>Core rules covered:</strong> Noon Sakin &amp; Tanween, Meem Sakin, Qalqalah, Madd, Ghunnah, and Makharij (articulation points).</li>
          <li><strong>Built for non-Arabic speakers:</strong> guided step-by-step so mispronunciation never changes meaning.</li>
          <li><strong>Flexible online timings</strong> designed around UK schedules.</li>
        </ul>
        {{-- <a class="btn btn-outline" href="#">Learn About Tajweed</a> --}}
      </div>
      <div class="media">
        <span class="tag">Stage 2 · Recitation</span>
        <h3 style="margin-top:20px;">Why parents choose it</h3>
        <ul class="points">
          <li>Tailored curriculum for both kids and adults</li>
          <li>Delivered by experienced, certified Qur'an teachers</li>
          <li>Practical, interactive lessons — not lectures</li>
          <li>Clear progression toward Hifz or Ijazah</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE 3: HIFZ -->
<section class="band-cream" id="hifz">
  <div class="wrap">
    <div class="service-row">
      <div class="media">
        <span class="tag">Stage 3 · Memorisation</span>
        <h3 style="margin-top:20px;">Features of our Hifz classes</h3>
        <ul class="points">
          <li>Individualised memorisation plans, paced to each student</li>
          <li>Daily &amp; weekly revision to prevent forgetting</li>
          <li>Regular progress tracking &amp; tutor feedback</li>
          <li>Parental involvement encouraged for younger Huffaz</li>
        </ul>
      </div>
      <div class="content">
        <div class="eyebrow">Certified Huffaz Tutors</div>
        <h3>Hifz-ul-Qur'an</h3>
        <p class="desc">A structured, supportive path to becoming a Hafiz or Hafiza — from anywhere in the world. We combine rigorous Tajweed with a memorisation method designed to build consistency without overwhelming the student.</p>
        <ul class="feat">
          <li><strong>Flexible scheduling</strong> around work, school and family life.</li>
          <li><strong>Beyond memorisation:</strong> our tutors build character, discipline and spiritual connection alongside recitation.</li>
          <li><strong>Global community</strong> of students working toward a shared goal.</li>
        </ul>
        {{-- <a class="btn btn-outline" href="#">Learn About Hifz</a> --}}
      </div>
    </div>
  </div>
</section>

<!-- SERVICE 4: ARABIC -->
<section id="arabic">
  <div class="wrap">
    <div class="service-row reverse">
      <div class="content">
        <div class="eyebrow">Runs Alongside Any Stage</div>
        <h3>Arabic Language Classes</h3>
        <p class="desc">Arabic is spoken by over 400 million people — and it's the key to engaging with the Qur'an in its original form. Our classes cover Conversational Arabic, Modern Standard Arabic (MSA), and Qur'anic Arabic for every age and level.</p>
        <ul class="feat">
          <li><strong>45 qualified teachers</strong> with a university degree in Arabic language.</li>
          <li><strong>5,500+ students taught</strong> across 20 years of experience.</li>
          <li><strong>Interactive lessons:</strong> multimedia resources, quizzes and progress tracking.</li>
        </ul>
        {{-- <a class="btn btn-outline" href="#">Learn About Arabic Classes</a> --}}
      </div>
      <div class="media">
        <span class="tag">Conversational · MSA · Qur'anic</span>
        <h3 style="margin-top:20px;">Why students stay</h3>
        <ul class="points">
          <li>Affordable pricing — courses start from £25/month</li>
          <li>Personalised lessons tailored to individual goals</li>
          <li>Experienced instructors covering both spoken &amp; Qur'anic Arabic</li>
          <li>Achievement tests to track measurable progress</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE 5: IJAZAH -->
<section class="band-cream" id="ijazah">
  <div class="wrap">
    <div class="service-row">
      <div class="media">
        <span class="tag">Stage 4 · Certification</span>
        <h3 style="margin-top:20px;">What to expect</h3>
        <ul class="points">
          <li>Advanced Tajweed &amp; Qur'anic recitation refinement</li>
          <li>Selected Hadith studies for deeper Islamic knowledge</li>
          <li>Recitation of the full Qur'an to a certified teacher</li>
          <li>Formal Ijazah certification on completion</li>
        </ul>
      </div>
      <div class="content">
        <div class="eyebrow">The Highest Level</div>
        <h3>Ijazah Qur'an Course</h3>
        <p class="desc">An Ijazah is a formal authorisation to teach and recite the Qur'an, passed down through an unbroken chain of certified scholars back to the Prophet ﷺ. It is the top level of achievement in Qur'anic study — and the ability to pass that certification on to others.</p>
        <ul class="feat">
          <li><strong>Who it's for:</strong> aspiring reciters, future Islamic educators, and dedicated students seeking the highest level of certification.</li>
          <li><strong>Taught by:</strong> certified scholars who hold their own Ijazah.</li>
          <li><strong>Outcome:</strong> a credential connecting you to an authentic, unbroken chain of transmission.</li>
        </ul>
        {{-- <a class="btn btn-outline" href="#">Learn About Ijazah</a> --}}
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
{{-- <section id="pricing">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" style="justify-content:center">Simple &amp; Transparent</div>
      <h2>Choose your <em>learning plan</em></h2>
      <p>Sample pricing shown for our Tajweed programme — every course follows the same transparent, no-hidden-fee structure. All plans include a free trial class.</p>
    </div>
    <div class="price-toggle">
      <span class="active">Monthly Plans</span>
      <span>Pay As You Go</span>
    </div>
    <div class="price-grid">
      <div class="price-card">
        <div class="plan">8 Classes / Month</div>
        <div class="amount">£25</div>
        <span class="per">per month</span>
        <ul>
          <li>2 days per week</li>
          <li>30 mins per day</li>
          <li>Up to 3 free trial classes</li>
          <li>High quality, low fees</li>
        </ul>
        <a class="btn btn-outline" href="#">Enroll Now</a>
      </div>
      <div class="price-card">
        <div class="plan">12 Classes / Month</div>
        <div class="amount">£30</div>
        <span class="per">per month</span>
        <ul>
          <li>3 days per week</li>
          <li>30 mins per day</li>
          <li>Up to 30% discount now</li>
          <li>Up to 3 free trial classes</li>
        </ul>
        <a class="btn btn-outline" href="#">Enroll Now</a>
      </div>
      <div class="price-card" style="border-color:var(--gold-500); box-shadow:0 8px 24px rgba(198,149,47,.14);">
        <div class="plan">16 Classes / Month</div>
        <div class="amount">£40</div>
        <span class="per">per month</span>
        <ul>
          <li>4 days per week</li>
          <li>30 mins per day</li>
          <li>Up to 30% discount now</li>
          <li>Most popular plan</li>
        </ul>
        <a class="btn btn-gold" href="#">Enroll Now</a>
      </div>
      <div class="price-card">
        <div class="plan">20 Classes / Month</div>
        <div class="amount">£45</div>
        <span class="per">per month</span>
        <ul>
          <li>5 days per week</li>
          <li>30 mins per day</li>
          <li>Up to 30% discount now</li>
          <li>High quality, low fees</li>
        </ul>
        <a class="btn btn-outline" href="#">Enroll Now</a>
      </div>
      <div class="price-card">
        <div class="plan">24 Classes / Month</div>
        <div class="amount">£50</div>
        <span class="per">per month</span>
        <ul>
          <li>6 days per week</li>
          <li>30 mins per day</li>
          <li>Up to 30% discount now</li>
          <li>High quality, low fees</li>
        </ul>
        <a class="btn btn-outline" href="#">Enroll Now</a>
      </div>
    </div>
    <p class="price-note">Prices shown in GBP (£) — USD and AED also available at checkout.</p>
  </div>
</section> --}}

<!-- WHY CHOOSE US -->
<section class="band-cream">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" style="justify-content:center">Why Families Choose Al Noor</div>
      <h2>Every course, built the <em>same trusted way</em></h2>
    </div>
    <div class="pillars">
      <div class="pillar">
        <div class="icon">✓</div>
        <h4>Certified Scholars</h4>
        <p>Every tutor holds their own recognised Ijazah or Quranic qualification, screened before joining.</p>
      </div>
      <div class="pillar">
        <div class="icon">⏱</div>
        <h4>Flexible Scheduling</h4>
        <p>Classes run 7 days a week — morning, afternoon or evening — around your family's routine.</p>
      </div>
      <div class="pillar">
        <div class="icon">☺</div>
        <h4>Personalised Attention</h4>
        <p>One-to-one lessons only. No classes, no distractions — just your child and their dedicated tutor.</p>
      </div>
      <div class="pillar">
        <div class="icon">◎</div>
        <h4>Global Accessibility</h4>
        <p>Learn from anywhere with an internet connection — the only prerequisite is the desire to learn.</p>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="band-green">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" style="justify-content:center">Simple Process</div>
      <h2>How to <em>get started</em></h2>
    </div>
    <div class="process">
      <div class="proc-step">
        <div class="proc-num">01</div>
        <h4>Book A Free Trial</h4>
        <p>Tell us your child's age and current level in a short enquiry form.</p>
      </div>
      <div class="proc-step">
        <div class="proc-num">02</div>
        <h4>Meet Your Tutor</h4>
        <p>We match you with a certified tutor suited to your goals and schedule.</p>
      </div>
      <div class="proc-step">
        <div class="proc-num">03</div>
        <h4>Trial Lesson</h4>
        <p>Experience a taster class — completely free, with no commitment.</p>
      </div>
      <div class="proc-step">
        <div class="proc-num">04</div>
        <h4>Begin Your Path</h4>
        <p>Start regular lessons and progress stage by stage, at your own pace.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA BAND -->
{{-- <section class="cta-band">
  <div class="wrap cta-inner">
    <div>
      <h2>Ready to begin the journey?</h2>
      <p>Join thousands of students learning the Qur'an and Arabic online with Al Noor Tutoring.</p>
    </div>
    <a class="btn btn-outline" href="{{ url('/book-free-trial') }}">Book A Free Trial</a>
  </div>
</section> --}}
@endsection