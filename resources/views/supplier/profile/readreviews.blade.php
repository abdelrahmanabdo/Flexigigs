@extends('layouts.home')
@section('title', 'profile')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<!-- message modal -->
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$userdata->first_name}}{{" ".$userdata->last_name}} profile</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('supplier.parts.sidecard')
            @include('supplier.profile.reviewsSearch')
        </div>
        <div class="col-md-8">
            <div class="reviews">
                <div class="header mb-5">
                    <h3 class="review-head">@lang('reviews.title')</h3>
                    <select class="form-control alt sort-DropDown sorter" name="sortby">
                        <option value="">@lang('general.sort_title')</option>
                        <option value="rate_asc" {{(@$_GET['sort_by']=="rate_asc")?"selected":""}}>@lang('general.sort_option_rating_ASC')</option>
                        <option value="rate_desc" {{(@$_GET['sort_by']=="rate_desc")?"selected":""}}>@lang('general.sort_option_rating_DESC')</option>
                        <option value="created_asc" {{(@$_GET['sort_by']=="created_asc")?"selected":""}}>@lang('general.sort_option_date_ASC')</option>
                        <option value="created_desc" {{(@$_GET['sort_by']=="created_desc")?"selected":""}}>@lang('general.sort_option_date_DESC')</option>
                    </select>
                </div>
                @forelse($reviews as $review)
                    @if ($review->user)
                    <div class="review">
                        <div class="header">
                            <div class="user">
                                <div class="user-img-md p-0">
                                    <div class="user-img-md-container">
                                        <img src="{{Flexihelp::get_file($review->user->avatar,'user',20,$review->user->gender)}}">
                                    </div>
                                </div>
                                <div>
                                    <p>{{$review->user->username}}</p>
                                    <p>{{($review->order->type == 1)?trans('reviews.service')." : ".$review->order->request->name:trans('reviews.gig')." : ".$review->order->application->title}}</p>
                                </div>
                            </div>
                            <?=Flexihelp::get_stars('review',$review->rate)?>
                        </div>
                        <p>{{$review->comment}}</p>
                    </div>
                    @endif
                @empty
                    <h1 class="text-center">@lang('general.no_review')</h1>
                @endforelse
            </div>
            <div class="row">
            {{$reviews->links()}}
            </div>
            <script type="text/javascript">
            $('.sorter').change(function () {
                url = window.location.href
                if(url.indexOf("?") > -1) {
                   window.location =url+"&sort_by="+$(this).val();
                }else{
                   window.location =url+"?sort_by="+$(this).val();
                }
            })
            </script>
        </div>
    </div>
</section>
@if (Auth::check())
    @include('parts.messages.send')
@endif
@endsection