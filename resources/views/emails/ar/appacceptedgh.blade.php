<div dir="rtl" style="direction: rtl;">
مرحبًا {{$supplier}}, <br>
<br>
تهانينا! تمّ قبول طلبك للحصول على وظيفة "{{$gig->title}}" من بين جميع الطلبات الأخرى. ستجد أمر العمل الجديد في مهامّ لوحة المعلومات الخاصّة بك. 	<br>
<br>
<br>
<b>تفاصيل أمر العمل:</b> <br>
<br>
اسم جهة التوظيف: {{$customer}}<br>
اسم الوظيفة: {{$gig->title}}<br>
رقم تعريف أمر العمل: #<a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$gig->title}}</a> <br>
تاريخ التسليم: {{$gig->deadline}}<br>
سعر الخدمة: {{$gig->price}} جنيه مصري <br>
رسوم المعاملة ({{config('site_settings.commission.gig.handling')*100}} %): {{$transaction_fee}} جنيه مصري <br>
(سيتم خصمها) <br>
السعر الكلي: {{$supplier_total}} جنيه مصري <br>	
<br>
مع تحيات فريق <div dir="rtl" style="direction: rtl; display: inline;">فلكسي غيغز!</div><br>
</div>
