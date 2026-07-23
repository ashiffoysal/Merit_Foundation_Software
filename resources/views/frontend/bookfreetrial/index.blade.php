@extends('layouts.frontend')
@section('title', 'Book Free Trial - Merit Education Foundation')
@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="about-hero">
        <div class="container position-relative" style="z-index:2">
            <div class="page-hero-badge"><span>Book Free Trial Lesson</span></div>
            <h1 class="page-hero-h mb-3">Book Free Trial Lesson,<br><em>For Your Child</em></h1>
            <p class="page-hero-p">Building a world where every child has access to quality education — regardless of
                financial or social background.</p>
        </div>
    </div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

        .mef-hero * {
            box-sizing: border-box;
        }

        .mef-hero {
            --teal-dark: #0B4A4E;
            --teal: #1B8FA1;
            --teal-mid: #0F7684;
            --bg: #ceeddf;
            --bg-2: #CFE6E4;
            --orange: #F2994A;
            --text: #23312F;
            --text-soft: #46605C;
            --field-border: #2AA6B4;
            --field-bg: #FFFFFF;

            font-family: 'Inter', sans-serif;
            background: var(--bg);
            position: relative;
            overflow: hidden;
            padding-bottom: 46px;
        }

        .mef-dots {
            position: absolute;
            top: 0;
            left: 0;
            width: 380px;
            height: 340px;
            z-index: 0;
            opacity: 0.5;
        }

        .mef-main {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 48px;
            max-width: 1180px;
            margin: 0 auto;
            padding: 64px 32px 40px;
            align-items: start;
            position: relative;
            z-index: 1;
        }

        .mef-left {
            min-width: 0;
            padding-top: 6px;
        }

        .mef-h1 {
            font-family: 'Baloo 2', sans-serif;
            font-size: 44px;
            font-weight: 700;
            color: var(--teal-dark);
            line-height: 1.16;
            margin: 0 0 14px;
        }

        .mef-sub {
            font-family: 'Baloo 2', sans-serif;
            font-size: 19px;
            font-weight: 600;
            color: var(--teal-mid);
            line-height: 1.5;
            margin: 0 0 18px;
            max-width: 480px;
        }

        .mef-desc {
            font-size: 14.5px;
            line-height: 1.7;
            color: var(--text-soft);
            max-width: 470px;
            margin: 0 0 26px;
        }

        .mef-checklist {
            display: grid;
            grid-template-columns: repeat(2, auto);
            row-gap: 12px;
            column-gap: 28px;
            margin-bottom: 30px;
        }

        .mef-check-item {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
        }

        .mef-check-box {
            width: 19px;
            height: 19px;
            background: var(--orange);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .mef-price-note {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1.5px dashed var(--field-border);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--teal-dark);
        }

        .mef-price-note b {
            font-family: 'Baloo 2', sans-serif;
            font-size: 18px;
            color: var(--orange);
        }

        .mef-right {
            position: relative;
            z-index: 1;
        }

        .mef-form-card {
            background: #fff;
            border-radius: 16px;
            padding: 26px 26px 24px;
            box-shadow: 0 16px 40px rgba(11, 74, 78, 0.14);
        }

        .mef-form-title {
            font-family: 'Baloo 2', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--teal-dark);
            margin-bottom: 4px;
        }

        .mef-form-sub {
            font-size: 12.5px;
            color: var(--text-soft);
            margin-bottom: 20px;
        }

        .mef-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 14px;
            margin-bottom: 6px;
        }

        .mef-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .mef-field.full {
            grid-column: 1 / -1;
        }

        .mef-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
        }

        .mef-req {
            color: #E0554A;
        }

        .mef-input,
        .mef-select {
            border: 1.5px solid var(--field-border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: var(--field-bg);
            width: 100%;
            outline: none;
        }

        .mef-input::placeholder {
            color: #9AA6A4;
        }

        .mef-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%230B4A4E' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
            color: #6B7876;
        }

        .mef-radio-row {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            padding-top: 4px;
        }

        .mef-radio {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .mef-radio input {
            accent-color: var(--teal-mid);
            width: 15px;
            height: 15px;
        }

        .mef-send {
            margin-top: 20px;
            width: 100%;
            background: var(--teal-mid);
            color: #fff;
            border: none;
            padding: 13px;
            border-radius: 9px;
            font-family: 'Baloo 2', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .mef-send:hover {
            background: var(--teal-dark);
        }

        .mef-form-foot {
            text-align: center;
            font-size: 11px;
            color: var(--text-soft);
            margin-top: 12px;
        }

        .mef-wave {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -2px;
            line-height: 0;
            z-index: 0;
        }

        @media (max-width: 900px) {
            .mef-main {
                grid-template-columns: 1fr;
                padding: 48px 24px 24px;
                gap: 36px;
            }

            .mef-h1 {
                font-size: 36px;
            }

            .mef-sub,
            .mef-desc {
                max-width: 100%;
            }

            .mef-dots {
                display: none;
            }
        }

        @media (max-width: 560px) {
            .mef-h1 {
                font-size: 29px;
            }

            .mef-sub {
                font-size: 16px;
            }

            .mef-checklist {
                grid-template-columns: 1fr;
            }

            .mef-form-grid {
                grid-template-columns: 1fr;
            }

            .mef-form-card {
                padding: 22px 18px 20px;
            }
        }
    </style>

    <div class="mef-hero">
        <svg class="mef-dots" viewBox="0 0 380 340" fill="none">
            <circle cx="330" cy="18" r="5" fill="#0B4A4E" opacity="0.35" />
            <circle cx="300" cy="46" r="4.5" fill="#0B4A4E" opacity="0.32" />
            <circle cx="266" cy="72" r="4.2" fill="#0B4A4E" opacity="0.3" />
            <circle cx="230" cy="94" r="4" fill="#0B4A4E" opacity="0.28" />
            <circle cx="192" cy="112" r="3.6" fill="#0B4A4E" opacity="0.26" />
            <circle cx="152" cy="126" r="3.2" fill="#0B4A4E" opacity="0.24" />
            <circle cx="112" cy="136" r="2.8" fill="#0B4A4E" opacity="0.22" />
            <circle cx="74" cy="142" r="2.4" fill="#0B4A4E" opacity="0.2" />
            <circle cx="40" cy="148" r="2" fill="#0B4A4E" opacity="0.18" />
            <circle cx="16" cy="160" r="1.6" fill="#0B4A4E" opacity="0.16" />
        </svg>

        <div class="mef-main">
            <div class="mef-left">
                <h1 class="mef-h1">Personal Quran Tuition for Children &amp; Adults, Anywhere in the UK</h1>

                <p class="mef-sub">Live one-to-one sessions with a qualified, Ijazah-certified tutor, flexible around your
                    schedule and tailored to your level.</p>

                <p class="mef-desc">
                    Whether you're in England, Scotland, Wales or Northern Ireland, your tutor is just one click away. Every
                    lesson you book also funds a free school place for an orphaned or disadvantaged child.
                </p>

                <div class="mef-checklist">
                    <div class="mef-check-item">
                        <div class="mef-check-box">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        Ijazah-certified tutors
                    </div>
                    <div class="mef-check-item">
                        <div class="mef-check-box">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        Ages 4 and above
                    </div>
                    <div class="mef-check-item">
                        <div class="mef-check-box">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        Male &amp; female tutors available
                    </div>
                    <div class="mef-check-item">
                        <div class="mef-check-box">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        Free first class, no card required
                    </div>
                </div>

                <div class="mef-price-note">
                    Lessons from <b>£5</b> — every fee funds a child's education
                </div>
            </div>

            <div class="mef-right">
                {{-- <form action="{{ route('book.free.trial') }}" method="POST">
            @csrf
      <div class="mef-form-card">

        <div class="mef-form-title">Book your free first class</div>
        <div class="mef-form-sub">Tell us a little about you and we'll match you with a tutor.</div>

        <div class="mef-form-grid">
          <div class="mef-field">
            <label class="mef-label">Parent Name <span class="mef-req">*</span></label>
            <input class="mef-input" type="text" placeholder="e.g. Sarah Ahmad">
          </div>
          <div class="mef-field">
            <label class="mef-label">Child Name <span class="mef-req">*</span></label>
            <input class="mef-input" type="text" placeholder="e.g. Yusuf Ahmad">
          </div>

          <div class="mef-field">
            <label class="mef-label">Child's Age <span class="mef-req">*</span></label>
            <select class="mef-select"><option>Select child's age</option></select>
          </div>
          <div class="mef-field">
            <label class="mef-label">Current Level <span class="mef-req">*</span></label>
            <select class="mef-select"><option>Select level</option></select>
          </div>

          <div class="mef-field">
            <label class="mef-label">Preferred Tutor Gender <span class="mef-req">*</span></label>
            <select class="mef-select"><option>No preference</option></select>
          </div>
          <div class="mef-field">
            <label class="mef-label">Your Country <span class="mef-req">*</span></label>
            <select class="mef-select">
                <option >Select country name</option>
            </select>
          </div>

          <div class="mef-field">
            <label class="mef-label">Email Address <span class="mef-req">*</span></label>
            <input class="mef-input" type="email" placeholder="you@email.com">
          </div>
          <div class="mef-field">
            <label class="mef-label">WhatsApp Number <span class="mef-req">*</span></label>
            <input class="mef-input" type="tel" placeholder="+44 0000 000000">
          </div>

          <div class="mef-field full">
            <label class="mef-label">Preferred Class Time <span class="mef-req">*</span></label>
            <div class="mef-radio-row">
              <label class="mef-radio"><input type="radio" name="time"> Morning</label>
              <label class="mef-radio"><input type="radio" name="time"> Afternoon</label>
              <label class="mef-radio"><input type="radio" name="time"> Evening</label>
              <label class="mef-radio"><input type="radio" name="time"> Flexible</label>
            </div>
          </div>
        </div>

        <button class="mef-send">Send</button>
        <div class="mef-form-foot">No payment required for your first lesson</div>
      </div>
        </form> --}}

                <form id="freeTrialForm" method="POST" action="{{ url('book-free-trial') }}" >
                    @csrf

                    <div class="mef-form-card">

                        <div class="mef-form-title">
                            Book your free first class
                        </div>

                        <div class="mef-form-sub">
                            Tell us a little about you and we'll match you with a tutor.
                        </div>

                        <div class="mef-form-grid">

                            <!-- Parent -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Parent Name <span class="mef-req">*</span>
                                </label>

                                <input type="text" name="parent_name" class="mef-input"
                                    placeholder="e.g. Sarah Ahmad">

                                <small class="text-danger error-text parent_name_error"></small>
                            </div>

                            <!-- Child -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Child Name <span class="mef-req">*</span>
                                </label>

                                <input type="text" name="child_name" class="mef-input"
                                    placeholder="e.g. Yusuf Ahmad">

                                <small class="text-danger error-text child_name_error"></small>
                            </div>

                            <!-- Age -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Child's Age <span class="mef-req">*</span>
                                </label>

                                <select name="child_age" class="mef-select">
                                    <option value="">Select Age</option>
                                    @for ($i = 4; $i <= 18; $i++)
                                        <option value="{{ $i }}">{{ $i }} Years</option>
                                    @endfor
                                </select>

                                <small class="text-danger error-text child_age_error"></small>
                            </div>

                            <!-- Level -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Current Level <span class="mef-req">*</span>
                                </label>

                                <select name="current_level" class="mef-select">
                                    <option value="">Select Level</option>
                                    <option>Primary</option>
                                    <option>KS1</option>
                                    <option>KS2</option>
                                    <option>KS3</option>
                                    <option>GCSE</option>
                                    <option>A Level</option>
                                </select>

                                <small class="text-danger error-text current_level_error"></small>
                            </div>

                            <!-- Tutor -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Preferred Tutor Gender
                                </label>

                                <select name="tutor_gender" class="mef-select">
                                    <option value="No Preference">No Preference</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>

                                <small class="text-danger error-text tutor_gender_error"></small>
                            </div>

                            <!-- Country -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Country <span class="mef-req">*</span>
                                </label>

                                <input type="text" name="country" class="mef-input" placeholder="Country">

                                <small class="text-danger error-text country_error"></small>
                            </div>

                            <!-- Email -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    Email <span class="mef-req">*</span>
                                </label>

                                <input type="email" name="email" class="mef-input" placeholder="Email">

                                <small class="text-danger error-text email_error"></small>
                            </div>

                            <!-- WhatsApp -->
                            <div class="mef-field">
                                <label class="mef-label">
                                    WhatsApp Number <span class="mef-req">*</span>
                                </label>

                                <input type="text" name="whatsapp" class="mef-input" placeholder="+44">

                                <small class="text-danger error-text whatsapp_error"></small>
                            </div>

                            <!-- Time -->
                            <div class="mef-field full">

                                <label class="mef-label">
                                    Preferred Class Time
                                </label>

                                <div class="mef-radio-row">

                                    <label>
                                        <input type="radio" name="time" value="Morning"> Morning
                                    </label>

                                    <label>
                                        <input type="radio" name="time" value="Afternoon"> Afternoon
                                    </label>

                                    <label>
                                        <input type="radio" name="time" value="Evening"> Evening
                                    </label>

                                    <label>
                                        <input type="radio" name="time" value="Flexible"> Flexible
                                    </label>

                                </div>

                                <small class="text-danger error-text time_error"></small>

                            </div>

                        </div>

                        <button type="submit" id="submitBtn" class="mef-send">
                            Send
                        </button>

                        <div class="mef-form-foot">
                            No payment required for your first lesson
                        </div>

                    </div>

                </form>
            </div>
        </div>

        <svg class="mef-wave" viewBox="0 0 1440 60" preserveAspectRatio="none">
            <path fill="#FFFFFF"
                d="M0,32 C120,60 240,60 360,40 C480,20 600,4 720,10 C840,16 960,44 1080,48 C1200,52 1320,32 1440,20 L1440,60 L0,60 Z" />
        </svg>
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

                Swal.fire({

                    icon:'success',

                    title:'Thank You!',

                    text:response.message,

                    confirmButtonColor:'#3085d6'

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
@endsection
