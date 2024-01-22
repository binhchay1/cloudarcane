<?php

require('/wp-load.php');

$post = $_POST;
if (empty($post)) {
    die;
}

global $wpdb;
foreach ($posts as $key => $post) {
    $table = $wpdb->prefix . 'set_category';
    $sql = "UPDATE " . $table . " SET post_id='" . $post . "' WHERE key_post='" . $key . "'";
    $results = $wpdb->get_results($sql);
}

wp_redirect(admin_url('/admin.php?page=topgame-seo_top_game_app&status=saved'));
