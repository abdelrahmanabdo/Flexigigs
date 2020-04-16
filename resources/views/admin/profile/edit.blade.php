@extends('layouts.home')
@section('title', 'profile')
@section('bodyClass', 'inner dashboard edit-profile')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<!-- message modal -->
@include('supplier.messages.parts.send')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin_users')}}">@lang('user.admin_edit_profile.users')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('user.admin_edit_profile.edit_user')</li>
        </ol>
    </nav>
</div>
<section class="container edit-profile">
    <div class="row">
        <div class="col-md-2">
            <div class="side">
                <div class="user pt-3">
					<div class="user-img col-12 p-0">
						<div class="user-img-container">
							<img src="{{ Flexihelp::get_file($userdata->avatar,'user',20,$userdata->gender) }}">
						</div>
					</div>
                </div>
                <a class="text-center" href=".edit-picture" data-toggle='modal'>@lang('user.admin_edit_profile.picture')</a>
                @if ($errors->has('avatar'))
                    <p class="help-block">
                        {{ $errors->first('avatar') }}
                    </p>
                @endif 
            </div>
        </div>
        <div class="col-md-10">
            <form enctype='multipart/form-data' method="post" class="edit-profile-form">
                {{ csrf_field() }}    
				<div class="row mt-5">
					<div class="col-12">
						<hh1 class="font-weight-bold text-black text-capitalize h2">@lang('user.admin_edit_profile.personal_info')</hh1>						
					</div>
				</div>   
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-12 pr-lg-5">
                        <label class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} has-float-label form-group mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->first_name?$userdata->first_name: old('first_name') }}" name="first_name" placeholder="@lang('user.admin_edit_profile.first_name')">
                            <span>@lang('user.admin_edit_profile.first_name')</span>
                            @if ($errors->has('first_name'))
                                <p class="help-block">
									{{ $errors->first('first_name') }}
                                </p>
                            @endif
                        </label>


                        <label class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} has-float-label form-group mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->last_name?$userdata->last_name:old('last_name') }}" name="last_name" placeholder="@lang('user.admin_edit_profile.last_name')">
                            <span>@lang('user.admin_edit_profile.last_name')</span>
                            @if ($errors->has('last_name'))
                                <p class="help-block">
                                    {{ $errors->first('last_name') }}
                                </p>
                            @endif
                        </label>
                        
                        <label class="form-group has-float-label form-group{{ $errors->has('username') ? ' has-error' : '' }} mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->username?$userdata->username:old('username') }}" name="username" placeholder="@lang('user.admin_edit_profile.user_name')">
                            <span>@lang('user.admin_edit_profile.user_name')</span>
                            @if ($errors->has('username'))
                                <p class="help-block">
                                    {{ $errors->first('username') }}
                                </p>
                            @endif
                        </label>
                        <label class="form-group has-float-label mt-5 form-group{{ $errors->has('oldPw') ? ' has-error' : '' }} mt-5">
                            <input type="password" class="form-control alt" name="oldPw" placeholder="@lang('user.admin_edit_profile.old_password')">
                            <span>@lang('user.admin_edit_profile.old_password')</span>
                            @if ($errors->has('oldPw'))
                                <p class="help-block">
                                    {{ $errors->first('oldPw') }}
                                </p>
                            @endif
                        </label>
                        <label class="form-group has-float-label mt-5 form-group{{ $errors->has('newPw') ? ' has-error' : '' }} mt-5">
                            <input type="password" class="form-control alt" name="newPw" placeholder="@lang('user.admin_edit_profile.new_password')">
                            <span>@lang('user.admin_edit_profile.new_password')</span>
                            @if ($errors->has('newPw'))
                                <p class="help-block">
                                    {{ $errors->first('newPw') }}
                                </p>
                            @endif
                        </label>
                        <label  class="has-float-label form-group mt-5 {{ $errors->has('newPw_confirmation') ? ' has-error' : '' }} mt-5">
                            <input type="password" class="form-control alt" name="newPw_confirmation" placeholder="@lang('user.admin_edit_profile.retype_new_password')">
                            <span>@lang('user.admin_edit_profile.retype_new_password')</span>
                            @if ($errors->has('newPw_confirmation'))
                                <p class="help-block">
                                    {{ $errors->first('newPw_confirmation') }}
                                </p>
                            @endif
                        </label>

                        <label class="form-group has-float-label mt-5 form-group{{ $errors->has('email') ? ' has-error' : '' }} mt-5">
                            <input type="email" class="form-control alt" value="{{$userdata->email?$userdata->email:old('email') }}"  name="email" placeholder="@lang('user.admin_edit_profile.email')">
                            <span>@lang('user.admin_edit_profile.email')</span>
                            @if ($errors->has('email'))
                                <p class="help-block">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </label>

                        <label class="form-group has-float-label mt-5 form-group{{ $errors->has('phone') ? ' has-error' : '' }} mt-5">
                            <input type="tel" class="form-control alt" value="{{$userdata->phone?$userdata->phone:old('phone') }}" name="phone" placeholder="@lang('user.admin_edit_profile.mobile')">
                            <span>@lang('user.admin_edit_profile.mobile')</span>
                            @if ($errors->has('phone'))
                                <p class="help-block">
                                    {{ $errors->first('phone') }}
                                </p>
                            @endif
                        </label>
                         <label class="form-group has-float-label mt-5">
                            <select class="form-control alt" name="availability">
                                <option value="" disabled>@lang('user.supplier_edit_profile.availability')</option>
                                <option value="0" {{($userdata->availability==0)?"selected":""}}>@lang('user.supplier_edit_profile.available')</option>
                                <option value="1" {{($userdata->availability==1)?"selected":""}}>@lang('user.supplier_edit_profile.busy')</option>
                                <option value="2" {{($userdata->availability==2)?"selected":""}}>@lang('user.supplier_edit_profile.away')</option>
                            </select>
                            <span>@lang('user.supplier_edit_profile.availability')</span>
                        </label>
                    </div>
                    <div class="col-lg-6 col-md-12 pr-lg-5">
                        <label class="form-group has-float-label mt-5 form-group{{ $errors->has('city') ? ' has-error' : '' }} mt-5">
                            <input type="text" name="formatted_address" value="{{$userdata->formatted_address?$userdata->formatted_address:old('formatted_address') }}" placeholder="City*" id="editlocation" class="form-control alt">
                            <input type="hidden" name="city" value="{{$userdata->city?$userdata->city:old('city') }}" id="edit_lat_long" class="latlong">
                            <span>@lang('user.admin_edit_profile.city')</span>
                            <script type="text/javascript">
                                    function findagigMapFunctions() {AutoCompleteSearchCity('editlocation','edit_lat_long','#editlocation'); }
                                    $('#editlocation').on('keyup', function () {
                                        if (!$(this).val()) {
                                            $('#edit_lat_long').val('');
                                        }
                                    });
                                </script>
                                @if ($errors->has('city'))
                                    <p class="help-block">
                                        {{ $errors->first('city') }}
                                    </p>
                                @endif
                        </label>
                        <label class="form-group has-float-label mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->facebook?$userdata->facebook:old('facebook') }}" name="facebook" placeholder="@lang('user.admin_edit_profile.facebook')">
                            <span>@lang('user.admin_edit_profile.facebook')</span>
                        </label>
                        <label class="form-group has-float-label mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->linkedin?$userdata->linkedin:old('linkedin') }}" name="linkedin" placeholder="@lang('user.admin_edit_profile.linkedin_url')">
                            <span>@lang('user.admin_edit_profile.linkedin_url')</span>
                        </label>
                        <label class="form-group has-float-label mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->twitter?$userdata->twitter:old('twitter') }}" name="twitter" placeholder="@lang('user.admin_edit_profile.twitter')">
                            <span>@lang('user.admin_edit_profile.twitter')</span>
                        </label>
                        <label class="form-group has-float-label mt-5">
                            <input type="text" class="form-control alt" value="{{$userdata->instagram?$userdata->instagram:old('instagram') }}" name="instagram" placeholder="@lang('user.admin_edit_profile.instagram_url')">
                            <span>@lang('user.admin_edit_profile.instagram_url')</span>
                        </label>
                        <label class="form-group has-float-label mt-5">
                            <input class="form-control alt" name="company_name" placeholder="@lang('user.admin_edit_profile.company_name')" value="{{$userdata->company_name}}">
                            <span class="text-hide">@lang('user.admin_edit_profile.company_name')</span>
                        </label>
                        <label class="form-group has-float-label mt-5">
                            <input type="text" class="form-control alt" name="site_url" placeholder="@lang('user.admin_edit_profile.company_url')" value="{{$userdata->site_url}}">
                            <span class="text-hide">@lang('user.admin_edit_profile.company_url')</span>
                        </label>
                    </div>
                </div>
                <div class="modal fade edit-picture" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">@lang('user.admin_edit_profile.picture')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="custom-file">
                                        <input type="file" name="avatar"    class="custom-file-input">
                                        <span class="custom-file-control"></span>
                                    </label>
                                </div>
                                <button class="btn btn-primary btn-block sendbtn">@lang('general.button_save')<i class="d-none fas fa-spinner fa-pulse ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end pr-lg-4">
                    <button type="button" onclick="window.location='{{route("admin_users")}}'" class="btn btn-default">@lang('general.button_cancel')</button>
                    <button type="submit" class="btn btn-primary sendbtn">@lang('general.button_save')<i class="d-none fas fa-spinner fa-pulse ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('.edit-profile-form').on('submit', function (e) {
        $('#sendbtn').prop('disabled',true);
        $('#sendbtn i').removeClass('d-none');
    });
    $('body').on('change', 'input[type="file"]', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    $('body').on('fileselect','.custom-file-input', function(
        event,
        numFiles,
        label
    ) {
        $(this).siblings('.custom-file-control').text(label);
    });
</script>
@endsection