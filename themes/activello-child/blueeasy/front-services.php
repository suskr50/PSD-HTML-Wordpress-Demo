<?php get_template_part( 'blueeasy/front', 'section-top' ); ?>
<div class="title">
							<h2>Services</h2>
							<div class="embelish">
							</div>
						</div>
						<?php query_posts('post_type=services&posts_per_page=4&category_name=demo3-services')?>
						<?php while ( have_posts() ) : the_post();?>
							<div class="col-md-3">
								<div class="card" ">

									<div class="card-img-top"><?php the_post_thumbnail( ); ?></div>
									<div class="card-block">
										<h4 class="card-title"><?php the_title();?></h4>
										<p class="card-text"><?php the_content();?></p>

									</div>
								</div>


							</div>

						<?php endwhile; // end of the loop. ?>
						<?php wp_reset_query();  ?>

<?php get_template_part( 'blueeasy/front', 'section-bottom' ); ?>


