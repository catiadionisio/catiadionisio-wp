<?php
/**
 * Script enqueue
 *
 */

function theme_enqueue_scripts(){

	// livereload
	wp_enqueue_script('livereload', 'http://www.citrinosalbufeira.test:35729/livereload.js?snipver=1', null, false, true);

	// main style and scripts
	wp_enqueue_script('scripts', get_template_directory_uri().'/assets/js/scripts.min.js', array ('jquery'), THEME_VERSION, true);
	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/global.min.css', false, THEME_VERSION);

	// modernizr
	//wp_enqueue_script('modernizr', get_template_directory_uri().'/assets/vendor/modernizr.js');

	// slick
	wp_enqueue_script('slick', get_template_directory_uri().'/assets/vendor/slick-carousel/slick/slick.min.js', array ('jquery'), false, true);

	// imagesloaded
	wp_enqueue_script('imagesloaded', get_template_directory_uri().'/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js', array ('jquery'), '4.1.4', true);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
