<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Restrictions {

	private function __construct( $params ) {
		global $_WPADSMNGR_uwxl__InitData;

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_ads_in_position_query_filter' , array( $this , 'adsQueryFilter' ) , 0 , 2 );

		add_filter( 'option_' . $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , array( $this , 'positionWidgetsOptionFilter' ) , 0 , 1 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_validate_positions_widgets_group_filter' , array( $this , 'validatePositionsWidgetsGroupFilter' ) , 0 , 2 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_ad_metabox_show_ads_on_selected_position_filter' , array( $this , 'adMetaboxShowAdsOnSelectedPositionFilter' ) , 0 , 1 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_info_positions_widgets_group_filter' , array( $this , 'info_PositionsWidgets_AdSizes_GroupFilter' ) , 0 , 1 );

		add_filter( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_info_ad_sizes_group_filter' , array( $this , 'info_PositionsWidgets_AdSizes_GroupFilter' ) , 0 , 1 );

		add_action( 'admin_notices', array( $this , 'adminNoticeInfo' ) );
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Restrictions( $params );
	}

	public function adminNoticeInfo() {
		global $_WPADSMNGR_uwxl__InitData;

		//$class = "error";
		$message = '<div class="error"><h1><p>'.__( 'Since version 1.2.0 only one widget can be add and only two ads can be shown' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'.</p><p>'.__( 'Full version is PRO version (available soon)' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p></h1></div>';

		$message .= '<div class="updated"><h1><p>'.__( 'If you are interested in the use and further development of this plugin by me, please email me ' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).': <a href="mailto:programmer@it-opes.com">programmer@it-opes.com</a></p></h1></div>';

		$screen = get_current_screen();

		if ( isset( $screen->post_type ) && $screen->post_type == $_WPADSMNGR_uwxl__InitData->ads_PostType['name'] )
			echo $message;

		//<pre>".print_r($screen,true)."</pre>
	}

	public function info_PositionsWidgets_AdSizes_GroupFilter( $info ) {

		$message = '<div class="error"><h1><p>'.__( 'Since version 1.2.0 only one widget can be add and only two ads can be shown' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'.</p><p>'.__( 'Full version is PRO version (available soon)' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</p></h1></div>';

		$message .= '<div class="updated"><h1><p>'.__( 'If you are interested in the use and further development of this plugin by me, please email me ' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).': <a href="mailto:programmer@it-opes.com">programmer@it-opes.com</a></p></h1></div>';

		return $message.$info;
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

		$newArgs[ 'posts_per_page' ] = 2;
		//$newArgs[ 'nopaging ' ] = true;
		$newArgs[ 'paged ' ] = true;

		return $newArgs;
	}

}

_WPADSMNGR_uwxl__Restrictions::init( array() );
