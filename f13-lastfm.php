<?php
/*
Plugin Name: F13 Music
Plugin URI: https://f13.dev/wordpress-plugins/wordpress-plugin-music/
Description: Last FM profile widget, and album shortcode
Version: 0.0.1
Author: Jim Valentine
Author URI: https://f13.dev
Text Domain: f13-lastfm
*/

namespace F13\LastFM;

if (!isset($wpdb)) global $wpdb;
if (!function_exists('get_plugins')) require_once(ABSPATH.'wp-admin/includes/plugin.php');
if (!defined('F13_LASTFM')) define('F13_LASTFM', get_plugin_data(__FILE__, false, false)['Version']);
if (!defined('F13_LASTFM_PATH')) define('F13_LASTFM_PATH', plugin_dir_path( __FILE__ ));
if (!defined('F13_LASTFM_URL')) define('F13_LASTFM_URL', plugin_dir_url(__FILE__));

class Plugin
{
    public function init()
    {
        spl_autoload_register(__NAMESPACE__.'\Plugin::loader');

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

    public static function loader($name)
    {
        $name = trim(ltrim($name, '\\'));
        if (strpos($name, __NAMESPACE__) !== 0) {
            return;
        }
        $file = str_replace(__NAMESPACE__, '', $name);
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        $file = plugin_dir_path(__FILE__).strtolower($file).'.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            die('Class not found: '.$name);
        }
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