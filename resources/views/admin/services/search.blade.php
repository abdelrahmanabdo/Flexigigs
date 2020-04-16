<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_service_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <label class="form-group has-float-label mt-5 mb-0">
            <input type="text" name="supplier_name" value="{{@$_GET['supplier_name']}}" placeholder="@lang('general.filter_search_gighunter')" class="form-control border-0">
			<span for="searchFilter">@lang('general.filter_search_gighunter')</span>
			<i class="fas fa-search filter-search-input-icon"></i>
		</label>
		<hr>
        <label class="form-group has-float-label mt-5 mb-0">
            <input type="text" name="service_name" value="{{@$_GET['service_name']}}" placeholder="@lang('general.filter_search_service')" class="form-control border-0">
            <span for="searchFilter">@lang('general.filter_search_service')</span>
			<i class="fas fa-search filter-search-input-icon"></i>
		</label>
		<hr>
        <div class="form-group mb-4">
            <label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
                <input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_from')" id="from" value="{{@$_GET['date_from']}}" name="date_from">
                <input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_to')" id="to" value="{{@$_GET['date_to']}}" name="date_to">
            </div>
		</div>
		<hr>
		<?php
			/*
			<div class="form-group">
				<label for="priceRange">@lang('general.filter_price_range')</label>
				<div class="range-wrap">
					@if(app()->getLocale()=="en")
					<input id="priceMin" type="text" name="price_from" >
					@else
					<input id="priceMax" type="text" name="price_to">
					@endif
					<div class="slider-range" data-from="<?=(@$min_price)?@$min_price:0;?>" data-to="<?=(@$max_price)?@$max_price:0;?>" data-value-from="<?=(@$_GET['price_from'])?@$_GET['price_from']:@$min_price;?>" data-value-to="<?=(@$_GET['price_to'])?@$_GET['price_to']:@$max_price;?>"></div>
					@if(app()->getLocale()=="en")
					<input id="priceMax" type="text" name="price_to">
					@else
					<input id="priceMin" type="text" name="price_from" >
					@endif
				</div>
			</div>
			*/
		?>

		<div class="form-group priceRange mb-4">
			<label for="priceRange">@lang('general.filter_price_range')</label>
			<div class="d-flex align-items-center justify-content-between">
				<div class="d-flex align-items-center justify-content-start">
					<input class="border p-2 mx-2" type="text" name="price-from" id="price-from" placeholder="from">
					<p class="m-0 font-weight-bold">EGP</p>
				</div>
				<div class="d-flex align-items-center justify-content-start">
					<input class="border p-2 mx-2" type="text" name="price-to" id="price-to" placeholder="to">
					<p class="m-0 font-weight-bold">EGP</p>
				</div>
			</div>
		</div>
		<hr>
                        
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>