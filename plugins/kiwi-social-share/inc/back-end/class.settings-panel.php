<?php


/**
 * The dashboard-specific functionality of the plugin.
 */
class Kiwi_Settings_Page extends Kiwi_Plugin_Utilities {

	public $page_hook_suffix = '';
	public $options = ''; // holds the options stored into the DB

	/**
	 *
	 * Initialize the class and set its properties.
	 *
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, '_set_default_options' ) );

		// add the menu page
		add_action( 'admin_menu', array( $this, 'register_menu_page' ) );

		// add hook for admin notices on save
		add_action( 'admin_notices', array( $this, 'show_admin_notice' ) );

		// load scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'back_end_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'back_end_styles' ) );

	}

	/**
	 * Get default options into an array suitable for the settings API
	 *
	 * @since Kiwi_Framework 1.0
	 *
	 */
	function _default_values() {

		$defaults = array();

		foreach ( $this->settings_fields() as $k => $section ) {

			foreach ( $section as $array_key => $array_value ) {

				if ( $array_value['type'] !== 'heading' ) { // skip headings

					if ( $array_value['type'] == 'sortable-toggle' && is_array( $array_value['std'] ) ) {
						$defaults[ $array_value['id'] ] = implode( ",", $array_value['std'] );

						// we need to loop one more time to get the options for toggles as well
						foreach ( $array_value['options'] as $k => $v ) {
							$defaults[ $v['id'] ] = $v['std'];
						}

					} else {
						$defaults[ $array_value['id'] ] = $array_value['std'];
					}

				}
			}
		}

		// before we return the $defaults_array, let's also make sure we save our structure version into the DB as well
		if ( empty( $defaults['kiwi-structure-version'] ) ) {
			$structure_version = $this->get_option_value( 'kiwi-structure-version' );

			if ( empty( $structure_version ) ) {
				$defaults['kiwi-structure-version'] = KIWI__STRUCTURE_VERSION;
			}
		}

		return $defaults;
	}

	/**
	 * Set default options based on 'std' param defined in the settings array
	 */
	public function _set_default_options() {
		if ( ! get_option( $this->settings_field ) ) {
			add_option( $this->settings_field, $this->_default_values() );
		}

	}//function


	/**
	 * Function that handles the creation of a new menu page for the plugin
	 *
	 * @since   1.0.0
	 */
	public function register_menu_page() {

		$this->page_hook_suffix = add_menu_page( 'Kiwi Social',          // page title
			'Kiwi Social',          // menu title
			'manage_options',       // capability
			'kiwi-social-share',    // menu-slug
			array(                  // callback function to render the options
			                        $this,
			                        'render_settings',
			),
			'dashicons-share-alt'  // icon
		);
	}

	/**
	 * Function to load back-end specific JS Scripts
	 *
	 * @param $hook
	 */
	public function back_end_scripts( $hook ) {

		if ( $hook !== $this->page_hook_suffix ) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_register_script( 'settings-panel-js', KIWI__PLUGINS_URL . 'assets/back-end/js/settings-panel.js', array(
			'jquery',
			'jquery-ui-sortable',
		), KIWI__PLUGIN_VERSION, true );
		wp_enqueue_script( 'settings-panel-js' );
	}

	/**
	 * Function to load back-end specific stylesheets
	 *
	 * @param $hook
	 */
	public function back_end_styles( $hook ) {

		if ( $hook !== $this->page_hook_suffix ) {
			return;
		}

		wp_register_style( 'kiwi-wpadmin-style', KIWI__PLUGINS_URL . 'assets/back-end/css/back-end-styles.css', false, KIWI__PLUGIN_VERSION );
		wp_enqueue_style( 'kiwi-wpadmin-style' );
	}


