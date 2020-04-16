Hey {{$order->customer->username}}, <br>
{{$order->supplier->username}} has now spared all his/her chances to deliver <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> 
successfully on time. <br>
You may now claim a refund. <br>
Regards from the Flexigigs Team!