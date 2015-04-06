jQuery( function() {

	var advert_state_container = jQuery( 'div#advert-state-container' );
	var position_items_container = jQuery( 'div#position-items-container' );
	var select_position_widget = jQuery( 'div#select-position-block select#select-position-widget' );
	var show_advert_start_date = jQuery( 'input#show_advert_start_date' );
	var show_advert_stop_date = jQuery( 'input#show_advert_stop_date' );
	var loader = jQuery( 'div#loader' );
	//var select_position_widget = jQuery( 'select#select-position-widget' );

	PNotify.prototype.options.delay = 900;

	select_position_widget.multiselect({
		selectedList: 1,
		multiple: false
	});

	position_items_container.find( 'ul.sortable' ).sortable( { placeholder: "ui-state-highlight" } ).disableSelection();

	//show_advert_stop_date.textinput();

	advert_state_container.find( 'input#advert-state-checkbox' ).change( function(e) {
		var this_select_Obj = jQuery( this );

		if ( this_select_Obj.is( ':checked' ) ) {
			//console.log( 'checked' );
			var id = advert_state_container.find( 'div#advert-state-ad-id' ).text();
			var if_exists = position_items_container.find( 'li[data-id='+id+']:not([action=removing])' );

			if ( if_exists.length ) {
				//console.log( 'jest' );
			} else {
				//console.log( 'nie ma' );
				var title = advert_state_container.find( 'div#advert-state-ad-title' ).text();
				var to_add = '<li class="ui-state-default to-show" style="display: none; cursor: move;" data-id="'+id+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span style="display: block; margin-left: 6px; margin-right: 6px; text-align: right;">'+title+'</span><input type="hidden" name="order_in_position_ad_id[]" value="'+id+'" /></li>';

				position_items_container.find( 'ul.sortable' ).prepend( to_add ).find( 'li[data-id='+id+']:not([action=removing]).to-show' ).removeClass( 'to-show' ).show( 250 );
			}

		} else {
			//console.log( 'unchecked' );
			var id = advert_state_container.find( 'div#advert-state-ad-id' ).text();
			var to_remove = position_items_container.find( 'li[data-id='+id+']:not([action=removing])' ).attr( 'action' , 'removing' );
			to_remove.hide( 250 );
			setTimeout( function() {
				to_remove.remove();
			}
			, 200 );
		}
	});

	select_position_widget.change( function(e) {

		e.preventDefault();
		e.stopPropagation();

		position_items_container.hide( 250 );//.css( { display: 'none' } );
		loader.show( 250 );//.css( { display: 'block' } );

		var this_select_Obj = jQuery( this );

		//alert( this_select_Obj.val() );
		var position_widget = this_select_Obj.val();

		jQuery.ajax( {
			type: 'POST',
			beforeSend: function() {

			},
			data: {
				'action': 'get_ads_on_position',
				'position': position_widget
			},
			timeout: 5000,
			url: ajaxurl,
			//dataType: 'html',
			success: function( data_ , textStatus , jqXHR ) {
				if ( data_ != 'error' ) {
					var response = jQuery( data_ );

					position_items_container.find( 'ul.sortable' ).html( response.html() );//.sortable( 'refresh' );

					var id = advert_state_container.find( 'div#advert-state-ad-id' ).text();
					var if_exists = position_items_container.find( 'li[data-id='+id+']:not([action=removing])' );

					var is_checked = advert_state_container.find( 'input#advert-state-checkbox' ).is( ':checked' );

					if ( if_exists.length ) {
						console.log( 'jest' );
						//if ( if_checked ) {
							//console.log( 'zaznaczony' );
						//} else {
						if ( !is_checked ) { 
							console.log( 'nie zaznaczony' );
							if_exists.remove();
						}
					} else {
						//console.log( 'nie ma' );
						if ( is_checked ) {
							//console.log( 'zaznaczony' );
							var title = advert_state_container.find( 'div#advert-state-ad-title' ).text();
							var to_add = '<li class="ui-state-default to-show" style="display: none; cursor: move;" data-id="'+id+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span style="display: block; margin-left: 6px; margin-right: 6px; text-align: right;">'+title+'</span><input type="hidden" name="order_in_position_ad_id[]" value="'+id+'" /></li>';

							position_items_container.find( 'ul.sortable' ).prepend( to_add ).find( 'li[data-id='+id+']:not([action=removing]).to-show' ).removeClass( 'to-show' ).show();
						} //else {
							//console.log( 'nie zaznaczony' );
						//}
						//var title = advert_state_container.find( 'div#advert-state-ad-title' ).text();
						//var to_add = '<li class="ui-state-default to-show" style="display: none; cursor: move;" data-id="'+id+'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span style="display: block; margin-left: 6px; margin-right: 6px; text-align: right;">'+title+'</span><input type="hidden" name="order_in_position_ad_id[]" value="'+id+'" /></li>';

						//position_items_container.find( 'ul.sortable' ).prepend( to_add ).find( 'li[data-id='+id+']:not([action=removing]).to-show' ).removeClass( 'to-show' ).show( 250 );
					}

					position_items_container.show( 250 );//css( { display: 'block' } );
					loader.hide( 250 );//css( { display: 'none' } );
				} else {
					new PNotify({
						title: uwxl_ads_on_position_title,
						text: uwxl_ads_on_position_error,
						type: 'error',
						opacity: .5,
						styling: 'jqueryui',
						//addclass: 'custom',
						//desktop: {
							//desktop: true
						//}
					});
					//position_items_container.show( 250 );//css( { display: 'block' } );
					loader.hide( 250 );//css( { display: 'none' } );
				};
			},
			error: function( jqXHR , textStatus , errorThrown ) {
				new PNotify({
					title: uwxl_ads_on_position_title,
					text: uwxl_ads_on_position_error,
					type: 'error',
					opacity: .5,
					styling: 'jqueryui',
					//addclass: 'custom',
					//desktop: {
						//desktop: true
					//}
				});
				//position_items_container.show( 250 );//css( { display: 'block' } );
				loader.hide( 250 );//css( { display: 'none' } );
			}
		});

	});

})