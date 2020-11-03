<?php

// Element Description: PT Image Comparison Slider

class PT_Image_Comparison_Slider extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_image_comparison_slider_mapping'));
    add_shortcode('pt_image_comparison_slider', array($this, 'pt_image_comparison_slider_html'));
  }

  // Element Mapping
  public function pt_image_comparison_slider_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Before/After Slider", "novo"),
      "base" => "pt_image_comparison_slider",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-image-comparison-slider",
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Old", "novo"),
          "param_name" => "old",
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("New", "novo"),
          "param_name" => "new",
        ),
        array(
          "type" => "animation_style",
          "heading" => esc_html__("Animation In", "novo"),
          "param_name" => "animation",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_image_comparison_slider_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'old' => '',
          'new' => '',
          'width' => '',
          'height' => '',
          'animation' => '',
        ),
        $atts
      )
    );

    $class = $id = uniqid('image-comparison-slider-');

    $custom_css = $old_img = $new_img = $style_attr = '';

    $animation = $this->getCSSAnimation($animation);

    if (!empty($old)) {
      $old_img = wp_get_attachment_image($old, 'large');
    }

    if (!empty($new)) {
      $new_img = wp_get_attachment_image($new, 'large');
    }

    vc_icon_element_fonts_enqueue('fontawesome');

    $html = '';

    $html .= '<div class="image-comparison-slider ' . esc_attr($animation) . '" style="' . esc_attr($style_attr) . '">';
    $html .= '<div class="new">' . wp_kses_post($new_img) . '</div>';
    $html .= '<div class="resize"><div class="old">' . wp_kses_post($old_img) . '</div></div>';
    $html .= '<div class="line"></div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Image_Comparison_Slider();