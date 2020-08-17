<?php

defined( 'ABSPATH' ) or die( 'Access denied !' );

class Eko_Frontend {



	var $helper;
	var $shortcode = 'eko-video';

	/**
	 * setup
	 *
	 * @return void
	 */
	public function setup() {
		// enable shortcodes
		add_shortcode(
			$this->shortcode,
			array(
				$this,
				'video_shortcode',
			)
		);
	}

	/**
	 * video_shortcode
	 *
	 * Extract arguments and set defaults
	 * args based on https://developer.eko.com/docs/embedding/dev.html
	 *
	 * @param  mixed $atts
	 * @return string
	 */
	public function video_shortcode( $atts ) {
		// extract params
		$merged = shortcode_atts(
			array(
				'id'               => '',
				'width'            => '',
				'height'           => '',
				'password'         => '',
				'responsive'       => 'true',
				'query_params'     => '',
				'full_screen'      => 'false',
				'revision'         => false,
				'debug'            => false,
				'autoplay'         => true,
				'clearCheckpoint'  => true,
				'hidePauseOverlay' => false,
				'cover'            => '',
				'headnodeid'       => '',

			),
			$atts
		);
		if ( ! $merged['id'] ) {
			return;
		}
		return $this->execute_shortcode( $merged );
	}

	function execute_shortcode( $merged ) {
		$env = eko_get_option( 'env' ) ? esc_attr( eko_get_option( 'env' ) ) : '';
		// extract sizes and style
		$style = array();
		if ( $merged['responsive'] === 'true' ) {
			$style['maxHeight'] = $merged['height'];
			$style['maxWidth']  = $merged['width'];
		} else {
			$style['height'] = $merged['height'];
			$style['width']  = $merged['width'];
		}
		// change the position of the iframe if it is not full screen
		if ( $merged['full_screen'] === 'false' ) {
			$style['position'] = 'static';
		}
		// send password and configs
		$extra_params = array(
			'password'         => $merged['password'],
			'debug'            => $merged['debug'],
			'autoplay'         => $merged['autoplay'],
			'clearCheckpoint'  => $merged['clearCheckpoint'],
			'hidePauseOverlay' => $merged['hidePauseOverlay'],
			'revision'         => $merged['revision'],
			'headnodeid'       => $merged['headnodeid'],
		);
		// create containing div
		$container_id = 'container-' . $merged['id'];
		// enqueue the script
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'eko-shortcode-script' );
		// js sdk
		wp_enqueue_script( 'eko-js-sdk' );
		// send the settings env to the script
		$iframe_params = array(
			'env'         => $env,
			'id'          => $merged['id'],
			'frame'       => '#' . $container_id,
			'style'       => $style,
			'extraParams' => $extra_params,
			'cover'       => $merged['cover'],
		);
		if ( $merged['query_params'] ) {
			$iframe_params['pageParams'] = explode( ',', $merged['query_params'] );
		}
		// send the information in the window as the video id - to allow duplicates
		wp_localize_script( 'eko-shortcode-script', $merged['id'], $iframe_params );
		return '<div id="' . $container_id . '"  class="sdk-container"></div>';
	}
}
