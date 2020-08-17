<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoActionsTest extends WP_UnitTestCase {


	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test add_user_meta for new user with author role
	 */
	function test_eko_actions() {

		$this->assertTrue( has_action( 'wp_enqueue_scripts', 'register_eko_scripts' ) == true );
		$this->assertTrue( has_action( 'admin_menu', 'add_main_admin_page' ) == true );
		$this->assertTrue( has_action( 'admin_enqueue_scripts', 'load_custom_plugin_style' ) == true );
		$this->assertTrue( has_action( 'init', 'eko_custom_post_type' ) == true );
		$this->assertTrue( has_action( 'add_meta_boxes', 'add_metabox_to_cpt' ) == true );
		$this->assertTrue( has_action( 'save_post', 'eko_save_meta_box' ) == true );
		$this->assertTrue( has_action( 'admin_enqueue_scripts', 'load_custom_cpt_code' ) == true );
	}
}
