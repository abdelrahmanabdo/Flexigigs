@foreach ($messages as $message)    
<?php
$user_id = ($message->id_from == 0)?$message->id_to:$message->id_from;
$msgUserdata = Flexihelp::get_user($user_id); 
?>
@if($msgUserdata&&$message->order)
    @if($message->order->type == 1)
    <div class="item msgbox">
        <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#messagesList" data-target="#message-{{$message->id}}" aria-expanded="false">
            <div class="item-info-collapsed">
                @include('admin.messages.conflects.parts.userdata')
                <p><?=Flexihelp::defult_date($message->created_at)?></p>
                <i class="icon-angle-down"></i>
                <div class="w-100" class="message-head">
                    <div class="w-100">
                        <div class="mt-3 pl-5 position-relative">
                            <span class="text-dark message-head-info">#{{$message->order->id}}</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->request->name}}</span>
                            <br>
                            <span class="text-dark message-head-info">{{$message->order->supplier->username}} (@lang('general.gigger_name'))</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->customer->username}} (@lang('general.headhunter_name'))</span>
                            <b class="fas fa-trash float-right mr-3 mt-0 deletemessages" data-order_id="{{$message->order_id}}"></b>
                        </div>
                    </div>
                    <p class="pl-5"><?=$message->msg?></p>
                </div>
            </div>
            <div class="item-info">
                <?php $msgUserdata = Flexihelp::get_user($message->id_from); ?>
                @include('admin.messages.conflects.parts.userdata')
                <p><?=Flexihelp::defult_date($message->created_at)?></p>
                <i class="icon-angle-down"></i>
                <div class="w-100" class="message-head">
                    <div class="w-100">
                        <div class="mt-3 pl-5 position-relative">
                            <span class="text-dark message-head-info">#{{$message->order->id}}</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->request->name}}</span>
                            <br>
                            <span class="text-dark message-head-info">{{$message->order->supplier->username}} (@lang('general.gigger_name'))</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->customer->username}} (@lang('general.headhunter_name'))</span>
                            <b class="fas fa-trash float-right mr-3 mt-0 deletemessages" data-order_id="{{$message->order_id}}"></b>
                        </div>
                    </div>
                    <p class="pl-5"><?=$message->msg?></p>
                    @if ($message->attach)
                    <p> <a href="<?= Flexihelp::get_file($message->attach)?>" target="blank" >{{$message->attach}}</a></p>
                    <p>
                        <small><strong>@lang('messages.messages.file_type') </strong>{{$message->type}}</small>
                        <small><strong>@lang('messages.messages.file_size') </strong>{{$message->size}} @lang('messages.messages.megabyte')</small>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div id="message-{{$message->id}}" class="item-content collapse message-collapse" role="tabpanel">
            <div class="scrollable" data-messageid="{{$message->id}}" data-order_id="{{$message->order->id}}" data-to="{{$user_id}}" data-page="0">
                <?php   $submessages = Flexihelp::get_messages_between($message->id_from,$message->id_to,5,0,$message->order->id);?>
                @include('admin.messages.conflects.parts.subitem')
            </div>
                <div class="mt-3 d-flex justify-content-end">
                    <a href="#" class="btn btn-primary sendmessage" data-id_to="{{$user_id}}" data-order_id="{{$message->order->id}}">@lang('general.button_reply')</a>
                </div>
        </div>
    </div>
    @else
    <div class="item msgbox">
        <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#messagesList" data-target="#message-{{$message->id}}" aria-expanded="false">
            <div class="item-info-collapsed">
                @include('admin.messages.conflects.parts.userdata')
                <p><?=Flexihelp::defult_date($message->created_at)?></p>
                <i class="icon-angle-down"></i>
                <div class="w-100" class="message-head">
                    <div class="w-100">
                        <div class="mt-3 pl-5 position-relative">
                            <span class="text-dark message-head-info">#{{$message->order->id}}</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->application->title}}</span>
                            <br>
                            <span class="text-dark message-head-info">{{$message->order->supplier->username}} (@lang('general.gigger_name'))</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->customer->username}} (@lang('general.headhunter_name'))</span>
                            <a class="fas fa-trash float-right mr-3 mt-0 deletemessages" data-order_id="{{$message->order_id}}"></a>
                        </div>
                    </div>
                    <p class="pl-5"><?=$message->msg?></p>
                </div>
            </div>
            <div class="item-info">
                <?php $msgUserdata = Flexihelp::get_user($message->id_from); ?>
                @include('admin.messages.conflects.parts.userdata')
                <p><?=Flexihelp::defult_date($message->created_at)?></p>
                <i class="icon-angle-down"></i>
                <div class="w-100" class="message-head">
                    <div class="w-100">
                        <div class="mt-3 pl-5 position-relative">
                            <span class="text-dark message-head-info">#{{$message->order->id}}</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->application->title}}</span>
                            <br>
                            <span class="text-dark message-head-info">{{$message->order->supplier->username}} (@lang('general.gigger_name'))</span>
                            <span class="text-dark ml-4 message-head-info">{{$message->order->customer->username}} (@lang('general.headhunter_name'))</span>
                            <b class="fas fa-trash float-right mr-3 mt-0 deletemessages" data-order_id="{{$message->order_id}}"></b>
                        </div>
                    </div>
                    <p class="pl-5"><?=$message->msg?></p>
                    @if ($message->attach)
                    <p> <a href="<?= Flexihelp::get_file($message->attach)?>" target="blank" >{{$message->attach}}</a></p>
                    <p>
                        <small><strong>@lang('messages.messages.file_type') </strong>{{$message->type}}</small>
                        <small><strong>@lang('messages.messages.file_size') </strong>{{$message->size}} @lang('messages.messages.megabyte')</small>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div id="message-{{$message->id}}" class="item-content collapse message-collapse" role="tabpanel">
            <div class="scrollable" data-messageid="{{$message->id}}" data-order_id="{{$message->order->id}}" data-to="{{$user_id}}" data-page="0">
                <?php   $submessages = Flexihelp::get_messages_between($message->id_from,$message->id_to,5,0,$message->order->id);?>
                @include('admin.messages.conflects.parts.subitem')
            </div>
                <div class="mt-3 d-flex justify-content-end">
                    <a href="#" class="btn btn-primary sendmessage" data-id_to="{{$user_id}}" data-order_id="{{$message->order->id}}">@lang('general.button_reply')</a>
                </div>
        </div>
    </div>
    @endif
