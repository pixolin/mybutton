<?php
/*
Plugin Name: Peters Titel
Version: 0.1
Description: Gibt vor und nach dem Titel von Beiträgen etwas aus
Author: Bego Mario Garde
Author URI: https://pixolin.de
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'MYTITLE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MYTITLE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once( MYTITLE_PLUGIN_PATH . 'settings/settings.php');
$mytitlesettings = new My_Title();

add_filter( 'the_title', 'peters_titel', 10, 2 );

if(!function_exists('peters_title')):
function peters_titel ( $title, $id = null ) {

		$post_type = get_post_type( $id );
		$settings  = (array) get_option( 'mytitle' );

		if(!empty($settings['before'])) {
			$before = $settings['before'] . '&nbsp;';
		} else {
			$before ='';
		};

		if(!empty($settings['after'])) {
			$after = '&nbsp;'. $settings['after'];
		} else {
			$after ='';
		};

		if( 'post' === $post_type ) {
			$title     = $before . $title . $after;
		}

		return $title;
}
endif;
