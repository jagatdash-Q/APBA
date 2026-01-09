@if ($paginator->hasPages())
    <div class="d-flex justify-content-center my-4">
        <div class="pagination-container">
            {{-- <div class="pagination-hover-overlay"></div> --}}
            @if ($paginator->onFirstPage())
                <a href="javascript:void(0)" style="pointer-events: none; opacity: 0.5;" class="pagination-prev">
                    <span class="icon-pagination">
                        <img style="rotate: 180deg;" class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
                    </span>
                </a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-prev">
                    <span class="icon-pagination">
                        <img style="rotate: 180deg;" class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
                    </span>
                </a>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <a href="javascript:void(0)" class="pagination-page-number">{{ $element }}</a>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="javascript:void(0)" class="pagination-page-number active">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="pagination-page-number">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next">
                    <span class="icon-pagination">
                        <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
                    </span>
                </a>
            @else
                <a href="javascript:void(0)" style="pointer-events: none; opacity: 0.5;" class="pagination-next">
                    <span class="icon-pagination">
                        <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
                    </span>
                </a>
            @endif

        </div>
    </div>
@endif
