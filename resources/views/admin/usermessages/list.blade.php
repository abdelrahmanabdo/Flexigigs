@extends('layouts.home') 
@section('title', trans('home.menu_my_dashboard')." | ".trans('general.dashboard_nav_usersmessages')) 
@section('bodyClass', 'inner dashboard') 
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
	<nav aria-label="breadcrumb" role="navigation">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{route('home')}}">@lang('home.title')</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
			<li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_nav_usersmessages')</li>
		</ol>
	</nav>
</div>
<section class="container">
	<div class="row">
		<div class="col-md-4">
			@include('admin.parts.sidecard')
			@include('admin.usermessages.search')
		</div>
		<div class="col-md-8">
			@include('admin.parts.nav')
			<div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="myMessages" role="tabpanel">
					<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_usersmessages')</p>
                    <div id="messagesList" data-children=".item">
						<style type="text/css">
						.scrollable {
						  max-height: 200px;
						}
						</style>
                      	<div class="item text-center msgloader d-none">
                          <img class="img-fluid my-0 mx-auto" src="{{asset('images/Preloader.gif')}}">
                       </div>
                       <div class="item text-center noResult d-none">
                          <p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
                       </div>
                    </div>
					<script type="text/javascript">
						function loadmessages(page,limit) {
					      $.post('{{route("usermessages")}}',
					      { page: page,
					        limit:limit,
					        type:"admin",
					        from:"{{@$_GET['from']}}",
					        to:"{{@$_GET['to']}}",
					        date_from:"{{@$_GET['date_from']}}",
					        date_to:"{{@$_GET['date_to']}}",
					        _token:$('meta[name="csrf-token"]').attr('content') } 
					      , function( data ) {
					        $( ".msgloader" ).removeClass('d-none');
					        $( ".noResult" ).addClass('d-none');
					      }).done( function( result ) {
					          $('.msgbox').remove();
					          $('#messagesList').append(result);

					      })
					      .fail(function(errors) {
					          if (!errors.responseJSON.status) {
					              $('.noResult').removeClass('d-none');
					          }
					      })
					      .always(function() {
					          $( ".msgloader" ).addClass('d-none');
					      });
					  	}
					  	$( document ).ready(function (e) {
					      loadmessages({{(@$_GET['page'])?@$_GET['page']:1}},5);
					      window.setInterval(function(){
					          loadmessages({{(@$_GET['page'])?@$_GET['page']:1}},5);
					      }, 1200000);
					  	});
					</script>
                </div>
            </div>
		</div>
	</div>
</section>

@endsection