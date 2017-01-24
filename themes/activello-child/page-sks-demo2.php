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

get_header('demo2'); ?>

<!-- ABOUT US SECTION  -->
<div id=" content " class="site-content about">
	<div class="container main-content-area">

		<div class="row ">
			<div class="main-content-inner col-sm-12 col-md-12 "> 
				<div id="primary" class="content-area">

					<main id="main" class="site-main " role="main">
						<div class="title">
							<h2>About Us</h2>
							<h3>We are added our major Services</h3>
							<div class="embelish">
							</div>
						</div>
						<?php query_posts('post_type=services&posts_per_page=3&category_name=demo2-about')?>
						<?php while ( have_posts() ) : the_post();?>
							<div class="col-md-4">
								<div class="card" ">

									<div class="card-img-top"><?php the_post_thumbnail( ); ?></div>
									<div class="card-block">
										<h4 class="card-title"><?php the_title();?></h4>
										<p class="card-text"><?php the_content();?></p>

									</div>
								</div>


							</div>

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query(); // resets the altered query back to the original ?>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .site-content -->


<!-- Our Approach SECTION  -->
<div id=" content " class="site-content approach">
	<div class="container main-content-area">

		<div class="row ">
			<div class="main-content-inner col-sm-12 col-md-12 "> 
				<div id="primary" class="content-area">

					<main id="main" class="site-main" role="main">
						<div class="title">
							<h2>Our Approach</h2>
							<h3>We are added our featured works below</h3>
							<div class="embelish">
							</div>
						</div>
						<div class="row no-gutters">
							<?php $count = 0 ?>
							<?php query_posts( array(
								'category_name'  => 'demo2-project',
								'posts_per_page' => -4,
								'post_type' => 'services',
								'order'    => 'DESC'

								) ); ?>



								<?php while ( have_posts() ) : the_post();?>
									<?php if ($count % 2 == 0) { ?>
									<div class="row abox no-gutters">
									<div class="col-sm-5">

											<?php the_post_thumbnail( ); ?>

										</div>
										<div class="col-sm-7">
											<div class="pwrap">
												<div>
													<h5><?php the_title();?></h5>
													<?php the_content();?>

												</div>
											</div>
										</div>



									</div>

									<?php } else {?>
									<div class="row abox no-gutters">

										<div class="col-sm-7">
											<div class="pwrap">
												<div>
													<h5><?php the_title();?></h5>
													<?php the_content();?>

												</div>
											</div>
										</div>
										<div class="col-sm-5">

											<?php the_post_thumbnail( ); ?>

										</div>


									</div>
									<?php }; $count= $count + 1; ?>


								<?php endwhile; // end of the loop. ?>
								<?php wp_reset_query(); // resets the altered query back to the original ?>
							</div>

						</main><!-- #main -->
					</div><!-- #primary -->

				</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
			</div><!-- close .row -->
		</div><!-- close .container -->
	</div><!-- close .site-content -->


	<!-- Our Work SECTION  -->
	<div id=" content " class="site-content work">
		<div class="container main-content-area">

			<div class="row ">
				<div class="main-content-inner col-sm-12 col-md-12 "> 
					<div id="primary" class="content-area">

						<main id="main" class="site-main" role="main">
							<div class="title">
								<h2>Our Work</h2>
								<h3>We are added our featured works below</h3>
								<div class="embelish">
								</div>
							</div>
							<?php $count = 0 ?>
							<div class="row no-gutters">
								<?php query_posts('category_name=work&post_type=projects&posts_per_page=4')?>
								<?php while ( have_posts() ) : the_post();?>
									<?php if ($count <2) { ?>
									<div class="col-sm-6">
										<div class="row abox no-gutters">
											<div class="col-xs-6">

												<?php the_post_thumbnail( ); ?>

											</div>
											<div class="col-xs-6">
												<div class="pwrap">
													<div>
														<i class="fa fa-paper-plane"></i>
														<h5><?php the_title();?></h5>
														<?php the_content();?>

													</div>
												</div>
											</div>
										</div>


									</div>
									<?php } else {?>

									<div class="col-sm-6">
										<div class="row abox no-gutters">

											<div class="col-xs-6">
												<div class="pwrap">
													<div>
														<i class="fa fa-paper-plane"></i>
														<h5><?php the_title();?></h5>
														<?php the_content();?>

													</div>
												</div>
											</div>
											<div class="col-xs-6">

												<?php the_post_thumbnail( ); ?>

											</div>
										</div>


									</div>

									<?php }; $count= $count + 1; ?>

								<?php endwhile; // end of the loop. ?>
								<?php wp_reset_query(); // resets the altered query back to the original ?>
							</div>

						</main><!-- #main -->
					</div><!-- #primary -->

				</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
			</div><!-- close .row -->
		</div><!-- close .container -->
	</div><!-- close .site-content -->


	<!-- Contact SECTION  -->
	<div id=" content " class="site-content contact">
		<div class="container main-content-area">

			<div class="row">
				<div class="main-content-inner col-sm-12 col-md-12 "> 
					<div id="primary" class="content-area">

						<main id="main" class="site-main " role="main">
							<div class="title">
								<h2>Get Your Free Facebook Analysis Now</h2>
								<h3>Enter your details below</h3>
								<div class="pointer">
									<i class="fa fa-chevron-down "></i>
								</div>
							</div>
						</div>
						<?php query_posts('pagename=contact2')?>
						<?php while ( have_posts() ) : the_post();?>


							<div class="contact-wrapper col-md-8 col-md-offset-2">
								<div>

									<?php the_content();?></p>
								</div>
							</div>




						</div>

					<?php endwhile; // end of the loop. ?>
					<?php wp_reset_query(); // resets the altered query back to the original ?>

				</main><!-- #main -->
			</div><!-- #primary -->

		</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
	</div><!-- close .row -->
</div><!-- close .container -->
</div><!-- close .site-content -->

<!-- Pre-Footer SECTION  -->
<div id=" content " class="site-content pre-footer">
	<div class="container main-content-area">

		<div class="row">
			<div class="main-content-inner col-sm-12 col-md-12 "> 
				<div id="primary" class="content-area">

					<main id="main" class="site-main " role="main">
						<div class="title">
							<h2>Get in touch</h2>
							<ul>
								<li>
									<span class="fa-stack fa-lg">
										<i class="fa fa-square-o fa-stack-2x"></i>
										<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
									</span>
								</li>
								<li>
									<span class="fa-stack fa-lg">
										<i class="fa fa-square-o fa-stack-2x"></i>
										<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
									</span>
								</li>
								<li>
									<span class="fa-stack fa-lg">
										<i class="fa fa-square-o fa-stack-2x"></i>
										<i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
									</span>
								</li>
								<li>
									<span class="fa-stack fa-lg">
										<i class="fa fa-square-o fa-stack-2x"></i>
										<i class="fa fa-linkedin fa-inverse"></i>
									</span>
								</li>
							</ul>
						</div>
					</div>
					<?php query_posts('pagename=subscribe')?>
					<?php while ( have_posts() ) : the_post();?>
						
						<div class="cform">


							<?php the_content();?></p>
						</div>

						

						
					</div>

				<?php endwhile; // end of the loop. ?>
				<?php wp_reset_query(); // resets the altered query back to the original ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
</div><!-- close .row -->
</div><!-- close .container -->
</div><!-- close .site-content -->




<?php get_footer('demo2'); ?>