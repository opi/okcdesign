<?php

/**
 * Reorganize theme settings in vertical tabs.
 * Puts plugin tab in first.
 * @param $form
 * @param $form_state
 */
function okcdesign_form_system_theme_settings_alter(&$form, $form_state) {

  include_once 'theme_plugins_manager/theme_plugins_manager.php';

  // create vertical tables
  $form['okcdesign'] = array(
    '#type' => 'vertical_tabs',
    '#weight' => -10,
  );

  // Create a "theme plugins" vertical tabs to enable / disabled theme plugins.
  // and set it in first position
  $form['okcdesign']['plugins'] = array(
    '#type' => 'fieldset',
    '#title' => t('Theme plugins'),
    '#description' => t('Enable additionnals plugins for your theme'),
  );

  $plugins = theme_get_plugins();
  // we build individual checkboxes because it is easier for us to disabled
  // checkboxes from required plugins this way with drupal FAPI.
  foreach($plugins as $id => $datas) {

    // group plugins in fieldset by package.
    $package = isset($datas['package']) ? $datas['package'] : 'others';
    $form['okcdesign']['plugins'][$package]['#title'] = $datas['package'];
    $form['okcdesign']['plugins'][$package]['#type'] = 'fieldset';
    $form['okcdesign']['plugins'][$package]["theme_plugin_$id"] = _okcdesign_build_checkbox($id, $datas, $form);

    // call settings_form() method in plugin object if exists; and use this as
    // plugin configuration form.
    $object = new $id;
    if (method_exists($object, 'settings_form') && $object->settings_form()) {
      $form['okcdesign']['plugins'][$package]["settings_$id"] =  array(
        '#title' => "Configure " . $datas['title'],
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
      );
      $form['okcdesign']['plugins'][$package]["settings_$id"]["theme_plugin_settings_$id"] = $object->settings_form();
      $form['okcdesign']['plugins'][$package]["settings_$id"]["theme_plugin_settings_$id"]['#tree'] = TRUE;
    }
    // just an html divider
    $form['okcdesign']['plugins'][$package][$id]['divider'] = array(
      '#type' => 'item',
      '#markup' => "<hr/>"
    );

  }

  // put back Drupal settings in a "General settings" vertical tab
  $form['okcdesign']['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('General Settings'),
  );
  foreach (array('theme_settings', 'logo', 'favicon') as $field) {
    if (isset($form[$field])) {
      $form['okcdesign']['general'][$field] =  $form[$field];
      unset($form[$field]);
    }
  }



}

/**
 * Build a checkbox to enable / disabled a plugin.
 * A plugin cannot be disabled if it is required by another plugin.
 * @param $id
 * @param $plugin
 * @return array
 */
function _okcdesign_build_checkbox($id, $plugin) {

  $plugins = theme_get_plugins();

  // Fetch all plugins which required this plugin to work as expected
  $required_by_plugins = array();
  foreach ($plugin['required_by_plugins'] as $required_by_plugin) {
    $required_by_plugins[] = $required_by_plugin['title'];
  }

  // Find all plugins our plugin need to work.
  $dependencies = array();
  if (isset($plugin['dependencies'])) {
    foreach($plugin['dependencies'] as $dependencie_id) {
      $dependencies[] = $plugins[$dependencie_id]['title'];
    }
  }

  // build a title for the checkbox, adding description and
  // all dependencies informations.
  $description = '';
  $title = "<strong>" . strtoupper($plugin['title']) . "</strong>";
  if (isset($plugin['description'])) {
    $title .= " - " . $plugin['description'];
  }
  if ($required_by_plugins) {
    $description .= '<br/> <strong>Required by : </strong>' . implode(', ', $required_by_plugins);
  }
  if ($dependencies) {
    $description .= '<br/> <strong>Depends on: </strong>' . implode(', ', $dependencies);
  }

  // create checkbox
  $checkbox = array(
    '#type' => 'checkbox',
    '#title' => $title,
    '#default_value' => theme_get_setting("theme_plugin_$id"),
    '#description' =>  $description,

  );

  // do not allow user to disable a plugin that is required by others plugins
  if ($required_by_plugins || !empty($plugin['required'])) {
    // comment disabled, may cause troubles when savings settings.
    //$checkbox['#disabled'] = TRUE;

  }

  return $checkbox;
}


