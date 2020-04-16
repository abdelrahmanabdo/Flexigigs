Hey {{$order->supplier->username}}, <br>

We are sorry to hear that you couldn’t deliver the service on time, despite our regular reminders. We have no choice but to refund {{$order->customer->username}} as per his request.<br>

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
<ul> <br>

Regards from the Flexigigs Team!
