<?php

/**
 * @todo: aplica filtre pentru afisarea (sau nu) a link-urilor de: support si documentatie; logo: text/imagine;
 *        afisare; rollback: da/nu versiune plugin
 * @todo: anumite CSS-uri/JS-uri trebuiesc incarcate "global"; idee nume functie: global_backend_scripts /
 *        global_backend_styles
 * @todo: add defaults + reset to "defaults" button for the UI
 * @todo: add filters for add_menu_page function
 * @todo: trebuie gasita o solutie pt. adaugarea link-ului de "settings"; acum are URL-ul hardcodat
 */


/**
 * The dashboard-specific functionality of the plugin.
 */
class EPFW_Settings_Page extends EPFW_Plugin_Utilities {

	public $page_hook_suffix = '';
	protected $options_init_array = array();
	public $tabs_init_array = array();

	/**
	 *
	 * Initialize the class and set its properties.
	 *
	 */
	public function __construct( $options_init_array ) {

		$this->options_init_array = $options_init_array;


		// add the menu page
		add_action( 'admin_menu', [ $this, 'register_menu_page' ] );

		add_action( 'admin_init', [ $this, 'add_and_register_options' ] );

		// add hook for admin notices on save
		add_action( 'admin_notices', [ $this, 'show_admin_notice' ] );

		// load scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'global_backend_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'local_backend_scripts' ] );

		// load styles
		add_action( 'admin_enqueue_scripts', [ $this, 'local_backend_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'global_backend_styles' ] );

		//rollback
		add_filter( 'plugin_action_links_' . EPFW__PLUGIN_BASE, [ $this, 'extra_settings_links' ] );
		add_action( 'admin_post_epfw_rollback', [ $this, 'post_epfw_rollback' ] );

	}

	/**
	 * Add an extra link under plugins.php for our plugin.
	 *
	 * This will allow the users to rollback to a defined (considered stable) previous version
	 *
	 * @param array $links
	 *
	 * @return array
	 */
	function extra_settings_links( array $links ) {

		$links['settings'] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=sbp_settings' ), __( 'Settings', 'epfw' ) );
		$links['rollback'] = sprintf( '<a href="%s" class="epfw-rollback-button">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=epfw_rollback' ), 'epfw_rollback' ), __( 'Rollback version', 'epfw' ) );

		return $links;
	}

	/**
	 *
	 * This function needs to be hooked on admin_int as per the WordPress Codex Docs.
	 *
	 * It will loop over our array ($this->options_init_array) and use the info in there to register our settings.
	 *
	 */
	public function add_and_register_options() { //@todo: fix this shit

		if ( ! empty( $this->options_init_array ) ) {
			foreach ( $this->options_init_array as $tab_name => $settings_array_main ) {
				foreach ( $settings_array_main as $settings_array_id => $settings_array_value ) {

					if ( isset( $settings_array_id['type'] ) && $settings_array_id['type'] == 'field-group' ) {
						if ( isset( $settings_array_id['fields'] ) ) {
							$settings_array = $settings_array_value['fields'];
						}
					} else {
						$settings_array = $settings_array_value;
					}

					register_setting( EPFW__SETTINGS_TABLE_GROUP, // option_group, stays the same for all the options, this is what ties them together across tabs
						EPFW__SETTINGS_TABLE, // option_name, if it's defined when registering the fields, use that
						array(
							'default'           => isset( $settings_array['default'] ) ? $settings_array['default'] : null,
							'sanitize_callback' => call_user_func( array(
								$this,
								'sanitize_field_type',
							), $settings_array ),
						) ); // this will look like sanitize_field_type($field_type = array() )


					add_settings_section( $tab_name,                                  // Section ID
						$this->format_asset_name( $tab_name ),      //generate section title from tab; ex: general-options will turn into General Options
						null,                                       // no section settings description since we're using tabs
						EPFW__SETTINGS_TABLE                  // admin_menu slug OR page_slug; this will look like toplevel_page_{plugin_slug} OR 'epfw_settings_{tab_name}_{section_name}
					);


					add_settings_field( $settings_array_id,                             // Field ID
						isset( $settings_array['label'] ) ? $settings_array['label'] : $settings_array['title'],                                       // Field title
						array(
							$this,
							'render_field_type',
							// Field callback function; will call render_field_type ( $args = array() )
						), EPFW__SETTINGS_TABLE,                    // Settings page slug
						$tab_name,                                  // Settings Section ID
						$settings_array                       // $args, passed as array;
					);

				}
			}
		}
	}


