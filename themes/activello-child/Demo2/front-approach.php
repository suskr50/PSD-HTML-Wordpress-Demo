<?php get_template_part( 'demo2/front', 'section-top' ); ?>

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

							<?php get_template_part( 'demo2/front', 'section-bottom' ); ?>
