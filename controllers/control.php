<?php namespace F13\LastFM\Controllers;

class Control
{
    private $cache_timeout;

    public function __construct()
    {
        add_shortcode('album', array($this, 'album'));
        add_shortcode('my_chart', array($this, 'my_chart'));
        add_shortcode('lyrics', array($this, 'lyrics'));

        $this->cache_timeout = get_option('cache_timeout','f13-lastfm-group' );
    }

    public function _check_cache( $timeout )
    {
        if ( empty($timeout) ) {
            $timeout = (int) $this->cache_timeout;
        }
        if ( (int) $timeout < 1 ) {
            $timeout = 1;
        }

        $timeout = $timeout * 60;

        return $timeout;
    }

    public function album($atts)
    {
        extract(shortcode_atts(array('artist' => '', 'album' => '', 'cache' => ''), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new Album( );
        return $c->album( $artist, $album, $cache );
    }

    public function lyrics($atts)
    {
        extract(shortcode_atts(array('artist' => '', 'song' => '', 'cache' => ''), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new Lyrics( );
        return $c->lyrics( $artist, $song, $cache );
    }

    public function my_chart($atts)
    {
        extract(shortcode_atts(array('limit' => '10', 'cache' => ''), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new My_chart( );
        return $c->my_chart( $limit, $cache );
    }
}