<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ (app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Flexigigs') }} - @yield('title')</title>
    <!-- Required meta tags -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('images/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('images/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('images/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('images/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('images/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('images/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('images/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('images/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('images/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('images/favicon/manifest.json')}}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <!-- Required meta tags -->
    <meta name="Keywords"           content="{{config('meta.keywords')}}" />
    <meta name="Description"        content="{{config('meta.description')}}" />
    <!-- ==================== meta facebook ===================== -->
    <meta property="og:image" content="{{config('meta.image')}}" />
    <meta property="og:description" content="{{config('meta.description')}}" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:title" content="@yield('title')" />
    <!-- <meta property="og:type" content="{{config('meta.type')}}" /> -->
    <!-- ==================== meta end facebook ===================== -->
    <meta name="theme-color" content="#ffffff">
    <!-- jQuery UI CSS -->
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5a7350012fd34b00134b0df8&product=inline-share-buttons-wp"></script>
    
    <script type="text/javascript" src="{{asset('js/modernizr.custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script
  src="https://code.jquery.com/jquery-migrate-3.0.1.js"
  integrity="sha256-VvnF+Zgpd00LL73P2XULYXEn6ROvoFaa/vbfoiFlZZ4="
  crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('js/jquery.form.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/core.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bluebird.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/chosen.jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/simplebar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/reloadAsGet.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/classie.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.barrating.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/script.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.structure.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{asset('css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.mCustomScrollbar.min.css')}}">
    @if (app()->getLocale() == 'ar')
    <script type="text/javascript" src="{{asset('js/slider_fire.rtl.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.rtlcss.com/bootstrap/v4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style-rtl.min.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('css/all.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/all.rtl.css')}}">
    <script type="text/javascript" src="{{asset('js/all.rtl.js')}}"></script>-->
    <!-- <link rel="stylesheet" href="{{asset('css/dumy-rtl.css')}}">  -->
    @else
    <script type="text/javascript" src="{{asset('js/slider_fire.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.min.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('css/all.css')}}">
    <script type="text/javascript" src="{{asset('js/all.js')}}"></script>-->
    <!-- <link rel="stylesheet" href="{{asset('css/dumy.css')}}">  -->
    @endif
    <script type="text/javascript" src="{{asset('js/validate.min.js')}}"></script>
    <script type="text/javascript">
        function clint_validator(form_identifier,item_identifier,constraints){
            $(form_identifier+' input,'+form_identifier+' select,'+form_identifier+' textarea').focusout(function() {
                item_name = $(this).attr('name');
                validate.validators.presence.options = {
                    message:function(value, attribute, validatorOptions, attributes, globalOptions) {
                        required_message = "@lang("validation.required")";
                        af = required_message.replace(':attribute',"%{attrname}");
                        return validate.format("^"+af, {
                          attrname: validate.prettify(attribute)
                        });
                    }
                }
                item_value = $(this).val();
                content ={};
                if (item_value) {
                    content={[item_name]:item_value};
                    if(item_name=="password_confirmation"){
                        password_value = $(form_identifier+' input[name="password"]').val();
                        content={password:password_value,[item_name]:item_value};
                    }
                }
                form_json = validate(content, constraints);
                message = form_json[item_name];
                showValidate(item_identifier+item_name,message,true);
            });
        }
        function showValidate(idenifier,messages,keyup){
            if (messages) {
                if (keyup==true) {
                    // idenifier will =  idenifier+item_name
                    $("."+idenifier).addClass('has-error');
                    $("."+idenifier+' .help-block').removeClass('d-none').text(messages);
                }else{
                    for(var key in messages){
                        $("."+idenifier+key).addClass('has-error');
                        $("."+idenifier+key+' .help-block').removeClass('d-none').text(messages[key]);
                    }
                }
            }else{
                $("."+idenifier).removeClass('has-error');
                $("."+idenifier+' .help-block').addClass('d-none').text("");
            }
        }
    </script>
</head>

<body class="loading">
    <div class="preloader">
        <img src="{{asset('images/Preloader.gif')}}">
    </div>
    <!-- Login Modal -->
    @if (!Auth::check())
        @include('auth.login')
        @include('auth.register')
    @endif
    <div class="site-wrap @yield('bodyClass')">
		<div class="beta-notification alert m-0 rounded-0 border-0 py-4 bg-primary text-white">@lang('general.alert.beta_msg')</div>
        <header class="container-fluid">
            <a href="{{route('home')}}" class="logo" title="home"><img src="{{asset('images/logo.png')}}" alt="logo"></a>
            @yield('search')
            <div class="top-nav">
                <button type="button" id="trigger-overlay" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                    <span class="tcon-menu__lines" aria-hidden="true"></span>
                    <span class="tcon-visuallyhidden">@lang('home.menu_toggle')</span>
                </button>

                <div class="btn-group btn-group-sm" role="group" aria-label="login and register">
                    @if (Route::has('login'))
                        @if (Auth::check())
                        <div class="user-welcome dropdown-toggle" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div class="user-img-sm">
								<div class="user-img-sm-container">
									<img src="{{ Flexihelp::get_file(Auth::user()->avatar,'user',20,Auth::user()->gender) }}" alt="user image">
								</div>
							</div>  
                            <p>@lang('home.menu_welcome') {{ Auth::user()->username }}</p>
                            @if (!Auth::guest())
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    @if (Auth::user()->hasRole('admin'))
                                    <a class="dropdown-item text-white" href="{{route('admin_orders')}}" onclick='event.preventDefault(); window.location.href= "{{route('admin_orders')}}";' >@lang('home.menu_my_dashboard')</a>
                                    @else
                                        @if(session('member_type') === 1)
                                        <a href="{{route('switch',['supplier','url'=>url()->current()])}}" onclick='event.preventDefault(); window.location.href= "{{route('switch',['supplier','url'=>url()->current()])}}";' class="dropdown-item text-white">@lang('home.menu_take_me_to_gh')</a>
                                        @elseif(session('member_type') === 0)
                                        <a href="{{route('switch',['customer','url'=>url()->current()])}}" onclick='event.preventDefault(); window.location.href= "{{route('switch',['customer','url'=>url()->current()])}}";' class="dropdown-item text-white">@lang('home.menu_take_me_to_hh')</a>
                                        @endif
                                        @if(session('member_type') === 1)
                                        <a class="dropdown-item text-white" href="{{route('customer_posts')}}" onclick='event.preventDefault(); window.location.href= "{{route('customer_posts')}}";' >@lang('home.menu_my_dashboard')</a>
                                        @elseif(session('member_type') === 0)
                                        <a class="dropdown-item text-white" href="{{route('supplier_services')}}" onclick='event.preventDefault(); window.location.href= "{{route('supplier_services')}}";' >@lang('home.menu_my_dashboard')</a>
                                        @endif
                                    @endif
                                        <a href="{{ route('logout') }}" class="dropdown-item text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('home.menu_logout')</a>
                                </div>
                            @endif
                        </div>
                        @else
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#loginModal">@lang('user.login_title')</button>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#registerModal">@lang('user.register_title')</button>
                        @endif
                    @endif
                </div>
                <div class="social">
                    <a href="{{config('site_settings.social.facebook')}}" title="facebook" target="blank"><i class="icon-facebook"></i></a>
                    <a href="{{config('site_settings.social.linkedin')}}" title="linkedin" target="blank"><i class="icon-linkedin"></i></a>
                    <a href="{{config('site_settings.social.twitter')}}" title="twitter" target="blank"><i class="icon-twitter"></i></a>
                    <a href="{{config('site_settings.social.instagram')}}" title="instgram" target="blank"><i class="icon-instagram"></i></a>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{(app()->getLocale()=='ar')?trans('home.menu_ar'):trans('home.menu_eng')}}</a>
                        <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuLink">
                            @if (app()->getLocale()=='ar'):
                            <a class="dropdown-item py-4" href="<?=str_replace(url('/ar'), url('/en'), url()->current())?>">@lang('home.menu_eng')</a>
                            @else
                            <a class="dropdown-item py-4" href="<?=str_replace(url('/en'), url('/ar'), url()->current())?>">@lang('home.menu_ar')</a>
                            @endif
                        </div>  
                    </div>
				</div>
				<div class="beta-label position-absolute">
					<img src="{{url('images/beta-'.app()->getLocale().'.png')}}" alt="beta label">
				</div>
				
			</div>
            <div class="overlay overlay-slidedown">
                <div class="container-fluid">
                    <button type="button" id="close-overlay" class="tcon tcon-menu--xcross tcon-transform close-overlay-btn" aria-label="toggle menu">
                        <span class="tcon-menu__lines" aria-hidden="true"></span>
                        <span class="tcon-visuallyhidden">@lang('home.menu_toggle')</span>
					</button>
					@if (app()->getLocale() == 'ar')
					<i class="to-level-1 icon-angle-right ml-2 float-left position-absolute d-none" ></i>
					@else
					<i class="to-level-1 icon-angle-left ml-2 float-left position-absolute d-none" ></i>
					@endif
                </div>
                <i class="icon-angel-right"></i>
                <nav aria-labelledby="main navigation">
                    <ul class="nav-level-1">
                        <li><a href="{{route('home')}}">@lang('home.menu_home')</a></li>
                        <li><a href="{{route('service_categories')}}">@lang('home.menu_categories')</a></li>
                        <li><a href="{{route('gigs_categories')}}">@lang('home.menu_gigs')</a></li>
                        @if (!Auth::guest())
                            @if (Auth::user()->hasRole('admin'))
                            <li><a href="{{route('admin_services')}}">@lang('home.menu_my_dashboard')</a></li>
                            @else
                                @if(session('member_type') === 1)
                                <li><a href="{{route('customer_posts')}}">@lang('home.menu_my_dashboard')</a></li>
                                @elseif(session('member_type') === 0)
                                <li><a href="{{route('supplier_services')}}">@lang('home.menu_my_dashboard')</a></li>
                                @endif
                            @endif
                        @endif
                        <li id="help-element"><a href="#" class="help" >@lang('home.menu_help')  @if (app()->getLocale() == 'ar') <i class="icon-angle-left ml-2"></i> @else <i class="icon-angle-right ml-2"></i> @endif </a></li>
                        <li class="d-lg-none">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{(app()->getLocale()=='ar')?'AR':'EN'}}</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @if (app()->getLocale()=='ar'):
                                    <a class="dropdown-item py-4" href="<?=str_replace(url('/ar'), url('/en'), url()->current())?>">@lang('home.menu_eng')</a>
                                    @else
                                    <a class="dropdown-item py-4" href="<?=str_replace(url('/en'), url('/ar'), url()->current())?>">@lang('home.menu_ar')</a>
                                    @endif
                                </div>  
                            </div>
                        </li>
                        @if (Auth::guest())
                        <li><a href="#loginModal" data-toggle="modal">@lang('home.menu_login')</a></li>
                        @else
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                                class="close-overlay-btn">
                                @lang('home.menu_logout')
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @endif

                        <li>
                            <div class="social">
                                <a href="{{config('site_settings.social.facebook')}}" title="facebook" target="blank"><i class="icon-facebook"></i></a>
                                <a href="{{config('site_settings.social.linkedin')}}" title="linkedin" target="blank"><i class="icon-linkedin"></i></a>
                                <a href="{{config('site_settings.social.twitter')}}" title="twitter" target="blank"><i class="icon-twitter"></i></a>
                                <!-- <a href="{{config('site_settings.social.instagram')}}" title="instgram"><i class="icon-instagram"></i></a> -->
                            </div>
                        </li>
                    </ul>
                    <ul class="nav-level-2 d-none">
					 
					    <li><a href="{{route('faq')}}" class="text-capitalize">@lang('home.menu_faqs')</a></li>
                        <li><a href="{{route('how-it-work')}}" class="text-capitalize">@lang('home.menu_how_it_works')</a></li>
                        <li><a href="{{route('terms')}}" class="text-capitalize">@lang('home.menu_terms_conditions') </a></li>
                        <li><a href="{{route('privacy-policy')}}" class="text-capitalize">@lang('home.menu_privacy_policy')</a></li>                       
                        <li><a href="{{route('refund-policy')}}" class="text-capitalize">@lang('home.menu_refund_police')</a></li>
                        <li><a href="{{route('contact-us')}}" class="text-capitalize">@lang('home.menu_contact_us')</a></li>
                    </ul>
                    <script type="text/javascript">
                        (function(){
                            $('.help').click(function(e){
                                e.preventDefault();
                                $('.nav-level-1').addClass('d-none');
                                $('.to-level-1').removeClass('d-none');
                                $('.nav-level-2').removeClass('d-none');
                            });
                            $('.to-level-1').click(function(e){
                                e.preventDefault();
                                $('.nav-level-1').removeClass('d-none');
                                $(this).addClass('d-none');
                                $('.nav-level-2').addClass('d-none');
                            });
                        })();
                    </script>
                </nav>
            </div>
		</header>
        <!-- /header -->
    @yield('content')
        <footer>
           <div class="container py-3 d-none d-md-flex footer-top">
               <div class="row w-100">
               <?php
               $footer_categories = DB::table('categories')->where('parent_id', 0)->get();
                foreach ($footer_categories as $footercat): ?>
                   <div class="col-lg-2">
                       <a href="{{route('service_subcategory',['category'=>$footercat->slug])}}">{{(app()->getLocale()=='ar'&&$footercat->name_ar)?$footercat->name_ar:$footercat->name}}</a>
                       <ul>
                           <?php
                           $children = DB::table('categories')->where('parent_id', $footercat->id)->get();
                           foreach ($children as $child): ?>
                           <li><a href="{{route('service_subcategory2',['category'=>$footercat->slug,'slug'=>$child->slug])}}" title="">{{(app()->getLocale()=='ar'&&$child->name_ar)?$child->name_ar:$child->name}}</a></li>
                           <?php endforeach ?>
                       </ul>
                   </div>
               <?php endforeach ?>
               </div>
           </div>
            <div class="footer-bottom">
                <div class="container">
					<div class="row w-100">
						<div class="col-12 col-lg-6 mb-3">
							<div class="row w-100">
								<div class="col-12 col-lg-12 text-center text-lg-left">
									<p class="mr-1">@lang('home.footer_rights')</p> 
									<a class="d-inline-block" href="https://road9media.com/" target="_blank">Road9 Media</a>
								</div>
								<a class="col-6 col-lg-4 text-center text-lg-left mr-0 mt-2" href="{{route('terms')}}" title="">@lang('home.footer_terms')</a>
								<a class="col-6 col-lg-4 text-center text-lg-left mr-0 mt-2" href="{{route('privacy-policy')}}" title="">@lang('home.footer_privacy')</a>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="row w-100">
								<div class="col-12 col-lg-6 text-center text-lg-left mb-3">
									<img src="{{asset('images/mastercard.png')}}" alt="">
									<img src="{{asset('images/fawry.png')}}" alt="">
									<img src="{{asset('images/visa.png')}}" alt="">
								</div>
								<div class="col-12 col-lg-6 text-center text-lg-left" col-md-6>
									<img src="{{asset('images/app-store.png')}}" alt="">
									<img src="{{asset('images/play-store.png')}}" alt="">
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="{{asset('js/addressAutoComplete.min.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAywsfsOy8AVT6sAMqp_INwzXcO47PtED0&libraries=places&callback=RunMaps&language= en-AU"></script>
    <script type="text/javascript">     
        $('body').on('change', 'input[type="file"]', function() {
            var filesize = (this.files[0].size/1024)/1024;
            if (filesize > 5) {
              $(this).val('').clone(true);
              swal("@lang('general.exedmaxfilesize')","","error");           
            }
        });
        @if(session('account_activated') || session('loginform_message'))
        $('#loginModal').modal('show');
        @endif
        @if(app('request')->session()->get('account_activated'))
            $('#loginModal').modal('show');
            $('.LoginErrors').removeClass('d-none')
                             .removeClass('alert-danger')
                             .addClass('alert-success')
                             .text("{{ app('request')->session()->get('account_activated') }}");
        @endif
        @if(session('UserRegInfo'))
        $('#registerModal').modal('show');
        @endif
        <?php $newreg = session('newreg'); ?>
        @if($newreg)
        $('#{{$newreg['membertype']}}').modal('show');
        $('#{{$newreg['membertype']}} input[name="ud_id"]').val('{{$newreg['ud_id']}}');
        $('#{{$newreg['membertype']}} input[name="first_name"]').val('{{$newreg['first_name']}}');
        $('#{{$newreg['membertype']}} input[name="last_name"]').val('{{$newreg['last_name']}}');
        $('#{{$newreg['membertype']}} input[name="email"]').val('{{$newreg['email']}}');
        $('#{{$newreg['membertype']}} input[name="username"]').val('{{$newreg['username']}}');
        $('#{{$newreg['membertype']}} input[name="facebook"]').val('{{$newreg['facebook']}}');
        @endif
    </script>
</body>

</html>