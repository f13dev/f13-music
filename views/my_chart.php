<?php namespace F13\LastFM\Views;

class My_chart
{
    public $label_1_month;
    public $label_1_year;
    public $label_3_months;
    public $label_6_months;
    public $label_7_days;
    public $label_charts;
    public $label_overall;
    public $label_play_count;
    public $label_rank;
    public $label_track;

    public function __construct( $atts )
    {
        foreach ($atts as $k => $v) {
            $this->{$k} = $v;
        }

        $this->label_1_month    = __('1 month', 'f13-lastfm');
        $this->label_1_year     = __('1 year', 'f13-lastfm');
        $this->label_3_months   = __('3 months', 'f13-lastfm');
        $this->label_6_months   = __('6 months', 'f13-lastfm');
        $this->label_7_days     = __('7 days', 'f13-lastfm');
        $this->label_charts     = __('Charts', 'f13-lfastfm');
        $this->label_overall    = __('Overall', 'f13-lastfm');
        $this->label_play_count = __('Play count', 'f13-lastfm');
        $this->label_rank       = __('Rank', 'f13-lastfm');
        $this->label_track      = __('Track', 'f13-lastfm');
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
                                $v .= $this->data['toptracks']['@attr']['user'].'\'s '.$this->label_charts.' ';
                                $v .= '<input type="hidden" name="action" value="f13-charts">';
                                $v .= '<input type="hidden" name="target" value="f13-charts-container">';
                                $v .= '<select name="period">';
                                    $v .= '<option value="7day"'.(($this->period == '7day') ? ' selected="selected"' : '').'>'.$this->label_7_days.'</option>';
                                    $v .= '<option value="1month"'.(($this->period == '1month') ? ' selected="selected"' : '').'>'.$this->label_1_month.'</option>';
                                    $v .= '<option value="3month"'.(($this->period == '3month') ? ' selected="selected"' : '').'>'.$this->label_3_months.'</option>';
                                    $v .= '<option value="6month"'.(($this->period == '6month') ? ' selected="selected"' : '').'>'.$this->label_6_months.'</option>';
                                    $v .= '<option value="12month"'.(($this->period == '12month') ? ' selected="selected"' : '').'>'.$this->label_1_year.'</option>';
                                    $v .= '<option value="overall"'.(($this->period == 'overall') ? ' selected="selected"' : '').'>'.$this->label_overall.'</option>';
                                $v .= '</select>';
                            $v .= '</form>';
                        $v .= '</th>';
                    $v .= '</tr>';
                    $v .= '<tr>';
                        $v .= '<th style="padding-left: 10px;">'.$this->label_rank.'</th>';
                        $v .= '<th style="padding-right: 10px;">'.$this->label_track.'</th>';
                    $v .= '</tr>';
                $v .= '</thead>';
                $v .= '<tbody>';
                    $odd = true;
                    foreach ($this->data['toptracks']['track'] as $track) {
                        $v .= '<tr '.(($odd) ? 'style="background-color: #eee;"' : '').'>';
                            $v .= '<td style="padding-left: 10px;">'.$track['@attr']['rank'].'</td>';
                            $v .= '<td style="padding-right: 10px;">'.$track['name'].' by '.$track['artist']['name'].'<br>'.$this->label_play_count.': '.$track['playcount'].'</td>';
                        $v .= '</tr>';
                        $odd = !$odd;
                    }
                $v .= '</tbody>';
            $v .= '</table>';
        $v .= '</div>';

        return ($this->container ? $this->_container($v) : $v);
    }
}