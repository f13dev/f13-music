<?php namespace F13\LastFM\Controllers;

class Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_f13-charts', array($this, 'f13_charts'));
        add_action('wp_ajax_nopriv_f13-charts', array($this, 'f13_charts'));
    }

    public function f13_charts() { $c = new My_chart(); echo $c->my_chart(); die; }
}