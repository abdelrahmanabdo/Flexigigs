<?php $i=0; ?>
@foreach ($submessages as $submessage)
@if($i==0)
<?php $i++ ?>
@else
<div class="message">
    <div class="message-detail">
        <?php $msgUserdata=Flexihelp::get_user($submessage->id_from); ?>
        @include('admin.usermessages.parts.userdata')
        <p><?=Flexihelp::defult_date($submessage->created_at)?></p>
        <b class="fas fa-trash fa-lg text-right text-secondary p-3 del-message" data-id="{{$submessage->id}}" style="position: inherit;float: right;"></b>
        <div class="w-100">
            <p><?=$submessage->msg?></p>
        	@if ($submessage->attach)
			<p> <a href="<?= Flexihelp::get_file($submessage->attach)?>" target="blank" >{{$submessage->attach}}</a></p>
			<p>
				<small><strong>@lang('messages.messages.file_type') </strong>{{$submessage->type}}</small>
				<small><strong>@lang('messages.messages.file_size') </strong>{{$submessage->size}} @lang('messages.messages.megabyte')</small>
			</p>
        	@endif
        </div>
    </div>
</div>
@endif
@endforeach        