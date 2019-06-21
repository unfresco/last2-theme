<?php

class Last_Theme_Public {

	function __construct( $theme_name, $theme_version ) {
		$this->theme_name = $theme_name;
		$this->theme_version = $theme_version;
		$this->theme_uri = get_template_directory_uri();
	}
	
	public function facebook_integration(){
			
		if( ! function_exists( 'carbon_get_theme_option' ) ){
			return;
		}
		
		$has_facebook_integration = carbon_get_theme_option( 'has_facebook_integration' );
		$facebook_root_script_location = carbon_get_theme_option( 'facebook_root_script_location' );
		$facebook_root_script = carbon_get_theme_option( 'facebook_root_script' );

		$print_facebook_script = false;
		
		if ( ! $has_facebook_integration ) {
			return;
		}
		
		if ( in_array( 'everywhere', $facebook_root_script_location ) ){
			
			$print_facebook_script = true;
		
		} else if ( in_array( 'page', $facebook_root_script_location ) && is_page() ) {
			
			$print_facebook_script = true;
			
		} else if ( in_array( 'single', $facebook_root_script_location ) && is_single() ) {
			
			$print_facebook_script = true;
			
		} else if ( in_array( 'archive', $facebook_root_script_location ) && is_archive() ) {
			
			$print_facebook_script = true;
			
		}
		
		if ( $print_facebook_script ){
			
			echo $facebook_root_script;
		
		}

		
	}

}
