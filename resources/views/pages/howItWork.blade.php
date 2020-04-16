@extends('layouts.home')
@section('title', trans('staticpages.hiw.title'))
@section('bodyClass', 'site-wrap inner bg-white')
@section('content')
  <div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">{{trans('general.home')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{trans('staticpages.hiw.title')}}</li>
        </ol>
    </nav>
    <section class="container how-it-works">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-center">{{trans('staticpages.hiw.title')}}</h1>
        </div>
        <div class="col-md-6">
          <h2 class="text-center">{{trans('staticpages.hiw.as_headhunter')}}</h2>

			<div class="video-wrapper w-100">
				<!-- <video class="video"  poster="{{asset('images/headhunter-thumbinal.png')}}">
					<source src="{{url($howitwork['for_hh'])}}" type="video/mp4" >
					Your browser does not support the video tag.
				</video>-->
				<iframe width="100%" height="400" src="{{$howitwork['for_hh']}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				<!-- <div class="playpause">
					<div class="fas fa-play"></div>
				</div> -->
			</div>
        </div>
        <div class="col-md-6">
           <h2 class="text-center">{{trans('staticpages.hiw.as_gighunter')}}</h2>
          <div class="video-wrapper w-100">
			<!-- <video class="video" poster="{{asset('images/gighunter-thumbinal.png')}}">
				<source src="{{url($howitwork['for_gh'])}}" type="video/mp4">
				Your browser does not support the video tag.
			</video> -->
			<iframe width="100%" height="400" src="{{$howitwork['for_gh']}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			<!-- <div class="playpause">
					<div class="fas fa-play"></div>
				</div> -->
		  </div>
        </div>
      </div>
	</section>
	<script>
		(function(){
			
			$('.video-wrapper').click(function () {
				// if($(this).children(".video").get(0).paused){
				// 	$(this).children(".video").get(0).play();
				// 	$(this).children(".playpause").fadeOut();
				// }else{
				// 	$(this).children(".video").get(0).pause();
				// 	$(this).children(".playpause").fadeIn();
				// }
				// $(this).find(".playpause").fadeOut();
				$(this).find("iframe").play();
			});
		})();
	</script>
  </div>
       
@endsection
