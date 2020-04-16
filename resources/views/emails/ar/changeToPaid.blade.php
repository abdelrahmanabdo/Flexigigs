Hey {{$order->supplier->username}},<br>
<br>
This is a notification email to inform that Flexigigs Admin marked this order #{{$order->id}} - {{$title}} as paid and the money shall be transfared to your account 
<br>
Order Details:<br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name:  <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{($order->type==1)?$order->request->name:$order->application->name}}<br>
Order ID: <a href="{{route('admin_orders')}}">#{{$order->id}} - {{$title}}</a><br>
Total Payment to release: {{$total}} EGP <br>
<br>
Regards from the Flexigigs Team! <br>
