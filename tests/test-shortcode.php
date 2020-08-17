<?php

/**
 * Test case for the constants action in the plugin main page eko.php
 */
class EkoShortcodesTest extends WP_UnitTestCase {


	public function setUp() {
		parent::setUp();
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
		var_dump( $shortcode_tags );
		// test existance of shortcodes
		$this->assertArrayHasKey( 'eko-video', $shortcode_tags );
		$this->assertArrayHasKey( 'eko-responsive-video', $shortcode_tags );
		$this->assertArrayHasKey( 'eko-simple-video', $shortcode_tags );
		//test shortcodes value
		$this->assertSame( 'video_shortcode', $shortcode_tags['eko-video'] );
		$this->assertSame( 'eko_responsive_video_shortcode', $shortcode_tags['eko-responsive-video'] );
		$this->assertSame( 'eko_simple_video_shortcode', $shortcode_tags['eko-simple-video'] );
		// test basic shortcode method
		$shortcode_res = eko_video_shortcode( array( 'id' => 'MebL1z' ) );
		$xml           = simplexml_load_string( $shortcode_res );
		$div_class     = $xml['class'];
		$iframe        = $xml->iframe;
		$this->assertSame( (string) $div_class, 'eko-iframe-container horizontal' );
		$this->assertTrue( (bool) $iframe['allowfullscreen'] );
		$this->assertSame( 'https://eko.com/v/MebL1z/embed', (string) $iframe['src'] );
	}
}
