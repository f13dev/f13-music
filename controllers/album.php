<?php namespace F13\LastFM\Controllers;

class Album
{
    public $data;
    public $art;

    public function album($artist, $album, $cache)
    {
        if (empty($artist) || empty($album)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align:center;">'.__('Please enter an artist and album argument in the shortcode', 'f13-lastfm').'</div>';
        }

        $cache_key = 'f13_music_'.sha1(F13_LASTFM['Version'].'-'.$artist.'-'.$album.'-'.$cache);
        $transient = get_transient( $cache_key );
        if ( $transient ) {
            echo '<script>console.log("Building album from transient: '.$cache_key.'");</script>';
            return $transient;
        }

        $m = new \F13\LastFM\Models\LastFM_api();
        $this->data = $m->get_album($artist, $album);

        if (array_key_exists('error', $this->data)) {
            return '<div style="padding: 10px; margin: 10px 0px; background: #ffcccc; border: 1px solid #222; text-align:center;">'.$this->data['message'].'</div>';
        }

        $this->get_album_art();

        $v = new \F13\LastFM\Views\Album(array(
            'data' => $this->data,
            'art' => $this->art,
        ));

        $return = $v->album();

        set_transient($cache_key, $return, $cache);
        echo '<script>console.log("Building album from API, setting transient: '.$cache_key.'");</script>';

        return $return;
    }

    public function get_album_art()
    {
        foreach ($this->data['album']['image'] as $image) {
            if ($image['size'] == 'mega') {
                $this->art = $image['#text'];
            }
        }
        if (!empty($this->art)) {
            $file_name = explode('/', $this->art);
            $file_name = end($file_name);
            $image_id = $this->get_attachment_id($file_name);
            if (empty($image_id)) {
                require_once(ABSPATH.'wp-admin/includes/media.php');
                require_once(ABSPATH.'wp-admin/includes/file.php');
                require_once(ABSPATH.'wp-admin/includes/image.php');

                media_sideload_image($this->art, get_the_ID(), $this->data['album']['artist'].' - '.$this->data['album']['name']);
                $image_id = $this->get_attachment_id($file_name);
            }
            if (!empty($image_id)) {
                $this->art = wp_get_attachment_url($image_id);
            }
        }
    }

    public function get_attachment_id($file_name) {
        global $wpdb;
        // Search the database for an attachment ending with the filename
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$wpdb->base_prefix}postmeta WHERE meta_key='_wp_attached_file' AND meta_value LIKE %s;", '%' . $file_name ));
        // Returns the post ID or null
        if (!empty($attachment) && ($attachment[0] == null || $attachment[0] == ''))
        {
            // If the post ID is not valid return null
            return null;
        }
        else
        {
            // Otherwise return the valid post ID
            return $attachment[0];
        }
    }
}