<?php //var_dump($messages);
// echo count($messages);
?>
@if($messages)
    @foreach ($messages as $message)    
    <?php
    $user_id = $message->id_to;
    $msgUserdata = $message->message_to; 
    ?>
       <div class="item msgbox ">
            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#messagesList" data-target="#message-{{$message->id}}" aria-expanded="false">
                <div class="item-info-collapsed">
                    @include('admin.usermessages.parts.userdata')
                    <?php $msgUserdata = $message->message_from; ?>
                    @include('admin.usermessages.parts.userdata')
                    <p>{{date('d-m-Y',strtotime($message->created_at))}}</p>
                    <i class="icon-angle-down"></i>
                    <div class="w-100">
                        <p><?=$message->msg?>
                        <b class="fas fa-trash fa-lg text-right text-secondary p-3 del-message" data-id="{{$message->id}}" style="position: inherit; @if(app()->getLocale()=='ar') float: left; @else float:right; @endif"></b>
                        </p>
                    </div>
                </div>
                <div class="item-info">
                    <?php $msgUserdata = $message->message_from; ?>
                    @include('admin.usermessages.parts.userdata')
                    <p>{{date('d-m-Y',strtotime($message->created_at))}}</p>
                    <i class="icon-angle-down"></i>
                    <div class="col-12 mt-2">
                        <p><?=$message->msg?>
                        <b class="fas fa-trash fa-lg text-right text-secondary p-3 del-message" data-id="{{$message->id}}" style="position: inherit;@if(app()->getLocale()=='ar') float: left; @else float:right; @endif"></b>
                        </p>
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
                <div class="scrollable" data-messageid="{{$message->id}}" data-from="{{$message->id_from}}" data-to="{{$message->id_to}}" data-page="0">
                    <?php $submessages = Flexihelp::get_messages_between($message->id_from,$message->id_to,5,0); ?>
                    @include('admin.usermessages.parts.subitem')
                </div>
            </div>
        </div>
    @endforeach
    <div class="row mt-4 msgbox">{{$messages->links()}}</div>
@endif
<script type="text/javascript">
    $( document ).ready(function() {
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
                    loadmore($(this).parent().data('messageid'),$(this).parent().data('from'),$(this).parent().data('to'));
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
          type:'usermessages',
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
@include('admin.usermessages.parts.delete')
