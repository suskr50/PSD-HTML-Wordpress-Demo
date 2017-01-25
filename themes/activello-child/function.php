<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
?>

function actchild_scripts() {
    wp_enqueue_style('googleFonts', 'https://fonts.googleapis.com/css?family=Bitter:700|Lato:300,400,700,900|Open+Sans|Roboto:300,400,700 ');
    
}

add_action( 'wp_enqueue_scripts', 'actchild_scripts' );
