@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
@include('parts.notavilable_modal')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item"><a href="{{route('service_subcategory',['category'=>$parent['slug']])}}">{{(app()->getLocale()=='ar'&&$parent['name_ar'])?$parent['name_ar']:$parent['name']}}</a></li>
            <?php if ($sub['id']!=$category->id): ?>
                <li class="breadcrumb-item"><a href="{{route('service_subcategory2',['category'=>$parent['slug'],'slug'=>$sub['slug']])}}">{{(app()->getLocale()=='ar'&&$sub['name_ar'])?$sub['name_ar']:$sub['name']}}</a></li>
            <?php endif ?>
            <li class="breadcrumb-item active" aria-current="page">{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</li>
        </ol>
    </nav>
    <h1>{{(app()->getLocale()=='ar'&&$category->name_ar)?$category->name_ar:$category->name}}</h1>
    <p>{{(app()->getLocale()=='ar'&&$category->intro_ar)?$category->intro_ar:$category->intro}}</p>
</div>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4">
                <div class="filter">
                    <h2>@lang('general.filter_title')</h2>
                    <form accept-charset="utf-8" onreset="window.location.replace('{{url()->current()}}')">
                        <button type="reset" class="resetForm text-primary">@lang('general.filter_reset')</button>
                        <div class="form-group">
                            <label class="text-hide" for="searchFilter">@lang('general.filter_search')</label>
                            <span>
                            <input type="text" name="free_text" placeholder="@lang('general.filter_search')" value="{{@$_GET['free_text']}}" class="form-control">
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
                        @if(@$subsub_categories)
                            <label class="text-hide" for="gig">@lang('general.filter_select_cat')</label>
                            <select class="form-control" name="subsub" required>
                                <option value="">-@lang('general.filter_select_cat')-</option>
                                @foreach($subsub_categories as $subsubcat):
                                <option value="{{$subsubcat->slug}}" <?=($subsub['slug']==$subsubcat->slug)?"selected":"";?>>{{(app()->getLocale()=="ar")?$subsubcat->name_ar:$subsubcat->name}}</option>
                                @endforeach
                            </select>
                        @endif
						</div>
                        <div class="form-group">
                            <label class="text-hide" for="location">@lang('general.filter_location')</label>
                            <input id="location" name="formated" class="form-control" placeholder="@lang('general.filter_location')" value="<?=(@$_GET['formated'])?@$_GET['formated']:"";?>" />
                            <input type="hidden" name="location" id="country_lat_long" class="latlong" value="<?=(@$_GET['location'])?@$_GET['location']:"";?>" >
                            <script type="text/javascript">
                                function CommonMapFunctions() {
                                    AutoCompleteSearchCity('location','country_lat_long','#location');
                                }
                            </script>
						</div>
						<div class="form-group">
							<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#delivery" aria-expanded="true" aria-controls="delivery">
								@lang('general.delivery_time')
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="collapse show" id="delivery">
								<div>
									<input type="radio" id="test1" name="radio-group1"  name="up_to" value="" <?=(!@$_GET['up_to'])?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test1">@lang('general.any')</label>
								</div>
								<div>
									<input type="radio" id="test2" name="radio-group1" name="up_to" value="1" <?=(@$_GET['up_to']==1)?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test2">@lang('general.up_to_1_day')</label>
								</div>
								<div>
									<input type="radio" id="test3" name="radio-group1" name="up_to" value="3" <?=(@$_GET['up_to']==2)?"checked":"";?>>
									<label class="text-dark h6 my-2" for="test3">@lang('general.up_to_3_day')</label>
								</div>
								<div>
									<input type="radio" id="test4" name="radio-group1" name="up_to" value="7" <?=(@$_GET['up_to']==7)?"checked":"";?>>
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
							<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#availablity" aria-expanded="true" aria-controls="availablity">
								@lang('general.availability')
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="collapse show" id="availablity">
								<div>
									<input type="radio" id="test5" name="availability" value="" {{(!@$_GET['availability'])?"checked":""}}>
									<label class="text-dark h6 my-2" for="test5">@lang('general.any')</label>
								</div>
								<div>
									<input type="radio" id="test6" name="availability" value="1" {{(@$_GET['availability']==1)?"checked":""}}>
									<label class="text-dark h6 my-2" for="test6">@lang('general.available')</label>
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<button class="btn btn-light btn-collapse" type="button" data-toggle="collapse" data-target="#rating" aria-expanded="true" aria-controls="rating">
								@lang('general.Rating')
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="collapse show" id="rating">
								<div>
									<input type="radio" id="test8" name="rating" value="" {{(!@$_GET['rating'])?"checked":""}}>
									<label class="text-dark h6 my-2" for="test8">@lang('general.any')</label>
								</div>
								<div>
									<input type="radio" id="test9" name="rating" value="4" {{(@$_GET['rating']==4)?"checked":""}}>
									<label class="text-dark h6 my-2" for="test9">@lang('general.4andmore')</label>
								</div>
								<div>
									<input type="radio" id="test10" name="rating" value="3" {{(@$_GET['rating']==3)?"checked":""}}>
									<label class="text-dark h6 my-2" for="test10">@lang('general.3andmore')</label>
								</div>
							</div>
						</div>
						<hr>
                        <button type="submit" class="btn btn-default btn-block">@lang('general.filter_submit_button')</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <div class="row mb-3 pt-0">
                    <div class="col-sm-12">
                        <div class="float-right form-group">
                            <select class="form-control alt sort-DropDown sorter" name="sortby">
                                <option disabled selected>@lang('general.sort_title')</option>
                                <option value="price_desc" {{(@$_GET['sort_by']=="price_desc")?"selected":""}}>@lang('general.sort_option_price_DESC')</option>
                                <option value="price_asc" {{(@$_GET['sort_by']=="price_asc")?"selected":""}}>@lang('general.sort_option_price_ASC')</option>
                                <!-- <option value="rating_asc" {{(@$_GET['sort_by']=="rating_asc")?"selected":""}}>@lang('general.sort_option_rating_ASC')</option> -->
                                <option value="rating_desc" {{(@$_GET['sort_by']=="rating_desc")?"selected":""}}>@lang('general.sort_option_rating_DESC')</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($result)
                        @foreach ($result as $service)
                            @include('parts.service.small')
                        @endforeach
                        {{$services_pagination->links()}}
                        @if(session('member_type') === 1)
                            @include('parts.service.add_favorite')
                            @include('parts.service.remove_favorite')
                        @endif
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
