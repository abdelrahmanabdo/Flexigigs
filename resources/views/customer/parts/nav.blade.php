<ul class="nav" id="dashboardTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='orders')?' show active':''}}" href="{{route('customer_orders')}}">@lang('general.dashboard_nav_my_orders')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='posts')?' show active':''}}" href="{{route('customer_posts')}}">@lang('general.dashboard_nav_my_gigs')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='favorites')?' show active':''}}" href="{{route('customer_favorites')}}">@lang('general.dashboard_nav_favorites')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='messages')?' show active':''}}" href="{{route('customer_messages')}}">@lang('general.dashboard_nav_messages')</a>
    </li>
</ul>