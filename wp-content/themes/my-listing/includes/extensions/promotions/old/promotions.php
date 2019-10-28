<?php

namespace CASE27\Integrations\PromotedListings;

class PromotedListings {

	use \MyListing\Src\Traits\Instantiatable;

	public function __construct() {

		\MyListing\Src\Dashboard_Pages::instance()->add_page( [
			'endpoint' => 'promotions',
			'title' => __( 'Promotions', 'my-listing' ),
			'template' => locate_template( 'includes/extensions/promotions/old/views/my-promotions.php' ),
			'show_in_menu' => true,
			'order' => 3,
		] );

		add_action( 'woocommerce_init', function() {
			require_once locate_template( 'includes/extensions/promotions/old/product.php' );
		} );

		// Handle actions.
		add_action( 'template_redirect', function() {
			if ( ! empty( $_GET['action'] ) && is_wc_endpoint_url( 'promotions' ) ) {
				$this->handle_action( sanitize_text_field( $_GET['action'] ) );
			}
		}, 500 );

		add_action( 'transition_post_status', function( $new_status, $old_status, $post ) {
			if ( $post->post_type === 'job_listing' && $old_status == 'publish' && $new_status != 'publish' ) {
				$keyID = get_post_meta( $post->ID, '_case27_listing_promotion_key_id', true );

				if ( $keyID && is_numeric( $keyID ) ) {
					$this->cancel_promotion( $post->ID, $keyID );
				}
			}
		}, 20, 3 );

		add_action( 'job_manager_job_dashboard_do_action_case27_promote', function() {
			if ( $listingID = absint( $_REQUEST['job_id'] ) ) {
				wp_safe_redirect( add_query_arg( 'listing_id', $listingID, wc_get_endpoint_url( 'promotions' ) ) );
				exit;
			}
		} );

		add_action( 'acf/save_post', function( $postID ) {
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'theme-integration-settings' ) {
				$promotionProduct = new PromotionProduct;
				$promotionProduct->c27_update_product();
			}
		}, 20 );

		add_filter( 'job_manager_duplicate_listing_ignore_keys', function( $keys ) {
			$keys[] = '_case27_listing_promotion_key_id';
			$keys[] = '_case27_listing_promotion_start_date';
			$keys[] = '_case27_listing_promotion_end_date';

			return $keys;
		});

