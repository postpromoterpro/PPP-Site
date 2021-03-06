<?php
/**
 * Constants
 *
 * @since 1.0
 */
if ( ! defined( 'PPP_INCLUDES_DIR' ) ) {
	define( 'PPP_INCLUDES_DIR', trailingslashit( get_stylesheet_directory() ) . 'includes' ); /* Sets the path to the theme's includes directory. */
}

if ( ! defined( 'PPP_THEME_VERSION' ) ) {
	define( 'PPP_THEME_VERSION', '1.0' );
}

/**
 * Setup
 *
 * @since 1.0
 */
function ppp_setup() {

	add_post_type_support( 'page', 'excerpt' );

	require_once( trailingslashit( PPP_INCLUDES_DIR ) . 'pricing.php' );
	require_once( trailingslashit( PPP_INCLUDES_DIR ) . 'custom.php' );
	require_once( trailingslashit( PPP_INCLUDES_DIR ) . 'countdown.php' );

	// EDD functions
	if ( function_exists( 'themedd_is_edd_active' ) && themedd_is_edd_active() ) {
		require_once( trailingslashit( PPP_INCLUDES_DIR ) . 'edd-functions.php' );
	}


}
add_action( 'after_setup_theme', 'ppp_setup' );

/**
 * Footer links
 *
 * @since 1.0.0
 */
function ppp_footer_menu() {
?>

<section class="container-fluid footer-links">
	<div class="footer-wrapper wide">
		<div class="row">

			<div class="col-xs-12 col-sm-6">
				<h4>Post Promoter Pro</h4>
				<ul>
					<li><a href="<?php echo site_url( 'affiliates' ); ?>">Affiliates</a></li>
					<li><a href="<?php echo site_url( 'account' ); ?>">Account</a></li>
					<li><a href="#changelog" id="ppp-changelog" class="popup-content download-meta-link" data-effect="mfp-move-from-bottom">Changelog</a></li>
					<li><a href="<?php echo esc_url( site_url('privacy-policy') ); ?>">Privacy Policy</a></li>
					<li><a href="https://github.com/postpromoterpro/post-promoter-pro" target="_blank">GitHub</a></li>
				</ul>
			</div>

			<div class="col-xs-12 col-sm-6">

				<div class="newsletter-wrap">
					<h4>Register for the email list</h4>
					<!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
					<form action="//postpromoterpro.us2.list-manage.com/subscribe/post?u=7e77a38f4cffdf200e065cb42&amp;id=508ef9398e" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div id="mc_embed_signup_scroll">
					<div class="mc-field-group">
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address *">&nbsp;
						<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
					</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_7e77a38f4cffdf200e065cb42_508ef9398e" tabindex="-1" value=""></div>
						</div>
					</form>
					</div>
					<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
					<!--End mc_embed_signup-->
				</div>

			</div>

		</div>

		<div id="changelog" class="popup entry-content mfp-with-anim mfp-hide">
			<h1>Changelog</h1>
			<?php echo ppp_get_changelog(); ?>
		</div>
	</div>
</section>

<?php
}
add_action( 'themedd_footer_before_site_info', 'ppp_footer_menu' );

/**
 * Get changelog
 */
function ppp_get_changelog() {

	// Check for transient, if none, grab remote HTML file
	if ( false === ( $html = get_transient( 'ppp_changelog' ) ) ) {

		// Get remote HTML file
		$response = wp_remote_get( 'https://postpromoterpro.com/downloads/post-promoter-pro/?changelog=1' );

		// Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}

		// Parse remote HTML file
		$data = wp_remote_retrieve_body( $response );

		// Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}

		// Store remote HTML file in transient, expire after 24 hours
		set_transient( 'ppp_changelog', $data, 24 * HOUR_IN_SECONDS );

	}

	if ( $html ) {
		return stripslashes_deep( $html );
	} else {
		return stripslashes_deep( $data );
	}

}

/**
 * Changelog
 *
 * @since 1.0.0
 */
function ppp_changelog() {

	?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {

			$('#ppp-changelog').magnificPopup({
				type: 'inline',
				fixedContentPos: true,
				fixedBgPos: true,
				overflowY: 'scroll',
				closeBtnInside: true,
				preloader: false,
				callbacks: {
					beforeOpen: function() {
					this.st.mainClass = this.st.el.attr('data-effect');
					}
				},
				midClick: true,
				removalDelay: 300
			});

		});
	</script>

	<?php
}
add_action( 'wp_footer', 'ppp_changelog', 100 );

/**
 * Typekit
 *
 * @since 1.0
 */
function ppp_typekit() {
	?>
<script src="https://use.typekit.net/bkk7eei.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<?php
}
add_action( 'wp_head', 'ppp_typekit' );

/**
 * Load our new site logo
 *
 * @since 1.0.0
 */
