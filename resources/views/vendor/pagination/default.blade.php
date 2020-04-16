@if ($paginator->hasPages())
    <div class="col-12">
        <div class="paging">
            <?php 
                $currentPage = $paginator->currentPage();
                $from = (($paginator->currentPage()-1)*$paginator->perPage());
                $to = $from+$paginator->count();
                $from++;
                ?>
            <p>{{$from." - ".$to}} @lang('general.of') {{@$paginator->total()}}</p>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="disabled" rel="prev"><i class="fas fa-angle-left"></i></a>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-angle-left"></i></a>
            @endif
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-angle-right"></i></a>
            @else
                <a class="disabled"><i class="fas fa-angle-right"></i></a>
            @endif
        </div>
    </div>
@endif
