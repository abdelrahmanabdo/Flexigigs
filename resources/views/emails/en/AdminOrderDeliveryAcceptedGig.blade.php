Hey FlexiGig Admin,<br>
<br>
This email is to notify you of order completion acceptance by HeadHunter. <br>
<br>
<b>Order Details:</b><br>
HeadHunter Name: <a href="{{route('customer_profile',[$order->customer->username])}}">{{$order->customer->username}}</a><br>
GigHunter Name: <a href="{{route('supplier_profile',[$order->supplier->username])}}">{{$order->supplier->username}}</a><br>
Gig: {{$order->application->title}}<br>
Order ID:  <a href="{{route('admin_orders',['order_id'=>$order->id])}}">#{{$order->id}} - {{$order->application->title}}</a><br>
Total Payment to release: {{$total}} EGP<br>
<br>
Regards from the Flexigigs Team!<br>
<br>
====================================================<br>
<br>
<div dir="rtl" style="direction: rtl;">
مرحبًا مسؤول فلكسي غيغز,<br>
<br>
هذه الرسالة لإبلاغك بقبول أمر عملك المُنجز من جهة التوظيف. <br>
<br>
<b>تفاصيل أمر العمل:</b><br>
اسم جهة التوظيف: <a href="{{route('customer_profile',[$order->customer->username])}}">{{$order->customer->username}}</a><br>
اسم الباحث عن وظيفة: <a href="{{route('supplier_profile',[$order->supplier->username])}}">{{$order->supplier->username}}</a><br>
الوظيفة: {{$order->application->title}}<br>
رقم تعريف أمر العمل: <a href="{{route('admin_orders',['order_id'=>$order->id])}}">#{{$order->id}} - {{$order->application->title}}</a><br>
إجمالي المدفوعات التي يجب إرسالها: {{$total}} جنيه مصري
<br>
مع تحيات فريق فلكسي غيغز!<br>
</div>
