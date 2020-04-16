@foreach ($messages as $message)    
<?php
$user_id = (Auth::user()->id == $message->id_from)?$message->id_to:$message->id_from;
$msgUserdata = Flexihelp::get_user($user_id); 
?>
    @if($message->conflect==1)
        @if($message->order->type == 1)
        <div class="item msgbox">
            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#messagesList" data-target="#message-{{$message->id}}" aria-expanded="false">
                <div class="item-info-collapsed">
                    @include('admin.messages.direct.parts.userdata')
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
                                <b class="fas fa-trash float-right mr-3 mt-0"></b>
                            </div>
                        </div>
                        <p class="pl-5"><?=$message->msg?></p>
                    </div>
                </div>
                <div class="item-info">
                    <?php $msgUserdata = Flexihelp::get_user($message->id_from); ?>
                    @include('admin.messages.direct.parts.userdata')
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
                                <b class="fas fa-trash float-right mr-3 mt-0"></b>
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
                <div class="scrollable" data-messageid="{{$message->id}}" data-to="{{Auth::user()->id}}" data-page="0">
                    <?php   $submessages = Flexihelp::get_messages_between($message->id_from,$message->id_to,5,0);?>
                    @include('admin.messages.direct.parts.subitem')
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    <a href="#" class="btn btn-primary sendmessage" data-id_to="0" data-order_id="{{$message->order->id}}" data-admin_id="{{$message->admin_id}}" data-conflect="{{$message->conflect}}" data-id_from="{{Auth::user()->id}}">@lang('general.button_reply')</a>
                </div>
            </div>
        </div>
        @else
        <div class="item msgbox">
            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#messagesList" data-target="#message-{{$message->id}}" aria-expanded="false">
                <div class="item-info-collapsed">
                    @include('admin.messages.direct.parts.userdata')
                    <p><?=date('d-m-Y',strtotime($message->created_at))?></p>
                    <i class="icon-angle-down"></i>
                    <div class="w-100" class="message-head">
                        <div class="w-100">
                            <div class="mt-3 pl-5 position-relative">
                                <span class="text-dark message-head-info">#{{$message->order->id}}</span>
                                <span class="text-dark ml-4 message-head-info">{{$message->order->application->title}}</span>
                                <br>
                                <span class="text-dark message-head-info">{{$message->order->supplier->username}} (@lang('general.gigger_name'))</span>
                                <span class="text-dark ml-4 message-head-info">{{$message->order->customer->username}} (@lang('general.headhunter_name'))</span>
                            </div>
                        </div>
                        <p class="pl-5"><?=$message->msg?></p>
                    </div>
                </div>
                <div class="item-info">
                    <?php $msgUserdata = Flexihelp::get_user($message->id_from); ?>
                    @include('admin.messages.direct.parts.userdata')
                    <p><?=date('d-m-Y h:i',strtotime($message->created_at))?></p>
                    <i class="icon-angle-down"></i>
                    <div class="w-100" class="message-head">
                        <div class="w-100">
                            <div class="mt-3 pl-5 position-relative">
                                <span class="text-dark message-head-info">#{{$message->order->id}}</span>
                                <span class="text-dark ml-4 message-head-info">{{$message->order->application->title}}</span>
                                <br>
                                <span class="text-dark message-head-info">{{$message->order->supplier->username}} (@lang('general.gigger_name'))</span>
                                <span class="text-dark ml-4 message-head-info">{{$message->order->customer->username}} (@lang('general.headhunter_name'))</span>
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
                <div class="scrollable" data-messageid="{{$message->id}}" data-to="{{Auth::user()->id}}" data-page="0">
                    <?php $submessages = Flexihelp::get_messages_between($message->id_from,$message->id_to,5,0); ?>
                    @include('admin.messages.direct.parts.subitem')
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    <a href="#" class="btn btn-primary sendmessage" data-id_to="{{$user_id}}" data-order_id="{{$message->order->id}}" data-admin_id="{{$message->admin_id}}" data-conflect="{{$message->conflect}}" data-id_from="{{Auth::user()->id}}">@lang('general.button_reply')</a>
                </div>
            </div>
        </div>
        @endif
    @else
    <div class="item msgbox ">
        <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#messagesList" data-target="#message-{{$message->id}}" aria-expanded="false">
            <div class="item-info-collapsed">
                @include('admin.messages.direct.parts.userdata')
                <p><?=date('d-m-Y',strtotime($message->created_at))?></p>
                <i class="icon-angle-down"></i>
                <div class="w-100">
                    <p><?=$message->msg?></p>
                </div>
            </div>
            <div class="item-info">
                <?php $msgUserdata = Flexihelp::get_user($message->id_from); ?>
                @include('admin.messages.direct.parts.userdata')
                <p>{{date('d-m-Y h:i',strtotime($message->created_at))}}</p>
                <i class="icon-angle-down"></i>
                <div class="w-100">
                    <p><?=$message->msg?></p>
                    @if ($message->attach)
                    <p> <a href="{{Flexihelp::get_file($message->attach)}}" target="blank" >{{$message->attach}}</a></p>
                    <p>
                        <small><strong>@lang('messages.messages.file_type') </strong>{{$message->type}}</small>
                        <small><strong>@lang('messages.messages.file_size') </strong>{{$message->size}} @lang('messages.messages.megabyte')</small>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div id="message-{{$message->id}}" class="item-content collapse message-collapse" role="tabpanel">
            <div class="scrollable" data-messageid="{{$message->id}}" data-to="{{$user_id}}" data-page="0">
                <?php $submessages = Flexihelp::get_messages_between($message->id_from,$message->id_to,5,0); ?>
                @include('admin.messages.direct.parts.subitem')
            </div>
            <div class="mt-3 d-flex justify-content-end">
                <a href="#" class="btn btn-primary sendmessage" data-id_to="{{$user_id}}" data-order_id="0" data-admin_id="0" data-conflect="{{$message->conflect}}" data-id_from="{{Auth::user()->id}}">@lang('general.button_reply')</a>
            </div>
        </div>
    </div>
    @endif
@endforeach
<script type="text/javascript">
    $( document ).ready(function() {
        $('.sendmessage').click(function() {
            var item = $(this);
            $('form#sendmessage #id_to').val(item.data('id_to'));
            $('form#sendmessage #id_from').val(item.data('id_from'));
            $('form#sendmessage #order_id').val(item.data('order_id'));
            $('form#sendmessage #admin_id').val(item.data('admin_id'));
            $('form#sendmessage #conflect').val(item.data('conflect'));
            $('.message-modal').modal('show');
        });
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
                    loadmore($(this).parent().data('messageid'),<?=Auth::user()->id?>,$(this).parent().data('to'));
                }
            });
           /* new SimpleBar($(this)[index], {
                autoHide: false
            });
            el.getContentElement().addEventListener('scroll', function(){
            });*/
        });
    });
     function loadmore(messageid,id_from,id_to,limit=5) {
        page = parseInt($('#message-'+messageid+' .scrollable').attr('data-page'));
        page=page+1;
        $('#message-'+messageid+' .scrollable').attr('data-page',page);
        newpage = $('#message-'+messageid+' .scrollable').attr('data-page');
        $.post('{{route("messagewith")}}',
        { page: page,
          limit:limit,
          id_from:id_from,
          id_to:id_to,
          _token:$('meta[name="csrf-token"]').attr('content') } 
        , function( data ) {
/*          $( ".msgloader" ).removeClass('d-none');
          $( ".noResult" ).addClass('d-none');*/
        }).done( function( result ) {
            $('#message-'+messageid+' .simplebar-content').append(result);
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

</script>
