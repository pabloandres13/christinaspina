<?php

// Element Name: Heading

class YPRM_Heading {

  public function __construct() {
    add_action('init', array($this, 'yprm_heading_mapping'));
    add_shortcode('yprm_heading', array($this, 'yprm_heading_html'));
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Sub Heading", "pt-addons"),
          "param_name" => "sub_heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading",
          "admin_label" => true,
          "description" => wp_kses_post(__("Wrap the text in { } if you want the text to be another color.<br>Example: Minds your work {level}", "pt-addons")),
        ),
        yprm_add_css_animation(),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Content Align", "pt-addons"),
          "param_name" => "content_aling",
          "value" => array(
            esc_html__("Left", "pt-addons") => "tal",
            esc_html__("Center", "pt-addons") => "tac",
            esc_html__("Right", "pt-addons") => "tar",
          ),
          "std" => "tal",
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Heading Size", "pt-addons"),
          "param_name" => "heading_size",
          "value" => array(
            esc_html__("H1", "pt-addons") => "h1",
            esc_html__("H2", "pt-addons") => "h2",
            esc_html__("H3", "pt-addons") => "h3",
            esc_html__("H4", "pt-addons") => "h4",
            esc_html__("H5", "pt-addons") => "h5",
            esc_html__("H6", "pt-addons") => "h6",
          ),
          "group" => esc_html__("Customizing", "pt-addons"),
          "std" => "h2",
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Decor", "pt-addons"),
          "param_name" => "decor_type",
          "value" => array(
            esc_html__("None", "pt-addons") => "",
            esc_html__("Bottom Line", "pt-addons") => "bottom-line",
          ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Custom Font Family", "pt-addons"),
          "param_name" => "custom_font_family",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          'type' => 'google_fonts',
          'param_name' => 'google_fonts',
          'value' => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
          'settings' => array(
            'fields' => array(
              'font_family_description' => esc_html__( 'Select font family.', 'pt-addons' ),
              'font_style_description' => esc_html__( 'Select font styling.', 'pt-addons' ),
            ),
          ),
          "dependency" => Array("element" => "custom_font_family", "value" => "on" ),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "heading",
          "heading_value" => esc_html__("Font Sizing", "pt-addons"),
          "param_name" => "h_font_sizing",
          "description" => wp_kses_post(__("Examples: 20px or 2em or 120%", "pt-addons")),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "font_size",
          "heading" => esc_html__("Sub Heading", "pt-addons"),
          "param_name" => "sub_heading_fs",
          "group" => esc_html__("Customizing", "pt-addons"),
          "dependency" => Array("element" => "sub_heading", "not_empty" => true),
        ),
        array(
          "type" => "font_size",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading_fs",
          "group" => esc_html__("Customizing", "pt-addons"),
          "dependency" => Array("element" => "heading", "not_empty" => true),
        ),
        array(
          "type" => "heading",
          "heading_value" => esc_html__("Colors", "pt-addons"),
          "param_name" => "h_colors",
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Sub Heading", "pt-addons"),
          "param_name" => "sub_heading_hex",
          "edit_field_class" => "vc_col-auto",
          "group" => esc_html__("Customizing", "pt-addons"),
          "dependency" => Array("element" => "sub_heading", "not_empty" => true),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading_hex",
          "edit_field_class" => "vc_col-auto",
          "group" => esc_html__("Customizing", "pt-addons"),
          "dependency" => Array("element" => "heading", "not_empty" => true),
        ),
        array(
          "type" => "heading",
          "heading_value" => esc_html__("Line Height", "pt-addons"),
          "param_name" => "h_line_height",
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Sub Heading", "pt-addons"),
          "param_name" => "sub_heading_lh",
          "group" => esc_html__("Customizing", "pt-addons"),
          "dependency" => Array("element" => "sub_heading", "not_empty" => true),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Heading", "pt-addons"),
          "param_name" => "heading_lh",
          "group" => esc_html__("Customizing", "pt-addons"),
          "dependency" => Array("element" => "heading", "not_empty" => true),
        ),
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

  public function yprm_heading_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Heading", "pt-addons"),
      "base" => "yprm_heading",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-heading",
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));
  }

  public function yprm_heading_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => '',
          'sub_heading' => '',
          'heading' => '',
          'css_animation' => '',
          'content_aling' => 'tal',
          'heading_size' => 'h2',
          'decor_type' => '',
          'accent_words' => '',
          'custom_font_family' => 'off',
          'google_fonts' => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
          'sub_heading_fs' => '',
          'heading_fs' => '',
          'sub_heading_hex' => '',
          'heading_hex' => '',
          'sub_heading_lh' => '',
          'heading_lh' => '',
          'css' => '',
        ),
        $atts
      )
    );

    $css_code = $block_class = array();

    $block_class[] = $block_id = 'heading-' . $uniqid;
    
    $block_class[] = $content_aling;
    $block_class[] = 'h-'.$heading_size;

    if($decor_type == 'dots') {
      $block_class[] = 'with-dots';
    } else if($decor_type == 'bottom-line') {
      $block_class[] = 'with-line';
    }

    if($accent_words == 'filled-text') {
      $block_class[] = 'type-accent';
    }

    if (!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if (!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    if($custom_font_family == 'on' && $google_font_array = yprm_parse_google_font($google_fonts)) {
      $css_code[] = ".$block_id .h {
        font-family: ".$google_font_array['font_family'].";
        font-weight: ".$google_font_array['font_weight'].";
      }";
    }

    if (!empty($sub_heading_fs)) {
      $css_code[] = yprm_build_font_size(".$block_id .sub-h", $sub_heading_fs);
    }
    if (!empty($heading_fs)) {
      $css_code[] = yprm_build_font_size(".$block_id .h", $heading_fs);
    }

    if (!empty($sub_heading_hex)) {
      $css_code[] = ".$block_id .sub-h { color: $sub_heading_hex; }";
    }
    if (!empty($heading_hex)) {
      $css_code[] = ".$block_id .h { color: $heading_hex; }";
    }

    if (!empty($sub_heading_lh)) {
      $css_code[] = ".$block_id .sub-h { line-height: $sub_heading_lh; }";
    }
    if (!empty($heading_lh)) {
      $css_code[] = ".$block_id .h { line-height: $heading_lh; }";
    }

    if (!empty($css_code)) {
      do_action('yprm_inline_css', yprm_implode($css_code, ''));
    }

    ob_start();
    ?>
      <div class="heading-block<?php echo yprm_implode($block_class) ?>">
        <?php if (!empty($sub_heading)) { ?>
          <div class="sub-h"><?php echo wp_kses_post($sub_heading); ?></div>
        <?php }if (!empty($heading)) { ?>
          <<?php echo $heading_size; ?> class="h"><?php echo yprm_heading_filter($heading); ?></<?php echo $heading_size; ?>>
        <?php } ?>
      </div>
    <?php
    return ob_get_clean();

  }

}

new YPRM_Heading();