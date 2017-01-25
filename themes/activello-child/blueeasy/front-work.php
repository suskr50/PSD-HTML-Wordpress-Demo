<?php get_template_part( 'blueeasy/front', 'section-top' ); ?>


<div class="title">
	<h2>Portfolio</h2>
	<div class="embelish">	</div>
</div>


<div class="row ">
	<?php query_posts('category_name=demo3-work&post_type=projects&posts_per_page=8')?>
	<?php while ( have_posts() ) : the_post();?>


		<div class="col-xs-3">
			<div class="abox">
				<?php the_post_thumbnail( ); ?>

			</div>


		</div>


	<?php endwhile; // end of the loop. ?>
	<?php wp_reset_query(); // resets the altered query back to the original ?>
</div>

<?php get_template_part( 'blueeasy/front', 'section-bottom' ); ?>


