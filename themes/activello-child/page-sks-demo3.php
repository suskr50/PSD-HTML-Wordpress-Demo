<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package activello
 */

get_header('demo3'); ?>

<div class="services">
	<?php get_template_part( 'blueeasy/front', 'services' ); ?>
</div>

<div class="work">
	<?php get_template_part( 'blueeasy/front', 'work' ); ?>
</div>	

<div class="just">
	<?php get_template_part( 'blueeasy/front', 'just' ); ?>
</div>	

<div class="twitter-api">
	<?php get_template_part( 'blueeasy/front', 'twitter' ); ?>
</div>

<div class="about">
	<?php get_template_part( 'blueeasy/front', 'about' ); ?>
</div>

<div class="testimonial">
	<?php get_template_part( 'blueeasy/front', 'testimonial' ); ?>
</div>	

<div class="contact">
	<?php get_template_part( 'blueeasy/front', 'contact' ); ?>
</div>









<?php get_footer('demo3'); ?>
