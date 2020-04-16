@extends('layouts.home')
@section('title', 'home')
@section('bodyClass', ' ')
@section('content')
        <section class="slider">
            <div class="owl-carousel swiper-container" style="z-index:-1;">
                <!-- Slides -->
                <div class="swiper-slide" style="background-image:url('images/slider.jpg')">
                    <div class="slide-text">
                        <h1>@lang('home.carousel_title_1')<small>@lang('home.carousel_small_title_1')</small></h1>
                    </div>
                </div>
                <div class="swiper-slide" style="background-image:url('images/slider.jpg')">
                    <div class="slide-text">
                        <h1>@lang('home.carousel_title_2')<small>@lang('home.carousel_small_title_2')</small></h1>
                    </div>
                </div>
            </div>
            @include('parts.search')
            <a href="#categories" title="" class="scroll-bottom d-none d-md-flex" style="z-index:0;">
              @lang('home.carousel_view_cat') <i class="icon-angle-down"></i>
            </a>
        </section>
        <section id="categories" class="container">
			<nav>
				<div class="nav nav-tabs pb-5" id="categories-toggle" role="tablist">
					<a class="nav-item nav-link active" id="nav-services-tab" data-toggle="tab" href="#nav-services" role="tab" aria-controls="nav-services" aria-selected="true">@lang('home.services')</a>
					<a class="nav-item nav-link" id="nav-gigs-tab" data-toggle="tab" href="#nav-gigs" role="tab" aria-controls="nav-gigs" aria-selected="false">@lang('home.gigs')</a>
				</div>
			</nav>
            <div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-services" role="tabpanel" aria-labelledby="nav-services-tab">
					<div class="section-title">
						<h2>@lang('home.categories_title')</h2>
						<a href="{{route('service_categories')}}" title="View All Categories">@lang('home.all_service_category')</a>
					</div>
					<div class="row d-flex">
						<?php foreach ($categories as $cat): ?>
						<div class="col-md-4 col-sm-6">
							<a href="{{route('service_subcategory',['category'=>$cat->slug])}}" class="category-thumb" title="{{$cat->name}}" style="background-image: url('{{Flexihelp::get_file($cat->image,null,'20')}}');">
								<div class="title">
									<i class="{{$cat->icon}}"></i>
									<h3>{{(app()->getLocale()=='ar'&&$cat['name_ar'])?$cat->name_ar:$cat->name}}</h3>
								</div>
								<div class="desc">
									<p>{{(app()->getLocale()=='ar'&&$cat->intro_ar)?Str::words($cat->intro_ar,10):Str::words($cat->intro,10)}}</p>
								</div>
							</a>
						</div>
						<?php endforeach ?>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-gigs" role="tabpanel" aria-labelledby="nav-gigs-tab">
					<div class="section-title">
						<h2>@lang('home.categories_title')</h2>
						<a href="{{route('gigs_categories')}}" title="View All Categories">@lang('home.all_gig_category')</a>
					</div>
					<div class="row d-flex">
						<?php foreach ($categories as $cat): ?>
						<div class="col-md-4 col-sm-6">
							<a href="{{route('gig_subcategory',['category'=>$cat->slug])}}" class="category-thumb" title="{{$cat->name}}" style="background-image: url('{{Flexihelp::get_file($cat->image,null,'20')}}');">
								<div class="title">
									<i class="{{$cat->icon}}"></i>
									<h3>{{(app()->getLocale()=='ar'&&$cat['name_ar'])?$cat->name_ar:$cat->name}}</h3>
								</div>
								<div class="desc">
									<p>{{(app()->getLocale()=='ar'&&$cat->intro_ar)?Str::words($cat->intro_ar,10):Str::words($cat->intro,10)}}</p>
								</div>
							</a>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
        </section>

        <section id="latestServices" class="d-flex align-items-center justify-content-center">
            <div class="container">
                @if(sizeof($services))
                <div class="row">
                    <div class="col-12 section-title">
                        <h2 class="float-left text-uppercase">@lang('home.latest_services')</h2>
                        <a href="{{route('service_categories')}}" class="float-right" title="View All services">@lang('home.view_all_services')</a>
                    </div>
                    <div class="col-12 d-flex p-0" style="overflow-x: auto;">
                        @foreach($services as $service)
                        @include('parts.service.small')
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </section>
        <section id="gigs">
            <div class="container">
                @if(sizeof($gigs))
                <div class="row section-title">
                    <h2 class="float-left">@lang('home.latest_gig_title')</h2>
                    <a href="{{route('gigs_categories')}}" class="float-right" title="View All Categories">@lang('home.latest_gig_view_all')</a>
                </div>
                <div class="row d-flex flex-row align-items-stretch justify-content-start" id="gigs-cards">
                    @foreach($gigs as $gig)
                    <div class="col-md-4 col-sm-12 service-thumb d-flex flex-column justify-content-around">
                        <div class="service-thumb-head">
                            <a href="{{route('gig_details',['id'=>$gig->id])}}">
                                <h3 class="text-capitalize">{{$gig->title}}</h3>
                                <span class="text-primary">{{number_format($gig->price)}} @lang('general.gig_price_unit_EGP')</span>
                                <p>@lang('home.latest_gig_single_submitted') {{Flexihelp::defult_date($gig->created_at)}}</p>
                                <p>@lang('home.latest_gig_single_dead_line') {{Flexihelp::defult_date($gig->deadline)}}</p> 
                            </a>  
                        </div>
                        <div class="service-thumb-body">
                            <p>{{$gig->description}}</p>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                var $desc = $('.service-thumb-body p');
                                var $title= $('.service-thumb-head a h3');
                                $desc.each(function(){
                                    var $descArr = $(this).text().split(" ").slice(0, 40).join(' ');
                                    $(this).text($descArr + "...");
                                });
                                $title.each(function(){
                                    var $titleArr = $(this).text().split(" ").slice(0, 6).join(' ');
                                    $(this).text($titleArr);
                                });
                            });
                        </script>
                        <div class="service-thumb-footer">
                            <h5>@lang('general.gig_skills')</h5>
                            <div class="button-group d-flex flex-row align-items-start flex-wrap justify-content-start">
                                <?php $i = 0 ?>
                                @foreach($gig->skills as $skill)
                                <?php 
                                $i++;
                                if ($i<3): ?>
                                <button type="button" class="btn btn-primary btn-sm">{{Flexihelp::catname($skill->category,app()->getLocale())}}</button>
                                <?php endif ?>
                                @endforeach
                                @if(count($gig->skills)>3)
                                <!-- <span>+<?=count($gig->skills)-2?></span> -->
                                <button type="button" class="btn btn-sm btn-link">+<?=count($gig->skills)-2?></button>
                                @endif
                            </div>
                            <a href="{{route('gig_details',['id'=>$gig->id])}}" class="text-primary">@lang('general.gig_view_more')</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
        <section id="how-it-works">
            <div class="container">
                <div class="row">
                    <div class="how__it__works">
                        <div class="how__it__works-title">
                            <h1 class="text-capitalize">@lang('home.how_it_works_title')</h1>
                        </div>
                        <div class="how__it__works-play d-flex flex-row align-items-center justify-content-between w-75 h-25">
                            <a href="#" data-toggle="modal" data-target="#videoGig">
                                <h3><i class="icon-play"></i>@lang('home.how_it_works_for_gig')</h3>
                            </a>
							<a href="#" data-toggle="modal" data-target="#videoHead">
                                <h3><i class="icon-play"></i>@lang('home.how_it_works_for_head')</h3>
                            </a>
                            <!-- Modals -->
                            <div class="modal fade fade bd-example-modal-lg howItWorks" id="videoGig" tabindex="-1" role="dialog" aria-labelledby="videoGigLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe width="100%" height="400" src="{{$howitwork['for_gh']}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                            <!-- <video id="modal-video" class="modalVideo" src="https://www.youtube.com/embed/5GH0E12HVS8" controls></video> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade fade bd-example-modal-lg howItWorks" id="videoHead" tabindex="-1" role="dialog" aria-labelledby="videoHeadLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe width="100%" height="400" src="{{$howitwork['for_hh']}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                            <!-- <video id="modal-video" class="modalVideo" src="{{url('videos/How-it-works-for-HH.mp4')}}" controls></video> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                // pausing video after closing the modal container
                                (function(){
                                    $('.howItWorks').each(function(){
										$(this).on('hidden.bs.modal', function (e) {
											// $(this).find('.modalVideo').get(0).pause();
											var src = $(this).find('iframe').attr("src");
											$(this).find('iframe').attr('src', src);
										});
									});
                                })();
                            
                            </script>
                        </div>
                        <div class="how__it__works-button">
                            <a href="{{route('how-it-work')}}"><button type="button" class="btn btn-outline-primary btn-lg">@lang('home.how_it_works_know_more')</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="gig-services">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 d-flex flex-column justify-content-between px-5" style="min-height: 20rem;">
                        <h2>@lang('user.register_post_gig')</h2>
                        <p>@lang('user.register_post_gig_content')</p>
                        @if (!Auth::check())
                            <a href="#registerPostagigModal" class="btn btn-primary" data-toggle="modal">@lang('user.register_headhunter')</a>
                        @else
                            <a href="{{route('customer_posts')}}" class="btn btn-primary">@lang('user.register_post_gig')</a>
                        @endif
                    </div>
                    <div class="col-sm-12 offset-sm-12 col-md-12 col-lg-4 d-flex flex-column justify-content-between px-5 offset-lg-4" style="min-height: 20rem;">
                        <h2>@lang('user.register_find_gig')</h2>
                        <p>@lang('user.register_find_gig_content')</p>
                        @if (!Auth::check())
                        <a href="#registerFindagigModal" class="btn btn-primary" data-toggle="modal">@lang('user.register_gighunter')</a>
                        @else
                            <a href="{{route('gigs_categories')}}" class="btn btn-primary">@lang('user.register_find_gig')</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section class="app">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 col-6  mobile">
                        <img src="{{asset('images/mobile.png')}}">
                        <h1>@lang('home.stay_connected_title')</h1>
                    </div>
                    <div class="col-lg-4  col-sm-12 col-6 content">
                        <p>@lang('home.stay_connected_content')</p>
                        <img src="{{asset('images/play-store.png')}}">
                        <img src="{{asset('images/app-store.png')}}">
                    </div>
                    <!-- <div class="col-lg-10 offset-lg-1"> -->
                    <!-- </div> -->
                </div>
            </div>
        </section>
        <section class="explore">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 d-flex flex-column justify-content-center">
                        <h1 class="text-capitalize">@lang('home.explore_title')</h1>
                        <a href="{{route('service_categories')}}" class="btn btn-primary text-uppercase">@lang('home.explore_more')</a>
                    </div>
                </div>
            </div>
        </section>

@endsection
