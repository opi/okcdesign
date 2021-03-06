<?php
/**
 * Base class to build a plugin, provided helpers variables.
 */

class theme_plugin_base {

  protected $base_theme_name = '';
  // path of okcdesign theme
  protected $base_theme_path = '';
  // default theme for the site
  protected $default_theme_path = '';
  protected $vendors_directory = '';

  // use this method to provide a configuration form for the plugin.
  // @see foundation_topbar for a working example.
  function settings_form(){}

  function __construct() {
    $this->base_theme_name = 'okcdesign';
    $this->base_theme_path = drupal_get_path('theme', $this->base_theme_name);
    $this->vendors_directory = 'bower_components';
    $this->default_theme_path = drupal_get_path('theme', variable_get('theme_default'));
  }

  /**
   * Helper function to get foundation settings stored in _settings.scss file.
   * @return array
   */
  protected function get_foundation_settings() {
    $file = file(drupal_get_path('theme', variable_get('theme_default', 'okcdesign')). '/scss/_settings.scss');
    $settings = array(
      'total_columns' => NULL,
    );
    foreach ($file as $line) {
      if (strpos($line, '$total-columns') !== FALSE) {
        $parts = explode(':', $line);
        if (isset($parts[1])) {
          $settings['total_columns'] = str_replace(';', '', $parts[1]);
        }
      }
    }
    return $settings;
  }

}

