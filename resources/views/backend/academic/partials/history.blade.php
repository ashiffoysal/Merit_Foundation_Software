@if($items->isEmpty())
    <p class="ac-muted mb-0">No history yet.</p>
@else
<ul class="ac-timeline">
    @foreach($items as $h)
        <li>
            <div class="t">{{ $h->description }}</div>
            @if(isset($h->old_value) || isset($h->new_value))
                <div class="ac-muted">{{ $h->old_value ?? '—' }} <i class="fas fa-arrow-right mx-1"></i> {{ $h->new_value ?? '—' }}</div>
            @endif
            @if(!empty($h->changes) && $h->event !== 'registered')
                <div class="ac-muted">
                    @foreach($h->changes as $field => $c)
                        @continue(!is_array($c))
                        <div>{{ ucfirst(str_replace('_', ' ', $field)) }}: {{ is_bool($c['from']) ? ($c['from'] ? 'Yes' : 'No') : ($c['from'] ?? '—') }} → {{ is_bool($c['to']) ? ($c['to'] ? 'Yes' : 'No') : ($c['to'] ?? '—') }}</div>
                    @endforeach
                </div>
            @endif
            <div class="m">
                {{ ($h->effective_date ?? $h->created_at)->format('d M Y') }} · {{ $h->created_at->format('H:i') }}
                @if($h->admin) · by {{ $h->admin->name }} @endif
            </div>
        </li>
    @endforeach
</ul>
@endif
