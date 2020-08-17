<?php

/**
 * Test case for the constants defined in the plugin
 */
class EkoConstantTest extends WP_UnitTestCase {


	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test add_user_meta for new user with author role
	 */
	function test_eko_constants() {
		$this->assertSame( plugins_url( '', __FILE__ ), EKO_PLUGIN_URL . '/tests' );
		$this->assertSame( plugin_dir_path( __FILE__ ), EKO_PLUGIN_PATH . 'tests/' );
	}
}
