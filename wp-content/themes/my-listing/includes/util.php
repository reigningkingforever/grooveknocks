<?php
// Debugging helper
if ( ! function_exists('mlog') ) {
	function mlog( $message = null ) {
		if ( $message !== null ) {
			return MyListing\Utils\Logger\Logger::instance()->info( $message );
		}

		return MyListing\Utils\Logger\Logger::instance();
	}
}

// Debugging helper
if ( ! function_exists('dump') ) {
	function dump() {
		call_user_func_array( [ MyListing\Utils\Logger\Logger::instance(), 'dump' ], func_get_args() );
	}
}

// Debugging helper
if ( ! function_exists('dd') ) {
	function dd() {
		call_user_func_array( [ MyListing\Utils\Logger\Logger::instance(), 'dd' ], func_get_args() );
	}
}

// Helper function for accessing mylisting\includes\app instance.
function mylisting() {
	return MyListing\Includes\App::instance();
}

// Alias for `mylisting()->helpers()`
function c27() {
	return mylisting()->helpers();
}

// Helpers.
mylisting()->register( 'helpers', MyListing\Utils\Helpers\Helpers::instance() );

// Logger.
mylisting()->register( 'logger', MyListing\Utils\Logger\Logger::instance() );