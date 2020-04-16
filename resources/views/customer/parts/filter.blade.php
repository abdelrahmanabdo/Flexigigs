<div class="filter">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8">
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
            <span>
            <input name="searchFilter" placeholder="@lang('general.filter_search')" class="form-control" type="text">
        </span>
        </div>
        <div class="form-group">
            <label class="text-hide" for="gig">@lang('general.filter_select_gig.title')</label>
            <select class="form-control" name="gig">
                <option>@lang('general.filter_select_gig.new')</option>
                <option>@lang('general.filter_select_gig.top')</option>
                <option>@lang('general.filter_select_gig.old')</option>
            </select>
        </div>
        <div class="form-group">
            <div class="d-flex justify-content-between">
                <label for="location">@lang('general.filter_date_range')</label>
                <div>
                    <input type="text" class="form-control datepicker" placeholder="@lang('general.filter_date_range_from')" id="from" name="from">
                    <input type="text" class="form-control datepicker" placeholder="@lang('general.filter_date_range_to')" id="to" name="to">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>