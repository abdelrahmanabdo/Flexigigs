Hey {{$order->supplier->username}}, <br>
Today is the day when you are scheduled to deliver <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> to {{$order->customer->username}}. <br>
We would also like to remind you that the {{$order->customer->username}} has the right to claim br
his money back anytime now! <br>
Check the order here and, if you wish, request a deadline extension directly from
{{$order->customer->username}} <br>
Regards from the Flexigigs Team!