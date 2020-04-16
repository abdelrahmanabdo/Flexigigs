@extends('layouts.home')
@section('title', 'profile')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<!-- message modal -->
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$userdata->first_name}}{{" ".$userdata->last_name}} @lang('user.customer_profile.title')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('customer.parts.sidecard')
        </div>
        <div class="col-md-8">
            @if (Auth::check())
                @if (@Auth::user()->id == $userdata->id)
                    @if(!$userdata->intro||!$userdata->phone||!$userdata->avatar||!$userdata->city||!$userdata->avatar||!$userdata->facebook||!$userdata->linkedin||!$userdata->instagram||!$userdata->twitter||!$userdata->company_name||!$userdata->site_url||!$userdata->formatted_address)
                    <div class="completeProfile bg-primary p-5 text-white font-weight-regular d-flex flex-row justify-content-start align-items-center mb-4 col-12">
                        <h1 class="m-0 h3">@lang('user.customer_profile.complete_msg') <a href="{{url(app()->getLocale().'/customer/profile/edit')}}" class="text-white h4"><u>@lang('user.customer_profile.complete_now')</u></a></h1>
                    </div>
                    @endif
                @endif
            @endif
            @include('customer.profile.reviews')
        </div>
    </div>
</section>
@if (Auth::check())
    @include('parts.messages.send')
@endif
@endsection