<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('user.login_title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form accept-charset="utf-8" role="form" onsubmit="return false"  method="POST" id="login-form">
                    <div class="col-md-12 alert alert-danger LoginErrors d-none rounded-0 text-lowercase" role="alert">
						<strong></strong>
						 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
                    {{ csrf_field() }}      
                    <div class="form-group" id="loginemail">
                        <label class="text-hide" for="email">@lang('user.login_email')</label>
                        <input id="email" type="email" class="form-control" name="email" placeholder="@lang('user.login_email')" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="text-hide" for="password">@lang('user.login_password')</label>
                        <input type="password" name="password" placeholder="@lang('user.login_password')" class="form-control" required>
                    </div>
                    <a href="{{ route('password.request') }}" title="@lang('user.login_forgot_password')">@lang('user.login_forgot_password')</a>
                    <button type="submit" class="btn btn-default btn-block">@lang('user.login_title')</button>
                    <a href="{{ url(app()->getLocale().'/login/facebook?membertype=registerFindagigModal') }}" class="btn btn-default btn-block text-center"><i class="icon-facebook"></i>@lang('user.login_facebook_account')</a>
                </form>
            </div>
            <div class="modal-footer">
                <p>@lang('user.login_no_account')</p>
                <a href="#" data-toggle="modal" data-target="#registerModal" title="register now" class="register-link">@lang('user.login_register')</a>
            </div>
        </div>
    </div>
</div>
<!-- you haven't verified you account yet. <a href=":href">Send other verification email?</a> -->
<!-- لم يتم تفعيل حسابك حتي  الآن . <a href=":href">ارسال  رساله تفعيل جديدة </a> -->
<script type="text/javascript">
    $('#login-form').on('submit', function (e) {
        e.preventDefault();
        var LoginData = $(this).serialize();
        var action = $(this).attr('action');
        $.ajax({
            type: 'POST', url: "{{ route('login') }}", data: LoginData,
            success: function (message) {
                window.location = "{{ (session('ReferertUrl'))?url(session('ReferertUrl')):route('home') }}";
            },
            error: function (message) {
                console.log('error',message.responseJSON.message);
                if (message.responseJSON.user_id) {
                    var messagedata = message.responseJSON.message+" <a href='{{url(app()->getLocale().'/revarify')}}/"+message.responseJSON.user_id+"'>@lang('auth.auth.resend')</a>";
                }else{
                    var messagedata = message.responseJSON.message;
                }
                $('.LoginErrors').removeClass('d-none')
                                 .addClass('alert-danger')
                                 .removeClass('alert-success')
								 .find('strong')
                                 .html(messagedata);
            }
        });
    });
    
</script>
