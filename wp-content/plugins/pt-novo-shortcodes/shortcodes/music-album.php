<?php

// Element Description: PT Music Album

class PT_Music_Album extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'pt_music_album_mapping' ) );
        add_shortcode( 'pt_music_album', array( $this, 'pt_music_album_html' ) );
    }

    public static function get_all_music_album( $param = 'All' ) {
        $result    = array();
        
        $args = array(
            'post_type'       => 'pt-music-album',
            'post_status'     => 'publish',
            'posts_per_page'    => '-1'
        );

        $music_album_array = new WP_Query( $args );
        $result[0] = "";

        if ( ! empty( $music_album_array->posts ) ) {
            foreach ( $music_album_array->posts as $item ) {
                $result[ 'ID ['.$item->ID.'] '. $item->post_title ] = $item->ID;
            }
        }

        return $result;
    }
     
    // Element Mapping
    public function pt_music_album_mapping() {
         
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
         
        // Map the block with vc_map()
        vc_map( array(
            "name" => esc_html__("Music Album item", "novo"),
            "base" => "pt_music_album",
            "show_settings_on_create" => true,
            "icon" => "shortcode-icon-music-album",
            "category" => esc_html__("Novo Shortcodes", "novo"),
            "params" => array(
                array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Item", "novo" ),
                    "param_name"  => "item",
                    "value"       => PT_Music_Album::get_all_music_album(),
                ),
                array(
                    "type" => "animation_style",
                    "heading" => esc_html__( "Animation In", "novo" ),
                    "param_name" => "animation",
                ),
            ),
        ) );
    }
     
     
    // Element HTML
    public function pt_music_album_html( $atts, $content = null ) {
         
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'item' => '0',
                    'animation' => '',
                ), 
                $atts
            )
        );

        $item_class = $this->getCSSAnimation($animation);

        $html = do_shortcode('[pt_music_album_shortcode id="'.$item.'" css="'.$item_class.'"]');

        return $html;
         
    }
     
} // End Element Class
 
 
// Element Class Init
new PT_Music_Album();