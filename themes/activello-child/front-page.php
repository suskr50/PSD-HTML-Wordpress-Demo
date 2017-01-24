<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package activello
 */

get_header('front'); ?>

<!-- ABOUT US SECTION  -->
<div id=" content " class="site-content about">
	<div class="container main-content-area">

		<div class="row ">
			<div class="main-content-inner col-sm-12 col-md-12 ">
				<div id="primary" class="content-area">

					<main id="main" class="site-main " role="main">


						<?php while ( have_posts() ) : the_post();?>

										<p class="card-text"><?php the_content();?></p>


						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); // resets the altered query back to the original ?>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .site-content -->


<?php get_footer('demo2'); ?>
