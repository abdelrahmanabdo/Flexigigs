<div class="side">
    <h2>@lang('general.search_nav_result_in')</h2>
    <div class="nav flex-column results-nav">
        <a href="{{route('search',['type'=>'services','free_text'=>app('request')->input('free_text')])}}" class="nav-link {{(Request::segment(3)==='services')?' active':''}}">@lang('general.search_nav_services')</a>
        <a href="{{route('search',['type'=>'categories','free_text'=>app('request')->input('free_text')])}}" class="nav-link {{(Request::segment(3)==='categories')?' active':''}}">@lang('general.search_nav_categories')</a>
        <a href="{{route('search',['type'=>'gigs','free_text'=>app('request')->input('free_text')])}}" class="nav-link {{(Request::segment(3)==='gigs')?'active':''}}">@lang('general.search_nav_gigs')</a>
    </div>
</div>