function ppp_header_logo() {

	if ( ! is_front_page() ) {
		return;
	}

	?>

	<div class="hero">

		<?php do_action( 'themedd_hero_start' ); ?>

		<section class="container-fluid">
			<div class="wrapper wide">
				<div class="row">

					<div class="col-xs-12 col-sm-12 col-lg-12 pv-sm-5 aligncenter">

						<h1 class="ph-lg-5 mb-xs-2">
							The easiest social network auto poster for WordPress
						</h1>

						<!--<p class="intro">You write great content, but it can get lost in the fast-moving world of social media. Post Promoter Pro makes sure your content is seen.</p>-->
						<p class="intro">Schedule all your social media shares, right from within WordPress.</p>


<div id="cta">
	<a href="#content" class="scroll button large mb-xs-2" style="background-color:#8D4AAD;border: 1px solid #8D4AAD;">Learn More</a>
	<a href="/pricing" class="button large mb-xs-2">Get Started</a>
	<svg version="1.1" id="like-this" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="128.068px" height="45.865px" viewBox="0 0 128.068 45.865" enable-background="new 0 0 128.068 45.865"
	 xml:space="preserve">
<g id="text">
	<path fill="#FFFFFF" d="M15.496,6.624c0.697,0,1.458-0.855,2.028-1.553c0.127-0.159,0.159-0.38,0.159-0.57
		c0-0.317-0.063-0.697-0.38-1.046c-0.222-0.253-0.824-0.412-1.331-0.412c-0.666,0-1.236,0.159-1.553,0.539
		c-0.285,0.349-0.412,0.888-0.412,1.331c0,0.349,0.063,0.761,0.222,1.078C14.387,6.275,14.862,6.624,15.496,6.624z"/>
	<path fill="#FFFFFF" d="M25.446,24.815c-1.395-0.57-1.68-0.919-2.599-2.187c-0.285-0.38-1.553-3.011-1.743-3.613
		c-0.507-1.647-0.666-1.965-0.666-2.187c0-0.126,0.032-0.285,0.222-0.412c1.68-1.109,3.455-2.282,5.071-3.645
		c0.38-0.317,0.38-0.507,0.888-0.951c0.634-0.539,1.426-1.648,1.426-2.124c0-0.126-0.159-0.317-0.571-0.57
		c-0.412-0.253-0.57-0.285-0.855-0.285s-0.634,0.095-0.951,0.317c-0.222,0.158-0.412,0.317-0.634,0.666
		c-1.3,2.06-3.36,3.518-5.388,4.754c-0.158,0.095-0.285,0.158-0.38,0.158c-0.063,0-0.095-0.031-0.095-0.095s0.032-0.159,0.095-0.285
		c1.109-2.567,1.933-5.229,3.422-7.67c0.159-0.253,0.19-0.412,0.792-1.236c0.507-0.697,0.951-1.299,0.951-2.219
		c0-0.443-0.412-0.792-1.172-0.887c-0.761-0.095-0.792-0.127-1.046-0.127c-0.159,0-0.349,0.19-0.507,0.603l-0.349,0.824
		c-2.52,5.979-5.302,11.878-7.387,17.92c-0.415,0.03-0.671,0.198-1.358,0.684c-1.268,0.887-1.616,1.077-2.313,1.077
		c-0.539,0-0.571-0.729-0.571-1.015c0-0.475,0.222-1.68,0.761-3.105c0.444-1.173,1.331-3.328,1.87-4.5
		c0.729-1.553,2.028-2.346,2.028-4.025c0-0.285-0.095-0.38-0.253-0.507C13.912,9.983,13.5,9.92,13.183,9.92
		c-0.602,0-1.268,0.19-1.584,0.855c-1.173,2.44-2.092,4.722-3.074,7.036c-0.19,0.443-0.317,0.982-0.539,1.585
		c-0.11,0.313-0.194,0.588-0.265,0.849c-1.322,0.457-2.699,2.694-3.949,3.461c-0.158,0.096-0.349,0.127-0.539,0.127
		c-0.285,0-0.539-0.095-0.634-0.38C2.472,23.041,2.44,22.66,2.44,22.28c0-1.395,0.697-2.599,1.205-3.898
		c1.87-4.944,5.197-9.191,8.082-13.85c0.19-0.317,0.317-0.697,0.317-1.109c0-0.317-0.063-0.602-0.253-0.887
		c-0.159-0.222-0.507-0.349-0.824-0.349c-0.349,0-0.602,0.063-1.046,0.063c-1.236,0-1.426,1.775-1.965,2.694
		c-2.409,4.12-5.229,9.191-6.592,12.741C0.666,19.491,0,20.949,0,22.407c0,0.38,0.032,0.729,0.095,1.077
		c0.317,1.743,2.947,2.44,3.169,2.44c1.901,0,3.109-1.46,4.315-2.93c0.02,0.1,0.029,0.2,0.057,0.3
		c0.349,1.172,1.426,2.503,2.377,2.503c1.323,0,2.422-0.788,3.106-1.382c0,0.006-0.002,0.014-0.002,0.02
		c0,0.95,0.951,1.014,1.109,1.014c0.349,0,0.539-0.095,0.792-0.095c0.666,0,0.951-1.521,1.078-2.187
		c0.349-1.965,1.078-3.867,1.775-5.547c0.032-0.095,0.095-0.126,0.126-0.126c0.063,0,0.159,0.031,0.254,0.253
		c0.412,0.951,1.014,3.296,2.82,6.593c0.19,0.316,0.412,0.475,0.602,0.634c0.127,0.095,0.286,0.253,0.571,0.538
		c0.507,0.508,1.236,0.919,2.44,0.919c0.412,0,0.602-0.095,0.76-0.349c0.127-0.189,0.666-0.38,0.666-0.792
		C26.111,24.688,25.826,24.975,25.446,24.815z"/>
	<path fill="#FFFFFF" d="M38.153,18.414c-0.127,0-0.285,0-0.634,0.222c-1.902,1.204-3.233,2.916-5.419,4.088
		c-1.426,0.761-1.902,0.888-2.44,0.888c-0.317,0-0.634-0.063-0.982-0.254c-0.285-0.158-0.761-0.823-0.761-1.331
		c0-0.095,0.032-0.158,0.19-0.253c2.694-1.489,5.166-4.247,7.353-6.72c0.444-0.507,0.697-0.855,1.014-1.489
		c0.38-0.761,0.729-1.458,0.729-2.282c0-1.268-0.666-1.838-1.014-1.965c-0.634-0.222-1.078-0.349-1.934-0.349
		c-1.553,0-2.852,0.856-3.391,1.426c-2.408,2.567-4.563,5.356-5.451,8.589c-0.127,0.443-0.159,0.761-0.159,1.046
		c0,0.602,0.159,1.807,0.38,2.44c0.349,1.046,0.951,1.838,1.584,2.187c0.222,0.127,1.331,0.634,2.028,0.888
		c0.507,0.189,0.824,0.222,1.205,0.222c0.412,0,0.57,0,1.141-0.317c4.817-2.662,5.483-4.246,7.004-5.546
		c0.158-0.127,0.158-0.316,0.158-0.443c0-0.096,0.032-0.127,0.032-0.412C38.787,18.73,38.343,18.414,38.153,18.414z M33.05,11.6
		c0.317-0.285,0.285-0.19,0.634-0.412c0.285-0.19,0.476-0.285,0.666-0.285c0.19,0,0.19,0.126,0.19,0.38
		c0,0.57-0.254,0.982-0.571,1.458c-0.412,0.634-0.285,0.729-0.76,1.299c-1.426,1.711-2.979,3.456-4.849,4.881
		c-0.095,0.063-0.159,0.095-0.222,0.095c-0.031,0-0.063-0.031-0.063-0.158C28.772,16.037,30.99,13.438,33.05,11.6z"/>
	<path fill="#FFFFFF" d="M63.913,14.071c0.571-0.982,0.951-1.616,0.951-2.535c0-0.222-0.254-0.507-0.476-0.602
		c-0.253-0.095-0.855-0.222-1.173-0.222c-0.158,0-0.443,0.063-0.729,0.159S62.044,11.124,61.6,11.6
		c-2.313,2.503-4.627,5.229-7.194,8.811c-0.158,0.222-0.189,0.254-0.222,0.254c-0.063,0-0.063-0.032-0.063-0.063
		s0.032-0.095,0.285-0.634c2.377-5.04,4.881-11.505,7.733-15.435c0.254-0.349,0.317-0.507,0.603-0.856
		c0.823-1.014,1.489-1.521,1.489-2.345c0-0.412-0.063-0.57-0.285-0.792c-0.254-0.253-0.603-0.475-0.888-0.475
		C62.899,0.063,62.709,0,62.393,0c-0.317,0-0.634,0.063-0.824,0.444c-1.553,3.105-3.328,6.021-4.659,8.684
		c-0.524,1.041-1.026,2.044-1.514,3.029c-0.07,0.02-0.165,0.065-0.292,0.141c-1.046,0.634-2.852,1.299-4.246,1.584
		c-0.317,0.063-0.697,0.127-0.793,0.127c-0.063,0-0.126-0.032-0.126-0.095c0-0.095,0.411-1.299,0.729-1.965
		c1.014-2.155,2.535-4.311,2.947-6.782c0.032-0.19,0.032-0.285,0.032-0.349c0-0.095-0.127-0.159-0.285-0.222
		c-0.381-0.158-0.92-0.253-1.205-0.253c-0.316,0-0.38,0.159-0.887,0.159c-0.127,0-0.159,0-0.349,0.412
		c-1.078,2.314-1.934,4.786-2.694,6.719c-0.254,0.666-0.412,1.141-0.507,1.489c-0.063,0.285-0.254,0.444-0.539,0.444
		c-0.57,0-1.362-0.507-2.06-0.507c-0.285,0-0.443,0.063-0.634,0.159c-0.253,0.127-0.38,0.19-0.38,0.412c0,0.095,0,0.253,0.159,0.38
		c0.729,0.602,0.919,1.426,2.06,1.997c0.127,0.063,0.158,0.126,0.158,0.19s-0.031,0.127-0.063,0.222
		c-1.014,2.441-1.584,5.199-2.376,7.543c-0.095,0.285-0.127,0.697-0.127,0.951c0,0.285,0.095,0.57,0.349,0.761
		c0.253,0.189,0.761,0.349,1.141,0.349c0.126,0,0.349-0.032,0.476-0.096c0.443-0.222,0.76-1.046,0.792-1.331
		c0.19-1.585,1.268-4.278,1.458-5.324c0.063-0.349,0.253-0.666,0.349-1.015c0.127-0.475,0.285-1.078,0.538-1.521
		c0.127-0.222,0.317-0.38,0.603-0.476c0.597-0.199,2.814-0.703,4.387-1.239c-1.382,2.946-2.487,5.661-3.088,8.243
		c-0.127,0.539-0.285,0.507-0.285,0.855c0,0.096,0.031,0.254,0.126,0.349c0.508,0.508,1.49,0.888,1.648,0.888
		c0.443,0,0.888-0.222,1.204-0.412c0.158-0.095,0.19-0.127,0.349-0.316c1.87-2.188,4.057-5.863,6.212-8.336
		c0.222-0.253,0.349-0.349,0.412-0.349c0.031,0,0.063,0.032,0.063,0.063c0,0.063-0.032,0.158-0.127,0.38
		c-0.381,0.919-0.761,1.87-1.173,3.264s-0.602,2.567-0.602,3.55c0,1.553,0.507,2.567,1.711,3.011
		c0.507,0.19,0.729,0.222,0.919,0.222c0.412,0,0.729-0.158,1.109-0.253c0.222-0.063,0.507-0.222,0.603-0.444
		c0.062-0.158,0.158-0.285,0.158-0.411c0-0.096-0.096-0.223-0.222-0.254c-0.254-0.063-0.603-0.095-0.793-0.19
		c-0.475-0.253-0.792-0.57-0.792-2.092c0-2.155,0.792-4.754,1.648-6.782C63.343,15.402,63.47,14.832,63.913,14.071z"/>
	<path fill="#FFFFFF" d="M72.024,6.624c0.697,0,1.458-0.855,2.028-1.553c0.127-0.159,0.158-0.38,0.158-0.57
		c0-0.317-0.063-0.697-0.38-1.046c-0.222-0.253-0.824-0.412-1.331-0.412c-0.666,0-1.236,0.159-1.553,0.539
		c-0.285,0.349-0.412,0.888-0.412,1.331c0,0.349,0.063,0.761,0.222,1.078C70.915,6.275,71.391,6.624,72.024,6.624z"/>
	<path fill="#FFFFFF" d="M79.502,10.649c-0.665-0.697-1.362-1.141-3.105-1.141c-0.603,0-1.901,0.57-2.82,2.028
		c-0.761,1.204-1.142,3.011-1.142,3.866c0,0.634,0.57,5.389,1.015,7.48c0.158,0.792,0.158,0.855,0.158,0.982
		s-0.127,0.253-0.317,0.253c-0.158,0-0.316-0.063-0.634-0.349c-0.453-0.408-0.773-0.896-1.066-1.4
		c0.01-0.049,0.022-0.096,0.022-0.153c0-0.127,0-0.285-0.19-0.443c-0.065-0.055-0.153-0.094-0.246-0.128
		c-0.179-0.315-0.364-0.627-0.58-0.918c-0.285-0.381-0.57-0.443-1.204-0.443c-0.666,0-1.142,0.696-1.142,1.172
		c0,0.096,0.096,0.317,0.19,0.476c0.112,0.187,0.232,0.372,0.355,0.556c-0.989,0.679-1.341,0.839-1.969,0.839
		c-0.539,0-0.57-0.729-0.57-1.015c0-0.475,0.222-1.68,0.761-3.105c0.443-1.173,1.331-3.328,1.869-4.5
		c0.729-1.553,2.028-2.346,2.028-4.025c0-0.285-0.095-0.38-0.253-0.507c-0.223-0.19-0.634-0.253-0.951-0.253
		c-0.603,0-1.268,0.19-1.585,0.855c-1.172,2.44-2.092,4.722-3.074,7.036c-0.189,0.443-0.316,0.982-0.538,1.585
		c-0.381,1.077-0.508,1.774-0.508,2.567c0,0.443,0.032,0.887,0.159,1.331c0.349,1.172,1.426,2.503,2.377,2.503
		c1.426,0,2.599-0.919,3.264-1.521l0.238-0.221c0.832,0.879,1.827,1.633,3.024,2.122c0.159,0.063,0.508,0.127,0.793,0.127
		c0.855,0,1.426-0.571,1.996-1.142c0.127-0.127,0.254-0.316,0.254-0.57c0-1.299-0.729-4.849-1.015-7.226
		c-0.063-0.413-0.222-1.839-0.222-2.029c0-0.38,0.032-0.603,0.063-0.824c0.254-1.458,1.711-3.264,1.934-3.264
		c0.253,0,0.57,0.222,0.697,0.443c0.126,0.222,0.222,0.603,0.222,0.856c0,0.539-0.254,0.982-0.539,1.458
		c-0.063,0.095-0.095,0.19-0.095,0.253c0,0.475,0.189,0.792,0.476,1.014c0.222,0.19,0.76,0.412,1.108,0.412
		c0.159,0,0.19-0.032,0.444-0.349c0.443-0.571,0.919-1.426,0.919-2.631C80.104,12.075,79.946,11.124,79.502,10.649z"/>
</g>
<g id="arrow">
	<path fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
		M114.724,42.708l7.844,2.157c-1.607-7.249-10.25-26.958-28.5-26.958"/>

		<line fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="127.068" y1="35.615" x2="122.568" y2="44.865"/>
</g>
</svg>



</div>


					</div>

				</div>
			</div>

			<div class='chart'>



				<svg version="1.1" id="graphs" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="100%" height="auto" viewBox="3.097 94.591 1400 452.445" enable-background="new 3.097 94.591 1400 452.445"
					 xml:space="preserve">

					<g class="dataset"  id="dataset-1">


					   <polygon fill="#50E3C2" points="1203.098,250.445 1003.097,282.445 803.097,335.445 603.097,325.445 403.097,385.445
						   203.097,419.445 3.097,463.445 3.097,547.036 703.097,547.036 1403.098,547.036 1403.098,168.445" style="fill: #4ab9ad;" />
					</g>

					<g class="dataset"  id="dataset-2">
					  <polygon fill="#21A6EE" points="1203.098,479.445 1003.097,433.924 803.097,386.445 603.097,467.445 403.097,424.445
						  203.097,320.813 3.097,448.445 3.097,547.036 703.097,547.036 1403.098,547.036 1403.098,384.445" style="fill: #008DFF;" />
				   </g>


				   <g class="dataset" id="dataset-3">

					 <polygon fill="#807CCC" points="1203.098,363.445 1003.097,433.924 803.097,445.445 603.097,419.445 403.097,359.445
						 203.097,475.445 3.097,495.445 3.097,547.036 703.097,547.036 1403.098,547.036 1403.098,443.445 " style="fill: #8D4AAD;" />
				  </g>

				</svg>

			</div>

		</section>

		<script>
		(function () {
			var load_chart;
			load_chart = function () {
				jQuery('body').removeClass('loaded');
				return setTimeout(function () {
					return jQuery('body').addClass('loaded');
				}, 500);
			};
			load_chart();
		}.call(this));
		</script>



	</div>

	<?php

}
add_action( 'themedd_header', 'ppp_header_logo', 11 );

