<?php
/**
 * Plugin Name:       Gp Customize Scripts
 * Description:       Add scripts in head, body and footer using wp customizer
 * Version:           1.0.0
 * Author:            German Pichardo PG6BM
 * Text Domain:       gp-customize-scripts
 */

namespace GP_CUSTOMIZE_SCRIPTS;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// The class that contains the plugin info.
require_once plugin_dir_path(__FILE__) . 'includes/class-info.php';

/**
 * Run the plugin init.
 */
function run()
{
    include_once plugin_dir_path(__FILE__) . 'customize/class-wp-customize-scripts.php';
    $wp_customize_scripts = new WP_Customize_Scripts();
}

run();
