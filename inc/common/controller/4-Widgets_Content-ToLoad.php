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
					'key' 		=> 'show_advert_start_date',
					'value'   	=> current_time( 'Y-m-d' ),
					'type'    	=> 'date',
					'compare' 	=> '<=',
				),
				array(
					'relation' => 'OR',
					array(
						'key'     	=> 'show_advert_stop_date',
						'value'   	=> date( 'Y-m-d' ),
						'type'    	=> 'date',
						'compare' 	=> '>=',
					),
					array(
						'key'     	=> 'show_advert_stop_date',
						'value'   	=> '',
						'compare' 	=> '=',
					),
					array(
						'key'     	=> 'show_advert_stop_date',
						//'value'   	=> '',
						'compare' 	=> 'NOT EXISTS',
					)
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
			'posts_per_page'   => -1//,
			//'nopaging' => true
		);

		$args = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_ads_in_position_query_filter' , $args , $position );

		return get_posts( $args );
	}

	public function getPositionWidgetContent( $position ,  $instance ) {
		global $_WPADSMNGR_uwxl__InitData;

		$ads = $this->getAdsInPosition( $position );

		$size = isset( $instance[ 'ad_size' ] ) && trim( $instance[ 'ad_size' ] ) != '' ? trim( $instance[ 'ad_size' ] ) : 'full' ;

		$fixed_max_dimension = isset( $instance[ 'fixed_max_dimension' ] ) && trim( $instance[ 'fixed_max_dimension' ] ) != '' ? trim( $instance[ 'fixed_max_dimension' ] ) : '' ;

		$widget_content = '';

		if ( is_array( $ads ) && count( $ads ) > 0 ) {
			foreach ( $ads as $key => $ad ) {
				$thumb_id = get_post_thumbnail_id( $ad->ID );
				$image = wp_get_attachment_image_src( $thumb_id, $size );

				$style_to_img = '';
				if ( isset( $image[3] ) && $image[3] === true ) {
					switch ( $fixed_max_dimension ) {
						case 'w':
							if ( isset( $image[1] ) && is_numeric( $image[1] ) )
								$style_to_img .= 'width: 100%; height: auto; max-width: ' . $image[1] . 'px;';
							break;

						case 'h':
							if ( isset( $image[2] ) && is_numeric( $image[2] ) )
								$style_to_img .= 'width: auto; height: auto; max-height: ' . $image[2] . 'px; max-width: 100%;';
							break;
					};
				} else {
					$style_to_img .= 'width: 100%; height: auto;';
				};
				if ( trim( $style_to_img ) != '' ) {
					$style_to_img = 'style="'.$style_to_img.'"';
				};

				$advert_url = get_post_meta( $ad->ID , 'advert_url' , true );
				if ( trim( $advert_url ) == '' )
					$advert_url = '#';

				if ( isset( $image[0] ) && trim( $image[0] ) != '' ) {


					$show_ad_in_widget = '<div class="uwxl-widget-image" style="">';

						$show_ad_in_widget .= '<a href="'.$advert_url.'" target="_blank" title="'.$ad->post_title.'">';
						
							$show_ad_in_widget .= '<img class="'.str_replace( 'advert' , '' , $size ).'" src="'.trim( $image[0] ).'" '.$style_to_img.' />';

						$show_ad_in_widget .= '</a>';

					$show_ad_in_widget .= '</div>';

					$filter_params = array(
						'ad' => $ad,
						'advert_url' => $advert_url,
						'size' => $size,
						'fixed_max_dimension' => $fixed_max_dimension, 
						'image' => $image
					);

					$show_ad_in_widget = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_before_show_ad_in_widget_filter' , $show_ad_in_widget , $filter_params/*$ad , $advert_url , $size , $fixed_max_dimension , $image */);

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
