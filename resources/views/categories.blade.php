@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
    <div class="page-header">
        <h1 class="text-uppercase">{{(Request::segment(2)=="service")?trans('service_category.list_title'):trans('gigs.list_title')}}</h1>
        @if(Request::segment(2)=="gig")
            <p>@lang('gigs.list_desc')</p>
        @endif
    </div>
    <section class="page-content alt" id="categories">
        <div class="container">
            <div class="row">
                <?php foreach ($categories as $cat): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="{{route(Request::segment(2).'_subcategory',$cat->slug)}}" class="cat-link">
                        <i class="{{$cat->icon}}"></i>
                        <h3>{{(app()->getLocale()=='ar'&&$cat->name_ar)?$cat->name_ar:$cat->name}}</h3>
                    </a>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
@endsection
