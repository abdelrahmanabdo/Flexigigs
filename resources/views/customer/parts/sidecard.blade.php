<div class="side">
    <div class="user">
        <div class="container p-0">
            <div class="row d-flex flex-row flex-wrap w-100 pl-4" style="overflow:hidden;">
				<div class="user-img col-lg-4 col-md-12 col-sm-12 p-0">
					<div class="user-img-container">
						<img src="{{ Flexihelp::get_file($userdata->avatar,'user',20,$userdata->gender) }}">
					</div>
				</div>
                <div class="col-lg-8 col-md-12 col-sm-12 pr-lg-0  pt-lg-2 ">
                    <p>{{$userdata->first_name." ".$userdata->last_name}}</p>
                    <?=Flexihelp::get_stars('customer',$userdata->id)?>
                    @if (Route::has('login'))
                        @if (@Auth::user()->id == $userdata->id)
                            @if (!Auth::user()->hasRole('admin'))
					        <a href="{{route('switch',['supplier','url'=>url()->current()])}}" class="btn btn-primary btn-sm text-capitalize py-1 px-3 mt-3" style="font-size: 10px;">@lang('general.button_take_to_gh')</a>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($userdata->company_name)
   <div class="d-flex justify-content-between">
        <label>@lang('general.personal_company_name')</label>
        <?=(filter_var($userdata->site_url, FILTER_VALIDATE_URL))?"<a href='".$userdata->site_url."'>".$userdata->company_name."</a>":$userdata->company_name?>
    </div>
    @endif
    <div class="d-flex justify-content-center mb-0">
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
    <div class="d-flex justify-content-around my-3">
        <p style="flex: 1;"><span>{{$userdata->views}}</span>@lang('general.personal_view_profile')</p>
		<p style="flex: 1;"><span>{{$total_gig}}</span>@lang('general.personal_total_gig_posted')</p>
		<p style="flex: 1;"><span>

            
            @if(isset($followers->followers))
                {{count($followers->followers)}}
            @endif
    </span> @lang('general.personal_total_followers')</p>
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
    @if (Request::segment(3)=="dashboard")
        <a href="{{route('customer_profile',['username'=>$userdata->username])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_read_reviews')</a>
        @if (!Auth::user()->hasRole('admin'))
        <a href="{{route('hh_edit_profile',['redirect_to'=>Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_edit_my_hh')</a>
        @endif
    @elseif (Request::segment(3)=="reviews")
        @if (Route::has('login'))
            @if (@Auth::user()->id == $userdata->id)
                @if (!Auth::user()->hasRole('admin'))
                <a href="{{route('hh_edit_profile',['redirect_to'=>Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)])}}" class="btn btn-default btn-block mt-4 text-uppercase">@lang('general.button_edit_my_hh')</a>
                @endif
            @else
            <div class="d-flex justify-content-between actions_container">
                @if (Auth::check())
                <a href="#" class="sendmessage text-primary lato-regular" style="font-size: 2rem !important;" data-id_to="{{$userdata->id}}"><i class="icon-comment"></i> <small>@lang('general.button_message')</small></a>

                @if(!$isFollow)
				<a href="{{route('follow',[
                'followerID'=>$userdata->id,
                'followeeID'=>@Auth::user()->id
                ])}}" class="text-primary lato-regular d-block" style="font-size: 2rem !important;"><i class="fab fa-telegram-plane"></i> <small>{{trans_choice('general.button_follow_hh',Request::segment(4), ['hh_name' => Request::segment(4) ])}}</small></a>

                @else
				<a  href="{{route('unFollow',[
                'followerID'=>$userdata->id,
                'followeeID'=>@Auth::user()->id
                ])}}" class="text-primary lato-regular d-block" style="font-size: 2rem !important;"><i class="fas fa-check"></i> <small>{{trans_choice('general.button_following',Request::segment(4), ['hh_name' => Request::segment(4) ])}} </small></a>

                @endif

                @endif
            </div>
            @endif
        @endif

    @endif
</div>