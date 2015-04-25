<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Ad_Metaboxes {

	private function __construct( $params ) {
		add_action( 'add_meta_boxes', array( $this , 'registerAddsMetaboxes' ) );

		add_action( 'save_post', array( $this , 'registerAdMetabox_1_save' ) );
		add_action( 'save_post', array( $this , 'registerAdMetabox_2_save' ) ); 
	}

	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Ad_Metaboxes( $params );
	}

	public function registerAddsMetaboxes(  ) {
		global $_WPADSMNGR_uwxl__InitData;

		add_meta_box(
			$_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_1',
			__( 'Ad fields', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
			array( $this , 'registerAdMetabox_1_callback' ),
			$_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ]
		);

		add_meta_box(
			$_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_2',
			__( 'Ad settings', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
			array( $this , 'registerAdMetabox_2_callback' ),
			$_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ] ,
			'side',
			'high'
		);
	}

	public function registerAdMetabox_1_callback( $post ) {
		global $_WPADSMNGR_uwxl__InitData;

		$advert_url = get_post_meta( $post->ID, 'advert_url', true );

		wp_nonce_field( $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_1' , $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_1_nonce' );

?>
		<div class="uwxl-metabox-block">								
			<div class="uwxl-field-block">
				<label><?php _e('Link', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_) ?></label>
				<br />
				<input placeholder="<?php _e( 'Type or paste the web address, that the ad is to lead to' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?>" type="text" style="display: block; width: 100%;" name="advert_url" value="<?php 
					if ( trim( $advert_url ) != '' ) {
						esc_html_e( $advert_url ); 
					}
				?>" />
			</div>
		</div>
<?php
	}

	public function registerAdMetabox_1_save( $post_id ) {
		global $_WPADSMNGR_uwxl__InitData;

		if ( ! isset( $_POST[ $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_1_nonce' ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST[ $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_1_nonce' ], $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_1' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ] == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		if ( isset( $_POST['advert_url'] ) && trim( $_POST['advert_url'] ) != '' ) {
			update_post_meta( $post_id, 'advert_url', $_POST['advert_url'] );
		} else {
			delete_post_meta( $post_id, 'advert_url' );
		}	
	}

	public function registerAdMetabox_2_callback( $post ) {
		global $_WPADSMNGR_uwxl__InitData, $_WPADSMNGR_uwxl__Widgets_Content;

		$show_advert_start_date = get_post_meta( $post->ID, 'show_advert_start_date', true );
		$show_advert_stop_date = get_post_meta( $post->ID, 'show_advert_stop_date', true );
		$ad_position = get_post_meta( $post->ID, 'ad_position', true );

		$advert_state = get_post_meta( $post->ID, 'advert_state', true );

		wp_nonce_field( $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_2' , $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_2_nonce' );

?>
		<h4 class="metabox-field-header"><?php _e( 'On/Off' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></h4>
		<div>
			<div class="field_row">

				<div class="" id="date-fields">
					<div id="advert-state-container">
						<input class="ui-state-default" id="advert-state-checkbox" type="checkbox" name="advert_settings[advert_state]" <?php if ( $advert_state == 'on' ) echo 'checked="checked"' ; ?> />
						<div id="advert-state-ad-id" style="display: none;"><?php echo $post->ID; ?></div>
						<div id="advert-state-ad-title" style="display: none;"><?php echo get_the_title( $post->ID ); ?></div>
					</div>
				</div>

			</div>
		</div>

		<h4 class="metabox-field-header"><?php _e( 'The period of the publication' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></h4>
		<div>
			<div class="field_row">

				<div class="" id="date-fields">
					<div class="">
						<label><?php _e('Start date', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_) ?></label>
						<br />
						<input class="ui-state-default" required="required" id="show_advert_start_date" type="text" style="display: block; width: 100%;" class="show_advert_start_date" name="advert_settings[show_advert_start_date]" value="<?php esc_html_e( $show_advert_start_date ); ?>" />
					</div>

					<div class="">
						<label><?php _e('Stop date', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_) ?></label>
						<br />
						<input class="ui-state-default" id="show_advert_stop_date" type="text" style="display: block; width: 100%;" class="show_advert_stop_date" name="advert_settings[show_advert_stop_date]" value="<?php esc_html_e( $show_advert_stop_date ); ?>" />
					</div>
				</div>
			</div>

		</div>
		<script type="text/javascript">
			jQuery( function() {
				jQuery('input#show_advert_start_date').datetimepicker({
					lang:'pl',
					timepicker: false,
					i18n:{
						pl:{
							months:[
								'Styczeń','Luty','Marzec','Kwiecień',
								'Maj','Czerwiec','Lipiec','Sierpień',
								'Wrzesień','Październik','Listopad','Grudzień',
							],
							dayOfWeek:[
								"N.", "P", "W", "Ś", 
								"C", "P", "S",
							]
						}
					},
					format:'Y-m-d',//'Y-m-d H:i:s',
					step: 5,
					theme: 'dark'
				});
				jQuery('input#show_advert_stop_date').datetimepicker({
					lang:'pl',
					timepicker: false,
					i18n:{
						pl:{
							months:[
								'Styczeń','Luty','Marzec','Kwiecień',
								'Maj','Czerwiec','Lipiec','Sierpień',
								'Wrzesień','Październik','Listopad','Grudzień',
							],
							dayOfWeek:[
								"N.", "P", "W", "Ś", 
								"C", "P", "S",
							]
						}
					},
					format: 'Y-m-d',//'Y-m-d H:i:s',
					step: 5,
					theme: 'dark'
				});
			})
		</script>

		<h4><?php _e( 'Choose a position' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></h4>
<?php
		$positions_widgets = get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , false );

		if ( $positions_widgets && is_array( $positions_widgets ) ) {
?>
			<div id="select-position-block">
				<select id="select-position-widget" dir="rtl" style="text-align:right;" class="opes-rtl" name="advert_settings[ad_position]">
					<option value=""><?php _e( '- none -' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></option>
<?php
				$selected_position = false;
				foreach ( $positions_widgets as $id => $position ) {
?>
					<option value="<?php echo $id; ?>" <?php
						if ( $id == $ad_position ) {
							echo 'selected="selected"';
							$selected_position = $ad_position;
						}
					?> ><?php _e( $position['name'] , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></option>
<?php
				}
?>
				</select>

<?php
				$show_ads_on_selected_position = true;

				$show_ads_on_selected_position = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_ad_metabox_show_ads_on_selected_position_filter' , $show_ads_on_selected_position );

				if ( $show_ads_on_selected_position ) {
?>
					<h4><?php _e( 'Ads on selected position' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?><br />
						<span style="font-size: 9px;">(<?php _e( 'Their order can be adjusted, this will result in the display order on the page' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?>)</span>
					</h4>

					<div id="loader" style="display: none; height: 20px; margin-top: 8px; margin-bottom: 8px; text-align: center;"><img src="<?php echo __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __WPADSMNGR_uwxl__PS_ . 'images' . __WPADSMNGR_uwxl__PS_ . 'loader.gif' ;?>"></div>
					
					<div id="position-items-container" class="">
						<ul class="sortable">
<?php
						$ads = $_WPADSMNGR_uwxl__Widgets_Content->getAdsInPosition( $selected_position );

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
						</ul>
					</div>
<?php
				}
?>
			</div>
<?php
		}
	}

	public function registerAdMetabox_2_save( $post_id ) {
		global $_WPADSMNGR_uwxl__InitData;

		if ( ! isset( $_POST[ $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_2_nonce' ] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST[ $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_2_nonce' ], $_WPADSMNGR_uwxl__InitData->plugin_slug . 'metabox_2' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ] == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		if ( isset( $_POST['advert_settings'][ 'advert_state' ] ) && trim( $_POST['advert_settings'][ 'advert_state' ] ) == 'on' ) {
			update_post_meta( $post_id, 'advert_state', $_POST['advert_settings']['advert_state'] );
		} else {
			delete_post_meta( $post_id, 'advert_state' );
		}

		if ( isset( $_POST['advert_settings'][ 'show_advert_start_date' ] ) && trim( $_POST['advert_settings'][ 'show_advert_start_date' ] ) != '' ) {
			update_post_meta( $post_id, 'show_advert_start_date', $_POST['advert_settings']['show_advert_start_date'] );
		} else {
			delete_post_meta( $post_id, 'show_advert_start_date' );
		}

		if ( isset( $_POST['advert_settings'][ 'show_advert_stop_date' ] ) && trim( $_POST['advert_settings'][ 'show_advert_stop_date' ] ) != '' ) {
			update_post_meta( $post_id, 'show_advert_stop_date', $_POST['advert_settings']['show_advert_stop_date'] );
		} else {
			delete_post_meta( $post_id, 'show_advert_stop_date' );
		}

		if ( isset( $_POST['advert_settings'][ 'ad_position' ] ) && trim( $_POST['advert_settings'][ 'ad_position' ] ) != '' ) {
			update_post_meta( $post_id, 'ad_position', $_POST['advert_settings']['ad_position'] );
		} else {
			delete_post_meta( $post_id, 'ad_position' );
		}

		$order_in_position = get_post_meta( $post->ID, 'order_in_position', true );
		if ( empty( $order_in_position ) ) {
			update_post_meta( $post_id, 'order_in_position', -1 );
		}

		//echo "<pre>".print_r($_POST,true)."</pre>";
		//die();

		if ( isset( $_POST[ 'order_in_position_ad_id' ] ) && is_array( $_POST[ 'order_in_position_ad_id' ] ) ) {
			foreach ( $_POST[ 'order_in_position_ad_id' ] as $order => $ad_id ) {
				update_post_meta( $ad_id, 'order_in_position', (int)$order+1 );
			}
		}
	}
}

_WPADSMNGR_uwxl__Ad_Metaboxes::init( $params ); 
