<?php

if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

add_action('init', function ($search) {
	add_rewrite_rule('search/?$', 'index.php?s=' . $search, 'top');
});

function game_html5_rewrite_rule()
{
	add_rewrite_rule(
		'^games/([^/]*)/?',
		'index.php?name=1-2-3',
		'top'
	);
}
add_action('init', 'game_html5_rewrite_rule');

function game_html5_get_param()
{
	if (false !== get_query_var('name')) {
		$_GET['name'] = get_query_var('name');
	}
}
add_action('parse_query', 'game_html5_get_param');

function game_html5_setup()
{
	load_theme_textdomain('game_html5', get_template_directory() . '/languages');

	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'game_html5'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'game_html5_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'game_html5_setup');

function game_html5_content_width()
{
	$GLOBALS['content_width'] = apply_filters('game_html5_content_width', 640);
}
add_action('after_setup_theme', 'game_html5_content_width', 0);

function game_html5_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'game_html5'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'game_html5'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'game_html5_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function game_html5_scripts()
{
	wp_enqueue_style('game_html5-style-user', get_template_directory_uri() . '/css/user.css', array(), _S_VERSION);
	wp_enqueue_style('game_html5-style-latin', get_template_directory_uri() . '/css/latin.css', array(), _S_VERSION);
	wp_enqueue_style('game_html5-style-app', get_template_directory_uri() . '/css/application.css', array(), _S_VERSION);
	wp_style_add_data('game_html5-style', 'rtl', 'replace');

	wp_enqueue_script('game_html5-jquery', get_template_directory_uri() . '/plugin/jquery/jquery.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('game_html5-main', get_template_directory_uri() . '/js/main.js', array(), _S_VERSION, true);
	wp_enqueue_script('game_html5-user', get_template_directory_uri() . '/js/user.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'game_html5_scripts');

require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}
