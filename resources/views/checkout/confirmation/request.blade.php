@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header alt">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            @if ($parent_slug)
            <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/'.$parent_slug['slug'])}}">{{(app()->getLocale()=='ar'&&$parent_slug['name_ar'])?$parent_slug['name_ar']:$parent_slug['name']}}</a></li>
            @endif
            @if ($category->id != $sub_slug['id'])
            <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/'.$parent_slug['slug'].'/'.$sub_slug['slug'])}}">{{(app()->getLocale()=='ar'&&$sub_slug['name_ar'])?$sub_slug['name_ar']:$sub_slug['name']}}</a></li>
            <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/'.$parent_slug['slug'].'/'.$sub_slug['slug'].'/'.$category->slug)}}">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</a></li>
            @else
            <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/'.$parent_slug['slug'].'/'.$category->slug)}}">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('service_details',[$service->id])}}">{{$service->name}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.button_request')</li>
        </ol>
    </nav>
    <div class="container mt-5">
		<p>{{trans_choice('orders.requests.msg', $category->name, ['cat_name' => $category->name])}}</p>
        <p>@lang('orders.requests.sub_msg')</p>
    </div>
</div>
<section id="service-request">
    <div class="container">

        <form method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12 col-lg-8">
					<div class="request mb-5">
						<div class="service-header">
							<h2 class="service-title">{{$service->name}} <small>{{(app()->getLocale()=='ar'&&$parent_slug['name_ar'])?$parent_slug['name_ar']:$parent_slug['name']}} - {{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</small></h2>
							<div class="price">
								<p>{{number_format($service->price_per_unit)}} @lang('general.service_price_unit_EGP')</p>
								<small>@lang('general.service_price_unit_per') {{trans('general.service_'.$service->price_unit)}}</small>
							</div>
						</div>
					</div>
                    <div class="request pt-0">
                        <div class="requirment">
                            <h2 class="service-title mt-0">@lang('orders.requests.requirement_questions')</h2>
                            <div class="mt-5">
                                @if($service->price_unit=="hour")
                                <label class="form-group has-float-label alt {{ $errors->has('delivery_at') ? ' has-error' : '' }}">
                                    <input type="text" name="delivery_at" id="deadlineDatePicker" class="form-control place-size datepicker" placeholder="@lang('service_category.ineed_delivery_at')" value="{{ $delivery_at or old('delivery_at') }}" required/>
                                    <span>@lang('service_category.ineed_delivery_at')</span>
                                     @if ($errors->has('delivery_at'))
                                        <p class="help-block mt-3 text-left">
                                            {{ $errors->first('delivery_at') }}
                                        </p>
                                    @endif
                                </label>
                                @endif
                                <label class="form-group has-float-label alt {{ $errors->has('answer1') ? ' has-error' : '' }}">
                                    <input type="text" name="answer1" class="form-control place-size" placeholder="{{$service->question1}}" value="{{ $answer1 or old('answer1') }}" required/>
                                    <span>{{$service->question1}}</span>
                                     @if ($errors->has('answer1'))
                                        <p class="help-block mt-3 text-left">
                                            {{ $errors->first('answer1') }}
                                        </p>
                                    @endif
                                </label>
                                @if ($service->question2)
                                <label class="form-group has-float-label alt mt-5 {{ $errors->has('answer2') ? ' has-error' : '' }}">
                                    <input type="text" name="answer2" class="form-control place-size" placeholder="{{$service->question2}}" value="{{ $answer2 or old('answer2') }}" required/>
                                    <span>{{$service->question2}}</span>
                                    @if ($errors->has('answer2'))
                                        <p class="help-block mt-3 text-left">
                                            {{ $errors->first('answer2') }}
                                        </p>
                                    @endif
                                </label>
                                @endif
                                @if ($service->question3)
                                <label class="form-group has-float-label alt mt-5 {{ $errors->has('answer3') ? ' has-error' : '' }}">
                                    <input type="text" name="answer3" class="form-control place-size" placeholder="{{$service->question3}}" value="{{ $answer3 or old('answer3') }}" required/>
                                    <span>{{$service->question3}}</span>
                                    @if ($errors->has('answer3'))
                                        <p class="help-block mt-3 text-left">
                                            {{ $errors->first('answer3') }}
                                        </p>
                                    @endif
                                </label>
                                @endif
                                <label class="form-group has-float-label alt mt-5 {{ $errors->has('notes') ? ' has-error' : '' }}">
                                    <textarea name="notes" type="text" class="form-control place-size" placeholder="@lang('orders.requests.other_notes')" value="{{ $notes or old('notes') }}"  required></textarea>
                                    <span>@lang('orders.requests.other_notes')</span>
                                    @if ($errors->has('notes'))
                                        <p class="help-block mt-5 pt-4 text-left">
                                            {{ $errors->first('notes') }}
                                        </p>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="side">
                        <h2 class="font-weight-bold">@lang('orders.requests.payment_card.title')</h2>
                        <div class="custom-controls-stacked">
                            <!-- <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required name="delvery_time">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.requests.payment_card.delever_after') {{$service->days_to_deliver}} @if ($service->price_unit=="project"||$service->price_unit=="Project") @lang('general.service_days') @else @lang('general.service_hours') @endif</span>
                            </label> -->
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required name="total_price">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">{{trans_choice('orders.requests.payment_card.pay_total', $totalfee, ['total_number' => $totalfee])}}</span>
                                <p class="text-gray mb-0 font-italic d-block" style="font-size: 12px;" >{{($service->price_unit === "hour")?$service->price_per_unit." X ".$service->days_to_deliver." = ".$servicefee:$servicefee}} @lang('general.request_service_fees')</p>
                                <p class="text-gray mb-0 font-italic d-block" style="font-size: 12px;" >{{trans_choice('orders.requests.payment_card.handeling_fees', $handlingfee, ['fees_number' => $handlingfee])}}</p>
								
                            </label>
                            <label class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" required name="accept_gigger_terms">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.requests.payment_card.accept_gh_terms')</span>
                                <a href="{{route('service_details',[$service->id])}}" target="blank">@lang('orders.requests.payment_card.view_gh_terms')</a>
                            </label>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required name="accept_flexigigs_terms">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.requests.payment_card.accept_flexi_terms')</span>
                                <a href="{{route('terms')}}" target="blank">@lang('orders.requests.payment_card.view_flexi_terms')</a>
                            </label>
                            <!-- <label class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" required checked name="payment_method">
                                <span class="custom-control-indicator rounded-circle" style="width:2rem;height:2rem;top:5px;"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.requests.payment_card.pay_online')</span>
                            </label> -->
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">@lang('general.button_send_request')</button>
                        <!-- <button type="submit" class="btn btn-primary btn-block">@lang('general.button_continue_to_payment')</button> -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection