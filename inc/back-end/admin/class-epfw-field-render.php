<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class EPFW_Field_Render {

	protected $_save_in_db_field = '';
	protected $_db_field_type    = '';

	/**
	 * Receives an $args array and passes on the info to the required field type for rendering
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {

		if ( isset( $args['type'] ) ) {
			switch ( $args['type'] ) {
				case 'text':
					$this->render_text_field( $args );
					break;
				case 'toggle':
					$this->render_toggle_field( $args );
					break;
				case 'js-script-handler':
					$this->render_js_scripts_handler_field( $args );
					break;
				case 'checkbox':
					$this->render_checkbox_field( $args );
					break;
				case 'field-group':
					$this->render_group( $args );
					break;
			}
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

	/**
	 * Sanity check for DB schema
	 *
	 * @param array $args
	 *
	 * @return bool
	 */
	protected function check_for_db_schema( $args = array() ) {

		if ( isset( $args['db_schema'] ) && is_array( $args['db_schema'] ) ) { // mandatory to have a save_in_db_field as long as db_schema is defined

			if ( isset( $args['db_schema']['save_in_db_field'] ) ) {
				$this->_save_in_db_field = $args['db_schema']['save_in_db_field'];

				if ( isset( $args['db_schema']['db_field_type'] ) ) {
					$this->_db_field_type = $args['db_schema']['db_field_type'];
				}
			}
		} else { // no DB schema defined
			return false;
		}
	}

	protected function _field_description( $description ) {

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
	public function render_text_field( $args ) { ?>

		<?php

		$this->_field_description( $args );

		?>

		<?php if ( isset( $args['label'] ) ) { ?>
			<label for="<?php echo esc_attr( $args['id'] ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
		<?php } ?>
		<br />
		<?php if ( isset( $args['tooltip'] ) ) { ?>
			<span class="tooltip-right" data-tooltip="<?php echo esc_attr( $args['tooltip'] ); ?>"> <i class="dashicons dashicons-editor-help"></i></span>
		<?php } ?>

		<input id="<?php echo esc_attr( $args['id'] ); ?>" class="regular-text" name="<?php echo esc_attr( EPFW__SETTINGS_TABLE ) . '[' . esc_attr( $args['id'] ) . ']'; ?>" type="textarea" value="<?php echo sanitize_text_field( $this->get_option_value( $args['id'], EPFW__SETTINGS_TABLE ) ); ?>">

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

		$this->_field_description( $args );

		?>

		<input id="<?php echo esc_attr( $args['id'] ); ?>" type="checkbox" name="<?php echo esc_attr( EPFW__SETTINGS_TABLE ) . '[' . esc_attr( $args['id'] ) . ']'; ?>" <?php checked( 1, $this->get_option_value( $args['id'], EPFW__SETTINGS_TABLE ), true ); ?> value="1">

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

	/**
	 * @param $args
	 */
	public function render_js_scripts_handler_field( $args ) {

		if ( $this->check_for_db_schema( $args ) !== false ) {
			?>

			<?php if ( $this->_db_field_type == 'array' ) { ?>
				<input class="regular-text" name="<?php echo esc_attr( $this->_save_in_db_field ); ?>" type="text" value="<?php echo sanitize_text_field( $this->get_option_value( $args['id'], $this->_save_in_db_field ) ); ?>">
			<?php } else { ?>
				<input class="regular-text" name="<?php echo esc_attr( $this->_save_in_db_field ); ?>" type="text" value="<?php echo sanitize_text_field( $this->get_option_value( '', $this->_save_in_db_field ) ); ?>">
			<?php } ?>

			<?php
		}
	}

	public function render_group( $args ) {

		if ( isset( $args['fields'] ) ) {
			foreach ( $args['fields'] as $key => $value ) {

				if ( isset( $value['type'] ) ) {
					if ( $value['type'] == 'text' ) {
						$this->render_text_field( $value );
					}

					if ( $value['type'] == 'checkbox' ) {
						$this->render_checkbox_field( $value );
					}

					if ( $value['type'] == 'slide-up-group' ) {
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

			if ( $v['type'] == 'text' ) {
				$this->render_text_field( $v );
			}
			if ( $v['type'] == 'checkbox' ) {
				$this->render_checkbox_field( $v );
			}
		}
		echo '</div><!--/.epfw-accordion-wrapper-->';

		echo '</div><!--/.epfw-field-slide-up-wrapper-->';

	}


}
