<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoAdmineTest extends WP_UnitTestCase {

	var $admin;

	public function setUp() {
		parent::setUp();
		require_once 'includes/admin/class-admin.php';
		$this->admin = new Eko_Admin();
		$this->admin->register_settings();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test add_user_meta for new user with author role
	 */
	function test_eko_admin() {
		global $wp_registered_settings;
		$this->assertarrayHasKey('eko_plugin_options', $wp_registered_settings);
	}
}
