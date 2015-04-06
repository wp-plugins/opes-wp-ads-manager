<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__InitData {

	public $plugin_full_name_label;

	public $plugin_slug = '_WPADSMNGR_uwxl_';

	public $plugin_short_slug = 'wpadsmngr_uwxl';

	public $ads_PostType;

	public $imagesSizes;

	public $optionsPanelSlug;

	public $positions_widgets;

	private function __construct( $params ) {
		$this->plugin_full_name_label = __( 'Opes WP Ads Manager' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ );

		$this->ads_PostType = array(
			'name' => $this->plugin_short_slug . '_ad'
		);

		$this->imagesSizes = array(
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
			'wp-advert-full-size' => array(
				'title' => __( "Ad - 700px width" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
				'width' => 700,
				'height' => 0,
				'crop' => false
			)
		);

		$this->optionsPanelSlug = $this->plugin_short_slug . '_options';

		$this->positions_widgets = get_option( $this->optionsPanelSlug . '_positions_widgets' , false );
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__InitData( $params );
	}

}

$GLOBALS['_WPADSMNGR_uwxl__InitData'] = _WPADSMNGR_uwxl__InitData::init( array() );
