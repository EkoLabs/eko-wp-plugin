<?php
// If uninstall/delete not called from WordPress then exit
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

/**
 * eko_delete_all_settings
 *
 * @return void
 */
function eko_delete_all_settings() {
	// Delete the eko options
	if ( get_option( 'eko_plugin_options' ) ) {
		delete_option( 'eko_plugin_options' );
	}

	// delete all eko-video posts
	$eko_cpt_args  = array(
		'post_type'   => 'eko-video',
		'post_status' => 'any',
		'numberposts' => -1,
	);
	$eko_cpt_posts = get_posts( $eko_cpt_args );
	if ( $eko_cpt_posts ) {
		foreach ( $eko_cpt_posts as $post ) {
			// delete the post and its meta
			wp_delete_post( $post->ID, false );
		}
	}
}
function eko_uninstall_plugin() {
	// check if multi-site and delete
	if ( function_exists( 'is_multisite' ) && is_multisite() ) {
		if ( ! is_super_admin() ) {
			return;
		}
		$all_sites = wp_get_sites();
		foreach ( $all_sites as $site ) {
			switch_to_blog( $site );
			eko_delete_all_settings();
			restore_current_blog();
		}
	} else {
		eko_delete_all_settings();
	}
}

eko_uninstall_plugin()();
