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
                    <div class="row tab-pane active fade show" id="servicesResult">
                        <div class="col-sm-12">
                            <div class="float-right form-group">
                                <label for="sortby" class="text-hide">@lang('general.sort_title')</label>
                                <select class="form-control alt sort-DropDown sorter" name="sortby">
                                    <option disabled selected>@lang('general.sort_title')</option>
                                    <option value="price_desc" {{(@$_GET['sort_by']=="price_desc")?"selected":""}}>@lang('general.sort_option_price_DESC')</option>
                                    <option value="price_asc" {{(@$_GET['sort_by']=="price_asc")?"selected":""}}>@lang('general.sort_option_price_ASC')</option>
                                    <option value="rating_asc" {{(@$_GET['sort_by']=="rating_asc")?"selected":""}}>@lang('general.sort_option_rating_ASC')</option>
                                    <option value="rating_desc" {{(@$_GET['sort_by']=="rating_desc")?"selected":""}}>@lang('general.sort_option_rating_DESC')</option>
                                </select>
                            </div>
                        </div>
                        @if ($result)
                            @foreach ($result as $service)
                                @include('parts.service.small')
                            @endforeach
                            {{$services_pagination->links()}}
                            @if(session('member_type') === 1)
                                @include('parts.service.add_favorite')
                                @include('parts.service.remove_favorite')
                            @endif
                        @else
                            <!-- <p class="noresultfound">{{trans('general.noresult.'.Request::segment(2))}}</p> -->
							<div class="item text-center noResult">
								<img class="img-fluid my-0 mx-auto noResult-img" src="{{asset('images/no-result_'.app()->getlocale().'.png')}}">
							</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <script type="text/javascript">
        $('.sorter').change(function () {
            url = window.location.href
            if(url.indexOf("?") > -1) {
               window.location =url+"&sort_by="+$(this).val();
            }else{
               window.location =url+"?sort_by="+$(this).val();
            }
        })
    </script>
@endsection
