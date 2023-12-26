<?php
global $wpdb;

// $sql = "SELECT * FROM wp_games WHERE thumb IS NOT NULL";
// $games = $wpdb->get_results($sql);

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
                        @foreach($search as $keyword)
                        <li style="display: inline-block;">
                            <form action="search" accept-charset="UTF-8" method="post">
                                @csrf
                                <input type="hidden" name="q" id="q" value="{{ $keyword['keyword'] }}" required="required" />
                                <button class="btn" type="submit" aria-label="Search" style="border-radius: 10px; padding: 1px 5px;">
                                    {{ $keyword['keyword'] }}
                                </button>
                            </form>
                        </li>
                        @endforeach
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
                <h3 class="home-title">Trò chơi (<?php echo $total ?>)
                </h3>
            </div>
        </div>
        <div class="items-container" id="items_container">
            <?php foreach ($games as $game) { ?>
                <div class="item thumb videobox grid-column">

                    <a title="Trò chơi <?php echo $game->name ?> - Chơi trực tuyến tại <?php echo get_bloginfo() ?>" href="<?php echo get_template_directory_uri() . '/template-parts/game.php?name=' . $game->name ?>">
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
    <h1>Các trò chơi Trực tuyến Miễn phí tại <a href="/"><?php echo get_bloginfo() ?></a></h1>
    <h2>Chơi trò chơi miễn phí trên <?php echo get_bloginfo() ?>. Các game hai người chơi và game trang điểm hàng đầu. Tuy nhiên, game mô phỏng và game nấu ăn cũng rất phổ biến trong các người chơi. Gamekafe cũng hoạt động trên các thiết bị di động và có nhiều game cảm ứng cho điện thoại. Ghé thăm Gamekafe và gia nhập với cộng đồng người chơi ngay.</h2>
</div>