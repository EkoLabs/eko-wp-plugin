<?php

/**
 * "Security Note: Consider blocking direct access to your plugin PHP
 * files by adding the following line at the top of each of them."
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Plugin Name: eko-video
 * Author:      eko
 * Author URI:  https://eko.com
 * Description: A plugin to assist on embedding eko videos in WordPress sites.
 * Version:     1.0.2
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
// Plugin definintions
define( 'EKO_NAME', pathinfo( __FILE__ )['filename'] );
define( 'EKO_VERSION', '1.0.0' );
define( 'EKO_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'EKO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EKO_DFAULT_CPT_SLUG', 'eko-videos' );
// base name
define( 'EKO_BASE_NAME', plugin_basename( __FILE__ ) );
// main file
define( 'EKO_PLUGIN_FILE', __FILE__ );

// Include all other files
include_once( EKO_PLUGIN_PATH . 'includes/api.php' );
include_once( EKO_PLUGIN_PATH . 'includes/embed-api.php' );

//////////////////////////////////
/////// HELPING FUNCTIONS ////////
//////////////////////////////////

/**
 * eko_get_embed_url
 * returns the url for embedding an eko video by its id
 * @param  mixed $videoId
 * @param  mixed $password
 * @param  mixed $query_params
 * @param  mixed $embedapi
 * @param  mixed $events
 * @return string src, the embed url of the video
 */
function eko_get_embed_url( string $videoId, string $password = '', bool $query_params = false, $embedapi = 'v1', array $events = array() ) {
	$src = 'https://eko.com/v/' . esc_attr( $videoId ) . '/embed';

	// add query params if wanted
	if ( $query_params ) {
		$src .= '?' . $_SERVER['QUERY_STRING'];
	}
	// add password if given
	if ( $password ) {
		$src .= ( $query_params ? '&password=' . esc_attr( $password ) : '?password=' . esc_attr( $password ) );
	}
	// add events if given
	$src .= ( $query_params || $password ? '&embedapi=' . esc_attr( $embedapi ) : '?embedapi=' . esc_attr( $embedapi ) );
	if ( $events ) {
		$src .= '?events=' . implode( ',', $events );
	}
	return $src;
}

/**
 * eko_get_the_post_id
 *
 * get $post->ID if $post_id not given
 *
 * @param  mixed $post_id
 * @return string
 */
function eko_get_the_post_id( $post_id = false ) {
	global $post;
	return $post_id ? $post_id : $post->ID;
}

/**
 * eko_get_actual_field
 *
 * get the value of a certain video field
 *
 * @param  mixed $field
 * @return bool
 */
function eko_get_actual_field( array $field ) {
	return isset( $field[0] ) ? $field[0] : null;
}

/**
 * eko_get_option
 *
 * @param  mixed $key
 * @param  mixed $default
 * @return void
 */
function eko_get_option( $key, $default = '') {
	$options = get_option( 'eko_plugin_options' );
	return ( $options && $options[$key] ) ? $options[$key] : '';
}


/**
 * eko_is_video
 *
 * @param  mixed $post_id
 * @return bool
 */
function eko_is_video( $post_id = null ) {
	return strcmp( get_post_type( $post_id ), 'eko-video' ) === 0;
}

// register as oembed provider
function eko_register_as_oembed_provider() {
	$endpoint = 'https://eko.com';
	$format   = 'https://eko.com/*';
	wp_oembed_add_provider( $format, $endpoint );
}

class Eko_Plugin {



	var $video;
	var $eko_admin;
	var $eko_frontend;

	function __construct() {
		require_once EKO_PLUGIN_PATH . 'includes/admin/class-video.php';
		require_once EKO_PLUGIN_PATH . 'includes/admin/class-admin.php';
		require_once EKO_PLUGIN_PATH . 'includes/frontend/class-frontend.php';
	}
	function setup() {
		// register scripts & atyles
		add_action( 'wp_loaded', [$this, 'register_eko_scripts'] );

		// register post type
		$this->video = new Eko_Video();
		$this->video->setup();

		if ( is_admin() ) {
			add_action( 'plugins_loaded', array( $this, 'load_eko_admin' ) );
		} else {
			add_action( 'plugins_loaded', array( $this, 'load_eko_frontend' ) );
		}
	}

	function register_eko_scripts() {
		// for video post type
		wp_register_script( 'eko-video-script', EKO_PLUGIN_URL . '/dist/js/videoPostType.js', array( 'jquery' ) );
		// register eko sdk for embedding
		wp_register_script( 'eko-js-sdk', EKO_PLUGIN_URL . '/eko-js-sdk-develop/dist/EkoPlayer.js' );
		// to embed via shortcode
		wp_register_script( 'eko-shortcode-script', EKO_PLUGIN_URL . '/dist/js/shortcodeIframe.js' );
	}

	function load_eko_admin() {
		$this->eko_admin = new Eko_Admin();
		$this->eko_admin->setup();
	}


	function load_eko_frontend() {
		$this->eko_frontend = new Eko_Frontend();
		$this->eko_frontend->setup();
	}
}
$eko_plugin = new Eko_Plugin();
$eko_plugin->setup();
