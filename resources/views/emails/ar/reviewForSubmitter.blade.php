<?php $username = ($review->type==2)?$review->order->supplier->username:$review->order->customer->username; 
	  $type = ($review->type==2)?"supplier":"customer"; ?>
<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$username}},<br>
	<br>
	نحن نقدّر حقًا تقديمك لهذه المراجعة! ورأيك بالغ الأهمية لنا. <br>
	<br>
	نشكرك على مشاركة تجربتك معنا. <br>
	<br>
	تمّت المراجعة بواسطة: {{($review->type==1)?$review->order->supplier->username:$review->order->customer->username}}<br>
	رقم تعريف أمر العمل: #{{$review->order->id}} - {{($review->order->type==1)?$review->order->request->name:$review->order->application->title}}<br>
	التقييم: {{$review->rate}} / 5 <br>
	المراجعة: {{$review->comment}}<br>
	<br>
	<a href="{{url('ar/'.$type.'/reviews/'.$username)}}">انتقل إلى مراجعاتي </a><br>
	<br>
	مع تحيات فريق فلكسي غيغز!<br>
</div>
