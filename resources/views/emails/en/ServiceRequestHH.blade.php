Hey {{$customer}},<br>
<br>
We’re just confirming that your order request #{{$order->id}} - "{{$service_request->name}}" has been successfully created and sent. <br>
<br>
Order Details:<br>
<br>
<br>
GigHunter Name: {{$supplier}}<br>
Service: {{$service_request->name}}<br>
Order ID: <a href="{{url('customer/dashboard/orders?order_id='.$order->id)}}">#{{$order->id}} - {{$service_request->name}} </a><br>
Due date to deliver: {{$service_request->days_to_deliver}} {{($service_request->price_unit=='hour')?"hour":"day"}}<br>
Service Price: {{number_format($service_request->price_per_unit)}} EGP <br>	
Handling fees({{config('site_settings.commission.service.handling')*100}}%): {{$transaction_fee}} EGP <br>
Total Price: {{number_format($service_request->price)}} EGP<br>
<br>
Regards from the Flexigigs Team! 