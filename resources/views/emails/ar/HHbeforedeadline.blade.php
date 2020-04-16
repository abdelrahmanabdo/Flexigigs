Hey {{$order->supplier->username}}, <br>
We just wanted to remind you that the agreed upon deadline for delivering <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> is fast approaching. Waste no time and exert more effort, for the deadline is
only 2 days away. <br>
We would also like to remind you that the {{$order->customer->username}} has the right to claim
his money back in case the deadline was missed! <br>
Check the order here and, if you wish, request a deadline extension directly from
{{$order->customer->username}} . <br>
Regards from the Flexigigs Team!