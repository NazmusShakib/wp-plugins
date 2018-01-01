<?php
/**
 * Plugin Name: Practice Form
 * Plugin URI: https://nazmusshakib.github.io/
 * Description: Looking forward to be Great.
 * Version: 1.0.0
 * Author: Nazmus Shakib
 * Author URI: https://nazmusshakib.github.io/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */

//don't call the file directly
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!'); //ABS = absolute

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * This code runs during plugin activation
 */
function activate_Practice_plugin()
{
    Inc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate_Practice_plugin');

/**
 * This code runs during plugin deactivation
 */
function deactivate_Practice_plugin()
{
    Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactivate_Practice_plugin');

if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
