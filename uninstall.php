<?php
/*
 * Uninstall
 */

 // If uninstall is not called from WordPress, exit
 if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
     exit();
 }

 delete_option( $mybutton );

 // For site options in Multisite
 delete_site_option( $mybutton );  