	/**
	 * Function that holds the required back-end field mark-up.
	 *
	 * @since   1.0.0
	 *
	 * @return  array   $settings   Holds all the mark-up required for the field rendering engine to render the fields
	 */
	public function settings_fields() {

		$settings['left-side'] = array(

			array(
				'title'      => __( 'General Settings', 'kiwi-social-share' ),
				'sub-title'  => __( 'drag & drop to reorder', 'kiwi-social-share' ),
				'type'       => 'heading',
				'nice-title' => 1,
				'id'         => 'general-settings-heading',
			),

			array(
				'type'    => 'sortable-toggle',
				'id'      => 'general-settings-order',
				'title'   => '',
				'std'     => array(
					'kiwi-enable-facebook',
					'kiwi-enable-twitter',
					'kiwi-enable-google-plus',
					'kiwi-enable-pinterest',
					'kiwi-enable-linkedin',
					'kiwi-enable-reddit',
					'kiwi-enable-email',
				),
				'options' => array(

					'kiwi-enable-facebook' => array(
						'title' => __( ' Facebook', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon'  => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/facebook-icon.png',
						'id'    => 'kiwi-enable-facebook',
					),

					'kiwi-enable-twitter' => array(
						'title' => __( ' Twitter', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon'  => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/twitter-icon.png',
						'id'    => 'kiwi-enable-twitter',
					),

					'kiwi-enable-pinterest' => array(
						'title' => __( ' Pinterest', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon' => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/pinterest-icon.png',
						'id'    => 'kiwi-enable-pinterest',
					),

					'kiwi-enable-linkedin' => array(
						'title' => __( ' LinkedIN', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon'  => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/linkedin-icon.png',
						'id'    => 'kiwi-enable-linkedin',
					),

					'kiwi-enable-reddit' => array(
						'title' => __( 'Reddit', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon'  => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/reddit-icon.png',
						'id'    => 'kiwi-enable-reddit',
					),

					'kiwi-enable-google-plus' => array(
						'title' => __( ' Google Plus', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon'  => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/google-plus-icon.png',
						'id'    => 'kiwi-enable-google-plus',
					),

					'kiwi-enable-email' => array(
						'title' => __( ' Email', 'kiwi-social-share' ),
						'type'  => 'sortable-toggle',
						'std'   => 1,
						'icon'  => KIWI__PLUGINS_URL . '/assets/back-end/images/social-icons/email-icon.png',
						'id'    => 'kiwi-enable-email',
					),

				), // sortable options array
			),
		);

		$settings['right-side'] = array(


			array(
				'title'      => __( 'Display Location', 'kiwi-social-share' ),
				'sub-title'  => __( 'posts & pages', 'kiwi-social-share' ),
				'type'       => 'heading',
				'id'         => 'display-location-heading',
				'nice-title' => 1,
			),

			array(
				'title' => __( ' Posts', 'kiwi-social-share' ),
				'type'  => 'toggle',
				'std'   => 1,
				'id'    => 'kiwi-enable-on-posts',
			),

			array(
				'title' => __( ' Pages', 'kiwi-social-share' ),
				'type'  => 'toggle',
				'std'   => 0,
				'id'    => 'kiwi-enable-on-pages',
			),

			array(
				'title'      => __( 'Display Position', 'kiwi-social-share' ),
				'sub-title'  => __( 'select button position', 'kiwi-social-share' ),
				'id'         => 'display-position-heading',
				'type'       => 'heading',
				'nice-title' => 1,
			),

			array(
				'title'   => __( 'Enable on:', 'kiwi-social-share' ),
				'type'    => 'radio',
				'id'      => 'kiwi-enable-share-position',
				'std'     => 'after-posts',
				'options' => array(
					'after-posts'            => __( 'After content', 'kiwi-social-share' ),
					'before-posts'           => __( 'Before content', 'kiwi-social-share' ),
					'before_and_after_posts' => __( 'Before & after content', 'kiwi-social-share' ),
				),
			),

			array(
				'title'      => __( 'Display Sizes', 'kiwi-social-share' ),
				'sub-title'  => __( 'comes in all shapes & sizes.', 'kiwi-social-share' ),
				'nice-title' => 1,
				'type'       => 'heading',
				'id'         => 'display-sizes-heading',
			),

			array(
				'title'   => '',
				'type'    => 'radio',
				'id'      => 'kiwi-display-sizes',
				'std'     => 'kiwi-large-size',
				'options' => array(
					'kiwi-small-size'  => __( 'Small size', 'kiwi-social-share' ),
					'kiwi-medium-size' => __( 'Medium size', 'kiwi-social-share' ),
					'kiwi-large-size'  => __( 'Large size', 'kiwi-social-share' ),
				),
			),
		);

		$settings['full-width'] = array(

			array(
				'id'         => 'kiwi-design-settings-heading',
				'title'      => __( 'Design Settings', 'kiwi-social-share' ),
				'sub-title'  => __( 'choose preferred layout', 'kiwi-social-share' ),
				'type'       => 'heading',
				'nice-title' => 1,
			),

			array(
				'id'      => 'kiwi-design-choose-layout',
				'type'    => 'radio-img',
				'std'     => 'kiwi-default-style',
				'options' => array(
					'kiwi-default-style' => array(
						'title' => __( 'Default Style', 'kiwi-social-share' ),
						'desc'  => __( 'Square, classic style.', 'kiwi-social-share' ),
						'img'   => KIWI__PLUGINS_URL . 'assets/back-end/images/kiwi-share-square-style.jpg',
					),
					'kiwi-shift-style'   => array(
						'title' => __( 'Shift Style', 'kiwi-social-share' ),
						'desc'  => __( 'Simple. Futuristic style.', 'kiwi-social-share' ),
						'img'   => KIWI__PLUGINS_URL . 'assets/back-end/images/kiwi-share-shift-style.jpg',
					),
					'kiwi-leaf-style'    => array(
						'title' => __( 'Leaf Style', 'kiwi-social-share' ),
						'desc'  => __( 'Like a leaf in the wind.', 'kiwi-social-share' ),
						'img'   => KIWI__PLUGINS_URL . 'assets/back-end/images/kiwi-share-leaf-style.jpg',
					),
					'kiwi-pills-style'   => array(
						'title' => __( 'Pill Style', 'kiwi-social-share' ),
						'desc'  => __( 'Them curves though.', 'kiwi-social-share' ),
						'img'   => KIWI__PLUGINS_URL . 'assets/back-end/images/kiwi-share-pill-style.jpg',
					),
				),
			),
		);


		return $settings;

	}

	/**
	 * Function that registers the settings sections
	 */
	public function render_settings() {

		// Check that the user is allowed to update options
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'kiwi-social-share' ) );
		}

		// save options
		$this->save_settings();

		// left side settings
		register_setting( 'kiwi_settings_left_side', $this->settings_field, array( $this, 'validate_fields' ) );
		add_settings_section( 'kiwi_settings_section_left', null, null, 'kiwi_settings_section_left_call' );

		// right side settings
		register_setting( 'kiwi_settings_right_side', $this->settings_field, array( $this, 'validate_fields' ) );
		add_settings_section( 'kiwi_settings_section_right', null, null, 'kiwi_settings_section_right_call' );

		// full width settings
		register_setting( 'kiwi_settings_fullwidth', $this->settings_field, array( $this, 'validate_fields' ) );
		add_settings_section( 'kiwi_settings_section_fullwidth', null, null, 'kiwi_settings_section_fullwidth_call' );

		// get settings fields
		$settings_fields = $this->settings_fields();

		if ( ! empty( $settings_fields['left-side'] ) ) {
			foreach ( $settings_fields['left-side'] as $settings_id => $settings_arguments ) {

				add_settings_field( $settings_arguments['id'],                        // unique ID for the field
					$settings_arguments['title'],        // title of the field
					array( $this, 'kiwi_render_field' ),   // function callback
					'kiwi_settings_section_left_call',        // page name, should be the same as the last argument used in add_settings_section
					'kiwi_settings_section_left',             // same as first argument passed to add_settings_section
					$settings_arguments                  // $args, passed as array; defined in kiwi_settings_field()
				);
			}
		}


		if ( ! empty( $settings_fields['right-side'] ) ) {
			foreach ( $settings_fields['right-side'] as $settings_arguments ) {
				add_settings_field( $settings_arguments['id'],                        // unique ID for the field
					$settings_arguments['title'],        // title of the field
					array( $this, 'kiwi_render_field' ),   // function callback
					'kiwi_settings_section_right_call',        // page name, should be the same as the last argument used in add_settings_section
					'kiwi_settings_section_right',             // same as first argument passed to add_settings_section
					$settings_arguments                  // $args, passed as array; defined in kiwi_settings_field()
				);
			}
		}


		if ( ! empty( $settings_fields['full-width'] ) ) {
			foreach ( $settings_fields['full-width'] as $settings_arguments ) {
				add_settings_field( $settings_arguments['id'],                        // unique ID for the field
					null,       // title of the field
					array( $this, 'kiwi_render_field' ),   // function callback
					'kiwi_settings_section_fullwidth_call',        // page name, should be the same as the last argument used in add_settings_section
					'kiwi_settings_section_fullwidth',             // same as first argument passed to add_settings_section
					$settings_arguments                  // $args, passed as array; defined in kiwi_settings_field()
				);
			}
		}


		?>

		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class='wrap kiwi-wrap'>

			<h1><?php _e( 'Kiwi Social Sharing', 'kiwi-social-share' ); ?></h1>
			<p class="kiwi-about-text"><?php echo __( 'Thank you for choosing Kiwi Social Share. An easy to use social button share plugin with a beautiful UI. We really hope you\'ll enjoy using it', 'kiwi-social-share' ); ?>
				.</p>
			<div class='kiwi-badge'>
				<span><?php echo __( 'Version: ', 'kiwi-social-share' ) . KIWI__PLUGIN_VERSION; ?></span></div>

			<?php settings_errors(); ?>

			<div class='kiwi-form-wrapper'>
				<form method="post" action="">

					<div class="kiwi-form-wrapper-right">
						<?php settings_fields( 'kiwi_settings_right_side' ); ?>
						<?php $this->do_settings_sections( 'kiwi_settings_section_right_call' ); ?>
					</div>

					<div class="kiwi-form-wrapper-left">
						<?php settings_fields( 'kiwi_settings_left_side' );               //settings group, defined as first argument in register_setting
						?>
						<?php $this->do_settings_sections( 'kiwi_settings_section_left_call' );   //same as last argument used in add_settings_section
						?>
					</div>
					<div class="clear"></div>
					<div class="kiwi-form-wrapper-full">
						<?php settings_fields( 'kiwi_settings_fullwidth' );               //settings group, defined as first argument in register_setting
						?>
						<?php $this->do_settings_sections( 'kiwi_settings_section_fullwidth_call' );   //same as last argument used in add_settings_section
						?>
					</div>

					<div class="clear"></div>

					<?php submit_button(); ?>
					<?php wp_nonce_field( 'kiwi_settings_nonce' ); ?>
				</form>
			</div>

		</div><!-- /.wrap -->

	<?php }

	/**
	 * Function that calls the rendering engine
	 *
	 * @param   array $args Each array entry defiend in the kiwi_settings_fields() is passed as a parameter to this
	 *                      function
	 *
	 * @since   1.0.0
	 */
	public function kiwi_render_field( $args ) {

		switch ( $args['type'] ) {

			case 'text':
				echo $this->render_text_field( $args );
				break;
			case 'radio':
				echo $this->render_radio_field( $args );
				break;
			case 'checkbox':
				echo $this->render_checkbox_field( $args );
				break;
			case 'sortable-toggle':
				echo $this->render_sortable_draggable_field( $args );
				break;
			case 'toggle':
				echo $this->render_toggle_field( $args );
				break;
			case 'select':
				echo $this->render_select_field( $args );
				break;
			case 'heading':
				echo $this->render_heading_field( $args );
				break;
			case 'hidden':
				echo $this->render_hidden_field( $args );
				break;
			case 'radio-img':
				echo $this->render_radio_img_field( $args );
				break;
		}
	}


	/**
	 * Function that saves the plugin options to the database
	 *
	 * @since   1.0.0
	 */
	public function save_settings() {

		if ( isset( $_POST[ $this->settings_field ] ) && check_admin_referer( 'kiwi_settings_nonce', '_wpnonce' ) ) {

			update_option( $this->settings_field, $_POST[ $this->settings_field ] );

		}
	}


	/**
	 * Acts as a callback for the register_setting function. Validates that settings actually exist
	 *
	 * @param $input
	 *
	 * @return mixed|void
	 */
	public function validate_fields( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach ( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'kiwi_plugin_validate_settings', $output, $input );
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

		if ( isset( $_POST[ $this->settings_field ] ) && check_admin_referer( 'kiwi_settings_nonce', '_wpnonce' ) ) {
			echo '<div class="notice updated is-dismissible">' . __( 'Settings updated successfully!', 'kiwi-social-share' ) . '</div>';
		}
	}
} // class end
$kiwi_settings_panel = new Kiwi_Settings_Page();