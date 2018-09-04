$('.panel-title').click(function() {
	$(this)
	// Find parent with the class that starts with "col-md"
	// Change class to "col-md-3"
		.closest('[class^="col-md"]')
		.toggleClass('col-md-2 col-md-3')
		// Find siblings of parent with similar class criteria
		// - if all siblings are the same, you can use ".siblings()"
		// Change class to "col-md-2"
		.siblings('[class^="col-md"]')
		.removeClass('col-md-3')
		.addClass('col-md-2');
});
