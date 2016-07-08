<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.2/foundation.min.css" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="icon" type="image/png" href="images/favicon.ico">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/foundation.min.css" />
  	<link href='https://fonts.googleapis.com/css?family=Halant:400,500,600,700|Roboto:100,300,400,500,700,900' rel='stylesheet' type='text/css'>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>
		<div id="content" class="site-content">
