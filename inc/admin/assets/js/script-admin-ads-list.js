jQuery( function() {

	PNotify.prototype.options.delay = 900;
	//update_timer_display();

	jQuery( 'img.advert_state-to-ajax-klik' ).live( 'click' , function( e ) {

		e.preventDefault();
		e.stopPropagation();

		var this_el = jQuery( this );
		var post_id = this_el.attr( 'post-id' );
		var nowy_status = this_el.attr( 'nowy-status' );

		jQuery.ajax( {
			type: 'POST',
			beforeSend: function() {

			},
			data: {
				'action': 'update_advert_state',
				'post_id': post_id,
				'nowy_status': nowy_status
			},
			timeout: 5000,
			url: ajaxurl,
			//dataType: 'html',
			success: function( data_ , textStatus , jqXHR ) {
				if ( data_ == 'success' ) {
					var the_text = "";
					if ( nowy_status == 'on' ) {
						this_el.attr( 'nowy-status' , 'off' );
						this_el.attr( 'src' , this_el.attr( 'img-whenset' ) );
						the_text = uwxl_ad_is_valid;
						the_type = 'success';
					} else if ( nowy_status == 'off' ) {
						this_el.attr( 'nowy-status' , 'on' );
						this_el.attr( 'src' , this_el.attr( 'img-whenunset' ) );
						the_text = uwxl_ad_is_not_valid;
						the_type = 'warning';
					}
					//PNotify.desktop.permission();
					new PNotify({
						title: uwxl_error_ad_validation_title,
						text: the_text,
						type: the_type,
						opacity: .9,
						styling: 'jqueryui'/*,
						addclass: 'custom',
						desktop: {
							desktop: true
						}*/
					});
				} else if ( data_ == 'error' ) {
					new PNotify({
						title: uwxl_error_ad_validation_title,
						text: uwxl_error_ad_validation_error,
						type: 'error',
						opacity: .5,
						styling: 'jqueryui'/*,
						addclass: 'custom',
						desktop: {
							desktop: true
						}*/
					});
				}
			},
			error: function( jqXHR , textStatus , errorThrown ) {
				new PNotify({
					title: 'Zmiana statusu wpisu',
					text: uwxl_error_ad_validation_error,
					type: 'error',
					opacity: .5,
					styling: 'jqueryui'/*,
					addclass: 'custom',
					desktop: {
						desktop: true
					}*/
				});
			}
		});

	});


//==============================================================================================
});