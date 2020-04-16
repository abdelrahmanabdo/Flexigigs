<div style="direction: rtl;">
مرحبًا {{$customer}}, <br>
<br>
نحن نؤكّد فقط أن طلب أمر العمل الجديد الخاص بك #{{$order->id}} - {{$gig->title}} تم إنشاؤه وإرساله بنجاح. <br>
<br>
<b>تفاصيل أمر العمل:</b><br>
<br>
<br>
اسم الباحث عن وظيفة: {{$supplier}}<br>
الخدمة: {{$gig->title}} <br>
رقم تعريف أمر العمل: <a href="{{url('ar/gig/details/'.$gig->id)}}">#{{$order->id}} - {{$gig->title}}</a><br>
تاريخ التسليم: {{$gig->deadline}}<br>
سعر الخدمة: {{$gig->price}} جنيه مصري <br>	
رسوم التسليم ({{config('site_settings.commission.gig.handling')*100}}%): {{$handling_commission}} جنيه مصري <br>
السعر الكلي: {{$customer_total}} جنيه مصري <br>
<br>
<br>
مع تحيات فريق <div dir="rtl" style="direction: rtl; display: inline;">فلكسي غيغز!</div><br>
</div>