@extends('layouts.home')
@section('title', trans('general.dashboard_my').' | '.trans('general.dashboard_nav_earnings'))
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
    <div class="page-header">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route("home")}}">@lang('home.title')</a></li>
                <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_my')</li>
                <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_nav_earnings')</li>
            </ol>
        </nav>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-md-4">
                @include('admin.parts.sidecard')
                @include('admin.earnings.search')
            </div>
            <div class="col-md-8">
                @include('admin.parts.nav')
                <div class="tab-content mt-4" id="dashboardTabsContent">
                    <p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_earnings')</p>
                    <div class="refund_nav item w-100 d-flex align-items-center justify-content-between">
                        <h3 class="font-weight-bold text-capitalize m-0 position-relative" style="font-size: 1.75rem;">
                            <div class="custom-controls-stacked">
                                <label class="custom-checkbox m-0">
                                    <input type="checkbox" class="custom-control-input" id="selectall">
                                    <span class="custom-control-indicator" style="top: initial !important;"></span>
                                    <span class="custom-control-description font-weight-bold text-capitalize"
                                          style="font-size: 1.4rem;">select all</span>
                                </label>
                            </div>
                        </h3>
                        <button type="submit" class="btn btn-outline-primary rounded">@lang('general.button_change_selected_to_paid')</button>
                    </div>
                    @if(count($orders))
                        <div class="tab-pane fade show active" id="myEarnings" role="tabpanel">
                            @php $i=0; @endphp
                            @foreach($orders as $order)
                                @if ($order->type == 1 && $order->request)
                                    <?php $price = Flexihelp::fixprice($order->request, 'service'); ?>
                                    <div class="item earning_item">
                                        @if($order->status< 6)
                                            <form action="{{url('api/orders/status/'.$order->id)}}" method="post"
                                                  class="order_trans" id="order_trans-{{$order->id}}"
                                                  data-id="{{$order->id}}">
                                                <input type="hidden" name="status" value="6">
                                            @endif
                                            <!-- refund triger -->
                                                <div class="item-trigger collapsed" data-toggle="collapse"
                                                     data-parent="#ordersList" data-target="#earning-{{$order->id}}"
                                                     aria-expanded="true">
                                                    <div class="item-info-collapsed row refund_item_collapsed">
                                                        <div class="pl-3">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-checkbox m-0 position-relative">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="order_id[{{$i}}]"
                                                                           value="{{$order->id}}">
                                                                    <span class="custom-control-indicator"
                                                                          style="top: initial !important;"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-lg-none d-md-block d-block"></div>
                                                        <div class="col-2 col-lg-1 p-lg-0">
                                                            <p class="font-weight-bold">#{{$order->id}}</p>
                                                        </div>
                                                        <div class="col-5 col-md-4 col-lg-2 p-lg-0">
                                                            <p class="font-weight-bold text-capitalize">
                                                                {{$order->request->name}}
                                                            </p>
                                                        </div>
                                                        <div class="col-5 col-md-6 col-lg-2 pr-lg-0">
                                                            <div class="row">
                                                                <div class="user col-12">
                                                                    <div class="user-img-sm m-0 mr-2">
                                                                        <div class="user-img-sm-container">
                                                                            <img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <a href="{{route('supplier_profile',[$order->supplier->username])}}"
                                                                           title="{{$order->supplier->username}}"
                                                                           class="user_name"
                                                                           class="user_name">
                                                                            <p class="font-weight-bold">{{$order->supplier->username}}</p>
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-lg-2 p-0 text-center">
                                                            <p class="text-capitalize">
                                                                @if($order->payment_method == "Fawry")
                                                                    @lang('general.cash_though_fawry')
                                                                @else
                                                                    @lang('general.method.bank')
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="col-6 col-lg-3">
                                                            <div class="row d-flex flex-row justify-content-end align-items-center">
                                                                <p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">
                                                                    {{$price->price}} @lang('general.service_price_unit_EGP')</p>
                                                                <p class="text-capitalize text-black">
                                                                    {{
                                                            ($order->status==6)
                                                            ? trans('orders.dashboard_supplier_earnings.status.paid')
                                                            : trans('orders.dashboard_supplier_earnings.status.due')
                                                            }}
                                                                </p>
                                                                <i class="icon-angle-down text-center col-4 col-md-4 col-lg-4"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-info row refund_item_info">
                                                        <div class="col-1 align-self-start">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-checkbox m-0 position-relative">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="order_id[{{$i}}]"
                                                                           value="{{$order->id}}">
                                                                    <span class="custom-control-indicator"
                                                                          style="top: initial !important;"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 text-left pl-0">
                                                            <h2 class="font-weight-bold text-capitalize text-black">
                                                                {{$order->request->name}}</h2>
                                                            <p class="text-capitalize text-black">
                                                                #{{$order->id}}</p>
                                                        </div>
                                                        <div class="col-4 text-right d-flex align-items-center justify-content-end">
                                                            @if($order->status< 6)
                                                                <button class="btn btn-outline-primary text-capitalize btn-sm changeToPaidBtn">@lang('general.button_change_to_paid')</button>
                                                            @endif
                                                            <i class="icon-angle-down mr-2 d-inline-block"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- refund triger end -->
                                                <!-- refund content -->
                                                <div id="earning-{{$order->id}}"
                                                     class="item-content collapse pt-4 refund_item_content"
                                                     role="tabpanel">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-lg-5 col-12 d-flex flex-column align-items-center justify-content-start px-2">
                                                                <div class="refund_item_content_done d-flex align-items-start justify-content-between w-100 py-3">
                                                                    <div class="user m-0">
                                                                        <div class="user-img-sm m-0 mr-2">
                                                                            <div class="user-img-sm-container">
                                                                                <img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="{{route('supplier_profile',[$order->supplier->username])}}"
                                                                               title="{{$order->supplier->username}}"
                                                                               class="user_name">
                                                                                <p>{{$order->supplier->username}}</p>
                                                                            </a>
                                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                                <?=Flexihelp::get_stars('supplier', $order->supplier->id)?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
                                                    <span class="text-capitalize text-dark text-left font-weight-bold">
                                                        @lang('orders.dashboard_supplier_earnings.service_price')
                                                    </span>
                                                                    <span class="text-uppercase text-primary text-right font-weight-bold">
                                                        {{$price->price}} @lang('general.service_price_unit_EGP')
                                                    </span>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
                                                    <span class="text-capitalize text-dark text-left font-weight-bold">
                                                        @lang('orders.dashboard_supplier_earnings.handling_fee')
                                                    </span>
                                                                    <span class="text-uppercase text-secondary text-right">
                                                       {{config('site_settings.commission.service.transaction')*100}}
                                                                        %
                                                        = {{$price->transaction}} @lang('general.service_price_unit_EGP')
                                                    </span>
                                                                </div>
                                                                @if($order->payment_method != "Fawry")
                                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
                                                    <span class="text-capitalize text-dark text-left font-weight-bold">
                                                        @lang('orders.dashboard_supplier_earnings.transaction_free')<br>
                                                        <i style="font-weight: normal"
                                                           class="text-secondary">( {{config('site_settings.commission.bank')*100}}
                                                            % "minimum = 60 @lang('general.service_price_unit_EGP')
                                                            ")</i>
                                                    </span>
                                                                        <span class="text-uppercase text-secondary text-right">
                                                       {{$price->total_bank_commission}} @lang('general.service_price_unit_EGP')
                                                    </span>
                                                                    </div>
                                                                @endif
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.total')
                                                            </span>
                                                                    <span class="text-secondary text-right text-capitalize">

                                                                <p>
                                                                    @if($order->payment_method != "Fawry")
                                                                        {{intval($price->total_transaction)-intval($price->total_bank_commission)}}
                                                                    @else
                                                                        {{$price->total_transaction}}
                                                                    @endif
                                                                    @lang('general.service_price_unit_EGP')</p>
                                                            </span>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('orders.dashboard_supplier_earnings.status.title')
                                                            </span>
                                                                    <span class="text-secondary text-right text-capitalize">
                                                                {{($order->status==6)? trans('orders.dashboard_supplier_earnings.status.paid') : trans('orders.dashboard_supplier_earnings.status.due') }}
                                                            </span>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.payment.title')
                                                            </span>
                                                                    <span class="text-secondary text-right text-capitalize">
                                                                {{$order->payment_method}}
                                                            </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-12 d-flex flex-column align-items-center justify-content-start">
                                                                @if($order->payment_method=="Fawry")
                                                                    <div class="fawry-details">
                                                                        <h2 class="font-weight-bold text-capitalize align-self-start mb-4 h5 refund_item_content_title">
                                                                            @lang('orders.dashboard_supplier_earnings.fawry_title')</h2>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.transaction_ref_id')
                                                            </span>
                                                                            <span class="badge badge-primary rounded m-0">
                                                                {{$order->fawryRefNo}}
                                                            </span>
                                                                        </div>
                                                                        {{--<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">--}}
                                                                        {{--<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.fawry_number')</span>--}}
                                                                        {{--<span class="badge badge-primary rounded m-0">1234</span>--}}
                                                                        {{--</div>--}}
                                                                    </div>
                                                                @else
                                                                    <div class="bank-details">
                                                                        <h2 class="font-weight-bold text-capitalize align-self-start mb-4 h5 refund_item_content_title">
                                                                            @lang('orders.dashboard_supplier_earnings.bank_title')</h2>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_beneficiary_name')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->beneficiary_name}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_account_number')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->bank_account_number}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_beneficiary_account')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->iban}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_name')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->bank_name}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_address')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->banks_address}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_swift')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->swift_code}}
                                                                    </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($order->status< 6)
                                            </form>
                                        @endif
                                    </div>
                                @elseif ($order->type == 2 && $order->application)
                                    <?php $price = Flexihelp::fixprice($order->application, 'gig'); ?>
                                    <div class="item earning_item">
                                        @if($order->status< 6)
                                            <form action="{{url('api/orders/status/'.$order->id)}}" method="post"
                                                  class="order_trans" id="order_trans-{{$order->id}}"
                                                  data-id="{{$order->id}}">
                                                <input type="hidden" name="status" value="6">
                                            @endif
                                            <!-- refund triger -->
                                                <div class="item-trigger collapsed" data-toggle="collapse"
                                                     data-parent="#ordersList" data-target="#earning-{{$order->id}}"
                                                     aria-expanded="true">
                                                    <div class="item-info-collapsed row refund_item_collapsed">
                                                        <div class="pl-3">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-checkbox m-0 position-relative">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="order_id[{{$i}}]"
                                                                           value="{{$order->id}}">
                                                                    <span class="custom-control-indicator"
                                                                          style="top: initial !important;"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-lg-none d-md-block d-block"></div>
                                                        <div class="col-2 col-lg-1 p-lg-0">
                                                            <p class="font-weight-bold">#{{$order->id}}</p>
                                                        </div>
                                                        <div class="col-5 col-md-4 col-lg-2 p-lg-0">
                                                            <p class="font-weight-bold text-capitalize">
                                                                {{$order->application->title}}
                                                            </p>
                                                        </div>
                                                        <div class="col-5 col-md-6 col-lg-2 pr-lg-0">
                                                            <div class="row">
                                                                <div class="user col-12">
                                                                    <div class="user-img-sm m-0 mr-2">
                                                                        <div class="user-img-sm-container">
                                                                            <img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <a href="{{route('supplier_profile',[$order->supplier->username])}}"
                                                                           title="{{$order->supplier->username}}"
                                                                           class="user_name"
                                                                           class="user_name">
                                                                            <p class="font-weight-bold">{{$order->supplier->username}}</p>
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-lg-2 p-0 text-center">
                                                            <p class="text-capitalize">
                                                                @if($order->payment_method == "Fawry")
                                                                    @lang('general.cash_though_fawry')
                                                                @else
                                                                    @lang('general.method.bank')
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="col-6 col-lg-3">
                                                            <div class="row d-flex flex-row justify-content-end align-items-center">
                                                                <p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">
                                                                    {{$price->price}} @lang('general.service_price_unit_EGP')</p>
                                                                <p class="text-capitalize text-black">
                                                                    {{
                                                            ($order->status==6)
                                                            ? trans('orders.dashboard_supplier_earnings.status.paid')
                                                            : trans('orders.dashboard_supplier_earnings.status.due')
                                                            }}
                                                                </p>
                                                                <i class="icon-angle-down text-center col-4 col-md-4 col-lg-4"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-info row refund_item_info">
                                                        <div class="col-1 align-self-start">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-checkbox m-0 position-relative">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="order_id[{{$i}}]"
                                                                           value="{{$order->id}}">
                                                                    <span class="custom-control-indicator"
                                                                          style="top: initial !important;"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-7 text-left pl-0">
                                                            <h2 class="font-weight-bold text-capitalize text-black">
                                                                {{$order->application->title}}</h2>
                                                            <p class="text-capitalize text-black">
                                                                #{{$order->id}}</p>
                                                        </div>
                                                        <div class="col-4 text-right d-flex align-items-center justify-content-end">
                                                            @if($order->status< 6)
                                                                <button class="btn btn-outline-primary text-capitalize btn-sm changeToPaidBtn">@lang('general.button_change_to_paid')</button>
                                                            @endif
                                                            <i class="icon-angle-down mr-2 d-inline-block"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- refund triger end -->
                                                <!-- refund content -->
                                                <div id="earning-{{$order->id}}"
                                                     class="item-content collapse pt-4 refund_item_content"
                                                     role="tabpanel">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-lg-5 col-12 d-flex flex-column align-items-center justify-content-start px-2">
                                                                <div class="refund_item_content_done d-flex align-items-start justify-content-between w-100 py-3">
                                                                    <div class="user m-0">
                                                                        <div class="user-img-sm m-0 mr-2">
                                                                            <div class="user-img-sm-container">
                                                                                <img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="{{route('supplier_profile',[$order->supplier->username])}}"
                                                                               title="{{$order->supplier->username}}"
                                                                               class="user_name">
                                                                                <p>{{$order->supplier->username}}</p>
                                                                            </a>
                                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                                <?=Flexihelp::get_stars('supplier', $order->supplier->id)?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
                                                    <span class="text-capitalize text-dark text-left font-weight-bold">
                                                        @lang('orders.dashboard_supplier_earnings.service_price')
                                                    </span>
                                                                    <span class="text-uppercase text-primary text-right font-weight-bold">
                                                        {{$price->price}} @lang('general.service_price_unit_EGP')
                                                    </span>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
                                                    <span class="text-capitalize text-dark text-left font-weight-bold">
                                                        @lang('orders.dashboard_supplier_earnings.handling_fee')
                                                    </span>
                                                                    <span class="text-uppercase text-secondary text-right">
                                                       {{config('site_settings.commission.service.transaction')*100}}
                                                                        %
                                                        = {{$price->transaction}} @lang('general.service_price_unit_EGP')
                                                    </span>
                                                                </div>
                                                                @if($order->payment_method != "Fawry")
                                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-left-0 border-right-0 ">
                                                    <span class="text-capitalize text-dark text-left font-weight-bold">
                                                        @lang('orders.dashboard_supplier_earnings.transaction_free')<br>
                                                        <i style="font-weight: normal"
                                                           class="text-secondary">( {{config('site_settings.commission.bank')*100}}
                                                            % "minimum = 60 @lang('general.service_price_unit_EGP')
                                                            ")</i>
                                                    </span>
                                                                        <span class="text-uppercase text-secondary text-right">
                                                       {{$price->total_bank_commission}} @lang('general.service_price_unit_EGP')
                                                    </span>
                                                                    </div>
                                                                @endif
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.total')
                                                            </span>
                                                                    <span class="text-secondary text-right text-capitalize">

                                                                <p>
                                                                    @if($order->payment_method != "Fawry")
                                                                        {{$price->total_transaction-$price->total_bank_commission}}
                                                                    @else
                                                                        {{$price->total_transaction}}
                                                                    @endif
                                                                    @lang('general.service_price_unit_EGP')</p>
                                                            </span>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('orders.dashboard_supplier_earnings.status.title')
                                                            </span>
                                                                    <span class="text-secondary text-right text-capitalize">
                                                                {{($order->status==6)? trans('orders.dashboard_supplier_earnings.status.paid') : trans('orders.dashboard_supplier_earnings.status.due') }}
                                                            </span>
                                                                </div>
                                                                <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.payment.title')
                                                            </span>
                                                                    <span class="text-secondary text-right text-capitalize">
                                                                {{$order->payment_method}}
                                                            </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-12 d-flex flex-column align-items-center justify-content-start">
                                                                @if($order->payment_method=="Fawry")
                                                                    <div class="fawry-details">
                                                                        <h2 class="font-weight-bold text-capitalize align-self-start mb-4 h5 refund_item_content_title">
                                                                            @lang('orders.dashboard_supplier_earnings.fawry_title')</h2>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.transaction_ref_id')
                                                            </span>
                                                                            <span class="badge badge-primary rounded m-0">
                                                                {{$order->fawryRefNo}}
                                                            </span>
                                                                        </div>
                                                                        {{--<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">--}}
                                                                        {{--<span class="text-capitalize text-dark text-left font-weight-bold">@lang('general.refund.fawry_number')</span>--}}
                                                                        {{--<span class="badge badge-primary rounded m-0">1234</span>--}}
                                                                        {{--</div>--}}
                                                                    </div>
                                                                @else
                                                                    <div class="bank-details">
                                                                        <h2 class="font-weight-bold text-capitalize align-self-start mb-4 h5 refund_item_content_title">
                                                                            @lang('orders.dashboard_supplier_earnings.bank_title')</h2>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_beneficiary_name')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->beneficiary_name}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_account_number')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->bank_account_number}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_beneficiary_account')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->iban}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_name')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->bank_name}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_address')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->banks_address}}
                                                                    </span>
                                                                        </div>
                                                                        <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                                <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                    @lang('service_category.dashboard_supplier_bank_swift')
                                                                </span>
                                                                            <span class="m-0">
                                                                        {{$order->supplier->swift_code}}
                                                                    </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($order->status< 6)
                                            </form>
                                        @endif
                                    </div>
                                @endif
                                @php $i++; @endphp
                            @endforeach
                            <div class="row mt-4">
                                <div class="modal fade export-modal" tabindex="-1" role="dialog"
                                     aria-labelledby="exportModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form onSubmit="$('.export-modal').modal('hide');" method="get"
                                                  action="{{route('exportorder')}}" target="_blank">
                                                {{csrf_field()}}
                                                <input type="hidden" name="earning" value="true">
                                                <input type="hidden" name="supplier"
                                                       value="{{ request()->has('supplier') ? request()->get('supplier') : '' }}">
                                                <input type="hidden" name="type"
                                                       value="{{ request()->has('type') ? request()->get('type') : '' }}">
                                                <input type="hidden" name="status"
                                                       value="{{ request()->has('status') ? request()->get('status') : '' }}">
                                                <input type="hidden" name="date_from"
                                                       value="{{ request()->has('date_from') ? request()->get('date_from') : '' }}">
                                                <input type="hidden" name="date_to"
                                                       value="{{ request()->has('date_to') ? request()->get('date_to') : '' }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">export data</h5>
                                                    <button type="reset" class="close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <label class="form-group has-float-label form-group mt-5">

                                                        <select class="form-control" name="payment_method">
                                                            <option selected disabled>--select Type--</option>
                                                            <option value="1">@lang('general.method.fawry')</option>
                                                            <option value="2">@lang('general.method.bank')</option>
                                                        </select>
                                                        <select class="form-control" name="month">
                                                            <option disabled>--select month--</option>
                                                            @foreach($months as $month)
                                                                <option value="{{date('Y-m',strtotime($month[0]->created_at))}}"> {{date('Y-M',strtotime($month[0]->created_at))}} </option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                    <button class="btn btn-primary btn-block" type="submit"
                                                            id="sendbtn">@lang('general.button_download')</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{$orders->links('vendor.pagination.withexport')}}
                            </div>
                        </div>
                    @else
                        <div class="item text-center noResult">
                            <p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans('general.noresult.'.Request::segment(2))}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $('.custom-checkbox').each(function (i, el) {
            $(el).click(function (e) {
                e.stopPropagation();
            });
        });
        $('#selectall').change(function () {
            if (this.checked) {
                $('.custom-control-input').prop('checked', true);
            } else {
                $('.custom-control-input').prop('checked', false);
            }
        });

        $('.sorter').change(function () {
            url = window.location.href;
            if (url.indexOf("?") > -1) {
                window.location = url + "&sort_by=" + $(this).val();
            } else {
                window.location = url + "?sort_by=" + $(this).val();
            }
        });
        // stoping bootstrap collapse from collapsing after clicking some buttons
        $('.changeToPaidBtn').on('click', function (e) {
            e.stopPropagation();
        });
    </script>
    <script type="text/javascript">
        $('.order_trans').on('submit', function (e) {
            var item = $(this);
            var id = item.data('id');
            e.preventDefault();
            var formData = $(this).serialize();
            var action = $(this).attr('action');
            swal({
                title: "@lang('general.earnings.title')",
                text: '@lang("general.earnings.desc")',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function (confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: 'POST',
                        url: action,
                        data: formData,
                        headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                        success: function (message) {
                            location.reload();
                        },
                        error: function (message) {
                            transErrors = message.responseJSON.message;
                            console.log(transErrors);
                            if (transErrors.transaction_id) {
                                $('#order_trans-' + id).addClass('has-error');
                                $('#order_trans-' + id + ' .help-block').removeClass('d-none').text(transErrors.transaction_id);
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $('form#MassPaid').submit(function () {
            var form = $(this);
            swal({
                title: "@lang('general.earnings.title')",
                text: '@lang("general.earnings.desc")',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then(function (done) {
                    if (done) {
                        $.ajax({
                            url: '{{route("mass_paid")}}',
                            data: form.serialize(),
                            type: 'POST',
                            success: function (result) {
                                location.reload();
                            }
                        });
                    }
                });
        });
    </script>
@endsection