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
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('customer_dashboard')}}">@lang('home.menu_my_dashboard')</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{url(app()->getLocale().'/application/'.$application->id)}}">@lang('home.application_supplier')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('home.request')</li>
        </ol>
    </nav>
    <div class="container mt-5">
        <p>@lang('orders.applications.message')</p>
    </div>
</div>
<section id="service-request">
    <div class="container">

        <form method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="request">
                        <div class="service-header">
                            <h2 class="service-title">{{$application->title}}</h2>
                            <div class="price">
                                <p>{{number_format($application->price)}} @lang('general.gig_price_unit_EGP')</p>
                            </div>
                        </div>
                    </div>
                    @if($application->notes)
                     <div class="request">
                        <div class="requirment">
                            <h2 class="service-title mt-0">@lang('gigs.dashboard_supplier_apps_info.gh_notes')</h2>
                            <div class="mt-5">
                                <p>{{$application->notes}}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="side">
                        <h2 class="font-weight-bold">@lang('orders.applications.payment_card.title')</h2>
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required name="total_price">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">{{trans_choice('orders.applications.payment_card.pay_total', $totalfee, ['total_number' => $totalfee])}}</span>
                                <p class="text-gray mb-0 font-italic d-block" style="font-size: 12px;" >{{number_format($application->price)}} @lang('general.service_fees')</p>
                                <p class="text-gray mb-0 font-italic d-block" style="font-size: 12px;" >{{trans_choice('orders.applications.payment_card.handeling_fees',$handlingfee, ['fees_number' => $handlingfee])}}</p>
                            </label>
                            <label class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" required name="accept_gighanter_note">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.applications.payment_card.accept_gh_notes')</span>
                            </label>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required name="accept_flexigigs_terms">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.applications.payment_card.accept_flexi_terms')</span>
                                <a href="{{route('terms')}}" target="blank">@lang('orders.applications.payment_card.view_flexi_terms')</a>
                            </label>
                            <label class="custom-control custom-radio"  >
                                <input type="radio" class="custom-control-input" name="payment_method" required checked>
                                <span class="custom-control-indicator rounded-circle"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">@lang('orders.applications.payment_card.pay_online')</span>
                            </label>
                            <label class="custom-control custom-checkbox"  >
                                <input type="checkbox" class="custom-control-input" name="semulate" value="1" checked>
                                <span class="custom-control-indicator rounded-circle"></span>
                                <span class="custom-control-description font-weight-bold text-capitalize">success payment</span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">@lang('general.button_continue_to_payment')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection