<?php

class Themeist_CLL {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      Themeist_CLL_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      string    $themeist_cll    The string used to uniquely identify this plugin.
	 */
	protected $themeist_cll;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'THEMIST_CLL_VERSION' ) ) {
			$this->version = THEMIST_CLL_VERSION;
		} else {
			$this->version = '1.0.2';
		}
		$this->plugin_name = 'themeist-cll';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Themeist_CLL_Loader. Orchestrates the hooks of the plugin.
	 * - Themeist_CLL_i18n. Defines internationalization functionality.
	 * - Themeist_CLL_Admin. Defines all hooks for the admin area.
	 * - Themeist_CLL_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-themeist-cll-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-themeist-cll-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-themeist-cll-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-themeist-cll-public.php';

		$this->loader = new Themeist_CLL_Loader();
	}

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	
	function __construct() {

		// Load text domain
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

		// Adding Plugin Menu
		add_action( 'admin_menu', array( &$this, 'dot_cll_menu' ) );

		 // Load our custom assets.
    	add_action( 'admin_enqueue_scripts', array( &$this, 'dot_cll_assets' ) );

		// Register Settings
		add_action( 'admin_init', array( &$this, 'dot_cll_settings' ) );


		// Change Login header URL
		add_filter( 'login_headerurl', array( &$this, 'dot_cll_login_headerurl' ) );

		// Change Login header Title
		add_filter( 'login_headertitle', array( &$this, 'dot_cll_login_headertitle' ) );

		// Change the default Login page Logo
		add_action( 'login_head', array( &$this, 'dot_cll_login_logo' ) );


	} // end constructor


	/*--------------------------------------------*
	 * Localisation | Public | 1.0 | Return : void
	 *--------------------------------------------*/

	public function load_localisation ()
	{
		load_plugin_textdomain( 'dot_cll', false, basename( dirname( __FILE__ ) ) . '/languages' );

	} // End load_localisation()

	/**
	 * Defines constants for the plugin.
	 */
	function constants() {
		define( 'DOT_CLL_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	/*--------------------------------------------*
	 * Admin Menu
	 *--------------------------------------------*/

	function dot_cll_menu()
	{
		$page_title = __('Custom Login Logo', 'dot_cll');
		$menu_title = __('Custom Login Logo', 'dot_cll');
		$capability = 'manage_options';
		$menu_slug = 'dot_cll';
		$function =  array( &$this, 'dot_cll_menu_contents');
		add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);

	}	//dot_cll_menu

	/*--------------------------------------------*
	 * Load Necessary JavaScript Files
	 *--------------------------------------------*/

	function dot_cll_assets() {
	    if (isset($_GET['page']) && $_GET['page'] == 'dot_cll') {

			wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
				wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );

	        wp_register_script('dot_cll_admin', plugins_url( '/admin/js/dot_cll_admin.js' , __FILE__ ), array( 'thickbox', 'media-upload' ));
	        wp_enqueue_script('dot_cll_admin');
	    }
	} //dot_cll_assets

	/*--------------------------------------------*
	 * Settings & Settings Page
	 *--------------------------------------------*/

	public function dot_cll_settings() {

		// Settings
		register_setting( 'dot_cll_settings', 'dot_cll_settings', array(&$this, 'settings_validate') );

		// Logo Settings
		add_settings_section( 'login_logo', __( 'Login Logo Settings', 'dot_cll' ), array( &$this, 'section_login_logo' ), 'dot_cll_settings' );

		add_settings_field( 'login_logo_url', __( 'Upload Login Logo', 'dot_cll' ), array( &$this, 'section_login_logo_url' ), 'dot_cll_settings', 'login_logo' );

		add_settings_field( 'login_logo_height', __( 'Set Logo Height', 'dot_cll' ), array( &$this, 'section_login_logo_height' ), 'dot_cll_settings', 'login_logo' );


	}	//dot_cll_settings


	/*--------------------------------------------*
	 * Settings & Settings Page
	 * dot_cll_menu_contents
	 *--------------------------------------------*/

	public function dot_cll_menu_contents() {
	?>
		<div class="wrap">
			<!--<div id="icon-freshdesk-32" class="icon32"><br></div>-->
			<div id="icon-options-general" class="icon32"><br></div>
			<h2><?php _e('Custom Login Logo Settings', 'dot_cll'); ?></h2>

			<form method="post" action="options.php">
				<?php //wp_nonce_field('update-options'); ?>
				<?php settings_fields('dot_cll_settings'); ?>
				<?php do_settings_sections('dot_cll_settings'); ?>
				<p class="submit">
					<input name="Submit" type="submit" class="button-primary" value="<?php _e('Save Changes', 'dot_cll'); ?>" />
				</p>
			</form>
		</div>

	<?php
	}	//dot_cll_menu_contents


	function section_login_logo() 	{


	}

	function section_login_logo_url() 	{
	    $options = get_option( 'dot_cll_settings' );
	    ?>
	    <span class='upload'>
	        <input type='text' id='dot_cll_settings[login_logo_url]' class='regular-text text-upload' name='dot_cll_settings[login_logo_url]' value='<?php echo esc_url( $options["login_logo_url"] ); ?>'/>
	        <input type='button' class='button button-upload' value='Upload an image'/></br>
	        <img style='max-width: 300px; display: block;' src='<?php echo esc_url( $options["login_logo_url"] ); ?>' class='preview-upload' />
	    </span>
	    <?php
	}

	function section_login_logo_height() 	{
	    $options = get_option( 'dot_cll_settings' );

	    ?>
	        <input type='text' id='dot_cll_settings[login_logo_height]' class='text' name='dot_cll_settings[login_logo_height]' value='<?php echo sanitize_text_field($options["login_logo_height"]); ?>'/> px
	    <?php
	}


	/*--------------------------------------------*
	 * Settings Validation
	 *--------------------------------------------*/

	function settings_validate($input) {

		return $input;
	}


	/*--------------------------------------------*
	 * Plugin Functions
	 *--------------------------------------------*/

	function dot_cll_login_logo() {

		$options = get_option( 'dot_cll_settings' );
		//if( !isset($options['login_logo_url']) ) $options['login_logo_url'] = '0';
		//if( !isset($options['login_logo_url_height']) ) $options['login_logo_url_height'] = 'auto';

		if( $options['login_logo_url'] != "" ) {
			echo '<style type="text/css">
        	h1 a { background-image:url('.esc_url( $options["login_logo_url"] ).') !important; 	height:'.sanitize_text_field( $options["login_logo_height"] ).'px !important; background-size: auto auto !important; width: auto !important;}
        		</style>';
    	}


	}


	function dot_cll_login_headertitle( $title ) {
		return get_bloginfo( 'name' );
	}

	function dot_cll_login_headerurl( $url ) {
		return home_url();
	}



	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Themeist_CLL_Public( $this->get_themeist_cll(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.1.0
	 */
	public function run() {
		$this->loader->run();
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_themeist_cll() {
		return $this->themeist_cll;
	}
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.1.0
	 * @return    Themeist_CLL_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}