<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

  .qtm * { box-sizing: border-box; }

  .qtm {
    --teal-dark: #0B3B3E;
    --teal: #10666F;
    --teal-light: #1B93A1;
    --accent: #F2994A;
    --field-bg: #F6F9F9;
    --field-border: #DEE8E7;
    --text: #1C2624;
    --text-soft: #5B6864;
    --req: #E0554A;
    --error: #D24B3F;
    --error-bg: #FCEEEC;

    font-family: 'Inter', sans-serif;

    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    height: 100dvh;

    background: rgba(9, 26, 27, 0.68);
    backdrop-filter: blur(2px);

    display: none; /* shown via JS */
    justify-content: center;
    align-items: center;

    padding: 20px;
    z-index: 999999;
    overflow-y: auto;
  }

  @keyframes popup {
    from { opacity: 0; transform: translateY(16px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }

  .qtm-modal {
    position: relative;
    width: 100%;
    max-width: 640px;

    background: #fff;
    border-radius: 20px;
    overflow: hidden;

    box-shadow: 0 30px 70px rgba(0,0,0,0.35);

    max-height: 92vh;
    max-height: 92dvh;
    display: flex;
    flex-direction: column;

    animation: popup .35s ease;
    margin: auto;
  }

  /* ---------- Header ---------- */
  .qtm-head {
    position: relative;
    background: linear-gradient(135deg, var(--teal-dark), var(--teal-light));
    padding: 30px 40px 26px;
    flex-shrink: 0;
    overflow: hidden;
  }

  .qtm-head::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.14) 1.4px, transparent 1.4px);
    background-size: 16px 16px;
    opacity: 0.5;
  }

  .qtm-head::after {
    content: "";
    position: absolute;
    right: -40px;
    top: -50px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
  }

  .qtm-close {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.16);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
    transition: background .15s ease;
  }
  .qtm-close:hover { background: rgba(255,255,255,0.28); }

  .qtm-badge {
    position: relative;
    z-index: 1;
    width: 42px;
    height: 42px;
    background: rgba(255,255,255,0.16);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
  }

  .qtm-title {
    position: relative;
    z-index: 1;
    font-family: 'Baloo 2', sans-serif;
    font-size: 27px;
    font-weight: 800;
    color: #fff;
    line-height: 1.25;
    margin: 0 0 8px;
    max-width: 460px;
  }

  .qtm-subtitle {
    position: relative;
    z-index: 1;
    font-size: 13px;
    color: #C9E6E3;
    font-weight: 500;
    max-width: 420px;
    line-height: 1.5;
  }

  /* ---------- Body ---------- */
  .qtm-body {
    padding: 30px 40px 32px;
    overflow-y: auto;
  }

  .qtm-hp { position: absolute; left: -9999px; top: -9999px; opacity: 0; height: 0; width: 0; }

  .qtm-banner {
    display: none;
    align-items: center;
    gap: 9px;
    background: var(--error-bg);
    color: var(--error);
    border: 1px solid #F3CAC4;
    border-radius: 9px;
    padding: 11px 14px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 18px;
  }

  .qtm-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px 16px;
    margin-bottom: 6px;
  }

  .qtm-field { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
  .qtm-field.full { grid-column: 1 / -1; }

  .qtm-label {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text);
  }

  .qtm-req { color: var(--req); }

  .qtm-input-wrap { position: relative; }

  .qtm-input-wrap svg {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #96A6A3;
    pointer-events: none;
  }

  .qtm-input,
  .qtm-select {
    border: 1.5px solid var(--field-border);
    border-radius: 9px;
    padding: 11px 12px 11px 36px;
    font-size: 13.5px;
    font-family: 'Inter', sans-serif;
    color: var(--text);
    background: var(--field-bg);
    width: 100%;
    outline: none;
    transition: border-color .15s ease, background .15s ease, box-shadow .15s ease;
  }

  .qtm-input:focus,
  .qtm-select:focus {
    border-color: var(--teal-light);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(27,147,161,0.14);
  }

  .qtm-input::placeholder { color: #9AA6A4; }

  .qtm-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%235B6864' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 30px;
    color: #6B7876;
  }

  .qtm-input--error,
  .qtm-select--error {
    border-color: var(--error) !important;
    background: var(--error-bg) !important;
  }

  .qtm-error-msg {
    font-size: 11.5px;
    color: var(--error);
    font-weight: 500;
    min-height: 14px;
  }

  /* ---------- Class time pills ---------- */
  .qtm-pill-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding-top: 2px;
  }

  .qtm-pill-row--error .qtm-pill span { border-color: var(--error); }

  .qtm-pill {
    position: relative;
    cursor: pointer;
  }

  .qtm-pill input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    cursor: pointer;
  }

  .qtm-pill span {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-soft);
    background: var(--field-bg);
    border: 1.5px solid var(--field-border);
    border-radius: 20px;
    padding: 8px 16px;
    transition: all .15s ease;
    white-space: nowrap;
  }

  .qtm-pill:has(input:checked) span {
    background: var(--teal-dark);
    border-color: var(--teal-dark);
    color: #fff;
  }

  /* ---------- Bottom ---------- */
  .qtm-cta {
    width: 100%;
    background: linear-gradient(135deg, var(--teal), var(--teal-light));
    color: #fff;
    border: none;
    padding: 15px;
    border-radius: 11px;
    font-family: 'Baloo 2', sans-serif;
    font-size: 17px;
    font-weight: 700;
    letter-spacing: 0.2px;
    cursor: pointer;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    transition: filter .15s ease, transform .15s ease, opacity .15s ease;
  }
  .qtm-cta:hover:not(:disabled) { filter: brightness(1.08); transform: translateY(-1px); }
  .qtm-cta:disabled { opacity: 0.75; cursor: not-allowed; transform: none; }

  .qtm-cta-icon { display: inline-flex; }

  .qtm-spinner {
    width: 16px;
    height: 16px;
    border: 2.5px solid rgba(255,255,255,0.4);
    border-top-color: #fff;
    border-radius: 50%;
    display: none;
    animation: qtm-spin .7s linear infinite;
  }

  .qtm-cta--loading .qtm-cta-icon { display: none; }
  .qtm-cta--loading .qtm-spinner { display: inline-block; }

  @keyframes qtm-spin { to { transform: rotate(360deg); } }

  .qtm-trust {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-soft);
    font-weight: 500;
    margin-top: 12px;
  }

  .qtm-trust svg { color: var(--teal-light); flex-shrink: 0; }

  /* ---------- Success state ---------- */
  .qtm-success {
    display: none;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 20px 10px 8px;
  }

  .qtm-success-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #E5F4EE;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1F9D65;
    margin-bottom: 16px;
  }

  .qtm-success-title {
    font-family: 'Baloo 2', sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: var(--teal-dark);
    margin-bottom: 8px;
  }

  .qtm-success-text {
    font-size: 13.5px;
    color: var(--text-soft);
    line-height: 1.6;
    max-width: 380px;
  }

  /* ===== Tablet ===== */
  @media (max-width: 992px) {
    .qtm { padding: 20px; }
    .qtm-modal { max-width: 92%; }
    .qtm-head { padding: 26px 30px 22px; }
    .qtm-body { padding: 26px 30px 28px; }
    .qtm-title { font-size: 24px; }
  }

  /* ===== Mobile ===== */
  @media (max-width: 560px) {
    .qtm { padding: 0; align-items: flex-end; }
    .qtm-modal {
      max-width: 100%;
      max-height: 94dvh;
      border-radius: 20px 20px 0 0;
    }
    .qtm-head { padding: 22px 20px 20px; }
    .qtm-badge { width: 36px; height: 36px; margin-bottom: 10px; }
    .qtm-title { font-size: 19px; }
    .qtm-subtitle { font-size: 12px; }
    .qtm-close { top: 12px; right: 12px; width: 28px; height: 28px; }
    .qtm-body { padding: 22px 18px 24px; }
    .qtm-form-grid { grid-template-columns: 1fr; gap: 14px; }
    .qtm-input, .qtm-select { font-size: 16px; padding: 11px 12px 11px 36px; } /* 16px avoids iOS zoom */
    .qtm-pill-row { gap: 8px; }
    .qtm-pill span { padding: 9px 14px; font-size: 12.5px; }
    .qtm-cta { padding: 15px; font-size: 16px; }
  }

  @media (max-width: 360px) {
    .qtm-title { font-size: 17px; }
  }
