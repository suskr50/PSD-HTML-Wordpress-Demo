<?php get_template_part( 'blueeasy/front', 'section-top' ); ?>


								<div class="title">
									<h2>Contact</h2>
									<div class="embelish"></div>
								</div>

								<?php query_posts('pagename=be-contact')?>
								<?php while ( have_posts() ) : the_post();?>


									<div class="be-contact-wrapper ">

										<?php the_content();?>

									</div>




								</div>

							<?php endwhile; // end of the loop. ?>
							<?php wp_reset_query(); // resets the altered query back to the original ?>




<?php get_template_part( 'blueeasy/front', 'section-bottom' ); ?>
