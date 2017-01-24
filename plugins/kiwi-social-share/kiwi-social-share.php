<?php
/**
 * Plugin Name: Kiwi Social Sharing WordPress Plugin
 * Plugin URI: https://www.machothemes.com/plugins/kiwi-social-sharing/
 * Description: Really beautiful & simple social sharing buttons. Simplicity & speed is key with this social sharing plugin.
 * Author: Macho Themes
 * Author URI: https://www.machothemes.com/
 * Version: 1.0.4
 * License: GPLv3
 * Text Domain: kiwi-social-share
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//======================================================================
// 		CONSTANTS
//======================================================================

define( 'KIWI__MINIMUM_WP_VERSION', '4.5.2' );
define( 'KIWI__STRUCTURE_VERSION', '1.0.0' );
define( 'KIWI__PLUGIN_VERSION', '1.0.4' );

define( 'KIWI__PLUGINS_URL', plugin_dir_url( __FILE__ ) );
define( 'KIWI__PLUGINS_PATH', plugin_dir_path( __FILE__ ) );

//======================================================================
// 		INCLUDES
//======================================================================

require KIWI__PLUGINS_PATH . 'inc/class.plugin-utilities.php';
require KIWI__PLUGINS_PATH . 'inc/front-end/class.render-share-bar.php';
require KIWI__PLUGINS_PATH . 'inc/back-end/class.settings-panel.php';

//======================================================================
// 		   JETPACK: Disable crap
//======================================================================

if ( ! has_filter( 'jetpack_enable_open_graph', '__return_false' ) ) {
	add_filter( 'jetpack_enable_open_graph', '__return_false' ); // this filter usually gets added by Yoast SEO
}