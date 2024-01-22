<?php if (!defined('ABSPATH')) die;
/*
Plugin Name: Config for only Apkafe
Description: All config SEO for Apkafe
Author: binhchay
Version: 1.0
License: GPLv2 or later
*/

add_action('template_redirect', function () {

	if ((defined('DOING_CRON') && DOING_CRON) || (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) || (defined('DOING_AJAX') && DOING_AJAX)) return;

	if (is_admin()) return;

	global $wp_query;
	if ($wp_query->is_404 === false) {
		return;
	} else {
		// $paths = explode('/', $_SERVER['REQUEST_URI']);
		// foreach ($paths as $path) {
		// 	if ($path == '404') {
		// 		if (end($paths) == '') {
		// 			status_header(200);
		// 			return;
		// 		}
		// 	} else {
		// 		wp_redirect('/404/');
		// 	}
		// }
	}
}, PHP_INT_MAX);

function wpb_change_search_url()
{
	if (is_search() && !empty($_GET['s'])) {
		wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
		exit();
	}
}
add_action('template_redirect', 'wpb_change_search_url');


$path = explode('/', $_SERVER['REQUEST_URI']);
if (in_array('page', $path)) {
	add_filter('wpseo_canonical', function () {
		$url = "https://" . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['REQUEST_URI'];
		$link = '';
		$statusExp = false;

		$explode = explode('/', $url);
		foreach ($explode as $check) {
			if ($check == 'page') {
				$link = $link . '/';
				break;
			}

			if ($link == '') {
				$link = $check;
			} else {
				if ($check == null) {
					if ($statusExp == false) {
						$link = $link . $check;
						$statusExp = true;
					} else {
						continue;
					}
				}
				$link = $link . '/' . $check;
			}
		}

		return $link;
	});
}

add_action('wp_head', function () {
	$paths = explode('/', $_SERVER['REQUEST_URI']);
	if (is_front_page()) {
		$urlFontPage = "https://" . $_SERVER['HTTP_HOST'] . '/';

		echo '<link rel="alternate" href="' . $urlFontPage . '" hreflang="x-default" />';
	}

	if (in_array('product-category', $paths)) {
		$host = 'https://apkafe.com';
		$urlProductCategory = $host . $_SERVER['REQUEST_URI'];
		echo '<link rel="alternate" href="' . $urlProductCategory . '" hreflang="x-default" />';
	}

	if (is_admin() || is_user_logged_in()) {
		$style = '<style type="text/css">
		#main-nav {
			margin-top: 30px !important;
		}
		</style>';

		echo $style;
	}
}, PHP_INT_MAX);
