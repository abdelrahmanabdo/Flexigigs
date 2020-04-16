<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$supplier}}, <br>
	<br>
	رائع! تحقّق من طلب أمر عملك الجديد #{{$order->id}} - {{$service_request->name}}. <br>
	<br>
	<b>تفاصيل أمر العمل:</b><br>
	<br>
	<br>
	اسم جهة التوظيف: {{$customer}}<br>
	الخدمة: {{$service_request->name}}<br>
	رقم تعريف أمر العمل: #<a href="{{url('ar/supplier/dashboard/gigs')}}">{{$order->id}} - {{$service_request->name}} </a><br>
	تاريخ التسليم: {{$service_request->days_to_deliver}} {{($service_request->price_unit=='hour')?"hours":"days"}}<br>
	سعر الخدمة: {{$service_request->price_per_unit}} جنيه مصري <br>	
	رسوم المعاملة ({{config('site_settings.commission.service.handling')}}%): {{$transaction_fee}} جنيه مصري <br>
	(سيتم خصمها) <br>
	السعر الكلي: {{$supplier_total}} جنيه مصري <br>
	<br>
	مع تحيات فريق فلكسي غيغز!<br>
	<br>
</div>