function showValidate(idenifier,messages){
    if (messages) {
        for(var key in messages){
            $(idenifier+key).addClass('has-error');
            $(idenifier+key+' .help-block').removeClass('d-none').text(messages[key]);
        }
    }
}
$(document).ready(function () {
    $('body').removeClass('loading');
	$('.preloader').addClass('d-none');
	// show validation messages
	(function(){
        $('.help').click(function(e){
            e.preventDefault();
            $('.nav-level-1').addClass('d-none');
            $('.to-level-1').removeClass('d-none');
            $('.nav-level-2').removeClass('d-none');
        });
        $('.to-level-1').click(function(e){
            e.preventDefault();
            $('.nav-level-1').removeClass('d-none');
            $(this).addClass('d-none');
            $('.nav-level-2').addClass('d-none');
        });
    })();
	(function () {
		var triggerBttn = document.getElementById("trigger-overlay"),
			overlay = document.querySelector("div.overlay"),
			closeBttn = document.getElementsByClassName("close-overlay-btn");
		(transEndEventNames = {
			WebkitTransition: "webkitTransitionEnd",
			MozTransition: "transitionend",
			OTransition: "oTransitionEnd",
			msTransition: "MSTransitionEnd",
			transition: "transitionend"
		}), (transEndEventName = transEndEventNames[Modernizr.prefixed("transition")]), (support = {
			transitions: Modernizr.csstransitions
		});

		function toggleOverlay() {
			if (classie.has(overlay, "open")) {
				classie.remove(overlay, "open");
				classie.add(overlay, "close");
				var onEndTransitionFn = function (ev) {
					if (support.transitions) {
						if (ev.propertyName !== "visibility") return;
						this.removeEventListener(transEndEventName, onEndTransitionFn);
					}
					classie.remove(overlay, "close");
				};
				if (support.transitions) {
					overlay.addEventListener(transEndEventName, onEndTransitionFn);
				} else {
					onEndTransitionFn();
				}
			} else if (!classie.has(overlay, "close")) {
				classie.add(overlay, "open");
			}
		}
		triggerBttn.addEventListener("click", toggleOverlay);
		for (var i = closeBttn.length - 1; i >= 0; i--) {
			closeBttn[i].addEventListener("click", toggleOverlay);
		}
	})();
	(function () { /*	$('select.form-control').each(function(index, el) {$(this).selectmenu({classes: {'ui-selectmenu-button': 'form-control', 'ui-selectmenu-icon': 'icon-caret-down', 'ui-selectmenu-menu': 'dropdown-menu', 'ui-selectmenu-open': 'show'} }); });*/
		$(".slider-range").each(function (index, el) {
			var min = $(this).data("from");
			var max = $(this).data("to");
			var pricemin = $(this).data("value-from");
			var pricemax = $(this).data("value-to");
			var input_min = $("#priceMin").val(pricemin);
			var input_max = $("#priceMax").val(pricemax);
			$(this).slider({
				range: true,
				min: min,
				max: max,
				values: [pricemin, pricemax],
				slide: function (event, ui) {
					$("#priceMin").val(ui.values[0]);
					$("#priceMax").val(ui.values[1]);
				}
			});
		});
		$(".rating-range").each(function (index, el) {
			var value = $(this).data("value");
			$(this).slider({
				min: 0,
				max: 5,
				value: value,
				step: 1,
				slide: function (event, ui) {
					$("#ratingMax").val(ui.value);
				}
			});
		});
	})();
	// (function () {
	// 	$(".service-portfolio .owl-carousel").owlCarousel({
	// 		items: 1,
	// 		center: true,
	// 		video: true,
	// 		autoHeight: true,
	// 		videoHeight: 428
	// 	});
	// })();
	(function () {
		$(".chosen-select").each(function (index, el) {
			$(this).chosen({
				max_selected_options: 4,
				width: "100%"
			});
		});
	})();
	(function () {
		var $textarea = $("textarea.counted");
		var count = 0;
		$textarea.each(function (index, el) {
			var initialCount = $(this).val().length;
			var charContainer = $(this).siblings(".char");
			charContainer.text(initialCount + "/2500");
			$(this).keyup(function () {
				count = $(this).val().length;
				if (count > 2500) {
					charContainer.addClass("text-danger");
				} else {
					charContainer.removeClass("text-danger");
				}
				charContainer.text(count + "/2500");
			});
		});
	})();
	(function () {
		var $textarea = $("input.counted");
		var count = 0;
		$textarea.each(function (index, el) {
			$(this).keyup(function () {
				count = $(this).val().length;
				var charContainer = $(this).siblings(".char");
				if (count > 200) {
					charContainer.addClass("text-danger");
				} else {
					charContainer.removeClass("text-danger");
				}
				charContainer.text(count + "/200");
			});
		});
	})();
	(function () {
		var postBtn = $("#postBtn"),
			postForm = document.getElementById("gigPost");
		postBtn.click(function (event) {
			if (classie.has(postForm, "d-none")) {
				classie.remove(postForm, "d-none");
				classie.add(postForm, "d-block");
			} else {
				classie.add(postForm, "d-none");
				classie.remove(postForm, "d-block");
			}
		});
	})();
	(function () {
		var dateFrom = $("#from"),
			dateTo = $("#to"),
			dateFormat = "yy-mm-dd";

		function getDate(element) {
			var date;
			try {
				date = $.datepicker.parseDate(dateFormat, element.value);
			} catch (error) {
				date = null;
			}
			return date;
		}
		dateFrom.datepicker().on("change", function () {
			dateTo.datepicker("option", "minDate", getDate(this));
		});
		dateTo.datepicker().on("change", function () {
			dateFrom.datepicker("option", "maxDate", getDate(this));
		});
	})();
	(function () {
		$(".datepicker, .hasDatepicker").each(function () {
			if ($(this).hasClass("hasDatepicker")) {
				$(this).removeClass("hasDatepicker").datepicker({
					dateFormat: "yy-mm-dd",
					nextText: "<i class='fas fa-angle-right'></i>",
					prevText: "<i class='fas fa-angle-left'></i>",
					setDate: new Date()
				});
			}
			$(this).datepicker({
				dateFormat: "yy-mm-dd",
				nextText: "<i class='fas fa-angle-right'></i>",
				prevText: "<i class='fas fa-angle-left'></i>",
				setDate: new Date()
			});
		});
		$('#deadlineDatePicker').each(function () {
			if ($(this).hasClass("hasDatepicker, datepicker")) {
				$(this).removeClass("hasDatepicker, datepicker").datepicker({
					dateFormat: "yy-mm-dd",
					nextText: "<i class='fas fa-angle-right'></i>",
					prevText: "<i class='fas fa-angle-left'></i>",
					setDate: new Date()
				});
			}
			$(this).datepicker({
				dateFormat: "yy-mm-dd",
				nextText: "<i class='fas fa-angle-right'></i>",
				prevText: "<i class='fas fa-angle-left'></i>",
				setDate: new Date()
			});
		});

		if ($('#deadlineDatePicker').hasClass('hasDatepicker')) {
			$('#deadlineDatePicker').removeClass("hasDatepicker").datepicker({
				dateFormat: "yy-mm-dd",
				minDate: new Date(),
				nextText: "<i class='fas fa-angle-right'></i>",
				prevText: "<i class='fas fa-angle-left'></i>",
				setDate: new Date()
			});
		} else {
			$('#deadlineDatePicker').datepicker({
				dateFormat: "yy-mm-dd",
				minDate: new Date(),
				nextText: "<i class='fas fa-angle-right'></i>",
				prevText: "<i class='fas fa-angle-left'></i>",
				setDate: new Date()
			});
		}
		

	})();
	(function () {
		var elements = $(".scrollable");
		elements.each(function (index, el) {
			new SimpleBar($(this)[0], {
				autoHide: false
			});
		});
	})();
	(function () {
		var $navPills = $(".nav-pills");
		var $tab = $navPills.find('a[role="tab"]');
		var $tabContent = $("#v-pills-tabContent");
		var $tabPane = $("#v-pills-tabContent .tab-pane");
		var $firstTab = $tab.eq(0);
		var $firstTab_selected = $firstTab.attr("aria-selected");
		if (!$firstTab.hasClass("active") && $firstTab_selected === "false") {
			$firstTab.addClass("active");
			$firstTab.attr("aria-selected", "true");
		}

		function resizing() {
			if ($(window).width() <= 730) {
				$tabPane.find(".ml-5").each(function () {
					$(this).eq(0).removeClass("ml-5").attr("class");
				});
				$tab.each(function () {
					$(this).click(function () {
						$("html, body").animate({
							scrollTop: $tabContent.offset().top - 20
						}, "slow");
					});
				});
			}
		}
		resizing();
		$(window).on("resize", function () {
			resizing();
		});
	})();
	(function () {
		$(".user-rating").each(function (index, el) {
			var $EL = $(this),
				$readonly = $EL[0].attributes["data-readonly"].nodeValue;
			$EL.barrating({
				theme: "fontawesome-stars",
				hoverState: false,
				readonly: false,
				showSelectedRating: true
			});
			if ($readonly == "true") {
				$EL.barrating("readonly", true);
			}
		});
	})();


	(function(){
		$('.side-scroll').each(function(i, el){
			$(el).mCustomScrollbar();
		});
		// $('.vertical-scroll').each(function (i, el) {
		// 	$(el).mCustomScrollbar({
		// 		axis: "x"
		// 	});
		// });
	})();
});