<?php namespace F13\LastFM\Controllers;

class Admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_init', array($this, 'register_settings') );
    }

    public function admin_menu()
    {
        global $menu;
        $exists = false;
        foreach($menu as $item) {
            if(strtolower($item[0]) == strtolower('F13 Admin')) {
                $exists = true;
            }
        }
        if(!$exists) {
            add_menu_page( 'F13 Settings', 'F13 Admin', 'manage_options', 'f13-settings', array($this, 'f13_settings'), 'dashicons-embed-generic', 4);
            add_submenu_page( 'f13-settings', 'Plugins', 'Plugins', 'manage_options', 'f13-settings', array($this, 'f13_settings'));
        }
        add_submenu_page( 'f13-settings', 'F13 LastFM Settings', 'Last.FM', 'manage_options', 'f13-settings-lastfm', array($this, 'f13_lastfm_settings'));
    }

    public function f13_settings()
    {
        $v = new \F13\LastFM\Views\Admin();

        echo $v->f13_settings();
    }

    public function f13_lastfm_settings()
    {
        $v = new \F13\LastFM\Views\Admin();

        echo $v->lastfm_settings();
    }

    public function register_settings()
    {
        register_setting( 'f13-lastfm-group', 'f13_lastfm_api_key');
        register_setting( 'f13-lastfm-group', 'f13_lastfm_cache_timeout');
    }
}