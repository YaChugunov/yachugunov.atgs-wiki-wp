jQuery(document).ready( function($) {

	$('.htoc__toggle').click(function () {
		var htoc_state = $(this).parents('.htoc').attr('data-htoc-state');

		if (htoc_state == 'expanded') {
			$(this).parents('.htoc').attr('data-htoc-state', 'closed');
		} else {
			$(this).parents('.htoc').attr('data-htoc-state', 'expanded');
		}

	});

});
