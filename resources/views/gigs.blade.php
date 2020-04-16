@extends('layouts.home')
@section('title', 'propsed gigs')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<!-- /header -->
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('gigs.title')</li>
        </ol>
    </nav>
    <h1 class="text-uppercase">@lang('gigs.list_title')</h1>
    <p>@lang('gigs.list_desc')</p>
</div>
<section id="gigs-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5 col-lg-3">
                <div class="filter">
                    <h2>@lang('general.filter_title')</h2>
                    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
                        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
                        <div class="form-group">
                            <label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
                            <span>
                            <input type="text" name="free_text" value="{{@$_GET['free_text']}}" placeholder="@lang('general.filter_search')" class="form-control">
                        </span>
                        </div>
                        <div class="form-group" id="parent">
                            <label class="text-hide" for="gig">@lang('general.filter_select_cat')</label>
                            <select class="form-control" id="parentselector" name="parent" required>
                                <option value="">-@lang('general.filter_select_cat')-</option>
                                @foreach($parents_categories as $cat):
                                <option value="{{$cat->slug}}" <?=($parent['slug']==$cat->slug)?"selected":"";?>>{{(app()->getLocale()=="ar")?$cat->name_ar:$cat->name}}</option>
                                @endforeach
                            </select>
                            <script type="text/javascript">
                                $('#parentselector').on('change',function (e) {
                                    $.post('{{url(app()->getLocale()."/category/dependancy")}}',
                                            { _token:$('meta[name="csrf-token"]').attr('content'),
                                            slug: $('#parentselector').val(),
                                            stage: 1
                                            })
                                    .done(function(content){
                                        $( "#sub" ).empty().append( content );
                                        $( "#subsub" ).empty();
                                    });
                                });
                            </script>
                        </div>

                        <div class="form-group" id="sub">
                            <label class="text-hide" for="gig">@lang('general.filter_select_cat')</label>
                            <select class="form-control" name="sub" id="subselector" required>
                                <option value="">-@lang('general.filter_select_cat')-</option>
                                @foreach($sub_categories as $subcat):
                                <option value="{{$subcat->slug}}" <?=($sub['slug']==$subcat->slug)?"selected":"";?>>{{(app()->getLocale()=="ar")?$subcat->name_ar:$subcat->name}}</option>
                                @endforeach
                            </select>
                            <script type="text/javascript">
                                $('#subselector').on('change',function (e) {
                                    $.post('{{url(app()->getLocale()."/category/dependancy")}}',
                                            { _token:$('meta[name="csrf-token"]').attr('content'),
                                            slug: $('#subselector').val(),
                                            stage: 2
                                            })
                                    .done(function(content){
                                        $( "#subsub" ).empty().append( content );
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-group" id="subsub">
                        @if(empty($subsub_categories))
                            <label class="text-hide" for="gig">@lang('general.filter_select_cat')</label>
                            <select class="form-control" name="subsub" required>
                                <option value="">-@lang('general.filter_select_cat')-</option>
                                @foreach($subsub_categories as $subsubcat):
                                <option value="{{$subsubcat->slug}}" <?=($subsub['slug']==$subsubcat->slug)?"selected":"";?>>{{(app()->getLocale()=="ar")?$subsubcat->name_ar:$subsubcat->name}}</option>
                                @endforeach
                            </select>
                        @endif
                        </div>


						<!-- New code from ashraf -->
						<div class="form-group">
                            <button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#delivery" aria-expanded="true" aria-controls="delivery">
                                @lang('general.delivery_time')
                                <i class="fas fa-angle-down"></i>
                            </button>
                            <div class="collapse show" id="delivery">
                                <div>
                                    <input type="radio" id="test1"  name="up_to" value="" <?=(!@$_GET['up_to'])?"checked":"";?>>
                                    <label class="text-dark h6 my-2" for="test1">@lang('general.any')</label>
                                </div>
                                <div>
                                    <input type="radio" id="test2" name="up_to" value="1" <?=(@$_GET['up_to']==1)?"checked":"";?>>
                                    <label class="text-dark h6 my-2" for="test2">@lang('general.up_to_1_day')</label>
                                </div>
                                <div>
                                    <input type="radio" id="test3" name="up_to" value="3" <?=(@$_GET['up_to']==2)?"checked":"";?>>
                                    <label class="text-dark h6 my-2" for="test3">@lang('general.up_to_3_day')</label>
                                </div>
                                <div>
                                    <input type="radio" id="test4" name="up_to" value="7" <?=(@$_GET['up_to']==7)?"checked":"";?>>
                                    <label class="text-dark h6 my-2" for="test4">@lang('general.up_to_7_day')</label>
                                </div>
                            </div>
                        </div>
						<hr>

						<div class="form-group priceRange">
                            <label for="priceRange">@lang('general.filter_price_range')</label>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center justify-content-start">
                                    <input class="border px-1 py-2" type="number" id="price-from" name="price_from" value="{{(@$_GET['price_from'])}}" placeholder="@lang('general.from')">
                                    <p class="m-0 font-weight-bold">@lang('general.egp')</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <input class="border px-1 py-2" type="number" id="price-to" name="price_to" value="{{(@$_GET['price_to'])}}" placeholder="@lang('general.to')">
                                    <p class="m-0 font-weight-bold">@lang('general.egp')</p>
                                </div>
                            </div>
                        </div>
						<hr>
						<div class="form-group">
							<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#relevant-to" aria-expanded="true" aria-controls="relevant-to">
								relevant to
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="collapse show" id="relevant-to">
								<div>
									<input type="radio" id="test5" name="supplier_type" value="" <?=(!@$_GET['supplier_type'])?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test5">@lang('general.any')</label>
								</div>
								<div>
									<input type="radio" id="test6" name="supplier_type" value="freelancer" <?=(@$_GET['supplier_type']=="freelancer")?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test6">@lang('general.freelancer')</label>
								</div>
								<div>
									<input type="radio" id="test8" name="supplier_type" value="partimer" <?=(@$_GET['supplier_type']=='partimer')?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test8">@lang('general.partimer')</label>
								</div>
								<div>
									<input type="radio" id="test9" name="supplier_type" value="intern" <?=(@$_GET['supplier_type']=='intern')?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test9">@lang('general.intern')</label>
								</div>
							</div>
						</div>
						<hr>
                        <button type="submit" class="btn btn-default btn-block">@lang('general.filter_submit_button')</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-12 col-md-7 col-lg-9">
                <div class="row mb-3 pt-0">
                    <div class="col-sm-12">
                        <div class="float-right form-group">
                            <select class="form-control alt sort-DropDown sorter" name="sortby">
                                <option value="">@lang('general.sort_title')</option>
                                <option value="price_desc" {{(@$_GET['sort_by']=="price_desc")?"selected":""}}>@lang('general.sort_option_price_DESC')</option>
                                <option value="price_asc" {{(@$_GET['sort_by']=="price_asc")?"selected":""}}>@lang('general.sort_option_price_ASC')</option>
                                <option value="created_asc" {{(@$_GET['sort_by']=="created_asc")?"selected":""}}>@lang('general.sort_option_creaetd_ASC')</option>
                                <option value="created_desc" {{(@$_GET['sort_by']=="created_desc")?"selected":""}}>@lang('general.sort_option_created_DESC')</option>
                                <option value="deadline_desc" {{(@$_GET['sort_by']=="deadline_desc")?"selected":""}}>@lang('general.sort_option_deadline_DESC')</option>
                                <option value="deadline_asc" {{(@$_GET['sort_by']=="deadline_asc")?"selected":""}}>@lang('general.sort_option_deadline_ASC')</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row d-flex">
                @if($status)
                @foreach($gigs_pagination as $gig)
                <div class="col-sm-12 col-lg-6 col-xl-4 d-flex flex-row align-items-stretch">
                    <div class="service-thumb proposed d-flex flex-column justify-content-between ml-0 mr-0 w-100">
                        <a href="{{route('gig_details',['id'=>$gig->id])}}">
							<h3 class="service-title text-truncate" style="white-space:pre-wrap;">{{$gig->title}}</h3>
                            <small class="d-block">@lang('gigs.single_submitted_on') {{Flexihelp::defult_date($gig->created_at)}}</small>
                            <small class="d-block">@lang('gigs.single_deadline_on') {{Flexihelp::defult_date($gig->deadline)}}</small>
                            <div class="service-desc text-truncate">
                                <div class="price">
                                    <p>{{number_format($gig->price)}} @lang('general.gig_price_unit_EGP')</p>
                                </div>
								<p class="service-desc-text m-0">{{$gig->description}}</p>
								<script>
									$(document).ready(function(){
										var $desc = $('.service-desc-text');
										var $title= $('.service-title');
										$desc.each(function(){
											var $descArr = $(this).text().split(" ").slice(0, 15).join(' ');
											$(this).text($descArr);
										});
										$title.each(function(){
											var $titleArr = $(this).text().split(" ").slice(0, 6).join(' ');
											$(this).text($titleArr);
										});
									});
								</script>
                            </div>
                            <div class="service-skills">
                                <label>@lang('general.gig_skills')</label>
                                <div class="d-flex flex-row align-items-start flex-wrap justify-content-start">
                                    <?php $i = 0 ?>
                                    @foreach($gig->skills as $skill)
                                    <?php
                                    $i++;
                                    if ($i<3): ?>
                                    <span class="badge m-1">{{(app()->getLocale()=="ar"&&$skill->category->name_ar)?$skill->category->name_ar:$skill->category->name}}</span>
                                    <?php endif ?>
                                    @endforeach
                                    @if(count($gig->skills)>2)
                                    <span class="my-1">+<?=count($gig->skills)-2?></span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="service-footer d-flex flex-row justify-content-between align-items-end">
                            <a href="{{route('gig_details',['id'=>$gig->id])}}">@lang('general.gig_view_more')</a>
                            @if($gig['is_apply'])
							 <span class="bg-primary text-white text-capitalize font-weight-bold position-absolute px-4 py-3" style="right:15px;bottom: 30px;">@lang('general.gig_applied')</span>
                            @endif
                            <!-- <a href="{{route('gig_details',['id'=>$gig->id])}}" data-toggle="modal">Apply</a> -->
                        </div>
                    </div>
                </div>
                @endforeach
                    {{$gigs_pagination->links()}}
                @else
                    <!-- <p class="noresultfound">{{trans('general.noresult.'.Request::segment(2))}}</p> -->
					<!-- <div class="item text-center noResult">
						<img class="img-fluid my-0 mx-auto noResult-img" src="{{asset('images/no-result_'.app()->getlocale().'.png')}}">
					</div> -->
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
    $('.sorter').change(function () {
        url = window.location.href
        if(url.indexOf("?") > -1) {
           window.location =url+"&sort_by="+$(this).val();
        }else{
           window.location =url+"?sort_by="+$(this).val();
        }
    })
</script>
@endsection