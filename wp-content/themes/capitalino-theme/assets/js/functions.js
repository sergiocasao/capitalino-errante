(function($) {

	$(document).ready(function () {

		$('.nav-toggle').on("click", function() {
			$(this).toggleClass('is-active');
			$('.nav-menu').toggleClass('is-active');
		});

		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
	        paginationClickable: true,
	        spaceBetween: 0,
	        centeredSlides: true,
	        autoplay: 2500,
	        autoplayDisableOnInteraction: false
    	});

	});

})(jQuery);
