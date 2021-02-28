
(function($) {
		
	$(".site-header #loginform").addClass("hidden");
		
	$("#bttn_login").click(function(e) {
		e.preventDefault();
		if ($(".site-header #loginform").hasClass("hidden")) {
			$(".site-header #loginform").removeClass("hidden");
		}
		else {
			$(".site-header #loginform").addClass("hidden");
		}
	});
	
})(jQuery);
