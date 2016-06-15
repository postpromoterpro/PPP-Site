<?php
/**
 * Template Name: Pricing
 */

get_header(); ?>

<?php /*
<header class="page-header<?php echo themedd_page_header_classes(); ?>">
	<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
</header>
*/ ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">

		<div class="wrapper wide">

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'template-parts/content', 'page' );


				if ( is_singular( 'attachment' ) ) {
					// Parent post navigation
					the_post_navigation( array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'themedd' ),
					) );
				}

				// End of the loop.
			endwhile;
			?>

			</div>

			<?php ppp_pricing_table(); ?>

		<div id="pricing-faqs" class="wrapper wide">
			<section class="container-fluid">

				<h2 class="center-sm mb-sm-4">Frequently asked questions</h2>

				<div class="row around-sm">

					<div class="col-xs-12 col-sm-6 mb-xs-2">
						<div class="box">
							<h4>How do I get updates?</h4>
							<p>Updates are performed in the WordPress admin, like most other plugins. All users with a valid license key will have access to these updates free of charge.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 mb-xs-2">
						<div class="box">
						<h4>Is there a refund policy?</h4>
						<p>Yes. The quality of our product and customer satisfaction are our top priorities. However, if for some reason you are unhappy with the plugin, we will refund 100% of your purchase. For more information you can view our <a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">Refund Policy</a>.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 mb-xs-2">
						<div class="box">
						<h4>Can I cancel my subscription?</h4>
						<p>Yes, your subscription can be cancelled at anytime from your account page. You will retain access to support and updates until your license key expires, one year from the purchase date.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 mb-xs-2">
						<div class="box">
						<h4>What if I need help?</h4>
						<p>You can contact us via our <a href="#">Support Form</a>. We believe a quality product should be backed by quality support!</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 mb-xs-2">
						<div class="box">
						<h4>Why do I have to renew my license?</h4>
						<p>Your license key is valid for one year from the purchase date. You need an active license key for continued access to automatic updates and support. License keys automatically renew at a 30% discount from the purchase price.</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 mb-xs-2">
						<div class="box">
						<h4>I’m interested but…</h4>
						<p>If you have any pre-sales questions please contact us via our <a href="<?php echo esc_url( site_url( 'support' ) ); ?>">Support Form</a>. We're here to help!</p>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 mb-sm-2">
					</div>
				</div>

			</section>
		</div>

	</main>



</div>

<?php get_footer(); ?>
