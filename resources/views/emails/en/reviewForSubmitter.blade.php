<?php $username = ($review->type==2)?$review->order->supplier->username:$review->order->customer->username; 
	  $type = ($review->type==2)?"supplier":"customer"; ?>
Hey {{$username}},<br>
<br>
We really appreciate your review submission! Your opinion is super important to us. <br>
<br>
Thanks for sharing your experience with us. <br>
<br>
Reviewed: {{($review->type==1)?$review->order->supplier->username:$review->order->customer->username}}<br>
Order ID: #{{$review->order->id}} - {{($review->order->type==1)?$review->order->request->name:$review->order->application->title}}<br>
Rating: {{$review->rate}} / 5 <br>
Review: {{$review->comment}}<br>
<br>
<a href="{{url($type.'/reviews/'.$username)}}">Go to My Reviews</a><br>
<br>
Regards from the Flexigigs Team! 