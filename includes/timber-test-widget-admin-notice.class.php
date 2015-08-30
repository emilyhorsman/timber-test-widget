<?php
namespace buttercup;

defined('ABSPATH') or die('-1');

class Admin_Notice {
  public static function hello_world() {
    \Timber::render('timber-test-widget-hello-world.twig');
  }
}
