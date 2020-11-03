<?php

// Element Name: Icon Box 

$global_array = array();

class YPRM_Icon_Box {

  public function __construct() {
    add_action('init', array($this, 'yprm_icon_box_mapping'));
    add_shortcode( 'yprm_icon_box', array( $this, 'yprm_icon_box_html' ) );
    add_shortcode( 'yprm_icon_box_item', array( $this, 'yprm_icon_box_item_html' ) );
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "cols",
          "heading" => esc_html__("Cols", "pt-addons"),
          "param_name" => "cols",
          "value" => "xs:1,md:3"
        ),
        yprm_add_css_animation(),
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
      ),
      yprm_vc_icons(),
      array(
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Description", "pt-addons"),
          "param_name" => "desc",
        ),
        yprm_add_css_animation(),
      )
    );
  }

  public function yprm_icon_box_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Icon Box", "pt-addons"),
      "as_parent" => array('only' => 'yprm_icon_box_item'),
      "base" => "yprm_icon_box",
      "show_settings_on_create" => true,
      "is_container" => true,
      "icon" => "shortcode-icon-icon-box",
      "js_view" => 'VcColumnView',
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));

    vc_map(array(
      "name" => esc_html__("Icon Box Item", "pt-addons"),
      "as_child" => array('only' => 'yprm_icon_box'),
      "base" => "yprm_icon_box_item",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-icon-box",
      "params" => self::yprm_vc_map_item_array(),
    ));
  }

  public function yprm_icon_box_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => '',
          'cols' => 'xs:1,md:3',
          'css_animation' => '',
          'css' => '',
        ),
        $atts
      )
    );

    global $global_array;
    $global_array['cols'] = yprm_parce_cols($cols);

    $css_code = $block_class = array();

    $block_class[] = $block_id = 'icon-box-block-'.$uniqid;

    if(!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    ob_start();
    ?>
    <div class="icon-box-block<?php echo yprm_implode($block_class) ?> row">
      <?php echo do_shortcode($content); ?>
    </div>
    <?php
    return ob_get_clean();

  }

  public function yprm_icon_box_item_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'type' => '',
          'icon_yprm_icons' => 'base-icon-avatar',
          'icon_fontawesome' => 'fa fa-adjust',
          'icon_openiconic' => 'vc-oi vc-oi-dial',
          'icon_typicons' => 'typcn typcn-adjust-brightness',
          'icon_entypo' => 'entypo-icon entypo-icon-note',
          'icon_linecons' => 'vc_li vc_li-heart',
          'icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
          'icon_material' => 'vc-material vc-material-cake',
          'heading' => '',
          'desc' => '',
          'link' => '',
          'css_animation' => ''
        ),
        $atts
      )
    );

    global $global_array;

    $block_class = array();

    $block_class[] = $block_id = 'icon-box-style-'.$uniqid;

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }
    
    if($type) {
      $icon = 'icon_'.$type;

      vc_icon_element_fonts_enqueue($type);
    }

    ob_start();
    ?>
    <div class="<?php echo esc_attr($global_array['cols']) ?>">
      <div class="icon-box<?php echo yprm_implode($block_class) ?>">
        <?php if($link_array = yprm_vc_link($link)) { ?>
          <a href="<?php echo esc_url($link_array['url']) ?>" target="<?php echo esc_attr($link_array['target']) ?>"></a>
        <?php } if(!empty($type)) { ?>
          <div class="icon"><i class="<?php echo esc_attr($$icon) ?>"></i></div>
        <?php } if(!empty($heading)) { ?>
          <h5 class="title"><?php echo strip_tags($heading) ?></h5>
        <?php } if(!empty($desc)) { ?>
          <div class="desc"><?php echo strip_tags($desc) ?></div>
        <?php } ?>
      </div>
    </div>
    <?php
    return ob_get_clean();

  }

}

new YPRM_Icon_Box();
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_YPRM_Icon_Box extends WPBakeryShortCodesContainer {
  }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
  class WPBakeryShortCode_YPRM_Icon_Box_Item extends WPBakeryShortCode {
  }
}