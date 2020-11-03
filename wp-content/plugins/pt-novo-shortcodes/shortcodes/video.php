<?php

// Element Description: PT Video

class PT_Video extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'pt_video_mapping' ) );
        add_shortcode( 'pt_video', array( $this, 'pt_video_html' ) );
    }
     
    // Element Mapping
    public function pt_video_mapping() {
         
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
         
        // Map the block with vc_map()
        vc_map( array(
            "name" => esc_html__("Video", "novo"),
            "base" => "pt_video",
            "show_settings_on_create" => true,
            "icon" => "shortcode-icon-video",
            "category" => esc_html__("Novo Shortcodes", "novo"),
            "params" => array(
                array(
                    "type"        => "textfield",
                    "heading"     => esc_html__( "Video url", "novo" ),
                    "param_name"  => "video_url",
                    "description" => esc_html__('YouTube or Vimeo link', 'novo')
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Video Cover Image", "novo"),
                    "param_name" => "video_cover_image",
                ),
                array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Content color", "novo" ),
                    "param_name"  => "content_color",
                    "value"      => array(
                        esc_html__( "White", "novo" ) => "white",
                        esc_html__( "Black", "novo" ) => "black",
                        esc_html__( "Custom", "novo" ) => "custom",
                    ),
                ),
                array(
                    "type" => "colorpicker",
                    "heading" => esc_html__("Color", "novo"),
                    "param_name" => "content_color_hex",
                    "dependency" => Array("element" => "content_color", "value" => "custom" ),
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => esc_html__( "Height", "novo" ),
                    "param_name"  => "height",
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => esc_html__( "Heading", "novo" ),
                    "param_name"  => "heading",
                ),
                array(
                    "type"        => "textfield",
                    "heading"     => esc_html__( "Text", "novo" ),
                    "param_name"  => "text",
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
    public function pt_video_html( $atts, $content = null ) {
         
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'uniqid' => uniqid(),
                    'video_url' => '',
                    'video_cover_image' => '',
                    'content_color' => 'white',
                    'content_color_hex' => '',
                    'animation' => '',
                    'text' => '',
                    'heading' => '',
                    'height' => '',
                ), 
                $atts
            )
        );

        $class = $id = uniqid('video-block-');

        $custom_css = $style_attr = '';

        if(!empty($video_cover_image)) {
            $style_attr = 'background-image: url('.esc_url(wp_get_attachment_image_src($video_cover_image, 'full')[0]).');';
        }

        if(!empty($height)) {
            $style_attr .= 'height: '.$height.'px;';
            $class .= ' fix-height';
        }

        if(isset($content_color) && $content_color != 'custom') {
            $class .= ' '.$content_color;
        }

        if(isset($content_color) && $content_color == 'custom') {
            $custom_css .= '.'.$id.' {
                color: '.$content_color_hex.';
            }';
        }

        wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
        wp_add_inline_style( 'novo-custom-style', $custom_css );

        if(!empty($text) || !empty($heading)) {
            $class .= ' with-content';
        }

        $html = '';
        $animation = $this->getCSSAnimation($animation);
        if($video_url) {
            $video_url = VideoUrlParser::get_url_embed($video_url);
            $html .= '<div class="video-block '.esc_attr($class).' popup-gallery '.esc_attr($animation).'">';
                $html .= '<div class="popup-item" style="'.esc_attr($style_attr).'">';
                    $html .= '<div class="area">';
                        if(!empty($text) || !empty($heading)) {
                            $html .= '<div class="content">';
                                if(!empty($heading)) {
                                    $html .= '<h2 class="h">'.wp_kses_post($heading).'</h2>';
                                }
                                if(!empty($text)) {
                                    $html .= '<div class="text">'.wp_kses_post($text).'</div>';
                                }
                            $html .= '</div>';
                        }
                        $html .= '<a href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="1920" height="1080" src="'.esc_url($video_url).'" frameborder="0" allowfullscreen></iframe></div></div>\'><div><i class="music-and-multimedia-play-button"></i></div></a>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
         
    }

    
     
} // End Element Class
 
 
// Element Class Init
new PT_Video();