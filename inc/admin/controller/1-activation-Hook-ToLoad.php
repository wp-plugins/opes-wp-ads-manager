<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Activation_Hook {

	private function __construct( $params ) {
		register_activation_hook( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_, array( $this , 'installPlugin' ) );
		//register_deactivation_hook( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_, array( $this , 'uninstallPlugin' ) );
	}
	
	public static function init( $params ) {
		return new _WPADSMNGR_uwxl__Activation_Hook( $params );
	}

	public function installPlugin() {
		global $_WPADSMNGR_uwxl__InitData;

		do_action( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_install_plugin_action' );

	}

	public function uninstallPlugin() {
		do_action( $_WPADSMNGR_uwxl__InitData->plugin_short_slug . '_uninstall_plugin_action' );
	}
}

_WPADSMNGR_uwxl__Activation_Hook::init( array() ); 
