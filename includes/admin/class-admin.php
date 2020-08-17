<?php

defined( 'ABSPATH' ) or die( 'Access denied !' );

/**
 * Eko_Admin
 */
class Eko_Admin {


	/**
	 * setup
	 *
	 * @return void
	 */
	function setup() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
		// register settings and admin page
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_main_admin_page' ) );
	}

	/**
	 * load_admin_scripts
	 *
	 * @param  mixed $hook
	 * @return void
	 */
	public function load_admin_scripts( $hook ) {
		global $post;
		if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
			if ( 'eko-video' === $post->post_type ) {
				wp_enqueue_script( 'jquery-ui-accordion' );
				wp_enqueue_script( 'eko-video-script' );
				// js sdk
				wp_enqueue_script( 'eko-js-sdk' );
				// send the settings env to the script
				$env         = eko_get_option( 'env' );
				$eko_options = array( 'env' => $env );
				wp_localize_script( 'eko-video-script', 'ekoOptions', $eko_options );
			}
		}
	}

	/**
	 * register_settings
	 *
	 * @return void
	 */
	function register_settings() {
		register_setting( 'eko_plugin_options', 'eko_plugin_options', array( $this, 'plugin_options_validate' ) );
		// general plugin section
		add_settings_section( 'eko_settings', 'eko plugin settings', array( $this, 'plugin_section_area' ), 'eko_plugin' );
		add_settings_field( 'eko_plugin_setting_env', 'API env', array( $this, 'plugin_setting_env' ), 'eko_plugin', 'eko_settings' );
		add_settings_field( 'eko_plugin_setting_slug', 'Slug for eko Video post type', array( $this, 'plugin_setting_slug' ), 'eko_plugin', 'eko_settings' );

		// http api settings
		// add_settings_section( 'eko_settings_api', 'Edit eko api settings', array( $this, 'plugin_api_area' ), 'eko_plugin' );
		// add_settings_field( 'eko_plugin_setting_api_key', 'API key', array( $this, 'plugin_setting_api_key' ), 'eko_plugin', 'eko_settings_api' );
		// add_settings_field( 'eko_plugin_setting_app_id', 'App Id', array( $this, 'plugin_setting_app_id' ), 'eko_plugin', 'eko_settings_api' );
		// add_settings_field( 'eko_plugin_setting_is_verified', 'Verified', array( $this, 'plugin_setting_is_verified' ), 'eko_plugin', 'eko_settings_api' );
	}

	/**
	 * add_main_admin_page
	 *
	 * Adding a custom admin page for the plugin
	 *
	 * @return void
	 */
	function add_main_admin_page() {
		add_menu_page(
			__( 'eko Options', 'my-textdomain' ),
			__( 'eko Options', 'my-textdomain' ),
			'manage_options',
			EKO_PLUGIN_PATH . '/includes/admin/templates/eko-admin-menu.php', // <- Load page content from file
			'',
			EKO_PLUGIN_URL . '/includes/images/eko_wp_admin_icon_mint.png',
			100
		);
	}

	///////////////////////////////////
	//////////// Helpers //////////////
	///////////////////////////////////

	/**
	 * plugin_options_validate
	 *
	 * @param  mixed $input
	 * @return mixed
	 */
	function plugin_options_validate( $input ) {
		$newinput = $input;
		// do validations
		// TODO...
		return $newinput;
	}
	/**
	 * plugin_section_area
	 *
	 * @return void
	 */
	function plugin_section_area() {
		echo '<p> Here you can set all the options for the eko plugin</p>';
	}
	/**
	 * plugin_setting_env
	 *
	 * @return void
	 */
	function plugin_setting_env() {
		$env = eko_get_option( 'env' );
		echo "<input id='eko_plugin_setting_env' name='eko_plugin_options[env]' type='text' value='" . $env
			. "' />";
		echo '<p>* It is adviced to leave the API env input empty, unless you specifically need to test different environments.</p>';
	}
	/**
	 * plugin_setting_slug
	 *
	 * @return void
	 */
	function plugin_setting_slug() {
		$slug = eko_get_option( 'slug' ) ? esc_attr( eko_get_option( 'slug' ) ) : EKO_DFAULT_CPT_SLUG;
		echo "<input id='eko_plugin_setting_slug' name='eko_plugin_options[slug]' type='text' value='" . $slug
			. "' placeholder='eko-videos' />";
	}
	/**
	 * plugin_edit_area
	 *
	 * @return void
	 */
	function plugin_edit_area() {
		echo '<p> Adjust the delay (seconds) to fetch video data from id</p>';
	}

	/**
	 * plugin_api_area
	 *
	 * @return void
	 */
	function plugin_api_area() {
		return;
	}
	/**
	 * plugin_setting_api_key
	 *
	 * @return void
	 */
	// function plugin_setting_api_key() {
	// 	$options = get_option( 'eko_plugin_options' );
	// 	echo "<input id='eko_plugin_setting_api_key' name='eko_plugin_options[apiKey]' type='text' value='" . esc_attr( $options['apiKey'] )
	// 		. "' placeholder='your eko api key' />";
	// }
	/**
	 * plugin_setting_app_id
	 *
	 * @return void
	 */
	// function plugin_setting_app_id() {
	// 	$options = get_option( 'eko_plugin_options' );
	// 	echo "<input id='eko_plugin_setting_app_id' name='eko_plugin_options[appId]' type='text' value='" . esc_attr( $options['appId'] )
	// 		. "' placeholder='your app Id' />";
	// }
	// function plugin_setting_is_verified() {
	// 	$options = get_option( 'eko_plugin_options' );
	// 	echo "<input id='eko_plugin_setting_is_verified' name='eko_plugin_options[verified]' readonly type='text' value='" . esc_attr( $options['verified'] ? 'true' : 'false' )
	// 		. "' />";
	// }

	function create_default_settings( $option, $name, $value ) {
		$options = get_option( $option );
		if ( $options === false || ! $options[ $name ] ) {
			if ( is_array( $options ) ) {
				$options[ $name ] = $value;
			} else {
				$options = array( $name => $value );
			}
		}
		update_option( 'eko_plugin_options', $options );
	}
}
