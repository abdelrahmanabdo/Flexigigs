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
			<div class="filter" style="position: relative;">
				<h2>@lang('general.filter_title')</h2>
				<form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
					<button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
					<div class="form-group">
						<label class="text-hide" for="searchFilter">search filter</label>
						<span>
							<input name="free_text" placeholder="Search" value="" class="form-control" type="text">
						</span>
					</div>
					<label class="form-group has-float-label mt-5 mb-0">
						<input type="text" name="from" value="" placeholder="@lang('messages.from')" class="form-control border-0">
						<span for="searchFilter">@lang('messages.from')</span>
						<i class="fas fa-search filter-search-input-icon"></i>
					</label>
					<hr>
					<button type="submit" class="btn btn-default btn-block">@lang('general.button_filter')</button>
				</form>
			</div>
        </div>


        <div class="col-md-8">
			<div class="container">
				<div class="row">
					<div class="item singleMessage-header col-12">
						<!-- <a href="#" class="btn btn-primary btn-lg">
							<span class="fas fa-angle-left"></span>
							back to messages
						</a> -->
						<a href="#" class="btn btn-primary btn-lg">
							<span class="fas fa-angle-left"></span>
							back to Search
						</a>
					</div>
					<p class="lato-bold text-capitalize h4 mt-4">search: </p>
					<div class="item singleMessage-content my-4 col-12">
						<div class="singleMessage-content-list side-scroll px-2 mb-4">
							<div class="row py-4">
								<div class="item col-12 py-3 my-1 singleMessage-content-single">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-2 col-md-1  text-center p-lg-0">
													<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
												</div>
												<div class="col-10 col-md-11 pl-0">
													<div class="d-flex align-items-center justify-content-between">
														<h4 class="text-capitalize">username</h4>
														<h5 class="pr-2 pr-md-0">12-11-2017</h5>
													</div>
													<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
													<div class="singleMessage-content-files">
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item col-12 py-3 my-1 singleMessage-content-single">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-2 col-md-1  text-center p-lg-0">
													<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
												</div>
												<div class="col-10 col-md-11 pl-0">
													<div class="d-flex align-items-center justify-content-between">
														<h4 class="text-capitalize">username</h4>
														<h5 class="pr-2 pr-md-0">12-11-2017</h5>
													</div>
													<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
													<div class="singleMessage-content-files">
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item col-12 py-3 my-1 singleMessage-content-single">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-2 col-md-1  text-center p-lg-0">
													<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
												</div>
												<div class="col-10 col-md-11 pl-0">
													<div class="d-flex align-items-center justify-content-between">
														<h4 class="text-capitalize">username</h4>
														<h5 class="pr-2 pr-md-0">12-11-2017</h5>
													</div>
													<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
													<div class="singleMessage-content-files">
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
														<a href="#" target="_blank">Word file.docx</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item col-12 py-3 my-1 singleMessage-content-single">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-2 col-md-1  text-center p-lg-0">
													<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
												</div>
												<div class="col-10 col-md-11 pl-0">
													<div class="d-flex align-items-center justify-content-between">
														<h4 class="text-capitalize">username</h4>
														<h5 class="pr-2 pr-md-0">12-11-2017</h5>
													</div>
													<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
													
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item col-12 py-3 my-1 singleMessage-content-single">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-2 col-md-1  text-center p-lg-0">
													<img class="rounded-circle img-fluid" src="http://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="">
												</div>
												<div class="col-10 col-md-11 pl-0">
													<div class="d-flex align-items-center justify-content-between">
														<h4 class="text-capitalize">username</h4>
														<h5 class="pr-2 pr-md-0">12-11-2017</h5>
													</div>
													<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore id ea earum nobis iure cupiditate voluptatem tenetur perferendis libero rerum nihil dolorem nulla delectus consectetur saepe ad, vel porro illo?</p>
													<div class="singleMessage-content-files">
														<a href="#" target="_blank">Word file.docx</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="singleMessage-content-footer bg-light">
							<div class="row p-4">
								<div class="col-12">
									<h4 class="text-body text-uppercase font-weight-bold">@lang('general.button_reply')</h4>
								</div>
								<div class="col-12 mt-5">
									<form action="#" class="row">
										<div class="col-12 col-md-5 d-flex align-items-center">
											<div class="form-group w-100 m-0">
												<textarea name="msg" maxlength="2500" class="form-control bg-transparent px-0 py-3 counted send-msg" rows="3" placeholder="@lang('messages.messages.title')"></textarea>
												<p class="char text-secondary text-right m-0">0/200</p>
												<p class="d-none help-block"></p>
											</div>
										</div>
										<div class="col-12 col-md-4 d-flex align-items-center">
											<label class="custom-file mt-2 d-flex flex-column">
												<input type="file" class="custom-file-input pl-0" accept=".doc, .docx, .pdf, .jpg, .png, .gif">
												<p class="help-block d-none"><strong></strong> </p>
												<p class="custom-file-control"></p>
												<small class="text-secondary mt-4"><em>(Doc, Docx, PDF, JPG, PNG, GIF)</em></small>
											</label>
										</div>
										<script>
											$(document).ready(function(){
												// change image name
												$('body').on('change', 'input[type="file"]', function() {
													var input = $(this),
														numFiles = input.get(0).files ? input.get(0).files.length : 1,
														label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
													input.trigger('fileselect', [numFiles, label]);
												});
												$('body').on('fileselect','.custom-file-input', function(
													event,
													numFiles,
													label
												) {
													$(this).siblings('.custom-file-control').text(label);
												});


											});
										</script>
										<div class="col-12 col-md-3 d-flex align-items-center mt-5 mt-md-0">
											<button type="submit" class="btn btn-primary btn-lg btn-block py-3 text-uppercase">@lang("general.button_send")</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>

    </div>
</section>
@endsection