/**
 * Move header
 */
function ppp_move_header() {

	if ( ! is_front_page() ) {
		return;
	}

	remove_action( 'themedd_header', 'themedd_header' );
	add_action( 'themedd_hero_start', 'themedd_header' );
}
add_action( 'template_redirect', 'ppp_move_header' );

/**
 * Remove navigation on EDD checkout
 */
function ppp_remove_header() {

	if ( ! ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) ) {
		return;
	}

	remove_action( 'themedd_masthead', 'themedd_navigation' );

}
add_action( 'template_redirect', 'ppp_remove_header' );

/**
 * Load our site logo
 *
 * @since 1.0
 */
function ppp_site_branding() {

	?>

	<svg id="ppp-logo" width="100%" height="100%" viewBox="0 0 40 55" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
		<g id="logo">

				<path class="piece p3" d="M34.134,27.361C34.134,37.06 29.082,45.602 21.47,50.492L25.695,54.717C34.335,48.686 40,38.673 40,27.361C40,16.045 34.332,6.03 25.687,0L21.462,4.225C29.078,9.114 34.134,17.658 34.134,27.361Z" style="fill:white;fill-rule:nonzero;"/>


				<path class="piece p2" d="M24.772,27.361C24.772,34.519 20.597,40.667 14.555,43.577L18.932,47.954C25.938,43.763 30.639,36.102 30.639,27.362C30.639,18.619 25.934,10.954 18.924,6.765L14.602,11.087C20.619,14.033 24.772,20.221 24.772,27.361Z" style="fill:white;fill-rule:nonzero;"/>


				<path class="p1"  d="M0.843,50.624C0.972,50.656 1.1,50.689 1.23,50.719C1.449,50.77 1.669,50.817 1.89,50.862C1.995,50.883 2.101,50.903 2.207,50.923C2.388,50.957 2.57,50.989 2.753,51.019C2.833,51.032 2.912,51.046 2.992,51.059C3.242,51.098 3.495,51.131 3.748,51.162C3.828,51.172 3.908,51.181 3.989,51.19C4.229,51.217 4.47,51.241 4.712,51.26C4.743,51.262 4.774,51.266 4.805,51.268C5.076,51.289 5.348,51.304 5.621,51.315C5.69,51.318 5.758,51.32 5.827,51.323C6.104,51.333 6.382,51.339 6.661,51.339C6.73,51.339 6.798,51.337 6.867,51.336L6.867,45.37L6.867,41.652C14.71,41.541 21.058,35.23 21.058,27.361C21.058,19.423 14.6,12.964 6.661,12.964C4.259,12.964 1.994,13.559 0,14.604L0,50.392C0.166,50.44 0.332,50.49 0.5,50.535C0.614,50.566 0.728,50.595 0.843,50.624ZM6.866,18.836C11.475,18.946 15.191,22.727 15.191,27.361C15.191,31.996 11.475,35.776 6.866,35.886L6.866,18.836Z" style="fill:white;fill-rule:nonzero;"/>

		</g>
	</svg>

	<svg id="ppp-logo-text" width="100%" height="100%" viewBox="0 0 164 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
		<g transform="matrix(2.45459,0,3.18405e-32,2.45459,-453.926,-387.03)">
			<path d="M184.916,165.68L186.164,165.68L186.164,162.62L186.848,162.62C188.312,162.62 188.96,161.468 188.96,160.148C188.96,158.828 188.312,157.676 186.848,157.676L184.916,157.676L184.916,165.68ZM187.676,160.148C187.676,160.952 187.352,161.516 186.728,161.516L186.164,161.516L186.164,158.78L186.728,158.78C187.352,158.78 187.676,159.332 187.676,160.148Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M191.3,165.824C192.74,165.824 193.328,164.372 193.328,162.776C193.328,161.18 192.74,159.74 191.3,159.74C189.86,159.74 189.26,161.18 189.26,162.776C189.26,164.372 189.86,165.824 191.3,165.824ZM191.3,164.828C190.616,164.828 190.436,163.844 190.436,162.776C190.436,161.72 190.616,160.736 191.3,160.736C191.984,160.736 192.164,161.72 192.164,162.776C192.164,163.844 191.984,164.828 191.3,164.828Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M193.784,165.08C194.156,165.548 194.744,165.824 195.536,165.824C196.532,165.824 197.288,165.152 197.288,164.168C197.288,163.004 196.52,162.56 195.872,162.188C195.416,161.924 195.032,161.684 195.032,161.264C195.032,160.916 195.308,160.64 195.716,160.64C196.148,160.64 196.544,160.868 196.772,161.168L197.252,160.412C196.856,159.992 196.304,159.74 195.692,159.74C194.612,159.74 193.976,160.436 193.976,161.3C193.976,162.428 194.72,162.848 195.344,163.22C195.812,163.496 196.22,163.736 196.22,164.204C196.22,164.648 195.884,164.924 195.44,164.924C194.984,164.924 194.576,164.66 194.276,164.3L193.784,165.08Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M199.412,165.824C199.808,165.824 200.108,165.704 200.3,165.512L200.036,164.648C199.952,164.756 199.82,164.828 199.676,164.828C199.424,164.828 199.34,164.636 199.34,164.24L199.34,160.868L200.096,160.868L200.096,159.884L199.34,159.884L199.34,158.3L198.212,158.3L198.212,159.884L197.648,159.884L197.648,160.868L198.212,160.868L198.212,164.444C198.212,165.38 198.56,165.824 199.412,165.824Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M202.844,165.68L204.092,165.68L204.092,162.62L204.776,162.62C206.24,162.62 206.888,161.468 206.888,160.148C206.888,158.828 206.24,157.676 204.776,157.676L202.844,157.676L202.844,165.68ZM205.604,160.148C205.604,160.952 205.28,161.516 204.656,161.516L204.092,161.516L204.092,158.78L204.656,158.78C205.28,158.78 205.604,159.332 205.604,160.148Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M207.656,165.68L208.784,165.68L208.784,161.684C209.012,161.228 209.42,160.844 209.864,160.844C209.936,160.844 210.02,160.856 210.104,160.88L210.104,159.752C209.552,159.752 209.036,160.172 208.784,160.736L208.784,159.884L207.656,159.884L207.656,165.68Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M212.564,165.824C214.004,165.824 214.592,164.372 214.592,162.776C214.592,161.18 214.004,159.74 212.564,159.74C211.124,159.74 210.524,161.18 210.524,162.776C210.524,164.372 211.124,165.824 212.564,165.824ZM212.564,164.828C211.88,164.828 211.7,163.844 211.7,162.776C211.7,161.72 211.88,160.736 212.564,160.736C213.248,160.736 213.428,161.72 213.428,162.776C213.428,163.844 213.248,164.828 212.564,164.828Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M220.448,165.68L221.576,165.68L221.576,161.036C221.576,160.1 221.108,159.74 220.412,159.74C219.848,159.74 219.272,160.208 219.044,160.712C218.972,160.064 218.528,159.74 217.916,159.74C217.364,159.74 216.8,160.208 216.584,160.664L216.584,159.884L215.456,159.884L215.456,165.68L216.584,165.68L216.584,161.576C216.728,161.18 217.064,160.736 217.46,160.736C217.796,160.736 217.952,160.964 217.952,161.408L217.952,165.68L219.08,165.68L219.08,161.576C219.224,161.18 219.56,160.736 219.956,160.736C220.28,160.736 220.448,160.94 220.448,161.408L220.448,165.68Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M224.468,165.824C225.908,165.824 226.496,164.372 226.496,162.776C226.496,161.18 225.908,159.74 224.468,159.74C223.028,159.74 222.428,161.18 222.428,162.776C222.428,164.372 223.028,165.824 224.468,165.824ZM224.468,164.828C223.784,164.828 223.604,163.844 223.604,162.776C223.604,161.72 223.784,160.736 224.468,160.736C225.152,160.736 225.332,161.72 225.332,162.776C225.332,163.844 225.152,164.828 224.468,164.828Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M228.74,165.824C229.136,165.824 229.436,165.704 229.628,165.512L229.364,164.648C229.28,164.756 229.148,164.828 229.004,164.828C228.752,164.828 228.668,164.636 228.668,164.24L228.668,160.868L229.424,160.868L229.424,159.884L228.668,159.884L228.668,158.3L227.54,158.3L227.54,159.884L226.976,159.884L226.976,160.868L227.54,160.868L227.54,164.444C227.54,165.38 227.888,165.824 228.74,165.824Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M229.976,162.776C229.976,164.54 230.708,165.824 232.16,165.824C232.796,165.824 233.396,165.476 233.816,164.888L233.228,164.276C232.964,164.672 232.604,164.9 232.268,164.9C231.476,164.9 231.092,164.168 231.08,163.148L233.972,163.148L233.972,162.752C233.972,161.072 233.408,159.74 232.016,159.74C230.636,159.74 229.976,161.096 229.976,162.776ZM231.98,160.664C232.7,160.664 232.868,161.588 232.868,162.344L231.08,162.344C231.08,161.648 231.26,160.664 231.98,160.664Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M234.776,165.68L235.904,165.68L235.904,161.684C236.132,161.228 236.54,160.844 236.984,160.844C237.056,160.844 237.14,160.856 237.224,160.88L237.224,159.752C236.672,159.752 236.156,160.172 235.904,160.736L235.904,159.884L234.776,159.884L234.776,165.68Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M239.84,165.68L241.088,165.68L241.088,162.62L241.772,162.62C243.236,162.62 243.884,161.468 243.884,160.148C243.884,158.828 243.236,157.676 241.772,157.676L239.84,157.676L239.84,165.68ZM242.6,160.148C242.6,160.952 242.276,161.516 241.652,161.516L241.088,161.516L241.088,158.78L241.652,158.78C242.276,158.78 242.6,159.332 242.6,160.148Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M244.652,165.68L245.78,165.68L245.78,161.684C246.008,161.228 246.416,160.844 246.86,160.844C246.932,160.844 247.016,160.856 247.1,160.88L247.1,159.752C246.548,159.752 246.032,160.172 245.78,160.736L245.78,159.884L244.652,159.884L244.652,165.68Z" style="fill:white;fill-rule:nonzero;"/>
			<path d="M249.56,165.824C251,165.824 251.588,164.372 251.588,162.776C251.588,161.18 251,159.74 249.56,159.74C248.12,159.74 247.52,161.18 247.52,162.776C247.52,164.372 248.12,165.824 249.56,165.824ZM249.56,164.828C248.876,164.828 248.696,163.844 248.696,162.776C248.696,161.72 248.876,160.736 249.56,160.736C250.244,160.736 250.424,161.72 250.424,162.776C250.424,163.844 250.244,164.828 249.56,164.828Z" style="fill:white;fill-rule:nonzero;"/>
		</g>
	</svg>

	<?php
}
add_action( 'themedd_site_branding_before_site_title', 'ppp_site_branding' );

