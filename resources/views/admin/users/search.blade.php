<!-- Users Filter -->
<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_user_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <label class="form-group has-float-label mt-5">
            <input type="text" name="free_text" value="{{(@$_GET['free_text'])?@$_GET['free_text']:''}}" placeholder="@lang('general.filter_search_username')" class="form-control">
            <span for="searchFilter">@lang('general.filter_search_username')</span>
        </label>  
        <label class="form-group has-float-label mt-5">
            <select type="text" name="status" class="form-control">
            	<option value="" {{(@$_GET['status']!=0&&!@$_GET['status'])?"selected":''}}>@lang('general.filter_status.all')</option>
            	<option value="0" {{(@$_GET['status']==0&&@$_GET['status']!="")?"selected":''}}>@lang('general.filter_status.inactive')</option>
            	<option value="1" {{(@$_GET['status']==1)?"selected":''}}>@lang('general.filter_status.active')</option>
            	<option value="2" {{(@$_GET['status']==2)?"selected":''}}>@lang('general.filter_status.ban')</option>
            </select>
            <span for="searchFilter">@lang('general.filter_status.title')</span>
        </label>        
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>