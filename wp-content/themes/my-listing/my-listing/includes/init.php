<?php

// Debugging helper
if ( ! function_exists('dump') ) {
	function dump( $expression ) { ?><pre><?php foreach ( func_get_args() as $expression ) { var_dump( $expression ); echo '<hr>'; } ?></pre><?php }
}

// Debugging helper
if ( ! function_exists('dd') && function_exists( 'dump' ) ) {
	function dd() { foreach ( func_get_args() as $expression ) { dump( $expression ); } die; }
}

// Helper function for accessing mylisting\includes\app instance.
function mylisting() {
	return MyListing\Includes\App::instance();
}

// Helper function for accessing mylisting\includes\helpers instance.
function c27() {
	return MyListing\Includes\Helpers::instance();
}

// Classes.
MyListing\Src\Dashboard_Pages::instance();
MyListing\Src\Explore::init();

// Queries.
MyListing\Src\Queries\Explore_Listings::instance();
MyListing\Src\Queries\Related_Listings::instance();
MyListing\Src\Queries\Term_Listings::instance();
MyListing\Src\Queries\User_Listings::instance();

// Filters.
MyListing\Includes\Filters::instance();

// Assets.
MyListing\Includes\Assets::instance();

// Ajax actions.
MyListing\Includes\Ajax::instance();

// Admin functions.
MyListing\Includes\Admin::instance();

// Strings.
MyListing\Includes\Strings::instance();

// Shortcodes.
MyListing\Includes\Shortcodes::instance();

/*
 * Configure theme textdomain, supported features, nav menus, etc.
 */
add_action( 'after_setup_theme', function() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for the WooCommerce plugin.
	add_theme_support( 'woocommerce' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// WP Job Manager templates support.
	add_theme_support( 'job-manager-templates' );

	// Set content width
	if ( ! isset( $content_width ) ) $content_width = 550;

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus([
		'primary' => esc_html__( 'Primary Menu', 'my-listing' ),
		'footer' => esc_html__( 'Footer Menu', 'my-listing' ),
	]);

	// Allow shortcodes in menu item labels.
	add_filter( 'wp_nav_menu_items', 'do_shortcode' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	]);

	add_theme_support( 'custom-background', [
		'default-color' => '#fafafa',
	]);
});


/*
 * Register theme sidebars.
 */
add_action( 'widgets_init', function() {
	register_sidebar([
		'name'          => __( 'Footer', 'my-listing' ),
		'id'            => 'footer',
		'before_widget' => '<div class="col-md-4 col-sm-6 col-xs-12 c_widget woocommerce reveal">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c_widget_title"><h5>',
		'after_title'   => '</h5></div>',
		]);

	register_sidebar([
		'name'          => __( 'Sidebar', 'my-listing' ),
		'id'            => 'sidebar',
		'before_widget' => '<div class="element c_widget woocommerce reveal">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="pf-head"><div class="title-style-1"><h5>',
		'after_title'   => '</h5></div></div>',
		]);

	do_action( 'case27_widgets_init' );
});

// Actions to be used by my-listing-addons plugin to add post types and taxonomies.
add_action( 'init', function() {
	do_action( 'case27_register_post_types' );
	do_action( 'case27_register_taxonomies' );
});

// Temporary fix for a bug in WC Vendors plugin, which breaks most AJAX functionality.
if ( apply_filters( 'mylisting\wc-vendors\apply-ajax-bugfix', true ) ) {
	add_action( 'init', function() {
	    if ( class_exists( 'WCV_Admin_Users' ) ) {
	        // @link https://gist.github.com/tripflex/c6518efc1753cf2392559866b4bd1a53
	        function remove_class_filter( $tag, $class_name = '', $method_name = '', $priority = 10 ) {
	            global $wp_filter;
	            if ( ! isset( $wp_filter[ $tag ] ) ) return FALSE;
	            if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {
	                $fob = $wp_filter[ $tag ];
	                $callbacks = &$wp_filter[ $tag ]->callbacks;
	            } else { $callbacks = &$wp_filter[ $tag ]; }
	            if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) return FALSE;
	            foreach( (array) $callbacks[ $priority ] as $filter_id => $filter ) {
	                if ( ! isset( $filter[ 'function' ] ) || ! is_array( $filter[ 'function' ] ) ) continue;
	                if ( ! is_object( $filter[ 'function' ][ 0 ] ) ) continue;
	                if ( $filter[ 'function' ][ 1 ] !== $method_name ) continue;
	                if ( get_class( $filter[ 'function' ][ 0 ] ) === $class_name ) {
	                    if( isset( $fob ) ){
	                        $fob->remove_filter( $tag, $filter['function'], $priority );
	                    } else {
	                        unset( $callbacks[ $priority ][ $filter_id ] );
	                        if ( empty( $callbacks[ $priority ] ) ) {
	                            unset( $callbacks[ $priority ] );
	                        }
	                        if ( empty( $callbacks ) ) {
	                            $callbacks = array();
	                        }
	                        unset( $GLOBALS['merged_filters'][ $tag ] );
	                    }
	                    return TRUE;
	                }
	            }
	            return FALSE;
	        }

	        remove_class_filter( 'product_type_selector', 'WCV_Admin_Users', 'filter_product_types', 99 );
	    }
	} );
}