/**
 * Show refund policy link
 */
function ppp_show_refund_policy_link() {

	ob_start();
	?>

	- <a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">see our refund policy</a>

	<?php

	return ob_get_clean();
}

/**
 * Embed the refund policy
 */
function ppp_embed_refund_policy() {

	// only show the refund policy on the homepage and the pricing page
	if ( ! ( is_page( 'pricing' ) || is_front_page() ) ) {
		return;
	}

	$refund_policy = get_page_by_title( 'refund policy' );

	if ( ! $refund_policy ) {
		return;
	}

	?>
	<div id="refund-policy" class="popup entry-content mfp-with-anim mfp-hide">
		<h1>
			<?php echo $refund_policy->post_title; ?>
		</h1>

		<?php echo stripslashes( wpautop( $refund_policy->post_content, true ) ); ?>
	</div>
	<?php
}
add_action( 'wp_footer', 'ppp_embed_refund_policy' );

/**
 * Enqueue scripts
 *
 * @since  1.0
 */
function ppp_enqueue_scripts() {

	// in addition to the parent theme's JS we load our own
	wp_register_script( 'ppp-js', get_stylesheet_directory_uri() . '/js/post-promoter-pro.min.js', array( 'jquery' ), PPP_THEME_VERSION, true );
	wp_enqueue_script( 'ppp-js' );

	wp_register_script( 'font-awesome', 'https://use.fontawesome.com/eec832792c.js', array(), PPP_THEME_VERSION );
	wp_enqueue_script( 'font-awesome' );

	wp_enqueue_script( 'jquery-ui-tabs' );

	wp_enqueue_style( 'dashicons' );

	// load jQuery UI + tabs for account page
	if ( is_page( 'account' ) ) {
		wp_enqueue_script( 'jquery-ui-core' );

		if ( class_exists( 'EDD_Software_Licensing' ) ) {
			wp_register_style( 'edd-sl-styles', plugins_url( '/css/edd-sl.css', EDD_SL_PLUGIN_FILE ), false, EDD_SL_VERSION );
			wp_enqueue_style( 'edd-sl-styles' );
		}

	}

}
add_action( 'wp_enqueue_scripts', 'ppp_enqueue_scripts' );

