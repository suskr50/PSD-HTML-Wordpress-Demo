<?php get_template_part( 'front', 'section-top' ); ?>

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

<?php query_posts('pagename=subscribe')?>
<?php while ( have_posts() ) : the_post();?>

	<div class="cform">


		<?php the_content();?></p>
	</div>




</div>

<?php endwhile; // end of the loop. ?>
<?php wp_reset_query(); // resets the altered query back to the original ?>


<?php get_template_part( 'front', 'section-bottom' ); ?>
