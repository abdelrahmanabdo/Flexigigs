<div class="filter" style="position:relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="text-primary resetForm">@lang('general.filter_reset')</button>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">search filter</label>
            <span>
				<input name="free_text" placeholder="Search" value="" class="form-control" type="text">
			</span>
		</div>
		
        <div class="form-group">
            <label class="text-hide" for="gig">@lang('general.filter_type.title')</label>
            <select class="form-control" name="type">
                <option value="" {{(@$_GET['type'])?"":"selected"}}>@lang('general.filter_type.title')</option>
                <option value="1" {{(@$_GET['type']==1)?"selected":""}}>@lang('general.filter_type.requested_services')</option>
                <option value="2" {{(@$_GET['type']==2)?"selected":""}}>@lang('general.filter_type.applied_gigs')</option>
            </select>
		</div>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
				@lang('general.filter_status.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="status">
				<div>
					<input type="radio" id="status-1" name="status" value="" {{(@$_GET['status'])?"":"checked"}}>
					<label class="text-dark h6 my-2" for="status-1" >all</label>
				</div>
				<div>
					<input type="radio" id="status-2" name="status" value="0" {{(@$_GET['status']=="0")?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-2">@lang('order.pending_abroval')</label>
				</div>
				<div>
					<input type="radio" id="status-6" name="status" value="1" {{(@$_GET['status']==1)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-6">@lang('order.pending_payment')</label>
				</div>
				<div>
					<input type="radio" id="status-7" name="status" value="2" {{(@$_GET['status']==2)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-7">@lang('general.filter_status.running')</label>
				</div>
				<div>
					<input type="radio" id="status-3" name="status" value="3" {{(@$_GET['status']==3)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-3">@lang('general.filter_status.done')</label>
				</div>
				<div>
					<input type="radio" id="status-4" name="status" value="4" {{(@$_GET['status']==4)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-4">@lang('general.filter_status.completed')</label>
				</div>
<!-- 				<div>
					<input type="radio" id="status-5" name="status" value="5" {{(@$_GET['status']==5)?"selected":""}}">
					<label class="text-dark h6 my-2" for="status-5">@lang('general.filter_status.canceld')</label>
				</div> -->
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_from')" id="from" name="date_from" value="{{(@$_GET['date_from'])?@$_GET['date_from']:""}}">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_to')" id="to" name="date_to" value="{{(@$_GET['date_to'])?@$_GET['date_to']:""}}">
            </div>
        </div>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>