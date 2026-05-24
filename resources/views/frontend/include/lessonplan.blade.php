@php
           $feesCategory = App\Models\FeesCategory::with('plans')
                    ->latest()
                    ->get();
    $allPlans=App\Models\Plan::with('category')->orderBy('sort_order')->get();
@endphp              
       
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--txt);
            background: var(--white);
            overflow-x: hidden
        }

        a {
            text-decoration: none;
            color: inherit
        }

        /* ── Scroll reveal */
        [data-r] {
            opacity: 0;
            transition: opacity .75s cubic-bezier(.16, 1, .3, 1), transform .75s cubic-bezier(.16, 1, .3, 1)
        }

        [data-r="up"] {
            transform: translateY(40px)
        }

        [data-r="left"] {
            transform: translateX(-45px)
        }

        [data-r="right"] {
            transform: translateX(45px)
        }

        [data-r="fade"] {
            transform: scale(.96)
        }

        [data-r].on {
            opacity: 1;
            transform: none
        }

        /* ═══════════════════════════════
       SHARED COMPONENTS
    ═══════════════════════════════ */
        section {
            padding: 90px 0
        }

        .section-cream {
            background: var(--cream)
        }

        .section-light {
            background: var(--light)
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px
        }

        .eyebrow-line {
            width: 28px;
            height: 1.5px;
            background: var(--gold)
        }

        .eyebrow-txt {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold)
        }

        .sec-h {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.9rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.1;
            color: var(--navy);
        }

        .sec-h em {
            font-style: italic;
            color: var(--gold)
        }

        .sec-p {
            color: var(--muted);
            font-size: .95rem;
            line-height: 1.85;
            font-weight: 300
        }

        .divider-gold {
            width: 52px;
            height: 2.5px;
            background: linear-gradient(to right, var(--gold), var(--gold2));
            border-radius: 2px;
            margin: 18px 0;
        }

        .divider-gold.center {
            margin: 18px auto
        }

        /* Buttons */
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gold);
            color: var(--navy);
            padding: 14px 34px;
            border-radius: 9px;
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all .3s;
            box-shadow: 0 6px 24px rgba(201, 168, 76, .3);
        }

        .btn-gold:hover {
            background: var(--gold2);
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(201, 168, 76, .4);
            color: var(--navy)
        }

        .btn-navy {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--navy);
            color: var(--white);
            padding: 14px 34px;
            border-radius: 9px;
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all .3s;
        }

        .btn-navy:hover {
            background: var(--navy2);
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(15, 31, 92, .25);
            color: var(--white)
        }

        /* Form fields */
        .field-label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--navy);
            margin-bottom: 8px;
            display: block;
        }

        .field-input,
        .field-select,
        .field-textarea {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--txt);
            background: var(--cream);
            outline: none;
            transition: all .3s;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--gold);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, .1);
        }

        .field-input::placeholder,
        .field-textarea::placeholder {
            color: rgba(124, 124, 144, .45)
        }

        .field-textarea {
            resize: none
        }

        .field-group {
            margin-bottom: 20px
        }

        /* ═══════════════════════════════
       BOOK HERO
    ═══════════════════════════════ */
        .book-hero {
            padding: 150px 0 80px;
            background: var(--dark);
            position: relative;
            overflow: hidden;
        }

        .book-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 100% 80% at 30% 60%, rgba(26, 46, 122, .85), transparent 65%),
                radial-gradient(ellipse 50% 50% at 80% 20%, rgba(201, 168, 76, .06), transparent);
        }

        .book-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, .022) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .022) 1px, transparent 1px);
            background-size: 64px 64px;
        }

        .book-hero .container {
            position: relative;
            z-index: 2
        }

        .page-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(201, 168, 76, .12);
            border: 1px solid rgba(201, 168, 76, .28);
            border-radius: 30px;
            padding: 6px 18px;
            margin-bottom: 18px;
        }

        .page-hero-badge span {
            font-size: .68rem;
            color: var(--gold);
            letter-spacing: 2.5px;
            text-transform: uppercase;
            font-weight: 600
        }

        .page-hero-h {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.4rem, 5.5vw, 4rem);
            font-weight: 700;
            color: var(--white);
            line-height: 1;
        }

        .page-hero-h em {
            font-style: italic;
            color: var(--gold)
        }

        .page-hero-p {
            font-size: .95rem;
            color: rgba(255, 255, 255, .48);
            line-height: 1.8;
            font-weight: 300;
            max-width: 530px;
        }

        .hero-trust {
            display: flex;
            flex-wrap: wrap;
            gap: 20px
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .75rem;
            color: rgba(255, 255, 255, .45);
            letter-spacing: .5px;
        }

        .trust-item i {
            color: var(--gold);
            font-size: .7rem
        }

        /* ═══════════════════════════════
       OFFER CARDS
    ═══════════════════════════════ */
        .offer-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 30px 24px;
            text-align: center;
            height: 100%;
            transition: .35s;
        }

        .offer-card:hover {
            border-color: var(--gold);
            box-shadow: var(--shadow-md);
            transform: translateY(-6px);
        }

        .offer-ic {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: var(--gold-pale);
            border: 2px solid rgba(201, 168, 76, .2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 1.2rem;
            color: var(--gold);
            transition: .3s;
        }

        .offer-card:hover .offer-ic {
            background: var(--gold);
            color: var(--navy);
            border-color: var(--gold)
        }

        .offer-card h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .offer-card p {
            font-size: .84rem;
            color: var(--muted);
            line-height: 1.75
        }

        /* ═══════════════════════════════════════════════
       CATEGORY TABS + SUBSCRIPTION PLANS (NEW)
    ═══════════════════════════════════════════════ */

        /* ── Billing Toggle */
        .billing-toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 40px;
        }

        .billing-lbl {
            font-size: .82rem;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: .5px
        }

        .billing-lbl.active {
            color: var(--navy)
        }

        .billing-switch {
            position: relative;
            width: 52px;
            height: 28px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .billing-switch input {
            opacity: 0;
            width: 0;
            height: 0
        }

        .billing-track {
            position: absolute;
            inset: 0;
            background: var(--border);
            border-radius: 28px;
            transition: .3s;
        }

        .billing-track::before {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            left: 3px;
            bottom: 3px;
            background: var(--white);
            border-radius: 50%;
            transition: .3s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
        }

        .billing-switch input:checked+.billing-track {
            background: var(--navy)
        }

        .billing-switch input:checked+.billing-track::before {
            transform: translateX(24px)
        }

        .save-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(13, 107, 99, .1);
            border: 1px solid rgba(13, 107, 99, .2);
            border-radius: 20px;
            padding: 3px 10px;
            font-size: .65rem;
            font-weight: 700;
            color: var(--teal);
        }

        /* ── Category Filter Tabs */
        .cat-tabs-outer {
            display: flex;
            justify-content: center;
            margin-bottom: 36px;
        }

        .cat-tabs {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 5px;
            box-shadow: var(--shadow-sm);
            flex-wrap: wrap;
            justify-content: center;
        }

        .cat-tab {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 9px 22px;
            border-radius: 50px;
            border: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .8px;
            color: var(--muted);
            cursor: pointer;
            transition: all .3s;
            white-space: nowrap;
        }

        .cat-tab i {
            font-size: .8rem
        }

        .cat-tab:hover {
            color: var(--navy)
        }

        .cat-tab.active {
            background: var(--navy);
            color: var(--white);
            box-shadow: 0 4px 16px rgba(15, 31, 92, .2);
        }

        .cat-tab.active i {
            color: var(--gold)
        }

        /* ── Plans Grid Container */
        .plans-category {
            display: none
        }

        .plans-category.active {
            display: block;
            animation: plansIn .4s ease
        }

        @keyframes plansIn {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        /* ── Session info row */
        .session-info-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }

        .si-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .78rem;
            color: var(--muted);
        }

        .si-item i {
            color: var(--gold);
            font-size: .72rem
        }

        .si-sep {
            width: 1px;
            height: 18px;
            background: var(--border)
        }

        /* ── Plan Card */
        .plan-card {
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 0;
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: all .4s cubic-bezier(.16, 1, .3, 1);
            cursor: pointer;
        }

        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--border);
            transition: background .3s;
        }

        .plan-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(201, 168, 76, .4);
        }

        .plan-card:hover::before {
            background: linear-gradient(to right, var(--gold), var(--gold2))
        }

        .plan-card.featured {
            background: linear-gradient(160deg, var(--navy) 0%, var(--navy2) 100%);
            border-color: var(--gold);
            box-shadow: 0 16px 60px rgba(15, 31, 92, .25);
        }

        .plan-card.featured::before {
            background: linear-gradient(to right, var(--gold), var(--gold2))
        }

        .plan-card.featured:hover {
            transform: translateY(-10px)
        }

        .plan-card.selected {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .25), var(--shadow-md);
        }

        .plan-card.selected::before {
            background: linear-gradient(to right, var(--gold), var(--gold2))
        }

        /* ── Plan Header */
        .plan-header {
            padding: 28px 26px 0
        }

        .plan-ribbon {
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gold);
            color: var(--navy);
            font-size: .6rem;
            font-weight: 800;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            padding: 5px 18px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 12px rgba(201, 168, 76, .35);
        }

        .plan-days-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(201, 168, 76, .1);
            border: 1px solid rgba(201, 168, 76, .25);
            border-radius: 20px;
            padding: 4px 12px;
            margin-bottom: 16px;
        }

        .plan-card.featured .plan-days-badge {
            background: rgba(201, 168, 76, .15);
            border-color: rgba(201, 168, 76, .35);
        }

        .plan-days-badge span {
            font-size: .65rem;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1.5px;
            text-transform: uppercase
        }

        .plan-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
            line-height: 1.1;
        }

        .plan-card.featured .plan-name {
            color: var(--white)
        }

        .plan-subtitle {
            font-size: .78rem;
            color: var(--muted);
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .plan-card.featured .plan-subtitle {
            color: rgba(255, 255, 255, .5)
        }

        /* ── Price Block */
        .plan-price-block {
            padding: 20px 26px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: var(--cream);
            margin: 0;
        }

        .plan-card.featured .plan-price-block {
            background: rgba(255, 255, 255, .06);
            border-color: rgba(255, 255, 255, .1);
        }

        .plan-price-amount {
            display: flex;
            align-items: flex-start;
            gap: 4px;
            font-family: 'Cormorant Garamond', serif;
            line-height: 1;
        }

        .plan-currency {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--navy);
            margin-top: 8px;
        }

        .plan-card.featured .plan-currency {
            color: var(--gold)
        }

        .plan-amount {
            font-size: 3rem;
            font-weight: 700;
            color: var(--navy)
        }

        .plan-card.featured .plan-amount {
            color: var(--white)
        }

        .plan-period {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding-bottom: 6px;
        }

        .plan-period-main {
            font-size: .78rem;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400
        }

        .plan-period-interval {
            font-size: .68rem;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif
        }

        .plan-card.featured .plan-period-main,
        .plan-card.featured .plan-period-interval {
            color: rgba(255, 255, 255, .45)
        }

        .plan-original-price {
            font-size: .75rem;
            color: var(--muted);
            text-decoration: line-through;
            margin-left: 4px;
            margin-top: 6px;
        }

        .plan-card.featured .plan-original-price {
            color: rgba(255, 255, 255, .3)
        }

        .plan-sessions-info {
            margin-top: 10px;
            font-size: .75rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .plan-card.featured .plan-sessions-info {
            color: rgba(255, 255, 255, .45)
        }

        .plan-sessions-info i {
            color: var(--teal);
            font-size: .65rem
        }

        .plan-card.featured .plan-sessions-info i {
            color: var(--gold)
        }

        /* ── Features */
        .plan-features {
            padding: 20px 26px
        }

        .plan-feat {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 11px;
            font-size: .82rem;
            color: var(--txt);
            line-height: 1.5;
        }

        .plan-feat:last-child {
            margin-bottom: 0
        }

        .plan-feat i {
            font-size: .72rem;
            color: var(--teal);
            margin-top: 3px;
            flex-shrink: 0;
        }

        .plan-card.featured .plan-feat {
            color: rgba(255, 255, 255, .78)
        }

        .plan-card.featured .plan-feat i {
            color: var(--gold)
        }

        .plan-feat.disabled {
            opacity: .38
        }

        .plan-feat.disabled i {
            color: var(--muted) !important
        }

        /* ── CTA */
        .plan-cta {
            padding: 0 26px 26px
        }

        .btn-plan {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .3s;
            border: none;
        }

        .btn-plan-outline {
            background: transparent;
            color: var(--navy);
            border: 2px solid var(--navy);
        }

        .btn-plan-outline:hover {
            background: var(--navy);
            color: var(--white);
            transform: translateY(-2px)
        }

        .btn-plan-gold {
            background: var(--gold);
            color: var(--navy);
            box-shadow: 0 6px 20px rgba(201, 168, 76, .35);
        }

        .btn-plan-gold:hover {
            background: var(--gold2);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(201, 168, 76, .45)
        }

        /* ── Scale featured plan */
        .col-scale .plan-card.featured {
            transform: scale(1.03)
        }

        .col-scale .plan-card.featured:hover {
            transform: scale(1.03) translateY(-10px)
        }

        /* ── Category description */
        .cat-description {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .cat-desc-ic {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: var(--gold-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--gold);
            flex-shrink: 0;
        }

        .cat-desc-t {
            font-size: .88rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 4px
        }

        .cat-desc-p {
            font-size: .78rem;
            color: var(--muted);
            margin: 0;
            line-height: 1.6
        }

        /* ── Plan comparison note */
        .plan-note {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 20px;
            margin-top: 28px;
        }

        .plan-note p {
            font-size: .8rem;
            color: var(--muted);
            margin: 0
        }

        .plan-note i {
            color: var(--gold);
            flex-shrink: 0
        }

        /* ── Selected plan indicator */
        .selected-plan-bar {
            display: none;
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            border-radius: 12px;
            padding: 16px 22px;
            margin-top: 28px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .selected-plan-bar.show {
            display: flex;
            animation: slideUp .35s ease
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .spb-info {
            font-size: .85rem;
            font-weight: 600;
            color: var(--white)
        }

        .spb-info span {
            color: var(--gold)
        }

        .spb-actions {
            display: flex;
            gap: 8px
        }

        /* ═══════════════════════════════
       BOOK FORM
    ═══════════════════════════════ */
        .book-form-wrap {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 48px 42px;
            box-shadow: var(--shadow-md);
        }

        .book-form-intro {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 28px;
            line-height: 1.6
        }

        .gift-aid-note {
            background: linear-gradient(135deg, rgba(201, 168, 76, .08), rgba(201, 168, 76, .04));
            border: 1px solid rgba(201, 168, 76, .25);
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 8px;
        }

        .gift-aid-note i {
            color: var(--gold);
            margin-top: 2px;
            font-size: .85rem
        }

        .gift-aid-note p {
            font-size: .78rem;
            color: var(--txt);
            margin: 0;
            line-height: 1.6
        }

        .success-msg {
            display: none;
            text-align: center;
            padding: 40px 20px
        }

        .success-msg i.fa-check-circle {
            font-size: 3rem;
            color: var(--teal);
            margin-bottom: 14px;
            display: block
        }

        .success-msg h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .success-msg p {
            font-size: .88rem;
            color: var(--muted)
        }

        /* ── Selected plan summary in form */
        .selected-plan-summary {
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            border-radius: 12px;
            padding: 18px 22px;
            margin-bottom: 24px;
            display: none;
        }

        .selected-plan-summary.show {
            display: block;
            animation: slideUp .35s ease
        }

        .sps-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .4);
            margin-bottom: 8px
        }

        .sps-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px
        }

        .sps-plan-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--white)
        }

        .sps-plan-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--gold)
        }

        .sps-details {
            margin-top: 8px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap
        }

        .sps-detail {
            font-size: .72rem;
            color: rgba(255, 255, 255, .45);
            display: flex;
            align-items: center;
            gap: 5px
        }

        .sps-detail i {
            color: rgba(201, 168, 76, .6);
            font-size: .62rem
        }

        .sps-change {
            font-size: .68rem;
            color: var(--gold);
            cursor: pointer;
            text-decoration: underline;
            margin-top: 10px;
            display: inline-block;
        }

        .sps-change:hover {
            color: var(--gold2)
        }

        /* ═══════════════════════════════
       PROCESS STEPS
    ═══════════════════════════════ */
        .step-card {
            text-align: center;
            padding: 32px 20px;
            position: relative
        }

        .step-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 700;
            color: rgba(15, 31, 92, .06);
            line-height: 1;
            margin-bottom: -8px;
        }

        .step-ic {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gold-pale);
            border: 2px solid rgba(201, 168, 76, .25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.2rem;
            color: var(--gold);
            transition: .3s;
        }

        .step-card:hover .step-ic {
            background: var(--gold);
            color: var(--navy);
            border-color: var(--gold)
        }

        .step-card h5 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .step-card p {
            font-size: .82rem;
            color: var(--muted);
            line-height: 1.7
        }

        .step-connector {
            position: absolute;
            top: 84px;
            right: -28px;
            width: 56px;
            height: 2px;
            background: linear-gradient(to right, var(--gold), rgba(201, 168, 76, .2));
            z-index: 1;
        }

        /* ═══════════════════════════════
       CTA BLOCK
    ═══════════════════════════════ */
        .cta-block {
            background: var(--gold);
            padding: 70px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-block::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='.06'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
        }

        .cta-block .inner {
            position: relative
        }

        /* ═══════════════════════════════
       FOOTER
    ═══════════════════════════════ */
        .site-footer {
            background: var(--dark);
            padding: 80px 0 0
        }

        .footer-brand-n {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: 2.5px
        }

        .footer-brand-s {
            font-size: .55rem;
            letter-spacing: 2.5px;
            color: var(--gold);
            text-transform: uppercase
        }

        .footer-col-title {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 22px
        }

        .footer-link {
            display: flex;
            align-items: center;
            gap: 9px;
            color: rgba(255, 255, 255, .38);
            font-size: .8rem;
            margin-bottom: 11px;
            cursor: pointer;
            transition: .3s
        }

        .footer-link i {
            font-size: .52rem;
            color: rgba(201, 168, 76, .45)
        }

        .footer-link:hover {
            color: var(--gold);
            padding-left: 4px
        }

        .footer-soc {
            display: flex;
            gap: 8px;
            margin-top: 18px
        }

        .footer-soc-btn {
            width: 36px;
            height: 36px;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, .38);
            font-size: .78rem;
            cursor: pointer;
            transition: .3s
        }

        .footer-soc-btn:hover {
            border-color: var(--gold);
            color: var(--gold);
            transform: translateY(-3px)
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .055);
            padding: 26px 0;
            margin-top: 60px
        }

        .footer-bot-txt {
            font-size: .75rem;
            color: rgba(255, 255, 255, .22)
        }

        /* ── Loader */
        #loader {
            position: fixed;
            inset: 0;
            background: var(--dark);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity .5s, visibility .5s
        }

        #loader.done {
            opacity: 0;
            visibility: hidden
        }

        .loader-t {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: 5px;
            margin-bottom: 16px
        }

        .loader-track {
            width: 140px;
            height: 2px;
            background: rgba(255, 255, 255, .1);
            border-radius: 2px;
            overflow: hidden
        }

        .loader-fill {
            height: 100%;
            width: 0;
            background: var(--gold);
            border-radius: 2px;
            animation: lf 1.2s ease forwards
        }

        @keyframes lf {
            to {
                width: 100%
            }
        }

        #btt {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 46px;
            height: 46px;
            background: var(--navy);
            border: 1.5px solid var(--gold);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            cursor: pointer;
            z-index: 800;
            opacity: 0;
            pointer-events: none;
            transition: .4s;
            box-shadow: 0 6px 20px rgba(15, 31, 92, .25)
        }

        #btt.show {
            opacity: 1;
            pointer-events: all
        }

        #btt:hover {
            background: var(--gold);
            color: var(--navy);
            transform: translateY(-3px)
        }

        @media(max-width:991px) {
            section {
                padding: 70px 0
            }

            .book-form-wrap {
                padding: 32px 20px
            }

            .col-scale .plan-card.featured {
                transform: none
            }
        }

        @media(max-width:576px) {
            .cat-tabs {
                gap: 4px
            }

            .cat-tab {
                padding: 8px 14px;
                font-size: .72rem
            }
        }
    </style>
        <!-- ═══════════════ WHAT WE OFFER ═══════════════ -->
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

    <!-- ═══════════════════════════════════════════
         PRICING WITH CATEGORY TABS (UPDATED)
    ═══════════════════════════════════════════ -->
    <section id="pricing-section">
        <div class="container">

            <!-- Section Header -->
            <div class="text-center mb-2" data-r="up">
                <div class="eyebrow justify-content-center">
                    <div class="eyebrow-line"></div>
                    <span class="eyebrow-txt">Subscription Plans</span>
                    <div class="eyebrow-line"></div>
                </div>
                <h2 class="sec-h">Choose Your <em>Learning Plan</em></h2>
                <div class="divider-gold center"></div>
                <p class="sec-p mx-auto" style="max-width:520px">
                    Select a plan category that fits your child's learning needs. All plans include a free trial lesson with
                    no commitment required.
                </p>
            </div>


            <div class="cat-tabs-outer" data-r="fade">
                <div class="cat-tabs" id="cat-tabs">
                    @foreach ($feesCategory as $index => $category)
                        <button class="cat-tab {{ $index == 0 ? 'active' : '' }}"
                            onclick="switchCat('{{ $category->slug }}',this)" data-cat="{{ $category->slug }}">
                            <i class="{{ $category->icon }}"></i>
                            {{ $category->category_name }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Category Sections --}}
            @foreach ($feesCategory as $catIndex => $category)
                <div class="plans-category {{ $catIndex == 0 ? 'active' : '' }}" id="cat-{{ $category->slug }}">

                  
                    {{-- Session Info --}}
                    <div class="session-info-row" data-r="up">
                        <div class="si-item">
                            <i class="fas fa-clock"></i>
                            {{ $category->category_name }}
                        </div>
                        <div class="si-sep"></div>
                        <div class="si-item">
                            <i class="fas fa-video"></i> Zoom or Teams
                        </div>
                        <div class="si-sep"></div>
                        <div class="si-item">
                            <i class="fas fa-user-shield"></i> DBS-checked tutors
                        </div>
                        <div class="si-sep"></div>
                        <div class="si-item">
                            <i class="fas fa-gift"></i> Free trial included
                        </div>
                    </div>

                    <div class="row g-4 align-items-stretch col-scale">

                        @foreach ($allPlans->where('category_id', $category->id) as $plan)
                            <div class="col-lg-4 col-md-6">
                                <div class="plan-card {{ $plan->is_featured ? 'featured' : '' }}"
                                    onclick="selectPlan(
                    this,
                    '{{ $plan->name }}',
                    '£{{ $plan->price }}',
                    'monthly',
                    '{{ $plan->duration }}',
                    '{{ $plan->days_per_week }}'
                 )">

                                    @if ($plan->is_featured)
                                        <div class="plan-ribbon">✦ Most Popular</div>
                                    @endif

                                    <div class="plan-header">
                                        <div class="plan-days-badge">
                                            <span>
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $plan->days_per_week }}
                                            </span>
                                        </div>

                                        <div class="plan-name">
                                            {{ $plan->name }}
                                        </div>

                                        <div class="plan-subtitle">
                                            {{ $plan->subtitle }}
                                        </div>
                                    </div>

                                    <div class="plan-price-block">
                                        <div class="plan-price-amount">
                                            <span class="plan-currency">£</span>

                                            <span class="plan-amount plan-monthly-price">
                                                {{ number_format($plan->monthly_price, 2) }}
                                            </span>

                                            <span class="plan-amount plan-annual-price" style="display:none">
                                                {{ number_format($plan->annual_price, 2) }}
                                            </span>

                                            <div class="plan-period">
                                                <span class="plan-period-main">/class</span>

                                            </div>
                                        </div>

                                        <div class="plan-sessions-info">
                                            <i class="fas fa-info-circle"></i>
                                            {{ $plan->sessions_per_month }}
                                            sessions/month
                                        </div>
                                    </div>

                                    <div class="plan-features">
                                        <div class="plan-feat">
                                            <i class="fas fa-check-circle"></i>
                                            1-to-1 personal lesson
                                        </div>

                                        <div class="plan-feat">
                                            <i class="fas fa-check-circle"></i>
                                            Qualified tutor
                                        </div>

                                        <div class="plan-feat">
                                            <i class="fas fa-check-circle"></i>
                                            Progress tracking
                                        </div>

                                        <div class="plan-feat">
                                            <i class="fas fa-check-circle"></i>
                                            {{ $plan->sessions_per_month }} Classes per month
                                        </div>
                                    </div>

                                    <div class="plan-cta">
                                        <a href="{{ route('checkout', ['plan' => $plan->id]) }}"
                                            class="btn-plan btn-plan-outline">
                                            <i class="fas fa-graduation-cap"></i>
                                            Choose Plan
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Selected Bar --}}
                    <div class="selected-plan-bar" id="selected-bar-{{ $category->slug }}">
                        <div class="spb-info">
                            Selected:
                            <span id="selected-name-{{ $category->slug }}">—</span>
                            &nbsp;·&nbsp;
                            <span id="selected-price-{{ $category->slug }}" style="color:var(--gold2)">—</span>
                        </div>

                        <div class="spb-actions">
                            <button class="btn-gold" onclick="scrollToForm()">
                                <i class="fas fa-arrow-down"></i>
                                Continue to Booking
                            </button>
                        </div>
                    </div>

                </div>
            @endforeach





            {{-- my code end --}}
            <!-- Disclaimer note -->
            <div class="text-center mt-4" data-r="up">
                <div class="plan-note">
                    <i class="fas fa-info-circle" style="color:var(--gold);flex-shrink:0"></i>
                    <p><strong style="color:var(--navy)">Lesson fee = Service only.</strong> Add an optional donation
                        alongside your booking to support a child in need — Gift Aid eligible for UK taxpayers.</p>
                </div>
            </div>

        </div>
    </section>
