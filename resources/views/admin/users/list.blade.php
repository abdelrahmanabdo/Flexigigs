@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route("home")}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
            @include('admin.users.search')
        </div>
        <div class="col-md-8">
            @include('admin.parts.nav')
            <div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="users" role="tabpanel">
					<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_users')</p>
                    @if(count($result))
                    <div id="adminDBUsers">
                        @foreach($result as $user)
                        <div class="service-thumb mt-4 ml-0 mr-0 mb-0 pb-4">
                            <div class="row">
                                <div class="col-6 col-md-6 col-lg-3 d-flex flex-row justify-content-start">
                                    <div class="user">
										<div class="user-img-sm ml-0">
											<div class="user-img-sm-container">
												<img src="{{Flexihelp::get_file($user->avatar,'user',20,$user->gender)}}">
											</div>
										</div>
                                        <div>
                                            <a href="#" title="" class="user_name font-weight-bold">
                                                <p class="font-weight-bold">{{$user->username}}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6 usersInfo">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <p class="mt-2 mb-0 font-weight-bold">{{$user->formatted_address}}</p>
                                        </div>
                                        <div class="col-lg-7">
                                            <p class="mt-2 mb-0 font-weight-bold">@lang('user.member_since') {{Flexihelp::defult_date($user->created_at)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-3 usersButtons">
                                    <div class="row">
                                        <a href="{{route('admin_edituser',['id'=>$user->id])}}" class="btn btn-outline-primary btn-sm col-5 col-lg-5 pt-2">@lang('general.button_edit')</a>
                                        @if($user->status==0)
                                        <button type="button" data-id="{{$user->id}}" class="btn btn-outline-success btn-sm col-5 offset-sm-1 col-lg-5 offset-lg-1 btnActive">@lang('general.button_active')</button>
                                        @elseif($user->status==1)
                                        <button type="button" data-id="{{$user->id}}" class="btn btn-outline-danger btn-sm col-5 offset-sm-1 col-lg-5 offset-lg-1 btnBan">@lang('general.button_ban')</button>
                                        @elseif($user->status==2)
                                        <button type="button" data-id="{{$user->id}}" class="btn btn-outline-success btn-sm col-5 offset-sm-1 col-lg-5 offset-lg-1 btnUnban">@lang('general.button_unban')</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="row mt-5">
                            <div class="modal fade export-modal" tabindex="-1" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  onSubmit="$('.export-modal').modal('hide');" method="get" action="{{route('downloadusers')}}" target="_blank">
                                            {{csrf_field()}}
                                            <input type="hidden" name="free_text" value="{{ request()->has('free_text') ? request()->get('free_text') : '' }}">
                                            <input type="hidden" name="status" value="{{ request()->has('status') ? request()->get('status') : '' }}">
                                            <div class="modal-header">
                                                <h5 class="modal-title">export data</h5>
                                                <button type="reset" class="close"  aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label class="form-group has-float-label form-group mt-5">
                                                    <select class="form-control" name="month">
                                                        <option disabled>--select month--</option>
                                                        @foreach($months as $month)
                                                        <option value="{{date('Y-m',strtotime($month[0]->created_at))}}"> {{date('Y-M',strtotime($month[0]->created_at))}} </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                                <button class="btn btn-primary btn-block" type="submit" id="sendbtn">download</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{$user_pagination->links('vendor.pagination.withexport')}}
                        </div>
					</div>
					@else
						<div class="item text-center noResult">
							<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
						</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@include('admin.users.ban')
@include('admin.users.unban')
@include('admin.users.active')
@endsection