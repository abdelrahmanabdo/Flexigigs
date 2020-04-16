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
			<div class="filter position-relative">
				<h2>@lang('general.filter_title')</h2>
				<form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
					<button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
					<label class="form-group has-float-label mt-5 mb-0">
						<input type="text" name="search" value="" placeholder="@lang('general.filter_search')" class="form-control border-0">
						<span for="searchFilter">@lang('general.filter_search')</span>
						<i class="fas fa-search filter-search-input-icon"></i>			
					</label>
					<hr>
					<label class="form-group has-float-label mt-5 mb-0">
						<input type="text" name="from" value="" placeholder="@lang('general.filter_deadline_range_from')" class="form-control border-0">
						<span for="searchFilter">@lang('general.filter_deadline_range_from')</span>
						<i class="fas fa-search filter-search-input-icon"></i>			
					</label>
					<hr>
					<button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
				</form>
			</div>
            
        </div>
        <div class="col-md-8">
            @include('customer.parts.nav')
            <div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="searchMessages" role="tabpanel">
					<div class="container">
						<div class="row">
							<div class="item col-12 py-3 my-3 searchMessages-single">
								<a href="#"></a>
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-2 col-md-1  text-center">
												<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
											</div>
											<div class="col-10 col-md-11 pl-0">
												<div class="d-flex align-items-center justify-content-between">
													<h4 class="text-capitalize">username</h4>
													<h5>12-11-2017</h5>
												</div>
												<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item col-12 py-3 my-3 searchMessages-single">
								<a href="#"></a>
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-2 col-md-1  text-center">
												<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
											</div>
											<div class="col-10 col-md-11 pl-0">
												<div class="d-flex align-items-center justify-content-between">
													<h4 class="text-capitalize">username</h4>
													<h5>12-11-2017</h5>
												</div>
												<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</section>
@endsection