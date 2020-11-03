<?php

// Element Description: PT Tabs

class PT_Tabs extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_tabs_mapping'));
    add_shortcode('pt_tabs', array($this, 'pt_tabs_html'));
    add_shortcode('pt_tabs_item', array($this, 'pt_tabs_item_html'));
  }

  // Element Mapping
  public function pt_tabs_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Tabs", "novo"),
      "base" => "pt_tabs",
      "as_parent" => array('only' => 'pt_tabs_item'),
      "content_element" => true,
      "show_settings_on_create" => false,
      "icon" => "shortcode-icon-tabs",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Tabs item", "novo"),
      "base" => "pt_tabs_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-tabs",
      "as_child" => array('only' => 'pt_tabs'),
      "is_container" => true,
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
  }

  // Element HTML
  public function pt_tabs_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'speed' => '500',
          'autoplay' => 'on',
          'autoplay_speed' => '3000',
          'arrows' => 'on',
          'arrow_color' => '',
          'pauseohover' => 'on',
        ),
        $atts
      )
    );

    $block_class = $id = uniqid('tabs-');

    // Fill $html var with data
    $html = '<div class="tabs ' . esc_attr($block_class) . '">';
    $html .= '<div class="tabs-head"></div>';
    $html .= '<div class="tabs-body">' . do_shortcode($content) . '</div>';
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_tabs_item_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'heading' => '',
          'text' => '',
          'link' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $html = '<div class="item" data-name="' . esc_attr($heading) . '">';
      $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Tabs();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Tabs extends WPBakeryShortCodesContainer {
  }
  class WPBakeryShortCode_PT_Tabs_Item extends WPBakeryShortCodesContainer {
  }
}
