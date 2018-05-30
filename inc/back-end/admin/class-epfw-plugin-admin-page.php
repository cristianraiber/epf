<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @todo: fix sanitize callback - sanitize_field (should also make sure this hooks into add_settings_errors); https://wordpress.stackexchange.com/a/78045
 * @todo: add defaults for each field type rendering function
 * @todo: add default values for each field in init.php
 */


/**
 * The dashboard-specific functionality of the plugin.
 */
class EPFW_Plugin_Admin_Page {

	/**
	 * Main plugin options table name
	 *
	 * Holds the plugin options table name.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string $settings_table_name.
	 */
	protected $settings_table_name = '';

	/**
	 * Page Hook Suffix.
	 *
	 * Holds the admin menu page string, resulted from add_menu_page.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var string page_hook_suffix.
	 */
	protected $page_hook_suffix = '';

	/**
	 * Holds the options array, coming from init.php and used in the constructor
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array
	 */
	protected $field_args = array();

	/**
	 * Register plugin hooks & options fields
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $field_args
	 * @param array $menu_args
	 * @param string $settings_table_name
	 */
	public function __construct( $field_args = array(), $menu_args = array(), $settings_table_name = 'epfw_settings' ) {

		$this->field_args          = $field_args;
		$this->menu_args           = $menu_args;
		$this->settings_table_name = $settings_table_name;

		// add the menu page
		add_action( 'admin_menu', array( $this, 'register_menu_page' ) );

		// add a custom body class
		add_filter( 'admin_body_class', array( $this, 'body_class' ) );

		// add & register options through add_
		add_action( 'admin_init', array( $this, 'add_and_register_options' ) );

		// add hook for admin notices on save
		add_action( 'admin_notices', array( $this, 'show_admin_notice' ) );

		// load scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'global_backend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'local_backend_scripts' ) );

		// load styles
		add_action( 'admin_enqueue_scripts', array( $this, 'local_backend_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'global_backend_styles' ) );

		// custom plugin action links
		add_filter( 'plugin_action_links_' . EPFW__PLUGIN_BASE, array( $this, 'extra_settings_links' ) );

		// custom action hooks
		add_action( 'epfw_print_form', array( $this, 'print_options_form' ) );
		add_action( 'epfw_print_form_buttons', array( $this, 'print_form_buttons' ) );
		add_action( 'epfw_print_changelog', array( $this, 'print_changelog' ) );
		add_action( 'epfw_print_masthead', array( $this, 'print_masthead' ) );

		/**
		 * WP Core function for showing admin notices
		 * @see: https://codex.wordpress.org/Function_Reference/settings_errors
		 */
		add_action( 'epfw_print_masthead_after', 'settings_errors' );

	}

	/**
	 * Used to add a custom CSS class to the admin_body
	 *
	 * @param [type] $classes
	 * @uses apply_filters epfw_admin_body_class
	 *
	 * @return string
	 */
	public function body_class( $classes ) {

		$current_screen = get_current_screen();

		if ( $current_screen->id === $this->page_hook_suffix ) {
			$classes .= ' epfw-plugin-page ';
		}

		return apply_filters( 'epfw_admin_body_class', $classes );
	}

	/**
	 * Add an extra link under plugins.php for our plugin.
	 *
	 * This will allow the users to rollback to a defined (considered stable) previous version
	 *
	 * @param array $links
	 *
	 * @uses apply_filters epfw_show_settings_link
	 * @uses apply_filters epfw_show_rollback_link
	 *
	 * @return array
	 */
	function extra_settings_links( array $links ) {

		if ( apply_filters( 'epfw_show_settings_link', true ) ) {
			// reuse the $menu_args['slug'] as the page slug
			$links['settings'] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=' . esc_url( $this->menu_args['slug'] ) ), __( 'Settings', 'epfw' ) );
		}

		if ( apply_filters( 'epfw_show_rollback_link', true ) ) {
			$links['rollback'] = sprintf( '<a href="%s" class="epfw-rollback-button">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=epfw_rollback' ), 'epfw_rollback' ), __( 'Rollback version', 'epfw' ) );
		}

		return $links;
	}

