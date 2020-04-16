<!doctype html>
<html lang="{{ app()->getLocale() }}">

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
    <meta property="og:url"         content="{{url()->current()}}" />
    <meta property="og:type"        content="{{config('meta.type')}}" />
    <meta property="og:title"       content="@yield('title')" />
    <meta property="og:description" content="{{config('meta.description')}}" />
    <meta property="og:image"       content="{{config('meta.image')}}" />
    <!-- ==================== meta end facebook ===================== -->
    <meta name="theme-color" content="#ffffff">
    <!-- jQuery UI CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset('css/jquery-ui.structure.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <!-- Bootstrap CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font awesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <!-- <link type="text/css" rel="stylesheet" href="{{asset('css/swiper.min.css')}}"> -->
    <!-- Site CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Modernizer -->
    <script src="{{asset('js/modernizr.custom.js')}}"></script>
    <!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>


    <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
    <script src="{{asset('js/simplebar.js')}}"></script>
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5a7350012fd34b00134b0df8&product=inline-share-buttons-wp' async='async'></script>
    <script type="text/javascript">
        function reloadAsGet() {
            var loc = window.location;
            window.location = loc.protocol + '//' + loc.host + loc.pathname + loc.search;
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
        <header class="container-fluid" style="display:flex;">
            <a href="{{route('home')}}" class="logo" title="home"><img src="{{asset('images/logo.png')}}" alt="logo"></a>
            @yield('search')
            <div class="top-nav">
                <button type="button" id="trigger-overlay" class="tcon tcon-menu--xcross" aria-label="toggle menu">
                    <span class="tcon-menu__lines" aria-hidden="true"></span>
                    <span class="tcon-visuallyhidden">toggle menu</span>
                </button>

                <div class="btn-group btn-group-sm" role="group" aria-label="login and register">
                    @if (Route::has('login'))
                        @if (Auth::check())
                        <div class="user-welcome dropdown-toggle" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div class="user-img-sm">
								<div class="user-img-sm-container">
									<img src="{{ Flexihelp::get_file(Auth::user()->avatar,'user',20) }}" alt="user image">
								</div>
							</div>  
                            <p>Welcome, {{ Auth::user()->username }}</p>
                            @if (!Auth::guest())
                                @if (!Auth::user()->hasRole('admin'))
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                    @if(session('member_type') === 1)
                                    <a href="{{route('switch',['supplier','url'=>url()->current()])}}" onclick='event.preventDefault(); window.location.href= "{{route('switch',['supplier','url'=>url()->current()])}}";' class="dropdown-item text-white">Take me to my Gighunter account</a>
                                    @elseif(session('member_type') === 0)
                                    <a href="{{route('switch',['customer','url'=>url()->current()])}}" onclick='event.preventDefault(); window.location.href= "{{route('switch',['customer','url'=>url()->current()])}}";' class="dropdown-item text-white">Take me to my Headhunter account</a>
                                    @endif
                                    @if(session('member_type') === 1)
                                    <a class="dropdown-item text-white" href="{{url('customer/dashboard/posts')}}" onclick='event.preventDefault(); window.location.href= "{{url('customer/dashboard/posts')}}";' >My Dashboard</a>
                                    @elseif(session('member_type') === 0)
                                    <a class="dropdown-item text-white" href="{{url('supplier/dashboard/services')}}" onclick='event.preventDefault(); window.location.href= "{{url('supplier/dashboard/services')}}";' >My Dashboard</a>
                                    @endif
                                    <a href="{{ route('logout') }}" class="dropdown-item text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                </div>
                                 @endif
                            @endif
                        </div>
                        @else
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#loginModal">Login</button>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#registerModal">Register</button>
                        @endif
                    @endif
                </div>
                <div class="social">
                    <a href="#" title="facebook"><i class="icon-facebook"></i></a>
                    <a href="#" title="linkedin"><i class="icon-linkedin"></i></a>
                    <a href="#" title="twitter"><i class="icon-twitter"></i></a>
                    <a href="#" title="instgram"><i class="icon-instagram"></i></a>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">AR</a>
                        </div>  
                    </div>
                </div>
				<div class="beta-label position-absolute">
				</div>
			</div>
            <div class="overlay overlay-slidedown">
                <div class="container-fluid">
                    <button type="button" id="close-overlay" class="tcon tcon-menu--xcross tcon-transform close-overlay-btn" aria-label="toggle menu">
                        <span class="tcon-menu__lines" aria-hidden="true"></span>
                        <span class="tcon-visuallyhidden">toggle menu</span>
                    </button>
                    <i class="to-level-1 icon-angle-left ml-2 float-left position-absolute d-none" ></i>
                </div>
                <i class="icon-angel-right"></i>
                <nav aria-labelledby="main navigation">
                    <ul class="nav-level-1">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('service_categories')}}">Categories</a></li>
                        <li><a href="{{route('gigs')}}">Gigs</a></li>
                        @if (!Auth::guest())
                            @if (Auth::user()->hasRole('admin'))
                            <li><a href="{{url('admin/dashboard/services')}}">My Dashboard</a></li>
                            @else
                                @if(session('member_type') === 1)
                                <li><a href="{{url('customer/dashboard/posts')}}">My Dashboard</a></li>
                                @elseif(session('member_type') === 0)
                                <li><a href="{{url('supplier/dashboard/services')}}">My Dashboard</a></li>
                                @endif
                            @endif
                        @endif
                        <li id="help-element"><a href="#" class="help" >Help <i class="icon-angle-right ml-2"></i></a></li>
                        <li class="d-lg-none">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">AR</a>
                                </div>  
                            </div>
                        </li>
                        <!-- <li><a href="#">Language 
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">AR</a>
                                </div>  
                            </div>
                            </a>
                        </li> -->
                        @if (Auth::guest())
                        <li><a href="#loginModal" data-toggle="modal">Login</a></li>
                        @else
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                                class="close-overlay-btn">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @endif

                        <li>
                            <div class="social">
                                <a href="#" title="facebook"><i class="icon-facebook"></i></a>
                                <a href="#" title="linkedin"><i class="icon-linkedin"></i></a>
                                <a href="#" title="twitter"><i class="icon-twitter"></i></a>
                                <a href="#" title="instgram"><i class="icon-instagram"></i></a>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav-level-2 d-none">
                        <li><a href="" class="text-capitalize">FAQs</a></li>
                        <li><a href="" class="text-capitalize">Contact us</a></li>
                        <li><a href="" class="text-capitalize">how it works</a></li>
                        <li><a href="" class="text-capitalize">terms & conditions</a></li>
                        <li><a href="" class="text-capitalize">privacy policy</a></li>                       
                        <li><a href="" class="text-capitalize">refund policy</a></li>
                    </ul>
                    <script>
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
            <div class="container footer-top">
                <div class="row">
                <?php
                $footer_categories = DB::table('categories')->where('parent_id', 0)->get();
                 foreach ($footer_categories as $footercat): ?>
                    <div class="col-lg-2">
                        <a href="{{url($footercat->slug)}}">{{$footercat->name}}</a>
                        <ul>
                            <?php
                            $children = DB::table('categories')->where('parent_id', $footercat->id)->get();
                            foreach ($children as $child): ?>
                            <li><a href="{{url($footercat->slug.'/'.$child->slug)}}" title="">{{$child->name}}</a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endforeach ?>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div>
                        <p>© 2017- FelxiGigs. All rights reserved. Designed & Developed by Road9 Media</p>
                        <a href="#" title="">View Terms & Conditions</a>
                        <a href="#" title="">View Privacy policy</a>
                    </div>
                    <div>
                        <img src="{{asset('images/mastercard.png')}}" alt="">
                        <img src="{{asset('images/bank.png')}}" alt="">
                        <img src="{{asset('images/visa.png')}}" alt="">
                        <img src="{{asset('images/app-store.png')}}" alt="">
                        <img src="{{asset('images/play-store.png')}}" alt="">
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('js/addressAutoComplete.js')}}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAywsfsOy8AVT6sAMqp_INwzXcO47PtED0&libraries=places&callback=RunMaps&language= en-AU "></script>    
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
<!--     <script src="{{asset('js/bootstrap.min.js')}}"></script> -->
    <!-- <script src="{{asset('js/swiper.min.js')}}"></script> -->
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/classie.js')}}"></script>
    <script src="{{asset('js/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').removeClass('loading');
            $('.preloader').addClass('d-none');
        });
        @if(app('request')->session()->get('account_activated') || app('request')->session()->get('loginform_message'))
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
        // http://hifny.com/crowd/public/login/facebook?membertype=findagig
    </script>
</body>

</html>
