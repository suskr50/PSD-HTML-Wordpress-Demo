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

get_header('demo2'); ?>

<!-- ABOUT US SECTION  -->
<div id="about">
	<?php get_template_part( 'demo2/front', 'about' ); ?>
</div>

<!-- Our Approach SECTION  -->

<div id="approach">
	<?php get_template_part( 'demo2/front', 'approach' ); ?>
</div>

<!-- Our Work SECTION  -->
<div id="work">
	<?php get_template_part( 'demo2/front', 'work' ); ?>
</div>

	<!-- Contact SECTION  -->

<div id="contact">
	<?php get_template_part( 'demo2/front', 'contact' ); ?>
</div>


<!-- Pre-Footer SECTION  -->
<div id="pre-footer">
	<?php get_template_part( 'demo2/front', 'pre-footer' ); ?>
</div>



<?php get_footer('demo2'); ?>