/**
 * Disable jetpack carousel comments
 */
function ppp_remove_comments_on_attachments( $open, $post_id ) {

	$post = get_post( $post_id );

	if ( $post->post_type == 'attachment' ) {
		return false;
	}

	return $open;

}
add_filter( 'comments_open', 'ppp_remove_comments_on_attachments', 10 , 2 );

/**
 * Stripe uses it's own credit card form because the card details are tokenized.
 *
 * We don't want the name attributes to be present on the fields in order to prevent them from getting posted to the server
 *
 * @access      public
 * @since       1.7.5
 * @return      void
 */
function ppp_stripe_credit_card_form( $echo = true ) {

	global $edd_options;

	ob_start(); ?>

	<?php if ( ! wp_script_is ( 'stripe-js' ) ) : ?>
		<?php edd_stripe_js( true ); ?>
	<?php endif; ?>

	<?php do_action( 'edd_before_cc_fields' ); ?>

	<fieldset id="edd_cc_fields" class="edd-do-validate">
		<legend><?php _e( 'Credit Card Info', 'edds' ); ?></legend>
		<?php if( is_ssl() ) : ?>
			<div id="edd_secure_site_wrapper">
				<span class="dashicons dashicons-lock"></span>
				<span>This is a secure checkout form</span>
			</div>
		<?php endif; ?>
		<p id="edd-card-number-wrap">
			<input type="tel" pattern="[0-9]{13,16}" autocomplete="off" <?php if ( isset( $edd_options['stripe_js_fallback'] ) ) { echo 'name="card_number" '; } ?>id="card_number" class="card-number edd-input required" placeholder="<?php _e( 'Card number', 'edds' ); ?>" />
		</p>
		<p id="edd-card-cvc-wrap">
			<input type="tel" pattern="[0-9]{3,4}" autocomplete="off" <?php if ( isset( $edd_options['stripe_js_fallback'] ) ) { echo 'name="card_cvc" '; } ?>id="card_cvc" class="card-cvc edd-input required" placeholder="<?php _e( 'Security code', 'edds' ); ?>" />
		</p>
		<p id="edd-card-name-wrap">
			<input type="text" autocomplete="off" <?php if ( isset( $edd_options['stripe_js_fallback'] ) ) { echo 'name="card_name" '; } ?>id="card_name" class="card-name edd-input required" placeholder="<?php _e( 'Card name', 'edds' ); ?>" />
		</p>
		<?php do_action( 'edd_before_cc_expiration' ); ?>
		<p class="card-expiration">
			<label for="card_exp_month" class="edd-label">
				Card Expiration
			</label>
			<select <?php if ( isset( $edd_options['stripe_js_fallback'] ) ) { echo 'name="card_exp_month" '; } ?>id="card_exp_month" class="card-expiry-month edd-select edd-select-small required">
				<?php for( $i = 1; $i <= 12; $i++ ) { echo '<option value="' . $i . '">' . sprintf ('%02d', $i ) . '</option>'; } ?>
			</select>
			<span class="exp-divider"> / </span>
			<select <?php if ( isset( $edd_options['stripe_js_fallback'] ) ) { echo 'name="card_exp_year" '; } ?>id="card_exp_year" class="card-expiry-year edd-select edd-select-small required">
				<?php for( $i = date('Y'); $i <= date('Y') + 30; $i++ ) { echo '<option value="' . $i . '">' . substr( $i, 2 ) . '</option>'; } ?>
			</select>
		</p>
		<?php do_action( 'edd_after_cc_expiration' ); ?>
                <p id="edd-card-zip-wrap">
                        <input type="text" size="4" name="card_zip" class="card-zip edd-input<?php if( edd_field_is_required( 'card_zip' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Zip / Postal Code', 'easy-digital-downloads' ); ?>" value=""<?php if( edd_field_is_required( 'card_zip' ) ) {  echo ' required '; } ?>/>
                </p>
                <p id="edd-card-country-wrap">
                        <label for="billing_country" class="edd-label">
                                <?php _e( 'Billing Country', 'easy-digital-downloads' ); ?>
                                <?php if( edd_field_is_required( 'billing_country' ) ) { ?>
                                        <span class="edd-required-indicator">*</span>
                                <?php } ?>
                        </label>
                        <select name="billing_country" id="billing_country" class="billing_country edd-select<?php if( edd_field_is_required( 'billing_country' ) ) { echo ' required'; } ?>"<?php if( edd_field_is_required( 'billing_country' ) ) {  echo ' required '; } ?>>
                                <?php

                                $selected_country = edd_get_shop_country();

                                $countries = edd_get_country_list();
                                foreach( $countries as $country_code => $country ) {
                                  echo '<option value="' . esc_attr( $country_code ) . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
                                }
                                ?>
                        </select>
                </p>

	</fieldset>
	<?php
	do_action( 'edd_after_cc_fields' );

	$form = ob_get_clean();

	if ( false !== $echo ) {
		echo $form;
	}

	return $form;
}
//remove_action( 'edd_stripe_cc_form', 'edds_credit_card_form' );
// add_action( 'edd_stripe_cc_form', 'ppp_stripe_credit_card_form' );

