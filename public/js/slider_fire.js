$(document).ready(function(){
	(function() {
		$(".slider .swiper-container").owlCarousel({
			items: 1,
			autoplay: true,
			loop: true,
			navSpeed: 2500,
			smartSpeed: 2500
		});
		$(".service-portfolio .owl-carousel").owlCarousel({
			items: 1,
			center: true,
			video: true,
			autoHeight: true,
			videoHeight: 428
		});
	})();
});
