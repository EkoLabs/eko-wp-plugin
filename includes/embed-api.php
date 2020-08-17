<?php

///////////////////////////////////////////
///////     main api functions      ///////
///////////////////////////////////////////

/**
 * eko_embed_video_by_id
 *
 * @param  string $videoId
 * @param  array  $config, for the embed settings
 * @param  mixed  $containerId, id of the html element to contain the iframe, will create one if empty
 * @param  array  $events, additional events to forward to the player
 * @return string
 */
function eko_embed_video_by_id( string $videoId, array $config = array(), string $containerId = '', $events = array() ) {
	if ( ! $videoId ) {
		return;
	}
	$o = '';
	// pop params and set default values
	$merged = shortcode_atts(
		array(
			'width'            => '',
			'height'           => '',
			'responsive'       => true,
			'password'         => '',
			'query_params'     => '',
			'env'              => '', // default environment is empty
			'debug'            => false,
			'autoplay'         => true,
			'clearCheckpoint'  => true,
			'hidePauseOverlay' => false,
			'cover'            => '',
			'revision'         => false,
			'headnodeid'       => '',

		),
		$config
	);

	// enqueue needed scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'eko-shortcode-script' );
	// js sdk
	wp_enqueue_script( 'eko-js-sdk' );
	// create a container if container id not scpecified
	if ( ! $containerId ) {
		$containerId = 'container-' . $videoId;
		$o          .= '<div id="' . $containerId . '" ></div>';
	}
	// extract sizes and style
	$style = array();
	if ( $merged['responsive'] === true ) {
		$style['maxHeight'] = $merged['height'];
		$style['maxWidth']  = $merged['width'];
	} else {
		$style['height'] = $merged['height'];
		$style['width']  = $merged['width'];
	}
	$extra_params = array(
		'password'         => $merged['password'],
		'debug'            => $merged['debug'],
		'autoplay'         => $merged['autoplay'],
		'clearCheckpoint'  => $merged['clearCheckpoint'],
		'hidePauseOverlay' => $merged['hidePauseOverlay'],
		'revision'         => $merged['revision'],
		'headnodeid'       => $merged['headnodeid'],
	);
	// send params to the embedding script
	$iframe_params = array(
		'env'         => $merged['env'],
		'id'          => $videoId,
		'frame'       => '#' . $containerId,
		'style'       => $style,
		'extraParams' => $extra_params,
		'events'      => $events,
		'cover'       => $merged['cover'],
	);
	if ( $merged['query_params'] ) {
		$iframe_params['pageParams'] = explode( ',', $merged['query_params'] );
	}
	wp_localize_script( 'eko-shortcode-script', 'iframeParams', $iframe_params );
	return $o;
}
/**
 * eko_embed_current_video
 *
 * embed current video on the loop
 *
 * @param  mixed $config
 * @param  mixed $iframeId
 * @param  mixed $events
 * @return string
 */
function eko_embed_current_video( array $config = array(), string $containerId = '', array $events = array() ) {
	$post_id = eko_get_the_post_id();
	if ( ! $post_id || ! eko_is_video( $post_id ) ) {
		// failed to get post id or post is not an eko-video
		return;
	}
	$videoId = eko_get_field( 'video_id' );
	// check to see if password protected
	$password           = eko_get_field( 'password' );
	$config['password'] = $password;
	return eko_embed_video_by_id( $videoId, $config, $containerId, $events );
}

/**
 * eko_embed_fixed_size
 *
 * @param  mixed $videoId
 * @param  mixed $height
 * @param  mixed $width
 * @param  mixed $config
 * @param  mixed $containerId
 * @param  mixed $events
 * @return void
 */
function eko_embed_fixed_size( string $videoId, string $height, string $width, array $config = array(), string $containerId = '', $events = array() ) {
	$merged = shortcode_atts(
		array(
			'width'      => $width,
			'height'     => $height,
			'responsive' => false,
		),
		$config
	);
	return eko_embed_video_by_id( $videoId, $merged, $containerId, $events );
}
function eko_embed_current_fixed_size( string $height, string $width, array $config = array(), string $containerId = '', $events = array() ) {
	$post_id = eko_get_the_post_id();
	if ( ! $post_id || ! eko_is_video( $post_id ) ) {
		// failed to get post id or post is not an eko-video
		return;
	}
	$videoId = eko_get_field( 'video_id' );
	return eko_embed_fixed_size( $videoId, $height, $width, $config, $containerId, $events );
}
