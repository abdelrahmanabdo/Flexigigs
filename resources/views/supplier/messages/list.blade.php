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
				<h1 class="text-uppercase text-primary m-0 text-left">gighunter dashboard</h1>
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
			@include('supplier.parts.sidecard')
			<div class="filter" style="position: relative;">
				<h2>@lang('general.filter_title')</h2>
				<form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
					<button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
					<div class="form-group">
						<label class="text-hide" for="searchFilter">search filter</label>
						<span>
							<input name="free_text" placeholder="Search" value="" class="form-control" type="text">
						</span>
					</div>
					<label class="form-group has-float-label mt-5 mb-0">
						<input type="text" name="from" value="" placeholder="@lang('messages.from')" class="form-control border-0">
						<span for="searchFilter">@lang('messages.from')</span>
						<i class="fas fa-search filter-search-input-icon"></i>
					</label>
					<hr>
					<button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
				</form>
			</div>
        </div>
        <div class="col-md-8">
            @include('supplier.parts.nav')
            
        </div>
    </div>
</section>
@endsection