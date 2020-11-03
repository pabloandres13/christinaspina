<?php

// Element Name: Button

class YPRM_Button {

  public function __construct() {
    add_action('init', array($this, 'yprm_button_mapping'));
    add_shortcode('yprm_button', array($this, 'yprm_button_html'));
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Align", "pt-addons"),
          "param_name" => "align",
          "value" => array(
            esc_html__("Left", "pt-addons") => "left",
            esc_html__("Center", "pt-addons") => "center",
            esc_html__("Right", "pt-addons") => "right",
          ),
          "std" => "left",
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Style", "pt-addons"),
          "param_name" => "style",
          "value" => array(
            esc_html__("Button", "pt-addons") => "style1",
            esc_html__("Link", "pt-addons") => "style2",
          ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Rounding", "pt-addons"),
          "param_name" => "rounding",
          "value" => array(
            esc_html__("None", "pt-addons") => "none",
            esc_html__("Small", "pt-addons") => "small",
            esc_html__("Medium", "pt-addons") => "medium",
            esc_html__("Big", "pt-addons") => "big",
          ),
          "std" => "val1",
          "dependency" => Array("element" => "style", "value" => "style1" ),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Fill", "pt-addons"),
          "param_name" => "fill",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "dependency" => Array("element" => "style", "value" => "style1" ),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "pt-addons"),
          "param_name" => "link",
          "admin_label" => true
        ),
       /*  array(
          "type" => "heading",
          "heading" => esc_html__("Colors", "pt-addons"),
          "param_name" => "h_color",
          "dependency" => Array("element" => "color", "value" => "custom" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Background", "pt-addons"),
          "param_name" => "bg_hex",
          "dependency" => Array("element" => "color", "value" => "custom" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Text", "pt-addons"),
          "param_name" => "text_hex",
          "dependency" => Array("element" => "color", "value" => "custom" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "heading",
          "heading" => esc_html__("Colors On Hover", "pt-addons"),
          "param_name" => "h_color_hover",
          "dependency" => Array("element" => "color", "value" => "custom" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Background", "pt-addons"),
          "param_name" => "bg_hover_hex",
          "dependency" => Array("element" => "color", "value" => "custom" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Text", "pt-addons"),
          "param_name" => "text_hover_hex",
          "dependency" => Array("element" => "color", "value" => "custom" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ), */
        yprm_add_css_animation(),
        array(
          "type" => "css_editor",
          "heading" => esc_html__("CSS box", "pt-addons"),
          "param_name" => "css",
          "edit_field_class" => "simple",
          "group" => esc_html__("Design Options", "pt-addons"),
        ),
      )
    );
  }

  public function yprm_button_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Button", "pt-addons"),
      "base" => "yprm_button",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-button",
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));
  }

  public function yprm_button_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'align' => 'left',
          'style' => 'style1',
          'rounding' => 'none',
          'fill' => 'off',
          'link' => '',
          'bg_hex' => '',
          'text_hex' => '',
          'bg_hover_hex' => '',
          'text_hover_hex' => '',
          'css_animation' => '',
          'css' => '',
        ),
        $atts
      )
    );

    $css_code = $block_class = $button_class = array();

    $block_class[] = $block_id = 'button-' . $uniqid;
    
    $block_class[] = $align;

    $button_class[] = 'button-'.$style;

    if($rounding != 'none') {
      $button_class[] = 'round-'.$rounding;
    }

    if($fill == 'on') {
      $button_class[] = 'fill';
    }

    if (!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if (!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    if (!empty($css_code)) {
      do_action('yprm_inline_css', yprm_implode($css_code, ''));
    }

    ob_start();
    if($button = yprm_vc_link($link, '_self', esc_html__('Button Label', 'pt-addons'))) { ?>
      <div class="button-container<?php echo yprm_implode($block_class) ?>">
        <a class="<?php echo yprm_implode($button_class, '') ?>" href="<?php echo esc_url($button['url']) ?>" target="<?php echo esc_attr($button['target']) ?>">
          <span><?php echo strip_tags($button['title']) ?></span>
        </a>
      </div>
    <?php }
    return ob_get_clean();

  }

}

new YPRM_Button();