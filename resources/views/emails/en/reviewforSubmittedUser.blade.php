<?php $username = ($review->type==1)?$review->order->supplier->username:$review->order->customer->username;
	  $type = ($review->type==1)?"supplier":"customer"; ?>
Hey {{$username}},<br>
<br>
Check out the new review that’s been submitted to your profile on Flexigigs’ system!<br>
<br>
Reviewed from: {{($review->type==2)?$review->order->supplier->username:$review->order->customer->username}}<br>
Order ID: #{{$review->order->id}} - {{($review->order->type==1)?$review->order->request->name:$review->order->application->title}}<br>
Rating: {{$review->rate}} / 5 <br>
Review: {{$review->comment}}<br>
<br>
<a href="{{url($type.'/reviews/'.$username)}}">View Review</a><br>
<br>
Regards from the Flexigigs Team! 