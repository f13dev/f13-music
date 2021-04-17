<?php namespace F13\LastFM\Views;

class Admin
{

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function f13_settings()
    {
        $v = '<div class="wrap">';
            $v .= '<h1>'.$this->label_plugins_by_f13.'</h1>';
            $v .= '<div id="f13-plugins">'.file_get_contents('https://f13dev.com/f13-plugins/').'</div>';
            //$v .= '<div id="f13-plugins">'.file_get_contents('https://f13.dev/wp-admin/admin-ajax.php?action=f13_plugins').'</div>';
            $v .= '<a href="'.admin_url('plugin-install.php').'?s=f13dev&tab=search&type=author">'.$this->label_all_wordpress_plugins.'</a>';
        $v .= '</div>';

        return $v;
    }

    public function lastfm_settings()
    {
        $v = '<div class="wrap">';
            $v .= '<h1>F13 Last.FM Settings</h1>';

        $v .= '<form method="post" action="options.php">';
            $v .= '<input type="hidden" name="option_page" value="'.esc_attr('f13-lastfm-group').'" />';
            $v .= '<input type="hidden" name="action" value="update">';
            $v .= '<input type="hidden" id="_wpnonce" name="_wpnonce" value="'.wp_create_nonce('f13-lastfm-group-options').'">';
            do_settings_sections( 'f13-lastfm-group' );

            $v .= '<table class="form-table">';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">API Key:</th>';
                    $v .= '<td>';
                        $v .= '<input type="text" name="f13_lastfm_api_key" value="'.esc_attr( get_option( 'f13_lastfm_api_key' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">Cache timeout:</th>';
                    $v .= '<td>';
                        $v .= '<input type="number" name="f13_lastfm_cache_timeout" value="'.esc_attr( get_option( 'f13_lastfm_cache_timeout' ) ).'" style="width: 75px;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
            $v .= '</table>';
            $v .= '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
        $v .= '</form>';


        return $v;
    }

    public function widget_settings()
    {

    }
}