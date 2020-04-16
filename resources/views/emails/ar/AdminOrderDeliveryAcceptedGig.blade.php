<div dir="rtl" style="direction: rtl;">
مرحبًا مسؤول فلكسي غيغز,<br>
<br>
هذه الرسالة لإبلاغك بقبول أمر عملك المُنجز من جهة التوظيف. <br>
<br>
<b>تفاصيل أمر العمل:</b><br>
اسم جهة التوظيف: <a href="{{route('customer_profile',[$order->customer->username])}}">{{$order->customer->username}}</a><br>
اسم الباحث عن وظيفة: <a href="{{route('supplier_profile',[$order->supplier->username])}}">{{$order->supplier->username}}</a><br>
الوظيفة: {{$order->application->title}}<br>
رقم تعريف أمر العمل: <a href="{{route('admin_orders',['order_id'=>$order-id])}}">#{{$order->id}} - {{$order->application->title}}</a><br>
إجمالي المدفوعات التي يجب إرسالها: {{$total}} جنيه مصري
<br>
مع تحيات فريق فلكسي غيغز!<br>
</div>
