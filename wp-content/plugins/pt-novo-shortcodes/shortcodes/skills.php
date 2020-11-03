<?php

// Element Description: PT Skills

class PT_Skills_Items extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_skills_mapping'));
    add_shortcode('pt_skills', array($this, 'pt_skills_html'));
  }

  // Element Mapping
  public function pt_skills_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Skills", "novo"),
      "base" => "pt_skills",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-skills",
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Style", "novo"),
          "param_name" => "style",
          "value" => array(
            esc_html__("Line", "novo") => "line",
            esc_html__("Circle", "novo") => "circle",
          ),
          "std" => 'circle',
        ),
        array(
          "type" => "slider",
          "heading" => esc_html__("Skill level", "novo"),
          "param_name" => "skill_level",
          "min" => "0",
          "max" => "100",
          "step" => "1",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "heading",
          "admin_label" => true,
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Description", "novo"),
          "param_name" => "desc",
        ),
        array(
          "type" => "animation_style",
          "heading" => __("Animation In", "novo"),
          "param_name" => "animation",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_skills_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'style' => 'circle',
          'skill_level' => '',
          'heading' => '',
          'desc' => '',
          'animation' => '',
        ),
        $atts
      )
    );

    $html = '';
    $animation = $this->getCSSAnimation($animation);
    if ($skill_level) {
      if ($style == 'circle') {
        $html = '<div class="skill-item ' . esc_attr($animation) . '">';
        $html .= '<figure class="chart" data-percent="' . esc_attr($skill_level) . '">';
        $html .= '<figcaption>' . esc_attr($skill_level) . '%</figcaption>';
        $html .= '<svg width="60" height="60">';
        $html .= '<circle class="outer" cx="160" cy="29" r="28" transform="rotate(-90, 95, 95)"/>';
        $html .= '</svg>';
        $html .= '</figure>';
        if ($heading) {
          $html .= '<h6>' . wp_kses($heading, 'post') . '</h6>';
        }
        if ($desc) {
          $html .= '<p>' . wp_kses($desc, 'post') . '</p>';
        }
        $html .= '</div>';
      } else {
        $html = '<div class="skill-item-line ' . esc_attr($animation) . '">';
        if ($heading) {
          $html .= '<h6>' . wp_kses($heading, 'post') . '</h6>';
        }
        $html .= '<div class="line"><div style="width: ' . esc_attr($skill_level) . '%;"><span>' . esc_html($skill_level) . '%</span></div></div>';
        if ($desc) {
          $html .= '<p>' . wp_kses($desc, 'post') . '</p>';
        }
        $html .= '</div>';
      }
    }

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Skills_Items();