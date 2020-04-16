@extends('layouts.home')
@section('title', 'Reset my password')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<section class="mb-0 reset-password">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="reset-password-form col-md-6">
                <div class="reset-password-form-header">
                    <h1 class="text-capitalize">@lang('user.reset_password_title')</h1>
                    <p class="lead">@lang('user.reset_password_desc')</p>
                </div>
                <div class="reset-password-form-body">
                    <form method="POST" action="{{ route('password.request') }}">
                        @if (session('status'))
                            <div class="col-12 alert alert-success rounded-0 text-lowercase mb-0" role="alert">
                                <strong>{{ session('status') }}</strong>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>					
                            </div>
                            @else
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <label class="form-group has-float-label mt-5 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" name="email" value="{{ $email or old('email') }}" required class="form-control alt" placeholder="@lang('user.reset_password_email_placeholder')">
                            @if ($errors->has('email'))
                                <p class="help-block mt-1">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </p>
                            @endif
                            <span>@lang('user.reset_password_email')</span>
                        </label>
                        <label class="form-group has-float-label mt-5 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control alt" name="password" placeholder="@lang('user.reset_password_password_placeholder')" required>
                            <span for="password" class="col-md-4 control-label">@lang('user.reset_password_password')</span>
                            @if ($errors->has('password'))
                                <p class="help-block mt-1">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </p>
                            @endif
                        </label>
                        <label class="form-group has-float-label mt-5 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input id="password-confirm" type="password" class="form-control alt" name="password_confirmation" placeholder="@lang('user.reset_password_confirm_password_placeholder')" required>
                            <span for="password-confirm" class="col-md-4 control-label">@lang('user.reset_password_confirm_password')</span>
                            @if ($errors->has('password_confirmation'))
                                <p class="help-block mt-1">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </p>
                            @endif
                        </label>
                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-5">@lang('general.button_submit')</button>
                        @endif
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
