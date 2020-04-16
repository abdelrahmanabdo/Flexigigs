Hey {{$order->customer->username}},<br>
<br>
We’re sorry to hear about your conflict over Job Order #{{$order->id}} - {{$title}}.<br>
We’ve thoroughly reviewed all your correspondence and we are sorry to inform you that <br>
we’ve decided to mark the order as “Completed”. The money will now be released to the GigHunter.<br>
<br>
<b>Order Details:</b><br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{$title}}<br>
Order ID: <a href="{{route('customer_orders')}}">#{{$order->id}} - {{$title}}</a><br>
Amount due: {{$price+$transaction_fee}} EGP<br>
<br>
Regards from the Flexigigs Team! 
