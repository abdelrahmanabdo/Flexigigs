Hey {{$order->customer->username}}, <br>
We just wanted to remind you that the agreed upon deadline for delivering <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> is fast approaching. Waste no time and exert more effort, for the deadline is
only 2 days away. <br>

Don’t worry, we’ve already sent a similar reminder to {{$order->supplier->username}} and we are pretty sure he/she is exerting a lot of effort to get the job done on time.<br>

Check your order details <a href="{{route('service_details',['id'=>$order->request->service_id])}}">here</a> and, if need be, consider extending the deadline by a few more days. <br>

Regards from the Flexigigs Team!