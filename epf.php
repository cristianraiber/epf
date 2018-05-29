<?php
/**
 * Plugin Name: Plugin Options API Framework
 * Plugin URI: https://www.machothemes.com/
 * Description: WordPress Options API framework
 * Author: Raiber Cristian
 * Author URI: https://www.machothemes.com/
 * Version: 1.0.0
 * License: GPLv3
 * Text Domain: epfw
 * Domain Path: /languages/
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

//======================================================================
// 		CONSTANT DEFINITION
//======================================================================

define( 'EPFW__PLUGINS_URL', plugin_dir_url( __FILE__ ) );
define( 'EPFW__PLUGINS_PATH', plugin_dir_path( __FILE__ ) );
define( 'EPFW__PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'EPFW__FILE__', __FILE__ );

/**
 * Rollback constants
 *
 * If these aren't defined but the epfw_show_settings_link && epfw_show_rollback_link filters are set to TRUE, it will throw a WP_Error
 * We need to know the version we're going to rollback to. The current plugin version is also cached in EPFW__PLUGIN_VERSION
 *
 * The current plugin version is used for cache busting on static assets
 */
define( 'EPFW__PLUGIN_VERSION', '1.0.0' );
define( 'EPFW__PREVIOUS_PLUGIN_VERSION', '3.6.1' );

/**
 * Plugin Options Page Constants
 *
 * Also see
 *
 * <filters:>epfw_masthead</filters:>
 * <filters:>epfw_form_buttons</filters:>
 * <filters:>epfw_changelog</filters:>
 *
 * 1. EPFW__DOCUMENTATION_HREF - your plugin's docs URL. Needs to be a public URL
 * 2. EPFW__SUPPORT_HREF - link to your plugin's support page. Needs to be a public URL.
 * 3. EPFW__CHANGELOG_HREF - link to your plugin's changelog. Needs to be a publicly accessible URL.
 */
define( 'EPFW__DOCUMENTATION_HREF', 'https://www.machothemes.com/help/speed-booster-pack/' );
define( 'EPFW__SUPPORT_HREF', 'https://www.machothemes.com/contact-us-now/' );
define( 'EPFW__CHANGELOG_HREF', 'https://github.com/MachoThemes/simple-author-box/blob/master/readme.txt' );

//======================================================================
// 		INCLUDES
//======================================================================

// back-end includes
require EPFW__PLUGINS_PATH . 'inc/back-end/sigma/rollback/class-epfw-rollback.php';
require EPFW__PLUGINS_PATH . 'inc/back-end/admin/class-epfw-field-render.php';
require EPFW__PLUGINS_PATH . 'inc/back-end/admin/class-epfw-settings-page.php';

// init
require EPFW__PLUGINS_PATH . 'bootstrap.php';
