Hey Admin,<br>

Unfortunately, it’s now 4 days post the agreed upon deadline and {{$order->supplier->username}} has missed delivering <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> service. Remain on standby; {{$order->customer->username}} will shortly claim a refund. <br>

Order details:<br>
<ul>
	<li>HeadHunter Name: {{$order->customer->username}}</li>
	<li>GigHunter Name: {{$order->supplier->username}}</li>
	<li>Service: {{$order->request->name}}</li>
	<li>Order ID: #{{order->id}} - {{$order->request->name}}</li> 
	<li>Deadline: {{$order->delivery_at}}</li>
	@if($order->request->price_unit=="hour")
		<li>Service Price: {{$order->request->price*$order->request->days_to_deliver}} EGP</li>
	@else
		<li>Service Price: {{$order->request->price}} EGP</li>

	@if($order->request->price_unit=="hour")
		<li>Refund Amount: {{$order->request->price*$order->request->days_to_deliver}} EGP</li>
	@else
		<li>Refund Amount: {{$order->request->price}} EGP</li>
<ul>

Click <a href="{{route('service_details',['id'=>$order->request->service_id])}}">here</a> for full order details.<br>

Regards from the Flexigigs Team!
