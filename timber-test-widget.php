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


function init_links_options() {
  global $links_option_identifier;

  $section_identifier = 'timber_test_widget_links';
  $section_page = 'general';
  add_settings_section(
    $section_identifier,
    'Timber Test Widget Links',
    __NAMESPACE__ . '\\links_description_callback',
    $section_page
  );

  add_settings_field(
    'links',
    'Links',
    __NAMESPACE__ . '\\links_form_callback',
    $section_page,
    $section_identifier
  );

  register_setting(
    $section_page,
    'links'
  );
}
add_action('admin_init', __NAMESPACE__ . '\\init_links_options');

function links_description_callback() {
  echo '<p>Widget links</p>';
}

function links_form_callback() {
  $context = array('links' => get_option('links'));
  \Timber::render('timber-test-widget-links-form.twig', $context);
}