		add_filter( 'job_manager_my_job_actions', [ $this, 'add_promote_listing_action' ], 10, 2 );
		add_action( 'mylisting/get-listings/before-query', [ $this, 'get_promoted_listings' ], 10, 3 );
		add_filter( 'mylisting/sections/listing-feed/args', [ $this, 'listing_feed_args' ], 30, 2 );
		add_filter( 'mylisting/preview-card/show-badge', [ $this, 'show_promoted_badge' ], 30, 3 );
	}

	public function handle_action( $action = '' ) {
		$listingID = ! empty( $_GET['listing_id'] ) ? absint( $_GET['listing_id'] ) : false;
		$keyID = ! empty( $_GET['key_id'] ) ? absint( $_GET['key_id'] ) : false;

		switch ($action) {
			case 'promote_listing':
				if ($listingID && $keyID && $this->promote_listing($listingID, $keyID)) {
					wc_add_notice( __( 'Listing was promoted successfully', 'my-listing' ), 'success' );
					wp_safe_redirect( wc_get_endpoint_url( 'my-listings' ) );
					exit;
				}
			break;

			case 'cancel_promotion':
				if ($listingID && $keyID && $this->cancel_promotion( $listingID, $keyID )) {
					wc_add_notice( __( 'Promotion got cancelled successfully.', 'my-listing' ), 'success' );
					wp_safe_redirect( wc_get_endpoint_url( 'promotions' ) );
					exit;
				}
			break;
		}
	}


	public function get_time_left( $key ) {
		$time = $key->get_meta( 'case27_time_left' );

		if ( $key->get_meta( 'case27_listing_promotion_applied' ) == 'yes' ) {
			$startDate = new \DateTime( get_post_meta( $key->get_meta( 'case27_listing_promotion_listing_id' ), '_case27_listing_promotion_start_date', true ) );
			$currentDate = new \DateTime( date( 'Y-m-d H:i:s' ) );
			$usedTime = $currentDate->getTimestamp() - $startDate->getTimestamp();
			$totalTime = absint( $key->get_meta( 'case27_time_left' ) );

			if ( $totalTime >= 1 && $usedTime >= 1 ) {
				$remainingTime = $totalTime - $usedTime;
				$time = $remainingTime >= 1 ? $remainingTime : 0;
			} else {
				$time = 0;
			}
		}

		return $time;
	}


	public function get_time_left_formatted( $key ) {
		$time = $this->get_time_left( $key );

		if ( absint( $time ) < 1 ) {
			return 'expired';
		}

		$from = new \DateTime( '@0' );
		$to = new \DateTime( '@' . $time );

		return $from->diff( $to )->format( '%a days %h hours %i minutes %s seconds' );
	}


	public function get_promotion_keys() {
		$orders = get_posts( [
			'post_type'   => 'shop_order',
			'post_status' => 'wc-completed',
			'numberposts' => -1,
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
		] );

		$keys = [];

		foreach ( $orders as $order_object ) {
			$order = new \WC_Order( $order_object->ID );
			$items = $order->get_items();

			foreach ( $items as $item ) {
				if (get_post_meta( $item->get_product_id(), 'case27_wc_product', true) !== 'listing_promotion') continue;
				if (absint( $item->get_meta( 'days' ) ) < 1) continue;
				if ((int) $item->get_quantity() !== 1) continue;

				$timeLeft = $item->get_meta( 'case27_time_left' );
				$days = absint( $item->get_meta( 'days' ) );

				// dump($timeLeft);

				if ( ! $timeLeft && $item->get_meta( 'case27_applied' ) != 'yes' ) {
					$item->update_meta_data( 'case27_time_left', $days * DAY_IN_SECONDS );
					$item->update_meta_data( 'case27_applied', 'yes' );
					$item->save_meta_data();
				}

				if ( $item->get_meta( 'case27_applied' ) == 'yes' && absint( $this->get_time_left( $item ) ) < 1 ) {
					$this->cancel_promotion( absint( $item->get_meta( 'case27_listing_promotion_listing_id' ) ), $item->get_id() );
					continue;
				}

				$keys[] = $item;
			}
		}

		return $keys;
	}


	public function get_listing( $listingID ) {
		if ( ! $listingID ) {
			return false;
		}

		$listing = is_numeric( $listingID ) ? get_post( $listingID ) : $listingID;

		if ( ! $listing ) {
			wc_add_notice( __( 'There was an error with the provided listing.', 'my-listing' ), 'error' );
			return false;
		}

		if ( (int) $listing->post_author && ((int) $listing->post_author !== (int) get_current_user_id()) && function_exists( 'wc_add_notice' ) ) {
			wc_add_notice( __( 'You don\'t have access to do that.', 'my-listing' ), 'error' );
			return false;
		}

		return $listing;
	}


	public function get_key( $keyID ) {
		if ( ! $keyID ) {
			return false;
		}

		$key = is_numeric( $keyID ) ? \WC_Order_Factory::get_order_item( $keyID ) : $keyID;

		if ( ! $key ) {
			wc_add_notice( __( 'There was an error with the provided key.', 'my-listing' ), 'error' );
			return false;
		}

		$keyOwner = (int) $key->get_order()->get_user_id();

		if ( $keyOwner && ( $keyOwner !== (int) get_current_user_id() ) ) {
			wc_add_notice( __( 'You don\'t have access to do that.', 'my-listing' ), 'error' );
			return false;
		}

		return $key;
	}


	public function promote_listing( $listingID, $keyID ) {
		if ( ! ( $listing = $this->get_listing( $listingID ) ) ) {
			return false;
		}

		if ( ! ( $key = $this->get_key( $keyID ) ) ) {
			return false;
		}

		if ( $listing->post_status !== 'publish' ) {
			wc_add_notice( __( 'Invalid listing.', 'my-listing' ), 'error' );
			return false;
		}

		if ( $key->get_meta( 'case27_listing_promotion_applied' ) === 'yes' ) {
			wc_add_notice( __( 'This key has already been applied to a listing.', 'my-listing' ), 'error' );
			return false;
		}

		$seconds = absint( $key->get_meta( 'case27_time_left' ) );

		if ( $seconds < 1 ) {
			wc_add_notice( __( 'Invalid key.', 'my-listing' ), 'error' );
			return false;
		}

		$listingOldPromotion = (int) get_post_meta( $listingID, '_case27_listing_promotion_key_id', true );

		if ( $listingOldPromotion && is_numeric( $listingOldPromotion ) ) {
			self::instance()->cancel_promotion( $listingID, $listingOldPromotion );
		}

		$startDate = date('Y-m-d H:i:s');
		$endDate = date('Y-m-d H:i:s', strtotime("+{$seconds} seconds"));

		if ( ! $startDate || ! $endDate ) {
			return false;
		}

		update_post_meta( $listingID, '_case27_listing_promotion_key_id', $keyID );
		update_post_meta( $listingID, '_case27_listing_promotion_start_date', $startDate );
		update_post_meta( $listingID, '_case27_listing_promotion_end_date', $endDate );
		$key->update_meta_data( 'case27_listing_promotion_applied', 'yes' );
		$key->update_meta_data( 'case27_listing_promotion_listing_id', $listingID );
		$key->save_meta_data();

		return true;
	}


	public function cancel_promotion( $listingID, $keyID ) {
		if ( ! ( $listing = $this->get_listing( $listingID ) ) ) {
			return false;
		}

		if ( ! ( $key = $this->get_key( $keyID ) ) ) {
			return false;
		}

		// Get listing start date.
		// Compare the current date how many days ahead of the start date it is.
		// That number subtract from the key's 'days' meta.
		// If the remaining number of days is 0 or less, just delete the meta key.
		try {
			$startDate = new \DateTime( get_post_meta( $listing->ID, '_case27_listing_promotion_start_date', true ) );
			$currentDate = new \DateTime( date( 'Y-m-d H:i:s' ) );
			$usedTime = $currentDate->getTimestamp() - $startDate->getTimestamp();
			$totalTime = absint( $key->get_meta( 'case27_time_left' ) );

			if ($totalTime >= 1 && $usedTime >= 1) {
				$remainingTime = $totalTime - $usedTime;

				if ($remainingTime >= 1) {
					$key->update_meta_data( 'case27_time_left', $remainingTime );
				} else {
					$key->delete_meta_data( 'case27_time_left' );
				}
			}

		} catch (\Exception $e) {
			wc_add_notice( __( 'Invalid listing.', 'my-listing' ), 'error' );
			// dump($e->getMessage());
			// $key->delete_meta_data( 'days' );
		}

		delete_post_meta( $listing->ID, '_case27_listing_promotion_key_id' );
		delete_post_meta( $listing->ID, '_case27_listing_promotion_start_date' );
		delete_post_meta( $listing->ID, '_case27_listing_promotion_end_date' );
		$key->delete_meta_data( 'case27_listing_promotion_applied' );
		$key->delete_meta_data( 'case27_listing_promotion_listing_id' );
		$key->save_meta_data();

		return true;
	}

	/**
	 * Add 'Promote' link in My Listings page in user dashboard.
	 *
	 * @since 1.0
	 */
	public function add_promote_listing_action( $actions, $listing ) {
		if ( $listing->post_status !== 'publish' || mylisting()->promotions()->version !== '1.0' ) {
			return $actions;
		}

		$new      = [];
		$promoted = absint( get_post_meta( $listing->ID, '_case27_listing_promotion_key_id', true ) );

		$new['case27_promote'] = [
			'label' => $promoted ? __( 'Promoted', 'my-listing' ) : __( 'Promote', 'my-listing' ),
			'nonce' => true,
		];

		return $new + $actions;
	}

	/**
	 * Display the promotion badge in listing preview card
	 * for eligible listings.
	 *
	 * @since 1.7.0
	 *
	 * @param bool                   $show_badge Whether to display the badge.
	 * @param \MyListing\Src\Listing $listing    Listing object
	 * @param array                  $data       Preview card settings array.
	 */
	public function show_promoted_badge( $show_badge, $listing, $data ) {
		if ( ! isset( $data['listing']->_c27_show_promoted_badge ) ) {
		    $data['listing']->_c27_show_promoted_badge = true;
		}

		if (
			$data['listing']->_c27_show_promoted_badge &&
			$listing->get_data( '_case27_listing_promotion_start_date' ) &&
			strtotime( $listing->get_data( '_case27_listing_promotion_start_date' ) ) &&
			$listing->get_data( '_case27_listing_promotion_end_date' ) &&
			strtotime( $listing->get_data( '_case27_listing_promotion_end_date' ) )
		) {
		    try {
		        $startDate   = new \DateTime( $listing->get_data( '_case27_listing_promotion_start_date' ) );
		        $endDate     = new \DateTime( $listing->get_data( '_case27_listing_promotion_end_date' ) );
		        $currentDate = new \DateTime( date( 'Y-m-d H:i:s' ) );

		        if ( $currentDate >= $startDate && $currentDate <= $endDate ) {
		            return true;
		        }
		    } catch (Exception $e) {}
		}

		return false;
	}

	/**
	 * Get promoted listings for Explore Listings query.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     \WP_Query args.
	 * @param obj   $type     Listing type object.
	 * @param array $response Array of contents that will be sent as Ajax json response.
	 */
	public function get_promoted_listings( &$args, &$type, &$response ) {
		$promoted_args = [
			'post_type'      => 'job_listing',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'rand',
			'meta_query'     => [ [
				'key'            => '_case27_listing_type',
				'value'          =>  $type->get_slug(),
				'compare'        => '='
			] ],
		];

		$promoted_args[ 'meta_query' ][] = $this->promoted_only_clause();

		$promoted_listings = ! empty( $promoted_args ) ? new \WP_Query( $promoted_args ) : false;
		$promoted_ids      = [];
		$listing_wrap      = ! empty( $_POST['listing_wrap'] ) ? sanitize_text_field( $_POST['listing_wrap'] ) : '';

		ob_start();

		if ( $promoted_listings && $promoted_listings->have_posts() ) {
			while ( $promoted_listings->have_posts() ) {
				$promoted_listings->the_post();

				global $post;
				$post->c27_options__wrap_in = $listing_wrap;

				get_job_manager_template_part( 'content', 'job_listing' );

				$promoted_ids[] = absint( get_the_ID() );
			}

			wp_reset_postdata();
		}

		$response['promoted_html'] = ob_get_clean();
		$response['promoted_ids']  = $promoted_ids;
	}

	/**
	 * Get the SQL for showing only promoted listings.
	 *
	 * @since 1.0
	 */
	public function promoted_only_clause() {
		return [
			'relation' => 'AND',
			[
				'key' => '_case27_listing_promotion_start_date',
				'value' => date('Y-m-d H:i:s'),
				'compare' => '<=',
				'type' => 'DATETIME',
			],
			[
				'key' => '_case27_listing_promotion_end_date',
				'value' => date('Y-m-d H:i:s'),
				'compare' => '>=',
				'type' => 'DATETIME',
			],
		];
	}

	/**
	 * Get the SQL for hiding promoted listings.
	 *
	 * @since 1.0
	 */
	public function hide_promoted_clause() {
		return [
			'relation' => 'OR',
			[
				'key' => '_case27_listing_promotion_start_date',
				'value' => date('Y-m-d H:i:s'),
				'compare' => '>',
				'type' => 'DATETIME',
			],
			[
				'key' => '_case27_listing_promotion_end_date',
				'value' => date('Y-m-d H:i:s'),
				'compare' => '<',
				'type' => 'DATETIME',
			],
			[
				'key' => '_case27_listing_promotion_end_date',
				'compare' => 'NOT EXISTS',
			],
		];
	}

	/**
	 * Filter 'listing-feed' widget args to make the
	 * 'Listing behavior' setting functional.
	 *
	 * @since 1.7.0
	 *
	 * @param array $args \WP_Query args.
	 * @param array $data Array of section settings.
	 */
	public function listing_feed_args( $args, $data ) {
		if ( $data['behavior'] === 'show_promoted_first' ) {
			//
		}

		if ( $data['behavior'] === 'show_promoted_only' ) {
			$args['meta_query']['c27_promoted_only_clause'] = $this->promoted_only_clause();
		}

		if ( $data['behavior'] === 'hide_promoted' ) {
			$args['meta_query']['c27_hide_promoted_clause'] = $this->hide_promoted_clause();
		}

		return $args;
	}
}

PromotedListings::instance();

