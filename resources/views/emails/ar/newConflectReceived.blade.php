Hey {{($messagedata->id_to == 0)?"Admin":$messagedata->message_to->username}},<br>
<br>
Check out the new conflect message you’ve just received on Flexigigs’ system!<br>
<br>
Message from: {{($messagedata->id_from == 0)?"Admin":$messagedata->message_from->username}}<br>
Message content: <?=$messagedata->msg?><br>
<br>
<strong> Conflect Details </strong><br>
order ID : <a href="{{route('admin_orders')}}"></a>#{{$messagedata->order_id}} {{$title}}<br>
Headhunter name : <a href="{{route('customer_profile',$messagedata->order->customer->username)}}">{{$messagedata->order->customer->username}}</a><br>
Gighunter name : <a href="{{route('supplier_profile',$messagedata->order->supplier->username)}}">{{$messagedata->order->supplier->username}}</a><br>

<br>
<br>
Regards from the Flexigigs Team!
