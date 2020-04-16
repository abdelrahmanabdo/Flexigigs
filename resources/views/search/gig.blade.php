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
                                    <option value="created_asc" {{(@$_GET['sort_by']=="created_asc")?"selected":""}}>@lang('general.sort_option_creaetd_ASC')</option>
                                    <option value="created_desc" {{(@$_GET['sort_by']=="created_desc")?"selected":""}}>@lang('general.sort_option_created_DESC')</option>
                                    <option value="deadline_desc" {{(@$_GET['sort_by']=="deadline_desc")?"selected":""}}>@lang('general.sort_option_deadline_DESC')</option>
                                    <option value="deadline_asc" {{(@$_GET['sort_by']=="deadline_asc")?"selected":""}}>@lang('general.sort_option_deadline_ASC')</option>
                                </select>
                            </div>
                        </div>
                        @if($result)
                        @foreach($result as $gig)
                        <div class="col-sm-12 col-lg-6 col-xl-4">
                            <div class="service-thumb proposed">
                                <a href="{{route('gig_details',['id'=>$gig->id])}}">
                                    <h3 class="service-title text-truncate">{{$gig->title}}</h3>
                                    <small>@lang('home.latest_gig_single_submitted') {{Flexihelp::defult_date($gig->created_at)}}</small>
                                    <small>@lang('home.latest_gig_single_dead_line') {{Flexihelp::defult_date($gig->deadline)}}</small>
                                    <div class="service-desc">
                                        <div class="price">
                                            <p>{{number_format($gig->price)}} @lang('general.gig_price_unit_EGP')</p>
                                        </div>
                                        <p>{{$gig->description}}</p>
                                    </div>
                                    <div class="service-skills">
                                        <label>Skills</label>
                                        <div>
                                            <?php $i = 0 ?>
                                            @foreach($gig->skills as $skill)
                                            <?php
                                            $i++;
                                            if ($i<2): ?>
                                            <span class="badge">{{Flexihelp::catname($skill->category,app()->getLocale())}}</span>
                                            <?php endif ?>
                                            @endforeach
                                            @if(count($gig->skills)>2)
                                            <span>+<?=count($gig->skills)-2?></span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="service-footer">
                                    <a href="{{route('gig_details',['id'=>$gig->id])}}">@lang('general.gig_view_more')</a>
                                    <!-- <a href="{{route('gig_details',['id'=>$gig->id])}}" data-toggle="modal">Apply</a> -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                            <!-- <p class="noresultfound">{{trans('general.noresult.'.Request::segment(2))}}</p> -->
							<div class="item text-center noResult">
								<img class="img-fluid my-0 mx-auto noResult-img" src="{{asset('images/no-result_'.app()->getlocale().'.png')}}">
							</div>
                        @endif
                    {{$gigs_pagination->links()}}
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
