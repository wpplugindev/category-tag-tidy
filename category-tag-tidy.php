<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              http://www.wpplugindev.net
 * @since             1.0.0
 * @package           Category_Tag_Tidy
 *
 * @wordpress-plugin
 * Plugin Name:       Category Tag Tidy
 * Plugin URI:        https://github.com/wpplugindev/category-tag-tidy
 * Description:       Allows easy deletion of unused categories and tags - maintains existing category structure. 
 * Version:           1.0.0
 * Author:            WPplugindev.Net
 * Author URI:        http://www.wpplugindev.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       category-tag-tidy
 * Domain Path:       /languages
 * Network:           true
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'CATEGORY_TAG_TIDY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-category-tag-tidy-activator.php
 */
function activate_category_tag_tidy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-tag-tidy-activator.php';
	Category_Tag_Tidy_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-category-tag-tidy-deactivator.php
 */
function deactivate_category_tag_tidy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-tag-tidy-deactivator.php';
	Category_Tag_Tidy_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_category_tag_tidy' );
register_deactivation_hook( __FILE__, 'deactivate_category_tag_tidy' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-category-tag-tidy.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_category_tag_tidy() {

	$plugin = new Category_Tag_Tidy();
	$plugin->run();

}
run_category_tag_tidy();
