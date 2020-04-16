<ul class="nav" id="dashboardTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='gigs')?' show active':''}}" href="{{route('supplier_gigs')}}">@lang('general.dashboard_nav_my_orders')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='applications')?' show active':''}}" href="{{route('supplier_application')}}">@lang('general.dashboard_nav_my_application')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='services')?' show active':''}}" href="{{route('supplier_services')}}">@lang('general.dashboard_nav_my_services')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='earnings')?' show active':''}}" href="{{route('supplier_earnings')}}">@lang('general.dashboard_nav_my_earnings')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{(Request::segment(4)==='messages')?' show active':''}}" href="{{route('supplier_messages')}}">@lang('general.dashboard_nav_messages')</a>
    </li>
    <li class="nav-item mr-auto">
        <a class="nav-link{{(Request::segment(4)==='bank')?' show active':''}}" href="{{route('supplier_bank')}}">@lang('general.dashboard_nav_bank_info')</a>
    </li>
</ul>