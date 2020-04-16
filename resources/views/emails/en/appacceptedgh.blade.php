Hey {{$supplier}},<br>
<br>
Congratulations! Your application to gig "{{$gig->title}}" has been accepted; out of all the other <br>
applications. You’ll find the new corresponding order in your dashboard tasks.<br>
<br>
<b>Order Details:</b><br>
<br>
- HeadHunter Name: {{$customer}}<br>
- Gig Name: {{$gig->title}}<br>
- Order ID: <a href="{{route('supplier_gigs')}}">#{{$order->id}} - {{$gig->title}}</a><br>
- Due date to deliver: {{$gig->deadline}}<br>
- Gig Price: {{$gig->price}} EGP<br>
- Transaction fees ({{config('site_settings.commission.gig.handling')*100}}%): {{$transaction_fee}} EGP<br>
- (to be deducted) <br>
- Total Price: {{$supplier_total}} EGP<br>
<br>
Regards from the Flexigigs Team! 