	/**
	 *
	 * This function needs to be hooked on admin_int as per the WordPress Codex Docs.
	 *
	 * It will loop over our array ($this->field_args) and use the info in there to register our settings.
	 *
	 */
	public function add_and_register_options() {

		/**
		 * @see: https://developer.wordpress.org/reference/functions/register_setting/
		 *
		 * <code>
		 * register_setting(
		 * string $option_group,
		 * string $option_name,
		 * array $args = array()
		 * )
		 * </code>
		 *
		 * - option_group, stays the same for all the options, this is what ties them together across tabs
		 */
		register_setting(
			esc_html( (string) $this->settings_table_name ),
			esc_html( (string) $this->settings_table_name ),
			array(
				'sanitize_callback' => array(
					$this,
					'sanitize_field',
				),
				'show_in_rest'      => false,
			)
		);

		if ( is_array( $this->field_args ) && ! empty( $this->field_args ) ) {

			foreach ( $this->field_args as $settings_array_values ) {

				/**
				 * @see: https://codex.wordpress.org/Function_Reference/add_settings_section#Parameters
				 *
				 * <code>
				 * add_settings_section(
				 * (string) (required) $id  String for use in the 'id' attribute of tags.
				 * (string) (required) $title Title of the section.
				 * (string) (required) $callback Function that fills the section with the desired content. The function should echo its output.
				 * (string) (required) $page The menu page on which to display this section
				 * );
				 * </code>
				 *
				 * - Generate section title from tab; ex: general-options will turn into General Options
				 * - No callback function, since we're not using any section descriptions
				 */
				$_tab = isset( $settings_array_values['tab'] ) ? $settings_array_values['tab'] : '';

				add_settings_section(
					esc_html( (string) $_tab ),
					esc_html( (string) $this->format_asset_name( $_tab ) ),
					null,
					esc_html( (string) $this->settings_table_name )
				);

				/**
				 * @see: https://codex.wordpress.org/Function_Reference/add_settings_field
				 *
				 * <code>
				 * add_settings_field(
				 * (string) (required) $id - String for use in the 'id' attribute of tags.
				 * (string) (required) $title - Title of the field
				 * (function) (required) $callback - Name and id of the input should match the $id given to this function. The function should echo its output
				 * (string) (required) $page - Should match $menu_slug from add_theme_page() or from do_settings_sections().
				 * (string) (optional) $section - The section of the settings page in which to show the box
				 * (array) (optional) $args - Additional arguments that are passed to the $callback function
				 * );
				 * </code>
				 *
				 * - $settings_array['label/title'] - if we're missing the 'label' it means we're looping over the main "well" element title
				 * - Field callback function; will call render_field() and takes the $settings_array as a param
				 */

				$_label = isset( $settings_array_values['label'] ) ? $settings_array_values['label'] : $settings_array_values['title'];

					add_settings_field(
						esc_html( (string) $this->settings_table_name ),
						esc_html( (string) $_label ),
						array(
							$this,
							'render_field',
						),
						esc_html( (string) $this->settings_table_name ),
						esc_html( (string) $_tab ),
						(array) $settings_array_values
					);
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

		/**
		 * menu defaults array
		 *
		 * @uses apply_filters epfw_menu_defaults
		 * @uses apply_filters epfw_menu_args
		 */
		$menu_defaults = apply_filters(
			'epfw_menu_defaults', array(
				'page_title' => esc_html__( 'Welcome to EPFW', 'epfw' ),
				'menu_title' => esc_html__( 'EPFW Page', 'epfw' ),
				'cap'        => 'manage_options',
				'slug'       => 'options',
				'callback'   => array( $this, 'render_settings_page' ),
				'menu_icon'  => 'dashicons-carrot',
				'position'   => null,
			)
		);

		$args = wp_parse_args( $this->menu_args, $menu_defaults );
		$args = apply_filters( 'epfw_menu_args', $args );

		/**
		* add_menu_page uses:
		*
		* string $page_title,
		* string $menu_title,
		* string $capability,
		* string $menu_slug,
		* callable $function = '',
		* string $icon_url = '',
		* int $position = null
		*/
		$this->page_hook_suffix = add_menu_page(
			$args['page_title'],
			$args['menu_title'],
			$args['cap'],
			$args['slug'],
			$args['callback'],
			$args['menu_icon'],
			$args['position']
		);

	}

	/**
	 * This function handles the actual options page rendering
	 */
	public function render_settings_page() { ?>

				<div class="epfw-masthead">
					<div class="epfw-container">
						<?php
						do_action( 'epfw_print_masthead_before' );
						do_action( 'epfw_print_masthead' );
						do_action( 'epfw_print_masthead_after' );
						?>
					</div><!--/.epfw-container-->
				</div><!--/.epfw-admin-top-bar-->
				<div class="wp-clearfix"></div>

				<div class="wrap epfw-container epfw-wrap">
					<?php
					do_action( 'epfw_print_form_before' );
					do_action( 'epfw_print_form' );
					do_action( 'epfw_print_form_after' );
					?>
				</div>

				<?php
				do_action( 'epfw_print_changelog_before' );
				do_action( 'epfw_print_changelog' );
				do_action( 'epfw_print_changelog_after' );
	}

	/**
	 * Settings Sanitization
	 *
	 * Adds a settings error (for the updated message)
	 * At some point this will validate input
	 *
	 * @since 1.0.0
	 *
	 * @param array $input The value inputted in the field
	 * @global array $edd_options Array of all the EDD Options
	 *
	 * @return string $input Sanitized value
	 */
	public function sanitize_field( $input = array() ) {

		return $input;
	}



	/**
	 *
	 * This is the function responsible with rendering the actual field types
	 *
	 *
	 * @param $args
	 */
	public function render_field( $args ) {

		if ( isset( $args['type'] ) ) {
			switch ( $args['type'] ) {
				case 'text':
					$this->render_text_field( $args );
					break;
				case 'toggle':
					$this->render_toggle_field( $args );
					break;
				case 'checkbox':
					$this->render_checkbox_field( $args );
					break;
				case 'field-group':
					$this->render_group( $args );
					break;
				case 'slide-up-group':
					$this->render_slide_up_group( $args );
					break;
			}
		}
	}

	/**
	 * Function to load LOCAL back-end specific JS Scripts
	 * LOCAL = (only on the plugin page)
	 *
	 * @param $hook
	 */
	public function local_backend_scripts( $hook ) {

		if ( $hook !== $this->page_hook_suffix ) {
			return;
		}

		wp_register_script(
			'epfw-admin-scripts', EPFW__PLUGINS_URL . 'inc/back-end/assets/js/admin-script.js', array(
				'jquery',
			), EPFW__PLUGIN_VERSION, true
		);

		wp_enqueue_script( 'epfw-admin-scripts' );
	}

	/**
	 * Function used to load GLOBAL JS scripts
	 * GLOBAL = ( anywhere in the admin dashboard )
	 */
	public function global_backend_scripts() {

	}

	/**
	 * Function to load LOCAL back-end specific stylesheets
	 * LOCAL = (only in the plugin page)
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
	 * Function used to load GLOBAL CSS stylesheets
	 *  GLOBAL = ( anywhere in the admin dashboard )
	 *
	 */
	public function global_backend_styles() {

		// register styles
		wp_register_style( 'epfw-wpadmin-utilities', EPFW__PLUGINS_URL . 'inc/back-end/assets/css/admin-utilities.css', false, EPFW__PLUGIN_VERSION );

		// enqueue styles
		wp_enqueue_style( 'epfw-wpadmin-utilities' );

	}

	/**
	 * Helper function for creating admin messages
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
	 * Helper function used for formatting asset names
	 *
	 * @param $asset_name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function format_asset_name( $asset_name ) {

		$asset_name = str_replace( '/', '', $asset_name );
		$asset_name = str_replace( '_', ' ', $asset_name );
		$asset_name = str_replace( '-', ' ', $asset_name );
		$asset_name = ucwords( $asset_name ); // capitalize

		return $asset_name;
	}

	/**
	 * The function that handles the printing of our options form
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function print_options_form() {
		echo '<form method="post" action="options.php">';

		settings_fields( $this->settings_table_name );
		$this->do_settings_sections( $this->settings_table_name );
		do_action( 'epfw_print_form_buttons' );

		echo '</form>';
	}

	public function print_form_buttons() {

		// defaults
		$form['restore']      = __( 'Restore defaults', 'epfw' );
		$form['submit']       = __( 'Save settings', 'epfw' );
		$form['show_restore'] = true;
		$form['show_submit']  = true;

		// filter
		$form = apply_filters( 'epfw_form_buttons', $form );

		echo '<div class="epfw-float-left">';
		submit_button( esc_html__( 'Restore defaults', 'epfw' ), 'button button-secondary', null, false );
		echo '</div>';

		echo '<div class="epfw-float-right">';
		submit_button( esc_html__( 'Save settings', 'epfw' ), 'button button-primary', null, false );
		echo '</div>';

		echo '<div class="wp-clearfix"></div>';
		echo '<br /><br />';
	}

	/**
	 * Handles the masthead section of our plugin page
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses apply_filters epfw_masthead
	 *
	 * @return void
	 */
	public function print_masthead() {

		// defaults
		$masthead['support_text'] = __( 'Support', 'epfw' );
		$masthead['support_href'] = EPFW__SUPPORT_HREF;
		$masthead['docs_text']    = __( 'Documentation', 'epfw' );
		$masthead['docs_href']    = EPFW__DOCUMENTATION_HREF;
		$masthead['title']        = get_admin_page_title();
		$masthead['docs_show']    = true;
		$masthead['support_show'] = true;

		// filters
		$masthead = apply_filters( 'epfw_masthead', $masthead );

		// Masthead title
		echo '<div class="epfw-masthead-title">';
		echo '<h1>' . esc_html( $masthead['title'] ) . '</h1>';
		echo '</div>';

		// Masthead links
		echo '<div class="epfw-masthead-links">';

		// Show support link
		if ( $masthead['support_show'] && isset( $masthead['support_href'] ) ) {
			echo sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				esc_url( $masthead['support_href'] ),
				esc_html( $masthead['support_text'] )
			);
		}

		// Show documentation link
		if ( $masthead['docs_show'] && isset( $masthead['docs_href'] ) ) {
			echo sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				esc_url( $masthead['docs_href'] ),
				esc_html( $masthead['docs_text'] )
			);
		}

		echo '</div><!--/.epfw-masthead-links-->';
	}

