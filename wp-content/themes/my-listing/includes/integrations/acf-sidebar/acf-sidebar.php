<?php defined('ABSPATH') OR die('restricted access');

class ACF_Sidebar {
    protected $settings;

    public function __construct() {

        $this->settings = [
            'version'   => CASE27_THEME_VERSION,
            'url'       => get_template_directory_uri() . '/includes/integrations/acf-sidebar',
            'path'      => CASE27_INTEGRATIONS_DIR . '/acf-sidebar',
        ];

        add_action( 'acf/include_field_types', [$this, 'acf_register_field' ] );
    }

    public function acf_register_field() {
        require_once CASE27_INTEGRATIONS_DIR . '/acf-sidebar/fields/acf-field-sidebar.php';
    }
}

new ACF_Sidebar();
