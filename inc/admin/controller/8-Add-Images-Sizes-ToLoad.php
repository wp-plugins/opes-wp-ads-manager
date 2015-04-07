<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Add_Images_Sizes {

	//private $imagesSizes;

	private function __construct( $params ) {
		add_action( 'init' , array( $this , 'addImageSizes' ) , -1 );
		add_filter( 'image_size_names_choose', array( $this , 'addImageSizesToChoose' ), -1 );
	}

	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Add_Images_Sizes( $params );
	}

	public function addImageSizes() {
		global $_WPADSMNGR_uwxl__InitData;

		foreach ( $_WPADSMNGR_uwxl__InitData->imagesSizes as $slug => $data ) {
			add_image_size( $slug , $data['width'] , $data['height'] , $data['crop'] );
		}
	}

	public function addImageSizesToChoose( $sizes ) {
		global $_WPADSMNGR_uwxl__InitData;
		
		$addsizes = array(
			//'wp-advert-standard-size' => __( "Reklama - szerokość 220px" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
			//'wp-advert-full-size' => __( "Reklama - szerokość 700px" , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ )
		);
		foreach ( $_WPADSMNGR_uwxl__InitData->imagesSizes as $slug => $data ) {
			$addsizes[ $slug ] = $data['title'];
		}
		
		$newsizes = array_merge( $sizes, $addsizes );
		return $newsizes ;
	}

}

_WPADSMNGR_uwxl__Add_Images_Sizes::init( array() ); 
