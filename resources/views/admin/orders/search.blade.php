<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search_username')</label>
            <span>
                <input name="customer" placeholder="@lang('general.filter_search_headhunter')" class="form-control" type="text" value="{{(@$_GET['customer'])?@$_GET['customer']:''}}">
            </span>
        </div>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search_username')</label>
            <span>
                <input name="supplier" placeholder="@lang('general.filter_search_gighunter')" class="form-control" type="text" value="{{(@$_GET['supplier'])?@$_GET['supplier']:''}}">
            </span>
		</div>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
				@lang('general.filter_status.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="status">
				<div>
					<input type="radio" id="status-1" name="radio-group" value="" checked>
					<label class="text-dark h6 my-2" for="status-1">all</label>
				</div>
				<div>
					<input type="radio" id="status-2" name="radio-group" value="1">
					<label class="text-dark h6 my-2" for="status-2">@lang('general.filter_status.running')</label>
				</div>
				<div>
					<input type="radio" id="status-3" name="radio-group" value="2">
					<label class="text-dark h6 my-2" for="status-3">@lang('general.filter_status.done')</label>
				</div>
				<div>
					<input type="radio" id="status-4" name="radio-group" value="3">
					<label class="text-dark h6 my-2" for="status-4">@lang('general.filter_status.completed')</label>
				</div>
				<div>
					<input type="radio" id="status-5" name="radio-group" value="4">
					<label class="text-dark h6 my-2" for="status-5">@lang('general.filter_status.canceld')</label>
				</div>
			</div>
		</div>
		<hr>
        <div class="form-group">
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
				<label class="text-hide" for="status">@lang('general.filter_status.title')</label>
				<select class="form-control" name="status">
					<option value="" {{(@$_GET['status'])?"":"selected"}}>@lang('general.filter_status.title')</option>
					<option value="1" {{(@$_GET['status']==1)?"selected":""}}>@lang('general.filter_status.running')</option>
					<option value="2" {{(@$_GET['status']==2)?"selected":""}}>@lang('general.filter_status.done')</option>
					<option value="3" {{(@$_GET['status']==3)?"selected":""}}>@lang('general.filter_status.completed')</option>
					<option value="5" {{(@$_GET['status']==5)?"selected":""}}>@lang('general.filter_status.canceld')</option>
				</select>
			</div>
			<div class="form-group">
				<label class="text-hide" for="type">@lang('general.filter_type.title')</label>
				<select class="form-control" name="type">
					<option value="" {{(@$_GET['type'])?"":"selected"}}>@lang('general.filter_type.title')</option>
					<option value="1" {{(@$_GET['type']==1)?"selected":""}}>@lang('general.filter_type.requested_services')</option>
					<option value="2" {{(@$_GET['type']==2)?"selected":""}}>@lang('general.filter_type.posted_gigs')</option>
				</select>
			</div>
		*/
		?>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type">
				@lang('general.filter_type.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="type">
				<div>
					<input type="radio" id="status-4" name="radio-group2" value="" checked>
					<label class="text-dark h6 my-2" for="status-4">all</label>
				</div>
				<div>
					<input type="radio" id="status-5" name="radio-group2" value="1">
					<label class="text-dark h6 my-2" for="status-5">@lang('general.filter_type.requested_services')</label>
				</div>
				<div>
					<input type="radio" id="status-6" name="radio-group2" value="2">
					<label class="text-dark h6 my-2" for="status-6">@lang('general.filter_type.posted_gigs')</label>
				</div>
				
			</div>
		</div>
		<hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>