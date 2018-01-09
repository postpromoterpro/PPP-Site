<?php
/**
 * http://hilios.github.io/jQuery.countdown/
 *
 * Thanks, Andrew!
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue scripts.
 *
 * @since 1.4.7
 *
 * @return void
 */
function eddwp_theme_enqueue_countdown_scripts() {

	// Register countdown script.
	wp_register_script( 'countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown.min.js', array( 'jquery' ) );
	wp_register_script( 'moment-timezone', get_stylesheet_directory_uri() . '/js/moment-timezone-with-data.min.js', array() );
	wp_register_script( 'moment', get_stylesheet_directory_uri() . '/js/moment.min.js', array() );

	// Only enqueue script if a sale notice is published.
	if ( eddwp_theme_sale_notice_active() ) {
		wp_enqueue_script( 'moment' );
		wp_enqueue_script( 'moment-timezone' );
		wp_enqueue_script( 'countdown' );
	}

}
add_action( 'wp_enqueue_scripts', 'eddwp_theme_enqueue_countdown_scripts' );

/**
 * Determine if a sale notice is active (published)
 *
 * @since 1.4.7
 *
 * @return boolean $found true if found, false otherwise
 */
function eddwp_theme_sale_notice_active() {

	$args = array(
		'posts_per_page'   => -1,
		'meta_key'         => 'eddwp_notice_is_sale',
		'meta_value'       => true,
		'post_type'        => 'notices',
		'post_status'      => 'publish',
	);

	$posts = get_posts( $args );

	$found = false;

	if ( $posts ) {
		foreach ( $posts as $post ) {
			if ( 'publish' === $post->post_status && get_post_meta( $post->ID, '_enabled', true ) ) {
				$found = true;
			}
		}
	}

	return $found;

}


/**
 * Add a [countdown] shortcode
 *
 * @since 1.4.7
 *
 * @return $content
 */
function eddwp_theme_countdown_shortcode( $atts, $content = null ) {

	$atts = shortcode_atts(
		array(
			'end' => '',
		),
		$atts,
		'countdown'
	);

	$end_date = isset( $atts['end'] ) ? $atts['end'] : false;

	if ( ! $end_date ) {
		return $content;
	}

	// Bail if countdown script hasn't been enqueued.
	if ( ! wp_script_is( 'countdown', 'enqueued' ) ) {
		return $content;
	}

	$content = eddwp_theme_get_countdown( $end_date );

	return $content;
}
add_shortcode( 'countdown', 'eddwp_theme_countdown_shortcode' );


/**
 * Get the countdown timer
 *
 * @since 1.4.7
 *
 * @return string
 */
function eddwp_theme_get_countdown( $end_date = '' ) {

	if ( empty( $end_date ) ) {
		return;
	}

	ob_start();
	?>
	<span id="countdown"><span id="countdown-text">Sale ends in </span><span id="countdown-date"></span></span><script type="text/javascript">

		var endDate = moment.tz("<?php echo $end_date; ?>", "America/Chicago");

		jQuery('#countdown-date').countdown( endDate.toDate() ).on('update.countdown', function(event) {

			var format = '%H:%M:%S';

			if ( event.offset.totalDays > 0 ) {
				format = '%-d day%!d ' + format;
			}

			if ( event.offset.weeks > 0 ) {
				format = '%-w week%!w ' + format;
			}

			jQuery(this).html(event.strftime(format));

		}).on('finish.countdown', function(event) {
			jQuery('#notification-area').hide();
		});
	</script>

	<?php
	return ob_get_clean();
}


/**
 * Add a metabox to the notices post type
 *
 * @since  1.4.7
 */
function eddwp_theme_notices_add_meta_box() {
	add_meta_box( 'eddwp_theme_sale_notice', 'Sale Notice', 'eddwp_theme_notices_sale_meta_box', array( 'notices' ), 'side', 'default' );
}
add_action( 'add_meta_boxes', 'eddwp_theme_notices_add_meta_box' );


/**
 * Add the meta box
 *
 * @since  1.4.7
 */
function eddwp_theme_notices_sale_meta_box( $post ) {

	$is_sale_notice = get_post_meta( $post->ID, 'eddwp_notice_is_sale', true );

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'eddwp_theme_sale_notice_nonce', 'eddwp_theme_sale_notice_nonce' );

	?>
	<p>	<input type="checkbox" name="eddwp_notice_is_sale" id="eddwp-notice-is-sale" value="1" <?php echo checked( $is_sale_notice, 1 ); ?>/>
		<label for="eddwp-notice-is-sale">This is a sale notice</label>
	</p>

	<?php
}


/**
 * Save post meta when the save_post action is called
 *
 * @since  1.4.7
 * @param  int $post_id
 * @global array $post All the data of the the current post
 * @return void
 */
function eddwp_theme_notices_save_meta_box( $post_id, $post ) {

	/**
	 * We need to verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['eddwp_theme_sale_notice_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['eddwp_theme_sale_notice_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'eddwp_theme_sale_notice_nonce' ) ) {
		return $post_id;
	}

	// If this is an autosave, our form has not been submitted,
	// so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( 'notices' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

	}

	// OK, its safe for us to save the data now.

	$is_sale_notice = isset( $_POST['eddwp_notice_is_sale'] ) ? sanitize_text_field( $_POST['eddwp_notice_is_sale'] ) : '';

	if ( $is_sale_notice ) {
		// Update post meta.
		update_post_meta( $post_id, 'eddwp_notice_is_sale', true );
	} else {
		// Delete post meta.
		delete_post_meta( $post_id, 'eddwp_notice_is_sale' );
	}

}
// Save metabox.
add_action( 'save_post', 'eddwp_theme_notices_save_meta_box', 10, 2 );
