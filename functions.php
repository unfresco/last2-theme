<?php


require get_template_directory() . '/includes/class-last-theme.php';


function run_last_theme() {
	
	$theme = new Last_Theme();
	$theme->run();
	
	if ( class_exists( 'Last_Child' ) ) {
		$theme_child = new Last_Child();
		$theme_child->dep_add( 'loader', $theme->new_loader() );
		$theme_child->run();
		$theme_child->dep_run();
	}

}

run_last_theme();
