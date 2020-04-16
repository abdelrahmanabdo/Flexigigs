<div class="col-12">
    <div class="paging d-flex flex-row justify-content-between align-items-center">
        <button type="button" class="btn btn-outline-primary text-uppercase"  data-toggle="modal" data-target=".export-modal">@lang('general.button_export')</button>
        @if ($paginator->hasPages())
            <?php 
                $currentPage = $paginator->currentPage();
                $from = (($paginator->currentPage()-1)*$paginator->perPage());
                $to = $from+$paginator->count();
                $from++;
                ?>
            <div class="d-flex flex-row align-items-center">
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
        @endif
    </div>
</div>
