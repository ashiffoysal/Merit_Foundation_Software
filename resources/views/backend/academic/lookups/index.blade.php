@extends('backend.academic.layout')
@section('page')
@include('backend.academic.partials.page-header', ['title' => 'Settings', 'subtitle' => 'Dropdown values used by teachers, students and lessons'])

<div class="row g-4">
    <div class="col-lg-3">
        <div class="card p-2">
            <div class="list-group list-group-flush">
                @foreach($types as $key => $t)
                    <a href="{{ route('admin.lookups.index', $key) }}" class="list-group-item list-group-item-action border-0 rounded {{ $key === $type ? 'active' : '' }}" style="font-size:.85rem{{ $key === $type ? ';background:var(--s100);border-color:var(--s100)' : '' }}">
                        <i class="fas {{ $t['icon'] }} me-2"></i>{{ $t['title'] }}
                    </a>
                @endforeach
                <a href="{{ route('admin.report-settings.edit') }}" class="list-group-item list-group-item-action border-0 rounded" style="font-size:.85rem"><i class="fas fa-user-lock me-2"></i>Report Settings</a>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header-custom flex-wrap gap-2">
                <div class="card-title"><i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['title'] }}</div>
                <div class="d-flex gap-2">
                    <form data-filter-for="#lookup-table"><input type="search" name="search" class="f-input" placeholder="Search…" style="padding:8px 12px"></form>
                    <button type="button" class="btn-gold-sm" data-lookup-new><i class="fas fa-plus"></i> Add {{ $cfg['singular'] }}</button>
                </div>
            </div>
            <div id="lookup-table" data-ajax-table data-url="{{ route('admin.lookups.index', $type) }}">
                @include('backend.academic.lookups._table')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lookupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="POST" action="{{ route('admin.lookups.store', $type) }}" data-ajax-form data-reload-table="#lookup-table" novalidate id="lookup-form">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-header"><h5 class="modal-title">{{ $cfg['singular'] }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <x-academic.input name="name" label="Name" required col="col-12" />
                    @foreach($cfg['fields'] as $field => $label)
                        @if($field === 'branch_id')
                            <x-academic.select name="branch_id" label="Branch" :options="$branches->pluck('name', 'id')" :search="false" />
                        @elseif($field === 'color')
                            <x-academic.select name="color" label="Badge colour" :options="array_combine(\App\Models\StudentStatus::COLORS, array_map('ucfirst', \App\Models\StudentStatus::COLORS))" :search="false" placeholder="— colour —" />
                        @elseif($field === 'capacity')
                            <x-academic.input name="capacity" label="Capacity" type="number" min="1" />
                        @else
                            <x-academic.input :name="$field" :label="$label" />
                        @endif
                    @endforeach
                    <x-academic.input name="sort_order" label="Sort order" type="number" min="0" value="0" />
                    <x-academic.switch name="is_active" label="Active" :checked="true" col="col-md-6 align-self-end" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-gold-sm"><i class="fas fa-save"></i> Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('academic-scripts')
<script>
(function () {
    const modalEl = document.getElementById('lookupModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    const form = document.getElementById('lookup-form');
    const storeUrl = @json(route('admin.lookups.store', $type));

    function open(item) {
        form.reset();
        form.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));
        form.querySelectorAll('[data-error-for]').forEach(e => { e.textContent = ''; e.classList.remove('d-block'); });
        form.action = item ? `${storeUrl}/${item.id}` : storeUrl;
        form.querySelector('[name="_method"]').value = item ? 'PUT' : 'POST';
        modalEl.querySelector('.modal-title').textContent = (item ? 'Edit ' : 'Add ') + @json($cfg['singular']);
        form.querySelector('[name="sort_order"]').value = 0;
        form.querySelector('[type="checkbox"][name="is_active"]').checked = item ? !!item.is_active : true;
        if (item) Object.entries(item).forEach(([k, v]) => {
            const el = form.querySelector(`[name="${k}"]:not([type="hidden"]):not([type="checkbox"])`);
            if (el) el.value = v ?? '';
        });
        modal.show();
        setTimeout(() => form.querySelector('[name="name"]').focus(), 300);
    }
    document.querySelector('[data-lookup-new]').addEventListener('click', () => open(null));
    document.addEventListener('click', e => {
        const b = e.target.closest('[data-lookup-edit]');
        if (b) open(JSON.parse(b.dataset.lookupEdit));
    });
})();
</script>
@endpush
