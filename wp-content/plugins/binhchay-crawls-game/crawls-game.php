<?php if (!defined('ABSPATH')) die;
/*
Plugin Name: Crawls Game by Domain
Description: Only get game of gamepix by current domain
Author: binhchay
Version: 1.0
License: GPLv2 or later
*/

define('CRAWLS_ADMIN_VERSION', '1.0.0');
define('CRAWLS_GAME_DIR', 'binhchay-crawls-game');

require plugin_dir_path(__FILE__) . 'admin-form.php';
require plugin_dir_path(__FILE__) . 'simple_html_dom.php';

function admin_form_get_game()
{
    $plugin = new Admin_form_get_game();
    $plugin->init();
}

admin_form_get_game();
