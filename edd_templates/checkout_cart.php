<?php
/**
 *  This template is used to display the Checkout page when items are in the cart
 */

global $post; ?>
<table id="edd_checkout_cart" <?php if ( ! edd_is_ajax_disabled() ) { echo 'class="ajaxed"'; } ?>>
	<thead>
		<tr class="edd_cart_header_row">
			<?php do_action( 'edd_checkout_table_header_first' ); ?>
			<th colspan="2" class="edd_cart_item_name"><?php _e( 'In your cart', 'easy-digital-downloads' ); ?></th>
			<?php do_action( 'edd_checkout_table_header_last' ); ?>
		</tr>
	</thead>
	<tbody>
		<?php $cart_items = edd_get_cart_contents(); ?>
		<?php do_action( 'edd_cart_items_before' ); ?>
		<?php if ( $cart_items ) : ?>
			<?php foreach ( $cart_items as $key => $item ) : ?>
				<tr class="edd_cart_item" id="edd_cart_item_<?php echo esc_attr( $key ) . '_' . esc_attr( $item['id'] ); ?>" data-download-id="<?php echo esc_attr( $item['id'] ); ?>">
					<?php do_action( 'edd_checkout_table_body_first', $item ); ?>
					<td class="edd_cart_item_name">
						<p class="edd_cart_item_details">
						<?php
							$price_id   = isset( $item['options']['price_id'] ) ? $item['options']['price_id'] : false;
							$item_title = edd_get_cart_item_name( $item );
							echo '<span class="edd_checkout_cart_item_title">' . esc_html( $item_title ) . '</span>';

							$item_prices = edd_get_variable_prices( $item['id'] );
							$description = '';

							if ( isset( $item_prices[ $price_id ]['description'] ) ) {
								$description = $item_prices[ $price_id ]['description'];
							}
							?>
							<span>
							<select data-download-id="<?php echo $item['id']; ?>" id="variable-price-switcher">
								<?php foreach ( $item_prices as $price_key => $price ) : ?>
									<option <?php selected( $price_key, $price_id, true ); ?> value="<?php echo $price_key; ?>"><?php echo $price['description']; ?></option>
								<?php endforeach; ?>
							</select>
							</span>
							<?php
							do_action( 'edd_checkout_cart_item_title_after', $item );
						?>
						</p>
						<p>
						<?php
						echo edd_cart_item_price( $item['id'], $item['options'] );
						do_action( 'edd_checkout_cart_item_price_after', $item );
						?>

						<?php do_action( 'edd_cart_actions', $item, $key ); ?>
						<a class="edd_cart_remove_item_btn" href="<?php echo esc_url( edd_remove_item_url( $key ) ); ?>"><?php _e( 'Remove', 'easy-digital-downloads' ); ?></a>
						</p>
					</td>
					<td>
						<span class="ppp-checkout-item-features"><i class="fa fa-check-circle" aria-hidden="true"></i> Instant plugin download</span>
						<?php if ( edd_recurring()->cart_contains_recurring() ) : ?>
						<span class="ppp-checkout-item-features"><i class="fa fa-check-circle" aria-hidden="true"></i> One year access to easy updates</span>
						<span class="ppp-checkout-item-features"><i class="fa fa-check-circle" aria-hidden="true"></i> One year of professional support</span>
						<span class="ppp-checkout-item-features"><i class="fa fa-check-circle" aria-hidden="true"></i> Renews yearly with hassle-free subscriptions</span>
						<?php else: ?>
						<span class="ppp-checkout-item-features"><i class="fa fa-check-circle" aria-hidden="true"></i> Lifetime access to updates</span>
						<span class="ppp-checkout-item-features"><i class="fa fa-check-circle" aria-hidden="true"></i> Lifetime access to support</span>
						<?php endif; ?>
					</td>
					<?php do_action( 'edd_checkout_table_body_last', $item ); ?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php do_action( 'edd_cart_items_middle' ); ?>
		<!-- Show any cart fees, both positive and negative fees -->
		<?php if( edd_cart_has_fees() ) : ?>
			<?php foreach( edd_get_cart_fees() as $fee_id => $fee ) : ?>
				<tr class="edd_cart_fee" id="edd_cart_fee_<?php echo $fee_id; ?>">

					<?php do_action( 'edd_cart_fee_rows_before', $fee_id, $fee ); ?>

					<td class="edd_cart_fee_label"><?php echo esc_html( $fee['label'] ); ?></td>
					<td class="edd_cart_fee_amount"><?php echo esc_html( edd_currency_filter( edd_format_amount( $fee['amount'] ) ) ); ?></td>
					<td>
						<?php if( ! empty( $fee['type'] ) && 'item' == $fee['type'] ) : ?>
							<a href="<?php echo esc_url( edd_remove_cart_fee_url( $fee_id ) ); ?>"><?php _e( 'Remove', 'easy-digital-downloads' ); ?></a>
						<?php endif; ?>

					</td>

					<?php do_action( 'edd_cart_fee_rows_after', $fee_id, $fee ); ?>

				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php do_action( 'edd_cart_items_after' ); ?>
	</tbody>
	<tfoot>

		<?php if( has_action( 'edd_cart_footer_buttons' ) ) : ?>
			<tr class="edd_cart_footer_row<?php if ( edd_is_cart_saving_disabled() ) { echo ' edd-no-js'; } ?>">
				<th colspan="<?php echo edd_checkout_cart_columns(); ?>">
					<?php do_action( 'edd_cart_footer_buttons' ); ?>
				</th>
			</tr>
		<?php endif; ?>

		<?php if( edd_use_taxes() && ! edd_prices_include_tax() ) : ?>
			<tr class="edd_cart_footer_row edd_cart_subtotal_row"<?php if ( ! edd_is_cart_taxed() ) echo ' style="display:none;"'; ?>>
				<?php do_action( 'edd_checkout_table_subtotal_first' ); ?>
				<th colspan="<?php echo edd_checkout_cart_columns(); ?>" class="edd_cart_subtotal">
					<?php _e( 'Subtotal', 'easy-digital-downloads' ); ?>:&nbsp;<span class="edd_cart_subtotal_amount"><?php echo edd_cart_subtotal(); ?></span>
				</th>
				<?php do_action( 'edd_checkout_table_subtotal_last' ); ?>
			</tr>
		<?php endif; ?>

		<?php if( edd_use_taxes() ) : ?>
			<tr class="edd_cart_footer_row edd_cart_tax_row"<?php if( ! edd_is_cart_taxed() ) echo ' style="display:none;"'; ?>>
				<?php do_action( 'edd_checkout_table_tax_first' ); ?>
				<th colspan="<?php echo edd_checkout_cart_columns(); ?>" class="edd_cart_tax">
					<?php _e( 'Tax', 'easy-digital-downloads' ); ?>:&nbsp;<span class="edd_cart_tax_amount" data-tax="<?php echo edd_get_cart_tax( false ); ?>"><?php echo esc_html( edd_cart_tax() ); ?></span>
				</th>
				<?php do_action( 'edd_checkout_table_tax_last' ); ?>
			</tr>

		<?php endif; ?>

	</tfoot>
