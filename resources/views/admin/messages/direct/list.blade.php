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
            <li class="breadcrumb-item active" aria-current="page">@lang('general.sort_option_direct_msg')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
            @include('admin.messages.direct.search')
        </div>
        <div class="col-md-8">
            @include('admin.parts.nav')
            <div class="tab-content" id="dashboardTabsContent">
              <div class="row mb-3 pt-0">
                <div class="col-12 d-flex align-items-center justify-content-between"> 
					<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_messages')</p>
                  <div class="float-right form-group my-3">
                      <select class="form-control alt sort-DropDown sorter">
                          <option>@lang('general.sort_option_conflect_msg')</option>
                          <option selected>@lang('general.sort_option_direct_msg')</option>
                      </select>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show active" id="myMessages" role="tabpanel">
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
                          <img class="img-fluid my-0 mx-auto" src="{{asset('images/no-result_'.app()->getlocale().'.png')}}">
                       </div>
                  </div>
                  <script type="text/javascript">
                      function loadmessages(page=0,limit=10) {
                          $.post('{{route("mymessages",[$userdata->id])}}',
                          { page: page,
                            limit:limit,
                            from:"{{ request()->has('from') ? request()->get('from') : '' }}",
                            type:"admin.messages.direct",
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
                </div>
                @include('admin.messages.direct.parts.send')
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $('.sorter').change(function () {
      window.location ="{{route('admin_messages')}}";
    })
</script>
@endsection