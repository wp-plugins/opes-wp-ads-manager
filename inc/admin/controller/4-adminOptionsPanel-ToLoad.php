<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__adminOptionsPanel {

	private $hookname_main;
	private $hookname_image_sizes;

	//private $optionsPanelSlug;

	private $initialOptions = array(
		'positions_widgets' => array(
		),
		'ad_sizes' => array(
		)
	);

	private function __construct( $params ) {
		global $_WPADSMNGR_uwxl__InitData;

		register_activation_hook( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_ , array( $this , 'activatePluginActions' ) );

		//$this->optionsPanelSlug = $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_options';

		add_action( 'admin_menu', array( $this , 'registerAdminOptionsPanel' ) );

		add_action( 'admin_init', array( $this , 'registerAdminOptionsPanel_RegisterSettings' ) );
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__adminOptionsPanel( $params );
	}

	public function activatePluginActions() {
		global $_WPADSMNGR_uwxl__InitData;

		$positions_widgets = get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , false );
		$ad_sizes = get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes' , false );
		//$social_links = get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_social_links' , false );

		if ( !is_array( $positions_widgets ) ) {
			update_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , $this->initialOptions[ 'positions_widgets' ] );
		};
		if ( !is_array( $ad_sizes ) ) {
			update_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes' , $this->initialOptions[ 'ad_sizes' ] );
		};
	}

	public function registerAdminOptionsPanel() {
		global $_WPADSMNGR_uwxl__InitData;
		
		$this->hookname_main = add_menu_page( 
			__( 'Opes WP Ads Manager' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
			__( 'OWP Ads Manager' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ), 
			'manage_options', 
			$_WPADSMNGR_uwxl__InitData->optionsPanelSlug,
			array( $this , 'displayAdminOptionsPanel' ), 
			__WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __WPADSMNGR_uwxl__PS_ . 'images' . __WPADSMNGR_uwxl__PS_ . 'icon-20-blue.png',
			82
		);

		$this->hookname_image_sizes = add_submenu_page(
			$_WPADSMNGR_uwxl__InitData->optionsPanelSlug,//$this->hookname_main, 
			__( 'Opes WP Ads Manager - Ad Sizes' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
			__( 'Ad sizes' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ), 
			'manage_options', 
			$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes',
			array( $this , 'displayAdminOptionsPanel_AdSizes' )
		);
	}

	public function displayAdminOptionsPanel_AdSizes() {
		global $_WPADSMNGR_uwxl__InitData;

		$ad_sizes = $_WPADSMNGR_uwxl__InitData->imagesSizes;//get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes' , array() );

		settings_errors( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes_group' );

?>
	<div class="wrap uwxl-options-wrap">
<?php
		$info = '';

		$info = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_info_ad_sizes_group_filter' , $info );

		if ( !empty( $info ) )
			echo $info;
?>

		<h2><?php echo $_WPADSMNGR_uwxl__InitData->plugin_full_name_label; ?></h2>

		<h3><?php _e( 'Ad sizes' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></h3>

		<div id="tabs-sizes-widgets" style="margin-bottom: 30px;">
			<ul>
				<li><a href="#add-size-tab-1"><span class="ui-icon ui-icon-plusthick" style="display: inline-block;"></span> <?php _e( 'Add new size' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></a></li>
			</ul>
			<div id="add-size-tab-1">
				<form method="post" action="options.php" style="">
<?php 
					settings_fields( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes_group' ); 
					do_settings_sections( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes_group' );
?>
					<p>
						<strong><?php _e( 'Title' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br />
						<input id="add-title" style="width: 100%;" type="text" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_ad_sizes[add][title]" />
					</p>

					<p>
						<strong><?php _e( 'Width' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br /><span style="">(<?php _e( '0 or blank means that the value is set to "auto"' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?>)</span><br />
						<input readonly="readonly" class="spinner" id="add-width" style="width: 200px;" type="text" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_ad_sizes[add][width]" value="0" />
					</p>

					<p>
						<strong><?php _e( 'Height' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br /><span style="">(<?php _e( '0 or blank means that the value is set to "auto"' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?>)</span><br />
						<input readonly="readonly" class="spinner" id="add-height" style="width: 200px;" type="text" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_ad_sizes[add][height]" value="0" />
					</p>

					<p>
						<strong><?php _e( 'Crop' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br /><span style="">(<?php _e( 'Default is "false"' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?>)</span><br />
						<input class="" id="add-crop" style="" type="checkbox" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_ad_sizes[add][crop]" />
					</p>

					<p>
						<strong><?php _e( 'Set as admin column size' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br /><span style="">(<?php _e( 'Default is "false"' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?>)</span><br />
						<input class="" id="added_sets-admin_column_size" style="" type="checkbox" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_ad_sizes[added_sets][admin_column_size]" />
					</p>

					<p>
<?php 
					submit_button( __( 'Add' ) , 'primary' , $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes[submit]' , false , array( 'tabindex' => '1' ));
?>
					</p>
				</form>
			</div>
		</div>

		<h4><?php _e( 'Existed ad sizes' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></h4>
<?php

		$accordions = '<div id="accordion-loader" style="display: block; height: 40px; margin-top: 8px; margin-bottom: 8px; text-align: center;"><img src="' . __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __WPADSMNGR_uwxl__PS_ . 'images' . __WPADSMNGR_uwxl__PS_ . 'loader.gif"></div>';

		$accordions .= '<div id="accordion-widgets" style="display: none; width: 100%;">';

		$admin_column_size = $_WPADSMNGR_uwxl__InitData->admin_column_size;
		if ( is_array( $ad_sizes ) ) {

			foreach ( $ad_sizes as $key => $size ) {

				$admin_column_size_checked = '';
				if ( $admin_column_size == $key )
					$admin_column_size_checked = 'checked="checked"';

				$crop_checked = '';
				if ( isset( $size['crop'] ) && $size['crop'] == 'on' )
					$crop_checked = 'checked="checked"';

				$accordions .= '<div class="item-widget" id="ad-size-widget"><h3 id="accordion-form-title" ><span id="form-title">'.__( $size['title'] , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span> <span class="delete-alink" data-type="ad_size" data-id="'.$key.'">'.__( 'Delete' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span></h3>
					<div id="accordion-form-'.$key.'" class="accordion-form" style="padding: 6px 12px;">
						<input id="size-widget-id" type="hidden" value="'.$key.'" />
						<h4>'.__( 'Name' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<input id="size-widget-title" type="text" style="width: 100%;" value="'.$size['title'].'" />
						<h4>'.__( 'Width' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<input class="spinner" id="size-widget-width" type="text" style="width: 200px;" value="'.$size['width'].'" />
						<h4>'.__( 'Height' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<input class="spinner" id="size-widget-height" type="text" style="width: 200px;" value="'.$size['height'].'" />
						<h4>'.__( 'Crop' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<input class="" id="size-widget-crop" type="checkbox" style="" '.$crop_checked.' />
						<h4>'.__( 'Set as admin column size' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<input class="" id="size-widget-admin_column_size" type="checkbox" style="" '.$admin_column_size_checked.' />
						<p><button id="submit-accordion-form-'.$key.'" class="submit-accordion-form-sizes button button-primary" tabindex="1">'.__( 'Save' ).'</button> <div id="submit-accordion-form-loader" style="display: inline-block; margin: 0px 0px 0px 10px;"><img style="height: 0px; display: none;" src="' . __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __WPADSMNGR_uwxl__PS_ . 'images' . __WPADSMNGR_uwxl__PS_ . 'loader.gif"></div></p>
					</div></div>';
			}
		}

		$accordions .= '</div>';

		if ( !empty( $accordions ) ) {
			echo $accordions;
		}
?>
	</div>
<?php
	}

	public function displayAdminOptionsPanel() {
		global $_WPADSMNGR_uwxl__InitData;

		$positions_widgets = $_WPADSMNGR_uwxl__InitData->positions_widgets;//get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , array() );

		settings_errors( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group' );

?>
	<div class="wrap uwxl-options-wrap">
<?php
		$info = '';

		$info = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_info_positions_widgets_group_filter' , $info );

		if ( !empty( $info ) )
			echo $info;
?>

		<h2><?php echo $_WPADSMNGR_uwxl__InitData->plugin_full_name_label; ?></h2>

		<h3><?php _e( 'Postions Widgets' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></h3>

		<div id="tabs-positions-widgets" style="margin-bottom: 30px;">
			<ul>
				<li><a href="#add-position-tab-1"><span class="ui-icon ui-icon-plusthick" style="display: inline-block;"></span> <?php _e( 'Add new position' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></a></li>
			</ul>
			<div id="add-position-tab-1">
				<form method="post" action="options.php" style="">
<?php 
					settings_fields( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group' ); 
					do_settings_sections( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group' );
?>
					<p>
						<strong><?php _e( 'Name' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br />
						<input id="add-name" style="width: 100%;" type="text" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_positions_widgets[add][name]" />
					</p>

					<p>
						<strong><?php _e( 'Description' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></strong><br />
						<textarea id="add-desc" style="width: 100%;" name="<?php echo $_WPADSMNGR_uwxl__InitData->optionsPanelSlug; ?>_positions_widgets[add][desc]"></textarea>
					</p>

					<p>
<?php 
					submit_button( __( 'Add' ) , 'primary' , $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets[submit]' , false , array( 'tabindex' => '1' ));
?>
					</p>
				</form>
			</div>
		</div>

		<h4><?php _e( 'Existed positions widgets' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) ?></h4>
<?php

		$accordions = '<div id="accordion-loader" style="display: block; height: 40px; margin-top: 8px; margin-bottom: 8px; text-align: center;"><img src="' . __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __WPADSMNGR_uwxl__PS_ . 'images' . __WPADSMNGR_uwxl__PS_ . 'loader.gif"></div>';

		$accordions .= '<div id="accordion-widgets" style="display: none; width: 100%;">';

		if ( is_array( $positions_widgets ) ) {

			foreach ( $positions_widgets as $key => $position ) {

				$accordions .= '<div class="item-widget" id="position-widget-widget"><h3 id="accordion-form-title"><span id="form-title">'.__( $position['name'] , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span> <span class="delete-alink" data-type="position_widget" data-id="'.$key.'">'.__( 'Delete' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</span></h3>
					<div id="accordion-form-'.$key.'" class="accordion-form" style="padding: 6px 12px;">
						<input id="position-widget-id" type="hidden" value="'.$key.'" />
						<h4>'.__( 'Name' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<input id="position-widget-name" type="text" style="width: 100%;" value="'.$position['name'].'" />
						<h4>'.__( 'Decsription' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ).'</h4>
						<textarea id="position-widget-desc" style="width: 100%;">'.$position['desc'].'</textarea>
						<p><button id="submit-accordion-form-'.$key.'" class="submit-accordion-form-positions button button-primary" tabindex="1">'.__( 'Save' ).'</button> <div id="submit-accordion-form-loader" style="display: inline-block; margin: 0px 0px 0px 10px;"><img style="height: 0px; display: none;" src="' . __WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_ . 'assets' . __WPADSMNGR_uwxl__PS_ . 'images' . __WPADSMNGR_uwxl__PS_ . 'loader.gif"></div></p>
					</div></div>';
			}
		}

		$accordions .= '</div>';

		if ( !empty( $accordions ) ) {
			echo $accordions;
		}
?>
	</div>
<?php
	}

	public function registerAdminOptionsPanel_RegisterSettings() {
		global $_WPADSMNGR_uwxl__InitData;

		register_setting( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group' , $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , array( $this , 'validatePositionsWidgetsGroup' ) );

		register_setting( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes_group' , $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes' , array( $this , 'validateAdSizesGroup' ) );

	}

	public function validateAdSizesGroup( $inputs ) {
		global $_WPADSMNGR_uwxl__InitData;

		$validateInputs = array();

		$ad_sizes = $_WPADSMNGR_uwxl__InitData->imagesSizes;
		$admin_column_size = $_WPADSMNGR_uwxl__InitData->admin_column_size;

		//echo "<pre>".print_r($inputs,true)."</pre>";
		//echo "<pre>".print_r($ad_sizes,true)."</pre>";

		//wp_die();

		if ( is_array( $ad_sizes ) ) {
			$validateInputs = $ad_sizes;
		}

		$added = false;

		if ( isset( $inputs[ 'submit' ] ) && $inputs[ 'submit' ] == __( 'Add' ) ) {

			$title = trim( $inputs['add']['title'] );
			$width = trim( $inputs['add']['width'] );
			$height = trim( $inputs['add']['height'] );
			$crop = isset( $inputs['add']['crop'] ) ? trim( $inputs['add']['crop'] ) : false;

			$id = sanitize_title( trim( $title ) );
			$id = $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_' . preg_replace( "/[^A-Za-z]/", '_', $id );

			if ( isset( $ad_sizes[ $id ] ) ) {
				add_settings_error(
					$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes_group',
					esc_attr( 'size_title_exists' ),
					__( 'Size ID exists - please rename.' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
					'error'
				);

				//return false;
			} else {
				if ( !is_array( $ad_sizes ) || count( $ad_sizes ) <= 0 ) {
					$ad_sizes = array();
				};

				$ad_sizes[ $id ] = array( 
					'title' => trim( $title ),
					'width' => trim( $width ),
					'height' => trim( $height ),
					'crop' => $crop ? $crop : 'off'
				);

				$validateInputs = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_validate_ad_sizes_group_filter' , $ad_sizes , $_WPADSMNGR_uwxl__InitData->imagesSizes );

				$added = true;

				if ( isset( $inputs['added_sets']['admin_column_size'] ) && $inputs['added_sets']['admin_column_size'] == 'on' ) {

					update_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_admin_column_size' , $id );
				};
				//echo "<pre>".print_r($inputs,true)."</pre>";
				//echo "<pre>".print_r($validateInputs,true)."</pre>";
				//wp_die();
			}

		}

		//return array();

		if (  isset( $validateInputs['ad_sizes'] ) ) {
			if (  isset( $validateInputs['messages'] ) ) {
				if ( is_array( $validateInputs['messages'] ) ) {
					foreach ( $validateInputs['messages'] as $messageArr ) {
						$setting = null;
						$code= null;
						$message= null;
						$type= null;

						extract( $messageArr );

						add_settings_error( $setting, $code, $message, $type );
					}
				}
			}
			return $validateInputs['ad_sizes'];
		} else {
			if ( $added ) {
				add_settings_error(
					$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_ad_sizes_group',
					esc_attr( 'size_added_successfully' ),
					__( 'Ad size has been added successfully.' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
					'updated'
				);
			}
			return $validateInputs;
		}

		//return $validateInputs;
	}

	public function validatePositionsWidgetsGroup( $inputs ) {
		global $_WPADSMNGR_uwxl__InitData;

		$validateInputs = array();

		$positions_widgets = $_WPADSMNGR_uwxl__InitData->positions_widgets;

		if ( is_array( $positions_widgets ) ) {
			$validateInputs = $positions_widgets;
		}

		$added = false;

		//echo "<pre>".print_r($inputs,true)."</pre>";
		//wp_die();

		if ( isset( $inputs[ 'submit' ] ) && $inputs[ 'submit' ] == __( 'Add' ) ) {

			$name = trim( $inputs['add']['name'] );
			$desc = trim( $inputs['add']['desc'] );

			$id = sanitize_title( trim( $name ) );
			$id = $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_' . preg_replace( "/[^A-Za-z]/", '_', $id );

			if ( isset( $positions_widgets[ $id ] ) ) {
				add_settings_error(
					$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group',
					esc_attr( 'position_exists' ),
					__( 'Position ID exists - please rename.' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
					'error'
				);

				//return false;
			} else {
				if ( !is_array( $positions_widgets ) || count( $positions_widgets ) <= 0 ) {
					$positions_widgets = array();
				};

				$positions_widgets[ $id ] = array( 
					'name' => trim( $name ),
					'desc' => trim( $desc )
				);

				$validateInputs = apply_filters( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_validate_positions_widgets_group_filter' , $positions_widgets , $_WPADSMNGR_uwxl__InitData->positions_widgets );

				$added = true;
			}

		}

		if (  isset( $validateInputs['positions_widgets'] ) ) {
			if (  isset( $validateInputs['messages'] ) ) {
				if ( is_array( $validateInputs['messages'] ) ) {
					foreach ( $validateInputs['messages'] as $messageArr ) {
						$setting = null;
						$code= null;
						$message= null;
						$type= null;

						extract( $messageArr );

						add_settings_error( $setting, $code, $message, $type );
					}
				}
			}
			return $validateInputs['positions_widgets'];
		} else {
			if ( $added ) {
				add_settings_error(
					$_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets_group',
					esc_attr( 'position_added_successfully' ),
					__( 'Position widget has been added successfully.' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ),
					'updated'
				);
			}
			return $validateInputs;
		}
	}

}

_WPADSMNGR_uwxl__adminOptionsPanel::init( array() );