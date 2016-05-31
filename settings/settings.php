<?php
/*
 * Settings
 */

class My_Title {
		function __construct() {
			add_action( 'admin_init', array( $this, 'register') );
			add_action( 'admin_init', array( $this, 'setup_options' ) );
			add_action( 'admin_init', array( $this, 'section_and_fields' ) );
		}

		function register() {
			register_setting( 'reading', 'mytitle', array( $this, 'sanitize') );
		}

		function setup_options() {
			if( false == get_option( 'mytitle' ) ) {
        add_option( 'mytitle' );
    	}
		}

		function section_and_fields(){
			add_settings_section(
				'mytitle_section' ,
				'Text vor und nach Beitragstiteln',
				array(),
				'reading' // place in menu "reading"
			);

			add_settings_field(
				'mytitle_field',
				'Soll vor oder nach dem Beitragstitel Text ausgegeben werden?',
				array( $this, 'mytitle_field' ),
				'reading',
				'mytitle_section'
			);


		}

		function mytitle_field() {

			$mytitle = (array) get_option( 'mytitle' );

			$html = '<label for="mytitle_before">Was soll <em>vor</em> dem Titel erscheinen?</label><br />';
			$html .= '<input type="text" id="mytitle_before" name="mytitle[before]" value="' . esc_attr( $mytitle['before'] ) . '" /><br />';
			$html .= '<label for="mytitle_after">Was soll <em>nach</em> dem Titel erscheinen?</label><br />';
			$html .= '<input type="text" id="mytitle_after" name="mytitle[after]" value="' . esc_attr( $mytitle['after'] ) . '" /><br />';

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
}
