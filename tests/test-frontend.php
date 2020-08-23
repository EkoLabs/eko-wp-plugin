<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoShortcodesTest extends WP_UnitTestCase {

	var $frontend;

	public function setUp() {
		parent::setUp();
		require_once 'includes/frontend/class-frontend.php';
		$this->frontend = new Eko_Frontend();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Test add_user_meta for new user with author role
	 */
	function test_eko_shortcodes() {
		// global $wp_scripts;
		// global $post;
		// $post = (object) array('post_type' => 'eko-video');
		// load_custom_cpt_code('post-new.php');
		// $data = $wp_scripts->get_data( 'eko-cpt-script', 'data' );
		// echo $data;
		// //$data = substr( $data, strpos( $data, '{' ) - 1, strpos( $data, '}' ) + 1 );
		// $sos_data = json_decode( $data, true );
		// var_dump($sos_data);
		global $shortcode_tags;
		// test existance of shortcodes
		$this->assertArrayHasKey( $this->frontend->shortcode, $shortcode_tags );

		//test shortcodes value
		$this->assertSame( 'video_shortcode', $shortcode_tags['eko-video'][1] );

		// test basic shortcode method
		$sample_id = 'MebL1z';
		$shortcode_res = $this->frontend->video_shortcode( array( 'id' => $sample_id ) );
		$xml           = simplexml_load_string( $shortcode_res );
		$div_class     = $xml['class'];
		$div_id     = $xml['id'];
		$this->assertSame( (string) $div_class, 'sdk-container' );
		$this->assertSame( (string) $div_id, 'container-'.$sample_id );
	}
}
