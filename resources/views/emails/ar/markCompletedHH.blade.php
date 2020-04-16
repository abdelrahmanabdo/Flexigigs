<div dir="rtl" style="direction: rtl">
	مرحبًا {{$order->customer->username}},<br>
	<br>
	يؤسفنا أن نعلم بحدوث نزاع بشأن أمر عمل الوظيفة رقم #{{$order->id}} - {{$title}}.<br>
	لقد راجعنا بدقة جميع مراسلاتك، ويؤسفنا إبلاغك بأنّنا قد قرّرنا اعتبار أمر العمل "منجزًا"، وسيتمّ دفع الأموال إلى مقدّم الخدمة.  <br>
	<br>
	<b>تفاصيل أمر العمل:</b><br>
	اسم جهة التوظيف: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
	اسم مقدّم الخدمة: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
	الخدمة/الوظيفة: {{$title}}<br>
	رقم تعريف أمر العمل: <a href="{{route('customer_orders')}}">#{{$order->id}} - {{$title}}</a><br>
	المبلغ المستحقّ: {{$price+$transaction_fee}} جنيه مصري <br>
	<br>
	مع تحيات فريق فلكسي غيغز!
</div>
