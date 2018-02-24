<?php

class Themeist_CustomLoginLogo_Admin {

	private $version;

	public function __construct( $version ) {
		$this->version = $version;
	}

	public function admin_menu() {
		$page_title = __('Custom Login Logo');
		$menu_title = __('Custom Login Logo');
		$capability = 'manage_options';
		$menu_slug = 'themeist_cll';
		$function =  array( $this, 'render_options_page');
		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
	}

	public function enqueue_styles() {

		if (isset($_GET['page']) && $_GET['page'] == 'themeist_cll') {
			wp_enqueue_style( 'thickbox' );
		}

	}

	public function enqueue_scripts() {

		if (isset($_GET['page']) && $_GET['page'] == 'themeist_cll') {

			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );

			wp_enqueue_script(
				'custom-login-logo-admin',
				plugin_dir_url( __FILE__ ) . 'js/custom-login-logo-admin.js',
				array( 'thickbox', 'media-upload' ),
				$this->version,
				FALSE
			);
		}

	}

	public function themeist_cll_settings() {

		register_setting(
			'themeist_cll_settings',
			'themeist_cll_settings',
			array( &$this, 'settings_validate' )
		);

		add_settings_section(
			'login_logo',
			__( 'Logo Settings', 'themeist_cll_settings' ),
			array( &$this, 'section_login_logo' ),
			'themeist_cll_settings'
		);

		add_settings_field(
			'login_logo_url',
			__( 'Upload Login Logo', 'themeist_cll_settings' ),
			array( &$this, 'section_login_logo_url' ),
			'themeist_cll_settings',
			'login_logo'
		);

		add_settings_field(
			'login_logo_height',
			__( 'Set Logo Height', 'themeist_cll_settings' ),
			array( &$this, 'section_login_logo_height' ),
			'themeist_cll_settings',
			'login_logo'
		);
	}

	public function section_login_logo() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/section_login_logo.php';
	}

	public function section_login_logo_url() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/section_login_logo_url.php';
	}

	public function section_login_logo_height() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/section_login_logo_height.php';
	}

	public function render_options_page() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/custom-login-logo-admin-display.php';
	}

}