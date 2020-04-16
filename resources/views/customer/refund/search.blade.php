<div class="filter" style="position: relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search_order_id')</label>
            <span>
                <input name="order_id" placeholder="@lang('general.filter_search_order_id')" class="form-control" type="number" value="{{(@$_GET['order_id'])?@$_GET['order_id']:''}}">
            </span>
        </div>
        <div class="form-group">
            <label class="text-hide" for="searchFilter">@lang('general.filter_search_refranceno')</label>
            <span>
                <input name="fawryRefNo" placeholder="@lang('general.filter_search_refranceno')" class="form-control" type="text" value="{{(@$_GET['fawryRefNo'])?@$_GET['fawryRefNo']:''}}">
            </span>
        </div>
        <div class="form-group">
            <button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
                @lang('general.filter_status.title')
                <i class="fas fa-angle-down"></i>
            </button>
            <div class="collapse show" id="status">
                <div>
                    <input type="radio" id="status-1" name="claim_refund" value="" {{(@$_GET['claim_refund'])?"":"checked"}}>
                    <label class="text-dark h6 my-2" for="status-1">@lang('general.filter_status.title')</label>
                </div>
                <div>
                    <input type="radio" id="status-2" name="claim_refund" value="1" {{(@$_GET['claim_refund']==1)?"checked":""}}>
                    <label class="text-dark h6 my-2" for="status-2">@lang('general.refund.status.toRefund')</label>
                </div>
                <div>
                    <input type="radio" id="status-3" name="claim_refund" value="2" {{(@$_GET['claim_refund']==2)?"checked":""}}>
                    <label class="text-dark h6 my-2" for="status-3">@lang('general.refund.status.refund')</label>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>