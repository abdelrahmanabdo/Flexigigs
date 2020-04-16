<div dir="rtl" style="direction: rtl;">
	مرحبًا {{$username}}، <br>
	<br>
	تهانينا! نحن نؤكّد فقط أنّه قد تمّ إضافة خدمتك  <a href="{{route('service_details',['id'=>$service->id])}}">{{$service->name}}</a>  إلى نظام  فلكسي غيغز!  بنجاح. تحكّم في جميع خدماتك بصورة <br>
	كاملة من خلال لوحة المعلومات الخاصة بك ← علامة التبويب <a href="{{url('ar/supplier/dashboard/services')}}">"منشوراتي"</a>.<br>
	<br>
	مع تحيات فريق فلكسي غيغز!<br>
</div>