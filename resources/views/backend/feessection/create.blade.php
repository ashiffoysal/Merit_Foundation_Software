@extends('layouts.backend')
@section('content')

<div class="container">
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1>Create Plan</h1>
            <p>Create a new subscription plan</p>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="btn-outline-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- Global AJAX alert --}}
    <div id="ajax-alert" class="alert alert-dismissible fade show mb-3 d-none" role="alert">
        <i class="fas me-2" id="ajax-alert-icon"></i>
        <span id="ajax-alert-msg"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="row g-4">

        {{-- ── Main Form ── --}}
        <div class="col-lg-8">
            <form id="plan-form" novalidate>
                @csrf

                {{-- ① Basic Info --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-tag"></i> Basic Information</div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">

                            {{-- Plan Name --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Plan Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                           class="f-input" placeholder="e.g. Standard, Premium">
                                    <div class="invalid-feedback-custom" id="err-name"></div>
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="f-input">
                                        <option value="">— Select Category —</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback-custom" id="err-category_id"></div>
                                </div>
                            </div>

                            {{-- Country Code --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Country Code <span class="text-danger">*</span></label>
                                    <input type="text" name="country_code" id="country_code"
                                           class="f-input" placeholder="GB" maxlength="2"
                                           value="GB" style="text-transform:uppercase">
                                    <div class="invalid-feedback-custom" id="err-country_code"></div>
                                </div>
                            </div>

                            {{-- Badge --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Badge <small class="text-muted">(optional)</small></label>
                                    <input type="text" name="badge" id="badge"
                                           class="f-input" placeholder="e.g. POPULAR">
                                    <div class="invalid-feedback-custom" id="err-badge"></div>
                                </div>
                            </div>

                            {{-- Button Text --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Button Text <span class="text-danger">*</span></label>
                                    <input type="text" name="button_text" id="button_text"
                                           class="f-input" placeholder="Choose Plan" value="Choose Plan">
                                    <div class="invalid-feedback-custom" id="err-button_text"></div>
                                </div>
                            </div>

                            {{-- Subtitle --}}
                            <div class="col-md-12">
                                <div class="f-group">
                                    <label class="f-label">Subtitle <small class="text-muted">(optional)</small></label>
                                    <input type="text" name="subtitle" id="subtitle"
                                           class="f-input" placeholder="e.g. Ideal for beginners and younger students">
                                    <div class="invalid-feedback-custom" id="err-subtitle"></div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <div class="f-group">
                                    <label class="f-label">Description <small class="text-muted">(optional)</small></label>
                                    <textarea name="description" id="description" rows="3"
                                              class="f-input" placeholder="Full details about the plan…"></textarea>
                                    <div class="invalid-feedback-custom" id="err-description"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ② Class Details --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-chalkboard-teacher"></i> Class Details</div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">

                            {{-- Duration --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Session Duration <span class="text-danger">*</span></label>
                                    <select name="duration" id="duration" class="f-input">
                                        <option value="">— Select Duration —</option>
                                        <option value="30_minutes">30 Minutes</option>
                                        <option value="1_hour">1 Hour</option>
                                    </select>
                                    <div class="invalid-feedback-custom" id="err-duration"></div>
                                </div>
                            </div>

                            {{-- Days Per Week --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Days Per Week <span class="text-danger">*</span></label>
                                    <input type="number" name="days_per_week" id="days_per_week"
                                           class="f-input" placeholder="e.g. 3" min="1" max="7">
                                    <div class="invalid-feedback-custom" id="err-days_per_week"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ③ Pricing --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-pound-sign"></i> Pricing</div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">

                            {{-- Monthly Price --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Monthly Price <span class="text-danger">*</span></label>
                                    <div class="input-prefix-wrap">
                                        <span class="input-prefix" id="currency-symbol">£</span>
                                        <input type="number" name="monthly_price" id="monthly_price"
                                               class="f-input f-input-prefixed"
                                               placeholder="0.00" step="0.01" min="0">
                                    </div>
                                    <div class="invalid-feedback-custom" id="err-monthly_price"></div>
                                </div>
                            </div>

                            {{-- Currency --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Currency <span class="text-danger">*</span></label>
                                    <select name="currency" id="currency" class="f-input">
                                        <option value="GBP" selected>GBP — £</option>
                                        <option value="USD">USD — $</option>
                                        <option value="EUR">EUR — €</option>
                                        <option value="BDT">BDT — ৳</option>
                                    </select>
                                    <div class="invalid-feedback-custom" id="err-currency"></div>
                                </div>
                            </div>

                            {{-- Billing Interval (read-only) --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Billing Interval</label>
                                    <input type="text" class="f-input" value="Monthly" readonly
                                           style="background:#f8f8f8;cursor:not-allowed;color:#888">
                                    <input type="hidden" name="billing_interval" value="month">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ④ Stripe --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fab fa-stripe-s"></i> Stripe Integration</div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">

                            {{-- Stripe Price ID --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Stripe Price ID <span class="text-danger">*</span></label>
                                    <input type="text" name="stripe_price_id" id="stripe_price_id"
                                           class="f-input" placeholder="price_xxxxxxxxxxxxxxxxxx">
                                    <div class="invalid-feedback-custom" id="err-stripe_price_id"></div>
                                </div>
                            </div>

                            {{-- Stripe Product ID --}}
                            <div class="col-md-6">
                                <div class="f-group">
                                    <label class="f-label">Stripe Product ID <small class="text-muted">(optional)</small></label>
                                    <input type="text" name="stripe_product_id" id="stripe_product_id"
                                           class="f-input" placeholder="prod_xxxxxxxxxxxxxxxxxx">
                                    <div class="invalid-feedback-custom" id="err-stripe_product_id"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ⑤ Features --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-list-check"></i> Features</div>
                    </div>
                    <div class="card-body-custom">

                        <div id="features-list" class="d-flex flex-column gap-2 mb-3">
                            {{-- Dynamic feature rows injected here --}}
                        </div>

                        <button type="button" id="add-feature" class="btn-outline-sm">
                            <i class="fas fa-plus"></i> Add Feature
                        </button>
                        <div class="invalid-feedback-custom" id="err-features"></div>
                    </div>
                </div>

                {{-- ⑥ Settings --}}
                <div class="card mb-4">
                    <div class="card-header-custom">
                        <div class="card-title"><i class="fas fa-cog"></i> Settings</div>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3 align-items-center">

                            {{-- Sort Order --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order"
                                           class="f-input" value="0" min="0">
                                    <div class="invalid-feedback-custom" id="err-sort_order"></div>
                                </div>
                            </div>

                            {{-- Active Status --}}
                            <div class="col-md-4">
                                <div class="f-group">
                                    <label class="f-label d-block mb-2">Status</label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox"
                                               name="is_active" id="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 mb-5">
                    <button type="submit" class="btn-gold-sm" id="submit-btn">
                        <span id="submit-text"><i class="fas fa-save"></i> Create Plan</span>
                        <span id="submit-spinner" class="d-none">
                            <span class="spinner-border spinner-border-sm me-1" role="status"></span> Saving…
                        </span>
                    </button>
                    <a href="{{ route('admin.plans.index') }}" class="btn-outline-sm">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>

        {{-- ── Sidebar ── --}}
        <div class="col-lg-4">

            {{-- Live Preview --}}
            <div class="card mb-4" style="position:sticky;top:1.5rem">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-eye"></i> Live Preview</div>
                </div>
                <div class="card-body-custom">

                    <div class="plan-preview-card">
                        <div class="plan-preview-badge d-none" id="prev-badge"></div>
                        <div class="plan-preview-name" id="prev-name">Plan Name</div>
                        <div class="plan-preview-subtitle" id="prev-subtitle"></div>
                        <div class="plan-preview-price">
                            <span class="plan-preview-currency" id="prev-currency-sym">£</span>
                            <span class="plan-preview-amount" id="prev-price">0.00</span>
                            <span class="plan-preview-interval">/mo</span>
                        </div>
                        <div class="plan-preview-meta" id="prev-meta">— / — days/wk</div>
                        <ul class="plan-preview-features" id="prev-features"></ul>
                        <button class="plan-preview-btn" id="prev-btn-text">Choose Plan</button>
                    </div>

                </div>
            </div>

            {{-- Tips --}}
            <div class="card">
                <div class="card-header-custom">
                    <div class="card-title"><i class="fas fa-info-circle"></i> Tips</div>
                </div>
                <div class="card-body-custom">
                    <ul class="tips-list">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Stripe Price ID must be unique per plan.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Country + Duration + Days/week combination must be unique.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Features are stored as a JSON array.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Use the badge field to highlight popular plans.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.invalid-feedback-custom {
    color: #dc3545;
    font-size: .8rem;
    margin-top: .3rem;
    display: none;
}
.invalid-feedback-custom.visible { display: block; }
.f-input.is-invalid { border-color: #dc3545 !important; }

.input-prefix-wrap { position: relative; }
.input-prefix {
    position: absolute;
    left: .75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: .9rem;
    pointer-events: none;
}
.f-input-prefixed { padding-left: 2rem !important; }

.feature-row {
    display: flex;
    gap: .5rem;
    align-items: center;
}
.feature-row .f-input { flex: 1; }
.feature-row .remove-feature {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 1rem;
    cursor: pointer;
    padding: .25rem .5rem;
    border-radius: 4px;
    transition: background .2s;
}
.feature-row .remove-feature:hover { background: #fdf0f0; }

.plan-preview-card {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
    border-radius: 16px;
    padding: 1.5rem 1.25rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.plan-preview-card::before {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    background: rgba(255,215,0,.08);
    border-radius: 50%;
    top: -40px;
    right: -30px;
}
.plan-preview-badge {
    display: inline-block;
    background: #ffd700;
    color: #1a1a2e;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .08em;
    padding: .2rem .6rem;
    border-radius: 20px;
    margin-bottom: .6rem;
}
.plan-preview-name {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: .2rem;
}
.plan-preview-subtitle {
    font-size: .78rem;
    opacity: .65;
    margin-bottom: .8rem;
    min-height: 1rem;
}
.plan-preview-price {
    display: flex;
    align-items: baseline;
    gap: .15rem;
    margin-bottom: .3rem;
}
.plan-preview-currency { font-size: 1rem; opacity: .8; }
.plan-preview-amount  { font-size: 2rem; font-weight: 700; line-height: 1; }
.plan-preview-interval{ font-size: .8rem; opacity: .6; }
.plan-preview-meta {
    font-size: .75rem;
    opacity: .55;
    margin-bottom: 1rem;
}
.plan-preview-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.2rem;
    display: flex;
    flex-direction: column;
    gap: .35rem;
}
.plan-preview-features li {
    font-size: .8rem;
    display: flex;
    align-items: center;
    gap: .45rem;
}
.plan-preview-features li::before {
    content: '✓';
    color: #ffd700;
    font-weight: 700;
    font-size: .85rem;
}
.plan-preview-btn {
    width: 100%;
    background: #ffd700;
    color: #1a1a2e;
    border: none;
    border-radius: 8px;
    padding: .55rem 1rem;
    font-weight: 700;
    font-size: .85rem;
    cursor: default;
}
.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: .6rem;
    font-size: .82rem;
    color: #555;
}
</style>

<script>
(function () {
    'use strict';

    const currencySymbols = { GBP: '£', USD: '$', EUR: '€', BDT: '৳' };
    const $   = id => document.getElementById(id);
    const val = id => ($( id)?.value ?? '').trim();

    function showError(field, msg) {
        const el    = $(`err-${field}`);
        const input = document.querySelector(`[name="${field}"]`);
        if (el)    { el.textContent = msg; el.classList.add('visible'); }
        if (input) { input.classList.add('is-invalid'); }
    }

    function clearErrors() {
        document.querySelectorAll('.invalid-feedback-custom').forEach(el => {
            el.textContent = ''; el.classList.remove('visible');
        });
        document.querySelectorAll('.f-input.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    function showAlert(type, msg) {
        const wrap = $('ajax-alert');
        wrap.className = `alert alert-${type} alert-dismissible fade show mb-3`;
        $('ajax-alert-icon').className =
            `fas me-2 ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}`;
        $('ajax-alert-msg').textContent = msg;
        wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function setLoading(loading) {
        $('submit-btn').disabled = loading;
        $('submit-text').classList.toggle('d-none', loading);
        $('submit-spinner').classList.toggle('d-none', !loading);
    }

    /* ── Feature rows ── */
    let featureCount = 0;

    function addFeatureRow(value = '') {
        featureCount++;
        const div = document.createElement('div');
        div.className = 'feature-row';
        div.innerHTML = `
            <input type="text" name="features[]" class="f-input"
                   placeholder="e.g. 1-to-1 personal lesson"
                   value="${value.replace(/"/g, '&quot;')}">
            <button type="button" class="remove-feature" title="Remove">
                <i class="fas fa-trash-alt"></i>
            </button>`;
        div.querySelector('.remove-feature').addEventListener('click', () => {
            div.remove(); updatePreviewFeatures();
        });
        $('features-list').appendChild(div);
        updatePreviewFeatures();
    }

    $('add-feature').addEventListener('click', () => {
        addFeatureRow();
        const rows = $('features-list').querySelectorAll('input');
        rows[rows.length - 1]?.focus();
    });

    addFeatureRow(); // one blank row by default

    /* ── Live preview ── */
    function updatePreview() {
        $('prev-name').textContent     = val('name')         || 'Plan Name';
        $('prev-subtitle').textContent = val('subtitle')     || '';
        $('prev-price').textContent    = parseFloat(val('monthly_price') || 0).toFixed(2);
        $('prev-btn-text').textContent = val('button_text')  || 'Choose Plan';

        const sym = currencySymbols[val('currency') || 'GBP'] || val('currency') || '£';
        $('prev-currency-sym').textContent = sym;
        $('currency-symbol').textContent   = sym;

        const dur = val('duration').replace('_', ' ');
        const dpw = val('days_per_week');
        $('prev-meta').textContent = `${dur || '—'} · ${dpw || '—'} days/wk`;

        const badge = val('badge');
        $('prev-badge').textContent = badge;
        $('prev-badge').classList.toggle('d-none', !badge);

        updatePreviewFeatures();
    }

    function updatePreviewFeatures() {
        const ul = $('prev-features');
        ul.innerHTML = '';
        $('features-list').querySelectorAll('input').forEach(inp => {
            const v = inp.value.trim();
            if (v) { const li = document.createElement('li'); li.textContent = v; ul.appendChild(li); }
        });
    }

    ['name','subtitle','monthly_price','button_text','badge','days_per_week']
        .forEach(id => $( id)?.addEventListener('input', updatePreview));
    ['currency','duration'].forEach(id => $( id)?.addEventListener('change', updatePreview));
    $('features-list').addEventListener('input', updatePreviewFeatures);
    $('country_code').addEventListener('input', function () { this.value = this.value.toUpperCase(); });

    /* ── AJAX Submit ── */
    $('plan-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        clearErrors();
        setLoading(true);

        const formData = new FormData(this);

        // Collect features as JSON
        const features = [];
        $('features-list').querySelectorAll('input').forEach(inp => {
            const v = inp.value.trim(); if (v) features.push(v);
        });
        formData.delete('features[]');
        formData.set('features', JSON.stringify(features));

        // Checkbox
        formData.set('is_active', $('is_active').checked ? '1' : '0');

        try {
            const res  = await fetch('{{ route("admin.plans.store") }}', {
                method : 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                    || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData,
            });
            const data = await res.json();

            if (res.ok && data.success) {
                showAlert('success', data.message ?? 'Plan created successfully!');
                if (data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1200);
                } else {
                    this.reset();
                    $('features-list').innerHTML = '';
                    featureCount = 0;
                    addFeatureRow();
                    updatePreview();
                }
            } else if (res.status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => showError(field, msgs[0]));
                showAlert('danger', data.message ?? 'Please fix the errors below.');
            } else {
                showAlert('danger', data.message ?? 'Something went wrong.');
            }
        } catch (err) {
            console.error(err);
            showAlert('danger', 'Network error. Please check your connection.');
        } finally {
            setLoading(false);
        }
    });

    updatePreview();
})();
</script>

@endsection