<?php

/**
 *
 * 10.00 becomes 10
 * 10.50 becomes 10.5
 *
 * @since 1.0
 */
function ppp_edd_download_price( $price, $download_id, $price_id ) {
	return floatval( $price );
}
add_filter( 'edd_download_price', 'ppp_edd_download_price', 10, 3 );


/**
 * Get ID of PPP based on title
 *
 * @since  1.0.0
 */
function ppp_get_download_id() {

	$download     = get_page_by_title( 'Post Promoter Pro', OBJECT, 'download' );
	$download_id  = $download->ID;

	if ( $download_id ) {
		return $download_id;
	}

	return false;
}

/**
 * Remove navigation on checkout
 *
 * @since 1.0.0
 */
function ppp_remove_checkout_nav() {

	if ( ! edd_is_checkout() ) {
		return;
	}

	remove_action( 'themedd_site_header_main', 'themedd_primary_menu' );
}
add_action( 'template_redirect', 'ppp_remove_checkout_nav' );

/**
 * Add the cart to the primary navigation
 */
function ppp_themedd_cart_link_position() {
	return 'primary_menu';
}
add_filter( 'themedd_cart_link_position', 'ppp_themedd_cart_link_position' );

/**
 * Turn cart icon count off since we're only selling 1 product
 */
add_filter( 'themedd_edd_cart_icon_count', '__return_false' );

/**
 * Show a full cart icon
 */
add_filter( 'themedd_edd_cart_icon_full', '__return_true' );

/**
 * Remove the primary navigation
 */
remove_action( 'site_header_main_end', 'themedd_primary_menu' );

/**
 * Add the primary navigation
 */
add_action( 'themedd_site_header_main', 'themedd_primary_menu' );

/**
 * Redirect to pricing page when cart is empty.
 *
 * @return void
 */
function ppp_empty_cart_redirect() {
	$cart     = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : false;
	$redirect = site_url( 'pricing' );

	if ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() && ! $cart ) {
		wp_redirect( $redirect, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'ppp_empty_cart_redirect' );


/**
 * Redirect to correct tab when profile is updated
 */
function rcp_edd_profile_updated( $user_id, $userdata ) {
	wp_safe_redirect( add_query_arg( 'updated', 'true', '#tabs=3' ) );
	exit;
}
add_action( 'edd_user_profile_updated', 'rcp_edd_profile_updated', 10, 2 );

/**
 * Remove the license keys column from the purchases tab
 */
remove_action( 'edd_purchase_history_row_end', 'edd_sl_site_management_links', 10 );
remove_action( 'edd_purchase_history_header_after', 'edd_sl_add_key_column' );

/**
 * Redirect to the second account tab when clicking the update payment method link
 */
function rcp_edd_subscription_update_url( $url, $object ) {

	$url = add_query_arg( array( 'action' => 'update', 'subscription_id' => $object->id ), '#tabs=1' );

	return $url;
}
add_filter( 'edd_subscription_update_url', 'rcp_edd_subscription_update_url', 10, 2 );


/**
 * Removes the "I acknowledge that by updating this subscription, the following subscriptions will also be updated to use this payment method for renewals: {download name}" message
 */
global $edd_recurring_stripe;
remove_action( 'edd_after_cc_fields', array( $edd_recurring_stripe, 'after_cc_fields'  ), 10 );

/**
 * Get the download URL of Post Promoter Pro, based on the user's purchase
 */
function ppp_edd_download_url( $download_id = 0 ) {

	// get user's current purchases
	$purchases = edd_get_users_purchases( get_current_user_id(), -1, false, 'complete' );

	$found_purchase_key = false;

	if ( $purchases ) {

		foreach ( $purchases as $key => $purchase ) {

			$payment_meta = edd_get_payment_meta( $purchase->ID );

			// get array of all downloads purchased
			$download_ids = wp_list_pluck( $payment_meta['downloads'], 'id' );

			// download found
			if ( in_array( $download_id, $download_ids ) ) {
				$found_purchase_key = $key;
				break;
			}

		}

		// get payment meta for the purchase containing the download
		if ( $found_purchase_key ) {
			$payment_meta = edd_get_payment_meta( $purchases[$found_purchase_key]->ID );
		}

		// get the download files for the download
		$download_files = edd_get_download_files( $download_id );

		if ( ! $download_files ) {
			// no download file exists
			return false;
		}

		// we want to retrieve the first download file attached
		$download_index = array_keys( $download_files );

		// build the download URL
		$download_url = edd_get_download_file_url( $payment_meta['key'], $payment_meta['user_info']['email'], $download_index[0], $download_id );

		if ( $download_url ) {
			return $download_url;
		}

	}

	return false;

}
