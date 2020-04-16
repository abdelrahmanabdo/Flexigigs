Hey {{$order->customer->username}},<br>
<br>
Oops! It seems that the {{$order->supplier->username}} is overwhelmed with the amount of work he/she has in hand, and so we are sorry to inform you that your request for <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> has been declined.  <br>
<br>
Look no further, we’ve handpicked a full list of other gighunters who provide similar services. Feel free to browse through and choose from a wide range of select candidates. <br><br>
<a href="{{route('service_list',['slug'=>$order->request->category->slug])}}">Find more “{{$order->request->name}}” services here</a> <br>
<br>
Regards from the Flexigigs Team! <br>
