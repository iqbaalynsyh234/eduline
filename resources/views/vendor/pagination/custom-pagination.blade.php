@if ($paginator->hasPages())
    <nav>
        <ul class="pagination pagination-gutter">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item page-indicator disabled" aria-disabled="true">
                    <span class="page-link"><i class="la la-angle-left"></i></span>
                </li>
            @else
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="la la-angle-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="la la-angle-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item page-indicator disabled" aria-disabled="true">
                    <span class="page-link"><i class="la la-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
