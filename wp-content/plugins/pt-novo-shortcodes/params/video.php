<?php

if (!class_exists('YPRM_Video_Param')) {
  class YPRM_Video_Param {
    public function __construct() {
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('video', array(&$this, 'video_settings_field'));
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('video', array(&$this, 'video_settings_field'));
        }
      }
    }

    public function video_settings_field($settings, $value) {
      $dependency = '';
      $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
      $type = isset($settings['type']) ? $settings['type'] : '';
      $class = isset($settings['class']) ? $settings['class'] : '';
      $uni = uniqid('video');
      //$value = htmlentities($value, ENT_QUOTES, 'utf-8');

      $output = '<div class="video-attachment-block" id="' . esc_attr($uni) . '">
          <button type="button" class="button" data-media-uploader-target="' . esc_attr($uni) . '">' . esc_html__('Upload Media', 'pt-addons') . '</button>
          <input type="text" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" />
      </div>';

      return $output;
    }

  }
}

if (class_exists('YPRM_Video_Param')) {
  $YPRM_Video_Param = new YPRM_Video_Param();
}