<?php

if (!class_exists('YPRM_Param_Heading')) {
  class YPRM_Param_Heading {
    public function __construct() {
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('heading', array(&$this, 'heading_settings_field'));
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('heading', array(&$this, 'heading_settings_field'));
        }
      }
    }

    public function heading_settings_field($settings, $value) {
      $dependency = '';
      $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
      $type = isset($settings['type']) ? $settings['type'] : '';
      $class = isset($settings['class']) ? $settings['class'] : '';
      $heading_value = isset($settings['heading_value']) ? $settings['heading_value'] : '';
      
      $output = '<div class="vc_heading '.$settings['param_name'].' wpb_vc_param_value">'.wp_kses_post($heading_value).'</div><input type="hidden" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" />';
      return $output;
    }

  }
}

if (class_exists('YPRM_Param_Heading')) {
  $YPRM_Param_Heading = new YPRM_Param_Heading();
}