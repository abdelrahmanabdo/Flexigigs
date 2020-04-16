Hey {{$order->customer->username}}, <br>
It has been more than 24hrs since you requested <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> service from <br>
{{$order->supplier->username}}. Since you couldn’t make the payment on time, we had no choice <br>
but to cancel this order. <br>
You can re-order this request if you wish or find out more <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a>  services
here. <br>
Regards from the Flexigigs Team!


Hey {{$order->supplier->username}}, <br>
This email is to give you the greenlight to go ahead and start working on <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> ordered by {{$order->customer->username}}.<br>
{{$order->customer->username}} has safely deposited <br>
your fees with us and we will release it to you once the job is successfully done on time. <br>
Order Details: <br>
‒ HeadHunter Name: <a href="">{{$order->customer->username}}</a> <br>
‒ Service: <a href="{{route('service_details',['id'=>$order->request->service_id])}}">“{{$order->request->name}}”</a> <br>
‒ Order ID: <a href="{{route('customer_orders',['order_id'=>$order->id])}}">#{{$order->id}} - {{$order->request->name}}</a> <br>
_ Due date to deliver: {{$order->delivery_at}}<br>
_ Service Price: {{$price->formated_price}} EGP<br>
‒ Transaction fees ({{$price->transaction_commission*100}}%): {{$price->handling}} EGP <br>P<br>
‒ Total Price: {{$price->total_handling}} EGP <br>
Regards from the Flexigigs Team!