	/**
	 * Handles the changelog section of our plugin page
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function print_changelog() {

		// vars
		$changelog['text']                  = __( 'Changelog', 'epfw' );
		$changelog['target']                = '_blank';
		$changelog['version']               = EPFW__PLUGIN_VERSION;
		$changelog['href']                  = EPFW__CHANGELOG_HREF;
		$changelog['show_plugin_version']   = true;
		$changelog['show_plugin_changelog'] = true;

		// general filters
		$changelog = apply_filters( 'epfw_changelog', $changelog );

		if ( $changelog['show_plugin_changelog'] || $changelog['show_plugin_version'] ) {
			echo '<div class="epfw-changelog">';
		}
		if ( $changelog['show_plugin_changelog'] ) {
			echo sprintf(
				'<span class="epfw-changelog-version">%1$s</span>',
				esc_html( $changelog['version'] )
			);
		}

		if ( $changelog['show_plugin_version'] ) {
			echo sprintf(
				'<a class="epfw-changelog-link" href="%1$s" title="%2$s" target="%3$s">%4$s</a>',
				esc_url( $changelog['href'] ),
				esc_attr( $changelog['text'] ),
				esc_attr( $changelog['target'] ),
				esc_html( $changelog['text'] )
			);
		}

		if ( $changelog['show_plugin_changelog'] || $changelog['show_plugin_version'] ) {
			echo '</div><!--/.epfw-changelog-->';
		}
	}


	protected function _compose_db_name( string $id ) {

		if ( null !== $id ) {
			return $this->settings_table_name . '[' . esc_attr( $id ) . ']';
		}
	}

	protected function _compose_get_option( string $id ) {

		if ( null !== $id ) {
			return $this->get_option_value( $id, $this->settings_table_name );
		}

	}

	/**
	 * Function that is responsible for checking if an option has a value in it or not.
	 *
	 * Returns false if it doesn't
	 *
	 * @param $option_id    string      actual option to search for in DB (if omitted, will return whole table;
	 *                      assuming single option value not array)
	 * @param $table        array      DB table to look in for
	 *
	 * Ex: in 'plugin_settings' table look for & return the value of 'font_size'
	 * Ex2: return the whole contents of 'plugin_settings' as long as $single is set to TRUE
	 *
	 * @since   1.0.0
	 *
	 * @return      array Options DB value
	 */
	public function get_option_value( $option_id = '', $table ) {

		$options = get_option( $table, array() );

		if ( ! empty( $option_id ) ) {
			if ( ! empty( $options[ $option_id ] ) ) {
				return $options[ $option_id ];
			}
		} else {
			return $options;
		}
	}

