<?php
/**
 * @package __WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_
 */
/*
Plugin Name: Opes WP Ads Manager
Plugin URI: https://wordpress.org/plugins/opes-wp-ads-manager/
Description: Opes WP Ads Manager allows you to show advertisements on the website
Version: 1.2.0
Author: Paweł Twardziak
Author URI: http://it-opes.com/
License: GPLv2 or later
Text Domain: __WPADSMNGR_uwxl__
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( '__WPADSMNGR_uwxl__DS_' , DIRECTORY_SEPARATOR );
define( '__WPADSMNGR_uwxl__PS_' , '/' );


define( '__WPADSMNGR_uwxl__THIS_PLUGIN__VERSION_' , '1.2.0' );


define( '__WPADSMNGR_uwxl__THIS_PLUGIN__MAIN_FILE_' , __FILE__ );


define( '__WPADSMNGR_uwxl__THIS_PLUGIN__TEXT_DOMAIN_' , '__WPADSMNGR_uwxl__' );


define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADMINAJAX_' , admin_url( 'admin-ajax.php' ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__DB_VERSION_' , '1.0.0' );


define( '__WPADSMNGR_uwxl__THIS_PLUGIN__DIR_' , plugin_dir_path( __FILE__ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__INC_DIR_' , __WPADSMNGR_uwxl__THIS_PLUGIN__DIR_ . 'inc' . __WPADSMNGR_uwxl__DS_ );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__COMMON_DIR_' , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_DIR_ . 'common' . __WPADSMNGR_uwxl__DS_ );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_DIR_' , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_DIR_ . 'admin' . __WPADSMNGR_uwxl__DS_ );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__FRONT_DIR_' , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_DIR_ . 'front' . __WPADSMNGR_uwxl__DS_ );


define( '__WPADSMNGR_uwxl__THIS_PLUGIN__URL_' , plugin_dir_url( __FILE__ ) );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__INC_URL_' , __WPADSMNGR_uwxl__THIS_PLUGIN__URL_ . 'inc' . __WPADSMNGR_uwxl__PS_ );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__COMMON_URL_' , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_URL_ . 'common' . __WPADSMNGR_uwxl__PS_ );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__ADMIN_URL_' , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_URL_ . 'admin' . __WPADSMNGR_uwxl__PS_ );
define( '__WPADSMNGR_uwxl__THIS_PLUGIN__FRONT_URL_' , __WPADSMNGR_uwxl__THIS_PLUGIN__INC_URL_ . 'front' . __WPADSMNGR_uwxl__PS_ );


require_once __WPADSMNGR_uwxl__THIS_PLUGIN__DIR_ . "conf.php";
require_once __WPADSMNGR_uwxl__THIS_PLUGIN__INC_DIR_ . "main.class.php";


_WPADSMNGR_uwxl__Main::init( array() );


