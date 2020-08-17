<?php

defined( 'ABSPATH' ) or die( 'Access denied !' );

class Eko_Video {

	var $post_type     = 'eko-video';
	var $name          = 'eko Videos';
	var $singular_name = 'eko Video';
	public function __construct() {
		require_once EKO_PLUGIN_PATH . 'includes/plugin_metabox.php';
	}
	/**
	 * setup
	 *
	 * @return void
	 */
	function setup() {
		add_action( 'init', array( $this, 'add_post_type' ) );
		add_action( 'save_post', 'eko_save_meta_box' );
	}

	/**
	 * add_post_type
	 *
	 * @return void
	 */
	function add_post_type() {
		$slug = eko_get_option( 'slug' ) ? esc_attr( eko_get_option( 'slug' ) ) : EKO_DFAULT_CPT_SLUG;
		register_post_type(
			$this->post_type,
			array(
				'labels'               => array(
					'name'          => $this->name,
					'singular_name' => $this->singular_name,
					'all_items'     => __( 'All eko Videos' ),
					'add_new_item'  => __( 'Add New eko Video' ),
					'add_new'       => __( 'Add New eko Video' ),
					'edit_item'     => __( 'Edit eko Video' ),
				),
				'public'               => true,
				'has_archive'          => true,
				'rewrite'              => array( 'slug' => $slug ),
				'menu_position'        => 4,
				'menu_icon'            => 'dashicons-video-alt3',
				'supports'             => array( 'title' ),
				'register_meta_box_cb' => 'eko_add_metabox_to_video',
			)
		);
	}
}
