<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoCustomPostTypeTest extends WP_UnitTestCase {

	var $video;

	public function setUp() {
		parent::setUp();
		require_once 'includes/admin/class-video.php';
		$this->video = new Eko_Video();
		$this->video->setup();
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
		$video_type = $wp_post_types['eko-video'];
		$this->assertTrue( $video_type->public );
		$this->assertTrue( $video_type->has_archive );
		$this->assertSame( $video_type->rewrite['slug'], 'eko-videos' );

		// the the object itself
		$this->assertSame( 'eko-video', $this->video->post_type );
		$this->assertSame( 'eko Videos', $this->video->name );
		$this->assertSame( 'eko Video', $this->video->singular_name );
	}
}
