<?php
	$avatar = ($msgUserdata)?$msgUserdata->avatar:"";
	$first_name = ($msgUserdata)?$msgUserdata->first_name:"Admin";	
	$last_name = ($msgUserdata)?$msgUserdata->last_name:"";	
    $gender = ($msgUserdata)?$msgUserdata->gender:0;
 ?>
<div class="user mr-auto">
    <div class="container">
        <div class="row">
            <div class="user-img-sm m-0 mr-2">
				<div class="user-img-sm-container">
					<img src="<?=Flexihelp::get_file($avatar,'user',20,$gender)?>">
				</div>
			</div>
            <div>
                <p class="mt-1"> {{$first_name}} {{$last_name}}</p>
            </div>
        </div>
    </div>
</div>