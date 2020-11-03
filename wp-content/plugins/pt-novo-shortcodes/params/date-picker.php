<?php

if (!class_exists('YPRM_Date_Picker_Param')) {
  class YPRM_Date_Picker_Param {
    public function __construct() {
      add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('date_picker', array(&$this, 'date_picker_settings_field'));
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('date_picker', array(&$this, 'date_picker_settings_field'));
        }
      }
    }

    public function admin_scripts($hook) {
      wp_register_script("datetimepicker", plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.datetimepicker.js', array('jquery'));

      if ($hook == "post.php" || $hook == "post-new.php") {
        wp_enqueue_script('datetimepicker');
      }
    }

    public function date_picker_settings_field($settings, $value) {
      $dependency = '';
      $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
      $type = isset($settings['type']) ? $settings['type'] : '';
      $class = isset($settings['class']) ? $settings['class'] : '';
      $uni = uniqid('date-picker');
      $output = '<input data-format="yyyy/MM/dd hh:mm:ss" id="' . esc_attr($uni) . '" type="text" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '" value="' . esc_attr($value) . '" />';
      ?>
      <link rel="stylesheet" href="<?php echo plugins_url('pt-novo-shortcodes') . '/assets/css/jquery.datetimepicker.css' ?>" type="text/css" media="all">
      <script>
          jQuery(document).ready(function(jQuery) {
              jQuery("#<?php echo esc_js($uni) ?>").datepicker({
                dateFormat: 'yy-mm-dd'
              });
          });
      </script>
      <?php
      return $output;
    }

  }
}

if (class_exists('YPRM_Date_Picker_Param')) {
  $YPRM_Date_Picker_Param = new YPRM_Date_Picker_Param();
}