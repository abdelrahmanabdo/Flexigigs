@if($my_service->reviews)
<div class="reviews">
    @forelse($my_service->reviews as $review)
    <div class="review">
        <div class="header">
            <div class="user">
				<div class="user-img-md p-0">
					<div class="user-img-md-container">
                		<img src="{{Flexihelp::get_file($review->user->avatar,'user',20,$review->user->gender)}}">
					</div>
				</div>
                <div>
                    <p>{{$review->user->username}}</p>
                </div>
            </div>
            <?=Flexihelp::get_stars('review',$review->rate)?>
        </div>
        <p>{{$review->comment}}</p>
    </div>
    @empty
        <!-- <h1 class="text-center">@lang('general.no_review')</h1> -->
    @endforelse
</div>
@if (count($my_service->allreviews)>5)
<div class="paging">
    <a href="{{route('service_details',[$my_service->id])}}" class="text-primary float-right font-weight-bold text-capitalize" style="font-size: 1.5rem;">@lang('user.supplier_profile.view_more')</a>
</div>
@endif
@endif