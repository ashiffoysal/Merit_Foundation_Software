@extends('layouts.backend')
@section('content')
@php
    $data = \App\Models\Seo::first();
@endphp

{{-- Toast --}}
<div id="toast" style="display:none;position:fixed;top:22px;right:22px;z-index:9999;min-width:260px;max-width:380px;padding:13px 18px;border-radius:12px;display:none;align-items:center;gap:10px;font-size:.83rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.22)">
    <i id="toast-icon"></i>
    <span id="toast-msg"></span>
</div>

<style>
/* ── Page shell ── */
.seo-page { max-width: 1060px; margin: 0 auto; padding-bottom: 60px; }

/* ── Page header ── */
.seo-ph { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:28px; gap:16px; flex-wrap:wrap; }
.seo-ph-left h1 { font-size:1.45rem; font-weight:700; margin:0 0 4px; }
.seo-ph-left p  { font-size:.8rem; color:var(--muted,#94a3b8); margin:0; }

/* ── Save button ── */
.btn-seo-save {
    display:inline-flex; align-items:center; gap:8px;
    padding:10px 24px; border-radius:10px; border:none;
    background:#f59e0b; color:#000; font-size:.82rem; font-weight:700;
    cursor:pointer; transition:opacity .2s, transform .1s;
    white-space:nowrap;
}
.btn-seo-save:hover   { opacity:.88; }
.btn-seo-save:active  { transform:scale(.97); }
.btn-seo-save:disabled{ opacity:.55; cursor:not-allowed; }

/* ── Sections ── */
.seo-sections { display:flex; flex-direction:column; gap:20px; }

.seo-block {
    background:var(--card-bg,#ffffff);
    border:1px solid var(--border,#334155);
    border-radius:16px; overflow:hidden;
}
.seo-block-head {
    display:flex; align-items:center; gap:10px;
    padding:14px 22px;
    border-bottom:1px solid var(--border,#010202);
    background:rgba(255,255,255,.025);
}
.seo-block-icon {
    width:32px; height:32px; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    font-size:.9rem; flex-shrink:0;
}
.ico-amber { background:rgba(245,158,11,.15); color:#f59e0b; }
.ico-blue  { background:rgba(59,130,246,.15);  color:#60a5fa; }
.ico-purple{ background:rgba(139,92,246,.15);  color:#a78bfa; }
.ico-teal  { background:rgba(20,184,166,.15);  color:#2dd4bf; }
.ico-rose  { background:rgba(244,63,94,.15);   color:#fb7185; }

.seo-block-title { font-size:.84rem; font-weight:700; flex:1; }
.seo-block-sub   { font-size:.7rem; color:var(--muted,#94a3b8); }

.seo-block-body { padding:20px 22px; }

/* ── Form grid ── */
.fg { display:grid; grid-template-columns:1fr 1fr; gap:14px 18px; }
.fg-3 { grid-template-columns:1fr 1fr 1fr; }
.fc  { grid-column:1/-1; }



.f-input, .f-textarea, .f-select {
    background: #ffffff !important;
    border: 1.5px solid var(--border, #334155);
    border-radius: 9px;
    color: var(--text, #f1f5f9);
    font-size: .82rem;
    padding: 9px 12px;
    transition: border-color .18s, box-shadow .18s;
    width: 100%;
    box-sizing: border-box;
}
@media(max-width:640px){ .fg,.fg-3{ grid-template-columns:1fr; } }

.f-group { display:flex; flex-direction:column; gap:5px; }
.f-label {
    font-size:.68rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:var(--muted,#94a3b8);
    display:flex; align-items:center; justify-content:space-between;
}
.f-label-hint { font-weight:400; text-transform:none; letter-spacing:0; font-size:.67rem; }
.f-counter { font-size:.67rem; color:var(--muted,#94a3b8); }
.f-counter.over { color:#ef4444; }

.f-input,.f-textarea,.f-select {
    background:var(--input-bg,#0f172a);
    border:1.5px solid var(--border,#334155);
    border-radius:9px; color:var(--text,#f1f5f9);
    font-size:.82rem; padding:9px 12px;
    transition:border-color .18s, box-shadow .18s;
    width:100%; box-sizing:border-box;
}
.f-input:focus,.f-textarea:focus,.f-select:focus {
    outline:none;
    border-color:#f59e0b;
    box-shadow:0 0 0 3px rgba(245,158,11,.13);
}
.f-input.is-invalid,.f-textarea.is-invalid,.f-select.is-invalid {
    border-color:#ef4444 !important;
    box-shadow:0 0 0 3px rgba(239,68,68,.12) !important;
}
.f-textarea { resize:vertical; min-height:72px; }
.f-code { font-family:'Fira Code','Courier New',monospace; font-size:.75rem; min-height:110px; }
.f-select { cursor:pointer; }

.err-msg { color:#ef4444; font-size:.69rem; display:block; min-height:14px; }

/* ── File upload ── */
.f-file-wrap { display:flex; flex-direction:column; gap:6px; }
.f-file-preview { display:flex; align-items:center; gap:8px; }
.f-file-preview img { height:44px; object-fit:contain; border-radius:6px; border:1px solid var(--border,#334155); }
.f-file-label {
    display:flex; align-items:center; gap:8px;
    padding:9px 13px; border:1.5px dashed var(--border,#334155);
    border-radius:9px; cursor:pointer; font-size:.77rem;
    color:var(--muted,#94a3b8); transition:border-color .2s, background .2s;
}
.f-file-label:hover { border-color:#f59e0b; background:rgba(245,158,11,.04); color:var(--text,#f1f5f9); }
.f-file-label i { color:#f59e0b; font-size:.85rem; }
.f-file-input { display:none; }

/* ── SERP preview ── */
.serp-preview {
    background:var(--input-bg,#0f172a);
    border:1px solid var(--border,#334155);
    border-radius:10px; padding:14px 16px; margin-top:14px;
}
.serp-label { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted,#94a3b8); margin-bottom:10px; }
.serp-url   { font-size:.74rem; color:#22c55e; margin-bottom:3px; }
.serp-title { font-size:1.05rem; font-weight:600; color:#60a5fa; margin-bottom:4px; line-height:1.3; }
.serp-desc  { font-size:.78rem; color:var(--muted,#94a3b8); line-height:1.5; }

/* ── Toggle switch ── */
.toggle-row { display:flex; align-items:center; justify-content:space-between; gap:12px; }
.toggle-info h6 { font-size:.82rem; font-weight:600; margin:0 0 2px; }
.toggle-info p  { font-size:.72rem; color:var(--muted,#94a3b8); margin:0; }
.toggle-sw { position:relative; width:42px; height:22px; flex-shrink:0; }
.toggle-sw input { opacity:0; width:0; height:0; position:absolute; }
.toggle-track {
    position:absolute; inset:0; border-radius:22px;
    background:var(--border,#334155); cursor:pointer; transition:background .2s;
}
.toggle-sw input:checked ~ .toggle-track { background:#f59e0b; }
.toggle-track::after {
    content:''; position:absolute; top:3px; left:3px;
    width:16px; height:16px; border-radius:50%;
    background:#fff; transition:transform .2s;
}
.toggle-sw input:checked ~ .toggle-track::after { transform:translateX(20px); }

/* ── Spinner ── */
.sp { display:inline-block; width:13px; height:13px; border:2px solid rgba(0,0,0,.25); border-top-color:#000; border-radius:50%; animation:spin .65s linear infinite; }
@keyframes spin { to{transform:rotate(360deg)} }

/* ── Toast anim ── */
@keyframes tIn  { from{opacity:0;transform:translateX(50px)} to{opacity:1;transform:none} }
@keyframes tOut { from{opacity:1;transform:none} to{opacity:0;transform:translateX(50px)} }
</style>

<div class="seo-page">

    {{-- Header --}}
    <div class="seo-ph">
        <div class="seo-ph-left">
            <h1><i class="fas fa-search" style="color:#f59e0b;margin-right:8px"></i>SEO Settings</h1>
            <p>Manage meta tags, Open Graph, Twitter cards, redirects and schema markup</p>
        </div>
        <button class="btn-seo-save" id="saveSeoBtn" onclick="saveSeoInfo()">
            <span id="seo-btn-text"><i class="fas fa-save"></i> Save All Changes</span>
            <span id="seo-btn-spin" style="display:none"><span class="sp"></span> Saving…</span>
        </button>
    </div>

    <form id="seoForm" enctype="multipart/form-data" novalidate>
    @csrf
    <div class="seo-sections">

        {{-- ── Block 1: URLs & Redirect ── --}}
        <div class="seo-block">
            <div class="seo-block-head">
                <div class="seo-block-icon ico-amber"><i class="fas fa-link"></i></div>
                <div>
                    <div class="seo-block-title">Page URLs &amp; Redirect</div>
                    <div class="seo-block-sub">Manage 301/302 redirects and canonical link</div>
                </div>
            </div>
            <div class="seo-block-body">
                <div class="fg fg-3">
                    <div class="f-group fc" style="grid-column:span 1">
                        <label class="f-label">Old URL</label>
                        <input type="url" name="old_url" class="f-input" value="{{ $data->old_url ?? '' }}" placeholder="https://example.com/old-page">
                        <span class="err-msg" id="err-old_url"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">New URL</label>
                        <input type="url" name="new_url" class="f-input" value="{{ $data->new_url ?? '' }}" placeholder="https://example.com/new-page">
                        <span class="err-msg" id="err-new_url"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Redirect Type</label>
                        <select name="redirect_type" class="f-select">
                            <option value="301" {{ ($data->redirect_type ?? '301') == '301' ? 'selected' : '' }}>301 — Permanent Redirect</option>
                            <option value="302" {{ ($data->redirect_type ?? '') == '302' ? 'selected' : '' }}>302 — Temporary Redirect</option>
                        </select>
                        <span class="err-msg" id="err-redirect_type"></span>
                    </div>
                    <div class="f-group fc">
                        <label class="f-label">Canonical URL</label>
                        <input type="url" name="canonical_url" class="f-input" value="{{ $data->canonical_url ?? '' }}" placeholder="https://example.com/canonical">
                        <span class="err-msg" id="err-canonical_url"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Block 2: Meta Tags + SERP Preview ── --}}
        <div class="seo-block">
            <div class="seo-block-head">
                <div class="seo-block-icon ico-blue"><i class="fas fa-tags"></i></div>
                <div>
                    <div class="seo-block-title">Meta Tags</div>
                    <div class="seo-block-sub">Page title, description, keywords &amp; indexing</div>
                </div>
            </div>
            <div class="seo-block-body">
                <div class="fg">
                    <div class="f-group">
                        <label class="f-label">
                            Page Title
                            <span class="f-counter" id="cnt-page_title">{{ strlen($data->page_title ?? '') }}/70</span>
                        </label>
                        <input type="text" name="page_title" id="inp-page_title" class="f-input"
                            value="{{ $data->page_title ?? '' }}" placeholder="Homepage | Brand Name"
                            oninput="tick(this,'cnt-page_title',70);serpUpdate()">
                        <span class="err-msg" id="err-page_title"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">
                            Meta Title
                            <span class="f-counter" id="cnt-meta_title">{{ strlen($data->meta_title ?? '') }}/60</span>
                        </label>
                        <input type="text" name="meta_title" id="inp-meta_title" class="f-input"
                            value="{{ $data->meta_title ?? '' }}" placeholder="SEO-focused meta title"
                            oninput="tick(this,'cnt-meta_title',60);serpUpdate()">
                        <span class="err-msg" id="err-meta_title"></span>
                    </div>
                    <div class="f-group fc">
                        <label class="f-label">
                            Meta Description
                            <span class="f-counter" id="cnt-meta_desc">{{ strlen($data->meta_description ?? '') }}/160</span>
                        </label>
                        <textarea name="meta_description" id="inp-meta_desc" class="f-textarea" rows="2"
                            placeholder="Concise summary shown in search results (120–160 chars)"
                            oninput="tick(this,'cnt-meta_desc',160);serpUpdate()">{{ $data->meta_description ?? '' }}</textarea>
                        <span class="err-msg" id="err-meta_description"></span>
                    </div>
                    <div class="f-group fc">
                        <label class="f-label">Meta Keywords</label>
                        <textarea name="meta_keywords" class="f-textarea" rows="2"
                            placeholder="keyword one, keyword two, keyword three">{{ $data->meta_keywords ?? '' }}</textarea>
                        <span class="err-msg" id="err-meta_keywords"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">H1 Tag</label>
                        <input type="text" name="h1_tag" class="f-input" value="{{ $data->h1_tag ?? '' }}" placeholder="Main visible heading">
                        <span class="err-msg" id="err-h1_tag"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Index Status</label>
                        <select name="index_status" class="f-select" id="sel-index_status" onchange="serpUpdate()">
                            <option value="index"   {{ ($data->index_status ?? 'index') == 'index'   ? 'selected' : '' }}>Index — allow search engines</option>
                            <option value="noindex" {{ ($data->index_status ?? '') == 'noindex' ? 'selected' : '' }}>No Index — hide from search</option>
                        </select>
                        <span class="err-msg" id="err-index_status"></span>
                    </div>
                </div>

                {{-- SERP Preview --}}
                <div class="serp-preview">
                    <div class="serp-label"><i class="fas fa-eye" style="margin-right:5px"></i>Live SERP Preview</div>
                    <div class="serp-url" id="serp-url">{{ $data->canonical_url ?? config('app.url') }}/page</div>
                    <div class="serp-title" id="serp-title">{{ $data->meta_title ?? $data->page_title ?? 'Your page title will appear here' }}</div>
                    <div class="serp-desc" id="serp-desc">{{ $data->meta_description ?? 'Your meta description will appear here in Google search results. Keep it between 120–160 characters for best results.' }}</div>
                </div>
            </div>
        </div>

        {{-- ── Block 3: Open Graph ── --}}
        <div class="seo-block">
            <div class="seo-block-head">
                <div class="seo-block-icon ico-blue"><i class="fab fa-facebook-f"></i></div>
                <div>
                    <div class="seo-block-title">Open Graph</div>
                    <div class="seo-block-sub">Facebook, LinkedIn &amp; WhatsApp sharing previews</div>
                </div>
            </div>
            <div class="seo-block-body">
                <div class="fg">
                    <div class="f-group">
                        <label class="f-label">
                            OG Title
                            <span class="f-counter" id="cnt-og_title">{{ strlen($data->og_title ?? '') }}/60</span>
                        </label>
                        <input type="text" name="og_title" id="inp-og_title" class="f-input"
                            value="{{ $data->og_title ?? '' }}" placeholder="Open Graph title"
                            oninput="tick(this,'cnt-og_title',60)">
                        <span class="err-msg" id="err-og_title"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">OG Image <span class="f-label-hint">Recommended 1200×630 px</span></label>
                        <div class="f-file-wrap">
                            <div class="f-file-preview" id="ogImgWrap" style="{{ !empty($data->og_image) ? '' : 'display:none' }}">
                                <img id="ogImgPrev" src="{{ !empty($data->og_image) ? asset('storage/'.$data->og_image) : '' }}" alt="OG Image">
                                <span id="ogImgName" style="font-size:.75rem;color:var(--muted,#94a3b8)">{{ !empty($data->og_image) ? basename($data->og_image) : '' }}</span>
                            </div>
                            <label class="f-file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="ogImgTxt">{{ !empty($data->og_image) ? basename($data->og_image) : 'Upload OG image…' }}</span>
                                <input type="file" name="og_image" class="f-file-input" accept="image/*"
                                    onchange="prevFile(this,'ogImgPrev','ogImgTxt','ogImgWrap')">
                            </label>
                            <span class="err-msg" id="err-og_image"></span>
                        </div>
                    </div>
                    <div class="f-group fc">
                        <label class="f-label">
                            OG Description
                            <span class="f-counter" id="cnt-og_desc">{{ strlen($data->og_description ?? '') }}/200</span>
                        </label>
                        <textarea name="og_description" class="f-textarea" rows="2"
                            placeholder="Description shown when shared on social media"
                            oninput="tick(this,'cnt-og_desc',200)">{{ $data->og_description ?? '' }}</textarea>
                        <span class="err-msg" id="err-og_description"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Block 4: Twitter Card ── --}}
        <div class="seo-block">
            <div class="seo-block-head">
                <div class="seo-block-icon ico-teal"><i class="fab fa-twitter"></i></div>
                <div>
                    <div class="seo-block-title">Twitter Card</div>
                    <div class="seo-block-sub">How your content looks when shared on X / Twitter</div>
                </div>
            </div>
            <div class="seo-block-body">
                <div class="fg">
                    <div class="f-group">
                        <label class="f-label">
                            Twitter Title
                            <span class="f-counter" id="cnt-tw_title">{{ strlen($data->twitter_title ?? '') }}/60</span>
                        </label>
                        <input type="text" name="twitter_title" class="f-input"
                            value="{{ $data->twitter_title ?? '' }}" placeholder="Twitter card title"
                            oninput="tick(this,'cnt-tw_title',60)">
                        <span class="err-msg" id="err-twitter_title"></span>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Twitter Image <span class="f-label-hint">Recommended 1200×600 px</span></label>
                        <div class="f-file-wrap">
                            <div class="f-file-preview" id="twImgWrap" style="{{ !empty($data->twitter_image) ? '' : 'display:none' }}">
                                <img id="twImgPrev" src="{{ !empty($data->twitter_image) ? asset('storage/'.$data->twitter_image) : '' }}" alt="Twitter Image">
                            </div>
                            <label class="f-file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="twImgTxt">{{ !empty($data->twitter_image) ? basename($data->twitter_image) : 'Upload Twitter image…' }}</span>
                                <input type="file" name="twitter_image" class="f-file-input" accept="image/*"
                                    onchange="prevFile(this,'twImgPrev','twImgTxt','twImgWrap')">
                            </label>
                            <span class="err-msg" id="err-twitter_image"></span>
                        </div>
                    </div>
                    <div class="f-group fc">
                        <label class="f-label">
                            Twitter Description
                            <span class="f-counter" id="cnt-tw_desc">{{ strlen($data->twitter_description ?? '') }}/200</span>
                        </label>
                        <textarea name="twitter_description" class="f-textarea" rows="2"
                            placeholder="Description shown on Twitter cards"
                            oninput="tick(this,'cnt-tw_desc',200)">{{ $data->twitter_description ?? '' }}</textarea>
                        <span class="err-msg" id="err-twitter_description"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Block 5: Schema + Notes ── --}}
        <div class="seo-block">
            <div class="seo-block-head">
                <div class="seo-block-icon ico-purple"><i class="fas fa-code"></i></div>
                <div>
                    <div class="seo-block-title">Schema Markup &amp; Notes</div>
                    <div class="seo-block-sub">JSON-LD structured data &amp; internal SEO notes</div>
                </div>
            </div>
            <div class="seo-block-body">
                <div class="fg">
                    <div class="f-group fc">
                        <label class="f-label">Schema Markup <span class="f-label-hint">(JSON-LD — paste your structured data)</span></label>
                        <textarea name="schema_markup" class="f-textarea f-code" rows="7"
                            id="inp-schema"
                            placeholder=''
                            oninput="validateJson(this)">{{ $data->schema_markup ?? '' }}</textarea>
                        <span class="err-msg" id="err-schema_markup"></span>
                        <div id="json-ok" style="display:none;font-size:.7rem;color:#22c55e;margin-top:4px"><i class="fas fa-check-circle"></i> Valid JSON-LD</div>
                    </div>
                    <div class="f-group fc">
                        <label class="f-label">SEO Notes <span class="f-label-hint">(internal — not published)</span></label>
                        <textarea name="seo_notes" class="f-textarea" rows="3"
                            placeholder="Internal notes about this page's SEO strategy, outstanding tasks…">{{ $data->seo_notes ?? '' }}</textarea>
                        <span class="err-msg" id="err-seo_notes"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /seo-sections --}}
    </form>

</div>{{-- /seo-page --}}

<script>
/* ── Toast ── */
function toast(msg, type) {
    const t = document.getElementById('toast');
    const icons = {success:'fas fa-check-circle',error:'fas fa-times-circle',warning:'fas fa-exclamation-triangle'};
    const bgs   = {success:'#16a34a',error:'#dc2626',warning:'#f59e0b'};
    const colors= {success:'#fff',error:'#fff',warning:'#000'};
    t.style.cssText = `display:flex;align-items:center;gap:10px;padding:13px 18px;border-radius:12px;font-size:.83rem;font-weight:600;box-shadow:0 8px 32px rgba(0,0,0,.22);position:fixed;top:22px;right:22px;z-index:9999;min-width:260px;max-width:380px;animation:tIn .3s ease;background:${bgs[type]};color:${colors[type]}`;
    document.getElementById('toast-icon').className = icons[type] || icons.success;
    document.getElementById('toast-msg').textContent = msg;
    clearTimeout(t._t);
    t._t = setTimeout(() => {
        t.style.animation = 'tOut .3s ease forwards';
        setTimeout(() => t.style.display='none', 300);
    }, 3800);
}

/* ── Char counter ── */
function tick(el, id, max) {
    const n = el.value.length;
    const c = document.getElementById(id);
    c.textContent = n+'/'+max;
    c.classList.toggle('over', n > max);
    el.classList.toggle('is-invalid', n > max);
}

/* ── Live SERP preview ── */
function serpUpdate() {
    const title = document.getElementById('inp-meta_title')?.value
               || document.getElementById('inp-page_title')?.value
               || 'Your page title will appear here';
    const desc  = document.getElementById('inp-meta_desc')?.value
               || 'Your meta description will appear here in Google search results.';
    const noIndex = document.getElementById('sel-index_status')?.value === 'noindex';
    document.getElementById('serp-title').textContent = noIndex ? '[NOINDEX] '+title : title;
    document.getElementById('serp-desc').textContent  = desc || 'No description set.';
}

/* ── JSON-LD validator ── */
function validateJson(el) {
    const ok = document.getElementById('json-ok');
    if (!el.value.trim()) { el.classList.remove('is-invalid'); ok.style.display='none'; return; }
    try { JSON.parse(el.value); el.classList.remove('is-invalid'); ok.style.display=''; }
    catch(e) { el.classList.add('is-invalid'); ok.style.display='none'; }
}

/* ── File preview ── */
function prevFile(input, imgId, txtId, wrapId) {
    const file = input.files[0];
    if (!file) return;
    document.getElementById(txtId).textContent = file.name;
    const r = new FileReader();
    r.onload = e => {
        document.getElementById(imgId).src = e.target.result;
        document.getElementById(wrapId).style.display = '';
    };
    r.readAsDataURL(file);
}

/* ── Validation helpers ── */
function clearErrs() {
    document.querySelectorAll('#seoForm .err-msg').forEach(el => el.textContent = '');
    document.querySelectorAll('#seoForm .is-invalid').forEach(el => el.classList.remove('is-invalid'));
}
function showErrs(errors) {
    Object.entries(errors).forEach(([field, msgs]) => {
        const e = document.getElementById('err-'+field);
        if (e) e.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
        const inp = document.querySelector('#seoForm [name="'+field+'"]');
        if (inp) inp.classList.add('is-invalid');
    });
}

/* ── Button loading state ── */
function setLoading(on) {
    const btn = document.getElementById('saveSeoBtn');
    btn.disabled = on;
    document.getElementById('seo-btn-text').style.display = on ? 'none' : '';
    document.getElementById('seo-btn-spin').style.display = on ? 'inline-flex' : 'none';
}

/* ── Main AJAX save ── */
async function saveSeoInfo() {
    clearErrs();
    setLoading(true);
    const form = document.getElementById('seoForm');
    const fd   = new FormData(form);
    try {
        const res  = await fetch('{{ route("admin.settings.seo.update") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value },
            body: fd
        });
        const json = await res.json();
        if (res.ok && json.success) {
            toast(json.message || 'SEO settings saved.', 'success');
        } else if (res.status === 422 && json.errors) {
            showErrs(json.errors);
            toast('Please fix the highlighted errors.', 'error');
        } else {
            toast(json.message || 'Something went wrong.', 'error');
        }
    } catch(e) {
        toast('Network error – please try again.', 'error');
    } finally {
        setLoading(false);
    }
}

/* ── Init SERP on load ── */
serpUpdate();
</script>

@endsection