</style>

<div class="qtm" id="trialModal" role="dialog" aria-modal="true" aria-labelledby="trialModalTitle">
  <div class="qtm-modal">

    <div class="qtm-head">
      <div class="qtm-close" id="closeTrialModal" role="button" aria-label="Close">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </div>

      <div class="qtm-badge">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 5.5C2 4.5 3 4 4.5 4c2.5 0 4.5 1 5.5 2v13c-1-1-3-2-5.5-2C3 17 2 17.5 2 18.5v-13Z"/><path d="M22 5.5C22 4.5 21 4 19.5 4c-2.5 0-4.5 1-5.5 2v13c1-1 3-2 5.5-2 1.5 0 2.5.5 2.5 1.5v-13Z"/></svg>
      </div>

      <div class="qtm-title" id="trialModalTitle">Book Your Child's FREE Quran Trial Class</div>
      <div class="qtm-subtitle">Trusted by 5,000+ families across the UK — matched with a tutor within 24 hours.</div>
    </div>

    <div class="qtm-body">

      <div class="qtm-banner" id="qtmBanner" role="alert">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
        <span id="qtmBannerText">Something went wrong. Please try again.</span>
      </div>

      <form id="freeTrialForm" method="POST" action="{{ url('book-free-trial') }}">
                    @csrf
        <!-- honeypot: real users never see or fill this in -->
        <input class="qtm-hp" type="text" name="website" tabindex="-1" autocomplete="off">
        @csrf
        <div class="qtm-form-grid">
          <div class="qtm-field">
            <label class="qtm-label" for="qtm-parent_name">Parent Name <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-6 8-6s8 2 8 6"/></svg>
              <input class="qtm-input" type="text" id="qtm-parent_name" name="parent_name" placeholder="e.g. Sarah Ahmad">
            
            </div>
            <small class="text-danger error-text parent_name_error"></small>
          </div>
          <div class="qtm-field">
            <label class="qtm-label" for="qtm-child_name">Child Name <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="4"/><path d="M5 21c0-4 3-6 7-6s7 2 7 6"/></svg>
              <input class="qtm-input" type="text" id="qtm-child_name" name="child_name" placeholder="e.g. Yusuf Ahmad">
            </div>
           <small class="text-danger error-text child_age_error"></small>
          </div>

          <div class="qtm-field">
            <label class="qtm-label" for="qtm-child_age">Child's Age <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>
              <select class="qtm-select" id="qtm-child_age" name="child_age">
                <option value="">Select Child's Age</option>
                <option value="4-6">4 – 6 years</option>
                <option value="7-9">7 – 9 years</option>
                <option value="10-12">10 – 12 years</option>
                <option value="13-15">13 – 15 years</option>
                <option value="16-17">16 – 17 years</option>
                <option value="adult">Adult</option>
              </select>
            </div>  <small class="text-danger error-text current_level_error"></small>
          </div>
          <div class="qtm-field">
            <label class="qtm-label" for="qtm-current_level">Current Level <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V10M12 20V4M20 20v-6"/></svg>
              <select class="qtm-select" id="qtm-current_level" name="current_level">
                <option value="">Select level</option>
                <option value="beginner">Complete beginner</option>
                <option value="qaida">Qaida</option>
                <option value="nazra">Nazra (reading)</option>
                <option value="tajweed">Tajweed</option>
                <option value="hifz">Hifz (memorisation)</option>
              </select>
            </div>
             <small class="text-danger error-text tutor_gender_error"></small>
          </div>

          <div class="qtm-field">
            <label class="qtm-label" for="qtm-tutor_gender">Preferred Tutor Gender <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.2"/><circle cx="17" cy="9" r="2.6"/><path d="M3.5 20c0-3.2 2.5-5 5.5-5s5.5 1.8 5.5 5M15 20c0-2.3 1.6-4 4-4s4 1.7 4 4"/></svg>
              <select class="qtm-select" id="qtm-tutor_gender" name="tutor_gender">
                <option value="no-preference">No preference</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
             <small class="text-danger error-text tutor_gender_error"></small>
          </div>
          <div class="qtm-field">
            <label class="qtm-label" for="qtm-country">Your Country <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.5 4 6 4 9s-1.5 6.5-4 9c-2.5-2.5-4-6-4-9s1.5-6.5 4-9Z"/></svg>
              <select class="qtm-select" id="qtm-country" name="country">
                <option value="">Select Country Name</option>
                <option value="UK">United Kingdom</option>
                <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="AU">Australia</option>
                <option value="other">Other</option>
              </select>
            </div>
            <small class="text-danger error-text country_error"></small>
          </div>

          <div class="qtm-field">
            <label class="qtm-label" for="qtm-email">Email Address <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 6.5 8 6.5 8-6.5"/></svg>
              <input class="qtm-input" type="email" id="qtm-email" name="email" placeholder="you@email.com">
            </div>
          <small class="text-danger error-text email_error"></small>
          </div>
          <div class="qtm-field">
            <label class="qtm-label" for="qtm-whatsapp">Whatsapp Number <span class="qtm-req">*</span></label>
            <div class="qtm-input-wrap">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h3l1.5 5-2 1.5a11 11 0 0 0 5 5l1.5-2 5 1.5v3a2 2 0 0 1-2 2C10.5 19 5 13.5 4 6a2 2 0 0 1 2-3Z"/></svg>
              <input class="qtm-input" type="tel" id="qtm-whatsapp" name="whatsapp" placeholder="+1 000 000 0000">
            </div>
            
                                <small class="text-danger error-text whatsapp_error"></small>
          </div>

          <div class="qtm-field full">
            <label class="qtm-label">Preferred Class Time <span class="qtm-req">*</span></label>
            <div class="qtm-pill-row" id="qtmTimeRow">
              <label class="qtm-pill">
                <input type="radio" name="time" value="Morning">
                <span>☀️ Morning</span>
              </label>
              <label class="qtm-pill">
                <input type="radio" name="time" value="Afternoon">
                <span>🌤️ Afternoon</span>
              </label>
              <label class="qtm-pill">
                <input type="radio" name="time" value="Evening">
                <span>🌙 Evening</span>
              </label>
              <label class="qtm-pill">
                <input type="radio" name="time" value="Flexible">
                <span>🔁 Flexible</span>
              </label>
            </div>
           <small class="text-danger error-text time_error"></small>
          </div>
        </div>

        <button class="qtm-cta" type="submit" id="qtmSubmitBtn">
          <span class="qtm-cta-text">Start Free Trial</span>
          <span class="qtm-cta-icon">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </span>
          <span class="qtm-spinner"></span>
        </button>

        <div class="qtm-trust">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
          No payment required — your first class is completely free
        </div>
      </form>

      <div class="qtm-success" id="qtmSuccess">
        <div class="qtm-success-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="qtm-success-title">You're all set!</div>
        <div class="qtm-success-text">Thanks for booking a free trial. A member of our team will reach out on WhatsApp or email within 24 hours to confirm your first class.</div>
      </div>

    </div>

  </div>
