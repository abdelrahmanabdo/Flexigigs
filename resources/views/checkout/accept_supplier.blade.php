@extends('layouts.home')
@section('title', 'profile')
@section('bodyClass', 'inner dashboard')
@section('content')
<!-- message modal -->
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            @if (Auth::check())
                @if (!Auth::user()->hasRole('admin'))
                <li class="breadcrumb-item" aria-current="page"> <a href="{{route('customer_dashboard')}}">@lang('home.menu_my_dashboard')</a> </li>
                @endif
            @endif
            <li class="breadcrumb-item active" aria-current="page"> <a href="#">@lang('gigs.dashboard_supplier_gigs_gig_info.applied_supplier')</a> </li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('supplier.parts.sidecard')
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="supplier-gig col-12">
                    <div class="row">
                        <div class="header pt-2 pl-4">
                            <h2 class="text-capitalize font-weight-bold">{{$application->title}}</h2>
                        </div>
                    </div>
                    <div class="item pl-0 pr-0 ">
                        <div class="row item-content">
                            <div class="col-12 col-lg-4">
                                <div class="item-status">
                                    <div class="d-flex justify-content-between">
                                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.price')</label>
                                        <p class="font-weight-bold text-primary">{{number_format($application->price)}} @lang('general.gig_price_unit_EGP')</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.deadline')</label>
                                        <p>{{$application->deadline}}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.status.title')</label>
                                        <p>@lang('gigs.dashboard_supplier_gigs_gig_info.status.opened')</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <label class="bold-label font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.skills')</label>
                                        <div class="d-flex flex-wrap">
                                            @foreach ($application->skills as $skill)
                                            <span class="badge">{{(app()->getLocale()=='ar'&&$skill->category->name_ar)?$skill->category->name_ar:$skill->category->name}}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="item-status">
                                    <div class="d-flex flex-wrap justify-content-between pt-0">
                                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.description') </label>
                                        <p class="lead">
                                            {{$application->description}}
                                        </p>
                                    </div>
                                    @if(count($application->gig->attach))
                                    <div class="d-flex flex-column">
                                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.attached_files')</label>
                                        <?php $i = 1 ?>
                                        @foreach ($application->gig->attach as $attach)
                                        <a href="{{Flexihelp::get_file($attach->filename)}}">@lang('gigs.dashboard_supplier_gigs_gig_info.file_attached')-{{$i++}}</a>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="item-status">
                                    <div class="d-flex  flex-wrap justify-content-between pt-0">
                                        @if($application->notes)
                                        <label class="font-weight-bold">@lang('gigs.dashboard_supplier_apps_info.gh_notes')</label>
                                        <p class="lead">
                                            {{$application->notes}}
                                        </p>
                                        @endif
                                        <label class="mt-4 text-capitalize font-weight-bold">@lang('gigs.dashboard_supplier_gigs_gig_info.applied_on') {{Flexihelp::defult_date($application->created_at)}}</label>
                                    </div>
                                    <a href="{{url(app()->getLocale().'/application/checkout/'.$application->id)}}" class="btn btn-primary text-uppercase col-12 mt-4">@lang('general.button_accept_application')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($userdata->intro||$userdata->skills)
                <div class="supplier-info col-12 mt-5">
                    @if($userdata->intro)
                    <h2>@lang('gigs.single_gh_info')</h2>
                    <p>{{$userdata->intro}}</p>
                    @endif
                    <?php $skills = explode(',',$userdata->skills); ?>
                    @if (count($skills))
                    <h2>@lang('gigs.single_key_skills')</h2>
                    <div class="w-75">
                        @foreach ($skills as $key => $value)
                            <?php $category = DB::table('categories')->where("slug",$value)->first(); ?>
                            @if($category)
                            <span class="badge">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</span>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@if (Auth::check())
    @if (@Auth::user()->id != $userdata->id)
        @include('parts.messages.send')
    @endif
@endif
@endsection