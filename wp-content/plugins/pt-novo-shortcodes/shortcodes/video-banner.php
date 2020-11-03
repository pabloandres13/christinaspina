<?php

// Element Description: PT Banner

class PT_Video_Banner extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_video_banner_mapping'));
    add_shortcode('pt_video_banner', array($this, 'pt_video_banner_html'));
    add_shortcode('pt_video_banner_item', array($this, 'pt_video_banner_item_html'));
  }

  // Element Mapping
  public function pt_video_banner_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Video Banner", "novo"),
      "base" => "pt_video_banner",
      "as_parent" => array('only' => 'pt_video_banner_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "is_container" => true,
      "icon" => "shortcode-icon-video-banner",
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Infinite loop", "novo"),
          "param_name" => "infinite_loop",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Restart the slider automatically as it passes the last slide.", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "number",
          "class" => "",
          "heading" => esc_html__("Transition speed", "novo"),
          "param_name" => "speed",
          "value" => "300",
          "min" => "100",
          "max" => "10000",
          "step" => "100",
          "suffix" => "ms",
          "description" => esc_html__("Speed at which next slide comes.", "novo"),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
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
          "group" => esc_html__("General", "novo"),
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
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Extra Class", "novo"),
          "param_name" => "el_class",
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Adaptive Height", "novo"),
          "param_name" => "adaptive_height",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Turn on Adaptive Height", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Height", "novo"),
          "param_name" => "height",
          "min" => "540",
          "max" => "1500",
          "step" => "10",
          "suffix" => "px",
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Social buttons", "novo"),
          "param_name" => "social_buttons",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Social buttons color", "novo"),
          "param_name" => "social_buttons_color_hex",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Default Color", "novo"),
          "param_name" => "default_color",
          "dependency" => Array("element" => "dots", "value" => array("on")),
          "value" => array(
            esc_html__("Inherit", "novo") => "inherit",
            esc_html__("White", "novo") => "white",
            esc_html__("Black", "novo") => "black",
            esc_html__("Custom", "novo") => "custom",
          ),
          "std" => 'inherit',
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Default Custom Color", "novo"),
          "param_name" => "default_color_hex",
          "dependency" => Array("element" => "default_color", "value" => array("custom")),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Navigation Arrows", "novo"),
          "param_name" => "arrows",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Display next / previous navigation arrows", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Arrow Color", "novo"),
          "param_name" => "arrow_color",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Arrow position", "novo"),
          "param_name" => "arrows_position",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
          "value" => array(
            esc_html__("Left Bottom", "novo") => "left-bottom",
            esc_html__("Right Bottom", "novo") => "right-bottom",
          ),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Pagination", "novo"),
          "param_name" => "dots",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Pagination position", "novo"),
          "param_name" => "dots_position",
          "dependency" => Array("element" => "dots", "value" => array("on")),
          "value" => array(
            esc_html__("Left", "novo") => "left",
            esc_html__("Left Outside", "novo") => "left-outside",
            esc_html__("Left Bottom", "novo") => "left-bottom",
            esc_html__("Bottom", "novo") => "bottom",
            esc_html__("Right Bottom", "novo") => "right-bottom",
            esc_html__("Right", "novo") => "right",
            esc_html__("Right Outside", "novo") => "right-outside",
          ),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Pagination color", "novo"),
          "param_name" => "dots_color",
          "dependency" => Array("element" => "dots", "value" => array("on")),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Pause on hover", "novo"),
          "param_name" => "pauseohover",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Pause the slider on hover", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => Array("element" => "autoplay", "value" => "on"),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 1", "novo"),
          "param_name" => "social_icon1",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 1", "novo"),
          "param_name" => "social_link1",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 2", "novo"),
          "param_name" => "social_icon2",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 2", "novo"),
          "param_name" => "social_link2",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 3", "novo"),
          "param_name" => "social_icon3",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 3", "novo"),
          "param_name" => "social_link3",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 4", "novo"),
          "param_name" => "social_icon4",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 4", "novo"),
          "param_name" => "social_link4",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Video Banner item", "novo"),
      "base" => "pt_video_banner_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-video-banner",
      "as_child" => array('only' => 'pt_video_banner'),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "image",
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Video url", "novo"),
          "param_name" => "video_url",
          "description" => esc_html__("Source YouTube, Vimeo", "novo"),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Sub Heading", "novo"),
          "param_name" => "sub_heading",
          "admin_label" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Inner shadow", "novo"),
          "param_name" => "inner_shadow",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Color overlay", "novo"),
          "param_name" => "color_overlay",
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Text color", "novo"),
          "param_name" => "text_color",
          "value" => array(
            esc_html__("Black", "novo") => "black",
            esc_html__("White", "novo") => "white",
            esc_html__("Custom", "novo") => "custom",
          ),
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Select Text color", "novo"),
          "param_name" => "text_color_hex",
          "dependency" => Array("element" => "text_color", "value" => "custom"),
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
          "group" => esc_html__("Design", "novo"),
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_video_banner_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'external_indent' => 'off',
          'carousel_nav' => 'off',
          'infinite_loop' => 'on',
          'speed' => '500',
          'autoplay' => 'on',
          'autoplay_speed' => '3000',
          'el_class' => '',
          'adaptive_height' => '',
          'default_color' => 'inherit',
          'default_color_hex' => '',
          'height' => '',
          'arrows' => 'on',
          'arrow_color' => '',
          'arrows_position' => 'left',
          'dots' => 'on',
          'dots_position' => 'left',
          'dots_color' => '',
          'pauseohover' => 'on',
          'social_buttons' => 'off',
          'social_buttons_color_hex' => '',
          'social_icon1' => '',
          'social_link1' => '',
          'social_icon2' => '',
          'social_link2' => '',
          'social_icon3' => '',
          'social_link3' => '',
          'social_icon4' => '',
          'social_link4' => '',
        ),
        $atts
      )
    );

    $id = 'banner-' . $uniqid;

    $banner_class = $id;
    $banner_class .= ' ' . $el_class;

    $banner_style = "";

    if (!empty($height)) {
      $banner_class .= ' fixed-height';
      $banner_style = 'height:' . $height . 'px;';
    }

    $custom_css = "";

    if (isset($dots_color) && !empty($dots_color)) {
      $custom_css .= '.' . $id . ' .owl-dots {
                color: ' . $dots_color . ';
            }';
    }

    $custom_area_css = $area_id = "banner-area-" . $uniqid;
    if ($external_indent == 'on') {
      $custom_area_css .= " external-indent";
    }

    if ($default_color != 'custom') {
      $custom_area_css .= " banner-color-" . $default_color;
    } else {
      $custom_css .= '.' . $area_id . ' {
                color: ' . $default_color_hex . ';
            }';
    }

    if (isset($social_buttons_color_hex) && !empty($social_buttons_color_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-social-buttons {
                color: ' . $social_buttons_color_hex . ';
            }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    if ($infinite_loop == 'on') {
      $infinite_loop = 'true';
    } else {
      $infinite_loop = 'false';
    }
    if ($autoplay == 'on') {
      $autoplay = 'true';
    } else {
      $autoplay = 'false';
    }
    if ($arrows == 'on') {
      $arrows = 'true';
    } else {
      $arrows = 'false';
    }
    if ($dots == 'on') {
      $dots = 'true';
      $banner_class .= ' pagination-' . $dots_position;
    } else {
      $dots = 'false';
    }
    if ($pauseohover == 'on') {
      $pauseohover = 'true';
    } else {
      $pauseohover = 'false';
    }

    if ($carousel_nav != 'on') {
      $loop = 'true';
    } else {
      $loop = 'false';
    }

    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('owl-carousel');
    wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');

    wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
            jQuery('." . esc_attr($id) . "').each(function(){
                jQuery(this).on('initialize.owl.carousel',function(property){
                    jQuery(this).find('.item').each(function() {
                        var num = leadZero(jQuery(this).index()+1);
                        jQuery(this).find('.num').text(num);
                    });
                });
                var head_slider = jQuery(this);
                if(head_slider.find('.item').length == 1) {
                    head_slider.parent().removeClass('with-carousel-nav');
                }
                if(jQuery(this).find('.item').length > 1){
                    head_slider.addClass('owl-carousel').owlCarousel({
                        loop:" . esc_js($loop) . ",
                        items:1,
                        nav: " . esc_js($arrows) . ",
                        dots: " . esc_js($dots) . ",
                        autoplay: " . esc_js($autoplay) . ",
                        autoplayTimeout: " . esc_js($autoplay_speed) . ",
                        autoplayHoverPause: " . esc_js($pauseohover) . ",
                        smartSpeed: " . esc_js($speed) . ",
                        navClass: ['owl-prev basic-ui-icon-left-arrow','owl-next basic-ui-icon-right-arrow'],
                        navText: false,
                        responsive:{
                            0:{
                                nav: false,
                            },
                            480:{

                            },
                            768:{
                                nav: " . esc_js($arrows) . ",
                            },
                        },
                    });

                    head_slider.on('changed.owl.carousel',function(property){
                        var current = property.item.index;
                        if(jQuery(property.target).find('.owl-item').eq(current).find('video').length > 0) {
                            jQuery(property.target).find('.owl-item').eq(current).find('video').get(0).play();
                        }
                    });
                }
            });
        });");

    // Fill $html var with data
    $html = '<div class="banner-area ' . esc_attr($custom_area_css) . '">';
    if ($social_buttons == 'on') {
      $social_links_array = array();

      $flag = true;
      $a = 0;
      while ($a <= 4) {
        $a++;
        $s_type = 'social_icon' . $a;
        $s_link = 'social_link' . $a;

        if (!empty($$s_type) && !empty($$s_link)) {
          $flag = false;

          array_push($social_links_array, array(
            'type' => $$s_type,
            'url' => $$s_link,
          ));
        }
      }

      if ($flag) {
        $social_links_html = yprm_build_social_links('with-label');
      } else {
        $social_links_html = yprm_build_social_links('with-label', $social_links_array);
      }

      if(!empty($social_links_html)) {
        $html .= '<div class="banner-social-buttons">';
          $html .= '<div class="links">';
            $html .= $social_links_html;
          $html .= '</div>';
        $html .= '</div>';
      }
    }

    $html .= '<div class="banner ' . esc_attr($banner_class) . '" style="' . $banner_style . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_video_banner_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'image' => '',
          'video_url' => '',
          'sub_heading' => '',
          'heading' => '',
          'link_button' => '',
          'link' => '',
          'link_play' => 'off',
          'link_text' => '',
          'inner_shadow' => 'off',
          'color_overlay' => '',
          'heading_size' => 'h1',
          'heading_style' => 'default',
          'text_color' => 'black',
          'text_color_hex' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data
    $item_attr = "";

    if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')';
    }

    $heading_html = $sub_heading_html = $text_html = $custom_css = '';
    $item_class = $item_id = 'banner-item-' . $uniqid;

    if (!empty($sub_heading)) {
      $sub_heading_html = '<div class="sub-h">' . wp_kses_post($sub_heading) . '</div>';
    }

    if (!empty($heading)) {
      $heading_html = '<div class="heading">
                <' . $heading_size . ' class="h">' . wp_kses_post($heading) . '</' . $heading_size . '>
            </div>';
    }

    $video_html = '';

    if (!empty($color_overlay)) {
      $custom_css .= '.' . $item_id . ':after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1;
                background-color: ' . $color_overlay . ';
            }';
    }

    if ($inner_shadow == 'on') {
      $item_class .= ' with-shadow';
    }

    if (isset($text_color) && $text_color != 'custom') {
      $item_class .= ' ' . $text_color;
    }

    if (isset($text_color) && $text_color == 'custom') {
      $custom_css .= '.' . $item_id . ' {
                color: ' . $text_color_hex . ';
            }';
    }

    if (!empty($video_url)) {
      wp_enqueue_script('video-background', get_template_directory_uri() . '/js/jquery.background-video.js', array('jquery'));
      wp_enqueue_script('video', get_template_directory_uri() . '/js/video.js', array('jquery'));
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    $html = '<div class="item ' . esc_attr($item_class) . '" style="' . esc_attr($item_attr) . '">';
    $html .= '<div class="container">';
    $html .= '<div class="cell middle">';
    $html .= '<div class="content popup-gallery images">';
    $html .= '<div class="angle"><span></span><span></span><span></span><span></span></div>';
    $html .= wp_kses_post($sub_heading_html);
    $html .= wp_kses_post($heading_html);
    if (!empty($video_url)) {
      $video_url = VideoUrlParser::get_url_embed($video_url);
      $html .= '<a href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="1920" height="1080" src="' . esc_url($video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\'><i class="music-and-multimedia-play-button"></i></a>';
    }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Video_Banner();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Video_Banner extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Video_Banner_Item extends WPBakeryShortCode {
  }
}
