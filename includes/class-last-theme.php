<?php

/**
 * 
 */
class Last_Theme {
	
	protected $loader;

	protected $theme_name;
	
	protected $theme_version;
	
	function __construct() {
		
		$this->theme_name = 'last-theme';
		$this->theme_dir = get_template_directory();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
	}
	
	private function load_dependencies() {
		
		/**
		 * Loader for theme actions & filters
		 * @var [type]
		 */
		require_once get_template_directory() . '/includes/class-last-loader.php';
		$this->loader = $this->new_loader();
		
		/**
		 * Localisation
		 * @var [type]
		 */
		require_once get_template_directory() . '/includes/class-last-i18n.php';
		
		/**
		 * Version control
		 * @var [type]
		 */
		require_once get_template_directory() . '/includes/class-last-theme-version.php';
		
		/**
		 * Load Carbon fields with composer autoload
		 */
		require_once get_template_directory() . '/includes/class-last-metafields.php';
		$this->meta_fields = new Last_Metafields();
		
		
		require_once get_template_directory() . '/admin/class-last-theme-admin.php';
		
		require_once get_template_directory() . '/public/class-last-theme-public.php';
		
	}
	
	private function set_locale() {

		$theme_i18n = new Last_i18n( $this->theme_name );

		$this->loader()->add_action( 'after_setup_theme', $theme_i18n, 'load_theme_textdomain' );

	}
	
	/**
	 * All actions for the admin facing logic
	 * @return [type] [description]
	 */
	private function define_admin_hooks() {
		
		$theme_admin = new Last_Theme_Admin( $this->theme_name, $this->get_version() );
		
		$this->loader()->add_action( 'after_setup_theme', $theme_admin, 'theme_supports' );
		$this->loader()->add_action( 'after_setup_theme', $this->meta_fields, 'load_framework' );
		$this->loader()->add_action( 'carbon_fields_register_fields', $theme_admin, 'register_carbon_fields_options' );
		
	}

	/**
	 * All actions for the public facing loginc
	 * @return [type] [description]
	 */
	private function define_public_hooks() {
		
		$theme_public = new Last_Theme_Public( $this->theme_name, $this->get_version() );
		
		if ( $this->meta_fields->is_loaded() ) {
			$this->loader()->add_action( 'after_body_tag', $theme_public, 'facebook_integration' );
		}
		
	}
	
	public function loader() {
		
		return $this->loader;
	
	}
	
	public function new_loader() {
		return new Last_Loader();
	}
	
	public function get_version() {
		
		if ( empty( $this->theme_version ) ) {
			$vc = new Last_Theme_Version_Control();
			$this->theme_version = $vc->get_version();
		}
		
		return $this->theme_version;
		
	}

	public function run() {
		
		$this->loader()->run();
		
	}
	
}
