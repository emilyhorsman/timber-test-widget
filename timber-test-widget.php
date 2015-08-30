<?php
/**
 * Plugin Name: Timber Test Widget
 * Plugin URI: http://emilyhorsman.com
 * Text Domain: timber-test-widget
 * Description: A sample widget written with Timber.
 * Author: Emily Horsman
 * Author URI: http://emilyhorsman.com
 * Version: 1.0.0
 */
namespace buttercup;

defined('ABSPATH') or die('-1');

function add_plugin_template_folder_to_timber() {
  \Timber::$locations[] = path_join(plugin_dir_path(__FILE__), 'templates');
}
add_plugin_template_folder_to_timber();

require_once('includes/timber-test-widget.class.php');
require_once('includes/timber-test-widget-admin-notice.class.php');

add_action('widgets_init', function() {
  register_widget(__NAMESPACE__ . '\\Timber_Test_Widget');
});

add_action('admin_notices', __NAMESPACE__ . '\\Admin_Notice::hello_world');

function add_theme_styles() {
  wp_enqueue_style(
    'timber-test-widget',
    plugins_url('assets/css/timber-test-widget.css', __FILE__)
  );
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\add_theme_styles');
