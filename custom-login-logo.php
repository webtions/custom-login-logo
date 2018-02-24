<?php
/*
Plugin Name: Custom Login Logo
Plugin URI: https://themeist.com/#utm_source=wp-plugin&utm_medium=mailchimp-for-wp&utm_campaign=plugins-page
Description: Customize WordPress login page by adding a custom logo to the WordPress login page.
Version: 1.1.0
Author: themeist
Author URI: https://themeist.com/
Text Domain: custom-login-logo
Domain Path: /languages
License: GPL v3

Custom Login Logo
Copyright (C) 2013-2018, Harish Chouhan, hello@dreamsmedia.in

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Design plugin version
define( 'THEMIST_CLL_VERSION', '1.1.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-themeist-cll.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.1.0
 */
function run_themeist_cll() {

	$plugin = new Themeist_CLL();
	$plugin->run();

}
run_themeist_cll();