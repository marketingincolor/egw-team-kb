<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:


if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css' );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css' );

function load_fonts() {
            wp_register_style('et-googleFonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Raleway');
            wp_enqueue_style( 'et-googleFonts');
        }
    add_action('wp_print_styles', 'load_fonts');

function last_modified($format='') {
	global $wpdb, $id;

	$post_mod_date = $wpdb->get_var("SELECT post_modified FROM $wpdb->posts WHERE id = $id");

	if (empty($format))
		$format = get_settings('date_format') . ' @ ' . get_settings('time_format') . ' |';

	echo mysql2date($format, $post_mod_date);
}
// END ENQUEUE PARENT ACTION

// Add favicon
function blog_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.ico" />' . "\n";
}
add_action('wp_head', 'blog_favicon');
