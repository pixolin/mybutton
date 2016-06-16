<?php
/*
Plugin Name: MyButton
Version: 0.2
Description: Adds a custom button underneath posts.
Author: Bego Mario Garde
Author URI: https://pixolin.de
License: GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
TextDomain: mybutton

(c) Bego Mario Garde, 2016
MyTitle is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

MyTitle is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Scroll to Anchor. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'MYBUTTON_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MYBUTTON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/*
 * When registered, set default setting values
 */
register_activation_hook( __FILE__, 'mybutton_set_up_options' );
function mybutton_set_up_options(){
  	if( false == get_option( 'mybutton' ) ) {
			add_option('mybutton', array(
				'text'=> 'Button',
				'url' => 'https://wordpress.org')
			);
		}
}

/*
 * Load Textdomain
 */
add_action( 'plugins_loaded', 'mybutton_plugins_loaded' );
	function mybutton_plugins_loaded() {
		load_plugin_textdomain( 'mybutton', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

/*
 * Settings
 */
require_once( MYBUTTON_PLUGIN_PATH . 'settings/settings.php');
$mybuttonsettings = new MyButtonSettings();

/*
 * Function to create the button
 */
add_filter( 'the_content', 'mb_add_the_button', 10, 1 );

if(!function_exists('mb_add_the_button')):
function mb_add_the_button ( $content ) {

		$settings  = (array) get_option( 'mybutton' );
		if( !empty($settings['url']) ) {
			$link = $settings['url'];
		} else {
			$link = '#';
		}

		$out = '<form class="mybutton" action="'. $link .'" method="get">';
		$out .= '<button>'. esc_html($settings['text']) .'</button>';
		$out .= '</form>';

		$content = $content . $out;

		return $content;
}
endif;

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mb_plugin_action_links' );
if( !function_exists('mb_plugin_action_links')) {
	function mb_plugin_action_links( $links ) {
		$mylinks = array(
		'<a href="options-general.php?page=mybutton">'. __( 'Settings', 'mybutton' ) . '</a>'
		);

		return array_merge( $links, $mylinks );
	}
}
