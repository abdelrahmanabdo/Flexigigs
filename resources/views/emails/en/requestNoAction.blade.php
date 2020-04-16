Hey {{$order->customer->username}}, <br>
<br>
It has been more than 24hrs since you requested <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> service and {{$order->supplier->username}} has not responded yet! <br>
<br>
We handpicked a full list of other gighunters who provide similar services. Feel free to browse through and choose from a wide range of select candidates. <br>
<br>
<a href="{{route('service_list',['slug'=>$order->request->category->slug])}}"> Find more “{{$order->request->name}}” services here </a><br>
<br>
Regards from the Flexigigs Team! <br>