<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Widgets_Content {

	private function __construct( $params ) {
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Widgets_Content( $params );
	}

	public function getAdsInPosition( $position ) {
		global $_WPADSMNGR_uwxl__InitData;

		$args = array(
			'post_type' => $_WPADSMNGR_uwxl__InitData->ads_PostType[ 'name' ],
			'post_status' => array( 'publish' ),
			'orderby'   => 'meta_value_num',
			'order'     => 'ASC',
			'meta_key'  => 'order_in_position',
			'meta_query' => array(
				array(
					'key'     	=> 'show_advert_stop_date',
					'value'   	=> date( 'Y-m-d' ),
					'type'    	=> 'date',
					'compare' 	=> '>=',
				),
				array(
					'key' 		=> 'show_advert_start_date',
					'value'   	=> current_time( 'Y-m-d' ),
					'type'    	=> 'date',
					'compare' 	=> '<=',
				),
				array(
					'key' 		=> 'ad_position',
					'value'   	=> $position,
					'compare' 	=> '=',
				),
				array(
					'key' 		=> 'advert_state',
					'value'   	=> 'on',
					'compare' 	=> '=',
				),
				array(
					'relation' => 'OR',
					array(
						'key' 		=> 'order_in_position',
						//'value'   	=> 'on',
						//'type' 		=> 'UNSIGNED',
						'compare' 	=> 'EXISTS',
					),
					array(
						'key' 		=> 'order_in_position',
						//'value'   	=> 'on',
						//'type' 		=> 'UNSIGNED',
						'compare' 	=> 'NOT EXISTS',
					)
				)
			),
			'posts_per_page'   => -1,
		);

		return get_posts( $args );
	}

	public function getPositionWidgetContent( $position ,  $instance ) {
		global $_WPADSMNGR_uwxl__InitData;

		$ads = $this->getAdsInPosition( $position );

		$size = isset( $instance[ 'ad_size' ] ) && trim( $instance[ 'ad_size' ] ) != '' ? trim( $instance[ 'ad_size' ] ) : 'full' ;

		$widget_content = '';

		if ( is_array( $ads ) && count( $ads ) > 0 ) {
			foreach ( $ads as $key => $ad ) {
				$thumb_id = get_post_thumbnail_id( $ad->ID );
				$image = wp_get_attachment_image_src( $thumb_id, $size );

				$advert_url = get_post_meta( $ad->ID , 'advert_url' , true );
				if ( trim( $advert_url ) == '' )
					$advert_url = '#';

				if ( isset( $image[0] ) && trim( $image[0] ) != '' ) {


					$show_ad_in_widget = '<div class="uwxl-widget-image" style="">';

						$show_ad_in_widget .= '<a href="'.$advert_url.'" target="_blank" title="'.$ad->post_title.'">';
						
							$show_ad_in_widget .= '<img class="'.str_replace( 'advert' , '' , $size ).'" src="'.trim( $image[0] ).'">';

						$show_ad_in_widget .= '</a>';

					$show_ad_in_widget .= '</div>';

					$show_ad_in_widget = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_before_show_ad_in_widget_filter' , $show_ad_in_widget , $ad , $advert_url , $size , $image );

					$widget_content .= $show_ad_in_widget;

					//$_WPADSMNGR_uwxl__Stats_Functions->updateViews( $ad->ID );
					do_action( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_after_show_ad_in_widget_action' , $ad );
				}
			}
		}

		if ( empty( $widget_content ) ) {
			return false;
		} else {
			return $widget_content;
		}
	}
}

$GLOBALS['_WPADSMNGR_uwxl__Widgets_Content'] = _WPADSMNGR_uwxl__Widgets_Content::init( array() ); 
