<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Ad_Add_Admin_Column {

	private function __construct( $params ) {
		global $_WPADSMNGR_uwxl__InitData;

		add_filter( 'manage_' . $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ] . '_posts_columns', array( $this , 'addStateColumn' ) );
		add_action( 'manage_' . $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ] . '_posts_custom_column', array( $this , 'viewStateColumnValue' ) , 1 , 2 );
	}

	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Ad_Add_Admin_Column( $params );
	}

	public function addStateColumn( $defaults ) {
		$new_defaults = array();
		
		foreach ( $defaults as $id => $title ) {
			if ( $id == 'date' ) {
				$new_defaults[ 'ad_position' ] = __( 'Position', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ );
				$new_defaults[ 'advert_img' ] = __( 'Image', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ );
				$new_defaults[ 'advert_state' ] = __( 'On/Off', __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ );
			};
			$new_defaults[ $id ] = __( $title );
		}


		return $new_defaults;
	}

	public function viewStateColumnValue( $column_name, $id ) {
		if ( $column_name === 'ad_position' ) {
			$ad_position = get_post_meta( $id , 'ad_position' , true );

			global $_WPADSMNGR_uwxl__InitData;

			$positions_widgets = get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , false );
?>
			<span class="post-ad_position">
<?php
				if ( isset( $positions_widgets[ $ad_position ] ) ) {
?>
					<span id="position"><?php _e( $positions_widgets[ $ad_position ][ 'name' ] , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ); ?></span>
<?php
				}
?>
			</span>
<?php			
		} else if ( $column_name === 'advert_img' ) {

			$advert_img_id = get_post_thumbnail_id( $id );

			$advert_img = wp_get_attachment_image_src( $advert_img_id, 'wp-advert-thumb-size' );

			$advert_img_src = isset( $advert_img[0] ) && trim( $advert_img[0] ) != '' ? trim( $advert_img[0] ) : false;
?>
			<span class="post-advert_img">
<?php
				if ( $advert_img_src ) {
?>
					<img src="<?php echo $advert_img_src; ?>" id="advert_img-<?php echo $id; ?>" class="advert_img admin-list-column" />
<?php
				}
?>
			</span>
<?php			
		} else if ( $column_name === 'advert_state' ) {

			$advert_state = get_post_meta( $id , 'advert_state' , true );

			$sub_src = 'assets/images/unchecked_checkbox-40.png';
			$nowy_status = "on";
			if ( $advert_state == 'on' ) {
				$sub_src = 'assets/images/checked_checkbox-40.png';
				$nowy_status = "off";
			}
?>
			<span class="post-advert_state">
				<img src="<?php echo __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . $sub_src; ?>" id="advert_state-<?php echo $id; ?>" class="advert_state-to-ajax-klik admin-list-column-image-checkbox" post-id="<?php echo $id; ?>" nowy-status="<?php echo $nowy_status; ?>" img-whenset="<?php echo __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets/images/checked_checkbox-40.png'; ?>" img-whenunset="<?php echo __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets/images/unchecked_checkbox-40.png'; ?>" />
			</span>
<?php
		}
	}
}

_WPADSMNGR_uwxl__Ad_Add_Admin_Column::init( $params ); 
