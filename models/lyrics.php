<?php namespace F13\LastFM\Models;

class Lyrics
{
    public function get_lyrics($artist, $song)
    {
        $curl = curl_init();
        $artist = str_replace(' ', '+', $artist);
        $song = str_replace(' ', '+', $song);

        $url = 'https://api.lyrics.ovh/v1/'.$artist.'/'.$song;

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);

        curl_setopt($curl, CURLOPT_USERAGENT, 'F13 WP Last.fm Album Shortcode/1.0');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $results = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $results;
    }
}