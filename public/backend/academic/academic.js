/* Teacher / Parent / Student / Lesson module – shared AJAX behaviour.
 * Needs: Bootstrap 5 bundle, SweetAlert2, Tom Select (loaded by backend/academic/layout.blade.php) */
(function () {
    'use strict';

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3200, timerProgressBar: true });

    // ── progress bar / loading indicator ───────────────────────────────
    const bar = document.createElement('div');
    bar.id = 'ac-progress';
    document.body.appendChild(bar);
    let pending = 0;
    const busy = on => {
        pending += on ? 1 : -1;
        if (pending > 0) { bar.className = 'on'; } else { pending = 0; bar.className = 'done'; setTimeout(() => (bar.className = ''), 350); }
    };

    async function request(url, { method = 'GET', body = null, json = true } = {}) {
        busy(true);
        try {
            const res = await fetch(url, {
                method,
                body,
                credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest', 'Accept': json ? 'application/json' : 'text/html' },
            });
            let data = null;
            const type = res.headers.get('content-type') || '';
            data = type.includes('json') ? await res.json() : await res.text();
            return { ok: res.ok, status: res.status, data };
        } catch (e) {
            return { ok: false, status: 0, data: { message: 'Network error – please check your connection.' } };
        } finally {
            busy(false);
        }
    }

    const errorMessage = r => (r.data && r.data.message) || (r.status === 403 ? 'You are not allowed to do this.' : r.status === 419 ? 'Session expired – please reload the page.' : 'Something went wrong.');

    const Academic = window.Academic = {
        request,
        toast: (title, icon = 'success') => Toast.fire({ icon, title }),
        flashNext: msg => sessionStorage.setItem('ac-flash', msg),
        go(url, msg) { if (msg) Academic.flashNext(msg); window.location.href = url; },
    };

    // flash messages carried over a redirect
    const carried = sessionStorage.getItem('ac-flash');
    if (carried) { sessionStorage.removeItem('ac-flash'); Academic.toast(carried); }

    // ── validation errors ──────────────────────────────────────────────
    function clearErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('[data-error-for]').forEach(el => { el.textContent = ''; el.classList.remove('d-block'); });
        document.querySelectorAll('.ac-tabs .has-error').forEach(el => el.classList.remove('has-error'));
    }

    function showErrors(form, errors) {
        let firstPane = null;
        Object.entries(errors).forEach(([key, msgs]) => {
            const base = key.split('.')[0];
            const box = form.querySelector(`[data-error-for="${base}"]`);
            const input = form.querySelector(`[name="${base}"], [name="${base}[]"]`);
            if (input) {
                input.classList.add('is-invalid');
                input.tomselect?.wrapper.classList.add('is-invalid');
            }
            if (box && !box.textContent) { box.textContent = msgs[0]; box.classList.add('d-block'); }
            const pane = (box || input)?.closest('.tab-pane');
            if (pane) {
                document.querySelector(`[data-bs-target="#${pane.id}"]`)?.classList.add('has-error');
                firstPane = firstPane || pane;
            }
        });
        if (firstPane && !firstPane.classList.contains('active')) {
            const btn = document.querySelector(`[data-bs-target="#${firstPane.id}"]`);
            if (btn) bootstrap.Tab.getOrCreateInstance(btn).show();
        }
        setTimeout(() => form.querySelector('.is-invalid, .ts-wrapper.is-invalid')?.scrollIntoView({ behavior: 'smooth', block: 'center' }), 150);
    }

    // ── AJAX forms ─────────────────────────────────────────────────────
    document.addEventListener('submit', async e => {
        const form = e.target.closest('form[data-ajax-form]');
        if (!form) return;
        e.preventDefault();

        if (form.dataset.confirm) {
            const ok = await Swal.fire({ title: form.dataset.confirm, icon: 'question', showCancelButton: true, confirmButtonColor: '#C9A84C' });
            if (!ok.isConfirmed) return;
        }

        clearErrors(form);
        const btns = form.querySelectorAll('[type="submit"]');
        btns.forEach(b => { b.disabled = true; b.dataset.html = b.innerHTML; b.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving…'; });

        const r = await request(form.action, { method: 'POST', body: new FormData(form) });

        btns.forEach(b => { b.disabled = false; b.innerHTML = b.dataset.html; });

        if (r.status === 422 && r.data.errors) {
            showErrors(form, r.data.errors);
            Academic.toast('Please correct the highlighted fields.', 'error');
            return;
        }
        if (!r.ok) {
            Swal.fire({ icon: 'error', title: 'Could not save', text: errorMessage(r) });
            return;
        }

        // custom handler (e.g. quick-add parent from the student form)
        if (form.dataset.successEvent) {
            document.dispatchEvent(new CustomEvent(form.dataset.successEvent, { detail: r.data }));
            bootstrap.Modal.getInstance(form.closest('.modal'))?.hide();
            form.reset();
            Academic.toast(r.data.message);
            return;
        }

        if (form.dataset.reloadTable) {
            bootstrap.Modal.getInstance(form.closest('.modal'))?.hide();
            Academic.toast(r.data.message);
            loadTable(document.querySelector(form.dataset.reloadTable));
            return;
        }

        if (r.data.generated_password) {
            await Swal.fire({
                icon: 'success',
                title: r.data.message,
                html: `A password was generated for this teacher. <b>Copy it now</b> – it will not be shown again.<br><br>
                       <code style="font-size:1.15rem;user-select:all">${r.data.generated_password}</code>`,
                confirmButtonText: 'Copy & continue',
                confirmButtonColor: '#C9A84C',
                preConfirm: () => navigator.clipboard?.writeText(r.data.generated_password).catch(() => {}),
            });
            return Academic.go(r.data.redirect || location.href);
        }

        if (r.data.redirect) return Academic.go(r.data.redirect, r.data.message);
        Academic.toast(r.data.message);
    });

    // ── Delete with SweetAlert2 ────────────────────────────────────────
    document.addEventListener('click', async e => {
        const btn = e.target.closest('[data-delete]');
        if (!btn) return;
        e.preventDefault();

        const ok = await Swal.fire({
            title: btn.dataset.title || 'Delete this record?',
            text: btn.dataset.text || 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            confirmButtonColor: '#E53935',
            focusCancel: true,
        });
        if (!ok.isConfirmed) return;

        const body = new FormData();
        body.append('_method', 'DELETE');
        const r = await request(btn.dataset.delete, { method: 'POST', body });
        if (!r.ok) return Swal.fire({ icon: 'error', title: 'Not deleted', text: errorMessage(r) });

        if (btn.dataset.reload) { Academic.toast(r.data.message); return loadTable(document.querySelector(btn.dataset.reload)); }
        if (btn.dataset.redirect) return Academic.go(btn.dataset.redirect, r.data.message);
        btn.closest('[data-row]')?.remove();
        Academic.toast(r.data.message);
    });

    // ── AJAX listing: filters + pagination ─────────────────────────────
    async function loadTable(box, url) {
        if (!box) return;
        url = url || box.dataset.current || box.dataset.url;
        box.classList.add('is-loading');
        const r = await request(url, { json: false });
        box.classList.remove('is-loading');
        if (!r.ok) return Academic.toast(errorMessage(r), 'error');
        box.innerHTML = r.data;
        box.dataset.current = url;
        const u = new URL(url, location.origin);
        history.replaceState(null, '', location.pathname + u.search);
    }
    Academic.loadTable = loadTable;

    const debounce = (fn, ms = 400) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; };

    document.querySelectorAll('form[data-filter-for]').forEach(form => {
        const box = document.querySelector(form.dataset.filterFor);
        const run = () => {
            const params = new URLSearchParams(new FormData(form));
            [...params.keys()].forEach(k => { if (!params.get(k)) params.delete(k); });
            loadTable(box, box.dataset.url + (params.toString() ? '?' + params : ''));
        };
        form.addEventListener('submit', e => { e.preventDefault(); run(); });
        form.addEventListener('change', run);
        form.querySelectorAll('input[type="search"], input[type="text"]').forEach(i => i.addEventListener('input', debounce(run)));
        form.querySelector('[data-reset]')?.addEventListener('click', e => { e.preventDefault(); form.reset(); form.querySelectorAll('select').forEach(s => s.tomselect?.clear(true)); run(); });
    });

    document.addEventListener('click', e => {
        const a = e.target.closest('[data-ajax-table] .pagination a');
        if (!a) return;
        e.preventDefault();
        loadTable(a.closest('[data-ajax-table]'), a.href);
    });

    // ── Tom Select (searchable dropdowns) ──────────────────────────────
    const renderOpt = (item, escape) => `<div>${escape(item.text)}${item.sub ? `<span class="ac-opt-sub">${escape(item.sub)}</span>` : ''}</div>`;

    Academic.initSelects = (root = document) => {
        root.querySelectorAll('select[data-ts]:not(.tomselected)').forEach(el => {
            new TomSelect(el, {
                plugins: el.multiple ? ['remove_button'] : [],
                allowEmptyOption: true,
                maxOptions: 500,
                hidePlaceholder: el.multiple,
            });
        });
        root.querySelectorAll('select[data-ts-remote]:not(.tomselected)').forEach(el => {
            new TomSelect(el, {
                valueField: 'id', labelField: 'text', searchField: ['text', 'sub'],
                plugins: el.multiple ? ['remove_button'] : [],
                preload: 'focus',
                loadThrottle: 300,
                load(query, cb) {
                    const u = new URL(el.dataset.tsRemote, location.origin);
                    u.searchParams.set('q', query);
                    Object.entries(el.dataset).filter(([k]) => k.startsWith('param')).forEach(([k, v]) => u.searchParams.set(k.slice(5).replace(/^./, c => c.toLowerCase()).replace(/[A-Z]/g, c => '_' + c.toLowerCase()), v));
                    request(u.toString()).then(r => cb(r.ok ? r.data : [])).catch(() => cb());
                },
                render: { option: renderOpt, item: (i, esc) => `<div>${esc(i.text)}</div>`, no_results: () => '<div class="no-results p-2 ac-muted">No matches</div>' },
            });
        });
    };
    Academic.initSelects();

    // ── small helpers ──────────────────────────────────────────────────
    // reveal / generate password
    document.addEventListener('click', e => {
        const t = e.target.closest('[data-toggle-password]');
        if (t) { const i = document.querySelector(t.dataset.togglePassword); i.type = i.type === 'password' ? 'text' : 'password'; }
        const g = e.target.closest('[data-generate-password]');
        if (g) {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
            const arr = new Uint32Array(12); crypto.getRandomValues(arr);
            let p = Array.from(arr, n => chars[n % chars.length]).join('');
            p = p.slice(0, 10) + 'a7';
            document.querySelectorAll(g.dataset.generatePassword).forEach(i => { i.value = p; i.type = 'text'; });
        }
    });

    // image preview for photo inputs
    document.addEventListener('change', e => {
        const i = e.target.closest('input[type="file"][data-preview]');
        if (!i || !i.files[0]) return;
        const img = document.querySelector(i.dataset.preview);
        if (img) { img.src = URL.createObjectURL(i.files[0]); img.classList.remove('d-none'); }
    });

    // open the tab named in the URL hash (#documents)
    if (location.hash) {
        const btn = document.querySelector(`[data-bs-target="${location.hash}"]`);
        if (btn) bootstrap.Tab.getOrCreateInstance(btn).show();
    }
})();
