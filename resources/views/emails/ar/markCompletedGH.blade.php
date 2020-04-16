<div dir="rtl" style="direction: rtl">
	مرحبًا {{$order->supplier->username}},<br>
	<br>
	يؤسفنا أن نعلم بحدوث نزاع بشأن أمر عمل الوظيفة رقم #{{$order->id}} - {{$title}}. <br>
	لقد راجعنا بدقة جميع مراسلاتك، ويسرّنا إبلاغك بأنّنا قد قرّرنا اعتبار أمر العمل "منجزًا". <br>
	<br>
	<b>تفاصيل أمر العمل:</b> <br>
	اسم جهة التوظيف: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
	اسم مقدّم الخدمة: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
	الخدمة/الوظيفة: {{$title}}<br>
	رقم تعريف أمر العمل: <a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$title}}</a><br>
	سعر الخدمة: {{$price}} جنيه مصري <br>
	رسوم المعاملة ({{config('site_settings.commission.service.transaction')}}%): {{$transaction_fee}} جنيه مصري (سيتم خصمها) <br>
	السعر الكلي: {{$total}} جنيه مصري <br>
	<br>
	<br>
	سيتمّ إرسال مدفوعاتك المستحقّة عن جدارة في أسرع وقت ممكن وفقًا لشروط وأحكام فلكسي غيغز. ويمكنك استلام مستحقّاتك :) <br>
	<br>
	في حالة حدوث أيّ مشاكل في الدفع و/أو المدّة الزمنية المتفق عليها؛ فلا تتردّد في <a href="{{route('contact-us')}}">الاتّصال بنا</a> على الفور. <br>
	<br>
	مع تحيات فريق فلكسي غيغز!
</div>
