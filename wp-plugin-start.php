<?php
/**
 * Plugin Name: WP Plugin Start
 * Author: Vladimir
 * Description: API for create new plugin
 * Version: 0.1
 *
 * Plugin URI:   https://example.com/plugins/the-basics/
 * Author URI:   https://author.example.com/
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  wpps
 * Domain Path:  /languages
 */
ini_set('display_errors', true);
error_reporting(-1);

include 'includes/autoloader.php';

WPPluginStart\autoloader([
//    'ClassName' => __DIR__ . '/path/to/file'
]);

new WPPluginStart\Plugin(__FILE__, ['version' => 0.1]);



