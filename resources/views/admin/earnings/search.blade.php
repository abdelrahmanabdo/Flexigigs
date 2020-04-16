<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search_gh_username')</label>
            <span>
                <input name="supplier" placeholder="@lang('general.filter_search_gh_username')" class="form-control" type="text" value="{{(@$_GET['supplier'])?@$_GET['supplier']:''}}">
            </span>
        </div>
        <div class="form-group">
            <label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_from')" id="from" value="{{@$_GET['date_from']}}" name="date_from">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_to')" id="to" value="{{@$_GET['date_to']}}" name="date_to">
            </div>
		</div>
		<hr>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
				@lang('general.filter_status.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="status">
				<div>
					<input type="radio" id="status-1" name="status">
					<label class="text-dark h6 my-2" for="status-1" value="" {{(@$_GET['status'])?"":"checked"}}>@lang('general.filter_status.title')</label>
				</div>
				<div>
					<input type="radio" id="status-2" name="status" value="5"{{(@$_GET['status']==5)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-2">@lang('general.filter_status.due')</label>
				</div>
				<div>
					<input type="radio" id="status-3" name="status" value="6"{{(@$_GET['status']==6)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-3">@lang('general.filter_status.paid')</label>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type">
				@lang('general.filter_type.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="type">
				<div>
					<input type="radio" id="status-4" name="type"  value="" {{(@$_GET['type'])?"":"checked"}} >
					<label class="text-dark h6 my-2" for="status-4">all</label>
				</div>
				<div>
					<input type="radio" id="status-5" name="type" value="1" {{(@$_GET['type']==1)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-5">@lang('general.filter_type.requested_services')</label>
				</div>
				<div>
					<input type="radio" id="status-6" name="type" value="2" {{(@$_GET['type']==2)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-6">@lang('general.filter_type.posted_gigs')</label>
				</div>
				
			</div>
		</div>
		<hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>