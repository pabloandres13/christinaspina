<?php

// Element Description: PT Testimonials

class PT_Testimonials extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_testimonials_mapping'));
    add_shortcode('pt_testimonials', array($this, 'pt_testimonials_html'));
    add_shortcode('pt_testimonials_item', array($this, 'pt_testimonials_item_html'));
  }

  // Element Mapping
  public function pt_testimonials_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Testimonials", "novo"),
      "base" => "pt_testimonials",
      "as_parent" => array('only' => 'pt_testimonials_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-testimonials",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Transition speed", "novo"),
          "param_name" => "speed",
          "value" => "300",
          "min" => "100",
          "max" => "10000",
          "step" => "100",
          "suffix" => "ms",
          "dependency" => Array("element" => "carousel", "value" => array("on")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay Slides", "novo"),
          "param_name" => "autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Enable Autoplay", "novo"),
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "dependency" => "",
          "default_set" => true,
          "dependency" => Array("element" => "carousel", "value" => array("on")),
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
          "dependency" => Array("element" => "carousel", "value" => array("on")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Navigation Dots", "novo"),
          "param_name" => "dots",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Display navigation dots", "novo"),
              "on" => "On",
              "off" => "Off",
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "carousel", "value" => array("on")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Navigation Arrows", "novo"),
          "param_name" => "arrows",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Display next / previous navigation arrows", "novo"),
              "on" => "On",
              "off" => "Off",
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "carousel", "value" => array("on")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Arrow Color", "novo"),
          "param_name" => "arrow_color",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Pause on hover", "novo"),
          "param_name" => "pauseohover",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Pause the slider on hover", "novo"),
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "dependency" => Array("element" => "autoplay", "value" => "on"),
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Testimonials item", "novo"),
      "base" => "pt_testimonials_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-testimonials",
      "as_child" => array('only' => 'pt_testimonials'),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "image",
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Name", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Post", "novo"),
          "param_name" => "post",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Text", "novo"),
          "param_name" => "text",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_testimonials_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'speed' => '500',
          'autoplay' => 'on',
          'dots' => 'on',
          'autoplay_speed' => '3000',
          'arrows' => 'on',
          'arrow_color' => '',
          'pauseohover' => 'on',
        ),
        $atts
      )
    );

    $id = 'testimonials-' . $uniqid;

    $category_class = $id;

    $custom_css = "";

    if (isset($arrow_color) && !empty($arrow_color)) {
      $custom_css .= '.' . $id . ' .owl-nav {
                color: ' . $arrow_color . ';
            }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

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
    } else {
      $dots = 'false';
    }
    if ($pauseohover == 'on') {
      $pauseohover = 'true';
    } else {
      $pauseohover = 'false';
    }

    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('owl-carousel');
    wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');

    wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
            jQuery('." . esc_attr($id) . "').each(function(){
                var head_slider = jQuery(this);
                if(jQuery(this).find('.item').length > 1){
                    head_slider.addClass('owl-carousel').owlCarousel({
                        loop:true,
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
                }
            });
        });");

    // Fill $html var with data
    $html = '<div class="testimonials row ' . esc_attr($category_class) . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_testimonials_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'image' => '',
          'heading' => '',
          'post' => '',
          'text' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $html = '<div class="item">';
    $html .= '<div class="row">';
    if (!empty($image) && isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $html .= '<div class="col-12 col-sm-6 image"><div style="background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')"></div></div>';
      $html .= '<div class="col-12 col-sm-6 offset-sm-6">';
    } else {
      $html .= '<div class="col-12">';
    }
    $html .= '<div class="quote"><div class="q">“</div>' . wp_kses($text, 'post') . '</div>';
    $html .= '<h4>' . wp_kses($heading, 'post') . '</h4>';
    $html .= '<div class="post">' . wp_kses($post, 'post') . '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Testimonials();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Testimonials extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Testimonials_Item extends WPBakeryShortCode {
  }
}
