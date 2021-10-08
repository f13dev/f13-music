<?php namespace F13\LastFM\Views;

class Lyrics
{
    public $label_by;

    public function __construct( $params = array() )
    {
        foreach ($params as $variable => $value) {
            $this->{$variable} = $value;
        }

        $this->label_by = __('by', 'f13-lastfm');
    }

    public function lyrics()
    {
        $v = '<div style="border: 1px solid #222; border-radius: 10px; padding: 10px; margin: 10px 0; max-height: 500px; overflow-y:auto;">';
            $v .= '<span style="font-size: 1.5em; font-weight: bold; text-align: center; display: block;">';
                $v .= htmlentities(ucfirst($this->song)).' '.$this->label_by.' '.htmlentities(ucfirst($this->artist));
            $v .= '</span>';
            $v .= nl2br($this->data['lyrics']);
        $v .= '</div>';

        return $v;
    }
}