// toggle: function( fn ) {
// 	// Save reference to arguments for access in closure
// 	var args = arguments,
// 		guid = fn.guid || jQuery.guid++,
// 		i = 0,
// 		toggler = function( event ) {
// 			// Figure out which function to execute
// 			var lastToggle = ( jQuery.data( this, "lastToggle" + fn.guid ) || 0 ) % i;
// 			jQuery.data( this, "lastToggle" + fn.guid, lastToggle + 1 );
//
// 			// Make sure that clicks stop
// 			event.preventDefault();
//
// 			// and execute the function
// 			return args[ lastToggle ].apply( this, arguments ) || false;
// 		};
//
// 	// link all the functions, so any of them can unbind this click handler
// 	toggler.guid = guid;
// 	while ( i < args.length ) {
// 		args[ i++ ].guid = guid;
// 	}
//
// 	return this.click( toggler );
// },
//
// hover: function( fnOver, fnOut ) {
// 	return this.mouseenter( fnOver ).mouseleave( fnOut || fnOver );
// }
// });


$( document ).ready(function() {
	$('button').toggle(
		function () {
			$('#map').removeClass('col-map').addClass('col-map-full');
			$('#list').hide();
		}, function () {
			$('#map').hide().removeClass('col-map-full').addClass('col-map');
			$('#list').show().addClass('col-list-full');
		}, function () {
			$('#map').show();
			$('#list').removeClass('col-list-full').addClass('col-list');
		})
});


// var action = 1;
// $('#toggle').on("click", toggleView);
//
// function toggleView() {
// 	if( action === 1 ) {
// 		$('#map').removeClass('col-map').addClass('col-map-full');
// 		$('#list').hide();
// 		action = 2;
// 	} else if( action === 2 ) {
// 		$('#map').hide().removeClass('col-map-full').addClass('col-map');
// 		$('#list').show().addClass('col-list-full');
// 		action = 3;
// 	} else {
// 		$('#map').show();
// 		$('#list').removeClass('col-list-full').addClass('col-list');
// 		action =1;
// 	}
// }

// $(function(){
// 	$('#toggle').on("click", function() {
// 		if($('#map').hasClass('col-map') === true) {
// 			$('#map').removeClass('col-map').addClass('col-map-full');
// 			$('#list').hide();
// 		} else if($('#map').hasClass('col-map-full') === true) {
// 			$('#map').hide().removeClass('col-map-full').addClass('col-map');
// 			$('#list').show().addClass('col-list-full');
// 		} else if($('#list').hasClass('col-list-full') === true) {
// 			$('#map').show();
// 			$('#list').removeClass('col-list-full').addClass('col-list');
// 		}
// 	});
// });
