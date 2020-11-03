<?php

if (!class_exists('YPRM_Switch_Param')) {
  class YPRM_Switch_Param {
    public function __construct() {
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('switch', array($this, 'checkbox_param'));
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('switch', array($this, 'checkbox_param'));
        }
      }
    }

    public function checkbox_param($settings, $value) {
      $dependency = '';
      $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
      $type = isset($settings['type']) ? $settings['type'] : '';
      $options = isset($settings['options']) ? $settings['options'] : '';
      $class = isset($settings['class']) ? $settings['class'] : '';
      $default_set = isset($settings['default_set']) ? $settings['default_set'] : false;
      $output = $checked = '';
      $un = uniqid('switch-' . rand());
      if (is_array($options) && !empty($options)) {
        foreach ($options as $key => $opts) {
          if ($value == $key) {
            $checked = "checked";
          } else {
            $checked = "";
          }
          $uid = uniqid('switchparam-' . rand());
          $output .= '<div class="checkbox-switch">
                            <input type="checkbox" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" ' . $dependency . ' class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . ' ' . esc_attr($dependency) . ' checkbox-switch-checkbox chk-switch-' . esc_attr($un) . '" id="switch' . esc_attr($uid) . '" ' . $checked . '>
                            <label class="checkbox-switch-label" for="switch' . esc_attr($uid) . '">
                                <div class="checkbox-switch-inner">
                                    <div class="checkbox-switch-active">
                                        <div class="checkbox-switch-switch">' . esc_html($opts['on']) . '</div>
                                    </div>
                                    <div class="checkbox-switch-inactive">
                                        <div class="checkbox-switch-switch">' . esc_html($opts['off']) . '</div>
                                    </div>
                                </div>
                            </label>
                        </div>';
          if (isset($opts['label'])) {
            $lbl = $opts['label'];
          } else {
            $lbl = '';
          }

          $output .= '<div class="chk-label">' . $lbl . '</div><br/>';
        }
      }

      if ($default_set) {
        $set_value = 'off';
      } else {
        $set_value = '';
      }

      $output .= '<script type="text/javascript">
                jQuery("#switch' . esc_attr($uid) . '").change(function(){

                     if(jQuery("#switch' . esc_attr($uid) . '").is(":checked")){
                        jQuery("#switch' . esc_attr($uid) . '").val("' . esc_attr($key) . '");
                        jQuery("#switch' . esc_attr($uid) . '").attr("checked","checked");
                     } else {
                        jQuery("#switch' . esc_attr($uid) . '").val("' . esc_attr($set_value) . '");
                        jQuery("#switch' . esc_attr($uid) . '").removeAttr("checked");
                     }

                });
            </script>';

      return $output;
    }

  }
}

if (class_exists('YPRM_Switch_Param')) {
  $YPRM_Switch_Param = new YPRM_Switch_Param();
}