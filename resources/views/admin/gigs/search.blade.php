<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>    <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
            <span>
            <input name="free_text" placeholder="@lang('general.filter_search')" value="{{(@$_GET['free_text'])?@$_GET['free_text']:""}}" class="form-control" type="text">
        </span>
        </div>
        <div class="form-group">
            <label class="text-hide" for="gig">@lang('general.filter_status.title')</label>
            <select class="form-control" name="status">
                <option value="" {{(@$_GET['status'])?"":"selected"}}>@lang('general.filter_status.title')</option>
                <option value="0" {{(@$_GET['status']=="0")?"selected":""}}>@lang('general.filter_status.opened')</option>
                <option value="1" {{(@$_GET['status']==1)?"selected":""}}>@lang('general.filter_status.closed')</option>
                <option value="5" {{(@$_GET['status']==5)?"selected":""}}>@lang('gigs.dashboard_admin_gigs_gig_info.status.canceld')</option>
            </select>
        </div>

		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
				status
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="status">
				<div>
					<input type="radio" id="test1" name="radio-group1" checked>
					<label class="text-dark h6 my-2" for="test1">Any</label>
				</div>
				<div>
					<input type="radio" id="test2" name="radio-group1">
					<label class="text-dark h6 my-2" for="test2">new</label>
				</div>
				<div>
					<input type="radio" id="test3" name="radio-group1">
					<label class="text-dark h6 my-2" for="test3">done</label>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group priceRange">
			<label for="priceRange">@lang('general.filter_price_range')</label>
			<div class="d-flex align-items-center justify-content-between">
				<div class="d-flex align-items-center justify-content-start">
					<input class="border px-1 py-2" type="text" name="price-from" id="price-from" placeholder="from">
					<p class="m-0 font-weight-bold">EGP</p>
				</div>
				<div class="d-flex align-items-center justify-content-start">
					<input class="border px-1 py-2" type="text" name="price-to" id="price-to" placeholder="to">
					<p class="m-0 font-weight-bold">EGP</p>
				</div>
			</div>
		</div>
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
					<label for="location">@lang('general.filter_date_range')</label>
					<div class="d-flex justify-content-between">
							<input type="text" class="form-control mr-2" placeholder="@lang('general.filter_date_range_to')" id="to" name="date_to" value="{{(@$_GET['date_to'])?@$_GET['date_to']:""}}">
							<input type="text" class="form-control" placeholder="@lang('general.filter_date_range_from')" id="from" name="date_from" value="{{(@$_GET['date_from'])?@$_GET['date_from']:""}}">
					</div>
				</div>
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
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>