<?php

namespace MyListing\Ext\Listing_Types;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Designer {
    use \MyListing\Src\Traits\Instantiatable;

    public $fields = [
        'url'   => 'URLField',
        'date'  => 'DateField',
        'file'  => 'FileField',
        'email' => 'EmailField',
        'radio' => 'RadioField',
        'links' => 'LinksField',

        'text'      => 'TextField',
        'textarea'  => 'TextAreaField',
        'wp-editor' => 'WPEditorField',

        'number'   => 'NumberField',
        'select'   => 'SelectField',
        'checkbox' => 'CheckboxField',
        'password' => 'PasswordField',
        'location' => 'LocationField',

        'work-hours'   => 'WorkHoursField',
        'texteditor'   => 'TextEditorField',
        'multiselect'  => 'MultiSelectField',
        'term-select'  => 'TermSelectField',
        'form-heading' => 'FormHeadingField',

        'select-product'   => 'SelectProductField',
        'select-products'  => 'SelectProductsField',
        'related-listing'  => 'RelatedListingField',
    ];

    public static $store = [];

	public function __construct() {
        add_filter( 'mylisting/admin-tips', [ $this, 'permalink_docs' ] );

        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

            add_action( 'init', [ $this, 'setup_store' ], 100 );
            add_action( 'init', [ $this, 'include_files' ] );

            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ], 20 );
        }

        require_once locate_template( 'includes/extensions/listing-types/schemes/schemes.php' );
	}

    public function setup_store() {
        self::$store['listing-types'] = get_posts( [
            'post_type' => 'case27_listing_type',
            'numberposts' => -1,
        ] );

        self::$store['mime-types'] = (array) get_allowed_mime_types();
        self::$store['listing-packages'] = (array) \CASE27\Integrations\PaidListings\PaidListings::get_packages();
        self::$store['taxonomies'] = (array) get_taxonomies( [
            'object_type' => [ 'job_listing' ],
        ], 'objects' );

        self::$store['content-blocks'] = require_once locate_template( 'includes/extensions/listing-types/blueprints/blocks.php' );
        self::$store['structured-data'] = mylisting()->schemes()->get('schema/LocalBusiness');

        if ( function_exists( 'wc_get_product_types' ) ) {
            self::$store['product-types'] = wc_get_product_types();
        } else {
            self::$store['product-types'] = [];
        }
    }

	public function init_metabox() {
        add_action( 'add_meta_boxes', [ $this, 'add_metabox' ] );
        add_action( 'save_post', [ $this, 'save_metabox' ], 10, 2 );
	}

	/**
     * Adds the meta box.
     */
    public function add_metabox() {
        add_meta_box(
            'case27-listing-type-options',
            __( 'Listing Type Options', 'my-listing' ),
            array( $this, 'render_metabox' ),
            'case27_listing_type',
            'advanced',
            'high'
        );
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );

        // Load the template.
        require_once locate_template( 'includes/extensions/listing-types/views/metabox.php' );
    }

    /**
     * Load assets specific to listing type editor screen.
     *
     * @since 1.7.5
     */
    public function enqueue_assets() {
        if ( ! ( $screen = get_current_screen() ) || empty( $screen->post_type ) || $screen->post_type !== 'case27_listing_type' ) {
            return;
        }

        // Load jsoneditor.
        wp_enqueue_script( 'jsoneditor', c27()->template_uri( 'assets/vendor/jsoneditor/jsoneditor.js' ), [], CASE27_THEME_VERSION, true );
        wp_enqueue_style( 'jsoneditor', c27()->template_uri( 'assets/vendor/jsoneditor/jsoneditor.css' ), [], CASE27_THEME_VERSION );

        // Load Listing Type Editor script.
        wp_enqueue_script( 'theme-type-editor', c27()->template_uri( 'assets/dist/admin/type-editor.js' ), ['jsoneditor', 'theme-script-vendor'], CASE27_THEME_VERSION, true );
    }

    /**
     * Handles saving the meta box.
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';

        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }

        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }

        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }

        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        do_action( 'mylisting/admin/types/before-update', $post );

        // Fields TAB
        if (isset($_POST['case27_listing_type_fields'])) {
            $decoded_fields = json_decode( stripslashes( $_POST['case27_listing_type_fields'] ), true );
            $updated_fields = [];

            foreach ( (array) $decoded_fields as $i => $field ) {
                $field['priority'] = ($i + 1);
                $updated_fields[$field['slug']] = (array) $field;
            }

            update_post_meta($post_id, 'case27_listing_type_fields', wp_slash( serialize( $updated_fields ) ) );
        }

        // Single Page TAB
        if (isset($_POST['case27_listing_type_single_page_options'])) {
            $options = (array) json_decode(stripslashes($_POST['case27_listing_type_single_page_options']), true);

            foreach ($options['menu_items'] as $key => $menu_item) {
                if (!isset($menu_item['_id'])) {
                    $options['menu_items'][$key]['_id'] = uniqid('menu_item_id__');
                }
            }

            update_post_meta($post_id, 'case27_listing_type_single_page_options', wp_slash( serialize( $options ) ) );
        }

        // Result Template TAB
        if (isset($_POST['case27_listing_type_result_template'])) {
            $result_template = (array) json_decode(stripslashes($_POST['case27_listing_type_result_template']), true);

            update_post_meta($post_id, 'case27_listing_type_result_template', wp_slash( serialize( $result_template ) ) );
        }

        // Search Forms TAB
        if (isset($_POST['case27_listing_type_search_page'])) {
            $search_forms = (array) json_decode(stripslashes($_POST['case27_listing_type_search_page']), true);

            foreach ($search_forms['advanced']['facets'] as $key => $facet) {
                if (!isset($facet['_id'])) {
                    $search_forms['advanced']['facets'][$key]['_id'] = uniqid('facetid__');
                }
            }

            update_post_meta($post_id, 'case27_listing_type_search_page', wp_slash( serialize( $search_forms ) ) );
        }

        // Settings TAB
        if (isset($_POST['case27_listing_type_settings_page'])) {
            $settings_page = (array) json_decode(stripslashes($_POST['case27_listing_type_settings_page']), true);

            update_post_meta($post_id, 'case27_listing_type_settings_page', wp_slash( serialize( $settings_page ) ) );
        }

        do_action( 'mylisting/admin/types/after-update', $post );
    }

    public function include_files() {
        require_once locate_template( 'includes/extensions/listing-types/fields/field.php' );

        foreach ($this->fields as $field_slug => $field_classname) {
            $namespaced_classname = sprintf( '%s\Fields\%s', __NAMESPACE__, $field_classname );
            require_once locate_template( sprintf( 'includes/extensions/listing-types/fields/%s.php', $field_slug ) );
            $this->fields[ $field_slug ] = new $namespaced_classname;
        }
    }

    public function get_packages_dropdown() {
        $items = [];
        foreach ( (array) self::$store['listing-packages'] as $package) {
            $items[ $package->ID ] = $package->post_title;
        }

        return $items;
    }

    /**
     * Print filter settings in search tab.
     *
     * @since 1.7.5
     */
    public function print_filter_settings() {
        $filters = [
            'WP_Search',
            'Text',
            'Range',
            'Proximity',
            'Location',
            'Dropdown',
            'Date',
            'Checkboxes',
        ];

        foreach ( $filters as $filter ) {
            $classname = sprintf( '\MyListing\Ext\Listing_Types\Filters\%s', $filter );
            if ( class_exists( $classname ) ) {
                $instance = new $classname();
                echo $instance->print_options();
            }
        }
    }

    public function permalink_docs( $tips ) {
        $tips['permalink-docs'] = locate_template( 'includes/extensions/listing-types/templates/admin/permalink-docs.php' );
        return $tips;
    }
}

Designer::instance();
