<?php

// Element Name: PT Num Box

$global_array = array();

class YPRM_Num_Box {

  public function __construct() {
    add_action('init', array($this, 'yprm_num_box_mapping'));
    add_shortcode( 'yprm_num_box', array( $this, 'yprm_num_box_html' ) );
    add_shortcode( 'yprm_num_box_item', array( $this, 'yprm_num_box_item_html' ) );
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        yprm_vc_cols(),
        array(
          "type" => "css_editor",
          "heading" => esc_html__("CSS box", "pt-addons"),
          "param_name" => "css",
          "edit_field_class" => "simple",
          "group" => esc_html__( "Design Options", "pt-addons" ),
        ),
      )
    );
  }

  public function yprm_vc_map_item_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "number",
          "heading" => esc_html__("Num", "pt-addons"),
          "param_name" => "num",
          "edit_field_class" => "vc_col-auto",
          "admin_label" => true,
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Suffix", "pt-addons"),
          "param_name" => "suffix",
          "edit_field_class" => "vc_col-auto",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        yprm_add_css_animation(),
      )
    );
  }

  public function yprm_num_box_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Num Box", "pt-addons"),
      "as_parent" => array('only' => 'yprm_num_box_item'),
      "base" => "yprm_num_box",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-num-box",
      "js_view" => 'VcColumnView',
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));

    vc_map(array(
      "name" => esc_html__("Num Box Item", "pt-addons"),
      "as_child" => array('only' => 'yprm_num_box'),
      "base" => "yprm_num_box_item",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-num-box",
      "params" => self::yprm_vc_map_item_array(),
    ));
  }

  public function yprm_num_box_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => '',
          'cols' => '',
          'css' => '',
        ),
        $atts
      )
    );

    global $global_array;
    $global_array['cols'] = yprm_parce_cols($cols);

    $block_class = array();

    $block_class[] = $block_id = 'num-box-'.$uniqid;

    if(!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    ob_start();
    ?>
    <div class="num-box-items<?php echo yprm_implode($block_class) ?> row">
      <?php echo do_shortcode($content); ?>
    </div>
    <?php
    return ob_get_clean();

  }

  public function yprm_num_box_item_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'num' => '',
          'suffix' => '',
          'heading' => '',
          'css_animation' => '',
        ),
        $atts
      )
    );

    if(empty($num)) return;

    global $global_array;

    $block_class = array();

    $block_class[] = $block_id = 'num-box-item-'.$uniqid;

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    ob_start();
    ?>
    <div class="<?php echo esc_attr($global_array['cols']) ?>">
      <div class="num-box<?php echo yprm_implode($block_class) ?>">
        <div class="num">
          <span><?php echo strip_tags($num) ?></span>
          <?php if(!empty($suffix)) { ?>
            <em><?php echo strip_tags($suffix) ?></em>
          <?php } ?>
        </div>
        <?php if(!empty($heading)) { ?>
          <div class="title"><?php echo wp_kses_post($heading) ?></div>
        <?php } ?>
      </div>
    </div>
    <?php
    return ob_get_clean();

  }

}

new YPRM_Num_Box();
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_YPRM_Num_Box extends WPBakeryShortCodesContainer {
  }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
  class WPBakeryShortCode_YPRM_Num_Box_Item extends WPBakeryShortCode {
  }
}