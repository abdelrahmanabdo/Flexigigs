@extends('layouts.home')
@section('title', trans('home.menu_my_dashboard').' | '.trans('general.dashboard_nav_reviews'))
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_nav_reviews')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
            @include('admin.reviews.search')
        </div>
        <div class="col-md-8">
            @include('admin.parts.nav')
	            <div class="tab-content mt-4" id="dashboardTabsContent">
	                <div class="tab-pane fade show active" id="myReviews" role="tabpanel">
						<p class="lato-bold text-capitalize m-0 h4">@lang('general.dashboard_nav_reviews')</p>
                    	<div id="admin-reviews" class="mt-4">
                        	<div id="reviewsList" data-children=".item">
							@if(count($reviews))
								<div class="item">
									<div class="reviews p-0">
										@foreach($reviews as $review)
											@if($review->type == 1 && $review->user)
											<div class="review review-{{$review->id}}">
												<div class="row">
													<div class="header col-12">
														<div class="user">
															<div class="user-img-md m-0 mr-2">
																<div class="user-img-md-container">
																	<img src="{{Flexihelp::get_file($review->user->avatar,'user',20,$review->user->gender)}}">
																</div>
															</div>
															<div>
																<h3 class="m-0 font-weight-bold">{{$review->user->username}} (@lang('general.hh')) <small>@lang('general.reviewd')</small> {{$review->supplier->username}} (@lang('general.gh'))</h3>
																<h6 class="m-0 font-weight-bold">@lang('reviews.order_id') : #{{$review->order_id}} <br> @lang('reviews.date'): {{Flexihelp::defult_date($review->created_at)}}</h6>
																<p class="m-0 font-weight-light">{{($review->order->type==1)?trans('general.service').' : '.$review->service->name: trans('general.gig').' : '.$review->gig->title}}</p>
															</div>
														</div>
														<?=Flexihelp::get_stars('review',$review->rate)?>
													</div>
													<div class="col-12 mt-2">
														<div class="row d-flex flex-row justify-content-between">
															<p class="text-secondary font-weight-light pr-0 col-11 pl-4" style="font-size:1rem;">{{$review->comment}}</p>
															<b class="fas fa-trash fa-lg col-1 text-center text-secondary pt-4 del-review" data-id="{{$review->id}}"></b>
														</div>
													</div>
												</div>
											</div>
											@elseif($review->type == 2 && $review->supplier)
											<div class="review review-{{$review->id}}">
												<div class="row">
													<div class="header col-12">
														<div class="user">
															<div class="user-img-md m-0 mr-2">
																<div class="user-img-md-container">
																	<img src="{{Flexihelp::get_file($review->supplier->avatar,'user',20,$review->supplier->gender)}}">
																</div>
															</div>
															<div>
																<h3 class="m-0 font-weight-bold">{{$review->supplier->username}}(@lang('general.gh'))  <small>@lang('general.reviewd')</small> {{$review->user->username}} (@lang('general.hh'))</h3>
																<h6 class="m-0 font-weight-bold">@lang('reviews.order_id') : #{{$review->order_id}} <br> @lang('reviews.date'): {{Flexihelp::defult_date($review->created_at)}}</h6>
																<p class="m-0 font-weight-light">{{($review->order->type==1)?trans('general.service').' : '.$review->order->request->name:trans('general.gig').' : '.$review->order->application->title}}</p>
															</div>
														</div>
														<?=Flexihelp::get_stars('review',$review->rate)?>
													</div>
													<div class="col-12 mt-2">
														<div class="row d-flex flex-row justify-content-between">
															<p class="text-secondary font-weight-light pr-0 col-11 pl-4" style="font-size:1rem;">{{$review->comment}}</p>
															<b class="fas fa-trash fa-lg col-1 text-center text-secondary pt-4 del-review" data-id="{{$review->id}}"></b>
														</div>
													</div>
												</div>
											</div>
											@endif
										@endforeach
									</div>
								</div>
								<div class="row mt-4">
		                        {{$reviews->links()}}
		                        </div>
		                    @else
			               <div class="item text-center noResult">
								<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
							</div>
			                @endif
                    	</div>
                	</div>
	            </div>
	        </div>  
        </div>
    </div>
</section>
@include('admin.reviews.delete')
@endsection