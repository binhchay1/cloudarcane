<?php
global $wpdb;

$items_per_page = 30;
$table_name = $wpdb->prefix . "games";
$page = isset($_GET['cpage']) ? abs((int) $_GET['cpage']) : 1;
$offset = ($page * $items_per_page) - $items_per_page;

$query = 'SELECT * FROM ' . $table_name . ' WHERE thumb IS NOT NULL';

$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
$total = $wpdb->get_var($total_query);

$games = $wpdb->get_results($query . ' ORDER BY name ASC LIMIT ' . $offset . ', ' . $items_per_page, OBJECT);
?>

<style type="text/css">
    .top-tags ul li {
        list-style-type: none;
    }

    .top-tags ul {
        display: flex;
        flex-direction: row;
    }
</style>

<div class="main js-search-trends">
    <div class="box search-trends-box">
        <div class="row single-line">
            <div class="search-trends-container col-md-12">
                <p class='h5'>Top Căutare</p>
                <div class="open-modal-btn">
                    <img src="<?php echo get_template_directory_uri() . '/svg/flag/ro.svg' ?>" class="image-flag image-flag-top-search" alt="Ngôn ngữ mặc định">
                </div>
                <div class="search-trends">
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="country-chooser-modal sub-menu">
    <div class="row controls-2">
        <div class="search-input-col col-md-12"></div>
    </div>
    <div class="row content-1">
        <div class="col-md-12 countries-container">
            <div class="countries"></div>
        </div>
    </div>
    <div class="row content-2">
        <div class="search-results"></div>
    </div>
</div>
<div class="tint"></div>
<div class="main">
    <div class="box items-grid no-background">
        <div class="row">
            <div class="item-title-container col-md-12">
                <h3 class="home-title">Joc (<?php echo $total ?>)
                </h3>
            </div>
        </div>
        <div class="items-container" id="items_container">
            <?php foreach ($games as $game) { ?>
                <div class="item thumb videobox grid-column">

                    <a title="Joc <?php echo $game->name ?> - Joacă online la <?php echo get_bloginfo() ?>" href="<?php echo '/game-html5-wp/games/' . $game->name ?>">
                        <div class="item__thumbarea">
                            <div class="item__microthumb"></div>
                            <div class="item__img-container">
                                <img class="thumb lazy playable" alt="<?php echo $game->name ?>" src="<?php echo $game->thumb ?>" />
                            </div>
                        </div>
                        <div class="item__infos">
                            <h4 class="item__title ltr"><?php echo ucfirst(str_replace("-", " ", $game->name)); ?></h4>
                            <p class="item__title ltr">Modobom</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <div class="navigator mobile">
            <?php
            echo paginate_links(array(
                'base' => add_query_arg('cpage', '%#%'),
                'format' => '',
                'prev_text' => __('&laquo;'),
                'next_text' => __('&raquo;'),
                'total' => ceil($total / $items_per_page),
                'current' => $page
            ));
            ?>
        </div>
    </div>
    <h1>Jocuri online gratuite la <a href="/"><?php echo get_bloginfo() ?></a></h1>
    <h2>Joacă jocuri gratuite pe <?php echo get_bloginfo() ?>. Cele mai bune jocuri pentru doi jucători și jocuri de machiaj. Cu toate acestea, jocurile de simulare și jocurile de gătit sunt, de asemenea, foarte populare printre jucători. Toponeapk funcționează și pe dispozitive mobile și are multe jocuri tactile pentru telefoane. Vizitați Gamekafe și alăturați-vă comunității de jucători acum.</h2>
</div>