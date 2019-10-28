<?php
/**
 * Code Field Module.
 *
 * @version 1.0.0
 * @author 27collective
 *
 *    Copyright: 2018 27collective
 *    License: GNU General Public License v2.0
 *    License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 *    Copyright: 2017 Peter Tasker (http://petetasker.com)
 *    License: GNU General Public License v2.0
 *    License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
**/

// Include field type for ACF5.
add_action( 'acf/include_field_types', function( $version ) {
    require_once trailingslashit( CASE27_INTEGRATIONS_DIR ) . 'advanced-custom-fields/acf-code-field/lib/code-field.php';
} );
