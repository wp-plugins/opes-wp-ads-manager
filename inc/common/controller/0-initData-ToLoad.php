<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__InitData {

	public $plugin_full_name_label;

	public $plugin_slug = '_WPADSMNGR_uwxl_';

	public $plugin_short_slug = 'wpadsmngr_uwxl';

	public $ads_PostType;

	public $imagesSizes;

	public $optionsPanelSlug;

	public $admin_column_size;

	public $positions_widgets;

	//private $ad_sizes;

	private function __construct( $params ) {
		$this->plugin_full_name_label = __( 'Opes WP Ads Manager' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ );

		$this->ads_PostType = array(
			'name' => $this->plugin_short_slug . '_ad'
		);

		$this->optionsPanelSlug = $this->plugin_short_slug . '_options';

		$this->positions_widgets = get_option( $this->optionsPanelSlug . '_positions_widgets' , false );

		$this->admin_column_size = get_option( $this->optionsPanelSlug . '_admin_column_size' , false );

		$ad_sizes = get_option( $this->optionsPanelSlug . '_ad_sizes' , false );

		if ( is_string( $this->admin_column_size ) && trim( $this->admin_column_size ) != '' ) {
			if ( !isset( $ad_sizes[ $this->admin_column_size ] ) ) {
				delete_option( $this->optionsPanelSlug . '_admin_column_size' );
				$this->admin_column_size = false;
			}
		};

		$imagesSizes = array();

		if ( is_array( $ad_sizes ) ) {
			foreach ( $ad_sizes as $size_slug => $size ) {

				/*
				$_size = array(
					'title' => __( $size['title'] , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
					'width' => $size['width'],
					'height' => $size['height'],
					'crop' => (bool)$size['crop']
				);
				*/
				//array_push( $imagesSizes , $size );
				$imagesSizes[ $size_slug ] = $size;
			};
		};

		$this->imagesSizes = $imagesSizes;/*array(
			'wp-advert-thumb-size' => array(
				'title' => __( "Ad - 50px height" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'width' => 0,
				'height' => 50,
				'crop' => false
			),
			'wp-advert-standard-size' => array(
				'title' => __( "Ad - 220px width" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'width' => 220,
				'height' => 0,
				'crop' => false
			),
			'wp-advert-middle-size' => array(
				'title' => __( "Ad - 460px width" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'width' => 460,
				'height' => 0,
				'crop' => false
			),
			'wp-advert-full-size' => array(
				'title' => __( "Ad - 700px width" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'width' => 700,
				'height' => 0,
				'crop' => false
			)
		);*/
		
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__InitData( $params );
	}

}

$GLOBALS['_WPADSMNGR_uwxl__InitData'] = _WPADSMNGR_uwxl__InitData::init( array() );
