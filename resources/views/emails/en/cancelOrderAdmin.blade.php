Hey Flexigigs Admin,<br>
<br>
We’re just making sure you know that you’ve cancelled Job  Order #{{$order->id}} - {{$title}}, and that the money will be refunded to the HeadHunter ASAP.<br>
<br>
<b>Order Details:</b><br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name:  <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{$title}}<br>
Order ID: <a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$title}}</a><br>
Amount to refund: {{$price}} EGP<br>
Conflict resolution fees: 25 EGP<br>
Refund amount: {{$price-25}} EGP<br>
<br>
Regards from the Flexigigs Team! <br>
<br>
========================================================== <br>
<br>
<div dir="rtl" style="direction: rtl;">
	مرحبًا مسؤول فلكسي غيغز, <br>
	<br>
	نحن فقط نتأكّد من إلغائك أمر عمل الوظيفة رقم{{$order->id}} - {{$title}} ، وأنّه سيتمّ ردّ الأموال إلى جهة التوظيف في أسرع وقت ممكن. <br>
	<br>
	<b>تفاصيل أمر العمل:</b>
	اسم جهة التوظيف: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
	اسم مقدّم الخدمة: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
	الخدمة/الوظيفة: {{$title}}<br>
	رقم تعريف أمر العمل: <a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$title}}</a><br>
	المبلغ الذي سيتمّ ردّه: {{$price}} جنيه مصري <br>
	رسوم خدمة تسوية المنازعات: 25 جنيهًا مصريًا <br>
	المبلغ المستردّ: {{$price-25}}  - 25 جنيهًا مصريًا <br>
	<br>
	مع تحيات فريق فلكسي غيغز!
</div>