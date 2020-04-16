<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_reviews_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <label class="form-group has-float-label mt-5">
            <select class="form-control" required name="type">
                <option value="" {{(@$_GET['type'])?"":"selected"}}> @lang('general.filter_type.review_type')</option>
                <option value="1" {{(@$_GET['type']==1)?"selected":""}}> (@lang('general.hh')) @lang('general.filter_type.reviewd') (@lang('general.gh'))</option>
                <option value="2" {{(@$_GET['type']==2)?"selected":""}}> (@lang('general.gh')) @lang('general.filter_type.reviewd') (@lang('general.hh'))</option>
            </select>
        </label>
        <label class="form-group has-float-label mt-5 mb-0">
            <input type="text" name="user_from" value="{{@$_GET['user_from']}}" placeholder="@lang('general.filter_deadline_range_from')" class="form-control border-0">
			<span for="searchFilter">@lang('general.filter_deadline_range_from')</span>
			<i class="fas fa-search filter-search-input-icon"></i>			
		</label>
		<hr>
        <label class="form-group has-float-label mt-5 mb-0">
            <input type="text" name="user_to" value="{{@$_GET['user_to']}}" placeholder="@lang('general.filter_deadline_range_to')" class="form-control border-0">
			<span for="searchFilter">@lang('general.filter_deadline_range_to')</span>
			<i class="fas fa-search filter-search-input-icon"></i>
		</label>
		<hr>
        <div class="form-group">
            <label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
                <input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_from')" id="from" value="{{@$_GET['date_from']}}" name="date_from">
                <input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_to')" id="to" value="{{@$_GET['date_to']}}" name="date_to">
            </div>
		</div>
		<hr>
        <label class="form-group has-float-label mt-5 mb-0">
            <input type="number" min="0" name="order_id" value="{{@$_GET['order_id']}}" placeholder="@lang('general.filter_order_id')" class="form-control border-0">
			<span for="searchFilter">@lang('general.filter_order_id')</span>
			<i class="fas fa-search filter-search-input-icon"></i>			
		</label>
		<hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>