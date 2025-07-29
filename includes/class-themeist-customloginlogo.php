<?php
/**
 * Custom Login Logo - Main plugin class.
 *
 * @package Themeist_CustomLoginLogo
 */

/**
 * Handles admin settings and login logo customization.
 *
 * @package Themeist_CustomLoginLogo
 */
class Themeist_CustomLoginLogo {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->version = defined( 'THEMEIST_CLL_VERSION' ) ? THEMEIST_CLL_VERSION : '1.0.0';

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

		add_action( 'login_head', array( $this, 'display_login_logo' ) );
		add_filter( 'login_headertext', array( $this, 'login_logo_title' ) );
		add_filter( 'login_headerurl', array( $this, 'login_logo_url' ) );
	}

	/**
	 * Add settings page to the admin menu.
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_options_page(
			__( 'Custom Login Logo', 'custom-login-logo' ),
			__( 'Custom Login Logo', 'custom-login-logo' ),
			'manage_options',
			'themeist_cll',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register plugin settings.
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting(
			'themeist_cll_settings',
			'themeist_cll_settings',
			array( $this, 'validate_settings' )
		);

		add_settings_section(
			'login_logo',
			__( 'Logo Settings', 'custom-login-logo' ),
			'__return_false',
			'themeist_cll_settings'
		);

		add_settings_field(
			'login_logo_url',
			__( 'Upload Login Logo', 'custom-login-logo' ),
			array( $this, 'field_logo_url' ),
			'themeist_cll_settings',
			'login_logo'
		);

		add_settings_field(
			'login_logo_height',
			__( 'Set Logo Height', 'custom-login-logo' ),
			array( $this, 'field_logo_height' ),
			'themeist_cll_settings',
			'login_logo'
		);
	}

	/**
	 * Validate settings input.
	 *
	 * @param array $input Input from form.
	 * @return array
	 */
	public function validate_settings( $input ) {
		$output = array();

		if ( isset( $input['login_logo_url'] ) ) {
			$output['login_logo_url'] = esc_url_raw( $input['login_logo_url'] );
		}

		if ( isset( $input['login_logo_height'] ) ) {
			$output['login_logo_height'] = absint( $input['login_logo_height'] );
		}

		return $output;
	}

	/**
	 * Enqueue media uploader JS for settings page.
	 *
	 * @return void
	 */
	public function enqueue_admin_assets() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['page'] ) && 'themeist_cll' === sanitize_key( $_GET['page'] ) ) {
			wp_enqueue_media();

			wp_enqueue_script(
				'custom-login-logo-admin',
				plugin_dir_url( __DIR__ ) . 'assets/js/media-uploader.js',
				array( 'jquery' ),
				$this->version,
				true
			);
		}
	}

	/**
	 * Render login logo URL field.
	 *
	 * @return void
	 */
	public function field_logo_url() {
		$options = get_option( 'themeist_cll_settings' );
		$url     = isset( $options['login_logo_url'] ) ? esc_url( $options['login_logo_url'] ) : '';
		?>
		<span class="upload">
			<input type="text" class="regular-text text-upload" name="themeist_cll_settings[login_logo_url]" value="<?php echo esc_attr( $url ); ?>" />
			<input type="button" class="button button-upload" value="<?php esc_attr_e( 'Upload an image', 'custom-login-logo' ); ?>" />
			<?php if ( $url ) : ?>
				<img style="max-width: 300px; display: block; margin-top: 10px;" src="<?php echo esc_url( $url ); ?>" class="preview-upload" />
			<?php endif; ?>
		</span>
		<p class="description"><?php esc_html_e( 'Maximum width should be 320 pixels or part of the logo may be hidden.', 'custom-login-logo' ); ?></p>
		<?php
	}

	/**
	 * Render login logo height field.
	 *
	 * @return void
	 */
	public function field_logo_height() {
		$options = get_option( 'themeist_cll_settings' );
		$height  = isset( $options['login_logo_height'] ) ? absint( $options['login_logo_height'] ) : '';
		printf(
			'<input type="number" name="themeist_cll_settings[login_logo_height]" value="%s" /> px',
			esc_attr( (string) $height )
		);
	}

	/**
	 * Render plugin settings page.
	 *
	 * @return void
	 */
	public function render_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Custom Login Logo', 'custom-login-logo' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'themeist_cll_settings' );
				do_settings_sections( 'themeist_cll_settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Display login logo styling on login page.
	 *
	 * @return void
	 */
	public function display_login_logo() {
		$options = get_option( 'themeist_cll_settings' );

		if ( ! empty( $options['login_logo_url'] ) ) {
			$height = ! empty( $options['login_logo_height'] ) ? absint( $options['login_logo_height'] ) : 100;
			$url    = esc_url( $options['login_logo_url'] );
			?>
			<style>
				.login h1 a {
					background-image: url('<?php echo esc_url( $url ); ?>');
					height: <?php echo esc_attr( (string) $height ); ?>px;
					width: auto;
					background-size: contain;
				}
			</style>
			<?php
		}
	}
	/**
	 * Change login logo title.
	 *
	 * @return string
	 */
	public function login_logo_title() {
		return get_bloginfo( 'name' );
	}

	/**
	 * Change login logo link.
	 *
	 * @return string
	 */
	public function login_logo_url() {
		return home_url();
	}
}
