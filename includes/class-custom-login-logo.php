<?php

class Themeist_CustomLoginLogo {

	protected $loader;

	protected $plugin_slug;

	protected $version;

	public function __construct() {

		$this->plugin_slug = 'custom-login-logo';
		$this->version = '1.1.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-custom-login-logo-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-custom-login-logo-public.php';

		require_once plugin_dir_path( __FILE__ ) . 'class-custom-login-logo-loader.php';
		$this->loader = new Themeist_CustomLoginLogo_Loader();

	}

	private function define_admin_hooks() {

		$admin = new Themeist_CustomLoginLogo_Admin( $this->get_version() );
		$this->loader->add_action( 'admin_menu', $admin, 'admin_menu' );
		$this->loader->add_action( 'admin_init', $admin, 'themeist_cll_settings' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'add_meta_boxes', $admin, 'add_meta_box' );

	}

	private function define_public_hooks() {

		$public = new Themeist_CustomLoginLogo_Public( $this->get_version() );
		$this->loader->add_filter( 'login_headertitle', $public, 'login_logo_title' );
		$this->loader->add_filter( 'login_headerurl', $public, 'login_logo_url' );


	}

	public function run() {
		$this->loader->run();
	}

	public function get_version() {
		return $this->version;
	}

}