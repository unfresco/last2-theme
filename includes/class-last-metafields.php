<?php

class Last_Metafields  {
	
	private $loaded;
	
	public function __construct() {
		$this->loaded = false;
		
		if ( $this->check_framework() ) {
			$this->load_framework();
		}

	}
	
	private function check_framework() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		
		$carbon_fields_plugin_file = 'carbon-fields/carbon-fields-plugin.php';
		$all_plugins = get_plugins();

		if ( class_exists( 'Carbon_Fields\\Container' ) ) {
			// Carbon fields exist as plugin
			if ( array_key_exists( $carbon_fields_plugin_file, $all_plugins ) ) {
				
				$current_active_plugins = get_option('active_plugins');

				// Check if is active as plugin or as framework
				if ( in_array( $carbon_fields_plugin_file, $current_active_plugins ) ) {
					// Is active as plugin
					$framework_version = $all_plugins[$carbon_fields_plugin_file]['Version'];
				} else {
					// Is active as framework
					$framework_version = Carbon_Fields\VERSION ;
				}
				
			} else {
				// Carbon fields already exist as framework. Asume version is >= 2
				$framework_version = Carbon_Fields\VERSION ;
			}
			
			if ( version_compare( $framework_version, '2'  ) >= 0 ) {
				// Included Carbon field plugin is higher than 2
				$this->loaded = true;
				return true;
			} else {
				// Carbon_Fields version is lower than 2
				return false;
			} 
			
		} else {
			// Use included framework
			return true;
		}
	}
	
	private function load_framework() {

		$dir_name = dirname( __FILE__ ) . '/';
		$autoload_path = dirname( $dir_name, 1 )  . '/vendor/autoload.php';
		require_once get_template_directory() . '/vendor/autoload.php';
		$this->loaded = true;
		
	}
	
	public function is_loaded() {
		return $this->loaded;
	}
	
	public function boot() {
		if ( $this->is_loaded() ) {
			\Carbon_Fields\Carbon_Fields::boot();
		}
	}

}
