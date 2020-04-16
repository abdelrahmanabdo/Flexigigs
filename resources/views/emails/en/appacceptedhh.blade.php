Hey {{$customer}},<br>
<br>
We’re just confirming that your order request #{{$order->id}} - {{$gig->title}} has been successfully created and sent.<br>
<br>
<b>Order Details:</b><br>
<br>
GigHunter Name: {{$supplier}}<br>
Gig Name: {{$gig->title}}<br>
Order ID: <a href="{{url('gig/details/'.$gig->id)}}">#{{$order->id}} - {{$gig->title}}</a><br>
Due date to deliver: {{$gig->deadline}}<br>
Gig Price: {{$gig->price}} EGP<br>
Transaction fees ({{config('site_settings.commission.gig.handling')*100}}%): {{$handling_commission}} EGP<br>
(to be deducted) <br>
Total Price: {{$customer_total}} EGP<br>
<br>
Regards from the Flexigigs Team!
