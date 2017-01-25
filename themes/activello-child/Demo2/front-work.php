<?php get_template_part( 'front', 'section-top' ); ?>

<div class="title">
	<h2>Our Work</h2>
	<h3>We are added our featured works below</h3>
	<div class="embelish">
	</div>
</div>
<?php $count = 0 ?>
<div class="container">
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
</div>

<?php get_template_part( 'front', 'section-bottom' ); ?>
