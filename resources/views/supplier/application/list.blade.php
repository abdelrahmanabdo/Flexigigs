@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
@include('supplier.messages.parts.send')
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
            @include('supplier.application.search')
        </div>
        <div class="col-md-8">
            @include('supplier.parts.nav')
            <div class="tab-content mt-4" id="dashboardTabsContent">
				<p class="lato-bold text-capitalize mb-3 h4">@lang('general.dashboard_nav_my_application')</p>
                @if(count($applications))
                <div class="tab-pane fade show active" id="myApplication" role="tabpanel">
                    <div id="applicationsList" data-children=".item" class="mt-5">
                        @foreach($applications as $application)
                        <div class="item">
                            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#applicationsList" data-target="#app{{$application->id}}" aria-expanded="false">
                                <div class="item-info-collapsed row">
                                    <div class="col-6 col-md-4 col-lg-4 pr-0">
                                        <p class="font-weight-bold">{{$application->title}}</p>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <div class="user">
											<div class="user-img-sm ml-0">
													<div class="user-img-sm-container">
														<img src="{{Flexihelp::get_file($application->customer->avatar,'user',20,$application->customer->gender)}}">
													</div>
												</div>
                                            <div>
                                                <a class="user_name">
                                                    <p class="font-weight-bold">{{$application->customer->username}}</p>
                                                </a>
                                                <?=Flexihelp::get_stars('customer',$application->customer->id)?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 col-md-8 col-lg-3">
                                        <p class="font-weight-bold">@lang('gigs.single_applied_on') {{Flexihelp::defult_date($application->created_at)}}</p>
                                    </div>
                                    <i class="icon-angle-down col-2 col-md-2 col-lg-1 text-center"></i>
                                </div>
                                <div class="item-info">
                                    <div class="mr-auto">
                                        <h2 class="font-weight-bold">{{$application->title}}</h2>
                                    </div>
                                    <a href="#" class="sendmessage" data-id_to="{{$application->customer_id}}" style="text-decoration: none; cursor: pointer;">
                                        <h3 class="font-weight-bold text-primary text-capitalize mb-0">
                                            <b class="fas fa-comment"></b> @lang('gigs.dashboard_supplier_apps_message_hh')
                                        </h3>
                                    </a>
                                    <button class="btn btn-danger text-danger bg-white border-danger cancel-application" data-id="{{$application->id}}">@lang('gigs.dashboard_supplier_apps_cancel_app')</button>
                                    @include('parts.applications.cancel')
                                    <i class="icon-angle-down"></i>
                                </div>
                            </div>
                            <div id="app{{$application->id}}" class="item-content collapse" role="tabpanel">
                                <div class="row pt-5">
                                    <div class="col-12 col-lg-4">
                                        <div class="user">
											<div class="user-img-md ml-0">
													<div class="user-img-md-container">
														<img src="{{Flexihelp::get_file($application->customer->avatar,'user',20,$application->customer->gender)}}">
													</div>
												</div>
                                            <div>
                                                <a href="{{route('customer_profile',[$application->customer->username])}}" title="">
                                                    <p>{{$application->customer->username}}</p>
                                                </a>
                                                <?=Flexihelp::get_stars('customer',$application->customer->id)?>
                                            </div>
                                        </div>
                                        <div class="item-status">
                                            <div class="d-flex justify-content-between">
                                                <label class="font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.price')</label>
                                                <p class="font-weight-bold text-primary">{{number_format($application->price)}} @lang('general.gig_price_unit_EGP')</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <label class="font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.deadline')</label>
                                                <p>{{Flexihelp::defult_date($application->deadline)}}</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <label class="bold-label font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.skills')</label>
                                                <div class="d-flex flex-wrap">
                                                    @foreach($application->skills as $skill)
                                                    <span class="badge">{{Flexihelp::catname($skill->category,app()->getLocale())}}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="item-status">
                                            <div class="d-flex flex-wrap justify-content-between pt-0">
                                                <label class="font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.description')</label>
                                                <p class="lead">
                                                    {{$application->description}}
                                                </p>
                                            </div>
                                            @if($application->attach)
                                            <div class="d-flex flex-column">
                                                <label class="font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.attached_files')</label>
                                                <?php $i = 1; ?>
                                                @foreach($application->attach as $attach)
                                                <a href="{{Flexihelp::get_file($attach->filename)}}" target="blank" download>@lang('gigs.dashboard_supplier_apps_info.file_attached')-{{$i++}}</a>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="item-status">
                                            <div class="d-flex  flex-wrap justify-content-between pt-0">
                                                <label class="font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.gh_notes')</label>
                                                <p class="lead">
                                                    {{$application->notes}}
                                                </p>
                                            </div>
                                            <h6 class="mt-4 text-capitalize font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.applied_on') {{Flexihelp::defult_date($application->created_at)}}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-5">
                    {{$applications->links()}}
                    </div>
                </div>
                @else
                <div class="item text-center noResult">
					<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
				</div>
                @endif
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.sendmessage').click(function() {
            $('form#sendmessage #order_id').val('0');
            $('form#sendmessage #conflect').val('0');
            $('form#sendmessage #admin_id').val('0');
            $('form#sendmessage #id_from').val("{{$userdata->id}}");
            $('form#sendmessage #id_to').val($(this).data('id_to'));
            $('.message-modal').modal('show');
        });
    });
</script>
@endsection