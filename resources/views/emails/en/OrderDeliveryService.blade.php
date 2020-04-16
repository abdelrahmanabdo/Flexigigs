Hey {{$order->customer->username}},<br>
<br>
<br>
Just letting you know that your order has been marked as completed by GigHunter.<br>
<b>Order Details:</b><br>
<br>
Order ID: <a href="{{url('customer/dashboard/orders?order_id='.$order->id)}}">#{{$order->id}} - {{$order->request->name}}</a><br>
GigHunter Name: {{$order->supplier->username}}<br>
Service: {{$order->request->name}} <br>
Due date to deliver: {{$order->delivery_at}}<br>
<br>
<br>
Our Flexigigs’ admin is waiting for your confirmation to release the payment. <br>
<br>
<a href="{{url('customer/dashboard/orders?order_id='.$order->id)}}">Check Your Order</a><br>
<br>
Also, please take a minute to rate the services delivered by the gighunter.<br>
<br>
Regards from the Flexigigs Team! 