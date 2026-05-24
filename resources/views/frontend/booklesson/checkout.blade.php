@extends('layouts.frontend')
@section('title', 'Book a Lesson - Merit Education Foundation')

@section('content')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
/* ═══════════════════════════════
   SHARED COMPONENTS
═══════════════════════════════ */
section{padding:90px 0}
.section-cream{background:var(--cream)}
.section-light{background:var(--light)}
.eyebrow{display:inline-flex;align-items:center;gap:10px;margin-bottom:16px}
.eyebrow-line{width:28px;height:1.5px;background:var(--gold)}
.eyebrow-txt{font-size:.68rem;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--gold)}
.sec-h{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(1.9rem,4vw,3rem);font-weight:700;line-height:1.1;color:var(--navy);
}
.sec-h em{font-style:italic;color:var(--gold)}
.sec-p{color:var(--muted);font-size:.95rem;line-height:1.85;font-weight:300}
.divider-gold{
  width:52px;height:2.5px;background:linear-gradient(to right,var(--gold),var(--gold2));
  border-radius:2px;margin:18px 0;
}
.divider-gold.center{margin:18px auto}

/* Buttons */
.btn-gold{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--gold);color:var(--navy);
  padding:14px 34px;border-radius:9px;font-weight:700;font-size:.8rem;
  letter-spacing:1.8px;text-transform:uppercase;border:none;cursor:pointer;
  transition:all .3s;box-shadow:0 6px 24px rgba(201,168,76,.3);
}
.btn-gold:hover{background:var(--gold2);transform:translateY(-2px);box-shadow:0 12px 36px rgba(201,168,76,.4);color:var(--navy)}
.btn-navy{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--navy);color:var(--white);
  padding:14px 34px;border-radius:9px;font-weight:700;font-size:.8rem;
  letter-spacing:1.8px;text-transform:uppercase;border:none;cursor:pointer;transition:all .3s;
}
.btn-navy:hover{background:var(--navy2);transform:translateY(-2px);box-shadow:0 12px 36px rgba(15,31,92,.25);color:var(--white)}

/* Form fields */
.field-label{
  font-size:.68rem;font-weight:700;letter-spacing:1.8px;
  text-transform:uppercase;color:var(--navy);margin-bottom:8px;display:block;
}
.field-input,.field-select,.field-textarea{
  width:100%;padding:13px 16px;border:1.5px solid var(--border);
  border-radius:9px;font-family:'DM Sans',sans-serif;font-size:.9rem;
  color:var(--txt);background:var(--cream);outline:none;transition:all .3s;
}
.field-input:focus,.field-select:focus,.field-textarea:focus{
  border-color:var(--gold);background:var(--white);
  box-shadow:0 0 0 4px rgba(201,168,76,.1);
}
.field-input::placeholder,.field-textarea::placeholder{color:rgba(124,124,144,.45)}
.field-textarea{resize:none}
.field-group{margin-bottom:20px}

/* Validation error highlight */
.field-input.is-invalid,
.field-select.is-invalid,
.field-textarea.is-invalid{
  border-color:#dc3545 !important;
  box-shadow:0 0 0 4px rgba(220,53,69,.1) !important;
}
.invalid-feedback{
  display:block;
  color:#dc3545;
  font-size:.75rem;
  margin-top:4px;
}
</style>

<div class="book-hero">
  <div class="container">
    <div class="page-hero-badge"><span>Book a Lesson</span></div>
    <h1 class="page-hero-h mb-3">
      Start Your Child's<br><em>Learning Journey</em> Today
    </h1>
    <p class="page-hero-p mb-4">
      Expert 1-to-1 online Quran lessons — flexible, structured, and taught by qualified tutors. Begin with a free trial lesson, no commitment required.
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