function ppp_user_info_fields() {

	$customer = EDD()->session->get( 'customer' );
	$customer = wp_parse_args( $customer, array( 'first_name' => '', 'last_name' => '', 'email' => '' ) );

	if( is_user_logged_in() ) {
		$user_data = get_userdata( get_current_user_id() );
		foreach( $customer as $key => $field ) {

			if ( 'email' == $key && empty( $field ) ) {
				$customer[ $key ] = $user_data->user_email;
			} elseif ( empty( $field ) ) {
				$customer[ $key ] = $user_data->$key;
			}

		}
	}

	$customer = array_map( 'sanitize_text_field', $customer );
	?>
	<fieldset id="edd_checkout_user_info">
		<legend><?php echo apply_filters( 'edd_checkout_personal_info_text', __( 'Personal Info', 'easy-digital-downloads' ) ); ?></legend>
		<?php do_action( 'edd_purchase_form_before_email' ); ?>
		<p id="edd-email-wrap">
			<input class="edd-input required" type="email" name="edd_email" placeholder="<?php _e( 'Email address', 'easy-digital-downloads' ); ?>" id="edd-email" value="<?php echo esc_attr( $customer['email'] ); ?>"/>
		</p>
		<?php do_action( 'edd_purchase_form_after_email' ); ?>
		<p id="edd-first-name-wrap">
			<input class="edd-input required" type="text" name="edd_first" placeholder="<?php _e( 'First name', 'easy-digital-downloads' ); ?>" id="edd-first" value="<?php echo esc_attr( $customer['first_name'] ); ?>"<?php if( edd_field_is_required( 'edd_first' ) ) {  echo ' required '; } ?>/>
		</p>
		<p id="edd-last-name-wrap">
			<input class="edd-input<?php if( edd_field_is_required( 'edd_last' ) ) { echo ' required'; } ?>" type="text" name="edd_last" id="edd-last" placeholder="<?php _e( 'Last name', 'easy-digital-downloads' ); ?>" value="<?php echo esc_attr( $customer['last_name'] ); ?>"<?php if( edd_field_is_required( 'edd_last' ) ) {  echo ' required '; } ?>/>
		</p>
		<?php do_action( 'edd_purchase_form_user_info' ); ?>
		<?php do_action( 'edd_purchase_form_user_info_fields' ); ?>
	</fieldset>
	<?php
}
remove_action( 'edd_purchase_form_after_user_info', 'edd_user_info_fields' );
remove_action( 'edd_register_fields_before', 'edd_user_info_fields' );
add_action( 'edd_purchase_form_after_user_info', 'ppp_user_info_fields' );
add_action( 'edd_register_fields_before', 'ppp_user_info_fields' );

