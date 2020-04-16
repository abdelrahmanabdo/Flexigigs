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
            <li class="breadcrumb-item active" aria-current="page">{{$userdata->first_name}}{{" ".$userdata->last_name}} @lang('user.supplier_profile.title')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
			@include('supplier.parts.sidecard')
			@include('supplier.parts.bankInfo')
        </div>
        <div class="col-md-8">
            @if (Auth::check())
                @if (@Auth::user()->id == $userdata->id)
                    @if(!$userdata->intro||!$userdata->phone||!$userdata->avatar||!$userdata->city||!$userdata->avatar||!$userdata->facebook||!$userdata->linkedin||!$userdata->instagram||!$userdata->twitter||!$userdata->skills)
                    <div class="completeProfile bg-primary p-5 text-white font-weight-regular d-flex flex-row justify-content-start align-items-center mb-4 col-12">
                        <h1 class="m-0 h3">@lang('user.supplier_profile.complete_msg') <a href="{{url(app()->getLocale().'/supplier/profile/edit')}}" class="text-white h4"><u>@lang('user.supplier_profile.complete_now')</u></a></h1>
                    </div>
                    @endif
                @endif
            @endif
            <?php $skills = explode(',',$userdata->skills); ?>
            @if (!empty($skills))
            <div class="supplier-info col-12">
                @if($userdata->intro)
                <h2>@lang('user.supplierinfo')</h2>
                <p>{{$userdata->intro}}</p>
                @endif
                <h2>@lang('user.supplier_profile.key_skills')</h2>
                <div class="w-75">
                        <?php foreach ($skills as $key => $value): ?>
                            <?php $category = DB::table('categories')->where("slug",$value)->first(); ?>
                            @if($category)
                            <span class="badge">{{(app()->getLocale()=="ar"&&$category->name_ar)?$category->name_ar:$category->name}}</span>
                            @endif
                        <?php endforeach ?>
                </div>
            </div>
            @endif
            @foreach($my_services as $my_service)
            <div class="supplier-gig col-12 mt-3">
                <div class="title">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{route('service_details',['id'=>$my_service->id])}}"><h3>{{$my_service->name}}</h3></a>
                            <small>{{(app()->getLocale()=="ar"&&$my_service->sub_cat['name_ar'])?$my_service->sub_cat['name_ar']:$my_service->sub_cat['name']}} - {{(app()->getLocale()=="ar"&&$my_service->parent_cat['name_ar'])?$my_service->parent_cat['name_ar']:$my_service->parent_cat['name']}}</small>
                            <span class="badge">{{count($my_service->requests_done)}} @lang('user.supplier_profile.requests_done')</span>
                        </div>
                        <div>
							<p>{{number_format($my_service->price_per_unit)}} @lang('general.service_price_unit_EGP')</p>
							<!--  $my_service->price_unit -->
                            <small>@lang('general.service_price_unit_per') {{trans('general.service_'.$my_service->price_unit)}}</small>
                        </div>
                    </div>
                </div>
                <p class="side-scroll">{{$my_service->description}}</p>
                <div class="col-12 mt-3 mb-5 pl-0 pr-0">
                    @include('supplier.profile.reviews')
                </div>
            </div>
            @endforeach
            <div class="row mt-3">
                {{$my_services->links()}}
            </div>

        </div>
    </div>
</section>
@if (Auth::check())
    @if (@Auth::user()->id != $userdata->id)
        @include('parts.messages.send')
    @endif
@endif
@endsection