@if ($paginator->hasPages())
    <ul class="pagenation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">@lang('general.pagenation_previous')</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('general.pagenation_previous')</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('general.pagenation_next')</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">@lang('general.pagenation_next')</span></li>
        @endif
    </ul>
@endif
