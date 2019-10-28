<?php defined('ABSPATH') OR die('restricted access');

class MyListing_Import_ACF_data
{
    private $_acf_directories = array();

    /**
     * A contruct function
     */
    public function __construct( $demo_name )
    {
        $this->_import_demo_name = $demo_name;

        // Load ACF directories
        $this->_load_acf_directories();

        // Clear ACF existing data
        $this->_clear_acf_data();

        // Import JSON fields Groups
        foreach( $this->_acf_directories as $directory ) {
            $this->_import_json_fields_groups( $directory );
        }
    }

    private function _import_json_fields_groups( $directory )
    {
        // Load JSON files available in directory
        $json_files = $this->_read_acf_directory( $directory );

        if ( ! $json_files ) {
            return false;
        }

        foreach ( $json_files as $file ) {

            $json_data = $this->_load_json_file( $file );

            if ( empty( $json_data['fields'] ) ) {
                continue;
            }

            // Wrap JSON data in an array
            $json_data = array( $json_data );

            $this->_sync_json_data( $json_data );

            // Save fields options data
            $this->_save_options_data( $json_data );
        }
    }

    private function _sync_json_data( $json_data )
    {
        foreach ( $json_data as $field_group ){

            // Remove fields from json_data
            $fields = acf_extract_var( $field_group, 'fields' );

            // format fields
            $fields = acf_prepare_fields_for_import( $fields );

            // save field group
            $field_group = acf_update_field_group( $field_group );

            $ref = array();
            $order = array();

            // add to ref
            $ref[ $field_group['key'] ] = $field_group['ID'];

            // add to order
            $order[ $field_group['ID'] ] = 0;

            // add fields
            foreach( $fields as $field ) {

                // add parent
                if ( empty( $field['parent'] ) ) {
                    $field['parent'] = $field_group['ID'];
                } elseif( isset($ref[ $field['parent'] ]) ) {
                    $field['parent'] = $ref[ $field['parent'] ];
                }

                // add field menu_order
                if ( ! isset( $order[ $field['parent'] ] ) ) {
                    $order[ $field['parent'] ] = 0;
                }

                $field['menu_order'] = $order[ $field['parent'] ];
                $order[ $field['parent'] ]++;

                // save field
                $field = acf_update_field( $field );
            }
        }
    }

    private function _save_options_data( $json_data )
    {
        if ( empty( $json_data[0]['title'] ) || 'Theme Options' != $json_data[0]['title'] || empty( $this->_import_demo_name ) ) {
            return false;
        }

        if ( 'My City' == $this->_import_demo_name ) {
            $default_values = $this->_default_my_city_theme_options();
        } elseif ( 'My Home' == $this->_import_demo_name ) {
            $default_values = $this->_default_my_home_theme_options();
        } elseif ( 'My Car' == $this->_import_demo_name ) {
            $default_values = $this->_default_my_car_theme_options();
        }

        // Time to save default theme options
        $org_post_data = $_POST;

        // Temporarily hack global POST variable
        $_POST = array('acf' => $default_values);

        acf_save_post('options', $default_values);

        // restore post data
        $_POST = $org_post_data;
    }

    private function _clear_acf_data()
    {
        // Make sure that acf Not to save to JSON
        add_filter('acf/settings/save_json', '__return_false', 99 );

        // Remove previous field groups in DB
        $args = [
                    'post_type'   => 'acf-field-group',
                    'post_status' => 'any',
                    'posts_per_page' => -1
                ];

        $query = new WP_Query( $args );

        foreach ( $query->posts as $acf_group ) {
            wp_delete_post( $acf_group->ID, true );
        }
    }

    private function _read_acf_directory( $directory )
    {
        return glob( $directory . '/*.json' );
    }

    private function _load_json_file( $file )
    {
        try {

            $json_data = json_decode( file_get_contents( $file ), true );
        } catch( Exception $e ) {}

        return ( ! empty( $json_data ) ) ? $json_data : array();
    }

    private function _load_acf_directories()
    {
        return $this->_acf_directories = acf_get_setting('load_json');
    }

