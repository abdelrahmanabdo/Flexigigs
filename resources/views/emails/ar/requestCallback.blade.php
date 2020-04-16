Hey {{$order->supplier->username}},<br>
<br>
Congratulations buddy! Your service <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> has been requested by <a href="{{route('customer_profile',[$order->customer->username])}}">{{$order->customer->username}}</a>.<br>
<br>
Please “Accept” or “Reject” the <a href="{{route('supplier_gigs',['order_id'=>$order->id])}}">service request</a> within 24hrs. Otherwise, the service request will be automatically cancelled by the system. <br>
<br>
Hurry up and get the job done!<br>
<br>
Regards from the Flexigigs Team!
