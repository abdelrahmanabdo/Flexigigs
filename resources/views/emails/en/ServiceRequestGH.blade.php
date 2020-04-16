Hey {{$supplier}},<br>
<br>
Cool! Check out your new order request #{{$order->id}} - {{$service_request->name}}. <br>
<br>
<b>Order Details:</b><br>
<br>
<br>
HeadHunter Name: {{$customer}}<br>
Service: {{$service_request->name}}<br>
Order ID: #<a href="{{url('supplier/dashboard/gigs')}}">{{$order->id}} - {{$service_request->name}} </a><br>
Due date to deliver: {{$service_request->days_to_deliver}} {{($service_request->price_unit=='hour')?"hour":"day"}}<br>
Service Price: {{$service_request->price_per_unit}} EGP <br>	
Transaction fees({{config('site_settings.commission.service.handling')}}%): {{$transaction_fee}} EGP <br>
(to be deducted) <br>
Total Price: {{$supplier_total}} EGP<br>
<br>
Regards from the Flexigigs Team! 