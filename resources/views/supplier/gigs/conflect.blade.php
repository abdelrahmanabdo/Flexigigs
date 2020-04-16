<div class="modal fade message-modal" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="conflect" onreset="$('.message-modal').modal('hide');" method="post" action="{{route('sendmessage')}}">
                {{csrf_field()}}
                <input type="hidden" name="conflect" value="1">
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="id_to" value="0">
                <input type="hidden" name="id_from" value="{{Auth::user()->id}}">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('general.button_report_conflict')</h5>
                    <button type="reset" class="close"  aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group addmsg">
                        <label class="text-hide">@lang('service_category.dashboard_admin_service_message')</label>
                        <textarea name="msg" maxlength="2500" class="form-control counted send-msg" rows="1" placeholder="@lang('service_category.dashboard_admin_service_message')"></textarea>
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
    $('.reportconflect').click(function() {
        var item = $(this);
        $('form#conflect #order_id').val(item.data('order_id'));
        $('.message-modal').modal('show');
    });
    $(document).ready(function() { 
        $('#conflect').ajaxForm( {
            headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
            beforeSend: function(){
                $('#sendbtn').text('loading...').prop("disabled", true);
            },
            success: function (message) {
                $('#sendbtn').text("@lang('general.button_send')").prop("disabled", false);
                $('.message-modal').modal('hide');
                swal("Admin reported!", "Conflect message sent with success", "success");
                $('#conflect')[0].reset();
            },
            error: function (message) {
                // console.log(message);
                // alert('false');
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
            // $('.LoginErrors').removeClass('d-none').text("Wrong E-Mail or password");
        });
    });

</script>