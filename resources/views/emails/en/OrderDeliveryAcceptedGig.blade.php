Hey {{$order->supplier->username}},<br>
<br>
<br>
Well done! We’re happy to inform you that your order delivery <a href="{{url('supplier/dashboard/gigs')}}">#{{$order->id}} - {{$order->application->title}}</a> has been accepted by the HeadHunter.<br>
<br>
<br>
<b>Order Details:</b><br>
<br>
Order ID: #<a href="{{url('supplier/dashboard/gigs')}}">#{{$order->id}} - {{$order->application->title}}</a><br>
HeadHunter Name: {{$order->customer->username}}<br>
Gig: {{$order->application->title}}<br>
Gig Price: {{$price}} EGP<br>
Transaction fees ({{config('site_settings.commission.gig.transaction')}}%): {{$transaction_fee}} EGP<br>
(to be deducted) <br>
Total Price: {{$total}} EGP<br>
<br>
<br>
<br>
Your well-earned payment will be released ASAP as per Flexigigs’ Terms & Conditions. <br>
Any problems with payment and/or its agreed-upon timeframe, feel free to <a href="{{route('contact-us')}}">contact us</a> immediately.<br>
<br>
Regards from the Flexigigs Team! 