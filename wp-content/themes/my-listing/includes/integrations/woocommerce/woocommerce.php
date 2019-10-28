<?php

namespace MyListing\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce {

	use \MyListing\Src\Traits\Instantiatable;

	public function __construct() {
		// Handle Custom Queries.
		require_once CASE27_INTEGRATIONS_DIR . '/woocommerce/woocommerce-queries.php';

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/dashboard.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/dashboard.php',
            'title' => __( 'Dashboard', 'my-listing' ),
            'icon' => 'material-icons://home',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/orders.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/orders.php',
            'title' => __( 'Orders', 'my-listing' ),
            'icon' => 'material-icons://shopping_basket',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/view-order.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/view-order.php',
            'title' => __( 'View Order', 'my-listing' ),
            'icon' => 'material-icons://shopping_basket',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/downloads.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/downloads.php',
            'title' => __( 'Downloads', 'my-listing' ),
            'icon' => 'material-icons://file_download',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/form-edit-address.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/form-edit-address.php',
            'title' => __( 'Addresses', 'my-listing' ),
            'icon' => 'material-icons://map',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/form-edit-account.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/form-edit-account.php',
            'title' => __( 'Account Details', 'my-listing' ),
            'icon' => 'material-icons://account_circle',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_account_products_published_before',
            'end' => 'case27_woocommerce_account_products_published_after',
            'title' => __( 'Published Products', 'my-listing' ),
            'icon' => 'material-icons://view_list',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_account_products_pending_before',
            'end' => 'case27_woocommerce_account_productspending_after',
            'title' => __( 'Pending Products', 'my-listing' ),
            'icon' => 'material-icons://view_list',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_account_add_product_before',
            'end' => 'case27_woocommerce_account_add_product_after',
            'title' => __( 'Add a Product', 'my-listing' ),
            'icon' => 'material-icons://note_add',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_account_listings_before',
            'end' => 'case27_woocommerce_account_listings_after',
            'title' => __( 'My Listings', 'my-listing' ),
            'icon' => 'material-icons://store_mall_directory',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_promoted_listings_before',
            'end' => 'case27_woocommerce_promoted_listings_after',
            'title' => __( 'Promotion Packages', 'my-listing' ),
            'icon' => 'material-icons://vpn_key',
        ] );


        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/payment-methods.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/payment-methods.php',
            'title' => __( 'Payment Methods', 'my-listing' ),
            'icon' => 'material-icons://payment',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_bookmarks_before',
            'end' => 'case27_woocommerce_bookmarks_after',
            'title' => __( 'Bookmarked Listings', 'my-listing' ),
            'icon' => 'material-icons://bookmark_border',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_wc_vendors_store_before',
            'end' => 'case27_woocommerce_wc_vendors_store_after',
            'title' => __( 'My Store', 'my-listing' ),
            'icon' => 'material-icons://store',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_wc_vendors_store_settings_before',
            'end' => 'case27_woocommerce_wc_vendors_store_settings_after',
            'title' => __( 'Store Settings', 'my-listing' ),
            'icon' => 'material-icons://settings',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/my-subscriptions.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/my-subscriptions.php',
            'title' => __( 'Subscriptions', 'my-listing' ),
            'icon' => 'material-icons://monetization_on',
        ] );

        $this->wrap_page_in_block( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/view-subscription.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/view-subscription.php',
            'title' => __( 'Subscriptions', 'my-listing' ),
            'icon' => 'material-icons://monetization_on',
        ] );

        // COLUMN WRAPS.
        $this->wrap_page_in_column( [
            'start' => 'case27_woocommerce_before_template_part_checkout/form-coupon.php',
            'end' => 'case27_woocommerce_after_template_part_checkout/form-coupon.php',
            'classes' => 'c27-form-coupon-wrapper',
        ] );

        // SECTION WRAPS.
        $this->wrap_page_in_section( [
            'start' => 'woocommerce_before_cart',
            'end' => 'woocommerce_after_cart',
            'title' => '',
            'icon' => 'icon-shopping-basket-1',
            'columns' => 'col-md-12',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_woocommerce_before_template_part_cart/cart-empty.php',
            'end' => 'case27_woocommerce_after_template_part_cart/cart-empty.php',
            'title' => '',
            'icon' => 'icon-shopping-basket-1',
            'columns' => 'col-md-12',
            'classes' => 'i-section empty-cart-wrapper',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_woocommerce_before_template_part_checkout/cart-errors.php',
            'end' => 'case27_woocommerce_after_template_part_checkout/cart-errors.php',
            'title' => '',
            'icon' => 'icon-shopping-basket-1',
            'columns' => 'col-md-12',
            'classes' => 'i-section cart-errors-wrapper',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'woocommerce_before_checkout_form',
            'end' => 'woocommerce_after_checkout_form',
            'title' => '',
            'icon' => 'icon-shopping-basket-1',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_woocommerce_before_thankyou_template',
            'end' => 'case27_woocommerce_after_thankyou_template',
            'title' => '',
            'icon' => 'icon-shopping-basket-1',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/form-lost-password.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/form-lost-password.php',
            'title' => __( 'Lost your password?', 'my-listing' ),
            'icon' => 'material-icons://lock_outline',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/form-reset-password.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/form-reset-password.php',
            'title' => __( 'Reset your password', 'my-listing' ),
            'icon' => 'material-icons://lock_outline',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_woocommerce_before_template_part_myaccount/lost-password-confirmation.php',
            'end' => 'case27_woocommerce_after_template_part_myaccount/lost-password-confirmation.php',
            'title' => __( 'Reset your password', 'my-listing' ),
            'icon' => 'material-icons://lock_outline',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'wpjmcl_submit_claim_form_claim_listing_view_before',
            'end' => 'wpjmcl_submit_claim_form_claim_listing_view_after',
            'title' => __( 'Claim this listing', 'my-listing' ),
            'icon' => 'material-icons://view_list',
        ] );

        $this->wrap_page_in_section( [
            'start' => 'case27_wpjmcl_login_register_view_before',
            'end' => 'case27_wpjmcl_login_register_view_after',
            'title' => __( 'Claim this listing', 'my-listing' ),
            'icon' => 'material-icons://view_list',
        ] );

        // Actions/Filters.
        add_action('woocommerce_before_template_part', [$this, 'before_template_action']);
        add_action('woocommerce_after_template_part', [$this, 'after_template_action']);
        add_filter( 'loop_shop_columns', [$this, 'c27_set_loop_shop_columns'] );
        add_filter( 'c27_shop_loop_products_columns', [$this, 'c27_get_loop_shop_columns'] );
        add_action( 'c27_shop_page_sidebar', [$this, 'c27_get_shop_page_sidebar'] );
        add_action( 'theme_page_templates', [$this, 'show_shop_archive_templates'], 2, 3 );

        // Ajax cart fragments.
        add_action( 'woocommerce_add_to_cart_fragments', [ $this, 'cart_fragments' ], 30 );

        // WooCommerce scripts.
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 30 );
    }

    public function c27_set_loop_shop_columns()
    {
        return apply_filters( 'c27_shop_loop_products_columns', 3 );
    }

    public function c27_get_loop_shop_columns( $columns )
    {
        $custom_columns = get_option( 'options_shop_page_product_columns' );

        if ( isset( $custom_columns ) && intval( $custom_columns ) ) {
            $columns = $custom_columns;
        }

        return $columns;
    }

    public function c27_get_shop_page_sidebar( $sidebar_name )
    {
        $custom_sidebar = get_option( 'options_shop_page_sidebar' );

        // remove extra classes
        add_filter('dynamic_sidebar_params', [$this, 'remove_sidebar_classes']);

        if ( empty( $sidebar_name ) ) {
            dynamic_sidebar( 'sidebar' );
        } else if ( isset( $custom_sidebar ) && ! empty( $custom_sidebar ) ) {
            dynamic_sidebar( $custom_sidebar );
        } else {
            dynamic_sidebar( 'sidebar' );
        }

        remove_filter('dynamic_sidebar_params', [$this, 'remove_sidebar_classes']);
    }

    public function remove_sidebar_classes( $params )
    {
        if ( isset( $params[0]['before_widget'] ) ) {
            $params[0]['before_widget'] = '<div class="element c_widget woocommerce">';
        }

        return $params;
    }

    public function show_shop_archive_templates( $page_templates, $theme, $post ) {

        global $wp_filter;

        if ( $post && function_exists('wc_get_page_id' ) && wc_get_page_id( 'shop' ) === absint( $post->ID ) ) {

            // remove woocommerce default filter to show the page templates
            foreach( $wp_filter['theme_page_templates'] as $filter_id => $filters ) {

                if ( empty( $filters ) ) {
                    continue;
                }

                foreach( $filters as $filter_name => $filter ) {

                    if ( count( $filter['function'] ) < 1 || ! is_a( $filter['function'][0], 'WC_Admin_Post_Types' ) ) {
                        continue;
                    }

                    remove_filter( 'theme_page_templates', $filter['function'] );
                }
            }
        }

        return $page_templates;
    }

	/**
	 * Generate an action hook for each WooCommerce
	 * template file before it's loaded, based on it's name.
	 *
	 * @since 1.0.0
	 * @param string $template Name of the template file.
	 */
	public function before_template_action( $template ) {
		do_action( sprintf( 'case27_woocommerce_before_template_part_%s', $template ) );
		do_action( sprintf( 'mylisting/woocommerce/templates/%s/before', $template ) );
	}

	/**
	 * Generate an action hook for each WooCommerce
	 * template file after it's loaded, based on it's name.
	 *
	 * @since 1.0.0
	 * @param string $template Name of the template file.
	 */
	public function after_template_action( $template ) {
		do_action( sprintf( 'case27_woocommerce_after_template_part_%s', $template ) );
		do_action( sprintf( 'mylisting/woocommerce/templates/%s/after', $template ) );
	}

	/**
	 * Wrap a WooCommerce page in a MyListing block layout.
	 *
	 * @since 1.0.0
	 * @param array $page {
	 *     An associative array with the page information.
	 *
	 *     @type string $start Action hook to insert the opening block markup.
	 *     @type string $end   Action hook to insert the closing block markup.
	 *     @type string $icon  Block icon to use.
	 *     @type string $title Block title to use.
	 * }
	 */
	public function wrap_page_in_block( $page ) {
		add_action($page['start'], function($args = []) use ($page) {
			if (!is_array($args)) $args = [];
			$page = c27()->merge_options($page, (array) $args);
			?>
			<div class="element">
				<div class="pf-head round-icon">
					<div class="title-style-1">
						<?php echo c27()->get_icon_markup($page['icon']) ?>
						<h5><?php echo esc_html( $page['title'] ) ?></h5>
					</div>
				</div>
				<div class="pf-body">
		<?php });

        add_action($page['end'], function() { ?>
                </div>
            </div>
        <?php });
    }

	/**
	 * Wrap a WooCommerce section in a MyListing block layout.
	 *
	 * @since 1.0.0
	 * @param array $page {
	 *     An associative array with the page information.
	 *
	 *     @type string $start   Action hook to insert the opening block markup.
	 *     @type string $end     Action hook to insert the closing block markup.
	 *     @type string $icon    Block icon to use.
	 *     @type string $title   Block title to use.
	 *     @type string $columns Column width.
	 *     @type string $classes Custom section classes.
	 * }
	 */
	public function wrap_page_in_section( $page ) {
		add_action($page['start'], function($args = []) use ($page) {
			if (!is_array($args)) $args = [];
			$page = c27()->merge_options($page, (array) $args);

            if ( empty( $page['columns'] ) ) {
                $page['columns'] = 'col-md-10 col-md-offset-1';
            }

            if ( empty( $page['classes'] ) ) {
                $page['classes'] = 'i-section';
            }
            ?>
            <section class="<?php echo esc_attr( $page['classes'] ) ?>">
                <div class="container">
                    <div class="row section-body reveal">
                        <div class="<?php echo esc_attr( $page['columns'] ) ?>">
                            <div class="element">
                                <div class="pf-head round-icon">
                                    <div class="title-style-1">
                                        <?php echo c27()->get_icon_markup($page['icon']) ?>
                                        <h5><?php echo $page['title'] ? esc_html( $page['title'] ) : get_the_title() ?></h5>
                                    </div>
                                </div>
                                <div class="pf-body">
        <?php });

        add_action($page['end'], function() { ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php });
    }

	/**
	 * Wrap a WooCommerce page in a MyListing column layout.
	 *
	 * @since 1.0.0
	 * @param array $page {
	 *     An associative array with the page information.
	 *
	 *     @type string $start   Action hook to insert the opening block markup.
	 *     @type string $end     Action hook to insert the closing block markup.
	 *     @type string $classes Custom section classes.
	 * }
	 */
	public function wrap_page_in_column( $page ) {
		add_action($page['start'], function($args = []) use ($page) {
			if (!is_array($args)) $args = [];
			$page = c27()->merge_options($page, (array) $args);
			?>
			<div class="container <?php echo esc_attr( $page['classes'] ) ?>">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
		<?php });

        add_action($page['end'], function() { ?>
                    </div>
                </div>
            </div>
        <?php });
    }

    /**
     * Retrieve the cart item count on cart items change,
     * and update the cart item counter in the header.
     *
     * @since 1.7.0
     */
    public function cart_fragments( $fragments ) {
        if ( WC()->cart->get_cart_contents_count() < 1 ) {
            $fragments['#user-cart-menu .header-cart-counter'] = '<i class="header-cart-counter counter-hidden"></i>';
        } else {
            $fragments['#user-cart-menu .header-cart-counter'] = sprintf(
                '<i class="header-cart-counter counter-pulse" data-count="%d"><span>%s</span></i>',
                WC()->cart->get_cart_contents_count(),
                number_format_i18n( WC()->cart->get_cart_contents_count() )
            );
        }

        return $fragments;
    }

    /**
     * Register/deregister WooCommerce scripts.
     *
     * @since 1.7.0
     */
    public function enqueue_scripts() {
        if ( ! is_user_logged_in() ) {
            wp_enqueue_script( 'wc-password-strength-meter' );
        }
    }
}

mylisting()->register( 'woocommerce', WooCommerce::instance() );

if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
    function woocommerce_template_loop_product_title() {
        echo '<h2 class="woocommerce-loop-product__title case27-secondary-text">' . get_the_title() . '</h2>';
    }
}