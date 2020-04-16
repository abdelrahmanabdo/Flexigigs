Hey {{$order->supplier->username}}, <br>

We just wanted to let you know that {{$order->customer->username}} has agreed to extend the deadline for your <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> service. The new deadline is {{$order->delivery_at}} <br>

Waste no time and exert more effort to beat the newly set deadline!<br>

We would also like to remind you that the {{$order->customer->username}} has the right to claim his money back in case the deadline was missed!<br>

Check your order details <a href="{{route('service_details',['id'=>$order->request->service_id])}}">here</a> <br>

Regards from the Flexigigs Team!