	public function _field_description( $description ) {

		if ( empty( $description ) ) {
			echo '<div class="epfw-field half-spaced">';
		} else {
			echo '<div class="epfw-field">';
		}
	}

	/**
	 * Function responsible for rendering text field types
	 *
	 * @param $args
	 */
	public function render_text_field( $args ) {
		?>

		<?php

		$this->_field_description( $args['description'] );

		?>

		<?php if ( isset( $args['label'] ) ) { ?>
			<label for="<?php echo esc_attr( $args['id'] ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
		<?php } ?>
		<br />
		<?php if ( isset( $args['tooltip'] ) ) { ?>
			<span class="tooltip-right" data-tooltip="<?php echo esc_attr( $args['tooltip'] ); ?>"> <i class="dashicons dashicons-editor-help"></i></span>
		<?php } ?>

		<input id="<?php echo esc_attr( $args['id'] ); ?>" class="regular-text" name="<?php echo esc_attr( $this->_compose_db_name( $args['id'] ) ); ?>" type="textarea" value="<?php echo sanitize_text_field( $this->_compose_get_option( $args['id'] ) ); ?>">

		</div> <!--/.epfw-field-->

	<?php
	}

	/**
	 * @param $args
	 */
	public function render_toggle_field( $args ) {

	}

	public function render_checkbox_field( $args ) {
		?>

		<?php

		$this->_field_description( $args['description'] );

		?>

		<input id="<?php echo esc_attr( $args['id'] ); ?>" type="checkbox" name="<?php echo esc_attr( $this->_compose_db_name( $args['id'] ) ); ?>" <?php checked( 1, $this->_compose_get_option( $args['id'] ), true ); ?> value="1">

		<?php if ( isset( $args['label'] ) ) { ?>
			<label for="<?php echo esc_attr( $args['id'] ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
		<?php } ?>
		<?php if ( isset( $args['tooltip'] ) ) { ?>
			<span class="tooltip-right" data-tooltip="<?php echo esc_attr( $args['tooltip'] ); ?>"> <i class="dashicons dashicons-info"></i></span>
		<?php } ?>
		<?php if ( isset( $args['description'] ) ) { ?>
			<div class="description"><i><?php echo esc_html( $args['description'] ); ?></i></div>
		<?php } ?>

		</div><!--/.epfw-field-->

		<?php if ( isset( $args['separator'] ) ) { ?>
			<div class="epfw-separator"></div>
		<?php } ?>

	<?php
	}

