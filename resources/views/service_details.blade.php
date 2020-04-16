@extends('layouts.home')
@section('title', $service->name)
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
@include('parts.notavilable_modal')
    <style>
    .service-portfolio .owl-carousel .owl-stage .owl-item img {
        width: auto !important;
        height: 400px !important;
        margin: 0 auto !important;
    }
    .owl-carousel.owl-drag .owl-item {
        background: #efefef !important;
    }
    .st-btn{
        display: inline-block!important;
    }
    </style>
     <div class="page-header">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
                @if ($parent_slug)
                <li class="breadcrumb-item"><a href="{{route('service_subcategory',['category'=>$parent_slug['slug']])}}">{{(app()->getLocale()=='ar'&&$parent_slug['name_ar'])?$parent_slug['name_ar']:$parent_slug['name']}}</a></li>
                @endif
                @if ($category->id != $sub_slug['id'])
                <li class="breadcrumb-item"><a href="{{route('service_subcategory2',['category'=>$parent_slug['slug'],'slug'=>$sub_slug['slug']])}}">{{(app()->getLocale()=='ar'&&$sub_slug['name_ar'])?$sub_slug['name_ar']:$sub_slug['name']}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('service_subcategory2',['parentcategory'=>$parent_slug['slug'],'category'=>$sub_slug['slug'],'slug'=>$category->slug])}}">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</a></li>
                @else
                <li class="breadcrumb-item"><a href="{{route('service_subcategory2',['category'=>$parent_slug['slug'],'slug'=>$category->slug])}}">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{$service->name}}</li>
            </ol>
        </nav>
        <h1>{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</h1>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-md-8">
				<div class="service-single">
					<div class="service-header">
						<h2 class="service-title">{{$service->name}}<small>{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}} - {{(app()->getLocale()=='ar'&&$parent_slug['name_ar'])?$parent_slug['name_ar']:$parent_slug['name']}}</small></h2>
						<div class="price">
							<p>{{number_format($service->price_per_unit)}} @lang('general.service_price_unit_EGP')</p>
							<small>@lang('general.service_price_unit_per') {{trans('general.service_'.$service->price_unit)}}</small>
						</div>
					</div>
				</div>
                <div class="service-single">
                    <div class="service-supplier">
                        <div class="user">
                            <a href="{{route('supplier_profile',['username'=>$user->username])}}" title="">
								<div class="user-img-md m-0 mr-2">
									<div class="user-img-md-container">
										<img src="{{Flexihelp::get_file($user->avatar,'user',20,$user->gender)}}">
									</div>
								</div>
                            </a>
                            <div>
                                <p><a href="{{route('supplier_profile',['username'=>$user->username])}}" title="">{{$user->username}}</a></p>
                                <?=Flexihelp::get_stars('review',$service->rate)?>
                                <span class="badge">{{count($service->requests_done)}} @lang('general.service_request_done')</span>
                            </div>
                        </div>
                        <div class="service-footer">
                            @if (Auth::check())
                                @if(Auth::user()->id!=$user->id&&!Auth::user()->hasRole('admin'))
                                    @if(session('member_type')===1)
                                        @if (count(DB::table('favorites')->where(['service_id'=>$service->id,'user_id'=>Auth::user()->id])->get()))
                                        <a href="#" class="deletefavorite" data-id="{{$service->id}}"><i class="icon-heart"></i>@lang('general.button_delete')</a> 
                                        @else
                                        <a href="#" class="addtofavorite" data-id="{{$service->id}}"><i class="icon-heart"></i>@lang('general.button_favorites')</a> 
                                        @endif
                                    @endif
    							@endif
                            @endif
                            <a  data-toggle="modal" data-target="#sheremodal" href="#"><i class="icon-share"></i>@lang('general.button_share')</a>
                            @if (Auth::check())
                            @if(Auth::user()->id!=$user->id)
                            <a href="#" class="sendmessage" data-id_to="{{$service->supplier_id}}"><i class="icon-comment"></i>@lang('general.button_message')</a>
                            @endif
                            @endif
                        </div>
                        <div class="modal fade" id="sheremodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content bg-white">
                              <div class="modal-header">
                                <h5 class="modal-title text-primary" id="exampleModalLabel">@lang('general.button_share')</h5>
                                <button type="button" class="close text-primary" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="sharethis-inline-share-buttons"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    @if (count($services_photo)||count($services_veds))
                    <div class="service-portfolio">
                        <div class="owl-carousel">
                            @foreach ($services_photo as $pic)
                            <div>
                                <img src="{{Flexihelp::get_file($pic->filename,'service',60)}}">
                            </div>
                            @endforeach
                            @foreach ($services_veds as $vid)
                            @if (filter_var($vid->url, FILTER_VALIDATE_URL))
                            <div>
                                <a class="owl-video" href="{{$vid->url}}"></a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @if(count($reviews))
                <div class="reviews">
                    <div class="header">
                        <h3>@lang('general.reviews_title')</h3>
                        <select class="form-control alt sort-DropDown sorter">
                            <option value="">@lang('general.sort_title')</option>
                            <option value="rate_asc" {{(@$_GET['sort_by']=="rate_asc")?"selected":""}}>@lang('general.sort_option_rating_ASC')</option>
                            <option value="rate_desc" {{(@$_GET['sort_by']=="rate_desc")?"selected":""}}>@lang('general.sort_option_rating_DESC')</option>
                            <option value="created_asc" {{(@$_GET['sort_by']=="created_asc")?"selected":""}}>@lang('general.sort_option_created_ASC')</option>
                            <option value="created_desc" {{(@$_GET['sort_by']=="created_desc")?"selected":""}}>@lang('general.sort_option_created_DESC')</option>
						</select>
                    </div>
                    @foreach($reviews as $review)
                    <div class="review">
                        <div class="header">
                            <div class="user">
                                <img src="{{Flexihelp::get_file($review->user->avatar,'user',20,$review->user->gender)}}">
                                <div>
                                    <p>{{$review->user->username}}</p>
                                </div>
                            </div>
                            <?=Flexihelp::get_stars('review',$review->rate)?>
                        </div>
                        <p>{{$review->comment}}</p>
                    </div>
                    @endforeach
                </div>
                {{$reviews->links()}}
                @endif
            </div>
            <div class="col-md-4">
                <div class="side">
                    <h2>@lang('general.disc_title')</h2>
                    <p class="side-scroll"><?=nl2br($service->description)?></p>
                    <div class="d-flex justify-content-between">
                        @if ($service->price_unit == "hour")
                        <p>@lang('general.service_hours_to_delever')</p>
                        @else
                        <p>@lang('general.service_days_to_delever')</p>
                        @endif
                        <p>{{$service->days_to_deliver}} @if ($service->price_unit == "hour") @lang('general.service_hours') @else @lang('general.service_days') @endif </p>
                    </div>
                    @if(Auth::check())
                        @if($user->id!==Auth::user()->id)
                            @if(session('member_type') === 1)
                                @if($user->availability!=0)
                                <a href="#noGigHunter" title="request" data-toggle="modal" class="btn btn-primary btn-block">@lang('general.button_request')</a>
                                @else
                                <a href="{{route('request',[$service->id])}}" title="request" class="btn btn-primary btn-block">@lang('general.button_request')</a>
                                @endif
                            @else
                                <h5 class="font-weight-bold">@lang('general.service_switch_to_hh')</h5>
                                <a class="btn btn-primary btn-block " href="{{route('switch',['customer','url'=>url()->current()])}}">@lang('general.button_switch_now')</a>
                            @endif
                        @else
                            <a class="btn btn-primary btn-block " href="{{route('supplier_services')}}">@lang('general.button_edit_service')</a>
                        @endif
                    @else
                        <h5 class="font-weight-bold text-center">@lang('general.button_login_to_request')</h5>
                        <button class="btn btn-primary btn-block text-capitalize" data-toggle="modal" data-target="#loginModal">@lang('home.login_title')</button>
                    @endif
                </div>
                <div class="side">
                    <h2>@lang('general.service_terms_conditions')</h2>
                    <p class="side-scroll"><?=$service->terms_handle?></p>
                    <a href="{{route('terms')}}">@lang('general.button_view_terms_conditions')</a>
                </div>
            </div>
        </div>
    </section>
    @if(session('member_type')===1)
    @include('parts.service.add_favorite')
    @include('parts.service.remove_favorite')
    @endif
    @if (Auth::check())
        @include('parts.messages.send')
    @endif
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
