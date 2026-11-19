<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                @foreach($cfg['fields'] as $f => $label)<th>{{ $label }}</th>@endforeach
                <th>Used by</th><th>Order</th><th>Status</th><th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
            <tr data-row>
                <td><strong>{{ $item->name }}</strong></td>
                @foreach($cfg['fields'] as $f => $label)
                    <td>
                        @if($f === 'branch_id'){{ $item->branch->name ?? '—' }}
                        @elseif($f === 'color')<span class="badge bg-{{ $item->color }}">{{ $item->name }}</span>
                        @else{{ $item->$f ?? '—' }}@endif
                    </td>
                @endforeach
                <td class="ac-muted">
                    {{ collect($cfg['counts'])->map(fn ($r) => (int) $item->{\Illuminate\Support\Str::snake($r) . '_count'} . ' ' . strtolower(\Illuminate\Support\Str::headline($r)))->implode(' · ') }}
                </td>
                <td>{{ $item->sort_order }}</td>
                <td><x-academic.yesno :value="$item->is_active" yes="Active" no="Inactive" /></td>
                <td class="text-end text-nowrap">
                    <button type="button" class="btn-outline-sm" data-lookup-edit="{{ json_encode($item->only(array_merge(['id', 'name', 'sort_order', 'is_active'], array_keys($cfg['fields'])))) }}"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn-danger-sm" data-delete="{{ route('admin.lookups.destroy', [$type, $item->id]) }}" data-reload="#lookup-table" data-title="Delete “{{ $item->name }}”?" data-text="Values that are in use cannot be deleted — mark them inactive instead."><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ 5 + count($cfg['fields']) }}" class="text-center ac-muted py-5">Nothing here yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@if($items->hasPages())<div class="p-3">{{ $items->links('pagination::bootstrap-5') }}</div>@endif
