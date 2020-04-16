@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('home.title')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('home.search')</li>
                </ol>
            </nav>
            <h1>@lang('general.search_nav_results_for') "{{app('request')->input('free_text')}}"</h1>
        </div>
        <section class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('search.nav')
                </div>
                <div class="col-md-9 tab-content">
                    <div class="row tab-pane active fade show" id="categoriesResult">
                        @foreach($categories as $cat)
                        <div class="col-12">
                            <a href="{{($cat->parent_id == 0)?url($cat->slug):url('category/'.$cat->slug)}}">{{Flexihelp::catname($cat,app()->getLocale())}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
@endsection
