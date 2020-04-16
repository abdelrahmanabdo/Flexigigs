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