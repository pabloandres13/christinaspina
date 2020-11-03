<?php

if (!class_exists('YPRM_Param_CSS_Editor')) {
  class YPRM_Param_CSS_Editor {
    public function __construct() {
      wp_enqueue_script( 'wp-color-picker' );
      wp_enqueue_style( 'wp-color-picker' );
  
      if (defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
        if (function_exists('vc_add_shortcode_param')) {
          vc_add_shortcode_param('yprm_css_editor', array(&$this, 'css_editor'), plugins_url('pt-novo-shortcodes') . '/assets/js/param-css-editor.js');
        }
      } else {
        if (function_exists('add_shortcode_param')) {
          add_shortcode_param('yprm_css_editor', array(&$this, 'css_editor'), plugins_url('pt-novo-shortcodes') . '/assets/js/param-css-editor.js');
        }
      }
    }

    public function render($tab_item, $index) {
      $position_array = array('top','right','bottom','left');
      $position_br_array = array('top-left','top-right','bottom-left','bottom-right');
      ?>
      <div class="yprm-content<?php echo ($index == 1) ? ' current' : ''; ?>" data-screen="<?php echo esc_attr($tab_item); ?>">
        <div class="yprm-offsets-table">
          <div class="yprm-property" data-property="margin">
            <div class="title"><?php echo esc_html__('Margin', 'pt-addons') ?></div>
            <?php foreach($position_array as $input) { ?>
              <input type="text" class="input <?php echo esc_attr($input) ?>" name="margin-<?php echo esc_attr($input) ?>" placeholder="-">
            <?php } ?>
          </div>
          <div class="yprm-property" data-property="border">
            <div class="title"><?php echo esc_html__('Border', 'pt-addons') ?></div>
            <?php foreach($position_array as $input) { ?>
              <input type="text" class="input <?php echo esc_attr($input) ?>" name="border-<?php echo esc_attr($input) ?>-width" placeholder="-">
            <?php } foreach($position_br_array as $input) { ?>
              <input type="text" class="input <?php echo esc_attr($input) ?>" name="border-<?php echo esc_attr($input) ?>-radius" placeholder="-">
            <?php } ?>
          </div>
          <div class="yprm-property" data-property="padding">
            <div class="title"><?php echo esc_html__('Padding', 'pt-addons') ?></div>
            <?php foreach($position_array as $input) { ?>
              <input type="text" class="input <?php echo esc_attr($input) ?>" name="padding-<?php echo esc_attr($input) ?>" placeholder="-">
            <?php } ?>
          </div>
        </div>
        <div class="yprm-right-col">
          <div class="yprm-input-row">
            <label><?php echo esc_html__('Border Style', 'pt-addons') ?></label>
            <select type="text" class="yprm-input" name="border-style">
              <option value=""><?php echo esc_html__('inherit', 'pt-addons') ?></option>
              <option value="none"><?php echo esc_html__('none', 'pt-addons') ?></option>
              <option value="hidden"><?php echo esc_html__('hidden', 'pt-addons') ?></option>
              <option value="dotted"><?php echo esc_html__('dotted', 'pt-addons') ?></option>
              <option value="dashed"><?php echo esc_html__('dashed', 'pt-addons') ?></option>
              <option value="solid"><?php echo esc_html__('solid', 'pt-addons') ?></option>
              <option value="double"><?php echo esc_html__('double', 'pt-addons') ?></option>
              <option value="groove"><?php echo esc_html__('groove', 'pt-addons') ?></option>
              <option value="ridge"><?php echo esc_html__('ridge', 'pt-addons') ?></option>
              <option value="inset"><?php echo esc_html__('inset', 'pt-addons') ?></option>
              <option value="outset"><?php echo esc_html__('outset', 'pt-addons') ?></option>
            </select>
          </div>
          <div class="yprm-input-row inline">
            <label><?php echo esc_html__('Custom Z-Index', 'pt-addons') ?></label>
            <input type="text" class="yprm-input" name="z-index" placeholder="-">
          </div>
        </div>
      </div>
      <?php
    }

    public function css_editor($settings, $value) {
      $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
      $type = isset($settings['type']) ? $settings['type'] : '';
      $screen_array = array('mobile_portrait','mobile_landscape','tablet_portrait','tablet_landscape','desktop');
      
      ob_start(); ?>
      <div class="yprm-css-editor">
        <div class="yprm-tabs-head">
          <div class="tab-item" title="<?php echo esc_html__('Extra small <576px', 'pt-addons') ?>"><i class="fas fa-mobile"></i></div>
          <div class="tab-item current" title="<?php echo esc_html__('Small ≥576px', 'pt-addons') ?>"><i class="fas fa-mobile-alt"></i></div>
          <div class="tab-item" title="<?php echo esc_html__('Medium ≥768px', 'pt-addons') ?>"><i class="fas fa-tablet-alt"></i></div>
          <div class="tab-item" title="<?php echo esc_html__('Large ≥992px', 'pt-addons') ?>"><i class="fas fa-laptop"></i></div>
          <div class="tab-item" title="<?php echo esc_html__('Extra large ≥1200px', 'pt-addons') ?>"><i class="fas fa-desktop"></i></div>
        </div>
        <div class="yprm-tabs-body">
          <?php foreach($screen_array as $index => $tab_item) {
            echo $this->render($tab_item, $index);
          } ?>
        </div>
        <input type="hidden" name="<?php echo esc_attr( $param_name ) ?>" class="wpb_vc_param_value wpb-textinput <?php echo esc_attr( $param_name.' '.$type ) ?>_field" value="<?php echo esc_attr($value) ?>">
      </div>
      <?php return ob_get_clean();
    }

  }
}

if (class_exists('YPRM_Param_CSS_Editor')) {
  $YPRM_Param_CSS_Editor = new YPRM_Param_CSS_Editor();
}