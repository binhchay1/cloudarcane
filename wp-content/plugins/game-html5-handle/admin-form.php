<?php
class Game_Html5
{
    const ID = 'game_html5_handler';

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

        wp_enqueue_style('apkafe-admin-form-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', BINHCHAY_ADMIN_VERSION);
        wp_enqueue_script(
            'apkafe-admin-form-bs',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            BINHCHAY_ADMIN_VERSION,
            true
        );

        wp_enqueue_script(
            'apkafe-admin-form-bs',
            'https://code.jquery.com/jquery-3.7.1.slim.js'
        );

        echo '<style>
        .list-group{
            max-height: 300px;
            margin-bottom: 10px;
            overflow-x: hidden;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
        }
        </style>';
    }

    public function add_menu_page()
    {
        add_menu_page(
            esc_html__('Game html5', 'game-html5'),
            esc_html__('Game html5', 'game-html5'),
            'manage_options',
            $this->get_id(),
            array(&$this, 'load_view_post'),
            'dashicons-games'
        );
    }

    public function load_view_post()
    {
        $listGame = $this->getListGamesWithinThumb();
        echo '<div class="container mt-5">';
        echo '<a href="' . plugin_dir_url(__DIR__) . 'game-html5-handle/process-update.php' . '" class="btn btn-primary">Update List Game</a>';
        echo '<ul class="list-group list-group-flush mt-5">';

        foreach ($listGame as $game) {
            echo '<li class="list-group-item">' . $game->name . '</li>';
        }

        echo '</ul>';
        echo '</div>';
    }

    public function getListGamesWithinThumb()
    {
        global $wpdb;

        $sql = "SELECT * FROM wp_games WHERE thumb IS NOT NULL";
        $games = $wpdb->get_results($sql);

        return $games;
    }
}
