Hey {{$order->customer->username}},<br>
<br>
We just wanted to let you know that your service request for <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}” has been accepted</a> by {{$order->supplier->username}}. Let us now redirect you to the payment page so {{$order->supplier->username}} can start working on the gig for you!<br>
<br>
Order Details:<br>
<br>
<br>
GigHunter Name: <a href="{{route('supplier_profile',['username'=>$order->supplier->username])}}">{{$order->supplier->username}}</a><br>
Service: <a href="{{route('service_details',['id'=>$order->request->service_id])}}">{{$order->request->name}}</a><br>
Order ID: <a href="{{route('customer_orders',['order_id'=>$order->id])}}">#{{$order->id}} - {{$order->request->name}} </a><br>
Due date to deliver: {{$order->delivery_at}}<br>
Service Price: {{$price->formated_price}} EGP<br>
Handling fees ({{$price->transaction_commission*100}}%): {{$price->handling}} EGP<br>
Total Payable Price: {{$price->total_handling}} EGP<br>
<br>
<br>
<a href="{{route('customer_orders',['order_id'=>$order->id])}}">Click here to pay.</a><br>
<br>
Regards from the Flexigigs Team!<br>
