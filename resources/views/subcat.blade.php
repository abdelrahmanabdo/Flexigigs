@extends('layouts.home')
@section('title', $category->name)
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
        <div class="page-header alt">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</li>
                </ol>
            </nav>
            <div class="container">
                <h1><i class="{{$category->icon}}"></i> {{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</h1>
                <p>{{(app()->getLocale()=='ar'&&$category->intro_ar)?$category->intro_ar:$category->intro}}</p>
            </div>
        </div>
        <section class="page-content alt">
            <div class="container">
                <div class="row">
                    <!-- sub-components -->
                    <div class="nav flex-column nav-pills col-md-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if ($children)
                        <?php $i=0; ?>
                        @foreach ($children as $cat)
                            @if($cat->children_status)
                            <?php $i++; ?>
                            <a class="cat-link v-pills-{{$cat->slug}} " id="v-pills-{{$cat->slug}}-tab" data-toggle="pill" href="#v-pills-{{$cat->slug}}" role="tab" aria-controls="v-pills-logo-design"
                                aria-selected="{{($i==1)?"false":"true"}}">
                                <h3>{{(app()->getLocale()=='ar'&&$cat->name_ar)?$cat->name_ar:$cat->name}}</h3>
                            </a>
                            @else
                            <a href="{{route(Request::segment(2).'_subcategory2',['parent'=>$category->slug,'slug'=>$cat->slug])}}" class="cat-link">
                                <h3>{{(app()->getLocale()=='ar'&&$cat->name_ar)?$cat->name_ar:$cat->name}}</h3>
                            </a>
                            @endif
                        @endforeach
                        @endif
                        
                    </div>
                    <!-- sub-sub-components -->
                    <!-- take care of div id, aria-labelledby. they changes by each tab listed above-->
                    <div class="tab-content col-md-7 col-sm-12" id="v-pills-tabContent">
                        @if ($children)
                        <?php $i=0; ?>
                        @foreach ($children as $cat)
                            @if($cat->children_status)
                            <?php $i++; ?>
                            <div class="tab-pane v-pills-{{$cat->slug}} fade {{($i==1)?"active show":""}}" id="v-pills-{{$cat->slug}}" role="tabpanel" aria-labelledby="v-pills-{{$cat->slug}}-tab">
                                <div class="col-md-12 ml-5">
                                    <p class="lead">{{(app()->getLocale()=='ar'&&$cat->intro_ar)?$cat->intro_ar:$cat->intro}}</p>
                                    @foreach($cat->children as $subcat)
                                    <a href="{{route(Request::segment(2).'_subcategory2',['parent'=>$cat->slug,'slug'=>$subcat->slug])}}" class="sub-cat-link">
                                        <h3 class="h5">{{(app()->getLocale()=='ar'&&$subcat->name_ar)?$subcat->name_ar:$subcat->name}}</h3>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
@endsection
