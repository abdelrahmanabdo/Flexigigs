<div class="col-sm-12 col-lg-6 {{(!Request::segment(2))?'col-xl-3':'col-xl-4'}}" id="service-{{$service->id}}">
    <div class="service-thumb w-100 mx-0 p-0">
        <a href="{{route('service_details',['id'=>$service->id])}}">
            <?php $photo = (count($service->photos))?$service->photos[0]['filename']:false;?>
            <div class="service-img w-100 mx-auto" style="background-image: url('{{Flexihelp::get_file($photo,'service')}}');"></div>
			<h3 class="service-title mb-0 px-3" style="min-height: 50px;">{{$service->name}}</h3>			
            <div class="service-desc px-3">
                <div class="user">
					<div class="user-img-sm m-0 mr-2">
						<div class="user-img-sm-container">
                    		<img src="{{Flexihelp::get_file($service->user['avatar'],'user',20,$service->user['gender'])}}">
						</div>
					</div>
                    <div>
                        <p>{{$service->user['username']}}</p>
                        <?=Flexihelp::get_stars('review',$service->rate)?>
                    </div>
				</div>
				<script>
					$(document).ready(function(){
						var $title= $('.service-title');
						$title.each(function(){
							var $titleArr = $(this).text().split(" ").slice(0, 6).join(' ');
							$(this).text($titleArr);
						});
					});
				</script>
                <div class="price">
                    <p style="font-size:1.3rem;">{{number_format($service->price_per_unit)}} @lang('general.service_price_unit_EGP')</p>
                    <small>@lang('general.service_price_unit_per') {{trans('service_category.'.$service->price_unit)}}</small>
                </div>
            </div>
        </a>
        <div class="service-footer  footer-serv px-3">
            @if (Auth::check())
                @if(Auth::user()->id!=$service->supplier_id&&!Auth::user()->hasRole('admin'))
                    @if(session('member_type') === 1)
                        @if (count(DB::table('favorites')->where([['service_id',$service->id],['user_id',Auth::user()->id]])->get()))
                        <a href="#" class="deletefavorite mr-3" data-id="{{$service->id}}"><i class="icon-heart"></i>@lang('general.button_delete')</a> 
                        @else
                        <a href="#" class="addtofavorite mr-3" data-id="{{$service->id}}"><i class="icon-heart"></i>@lang('general.button_favorites')</a> 
                        @endif
                    @endif
                @endif
            @endif
            <a href="{{route('service_details',[$service->id])}}"><i class="icon-plus"></i>@lang('general.button_more')</a>
        </div>
    </div>
</div>