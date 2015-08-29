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

add_action('widgets_init', function() {
  register_widget(__NAMESPACE__ . '\\Timber_Test_Widget');
});

class Timber_Test_Widget extends \WP_Widget {
  const I18N_DOMAIN = 'timber-test-widget';

  function __construct() {
    if (!class_exists('\Timber')) {
      error_log('Tried to construct ' . __CLASS__ . ' but Timber was not found.');
      return;
    }

    parent::__construct(
      'timber_test_widget',                         // Base ID
      __('Timber Test Widget', self::I18N_DOMAIN),  // Name in admin panel
      array('description' => __('Sample widget written with Timber', self::I18N_DOMAIN), )
      );

    \Timber::$locations[] = path_join(plugin_dir_path(__FILE__), 'templates');
  }

  public function widget($args, $instance) {
    $context = \Timber::get_context();
    $context['args'] = $args;
    $context['instance'] = $instance;
    \Timber::render('timber-test-widget.twig', $context);
  }

  public function form($instance) {
    $context = \Timber::get_context();
    $context['title'] = (!empty($instance['title'])) ? $instance['title'] :
               __('Test', self::I18N_DOMAIN);
    $context['widget'] = $this;
    \Timber::render('timber-test-widget-form.twig', $context);
  }

  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['static'] = 'This never changes!';
    return $instance;
  }
}
