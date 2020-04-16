<script type="text/javascript">
	$(document).ready(function() { 
		$('#edit{{$my_service->id}}-service').ajaxForm( {
			beforeSend: function(){
                $('.sendbtn{{$my_service->id}}').prop('disabled',true);
                $('.sendbtn{{$my_service->id}} i').removeClass('d-none');
            },
			success: function (message) {
				swal("Saved!", "updated with success", "success").then(function(value) {
					window.location = "{{ url()->full() }}";
				});
			},
			error: function (message) {
				$('.sendbtn{{$my_service->id}}').prop("disabled", false);
        		$('.sendbtn{{$my_service->id}} i').addClass('d-none');
				var edit{{$my_service->id}}serviceErrors = message.responseJSON;
				if (edit{{$my_service->id}}serviceErrors.name) {
					$('.edit{{$my_service->id}}name').addClass('has-error');
					$('.edit{{$my_service->id}}name .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.name);
				}
				if (edit{{$my_service->id}}serviceErrors.days_to_delever) {
					$('.edit{{$my_service->id}}days_to_delever').addClass('has-error');
					$('.edit{{$my_service->id}}days_to_delever .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.days_to_delever);
				}
				if (edit{{$my_service->id}}serviceErrors.price_per_unit) {
					$('.edit{{$my_service->id}}price').addClass('has-error');
					$('.edit{{$my_service->id}}price .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.price_per_unit);
				}
				if (edit{{$my_service->id}}serviceErrors.price_unit) {
					$('.edit{{$my_service->id}}unit').addClass('has-error');
					$('.edit{{$my_service->id}}unit .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.price_unit);
				}
				if (edit{{$my_service->id}}serviceErrors.category) {
					$('.edit{{$my_service->id}}category.help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.category);
				}
				if (edit{{$my_service->id}}serviceErrors.description) {
					$('.edit{{$my_service->id}}description').addClass('has-error');
					$('.edit{{$my_service->id}}description .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.description);
				}
				if (edit{{$my_service->id}}serviceErrors.terms) {
					$('.edit{{$my_service->id}}terms').addClass('has-error');
					$('.edit{{$my_service->id}}terms .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.terms);
				}
				if (edit{{$my_service->id}}serviceErrors.question1) {
					$('.edit{{$my_service->id}}question1').addClass('has-error');
					$('.edit{{$my_service->id}}question1 .help-block').removeClass('d-none').text(edit{{$my_service->id}}serviceErrors.question1);
				}
			}
		});
		

        
    });
</script>