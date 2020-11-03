<?php

// Element Name: PT Side Img

class YPRM_Side_Img {

  public function __construct() {
    add_action('init', array($this, 'yprm_side_img_mapping'));
    add_shortcode('yprm_side_img', array($this, 'yprm_side_img_html'));
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Image", "pt-addons"),
          "param_name" => "image",
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Style", "pt-addons"),
          "param_name" => "style",
          "value" => array(
            esc_html__("Square", "pt-addons") => "square",
            esc_html__("Circle", "pt-addons") => "circle",
          ),
          "std" => "circle",
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
          "heading" => esc_html__("Max Width", "pt-addons"),
          "param_name" => "max_width",
          "description" => wp_kses_post(__("Examples: 20px or 2em or 120%", "pt-addons")),
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

  public function yprm_side_img_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Side Img", "pt-addons"),
      "base" => "yprm_side_img",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-side-img",
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));
  }

  public function yprm_side_img_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'image' => '',
          'align' => 'left',
          'style' => 'circle',
          'max_width' => '',
          'css_animation' => '',
          'css' => '',
        ),
        $atts
      )
    );

    $css_code = $block_class = array();

    $block_class[] = $block_id = 'side-img-' . $uniqid;
    $block_class[] = 'style-'.$style;
    $block_class[] = 'align-'.$align;

    if(!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    if ($max_width) {
      $css_code[] = ".$block_id {
        max-width: $max_width;
      }";
    }

    if (!empty($css_code)) {
      do_action('yprm_inline_css', yprm_implode($css_code, ''));
    }

    ob_start();

    if($bg = yprm_get_image($image, 'bg')) { ?>
    <div class="side-img<?php echo esc_attr(yprm_implode($block_class)) ?>">
      <div style="<?php echo esc_attr($bg) ?>"></div>
    </div>
    <?php }
    return ob_get_clean();

  }

}

new YPRM_Side_Img();