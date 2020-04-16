Hey {{$order->supplier->username}},<br>
<br>
We’re sorry to hear about you conflict over Job Order #{{$order->id}} - {{$title}}. <br>
We’ve thoroughly reviewed all your correspondence and we are glad to inform you that <br>
we’ve decided to mark the order as “Completed”. <br>
<br>
<br>
<b>Order Details:</b><br>
HeadHunter Name: <a href="{{route('customer_profile',$order->customer->username)}}">{{$order->customer->username}}</a><br>
GigHunter Name: <a href="{{route('supplier_profile',$order->supplier->username)}}">{{$order->supplier->username}}</a><br>
Service/Gig: {{$title}}<br>
Order ID: <a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$title}}</a><br>
Service/Gig Price: {{$price}} EGP<br>
Transaction fees ({{config('site_settings.commission.service.transaction')}}%): {{$transaction_fee}} EGP  (to be deducted) <br>
Total Price: {{$total}} EGP<br>
<br>
<br>
Your well-earned payment will be released ASAP as per Flexigigs’ Terms & Conditions. So, go ahead and cash in your payment :) <br>
Any problems with payment and/or its agreed-upon timeframe, feel free to <a href="{{route('contact-us')}}">contact us</a> immediately. <br>
<br>
Regards from the Flexigigs Team!