<?php

/**
 * Enqueue scripts and stylesheets
 */
function maera_scripts() {
	global $wp_customize;
	global $active_framework;

	// Get the stylesheet path and version
	$stylesheet_url = apply_filters( 'maera/stylesheet/url', MAERA_ASSETS_URL . '/css/style.css' );
	$stylesheet_ver = apply_filters( 'maera/stylesheet/ver', null );

	// Enqueue the theme's stylesheet
	wp_enqueue_style( 'maera', $stylesheet_url, false, $stylesheet_ver );

	wp_enqueue_script( 'maera-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Enqueue Modernizr
	wp_register_script( 'modernizr', MAERA_ASSETS_URL . '/js/modernizr-2.7.0.min.js', false, null, false );
	wp_enqueue_script( 'modernizr' );

	// Enqueue fitvids
	wp_register_script( 'fitvids', MAERA_ASSETS_URL . '/js/jquery.fitvids.js',false, null, true  );
	wp_enqueue_script( 'fitvids' );

	if ( current_theme_supports( 'ajax' ) ) {
		// Enqueue pace
		wp_register_script( 'jquery-address', MAERA_ASSETS_URL . '/js/jquery.address-1.5.min.js', array( 'jquery' ), null, true  );
		wp_register_script( 'maera_ajax', MAERA_ASSETS_URL . '/js/maera-ajax.js', array( 'jquery', 'jquery-address' ), null, true  );
		$config = array(
			'base'            => get_home_url(),
			'wrapper'         => 'body',
			'loader'          => '<div class="loader></div>',
			'main'            => '#main',
			'loader_selector' => '.loader',
			'search_selector' => '#search',
			'search_text'     => 'Search...',
		);
		wp_localize_script( 'maera_ajax', 'config', $config );
		wp_enqueue_script( 'maera_ajax' );
	}

	// Enqueue jQuery
	wp_enqueue_script( 'jquery' );

	// If needed, add the comment-reply script.
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$caching = apply_filters( 'maera/styles/caching', false );

	if ( ! $caching ) {

		// Get our styles using the maera/styles filter
		$data = apply_filters( 'maera/styles', null );

	} else {

		// Get the cached CSS from the database
		$cache = get_theme_mod( 'css_cache', '' );

		// If the transient does not exist, then create it.
		if ( $cache === false || empty( $cache ) || '' == $cache ) {

			// Get our styles using the maera/styles filter
			$data = apply_filters( 'maera/styles', null );
			// Set the transient for 24 hours.
			set_theme_mod( 'css_cache', $data );

		} else {

			$data = $cache;

		}

	}

	// Add the CSS inline.
	// See http://codex.wordpress.org/Function_Reference/wp_add_inline_style#Examples
	wp_add_inline_style( 'maera', $data );

}
add_action( 'wp_enqueue_scripts', 'maera_scripts', 100 );
