Hey {{$order->customer->username}}, <br>
We are sorry to inform you that the delivery of <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> service is now 2 days overdue. <br>

Check your order <a href="{{route('service_details',['id'=>$order->request->service_id])}}">here</a> and, if you wish, you may extend the deadline by a few more
days. <br>

Regards from the Flexigigs Team!