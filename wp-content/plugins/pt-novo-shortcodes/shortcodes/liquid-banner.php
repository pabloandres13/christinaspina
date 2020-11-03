<?php

// Element Name: PT Liquid Banner

class YPRM_Liquid_Banner {

  public static $g_array = array();

  public function __construct() {
    add_action('init', array($this, 'yprm_liquid_banner_mapping'));
    add_shortcode( 'yprm_liquid_banner', array( $this, 'yprm_liquid_banner_html' ) );
    add_shortcode( 'yprm_liquid_banner_item', array( $this, 'yprm_liquid_banner_item_html' ) );
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Effect Type", "pt-addons"),
          "param_name" => "effect_type",
          "value" => array(
            esc_html__("Default", "pt-addons") => "default",
            esc_html__("Style 1", "pt-addons") => "style1",
            esc_html__("Style 2", "pt-addons") => "style2",
          ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Text align", "novo"),
          "param_name" => "text_align",
          "value" => array(
            esc_html__("Left", "novo") => "left",
            esc_html__("Center", "novo") => "center",
            esc_html__("Right", "novo") => "right",
          ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Text vertical align", "novo"),
          "param_name" => "text_vertical_align",
          "value" => array(
            esc_html__("Top", "novo") => "top",
            esc_html__("Middle", "novo") => "middle",
            esc_html__("Bottom", "novo") => "bottom",
          ),
          "std" => "bottom",
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Navigation Arrows", "pt-addons"),
          "param_name" => "nav_arrows",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay Slides", "novo"),
          "param_name" => "autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Enable Autoplay", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Autoplay Speed", "novo"),
          "param_name" => "autoplay_speed",
          "value" => "5000",
          "min" => "100",
          "max" => "10000",
          "step" => "10",
          "suffix" => "ms",
          "dependency" => Array("element" => "autoplay", "value" => array("on")),
        ),
      )
    );
  }

  public function yprm_vc_map_item_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Image", "pt-addons"),
          "param_name" => "image",
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Sub Heading", "pt-addons"),
          "param_name" => "sub_heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Text", "novo"),
          "param_name" => "text",
          "admin_label" => true,
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "pt-addons"),
          "param_name" => "link",
        ),
        array(
          "type" => "video",
          "heading" => esc_html__("Video In Popup", "pt-addons"),
          "param_name" => "video_url",
          "description" => esc_html__("Source YouTube, Vimeo and mp4 file", "pt-addons"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Color Scheme", "novo"),
          "param_name" => "color_scheme",
          "value" => array(
            esc_html__("Default", "pt-addons") => "default",
            esc_html__("Black", "novo") => "black",
            esc_html__("White", "novo") => "white",
          ),
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Heading size", "novo"),
          "param_name" => "heading_size",
          "value" => array(
            esc_html__("H1", "novo") => "h1",
            esc_html__("H2", "novo") => "h2",
            esc_html__("H3", "novo") => "h3",
            esc_html__("H4", "novo") => "h4",
            esc_html__("H5", "novo") => "h5",
            esc_html__("H6", "novo") => "h6",
          ),
          "std" => "h2",
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Sub Heading", "pt-addons"),
          "param_name" => "sub_heading_hex",
          "dependency" => Array("element" => "sub_heading", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading_hex",
          "dependency" => Array("element" => "heading", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Text", "pt-addons"),
          "param_name" => "text_hex",
          "dependency" => Array("element" => "text", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Link", "pt-addons"),
          "param_name" => "link_hex",
          "dependency" => Array("element" => "link", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Link on Hover", "pt-addons"),
          "param_name" => "link_hover_hex",
          "dependency" => Array("element" => "link", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Play Button", "pt-addons"),
          "param_name" => "play_button_hex",
          "dependency" => Array("element" => "video_url", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Play Button Background", "pt-addons"),
          "param_name" => "play_button_bg_hex",
          "dependency" => Array("element" => "video_url", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Play Button on Hover", "pt-addons"),
          "param_name" => "play_button_hover_hex",
          "dependency" => Array("element" => "video_url", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Play Button Background on Hover", "pt-addons"),
          "param_name" => "play_button_bg_hover_hex",
          "dependency" => Array("element" => "video_url", "not_empty" => true ),
          "group" => esc_html__("Color Customize", "novo"),
        ),
      )
    );
  }

  public function yprm_liquid_banner_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Liquid Slider", "pt-addons"),
      "as_parent" => array('only' => 'yprm_liquid_banner_item'),
      "base" => "yprm_liquid_banner",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-liquiq-banner",
      "js_view" => 'VcColumnView',
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));

    vc_map(array(
      "name" => esc_html__("Liquid Slider Item", "pt-addons"),
      "as_child" => array('only' => 'yprm_liquid_banner'),
      "base" => "yprm_liquid_banner_item",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-liquiq-banner",
      "params" => self::yprm_vc_map_item_array(),
    ));
  }

  public function yprm_liquid_banner_html($atts, $content = null) {

    extract(
      self::$g_array = shortcode_atts(
        array(
          'uniqid' => '',
          'effect_type' => 'default',
          'text_align' => 'left',
          'text_vertical_align' => 'bottom',
          'nav_arrows' => 'on',
          'autoplay' => 'on',
          'autoplay_speed' => '5000',
        ),
        $atts
      )
    );

    $block_class = array();

    $block_class[] = $block_id = 'liquiq-banner-'.$uniqid;

    wp_enqueue_script('pt-liquidSlider');
    wp_enqueue_style('swiper');
    wp_add_inline_script('novo-script', "document.addEventListener('DOMContentLoaded', function() { 
      new LiquidSlider(document.querySelector('.$block_id'), {
        autoplay: '$autoplay',
        autoplaySpeed: $autoplay_speed
      });
    });");

    $slides = array();
    yprm_the_shortcodes($slides, $content);

    if($effect_type == 'default') {
      $displacement_url = YPRM_PLUGINS_HTTP.'/assets/imgs/pattern.jpg';
    } else if($effect_type == 'style1') {
      $displacement_url = YPRM_PLUGINS_HTTP.'/assets/imgs/pattern2.jpg';
    } else if($effect_type == 'style2') {
      $displacement_url = YPRM_PLUGINS_HTTP.'/assets/imgs/pattern3.png';
    }

    ob_start();
    ?>
    <div class="liquiq-banner<?php echo yprm_implode($block_class) ?>" data-displacement="<?php echo esc_url($displacement_url) ?>">
      <?php if($nav_arrows == 'on') { ?>
        <div class="nav-arrows">
          <div class="prev">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="#C48F56" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.0941 15.0937L24.2574 15.0937L20.4203 18.9122C19.9922 19.3383 19.9905 20.0308 20.4167 20.459C20.8428 20.8872 21.5354 20.8888 21.9635 20.4627L27.6786 14.7752C27.6789 14.7749 27.6792 14.7745 27.6795 14.7742C28.1066 14.3481 28.108 13.6533 27.6797 13.2258C27.6793 13.2254 27.679 13.2251 27.6787 13.2247L21.9636 7.53724C21.5355 7.11122 20.843 7.1127 20.4168 7.54095C19.9907 7.9691 19.9923 8.66161 20.4204 9.08773L24.2574 12.9062L1.0941 12.9062C0.490021 12.9062 0.000349045 13.3959 0.000349045 14C0.000349045 14.6041 0.490021 15.0937 1.0941 15.0937Z"/>
            </svg>
          </div>
          <div class="next">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="#C48F56" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.0941 15.0937L24.2574 15.0937L20.4203 18.9122C19.9922 19.3383 19.9905 20.0308 20.4167 20.459C20.8428 20.8872 21.5354 20.8888 21.9635 20.4627L27.6786 14.7752C27.6789 14.7749 27.6792 14.7745 27.6795 14.7742C28.1066 14.3481 28.108 13.6533 27.6797 13.2258C27.6793 13.2254 27.679 13.2251 27.6787 13.2247L21.9636 7.53724C21.5355 7.11122 20.843 7.1127 20.4168 7.54095C19.9907 7.9691 19.9923 8.66161 20.4204 9.08773L24.2574 12.9062L1.0941 12.9062C0.490021 12.9062 0.000349045 13.3959 0.000349045 14C0.000349045 14.6041 0.490021 15.0937 1.0941 15.0937Z"/>
            </svg>
          </div>
        </div>
      <?php } ?>
      <div class="swiper-container">
        <div class="swiper-wrapper"><?php echo do_shortcode($content); ?></div>
      </div>
      <div class="images-slider-container">
        <div class="images-slider-wrapper"></div>
      </div>
      <?php if(count($slides > 0)) { ?>
        <div class="content-slider-container">
          <?php foreach($slides as $slide) {
            echo self::yprm_liquid_banner_slide_html($slide);
          } ?>
        </div>
      <?php } ?>
    </div>
    <?php
    return ob_get_clean();

  }

  public function yprm_liquid_banner_item_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'image' => '',
        ),
        $atts
      )
    );

    ob_start();
    ?>
      <div class="swiper-slide">
        <?php echo yprm_get_image($image, 'img') ?>
      </div>
    <?php
    return ob_get_clean();

  }

  public function yprm_liquid_banner_slide_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'sub_heading' => '',
          'heading' => '',
          'text' => '',
          'link' => '',
          'video_url' => '',
          'color_scheme' => 'default',
          'heading_size' => 'h2',
          'sub_heading_hex' => '',
          'heading_hex' => '',
          'text_hex' => '',
          'link_hex' => '',
          'link_hover_hex' => '',
          'play_button_hex' => '',
          'play_button_bg_hex' => '',
          'play_button_hover_hex' => '',
          'play_button_bg_hover_hex' => '',
        ),
        $atts
      )
    );

    $block_class = $block_attrs = $custom_css = array();

    $block_class[] = $block_id = 'liquiq-banner-item-'.$uniqid;

    if($color_scheme != 'custom') {
      $block_class[] = 'current-color-'.$color_scheme;
    }

    $block_class[] = 'horizontal-type-'.self::$g_array['text_align'];
    $block_class[] = 'vertical-type-'.self::$g_array['text_vertical_align'];

    if($video_url && $video_player = VideoUrlParser::get_player($video_url)) {
      $block_class[] = 'with-video';
    }

    if($sub_heading_hex) {
      $custom_css[] = ".$block_id .sub-h {
        color: $sub_heading_hex !important;
      }";
    }
    if($heading_hex) {
      $custom_css[] = ".$block_id .h {
        color: $heading_hex;
      }";
    }
    if($text_hex) {
      $custom_css[] = ".$block_id .text {
        color: $text_hex;
      }";
    }
    if($link_hex) {
      $custom_css[] = ".$block_id .button-style2:not(:hover) {
        color: $link_hex;
      }";
    }
    if($link_hover_hex) {
      $custom_css[] = ".$block_id .button-style2:hover {
        color: $link_hover_hex;
      }";
    }
    if($play_button_hex) {
      $custom_css[] = ".$block_id .play-button-block a:not(:hover) {
        color: $play_button_hex;
        border-color: $play_button_hex;
      }";
    }
    if($play_button_bg_hex) {
      $custom_css[] = ".$block_id .play-button-block a:not(:hover) {
        background: $play_button_bg_hex;
      }";
    }
    if($play_button_hover_hex) {
      $custom_css[] = ".$block_id .play-button-block a:hover {
        color: $play_button_hover_hex;
        border-color: $play_button_hover_hex;
      }";
    }
    if($play_button_bg_hover_hex) {
      $custom_css[] = ".$block_id .play-button-block a:hover {
        background: $play_button_bg_hover_hex;
      }";
    }


    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', yprm_implode($custom_css, ''));

    ob_start();
    ?>
      <div class="content-slide container<?php echo yprm_implode($block_class) ?>">
        <div class="content-wrap">
          <?php if($video_url && $video_player = VideoUrlParser::get_player($video_url)) { ?>
            <div class="play-button-block popup-gallery images">
              <a href="#" data-type="video" data-size="1280x768" data-video='<div class="wrapper"><div class="video-wrapper"><?php echo $video_player ?></div></div>'>
                <i class="music-and-multimedia-play-button"></i>
              </a>
            </div>
          <?php } ?>
          <div class="content">
            <div class="h-block">
              <?php if($sub_heading) { ?>
                <div class="sub-h"><?php echo wp_kses($sub_heading, 'post') ?></div>
              <?php } if($heading) { ?>
                <<?php echo $heading_size ?> class="h"><?php echo wp_kses($heading, 'post') ?></<?php echo $heading_size ?>>
              <?php } ?>
            </div>
            <?php if($text) { ?>
              <div class="text"><?php echo wp_kses($text, 'post') ?></div>
            <?php } if($link = yprm_vc_link($link)) { ?>
              <div class="button-block">
                <a href="<?php echo esc_url($link['url']) ?>" class="button-style2" target="<?php echo esc_attr($link['target']) ?>"><?php echo strip_tags($link['title']) ?></a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php
    return ob_get_clean();

  }

}

new YPRM_Liquid_Banner();
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_YPRM_Liquid_Banner extends WPBakeryShortCodesContainer {
  }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
  class WPBakeryShortCode_YPRM_Liquid_Banner_Item extends WPBakeryShortCode {
  }
}