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
				<h1 class="text-uppercase text-primary m-0 text-left">gighunter dashboard</h1>
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
            @include('supplier.parts.sidecard')
            @include('supplier.gigs.search')
        </div>
        <div class="col-md-8">
            @include('supplier.parts.nav')
            <div class="tab-content mt-4" id="dashboardTabsContent">
				<p class="lato-bold text-capitalize mb-3 h4">@lang('general.dashboard_nav_my_gigs')</p>

                @if(count($gigs))
                <div class="tab-pane fade show active" id="myGigs" role="tabpanel">
                    <div id="gigsList" data-children=".item">
                        @foreach( $gigs as $gig)
                            @if($gig->type == 1 && $gig->request)
                                @include('supplier.gigs.item.service_order')
                            @elseif($gig->type == 2 &&$gig->application)
                                @include('supplier.gigs.item.gig_order')
                            @endif
                        @endforeach
                    </div>
                    <div class="row mt-5">
                        {{$gigs->links()}}
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
</section>
<script type="text/javascript">
    $(".cant-say-done").click(function(){
        swal({title: "@lang('general.alert.cantSayDone.title')",
              text: "@lang('general.alert.cantSayDone.body')",
              icon: "warning",
              dangerMode: true,});
    });
    $(".sorter").change(function () {
        url = window.location.href;
        if(url.indexOf("?") > -1) {
           window.location =url+"&sort_by="+$(this).val();
        }else{
           window.location =url+"?sort_by="+$(this).val();
        }
    })
</script>
@include("supplier.gigs.done")
@include("supplier.gigs.reject")
@include("supplier.gigs.conflect")
@include("supplier.gigs.review")
@endsection