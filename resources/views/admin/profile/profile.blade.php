@extends('layouts.home')
@section('title', 'profile')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<!-- message modal -->
@include('supplier.messages.parts.send')
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
        </div>
        <div class="col-md-8">
            <div class="supplier-info">
                <h2>@lang('user.suppler_profile.supplier_info')</h2>
                <p>{{$userdata->intro}}</p>
                <h2>@lang('user.supplier_profile.key_skills')</h2>
                <div class="w-75">
                    <?php $skills = explode(',',$userdata->skills); ?>
                    <?php if (!empty($skills)): ?>
                        <?php foreach ($skills as $key => $value): ?>
                            <?php $category = DB::table('categories')->where("slug",$value)->first(); ?>
                            @if($category)
                            <span class="badge">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</span>
                            @endif
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            @foreach($my_services as $my_service)
            <div class="supplier-gig">
                <div class="title">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3>{{$my_service->name}}</h3>
                            <small>{{(app()->getLocale()=='ar'&&$my_service->sub_cat['name_ar'])?$my_service->sub_cat['name_ar']:$my_service->sub_cat['name']}} - {{(app()->getLocale()=='ar'&&$my_service->parent_cat['name_ar'])?$my_service->parent_cat['name_ar']:$my_service->parent_cat['name']}}</small>
                            <span class="badge">0 Requests Done</span>
                        </div>
                        <div>
                            <p>{{$my_service->price_per_unit}} EGP</p>
                            <small>Per {{$my_service->price_unit}}</small>
                        </div>
                    </div>
                </div>
                <p>{{$my_service->description}}</p>
                <!-- <div class="reviews">
                    <div class="header">
                        <h3>Reviews</h3>
                        <select class="form-control">
                            <option value="">Sort by</option>
                            <option value="rating">Rating</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                    <div class="review">
                        <div class="header">
                            <div class="user">
                                <img src="images/man.png">
                                <div>
                                    <p>Supplier Name</p>
                                </div>
                            </div>
                            <select id="test" class="user-rating" data-readonly="true">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option selected value="5">5</option>
                            </select>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>
                </div>
                <div class="paging">
                    <p>1 - 15 of 100</p>
                    <a href="#"><i class="icon-angle-left"></i></a>
                    <a href="#" class="disabled"><i class="icon-angle-right"></i></a>
                </div> -->
            </div>
            @endforeach

        </div>
    </div>
</section>
@endsection