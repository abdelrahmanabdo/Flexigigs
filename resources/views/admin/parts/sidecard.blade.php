<?php $userdata = Auth::user();?>
<div class="side">
    <div class="container">
        <div class="row">
            <div class="user d-flex flex-row flex-wrap w-100" style="overflow: hidden;">
                <div class="user-img col-lg-4 col-md-12 col-sm-12 p-0">
					<div class="user-img-container">
						<img class="" src="{{ Flexihelp::get_file($userdata->avatar,'user',20,$userdata->gender) }}">
					</div>
				</div>
				<div class="col-lg-8 col-md-12 col-sm-12 d-flex flex-column pr-0">
					<p>{{$userdata->first_name}} {{$userdata->last_name}}</p>
					<a href="{{route('admin_profile')}}" class="text-primary text-uppercase font-weight-regular h5 mt-2">@lang('general.dashboard_edit_profile')</a>
				</div>
            </div>
		</div>
        @if(@$counter_title)
		<div class="row mt-4">
			<div class="col-12 d-flex flex-column justify-content-between total_num">
				<h4 class="h4 text-black font-weight-regular text-capitalize">@lang('general.dashboard_total_number') <span>{{trans_choice('general.dashboard_total_number_counter', @$counter_title ,['counter_title' => @$counter_title])}}</span></h4>
				<h5 class="h5 font-weight-regular text-black text-capitalize">{{@$counter}} <span>{{@$counter_title}}</span></h5>
			</div>
		</div>
        @endif
    </div>
</div>