<?php
/*
* Get latest version
*/
if ( ! function_exists( 'botonomics_feedback_include_init' ) ) {
	function botonomics_feedback_include_init( $base ) {
		global $botonomics_options, $botonomics_active_plugin;
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		$wp_plugins_dir = plugins_url();

		$botonomics_dir                    = $wp_plugins_dir . '/' . dirname( $base ) . '/plugin.php';
		$botonomics_active_plugin[ $base ] = get_plugin_data( $wp_plugins_dir . '/' . $base );


		if ( ! function_exists( 'botonomics_admin_enqueue_scripts' ) ) {
			function botonomics_admin_enqueue_scripts() {
				global $hook_suffix;
				if ( 'plugins.php' === $hook_suffix ) {
					if ( ! defined( 'DOING_AJAX' ) ) {
						//wp_enqueue_style( 'botonomics-modal-css', plugin_dir_url(__FILE__) .'css/modal.css' );
						
					}
				}
			}
		}
		add_action( 'admin_enqueue_scripts', 'botonomics_admin_enqueue_scripts' );
	}
}
