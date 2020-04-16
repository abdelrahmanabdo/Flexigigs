<div class="side ">
    <div class="user">
        <div class="container pr-0">
            <div class="row d-flex flex-wrap flex-row w-100" style="overflow:hidden;">
				<div class="user-img col-lg-4 col-md-12 col-sm-12 p-0">
					<div class="user-img-container">
						<img class="" src="{{ Flexihelp::get_file($userdata->avatar,'user',20,$userdata->gender) }}">
					</div>
				</div>
                <div class="col-lg-8 col-md-12 col-sm-12 pr-0 pt-2">
                    <p>{{$userdata->first_name." ".$userdata->last_name}}</p>
                    <?=Flexihelp::get_stars('supplier',$userdata->id)?>
                    @if($userdata->supplier_type &&$userdata->supplier_type!=="null")
                    <p>{{trans('user.register_iam_'.strtolower($userdata->supplier_type))}}</p>
                    @endif
					<a href="{{route('switch',['customer','url'=>url()->current()])}}" class="btn btn-primary btn-sm text-capitalize py-1 px-3 my-3" style="font-size: 10px;">@lang('home.menu_take_me_to_hh')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center my-0">
        <p>{{$userdata->formatted_address}}</p>
    </div>
    <div class="d-flex justify-content-center">
        <p>@lang('general.personal_member_from') <?= Flexihelp::defult_date($userdata->created_at) ?></p>
    </div>
    @if (!Auth::guest())
        @if (Auth::user()->hasRole('admin'))
            @if($userdata->email)
                <div class="d-flex justify-content-center">
                    <p> <a href="mailto:{{$userdata->email}}">{{$userdata->email}}</a> </p>
                </div>
            @endif
            @if($userdata->phone)
                <div class="d-flex justify-content-center">
                    <p> <a href="tel:{{$userdata->phone}}">{{$userdata->phone}}</a> </p>
                </div>
            @endif
        @endif
    @endif
    <div class="d-flex justify-content-center">
        @if ($userdata->availability==0)
        <p>@lang('general.personal_available')</p>
        @elseif($userdata->availability==1)
        <p>@lang('general.personal_busy')</p>
        @elseif($userdata->availability==2)
        <p>@lang('general.personal_away')</p>
        @endif
    </div>
    <div class="d-flex justify-content-around my-0">
        <p style="flex: 1;"><span><?=($userdata->views)?$userdata->views:0?></span>@lang('general.personal_view_profile')</p>
		<p style="flex: 1;"><span>{{$total_services}}</span>@lang('general.personal_total_services')</p>
    </div>
    @if($userdata->facebook||$userdata->linkedin||$userdata->instagram||$userdata->twitter)
    <div class="d-flex justify-content-center social_container mb-5">
        @if ($userdata->facebook)
        <a href="{{$userdata->facebook}}" class="link-fb"><i class="icon-facebook"></i></a>
        @endif
        @if ($userdata->linkedin)
        <a href="{{$userdata->linkedin}}" class="link-in"><i class="icon-linkedin"></i></a>
        @endif
        @if ($userdata->instagram)
        <a href="{{$userdata->instagram}}" class="link-insta"><i class="icon-instagram"></i></a>
        @endif
        @if ($userdata->twitter)
        <a href="{{$userdata->twitter}}" class="link-in"><i class="icon-twitter"></i></a>
        @endif
    </div>
    @endif
    @if (Request::segment(3)=="dashboard"||Request::segment(2)=="application")
        <a href="{{route('supplier_profile',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_view_profile')</a>
        <a href="{{route('supplier_reviews',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_read_reviews')</a>
        @if (!Auth::user()->hasRole('admin'))
        <!-- <a href="{{route('switch',['customer','url'=>url()->current()])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_take_to_hh')</a> -->
        @endif
    @elseif (Request::segment(3)=="profile"||Request::segment(3)=="reviews")
        @if (Auth::check())
            @if (@Auth::user()->id == $userdata->id)
                @if(Request::segment(3)=="reviews")
                    <a href="{{route('supplier_profile',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_view_profile')</a>
                @else
                <a href="{{route('supplier_reviews',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_read_reviews')</a>
                    @if (!Auth::user()->hasRole('admin'))
                    <a href="{{route('gh_edit_profile')}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_edit_my_gh')</a>
                    @endif
                @endif
            @else
            <div class="d-flex justify-content-center actions_container">
                @if (Auth::check())
                <a href="#" style="width:90px" class="sendmessage" data-id_to="{{$userdata->id}}"><i class="icon-comment"></i> <small>@lang('general.button_message')</small></a>
                @endif
            </div>
            @endif
        @else
            @if(Request::segment(3)=="reviews")
            <a href="{{route('supplier_profile',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_view_profile')</a>
            @elseif(Request::segment(3)=="profile")
            <a href="{{route('supplier_reviews',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_read_reviews')</a>
            @endif
        @endif

    @endif
</div>