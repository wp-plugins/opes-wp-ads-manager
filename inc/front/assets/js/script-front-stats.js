jQuery( function() {
	jQuery( '.uwxl-widget-image > a.counting-clicks' ).on( 'click' , function(e) {

		if ( e.which == 1 || e.which == 2 /*|| e.which == 3*/ ) {

			//e.preventDefault();
			//e.stopPropagation();

			var id = jQuery( this ).data( 'countedid' );

			console.log( id );

			var data = {
				action: 'clicks_counter',
				id: id
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php

			jQuery.ajax({
				url: uwxl_ajaxurl,
				data: data,
				cache: false,
				timeout: 10000,
				type: 'POST',
				dataType: 'html',
				success: function( data ){
					//console.log( 'ok' );
				},
				error: function( data ){
					//console.log( 'error' );
				}
			});

		}

		return true;
	});
});