<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <hr>
        <!-- <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search_order_id')</label>
            <span>
                <input name="order_id" placeholder="@lang('general.filter_search_order_id')" class="form-control" type="number" value="{{(@$_GET['order_id'])?@$_GET['order_id']:''}}">
            </span>
        </div> -->
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type">
				@lang('general.filter_type.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="type">
				<div>
					<input type="radio" id="type-1" name="type" value="" {{(@$_GET['type'])?"":"checked"}}  onchange="if($(this).is(':checked'))($(searchbyname).addClass('d-none'))">
					<label class="text-dark h6 my-2" for="type-1">@lang('general.filter_type.title')</label>
				</div>
				<div>
					<input type="radio" id="type-2" name="type" value="1" {{(@$_GET['type']==1)?"checked":""}} onchange="if($(this).is(':checked'))($(searchbyname).removeClass('d-none'))">
					<label class="text-dark h6 my-2" for="type-2">@lang('general.filter_type.service')</label>
				</div>
				<div>
					<input type="radio" id="type-3" name="type" value="2" {{(@$_GET['type']==2)?"checked":""}} onchange="if($(this).is(':checked'))($(searchbyname).removeClass('d-none'))">
					<label class="text-dark h6 my-2" for="type-3">@lang('general.filter_status.gig')</label>
				</div>
			</div>
		</div>
		<label class="form-group has-float-label mt-5 mb-0 d-none" id="searchbyname">
            <input type="text" name="search" value="" placeholder="@lang('general.filter_search')" class="form-control border-0">
			<span for="searchFilter">@lang('general.filter_search')</span>
			<i class="fas fa-search filter-search-input-icon"></i>			
		</label>
		<hr>
		<div class="form-group">
			<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
				@lang('general.filter_status.title')
				<i class="fas fa-angle-down"></i>
			</button>
			<div class="collapse show" id="status">
				<div>
					<input type="radio" id="status-1" name="status" value="" {{(@$_GET['status'])?"":"checked"}} >
					<label class="text-dark h6 my-2" for="status-1">@lang('general.filter_status.title')</label>
				</div>
				<div>
					<input type="radio" id="status-4" name="status" value="0" {{(@$_GET['status']=="0")?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-4">waiting approval</label>
				</div>
				<div>
					<input type="radio" id="status-5" name="status" value="1" {{(@$_GET['status']==1)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-5">pending payment</label>
				</div>
				<div>
					<input type="radio" id="status-2" name="status" value="2" {{(@$_GET['status']==2)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-2">@lang('general.filter_status.running')</label>
				</div>
				<div>
					<input type="radio" id="status-3" name="status" value="3" {{(@$_GET['status']==3)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-3">@lang('general.filter_status.done')</label>
				</div>
				<div>
					<input type="radio" id="status-6" name="status" value="4" {{(@$_GET['status']==4)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-6">@lang('general.filter_status.completed')</label>
				</div>

				<div>
					<input type="radio" id="status-7" name="status" value="7" 
					{{(@$_GET['status']==7)?"checked":""}}>
					<label class="text-dark h6 my-2" for="status-7">Cancelled</label>
				</div>

			</div>
		</div>
		<hr>
        <div class="form-group">
			<label for="location">@lang('general.filter_date_range')</label>
            <div class="d-flex justify-content-between">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_from')" id="from" name="date_from" value="{{(@$_GET['date_from'])?@$_GET['date_from']:''}}">
				<input type="text" class="form-control border p-2 mx-2" placeholder="@lang('general.filter_date_range_to')" id="to" name="date_to" value="{{(@$_GET['date_to'])?@$_GET['date_to']:''}}">
            </div>
		</div>
		<hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>