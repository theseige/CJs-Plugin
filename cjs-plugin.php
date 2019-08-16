<?php

/*
Plugin Name: CJs Plugin
Plugin URI: https://wp.cjs.zone/cjs-plugin/
Description: My general plugin where I do testing and complex things.
Version: 1.0
Author: CJ Andren
Author URI: https://wp.cjs.zone/
License: GPL2
*/




/*
Begin Activation Functions
*/

function generate_activation_notice() {
    ?>
    <div class="notice notice-success is-dismissable">
        <p><?php _e( 'Thanks for enabling my plugin!', 'cjs-text-domain'); ?></p>
    </div>
    <?php
}

function cjs_plugin_activation() {
    add_option('Activated_Plugin', 'CJs-Plugin');
}

register_activation_hook(__FILE__, 'cjs_plugin_activation' );

function load_plugin() {
    if ( is_admin && get_option('Activated_Plugin' ) == 'CJs-Plugin' ) {
        delete_option('Activated_Plugin');
	    add_action( 'admin_notices', 'generate_activation_notice');
    }
}

add_action(admin_init, load_plugin());




/*
 * Below here will be the core functionality of our plugin
 */




/*
 * Begin Deactivation Functions - Uninstall is handled by uninstall.php
 */

function cjs_plugin_deactivation() {
    add_option('Deactivated_Plugin', 'CJs-Plugin');
}

register_deactivation_hook(__FILE__, 'cjs_plugin_deactivation');
