<?php

// Element Description: PT Categories

class PT_Categories extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_categories_mapping'));
    add_shortcode('pt_categories', array($this, 'pt_categories_html'));
    add_shortcode('pt_categories_item', array($this, 'pt_categories_item_html'));
  }

  public static function get_all_portfolio_category() {
    $taxonomy = 'pt-portfolio-category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  public static function get_all_blog_category() {
    $taxonomy = 'category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  public static function get_all_product_category() {
    $taxonomy = 'product_cat';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  // Element Mapping
  public function pt_categories_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Categories", "novo"),
      "base" => "pt_categories",
      "as_parent" => array('only' => 'pt_categories_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-categories",
      "is_container" => true,
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
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Style", "novo"),
          "param_name" => "style",
          "value" => array(
            esc_html__("Normal", "novo") => "normal",
            esc_html__("Big", "novo") => "big",
          ),
          "std" => 'big',
          "group" => esc_html__("General", "novo"),
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
          "group" => esc_html__("Cols", "novo"),
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
          "group" => esc_html__("Cols", "novo"),
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
          "group" => esc_html__("Cols", "novo"),
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
          "dependency" => Array("element" => "carousel", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
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
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "dependency" => "",
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
          "class" => "",
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
      "name" => esc_html__("Categories item", "novo"),
      "base" => "pt_categories_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-categories",
      "as_child" => array('only' => 'pt_categories'),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Source", "novo"),
          "param_name" => "source",
          "admin_label" => true,
          "value" => array(
            esc_html__("Blog", "novo") => "blog",
            esc_html__("Portfolio", "novo") => "portfolio",
            esc_html__("Product", "novo") => "product",
            esc_html__("Custom link", "novo") => "custom_link",
          ),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "category_portfolio",
          "admin_label" => true,
          "value" => PT_Categories::get_all_portfolio_category(),
          "group" => esc_html__("General", "novo"),
          "dependency" => Array("element" => "source", "value" => "portfolio"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "category_blog",
          "admin_label" => true,
          "value" => PT_Categories::get_all_blog_category(),
          "group" => esc_html__("General", "novo"),
          "dependency" => Array("element" => "source", "value" => "blog"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "category_product",
          "admin_label" => true,
          "value" => PT_Categories::get_all_product_category(),
          "group" => esc_html__("General", "novo"),
          "dependency" => Array("element" => "source", "value" => "product"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Custom link", "novo"),
          "param_name" => "custom_link",
          "dependency" => Array("element" => "source", "value" => "custom_link"),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "image",
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Sub Heading", "novo"),
          "param_name" => "sub_heading",
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "group" => esc_html__("General", "novo"),
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
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Link text", "novo"),
          "param_name" => "link_text",
          "value" => esc_html__('see more', 'novo'),
          "dependency" => Array("element" => "link_button", "value" => "on"),
          "group" => esc_html__("General", "novo"),
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
          "heading" => esc_html__("Sub Heading size", "novo"),
          "param_name" => "sub_heading_size",
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
          "std" => 'h3',
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
  public function pt_categories_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'carousel' => 'on',
          'style' => 'big',
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
        ),
        $atts
      )
    );

    $id = 'category-' . $uniqid;

    $category_class = $id . ' type-' . $style;

    $custom_css = "";

    if (isset($arrow_color) && !empty($arrow_color)) {
      $custom_css .= '.' . $id . ' .owl-nav {
                color: ' . $arrow_color . ';
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
                                    items: 1,
                                },
                                480:{

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
    $html = '<div class="category row ' . esc_attr($category_class) . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_categories_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'source' => '',
          'category_portfolio' => '',
          'category_blog' => '',
          'category_product' => '',
          'custom_link' => '',
          'image' => '',
          'sub_heading' => '',
          'heading' => '',
          'link_button' => 'on',
          'link_text' => esc_html__('see more', 'novo'),
          'text_color' => 'black',
          'text_color_hex' => '',
          'sub_heading_size' => 'h6',
          'heading_size' => 'h3',
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
    $item_class = $item_id = 'category-item-' . $uniqid;

    if (!$heading) {
      $heading = '';
    }

    if ($sub_heading) {
      $heading_html .= '<' . $sub_heading_size . ' class="sub-h">' . $sub_heading . '</' . $sub_heading_size . '>';
    }
    if ($heading) {
      $heading_html .= '<' . $heading_size . ' class="h">' . $heading . '</' . $heading_size . '>';
    }

    $item_attr = "";
    if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')';
    }

    $target = '_self';
    if ($source != 'custom_link') {
      if ($category_portfolio) {
        $link = get_category_link($category_portfolio);
      }
      if ($category_blog) {
        $link = get_category_link($category_blog);
      }
      if ($category_product) {
        $link = get_category_link($category_product);
      }
    } elseif ($source == 'custom_link' && isset(vc_build_link($custom_link)['url']) && !empty(vc_build_link($custom_link)['url'])) {
      $link = vc_build_link($custom_link)['url'];
      
      if(isset(vc_build_link($custom_link)['target'])) {
        $target = vc_build_link($custom_link)['target'];
      }
    }

    if ($link_button == 'on' && !empty($link) && !empty($link_text)) {
      $link_html = '<a href="' . esc_url($link) . '" class="button-style1" target="'.$target.'">' . esc_html($link_text) . '</a>';
      if (!empty($button_text_color) || !empty($button_border_color) || !empty($button_bg_color)) {
        $custom_css .= '.' . $item_id . ' .button-style1 {';
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
        $custom_css .= '.' . $item_id . ' .button-style1:hover {';
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

    if (isset($text_color) && $text_color != 'custom') {
      $item_class .= ' ' . $text_color;
    }

    if (isset($text_color) && $text_color == 'custom') {
      $custom_css .= '.' . $item_id . ' {
                color: ' . $text_color_hex . ';
            }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    $html = '<div class="item ' . esc_attr($item_class) . '" style="' . esc_attr($item_attr) . '">
                    ' . wp_kses($heading_html, 'post') . '
                    ' . wp_kses($link_html, 'post') . '
                </div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Categories();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Categories extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Categories_Item extends WPBakeryShortCode {
  }
}
