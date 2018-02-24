<div class="wrap">

	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Custom Login Logo'); ?></h2>

	<form method="post" action="options.php">
		<?php //wp_nonce_field('update-options'); ?>
		<?php settings_fields('themeist_cll_settings'); ?>
		<?php do_settings_sections('themeist_cll_settings'); ?>
		<?php submit_button(); ?>
		<!--<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
		</p>-->
	</form>

</div>