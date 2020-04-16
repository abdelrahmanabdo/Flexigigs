<ul class="nav" id="dashboardTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='users')?' show active':''}}" href="{{route('admin_users')}}">@lang('general.dashboard_nav_users')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='services')?' show active':''}}" href="{{route('admin_services')}}">@lang('general.dashboard_nav_services')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='orders')?' show active':''}}" href="{{route('admin_orders')}}">@lang('general.dashboard_nav_orders')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='gigs')?' show active':''}}" href="{{route('admin_gigs')}}">@lang('general.dashboard_nav_gigs')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='earnings')?' show active':''}}" href="{{route('admin_earnings')}}">@lang('general.dashboard_nav_earnings')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='messages')?' show active':''}}" href="{{route('admin_messages')}}">@lang('general.dashboard_nav_messages')</a>
	</li>
	<li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='usermessages')?' show active':''}}" href="{{route('admin_usermessages')}}">@lang('general.dashboard_nav_usersmessages')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='reviews')?' show active':''}}" href="{{route('admin_reviews')}}">@lang('general.dashboard_nav_reviews')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='translations')?' show active':''}}" href="{{url(app()->getLocale().'/admin/dashboard/translations')}}">
            <span class="fa fa-language"></span>
        </a>
    </li>
    <li class="nav-item notification">
        <!-- <a class="nav-link" data-notification='20' data-toggle="tab" href="#notifications" role="tab" aria-selected="false"><span class="icon-bell"></span></a> -->
    </li>
</ul>