@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<section class="mb-0" id="service-order-confirm">
	<div class="container">
		<div class="row">
			<div class="text-center col-lg-12" id="confirmation-icon">
				<i class="fas fa-times fa-6x bg-danger text-white pl-4 pr-4 pt-3 pb-3 mt-lg-4 rounded-circle"></i>
			</div>
			<div class="text-center col-lg-12" id="confirmation-msg">
				<h1 class="text-primary text-uppercase font-weight-bold mt-5 mb-4">@lang('orders.applications.faild_confirm.msg')</h1>
				<p class="text-dark text-capitalize font-weight-light mt-4 mb-4 h4 w-100">@lang('orders.applications.faild_confirm.sub_msg')</p>
				<a href="{{url(app()->getLocale().'/application/checkout/'.$application->id)}}" class="text-primary text-capitalize mt-5">
					@lang('orders.applications.faild_confirm.try_again')
				</a>
			</div>
		</div>
	</div>
</section>
@endsection