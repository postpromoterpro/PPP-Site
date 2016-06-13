<?php
/**
 * Template Name: Account
 */

get_header();

?>

<div id="tabs">
<header class="aligncenter page-header<?php echo themedd_page_header_classes(); ?>">

	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>

	<h2 class="subtitle">
		<?php if ( is_user_logged_in() ) : ?>
			<?php printf( __( 'Welcome, %s', 'rcp' ), wp_get_current_user()->display_name ); ?>
		<?php else : ?>
			<?php _e( 'Come on in!', 'rcp' ); ?>
		<?php endif; ?>

	</h2>

</header>

<?php
$wrapper_class = ! is_user_logged_in() ? ' slim' : '';

?>
<section class="container-fluid">
<div class="wrapper<?php echo $wrapper_class; ?>">

	<div class="row">

		<div class="col-xs-12">

			<?php if ( is_user_logged_in() ) : ?>
			<ul class="center-xs">
				<li><a href="#tab-1">Licenses</a></li>
				<li><a href="#tab-2">Subscriptions</a></li>
				<li><a href="#tab-3">Purchases</a></li>
				<li><a href="#tab-4">Downloads</a></li>
				<li><a href="#tab-5">Profile</a></li>
			</ul>
			<?php endif; ?>

			<?php
			/**
			 * Logout message
			 */
			if ( isset( $_GET['logout'] ) && $_GET['logout'] == 'success' ) { ?>
				<p class="alert notice">
					<?php _e( 'You have been successfully logged out', 'rcp' ); ?>
				</p>
			<?php } ?>

			<?php if ( ! is_user_logged_in() ) : ?>

				<?php /*
				<p>
					<a href="<?php echo site_url( 'account/register' ); ?>">Need to register an account?</a>
				</p>
				*/ ?>

				<?php echo edd_login_form( add_query_arg( array( 'login' => 'success', 'logout' => false ), site_url( $_SERVER['REQUEST_URI'] ) ) ); ?>

			<?php endif; ?>


			<?php if ( is_user_logged_in() ) : ?>

			<div id="tab-1">
				<h2>Licenses</h2>
				<?php echo do_shortcode( '[edd_license_keys]'); ?>
			</div>

			<div id="tab-2">
	  			<h2>Subscriptions</h2>
	  			<?php echo do_shortcode( '[edd_subscriptions]'); ?>
	  		</div>

			<div id="tab-3">
				<h2>Purchases</h2>
				<?php echo do_shortcode( '[purchase_history]'); ?>
			</div>

			<div id="tab-4">
				<h2>Downloads</h2>
				<?php echo do_shortcode( '[download_history]'); ?>


				<?php if ( function_exists( 'ppp_edd_download_url' ) && ppp_edd_download_url( ppp_get_download_id() ) ) : ?>
					<h4>Post Promoter Pro</h4>
				    <p><a href="<?php echo ppp_edd_download_url( ppp_get_download_id() ); ?>" class="button">Download Post Promoter Pro</a></p>
				<?php endif; ?>
			</div>

			<div id="tab-5">

				<div class="wrapper">
					<h2>Edit your profile</h2>
					<?php echo do_shortcode( '[edd_profile_editor]'); ?>
				</div>

			</div>
			<?php endif; ?>

			</div>
		</div>

</div>
</section>

</div>
<?php
get_footer();
