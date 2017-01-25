<?php get_template_part( 'front', 'section-top' ); ?>



<div class="title">
	<h2>Get Your Free Facebook Analysis Now</h2>
	<h3>Enter your details below</h3>
	<div class="pointer">
		<i class="fa fa-chevron-down "></i>
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

<?php get_template_part( 'front', 'section-bottom' ); ?>
