<?php

add_action( 'plugins_loaded', '_WPADSMNGR_uwxl__load_textdomain' );
function _WPADSMNGR_uwxl__load_textdomain() {
	load_plugin_textdomain( __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ , false , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_DIR_ . 'languages' );
}

define( '__WPADSMNGR_uwxl__THIS_PLUGIN__AD_IS_VALID_' , __( 'Ad is active' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__AD_IS_NOT_VALID_' , __( 'Ad is NOT active' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__AD_VALIDATION_ERROR_' , __( 'An error occurred while validating ad' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__AD_VALIDATION_TITLE_' , __( 'Ad activity' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );

define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADS_ON_POSITION_TITLE_' , __( 'Getting ads for the selected position' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADS_ON_POSITION_ERROR_' , __( 'An error occurred while getting ads' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );

define( '__WPADSMNGR_uwxl__THIS_PLUGIN__UPDATE_POSITION_TITLE_' , __( 'Ads position update' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__UPDATE_POSITION_OK_' , __( 'The update succeeded' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__UPDATE_POSITION_ERROR_' , __( 'The update was NOT successful' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );

define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADD_POSITION_TITLE_' , __( 'Adding ad position' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADD_POSITION_NAME_ERROR_' , __( 'Position name can not be blank and must have at least 6 characters' , __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_ ) );

class _WPADSMNGR_uwxl__Conf {

	

	public static $defaultScriptsAndStyles = array(
		'common' => array(
			'js' => array(
				
			),
			'css' => array(

			)
		),
		'admin' => array(
			'js' => array(
/*
				array( 
					'handle' => 'wpadsmngr_uwxl_admin-single-project',
					'src' => 'script-admin-single-project.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-single-project-update',
					'src' => 'script-admin-single-project-update.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					)
				),
*/
				array( 
					'handle' => 'wpadsmngr_uwxl_admin-datetime-picker',
					'src' => 'jquery.datetimepicker.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),
				array( 
					'handle' => 'wpadsmngr_uwxl_admin-jquery-multiselect',
					'src' => 'jquery.multiselect.min.js',
					'deps' => array(
						'jquery',
						'jquery-ui-widget',
						'jquery-effects-fade'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),
				array(
					'handle' => 'wpadsmngr_uwxl_admin-pnotify-custom',
					'src' => 'pnotify.custom.min.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'post-new.php',
						'post.php',
						'wpadsmngr_uwxl_options',
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ad-single',
					'src' => 'script-admin-ad-single.js',
					'deps' => array(
						//'jquery',
						'jquery-ui-sortable',
						'wpadsmngr_uwxl_admin-pnotify-custom'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					),
					'localize' => array(
						'uwxl_ads_on_position_title' => __WPADSMNGR_uwxl__THIS_PLUGIN__ADS_ON_POSITION_TITLE_,
						'uwxl_ads_on_position_error' => __WPADSMNGR_uwxl__THIS_PLUGIN__ADS_ON_POSITION_ERROR_
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ads-list',
					'src' => 'script-admin-ads-list.js',
					'deps' => array(
						'jquery',
						'wpadsmngr_uwxl_admin-pnotify-custom'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
					),
					'localize' => array(
						'uwxl_ad_is_valid' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_IS_VALID_,
						'uwxl_ad_is_not_valid' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_IS_NOT_VALID_,
						'uwxl_error_ad_validation_error' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_VALIDATION_ERROR_,
						'uwxl_error_ad_validation_title' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_VALIDATION_TITLE_
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ads-list',
					'src' => 'script-admin-ads-list.js',
					'deps' => array(
						'jquery',
						'wpadsmngr_uwxl_admin-pnotify-custom'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
					),
					'localize' => array(
						'uwxl_ad_is_valid' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_IS_VALID_,
						'uwxl_ad_is_not_valid' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_IS_NOT_VALID_,
						'uwxl_error_ad_validation_error' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_VALIDATION_ERROR_,
						'uwxl_error_ad_validation_title' => __WPADSMNGR_uwxl__THIS_PLUGIN__AD_VALIDATION_TITLE_
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ads-options',
					'src' => 'script-admin-ads-options.js',
					'deps' => array(
						'jquery',
						'jquery-ui-accordion',
						'jquery-ui-tabs'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'wpadsmngr_uwxl_options',
					),
					'localize' => array(
						'uwxl_update_position_title' => __WPADSMNGR_uwxl__THIS_PLUGIN__UPDATE_POSITION_TITLE_,
						'uwxl_update_position_ok' => __WPADSMNGR_uwxl__THIS_PLUGIN__UPDATE_POSITION_OK_,
						'uwxl_update_position_error' => __WPADSMNGR_uwxl__THIS_PLUGIN__UPDATE_POSITION_ERROR_,
						'uwxl_add_position_title' => __WPADSMNGR_uwxl__THIS_PLUGIN__ADD_POSITION_TITLE_,
						'uwxl_add_position_name_error' => __WPADSMNGR_uwxl__THIS_PLUGIN__ADD_POSITION_NAME_ERROR_
					)
				),
/*
				array( 
					'handle' => 'wpadsmngr_uwxl_admin-dashboard',
					'src' => 'script-admin-dashboard.js',
					'deps' => array(
						'jquery',
						'jquery-ui-dialog'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-bootstrap',
					'src' => 'bootstrap.min.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				)
*/
			),
			'css' => array(

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ad-single',
					'src' => 'style-admin-ad-single.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post-new.php',
						'post.php'
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-datetime-picker',
					'src' => 'jquery.datetimepicker.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-jquery-multiselect',
					'src' => 'jquery.multiselect.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'post.php',
						'post-new.php'
					)
				),

				array(
					'handle' => 'wpadsmngr_uwxl_admin-pnotify-custom',
					'src' => 'pnotify.custom.min.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'post.php',
						'post-new.php',
						'wpadsmngr_uwxl_options',
					)
				),

				array(
					'handle' => 'wpadsmngr_uwxl_admin-jquery-ui',
					'src' => 'jquery-ui.min.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'index.php',
						'post.php',
						'post-new.php',
						'wpadsmngr_uwxl_options',
					)
				),

				array(
					'handle' => 'wpadsmngr_uwxl_admin-jquery-ui-structure',
					'src' => 'jquery-ui.structure.min.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'index.php',
						'post.php',
						'post-new.php',
						'wpadsmngr_uwxl_options',
					)
				),

				array(
					'handle' => 'wpadsmngr_uwxl_admin-jquery-ui-theme',
					'src' => 'jquery-ui.theme.min.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
						'index.php',
						'post.php',
						'post-new.php',
						'wpadsmngr_uwxl_options',
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ads-list',
					'src' => 'style-admin-ads-list.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'edit.php',
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-ads-options',
					'src' => 'style-admin-ads-options.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'wpadsmngr_uwxl_options',
					)
				),
/*
				array( 
					'handle' => 'wpadsmngr_uwxl_admin-dashboard',
					'src' => 'style-admin-dashboard.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php'
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-bootstrap',
					'src' => 'bootstrap.min.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				),

				array( 
					'handle' => 'wpadsmngr_uwxl_admin-bootstrap-theme',
					'src' => 'bootstrap-theme.min.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'hook_deps' => array(
						'index.php',
					)
				)
*/
			)
		),
		'front' => array(
			'js' => array(
/*
				array( 
					'handle' => 'wpadsmngr_uwxl_front',
					'src' => 'script-front-stats.js',
					'deps' => array(
						'jquery'
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_,
					'localize' => array(
						'uwxl_ajaxurl' => __WPADSMNGR_uwxl__THIS_PLUGIN__ADMINAJAX_
					)
				)
*/
			),
			'css' => array(

				array( 
					'handle' => 'wpadsmngr_uwxl_front-style-css',
					'src' => 'style-front.css',
					'deps' => array(
					),
					'ver' => __WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_
				)

			)
		)
	);

	public static $added_PHP_Common_Files = array(
	);

	public static $added_PHP_Admin_Files = array(
	);

	public static $added_PHP_Front_Files = array(
	);

	public static $added_SCRIPT_Common_Files = array(
	);

	public static $added_STYLE_Common_Files = array(
	);

	public static $added_SCRIPT_Admin_Files = array(
	);

	public static $added_STYLE_Admin_Files = array(
	);

	public static $added_SCRIPT_Front_Files = array(
	);

	public static $added_STYLE_Front_Files = array(
	); 

}
