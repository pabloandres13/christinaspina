<?php

// Element Description: PT Price_List

class PT_Price_List extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_price_list_mapping'));
    add_shortcode('pt_price_list', array($this, 'pt_price_list_html'));
    add_shortcode('pt_price_list_item', array($this, 'pt_price_list_item_html'));
  }

  // Element Mapping
  public function pt_price_list_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Price List", "novo"),
      "base" => "pt_price_list",
      "as_parent" => array('only' => 'pt_price_list_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-price-list",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "switch",
          "heading" => esc_html__("Carousel", "novo"),
          "param_name" => "carousel",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Desktop", "novo"),
          "param_name" => "desctop_cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '3',
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Tablet", "novo"),
          "param_name" => "tablet_cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '2',
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Mobile", "novo"),
          "param_name" => "mobile_cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '1',
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Heading Font Size", "pt-addons"),
          "param_name" => "heading_font_size",
          "suffix" => esc_html__("px", "pt-addons"),
          "group" => esc_html__("Customizing", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Heading Color", "pt-addons"),
          "param_name" => "heading_hex",
          "group" => esc_html__("Customizing", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Price Font Size", "pt-addons"),
          "param_name" => "price_font_size",
          "suffix" => esc_html__("px", "pt-addons"),
          "group" => esc_html__("Customizing", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Price Color", "pt-addons"),
          "param_name" => "price_hex",
          "group" => esc_html__("Customizing", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Options Color", "pt-addons"),
          "param_name" => "options_hex",
          "group" => esc_html__("Customizing", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Button Color", "pt-addons"),
          "param_name" => "button_hex",
          "group" => esc_html__("Customizing", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Button Hover Color", "pt-addons"),
          "param_name" => "button_hover_hex",
          "group" => esc_html__("Customizing", "novo"),
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
          "group" => esc_html__("Carousel settings", "novo"),
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
          "default_set" => true,
          "dependency" => Array("element" => "carousel", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
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
          "group" => esc_html__("Carousel settings", "novo"),
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
          "group" => esc_html__("Carousel settings", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Arrow Color", "novo"),
          "param_name" => "arrow_color",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
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
          "group" => esc_html__("Carousel settings", "novo"),
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Price List item", "novo"),
      "base" => "pt_price_list_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-price-list",
      "as_child" => array('only' => 'pt_price_list'),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "image",
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Price", "novo"),
          "param_name" => "price",
          "admin_label" => true,
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Link Button", "novo"),
          "param_name" => "link_button",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Options heading", "novo"),
          "param_name" => "options_heading",
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Options", "novo"),
          "param_name" => "options",
          "description" => esc_html__("Per row", "novo"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Custom link", "novo"),
          "param_name" => "custom_link",
          "dependency" => Array("element" => "link_button", "value" => "on"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Link text", "novo"),
          "param_name" => "link_text",
          "value" => esc_html__('purchase', 'novo'),
          "dependency" => Array("element" => "link_button", "value" => "on"),
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
          "std" => 'h6',
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Option Heading size", "novo"),
          "param_name" => "options_heading_size",
          "value" => array(
            esc_html__("H1", "novo") => "h1",
            esc_html__("H2", "novo") => "h2",
            esc_html__("H3", "novo") => "h3",
            esc_html__("H4", "novo") => "h4",
            esc_html__("H5", "novo") => "h5",
            esc_html__("H6", "novo") => "h6",
          ),
          "std" => 'h5',
          "group" => esc_html__("Design", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Text color", "novo"),
          "param_name" => "button_text_color",
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("Button customize", "novo"),
          "edit_field_class" => "vc_col-sm-6",
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Hover color", "novo"),
          "param_name" => "button_text_color_hover",
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("Button customize", "novo"),
          "edit_field_class" => "vc_col-sm-6",
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Border color", "novo"),
          "param_name" => "button_border_color",
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("Button customize", "novo"),
          "edit_field_class" => "vc_col-sm-6",
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Hover color", "novo"),
          "param_name" => "button_border_color_hover",
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("Button customize", "novo"),
          "edit_field_class" => "vc_col-sm-6",
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Background color", "novo"),
          "param_name" => "button_bg_color",
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("Button customize", "novo"),
          "edit_field_class" => "vc_col-sm-6",
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Hover color", "novo"),
          "param_name" => "button_bg_color_hover",
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("Button customize", "novo"),
          "edit_field_class" => "vc_col-sm-6",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_price_list_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'carousel' => 'on',
          'style' => 'big',
          'price_font_size' => '',
          'cols' => '3',
          'speed' => '500',
          'autoplay' => 'on',
          'autoplay_speed' => '3000',
          'arrows' => 'on',
          'arrow_color' => '',
          'pauseohover' => 'on',
          'desctop_cols' => '3',
          'tablet_cols' => '2',
          'mobile_cols' => '1',
          'heading_font_size' => '',
          'price_font_size' => '',
          'heading_hex' => '',
          'price_hex' => '',
          'options_hex' => '',
          'button_hex' => '',
          'button_hover_hex' => '',
        ),
        $atts
      )
    );

    $id = 'price-list-' . $uniqid;

    $category_class = $id . ' type-big';

    $custom_css = "";

    if (isset($arrow_color) && !empty($arrow_color)) {
      $custom_css .= '.' . $id . ' .owl-nav {
        color: ' . $arrow_color . ';
      }';
    }

    if(!empty($price_font_size)) {
      $custom_css .= '.' . $id . '.price-list .item .price {
        font-size: ' . $price_font_size . 'px;
      }';
    }

    if(!empty($price_hex)) {
      $custom_css .= '.' . $id . '.price-list .item .price {
        color: ' . $price_hex . ';
      }';
    }

    if(!empty($heading_font_size)) {
      $custom_css .= '.' . $id . '.price-list .item .h {
        font-size: ' . $heading_font_size . 'px;
      }';
    }

    if(!empty($heading_hex)) {
      $custom_css .= '.' . $id . '.price-list .item .h {
        color: ' . $heading_hex . ';
      }';
    }

    if(!empty($options_hex)) {
      $custom_css .= '.' . $id . '.price-list .item .options {
        color: ' . $options_hex . ' !important;
      }';
    }

    if(!empty($button_hex)) {
      $custom_css .= '.' . $id . '.price-list .item .button-style1:not(:hover),
      .' . $id . '.price-list .item .button-style2:not(:hover) {
        color: ' . $button_hex . ';
      }';
    }

    if(!empty($button_hover_hex)) {
      $custom_css .= '.' . $id . '.price-list .item .button-style2:hover {
        color: ' . $button_hover_hex . ';
      }';
      $custom_css .= '.' . $id . '.price-list .item .button-style1:hover {
        color: #fff;
        background: ' . $button_hover_hex . ';
      }';

      $custom_css .= '.' . $id . '.price-list .item .button-style1 span,
      .' . $id . '.price-list .item .button-style1 span:after {
        background: ' . $button_hover_hex . ';
      }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    if ($carousel == "on") {
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
              dots: false,
              autoplay: " . esc_js($autoplay) . ",
              autoplayTimeout: " . esc_js($autoplay_speed) . ",
              autoplayHoverPause: " . esc_js($pauseohover) . ",
              smartSpeed: " . esc_js($speed) . ",
              navClass: ['owl-prev basic-ui-icon-left-arrow','owl-next basic-ui-icon-right-arrow'],
              navText: false,
              responsive:{
                0:{
                  nav: false,
                  items: 1,
                },
                768:{
                  nav: " . esc_js($arrows) . ",
                  items: " . esc_js($mobile_cols) . ",
                },
                980:{
                  items: " . esc_js($tablet_cols) . ",
                },
                1200:{
                  items: " . esc_js($desctop_cols) . ",
                },
              },
          });
        }
      });
    });");
    } else {
      wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');

      wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
        jQuery('." . esc_attr($id) . "').each(function(){
          jQuery(this).find('.item').addClass('col-12 col-sm-" . (12 / $mobile_cols) . " col-md-" . (12 / $tablet_cols) . " col-lg-" . (12 / $desctop_cols) . "');
        });
      });");
    }

    // Fill $html var with data
    $html = '<div class="price-list row ' . esc_attr($category_class) . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_price_list_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'price' => '',
          'options_heading' => '',
          'options' => '',
          'custom_link' => '',
          'image' => '',
          'sub_heading' => '',
          'heading' => '',
          'link_button' => 'on',
          'link_text' => esc_html__('purchase', 'novo'),
          'text_color' => 'black',
          'text_color_hex' => '',
          'heading_size' => 'h6',
          'options_heading_size' => 'h5',
          'button_text_color' => '',
          'button_text_color_hover' => '',
          'button_border_color' => '',
          'button_border_color_hover' => '',
          'button_bg_color' => '',
          'button_bg_color_hover' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $heading_html = '';
    $link_html = '';
    $price_html = '';
    $custom_css = '';
    $link = '';
    $options_heading_html = "";
    $options_html = "";
    $item_class = $item_id = 'price-list-item-' . $uniqid;

    if (!$heading) {
      $heading = '';
    }

    if ($heading) {
      $heading_html = '<' . $heading_size . ' class="h">' . $heading . '</' . $heading_size . '>';
    }

    if ($price) {
      $price_html = '<div class="price">' . $price . '</div>';
    }

    if ($options_heading) {
      $options_heading_html = '<div class="heading-decor"><' . $options_heading_size . '>' . $options_heading . '</' . $options_heading_size . '></div>';
    }

    $item_attr = "";
    if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')';
    }

    if (isset(vc_build_link($custom_link)['url']) && !empty(vc_build_link($custom_link)['url'])) {
      $link = vc_build_link($custom_link)['url'];
    }

    if ($link_button == 'on' && !empty($link) && !empty($link_text)) {
      $link_html = '<a href="' . esc_url($link) . '" class="button-style2">' . esc_html($link_text) . '</a>';
      if (!empty($button_text_color) || !empty($button_border_color) || !empty($button_bg_color)) {
        $custom_css .= '.' . $item_id . ' .button-style2 {';
        if (!empty($button_text_color)) {
          $custom_css .= 'color: ' . $button_text_color . ';';
        }
        if (!empty($button_border_color)) {
          $custom_css .= 'border-color: ' . $button_border_color . ';';
        }
        if (!empty($button_bg_color)) {
          $custom_css .= 'background-color: ' . $button_bg_color . ';';
        }
        $custom_css .= '}';
      }

      if (!empty($button_text_color_hover) || !empty($button_border_color_hover) || !empty($button_bg_color_hover)) {
        $custom_css .= '.' . $item_id . ' .button-style2:hover {';
        if (!empty($button_text_color_hover)) {
          $custom_css .= 'color: ' . $button_text_color_hover . ';';
        }
        if (!empty($button_border_color_hover)) {
          $custom_css .= 'border-color: ' . $button_border_color_hover . ';';
        }
        if (!empty($button_bg_color_hover)) {
          $custom_css .= 'background-color: ' . $button_bg_color_hover . ';';
        }
        $custom_css .= '}';
      }
    }

    if ($options) {
      $options = preg_split('/\r\n|[\r\n]/', $options);

      foreach ($options as $option) {
        $options_html .= '<div class="o-row">' . $option . '</div>';
      }
    }

    if (isset($text_color) && $text_color != 'custom') {
      $item_class .= ' ' . $text_color;
    }

    if (isset($text_color) && $text_color == 'custom') {
      $custom_css .= '.' . $item_id . ' {
        color: ' . $text_color_hex . ' !important;
      }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    $html = '<div class="item ' . esc_attr($item_class) . '" style="' . esc_attr($item_attr) . '">
      ' . wp_kses($heading_html, 'post') . '
      ' . wp_kses($price_html, 'post') . '
      ' . wp_kses($link_html, 'post') . '
      <div class="options">
        <div class="wrap">
          ' . wp_kses($options_heading_html, 'post') . '
          ' . wp_kses($options_html, 'post') . '
        </div>
        <a href="#" class="button-style1">' . yprm_get_theme_setting('tr_options') . '<span></span></a>
      </div>
    </div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Price_List();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Price_List extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Price_List_Item extends WPBakeryShortCode {
  }
}
