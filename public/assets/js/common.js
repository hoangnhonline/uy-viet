(function($){
	"use strict";

	// Select picker
	$('.selectpicker').selectpicker({});

	$(".sidebar-toggle").click(function() {
		$("body").toggleClass("sidebar-collapse sidebar-mini");
	});

	//button menu when reponsive
	$("#search_icon > button").click(function() {
		$(".form-select").toggle(500);
	});
	$(window).resize(function() {
		var win = $(this);
		//alert(win.width());
		if (win.width() >= 767) {
			$(".form-select").show();
		} else {
			$(".form-select").hide();
		}
	});

})(jQuery); // End of use strict