	public function render_group( $args ) {

		if ( isset( $args['fields'] ) ) {
			foreach ( $args['fields'] as $key => $value ) {
				if ( isset( $value['type'] ) ) {
					if ( 'text' === $value['type'] ) {
						$this->render_text_field( $value );
					}
					if ( 'checkbox' === $value['type'] ) {
						$this->render_checkbox_field( $value );
					}
					if ( 'slide-up-group' === $value['type'] ) {
						$this->render_slide_up_group( $value );
					}
				}
			}
		}

	}

	/**
	 * @param $args
	 */
	public function render_slide_up_group( $args ) {

		echo '<div id="' . esc_attr( $args['id'] ) . '" class="epfw-field-slide-up-wrapper">';
		echo '<div class="epfw-field-slide-up-header">';
		echo '<h3 class="epfw-accordion-heading">' . $args['label'] . '</h3>';
		echo '<a class="epfw-accordion-handle" href="#' . esc_attr( $args['id'] ) . '"><i class="dashicons dashicons-arrow-down-alt2"></i></a>';
		echo '</div><!--/.epfw-field-slide-up-header-->';
		echo '<div class="epfw-accordion-wrapper">';

		foreach ( $args['fields'] as $v ) {

			if ( 'text' === $v['type'] ) {
				$this->render_text_field( $v );
			}
			if ( 'checkbox' === $v['type'] ) {
				$this->render_checkbox_field( $v );
			}
		}
		echo '</div><!--/.epfw-accordion-wrapper-->';

		echo '</div><!--/.epfw-field-slide-up-wrapper-->';

	}

}
