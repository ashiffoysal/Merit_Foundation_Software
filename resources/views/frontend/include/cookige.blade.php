<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700;900&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* ==============================
   TOKENS
================================ */
#cookie-consent-wrapper {
    --paper: #F2ECDD;
    --paper-raised: #FAF6EB;
    --ink: #1B1812;
    --ink-soft: #6B6355;
    --ink-faint: #A79E8B;
    --accent: #B8791E;
    --accent-deep: #8F5D14;
    --line: #1B1812;
    --line-soft: rgba(27,24,18,0.14);
    --radius: 3px;

    --font-display: 'Archivo', sans-serif;
    --font-mono: 'IBM Plex Mono', monospace;
    --font-body: 'Inter', sans-serif;

    color: var(--ink);
    font-family: var(--font-body);
}

#cookie-consent-wrapper * {
    box-sizing: border-box;
}

#cookie-consent-wrapper button {
    font-family: inherit;
}

/* ==============================
   BANNER — ticket stub
================================ */
.cookie-banner {
    position: fixed;
    left: 16px;
    right: 16px;
    bottom: 16px;
    z-index: 999999;
    max-width: 1100px;
    margin: 0 auto;
    display: none;
}

.cookie-banner-perf {
    height: 14px;
    background-image: radial-gradient(circle at 12px 100%, transparent 6px, var(--paper) 6.5px);
    background-size: 24px 14px;
    background-repeat: repeat-x;
}

.cookie-banner-body {
    background: var(--paper);
    border: 1px solid var(--line);
    border-top: none;
    box-shadow: 0 14px 34px rgba(27,24,18,0.22);
}

.cookie-banner-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 28px;
    padding: 20px 26px;
}

.cookie-eyebrow {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 6px;
}

.cookie-eyebrow .mark {
    font-family: var(--font-mono);
    font-size: 11px;
    letter-spacing: 0.12em;
    color: var(--accent-deep);
    background: rgba(184,121,30,0.14);
    padding: 2px 7px;
    border-radius: 2px;
}

.cookie-text h3 {
    margin: 0;
    font-family: var(--font-display);
    font-weight: 900;
    font-size: 19px;
    letter-spacing: 0.01em;
    text-transform: uppercase;
}

.cookie-text p {
    margin: 8px 0 0;
    max-width: 620px;
    font-size: 13.5px;
    line-height: 1.55;
    color: var(--ink-soft);
}

.cookie-links {
    margin-top: 10px;
    display: flex;
    gap: 16px;
    font-family: var(--font-mono);
}

.cookie-links a {
    color: var(--ink);
    text-decoration: none;
    font-size: 11.5px;
    letter-spacing: 0.03em;
    border-bottom: 1px solid var(--ink-faint);
    padding-bottom: 1px;
}

.cookie-links a:hover {
    border-color: var(--ink);
}

/* ==============================
   BUTTONS
================================ */
.cookie-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

.cookie-btn {
    border-radius: var(--radius);
    padding: 11px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.15s ease;
    white-space: nowrap;
    letter-spacing: 0.01em;
}

.cookie-btn-text {
    border: none;
    background: transparent;
    color: var(--ink-soft);
    text-decoration: underline;
    text-underline-offset: 3px;
    padding: 11px 4px;
}
.cookie-btn-text:hover { color: var(--ink); }

.cookie-btn-outline {
    background: transparent;
    color: var(--ink);
    border: 1.5px solid var(--ink);
}
.cookie-btn-outline:hover {
    background: var(--ink);
    color: var(--paper);
}

