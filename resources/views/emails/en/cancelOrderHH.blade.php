Hey {{$order->customer->username}},<br>
<br>
We are sorry to hear about your conflict over Job Order #{{$order->id}} - {{$title}},  We have thoroughly reviewed all your correspondence and decided to mark the order as “Cancelled”. Your money will be refunded ASAP.<br>
<br>
<b>Order Details:</b><br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{$title}}<br>
Order ID: <a href="{{route('customer_orders')}}">#{{$order->id}} - {{$title}}</a><br>
Amount Paid: {{$total}} EGP<br>
Conflict resolution fees: 25 EGP<br>
Refund amount: {{$total-25}}EGP<br>
<br>
<br>
The refund process will take from 10 to 15 working days, so kindly <a href="{{route('contact-us')}}" target="_blank">contact us</a> if you haven’t received your money back after this period of time. <br>
<br>
Regards from the Flexigigs Team!