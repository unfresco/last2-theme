<?php

/**
 * 
 */
class Last_Theme_Version_Control extends Last_Theme {
	protected $theme;
	protected $version;
	
	function __construct() {
		$this->theme = wp_get_theme();
	}
	
	/**
	 * Retrieve the version number of this plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		
		if ( empty( $this->version ) ) {
			$this->version = $this->theme['Version'];
		}
		
		return $this->version;
		
	}
	
	/**
	 * Setup version check/hooks
	 * @return void 
	 */
	public function check_version() {
		$options = get_option( 'last_status' );

		$arg = array(
			'old_version' => $options['theme_version'],
			'new_version' => $this->get_version()
		);
		
		
		if ( version_compare( $this->get_version(), $options['theme_version']  ) != 0 ) {

			do_action( 'last_theme/update_status_version', $arg );

		}
		
		if ( version_compare( $this->get_version(), $options['theme_version']  ) < 0 ) {
			
			do_action( 'last_theme/downgrade_status_version', $arg );

		}
		
	}
	 
}