function ppp_default_cc_address_fields() {
	return;
	$logged_in = is_user_logged_in();
	$customer  = EDD()->session->get( 'customer' );
	$customer  = wp_parse_args( $customer, array( 'address' => array(
		'line1'   => '',
		'line2'   => '',
		'city'    => '',
		'zip'     => '',
		'state'   => '',
		'country' => ''
	) ) );

	$customer['address'] = array_map( 'sanitize_text_field', $customer['address'] );

	if( $logged_in ) {

		$user_address = get_user_meta( get_current_user_id(), '_edd_user_address', true );

		foreach( $customer['address'] as $key => $field ) {

			if ( empty( $field ) && ! empty( $user_address[ $key ] ) ) {
				$customer['address'][ $key ] = $user_address[ $key ];
			} else {
				$customer['address'][ $key ] = '';
			}

		}

	}

	ob_start(); ?>
	<fieldset id="edd_cc_address" class="cc-address">
		<legend><?php _e( 'Billing Details', 'easy-digital-downloads' ); ?></legend>
		<?php do_action( 'edd_cc_billing_top' ); ?>
		<p id="edd-card-address-wrap">
			<input type="text" id="card_address" name="card_address" class="card-address edd-input<?php if( edd_field_is_required( 'card_address' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Address line 1', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['line1']; ?>"<?php if( edd_field_is_required( 'card_address' ) ) {  echo ' required '; } ?>/>
		</p>
		<p id="edd-card-address-2-wrap">
			<input type="text" id="card_address_2" name="card_address_2" class="card-address-2 edd-input<?php if( edd_field_is_required( 'card_address_2' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Address line 2', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['line2']; ?>"<?php if( edd_field_is_required( 'card_address_2' ) ) {  echo ' required '; } ?>/>
		</p>
		<p id="edd-card-city-wrap">
			<input type="text" id="card_city" name="card_city" class="card-city edd-input<?php if( edd_field_is_required( 'card_city' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'City', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['city']; ?>"<?php if( edd_field_is_required( 'card_city' ) ) {  echo ' required '; } ?>/>
		</p>
		<p id="edd-card-zip-wrap">
			<input type="text" size="4" name="card_zip" class="card-zip edd-input<?php if( edd_field_is_required( 'card_zip' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Zip / Postal Code', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['zip']; ?>"<?php if( edd_field_is_required( 'card_zip' ) ) {  echo ' required '; } ?>/>
		</p>
		<p id="edd-card-country-wrap">
			<label for="billing_country" class="edd-label">
				<?php _e( 'Billing Country', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'billing_country' ) ) { ?>
					<span class="edd-required-indicator">*</span>
				<?php } ?>
			</label>
			<select name="billing_country" id="billing_country" class="billing_country edd-select<?php if( edd_field_is_required( 'billing_country' ) ) { echo ' required'; } ?>"<?php if( edd_field_is_required( 'billing_country' ) ) {  echo ' required '; } ?>>
				<?php

				$selected_country = edd_get_shop_country();

				if( ! empty( $customer['address']['country'] ) && '*' !== $customer['address']['country'] ) {
					$selected_country = $customer['address']['country'];
				}

				$countries = edd_get_country_list();
				foreach( $countries as $country_code => $country ) {
				  echo '<option value="' . esc_attr( $country_code ) . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
				}
				?>
			</select>
		</p>
		<p id="edd-card-state-wrap">
			<label for="card_state" class="edd-label">
				<?php _e( 'Billing State / Province', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'card_state' ) ) { ?>
					<span class="edd-required-indicator">*</span>
				<?php } ?>
			</label>
			<?php
			$selected_state = edd_get_shop_state();
			$states         = edd_get_shop_states( $selected_country );

			if( ! empty( $customer['address']['state'] ) ) {
				$selected_state = $customer['address']['state'];
			}

			if( ! empty( $states ) ) : ?>
			<select name="card_state" id="card_state" class="card_state edd-select<?php if( edd_field_is_required( 'card_state' ) ) { echo ' required'; } ?>">
				<?php
					foreach( $states as $state_code => $state ) {
						echo '<option value="' . $state_code . '"' . selected( $state_code, $selected_state, false ) . '>' . $state . '</option>';
					}
				?>
			</select>
			<?php else : ?>
			<?php $customer_state = ! empty( $customer['address']['state'] ) ? $customer['address']['state'] : ''; ?>
			<input type="text" size="6" name="card_state" id="card_state" class="card_state edd-input" value="<?php echo esc_attr( $customer_state ); ?>" placeholder="<?php _e( 'State / Province', 'easy-digital-downloads' ); ?>"/>
			<?php endif; ?>
		</p>
		<?php do_action( 'edd_cc_billing_bottom' ); ?>
	</fieldset>
	<?php
	echo ob_get_clean();
}
// remove_action( 'edd_after_cc_fields', 'edd_default_cc_address_fields' );
// add_action( 'edd_after_cc_fields', 'ppp_default_cc_address_fields' );

