@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item"><a href="{{route('gigs_categories')}}">@lang('gigs.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$gig->title}}</li>
        </ol>
    </nav>
    <h1 class="text-uppercase">@lang('gigs.list_title')</h1>
    <p>@lang('gigs.list_desc')</p>
</div>

<section id="single-gig">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-3">
                <div class="filter">
                    <h2>@lang('general.filter_title')</h2>
                    <a href="#" class="resetForm pr-3">@lang('general.filter_reset')</a>
                    <form accept-charset="utf-8" action="{{route('gigs')}}">
                        <div class="form-group">
                            <label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
                            <span>
                            <input type="text" name="free_text" value="{{@$_GET['free_text']}}" placeholder="@lang('general.filter_search')" class="form-control">
                        </span>
                        </div>
                       <div class="form-group" id="parent">
                            <label class="text-hide" for="gig">@lang('general.filter_select_cat')</label>
                            <select class="form-control" id="parentselector" name="parent" required>
                                <option value="">-@lang('general.filter_select_cat')-</option>
                                @foreach($parents_categories as $cat)
                                <option value="{{$cat->slug}}" <?=(@$_GET['parent']==@$cat->slug)?"selected":"";?>>{{Flexihelp::catname($cat,app()->getLocale())}}</option>
                                @endforeach
                            </select>
                            <script type="text/javascript">
                                $('#parentselector').on('change',function (e) {
                                    $.post('{{url(app()->getLocale()."/category/dependancy")}}',
                                            { _token:$('meta[name="csrf-token"]').attr('content'),
                                            slug: $('#parentselector').val(),
                                            stage: 1
                                            })
                                    .done(function(content){
                                        $( "#sub" ).empty().append( content );
                                        $( "#subsub" ).empty();
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-group" id="sub"> </div>
                        <div class="form-group" id="subsub"></div>
                        <div class="form-group">
                            <label for="location">@lang('general.filter_date_range')</label>
                            <div class="d-flex justify-content-between">
                                <input type="text" class="form-control" placeholder="@lang('general.filter_date_range_from')" id="from"value="{{@$_GET['deadline_from']}}" name="deadline_from">
                                <input type="text" class="form-control" placeholder="@lang('general.filter_date_range_to')" id="to" value="{{@$_GET['deadline_to']}}" name="deadline_to">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="priceRange">@lang('general.filter_price_range')</label>
                            <div class="range-wrap">
                                @if(app()->getLocale()=="en")
                                <input id="priceMin" type="text" name="price_from" >
                                @else
                                <input id="priceMax" type="text" name="price_to">
                                @endif
                                <div class="slider-range" data-from="<?=(@$min_price)?@$min_price:0;?>" data-to="<?=(@$max_price)?@$max_price:0;?>" data-value-from="<?=(@$_GET['price_from'])?@$_GET['price_from']:@$min_price;?>" data-value-to="<?=(@$_GET['price_to'])?@$_GET['price_to']:@$max_price;?>"></div>
                                @if(app()->getLocale()=="en")
                                <input id="priceMax" type="text" name="price_to">
                                @else
                                <input id="priceMin" type="text" name="price_from" >
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-9" id="gigContent">
                @if(session('applications_created'))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-dismissible fade show rounded-0 ml-3 mr-3" role="alert">
                            <h4 class="alert-heading font-weight-bold ">@lang('gigs.list_application_success_title')</h4>
                            <p class=" lead">@lang('gigs.list_application_success_message')</p>
                            <button type="button" class="close mt-1" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="service-thumb proposed">
                            <div class="service-thumb--header">
                                <h1>{{$gig->title}}</h1>
                                <p>@lang('gigs.single_submitted_on') {{Flexihelp::defult_date($gig->created_at)}}</p>
                            </div>
                            <div class="service-thumb--body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                        @if($user)
                                        <div class="user">
                                            <img src="<?=Flexihelp::get_file($user->avatar,'user',20,$user->gender)?>">
                                            <div>
                                                <a href="{{route('customer_profile',[$user->username])}}" title="" class="user_name">
                                                    <p>{{$user->username}}</p>
                                                </a>
                                                <div class="br-wrapper br-theme-fontawesome-stars">
                                                    <?=Flexihelp::get_stars('review',$user->customer_rate)?>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="item-status">
                                            <div class="d-flex justify-content-between item">
                                                <label>@lang('gigs.single_price')</label>
                                                <p class="price text-primary">{{number_format($gig->price)}} @lang('general.gig_price_unit_EGP')</p>
                                            </div>
                                            <div class="d-flex justify-content-between item">
                                                <label>@lang('gigs.single_deadline')</label>
                                                <p>{{Flexihelp::defult_date($gig->deadline)}}</p>
                                            </div>
                                            <div class="d-flex justify-content-between item">
                                                <label>@lang('gigs.single_status')</label>
                                                <p>@lang('gigs.single_status_active')</p>
                                            </div>
                                            <div class="d-flex item skills">
                                                <label>@lang('gigs.single_skills')</label>
                                                <div class="d-flex flex-wrap justify-content-start align-items-end">
                                                    @foreach($gig->skills as $skill)
                                                    <span class="badge py-2 px-2" style="width: auto;">{{(app()->getLocale()=="ar"&&$skill->category->name_ar)?$skill->category->name_ar:$skill->category->name}}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                        <div class="item-status">
                                            <div class="d-flex item skills">
                                                <label class="sec-title py-2">@lang('user.gh_type') </label>
                                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                                    @foreach($gig->supplier_type as $type)
                                                        <span class="badge py-2 px-2" style="width: auto;">{{$type->supplier_type}}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="description side-scroll">
                                            <label class="sec-title">@lang('gigs.single_desc') </label>
                                            <p><?=nl2br($gig->description)?></p>
                                        </div>
                                        @if(count($gig->attach))
                                        <div class="d-flex justify-content-between align-items-center item py-3">
                                            <label class="sec-title">@lang('gigs.single_attatched')</label>
                                            <?php $i = 1 ?>
                                            @foreach($gig->attach as $attach)
                                            <a class="text-primary" href="{{Flexihelp::get_file($attach->filename)}}" target="blank" download>@lang('gigs.single_attatched_count')-<?=$i++?></a>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-4">
                                        @if (Auth::check())
                                            @if(@$is_apply)
                                                <label class="font-weight-bold text-capitalized sec-title">@lang('gigs.single_applied_on') {{Flexihelp::defult_date($is_apply->created_at)}}</label>
                                                <button class="btn btn-outline-danger btn-block text-capitalize cancel-application" data-id="{{$is_apply->id}}">@lang('gigs.dashboard_supplier_apps_cancel_app')</button>
                                                @include('parts.applications.cancel')
                                                @else
                                                @if(Auth::user()->id===$gig->customer_id)
                                                <label class="font-weight-bold text-capitalized sec-title">@lang('gigs.single_gig_has') {{count($gig->applications)}} @lang('gigs.applications').</label>
                                                @if(count($gig->applications))
                                                <a class="btn btn-outline-primary btn-block text-capitalize cancel-application" href="{{url(app()->getLocale().'/customer/dashboard/posts#giglink-'.$gig->id)}}">@lang('gigs.view_application')</a>
                                                @endif
                                                @else
                                                    @if(session('member_type') === 0)
                                                    <form method="post">
                                                        {{ csrf_field() }}
                                                        <div class="item-review">
                                                            <label class="sec-title">@lang('gigs.single_apply_now')</label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox{{ $errors->has('gig_price') ? ' has-error' : '' }}">
                                                                    <input class="custom-control-input" type="checkbox" name="gig_price" required>
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">@lang('gigs.single_confirm_proj_value') {{number_format($gig->price)}} @lang('general.gig_price_unit_EGP')</span>
                                                                    <p class="help-block"> <strong>{{ $errors->first('gig_price') }}</strong></p>
                                                                </label>
                                                                <label class="custom-control custom-checkbox{{ $errors->has('delivery_date') ? ' has-error' : '' }}">
                                                                    <input class="custom-control-input" type="checkbox" name="delivery_date" required>
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description">@lang('gigs.single_confirm_proj_deadline') {{$gig->deadline}}</span>
                                                                    <p class="help-block"> <strong>{{ $errors->first('delivery_date') }}</strong></p>
                                                                </label>
                                                            </div>
                                                            <label class="form-group has-float-label mt-5{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                                <textarea class="form-control counted" rows="2" placeholder="@lang('gigs.single_note_to_hh')" name="notes"></textarea>
                                                                <span>@lang('gigs.single_note_to_hh')</span>
                                                                <p class="char">0/200</p>
                                                                <p class="help-block" style="top: 80px;"> <strong>{{ $errors->first('notes') }}</strong></p>
                                                            </label>
                                                            <button class="btn btn-primary btn-block" type="submit">@lang('general.button_apply')</button>
                                                        </div>
                                                    </form>
                                                    @else
                                                        <h5 class="font-weight-bold">@lang('gigs.single_switch_to_gh')</h5>
                                                        <a class="btn btn-primary btn-block " href="{{route('switch',['supplier','url'=>url()->current()])}}">@lang('general.button_switch_now')</a>
                                                    @endif
                                               @endif
                                            @endif
                                        @else
                                            <h5 class="font-weight-bold ">@lang('gigs.single_login_to_apply')</h5>
                                            <button class="btn btn-primary btn-block text-capitalize" data-toggle="modal" data-target="#loginModal">@lang('general.button_login')</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection