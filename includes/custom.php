<?php

/**
 * Prepend home link to the primary navigation
 *
 * @since 1.0.0
*/
function ppp_wp_nav_menu_items( $items, $args ) {

    if ( 'primary' == $args->theme_location ) {
    	$home = ! is_front_page() ? ppp_nav_home() : '';
        return $home . $items;
    }

    return $items;

}
add_filter( 'wp_nav_menu_items', 'ppp_wp_nav_menu_items', 10, 2 );

/**
 * Prepend home link to main navigation
 *
 * @since 1.0.0
 */
function ppp_nav_home() {
	 ob_start();
	?>

	<li class="menu-item home">
		<a href="<?php echo site_url(); ?>">Home</a>
	</li>

	<?php $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }
