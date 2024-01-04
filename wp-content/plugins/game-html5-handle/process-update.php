<?php
$root = preg_replace('/wp-content.*$/', '', __DIR__);
require($root . 'wp-load.php');

global $wpdb;

$path = getcwd();
$explode = explode('\\', $path);
$absolutePath = '';
foreach ($explode as $exp) {
    if ($exp == 'wp-content') {
        break;
    }

    if ($absolutePath == '') {
        $absolutePath = $exp;
    } else {
        $absolutePath .= '\\' . $exp;
    }
}

$dirGameList = $absolutePath . '\modobom';
$fileList = scandir($dirGameList);

foreach ($fileList as $key => $name) {
    if ($key == 0 || $key == 1) {
        continue;
    }

    $query  = "SELECT * FROM wp_games WHERE `name` = %s";
    $results = $wpdb->get_results($wpdb->prepare($query, $name));

    if (empty($results)) {
        $dirGame = $dirGameList . '\\' . $name;
        $scanDirGame = scandir($dirGame);
        $dataPerGame = [];
        $dataPerGame['name'] = $name;
        $dataPerGame['url'] = 'modobom/' . $name;

        foreach ($scanDirGame as $keyDir => $file) {
            if ($keyDir == 0 || $keyDir == 1) {
                continue;
            }

            if (strpos($file, 'icon.jpg') !== false || strpos($file, 'big_icon.jpg') !== false) {
                $dataPerGame['thumb'] = 'modobom/' . $name . '/' . $file;
            }
        }

        if (empty($dataPerGame['thumb'])) {
            continue;
        }

        $path = '/games/' . $dataPerGame['name'];
        $src = site_url() . '/modobom/' . $dataPerGame['name'];
        $post_guid_p = site_url() . $path;
        $post_content = '
        <!-- wp:html -->
            <div class="iframe-area">
                <iframe loading="lazy" src="' . $src . '" id="game-iframe" frameBorder="0" scrolling="yes" allowfullscreen="true" 
                webkitallowfullscreen="true" mozallowfullscreen="true" oallowfullscreen="true" msallowfullscreen="true">
                </iframe>
            </div>
        <!-- /wp:html -->';

        $new_post_p = array(
            'post_author' => 1,
            'post_date' => date('Y-m-d H:i:s'),
            'post_date_gmt' => date('Y-m-d H:i:s'),
            'post_content' => $post_content,
            'post_title' => ucfirst(str_replace('-', ' ', $dataPerGame['name'])),
            'post_status' => 'publish',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => $dataPerGame['name'],
            'post_parent' => 0,
            'guid' => $post_guid_p,
            'menu_order' => 0,
            'post_type' => 'page',
        );

        $post_id = wp_insert_post($new_post_p, true);
        if (is_wp_error($post_id)) {
            continue;
        }
        $dataPerGame['post_id'] = $post_id;
        $post_name_i = $post_id . '-revision-v1';
        $path_i = $post_id . '-autosave-v1/';
        $post_guid_i = site_url() . '/' . $path_i;

        $new_post_i = array(
            'post_author' => 1,
            'post_date' => date('Y-m-d H:i:s'),
            'post_date_gmt' => date('Y-m-d H:i:s'),
            'post_content' => $post_content,
            'post_title' => ucfirst(str_replace('-', ' ', $dataPerGame['name'])),
            'post_status' => 'inherit',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_name' => $post_name_i,
            'post_parent' => $post_id,
            'guid' => $post_guid_i,
            'menu_order' => 0,
            'post_type' => 'revision',
        );

        $post_id = wp_insert_post($new_post_i, true);
        $wpdb->insert('wp_games', $dataPerGame);
    }
}

wp_redirect(admin_url('/admin.php?page=game_html5_handler'));