@endif
@endforeach
<script type="text/javascript">
    $('.deletemessages').on('click',function (e) {
        var item = $(this);
         order_id = item.data('order_id');
        swal({
          title: "@lang('messages.messages.delete_confirmation')",
          text: "@lang('messages.messages.delete_conrirmation_msg')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then(function(willDelete) {
            if (willDelete) {
                $.ajax({
                    url: '{{url("api/conflect")}}/'+order_id,
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    type: 'DELETE',
                    success: function(result) {
                        swal("@lang('messages.messages.deleted')", "@lang('messages.messages.deleted_msg')", "success").then(function (deleted) {
                            location.reload();
                        });

                    }
                });
          }
        });
    });

    $( document ).ready(function() {
        $('.sendmessage').click(function() {
            var item = $(this);
            $('form#sendmessage #id_to').val(item.data('id_to'));
            $('form#sendmessage #order_id').val(item.data('order_id'));
            $('.message-modal').modal('show');
        });
    });
     function loadmore(messageid,id_from,id_to,limit=5,order_id) {
        page = parseInt($('#message-'+messageid+' .scrollable').attr('data-page'));
        // alert(page);
        page=page+1;
        $('#message-'+messageid+' .scrollable').attr('data-page',page);
        newpage = $('#message-'+messageid+' .scrollable').attr('data-page');
        // alert(newpage);
        $.post('{{route("admin_messagewith")}}',
        { page: page,
          limit:limit,
          id_from:id_from,
          id_to:id_to,
          order_id:order_id,
          _token:$('meta[name="csrf-token"]').attr('content') } 
        , function( data ) {
/*          $( ".msgloader" ).removeClass('d-none');
          $( ".noResult" ).addClass('d-none');*/
        }).done( function( result ) {
            $('#message-'+messageid+' .simplebar-content').append(result);
            // alert(page+1);
        })
        .fail(function(errors) {
            if (!errors.responseJSON.status) {
                $('.noResult').removeClass('d-none');
            }
        })
        .always(function() {
            $( ".msgloader" ).addClass('d-none');
        });
    }

    var elements = $('.scrollable');
    // elements = 
    elements.each(function(index, el) {
        var item = $(this)[0];
        new SimpleBar(item, {
            autoHide: false
        }).getScrollElement().addEventListener('scroll', function(e){
            var msgbox = $(e.target),
            msgboxH = msgbox.siblings(".vertical").children(".simplebar-scrollbar").css("height").replace('px', ''),
            msgboxTop = msgbox.siblings(".vertical").children(".simplebar-scrollbar").css("top").replace('px', ''),
            total = parseInt(msgboxH) + parseInt(msgboxTop) + 2;
            // console.log('scroll log',total);
            if (total == 200) {
                loadmore($(this).parent().data('messageid'),0,$(this).parent().data('to'),$(this).parent().data('order_id'));
            }
        });
       /* new SimpleBar($(this)[index], {
            autoHide: false
        });
        el.getContentElement().addEventListener('scroll', function(){
        });*/
    });
</script>
