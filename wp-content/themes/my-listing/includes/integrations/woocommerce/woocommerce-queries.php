<?php

namespace MyListing\Integrations\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Queries {

	public function __construct() {
		// Get products.
		add_action( "wp_ajax_c27_get_products", [ $this, 'get_products' ] );
		add_action( "wp_ajax_nopriv_c27_get_products", [ $this, 'get_products' ] );
	}

	public function get_products() {
		check_ajax_referer( 'c27_ajax_nonce', 'security' );

		if ( empty( $_POST['products'] ) || empty( $_POST['author_id'] ) ) {
			return false;
		}

		$products  = array_map( 'absint', (array) $_POST['products'] );
		$page      = absint( isset( $_POST['page'] ) ? $_POST['page'] : 0 );
		$author_id = absint( isset( $_POST['author_id'] ) ? $_POST['author_id'] : 0 );
		$per_page  = 9;
		$form_data = isset( $_POST['form_data'] ) ? $_POST['form_data'] : [];

		$args = [
			'order' => sanitize_text_field( isset($form_data['order']) ? $form_data['order'] : 'DESC' ),
			'offset' => $page * $per_page,
			'orderby' => sanitize_text_field( isset($form_data['orderby']) ? $form_data['orderby'] : 'date' ),
			'posts_per_page' => $per_page,
			'post_status' => 'publish',
			'post__in' => !empty($products) ? $products : [0],
			'post_type' => 'product',
            'author' => $author_id,
		];

		// dd($args);
		add_filter( 'loop_shop_columns', function() {
			return 3;
		} );

		$products = new \WP_Query($args);
		$response = [];

		ob_start();
		if ( $products->have_posts() ): ?>
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<div class="reveal">
					<?php wc_get_template_part( 'content', 'product' ) ?>
				</div>
			<?php endwhile ?>
		<?php else: ?>
			<div class="no-results-wrapper">
				<i class="no-results-icon material-icons">mood_bad</i>
				<li class="no_job_listings_found"><?php _e( 'There are no products matching your search.', 'my-listing' ) ?></li>
			</div>
		<?php endif;

		$response['html'] = ob_get_clean();
		$response['pagination'] = get_job_listing_pagination( $products->max_num_pages, ($page + 1) );
		$response['max_num_pages'] = $products->max_num_pages;
		$response['found_posts'] = $products->found_posts;

		wp_send_json($response);
	}
}

new Queries;