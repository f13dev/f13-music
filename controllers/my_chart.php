<?php namespace F13\LastFM\Controllers;

class My_chart
{
    public $request_method;

    public function __construct()
    {
        $this->request_method = ($_SERVER['REQUEST_METHOD'] === 'POST') ? INPUT_POST : INPUT_GET;
    }

    public function my_chart( $limit = '10', $cache = '0' )
    {
        $period = filter_input($this->request_method, 'period');

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
        ));

        return $v->my_chart();

    }
}