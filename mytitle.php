<?php
/*
Plugin Name: MyTitle
Version: 0.2
Description: Gibt vor und nach dem Titel von Beiträgen etwas aus. (Einstellungen können im Menü Einstellungen > Lesen vorgenommen werden.)
Author: Bego Mario Garde
Author URI: https://pixolin.de
License: GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html

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