    private function _default_my_city_theme_options()
    {
        return [

            'field_595b7eda34dc9' => 131,
            'field_5998c6c12e783' => '#ff447c',
            'field_598dd43d705fa' => 'material-spinner',
            'field_59ba134da1abd' => '#242833',
            'field_59ba138ca1abe' => 'rgba(29, 35, 41, 0.98)',
            'field_59732236d5c0f' => 0,
            'field_595ba530f1c84' => 'AIzaSyCR6AOuQsB6exa92mIRvhldD517WzZsaqI',
            'field_595b7d8981914' => 'default',
            'field_59a1982a24d8f' => 'dark',
            'field_595b7e899d6ac' => 'rgba(29, 35, 41, 0.97)',
            'field_59a3566469433' => 'rgba(29, 35, 41, 0.97)',
            'field_595b7dd181915' => 1,
            'field_595b80b1a931a' => 'right',
            'field_59eeaac62c1c5' => 38,
            'field_595b8055a9318' => 1,
            'field_595b8071a9319' => 'Type your search...',
            'field_5964e0d3bbed9' => array (
                                        27, 25, 24,
                                    ),

            'field_595b820157999' => 1,
            'field_595b82555799a' => 17,
            'field_595b82b95799b' => '[27-icon icon="icon-add-circle-1"] Add Listing',
            'field_59a3660f98ace' => 0,
            'field_59ac724a6000a' => '',
            'field_59a350150bddf' => 'dark',
            'field_59a34ff80bdde' => 'rgba(29, 35, 41, 0.97)',
            'field_59ac71706c392' => 'rgba(29, 35, 41, 0.97)',
            'field_595b85b15dbec' => 0,
            'field_595b85cc5dbed' => 0,
            'field_595b85e35dbee' => '© Made by 27collective',
            'field_598719cf8d4c3' => 1,
            'field_595bd2fffffff' => 23,
            'field_59770a24cb27d' => 20,
            'field_59a455e61eccc' => 17,
            'field_5a41a68a9adf4' => 'geocode',
            'field_5a41b1647b8aa' => '',
            'field_59a3619133e32' => array (
                                        'field_59a3619133e32_field_595b7d8981914' => 'default',
                                        'field_59a3619133e32_field_59a1982a24d8f' => 'dark',
                                        'field_59a3619133e32_field_595b7e899d6ac' => 'rgba(25, 28, 31, 0)',
                                        'field_59a3619133e32_field_59a3566469433' => 'rgba(255, 255, 255, 0.2)',
                                      ),

            'field_5963dbc3f9cbe' => 'header2',
            'field_59a056ca65404' => '#242429',
            'field_59a056ef65405' => 0.5,
            'field_59a169755eeef' => '#242429',
            'field_59a1697b5eef0' => '0.5',
            'field_5971331211e6c' => '',
            'field_598dd4ba53c28' => '',
            'field_598dd4eb53c29' => '',
            'field_5a0d7bfc4e799' => '',
        ];
    }

