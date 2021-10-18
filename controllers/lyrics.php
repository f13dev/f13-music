<?php namespace F13\LastFM\Controllers;

class Lyrics
{
    public function lyrics($artist, $song, $cache)
    {
        if (empty($artist) || empty($song)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align: center;">'.__('Please enter an artist and song argument in the shortcode', 'f13-lastfm').'</div>';
        }

        $cache_key = 'f13_music_'.sha1(F13_LASTFM['Version'].'-'.$artist.'-'.$song.'-'.$cache);
        $transient = get_transient( $cache_key );
        if ( $transient ) {
            echo '<script>console.log("Building lyrics from transient: '.$cache_key.'");</script>';
            return $transient;
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

        $return = $v->lyrics();

        set_transient($cache_key, $return, $cache);
        echo '<script>console.log("Building lyrics from API, setting transient: '.$cache_key.'");</script>';

        return $return;
    }
}