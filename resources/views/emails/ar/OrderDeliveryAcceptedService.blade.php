<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$order->supplier->username}},<br>
	<br>
	<br>
	أحسنت! يسرّنا إبلاغك بقبول جهة التوظيف لأمر عملك المسلّم <a href="{{url('ar/supplier/dashboard/gigs')}}">#{{$order->id}} - {{$order->request->name}}</a>. <br>
	<br>
	<br>
	<b>تفاصيل أمر العمل:</b><br>
	<br>
	رقم تعريف أمر العمل: #<a href="{{url('ar/supplier/dashboard/gigs')}}">#{{$order->id}} - {{$order->request->name}}</a><br>
	اسم جهة التوظيف: {{$order->customer->username}}<br>
	الخدمة: <a href="{{url('ar/service/'.$order->request->service_id)}}">{{$order->request->name}}</a> <br>
	سعر الخدمة: {{$price}} جنيه مصري <br>
	رسوم المعاملة ({{config('site_settings.commission.service.transaction')}} ٪): {{$transaction_fee}} جنيه مصري <br>
	(سيتم خصمها) <br>
	السعر الكلي: {{$total}} جنيه مصري <br>
	<br>
	<br>
	<br>
	سيتم إرسال مدفوعاتك المستحقّة عن جدارة في أسرع وقت ممكن وفقًا لشروط وأحكام فلكسي غيغز. <br>
	في حالة حدوث أيّ مشاكل في الدفع و/أو الإطار الزمني المتفق عليه؛ فلا تتردّد في <a href="{{route('contact-us')}}">الاتّصال بنا</a> على الفور. <br>
	<br>
	مع تحيات فريق فلكسي غيغز! <br>
</div>
