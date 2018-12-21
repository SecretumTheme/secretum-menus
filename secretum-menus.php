<?php
namespace SecretumMenus;

/**
 * Plugin Name: Secretum Menus Shortcode
 * Plugin URI: https://github.com/SecretumTheme/secretum-menus
 * Description: Secretum Menus Shortcode allows developers to provide a customizable menu shortcode for all registered menus.
 * Version: 0.0.2
 * License: GNU GPLv3
 * Copyright (c) 2018 Secretum Theme
 * Author: Secretum Theme
 * Author URI: https://github.com/SecretumTheme
 * Text Domain: secretum-menus
 *
 * @package Secretum
 * @subpackage SecretumMenus
 */


// Constants
define('SECRETUM_MENUS_WP_MIN_VERSION', '3.8');
define('SECRETUM_MENUS_PLUGIN_FILE',    __FILE__);
define('SECRETUM_MENUS_PLUGIN_DIR',     dirname(SECRETUM_MENUS_PLUGIN_FILE));
define('SECRETUM_MENUS_PLUGIN_BASE',    plugin_basename(SECRETUM_MENUS_PLUGIN_FILE));


// Include Functions
require SECRETUM_MENUS_PLUGIN_DIR . '/functions.php';


// Activate Plugin
register_activation_hook(SECRETUM_MENUS_PLUGIN_FILE, '\SecretumMenus\Functions\activate');


/**
 * Add Shortcode: secretum_menus
 *
 * @example [secretum_menus menu="1"]
 * @example [secretum_menus menu="short"]
 * @example [secretum_menus menu="REQUIRED" container="" container_class="" container_id="" menu_class="" menu_id="" fallback="" walker="" depth="" before="" after="" link_before="" link_after="" items_wrap="" items_class="" item_spacing="" divider=""]
 *
 * @link https://developer.wordpress.org/reference/functions/add_shortcode/
 */
add_shortcode(
    'secretum_menus',
    '\SecretumMenus\Functions\shortcode'
);


// 
/**
 * Add Menu Meta Box
 *
 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
 */
add_action('admin_init', function() {
    add_meta_box(
        'secretum-menus-mb',
        __('Menu Shortcode', 'secretum-menus'),
        '\SecretumMenus\Functions\metabox',
        'nav-menus',
        'side',
        'default'
    );
});

// Inject Links Into Plugin.php Admin
add_filter('plugin_row_meta', '\SecretumMenus\Functions\links', 10, 2);

// Secretum Updater Plugin
if (file_exists(WP_PLUGIN_DIR . '/secretum-updater/puc/plugin-update-checker.php')) {
    include_once(WP_PLUGIN_DIR . '/secretum-updater/puc/plugin-update-checker.php');
    $secretum_hf_updater = \Puc_v4_Factory::buildUpdateChecker(
        'https://raw.githubusercontent.com/SecretumTheme/secretum-menus/master/updates.json',
        SECRETUM_MENUS_PLUGIN_FILE,
        'secretum-menus'
    );
}
