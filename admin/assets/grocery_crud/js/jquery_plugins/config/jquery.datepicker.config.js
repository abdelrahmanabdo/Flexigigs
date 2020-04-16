$(function() {
	$(".datepicker-input").datepicker({
		dateFormat: js_date_format,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true,
		nextText: "<i class='fas fa-angle-right'></i>",
		prevText: "<i class='fas fa-angle-left'></i>"
	});

	$(".datepicker-input-clear").button();

	$(".datepicker-input-clear").click(function() {
		$(this)
			.parent()
			.find(".datepicker-input")
			.val("");
		return false;
	});
});
