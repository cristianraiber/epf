<?php
/**
 * Plugin Name: Plugin Options API Framework
 * Plugin URI: https://www.machothemes.com/
 * Description: WordPress Options API framework
 * Author: Cristian Raiber
 * Author URI: https://www.machothemes.com/
 * Version: 1.0
 * License: GPLv3
 * Text Domain: epfw
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//======================================================================
// 		CONSTANT DEFINITION
//======================================================================

define( 'EPFW__PLUGINS_URL', plugin_dir_url( __FILE__ ) );
define( 'EPFW__PLUGINS_PATH', plugin_dir_path( __FILE__ ) );
define( 'EPFW__PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'EPFW__FILE__', __FILE__ );
define( 'EPFW__SETTINGS_TABLE', 'sbp_settings' );
define( 'EPFW__SETTINGS_TABLE_GROUP', 'sbp_settings_group' );


//rollback constants
define( 'EPFW__PLUGIN_VERSION', '1.0.0' );
define( 'EPFW__PREVIOUS_PLUGIN_VERSION', '3.6.1' );


//======================================================================
// 		INCLUDES
//======================================================================

// back-end includes
require EPFW__PLUGINS_PATH . 'inc/back-end/sigma/rollback/rollback.php';
require EPFW__PLUGINS_PATH . 'inc/back-end/admin/class.plugin-utilities.php';
require EPFW__PLUGINS_PATH . 'inc/back-end/admin/class.plugin-field-render.php';
require EPFW__PLUGINS_PATH . 'inc/back-end/admin/class.plugin-options-panel.php';
require EPFW__PLUGINS_PATH . 'inc/back-end/admin/class.plugin-options-init.php';



// front-end includes