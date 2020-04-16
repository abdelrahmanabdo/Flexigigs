@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-6">
				<h1 class="text-uppercase text-primary m-0 text-left">headhunter dashboard</h1>
			</div>
			<div class="col-6">
				<nav aria-label="breadcrumb" role="navigation">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
						<li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
			@include('customer.parts.sidecard')
			<div class="filter position-relative">
				<h2>@lang('general.filter_title')</h2>
				<form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
					<button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
					<label class="form-group has-float-label mt-5 mb-0">
						<input type="text" name="search" value="" placeholder="@lang('general.filter_search')" class="form-control border-0">
						<span for="searchFilter">@lang('general.filter_search')</span>
						<i class="fas fa-search filter-search-input-icon"></i>			
					</label>
					<hr>
					<label class="form-group has-float-label mt-5 mb-0">
						<input type="text" name="from" value="" placeholder="@lang('general.filter_deadline_range_from')" class="form-control border-0">
						<span for="searchFilter">@lang('general.filter_deadline_range_from')</span>
						<i class="fas fa-search filter-search-input-icon"></i>			
					</label>
					<hr>
					<button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
				</form>
			</div>
            
        </div>
        <div class="col-md-8">
            @include('customer.parts.nav')
            <div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="myMessages" role="tabpanel">
					<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_messages')</p>
                    <div id="messagesList" data-children=".item">
                      <style type="text/css">
                      .scrollable {
                          max-height: 200px;
                      }
                      </style>
                          <div class="item text-center msgloader d-none">
                              <img class="img-fluid my-0 mx-auto" src="{{asset('images/Preloader.gif')}}">
                           </div>
                           <div class="item text-center noResult">
								<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
							</div>
                      </div>
                      <script type="text/javascript">
                          function loadmessages(page,limit) {
                              $.post('{{route("customer_mymessages",[$userdata->id])}}',
                              { page: page,
                                limit:limit,
                                type:"customer",
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
                              loadmessages();
                              window.setInterval(function(){
                                  loadmessages();
                              }, 1200000);
                          });
                      </script>
                    @include('customer.messages.parts.send')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection