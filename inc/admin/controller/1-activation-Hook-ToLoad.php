<?php

# Here you can include the 'model' and 'view' files - not other controllers! All controllers are loaded automatically.

class _WPADSMNGR_uwxl__Activation_Hook {

	private function __construct( $params ) {
		register_activation_hook( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_, array( $this , 'installPlugin' ) );
		register_deactivation_hook( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_, array( $this , 'uninstallPlugin' ) );
/*
		global $pagenow;

		if ( 'plugins.php' == $pagenow ) {
			// Better update message
			$file   = basename( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_ );
			$folder = basename( dirname( __WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_ ) );
			$hook = "in_plugin_update_message-$folder/$file";
			add_action( $hook, array( $this , 'updateMessage' ) , 20, 2 );
		}
*/
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
/*
	public function updateMessage( $plugin_data, $r )
	{
	    // readme contents
	    $data       = file_get_contents( 'http://plugins.trac.wordpress.org/browser/opes-wp-ads-manager/trunk/readme.txt?format=txt' );

	    // assuming you've got a Changelog section
	    // @example == Changelog ==
	    $changelog  = stristr( $data, '== Changelog ==' );

	    // assuming you've got a Screenshots section
	    // @example == Screenshots ==
	    $changelog  = stristr( $changelog, '== Screenshots ==', true );

	    // only return for the current & later versions
	    $curr_ver   = get_plugin_data('Version');

	    // assuming you use "= v" to prepend your version numbers
	    // @example = v0.2.1 =
	    $changelog  = stristr( $changelog, "= $curr_ver =" );

	    // uncomment the next line to var_export $var contents for dev:
	    # echo '<pre>'.var_export( $plugin_data, false ).'<br />'.var_export( $r, false ).'</pre>';

	    // echo stuff....
	    $output = $changelog;
	    echo $output;
	}
*/
}

_WPADSMNGR_uwxl__Activation_Hook::init( array() ); 
