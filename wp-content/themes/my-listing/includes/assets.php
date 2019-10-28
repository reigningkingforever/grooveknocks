<?php

namespace MyListing\Includes;

class Assets {
	use \MyListing\Src\Traits\Instantiatable;

	protected $styles, $scripts;

	public function __construct() {
		// Enqueue Scripts and Styles
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 30 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_icons' ] );
		add_action( 'wp_head', [ $this, 'print_head_content' ] );
		add_action( 'admin_head', [ $this, 'print_head_content' ] );
	}

	/**
     * Enqueue theme scripts.
     *
     * @since 1.0.0
	 */
	public function enqueue_scripts() {
		global $wp_query;

		// URL Scripts.
		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_enqueue_script( 'moment', c27()->template_uri( 'assets/vendor/moment/moment.js' ), [], CASE27_THEME_VERSION, true );
		$this->load_moment_locale();

		wp_enqueue_script( 'select2', c27()->template_uri( 'assets/vendor/select2/select2.js' ), ['jquery'], CASE27_THEME_VERSION, true );

		// Frontend scripts.
		wp_enqueue_script( 'mylisting-vendor', c27()->template_uri( 'assets/dist/frontend/vendor.js' ), ['jquery'], CASE27_THEME_VERSION, true );
		wp_enqueue_script( 'c27-main', c27()->template_uri( 'assets/dist/frontend/frontend.js' ), ['jquery'], CASE27_THEME_VERSION, true );

		// Comment reply script
		if ( is_singular() && comments_open() && get_option('thread_comments') ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$localized_data = [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'template_uri' => c27()->template_uri(),
			'posts_per_page' => (int) get_field('portfolio_projects_per_page') ? : get_option('posts_per_page'),
			'query_vars' => json_encode( $wp_query->query ),
			'ajax_nonce' => wp_create_nonce('c27_ajax_nonce'),
			'smooth_scroll_enabled' => c27()->get_setting('general_enable_smooth_scrolling', false),
			'l10n' => [
				'selectOption' => _x( 'Select an option', 'Dropdown placeholder', 'my-listing' ),
				'errorLoading' => _x( 'The results could not be loaded.', 'Dropdown could not load results', 'my-listing' ),
				'loadingMore'  => _x( 'Loading more results…', 'Dropdown loading more results', 'my-listing' ),
				'noResults'    => _x( 'No results found', 'Dropdown no results found', 'my-listing' ),
				'searching'    => _x( 'Searching…', 'Dropdown searching', 'my-listing' ),
				'datepicker'   => mylisting()->strings()->get_datepicker_locale(),
				'irreversible_action' => _x( 'This is an irreversible action. Proceed anyway?', 'Alerts: irreversible action', 'my-listing' ),
				'copied_to_clipboard' => _x( 'Copied!', 'Alerts: Copied to clipboard', 'my-listing' ),
				'nearby_listings_location_required' => _x( 'Enter a location to find nearby listings.', 'Nearby listings dialog', 'my-listing' ),
				'nearby_listings_retrieving_location' => _x( 'Retrieving location...', 'Nearby listings dialog', 'my-listing' ),
				'nearby_listings_searching' => _x( 'Searching for nearby listings...', 'Nearby listings dialog', 'my-listing' ),
			],
			'woocommerce' => [],
		];

		if ( class_exists( 'WooCommerce' ) ) {
			$localized_data['woocommerce']['cart_count'] = WC()->cart->get_cart_contents_count();
		}

		// Localize data.
		wp_localize_script( 'c27-main', 'CASE27', $localized_data );

		// Custom JavaScript
		wp_add_inline_script( 'c27-main', c27()->get_setting('custom_js') );

		// Disable WooCommerce pretty photo plugin.
		if ( class_exists( 'WooCommerce' ) ) {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}
	}

	public function enqueue_icons() {
		wp_enqueue_style( 'c27-icons', c27()->template_uri( 'assets/dist/icons/icons.css' ), [], CASE27_THEME_VERSION );
	}

	/**
	 * Enqueue Theme Styles.
	 */
	public function enqueue_styles() {
		// URL Styles.
		wp_enqueue_style( 'c27-material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
		wp_enqueue_style( 'c27-google-fonts', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' );
		wp_enqueue_style( 'select2', c27()->template_uri( 'assets/vendor/select2/select2.css' ), [], CASE27_THEME_VERSION );

		// Minfied, single styles file for production.
		wp_enqueue_style( 'mylisting-vendor', c27()->template_uri( 'assets/dist/frontend/vendor.css' ), [], CASE27_THEME_VERSION );
		wp_enqueue_style( 'c27-style', c27()->template_uri( 'assets/dist/frontend/frontend.css' ), [], CASE27_THEME_VERSION );

		// Default Styles
		wp_enqueue_style( 'theme-styles-default', c27()->template_uri( 'style.css' ) );

		wp_enqueue_style( 'thems-styles-dynamic', c27()->template_uri( 'assets/dynamic/frontend.css.php?' . http_build_query( [
			'brand' => c27()->get_setting('general_brand_color', '#f24286'),
			'loader' => c27()->hexToRgb( c27()->get_setting( 'general_loading_overlay_color' ,'#000000' ) ),
		] ) ) );

		// Custom Styles.
		wp_add_inline_style( 'theme-styles-default', $this->custom_styles());
	}


    // Get custom styles.
	public function custom_styles() {
		ob_start();

		echo c27()->get_setting('custom_css');

		return str_replace( "\n", '', ob_get_clean() );
	}

	public function load_moment_locale() {
		$locales = [
			'af', 'ar-dz', 'ar-kw', 'ar-ly', 'ar-ma', 'ar-sa', 'ar-tn', 'ar', 'az', 'be', 'bg', 'bm', 'bn', 'bo', 'br', 'bs', 'ca', 'cs', 'cv', 'cy',
			'da', 'de-at', 'de-ch', 'de', 'dv', 'el', 'en-au', 'en-ca', 'en-gb', 'en-ie', 'en-il', 'en-nz', 'eo', 'es-do', 'es-us', 'es', 'et', 'eu',
			'fa', 'fi', 'fo', 'fr-ca', 'fr-ch', 'fr', 'fy', 'gd', 'gl', 'gom-latn', 'gu', 'he', 'hi', 'hr', 'hu', 'hy-am', 'id', 'is', 'it', 'ja', 'jv',
			'ka', 'kk', 'km', 'kn', 'ko', 'ky', 'lb', 'lo', 'lt', 'lv', 'me', 'mi', 'mk', 'ml', 'mr', 'ms-my', 'ms', 'mt', 'my', 'nb', 'ne', 'nl-be',
			'nl', 'nn', 'pa-in', 'pl', 'pt-br', 'pt', 'ro', 'ru', 'sd', 'se', 'si', 'sk', 'sl', 'sq', 'sr-cyrl', 'sr', 'ss', 'sv', 'sw', 'ta', 'te',
			'tet', 'tg', 'th', 'tl-ph', 'tlh', 'tr', 'tzl', 'tzm-latn', 'tzm', 'ug-cn', 'uk', 'ur', 'uz-latn', 'uz', 'vi', 'x-pseudo', 'yo', 'zh-cn', 'zh-hk', 'zh-tw'
		];

		$load_locale = false;
		$locale = str_replace( '_', '-', strtolower( get_locale() ) );

		if ( in_array( $locale, $locales ) ) {
			$load_locale = $locale;
		} elseif ( strpos( $locale, '-') !== false ) {
			$locale = explode( '-', $locale );
			if ( in_array( $locale[0], $locales ) ) {
				$load_locale = $locale[0];
			}
		}

		if ( $load_locale ) {
			wp_enqueue_script( 'moment-locale-' . $load_locale, sprintf( 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/%s.js', $load_locale ), ['moment'], '1.0', true );
			wp_add_inline_script( 'moment-locale-' . $load_locale, sprintf( 'window.MyListing_Moment_Locale = \'%s\';', $load_locale ) );
		}
	}

	/**
	 * Print content within the site <head></head>.
	 *
	 * @since 1.7.2
	 */
	public function print_head_content() {
		// MyListing object.
		$data = apply_filters( 'mylisting/localize-data', [
			'Helpers' => new \stdClass,
		] );

		foreach ( (array) $data as $key => $value ) {
			if ( ! is_scalar( $value ) ) {
				continue;
			}
			$data[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
		}

		printf( '<script type="text/javascript">var MyListing = %s;</script>', wp_json_encode( (object) $data ) );
	}
}
