<?php get_template_part( 'front', 'section-top' ); ?>

<div class="title">
	<h2>About Us</h2>
	<h3>We are added our major Services</h3>
	<div class="embelish">
	</div>
</div>


<?php query_posts('post_type=services&posts_per_page=3&category_name=demo2-about')?>
<?php while ( have_posts() ) : the_post();?>
	<div class="col-sm-4">
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

<?php get_template_part( 'front', 'section-bottom' ); ?>
