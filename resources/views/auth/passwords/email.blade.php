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
                    <p class="lead">@lang('user.enter_your_mail')</p>
                </div>
                <div class="reset-password-form-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @if (session('status'))
							<div class="col-md-12 alert alert-success rounded-0 text-lowercase mb-0" role="alert">
								<strong>{{ session('status') }}</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
                        @else
                        {{ csrf_field() }}
                        <label class="form-group has-float-label mt-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control alt" placeholder="@lang('user.reset_password_email_placeholder')">
                            @if ($errors->has('email'))
                                <p class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </p>
                            @endif
                            <span>@lang('user.reset_password_email')</span>
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
