<?php namespace F13\LastFM\Views;

class Album
{
    public $label_album_summary;
    public $label_published;

    public function __construct( $args = array() )
    {
        foreach ($args as $variable => $value) {
            $this->{$variable} = $value;
        }

        $this->label_album_summary  = __('Album summary', 'f13-lastfm');
        $this->label_published      = __('Published', 'f13-lastfm');
    }

    public function album()
    {
        $v = '<div class="f13-lastfm-album-container">';
            $v .= '<div class="f13-lastfm-album-head">';
                $v .= $this->data['album']['artist'] . ' - ' . $this->data['album']['name'];
            $v .= '</div>';

            if (!empty($this->art)) {
                $v .= '<div class="f13-lastfm-album-art">';
                    $v .= '<img src="'.$this->art.'" />';
                $v .= '</div>';
            }

            if (!empty($this->data['album']['tracks']['track']))
            {
                $v .= '<div class="f13-lastfm-album-tracks">';
                    $currentTrack = 1;
                    foreach ($this->data['album']['tracks']['track'] as &$eachTrack)
                    {
                        $v .= '<span>' . $currentTrack . ') <a href="' . $eachTrack['url'] . '">' . $eachTrack['name'] . '</a> (' . gmdate("i:s", $eachTrack['duration']) . ')</span>';
                        $currentTrack++;
                    }
                $v .= '</div>';
            }

            if (!empty($this->data['album']['tags']['tag']))
            {
                $v .= '<div class="f13-lastfm-album-tags">';
                    $v .= '<span class="f13-lastfm-album-tags-label">Tags:</span>';
                    foreach ($this->data['album']['tags']['tag'] as &$eachTag)
                    {
                        if (!is_numeric($eachTag['name']))
                        {
                            $v .= '<a href="' . $eachTag['url'] . '"><span class="f13-lastfm-album-tags-tag">' . $eachTag['name'] . '</span></a>';
                        }
                    }
                $v .= '</div>';
            }

            if (array_key_exists('wiki', $this->data['album']) && array_key_exists('published', $this->data['album']['wiki']))
            {
                $publishDate = explode(',', $this->data['album']['wiki']['published']);
                $publishDate = $publishDate[0];
                $v .= '<div class="f13-lastfm-album-published"><span>'.$this->label_published.':</span> ' . $publishDate . '</div>';
            }

            if (array_key_exists('album', $this->data['album']) && array_key_exists('summary', $this->data['album']['wiki']))
            {
                $v .= '<div class="f13-lastfm-album-summary"><span>'.$this->label_album_summary.':</span> ' . $this->data['album']['wiki']['summary'] . '</div>';
            }
        $v .= '</div>';

        return $v;
    }

    public function f13_get_album_attachment_id($file_name) {
        global $wpdb;
        // Search the database for an attachment ending with the filename
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM {$wpdb->base_prefix}postmeta WHERE meta_key='_wp_attached_file' AND meta_value LIKE %s;", '%' . $file_name ));
        // Returns the post ID or null
        if ($attachment[0] == null || $attachment[0] == '')
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