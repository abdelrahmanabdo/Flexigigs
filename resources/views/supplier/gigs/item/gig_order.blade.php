<div class="item">
    <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#gigsList" data-target="#gig{{$gig->id}}" aria-expanded="false">
        <div class="item-info-collapsed">
            <div class="row w-100 align-items-center justify-content-between">
				<div class="col-3 d-flex justify-content-start align-items-center">
					<span>#{{$gig->id}}</span>
					<span class="ml-4">{{$gig->application->title}}</span>
				</div>
				<div class="col-2 d-flex flex-row justify-content-start">
					<div class="user">
						<div class="user-img-sm ml-0 mr-2">
								<div class="user-img-sm-container">
									<img src="{{Flexihelp::get_file($gig->customer->avatar,'user',20,$gig->customer->gender)}}">
								</div>
							</div>
						<div>
							<p class="font-weight-bold">{{$gig->customer->username}}</p>
							<p class="font-weight-bold text-center">@lang('general.hh')</p>
						</div>
					</div>
				</div>
				<div class="col-2 d-flex justify-content-center">
					<p>@lang('gigs.dashboard_supplier_gigs_gig_info.date_requested') {{Flexihelp::defult_date($gig->created_at)}}</p>
				</div>
				<div class="col-3 d-flex justify-content-start">
					<p>{{$gig->order_status}}</p>
				</div>
				<div class="col-2 d-flex flex-row justify-content-between align-items-center">
					<span class="text-primary font-weight-bold mr-4">{{number_format($gig->application->price)}} @lang('general.gig_price_unit_EGP')</span>
					<i class="icon-angle-down"></i>
				</div>
			</div>
        </div>
        <div class="item-info">
            <div class="row w-100 align-items-center">
				<div class="mr-auto col-6">
					<h2>{{$gig->application->title}}</h2>
					<p>Request #{{$gig->id}}</p>
				</div>
				<div class="col-6">
					<div class="row align-items-center">
                        @if($gig->status>=2 && $gig->status < 4)
                        <a href="#" data-order_id="{{$gig->id}}" class="reportconflect col-4">@lang('general.button_report_conflict')</a>
						@endif
                        @if($gig->status==2)
                            @if($gig->cus_review)
                            <button class="btn btn-default btn-done gig{{$gig->id}} col-4" data-status="3" data-id="{{$gig->id}}" data-title="@lang('gigs.dashboard_supplier_gigs_done_confirmation')" data-desc="@lang('gigs.dashboard_supplier_gigs_done_msg')" data-message-title="@lang('gigs.dashboard_supplier_gigs_done_success')" data-message-desc="@lang('gigs.dashboard_supplier_gigs_done_success_msg')">@lang('general.button_done')</button>
                            @else
                            <button class="btn btn-default cant-say-done col-4">@lang('general.button_done')</button>
                            @endif
						@endif
						<i class="icon-angle-down col"></i>
					</div>
				</div>
			</div>
        </div>
    </div>
    <div id="gig{{$gig->id}}" class="item-content collapse" role="tabpanel">
        @if($gig->order_ghmessage)
        <div class="col-12 alert alert-dark" role="alert">
          {{$gig->order_ghmessage}}
        </div>
        @endif
        <div class="row pt-5">
            <div class="col-md-4">
                <div class="user">
					<div class="user-img-md ml-0 mr-2">
						<div class="user-img-md-container">
							<img src="{{Flexihelp::get_file($gig->customer->avatar,'user',20,$gig->customer->gender)}}">
						</div>
					</div>
                    <div>
                        <a href="{{route('customer_profile',$gig->customer->username)}}" title="">
                            <p>{{$gig->customer->username}}</p>
                        </a>
                        <?=Flexihelp::get_stars('customer',$gig->customer->id)?>
                    </div>
                </div>
                <div class="item-status">
                    <div class="d-flex justify-content-between">
                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.price')</label>
                        <p class="font-weight-bold text-primary">{{number_format($gig->application->price)}} @lang('general.gig_price_unit_EGP')</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.date_requested')</label>
                        <p>{{Flexihelp::defult_date($gig->created_at)}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.deadline')</label>
                        <p>{{Flexihelp::defult_date($gig->delivery_at)}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.status.title')</label>
                        <p> {{$gig->order_status}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="item-requirment">
                    <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.description')</label>
                    <p>{{$gig->application->description}}</p>
                </div>
            </div>
            <div class="col-md-4">
                @include('reviews.form')
            </div>
        </div>
    </div>
</div>