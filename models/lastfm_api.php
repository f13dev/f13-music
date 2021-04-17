<?php namespace F13\LastFM\Models;

class LastFM_api
{
    private $key;

    public function __construct()
    {
        $this->key = get_option('f13_lastfm_api_key', 'f13-lastfm-group');
    }

    public function _get_data( $url )
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = json_decode(curl_exec($curl), true);

        curl_close($curl);

        return $result;
    }

    function get_album($anArtist, $anAlbum)
    {
        $anArtist = urlencode($anArtist);
        $anAlbum = urlencode($anAlbum);

        $url = 'http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=' . $this->key . '&artist=' . $anArtist . '&album=' . $anAlbum . '&format=json';

        return $this->_get_data( $url );
    }

    public function get_my_chart($limit, $period)
    {
        $url = 'http://ws.audioscrobbler.com/2.0/?method=user.gettoptracks&user=thevdm&api_key=' . $this->key . '&limit=' . $limit . '&period=' . $period . '&format=json';

        return $this->_get_data( $url );
    }
}