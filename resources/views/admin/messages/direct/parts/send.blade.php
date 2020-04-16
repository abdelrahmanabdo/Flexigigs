<div class="modal fade message-modal" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="sendmessage" onreset="$('.message-modal').modal('hide');$" method="post" action="{{route('sendmessage')}}">
                {{csrf_field()}}
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="admin_id" id="admin_id" value="0">
                <input type="hidden" name="id_from" id="id_from" value="0">
                <input type="hidden" name="id_to" id="id_to">
                <input type="hidden" name="conflect" id="conflect">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('messages.messages.send_message')</h5>
                    <button type="reset" class="close"  aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group addmsg">
                        <label class="text-hide">@lang('messages.messages.title')</label>
                        <textarea name="msg" maxlength="2500" class="form-control counted send-msg" rows="1" placeholder="@lang('messages.messages.title')"></textarea>
                        <span class="char">0/200</span>
                        <p class="d-none help-block"></p>
                    </div>
                    <div class="form-group">
                        <label class="custom-file">
                            <input type="file" name="attach" class="custom-file-input send-attach">
                            <span class="custom-file-control"></span>
                        </label>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit" id="sendbtn">@lang('general.button_send')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() { 
        $('#sendmessage').ajaxForm( {
            beforeSend: function(){
                $('#sendbtn').text('loading...').prop("disabled", true);
            },
            success: function (message) {
                $.post('{{route("mymessages",[$userdata->id])}}',
                { page: 0,
                  limit:10,
                  type:"supplier",
                  _token:$('meta[name="csrf-token"]').attr('content') } 
                , function( data ) {
                  $( ".msgloader" ).removeClass('d-none');
                  $( ".noResult" ).addClass('d-none');
                }).done( function( result ) {
                    $('.msgbox').remove();
                    $('#messagesList').append(result);
                    $('.send-msg').val('');
                    $('.send-attach').val('');
                    $('.message-modal').modal('hide');
                })
                .fail(function(errors) {
                    if (!errors.responseJSON.status) {
                        $('.msgbox').remove();
                        $('.noResult').removeClass('d-none');
                    }
                })
                .always(function() {
                    $( ".msgloader" ).addClass('d-none');
                    $('#sendbtn').text("@lang('general.button_send')").prop("disabled", false);
                });
            },
            error: function (message) {
                addserviceErrors = message.responseJSON;
                if (addserviceErrors.msg) {
                    $('.addmsg').addClass('has-error');
                    $('.addmsg .help-block').removeClass('d-none').text(addserviceErrors.msg);
                }
                if (addserviceErrors.attach) {
                    $('.addattach').addClass('has-error');
                    $('.addattach .help-block').removeClass('d-none').text(addserviceErrors.attach);
                }
                $('#sendbtn').text("@lang('general.button_send')").prop("disabled", false);
             }
        });
    });

</script>