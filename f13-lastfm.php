<?php
/*
Plugin Name: F13 Music
Plugin URI: https://f13.dev/wordpress-plugins/wordpress-plugin-music/
Description: Last FM profile widget, and album shortcode
Version: 0.0.1
Author: Jim Valentine
Author URI: https://www.f13.dev
Text Domain: f13
*/

namespace F13\LastFM;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($wpdb)) global $wpdb;
if (!function_exists('get_plugins')) require_once(ABSPATH.'wp-admin/includes/plugin.php');
if (!defined('F13_LASTFM')) define('F13_LASTFM', get_plugin_data(__FILE__, false, false)['Version']);
if (!defined('F13_LASTFM_PATH')) define('F13_LASTFM_PATH', plugin_dir_path( __FILE__ ));
if (!defined('F13_LASTFM_URL')) define('F13_LASTFM_URL', plugin_dir_url(__FILE__));

class Plugin
{
    public function init()
    {
        spl_autoload_register(__NAMESPACE__.'\Plugin::autoload');

        add_action('wp_enqueue_scripts', array($this, 'style_and_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_style_and_scripts'));



        if (is_admin()) {
            $a = new Controllers\Admin();
        }

        if (defined('DOING_AJAX') && DOING_AJAX) {
            $ajax = new Controllers\Ajax();
        }

        $c = new Controllers\Control();
    }

    public static function autoload($class)
    {
        $class = ltrim($class, '\\');
        if (strpos($class, __NAMESPACE__) !== 0) return;
        $class = ltrim(str_replace(__NAMESPACE__, '', $class), '\\');
        $path = F13_LASTFM_PATH.strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php');
        require_once $path;
    }

    public function style_and_scripts()
    {
        $styles_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/styles.css' ));
        wp_enqueue_style('f13_lastfm_styles', F13_LASTFM_URL.'css/styles.css', array(), $styles_ver);
        $scripts_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/scripts.js' ));
        wp_enqueue_script('f13_lastfm_scripts', F13_LASTFM_URL.'js/scripts.js', array('jquery'), $scripts_ver);
    }

    public function admin_style_and_scripts()
    {

    }
}

$p = new Plugin();
$p->init();