<?php

/** if class `WP_Dark_Mode_Settings` not exists yet */
if ( ! class_exists( 'WP_Dark_Mode_Settings' ) ) {

	class WP_Dark_Mode_Settings {

		private static $instance = null;
		private static $settings_api = null;

		public function __construct() {
			add_action( 'admin_init', array( $this, 'settings_fields' ) );
			add_action( 'admin_menu', array( $this, 'settings_menu' ) );
		}

		/**
		 * Registers settings section and fields
		 */
		public function settings_fields() {
			$time_range = [
				'00:00' => '12:00 AM',
				'01:00' => '01:00 AM',
				'02:00' => '02:00 AM',
				'03:00' => '03:00 AM',
				'04:00' => '04:00 AM',
				'05:00' => '05:00 AM',
				'06:00' => '06:00 AM',
				'07:00' => '07:00 AM',
				'08:00' => '08:00 AM',
				'09:00' => '09:00 AM',
				'10:00' => '10:00 AM',
				'11:00' => '11:00 AM',
				'12:00' => '12:00 PM',
				'13:00' => '01:00 PM',
				'14:00' => '02:00 PM',
				'15:00' => '03:00 PM',
				'16:00' => '04:00 PM',
				'17:00' => '05:00 PM',
				'18:00' => '06:00 PM',
				'19:00' => '07:00 PM',
				'20:00' => '08:00 PM',
				'21:00' => '09:00 PM',
				'22:00' => '10:00 PM',
				'23:00' => '11:00 PM',
			];

			$sections = array(
				array(
					'id'    => 'wp_dark_mode_general',
					'title' => sprintf( __( '%s <span>General Settings</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-admin-tools" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_advanced',
					'title' => sprintf( __( '%s <span>Advanced Settings</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-admin-generic" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_display',
					'title' => sprintf( __( '%s <span>Display Settings</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-welcome-view-site" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_style',
					'title' => sprintf( __( '%s <span>Style Settings</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-admin-customizer" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_image_settings',
					'title' => sprintf( __( '%s <span>Image Settings</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-format-gallery" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_custom_css',
					'title' => sprintf( __( '%s <span>Custom CSS</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-editor-code" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_gutenberg',
					'title' => sprintf( __( '%s <span>Gutenberg Block</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-screenoptions" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_elementor',
					'title' => sprintf( __( '%s <span>Elementor Widget</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-align-none" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_shortcodes',
					'title' => sprintf( __( '%s <span>Shortcodes</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-shortcode" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_widget_doc',
					'title' => sprintf( __( '%s <span>Switch Widget</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-align-full-width" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_license',
					'title' => sprintf( __( '%s <span>Activate License</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-admin-network" ></i>' ),
				),
				array(
					'id'    => 'wp_dark_mode_start',
					'title' => sprintf( __( '%s <span>Get Started</span>', 'wp-dark-mode' ),
						'<i class="dashicons dashicons-location" ></i>' ),
				),
			);

			if ( ! class_exists('WP_Dark_Mode_Ultimate') && ! class_exists('WP_Dark_Mode_Pro') ) {
				$key = array_search( 'wp_dark_mode_license', array_column( $sections, 'id' ) );

				unset( $sections[ $key ] );
			}

			$fields = array(

				'wp_dark_mode_general' => apply_filters( 'wp_dark_mode/general', array(

					'enable_frontend' => array(
						'name'    => 'enable_frontend',
						'default' => 'on',
						'label'   => __( 'Enable Frontend Darkmode', 'wp-dark-mode' ),
						'desc'    => __( 'Turn ON to enable the darkmode in the frontend.', 'wp-dark-mode' ),
						'type'    => 'switcher',
					),

                    'enable_backend' => array(
						'name'    => 'enable_backend',
						'default' => 'off',
						'label'   => __( 'Enable Backend Darkmode', 'wp-dark-mode' ),
						'desc'    => __( 'Enable the backend darkmode to display a darkmode switch button in the admin bar for the admins on the backend.',
							'wp-dark-mode' ),
						'type'    => 'switcher',
					),

					'show_switcher' => array(
						'name'    => 'show_switcher',
						'default' => 'on',
						'label'   => __( 'Show Floating Switch', 'wp-dark-mode' ),
						'desc'    => __( 'Show the floating dark mode switcher button on the frontend for the users.', 'wp-dark-mode' ),
						'type'    => 'switcher',
					),

					'enable_os_mode' => array(
						'name'    => 'enable_os_mode',
						'default' => 'on',
						'label'   => __( 'Enable OS aware Dark Mode', 'wp-dark-mode' ),
						'desc'    => __( 'Dark Mode has been activated in the frontend. Now, your users will be served a dark mode of your website when their device preference is set to Dark Mode or by switching the darkmode switch button.',
								'wp-dark-mode' ) . '<br><br><br> <img src="' . wp_dark_mode()->plugin_url( 'assets/images/os-theme.gif' )
						             . '" alt="">',
						'type'    => 'switcher',
					),

				) ),

				'wp_dark_mode_advanced' => apply_filters( 'wp_dark_mode/advanced_settings', array(
				        
					'time_based_mode'   => array(
						'name'    => 'time_based_mode',
						'default' => 'off',
						'label'   => __( 'Time Based Dark Mode', 'wp-dark-mode' ),
						'desc'    => __( 'Automatically turn on the dark mode between a given time range.', 'wp-dark-mode' ),
						'type'    => 'switcher',
					),

					'start_at'          => array(
						'name'    => 'start_at',
						'default' => '17:00',
						'label'   => __( 'Dark Mode Start Time', 'wp-dark-mode' ),
						'desc'    => __( 'Time to start Dark mode.', 'wp-dark-mode' ),
						'type'    => 'select',
						'options' => $time_range,
					),

					'end_at'            => array(
						'name'    => 'end_at',
						'default' => '06:00',
						'label'   => __( 'Dark Mode End Time', 'wp-dark-mode' ),
						'desc'    => __( 'Time to end Dark mode.', 'wp-dark-mode' ),
						'type'    => 'select',
						'options' => $time_range,
					),
				) ),

				'wp_dark_mode_display'  => apply_filters( 'wp_dark_mode/display_settings', array(

					'switch_style'      => array(
						'name'    => 'switch_style',
						'default' => '1',
						'label'   => __( 'Floating Switch Style', 'wp-dark-mode' ),
						'desc'    => __( 'Select the switcher button style for the frontend.', 'wp-dark-mode' ),
						'type'    => 'image_choose',
						'options' => [
							'1' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/1.svg' ),
							'2' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/2.svg' ),
							'3' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/3.svg' ),
							'4' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/4.svg' ),
							'5' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/5.svg' ),
							'6' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/6.svg' ),
							'7' => wp_dark_mode()->plugin_url( 'assets/images/button-presets/7.svg' ),
						],
					),

					'switcher_position' => array(
						'name'    => 'switcher_position',
						'default' => 'right_bottom',
						'label'   => __( 'Floating Switch Position', 'wp-dark-mode' ),
						'desc'    => __( 'Select the position of the floating dark mode switcher button on the frontend.',
							'wp-dark-mode' ),
						'type'    => 'select',
						'options' => [
							'left_bottom'  => __( 'Left Bottom', 'wp-dark-mode' ),
							'right_bottom' => __( 'Right Bottom', 'wp-dark-mode' ),
						],
					),

					'show_above_post'   => array(
						'name'    => 'show_above_post',
						'default' => 'off',
						'label'   => __( 'Show Above Posts', 'wp-dark-mode' ),
						'desc'    => __( 'Show the dark mode switcher button above of all the post.', 'wp-dark-mode' ),
						'type'    => 'switcher',
					),

					'show_above_page'   => array(
						'name'    => 'show_above_page',
						'default' => 'off',
						'label'   => __( 'Show Above Pages', 'wp-dark-mode' ),
						'desc'    => __( 'Show the dark mode switcher button above of all the pages.', 'wp-dark-mode' ),
						'type'    => 'switcher',
					),

					'excludes'   => array(
						'name'    => 'excludes',
						'default' => '',
						'label'   => __( 'Excludes Elements', 'wp-dark-mode' ),
						'desc'    => __( 'Add comma separated (classes, ids) to ignore the darkmode. ex: .class1, #hero-area', 'wp-dark-mode' ),
						'type'    => 'textarea',
					),

					'exclude_pages' => array(
						'name'    => 'exclude_pages',
						'default' => [ $this, 'exclude_pages' ],
						'label'   => __( 'Exclude Pages', 'wp-dark-mode' ),
						'desc'    => __( 'Select the pages to disable darkmode on the selected pages.', 'wp-dark-mode' ),
						'type'    => 'cb_function',
					),


				) ),

				'wp_dark_mode_style'    => apply_filters( 'wp_dark_mode/style_settings', array(
					'color_preset'         => array(
						'name'    => 'color_preset',
						'default' => '0',
						'label'   => __( 'Darkmode Color Preset:', 'wp-dark-mode' ),
						'desc'    => __( 'Select the predefined darkmode background, text and link preset color.', 'wp-dark-mode' ),
						'type'    => 'image_choose',
						'options' => [
							'0' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/1.svg' ),
							'1' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/2.svg' ),
							'2' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/3.svg' ),
							'3' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/4.svg' ),
							'4' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/5.svg' ),
							'5' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/6.svg' ),
							'6' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/7.svg' ),
							'7' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/8.svg' ),
							'8' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/9.svg' ),
							'9' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/10.svg' ),
							'10' => wp_dark_mode()->plugin_url( 'assets/images/color-presets/11.svg' ),
						],
					),

					'customize_colors' => array(
						'name'    => 'customize_colors',
						'default' => 'off',
						'label'   => __( 'Want to customize colors?', 'wp-dark-mode' ),
						'desc'    => __( 'Customize the darkmode background, text and link colors.', 'wp-dark-mode' ),
						'type'    => 'switcher',
					),

					'darkmode_bg_color'    => array(
						'name'    => 'darkmode_bg_color',
						'default' => '',
						'label'   => __( 'Darkmode Background Color', 'wp-dark-mode' ),
						'desc'    => __( 'Select the background color when the dark mode is on.', 'wp-dark-mode' ),
						'type'    => 'color',
					),

					'darkmode_text_color'  => array(
						'name'    => 'darkmode_text_color',
						'default' => '',
						'label'   => __( 'Darkmode Text Color', 'wp-dark-mode' ),
						'desc'    => __( 'Select the text color when the dark mode is on.', 'wp-dark-mode' ),
						'type'    => 'color',
					),

					'darkmode_links_color' => array(
						'name'    => 'darkmode_link_color',
						'default' => '',
						'label'   => __( 'Darkmode Links Color', 'wp-dark-mode' ),
						'desc'    => __( 'Select the links color when the dark mode is on.', 'wp-dark-mode' ),
						'type'    => 'color',
					),
				) ),

				'wp_dark_mode_license' => apply_filters( 'wp_dark_mode/license_settings', array(
					'license_settings' => array(
						'name'    => 'license',
						'default' => [ 'WP_Dark_Mode_Settings', 'license_output' ],
						'type'    => 'cb_function',
					),
				) ),

				'wp_dark_mode_start' => apply_filters( 'wp_dark_mode/getting_start', array(
					'getting_started' => array(
						'name'    => 'getting_started',
						'default' => [ 'WP_Dark_Mode_Settings', 'getting_started' ],
						'type'    => 'cb_function',
					),
				) ),

				'wp_dark_mode_custom_css' => apply_filters( 'wp_dark_mode/custom_css', array(
					array(
						'name'  => 'custom_css',
						'label' => 'Dark Mode Custom CSS',
						'type'  => 'textarea',
						'desc'  => 'Add custom css for dark mode only.',
					),
				) ),

				'wp_dark_mode_gutenberg' => apply_filters( 'wp_dark_mode/settings_gutenberg', array(
					array(
						'name'    => 'gutenberg_doc',
						'default' => [ $this, 'gutenberg_doc' ],
						'type'    => 'cb_function',
					),
				) ),

				'wp_dark_mode_elementor' => apply_filters( 'wp_dark_mode/settings_elementor', array(
					array(
						'name'    => 'elementor_doc',
						'default' => [ $this, 'elementor_doc' ],
						'type'    => 'cb_function',
					),
				) ),

				'wp_dark_mode_shortcodes' => apply_filters( 'wp_dark_mode/settings_elementor', array(
					array(
						'name'    => 'shortcodes_doc',
						'default' => [ $this, 'shortcodes_doc' ],
						'type'    => 'cb_function',
					),
				) ),

				'wp_dark_mode_widget_doc' => apply_filters( 'wp_dark_mode/widget_doc', array(
					array(
						'name'    => 'widget_doc',
						'default' => [ $this, 'widget_doc' ],
						'type'    => 'cb_function',
					),
				) ),

				'wp_dark_mode_image_settings' => apply_filters( 'wp_dark_mode/image_settings', array(
					array(
						'name'    => 'image_settings',
						'default' => [ $this, 'image_settings' ],
						'type'    => 'cb_function',
					),
				) ),
			);

			if ( ! is_plugin_active( 'wp-dark-mode-pro/plugin.php' ) && ! is_plugin_active( 'wp-dark-mode-ultimate/plugin.php' ) ) {
				$key = array_search( 'wp_dark_mode_license', array_column( $fields, 'id' ) );

				unset( $fields[ $key ] );
			}

			self::$settings_api = new WPPOOL_Settings_API();

			//set sections and fields
			self::$settings_api->set_sections( $sections );
			self::$settings_api->set_fields( $fields );

			//initialize them
			self::$settings_api->admin_init();
		}

		public function exclude_pages() {

			$exclude_pages = wp_dark_mode_exclude_pages();

			?>
            <select name="wp_dark_mode_display[exclude_pages][]" multiple id="wp_dark_mode_display[exclude_pages]">
				<?php

				$pages = get_posts( [
					'numberposts' => - 1,
					'post_type'   => 'page',
				] );

				if ( ! empty( $pages ) ) {
					$page_ids = wp_list_pluck( $pages,  'post_title', 'ID'  );

					foreach ( $page_ids as $id => $title ) {
						printf( '<option value="%1$s" %2$s>%3$s</option>', $id, in_array( $id, $exclude_pages ) ? 'selected' : '', $title );
					}
				}

				?>
            </select>
			<?php
		}

		public static function widget_doc(){ ?>
		    <div class="getting-started-wrap">
                <div class="getting-started-section">
                    <h2>Display Switch Button Using The WP Dark Mode widget.</h2>
                    <p>You can display the switch button by using the (WP Dark Mode ) wordpress widget, for your users to switch between the dark and normal mode.
                        <br>
                        <br>
                        Dark Mode Switch Widget is available in the PRO version.
                        <br>
                        <br> For displaying the Darkmode Switch button using the WP Dark Mode widget follow the below steps:</p>
					<p>
                        <br>
                        ➡️ Add the WP Dark Mode Widget to a sidebar where you want to display the switch button. <br>
                        ➡️ Enter the widget title, if you want to display the widget title <br>
                        ➡️ Select The Switch Style <br>
                        ➡️ Select the position alignment <br>
                        ➡️ Save & you are done. <br>
                        <br>
                    </p>

                    <p><img src="<?php echo wp_dark_mode()->plugin_url('assets/images/switch-widget.png') ?>" alt=""></p>

                </div>
            </div>
        <?php }

		public static function shortcodes_doc() { ?>
            <div class="shortcode">
                <p><b>✅</b>
                    <b><code>[wp_dark_mode_switch]</code></b> - Using the
                    <b>[wp_dark_mode_switch]</b> shortcode, you can place the dark mode switch button anywhere in your website.
                    This shortcode supports an optional <code>style</code> attribute for the switch style from the 7 switch style.
                    <br>This shortcode is available in the PRO version.
                </p>

                <p><b>Examples:</b></p>

                <p style="margin: 10px 0 0 40px"> → <code>[wp_dark_mode_switch]</code> - Display the default dark mode switch.</p>
                <p style="margin: 10px 0 0 40px"> →
                    <code>[wp_dark_mode_switch style="3"]</code> - Display specific switch style from 7 switch styles.
                </p>
            </div>

		<?php }

		public static function image_settings() {

			$light_images = [];
			$dark_images  = [];

			if ( wp_dark_mode()->is_ultimate_active() ) {

				$images       = get_option( 'wp_dark_mode_image_settings' );
				$light_images = ! empty( $images['light_images'] ) ? array_filter( (array) $images['light_images'] ) : [];
				$dark_images  = ! empty( $images['dark_images'] ) ? array_filter( (array) $images['dark_images'] ) : [];
			}

			?>

            <p>🔹️ <strong>Light Mode Image: </strong> The image link shown in the light mode.</p>
            <p style="margin-bottom: 20px">🔹️ <strong>Dark Mode Image: </strong> The image link that will replace the light mode image while in dark mode.</p>

            <table class="image-settings-table">
                <tbody>
                <tr>
                    <td>Light Mode Image</td>
                    <td>Dark Mode Image</td>
                    <td></td>
                </tr>

				<?php

				if ( ! empty( $light_images ) ) {
					foreach ( $light_images as $key => $light_image ) { ?>
                        <tr>
                            <td><input type="url" value="<?php echo $light_image; ?>" name="wp_dark_mode_image_settings[light_images][]">
                            </td>
                            <td>
                                <input type="url" value="<?php echo $dark_images[ $key ] ?>" name="wp_dark_mode_image_settings[dark_images][]">
                            </td>
                            <td>
                                <a href="#" class="add_row button button-primary">Add</a>
                                <a href="#" class="remove_row button button-link-delete">Remove</a>
                            </td>
                        </tr>
					<?php }
				} else { ?>
                    <tr>
                        <td><input type="url" value="" name="wp_dark_mode_image_settings[light_images][]"></td>
                        <td><input type="url" value="" name="wp_dark_mode_image_settings[dark_images][]"></td>
                        <td>
                            <a href="#" class="add_row button button-primary">Add</a>
                            <a href="#" class="remove_row button button-link-delete">Remove</a>
                        </td>
                    </tr>
				<?php } ?>

                </tbody>
            </table>
		<?php }

		public static function license_output() {
			global $wp_dark_mode_license;
			$wp_dark_mode_license->menu_output();
		}

		public static function gutenberg_doc() { ?>
            <div class="wp-dark-mode-gutenberg-doc">
                <h2>How to display Dark Mode Switch Button using Gutenberg block</h2>

                <ul class="doc-section">
                    <li>
                        <h3>While you are on the post/page edit screen click on gutenberg plus icon to add a new gutenberg block</h3>
                        <img src="<?php echo wp_dark_mode()->plugin_url( 'assets/images/gutenberg/step-1.png' ) ?>" alt="step-1">
                    </li>

                    <li>
                        <h3>Add "Dark Mode Switch" from "Text" category</h3>
                        <img src="<?php echo wp_dark_mode()->plugin_url( 'assets/images/gutenberg/step-2.png' ) ?>" alt="step-2">
                    </li>

                    <li>
                        <h3>Choose button style from block settings and you are done</h3>
                        <img src="<?php echo wp_dark_mode()->plugin_url( 'assets/images/gutenberg/step-3.png' ) ?>" alt="step-2">
                    </li>
                </ul>


            </div>
		<?php }

		public static function elementor_doc() { ?>
            <div class="wp-dark-mode-elementor-doc">
                <h2>How to display Dark Mode Switch Button using Elementor Widget</h2>

                <ul class="doc-section">

                    <li>
                        <h3>Add "Dark Mode Switch" widget from "Basic" category</h3>
                        <img src="<?php echo wp_dark_mode()->plugin_url( 'assets/images/elementor/step-1.png' ) ?>" alt="step-2">
                    </li>

                    <li>
                        <h3>Choose button style from widget settings and you are done</h3>
                        <img src="<?php echo wp_dark_mode()->plugin_url( 'assets/images/elementor/step-2.png' ) ?>" alt="step-2">
                    </li>
                </ul>


            </div>
		<?php }

		public static function getting_started() { ?>
            <div class="getting-started-wrap">
                <div class="getting-started-section">
                    <h2>How to display Dark Mode Switch Button using Gutenberg block</h2>
                    <p>You can place the switch button into any page/post by using the (Dark Mode Switch) gutenberg block , for your users to switch between the dark and normal mode.
                        <br> For displaying the Darkmode Switch button in Gutenberg use the (Dark Mode Switch) Block.</p>
					<?php echo do_shortcode( '[video width="640" src="https://www.youtube.com/watch?v=TPKa-Xg9w5c"]' ); ?>
                </div>

                <div class="getting-started-section">
                    <h2>How to display Dark Mode Switch Button using Elementor Widget</h2>
                    <p>Also, You can place the Dark Mode switch button into any page/post by using the (Dark Mode Switch) elementor widget.
                        <br> For displaying the Darkmode Switch button in Elementor use the (Dark Mode Switch) Widget.
                    </p>
					<?php echo do_shortcode( '[video src="https://www.youtube.com/watch?v=5Y8XawJg4pw"]' ); ?>
                </div>

            </div>
		<?php }

		/**
		 * Register the plugin page
		 */
		public function settings_menu() {
			add_options_page( __( 'WP Dark Mode Settings', 'wp-dark-mode' ), __( 'WP Dark Mode', 'wp-dark-mode' ), 'manage_options',
				'wp-dark-mode-settings', array( $this, 'settings_page' ) );
		}

		/**
		 * Display the plugin settings options page
		 */
		public function settings_page() { ?>

            <div class="wrap">

                <div class="wrap">
                    <h2><?php _e( 'WP Dark Mode Settings', 'wp-dark-mode' ) ?></h2>
					<?php self::$settings_api->show_settings(); ?>
                </div>

            </div>
		<?php }

		/**
		 * @return WP_Dark_Mode_Settings|null
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

	}
}

WP_Dark_Mode_Settings::instance();