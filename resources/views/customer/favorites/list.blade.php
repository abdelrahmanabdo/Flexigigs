@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-6">
				<h1 class="text-uppercase text-primary m-0 text-left">headhunter dashboard</h1>
			</div>
			<div class="col-6">
				<nav aria-label="breadcrumb" role="navigation">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
						<li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('customer.parts.sidecard')
        </div>
        <div class="col-md-8">
            @include('customer.parts.nav')
			<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_favorites')</p>
            @if (count($favorites))
            <div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="favorites" role="tabpanel">
                    <div class="row pt-4">
                        @foreach ($favorites as $favorite)
                        <?php $service = $favorite->service; ?>
                            @if(@$service->category_id)
                            @include('parts.service.small')
                            @endif
                        @endforeach
                        @include('parts.service.remove_favorite')
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                {{$favorites->links()}}
            </div>
            @else
            <div class="item text-center noResult">
				<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
			</div>
            @endif
        </div>
    </div>
</section>
@endsection