function ppp_payment_mode_select() {
	$gateways = edd_get_enabled_payment_gateways( true );
	$page_URL = edd_get_current_page_url();
	do_action('edd_payment_mode_top'); ?>
	<?php if( edd_is_ajax_disabled() ) { ?>
	<form id="edd_payment_mode" action="<?php echo $page_URL; ?>" method="GET">
	<?php } ?>
		<fieldset id="edd_payment_mode_select">
			<legend>Payment Method</legend>
			<?php do_action( 'edd_payment_mode_before_gateways_wrap' ); ?>
			<div id="edd-payment-mode-wrap">
				<?php

				do_action( 'edd_payment_mode_before_gateways' );
				?>
				<label for="edd-gateway-paypalexpress" class="edd-gateway-option edd-gateway-option-selected" id="edd-gateway-option-paypalexpress">
					<span class="payment-type"><input type="radio" name="payment-mode" class="edd-gateway" id="edd-gateway-paypalexpress" value="paypalexpress" checked="checked" />PayPal <i class="fa fa-cc-paypal" aria-hidden="true"></i></span>
					<span class="card-info">Pay quickly and securly with PayPal</span>
				</label>
				<label for="edd-gateway-stripe" class="edd-gateway-option" id="edd-gateway-option-stripe">
					<span class="payment-type"><input type="radio" name="payment-mode" class="edd-gateway" id="edd-gateway-stripe" value="stripe" />Credit Card <i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>
					<span class="card-info">Use your Visa, Mastercard, AMEX, or Discover</span>
				</label>
				<?php
				do_action( 'edd_payment_mode_after_gateways' );

				?>
			</div>
			<?php do_action( 'edd_payment_mode_after_gateways_wrap' ); ?>
		</fieldset>
		<fieldset id="edd_payment_mode_submit" class="edd-no-js">
			<p id="edd-next-submit-wrap">
				<?php echo edd_checkout_button_next(); ?>
			</p>
		</fieldset>
	<?php if( edd_is_ajax_disabled() ) { ?>
	</form>
	<?php } ?>
	<div id="edd_purchase_form_wrap"></div><!-- the checkout fields are loaded into this-->
	<?php do_action('edd_payment_mode_bottom');
}
remove_action( 'edd_payment_mode_select', 'edd_payment_mode_select' );
add_action( 'edd_payment_mode_select', 'ppp_payment_mode_select' );

// Remove the Renewal and Discount Code fields
// remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );
remove_action( 'edd_before_purchase_form', 'edd_sl_renewal_form', -1 );

function ppp_empty_cart_on_add() {
	$discounts     = edd_get_cart_discounts();
	$cart_contents = edd_get_cart_contents();

	foreach ( $cart_contents as $key => $item ) {
		edd_remove_from_cart( $key );
	}

	if ( ! empty( $discounts ) ) {
		foreach ( $discounts as $discount ) {
			edd_set_cart_discount( $discount );
		}
	}
}
add_action( 'edd_add_to_cart', 'ppp_empty_cart_on_add', 1 );

add_filter( 'edd_recurring_show_terms_on_cart_item', '__return_false' );

// Add a custom login logo
function ppp_site_login_logo() { ?>
	<style type="text/css">
		body{
			background: rgba(0,0,0,0) linear-gradient(70deg, #3f1258, #0c023b) repeat scroll 0 0 !important;
		}
		#nav a {
			color: #FFF;
		}
		body.login div#login h1 a {
			background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/images/logo-ppp-2.svg");
			padding-bottom: 30px;
				background-size: 600px 100px;
				background-position: center top;
				width: 600px;
				margin-left: -140px;
		}
		#login form {
			background: rgba(255,255,255,.75) !important;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'ppp_site_login_logo' );
// Remove our old hooks here
remove_action( 'login_enqueue_scripts', 'ppp_login_logo' );


// Variable pricing switcher
function ppp_ajax_change_price_id() {
	$download_id = $_POST['download_id'];
	$price_id    = $_POST['price_id'];
	$discounts   = edd_get_cart_discounts();
	// Remove cart contents
	edd_remove_from_cart( 0 );

        if ( ! empty( $discounts ) ) {
                foreach ( $discounts as $discount ) {
                        edd_set_cart_discount( $discount );
                }
        }

	echo json_encode( array( 'url' => 'https://postpromoterpro.com/checkout/?edd_action=add_to_cart&download_id=' . $download_id . '&edd_options[price_id]=' . $price_id ) );
	die();
}
add_action( 'wp_ajax_ppp_switch_price', 'ppp_ajax_change_price_id' );
add_action( 'wp_ajax_nopriv_ppp_switch_price', 'ppp_ajax_change_price_id' );

/**
 * Adds a CSS class to Ninja Forms
 */
function ppp_ninja_forms_form_wrap_class( $wrap_class, $form_id ) {

	$wrap_class = ' box';
	return $wrap_class;
}
add_filter( 'ninja_forms_form_wrap_class', 'ppp_ninja_forms_form_wrap_class', 10, 2 );

function themedd_entry_meta() {
	if ( 'post' == get_post_type() ) {
		global $post, $current_user;
		$author = get_userdata( $post->post_author );
		?>
		<div class="author-profile">
				<span class="author-profile-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 75 ); ?>
				</span>

				<div class="author-profile-info">
						<h3 class="author-profile-title">
								<?php esc_html_e( 'Written by', 'themedd' ); ?>
								<?php echo esc_html( get_the_author() ); ?></h3>

						<?php if ( empty( $author->description ) && $post->post_author == $current_user->ID ) { ?>
								<div class="author-description">
										<p>
										<?php
												$profileString = sprintf( wp_kses( __( 'Complete your author profile info to be shown here. <a href="%1$s">Edit your profile &rarr;</a>', 'themedd' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'profile.php' ) ) );
												echo $profileString;
										?>
										</p>
								</div>
						<?php } else if ( $author->description ) { ?>
								<div class="author-description">
										<p><?php the_author_meta( 'description' ); ?></p>
								</div>
						<?php } ?>

						<div class="author-profile-links">
								<?php if ( $author->user_url ) { ?>
										<?php printf( '<a href="%s"><i class="fa fa-external-link-square"></i> %s</a>', $author->user_url, __( 'Website', 'themedd' ) ); ?>
								<?php } ?>
						</div>
				</div><!-- .author-drawer-text -->
		</div><!-- .author-profile -->
		<?php
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		themedd_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', esc_html_x( 'Format', 'Used before post format.', 'themedd' ) ),
			esc_url( get_post_format_link( $format ) ),
			esc_html( get_post_format_string( $format ) )
		);
	}

	if ( 'post' == get_post_type() ) {
		themedd_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'themedd' ), get_the_title() ) );
		echo '</span>';
	}
}

function ppp_check_if_is_renewal( $return, $discount_id, $code, $user ) {

	if ( strtoupper( $code ) === 'H5KM6Y' ) {
		$cart_contents = edd_get_cart_contents();
		foreach ( $cart_contents as $item ) {
			if ( $item['options']['price_id'] == 3 || $item['options']['price_id'] == 2 ) {
				edd_set_error( 'edd-discount-error', __( 'This discount is only valid on Personal and Business plans', 'edd' ) );
				return false;
			}
		}
	}

	if ( strtoupper( $code ) === 'LIFETIME32' && edd_recurring()->cart_contains_recurring() ) {
		edd_set_error( 'edd-discount-error', __( 'This discount is only valid for the lifetime license', 'edd' ) );
		return false;
	}

	return $return;
}
add_filter( 'edd_is_discount_valid', 'ppp_check_if_is_renewal', 99, 4 );


function ppp_maybe_show_discount_field() {
	remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );
}
//add_action( 'init', 'ppp_maybe_show_discount_field' );

if ( function_exists( 'pippin_display_notice' ) ) {
	remove_action('wp_footer', 'pippin_display_notice');
	add_action( 'themedd_site_before', 'pippin_display_notice' );
}
