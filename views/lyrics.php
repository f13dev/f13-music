<?php namespace F13\LastFM\Views;

class Lyrics
{
    public function __construct( $params = array() )
    {
        foreach ($params as $variable => $value) {
            $this->{$variable} = $value;
        }
    }

    public function lyrics()
    {
        $v = '<div style="border: 1px solid #222; border-radius: 10px; padding: 10px; margin: 10px 0; max-height: 500px; overflow-y:auto;">';
            $v .= '<span style="font-size: 1.5em; font-weight: bold; text-align: center; display: block;">'.htmlentities(ucfirst($this->song)).' by '.htmlentities(ucfirst($this->artist)).'</span>';
            $v .= nl2br($this->data['lyrics']);
        $v .= '</div>';

        return $v;
    }
}