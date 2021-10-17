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
        $v = '<div class="f13_music_lyrics">';
            $v .= '<span style="font-size: 1.5em; font-weight: bold; text-align: center; display: block;">';
                $v .= htmlentities(ucfirst($this->song)).' '.$this->label_by.' '.htmlentities(ucfirst($this->artist));
            $v .= '</span>';
            $v .= nl2br($this->data['lyrics']);
        $v .= '</div>';

        return $v;
    }
}