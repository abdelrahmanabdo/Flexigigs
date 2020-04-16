<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$customer}},<br>
	<br>
	نحن نؤكّد فقط أن طلب أمر العمل الجديد الخاص بك #{{$order->id}} - {{$service_request->name}} تم إنشاؤه وإرساله بنجاح. <br>
	<br>
	<b>تفاصيل أمر العمل:</b> <br>
	<br>
	<br>
	اسم الباحث عن وظيفة: {{$supplier}}<br>
	الخدمة: {{$service_request->name}} <br>
	رقم تعريف أمر العمل: <a href="{{url('ar/customer/dashboard/orders?order_id='.$order->id)}}">#{{$order->id}} - {{$service_request->name}}  </a><br>
	تاريخ التسليم: {{$service_request->days_to_deliver}} {{($service_request->price_unit=='hour')?"ساعة":"يوم"}}<br>
	سعر الخدمة: {{$service_request->price_per_unit}} جنيه مصري <br>
	رسوم التسليم ({{config('site_settings.commission.service.handling')}}%): {{$transaction_fee}} جنيه مصري <br>
	السعر الكلي: {{$service_request->price}} جنيه مصري <br>
	<br>
	<br>
	مع تحيات فريق فلكسي غيغز!<br>
	<br>
</div>