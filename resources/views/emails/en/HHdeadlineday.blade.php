Hey {{$order->customer->username}}, <br>
Today is the day when {{$order->supplier->username}} is scheduled to deliver <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a>
service. <br>
We are pretty sure {{$order->supplier->username}} is still doing his/her best to deliver the job on <br>
time. However, out of consideration, would you like to extend the deadline by few more
days?  <br>
Check your order details <a href="{{route('service_details',['id'=>$order->request->service_id])}}">here</a> and use the same link to extend the deadline. <br>
Regards from the Flexigigs Team! <br>