<!-- ═══════════════ BOOKING FORM ═══════════════ -->
<section id="booking-form-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12" data-r="up">
        <div class="book-form-wrap">

          <div id="book-form-body">
            <div class="eyebrow">
              <div class="eyebrow-line"></div>
              <span class="eyebrow-txt">Enquiry Form</span>
            </div>
            <h2 class="sec-h mb-2">Book a Lesson <em>Now</em></h2>
            <p class="book-form-intro">
              Fill in the details below and we'll be in touch within 24 hours to arrange your free trial lesson. No commitment required.
            </p>

            {{-- FIX: onsubmit passes event so we can call preventDefault() --}}
            <form id="book-lesson-form" >
              @csrf

              <div class="row g-3">

                {{-- Parent / Guardian --}}
                <div class="col-md-6">
                    <div class="field-group">
                      <label class="field-label">Parent / Guardian Name *</label>
                      <input type="text" class="field-input" name="parent_name" placeholder="Your full name">
                      <span class="text-danger error-text parent_name_error"></span>
                    </div>
                 
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Email *</label>
                    <input type="email" class="field-input" name="email" placeholder="you@email.com">
                    <span class="text-danger error-text email_error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Phone *</label>
                    <input type="tel" class="field-input" name="phone" placeholder="+44 7000 000000">
                    <span class="text-danger error-text phone_error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Emergency Phone *</label>
                    <input type="tel" class="field-input" name="emergency_phone" placeholder="+44 7000 000000">
                    <span class="text-danger error-text emergency_phone_error"></span>
                  </div>
                </div>

                {{-- Address --}}
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Address *</label>
                    <input type="text" class="field-input" name="address" placeholder="Your address">
                    <span class="text-danger error-text address_error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Post Code *</label>
                    <input type="text" class="field-input" name="post_code" placeholder="Your post code">
                    <span class="text-danger error-text post_code_error"></span>
                  </div>
                </div>

                {{-- Student --}}
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Student First Name *</label>
                    <input type="text" class="field-input" name="student_first_name" placeholder="Student's first name">
                    <span class="text-danger error-text student_first_name_error"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Student Last Name *</label>
                    <input type="text" class="field-input" name="student_last_name" placeholder="Student's last name">
                    <span class="text-danger error-text student_last_name_error"></span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Package</label>
                    <select class="field-select" name="package_id">
                      <option value="">Select level...</option>
                      @foreach ($allPackage as $package)

                        <option value="{{ $package->id }}" >{{ $package->name }} {{ $package->duration }}</option>
                        
                      @endforeach
                      
                    </select>
                  </div>
                </div>
                {{-- Lesson preferences --}}
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Current Quran Level</label>
                    <select class="field-select" name="current_level">
                      <option value="">Select level...</option>
                      <option value="Complete Beginner">Complete Beginner</option>
                      <option value="Qaida / Basics">Qaida / Basics</option>
                      <option value="Reading Quran">Reading Quran</option>
                      <option value="Tajweed">Tajweed</option>
                      <option value="Hifz (Memorisation)">Hifz (Memorisation)</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Preferred Tutor *</label>
                    <select class="field-select" name="preferred_tutor">
                      <option value="">Select preference...</option>
                      <option value="Not Specified">Not Specified</option>
                      <option value="Male Tutor">Male Tutor</option>
                      <option value="Female Tutor">Female Tutor</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="field-group">
                    <label class="field-label">Preferred Time *</label>
                    {{--
                      IMPORTANT: The option values here use an en-dash (–).
                      They MUST match the exact characters in your validator's in: rule.
                      If you change these, update the controller validator too.
                    --}}
                    <select class="field-select" name="preferred_time">
                      <option value="">Select preference...</option>
                      <option value="Morning (8am–12pm)">Morning (8am–12pm)</option>
                      <option value="Afternoon (12pm–5pm)">Afternoon (12pm–5pm)</option>
                      <option value="Evening (5pm–9pm)">Evening (5pm–9pm)</option>
                      <option value="Weekend only">Weekend only</option>
                      <option value="Flexible — any time">Flexible — any time</option>
                    </select>
                  </div>
                </div>

                {{-- Notes --}}
                <div class="col-12">
                  <div class="field-group">
                    <label class="field-label">Additional Notes</label>
                    <textarea class="field-textarea" rows="3" name="notes" placeholder="Any specific goals, requirements, or questions about the plan..."></textarea>
                  </div>
                </div>

                {{-- Gift Aid notice --}}
                <div class="col-12">
                  <div class="gift-aid-note">
                    <i class="fas fa-gift"></i>
                    <p>
                      Would you like to add an <strong>optional donation</strong> alongside your lesson booking? Donations are separate from lesson fees and are <strong>Gift Aid eligible</strong> if you're a UK taxpayer.
                      <a href="/donate" style="color:var(--gold);font-weight:600">Visit our Donate page →</a>
                    </p>
                  </div>
                </div>

                <div class="col-12 mt-2">
                  <button type="submit" id="book-submit-btn" class="btn-gold" style="width:100%;justify-content:center;padding:16px;font-size:.85rem">
                    <i class="fas fa-graduation-cap" id="btn-icon"></i>
                    <i class="fas fa-spinner fa-spin" id="btn-spinner" style="display:none"></i>
                    Book a Lesson Now
                  </button>
                </div>

                <div class="col-12">
                  <p style="font-size:.72rem;color:var(--muted);text-align:center;margin-top:4px">
                    <i class="fas fa-shield-alt" style="color:var(--gold);margin-right:5px"></i>
                    By submitting, you agree to our <a href="/terms" style="color:var(--gold)">Terms & Conditions</a> and <a href="/privacy" style="color:var(--gold)">Privacy Policy</a>.
                  </p>
                </div>

              </div>{{-- end .row --}}
            </form>
          </div>{{-- end #book-form-body --}}

          <div class="success-msg" id="book-success" style="display:none">
            <i class="fas fa-check-circle"></i>
            <h5>Enquiry Received!</h5>
            <p>Thank you for reaching out. We'll contact you within 24 hours to confirm your free trial lesson. Jazakallah Khair.</p>
            <button class="btn-navy mt-3" onclick="window.location.href='/'">
              <i class="fas fa-home"></i>Return Home
            </button>
          </div>

        </div>{{-- end .book-form-wrap --}}
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════ CTA ═══════════════ -->
<div class="cta-block">
  <div class="container"><div class="inner">
    <div class="row align-items-center g-4">
      <div class="col-lg-7" data-r="left">
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;color:var(--navy)">
          Questions About Our Plans?
        </h2>
        <p style="color:rgba(15,31,92,.65);font-size:.92rem;margin-top:10px;font-weight:300;max-width:440px">
          Not sure which plan is right for your child? Our team is happy to guide you — contact us for a free consultation.
        </p>
      </div>
      <div class="col-lg-5 d-flex flex-wrap gap-3 justify-content-lg-end" data-r="right">
        <button class="btn-navy" onclick="window.location.href='/contact'"><i class="fas fa-comments"></i>Talk to Us</button>
        <button class="btn-gold" onclick="scrollToForm()"><i class="fas fa-graduation-cap"></i>Book a Free Trial</button>
      </div>
    </div>
  </div></div>
</div>


<script>
        $(document).ready(function() {

            $('#book-lesson-form').submit(function(e) {
                e.preventDefault();

                $('.error-text').text('');

                $.ajax({
                    url: "{{ route('checkout.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {

                        if (response.status == 'success') {
                            $('#book-lesson-form')[0].reset();

                            $('#book-form-body').hide();
                            $('#book-success').show();
                        }
                    },
                    error: function(xhr) {

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                $('.' + key + '_error').text(value[0]);
                            });
                        }
                    }
                });

            });

        });
    </script>
@endsection