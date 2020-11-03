<?php

// Element Description: PT Podcast

class PT_Podcast extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'pt_podcast_mapping' ) );
        add_shortcode( 'pt_podcast', array( $this, 'pt_podcast_html' ) );
    }
     
    // Element Mapping
    public function pt_podcast_mapping() {
         
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
         
        // Map the block with vc_map()
        vc_map( array(
            "name" => esc_html__("Podcast item", "sansara"),
            "base" => "pt_podcast",
            "show_settings_on_create" => true,
            "icon" => "shortcode-icon-podcast",
            "category" => esc_html__("Novo Shortcodes", "sansara"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Track url", "sansara"),
                    "param_name" => "track_url",
                    "description" => esc_html__('Example: http://example.com/podcast/red.mp3', 'sansara')
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Cover image", "sansara"),
                    "param_name" => "cover_image_url",
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Sub Heading", "sansara"),
                    "param_name" => "sub_heading",
                    "admin_label" => true,
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Heading", "sansara"),
                    "param_name" => "heading",
                    "admin_label" => true,
                ),
                array(
                    "type" => "animation_style",
                    "heading" => esc_html__( "Animation In", "sansara" ),
                    "param_name" => "animation",
                ),
            ),
        ) );
    }
     
     
    // Element HTML
    public function pt_podcast_html( $atts, $content = null ) {
         
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'cover_image_url' => '',
                    'sub_heading' => '',
                    'heading' => '',
                    'track_url' => '',
                    'animation' => '',
                    'css' => ''
                ), 
                $atts
            )
        );

        if(!empty($animation)) {
            $css = $this->getCSSAnimation($animation);
        }

        $html = do_shortcode('[pt_podcast_shortcode cover_image_url="'.$cover_image_url.'" sub_heading="'.$sub_heading.'" heading="'.$heading.'" track_url="'.$track_url.'" css="'.$css.'"]');

        return $html;
         
    }
     
} // End Element Class
 
 
// Element Class Init
new PT_Podcast();