    private function _default_my_home_theme_options()
    {
        return [

            'field_595b7eda34dc9' => 140,
            'field_5998c6c12e783' => '#ff5a64',
            'field_598dd43d705fa' => 'site-logo',
            'field_59ba134da1abd' => '#ff5a64',
            'field_59ba138ca1abe' => '#ffffff',
            'field_59732236d5c0f' => 0,
            'field_595ba530f1c84' => 'AIzaSyCR6AOuQsB6exa92mIRvhldD517WzZsaqI',
            'field_595b7d8981914' => 'default',
            'field_59a1982a24d8f' => 'light',
            'field_595b7e899d6ac' => '#ffffff',
            'field_59a3566469433' => 'rgba(25, 28, 31, 0)',
            'field_595b7dd181915' => 0,
            'field_595b80b1a931a' => 'right',
            'field_59eeaac62c1c5' => 42,
            'field_595b8055a9318' => 0,
            'field_595b8071a9319' => 'Type your search...',
            'field_5964e0d3bbed9' => array (
                                        27, 25, 24,
                                    ),

            'field_595b820157999' => 1,
            'field_595b82555799a' => 17,
            'field_595b82b95799b' => '[27-icon icon="icon-add-circle-1"] Add Listing',
            'field_59a3660f98ace' => 0,
            'field_59ac724a6000a' => '',
            'field_59a350150bddf' => 'light',
            'field_59a34ff80bdde' => '#ffffff',
            'field_59ac71706c392' => 'rgba(0, 0, 0, 0.10)',
            'field_595b85b15dbec' => 0,
            'field_595b85cc5dbed' => 1,
            'field_595b85e35dbee' => '© Made with <i class="fa fa-heart-o" style="color: #f2498b;"></i> by <a href="http://27collective.net" target="_blank">27collective</a>',
            'field_598719cf8d4c3' => 1,
            'field_595bd2fffffff' => 23,
            'field_59770a24cb27d' => 9,
            'field_59a455e61eccc' => 17,
            'field_5a41b1647b8aa' => '',
            'field_59a3619133e32' => array (
                                        'field_59a3619133e32_field_595b7d8981914' => 'default',
                                        'field_59a3619133e32_field_59a1982a24d8f' => 'light',
                                        'field_59a3619133e32_field_595b7e899d6ac' => '#ffffff',
                                        'field_59a3619133e32_field_59a3566469433' => 'rgba(25, 28, 31, 0)',
                                      ),

            'field_5963dbc3f9cbe' => 'header4',
            'field_59a056ca65404' => '#242429',
            'field_59a056ef65405' => 0.5,
            'field_59a169755eeef' => '#242429',
            'field_59a1697b5eef0' => '0.4',
            'field_5971331211e6c' => '',
            'field_598dd4ba53c28' => '',
            'field_598dd4eb53c29' => '',
        ];
    }

    private function _default_my_car_theme_options()
    {
        return [

            'field_595b7eda34dc9' => 138,
            'field_5998c6c12e783' => '#018bb5',
            'field_598dd43d705fa' => 'material-spinner',
            'field_59ba134da1abd' => '#242833',
            'field_59ba138ca1abe' => '#ffffff',
            'field_59732236d5c0f' => 0,
            'field_595ba530f1c84' => 'AIzaSyCR6AOuQsB6exa92mIRvhldD517WzZsaqI',
            'field_595b7d8981914' => 'default',
            'field_59a1982a24d8f' => 'dark',
            'field_595b7e899d6ac' => '#018bb5',
            'field_59a3566469433' => '#018bb5',
            'field_595b7dd181915' => 1,
            'field_595b80b1a931a' => 'right',
            'field_59eeaac62c1c5' => 38,
            'field_595b8055a9318' => 1,
            'field_595b8071a9319' => 'What are you looking for?',
            'field_5964e0d3bbed9' => array (
                                        27, 25, 24,
                                    ),

            'field_595b820157999' => 1,
            'field_595b82555799a' => 17,
            'field_595b82b95799b' => '[27-icon icon="icon-add-circle-1"] Add Listing',
            'field_59a3660f98ace' => 0,
            'field_59ac724a6000a' => '',
            'field_59a350150bddf' => 'dark',
            'field_59a34ff80bdde' => '#018bb5',
            'field_59ac71706c392' => '#018bb5',
            'field_595b85b15dbec' => 1,
            'field_595b85cc5dbed' => 1,
            'field_595b85e35dbee' => '© Made by 27collective',
            'field_598719cf8d4c3' => 1,
            'field_595bd2fffffff' => 23,
            'field_59770a24cb27d' => 9,
            'field_59a455e61eccc' => 17,
            'field_59a3619133e32' => array (
                                        'field_59a3619133e32_field_595b7d8981914' => 'default',
                                        'field_59a3619133e32_field_59a1982a24d8f' => 'dark',
                                        'field_59a3619133e32_field_595b7e899d6ac' => '#018bb5',
                                        'field_59a3619133e32_field_59a3566469433' => '#018bb5',
                                      ),

            'field_5963dbc3f9cbe' => 'default',
            'field_59a056ca65404' => '#018bb5',
            'field_59a056ef65405' => 1,
            'field_59a169755eeef' => '#15191b',
            'field_59a1697b5eef0' => '0.4',
            'field_5971331211e6c' => '',
            'field_598dd4ba53c28' => '',
            'field_598dd4eb53c29' => '',
        ];
    }
}