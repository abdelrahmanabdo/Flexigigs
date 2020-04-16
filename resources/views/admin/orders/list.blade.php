@extends('layouts.home')
@section('title', trans('home.menu_my_dashboard').' | '.trans('general.dashboard_nav_orders'))
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_nav_orders')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
            @include('admin.orders.search')
        </div>
        <div class="col-md-8">
            @include('admin.parts.nav')
			<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_orders')</p>
            <div class="refund_nav item w-100 d-flex align-items-center justify-content-between bg-transparent px-0 pt-0">
                <a href="{{route('admin_refund')}}" class="btn btn-primary rounded">@lang('general.refund.title')</a>
            </div>
            <div class="tab-content" id="dashboardTabsContent">
            @if(count($orders))
                <div class="tab-pane fade show active" id="myOrders" role="tabpanel">
                    <div id="admin-earnings" class="mt-5">
                        <div id="earningsList" data-children=".item">
                        @foreach($orders as $order)
                        @if ($order->type == 1)
                            @if ($order->request)
                            <div class="item">
                                <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList" data-target="#order-{{$order->id}}" aria-expanded="true">
                                    <div class="item-info-collapsed row">
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <p class="font-weight-bold">#{{$order->id}} {{$order->request->name}}</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <div class="row">
                                                <div class="user col-6 col-md-6 col-lg-6 pl-0 pr-0">
													<div class="user-img-sm">
														<div class="user-img-sm-container">
															<img src="{{Flexihelp::get_file($order->customer->avatar,'user',20,$order->customer->gender)}}">
														</div>
													</div>
                                                    <div>
                                                        <a href="{{route('customer_profile',[$order->customer->username])}}" title="{{$order->customer->username}}" class="user_name">
                                                            <p class="font-weight-bold">{{$order->customer->username}}</p>
                                                            <p class="font-weight-light">(@lang('orders.dashboard_supplier_orders_hh'))</p>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="user col-6 col-md-6 col-lg-6 pl-0 pr-0">
													<div class="user-img-sm">
														<div class="user-img-sm-container">
															<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->customer->gender)}}">
														</div>
													</div>
                                                    <div>
                                                        <a href="{{route('supplier_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
                                                            <p class="font-weight-bold">{{$order->supplier->username}}</p>
                                                            <p class="font-weight-light">(@lang('orders.dashboard_supplier_orders_gh'))</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-3 pl-0">
                                            <p class="font-weight-light text-dark text-capitalize col-12">@lang('orders.dashboard_supplier_orders_status.requested') {{Flexihelp::defult_date($order->created_at)}}</p>
                                            <p class="font-weight-light text-dark text-capitalize col-12">{{$order->request->days_to_deliver}} @if ($order->request->price_unit==="hour") @lang('orders.dashboard_supplier_orders_info.status.hours') @else @lang('orders.dashboard_supplier_orders_info.status.days') @endif @lang('orders.dashboard_supplier_orders_info.status.to_deliver')</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <div class="row d-flex flex-row justify-content-end align-items-center">
                                                <p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">{{number_format($order->request->price)}} @lang('general.service_price_unit_EGP')</p>
                                                {{$order->order_status}}
                                                <i class="icon-angle-down text-center col-4 col-md-4 col-lg-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info row">
                                        <div class="col-6 pr-0">
                                            <h2 class="font-weight-bold">{{$order->request->name}}</h2>
                                            <p class="float-left text-weight-bold text-dark text-capitalize">{{Flexihelp::catname($order->request->parent_cat,app()->getLocale(),'array')}} - {{Flexihelp::catname($order->request->sub_cat,app()->getLocale(),'array')}}</p>
                                            <p class="float-left text-weight-bold text-dark text-capitalize" style="clear: left;"> @lang('orders.dashboard_supplier_orders_order') #{{$order->id}}</p>
                                        </div>
                                        <i class="icon-angle-down col-1 text-center"></i>
                                    </div>
                                </div>
                                <div id="order-{{$order->id}}" class="item-content collapse" role="tabpanel">
                                    <div class="row pt-3">
                                        <div class="col-12 col-lg-5">
                                            <div class="item-status">
                                                <div class="row">
                                                    <div class="user col-6">
														<div class="user-img-md">
															<div class="user-img-md-container">
																<img src="{{Flexihelp::get_file($order->customer->avatar,'user',20,$order->customer->gender)}}">
															</div>
														</div>
                                                        <div class="pl-2">
                                                            <a href="{{route('customer_profile',[$order->customer->username])}}" title="{{$order->customer->username}}" class="user_name">
                                                                <p>{{$order->customer->username}}</p>
                                                                <p>(@lang('orders.dashboard_supplier_orders_hh'))</p>
                                                            </a>
                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                <?=Flexihelp::get_stars('customer',$order->customer_id)?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user col-6">
														<div class="user-img-md">
															<div class="user-img-md-container">
																<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
															</div>
														</div>
                                                        <div class="pl-2">
                                                            <a href="{{route('supplier_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
                                                                <p>{{$order->supplier->username}}</p>
                                                                <p>(@lang('orders.dashboard_supplier_orders_gh'))</p>
                                                            </a>
                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                <?=Flexihelp::get_stars('supplier',$order->supplier_id)?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.price')</label>
                                                    <p class="text-primary font-weight-bold">{{number_format($order->request->price)}} @lang('general.gig_price_unit_EGP')</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.date_requiested')</label>
                                                    <p>{{Flexihelp::defult_date($order->created_at)}}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.deadline')</label>
                                                    <p>{{Flexihelp::defult_date($order->delivery_at)}}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.status.title')</label>
                                                    <p>{{$order->order_status}}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label> @lang('orders.dashboard_supplier_orders_info.type.title') </label>
                                                    <p>@if($order->type == 1) @lang('orders.dashboard_supplier_orders_info.type.service') @elseif($order->type == 2) @lang('orders.dashboard_supplier_orders_info.type.gig') @endif</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="row">
                                                <div class="col-12 mt-2 pl-md-0 pl-lg-4">
                                                    <div class="item-status">
                                                        <div class="d-flex flex-wrap flex-column pt-0">
                                                            <h5 class="font-weight-bold h5">{{$order->request->question1}}</h5>
                                                            <p>{{$order->request->answer1}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($order->request->question2)
                                                <div class="col-12 mt-2 pl-md-0 pl-lg-4">
                                                    <div class="item-status">
                                                        <div class="d-flex flex-wrap flex-column pt-0">
                                                            <h5 class="font-weight-bold h5">{{$order->request->question2}}</h5>
                                                            <p>{{$order->request->answer2}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($order->request->question3)
                                                <div class="col-12 mt-2 pl-md-0 pl-lg-4">
                                                    <div class="item-status">
                                                        <div class="d-flex flex-wrap flex-column pt-0">
                                                            <h5 class="font-weight-bold h5">{{$order->request->question3}}</h5>
                                                            <p>{{$order->request->question3}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($order->request->notes)
                                                <div class="item-requirment">
                                                    <label class="font-weight-bold">@lang('orders.dashboard_supplier_orders_info.customer_note')</label>
                                                    <p>{{$order->request->notes}}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            @if(Auth::user()->id==$order->supplier_id && $order->status == 0 && $order->falier == 0)
                                            <button type="button" class="btn btn-outline-primary mt-2 text-capitalize col-12 btn-done" data-id="{{$order->id}}" data-status="1" data-title="@lang('gigs.dashboard_supplier_gigs_title_accept')" data-desc="@lang('gigs.dashboard_supplier_gigs_desc_accept')" data-message-title="@lang('gigs.dashboard_supplier_gigs_title_done_accept')" data-message-desc="@lang('gigs.dashboard_supplier_gigs_desc_done_accept')">@lang('general.button_accept_order')</button>
                                            <button class="btn btn-outline-danger mt-2 text-capitalize col-12 rejectOrder" data-id="{{$order->id}}" data-falier="1">@lang('general.button_reject_order')</button>
                                            @endif
                                            @if(Auth::user()->id==$order->supplier_id||Auth::user()->id==$order->customer_id)
                                                @if($order->status == 2)
                                                    @if(Auth::user()->id==$order->supplier_id)
                                                        @if ($order->cus_review)
                                                            <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 confirmOrder" data-id="{{$order->id}}" data-status="3">@lang('general.button_done')</button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 cantconfirm" data-id="{{$order->id}}">@lang('general.button_done')</button>
                                                        @endif
                                                    @endif
                                                @elseif($order->status == 3)
                                                    @if(Auth::user()->id==$order->customer_id)
                                                        @if ($order->ser_review)
                                                            <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 confirmOrder" data-id="{{$order->id}}" data-status="4">@lang('general.button_confirm_done')</button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 cantconfirm" data-id="{{$order->id}}">@lang('general.button_confirm_done')</button>
                                                        @endif
                                                    @endif
                                                @elseif($order->status >= 2)
                                                    @if($order->request->service)
                                                    <button type="button" class="btn btn-default  {{($order->supplier->availability==0)?'orderAgain':'notAvilable'}}" 
                                                        data-serviceid="{{$order->request->service_id}}"
                                                         data-categoryslug="{{$order->request->category->slug}}">@lang('general.button_order_again')</button>
                                                    @else
                                                    <span class="text-center">@lang('general.service_not_available')</span>
                                                    @endif
                                                @endif
                                            @endif
                                            
                                            @if($order->status < 4)
                                                <button type="button" class="btn btn-outline-primary mt-2 text-capitalize col-12 confirmOrder" data-id="{{$order->id}}" data-status="4">@lang('general.button_mark_completed')</button>
                                                <button class="btn btn-outline-danger mt-2 text-capitalize col-12 confirmOrder" data-id="{{$order->id}}" data-status="5">@lang('general.button_cancel_order')</button>
                                            @endif
                                            @if($order->status == 1 && $order->falier == 0 && !$order->payment)
                                            <a href="{{route('proceed_to_payment',['order_id'=>$order->id])}}" class="btn btn-primary mt-2 text-capitalize col-12" data-id="{{$order->id}}">@lang('general.button_proceed_To_payment')</a>
                                            @elseif($order->status >= 2 && $order->falier == 0)
                                                <button class="btn btn-primary mt-2 text-uppercase col-12 extend_deadline" data-id="{{$order->id}}">@lang('general.extend_deadline')</button>
                                                @if($order->delivery_status->after_4days)
                                                <button class="btn btn-outline-danger mt-2 text-uppercase col-12" type="button" data-toggle="modal" data-target="#claim-refund-{{$order->id}}">@lang('general.claim_refund')</button>                   
                                                <div class="modal fade bd-example-modal-lg" id="claim-refund-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="claim-refund-{{$order->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg bg-white" role="document">
                                                        <div class="modal-content bg-white">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-dark text-uppercase" id="claim-refund-{{$order->id}}Label">claim refund</h5>
                                                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-dark h4">are you sure you want to cancel ypur order and recive the service refund?</p>
                                                            <p class="text-dark h4">IF you confirm you can follow yout refund process from the refunds tab.</p>
                                                        </div>
                                                        <div class="modal-footer d-flex align-items-center justify-content-between m-0 pt-0">
                                                            <button type="button" class="btn btn-outline-primary text-uppercase font-weight-bold w-50" data-dismiss="modal">cancel</button>
                                                            <button type="button" class="btn btn-primary text-uppercase font-weight-bold w-50 claim_refund" data-id="{{$order->id}}">confirm</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @endif  
                                            @endif
                                            @include('reviews.form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @elseif ($order->type == 2)
                            @if ($order->application)
                            <div class="item">
                                <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#orderList" data-target="#order-{{$order->id}}" aria-expanded="true">
                                    <div class="item-info-collapsed row">
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <p class="font-weight-bold">#{{$order->id}} {{$order->application->title}}</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <div class="row">
                                                <div class="user col-6 col-md-6 col-lg-6 pl-0 pr-0">
													<div class="user-img-sm">
														<div class="user-img-sm-container">
															<img src="{{Flexihelp::get_file($order->customer->avatar,'user',20,$order->customer->gender)}}">
														</div>
													</div>

                                                    <div>
                                                        <a href="{{route('customer_profile',[$order->customer->username])}}" title="{{$order->customer->username}}" class="user_name">
                                                            <p class="font-weight-bold">{{$order->customer->username}}</p>
                                                            <p class="font-weight-light">(@lang('orders.dashboard_supplier_orders_hh'))</p>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="user col-6 col-md-6 col-lg-6 pl-0 pr-0">
													<div class="user-img-sm">
														<div class="user-img-sm-container">
															<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->supplier->gender)}}">
														</div>
													</div>
                                                    <div>
                                                        <a href="{{route('supplier_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
                                                            <p class="font-weight-bold">{{$order->supplier->username}}</p>
                                                            <p class="font-weight-light">(@lang('orders.dashboard_supplier_orders_gh'))</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-3 pl-0">
                                            <p class="font-weight-light text-dark text-capitalize col-12">@lang('orders.dashboard_supplier_orders_info.requested') {{Flexihelp::defult_date($order->created_at)}}</p>
                                            <p class="font-weight-light text-dark text-capitalize col-12">@lang('orders.dashboard_supplier_orders_info.deadline') {{Flexihelp::defult_date($order->application->deadline)}}</p>
                                        </div>
                                        <div class="col-6 col-md-6 col-lg-3">
                                            <div class="row d-flex flex-row justify-content-end align-items-center">
                                                <p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">{{number_format($order->application->price)}} @lang('general.service_price_unit_EGP')</p>
                                                {{$order->order_status}}
                                                <i class="icon-angle-down text-center col-4 col-md-4 col-lg-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info row">
                                        <div class="col-6 pr-0">
                                            <h2 class="font-weight-bold">{{$order->application->title}}</h2>
                                            <p class="float-left text-weight-bold text-dark text-capitalize" style="clear: left;">@lang('orders.dashboard_supplier_orders_order') #{{$order->id}}</p>
                                        </div>
                                        <i class="icon-angle-down col-1 text-center"></i>
                                    </div>
                                </div>
                                <div id="order-{{$order->id}}" class="item-content collapse" role="tabpanel">
                                    <div class="row pt-3">
                                        <div class="col-12 col-lg-5">
                                            <div class="item-status">
                                                <div class="row">
                                                    <div class="user col-6">
														<div class="user-img-md">
															<div class="user-img-md-container">
																<img src="{{Flexihelp::get_file($order->customer->avatar,'user',20,$order->customer->gender)}}">
															</div>
														</div>

                                                        <div class="pl-2">
                                                            <a href="{{route('customer_profile',[$order->customer->username])}}" title="{{$order->customer->username}}" class="user_name">
                                                                <p>{{$order->customer->username}}</p>
                                                                <p>(@lang('orders.dashboard_supplier_orders_hh'))</p>
                                                            </a>
                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                <?=Flexihelp::get_stars('customer',$order->customer_id)?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user col-6">
														<div class="user-img-md">
															<div class="user-img-md-container">
																<img src="{{Flexihelp::get_file($order->supplier->avatar,'user',20,$order->customer->gender)}}">
															</div>
														</div>
                                                        <div class="pl-2">
                                                            <a href="{{route('supplier_profile',[$order->supplier->username])}}" title="{{$order->supplier->username}}" class="user_name">
                                                                <p>{{$order->supplier->username}}</p>
                                                                <p>(@lang('orders.dashboard_supplier_orders_gh'))</p>
                                                            </a>
                                                            <div class="br-wrapper br-theme-fontawesome-stars">
                                                                <?=Flexihelp::get_stars('supplier',$order->supplier_id)?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.price')</label>
                                                    <p class="text-primary font-weight-bold">{{number_format($order->application->price)}} @lang('general.service_price_unit_EGP')</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.date_requiested')</label>
                                                    <p>{{Flexihelp::defult_date($order->created_at)}}</p>
                                                
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.deadline')</label>
                                                    <p>{{Flexihelp::defult_date($order->application->deadline)}}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label>@lang('orders.dashboard_supplier_orders_info.status.title')</label>
                                                    <p>{{$order->order_status}}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <label> @lang('orders.dashboard_supplier_orders_info.type.title') </label>
                                                    <p>@if($order->type == 1) @lang('orders.dashboard_supplier_orders_info.type.service') @elseif($order->type == 2) @lang('orders.dashboard_supplier_orders_info.type.gig') @endif</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="row">
                                                <div class="col-12 mt-2 pl-md-0 pl-lg-4">
                                                    <div class="item-status">
                                                        <div class="d-flex flex-wrap flex-column pt-0">
                                                            <h5 class="font-weight-bold h5">@lang('orders.dashboard_supplier_orders_info.description')</h5>
                                                            <p>{{$order->application->description}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            @if(Auth::user()->id==$order->supplier_id )
                                                @if($order->status == 2)
                                                    @if ($order->cus_review)
                                                        <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 confirmOrder" data-id="{{$order->id}}" data-status="3">@lang('general.button_done')</button>
                                                    @else
                                                        <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 cantconfirm" data-id="{{$order->id}}">@lang('general.button_done')</button>
                                                    @endif
                                                @endif
                                            @elseif(Auth::user()->id==$order->customer_id)
                                                @if($order->status == 3)
                                                    @if ($order->ser_review)
                                                        <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 confirmOrder" data-id="{{$order->id}}" data-status="4">@lang('general.button_confirm_done')</button>
                                                    @else
                                                        <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 cantconfirm" data-id="{{$order->id}}" >@lang('general.button_confirm_done')</button>
                                                    @endif
                                                @endif
                                            @endif
                                            @if($order->status < 4)
                                                <button type="button" class="btn btn-outline-primary mt-2 text-capitalize text-center col-12 confirmOrder" data-id="{{$order->id}}" data-status="4">@lang('general.button_mark_completed')</button>
                                                <button class="btn btn-outline-danger mt-2 text-capitalize col-12 confirmOrder text-center" data-id="{{$order->id}}" data-status="5">@lang('general.button_cancel_order')</button>
                                            @endif
                                            @if($order->status == 1 && $order->falier == 0 && !$order->payment)
                                            <a href="{{route('proceed_to_payment',['order_id'=>$order->id])}}" class="btn btn-primary mt-2 text-capitalize col-12" data-id="{{$order->id}}">@lang('general.button_proceed_To_payment')</a>
                                            @elseif($order->status >= 2 && $order->falier == 0)
                                                <button class="btn btn-primary mt-2 text-uppercase col-12 extend_deadline" data-id="{{$order->id}}">@lang('general.extend_deadline')</button>
                                                @if($order->delivery_status->after_4days)
                                                <button class="btn btn-outline-danger mt-2 text-uppercase col-12" type="button" data-toggle="modal" data-target="#claim-refund-{{$order->id}}">@lang('general.claim_refund')</button>                   
                                                <div class="modal fade bd-example-modal-lg" id="claim-refund-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="claim-refund-{{$order->id}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg bg-white" role="document">
                                                        <div class="modal-content bg-white">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-dark text-uppercase" id="claim-refund-{{$order->id}}Label">claim refund</h5>
                                                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-dark h4">are you sure you want to cancel ypur order and recive the service refund?</p>
                                                            <p class="text-dark h4">IF you confirm you can follow yout refund process from the refunds tab.</p>
                                                        </div>
                                                        <div class="modal-footer d-flex align-items-center justify-content-between m-0 pt-0">
                                                            <button type="button" class="btn btn-outline-primary text-uppercase font-weight-bold w-50" data-dismiss="modal">cancel</button>
                                                            <button type="button" class="btn btn-primary text-uppercase font-weight-bold w-50 claim_refund" data-id="{{$order->id}}">confirm</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @endif  
                                            @endif
                                            @include('reviews.form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                        @endforeach
                        <!-- Modal -->
                        <div class="modal fade" id="orderagainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-light text-dark">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">@lang('orders.dashboard_customer_orders_order_again')</h5>
                                        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center lead">
                                            @lang('orders.dashboard_customer_orders_order_again_msg')
                                        </p>
                                    </div>
                                    <div class="modal-footer pt-0 pb-0">
                                        <div class="container">
                                            <div class="row">
                                                <button type="button" class="col-sm-6 btn btn-outline-primary btn-sm text-uppercase" data-dismiss="modal">@lang('general.button_cancel') </button>
                                                <a href="#" class="col-sm-6 btn btn-primary btn-sm text-uppercase confirmbtn">@lang('general.button_confirm')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                <a href="#" class="col-sm-6 btn btn-primary btn-sm text-uppercase confirmbtn">@lang('general.button_view_similar_services')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="modal fade export-modal" tabindex="-1" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form  onSubmit="$('.export-modal').modal('hide');" method="get" action="{{route('exportorder')}}" target="_blank">
                                    {{csrf_field()}}
                                    <input type="hidden" name="supplier" value="{{ request()->has('supplier') ? request()->get('supplier') : '' }}">
                                    <input type="hidden" name="customer" value="{{ request()->has('customer') ? request()->get('customer') : '' }}">
                                    <input type="hidden" name="type" value="{{ request()->has('type') ? request()->get('type') : '' }}">
                                    <input type="hidden" name="status" value="{{ request()->has('status') ? request()->get('status') : '' }}">
                                    <input type="hidden" name="date_from" value="{{ request()->has('date_from') ? request()->get('date_from') : '' }}">
                                    <input type="hidden" name="date_to" value="{{ request()->has('date_to') ? request()->get('date_to') : '' }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title">export data</h5>
                                        <button type="reset" class="close"  aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-group has-float-label form-group mt-5">
                                            <select class="form-control" name="month">
                                                <option disabled>--select month--</option>
                                                @foreach($months as $month)
                                                <option value="{{date('Y-m',strtotime($month[0]->created_at))}}"> {{date('Y-M',strtotime($month[0]->created_at))}} </option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <button class="btn btn-primary btn-block" type="submit" id="sendbtn">download</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{$orders->links('vendor.pagination.withexport')}}
                </div>
            @else
                <div class="item text-center noResult">
					<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
				</div>
            @endif
    		</div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('body').on('click','.orderAgain',function () {
        var item = $(this);
        serviceid = item.data('serviceid');
        $('#orderagainModal .confirmbtn').attr('href','{{url(app()->getLocale()."/request/service")}}/'+serviceid);
        $('#orderagainModal').modal('show');
    });
     $('body').on('click','.notAvilable',function () {
        var item = $(this);
        categoryslug = item.data('categoryslug');
        $('#noGigHunter .confirmbtn').attr('href','{{url(app()->getLocale()."category")}}/'+categoryslug);
        $('#noGigHunter').modal('show');
    });
    $('.cantconfirm').click(function () {
        swal({title: "@lang('general.cantconfirm.title')",
              text: "@lang('general.cantconfirm.desc')",
              icon: "warning",
              dangerMode: true,});
    });
</script>
@include('admin.orders.done')
@include('supplier.gigs.done')
@include('customer.orders.extend_deadline')
@endsection