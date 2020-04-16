@extends('layouts.home')
@section('title', trans('home.menu_my_dashboard').' | '.trans('service_category.dashboard_categories_title'))
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin_services')}}">@lang('home.menu_my_dashboard')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('service_category.dashboard_categories_title')</li>
        </ol>
    </nav>
</div>

<section class="container">
    <div class="row">
        <div class="col-md-4">
            @include('admin.parts.sidecard')
        </div>
         <div class="col-md-8">
         	@if (count($parent_categories))

            <div id="admin_categoriesList" data-children=".item">
                <div class="d-flex justify-content-end pt-4 mb-4">
                    <a href=".add-category" data-toggle="modal" class="btn btn-primary">@lang('service_category.dashboard_admin_add_category')</a>
				</div>
				@foreach($parent_categories as $parent)
                <div class="item category-{{$parent->id}}">
					<div class="item-trigger collapsed" data-toggle="collapse" data-parent="#admin_categoriesList" data-target="#parent-{{$parent->id}}" aria-expanded="false">
						<div class="item-info-collapsed">
							<span class="mr-auto h4">{{(app()->getLocale()=='ar'&&$parent->name_ar)?$parent->name_ar:$parent->name}}</span>

							<b class="fas fa-plus text-primary mr-3 fa-1x addsub" data-parent_id="{{$parent->id}}"></b>
							<b class="fas fa-pencil-alt text-primary mr-3 fa-1x editCat" data-id="{{$parent->id}}" data-name="{{$parent->name}}" data-name_ar="{{$parent->name_ar}}" data-slug="{{$parent->slug}}" data-intro="{{$parent->intro}}" data-intro_ar="{{$parent->intro_ar}}" data-keywords="{{$parent->keywords}}" data-featured="{{$parent->featured}}" data-icon="{{$parent->icon}}" data-image="{{Flexihelp::get_file($parent->image,null,20)}}"></b>
							<b class="fas fa-trash text-danger mr-3 fa-1x deleteCat" data-deleteid="{{$parent->id}}" data-type="{{count($parent->children)?'parent':'candelete'}}"></b>
                            <i class="icon-angle-down"></i>
						</div>
						<div class="item-info">
							<span class="mr-auto h4">{{(app()->getLocale()=='ar'&&$parent->name_ar)?$parent->name_ar:$parent->name}}</span>
							<b class="fas fa-plus text-primary mr-3 fa-1x addsub" data-parent_id="{{$parent->id}}"></b>
							<b class="fas fa-pencil-alt text-primary mr-3 fa-1x editCat" data-id="{{$parent->id}}" data-name="{{$parent->name}}" data-name_ar="{{$parent->name_ar}}" data-slug="{{$parent->slug}}" data-intro="{{$parent->intro}}" data-intro_ar="{{$parent->intro_ar}}" data-keywords="{{$parent->keywords}}" data-featured="{{$parent->featured}}" data-icon="{{$parent->icon}}" data-image="{{Flexihelp::get_file($parent->image,null,20)}}"></b>
							<b class="fas fa-trash text-danger mr-3 fa-1x deleteCat" data-deleteid="{{$parent->id}}" data-type="{{count($parent->children)?'parent':'candelete'}}"></b>
                            <i class="icon-angle-down"></i>
						</div>
					</div>
					<div id="parent-{{$parent->id}}" class="item-content collapse" role="tabpanel">
						@if(count($parent->children))
                        @foreach ($parent->children as $child)
                        @if (count($child->children))
						<div class="nestedCats">
							<div class="item mt-0 pt-0 pb-0 pl-0 pr-0 nestedCat" >
								<div class="item-trigger collapsed " data-toggle="collapse" data-parent="#categoriesListsub-{{$child->id}}" data-target="#ordersub-{{$child->id}}" aria-expanded="false">
									<div class="item-info-collapsed pt-4 pb-4">
										<span class="mr-auto">{{(app()->getLocale()=='ar'&&$child->name_ar)?$child->name_ar:$child->name}}</span>
										<b class="fas fa-plus text-primary mr-3 fa-1x addsub" data-parent_id="{{$child->id}}"></b>
										<b class="fas fa-pencil-alt text-primary mr-3 fa-1x editsubCat" data-id="{{$child->id}}" data-name="{{$child->name}}" data-name_ar="{{$child->name_ar}}" data-slug="{{$child->slug}}" data-intro="{{$child->intro}}" data-intro_ar="{{$child->intro_ar}}" data-keywords="{{$child->keywords}}"></b>
										<b class="fas fa-trash text-danger mr-3 fa-1x deleteCat" data-deleteid="{{$child->id}}" data-type="parent"></b>
										<i class="icon-angle-down"></i>
									</div>
									<div class="item-info pt-4">
										<span class="mr-auto">{{(app()->getLocale()=='ar'&&$child->name_ar)?$child->name_ar:$child->name}}</span>
										<b class="fas fa-plus text-primary mr-3 fa-1x addsub" data-parent_id="{{$child->id}}"></b>
										<b class="fas fa-pencil-alt text-primary mr-3 fa-1x editsubCat" data-id="{{$child->id}}" data-name="{{$child->name}}" data-name_ar="{{$child->name_ar}}" data-slug="{{$child->slug}}" data-intro="{{$child->intro}}" data-intro_ar="{{$child->intro_ar}}" data-keywords="{{$child->keywords}}"></b>
										<b class="fas fa-trash text-danger mr-3 fa-1x deleteCat" data-deleteid="{{$child->id}}" data-type="parent"></b>
										<i class="icon-angle-down"></i>
									</div>
								</div>
								<div id="ordersub-{{$child->id}}" class="item-content collapse" role="tabpanel">
									@foreach ($child->children as $subchild)
									<div class="d-flex align-items-center py-4 pr-5 pl-5 category-{{$subchild->id}}">
										<span class="mr-auto">{{(app()->getLocale()=='ar'&&$subchild->name_ar)?$subchild->name_ar:$subchild->name}}</span>
										<b class="fas fa-pencil-alt text-primary mr-3 fa-1x editsubCat" data-id="{{$subchild->id}}" data-name="{{$subchild->name}}" data-name_ar="{{$subchild->name_ar}}" data-slug="{{$subchild->slug}}" data-intro="{{$subchild->intro}}" data-intro_ar="{{$subchild->intro_ar}}" data-keywords="{{$subchild->keywords}}"></b>
										<b class="fas fa-trash text-danger mr-3 fa-1x deleteCat" data-deleteid="{{$subchild->id}}" data-type="candelete"></b>
									</div>
									@endforeach
								</div>
							</div>
						</div>
						@else
                        <div class="d-flex align-items-center py-4 pr-0 category-{{$child->id}}">
                            <span class="mr-auto">{{(app()->getLocale()=='ar'&&$child->name_ar)?$child->name_ar:$child->name}}</span>
							<b class="fas fa-plus text-primary mr-3 fa-1x addsub" data-parent_id="{{$child->id}}"></b>
							<b class="fas fa-pencil-alt text-primary mr-3 fa-1x editsubCat" data-id="{{$child->id}}" data-name="{{$child->name}}" data-name_ar="{{$child->name_ar}}" data-slug="{{$child->slug}}" data-intro="{{$child->intro}}" data-intro_ar="{{$child->intro_ar}}" data-keywords="{{$child->keywords}}"></b>
							<b class="fas fa-trash text-danger mr-3 fa-1x deleteCat" data-deleteid="{{$child->id}}" data-type="candelete"></b>
                        </div>
                        @endif
                        @endforeach
                        @endif
					</div>
				</div>
				@endforeach
            </div>
            @else
            <div class="item text-center noResult">
				<p class="noresultfound m-0 text-capitalize h4 text-secondary">{{trans_choice('general.noresult',Request::segment(4), ['tab-name' => Request::segment(4) ])}}</p>
			</div>
         	@endif
            <!-- <div class="paging mt-4 py-3">
                <button class="btn btn-default mr-auto">Export All To Excel</button>
                <p>1 - 15 of 100</p>
                <a href="#"><i class="icon-angle-left"></i></a>
                <a href="#" class="disabled"><i class="icon-angle-right"></i></a>
            </div> -->
        </div>
    </div>
</section>
<!-- add -->
@include('admin.categories.addparent')
@include('admin.categories.add')

<!-- edit -->
@include('admin.categories.editparent')
@include('admin.categories.edit')
@include('admin.categories.delete')
@endsection