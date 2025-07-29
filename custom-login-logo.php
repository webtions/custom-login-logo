<?php
/**
 * Plugin Name:       Custom Login Logo
 * Plugin URI:        https://themeist.com/plugins/wordpress/custom-login-logo/#utm_source=wp-plugin&utm_medium=custom-login-logo&utm_campaign=plugins-page
 * Description:       Easily add a custom logo to your WordPress login page using the built-in media uploader.
 * Version:           1.2.0
 * Requires at least: 6.0
 * Tested up to:      6.8
 * Requires PHP:      7.4
 * Author:            Themeist
 * Author URI:        https://themeist.com/
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       custom-login-logo
 *
 * @package Themeist_CustomLoginLogo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'THEMEIST_CLL_VERSION', '1.2.0' );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-themeist-customloginlogo.php';

new Themeist_CustomLoginLogo();
