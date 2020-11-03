<?php

// Element Description: PT Price_List

class PT_Accordion extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_accordion_mapping'));
    add_shortcode('pt_accordion', array($this, 'pt_accordion_html'));
    add_shortcode('pt_accordion_item', array($this, 'pt_accordion_item_html'));
  }

  // Element Mapping
  public function pt_accordion_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Accordion", "novo"),
      "base" => "pt_accordion",
      "as_parent" => array('only' => 'pt_accordion_item'),
      "content_element" => true,
      "show_settings_on_create" => false,
      "icon" => "shortcode-icon-accordion",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "js_view" => 'VcColumnView',
      "params" => array(
        yprm_vc_uniqid(),
        yprm_add_css_animation(),
        array(
          "type" => "css_editor",
          "heading" => esc_html__("CSS box", "pt-addons"),
          "param_name" => "css",
          "edit_field_class" => "simple",
          "group" => esc_html__("Design Options", "pt-addons"),
        ),
      ),
    ));
    vc_map(array(
      "name" => esc_html__("Accordion item", "novo"),
      "base" => "pt_accordion_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-accordion",
      "as_child" => array('only' => 'pt_accordion'),
      "params" => array(
        array(
          "type" => "switch",
          "heading" => esc_html__("Open?", "pt-addons"),
          "param_name" => "open",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Text", "novo"),
          "param_name" => "text",
          "admin_label" => true,
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_accordion_html($atts, $content = null) {

    // Params extraction

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'css_animation' => '',
          'css' => '',
        ),
        $atts
      )
    );

    $block_class[] = $block_id = 'accordion-' . $uniqid;

    if(!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    // Fill $html var with data
    $html = '<div class="accordion-items'.yprm_implode($block_class).'">';
      $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_accordion_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'open' => 'off',
          'heading' => '',
          'text' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $html = '';

    if (!empty($heading) && !empty($text)) {
      $html .= '<div class="item'.($open == 'on' ? ' active' : '').'">';
      $html .= '<div class="top"><div class="t"></div><div class="cell">' . wp_kses_post($heading) . '</div></div>';
      $html .= '<div class="wrap"'.($open == 'on' ? ' style="display: block;"' : '').'>' . wp_kses_post($text) . '</div>';
      $html .= '</div>';
    }

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Accordion();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Accordion extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Accordion_Item extends WPBakeryShortCode {
  }
}
