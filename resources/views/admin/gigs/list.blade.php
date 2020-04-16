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
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_my')</li>
            <li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_nav_gigs')</li>
        </ol>
    </nav>
</div>
<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
            @include('admin.gigs.search')
        </div>
        <div class="col-md-8">
            @include('admin.parts.nav')

            <div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="myPosts" role="tabpanel">
					<p class="lato-bold text-capitalize my-3 h4">@lang('general.dashboard_nav_gigs')</p>
                    @include('admin.gigs.add')
                    @if(count($posts))
                    <div id="admin-gigs">
                        <div id="gigsList" data-children=".item">
                            @foreach($posts as $post)
                                @if ($post->status == 0)
                                    @if (count($post->applications))
                                        @include('admin.gigs.itemWithSupplier')
                                    @else
                                        @include('admin.gigs.item')
                                    @endif
                            @else
                                @include('admin.gigs.item')
                            @endif
                            @endforeach
                        </div>
                        <div class="row mt-5">
                            <div class="modal fade export-modal" tabindex="-1" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  onSubmit="$('.export-modal').modal('hide');" method="get" action="{{route('exportgig')}}" target="_blank">
                                            {{csrf_field()}}
                                            <input type="hidden" name="free_text" value="{{ request()->has('free_text') ? request()->get('free_text') : '' }}">
                                            <input type="hidden" name="status" value="{{ request()->has('status') ? request()->get('status') : '' }}">
                                            <input type="hidden" name="date_from" value="{{ request()->has('date_from') ? request()->get('date_from') : '' }}">
                                            <input type="hidden" name="date_to" value="{{ request()->has('date_to') ? request()->get('date_to') : '' }}">
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
                        {{$posts->links('vendor.pagination.withexport')}}
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
<script type="text/javascript">
    function copyfornewgig(id) {
        $('#gigPost').removeClass('d-none');
        $('#add_gig input[name=title]').val($('.gigtitle-'+id).text());
        $('#add_gig input[name=price]').val($('.gigprice-'+id).data('price'));
        $('#add_gig textarea[name=description]').val($('.gigdescription-'+id).text());
        $('#keySkills option').attr('selected', false);
        var skills = $('.gigskills-'+id).text();
        var skill = skills.split(',');
        $.each(skill,function( index,value ) {
            if (value) {
                $('#keySkills option[value=' + value + ']').attr('selected', true);
            }
        });
        $('#keySkills').trigger('chosen:updated');
        $('#skills').val(skills);
        window.scrollTo(0,100);

    }
    function cancelgig(id) {
        swal({
          title: "@lang('gigs.dashboard_admin_gigs_confirm.title')",
          text: "@lang('gigs.dashboard_admin_gigs_confirm.text')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/gigcancel")}}/'+id,
                    data:{"status":4},
                    type: 'POST',
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    success: function(result) {
                        swal("@lang('gigs.dashboard_admin_gigs_confirm.canceld')", "@lang('gigs.dashboard_admin_gigs_confirm.canceld_msg')", "success").then(function(canceld){
                            if (canceld) {
                                window.location.replace('{{url()->full()}}');
                            }
                        });

                    }
                });
          }
        });
    }
</script>
@endsection