</div>


<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
$('#freeTrialForm').submit(function(e){

    e.preventDefault();

    let form=$(this);

    let btn=$("#submitBtn");

    $(".error-text").text("");

    btn.html('<i class="fa fa-spinner fa-spin"></i> Please Wait...');
    btn.prop('disabled',true);

    $.ajax({

        url:form.attr('action'),

        type:"POST",

        data:form.serialize(),

        success:function(response){

            btn.html("Send");
            btn.prop('disabled',false);

            if(response.status){


    form.trigger("reset");

    // Hide modal
    $("#trialModal").fadeOut(300);

    // Enable body scroll
    $("body").css("overflow", "auto");

    Swal.fire({
        icon: "success",
        title: "Thank You!",
        text: response.message,
        confirmButtonColor: "#3085d6"
    });

            }

        },

        error:function(xhr){

            btn.html("Send");
            btn.prop('disabled',false);

            if(xhr.status==422){

                let errors=xhr.responseJSON.errors;

                $.each(errors,function(key,value){

                    $("."+key+"_error").text(value[0]);

                });

            }

            else{

                Swal.fire({

                    icon:'error',

                    title:'Oops!',

                    text:'Something went wrong.'

                });

            }

        }

    });

});
 });
</script>

 <script>
document.addEventListener("DOMContentLoaded", function () {
  var modal = document.getElementById("trialModal");
  var closeBtn = document.getElementById("closeTrialModal");
  var form = document.getElementById("trialForm");
  var submitBtn = document.getElementById("qtmSubmitBtn");
  var banner = document.getElementById("qtmBanner");
  var bannerText = document.getElementById("qtmBannerText");
  var successPanel = document.getElementById("qtmSuccess");
  var timeRow = document.getElementById("qtmTimeRow");

  // Point this at wherever the PHP endpoint actually lives on your server.
  var ENDPOINT_URL = "{{ url('/book-free-trial') }}";

  /* ---------- modal open/close ---------- */
  function openModal() {
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";
  }
  function closeModal() {
    modal.style.display = "none";
    document.body.style.overflow = "";
  }
  setTimeout(openModal, 500);
  closeBtn.addEventListener("click", closeModal);
  modal.addEventListener("click", function (e) { if (e.target === this) closeModal(); });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && modal.style.display === "flex") closeModal();
  });

  /* ---------- validation ---------- */
  var validators = {
    parent_name: function (v) { return v.trim().length > 0 ? "" : "Please enter the parent's name."; },
    child_name:  function (v) { return v.trim().length > 0 ? "" : "Please enter the child's name."; },
    child_age:   function (v) { return v ? "" : "Please select the child's age."; },
    current_level: function (v) { return v ? "" : "Please select a level."; },
    tutor_gender:  function (v) { return v ? "" : "Please choose a tutor preference."; },
    country:     function (v) { return v ? "" : "Please select your country."; },
    email:       function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? "" : "Please enter a valid email address."; },
    whatsapp:    function (v) { return /^[0-9+\-\s()]{7,20}$/.test(v) ? "" : "Please enter a valid WhatsApp number."; },
    time:  function (v) { return v ? "" : "Please choose a preferred class time."; }
  };

  function fieldEl(name) { return form.querySelector('[name="' + name + '"]'); }
  function errorEl(name) { return form.querySelector('[data-error-for="' + name + '"]'); }

  function clearFieldError(name) {
    var msg = errorEl(name);
    if (msg) msg.textContent = "";
    if (name === "time") {
      timeRow.classList.remove("qtm-pill-row--error");
    } else {
      var el = fieldEl(name);
      if (el) el.classList.remove("qtm-input--error", "qtm-select--error");
    }
  }

  function clearAllErrors() {
    Object.keys(validators).forEach(clearFieldError);
    banner.style.display = "none";
  }

  function showFieldError(name, message) {
    var msg = errorEl(name);
    if (msg) msg.textContent = message;
    if (name === "time") {
      timeRow.classList.add("qtm-pill-row--error");
    } else {
      var el = fieldEl(name);
      if (el) el.classList.add(el.tagName === "SELECT" ? "qtm-select--error" : "qtm-input--error");
    }
  }

  function validateForm() {
    var data = new FormData(form);
    var errors = {};
    Object.keys(validators).forEach(function (name) {
      var value = data.get(name) || "";
      var message = validators[name](value);
      if (message) errors[name] = message;
    });
    return errors;
  }

  // Clear a field's error as soon as the person fixes it.
  Object.keys(validators).forEach(function (name) {
    if (name === "time") {
      form.querySelectorAll('input[name="time"]').forEach(function (input) {
        input.addEventListener("change", function () { clearFieldError("time"); });
      });
    } else {
      var el = fieldEl(name);
      if (el) el.addEventListener("input", function () { clearFieldError(name); });
      if (el) el.addEventListener("change", function () { clearFieldError(name); });
    }
  });

  function setLoading(isLoading) {
    submitBtn.disabled = isLoading;
    submitBtn.classList.toggle("qtm-cta--loading", isLoading);
    submitBtn.querySelector(".qtm-cta-text").textContent = isLoading ? "Sending…" : "Start Free Trial";
  }

  function showBanner(message) {
    bannerText.textContent = message;
    banner.style.display = "flex";
  }

  /* ---------- submit ---------- */
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    clearAllErrors();

    var errors = validateForm();
    if (Object.keys(errors).length) {
      Object.keys(errors).forEach(function (name) { showFieldError(name, errors[name]); });
      var firstField = fieldEl(Object.keys(errors)[0]);
      if (firstField) firstField.focus();
      return;
    }

    setLoading(true);

    fetch(ENDPOINT_URL, {
      method: "POST",
      body: new FormData(form),
      headers: { "X-Requested-With": "XMLHttpRequest" }
    })
      .then(function (res) {
        return res.json().catch(function () {
          throw new Error("Unexpected response from server.");
        });
      })
      .then(function (result) {
        setLoading(false);

        if (result.success) {
          console.log(result.success);
          form.style.display = "none";
          banner.style.display = "none";
          successPanel.style.display = "flex";
          
        }

        if (result.errors) {
          Object.keys(result.errors).forEach(function (name) {
            showFieldError(name, result.errors[name]);
          });
        }
        showBanner(result.message || "Please check the highlighted fields and try again.");
      })
      .catch(function () {
        setLoading(false);
        showBanner("Network error — please check your connection and try again.");
      });
  });
});
</script> 