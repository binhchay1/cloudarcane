<?php
if (!defined('ABSPATH')) die;
/**
 * @package Game HTML5 Handler
 * @version 1.7.2
 */
/*
Plugin Name: Game HTML5 Handler
Description: This is not just a plugin, this is a handler for add and update game html5 just only for this site. Dont use this plugin for other domains
Author: binhchay
Version: 1.0.0
*/

define('BINHCHAY_ADMIN_VERSION', '1.0.0');
define('BINHCHAY_ADMIN_DIR', 'game-html5-handle');

require plugin_dir_path(__FILE__) . 'admin-form.php';
function game_html5_wp_admin_form()
{
    $plugin = new Game_Html5();
    $plugin->init();
}
game_html5_wp_admin_form();
