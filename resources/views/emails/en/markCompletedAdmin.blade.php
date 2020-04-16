Hey Flexigigs Admin,<br>
<br>
We’re just making sure you know that you’ve marked Job Order #{{$order->id}} - {{$title}} as “Completed” and the money shall be released to the GigHunter as per agreed conditions.	<br> 
<br>
Order Details:<br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{$title}}<br>
Order ID: <a href="{{route('admin_orders')}}">#{{$order->id}} - {{$title}}</a><br>
Total Payment to release: {{$total}} EGP <br>
<br>
Regards from the Flexigigs Team!