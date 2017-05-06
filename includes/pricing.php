<?php
/**
 * Pricing table
 */
function ppp_pricing_table( $blank_tab = false ) {

	$download_id = function_exists( 'ppp_get_download_id' ) ? ppp_get_download_id() : '';
	$checkout_url = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() : '';

	$download_url = add_query_arg( array( 'edd_action' => 'add_to_cart', 'download_id' => $download_id ), $checkout_url );

?>

	<section class="container-fluid pricing-table mb-xs-4" id="pricing">

		<div class="wrapper wide">

			<h1 class="align-xs-center mb-xs-4 mb-sm-7">Start sharing like a Pro</h1>
			<!-- <h3 class="hr-title"><span>Ready to get started?</span></h3> -->

			<div class="row pricing table-row mb-xs-2">

                                <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-2">
                                        <div class="table-option pv-xs-2">

                                                        <h2>Lifetime</h2>

                                                        <ul class="mb-xs-2">

                                                                <li class="pricing">
                                                                        <span class="price"><span class="currency">$</span>429</span>
                                                                </li>

                                                                <li class="feature"><strong>Unlimited sites</strong></li>
                                                                <li class="feature"><strong>Lifetime plugin updates</strong></li>
                                                                <li class="feature"><strong>Lifetime email support</strong></li>
                                                        </ul>

                                                        <div class="footer">
                                                                <a class="button" <?php echo $blank_tab ? 'target="_blank"' : ''; ?> href="<?php echo $download_url; ?>&amp;edd_options[price_id]=3">Purchase</a>
                                                        </div>

                                        </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-2 best-value">
                                        <div class="table-option pv-xs-2">
						<span>Most Popular</span>
                                                        <h2>Professional</h2>

                                                        <ul class="mb-xs-2">

                                                                <li class="pricing">
                                                                        <span class="price"><span class="currency">$</span>249</span>
                                                                </li>
								<li class="feature showcase">A $138 Savings<sup>&dagger;</sup></li>
                                                                <li class="feature"><strong>Up to 15 Sites</strong></li>
                                                                <li class="feature">Plugin updates*</li>
                                                                <li class="feature">Email support*</li>
                                                        </ul>

                                                        <div class="footer">
                                                                <a class="button" <?php echo $blank_tab ? 'target="_blank"' : ''; ?> href="<?php echo $download_url; ?>&amp;edd_options[price_id]=2">Sign Up</a>
                                                        </div>
                                        </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-2">

                                        <div class="table-option pv-xs-2">
                                                        <h2>Business</h2>

                                                        <ul class="mb-xs-2">
                                                                <li class="pricing">

                                                                        <span class="price">
                                                                                <span class="currency">$</span>129</span>
                                                                </li>

                                                                <li class="feature"><strong>Up to 5 Sites</strong></li>
                                                                <li class="feature">Plugin updates*</li>
                                                                <li class="feature">Email support*</li>
                                                        </ul>

                                                        <div class="footer">
                                                                <a class="button" <?php echo $blank_tab ? 'target="_blank"' : ''; ?> href="<?php echo $download_url; ?>&amp;edd_options[price_id]=1">Sign Up</a>
                                                        </div>
                                        </div>
                                </div>


				<div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-5 mb-sm-2">
					<div class="table-option pv-xs-2">

						<h2>Personal</h2>

						<ul class="mb-xs-2">
							<li class="pricing">
								<span class="price"><span class="currency">$</span>59</span>
							</li>
							<li class="feature"><strong>1 site</strong></li>
							<li class="feature">Plugin updates*</li>
							<li class="feature">Email support*</li>
						</ul>

						<div class="footer">
							<a class="button" <?php echo $blank_tab ? 'target="_blank"' : ''; ?> href="<?php echo $download_url; ?>&amp;edd_options[price_id]=0">Sign Up</a>
						</div>

					</div>
				</div>


			</div>

			<div class="row center-sm">
				<div class="col-xs-12">
					<p><small><sup>&dagger;</sup>When compared with the business plan<br />* Plugin updates and email support are provided for the duration of your current subscription.</small></p>
					<p><small>License keys automatically renew at a 30% discount from the purchase price. All purchases are subject to the terms and conditions of use.</small></p>
				</div>
			</div>

		</div>

	</section>

	<?php
}
