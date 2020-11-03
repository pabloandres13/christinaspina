<?php

// Element Description: PT Categories

class PT_Categories_Slider extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_categories_slider_mapping'));
    add_shortcode('pt_categories_slider', array($this, 'pt_categories_slider_html'));
    add_shortcode('pt_categories_slider_item', array($this, 'pt_categories_slider_item_html'));
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
  public function pt_categories_slider_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Categories Slider", "novo"),
      "base" => "pt_categories_slider",
      "as_parent" => array('only' => 'pt_categories_slider_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-categories",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Show Serial Number", "novo"),
          "param_name" => "serial_number",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => "On",
              "off" => "Off",
            ),
          ),
          "default_set" => true,
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Category item", "novo"),
      "base" => "pt_categories_slider_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-categories",
      "as_child" => array('only' => 'pt_categories_slider'),
      "params" => array(
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
          "value" => PT_Categories_Slider::get_all_portfolio_category(),
          "group" => esc_html__("General", "novo"),
          "dependency" => Array("element" => "source", "value" => "portfolio"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "category_blog",
          "admin_label" => true,
          "value" => PT_Categories_Slider::get_all_blog_category(),
          "group" => esc_html__("General", "novo"),
          "dependency" => Array("element" => "source", "value" => "blog"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "category_product",
          "admin_label" => true,
          "value" => PT_Categories_Slider::get_all_product_category(),
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
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
          "group" => esc_html__("General", "novo"),
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_categories_slider_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'serial_number' => 'on',
        ),
        $atts
      )
    );

    $category_class = $id = '';

    if ($serial_number != 'on') {
      $category_class = ' numbers-off';
    }

    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('owl-carousel');

    // Fill $html var with data

    $html = '<div class="category-slider-area' . esc_attr($category_class) . '">';
    $html .= '<div class="category-slider-images"></div>';
    $html .= '<div class="category-slider owl-carousel">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_categories_slider_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'source' => '',
          'category_portfolio' => '',
          'category_blog' => '',
          'category_product' => '',
          'custom_link' => '',
          'image' => '',
          'heading' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $item_image = $item_class = $link = '';

    if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $item_image = esc_url(wp_get_attachment_image_src($image, 'full')[0]);
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

    $html = '<div class="item' . esc_attr($item_class) . '" data-image="' . esc_url($item_image) . '"><a href="' . esc_url($link) . '" target="'.$target.'">' . wp_kses_post($heading) . '</a></div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Categories_Slider();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Categories_Slider extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Categories_Slider_Item extends WPBakeryShortCode {
  }
}
