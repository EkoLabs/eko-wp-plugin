<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoCustomPostTypeTest extends WP_UnitTestCase {


	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test add_user_meta for new user with author role
	 */
	function test_eko_cpt() {
		global $wp_post_types;
		// first remove our cpt
		if ( isset( $wp_post_types['eko-video'] ) ) {
			unset( $wp_post_types['eko-video'] );
		}
		$this->assertarrayNotHasKey( 'eko-video', $wp_post_types );
		// call the action that init the cpt
		do_action( 'init' );
		$this->assertarrayHasKey( 'eko-video', $wp_post_types );
		$video = $wp_post_types['eko-video'];
		$this->assertTrue( $video->public );
		$this->assertTrue( $video->has_archive );
		$this->assertSame( $video->rewrite['slug'], 'eko-videos' );

	}
}
