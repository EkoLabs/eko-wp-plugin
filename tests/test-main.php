<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoMainTest extends WP_UnitTestCase {

	var $main;

	public function setUp() {
		parent::setUp();
		require_once 'eko-video.php';
		$this->main = new Eko_Plugin();
		$this->main->setup();
		do_action( 'plugins_loaded' );
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test add_user_meta for new user with author role
	 */
	function test_eko_main() {

		$this->assertSame( NULL, $this->main->eko_admin );
		$this->assertSame( 'eko-video', $this->main->eko_frontend->shortcode );
		// test for scripts
		$this->assertTrue( wp_script_is( 'eko-video-script', 'registered' ) );
		$this->assertTrue( wp_script_is( 'eko-js-sdk', 'registered' ) );
		$this->assertTrue( wp_script_is( 'eko-shortcode-script', 'registered' ) );

	}

}
