<?php

class Kiwi_Plugin_Utilities {

	public $settings_field = 'kiwi_settings'; // holds the options table name


	/**
	 * Small rewrite of the Core version of do_settings_sections. Needed to remove <table> mark-up
	 *
	 * @param $page
	 */
	function do_settings_sections( $page ) {
		global $wp_settings_sections, $wp_settings_fields;

		if ( ! isset( $wp_settings_sections[ $page ] ) ) {
			return;
		}

		foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
			if ( $section['title'] ) {
				echo "<h3>{$section['title']}</h3>" . PHP_EOL;
			}

			if ( $section['callback'] ) {
				call_user_func( $section['callback'], $section );
			}

			if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
				continue;
			}

			$this->do_settings_fields( $page, $section['id'] );

		}
	}

	/**
	 *  Small rewrite of the Core version of do_settings_fields. Needed to remove <table> mark-up
	 *
	 * @param $page
	 * @param $section
	 */
	function do_settings_fields( $page, $section ) {
		global $wp_settings_fields;

		if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
			return;
		}

		foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {
			if ( ! empty( $field['args']['label_for'] ) ) {
				echo '<label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label>';
			}

			call_user_func( $field['callback'], $field['args'] );

		}
	}

	/**
	 * Function that is responsible for checking if an option has a value in it or not.
	 *
	 * Returns false if it doesn't
	 *
	 * @param $option_id
	 *
	 * @since   1.0.0
	 */
	public function get_option_value( $option_id ) {

		$options = get_option( $this->settings_field );

		if ( ! empty( $options[ $option_id ] ) ) {
			return $options[ $option_id ];
		} else {
			return;
		}
	}


	/**
	 * Function that is responsible for generating text fields
	 *
	 * @param $args
	 *
	 * @return string
	 *
	 * @since   1.0.0
	 */
	public function render_text_field( $args ) {

		$output = '<fieldset class="kiwi-text-field-wrapper">';
		$output .= '<label for="' . esc_attr( $args['id'] ) . '">';
		$output .= '<div class="kiwi-form-label">' . esc_attr( $args['title'] ) . '</div>';
		$output .= '<input id="' . esc_attr( $args['id'] ) . '" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '" class="widefat" placeholder="' . esc_attr( $args['placeholder'] ) . '" type="text"  value="' . sanitize_text_field( $this->get_option_value( $args['id'] ) ) . '">';
		$output .= '</label>';
		$output .= '</fieldset>';

		return $output;
	}

	/**
	 * Function that is responsible for generating radio fields
	 *
	 * @param $args
	 *
	 * @return string
	 *
	 * @since   1.0.0
	 */
	public function render_radio_field( $args ) {

		$output = '<fieldset class="kiwi-radio-field-wrapper">';

		foreach ( $args['options'] as $array_key => $array_value ) {

			$output .= '<input id="' . esc_attr( $array_key ) . '" type="radio" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '" value="' . esc_attr( $array_key ) . '"' . checked( $this->get_option_value( $args['id'] ), esc_attr( $array_key ), false ) . '>';
			$output .= '<label for="' . esc_attr( $array_key ) . '">' . $array_value . '</label>';
		}

		$output .= '</fieldset>';

		return $output;

	}

	/**
	 * Function that is responsible for generating radio IMG type fields
	 *
	 * @param $args
	 *
	 * @return string
	 *
	 * @since   1.0.0
	 */
	public function render_radio_img_field( $args ) {


		$output = '<fieldset class="kiwi-radio-img-wrapper">';

		$output .= '<ul class="kiwi-field-wrapper kiwi-radio-img">';

		foreach ( $args['options'] as $array_key => $array_value ) {

			if ( checked( $this->get_option_value( $args['id'] ), $array_key, false ) ) {
				$field_class = ' kiwi-active-field';
			} else {
				$field_class = '';
			}

			$output .= '<li class="kiwi-radio-img-field ' . esc_attr( $array_key ) . esc_attr( $field_class ) . '">';
			$output .= '<label for="' . esc_attr( $array_key ) . '"  class="kiwi-field-helper-radio-img" data-click-to="' . esc_attr( $array_key ) . '" >';
			$output .= '<img class="kiwi-background-image" src="' . esc_attr( $array_value['img'] ) . '" />';

			$output .= '<input class="kiwi-hidden-input" type="radio" id="' . esc_attr( $array_key ) . '" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '" value="' . esc_attr( $array_key ) . '"' . checked( $this->get_option_value( $args['id'] ), $array_key, false ) . '>';
			$output .= '<div class="kiwi-form-label radio-img">' . esc_html( $array_value['title'] ) . '</div>';

			$output .= '<div class="kiwi-field-description img-radio">' . esc_html( $array_value['desc'] ) . '</div>';
			$output .= '</label>';
			$output .= '</li>';

		}

		$output .= '</ul>';
		$output .= '</fieldset>';

		return $output;

	}

	/**
	 * Function that is responsible for generating checkbox fields
	 *
	 * @param $args
	 *
	 * @return string
	 *
	 * @since   1.0.0
	 */
	public function render_checkbox_field( $args ) {


		$output = '<fieldset class="kiwi-checkbox-wrapper">';

		// render
		$output .= '<label title="' . esc_attr( $args['title'] ) . '" for="' . esc_attr( $args['id'] ) . '">';
		$output .= '<div class="kiwi-form-label">' . esc_attr( $args['title'] ) . '</div>';
		$output .= '<input id="' . esc_attr( $args['id'] ) . '" type="checkbox" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '" value="1"' . checked( $this->get_option_value( $args['id'] ), 1, false ) . '>';

		// check we actually have a description
		if ( ! empty( $args['desc'] ) ) {
			$output .= '<span class="kiwi-field-description">' . esc_html( $args['desc'] ) . '</span>';
		}

		$output .= '</label>';
		$output .= '</fieldset>';

		return $output;

	}

	/**
	 * Function that is responsible for generating draggable & sortable checkbox combo fields
	 *
	 * @param $args
	 *
	 * @return string
	 *
	 * @since   1.0.0
	 *
	 *
	 */
	public function render_sortable_draggable_field( $args ) {
		$output = '';
		$order = $this->get_option_value('general-settings-order');

		//overwrite $args['std']
		if ( ! empty( $order ) ) {

			// convert the string to an array
			$saved_values = $this->get_option_value( 'general-settings-order' );

			$order_preload = explode( ',', $saved_values );

			$args['std'] = $order_preload;
		}

		// arrange the sortable fields in desired order; by order saved/defined as default
		$args['options'] = array_merge( array_flip( $args['std'] ), $args['options'] );

		// loop through the options array
		foreach ( $args['options'] as $array_key => $array_value ) {

			// add class "kiwi-sortable-disabled" if it's unchecked
			$checked = checked( $this->get_option_value( $array_value['id'] ), 1, false );

			// start render
			if ( $checked == '' ) { // checking to see if toggle is active or not; if it's not, output the disabled class so it has a lowered opacity
				$output .= '<fieldset class="kiwi-checkbox-sortable-wrapper kiwi-sortable-disabled">';
			} else {
				$output .= '<fieldset class="kiwi-checkbox-sortable-wrapper">';
			}

			$output .= '<div class="kiwi-sortable-helper"></div>';
			$output .= '<div class="kiwi-sortable-form-label"><span class="' . strtolower( esc_html( $array_value['title'] ) ) . '"><img src="'.esc_url( $array_value['icon'] ).'" /></span>' . esc_html( $array_value['title'] ) . '</div>';

			$output .= '<label class="kiwi-switch" for="' . esc_attr( $array_value['id'] ) . '">';
			$output .= '<input id="' . esc_attr( $array_value['id'] ) . '" class="kiwi-switch-input" type="checkbox" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $array_value['id'] ) . ']' . '" value="1"' . esc_attr( $checked ) . '>';
			$output .= '<span class="kiwi-switch-label" data-on="' . __( 'On', 'kiwi-social-share' ) . '" data-off="' . __( 'Off', 'kiwi-social-share' ) . '"></span>';
			$output .= '<span class="kiwi-switch-handle"></span>';
			$output .= '</label>';

			$output .= '</fieldset>';
		}

		$output .= '<input type="hidden" class="widefat" id="general-settings-order" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '">';

		return $output;
	}


	/**
	 * Function that is responsible for generating checkbox fields
	 *
	 * @param $args
	 *
	 * @return string
	 *
	 * @since   1.0.0
	 */
	public function render_toggle_field( $args ) {


		// start render
		$output = '<fieldset class="kiwi-checkbox-toggle-wrapper">';

		$output .= '<span class="kiwi-checkbox-toggle-form-label">' . $args['title'] . '</span>';

		$output .= '<label class="kiwi-switch" for="' . esc_attr( $args['id'] ) . '">';
		$output .= '<input id="' . esc_attr( $args['id'] ) . '" class="kiwi-switch-input" type="checkbox" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '" value="1"' . checked( $this->get_option_value( $args['id'] ), 1, false ) . '>';
		$output .= '<span class="kiwi-switch-label" data-on="' . __( 'On', 'kiwi-social-share' ) . '" data-off="' . __( 'Off', 'kiwi-social-share' ) . '"></span>';
		$output .= '<span class="kiwi-switch-handle"></span>';
		$output .= '</label>';

		$output .= '</fieldset>';

		return $output;
	}

	/**
	 * Function that generates select drop-down type fields
	 *
	 * @param $args
	 *
	 * @return string
	 */
	public function render_select_field( $args ) {


		$output = '<fieldset class="kiwi-select-wrapper">';
		$output .= '<select name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '">';

		foreach ( $args['options'] as $key => $value ) {
			$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $this->get_option_value( $args['id'] ), $key, false ) . '>' . esc_attr( $value ) . '</option>';
		}

		$output .= '</select>';
		$output .= '</fieldset>';

		return $output;
	}

	/**
	 * Function that generates heading fields
	 *
	 * @param $args
	 *
	 * @return string
	 */
	public function render_heading_field( $args ) {

		if ( $args['nice-title'] == 1 ) {
			// split the title into 2 pieces
			list( $first_word, $second_word ) = explode( ' ', $args['title'], 2 );
		}

		$output = '<h2 class="kiwi-form-heading">';
		if ( $args['nice-title'] == 1 ) {
			$output .= '<span class="first-word">' . esc_html( $first_word ) . '</span>' . '&nbsp;' . esc_html( $second_word );
		} else {
			$output .= esc_html( $args['title'] );
		}

		if ( ! empty( $args['sub-title'] ) ) {
			$output .= '<span class="kiwi-sub-title">';
			$output .= esc_html( $args['sub-title'] );
			$output .= '</span>';
		}

		$output .= '</h2>';

		return $output;

	}

	/**
	 * Function to generate hidden input
	 *
	 * @param $args
	 *
	 * @return string
	 */
	public function render_hidden_field( $args ) {
		$output = '<input type="hidden" class="widefat" name="' . esc_attr( $this->settings_field ) . '[' . esc_attr( $args['id'] ) . ']' . '" id="' . esc_attr( $args['id'] ) . '" value="' . $this->get_option_value( $args['id'] ) . '">';

		return $output;
	}
}

$kiwi_plugin_base = new Kiwi_Plugin_Utilities();