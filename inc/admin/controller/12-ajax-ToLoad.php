<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__AjaxFunctions {


	private function __construct( $params ) {		
		add_action( 'wp_ajax_update_advert_state', array( $this , 'update_advert_state_callback' ) );

		add_action( 'wp_ajax_get_ads_on_position', array( $this , 'get_ads_on_position_callback' ) );

		add_action( 'wp_ajax_update_position_widget', array( $this , 'update_position_widget_callback' ) );

		add_action( 'wp_ajax_update_ad_size', array( $this , 'update_ad_size_callback' ) );

		add_action( 'wp_ajax_delete_position_widget', array( $this , 'delete_position_widget_callback' ) );

		add_action( 'wp_ajax_delete_ad_size', array( $this , 'delete_ad_size_callback' ) );

		add_action( 'wp_ajax_set_admin_column_size', array( $this , 'set_admin_column_size_callback' ) );

		add_action( 'wp_ajax_clicks_counter', array( $this , 'clicks_counter_callback' ) );
		add_action( 'wp_ajax_nopriv_clicks_counter', array( $this , 'clicks_counter_callback' ) );

		#dodane akcje w pliku 4-dashboardWidget-ToLoad.php dla admin view
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__AjaxFunctions( $params );
	}

	public function set_admin_column_size_callback() {
		global $_WPADSMNGR_uwxl__InitData, $wpdb;

		$response = array();

		if ( isset( $_POST['size'] ) && trim( $_POST['size'] ) != '' ) {
			$ad_sizes = $_WPADSMNGR_uwxl__InitData->imagesSizes;

			if ( !isset( $ad_sizes[ $_POST['size'] ] ) ) {
				$response[ 'status' ] = 'error';
				$response[ 'message' ] = '<p style="color: blue;">'.__( "Size ID does not exist." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			} else {

				if ( isset( $_POST['subaction'] ) ) {
					switch ( $_POST['subaction'] ) {
						case 'set':

							if ( is_string( $_WPADSMNGR_uwxl__InitData->admin_column_size ) && trim( $_WPADSMNGR_uwxl__InitData->admin_column_size ) != '$_WPADSMNGR_uwxl__InitData->admin_column_size' ) {

								$update_option = $wpdb->update( $wpdb->prefix.'options', array( 'option_value' => $_POST['size'] ), array( 'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_admin_column_size' ),  null, null );

								if ( $update_option === false ) {

									$response[ 'status' ] = 'error';
									$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while setting database option - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

								} else if ( $update_option === 0 || $update_option === '0' ) {
									$response[ 'status' ] = 'warning';
									$response[ 'message' ] = '<p style="color: blue;">'.__( "Setting was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
								} else {
									$response[ 'status' ] = 'success';
									$response[ 'message' ] = '<p style="color: blue;">'.__( "Size has been set" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
								}
							} else {
								$insert_option = $wpdb->insert( 
									$wpdb->prefix.'options', 
									array( 
										'option_value' => $_POST['size'] ,
										'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_admin_column_size',
										'autoload' => 'yes'
									), 
									array(
										'%s',
										'%s',
										'%s'
									)
								);

								if ( $insert_option === false ) {

									$response[ 'status' ] = 'error';
									$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while inserting database option - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

								} else if ( $insert_option === 0 || $insert_option === '0' ) {
									$response[ 'status' ] = 'warning';
									$response[ 'message' ] = '<p style="color: blue;">'.__( "Inserting was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
								} else {
									$response[ 'status' ] = 'success';
									$response[ 'message' ] = '<p style="color: blue;">'.__( "Size has been inserted" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
								}
							}

							break;
						case 'unset':

							$delete_option = $wpdb->delete( 
								$wpdb->prefix.'options', 
								array( 'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_admin_column_size' ), 
								null 
							);
							if ( $delete_option === false ) {

								$response[ 'status' ] = 'error';
								$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while deleting database option - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

							} else if ( $delete_option === 0 || $delete_option === '0' ) {
								$response[ 'status' ] = 'warning';
								$response[ 'message' ] = '<p style="color: blue;">'.__( "Deleting was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
							} else {
								$response[ 'status' ] = 'success';
								$response[ 'message' ] = '<p style="color: blue;">'.__( "Size has been deleted" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
							}

							break;

						default:
							$response[ 'status' ] = 'warning';
							$response[ 'message' ] = '<p style="color: red;">'.__( "Subaction ID has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
							break;
					}
				} else {
					$response[ 'status' ] = 'warning';
					$response[ 'message' ] = '<p style="color: red;">'.__( "Subaction ID has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				}
			}
			
		} else {
			$response[ 'status' ] = 'warning';
			$response[ 'message' ] = '<p style="color: red;">'.__( "Size ID to set has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
		}

		echo json_encode( $response );

		wp_die();
	}

	public function clicks_counter_callback() {
		global $_WPADSMNGR_uwxl__InitData;

		if ( isset( $_POST[ 'id' ] ) && is_numeric( $_POST[ 'id' ] ) ) {
			//$_WPADSMNGR_uwxl__Stats_Functions->insertClickToDB( (int)$_POST[ 'id' ] );
			do_action( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_click_ad_in_widget_action' , $_POST[ 'id' ] );
		};

		wp_die();
	}

	public function delete_position_widget_callback() {
		global $_WPADSMNGR_uwxl__InitData, $wpdb;

		$response = array();

		//$response[ 'status' ] = 'error';
		//$response[ 'message' ] = 'aaaaaaa';

		if ( isset( $_POST['position'] ) && trim( $_POST['position'] ) != '' ) {
			$positions_widgets = $_WPADSMNGR_uwxl__InitData->positions_widgets;

			if ( !isset( $positions_widgets[ $_POST['position'] ] ) ) {
				$response[ 'status' ] = 'error';
				$response[ 'message' ] = '<p style="color: blue;">'.__( "Position ID does not exist." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			} else {

				unset( $positions_widgets[ $_POST['position'] ] );

				$update_option = $wpdb->update( $wpdb->prefix.'options', array( 'option_value' => serialize( $positions_widgets ) ), array( 'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' ),  null, null );

				if ( $update_option === false ) {

					$response[ 'status' ] = 'error';
					$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while deleting from the database - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

				} else if ( $update_option === 0 || $update_option === '0' ) {
					$response[ 'status' ] = 'warning';
					$response[ 'message' ] = '<p style="color: blue;">'.__( "Updating after deleting was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				} else {
					$response[ 'status' ] = 'success';
					$response[ 'message' ] = '<p style="color: blue;">'.__( "Position has been deleted" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				}

			}
		} else {
			$response[ 'status' ] = 'warning';
			$response[ 'message' ] = '<p style="color: red;">'.__( "Position ID to delete has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
		}

		echo json_encode( $response );

		wp_die();
	}

	public function delete_ad_size_callback() {
		global $_WPADSMNGR_uwxl__InitData, $wpdb;

		$response = array();

		//$response[ 'status' ] = 'error';
		//$response[ 'message' ] = 'aaaaaaa';

		if ( isset( $_POST['size'] ) && trim( $_POST['size'] ) != '' ) {
			$ad_sizes = $_WPADSMNGR_uwxl__InitData->imagesSizes;

			if ( !isset( $ad_sizes[ $_POST['size'] ] ) ) {
				$response[ 'status' ] = 'error';
				$response[ 'message' ] = '<p style="color: blue;">'.__( "Size ID does not exist." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			} else {

				unset( $ad_sizes[ $_POST['size'] ] );

				$update_option = $wpdb->update( $wpdb->prefix.'options', array( 'option_value' => serialize( $ad_sizes ) ), array( 'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes' ),  null, null );

				if ( $update_option === false ) {

					$response[ 'status' ] = 'error';
					$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while deleting from the database - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

				} else if ( $update_option === 0 || $update_option === '0' ) {
					$response[ 'status' ] = 'warning';
					$response[ 'message' ] = '<p style="color: blue;">'.__( "Updating after deleting was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				} else {
					$response[ 'status' ] = 'success';
					$response[ 'message' ] = '<p style="color: blue;">'.__( "Size has been deleted" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				}

			}
		} else {
			$response[ 'status' ] = 'warning';
			$response[ 'message' ] = '<p style="color: red;">'.__( "Size ID to delete has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
		}

		echo json_encode( $response );

		wp_die();
	}

	public function update_ad_size_callback() {
		global $_WPADSMNGR_uwxl__InitData, $wpdb;

		$response = array();

		if ( isset( $_POST['size'] ) && trim( $_POST['size'] ) != '' ) {
			$ad_sizes = $_WPADSMNGR_uwxl__InitData->imagesSizes;

			if ( !isset( $ad_sizes[ $_POST['size'] ] ) ) {
				$response[ 'status' ] = 'error';
				$response[ 'message' ] = '<p style="color: red;">'.__( "Size ID does not exist." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			} else if ( isset( $_POST['data'] ) && is_array( $_POST['data'] ) ) {
				
				if ( isset( $_POST['data'][ 'title' ] ) && trim( $_POST['data'][ 'title' ] ) != '' ) {
					$response[ 'status' ] = 'success';
					$response[ 'message' ] = '';

					$if_update_is_need = false;

					if ( isset( $_POST['data'][ 'title' ] ) && isset( $ad_sizes[ $_POST['size'] ][ 'title' ] ) ) {

						if ( trim( $_POST['data'][ 'title' ] ) != trim( $ad_sizes[ $_POST['size'] ][ 'title' ] ) ) {

							$if_update_is_need = true;

							$ad_sizes[ $_POST['size'] ][ 'title' ] = trim( $_POST['data'][ 'title' ] );

							$response[ 'message' ] .= '<p style="color: green;">'.__( "Size title has been updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {
							$response[ 'message' ] .= '<p style="color: blue;">'.__( "Size title does not need to be updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						}

					}


					if ( isset( $_POST['data'][ 'width' ] ) && isset( $ad_sizes[ $_POST['size'] ][ 'width' ] ) ) {

						if ( trim( $_POST['data'][ 'width' ] ) != trim( $ad_sizes[ $_POST['size'] ][ 'width' ] ) ) {

							$if_update_is_need = true;

							$ad_sizes[ $_POST['size'] ][ 'width' ] = trim( $_POST['data'][ 'width' ] );

							$response[ 'message' ] .= '<p style="color: green;">'.__( "Size width has been updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {
							$response[ 'message' ] .= '<p style="color: blue;">'.__( "Size width does not need to be updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						}

					}

					if ( isset( $_POST['data'][ 'height' ] ) && isset( $ad_sizes[ $_POST['size'] ][ 'height' ] ) ) {

						if ( trim( $_POST['data'][ 'height' ] ) != trim( $ad_sizes[ $_POST['size'] ][ 'height' ] ) ) {

							$if_update_is_need = true;

							$ad_sizes[ $_POST['size'] ][ 'height' ] = trim( $_POST['data'][ 'height' ] );

							$response[ 'message' ] .= '<p style="color: green;">'.__( "Size height has been updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {
							$response[ 'message' ] .= '<p style="color: blue;">'.__( "Size height does not need to be updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						}

					}

					if ( isset( $_POST['data'][ 'crop' ] ) && isset( $ad_sizes[ $_POST['size'] ][ 'crop' ] ) ) {

						$to_update_value = trim( $_POST['data'][ 'crop' ] ) == 'true' ? 'on' : 'off';

						if ( $to_update_value != trim( $ad_sizes[ $_POST['size'] ][ 'crop' ] ) ) {

							$if_update_is_need = true;

							$ad_sizes[ $_POST['size'] ][ 'crop' ] = $to_update_value;

							$response[ 'message' ] .= '<p style="color: green;">'.__( "Size crop has been updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {
							$response[ 'message' ] .= '<p style="color: blue;">'.__( "Size crop does not need to be updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						}

					}

					if ( $if_update_is_need ) {

						$update_option = $wpdb->update( $wpdb->prefix.'options', array( 'option_value' => serialize( $ad_sizes ) ), array( 'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes' ),  null, null );

						if ( $update_option === false ) {

							$response[ 'status' ] = 'error';
							$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while updating the database - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

						} else if ( $update_option === 0 || $update_option === '0' ) {
							$response[ 'status' ] = 'warning';
							$response[ 'message' ] = '<p style="color: blue;">'.__( "Updating was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {

							$updated_ad_sizes_Res = $wpdb->get_row( "SELECT * FROM $wpdb->options WHERE option_name = '".$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes'."'", OBJECT );

							if ( isset( $updated_ad_sizes_Res->option_value ) ) {
								$updated_ad_sizes = unserialize( $updated_ad_sizes_Res->option_value );
							} else {
								$updated_ad_sizes = false;
							}

							if ( $updated_ad_sizes && isset( $updated_ad_sizes[ $_POST['size'] ][ 'title' ] ) && isset( $updated_ad_sizes[ $_POST['size'] ][ 'width' ] ) && isset( $updated_ad_sizes[ $_POST['size'] ][ 'height' ] ) && isset( $updated_ad_sizes[ $_POST['size'] ][ 'crop' ] ) ) {

								$response[ 'message' ] .= '<p style="color: black;">'.__( "Values after the update: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'<br/><span style="font-weight: normal;">'.__( "Title: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).':</span> <span style="color: green;">'.$updated_ad_sizes[ $_POST['size'] ][ 'title' ].'</span><br/><span style="font-weight: normal;">'.__( "Width: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).':</span> <span style="color: green;">'.$updated_ad_sizes[ $_POST['size'] ][ 'width' ].'</span><br/><span style="font-weight: normal;">'.__( "Width: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).':</span> <span style="color: green;">'.$updated_ad_sizes[ $_POST['size'] ][ 'height' ].'</span><br/><span style="font-weight: normal;">'.__( "Crop: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).':</span> <span style="color: green;">'.$updated_ad_sizes[ $_POST['size'] ][ 'crop' ].'</span></p>';
							}

						}
						
					} else {
						$response[ 'status' ] = 'warning';
						$response[ 'message' ] = '<p style="color: blue;">'.__( "Updating was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
					}
				} else {
					$response[ 'status' ] = 'error';
					$response[ 'message' ] = '<p style="color: red;">'.__( "Size title can not be empty" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				}

			} else {
				$response[ 'status' ] = 'warning';
				$response[ 'message' ] = '<p style="color: red;">'.__( "Size data to update has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			}
		} else {
			$response[ 'status' ] = 'warning';
			$response[ 'message' ] = '<p style="color: red;">'.__( "Size ID to update has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
		}

		echo json_encode( $response );

		wp_die();
	}

	public function update_position_widget_callback() {
		global $_WPADSMNGR_uwxl__InitData, $wpdb;

		$response = array();

		if ( isset( $_POST['position'] ) && trim( $_POST['position'] ) != '' ) {
			$positions_widgets = $_WPADSMNGR_uwxl__InitData->positions_widgets;

			if ( !isset( $positions_widgets[ $_POST['position'] ] ) ) {
				$response[ 'status' ] = 'error';
				$response[ 'message' ] = '<p style="color: red;">'.__( "Position ID does not exist." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			} else if ( isset( $_POST['data'] ) && is_array( $_POST['data'] ) ) {
				
				if ( isset( $_POST['data'][ 'name' ] ) && trim( $_POST['data'][ 'name' ] ) != '' ) {
					$response[ 'status' ] = 'success';
					$response[ 'message' ] = '';

					$if_update_is_need = false;

					if ( isset( $_POST['data'][ 'name' ] ) && isset( $positions_widgets[ $_POST['position'] ][ 'name' ] ) ) {

						if ( trim( $_POST['data'][ 'name' ] ) != trim( $positions_widgets[ $_POST['position'] ][ 'name' ] ) ) {

							$if_update_is_need = true;

							$positions_widgets[ $_POST['position'] ][ 'name' ] = trim( $_POST['data'][ 'name' ] );

							$response[ 'message' ] .= '<p style="color: green;">'.__( "Position name has been updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {
							$response[ 'message' ] .= '<p style="color: blue;">'.__( "Position name does not need to be updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						}

					}


					if ( isset( $_POST['data'][ 'desc' ] ) && isset( $positions_widgets[ $_POST['position'] ][ 'desc' ] ) ) {

						if ( trim( $_POST['data'][ 'desc' ] ) != trim( $positions_widgets[ $_POST['position'] ][ 'desc' ] ) ) {

							$if_update_is_need = true;

							$positions_widgets[ $_POST['position'] ][ 'desc' ] = trim( $_POST['data'][ 'desc' ] );

							$response[ 'message' ] .= '<p style="color: green;">'.__( "Position description has been updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {
							$response[ 'message' ] .= '<p style="color: blue;">'.__( "Position description does not need to be updated" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						}

					}

					if ( $if_update_is_need ) {

						$update_option = $wpdb->update( $wpdb->prefix.'options', array( 'option_value' => serialize( $positions_widgets ) ), array( 'option_name' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' ),  null, null );

						if ( $update_option === false ) {

							$response[ 'status' ] = 'error';
							$response[ 'message' ] = '<p style="color: red;">'.__( "An unknown error occurred while updating the database - CHECK that the data has not been corrupted!" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';

						} else if ( $update_option === 0 || $update_option === '0' ) {
							$response[ 'status' ] = 'warning';
							$response[ 'message' ] = '<p style="color: blue;">'.__( "Updating was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
						} else {

							$updated_positions_widgets_Res = $wpdb->get_row( "SELECT * FROM $wpdb->options WHERE option_name = '".$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets'."'", OBJECT );

							if ( isset( $updated_positions_widgets_Res->option_value ) ) {
								$updated_positions_widgets = unserialize( $updated_positions_widgets_Res->option_value );
							} else {
								$updated_positions_widgets = false;
							}

							if ( $updated_positions_widgets && isset( $updated_positions_widgets[ $_POST['position'] ][ 'name' ] ) && isset( $updated_positions_widgets[ $_POST['position'] ][ 'desc' ] ) ) {

								$response[ 'message' ] .= '<p style="color: black;">'.__( "Values after the update: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'<br/><span style="font-weight: normal;">'.__( "Name: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).':</span> <span style="color: green;">'.$updated_positions_widgets[ $_POST['position'] ][ 'name' ].'</span><br/><span style="font-weight: normal;">'.__( "Description: " , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).':</span> <span style="color: green;">'.$updated_positions_widgets[ $_POST['position'] ][ 'desc' ].'</span></p>';
							}

						}
						
					} else {
						$response[ 'status' ] = 'warning';
						$response[ 'message' ] = '<p style="color: blue;">'.__( "Updating was not necessary - the data has not changed." , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
					}
				} else {
					$response[ 'status' ] = 'error';
					$response[ 'message' ] = '<p style="color: red;">'.__( "Position name can not be empty" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
				}

			} else {
				$response[ 'status' ] = 'warning';
				$response[ 'message' ] = '<p style="color: red;">'.__( "Position data to update has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
			}
		} else {
			$response[ 'status' ] = 'warning';
			$response[ 'message' ] = '<p style="color: red;">'.__( "Position ID to update has not been given" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p>';
		}

		echo json_encode( $response );

		wp_die();
	}

	public function get_ads_on_position_callback() {
		global /*$_WPADSMNGR_uwxl__InitData,*/ $_WPADSMNGR_uwxl__Widgets_Content;

		if ( isset( $_POST['position'] ) && trim( $_POST['position'] ) != '' ) {

			$ads = $_WPADSMNGR_uwxl__Widgets_Content->getAdsInPosition( $_POST['position'] );

?>
			<div id="ajax-response-html-container">
<?php
			if ( is_array( $ads ) && count( $ads ) > 0 ) {
				foreach ( $ads as $key => $ad ) {
?>
					<li class="ui-state-default" style="cursor: move;" data-id="<?php echo $ad->ID; ?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span style="display: block; margin-left: 6px; margin-right: 6px; text-align: right;"><?php
						echo get_the_title( $ad->ID );
					?></span><input type="hidden" name="order_in_position_ad_id[]" value="<?php echo $ad->ID; ?>" /></li>
<?php
				}
			}
?>
			</div>
<?php
			wp_die();
		}
	}

	public function update_advert_state_callback() {
		global $wpdb; // this is how you get access to the database

		if ( isset( $_POST['post_id'] ) && isset( $_POST['nowy_status'] ) ) {

			$post_id = intval( $_POST['post_id'] );
			$nowy_status = $_POST['nowy_status'];

			if ( $nowy_status == 'on' )
				$result = update_post_meta( $post_id , 'advert_state' , $nowy_status );
			else
				$result = delete_post_meta( $post_id , 'advert_state' );

			if ( $result !== false ) {
				echo 'success';
			} else {
				echo 'error';
			}
		} else {
			echo 'error';
		}

		wp_die(); // this is required to terminate immediately and return a proper response
	}

}

//$GLOBALS['_WPADSMNGR_uwxl__AjaxFunctions'] ;
_WPADSMNGR_uwxl__AjaxFunctions::init( array() ); 
