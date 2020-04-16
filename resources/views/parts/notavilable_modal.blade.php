<!-- Modal with no Gighunter available -->
<div class="modal fade" id="noGigHunter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabe">@lang('orders.dashboard_customer_orders_order_again')</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center lead">
                    @lang('orders.dashboard_customer_orders_gh_not_available_title')
                </p>
                <p class="text-center lead">@lang('orders.dashboard_customer_orders_gh_not_available')</p>
            </div>
            <div class="modal-footer pt-0 pb-0">
                <div class="container">
                    <div class="row">
                        <button type="button" class="col-sm-6 btn btn-outline-primary btn-sm text-uppercase" data-dismiss="modal">@lang('general.button_cancel') </button>
                        @if (Request::segment(1)!=="category")
                        <a href="{{url('category/'.$category->slug)}}" class="col-sm-6 btn btn-primary btn-sm text-uppercase">@lang('general.button_view_similar_services')</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>