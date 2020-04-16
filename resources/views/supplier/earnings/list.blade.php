@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
	@include('parts.search')
@endsection
@section('content')
	<div class="page-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-6">
					<h1 class="text-uppercase text-primary m-0 text-left">gighunter dashboard</h1>
				</div>
				<div class="col-6">
					<nav aria-label="breadcrumb" role="navigation">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
							<li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<section class="container">
		<div class="row">
			<div class="col-md-4">
				@include('supplier.parts.sidecard')
				<div class="filter position-relative">
					<h2>@lang('general.filter_title')</h2>
					<form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
						<button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
						<div class="form-group">
							<label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
							<span>
							<input name="service_gig" placeholder="Search" value="{{@$_GET['service_gig']}}" class="form-control" type="text">
						</span>
						</div>
						<div class="form-group">
							<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status">
								@lang('general.filter_status.title')
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="collapse show" id="status">
								<div>
									<input type="radio" id="status-2" name="status" value="5"{{(@$_GET['status']==5)?"checked":""}}>
									<label class="text-dark h6 my-2" for="status-2">@lang('general.filter_status.due')</label>
								</div>
								<div>
									<input type="radio" id="status-3" name="status" value="6"{{(@$_GET['status']==6)?"checked":""}}>
									<label class="text-dark h6 my-2" for="status-3">@lang('general.filter_status.paid')</label>
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
						<div class="form-group">
							<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse"
									data-target="#payment-method" aria-expanded="true" aria-controls="payment-method">
								@lang('general.filter.payment_method')
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="collapse show" id="payment-method">
								<div>
									<input type="radio" id="payment-method-2" name="payment_method" value="1" {{(@$_GET['payment_method']==1)?"checked":""}}>
									<label class="text-dark h6 my-2"
										   for="payment-method-2">@lang('general.filter_status.cash_fawry')</label>
								</div>
								<div>
									<input type="radio" id="payment-method-3" name="payment_method" value="2" {{(@$_GET['payment_method']==2)?"checked":""}} >
									<label class="text-dark h6 my-2"
										   for="payment-method-3">@lang('general.filter_status.bank_transfer')</label>
								</div>
							</div>
						</div>
						<hr>
						<button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
					</form>
				</div>
			</div>
			<div class="col-md-8">
				@include('supplier.parts.nav')
				<div class="tab-content mt-4" id="dashboardTabsContent">
					<p class="lato-bold text-capitalize m-0 h4">@lang('general.dashboard_nav_my_earnings')</p>


					<!--
                        New Design from ashraf
                    ============================
                     -->
					<div class="d-flex align-items-center justify-content-between my-3">
						<p class="text-black font-weight-bold text-left m-0 h5 lato-regular">completed orders'
							transactions will be fulfilled to you from flexigigs every week.</p>
						<div class="float-right form-group">
							<select class="form-control alt sort-DropDown sorter">
								<option selected>option 1</option>
								<option>option 2</option>
							</select>
						</div>
					</div>
					@if(sizeof($orders))
						<div id="refundList" data-children=".item">
							@foreach($orders as $order)
								@if ($order->type == 1 && $order->request)
                                    <?php $price = Flexihelp::fixprice($order->request, 'service'); ?>
									<div class="item refund_item">
										<!-- refund triger -->
										<div class="item-trigger collapsed" data-toggle="collapse"
											 data-parent="#ordersList"
											 data-target="#earning-{{$order->id}}" aria-expanded="true">
											<div class="item-info-collapsed row refund_item_collapsed">
												<div class="col-2 col-lg-1">
													<p class="font-weight-bold">#{{$order->id}}</p>
												</div>
												<div class="col-5 col-md-4 col-lg-3">
													<p class="font-weight-bold text-capitalize">
														{{$order->request->name}}
													</p>
												</div>
												<div class="col-6 col-lg-2 text-center">
													<p class="text-capitalize">
														{{$order->customer->username}}
													</p>
												</div>
												<div class="col-6 col-lg-2 text-center">
													<p class="text-capitalize">
														@if($order->completed_at)
															{{Flexihelp::defult_date($order->completed_at)}}
														@endif
													</p>
												</div>
												<div class="col-6 col-lg-4">
													<div class="row d-flex flex-row justify-content-end align-items-center">
														<p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">
															{{$price->price}} @lang('general.service_price_unit_EGP')
														</p>
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
												<div class="col-10 text-left">
													<h2 class="font-weight-bold text-capitalize text-black">
														{{$order->request->name}}
													</h2>
													<p class="text-capitalize text-black">Order #{{$order->id}}</p>
												</div>
												<div class="col-2 text-right">
													<i class="icon-angle-down mr-2 d-inline-block"></i>
												</div>
											</div>
										</div>
										<!-- refund triger end -->
										<!-- refund content -->
										<div id="earning-{{$order->id}}"
											 class="item-content collapse pt-4 refund_item_content" role="tabpanel">
											<div class="container">
												<div class="row">
													<div style="padding-top:0 !important;"
														 class="col-lg-5 col-12 d-flex flex-column align-items-center justify-content-start px-2 pt-5">

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
															@if($order->status == 6)
																<div class="refund_item_content_done d-flex align-items-start justify-content-start w-100 py-3">
																	<div class="mr-2">
																		<i class="fas fa-check-circle fa-3x text-primary"></i>
																	</div>
																	<div>
																		<h5 class="font-weight-bold text-capitalize m-0">@lang('general.earning.fawry_success')</h5>
																		<p>
																			@lang('general.earning.fawry_success_label')
																			on
																			{{Flexihelp::defult_date($order->updated_at,false,true)}}
																		</p>
																	</div>
																</div>
															@else
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
																	<p class="align-self-start font-weight-light text-black my-3">
																		@lang('orders.dashboard_supplier_earnings.fawry_note')
																	</p>
																</div>
															@endif
														@else
															@if($order->status == 6)
																<div class="refund_item_content_done d-flex align-items-start justify-content-start w-100 py-3">
																	<div class="mr-2">
																		<i class="fas fa-check-circle fa-3x text-primary"></i>
																	</div>
																	<div>
																		<h5 class="font-weight-bold text-capitalize m-0">@lang('general.earning.bank_success')</h5>
																		<p>
																			@lang('general.earning.bank_success_label')
																			on
																			{{Flexihelp::defult_date($order->updated_at,false,true)}}
																		</p>
																	</div>
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
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								@elseif ($order->type == 2 && $order->application)
                                    <?php $price = Flexihelp::fixprice($order->application, 'gig'); ?>
									<div class="item refund_item">
										<!-- refund triger -->
										<div class="item-trigger collapsed" data-toggle="collapse"
											 data-parent="#ordersList"
											 data-target="#earning-{{$order->id}}" aria-expanded="true">
											<div class="item-info-collapsed row refund_item_collapsed">
												<div class="col-2 col-lg-1">
													<p class="font-weight-bold">#{{$order->id}}</p>
												</div>
												<div class="col-5 col-md-4 col-lg-3">
													<p class="font-weight-bold text-capitalize">
														{{$order->application->title}}
													</p>
												</div>
												<div class="col-6 col-lg-2 text-center">
													<p class="text-capitalize">
														{{$order->customer->username}}
													</p>
												</div>
												<div class="col-6 col-lg-2 text-center">
													<p class="text-capitalize">
														{{Flexihelp::defult_date($order->completed_at)}}
													</p>
												</div>
												<div class="col-6 col-lg-4">
													<div class="row d-flex flex-row justify-content-end align-items-center">
														<p class="text-primary font-weight-bold p-0 col-4 col-md-4 col-lg-4">
															{{$price->price}} @lang('general.service_price_unit_EGP')
														</p>
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
												<div class="col-10 text-left">
													<h2 class="font-weight-bold text-capitalize text-black">
														{{$order->application->title}}
													</h2>
													<p class="text-capitalize text-black">Order #{{$order->id}}</p>
												</div>
												<div class="col-2 text-right">
													<i class="icon-angle-down mr-2 d-inline-block"></i>
												</div>
											</div>
										</div>
										<!-- refund triger end -->
										<!-- refund content -->
										<div id="earning-{{$order->id}}"
											 class="item-content collapse pt-4 refund_item_content" role="tabpanel">
											<div class="container">
												<div class="row">
													<div style="padding-top:0 !important;"
														 class="col-lg-5 col-12 d-flex flex-column align-items-center justify-content-start px-2 pt-5">

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
														<div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-3 border border-top-0 border-right-0 border-left-0">
                                                            <span class="text-capitalize text-dark text-left font-weight-bold">
                                                                @lang('orders.dashboard_supplier_earnings.total')
                                                            </span>
															<span class="text-secondary text-right text-capitalize">
                                                                <p>{{$price->total_transaction}} @lang('general.service_price_unit_EGP')</p>
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
															@if($order->status == 6)
																<div class="refund_item_content_done d-flex align-items-start justify-content-start w-100 py-3">
																	<div class="mr-2">
																		<i class="fas fa-check-circle fa-3x text-primary"></i>
																	</div>
																	<div>
																		<h5 class="font-weight-bold text-capitalize m-0">@lang('general.refund.fawry_number')</h5>
																		<p>
																			you recived your mony cash through fawry on
																			14/7/2018 at 2:32 pm
																		</p>
																	</div>
																</div>
															@else
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
																	<p class="align-self-start font-weight-light text-black my-3">
																		@lang('orders.dashboard_supplier_earnings.fawry_note')
																	</p>
																</div>
															@endif
														@else
															@if($order->status == 6)
																<div class="refund_item_content_done d-flex align-items-start justify-content-start w-100 py-3">
																	<div class="mr-2">
																		<i class="fas fa-check-circle fa-3x text-primary"></i>
																	</div>
																	<div>
																		<h5 class="font-weight-bold text-capitalize m-0">@lang('general.refund.fawry_number')</h5>
																		<p>
																			you recived your mony cash through fawry on
																			14/7/2018 at 2:32 pm
																		</p>
																	</div>
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
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								@endif
							@endforeach
							<div class="row mt-5">
								{{$orders->links()}}
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
        $('.sorter').change(function () {
            url = window.location.href;
            if (url.indexOf("?") > -1) {
                window.location = url + "&sort_by=" + $(this).val();
            } else {
                window.location = url + "?sort_by=" + $(this).val();
            }
        })
	</script>
@endsection