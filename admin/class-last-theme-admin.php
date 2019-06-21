<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Last_Theme_Admin {

	function __construct( $theme_name, $theme_version ) {
		$this->theme_name = $theme_name;
		$this->theme_version = $theme_version;
	}

	public function enqueue_styles() {
		
	}

	public function enqueue_scripts() {
		
	}
	
	public function theme_supports() {
		add_theme_support( 'title-tag' );
	}
	
	public function register_carbon_fields_options() {
		
		Container::make( 'theme_options', __( 'Last', 'last-theme' ) )
			->set_page_parent('options-general.php')
			->add_tab( __('Connect to service/functionality providers', 'last-theme'), array(
				Field::make( 'header_scripts', '_header_scripts', __( 'In site header', 'last-theme' ) )
					->help_text( __( 'F.e. Google Analitics or for including font libraries', 'last-theme' ) ),
				
				Field::make( 'footer_scripts', '_footer_scripts', __( 'In site footer', 'last-theme' ) )
					->help_text( __( 'F.e. External script libraries to enhance functionality', 'last-theme' ) ),
				
				Field::make( 'checkbox', 'has_facebook_integration', __( 'Activate facebook integration', 'last-theme' ) )
					->set_option_value('1')
					->set_width(30),
				
				Field::make( 'textarea', 'facebook_root_script', __( 'Facebook root script', 'last-theme' ) )
					->set_width(40)
					->help_text( __( 'Get facebook script <a href="https://developers.facebook.com/docs/javascript/quickstart" target="_blank">here</a>', 'last-theme' ) )
					->set_conditional_logic(array(
						array(
							'field' => 'has_facebook_integration',
							'value' => '1',
							'compare' => '='
						)
					)),
				
				Field::make( 'set', 'facebook_root_script_location', __( 'Include script ', 'last-theme' ) )
					->set_options(array(
						'everywhere' => __ ( 'Everywhere', 'last-theme' ),
						'page' => __ ( 'Pages', 'last-theme' ),
						'single' => __ ( 'Single', 'last-theme' ),
						'archive' => __ ( 'Archive pages', 'last-theme' )
					))
					->set_width(30)
					->set_conditional_logic(array(
						array(
							'field' => 'has_facebook_integration',
							'value' => '1',
							'compare' => '='
						)
					))
			));
			
	}
	
}
