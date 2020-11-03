<?php

// Element Name: PT Decor Elements

class YPRM_Decor_Elements {

  public function __construct() {
    add_action('init', array($this, 'yprm_decor_elements_mapping'));
    add_shortcode( 'yprm_decor_elements', array( $this, 'yprm_decor_elements_html' ) );
    add_shortcode( 'yprm_decor_elements_item', array( $this, 'yprm_decor_elements_item_html' ) );
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
      )
    );
  }

  public function yprm_vc_map_item_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Type", "pt-addons"),
          "param_name" => "type",
          "value" => array(
            esc_html__("Type 1", "pt-addons") => "type1",
            esc_html__("Type 2", "pt-addons") => "type2",
          ),
          "admin_label" => true
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__("Position", "pt-addons"),
          "param_name" => "h_position",
          "description" => esc_html__("Examples: 20px or 2em or 120%", "pt-addons"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Align", "pt-addons"),
          "param_name" => "align",
          "value" => array(
            esc_html__("Left", "pt-addons") => "left",
            esc_html__("Right", "pt-addons") => "right",
          ),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Top", "pt-addons"),
          "param_name" => "top",
          "edit_field_class" => "vc_col-12 vc_col-sm-6 vc_col-md-3",
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Bottom", "pt-addons"),
          "param_name" => "bottom",
          "edit_field_class" => "vc_col-12 vc_col-sm-6 vc_col-md-3",
        ),
      )
    );
  }

  public function yprm_decor_elements_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Decor Elements", "pt-addons"),
      "as_parent" => array('only' => 'yprm_decor_elements_item'),
      "base" => "yprm_decor_elements",
      "show_settings_on_create" => false,
      "icon" => "shortcode-icon-decor-elements",
      "js_view" => 'VcColumnView',
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));

    vc_map(array(
      "name" => esc_html__("Decor Elements Item", "pt-addons"),
      "as_child" => array('only' => 'yprm_decor_elements'),
      "base" => "yprm_decor_elements_item",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-decor-elements",
      "params" => self::yprm_vc_map_item_array(),
    ));
  }

  public function yprm_decor_elements_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
        ),
        $atts
      )
    );

    $block_class = $css_code = array();

    $block_class[] = $block_id = 'decor-elements-'.$uniqid;

    do_action('yprm_inline_css', yprm_implode($css_code, ''));

    ob_start();
    ?>
    <div class="decor-elements-block<?php echo yprm_implode($block_class) ?>">
      <?php echo do_shortcode($content); ?>
    </div>
    <?php
    return ob_get_clean();

  }

  public function yprm_decor_elements_item_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'type' => 'type1',
          'align' => 'left',
          'top' => '',
          'bottom' => '',
        ),
        $atts
      )
    );

    $block_class = $css_code = array();

    $block_class[] = $block_id = 'decor-el-'.$uniqid;
    $block_class[] = 'type-'.$type;
    $block_class[] = 'align-'.$align;

    $css_code[] = ".$block_id {
      ".(($top) ? "top: $top;" : "")."
      ".(($bottom) ? "bottom: $bottom;" : "")."
    }";

    if (!empty($css_code)) {
      do_action('yprm_inline_css', yprm_implode($css_code, ''));
    }

    ob_start();
    ?>
    <div class="decor-el<?php echo yprm_implode($block_class) ?>"></div>
    <?php
    return ob_get_clean();

  }

}

new YPRM_Decor_Elements();
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_YPRM_Decor_Elements extends WPBakeryShortCodesContainer {
  }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
  class WPBakeryShortCode_YPRM_Decor_Elements_Item extends WPBakeryShortCode {
  }
}