@extends('layouts.frontend')
@section('title', 'Admission - Merit Education Foundation')
@section('content')
    <div class="book-hero">
        <div class="container">
            <div class="page-hero-badge"><span>Book a Lesson</span></div>
            <h1 class="page-hero-h mb-3">
                Start Your Child's<br><em>Learning Journey</em> Today
            </h1>
            <p class="page-hero-p mb-4">
                Expert 1-to-1 online Quran lessons — flexible, structured, and taught by qualified tutors. Begin with a free
                trial lesson, no commitment required.
            </p>
            <div class="hero-trust mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,.08)">
                <span class="trust-item"><i class="fas fa-shield-alt"></i>DBS Checked Tutors</span>
                <span class="trust-item"><i class="fas fa-video"></i>Lessons via Zoom / Teams</span>
                <span class="trust-item"><i class="fas fa-gift"></i>Free Trial Lesson</span>
                <span class="trust-item"><i class="fas fa-clock"></i>Flexible Scheduling</span>
                <span class="trust-item"><i class="fas fa-certificate"></i>Qualified Tutors</span>
            </div>
        </div>
    </div>

        <section class="section-cream">
        <div class="container">
            <div class="text-center mb-5" data-r="up">
                <div class="eyebrow justify-content-center">
                    <div class="eyebrow-line"></div>
                    <span class="eyebrow-txt">What We Offer</span>
                    <div class="eyebrow-line"></div>
                </div>
                <h2 class="sec-h">Structured, Expert <em>Quran Learning</em></h2>
                <div class="divider-gold center"></div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-r="up">
                    <div class="offer-card">
                        <div class="offer-ic"><i class="fas fa-user-graduate"></i></div>
                        <h5>1-to-1 Online Lessons</h5>
                        <p>Personal attention from a qualified tutor — no classes, no distractions. Just your child and
                            their dedicated teacher.</p>
                    </div>
                </div>
                <div class="col-md-4" data-r="up" style="transition-delay:.1s">
                    <div class="offer-card">
                        <div class="offer-ic"><i class="fas fa-calendar-alt"></i></div>
                        <h5>Flexible Timings</h5>
                        <p>Morning, afternoon or evening slots — 7 days a week. Choose what works for your family's
                            schedule.</p>
                    </div>
                </div>
                <div class="col-md-4" data-r="up" style="transition-delay:.2s">
                    <div class="offer-card">
                        <div class="offer-ic"><i class="fas fa-layer-group"></i></div>
                        <h5>Structured Learning</h5>
                        <p>From Qaida for beginners to full Quran recitation and Tajweed — a clear progression for every
                            student.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ═══════════════ HOW IT WORKS ═══════════════ -->
    <section class="section-cream">
        <div class="container">
            <div class="text-center mb-5" data-r="up">
                <div class="eyebrow justify-content-center">
                    <div class="eyebrow-line"></div><span class="eyebrow-txt">Simple Process</span>
                    <div class="eyebrow-line"></div>
                </div>
                <h2 class="sec-h">How It <em>Works</em></h2>
                <div class="divider-gold center"></div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-6 position-relative" data-r="up">
                    <div class="step-card">
                        <div class="step-num">01</div>
                        <div class="step-ic"><i class="fas fa-mouse-pointer"></i></div>
                        <h5>Choose a Plan</h5>
                        <p>Select the lesson category and plan that best suits your child's age, level and schedule.</p>
                    </div>
                    <div class="step-connector d-none d-lg-block"></div>
                </div>
                <div class="col-lg-3 col-6 position-relative" data-r="up" style="transition-delay:.1s">
                    <div class="step-card">
                        <div class="step-num">02</div>
                        <div class="step-ic"><i class="fas fa-file-alt"></i></div>
                        <h5>Fill Enquiry Form</h5>
                        <p>Complete our short form with your child's details, learning level and preferred time slot.</p>
                    </div>
                    <div class="step-connector d-none d-lg-block"></div>
                </div>
                <div class="col-lg-3 col-6 position-relative" data-r="up" style="transition-delay:.2s">
                    <div class="step-card">
                        <div class="step-num">03</div>
                        <div class="step-ic"><i class="fas fa-comments"></i></div>
                        <h5>Free Trial Lesson</h5>
                        <p>We'll match your child with a tutor and arrange a completely free trial session — no obligation.
                        </p>
                    </div>
                    <div class="step-connector d-none d-lg-block"></div>
                </div>
                <div class="col-lg-3 col-6" data-r="up" style="transition-delay:.3s">
                    <div class="step-card">
                        <div class="step-num">04</div>
                        <div class="step-ic"><i class="fas fa-rocket"></i></div>
                        <h5>Begin Learning</h5>
                        <p>Start your regular lessons and watch your child's Quran knowledge grow week by week.</p>
                    </div>
                </div>
            </div>
        </div>
        
    </section>


  <div class="cta-block"><div class="container"><div class="inner">
    <div class="row align-items-center g-4">
      <div class="col-lg-7"><h2 class="display-h" style="font-size:clamp(1.7rem,3.5vw,2.5rem);color:var(--navy)">Ready to Make a Difference?</h2><p style="color:rgba(15,31,92,.6);margin-top:10px;font-size:.92rem">Book a lesson or donate today and become part of something bigger.</p></div>
      <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end">
        <a class="btn-navy" href="{{ route('prices.lesson') }}"><i class="fas fa-graduation-cap"></i>Book a Lesson</a>
      
      </div>
    </div>
  </div></div></div>
@endsection