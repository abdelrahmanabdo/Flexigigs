<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <div class="form-group">
			<label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_deadline_range_from')" id="from" name="date_from" value="{{(@$_GET['date_from'])?@$_GET['date_from']:""}}">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_deadline_range_to')" id="to" name="date_to" value="{{(@$_GET['date_to'])?@$_GET['date_to']:""}}">
            </div>
		</div>
		<hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>