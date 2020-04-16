Hey {{$order->supplier->username}}, <br>
 <br>
It has been more than 24hrs since you accepted <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> service order from {{$order->customer->username}}. However, we are sorry to inform you that {{$order->customer->username}} has not made the payment on time! As a result, we have got no choice but to cancel this order. <br>
 <br>
Keep an eye on the posted gigs and don’t forget to keep your profile up-to-date with your recent work. <br>
 <br>
Regards from the Flexigigs Team!
