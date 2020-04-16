<script type="text/javascript">
    $('.reviewsform').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var msgData = form.serialize();
        var action = form.attr('action');
        var id = form.data('id');
        $.ajax({
            type: 'POST', 
            url: action, 
            headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
            data: msgData,
            success: function (message) {
                location.reload();
            },
            error: function (message) {
                // console.log(message);
                // alert('false');

                reviewErrors = message.responseJSON.message;
                if (reviewErrors.rate) {
                    $('#reviews-'+id+' .review-rate').addClass('has-error');
                    $('#reviews-'+id+' .review-rate .help-block').removeClass('d-none').text(reviewErrors.rate);
                }
                if (reviewErrors.comment) {
                    $('#reviews-'+id+' .review-comment').addClass('has-error');
                    $('#reviews-'+id+' .review-comment .help-block').removeClass('d-none').text(reviewErrors.comment);
                }
                $('#sendbtn').text("@lang('general.button_send')").prop("disabled", false);
            }
            // $('.LoginErrors').removeClass('d-none').text("Wrong E-Mail or password");
        });
    });

</script>