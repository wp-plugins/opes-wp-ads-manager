jQuery( function() {

	PNotify.prototype.options.delay = 6000;

	var accordion = jQuery( 'div#accordion-widgets' );
	var accordion_loader = jQuery( 'div#accordion-loader' );
	var tabs_positions_widgets = jQuery( "#tabs-positions-widgets" );

	var afterUpadting = function( img_Obj, title_Obj, new_title ) {
		setTimeout( function() {
			img_Obj.animate( { height: 0 } , 250 );
			setTimeout( function() {
				img_Obj.css( { display: 'none' } );
				if ( title_Obj && new_title )
					title_Obj.html( new_title );
			}, 250 );
		}, 800);
	};

	tabs_positions_widgets
		.tabs({
			collapsible: true,
			active: false,
			hide: 150,
			show: 150,
			heightStyle: "content"
		})
		.on( 'focusout blur' , this , function(e) {
			var this_submit_Obj = jQuery( this );

			e.preventDefault();
			e.stopPropagation();

			//alert('ok');
			console.log('ok');

			//tabs_positions_widgets.tabs( 'refresh' );
		})
		.find( '#add-position-tab-1 form' ).submit( function(e) {
			var this_submit_Obj = jQuery( this );

			//e.preventDefault();
			e.stopPropagation();

			var add_name = this_submit_Obj.find( 'input#add-name' ).val();

			if ( add_name.trim() == '' || add_name.trim().length < 6 ) {
				new PNotify({
					title: uwxl_add_position_title,
					text: uwxl_add_position_name_error,
					type: 'warning',
					opacity: .9,
					styling: 'jqueryui',
					//addclass: 'custom',
					desktop: {
						desktop: true
					},
					hide: true
				});

				e.preventDefault();
				return false;
			}

			return true;
		});

	accordion
		.accordion({
			header: "> div.position-widget > h3",
			active: false,
			heightStyle: "content",
			animate: 150,
			collapsible: true,
			create: function( event, ui ) {
				accordion.show( 800 );
				setTimeout( function() {
					accordion_loader.hide( 200 );
				}, 800);
			}
	    })
		.on( 'click' , 'button.submit-accordion-form' , function(e) {
			var this_submit_Obj = jQuery( this );

			e.preventDefault();
			e.stopPropagation();

			var parent_position_widget_Obj = this_submit_Obj.closest( 'div.position-widget' );
			var parent_form_Obj = parent_position_widget_Obj.find( 'div.accordion-form' );
			var submit_accordion_form_title_Obj = parent_position_widget_Obj.find( 'h3#accordion-form-title span#form-title' );
			var submit_accordion_form_loader_img_Obj = parent_form_Obj.find( 'div#submit-accordion-form-loader img' );
			submit_accordion_form_loader_img_Obj.css( { display: 'inline-block' } ).animate( { height: 22 } , 250 );

			var submit_accordion_form_id = parent_form_Obj.find( 'input#position-widget-id' ).val();
			var submit_accordion_form_name = parent_form_Obj.find( 'input#position-widget-name' ).val();
			var submit_accordion_form_desc = parent_form_Obj.find( 'textarea#position-widget-desc' ).val();

			if ( submit_accordion_form_name.trim() == '' || submit_accordion_form_name.trim().length < 6 ) {
				new PNotify({
					title: uwxl_add_position_title,
					text: uwxl_add_position_name_error,
					type: 'warning',
					opacity: .9,
					styling: 'jqueryui',
					//addclass: 'custom',
					desktop: {
						desktop: true
					},
					hide: true
				});

				afterUpadting( submit_accordion_form_loader_img_Obj, false, false );

				return false;
			}

			//console.log( submit_accordion_form_id );
			//console.log( submit_accordion_form_name );
			//console.log( submit_accordion_form_desc );

			jQuery.ajax( {
				type: 'POST',
				beforeSend: function() {
				},
				data: {
					'action': 'update_position_widget',
					'position': submit_accordion_form_id,
					'data': {
						'name': submit_accordion_form_name,
						'desc': submit_accordion_form_desc
					}
				},
				dataType: 'json',
				timeout: 8000,
				url: ajaxurl,
				//dataType: 'html',
				success: function( data_ , textStatus , jqXHR ) {
					if ( typeof data_ == 'object' ) {

						if ( data_.status == 'success' || data_.status == 'warning' || data_.status == 'error' ) {

							var if_hide = false;

							if ( data_.status == 'success' ) {
								afterUpadting( submit_accordion_form_loader_img_Obj, submit_accordion_form_title_Obj, submit_accordion_form_name );
								if_hide = true;
							} else {
								afterUpadting( submit_accordion_form_loader_img_Obj, false, false );
							}

							new PNotify({
								title: uwxl_update_position_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>"+data_.message,
								type: data_.status,
								opacity: .9,
								styling: 'jqueryui',
								//addclass: 'custom',
								desktop: {
									desktop: true
								},
								hide: if_hide
							});
						} else {

							new PNotify({
								title: uwxl_update_position_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>Error 3: "+uwxl_update_position_error,
								type: 'error',
								opacity: .5,
								styling: 'jqueryui',
								//addclass: 'custom',
								desktop: {
									desktop: true
								},
								hide: false
							});

							afterUpadting( submit_accordion_form_loader_img_Obj, false, false );
						}

					} else {
						new PNotify({
							title: uwxl_update_position_title,
							text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>Error 2: "+uwxl_update_position_error,
							type: 'error',
							opacity: .5,
							styling: 'jqueryui',
							//addclass: 'custom',
							desktop: {
								desktop: true
							},
							hide: false
						});

						afterUpadting( submit_accordion_form_loader_img_Obj, false, false );

						//alert( data_ );
					};
				},
				error: function( jqXHR , textStatus , errorThrown ) {
					new PNotify({
						title: uwxl_update_position_title,
						text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>Error 1: "+uwxl_update_position_error,
						type: 'error',
						opacity: .5,
						styling: 'jqueryui',
						//addclass: 'custom',
						desktop: {
							desktop: true
						},
						hide: false
					});

					afterUpadting( submit_accordion_form_loader_img_Obj, false, false );
				}
			});
	    });
		//.show( 800 );
});