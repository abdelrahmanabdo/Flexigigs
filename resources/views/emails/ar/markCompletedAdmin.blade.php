<div dir="rtl" style="direction: rtl">
	مرحبًا مسؤول فلكسي غيغز,<br>
	<br>
	نحن فقط نتأكّد من أنّك قد قرّرت اعتبار أمر عمل الوظيفة رقم #{{$order->id}} - {{$title}} "منجزًا"، وأنّه سيتمّ سداد مستحقّات مقدّم الخدمة في أسرع وقت ممكن. <br>
	<br>
	<b>تفاصيل أمر العمل:</b> <br>
	اسم جهة التوظيف: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
	اسم مقدّم الخدمة: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
	الخدمة/الوظيفة: {{$title}}<br>
	رقم تعريف أمر العمل: <a href="{{route('admin_orders')}}">#{{$order->id}} - {{$title}}</a><br>
	إجمالي المدفوعات التي سيتمّ سدادها: {{$total}} جنيه مصري <br>
	<br>
	مع تحيات فريق فلكسي غيغز!
</div>