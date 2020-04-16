<div class="filter" style="position:relative;">
    <h2>@lang('general.filter_title')</h2>
    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
        <button type="reset" class="text-primary resetForm">@lang('general.filter_reset')</button>
        <div class="form-group">
            <label class="text-hide" for="gig">@lang('general.supplier_reviews.title')</label>
            <select class="form-control" name="filter">
                <option value="all" {{(@$_GET['filter']=="all")?"":"selected"}}>@lang('general.supplier_reviews.all')</option>
                <option value="gig" {{(@$_GET['filter']=="gig")?"selected":""}}>@lang('general.supplier_reviews.gigs')</option>
                @if(count($reviewd_services))
                    @foreach($reviewd_services as $rev_service)
                      <option value="{{$rev_service->id}}" {{(@$_GET['filter']==$rev_service->name)?"selected":""}}>{{$rev_service->name}}</option>
                    @endforeach
                @endif  
            </select>
        </div>
        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
    </form>
</div>