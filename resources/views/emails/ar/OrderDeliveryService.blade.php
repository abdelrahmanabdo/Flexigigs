<div dir="rtl" style="direction: rtl;">
مرحبًا {{$order->customer->username}},<br>
<br>
<br>
نحن فقط نبلغك بأنّ أمر العمل الخاصّ بك قد تمّ إنجازه من قبل مقدّم الخدمة. <br>
<b>تفاصيل أمر العمل:</b><br>
<br>
رقم تعريف أمر العمل: <a href="{{url('ar/customer/dashboard/orders?order_id='.$order->id)}}">#{{$order->id}} - {{$order->request->name}}</a><br>
اسم الباحث عن وظيفة: {{$order->supplier->username}}<br>
الخدمة:  {{$order->request->name}} <br>
تاريخ التسليم: {{$order->updated_at}}<br>
<br>
<br>
مسؤول فلكسي غيغز في انتظار تأكيدك لإرسال المدفوعات. <br>
<br>
<a href="{{url('ar/customer/dashboard/orders?order_id='.$order->id)}}">تفقد أمر العمل الخاصّ بي</a><br>
<br>
كما يُرجى أخذ دقيقة لتقييم الخدمات التي أنجزها مقدّم الخدمة. <br>
<br>
مع تحيات فريق فلكسي غيغز!<br>
</div>
