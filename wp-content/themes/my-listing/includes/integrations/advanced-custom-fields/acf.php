<?php

namespace MyListing;

class ACF {
	use \MyListing\Src\Traits\Instantiatable;

	public function __construct() {
		add_filter( 'acf/settings/path',       [ $this, 'settings_path' ] );
		add_filter( 'acf/settings/dir',        [ $this, 'settings_dir' ] );
		add_filter( 'acf/settings/save_json',  [ $this, 'save_json' ] );
		add_filter( 'acf/settings/load_json',  [ $this, 'load_json' ] );
		add_filter( 'acf/settings/show_admin', [ $this, 'show_admin' ], 30 );

		// Load ACF extensions.
		$this->load_extensions();

		// Add 'Theme Options' ACF page.
		add_action( 'acf/init', [ $this, 'add_theme_options_page' ] );

		// Add 'Integrations' ACF page.
		add_action( 'acf/init', [ $this, 'add_integrations_page' ] );

		// filter for every field
		add_filter( 'acf/fields/post_object/query', [ $this, 'post_object_query' ], 30, 3 );
		add_filter( 'acf/fields/post_object/result', [ $this, 'post_object_result' ], 30, 4 );

	}

	/**
	 * Load ACF extensions.
	 *
	 * @since 1.7.0
	 */
	public function load_extensions() {
		require_once CASE27_INTEGRATIONS_DIR . '/advanced-custom-fields/acf-icon-picker/acf-icon_picker.php';
		require_once CASE27_INTEGRATIONS_DIR . '/advanced-custom-fields/acf-code-field/acf-code-field.php';
	}

	public function settings_path( $path ) {
    	return CASE27_INTEGRATIONS_DIR . '/advanced-custom-fields/plugin/';
	}

	public function settings_dir( $dir ) {
    	return get_template_directory_uri() . '/includes/integrations/advanced-custom-fields/plugin/';
	}

	public function save_json( $path ) {
    	return CASE27_INTEGRATIONS_DIR . '/advanced-custom-fields/acf-json';
	}

	public function load_json( $paths ) {
		// Remove original path.
    	unset($paths[0]);
    	$paths[] = CASE27_INTEGRATIONS_DIR . '/advanced-custom-fields/acf-json';
	    return $paths;
	}

    public function show_admin() {
        return CASE27_ENV === 'dev';
    }

    public function add_theme_options_page() {
		acf_add_options_sub_page( [
			'page_title' 	=> __('Theme Options', 'my-listing'),
			'menu_title'	=> __('Theme Options', 'my-listing'),
			'menu_slug' 	=> 'theme-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'parent_slug'   => 'case27/tools.php',
		] );
	}

    public function add_integrations_page() {
		acf_add_options_sub_page( [
			'page_title' 	=> __( 'Integrations', 'my-listing' ),
			'menu_title'	=> __( 'Integrations', 'my-listing' ),
			'menu_slug' 	=> 'theme-integration-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'parent_slug'   => 'case27/tools.php',
		] );
	}

	/**
	 * Order 'Post Object' dropdown fields by date,
	 * based on it's classname (.order-by-date).
	 *
	 * @since 1.7.0
	 */
	public function post_object_query( $args, $field, $post_id ) {
		if ( ! isset( $field['wrapper'], $field['wrapper']['class'], $field['type'] ) || $field['type'] !== 'post_object' ) {
			return $args;
		}

		// Order by date.
		if ( strpos( $field['wrapper']['class'], 'order-by-date' ) !== false ) {
			$args['orderby'] = 'date';
			$args['order'] = 'DESC';
		}

	    return $args;
	}

	/**
	 * Filter the dropdown item name.
	 *
	 * @since 1.7.0
	 */
	public function post_object_result( $title, $post, $field, $post_id ) {
		if ( ! isset( $field['wrapper'], $field['wrapper']['class'], $field['type'] ) || $field['type'] !== 'post_object' ) {
			return $title;
		}

		// Prepend ID.
		if ( strpos( $field['wrapper']['class'], 'prepend-item-id' ) !== false ) {
			$title = sprintf( '<strong>#%d</strong> &mdash; %s', $post->ID, $title );
		}

		return $title;
	}
}

ACF::instance();