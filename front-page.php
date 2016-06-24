<?php
/**
 * Front page
 */
get_header(); ?>

<section class="container-fluid pv-xs-2 pv-lg-6 ph-lg-4 center-xs">
	<div class="wrapper slim">
		<h1>Engage your followers</h1>
		<p>Engage people who may have missed the original post; Post Promoter Pro allows you to customize the text that sits before the link to your content. Experiment with hashtags, a call to action, or interesting text that starts a conversation and compels your followers to view your post.</p>
	</div>

</section>

<section class="container-fluid pv-xs-2 ph-lg-4 pv-lg-4 highlight">
	<div class="wrapper wide">

		<div class="row middle-xs">

			<?php
			/**
			 * Supported integrations
			 */
			?>
			<div class="col-xs-12 col-lg-4">
				<img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/svgs/share.svg'; ?>" />
				<h2>Share to your favorite social networks.</h2>

				<p class="mb-xs-2 mb-lg-0">With built in support for Twitter, Facebook, and LinkedIn (and support for others on the way), you'll be able to reach your followers wherever they are.</p>
			</div>

			<div class="col-xs-12 col-lg-8">

				<div class="row table-row mb-xs-0 supported-integrations">

					<div class="col-xs-12 col-sm-4 col-lg-4 align-xs-center mb-xs-2 mb-lg-0 ph-xs-1">
						<div class="table-option twitter">

							<h3 class="table-header"><img src="<?php echo get_stylesheet_directory_uri() . '/svgs/logo-twitter.svg'; ?>" /><span>Twitter</span></h3>

							<ul>
								<li class="feature">1 Click Connect</li>
								<li class="feature">Featured Images</li>
								<li class="feature">Twitter Cards</li>
								<li class="feature">Author Retweets</li>
								<li class="feature">Scheduled Tweets</li>
							</ul>

						</div>
					</div>

					<div class="col-xs-12 col-sm-4 col-lg-4 align-xs-center mb-xs-2 mb-lg-0 ph-xs-1">

						<div class="table-option facebook">

							<h3 class="table-header"><img src="<?php echo get_stylesheet_directory_uri() . '/svgs/logo-facebook.svg'; ?>" /><span>Facebook</span></h3>

							<ul>
								<li class="feature">1 Click Connect</li>
								<li class="feature">Publish to Pages</li>
								<li class="feature">Featured Images</li>
								<li class="feature">Uses Native Link Sharing</li>
								<li class="feature">Scheduled Facebook Posts</li>
							</ul>

						</div>
					</div>

					<div class="col-xs-12 col-sm-4 col-lg-4 align-xs-center mb-xs-2 mb-lg-0 ph-xs-1">
						<div class="table-option linkedin">
							<h3 class="table-header"><img src="<?php echo get_stylesheet_directory_uri() . '/svgs/logo-linkedin.svg'; ?>" /><span>LinkedIn</span></h3>
							<ul>
								<li class="feature">1 Click Connect</li>
								<li class="feature">Featured Images</li>
								<li class="feature">Title &amp; Description Support</li>
								<li class="feature">Uses Native Link Sharing</li>
								<li class="feature">Scheduled LinkedIn Posts</li>
							</ul>

						</div>
					</div>


				</div>

			</div>
		</div>
	</div>
</section>


<section class="container-fluid pv-xs-2 pv-lg-4 ph-lg-4">
	<div class="wrapper wide">

		<div class="row middle-xs">

			<div class="col-xs-12 col-md-8">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/slide-1.png'; ?>" />
			</div>

			<div class="col-xs-12 col-md-4">
				<!-- <h2>Easily share to Twitter, Facebook and LinkedIn</h2> -->
				<img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/svgs/time-2.svg'; ?>" />
				<h2>Time is precious. </br>Have some back.</h2>

				<p class="mb-xs-0">No 3rd party services, or additional apps are needed. Schedule sharing to all your social networks right from within your WordPress admin. Since it's built in, Post Promtoer Pro just becomse part of your editorial flow.</p>
			</div>

		</div>


	</div>
</section>

<section class="container-fluid pv-xs-2 ph-lg-4">
	<div class="wrapper wide">

		<div class="row pv-xs-2 pv-sm-4 middle-xs">

			<div class="col-xs-12 col-sm-8">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/schedule-view.png'; ?>" />
			</div>

			<div class="col-xs-12 col-sm-4 first-xs">
				<img class="icon" src="<?php echo get_stylesheet_directory_uri() . '/svgs/calendar.svg'; ?>" />
				<h2>Easily see scheduled shares</h2>
				<p>Quickly view and manage all items you have scheduled to share. You can easiliy delete an item or choose to share it now if you wish.</p>
			</div>

		</div>


	</div>
</section>


<section class="container-fluid mb-xs-4" id="plus-more">
	<div class="wrapper wide">

		<h3 class="title-rule"><span>Plus More</span></h3>

		<div class="row center-xs">

			<div class="col-xs-12 col-md-4 col-lg-4">
				<h4><i class="fa fa-clock-o" aria-hidden="true"></i></h4>
				<h4>Quick and Easy Setup</h4>
				<p>No need to hastle with keys and tokens. Just install and sign into your social media accounts. Its that easy.</p>
			</div>

			<div class="col-xs-12 col-md-4 col-lg-4 ">
				<h4><i class="fa fa-life-ring" aria-hidden="true"></i></h4>
				<h4>World-class support</h4>
				<p>We're here to answer any Post Promoter Pro related questions you have with friendly, email-based support.</p>

			</div>

			<div class="col-xs-12 col-md-4 col-lg-4">
				<h4><i class="fa fa-code-fork" aria-hidden="true"></i></h4>
				<h4>Developer Friendly</h4>
				<p>This extensible plugin is built from the ground up, using WordPress actions and filters that allow you to adapt it for your specific needs.</p>
			</div>

		</div>
	</div>
</section>

<section class="container-fluid mb-xs-4 testimonials slider pv-xs-4">

	<div class="wrapper slim">

		<div class="js-flickity" data-flickity-options='{ "wrapAround": true, "prevNextButtons": false, "selectedAttraction": 0.2, "friction": 0.8 }'>
			<div class="gallery-cell ph-sm-8">
				<?php echo get_avatar('pippin@pippinsplugins.com', '96' ); ?>
				<blockquote>

					<p>If I can boost my site's traffic and engagement while also lessening my work load, I've done something right. Post Promoter Pro does exactly that by handling all of the scheduling and posting for me. I can't recommend it enough.</p>

					<footer>— Pippin Williamson, PippinsPlugins.com</footer>
				</blockquote>
			</div>
			<div class="gallery-cell ph-sm-8">
				<?php echo get_avatar('andrew@sumobi.com', '96' ); ?>
				<blockquote>
					<p>I’ve been using Post Promoter Pro since day one and have seen an instant boost in engagement and website traffic across posts shared to Twitter. This is an exceptional plugin and a definite must-have for your social media strategy.</p>
					<footer>— Andrew Munro, sumobi.com</footer>
				</blockquote>
			</div>
			<div class="gallery-cell ph-sm-8">
				<?php echo get_avatar('dgriffiths@section214.com', '96' ); ?>
				<blockquote>
					<p>The difference Post Promoter Pro has made in my site traffic and user engagement has been nothing short of astounding. I can't recommend it enough to anyone who wants to truly leverage their social media presence!.</p>
					<footer>—  Dan Griffiths, section214.com</footer>
				</blockquote>
			</div>
		</div>

	</div>


</section>


<?php
/**
 * Pricing table
 */
?>

<?php ppp_pricing_table(); ?>

<?php get_footer(); ?>
