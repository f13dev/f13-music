<?php namespace F13\LastFM\Controllers;

class Lyrics
{
    public function lyrics($artist, $song, $cache)
    {
        if (empty($artist) || empty($song)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align: center;">'.__('Please enter an artist and song argument in the shortcode', 'f13-lastfm').'</div>';
        }

        $m = new \F13\LastFM\Models\Lyrics();
        $data = $m->get_lyrics($artist, $song);

        if (array_key_exists('error', $data)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align: center;">'.$data['error'].'</div>';
        }

        $v = new \F13\LastFM\Views\Lyrics(array(
            'data' => $data,
            'artist' => $artist,
            'song' => $song,
        ));

        return $v->lyrics();
    }
}