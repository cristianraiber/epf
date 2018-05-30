<?php

class EPFW_Plugin_RollBack {

	public function __construct() {

		/**
		 * $_POST action hook
		 *
		 * @see: https://codex.wordpress.org/Plugin_API/Action_Reference/admin_post_(action)
		 *
		 */
		add_action( 'admin_post_epfw_rollback', array( $this, 'post_epfw_rollback' ) );

		/**
		 * Hook responsible for loading our Rollback JS script
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'rollback_scripts' ) );

	}

	/**
	 * EPFW version rollback.
	 *
	 * Rollback to previous {plugin} version.
	 *
	 * Fired by `admin_post_epfw_rollback` action.
	 *
	 * @since  1.5.0
	 * @access public
	 */
	public function post_epfw_rollback() {

		check_admin_referer( 'epfw_rollback' );

		$plugin_slug = basename( EPFW__FILE__, '.php' );

		// check for const defines
		if ( ! defined( 'EPFW__PREVIOUS_PLUGIN_VERSION' ) || ! defined( 'EPFW__PLUGIN_BASE' ) ) {
			wp_die(
				new WP_Error( 'broke', esc_html__( 'Previous plugin version or plugin basename CONST aren\'t defined.', 'epfw' ) )
			);
		}

		if ( class_exists( 'EPFW_Rollback' ) ) {
			$rollback = new EPFW_Rollback(
				[
					'version'     => EPFW__PREVIOUS_PLUGIN_VERSION,
					'plugin_name' => EPFW__PLUGIN_BASE,
					'plugin_slug' => $plugin_slug,
					'package_url' => sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, EPFW__PREVIOUS_PLUGIN_VERSION ),
				]
			);
			$rollback->run();
		}

		wp_die(
			'', __( 'Rollback to Previous Version', 'epfw' ), [
				'response' => 200,
			]
		);
	}

	public function rollback_scripts() {

		// register scripts
		wp_register_script(
			'epfw-dialog-script', EPFW__PLUGINS_URL . 'inc/back-end/assets/vendors/dialog/dialog.min.js', array(
				'jquery',
			), EPFW__PLUGIN_VERSION, true
		);

		wp_register_script(
			'epfw-rollback-script', EPFW__PLUGINS_URL . 'inc/back-end/assets/js/rollback-script.js', array(
				'epfw-dialog-script',
			), EPFW__PLUGIN_VERSION, true
		);

		wp_localize_script(
			'epfw-rollback-script', 'EPFWRollbackConfig', [
				'home_url' => home_url(),
				'i18n'     => [
					'rollback_confirm'             => __( 'Are you sure you want to reinstall previous version?', 'epfw' ),
					'rollback_to_previous_version' => __( 'Rollback to Previous Version', 'epfw' ),
					'yes'                          => __( 'Yes', 'epfw' ),
					'cancel'                       => __( 'Cancel', 'epfw' ),
				],
			]
		);

		// enqueue scripts
		wp_enqueue_script( 'epfw-dialog-script' );
		wp_enqueue_script( 'epfw-rollback-script' );

	}
}

new EPFW_Plugin_Rollback();
