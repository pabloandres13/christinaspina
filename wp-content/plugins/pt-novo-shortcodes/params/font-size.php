<?php

if (!class_exists('YPRM_Param_Font_Size')) {
  class YPRM_Param_Font_Size {
    public function __construct() {
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('font_size', array(&$this, 'font_size_field'), plugins_url('pt-novo-shortcodes') . '/assets/js/param-font-size.js');
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('font_size', array(&$this, 'font_size_field'), plugins_url('pt-novo-shortcodes') . '/assets/js/param-font-size.js');
        }
      }
    }

    public function font_size_field($settings, $value) {
      $param_name = $settings['param_name'];
      $type = $settings['type'];

      ob_start(); ?>
      <div class="font-size-block">
        <div class="vc_param_font_size">
          <div class="input-col" data-type="xs" data-size="px">
            <i class="fas fa-mobile" title="Extra small <576px"></i>
            <input type="number" min="0">
            <div class="switch">
              <span class="current"><?php echo esc_html__('px', 'pt-addons') ?></span>
              <span><?php echo esc_html__('em', 'pt-addons') ?></span>
            </div>
          </div>
          <div class="input-col" data-type="sm" data-size="px">
            <i class="fas fa-mobile-alt" title="Small ≥576px"></i>
            <input type="number" min="0">
            <div class="switch">
              <span class="current"><?php echo esc_html__('px', 'pt-addons') ?></span>
              <span><?php echo esc_html__('em', 'pt-addons') ?></span>
            </div>
          </div>
          <div class="input-col" data-type="md" data-size="px">
            <i class="fas fa-tablet-alt" title="Medium ≥768px"></i>
            <input type="number" min="0">
            <div class="switch">
              <span class="current"><?php echo esc_html__('px', 'pt-addons') ?></span>
              <span><?php echo esc_html__('em', 'pt-addons') ?></span>
            </div>
          </div>
          <div class="input-col" data-type="lg" data-size="px">
            <i class="fas fa-laptop" title="Large ≥992px"></i>
            <input type="number" min="0">
            <div class="switch">
              <span class="current"><?php echo esc_html__('px', 'pt-addons') ?></span>
              <span><?php echo esc_html__('em', 'pt-addons') ?></span>
            </div>
          </div>
          <div class="input-col" data-type="xl" data-size="px">
            <i class="fas fa-desktop" title="Extra large ≥1200px"></i>
            <input type="number" min="0">
            <div class="switch">
              <span class="current"><?php echo esc_html__('px', 'pt-addons') ?></span>
              <span><?php echo esc_html__('em', 'pt-addons') ?></span>
            </div>
          </div>
        </div>
        <input type="hidden" name="<?php echo esc_attr( $param_name ) ?>" class="wpb_vc_param_value wpb-textinput <?php echo esc_attr( $param_name.' '.$type ) ?>_field" value="<?php echo esc_attr($value) ?>">
      </div>
      <?php return ob_get_clean();
    }

  }
}

if (class_exists('YPRM_Param_Font_Size')) {
  $YPRM_Param_Font_Size = new YPRM_Param_Font_Size();
}