</table>

<!-- Needs this for the stripe tokens -->
<div style="display: none;" class="edd_cart_total"><span class="edd_cart_amount" data-subtotal="<?php echo edd_get_cart_subtotal(); ?>" data-total="<?php echo edd_get_cart_total(); ?>"></span></div>

<div class="edd_cart_footer_row edd_cart_discount_row" <?php if( ! edd_cart_has_discounts() )  echo ' style="display:none;"'; ?>>
	<?php do_action( 'edd_checkout_table_discount_first' ); ?>
	<?php $discounts = edd_get_cart_discounts(); ?>
	<?php if ( ! empty( $discounts ) ) : ?>

		<?php foreach ( $discounts as $discount ) : ?>
			<?php
			$discount_id  = edd_get_discount_id_by_code( $discount );
			$rate         = edd_format_discount_rate( edd_get_discount_type( $discount_id ), edd_get_discount_amount( $discount_id ) );

			$remove_url   = add_query_arg(
				array(
					'edd_action'    => 'remove_cart_discount',
					'discount_id'   => $discount_id,
					'discount_code' => $discount
				),
				edd_get_checkout_uri()
			);
			?>

			<p class="edd-alert edd-alert-discount">
				<span class="edd_discount">
					<strong>Discount:</strong>&nbsp;
					<span class="edd_discount_rate"><?php echo $discount; ?>&nbsp;&ndash;&nbsp;<?php echo $rate; ?></span>
					<a href="<?php echo $remove_url; ?>" data-code="$discount" class="edd_discount_remove">Remove</a>
				</span>
			</p>

		<?php endforeach; ?>

	<?php endif; ?>
	<?php do_action( 'edd_checkout_table_discount_last' ); ?>
</tr>