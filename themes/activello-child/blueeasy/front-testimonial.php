<?php get_template_part( 'blueeasy/front', 'section-top' ); ?>
<div class="title">
								<h2>Testimonials</h2>
								<div class="embelish"></div>
							</div>

							<?php query_posts( array(
								'category_name'  => 'demo3',
								'posts_per_page' => -1,
								'post_type' => 'testimonials',
								

								) ); ?>
								<?php while ( have_posts() ) : the_post();?>
									
									
									<h2><?php the_content();?></h2
										<div class="tauthor">
											<?php the_title('- ');?>
										</div>







									</div>

								<?php endwhile; // end of the loop. ?>
								<?php wp_reset_query(); // resets the altered query back to the original ?>

<?php get_template_part( 'blueeasy/front', 'section-bottom' ); ?>


