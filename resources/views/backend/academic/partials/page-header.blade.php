<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1>{{ $title }}</h1>
        @isset($subtitle)<p class="mb-0">{{ $subtitle }}</p>@endisset
    </div>
    <div class="d-flex gap-2 flex-wrap">{!! $actions ?? '' !!}</div>
</div>