	/**
	 * This function's used to register our menu page.
	 *
	 * Add_menu_page returns the plugin slug which we'll need later down when we're going to be only loading our assets
	 * on the plugin's page.
	 *
	 * See:
	 *
	 * @function local_backend_scripts
	 * @function local_backend_styles
	 *
	 */
	public function register_menu_page() {

		$this->page_hook_suffix = add_menu_page( __( 'Speed Booster Pack', 'epfw' ),                               // page title
			__( 'Testing', 'epfw' ),                                // menu title
			'manage_options',                                       // capability
			EPFW__SETTINGS_TABLE,                                // menu-slug; we'll use the same menu_slug as the DB options
			array(                                                  // callback function to render the options page
			                                                        $this,
			                                                        'render_settings_page',
			), 'dashicons-carrot'                                // menu item icon
		);
	}

	/**
	 * This function handles the actual options page rendering
	 */
	public function render_settings_page() {

		// Check that the user is actually allowed to access the options page
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'epfw' ) );
		}
		?>

		<div class="epfw-masthead">
			<div class="epfw-container">
				<div class="epfw-masthead-title">
					<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
					<span class="epfw-version"><?php echo EPFW__PLUGIN_VERSION; ?></span>
				</div>
				<div class="epfw-masthead-links">
					<a href="https://www.machothemes.com/contact-us-now/"><?php _e( 'Support', 'sb-pack' ); ?></a>
					<a href="https://www.machothemes.com/help/speed-booster-pack/"><?php _e( 'Documentation', 'sb-pack' ); ?></a>
				</div>
			</div><!--/.epfw-container-->
		</div><!--/.epfw-admin-top-bar-->
		<div class="wp-clearfix"></div>

		<div class="wrap epfw-container epfw-wrap">

			<form method="post" action="options.php">
				<?php
				// this is all we need to render our actual options page content

				settings_fields( EPFW__SETTINGS_TABLE_GROUP );
				$this->do_settings_sections( EPFW__SETTINGS_TABLE );

				echo '<div class="textright">';
				submit_button( __( 'Save settings', 'sb-pack' ), 'button button-primary button-hero', null, false );
				echo '</div>';
				?>
			</form>
		</div>

		<hr />
		<br />
		<?php echo 'blabla'; ?>
		<br />
		<hr />

		<?php
	}


	/**
	 * @param $args
	 */
	public function sanitize_field_type( $args ) {

	}

	/**
	 *
	 * This is the function responsible with rendering the actual field types
	 *
	 *
	 * @param $args
	 */
	public function render_field_type( $args ) { // @todo: rescrie asta, case-urile ar trebui gestionate in EPFW_Field_Render

		$renderer = new EPFW_Field_Render();

		switch ( $args['type'] ) {
			case 'text':
				$renderer->render_text_field( $args );
				break;
			case 'toggle':
				$renderer->render_toggle_field( $args );
				break;
			case 'js-script-handler':
				$renderer->render_js_scripts_handler_field( $args );
				break;
			case 'checkbox':
				$renderer->render_checkbox_field( $args );
				break;
			case 'field-group':
				$renderer->render_group( $args );
				break;
		}

	}

	/**
	 * Function to load back-end specific JS Scripts
	 *
	 * @param $hook
	 */
	public function local_backend_scripts( $hook ) {

		if ( $hook !== $this->page_hook_suffix ) {
			return;
		}
	}

	public function global_backend_scripts( $hook ) {

		// register scripts
		wp_register_script( 'epfw-dialog-script', EPFW__PLUGINS_URL . 'inc/back-end/assets/vendors/dialog/dialog.min.js', array(
			'jquery',
		), EPFW__PLUGIN_VERSION, true );


		wp_register_script( 'epfw-admin-scripts', EPFW__PLUGINS_URL . 'inc/back-end/assets/js/admin-script.js', array(
			'jquery',
			'jquery-ui-accordion',
			'epfw-dialog-script',
		), EPFW__PLUGIN_VERSION, true );

		wp_localize_script( 'epfw-admin-scripts', 'ElementorAdminConfig', [
			'home_url' => home_url(),
			'i18n'     => [
				'rollback_confirm'             => __( 'Are you sure you want to reinstall previous version?', 'epfw' ),
				'rollback_to_previous_version' => __( 'Rollback to Previous Version', 'epfw' ),
				'yes'                          => __( 'Yes', 'epfw' ),
				'cancel'                       => __( 'Cancel', 'epfw' ),
			],
		] );


		// enqueue scripts
		wp_enqueue_script( 'epfw-dialog-script' );
		wp_enqueue_script( 'epfw-admin-scripts' );

	}

	/**
	 * Function to load LOCAL back-end specific stylesheets
	 *
	 * @param $hook
	 */
	public function local_backend_styles( $hook ) {

		if ( $hook !== $this->page_hook_suffix ) {
			return;
		}

		// register styles
		wp_register_style( 'epfw-wpadmin-utilities', EPFW__PLUGINS_URL . 'inc/back-end/assets/css/admin-utilities.css', false, EPFW__PLUGIN_VERSION );
		wp_register_style( 'epfw-wpadmin-style', EPFW__PLUGINS_URL . 'inc/back-end/assets/css/admin-style.css', false, EPFW__PLUGIN_VERSION );

		// enqueue styles
		wp_enqueue_style( 'epfw-wpadmin-utilities' );
		wp_enqueue_style( 'epfw-wpadmin-style' );
	}


	/**
	 * Function to load GLOBAL back-end specific stylesheets
	 *
	 * @param $hook
	 */
	public function global_backend_styles( $hook ) {


		// register styles
		wp_register_style( 'epfw-wpadmin-utilities', EPFW__PLUGINS_URL . 'inc/back-end/assets/css/admin-utilities.css', false, EPFW__PLUGIN_VERSION );


		// enqueue styles
		wp_enqueue_style( 'epfw-wpadmin-utilities' );

	}

	/**
	 * Helper function for creating admin messages
	 *
	 * @param (string) $message The message to echo
	 * @param (string) $msgclass The message class
	 *
	 * @return the message
	 *
	 * $msgclass possible values: info / error
	 *
	 */
	public function show_admin_notice() {

		/*
		if ( isset( $_POST[ $this->settings_field ] ) && check_admin_referer( 'kiwi_settings_nonce', '_wpnonce' ) ) {
			echo '<div class="notice updated is-dismissible">' . __( 'Settings updated successfully!', 'kiwi-social-share' ) . '</div>';
		}
		*/
	}

	/**
	 * Small rewrite of the Core version of do_settings_sections.
	 *
	 * The purpose here is to generate the necessary mark-up to render our tabbed interface. No core functionality has
	 * actually been removed.
	 *
	 * In lack of proper filters, this is what we have to do.
	 *
	 * @param $page
	 */
	public function do_settings_sections( $page ) {
		global $wp_settings_sections, $wp_settings_fields;


		if ( ! isset( $wp_settings_sections[ $page ] ) ) {
			return;
		}


		// we need to first render just the links outside the whole wrapper
		echo '<h2 class="epfw-tab-wrapper nav-tab-wrapper wp-clearfix">';
		foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
			if ( $section['title'] ) {
				echo "<a class='epfw-tab nav-tab' href='#" . esc_attr( $section['id'] ) . "'>{$section['title']}</a>\n";
			}
		}

		echo '</h2><!--/.end-nav-tab-wrapper-->';

		foreach ( (array) $wp_settings_sections[ $page ] as $section ) {


			echo '<div class="epfw-turn-into-tab" id="' . esc_attr( $section['id'] ) . '">';
			if ( $section['callback'] ) {
				call_user_func( $section['callback'], $section );
			}

			if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
				continue;
			}


			$this->do_settings_fields( $page, $section['id'] );

			echo '</div><!--/.epfw-turn-into-tab-->';

		}
	}

	function do_settings_fields( $page, $section ) {
		global $wp_settings_fields;

		if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
			return;
		}

		foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {

			echo '<div class="epfw-field-wrapper">';

			if ( isset( $field['args']['title'] ) ) {
				echo '<div class="epfw-heading">' . esc_html( $field['args']['title'] ) . '</div><!--/.epfw-heading-->';
			} else {
				echo '<div class="epfw-heading">' . esc_html( $field['title'] ) . '</div><!--/.epfw-heading-->';
			}


			echo '<div class="epfw-field-group">';
			call_user_func( $field['callback'], $field['args'] );
			echo '<div class="wp-clearfix"></div>';
			echo '</div><!--/.epfw-field-group-->';


			echo '</div><!--/.epfw-field-wrapper-->';
		}
	}




	/**
	 * Elementor version rollback.
	 *
	 * Rollback to previous Elementor version.
	 *
	 * Fired by `admin_post_epfw_rollback` action.
	 *
	 * @since  1.5.0
	 * @access public
	 */
	public function post_epfw_rollback() {

		check_admin_referer( 'epfw_rollback' );

		$plugin_slug = basename( EPFW__FILE__, '.php' );

		$rollback = new Rollback( [
			'version'     => EPFW__PREVIOUS_PLUGIN_VERSION,
			'plugin_name' => EPFW__PLUGIN_BASE,
			'plugin_slug' => $plugin_slug,
			'package_url' => sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, EPFW__PREVIOUS_PLUGIN_VERSION ),
		] );

		$rollback->run();

		wp_die( '', __( 'Rollback to Previous Version', 'epfw' ), [
			'response' => 200,
		] );
	}
}