<?php $username = ($review->type==1)?$review->order->supplier->username:$review->order->customer->username;
	  $type = ($review->type==1)?"supplier":"customer"; ?>
<br>
<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$username}},<br>
	<br>
	تحقّق من المراجعة الجديدة المرسلة إلى ملفك الشخصي على نظام فلكسي غيغز!<br>
	<br>
	تمّت المراجعة بواسطة: {{($review->type==2)?$review->order->supplier->username:$review->order->customer->username}}<br>
	رقم تعريف أمر العمل: #{{$review->order->id}} - {{($review->order->type==1)?$review->order->request->name:$review->order->application->title}}<br>
	التقييم: {{$review->rate}} / 5 <br>
	المراجعة: {{$review->comment}}<br>
	<br>
	<a href="{{url('ar/'.$type.'/reviews/'.$username)}}">عرض المراجعة</a><br>
	<br>
	مع تحيات فريق فلكسي غيغز!<br>
</div>
