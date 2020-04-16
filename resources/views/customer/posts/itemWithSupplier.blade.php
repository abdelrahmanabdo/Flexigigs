<div class="item" id="giglink-{{$post->id}}">
   <div class="item-trigger @if ($post->status >= 1) collapsed @endif" data-toggle="collapse" data-parent="#gigsList" data-target="#gigActive-{{$post->id}}" aria-expanded="@if ($post->status === 0) true @else false @endif">
        <div class="item-info-collapsed row">
            <div class="col-6 col-md-6 col-lg-3 pr-0">
                <p class="font-weight-bold pr-4">{{$post->title}}</p>
            </div>
            <div class="col-6 col-md-6 col-lg-4 pl-0 pr-0">
                <?php $skills = count($post->skills);$i=0;?>
                @if ($skills)
                <div class="row">
                    @foreach($post->skills as $skill)
                        @if ($i < 1)
                            <?php $skills--;$i++;?>
                            <div class="badge col-sm">{{Flexihelp::catname($skill->category,app()->getLocale())}}</div>
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
                <button class="btn btn-default btn-sm text-uppercase" onclick="copyfornewgig({{$post->id}})">@lang('gigs.dashboard_customer_posts_repost_info')</button>
            </div>
            <i class="icon-angle-down col-2 col-md-1 col-lg-1 text-center"></i>
        </div>
        <div class="item-info row">
            <h2 class="gigtitle-{{$post->id}} col-lg-4">{{$post->title}}</h2>
            <div class="button-group col-lg-6  pl-sm-3 mt-sm-4 p-lg-0 m-lg-0">
                <?php if ($post->status == 0): ?>
                <button type="button" class="btn btn-default" onclick="cancelgig({{$post->id}})">@lang('gigs.dashboard_customer_posts_cancel_gig')</button>
                <?php endif ?>
                <button type="button" class="btn btn-default" onclick="copyfornewgig({{$post->id}})" >@lang('gigs.dashboard_customer_posts_repost_info')</button>
            </div>
            <i class="icon-angle-down col-lg-1"></i>
        </div>
        <div id="gigActive-{{$post->id}}" class="item-content collapse {{($post->status == 0)?'show':''}}" role="tabpanel">
            <div class="row pt-3">
                <div class="col-md-4">
                    <div class="item-status">
                        <div class="d-flex justify-content-between">
                            <label>@lang('gigs.dashboard_customer_posts_gig_info.price')</label>
                            <p class="text-primary font-weight-bold gigprice-{{$post->id}}" data-price="{{$post->price}}">{{number_format($post->price)}} @lang('general.gig_price_unit_EGP')</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <label>@lang('gigs.dashboard_customer_posts_gig_info.deadline')</label>
                            <p class="gigdeadline-{{$post->id}}">{{Flexihelp::defult_date($post->deadline)}}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <label>@lang('gigs.dashboard_customer_posts_gig_info.status.title')</label>
                            <p>{{$post->gig_status}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="item-status">
                                <div class="d-flex flex-wrap pt-0">
                                    <label class="bold-label">@lang('gigs.dashboard_customer_posts_gig_info.description') </label>
                                    <p class="gigdescription-{{$post->id}}"><?=nl2br($post->description)?></p>
                                </div>
                   
                                <div class="d-flex">
                                    <label class="bold-label">@lang('gigs.dashboard_customer_posts_gig_info.skills')</label>
                                    <div class="d-flex flex-wrap">
                                        <?php $skills_ids ="";  ?>
                                        @foreach($post->skills as $skill)
                                        <?php $skills_ids.=$skill->category_id."," ?>
                                         <div class="badge">{{Flexihelp::catname($skill->category,app()->getLocale())}}</div>
                                        @endforeach
                                        <div class="gigskills-{{$post->id}} d-none">{{$skills_ids}}</div>
                                    </div>
                                </div>
                                @if($post->attach)
                                <div class="d-flex flex-column">
                                    <label>@lang('gigs.dashboard_customer_posts_gig_info.attached_files')</label>
                                    <?php $i =1; ?>
                                    @foreach($post->attach as $attach)
                                    <a href="{{Flexihelp::get_file($attach->filename)}}" download target="blank">@lang('gigs.dashboard_customer_posts_gig_info.file_attached')-{{$i++}}</a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="item-status">
                                <label class="bold-label mt-0">@lang('gigs.dashboard_customer_posts_gig_info.applied_supplier')</label>
                                <div class="applied-supplier-cont">
                                    <ol class="pl-0">
                                        <?php $i = 1;?>
                                        @foreach($post->applications as $application)
                                        <li><a href="{{url(app()->getLocale().'/application/'.$application->id)}}">{{$i++}} - {{$application->supplier->username}}: @lang('gigs.dashboard_customer_posts_gig_info.applied_on') {{Flexihelp::defult_date($application->created_at)}}</a></li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>