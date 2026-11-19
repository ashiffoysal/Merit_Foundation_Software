<div class="ac-tt">
    @foreach(\App\Models\Lesson::WEEKDAYS as $day => $label)
        @php $items = $lessonsByDay->get($day, collect()); @endphp
        <div class="ac-tt-day">
            <h6>{{ $label }} <span>{{ $items->count() }}</span></h6>
            @foreach($items as $l)
                @php $hue = crc32((string) ($l->subject_id ?? $l->id)) % 360; @endphp
                <a href="{{ route('admin.lessons.show', $l) }}" class="ac-tt-item" style="--c:hsl({{ $hue }},55%,50%)">
                    <div class="tm">{{ $l->time_range }}</div>
                    <div class="nm">{{ $l->name }}</div>
                    <div class="mt"><i class="fas fa-user"></i> {{ $l->teacher->full_name ?? 'No teacher' }}</div>
                    <div class="mt"><i class="fas fa-door-open"></i> {{ $l->classroom->name ?? '—' }} {{ $l->branch ? '· ' . $l->branch->name : '' }}</div>
                    <div class="mt"><i class="fas fa-users"></i> {{ $l->students_count }}/{{ $l->capacity }} {{ $l->is_one_to_one ? '· 1-to-1' : '' }}</div>
                </a>
            @endforeach
            <a href="{{ route('admin.lessons.create', ['weekday' => $day]) }}" class="ac-tt-add"><i class="fas fa-plus"></i> Add</a>
        </div>
    @endforeach
</div>
