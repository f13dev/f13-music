<?php namespace F13\LastFM\Views;

class My_chart
{
    public function __construct( $atts )
    {
        foreach ($atts as $k => $v) {
            $this->{$k} = $v;
        }
    }

    public function _container($input)
    {
        $v = '<div id="f13-charts-container">';
            $v .= $input;
        $v .= '</div>';

        return $v;
    }

    public function my_chart()
    {
        $v = '<div style="border: 1px solid #222; border-radius: 10px;">';
            $v .= '<table style="width: 100%; margin: 5px 0px;">';
                $v .= '<thead>';
                    $v .= '<tr>';
                        $v .= '<th colspan="2" style="text-align: center; font-size: 1.5em; font-weight: bold;">';
                            $v .= '<form method="post" class="f13-lastfm-auto-submit f13-lastfm-ajax" data-action="f13-charts" data-target="f13-charts-container" data-href="'.admin_url('admin-ajax.php').'">';
                                $v .= 'F13Dev\'s charts ';
                                $v .= '<input type="hidden" name="action" value="f13-charts">';
                                $v .= '<input type="hidden" name="target" value="f13-charts-container">';
                                $v .= '<select name="period">';
                                    $v .= '<option value="7day"'.(($this->period == '7day') ? ' selected="selected"' : '').'>7 days</option>';
                                    $v .= '<option value="1month"'.(($this->period == '1month') ? ' selected="selected"' : '').'>1 month</option>';
                                    $v .= '<option value="3month"'.(($this->period == '3month') ? ' selected="selected"' : '').'>3 months</option>';
                                    $v .= '<option value="6month"'.(($this->period == '6month') ? ' selected="selected"' : '').'>6 months</option>';
                                    $v .= '<option value="12month"'.(($this->period == '12month') ? ' selected="selected"' : '').'>1 year</option>';
                                    $v .= '<option value="overall"'.(($this->period == 'overall') ? ' selected="selected"' : '').'>Overall</option>';
                                $v .= '</select>';
                            $v .= '</form>';
                        $v .= '</th>';
                    $v .= '</tr>';
                    $v .= '<tr>';
                        $v .= '<th style="padding-left: 10px;">Rank</th>';
                        $v .= '<th style="padding-right: 10px;">Track</th>';
                    $v .= '</tr>';
                $v .= '</thead>';
                $v .= '<tbody>';
                    $odd = true;
                    foreach ($this->data['toptracks']['track'] as $track) {
                        $v .= '<tr '.(($odd) ? 'style="background-color: #eee;"' : '').'>';
                            $v .= '<td style="padding-left: 10px;">'.$track['@attr']['rank'].'</td>';
                            $v .= '<td style="padding-right: 10px;">'.$track['name'].' by '.$track['artist']['name'].'<br>Play count: '.$track['playcount'].'</td>';
                        $v .= '</tr>';
                        $odd = !$odd;
                    }
                $v .= '</tbody>';
            $v .= '</table>';
        $v .= '</div>';

        return ($this->container ? $this->_container($v) : $v);
    }
}