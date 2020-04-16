<div class="item" id="giglink-{{$post->id}}">
    <div class="item-trigger @if ($post->status >= 1) collapsed @endif" data-toggle="collapse" data-parent="#gigsList" data-target="#gigActive-{{$post->id}}" aria-expanded="@if ($post->status === 0) true @else false @endif">
        <div class="item-info-collapsed row">
            <div class="col-6 col-md-6 col-lg-3">
                <p class="font-weight-bold">{{$post->title}}</p>
            </div>
            <div class="col-6 col-md-6 col-lg-4">
                <?php $skills = count($post->skills);$i=0;?>
                @if ($skills)
                <div class="row">
                    @foreach($post->skills as $skill)
                        @if ($i< 1)
                            <?php $skills--;$i++; ?>
                            <div class="badge col-sm">{{(app()->getLocale()=='ar'&&$skill->category->name_ar)?$skill->category->name_ar:$skill->category->name}} </div>
                        @endif
                    @endforeach
                    <div class="col-sm pr-0 pl-0">{{($skills)?"+".$skills:""}}</div>
                </div>
                @endif
            </div>
            <div class="col-1 col-md-2 col-lg-1 pr-0 pl-lg-0">
                <p class="text-primary font-weight-bold">{{number_format($post->price)}} @lang('general.gig_price_unit_EGP')</p>
            </div>
            <div class="col-1 col-md-6 col-lg-3">
                <button class="btn btn-default btn-sm text-uppercase" onclick="copyfornewgig(<?=$post->id?>,'<?=($post->status<2&&$post->deadline > date('Y-m-d'))?'copy':'repost'?>')">
                    @if($post->status<2&&$post->deadline > date('Y-m-d'))
                        @lang('gigs.dashboard_customer_posts_copy_info')
                    @else
                        @lang('gigs.dashboard_customer_posts_repost_info')
                    @endif
                </button>
            </div>
            <i class="icon-angle-down col-2 col-md-1 col-lg-1 mt-md-4 mt-lg-0 text-center"></i>
        </div>
        <div class="item-info row">
            <h2 class="gigtitle-{{$post->id}} col-lg-4">{{$post->title}}</h2>
            <div class="button-group col-lg-6 pl-sm-3 mt-sm-4 p-lg-0 m-lg-0 text-right">
                <?php if ($post->status == 0): ?>
                <button type="button" class="btn btn-default" onclick="cancelgig({{$post->id}})">@lang('gigs.dashboard_admin_gigs_cancel_gig')</button>
                <?php endif ?>
                <button class="btn btn-default btn-sm text-uppercase" onclick="copyfornewgig(<?=$post->id?>,'<?=($post->status<2&&$post->deadline > date('Y-m-d'))?'copy':'repost'?>')">
                    @if($post->status<2&&$post->deadline > date('Y-m-d'))
                        @lang('gigs.dashboard_customer_posts_copy_info')
                    @else
                        @lang('gigs.dashboard_customer_posts_repost_info')
                    @endif
                </button>
            </div>
            <i class="icon-angle-down col-lg-1"></i>
        </div>
    </div>
    <div id="gigActive-{{$post->id}}" class="item-content collapse {{($post->status == 0)?'show':''}}" role="tabpanel">
        <div class="row pt-3">
            <div class="col-lg-4 col-md-12">
                <div class="item-status">
                    <div class="user">
						<div class="user-img-md m-0 mr-2">
							<div class="user-img-md-container">
								<img src="{{Flexihelp::get_file($post->customer->avatar,'user',20,$post->customer->gender)}}">
							</div>
						</div>
                        <div>
                            <a href="{{route('customer_profile',[$post->customer->username])}}" title="{{$post->customer->username}}" class="user_name">
                                <p>{{$post->customer->username}}</p>
                                <p>(HH)</p>
                            </a>
                            <div class="br-wrapper br-theme-fontawesome-stars">
                                <?=Flexihelp::get_stars('customer',$post->customer->id)?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label>@lang('gigs.dashboard_admin_gigs_gig_info.price')</label>
                        <p class="text-primary font-weight-bold gigprice-{{$post->id}}" data-price="{{$post->price}}">{{number_format($post->price)}} @lang('general.gig_price_unit_EGP')</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label>@lang('gigs.dashboard_admin_gigs_gig_info.deadline')</label>
                        <p class="gigdeadline-{{$post->id}}">{{Flexihelp::defult_date($post->deadline)}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <label>@lang('gigs.dashboard_admin_gigs_gig_info.status.title')</label>
                        @if ($post->status == 0)
                        <p>@lang('gigs.dashboard_admin_gigs_gig_info.status.opened')</p>
                        @elseif ($post->status == "5")
                        <p>@lang('gigs.dashboard_admin_gigs_gig_info.status.canceld') </p>
                        @elseif ($post->status >= 1)
                        <p>@lang('gigs.dashboard_admin_gigs_gig_info.status.closed')</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="item-status">
                            <div class="d-flex flex-column pt-0">
                                <label class="bold-label">@lang('gigs.dashboard_admin_gigs_gig_info.skills')</label>
                                <div class="d-flex flex-wrap flex-row justify-content-start">
                                    <?php $skills_ids ="";  ?>
                                    @foreach($post->skills as $skill)
                                    <?php $skills_ids.=$skill->category_id."," ?>
                                     <div class="badge" style="white-space:pre-wrap">{{(app()->getLocale()=='ar'&&$skill->category->name_ar)?$skill->category->name_ar:$skill->category->name}}</div>
                                    @endforeach
                                    <div class="gigskills-{{$post->id}} d-none">{{$skills_ids}}</div>
                                </div>
                            </div>
                            @if(count($post->attach))
                            <div class="d-flex flex-column">
                                <label>@lang('gigs.dashboard_admin_gigs_gig_info.attached_files')</label>
                                <?php $i =1; ?>
                                @foreach($post->attach as $attach)
                                <a href="{{Flexihelp::get_file($attach->filename)}}" target="blank" download>@lang('gigs.dashboard_admin_gigs_gig_info.file_attached')-{{$i++}}</a>
                                @endforeach
                            </div>
                            @endif                            
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="item-status">
                            <div class="d-flex flex-wrap pt-0">
                                <label class="bold-label w-100">@lang('user.gh_type') </label>
                                @foreach($post->supplier_type as $type)
                                    <div class="badge">{{$type->supplier_type}}</div>
                                @endforeach
                            </div>
                            <div class="d-flex flex-wrap flex-column pt-0">
                                <label class="bold-label">@lang('gigs.dashboard_admin_gigs_gig_info.description') </label>
                                <p class="gigdescription-{{$post->id}}  side-scroll"><?=nl2br($post->description)?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>