<?php

// Element Description: PT Split_Screen

class PT_Split_Screen extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_split_screen_mapping'));
    add_shortcode('pt_split_screen', array($this, 'pt_split_screen_html'));
    add_shortcode('pt_split_screen_item', array($this, 'pt_split_screen_item_html'));
  }

  // Element Mapping
  public function pt_split_screen_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Split Screen", "novo"),
      "base" => "pt_split_screen",
      "as_parent" => array('only' => 'pt_split_screen_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-split-screen",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "switch",
          "heading" => esc_html__("Pagination", "novo"),
          "param_name" => "pagination",
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
          "type" => "colorpicker",
          "heading" => esc_html__("Pagination Color", "novo"),
          "param_name" => "dots_color",
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Split Screen item", "novo"),
      "base" => "pt_split_screen_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-split-screen",
      "as_child" => array('only' => 'pt_split_screen'),
      "is_container" => true,
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "attach_images",
          "heading" => esc_html__("Images", "novo"),
          "param_name" => "images",
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
  }

  // Element HTML
  public function pt_split_screen_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'pagination' => 'on',
          'dots_color' => '',
        ),
        $atts
      )
    );

    $container_css = $id = 'split-screen-'.$uniqid;

    if ($pagination != 'on') {
      $container_css .= ' pagination-off';
    }

    $custom_css = "";

    if (isset($dots_color) && !empty($dots_color)) {
      $custom_css .= '.' . $id . ' .owl-dots {
        color: ' . $dots_color . ';
      }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('owl-carousel');
    wp_enqueue_script('touch-swipe');

    // Fill $html var with data
    $html = '<div class="split-screen ' . esc_attr($container_css) . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_split_screen_item_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'images' => '',
        ),
        $atts
      )
    );

    $images = explode(',', $images);
    // Fill $html var with data

    $html = '<div class="item">';
    if (is_array($images) && count($images) > 0) {
      $html .= '<div class="image">';
      foreach ($images as $item) {
        $image_src = wp_get_attachment_image_src($item, 'full')[0];
        $html .= '<div class="img-item" style="background-image: url(' . esc_url($image_src) . ');"></div>';
      }
      $html .= '</div>';
    }
    $html .= '<div class="content">';
    $html .= '<div class="cell">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Split_Screen();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Split_Screen extends WPBakeryShortCodesContainer {
  }
  class WPBakeryShortCode_PT_Split_Screen_Item extends WPBakeryShortCodesContainer {
  }
}
