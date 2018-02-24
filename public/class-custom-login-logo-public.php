<?php

class Themeist_CustomLoginLogo_Public {

	private $version;

	public function __construct( $version ) {
		$this->version = $version;
	}


	public function login_logo_title( $title ) {
		return get_bloginfo( 'name' );
	}

	public function login_logo_url( $url ) {
		return home_url();
	}

}