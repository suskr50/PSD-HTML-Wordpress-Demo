<?php get_template_part( 'blueeasy/front', 'section-top' ); ?>
<div class="row ">
	<?php query_posts('pagename=just-default-section')?>
	<?php while ( have_posts() ) : the_post();?>

		<div class="title">
			<h2><?php the_title()?></h2>
			<div class="embelish">
			</div>
		</div>


		<?php the_content( ); ?>


	<?php endwhile; // end of the loop. ?>
	<?php wp_reset_query(); // resets the altered query back to the original ?>
</div>
<?php get_template_part( 'blueeasy/front', 'section-bottom' ); ?>


