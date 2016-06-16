<?php
/*
 * Settings
 */

class MyButtonSettings {
		function __construct() {
			add_action( 'admin_init', array( $this, 'register_button_setting') );
			add_action( 'admin_init', array( $this, 'setup_options' ) );
			add_action( 'admin_init', array( $this, 'section_and_fields' ) );
			add_action( 'admin_menu', array( $this, 'mybutton_settings_page') );
		}

		function register_button_setting() {
			register_setting( 'mybutton', 'mybutton', array( $this, 'sanitize') );
		}

		function setup_options() {
			if( false == get_option( 'mybutton' ) ) {
        add_option( 'mybutton' );
    	}
		}

		function section_and_fields(){
			add_settings_section(
				'mybutton_section' ,
				__('Please provide text and URL for the button.','mybutton'),
				array(),
				'mybutton' // place in menu "reading"
			);

			add_settings_field(
				'mybutton_text',
				__( 'Button Text', 'mybutton' ),
				array( $this, 'mybutton_text' ),
				'mybutton',
				'mybutton_section'
			);

			add_settings_field(
				'mybutton_url',
				__( 'Button URL', 'mybutton' ),
				array( $this, 'mybutton_url' ),
				'mybutton',
				'mybutton_section'
			);



		}

		function mybutton_text() {

			$mybutton = (array) get_option( 'mybutton' );

			$html = '<label for="mybutton_text">'.__('Button Text','mybutton').'</label><br />';
			$html .= '<input type="text" id="mybutton_text" name="mybutton[text]" value="' . esc_attr( $mybutton['text'] ) . '" /><br />';

			echo $html;
		}

		function mybutton_url() {

			$mybutton = (array) get_option( 'mybutton' );

			$html = '<label for="mybutton_url">'.__('Button URL','mybutton').'</label><br />';
			$html .= '<input type="url" id="mybutton_url" name="mybutton[url]" value="' . esc_attr( $mybutton['url'] ) . '" /><br />';

			echo $html;
		}


		function sanitize( $input ) {
			$output = array();
			if ($input) {
				foreach ( $input as $key => $value ) {
					if( isset( $input[$key] ) ) {
						$output[$key] = strip_tags( stripslashes( $input[$key] ) );
					}
				}
			}
			return apply_filters( 'sanitize', $output, $input );
		}

		function mybutton_settings_page() {
			add_options_page( 'My Button', __('My Button Settings', 'mybutton'), 'manage_options', 'mybutton', array( $this, 'mybutton_settings_form') );
		}

		function mybutton_settings_form() {
			?>
			<form action='options.php' method='post' class="wrap">

				<h1><?php _e('My Button', 'mybutton'); ?></h1>

				<?php
				settings_fields( 'mybutton' );
				do_settings_sections( 'mybutton' );
				submit_button();
				?>

			</form>
			<?php
		}
}
