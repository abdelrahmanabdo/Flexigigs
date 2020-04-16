<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
            <span>
				<input name="free_text" placeholder="@lang('general.filter_search')" value="{{(@$_GET['free_text'])?@$_GET['free_text']:""}}" class="form-control" type="text">
			</span>
        </div>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
				@lang('general.filter_status.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="status">
				<div>
					<input type="radio" id="status-1" name="status"  value="" {{(!@$_GET['status'])?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-1">@lang('general.filter_status.title')</label>
				</div>
				<div>
					<input type="radio" id="status-2" name="status" value="0" {{(@$_GET['status']=="0")?"selected":""}}>
					<label class="text-dark h6 my-2" for="status-2">@lang('general.filter_status.opened')</label>
				</div>
				<div>
					<input type="radio" id="status-3" name="status" value="1" {{(@$_GET['status']==1)?"selected":""}}>
					<label class="text-dark h6 my-2" for="status-3">@lang('general.filter_status.closed')</label>
				</div>
				<div>
					<input type="radio" id="status-3" name="status" value="4" {{(@$_GET['status']==4)?"selected":""}}>
					<label class="text-dark h6 my-2" for="status-3">@lang('gigs.dashboard_admin_gigs_gig_info.status.canceld')</label>
				</div>
			</div>
		</div>
		<hr>
        <div class="form-group">
			<label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
				<input type="text" class="form-control datepicker border p-2 mx-2" placeholder="@lang('general.filter_date_range_from')" id="from" name="date_from" value="{{(@$_GET['date_from'])?@$_GET['date_from']:""}}">
				<input type="text" class="form-control datepicker border p-2 mx-2" placeholder="@lang('general.filter_date_range_to')" id="to" name="date_to" value="{{(@$_GET['date_to'])?@$_GET['date_to']:""}}">
            </div>
		</div>
		<hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>