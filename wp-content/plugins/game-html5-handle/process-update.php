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

        $wpdb->insert('wp_games', $dataPerGame);
    }
}

wp_redirect(admin_url('/admin.php?page=game_html5_handler'));
