<?php namespace F13\LastFM\Controllers;

class My_chart
{
    public $request_method;

    public function __construct()
    {
        $this->request_method = ($_SERVER['REQUEST_METHOD'] === 'POST') ? INPUT_POST : INPUT_GET;
    }

    public function my_chart( $limit = '10', $cache = '1' )
    {
        $period = filter_input($this->request_method, 'period');
        $submit = (int) filter_input($this->request_method, 'submit');
        if ($submit) {
            $limit = (int) filter_input($this->request_method, 'limit');
            $cache = (int) filter_input($this->request_method, 'cache');
        }

        $cache_key = 'f13_music_chart_'.md5($limit.'-'.$period.'-'.$cache);
        $transient = get_transient( $cache_key );
        if ( $transient ) {
            echo '<script>console.log("Building chart from transient: '.$cache_key.'");</script>';
            return $transient;
        }

        if (empty($period)) {
            $period = '7day';
        }

        $m = new \F13\LastFM\Models\LastFM_api();
        $data = $m->get_my_chart( $limit, $period );

        $container = true;

        if (defined('DOING_AJAX') && DOING_AJAX) {
            $container = false;
        }

        $v = new \F13\LastFM\Views\My_chart(array(
            'data' => $data,
            'period' => $period,
            'container' => $container,
            'limit' => $limit,
            'cache' => $cache,
        ));

        $return = $v->my_chart();

        set_transient($cache_key, $return, $cache);
        echo '<script>console.log("Building chart from API, setting transient: '.$cache_key.'");</script>';

        return $return;
    }
}