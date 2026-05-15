@if ($paginator->hasPages())
<div class="d-flex align-items-center justify-content-between mt-5" data-r="up">

    {{-- Showing text --}}
    <span style="font-size:.78rem;color:var(--muted)">
        Showing {{ $paginator->count() }} of {{ $paginator->total() }} articles
    </span>

    <div class="d-flex gap-2">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <div class="pag-btn disabled">
                <i class="fas fa-chevron-left"></i>
            </div>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pag-btn">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif


        {{-- Pagination Numbers --}}
        @foreach ($elements as $element)

            {{-- Dots --}}
            @if (is_string($element))
                <div class="pag-btn" style="width:auto;padding:0 14px">
                    {{ $element }}
                </div>
            @endif

            {{-- Page Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="pag-btn active">
                            {{ $page }}
                        </div>
                    @else
                        <a href="{{ $url }}" class="pag-btn">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif

        @endforeach


        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pag-btn">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <div class="pag-btn disabled">
                <i class="fas fa-chevron-right"></i>
            </div>
        @endif

    </div>
</div>
@endif