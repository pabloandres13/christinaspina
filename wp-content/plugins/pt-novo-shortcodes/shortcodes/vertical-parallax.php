<?php

// Element Description: PT Vertical Parallax Slider

class PT_Vertical_Parallax extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_vertical_parallax_mapping'));
    add_shortcode('pt_vertical_parallax', array($this, 'pt_vertical_parallax_html'));
    add_shortcode('pt_vertical_parallax_item', array($this, 'pt_vertical_parallax_item_html'));
  }

  // Element Mapping
  public function pt_vertical_parallax_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Vertical Parallax Slider", "novo"),
      "base" => "pt_vertical_parallax",
      "as_parent" => array('only' => 'pt_vertical_parallax_item'),
      "content_element" => true,
      "show_settings_on_create" => false,
      "icon" => "shortcode-icon-vertical-parallax",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "switch",
          "heading" => esc_html__("Social buttons", "novo"),
          "param_name" => "social_buttons",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Social buttons color", "novo"),
          "param_name" => "social_buttons_color_hex",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "switch",
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
          "type" => "switch",
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
          "type" => "colorpicker",
          "heading" => esc_html__("Pagination color", "novo"),
          "param_name" => "dots_color",
          "dependency" => Array("element" => "dots", "value" => array("on")),
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
      "name" => esc_html__("Vertical Parallax Slider item", "novo"),
      "base" => "pt_vertical_parallax_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-vertical-parallax",
      "as_child" => array('only' => 'pt_vertical_parallax'),
      "params" => array(
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "image",
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("With price", "novo"),
          "param_name" => "with_price",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Price pre text", "novo"),
          "param_name" => "price_pre_text",
          "dependency" => Array("element" => "with_price", "value" => array("on")),
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Price", "novo"),
          "param_name" => "price",
          "dependency" => Array("element" => "with_price", "value" => array("on")),
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Text", "novo"),
          "param_name" => "text",
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "novo"),
          "param_name" => "link",
          "group" => esc_html__("Content", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Inner shadow", "novo"),
          "param_name" => "inner_shadow",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
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
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Content align", "novo"),
          "param_name" => "content_align",
          "value" => array(
            esc_html__("Left", "novo") => "tal",
            esc_html__("Center", "novo") => "tac",
            esc_html__("Right", "novo") => "tar",
          ),
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
      ),
    ));
  }

  // Element HTML
  public function pt_vertical_parallax_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'social_buttons' => 'on',
          'social_buttons_color_hex' => '',
          'arrows' => 'on',
          'arrow_color' => '',
          'dots' => 'on',
          'dots_color' => '',
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

    $custom_css = "";

    $area_id = uniqid('vertical-parallax-');

    if (isset($arrow_color) && !empty($arrow_color)) {
      $custom_css .= '.' . $id . ' .nav-dots {
        color: ' . $arrow_color . ';
      }';
    }

    if (isset($dots_color) && !empty($dots_color)) {
      $custom_css .= '.' . $id . ' .pagination-dots {
        color: ' . $dots_color . ';
      }';
    }

    if (isset($social_buttons_color_hex) && !empty($social_buttons_color_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-social-buttons {
        color: ' . $social_buttons_color_hex . ';
      }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    // Fill $html var with data
    $html = '<div class="vertical-parallax-area ' . esc_attr($area_id) . '">';
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
    $html .= '<div class="vertical-parallax-slider">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    if ($dots == 'on') {
      $html .= '<div class="pagination-dots"></div>';
    }
    if ($arrows == 'on') {
      $html .= '<div class="nav-arrows"><div class="prev multimedia-icon-up-arrow-2"></div><div class="next multimedia-icon-down-arrow-2"></div></div>';
    }
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_vertical_parallax_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'image' => '',
          'with_price' => 'off',
          'price_pre_text' => '',
          'price' => '',
          'heading' => '',
          'text' => '',
          'link' => '',
          'inner_shadow' => 'on',
          'heading_size' => 'h1',
          'content_align' => 'tal',
          'text_color' => 'black',
          'text_color_hex' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $item_attr = $custom_css = '';

    $block_class = $item_id = uniqid('vertical-parallax-item');

    if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')';
    }

    $block_class .= ' ' . $content_align . ' ' . $text_color;

    if ($inner_shadow == 'on') {
      $block_class .= ' inner-shadow';
    }

    if (isset($text_color_hex) && !empty($text_color_hex)) {
      $custom_css .= '.' . $item_id . ' {
                color: ' . $text_color_hex . ' !important;
            }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    $html = '<div class="item ' . esc_attr($block_class) . '" style="' . esc_attr($item_attr) . '">';
    $html .= '<div class="container">';
    $html .= '<div class="cell">';
    if ($with_price == 'on' && (!empty($price_pre_text) || !empty($price))) {
      if (!empty($price_pre_text)) {
        $html .= '<div class="sub-h">' . wp_kses_post($price_pre_text) . '</div>';
      }
      if (!empty($price)) {
        $html .= '<div class="price">' . wp_kses_post($price) . '</div>';
      }
    }
    if (!empty($heading)) {
      $html .= '<' . esc_attr($heading_size) . ' class="h">' . wp_kses_post($heading) . '</' . esc_attr($heading_size) . '>';
    }
    if (!empty($text)) {
      $html .= '<div class="text"><div>' . wp_kses_post($text) . '</div></div>';
    }
    if (isset(vc_build_link($link)['url']) && !empty(vc_build_link($link)['url'])) {
      if (empty(vc_build_link($link)['title'])) {
        vc_build_link($link)['title'] = esc_html__('Read More', 'novo');
      }
      $html .= '<a href="' . esc_url(vc_build_link($link)['url']) . '" class="button-style1">' . esc_html(vc_build_link($link)['title']) . '</a>';
    }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Vertical_Parallax();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Vertical_Parallax extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Vertical_Parallax_Item extends WPBakeryShortCode {
  }
}
