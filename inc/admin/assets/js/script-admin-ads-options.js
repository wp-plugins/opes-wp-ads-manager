jQuery( function() {

	PNotify.prototype.options.delay = 6000;

	var accordion = jQuery( 'div#accordion-widgets' );
	var accordion_loader = jQuery( 'div#accordion-loader' );
	var tabs_widgets = jQuery( "div#tabs-positions-widgets, div#tabs-sizes-widgets" );

	var spinners = jQuery( ".spinner" );

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

	spinners
		.spinner({
			min: 0
		});
	//spinners.spinner( "value" , "0" );

	tabs_widgets
		.tabs({
			collapsible: true,
			active: false,
			hide: 150,
			show: 150,
			heightStyle: "content",
			beforeActivate: function( event, ui ) {
			}
		})
		.on( 'focusout blur' , this , function(e) {
			//var this_submit_Obj = jQuery( this );

			e.preventDefault();
			e.stopPropagation();

			//alert('ok');
			//console.log('ok');

			//tabs_widgets.tabs( 'refresh' );
		})
		.find( 'div#add-position-tab-1 form , div#add-size-tab-1 form' ).on( 'submit' , function(e) {
			var this_submit_Obj = jQuery( this );

			//e.preventDefault();
			e.stopPropagation();

			var add_name = this_submit_Obj.find( 'input#add-name' ).val();

			var add_title = this_submit_Obj.find( 'input#add-title' ).val();

			if ( add_title.trim() == '' || add_title.trim().length < 6 ) {
				new PNotify({
					title: uwxl_add_size_title,
					text: uwxl_add_size_title_error,
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
			};

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
			};

			return true;
		});

	var deleteSize = function( id , submit_accordion_form_name , type ) {
		console.log( type );
		console.log( id );
		console.log( submit_accordion_form_name );

		var _data = {
			'action': 'delete_'+type
		};

		if ( type == 'ad_size' ) {
			_data.size = id;
		} else if ( type == 'position_widget' ) {
			_data.position = id;
		}

		if ( confirm( uwxl_delete_confirm ) ) {
			jQuery.ajax({
				type: 'POST',
				beforeSend: function() {
				},
				data: _data,
				dataType: 'json',
				timeout: 8000,
				url: ajaxurl,
				//dataType: 'html',
				success: function( data_ , textStatus , jqXHR ) {
					if ( typeof data_ == 'object' ) {
						var if_hide = false;

						if ( data_.status == 'success' || data_.status == 'warning' || data_.status == 'error' ) {
							if ( data_.status == 'success' ) {
								window.location.reload();
							} else {
								new PNotify({
									title: uwxl_delete_title,
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
							}
						} else {
							new PNotify({
								title: uwxl_delete_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>Error 3: "+uwxl_delete_error,
								type: 'error',
								opacity: .5,
								styling: 'jqueryui',
								//addclass: 'custom',
								desktop: {
									desktop: true
								},
								hide: false
							});
						}

					} else {
						new PNotify({
							title: uwxl_delete_title,
							text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>Error 2: "+uwxl_delete_error,
							type: 'error',
							opacity: .5,
							styling: 'jqueryui',
							//addclass: 'custom',
							desktop: {
								desktop: true
							},
							hide: false
						});
					};
				},
				error: function( jqXHR , textStatus , errorThrown ) {
					new PNotify({
						title: uwxl_delete_title,
						text: '<p style="font-size: 13px;">'+submit_accordion_form_name+"</p>Error 1: "+uwxl_delete_error,
						type: 'error',
						opacity: .5,
						styling: 'jqueryui',
						//addclass: 'custom',
						desktop: {
							desktop: true
						},
						hide: false
					});
				}
			});	
		};
	};

	accordion
		.accordion({
			header: "> div.item-widget > h3",
			active: false,
			heightStyle: "content",
			animate: 150,
			collapsible: true,
			create: function( event, ui ) {
				accordion.find( '.delete-alink' )
					.on( 'click' , function(e) {
						var this_submit_Obj = jQuery( this );

						e.preventDefault();
						e.stopPropagation();

						var type = this_submit_Obj.data( 'type' );
						var id = this_submit_Obj.data( 'id' );
						var parent_widget_Obj = this_submit_Obj.closest( 'div.item-widget' );
						//var parent_form_Obj = parent_widget_Obj.find( 'div.accordion-form' );
						var submit_accordion_form_title_Obj = parent_widget_Obj.find( 'h3#accordion-form-title span#form-title' );

						deleteSize( id , submit_accordion_form_title_Obj.text() , type )

						return false;
					});
				accordion.show( 800 );
				setTimeout( function() {
					accordion_loader.hide( 200 );
				}, 800);
			}
	    })
		.on( 'click' , 'button.submit-accordion-form-positions' , function(e) {
			var this_submit_Obj = jQuery( this );

			e.preventDefault();
			e.stopPropagation();

			var parent_widget_Obj = this_submit_Obj.closest( 'div.item-widget' );
			var parent_form_Obj = parent_widget_Obj.find( 'div.accordion-form' );
			var submit_accordion_form_title_Obj = parent_widget_Obj.find( 'h3#accordion-form-title span#form-title' );
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
	    })
		.on( 'click' , 'button.submit-accordion-form-sizes' , function(e) {
			var this_submit_Obj = jQuery( this );

			//alert('ok');
			//return false;

			e.preventDefault();
			e.stopPropagation();

			var parent_widget_Obj = this_submit_Obj.closest( 'div.item-widget' );
			var parent_form_Obj = parent_widget_Obj.find( 'div.accordion-form' );
			var submit_accordion_form_title_Obj = parent_widget_Obj.find( 'h3#accordion-form-title span#form-title' );
			var submit_accordion_form_loader_img_Obj = parent_form_Obj.find( 'div#submit-accordion-form-loader img' );
			submit_accordion_form_loader_img_Obj.css( { display: 'inline-block' } ).animate( { height: 22 } , 250 );

			var submit_accordion_form_id = parent_form_Obj.find( 'input#size-widget-id' ).val();
			var submit_accordion_form_title = parent_form_Obj.find( 'input#size-widget-title' ).val();
			var submit_accordion_form_width = parent_form_Obj.find( 'input#size-widget-width' ).val();
			var submit_accordion_form_height = parent_form_Obj.find( 'input#size-widget-height' ).val();
			var submit_accordion_form_crop = parent_form_Obj.find( 'input#size-widget-crop' ).is(':checked');

			if ( submit_accordion_form_title.trim() == '' || submit_accordion_form_title.trim().length < 6 ) {
				new PNotify({
					title: uwxl_add_size_title,
					text: uwxl_add_size_title_error,
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
			//console.log( submit_accordion_form_title );
			//console.log( submit_accordion_form_desc );

			jQuery.ajax({
				type: 'POST',
				beforeSend: function() {
				},
				data: {
					'action': 'update_ad_size',
					'size': submit_accordion_form_id,
					'data': {
						'title': submit_accordion_form_title,
						'width': submit_accordion_form_width,
						'height': submit_accordion_form_height,
						'crop': submit_accordion_form_crop
					}
				},
				dataType: 'json',
				timeout: 8000,
				url: ajaxurl,
				//dataType: 'html',
				success: function( data_ , textStatus , jqXHR ) {
					if ( typeof data_ == 'object' ) {

						if ( typeof data_ == 'object' && ( data_.status == 'success' || data_.status == 'warning' || data_.status == 'error' ) ) {

							var if_hide = false;

							if ( data_.status == 'success' ) {
								afterUpadting( submit_accordion_form_loader_img_Obj, submit_accordion_form_title_Obj, submit_accordion_form_title );
								if_hide = true;
							} else {
								afterUpadting( submit_accordion_form_loader_img_Obj, false, false );
							}

							new PNotify({
								title: uwxl_update_size_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>"+data_.message,
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
								title: uwxl_update_size_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>Error 3: "+uwxl_update_size_error,
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
							title: uwxl_update_size_title,
							text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>Error 2: "+uwxl_update_size_error,
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
						title: uwxl_update_size_title,
						text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>Error 1: "+uwxl_update_size_error,
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
	    })
		.on( 'change' , '.item-widget#ad-size-widget input#size-widget-admin_column_size' , function(e) {
			var this_submit = this;
			var this_submit_Obj = jQuery( this );

			e.preventDefault();
			e.stopPropagation();

			var parent_widget_Obj = this_submit_Obj.closest( 'div.item-widget' );
			var parent_form_Obj = parent_widget_Obj.find( 'div.accordion-form' );
			var submit_accordion_form_title_Obj = parent_widget_Obj.find( 'h3#accordion-form-title span#form-title' );
			var submit_accordion_form_loader_img_Obj = parent_form_Obj.find( 'div#submit-accordion-form-loader img' );
			submit_accordion_form_loader_img_Obj.css( { display: 'inline-block' } ).animate( { height: 22 } , 250 );

			var submit_accordion_form_id = parent_form_Obj.find( 'input#size-widget-id' ).val();
			var submit_accordion_form_title = parent_form_Obj.find( 'input#size-widget-title' ).val();

			var subaction = 'unset';
			if ( this_submit_Obj.is( ':checked' ) ) {
				subaction = 'set';
			};

			jQuery.ajax({
				type: 'POST',
				beforeSend: function() {
				},
				data: {
					'action': 'set_admin_column_size',
					'subaction': subaction,
					'size': submit_accordion_form_id
				},
				dataType: 'json',
				timeout: 8000,
				url: ajaxurl,
				//dataType: 'html',
				success: function( data_ , textStatus , jqXHR ) {
					if ( typeof data_ == 'object' ) {

						if ( typeof data_ == 'object' && ( data_.status == 'success' || data_.status == 'warning' || data_.status == 'error' ) ) {

							var if_hide = false;

							if ( data_.status == 'success' ) {
								/*var parent_accordion_Obj = */
								this_submit_Obj.closest( 'div#accordion-widgets' ).find( '.item-widget#ad-size-widget input#size-widget-admin_column_size' ).each( function( i , el ) {
									if ( this_submit != el ) {
										jQuery( el ).removeProp( 'checked' );
									}
								});
								if_hide = true;
							} ;
							afterUpadting( submit_accordion_form_loader_img_Obj, false, false );

							new PNotify({
								title: uwxl_set_admin_column_size_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>"+data_.message,
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
								title: uwxl_set_admin_column_size_title,
								text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>Error 3: "+uwxl_set_admin_column_size_error,
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
							title: uwxl_set_admin_column_size_title,
							text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>Error 2: "+uwxl_set_admin_column_size_error,
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
						title: uwxl_set_admin_column_size_title,
						text: '<p style="font-size: 13px;">'+submit_accordion_form_title+"</p>Error 1: "+uwxl_set_admin_column_size_error+errorThrown+textStatus+jqXHR,
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

			//console.log( 'ok' );

			//setTimeout( function() {
				//afterUpadting( submit_accordion_form_loader_img_Obj, false, false );
			//}, 2000 );

			return false;			
		});
});