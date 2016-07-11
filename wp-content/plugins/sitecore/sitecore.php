<?php
/**
 * Plugin Name: Sitecore - Plugin for current site
 * Plugin URI: http://marketingincolor.com
 * Description: Site specific code changes for current site
 * Version: 1.0
 * Author: Marketing In Color
 * Author URI: http://marketingincolor.com
 * License: GPL2
 *
 * Copyright 2014 Marketing In Color (email : developer@marketingincolor.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Site-wide Security Features
 *  - Removal of the "generator" meta tag from all page content.
 */
remove_action('wp_head', 'wp_generator');

/**
 * TODO: Determine "hook" method for Members plugin (https://wordpress.org/plugins/members/) that identifies Users for content Access.
 * TODO: Determine "hook" method for WP Knowledgebase plugin (https://wordpress.org/plugins/wp-knowledgebase/) to interrupt the output of the links listing.
 * TODO: Create functions for above methods to "filter" the links listing of the KB plugin based on the Users who have access permissions from the Members plugin.
 */

/**
 * Custom Login image
 */
 function sitecore_login_enqueue_scripts(){
echo '<style type="text/css" media="screen">';
echo '#login h1 a{background-image:url("'. site_url() . '/wp-content/uploads/2016/06/cropped-EvergreenWellnessLogoTablet-1.png");background-size:165px 57px; width:auto;';
echo '</style>';
}
add_action( 'login_enqueue_scripts', 'sitecore_login_enqueue_scripts' );

/**
 * Custom "linking" Function for WP Knowledgebase Plugin output to be filtered by Members Plugin settings.
 * These customizations require the above plugins to properly function, and without them it should NOT be used!
  */
function show_for_user_role() {
    if( function_exists( 'members_get_user_role_names' ) ) {
        print_r( members_get_user_role_names(get_current_user_id()) );
    }
}
add_action ( 'show_for_role', 'show_for_user_role', 10 );

/**
* Custom display function to change wrapper for Category list of Knowlegebase template page
*/
function display_kb_cat_listing( $cat_name ) {
	$cat_name = str_replace( '-', '_', $cat_name );
	$permission = "kb_can_view_cat_" . $cat_name;
	if ( current_user_can( $permission ) ) {
		print '<div class="kbe_category ' . $permission . '">';
	} else {
		print '<div class="kbe_category ' . $permission . '" style="display:none;">';
	}


}
add_action ( 'kb_cat_list', 'display_kb_cat_listing', 10 );

/**
 * Added function from Justin Tadlock to filter the post list content by Role
 * http://themehybrid.com/board/topics/subscribers-cant-see-content-marked-for-subscribers
 */
add_action( 'pre_get_posts', 'custom_kb_pre_get_posts' );

function custom_kb_pre_get_posts( $query ) {

    // Bail if current user can restrict content or edit other users' posts.
    if ( current_user_can( 'restrict_content' ) || current_user_can( 'edit_others_posts' ) )
        return;

    if ( is_user_logged_in() ) {

        $user = new WP_User( get_current_user_id() );

        $meta_query = array(
            'relation' => 'OR',
            array(
                'key'     => '_members_access_role',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key'     => '_members_access_role',
                'value'   => $user->roles[0],
                'compare' => '='
            )
        );
    } else {

        $meta_query = array(
            array(
                'key'     => '_members_access_role',
                'compare' => 'NOT EXISTS'
            )
        );
    }

    $query->set( 'meta_query', $meta_query );
}