.cookie-btn-primary {
    background: var(--ink);
    color: var(--paper-raised);
    border: 1.5px solid var(--ink);
    font-family: var(--font-mono);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.cookie-btn-primary:hover {
    background: var(--accent-deep);
    border-color: var(--accent-deep);
}

.cookie-btn:focus-visible,
.cookie-close:focus-visible,
.cookie-links a:focus-visible {
    outline: 2px solid var(--accent-deep);
    outline-offset: 2px;
}

/* ==============================
   MODAL — "Cookie Facts" label
================================ */
.cookie-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(20, 17, 12, 0.6);
    z-index: 1000000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.cookie-modal {
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
    overflow-y: auto;
    background: var(--paper-raised);
    border: 2px solid var(--line);
    box-shadow: 0 20px 60px rgba(0,0,0,0.35);
}

.cookie-modal-header {
    padding: 24px 26px 16px;
    position: relative;
}

.cookie-modal-header .mark {
    font-family: var(--font-mono);
    font-size: 11px;
    letter-spacing: 0.12em;
    color: var(--accent-deep);
}

.cookie-modal-header h3 {
    margin: 4px 0 0;
    font-family: var(--font-display);
    font-weight: 900;
    font-size: 28px;
    letter-spacing: 0.01em;
    text-transform: uppercase;
}

.cookie-close {
    position: absolute;
    top: 20px;
    right: 20px;
    border: 1.5px solid var(--ink);
    background: transparent;
    width: 30px;
    height: 30px;
    font-size: 18px;
    line-height: 1;
    cursor: pointer;
    color: var(--ink);
}
.cookie-close:hover { background: var(--ink); color: var(--paper); }

.cookie-rule-thick {
    height: 6px;
    background: var(--ink);
    margin: 0 26px;
}

.cookie-serving {
    display: flex;
    justify-content: space-between;
    padding: 12px 26px;
    font-family: var(--font-mono);
    font-size: 12px;
    border-bottom: 1px solid var(--line);
}
.cookie-serving span:last-child { color: var(--ink-soft); }

/* ==============================
   ROWS
================================ */
.cookie-modal-body {
    padding: 0 26px;
}

.cookie-option {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 18px;
    padding: 18px 0;
    border-bottom: 1px solid var(--line-soft);
}

.cookie-option-info h4 {
    margin: 0 0 5px;
    font-family: var(--font-mono);
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.cookie-option-info p {
    margin: 0;
    color: var(--ink-soft);
    font-size: 12.5px;
    line-height: 1.5;
    max-width: 320px;
}

.cookie-always-active {
    font-family: var(--font-mono);
    font-size: 10.5px;
    letter-spacing: 0.06em;
    color: var(--accent-deep);
    background: rgba(184,121,30,0.14);
    padding: 6px 9px;
    border-radius: 2px;
    white-space: nowrap;
    margin-top: 2px;
}

/* ==============================
   TOGGLE
================================ */
.cookie-switch {
    position: relative;
    display: inline-block;
    width: 42px;
    height: 24px;
    flex-shrink: 0;
    margin-top: 2px;
}

.cookie-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.cookie-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: transparent;
    border: 1.5px solid var(--ink);
    border-radius: 2px;
    transition: .15s;
}

.cookie-slider:before {
    content: "";
    position: absolute;
    height: 16px;
    width: 16px;
    left: 2px;
    top: 2px;
    background: var(--ink);
    transition: .15s;
}

.cookie-switch input:checked + .cookie-slider {
    background: var(--accent);
    border-color: var(--accent-deep);
}
.cookie-switch input:checked + .cookie-slider:before {
    transform: translateX(18px);
    background: var(--paper-raised);
}

/* ==============================
   MODAL FOOTER
================================ */
.cookie-modal-footer {
    padding: 18px 26px 26px;
}

.cookie-modal-footer .cookie-btn-primary {
    width: 100%;
    justify-content: center;
    padding: 13px 18px;
    font-size: 13px;
}

.cookie-modal-footer-links {
    display: flex;
    justify-content: center;
    margin-top: 12px;
}

.cookie-settings-button {
    border: none;
    background: transparent;
    color: var(--ink-soft);
    text-decoration: underline;
    text-underline-offset: 3px;
    cursor: pointer;
    font-size: 12px;
    padding: 0;
    font-family: var(--font-mono);
}
.cookie-settings-button:hover { color: var(--ink); }

/* ==============================
   MOBILE
================================ */
@media (max-width: 720px) {
    .cookie-banner {
        left: 8px;
        right: 8px;
        bottom: 8px;
    }
    .cookie-banner-content {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        padding: 18px 18px 20px;
    }
    .cookie-actions {
        flex-direction: column;
        width: 100%;
    }
    .cookie-actions .cookie-btn {
        width: 100%;
        text-align: center;
        justify-content: center;
    }
    .cookie-btn-text {
        order: 3;
    }
    .cookie-modal-header h3 { font-size: 22px; }
    .cookie-rule-thick, .cookie-modal-body, .cookie-serving, .cookie-modal-footer {
        margin-left: 0;
        margin-right: 0;
    }
}

@media (prefers-reduced-motion: reduce) {
    #cookie-consent-wrapper * { transition: none !important; }
}
</style>

<div id="cookie-consent-wrapper">

    <!-- Cookie Banner -->
    <div id="cookie-banner" class="cookie-banner" role="region" aria-label="Cookie consent">
        <div class="cookie-banner-perf" aria-hidden="true"></div>
        <div class="cookie-banner-body">
            <div class="cookie-banner-content">
                <div class="cookie-text">
                    <div class="cookie-eyebrow">
                        <span class="mark">001 · CONSENT</span>
                    </div>
                    <h3>Cookie Facts</h3>
                    <p>
                        This site uses cookies to run properly, understand traffic,
                        and support marketing. Choose what you allow — necessary
                        cookies stay on either way.
                    </p>
                    <div class="cookie-links">
                        <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ url('/cookie-policy') }}">Cookie Policy</a>
                    </div>
                </div>

                <div class="cookie-actions">
                    <button type="button" id="cookie-reject" class="cookie-btn cookie-btn-text">
                        Reject non-essential
                    </button>
                    <button type="button" id="cookie-preferences" class="cookie-btn cookie-btn-outline">
                        Manage
                    </button>
                    <button type="button" id="cookie-accept" class="cookie-btn cookie-btn-primary">
                        Accept all →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Preferences Modal -->
    <div id="cookie-preferences-modal" class="cookie-modal-overlay">
        <div class="cookie-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-modal-title">

            <div class="cookie-modal-header">
                <span class="mark">001 · CONSENT</span>
                <h3 id="cookie-modal-title">Cookie Facts</h3>
                <button type="button" id="cookie-modal-close" class="cookie-close" aria-label="Close">&times;</button>
            </div>

            <div class="cookie-rule-thick"></div>

            <div class="cookie-serving">
                <span>Serving size</span>
                <span>1 visit</span>
            </div>

            <div class="cookie-modal-body">

                <div class="cookie-option">
                    <div class="cookie-option-info">
                        <h4>Necessary</h4>
                        <p>Required to run the site — login, cart, security. Can't be turned off.</p>
                    </div>
                    <span class="cookie-always-active">Always on</span>
                </div>

                <div class="cookie-option">
                    <div class="cookie-option-info">
                        <h4>Analytics</h4>
                        <p>Aggregated usage data that shows us what's working and what isn't.</p>
                    </div>
                    <label class="cookie-switch">
                        <input type="checkbox" id="cookie-analytics">
                        <span class="cookie-slider"></span>
                    </label>
                </div>

                <div class="cookie-option">
                    <div class="cookie-option-info">
                        <h4>Marketing</h4>
                        <p>Used to measure ad performance and personalize what you see elsewhere.</p>
                    </div>
                    <label class="cookie-switch">
                        <input type="checkbox" id="cookie-marketing">
                        <span class="cookie-slider"></span>
                    </label>
                </div>

            </div>

            <div class="cookie-rule-thick"></div>

            <div class="cookie-modal-footer">
                <button type="button" id="cookie-save-preferences" class="cookie-btn cookie-btn-primary">
                    Save preferences
                </button>
                <div class="cookie-modal-footer-links">
                    <button type="button" id="cookie-modal-reject-all" class="cookie-settings-button">
                        Reject all instead
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const banner = document.getElementById('cookie-banner');
    const modal = document.getElementById('cookie-preferences-modal');
    const modalPanel = modal.querySelector('.cookie-modal');

    const acceptButton = document.getElementById('cookie-accept');
    const rejectButton = document.getElementById('cookie-reject');
    const preferencesButton = document.getElementById('cookie-preferences');
    const closeButton = document.getElementById('cookie-modal-close');
    const saveButton = document.getElementById('cookie-save-preferences');
    const modalRejectAll = document.getElementById('cookie-modal-reject-all');

    const analyticsCheckbox = document.getElementById('cookie-analytics');
    const marketingCheckbox = document.getElementById('cookie-marketing');

    const STORAGE_KEY = 'cookie_preferences';
    const POLICY_VERSION = 1;
    const CONSENT_MAX_AGE_DAYS = 180;

    let lastFocused = null;

    function getPreferences() {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (!stored) return null;
        try {
            const parsed = JSON.parse(stored);
            const ageDays = (Date.now() - (parsed.timestamp || 0)) / 86400000;
            if (parsed.policyVersion !== POLICY_VERSION || ageDays > CONSENT_MAX_AGE_DAYS) {
                return null;
            }
            return parsed;
        } catch (error) {
            console.error('Invalid cookie preferences:', error);
            return null;
        }
    }

    function savePreferences(preferences) {
        preferences.timestamp = Date.now();
        preferences.policyVersion = POLICY_VERSION;
        localStorage.setItem(STORAGE_KEY, JSON.stringify(preferences));
        applyConsent(preferences);
        hideBanner();
        closeModal();
    }

    function applyConsent(preferences) {
        if (preferences.analytics === true) loadAnalytics();
        if (preferences.marketing === true) loadMarketing();
    }

    acceptButton.addEventListener('click', function () {
        savePreferences({ necessary: true, analytics: true, marketing: true });
    });

    rejectButton.addEventListener('click', function () {
        savePreferences({ necessary: true, analytics: false, marketing: false });
    });

    modalRejectAll.addEventListener('click', function () {
        savePreferences({ necessary: true, analytics: false, marketing: false });
    });

    preferencesButton.addEventListener('click', openModal);

    function openModal() {
        const preferences = getPreferences();
        analyticsCheckbox.checked = preferences ? preferences.analytics === true : false;
        marketingCheckbox.checked = preferences ? preferences.marketing === true : false;

        lastFocused = document.activeElement;
        modal.style.display = 'flex';
        closeButton.focus();
        document.addEventListener('keydown', trapFocus);
    }

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) closeModal();
    });

    saveButton.addEventListener('click', function () {
        savePreferences({
            necessary: true,
            analytics: analyticsCheckbox.checked,
            marketing: marketingCheckbox.checked
        });
    });

    function showBanner() { banner.style.display = 'block'; }
    function hideBanner() { banner.style.display = 'none'; }

    function closeModal() {
        modal.style.display = 'none';
        document.removeEventListener('keydown', trapFocus);
        if (lastFocused) lastFocused.focus();
    }

    function trapFocus(event) {
        if (event.key === 'Escape') {
            closeModal();
            return;
        }
        if (event.key !== 'Tab') return;

        const focusable = modalPanel.querySelectorAll(
            'button, [href], input, [tabindex]:not([tabindex="-1"])'
        );
        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }

    const existingPreferences = getPreferences();
    if (existingPreferences) {
        hideBanner();
        applyConsent(existingPreferences);
    } else {
        showBanner();
    }

    /* Google Analytics */
    function loadAnalytics() {
        if (window.analyticsLoaded) return;
        window.analyticsLoaded = true;

        const GA_ID = 'G-XXXXXXXXXX'; // Replace with your Google Analytics ID

        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
        document.head.appendChild(script);

        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', GA_ID);
    }

    /* Meta Pixel */
    function loadMarketing() {
        if (window.metaPixelLoaded) return;
        window.metaPixelLoaded = true;
        // Add your Meta Pixel implementation here.
        console.log('Marketing cookies enabled');
    }

});
</script>