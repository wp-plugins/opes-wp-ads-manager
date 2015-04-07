<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Restrictions {

	private function __construct( $params ) {
		global $_WPADSMNGR_uwxl__InitData;

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_ads_in_position_query_filter' , array( $this , 'adsQueryFilter' ) , 0 , 2 );

		add_filter( 'option_' . $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , array( $this , 'positionWidgetsOptionFilter' ) , 0 , 1 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_validate_positions_widgets_group_filter' , array( $this , 'validatePositionsWidgetsGroupFilter' ) , 0 , 2 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_ad_metabox_show_ads_on_selected_position_filter' , array( $this , 'adMetaboxShowAdsOnSelectedPositionFilter' ) , 0 , 1 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_info_positions_widgets_group_filter' , array( $this , 'infoPositionsWidgetsGroupFilter' ) , 0 , 1 );
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Restrictions( $params );
	}

	public function infoPositionsWidgetsGroupFilter( $info ) {

		return __( '<div class="error"><h1><p>Since version 1.1.0 only one widget can be add and only one ad can be shown.</p><p>Full version is PRO version (available soon)</p></h1></div>' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).$info;
	}

	public function validatePositionsWidgetsGroupFilter( $validateInputs , $positions_widgets ) {
		global $_WPADSMNGR_uwxl__InitData;

		if ( count( $positions_widgets ) < 1 ) {
			$return = $validateInputs;
		} else {
			$return = array(
				'positions_widgets' => $positions_widgets,
				'messages' => array(
						array(
							'setting' => $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group',
							'code' => esc_attr( 'positions_limited' ),
							'message' => __( 'In this version of the plugin you can create only 1 position widget.' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
							'type' => 'error'
						)					
					)
			);
		}

		return $return;
	}

	public function adMetaboxShowAdsOnSelectedPositionFilter( $ads_on_selected_position ) {
		return false;
	}

	public function positionWidgetsOptionFilter( $positions_widgets ) {
		$_new_positions_widgets = array();

		if ( is_array( $positions_widgets ) ) {
			$maxPos = 1;
			$noPos = 0;
			foreach ( $positions_widgets as $key => $pos ) {
				$_new_positions_widgets[ $key ] = $pos;

				$noPos++;
				if ( $noPos >= $maxPos )
					break;
			}
		}

		return $_new_positions_widgets;
	}

	public function adsQueryFilter( $args , $position ) {

		$newArgs = $args;

		$newArgs[ 'posts_per_page' ] = 1;
		//$newArgs[ 'nopaging ' ] = true;
		$newArgs[ 'paged ' ] = true;

		return $newArgs;
	}

}

_WPADSMNGR_uwxl__Restrictions::init( array() );
