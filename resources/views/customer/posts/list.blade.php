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
						<li class="breadcrumb-item active" aria-current="page">@lang('general.dashboard_my')</li>
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
            @include('customer.posts.search')
        </div>
        <div class="col-md-8">
            @include('customer.parts.nav')
            <div class="tab-content mt-4" id="dashboardTabsContent">
                <div class="tab-pane fade show active" id="myPosts" role="tabpanel">
					<p class="lato-bold text-capitalize mb-3 h4">@lang('general.dashboard_nav_my_gigs')</p>
                    @include('customer.posts.add')
                    @if (count($posts))
                    <div id="admin-gigs">
                        <div id="gigsList" data-children=".item">
                            @foreach($posts as $post)
                                @if ($post->status == 0)
                                    @if (count($post->applications))
                                        @include('customer.posts.itemWithSupplier')
                                    @else
                                        @include('customer.posts.item')
                                    @endif
                                @else
                                    @include('customer.posts.item')
                                @endif
                            @endforeach
                        </div>
                        <div class="row mt-5">
                        {{$posts->links()}}
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
    function copyfornewgig(id,type) {
        $('#gigPost').removeClass('d-none');
        if (type=="repost") {
            $('#add_gig input[name=repost]').val(id);
        }else{
            $('#add_gig input[name=repost]').val(0);
        }
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
        $('#keySkills').trigger('chosen:updated');;
        $('#skills').val(skills);
        window.scrollTo(0,100);
    }
    function cancelgig(id) {
        swal({
          title: "@lang('gigs.dashboard_customer_posts_confirm.title')",
          text: "@lang('gigs.dashboard_customer_posts_confirm.text')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/gigcancel")}}/'+id,
                    data:{"status":4},
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    type: 'POST',
                    success: function(result) {
                        swal("@lang('gigs.dashboard_customer_posts_confirm.canceld')", "@lang('gigs.dashboard_customer_posts_confirm.canceld_msg')", "success").then(function(canceld){
                            if (canceld) {
                                window.location.replace('{{url()->current()}}');
                            }
                        });

                    }
                });
          }
        });
    }
</script>
@endsection