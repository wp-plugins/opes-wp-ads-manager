<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Register_Adds_As_PostTypes {

	private function __construct( $params ) {
		global $_WPADSMNGR_uwxl__InitData;

		add_action( 'init' , array( $this , 'registerPostTypes' ) , -1 );

		//add_action( 'save_post', array( $this , 'registerAddsMetabox_1_save' ) );
		//add_action( 'save_post', array( $this , 'registerAddsMetabox_2_save' ) );

		//add_action( 'admin_init', array( $this , 'addCaps' ) , -1 );
	}

	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Register_Adds_As_PostTypes( $params );
	}

	public function registerPostTypes() {
		global $_WPADSMNGR_uwxl__InitData;

		$args = array(
			'labels' => array(
				'name' => __( 'Ads' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'singular_name' => __( 'Ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'menu_name' => __( 'Ads' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'name_admin_bar' => __( 'Ads' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'all_items' => __( 'All ads' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'add_new' => __( 'New ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'add_new_item' => __( 'Add new ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'edit_item' => __( 'Edit ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'new_item' => __( 'New ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'view_item' => __( 'View ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'search_items' => __( 'Search ads' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'not_found' => __( 'No ads found' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'not_found_in_trash' => __( 'No ads were found in the trash' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'parent_item_colon'	 => __( 'Parent ad colon' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),	
			),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 4.1425257775883252,
			//'capability_type' => $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'capability_type' ],
			//'capabilities' => $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'capabilities' ],
			'supports' => array(
				'title',
				//'editor',
				'thumbnail'
			),
			//'map_meta_cap' => true
			//'register_meta_box_cb' => array( $this , 'registerAddsMetaboxes' )
		);

		register_post_type( $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ] , $args );

	}
}

_WPADSMNGR_uwxl__Register_Adds_As_PostTypes::init( array() );
