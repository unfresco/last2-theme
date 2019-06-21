<?php


class Last_i18n {
	
	private $theme_name;
	
	function __construct( $theme_name ) {
		$this->theme_name = $theme_name;
	}
	
	/**
	 * Load the theme text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_theme_textdomain() {

		load_theme_textdomain(
			$this->theme_name,
			false,
			get_template_directory() . '/languages/'
		);

	}



}
