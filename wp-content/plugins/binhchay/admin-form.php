<?php
class TopGame_Admin_Form
{
    const ID = 'topgame-seo';

    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_page'), 1);
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    public function get_id()
    {
        return self::ID;
    }

    public function admin_enqueue_scripts($hook_suffix)
    {
        if (strpos($hook_suffix, $this->get_id()) === false) {
            return;
        }

        wp_enqueue_style('topgame-admin-form-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', BINHCHAY_ADMIN_VERSION);
        wp_enqueue_script(
            'topgame-admin-form-bs',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            BINHCHAY_ADMIN_VERSION,
            true
        );

        wp_enqueue_script(
            'topgame-admin-form-bs',
            'https://code.jquery.com/jquery-3.7.1.slim.js'
        );

        echo '
        <style>
            .ul-post {
                height : 400px !important;
                overflow: scroll;
                overflow-x : hidden;
            }

            .button-submit {
                border: 1px solid black !important;
            }

            #alert-post {
                display: none;
            }
            
            .ul-posted {
                max-height : 400px !important;
                overflow: scroll;
                overflow-x : hidden;
            }
        </style>';
    }

    public function add_menu_page()
    {
        add_menu_page(
            esc_html__('topgame for SEO', 'topgame-seo'),
            esc_html__('topgame for SEO', 'topgame-seo'),
            'manage_options',
            $this->get_id(),
            array(&$this, 'load_view_post'),
            'dashicons-feedback'
        );

        add_submenu_page(
            $this->get_id(),
            esc_html__('Trending Search', 'topgame-seo'),
            esc_html__('Trending Search', 'topgame-seo'),
            'manage_options',
            $this->get_id() . '_trending',
            array(&$this, 'load_view_trending')
        );

        add_submenu_page(
            $this->get_id(),
            esc_html__('Set Category', 'topgame-seo'),
            esc_html__('Set Category', 'topgame-seo'),
            'manage_options',
            $this->get_id() . '_top_game_app',
            array(&$this, 'load_view_set_category'),
        );
    }

    public function load_view_post()
    {
        $listGame = $this->getListGame();
        $listConfig = $this->getConfigForTopGame();

        $listTextKey = [
            'slide_big' => 'Slide big',
            'slide_small' => 'Slide small',
            'popular' => 'Popular',
            'weekly_games' => 'Weekly games',
            'new_weekly_games' => 'New weekly games',
            'top_new' => 'Top new',
            'most_played' => 'Most played',
        ];

        echo '<div class="container mt-5">';
        echo "<div class='alert' role='alert' id='alert-post'></div>";

        foreach ($listConfig as $record) {
            $explode = explode(',', $record->post_id);
            $stringList = '';
            foreach ($explode as $id) {
                if (empty($stringList)) {
                    $stringList = $stringList . get_the_title($id);
                } else {
                    $stringList = $stringList . ', ' . get_the_title($id);
                }
            }
            echo '<p>List ' . $listTextKey[$record->key_post] . ' : ' . $stringList . '</p>';
        }

        echo '
            <div class="input-group mb-3">
            <input type="text" class="form-control" aria-label="Search list" 
            aria-describedby="inputGroup-sizing-default" placeholder="Enter post title" id="search-post-list">
            </div>';
        echo '<ul class="list-group ul-post">';
        foreach ($listGame->posts as $post) {
            $titlePost = get_permalink($post->ID);
            echo '<li class="list-group-item item-post">
                <span class="post-title">' . $titlePost . '</span>
                <span>
                    <select class="form-select" aria-label="Selection" id="' . $post->ID . '">
                        <option value="">Open this select menu</option>
                        <option value="slide_big">Slide big</option>
                        <option value="slide_small">Slide small</option>
                        <option value="popular">Popular</option>
                        <option value="weekly_games">Weekly games</option>
                        <option value="new_weekly_games">New weekly games</option>
                        <option value="top_new">Top new</option>
                        <option value="most_played">Most played</option>
                    </select>
                </span>
                </li>';
        }
        echo '</ul>';
        echo '
        <form action="/game-html5-wp/process-data-post.php" method="POST" id="form-post-config">
            <input type="hidden" name="slide_big" value="" id="slide_big-form"/>
            <input type="hidden" name="slide_small" value="" id="slide_small-form"/>
            <input type="hidden" name="popular" value="" id="popular-form"/>
            <input type="hidden" name="weekly_games" value="" id="weekly_games-form"/>
            <input type="hidden" name="new_weekly_games" value="" id="new_weekly_games-form"/>
            <input type="hidden" name="top_new" value="" id="top_new-form"/>
            <input type="hidden" name="most_played" value="" id="most_played-form"/>
        </form>';
        echo '<button class="btn button-submit" id="save-posts-config" onclick="saveConfigSave()">Save</button>';
        echo '</div>';

        echo "
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const status = urlParams.get('status')

                if(status != null) {
                    let alert = document.getElementById('alert-post');
                    if(status == 'saved') {
                        alert.classList.add('alert-success');
                        alert.innerHTML = 'Change is saved';
                    } else {
                        alert.classList.add('alert-danger');
                        alert.innerHTML = 'Change is not saved';
                    }

                    alert.style.display = 'block';
                }
            });
            var input = document.getElementById('search-post-list');
            var lis = document.getElementsByClassName('item-post');
            var listResult = [];
            var listConfigSave = {
                'slide_big' : [],
                'slide_small' : [],
                'popular' : [],
                'weekly_games' : [],
                'new_weekly_games' : [],
                'top_new' : [],
                'most_played' : []
            };
            var listConfigGet = " . json_encode($listConfig) . "

            for (var y = 0; y < listConfigGet.length; y++) {
                if(listConfigGet[y].post_id != '' && listConfigGet[y].post_id != null) {
                    var split = listConfigGet[y].post_id.split(',');
                    for(var a = 0; a < split.length; a++) {
                        let select = document.getElementById(split[a]);
                        select.value = listConfigGet[y].key_post;
                    }
                }
            }

            input.onkeyup = function () {
            var filter = input.value.toUpperCase();

            for (var i = 0; i < lis.length; i++) {
                var text = lis[i].getElementsByClassName('post-title')[0].innerHTML;
                if (text.toUpperCase().indexOf(filter) == 0) 
                    lis[i].style.display = 'list-item';
                else
                    lis[i].style.display = 'none';
                }
            }

            function saveConfigSave() {
                for (var i = 0; i < lis.length; i++) {
                    let result = getSelectValues(lis[i].getElementsByTagName('select')[0]);
                    listResult.push(result);
                }
    
                for (var k = 0; k < listResult.length; k++) {
                    if(listResult[k][0] == 'slide_big') {
                        listConfigSave.slide_big.push(listResult[k][1]);
                    }

                    if(listResult[k][0] == 'slide_small') {
                        listConfigSave.slide_small.push(listResult[k][1]);
                    }

                    if(listResult[k][0] == 'popular') {
                        listConfigSave.popular.push(listResult[k][1]);
                    }

                    if(listResult[k][0] == 'weekly_games') {
                        listConfigSave.weekly_games.push(listResult[k][1]);
                    }

                    if(listResult[k][0] == 'new_weekly_games') {
                        listConfigSave.new_weekly_games.push(listResult[k][1]);
                    }

                    if(listResult[k][0] == 'top_new') {
                        listConfigSave.top_new.push(listResult[k][1]);
                    }

                    if(listResult[k][0] == 'most_played') {
                        listConfigSave.most_played.push(listResult[k][1]);
                    }
                }

                document.getElementById('slide_big-form').value = listConfigSave.slide_big;
                document.getElementById('slide_small-form').value = listConfigSave.slide_small;
                document.getElementById('popular-form').value = listConfigSave.popular;
                document.getElementById('weekly_games-form').value = listConfigSave.weekly_games;
                document.getElementById('new_weekly_games-form').value = listConfigSave.new_weekly_games;
                document.getElementById('top_new-form').value = listConfigSave.top_new;
                document.getElementById('most_played-form').value = listConfigSave.most_played;

                document.getElementById('form-post-config').submit();
            }

            function getSelectValues(select) {
                var result = [];
                var options = select && select.options;
                var opt;
              
                for (var i=0, iLen=options.length; i<iLen; i++) {
                  opt = options[i];
              
                  if (opt.selected) {
                    if(opt.value !== '') {
                        result.push(opt.value);
                        result.push(select.id);
                    }
                  }
                }

                return result;
            }
        </script>";
    }

    public function load_view_trending()
    {
        $listTrending = $this->getUrlTrending();
        $count = 1;
        $urlTrending = '/process-data-trending.php';
        $urlDeleteTrending = '/delete-data-trending.php';
        $classText = "'text-danger'";
        $functionDelete = "'deleteTrending(this.id)'";
        $idText = "id='td-";

        echo '
        <style>
            .form-control {
                width: 49% !important;
            }

            a:hover {
                cursor: pointer;
            }
        </style>';

        echo '<div class="container mt-5">';
        echo '<label for="basic-url" class="form-label">Add trending search</label>
        <div class="form-group mb-3 d-flex justify-content-between">
            <input type="text" class="form-control" placeholder="Enter title" id="title-input">
            <input type="text" class="form-control" placeholder="Enter link" id="link-input">
        </div>
        <div><button class="btn btn-success" id="store-trending" onclick="saveTrending()">Save</button></div>';
        echo '
        <table class="table" id="table-trending">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Link</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($listTrending as $trending) {
            echo    '<tr id="td-' . $trending->id . '">
                    <th scope="row">' . $count . '</th>
                    <td>' . $trending->title . '</td>
                    <td>' . $trending->url . '</td>
                    <td><a class="' . 'text-danger' . '" id="' . $trending->id . '" onclick="' . 'deleteTrending(this.id)' . '">x</a></td>
                    </tr>';

            $count++;
        }

        echo    '</tbody>
        </table>';
        echo '</div>';

        echo '<script>
            function saveTrending() {

                let title = jQuery("#title-input").val();
                let url = jQuery("#link-input").val();
                let data = {"title": title, "url": url};

                jQuery.ajax({
                    url: "' . $urlTrending . '",
                    type: "GET",
                    dataType: "json",
                    data: data
                }).done(function(result) {
                    let rowCount = jQuery("#table-trending tr").length;
                    let currentId = 0;
                    if(rowCount == 1) {
                        currentId = 1;
                    } else {
                        let lastId = jQuery("#table-trending tr:last").attr("id");
                        let split = lastId.split("-");
                        currentId = parseInt(split[1]) + 1;
                    }
                    
                    let newTr = "<tr ' . $idText . '" + currentId + "' . "'" . '><th>" + rowCount + "</th><td>" + title + "</td><td>" + url + "</td><td><a id=" + currentId + " class=' . $classText . ' onclick=' . $functionDelete . '>x</a></td></tr>";
                    
                    jQuery("#table-trending tbody").append(newTr);
                });
            }

            function deleteTrending(id) {
                let data = {"id": id};
                jQuery.ajax({
                    url: "' . $urlDeleteTrending . '",
                    type: "GET",
                    dataType: "json",
                    data: data
                }).done(function(result) {
                    let idTr = "#td-" + id;
                    let deleteTr = jQuery(idTr);
                    deleteTr.remove();
                });
            }
        </script>';
    }

    public function load_view_set_category()
    {
        $listCategory = $this->getListCategoryGame();
        $listSetCategory = $this->getListSetCategory();
        $listSet = [];

        foreach ($listSetCategory as $record) {
            $listSet[$record->location] = $record->category;
        }

        echo '<div class="container mt-5">';
        echo "<div class='alert' role='alert' id='alert-post'></div>";

        echo '<div class="container mt-5"><form action="/game-html5-wp/process-data-category.php" method="POST">';
        echo '<div>
        <p>First Category</p>
        <select class="form-select form-select-lg mb-3" name="first">';
        foreach ($listCategory as $category) {
            if ($category->slug == $listSet['first']) {
                echo '<option value="' . $category->slug . '" selected>' . $category->name . '</option>';
            } else {
                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
            }
        }
        echo '</select></div>';

        echo '<div>
        <p>Second Category</p>
        <select class="form-select form-select-lg mb-3" name="second">';
        foreach ($listCategory as $category) {
            if ($category->slug == $listSet['second']) {
                echo '<option value="' . $category->slug . '" selected>' . $category->name . '</option>';
            } else {
                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
            }
        }
        echo '</select></div>';

        echo '<div>
        <p>Third Category</p>
        <select class="form-select form-select-lg mb-3" name="third">';
        foreach ($listCategory as $category) {
            if ($category->slug == $listSet['third']) {
                echo '<option value="' . $category->slug . '" selected>' . $category->name . '</option>';
            } else {
                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
            }
        }
        echo '</select></div>';

        echo '<div>
        <p>Fourth Category</p>
        <select class="form-select form-select-lg mb-3" name="fourth">';
        foreach ($listCategory as $category) {
            if ($category->slug == $listSet['fourth']) {
                echo '<option value="' . $category->slug . '" selected>' . $category->name . '</option>';
            } else {
                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
            }
        }
        echo '</select></div>';

        echo '<button type="submit" class="btn btn-primary">Save</button></form>';
        echo '</div>';

        echo "<script>
        document.addEventListener('DOMContentLoaded', () => {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const status = urlParams.get('status')

            if(status != null) {
                let alert = document.getElementById('alert-post');
                if(status == 'saved') {
                    alert.classList.add('alert-success');
                    alert.innerHTML = 'Change is saved';
                } else {
                    alert.classList.add('alert-danger');
                    alert.innerHTML = 'Change is not saved';
                }

                alert.style.display = 'block';
            }
        });
        </script>";
    }

    public function getListGame()
    {
        $argsGame = array(
            'post_type' => 'game',
            'orderby'    => 'post_date',
            'post_status' => 'publish',
            'order'    => 'DESC',
            'posts_per_page' => -1
        );

        $resultGame = new WP_Query($argsGame);

        return $resultGame;
    }

    public function getConfigForTopGame()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_binhchay");

        return $result;
    }

    public function getUrlTrending()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_trending_search");

        return $result;
    }

    public function getListCategoryGame()
    {
        $terms = get_terms(array(
            'taxonomy'   => 'game_category',
            'hide_empty' => true,
        ));

        return $terms;
    }

    public function getListSetCategory()
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM wp_set_category");

        return $result;
    }
}
