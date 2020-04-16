Hey {{$order->supplier->username}},<br>
<br>
We are sorry to hear about your conflict over Job Order #{{$order->id}} - {{$title}}. <br>
We’ve thoroughly reviewed all your correspondence and we are sorry to to inform you that we’ve decided to mark the order as “Cancelled”. The money will be refunded to the HeadHunter.<br>
<b>Order Details:</b><br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name:  <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{$title}}<br>
Order ID: <a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$title}}</a><br>
Amount to refund: {{$price}} EGP<br>
<br>
Better luck on your next gig!<br>
<br>
Regards from the Flexigigs Team! 