<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package activello
 */
?><!doctype html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
	<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">

			<div id="pre-header" class="container-fluid">
			<div class="container">
				<ul>
					<li><i class="fa fa-mobile"></i>6337 3428</li>
					<li><i class="fa fa-envelope"></i>info@business.co</li>
					<li><span class="fa-stack fa-lg">
						<i class="fa fa-square fa-stack-2x"></i>
						<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
					</span></li>
				</ul>
				</div>
			</div>

			<header id="masthead" class="site-header" role="banner">

				<nav class="navbar navbar-default" role="navigation">
					<div class="container">
						<div class="row">
							<div class="site-navigation-inner col-sm-12">
								<div class="navbar-header">
									<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
										<span class="sr-only"><?php _e( 'Toggle navigation', 'activello' ); ?></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
									<a class="navbar-brand" href="<?php bloginfo('url');?>"><?php $logo = get_theme_mod('header_logo', '');
										
										echo wp_get_attachment_image($logo, 'full');?></a>
									</div>
									<?php
						// display the WordPress Custom Menu if available
									wp_nav_menu(array(
										'menu'              => 'primary',
										'theme_location'    => 'primary',
										'depth'             => 3,
										'container'         => 'div',
										'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
										'menu_class'        => 'nav navbar-nav ',
										'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
										'walker'            => new activello_wp_bootstrap_navwalker()
										)); ?>
										
										
										
									</div>
								</div>
							</div>
						</nav><!-- .site-navigation -->

						
						

					</header><!-- #masthead -->


					<div id="content" class="site-content front-top-section">

						<div class="cta">
							
							<div class="inner-front">
								<div>
									<div class="inner-top">
										
										<h1>We Providing</h1>
										<h2>Social Media marketing for businesses</h2>
										
										<a class="btn btn-danger" href="">FREE CONSULTATION </a>
									</div>
									
								</div>

							</div>
						</div>
					</div>
					

					

					
