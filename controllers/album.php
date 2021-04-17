<?php namespace F13\LastFM\Controllers;

class Album
{
    public function album($artist, $album, $cache)
    {
        if (empty($artist) || empty($album)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align:center;">'.__('Please enter an artist and album argument in the shortcode', 'f13-lastfm').'</div>';
        }

        $m = new \F13\LastFM\Models\LastFM_api();
        $data = $m->get_album($artist, $album);

        if (array_key_exists('error', $data)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align:center;">'.$data['message'].'</div>';
        }

        $v = new \F13\LastFM\Views\Album(array(
            'data' => $data,
        ));

        return $v->album();
    }
}