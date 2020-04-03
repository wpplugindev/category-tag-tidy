<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.wpplugindev.net
 * @since      1.0.0
 *
 * @package    Category_Tag_Tidy
 * @subpackage Category_Tag_Tidy/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Category_Tag_Tidy
 * @subpackage Category_Tag_Tidy/includes
 * @author     WPplugindev.Net <info@wpplugindev.net>
 */
class Category_Tag_Tidy_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'category-tag-tidy',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
