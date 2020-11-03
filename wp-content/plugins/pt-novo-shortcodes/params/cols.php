<?php

if (!class_exists('YPRM_Param_Cols')) {
  class YPRM_Param_Cols {
    public function __construct() {
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('cols', array(&$this, 'heading_settings_field'));
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('cols', array(&$this, 'heading_settings_field'));
        }
      }
    }

    public function heading_settings_field($settings, $value) {
      $dependency = '';
      $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
      $type = isset($settings['type']) ? $settings['type'] : '';
      $class = isset($settings['class']) ? $settings['class'] : '';
      $mode = isset($settings['mode']) ? $settings['mode'] : '';
      $values = array();

      if(yprm_parce_cols($value)) {
        $values = yprm_parce_cols($value, 'array');
      }
      
      $output = '<div class="vc_param_cols '.$settings['param_name'].' '.$mode.' wpb_vc_param_value">
        <div class="input-col" data-type="xs"><i class="fas fa-mobile" title="'.esc_html__('Extra small <576px', 'pt-addons').'"></i><input type="number" min="1" max="4" value="'.((isset($values['xs']) ? $values['xs'] : '')).'"></div>
        <div class="input-col" data-type="sm"><i class="fas fa-mobile-alt" title="'.esc_html__('Small ≥576px', 'pt-addons').'"></i><input type="number" min="1" max="4" value="'.((isset($values['sm']) ? $values['sm'] : '')).'"></div>
        <div class="input-col" data-type="md"><i class="fas fa-tablet-alt" title="'.esc_html__('Medium ≥768px', 'pt-addons').'"></i><input type="number" min="1" max="4" value="'.((isset($values['md']) ? $values['md'] : '')).'"></div>
        <div class="input-col" data-type="lg"><i class="fas fa-laptop" title="'.esc_html__('Large ≥992px', 'pt-addons').'"></i><input type="number" min="1" max="4" value="'.((isset($values['lg']) ? $values['lg'] : '')).'"></div>
        <div class="input-col" data-type="xl"><i class="fas fa-desktop" title="'.esc_html__('Extra large ≥1200px', 'pt-addons').'"></i><input type="number" min="1" max="4" value="'.((isset($values['xl']) ? $values['xl'] : '')).'"></div>
      </div>
      <input type="hidden" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" />';
      return $output;
    }

  }
}

if (class_exists('YPRM_Param_Cols')) {
  $YPRM_Param_Cols = new YPRM_Param_Cols();
}