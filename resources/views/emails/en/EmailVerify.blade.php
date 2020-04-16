<div>
	Hey {{ $name }}, </br>
	</br>
	Thanks for registering with us. </br>
	</br>
	</br>
	Let’s get started! Just confirm your email address so we can make sure everything’s spot-on. 
	</br>
	Then you can add your services, post your gigs, and get a taste of the full Flexigigs experience. 
	</br>
	</br>
	<a href="{{url('en/varify/'.$token).'?email='.urlencode($email) }}"> Confirm Email Address </a> <br>
	<br>
	Regards from the Flexigigs Team!
</div>
