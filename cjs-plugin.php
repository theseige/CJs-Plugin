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
function generate_activation_notice()
{
    ?>
    <div class="notice notice-success is-dismissable">
        <p><?php _e( 'Thanks for enabling my plugin!', 'cjs-text-domain'); ?></p>
    </div>
    <?php
}

function cjs_plugin_activation()
{
    add_option('Activated_Plugin', 'CJs-Plugin');
}

register_activation_hook(__FILE__, 'cjs_plugin_activation' );

function load_plugin()
{
    if ( is_admin && get_option('Activated_Plugin' ) == 'CJs-Plugin' ) {
        delete_option('Activated_Plugin');
	    add_action( 'admin_notices', 'generate_activation_notice');
    }
}

add_action(admin_init, load_plugin());


/*
 * Below here will be the core functionality of our plugin
 */

function cjs_add_class_to_body()
{
    if ( !is_admin() ) {
        $classes[] = 'cj-has-a-class';
    }
    return $classes;
}

function cjs_options_page()
{
/* Using this function will add a menu option directly on the main menu
     add_menu_page(
        'CJs',
        'CJs Options',
        'manage_options',
        'cjs',
        'cjs_options_page_html',
        '',
        20
    );
*/

/*
 * Using this function will add a submenu option under Tools
*/

    add_submenu_page(
            'tools.php',
        'CJs Options',
        'CJs Options',
        'manage_options',
        'cjs',
        'cjs_options_page_html'
    );
}

/*
 * This is the default html for the options page in the Admin Menu
 */
function cjs_options_page_html()
{
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action=""options.php" method="post">
                <?php
                settings_fields( 'cjs_options');
                do_settings_sections( 'cjs' );
                submit_button( 'Save Settings' );
                ?>
            </form>
            <p><?php echo esc_html('It works!' ); ?></p>
        </div>
    <?php
    $body = wp_remote_retrieve_body( wp_remote_get('https://api.github.com/users/theseige' ));
    echo $body;
}

/*
 * Enabling this action will remove the default Options page in the Admin Menu
 * It is still directly accessible.
 * Use add_action('admin_menu', 'cjs_options_page_remove', 99);
 * Must be below add_action('admin_menu', 'cjs_options_page');
 */
function cjs_options_page_remove()
{
    remove_menu_page('cjs');
}

/*
 * Modify the post object using this function
 * Implement add_action('the_post', 'cjs_post_action');
 * to include and test this functionality
 */
function cjs_post_action()
{
    echo esc_html('This is a post action performed by CJs Plugin!');
}

/*
 * Basic shortcode function
 */
function cjs_shortcodes_init()
{
    function cjs_shortcode($atts = [], $content = null)
    {
	    echo esc_html('My shortcode works!');
	    return $content;
    }
    add_shortcode('cjs', 'cjs_shortcode');
}

add_action('admin_menu', 'cjs_options_page');
add_action('init', 'cjs_shortcodes_init');
add_filter('body_class', 'cjs_add_class_to_body');


/*
 * Begin Deactivation Functions - Uninstall is handled by uninstall.php
 */
function cjs_plugin_deactivation() {
    add_option('Deactivated_Plugin', 'CJs-Plugin');
}

register_deactivation_hook(__FILE__, 'cjs_plugin_deactivation');
