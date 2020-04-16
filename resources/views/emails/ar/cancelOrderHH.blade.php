<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$order->customer->username}},<br>
	<br>
	يؤسفنا أن نعلم بحدوث نزاع بشأن أمر العمل رقم #{{$order->id}} - {{$title}}. لقد راجعنا بدقة جميع مراسلاتك، وقرّرنا "إلغاء" أمر العمل، وسيتمّ ردّ أموالك في أسرع وقت ممكن. <br>
	<br>
	<b>تفاصيل أمر العمل:</b><br>
	اسم جهة التوظيف: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
	اسم مقدّم الخدمة: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
	الخدمة/الوظيفة: {{$title}}<br>
	رقم تعريف أمر العمل: <a href="{{route('customer_orders')}}">#{{$order->id}} - {{$title}}</a><br>
	المبلغ المدفوع: {{$total}} جنيه مصري <br>
	رسوم خدمة تسوية المنازعات: 25 جنيهًا مصريًا <br>
	المبلغ المستردّ: {{$total-25}}  -  25جنيهًا مصريًا <br>
	<br>
	<br>
	ستستغرق عملية ردّ الأموال من 10 إلى 15 يوم عمل، وفي حالة عدم استلامك لأموالك بعد هذه المدّة؛ يُرجى مراسلتنا على <a href="{{route('contact-us')}}" target="_blank">contact us</a>. <br>
	<br>	
	مع تحيات فريق فلكسي غيغز!
</div>