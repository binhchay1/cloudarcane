<?php

class Admin_form_get_game
{
    const ID = 'crawls-game';

    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_page'), 1);
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('wp_ajax_get_game', array($this, 'get_game'));
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

        wp_enqueue_style('crawls-game-admin-form-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', CRAWLS_ADMIN_VERSION);
        wp_enqueue_script(
            'crawls-game-admin-form-bs',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            CRAWLS_ADMIN_VERSION,
            true
        );

        wp_enqueue_script(
            'crawls-game-admin-form-bs',
            'https://code.jquery.com/jquery-3.7.1.slim.js'
        );

        echo '<style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 25px;
            height: 25px;
            margin-left: 15px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
    
            100% {
                -webkit-transform: rotate(360deg);
            }
        }
    
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
    
            100% {
                transform: rotate(360deg);
            }
        }
        </style>';
    }

    public function add_menu_page()
    {
        add_menu_page(
            esc_html__('Crawls game', 'crawls-game'),
            esc_html__('Crawls game', 'crawls-game'),
            'manage_options',
            $this->get_id(),
            array(&$this, 'load_view_post'),
            'dashicons-games'
        );
    }

    public function load_view_post()
    {
        $nonce = wp_create_nonce("get_game_nonce");
        $link = admin_url('admin-ajax.php');
        $domain = $_SERVER['SERVER_NAME'];
        if (strpos($domain, 'coloringgames')) {
            $domain = 'coloringgames';
        }

        $domain = 'coloringgames';

        echo '<div class="container mt-5">';
        echo "<div class='alert' role='alert' id='alert-post'></div>";
        echo '<div class="d-flex"><button type="button" class="btn btn-primary" id="crawls-game">Crawls game</button>';
        echo '<div style="display: none;" id="pre-loader"><div class="loader"></div></div>';
        echo "<div style='display: none;' id='pre-loader-text'><p style='margin-left: 15px'>Crawls game is processing. Please don't refresh this page.</p></div>";
        echo '</div></div>';

        echo '<script type="text/javascript">
        jQuery(document).ready( function() {
            jQuery("#crawls-game").on("click", function(e) {
                jQuery("#pre-loader").attr("style", "display: block !important");
                jQuery("#pre-loader-text").attr("style", "display: block !important");
                e.preventDefault();
        
                jQuery.post("' . $link . '", 
                    {
                        "action": "get_game",
                        "domain": "' . $domain . '",
                        "nonce": "' . $nonce . '"
                    }, 
                    function(response) {
                        jQuery("#pre-loader").attr("style", "display: none !important");
                        jQuery("#pre-loader-text").attr("style", "display: none !important");
                    }
                );
            })
         })</script>';
    }

    public function get_game()
    {
        if (!wp_verify_nonce($_REQUEST['nonce'], "get_game_nonce")) {
            exit("Please don't fucking hack this API");
        }

        $domain = $_REQUEST['domain'];
        $start = microtime(true);

        if ($domain == 'coloringgames') {

            $page = 1;
            $break = false;
            $dataGame = array();

            while (!$break) {
                $linkCrawls = 'https://www.gamepix.com/t/coloring-games/' . $page;
                $html = file_get_html($linkCrawls);
                $arrayGridGame = $html->find('.games-grid-item');
                if (empty($arrayGridGame)) {
                    $break = true;
                }

                foreach ($arrayGridGame as $gridGame) {
                    $linkGame = $gridGame->find('a');
                    $titleGame = $gridGame->find('.game-title');
                    $imgGame = $gridGame->find('img');

                    foreach ($titleGame as $title) {
                        $titlestrtok = strtok($title->plaintext . '|', '|');
                        $dataGame[$titlestrtok]['title'] = $titlestrtok;
                    }

                    foreach ($imgGame as $img) {
                        $imgstrok = strtok($img->src . '|', '|');
                        if (strlen($imgstrok) >= 200 || empty($imgstrok)) {
                            continue;
                        }
                        $dataGame[$titlestrtok]['img'] = $imgstrok;
                    }

                    foreach ($linkGame as $link) {
                        $linkstrtok = strtok($link->href . '|', '|');
                        if (strpos($linkstrtok, 'play/') > 0) {
                            $dataGame[$titlestrtok]['link_play'] = $linkstrtok;
                        }
                    }
                }

                $page++;
            }

            $dataFinal = array();
            foreach ($dataGame as $game) {
                $link_play = $game['link_play'];
                $explode = explode('/', $link_play);
                $linkCheck = 'https://api.h5.gamepix.com/v3/game/' . $explode[2];
                $headers = get_headers($linkCheck);
                $subCode = substr($headers[0], 9, 3);
                if ($subCode != '200') {
                    continue;
                }
                $getDescription = file_get_html('https://www.gamepix.com' . $link_play);
                if (!$getDescription) {
                    continue;
                }
                $arrayP = $getDescription->find('.text-description p');
                $descriptionstrtok = strtok($arrayP[0]->plaintext . '|', '|');
                $linkPlay = 'https://play.gamepix.com/' . $explode[2] . '/embed';
                $response = json_decode(file_get_contents($linkCheck));
                if ($response->code == 200) {
                    $dataFinal[] = [
                        'title' => $game['title'],
                        'link_play' => $linkPlay,
                        'img' => $game['img'],
                        'content' => $descriptionstrtok
                    ];
                }
            }
        }

        foreach ($dataFinal as $final) {
            $my_post = array(
                'post_title'    => wp_strip_all_tags($final['title']),
                'post_content'  => $final['content'],
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_category' => 'Color games',
                'post_parent' => 0,
                'menu_order' => 0,
                'post_type' => 'game',
                'guid' => 'https://' . $domain . '/game/' . $this->slugify($final['title'])
            );

            wp_insert_post($my_post);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result);
            echo $result;
        } else {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
