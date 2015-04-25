<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Add_Widgets {

	//private $optionsPanelSlug;

	private $positions_widgets;

	private function __construct( $params ) {
		global $_WPADSMNGR_uwxl__InitData;

		//$this->optionsPanelSlug = $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_options';

		$this->positions_widgets = get_option( $_WPADSMNGR_uwxl__InitData->optionsPanelSlug . '_positions_widgets' , false );

		if ( $this->positions_widgets ) {
			//$this->registerWidgets( $positions_widgets );
			add_action( 'widgets_init', array( $this , 'registerWidgets' ) );
		}
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Add_Widgets( $params );
	}

	public function registerWidgets() {

		foreach ( $this->positions_widgets as $widget_class_name => $position ) {
			//if ($position['type'] == 'widget' && str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9\s]/', '', $position['position'])) ) {
			if ( !preg_match( '/[^a-zA-Z_]/' , $widget_class_name ) ) {
				if( !class_exists( $widget_class_name ) )
					eval('
					class ' . $widget_class_name . ' extends WP_Widget {
						
						//private function getPositionWidgetContent( $position ) {
							//echo "bedzie kontent!";
						//}

						function __construct() {
							parent::__construct(
								"'.$widget_class_name.'", // Base ID
								"'.$position['name'].'", // Name
								array( 
									"description" => "'.$position['desc'].'" 
								) // Args
							);
						}

						function form($instance) {
							global $_WPADSMNGR_uwxl__InitData;

					        $title = !empty( $instance["title"] ) ? $instance["title"] : "";
					        $ad_size = !empty( $instance["ad_size"] ) ? $instance["ad_size"] : "";
					        $fixed_max_dimension = !empty( $instance["fixed_max_dimension"] ) ? $instance["fixed_max_dimension"] : "";
					        ?>
					            <p><label for="<?php echo $this->get_field_id("title"); ?>"><?php _e("Title:",__WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_); ?><br />
					            <input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

					            <p><label for="<?php echo $this->get_field_id("ad_size"); ?>"><?php _e("Ad size:",__WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_); ?><br />
					            <select name="<?php echo $this->get_field_name("ad_size"); ?>">
					            	<?php
										foreach ( $_WPADSMNGR_uwxl__InitData->imagesSizes as $slug => $data ) {
									?>
											<option value="<?php echo $slug; ?>" <?php 
						           			if ( $ad_size == $slug ) {
						           				echo "selected";
						           			}
						           			?> ><?php echo $data["title"]; ?></option>
						           	<?php
										}
									?>
					            </select></p>

					            <?php
					            	$checked = "w";
					            	if ( $fixed_max_dimension == "h" )
					            		$checked = "h";
					            ?>
					            <p><label for="<?php echo $this->get_field_id("ad_size"); ?>"><?php _e("Fixed dimension:",__WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_); ?><br />
					            <input type="radio" name="<?php echo $this->get_field_name("fixed_max_dimension"); ?>" value="w"
					            <?php 
									if ( $checked == "w" )
										echo \'checked="checked"\';
								?> > <?php _e("Width",__WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_); ?><br />
								<input type="radio" name="<?php echo $this->get_field_name("fixed_max_dimension"); ?>" value="h"
								<?php 
									if ( $checked == "h" )
										echo \'checked="checked"\';
								?> > <?php _e("Height",__WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_); ?>
					            </p>
					        <?php 
					    }

						function update($new_instance, $old_instance) {				
							$instance = $old_instance;
							$instance["title"] = strip_tags($new_instance["title"]);
							$instance["ad_size"] = strip_tags($new_instance["ad_size"]);
							$instance["fixed_max_dimension"] = strip_tags($new_instance["fixed_max_dimension"]);
						        return $instance;
						}

						function widget($args, $instance) {	
							global $_WPADSMNGR_uwxl__InitData, $_WPADSMNGR_uwxl__Widgets_Content;

					        $widget_content = $_WPADSMNGR_uwxl__Widgets_Content->getPositionWidgetContent("' . $widget_class_name . '" , $instance );

					        if ( $widget_content ) {
						        extract($args);
								echo $before_widget;
								echo $before_title;
								echo $instance["title"];
								echo $after_title;
								echo $widget_content;
								echo $after_widget;
							};
					    }
					}
					register_widget("' . $widget_class_name . '");
					');
			}
		}
	}
}

_WPADSMNGR_uwxl__Add_Widgets::init( $params ); 
