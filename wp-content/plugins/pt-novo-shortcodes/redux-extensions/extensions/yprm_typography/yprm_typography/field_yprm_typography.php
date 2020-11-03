<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

// Don't duplicate me!
if (!class_exists('ReduxFramework_yprm_typography')) {

  /**
   * Main ReduxFramework_yprm_typography class
   *
   * @since       1.0.0
   */
  class ReduxFramework_yprm_typography {

    /**
     * Field Constructor.
     *
     * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
     *
     * @since       1.0.0
     * @access      public
     * @return      void
     */
    public function __construct($field = array(), $value = '', $parent) {

      $this->parent = $parent;
      $this->field = $field;
      $this->value = $value;
      if(isset($this->field['name'])) {
        $this->name = $this->field['name'];
      }

      if (empty($this->extension_dir)) {
        $this->extension_dir = trailingslashit(str_replace('\\', '/', dirname(__FILE__)));
        $this->extension_url = site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', $this->extension_dir));
      }

      // Set default args for this field to avoid bad indexes. Change this to anything you use.
      $defaults = array(
        'options' => array(),
        'letter-spacing' => '',
        'line-height' => '',
        'stylesheet' => '',
        'output' => true,
        'enqueue' => true,
        'enqueue_frontend' => true,
      );
      $this->field = wp_parse_args($this->field, $defaults);

      $value_defaults = array(
        'family' => '',
        'backup-family' => '',
        'weight' => '',
        'text-transform' => '',
        'subsets' => '',
        'font-size' => '',
        'letter-spacing' => '',
        'line-height' => '',
      );
      $value_defaults = wp_parse_args($this->field['default'], $value_defaults);
      $this->value = wp_parse_args($this->value, $value_defaults);
    }

    public function default_font_family() {
      return array(
        "Arial, Helvetica, sans-serif",
        "'Arial Black', Gadget, sans-serif",
        "'Bookman Old Style', serif",
        "'Comic Sans MS', cursive",
        "Courier, monospace",
        "Garamond, serif",
        "Georgia, serif",
        "Impact, Charcoal, sans-serif",
        "'Lucida Console', Monaco, monospace",
        "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
        "'MS Sans Serif', Geneva, sans-serif",
        "'MS Serif', 'New York', sans-serif",
        "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
        "Tahoma, Geneva, sans-serif",
        "'Times New Roman', Times, serif",
        "'Trebuchet MS', Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif",
      );
    }

    public function render_num_unit($name) {
      ?>
      <div class="yprm-num-units-block">
        <input type="hidden" name="<?php echo $this->name.'['.$name.']' ?>" value="<?php echo esc_attr($this->value[$name]) ?>">
        <input class="input" type="number" min="0" value="<?php echo str_replace(array('px', 'em'), '', $this->value[$name]) ?>">
        <div class="num-units">
          <div class="num-unit<?php echo strpos($this->value[$name], 'px') === false || empty($this->value[$name]) ? '' : ' current'; ?>" data-unit="px"><?php echo esc_html__('px', 'pt-addons') ?></div>
          <div class="num-unit<?php echo strpos($this->value[$name], 'em') === false ? '' : ' current'; ?>" data-unit="em"><?php echo esc_html__('em', 'pt-addons') ?></div>
        </div>
      </div>
      <?php
    }

    /**
     * Field Render Function.
     *
     * Takes the vars and outputs the HTML for the field in the settings
     *
     * @since       1.0.0
     * @access      public
     * @return      void
     */
    public function render() {
      if(!isset($this->parent->options['custom_fonts']['fonts'])) {
        $json = '{}';
      } else {
        $json = $this->parent->options['custom_fonts']['fonts'];
      }
      $fonts_array = (object) json_decode('['.$json.']');
      $value = $this->value;
      $current_font = array();
      $has_font = !empty($this->value['family']) && $this->value['family'] != 'inherit';
      ?>
      <div class="yprm-typography-block">
        <div class="row">
          <div class="item col-6">
            <label><?php echo esc_html__('Font Family', 'pt-addons') ?></label>
            <select name="<?php echo $this->name ?>[family]" class="yprm-typography yprm-font-family">
              <option value="inherit"><?php echo esc_html__('Inherit', 'pt-addons') ?></option>
              <?php if(is_object($fonts_array) && count($fonts_array) > 0) {
                foreach ($fonts_array as $font) { 
                  if($this->value['family'] == $font->family) {
                    $current_font = $font;
                  }
                  $value = $font->family;
                  if($font->type == 'typekit') {
                    $value = $font->slug;
                  }
                ?>
                <option 
                  value="<?php echo esc_attr($value) ?>" 
                  data-json="<?php echo esc_attr(json_encode($font)) ?>"
                  <?php echo $this->value['family'] == $font->family ? ' selected' : '' ?>
                ><?php echo esc_html($font->family) ?></option>
              <?php }
              } ?>
            </select>
          </div>
          <div class="item col-6">
            <label><?php echo esc_html__('Backup Font Family', 'pt-addons') ?></label>
            <select name="<?php echo $this->name ?>[backup-family]" class="yprm-typography yprm-backup-font-family">
              <option value=""></option>
              <?php foreach($this->default_font_family() as $item) { ?>
                <option 
                  value="<?php echo esc_attr($item) ?>"
                  <?php echo $this->value['backup-family'] == $item ? ' selected' : '' ?>
                ><?php echo esc_html($item) ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="item col-4">
            <label><?php echo esc_html__('Font Weight', 'pt-addons') ?></label>
            <select name="<?php echo $this->name ?>[weight]" class="yprm-typography yprm-font-weight" data-value="<?php echo esc_attr($this->value['weight']) ?>">
              <?php if($has_font && !empty($current_font->variants)) {
                foreach(explode(', ', $current_font->variants) as $variant) { ?>
                  <option 
                  value="<?php echo esc_attr($variant) ?>"
                    <?php echo $this->value['weight'] == $variant ? ' selected' : '' ?>
                  ><?php echo esc_html($variant) ?></option>
                <?php }
              } ?>
            </select>
          </div>
          <div class="item col-4">
            <label><?php echo esc_html__('Text Transform', 'pt-addons') ?></label>
            <select name="<?php echo $this->name ?>[text-transform]" class="yprm-typography yprm-text-transform">
              <option 
                value=""
              ><?php echo esc_html__('Inherit', 'pt-addons') ?></option>
              <option 
                value="capitalize"
                <?php echo $this->value['text-transform'] == 'capitalize' ? ' selected' : '' ?>
              ><?php echo esc_html__('Capitalize', 'pt-addons') ?></option>
              <option 
                value="uppercase"
                <?php echo $this->value['text-transform'] == 'uppercase' ? ' selected' : '' ?>
              ><?php echo esc_html__('Uppercase', 'pt-addons') ?></option>
              <option 
                value="lowercase"
                <?php echo $this->value['text-transform'] == 'lowercase' ? ' selected' : '' ?>
              ><?php echo esc_html__('Lowercase', 'pt-addons') ?></option>
              <option 
                value="none"
                <?php echo $this->value['text-transform'] == 'none' ? ' selected' : '' ?>
              ><?php echo esc_html__('None', 'pt-addons') ?></option>
            </select>
          </div>
          <div class="item col-4">
            <label><?php echo esc_html__('Font Subsets', 'pt-addons') ?></label>
            <select name="<?php echo $this->name ?>[subsets]" class="yprm-typography yprm-font-subsets" data-value="<?php echo esc_attr($this->value['subsets'] ? $this->value['subsets'] : 'latin') ?>">
              <?php if($has_font && !empty($current_font->subsets)) {
                foreach(explode(', ', $current_font->subsets) as $subset) { ?>
                  <option 
                  value="<?php echo esc_attr($subset) ?>"
                    <?php echo $this->value['subsets'] == $subset ? ' selected' : '' ?>
                  ><?php echo esc_html($subset) ?></option>
                <?php }
              } ?>
            </select>
          </div>
          <div class="item col-4">
            <label><?php echo esc_html__('Font Size', 'pt-addons') ?></label>
            <?php echo $this->render_num_unit('font-size') ?>
          </div>
          <div class="item col-4">
            <label><?php echo esc_html__('Letter Spacing', 'pt-addons') ?></label>
            <?php echo $this->render_num_unit('letter-spacing') ?>
          </div>
          <div class="item col-4">
            <label><?php echo esc_html__('Line Height', 'pt-addons') ?></label>
            <?php echo $this->render_num_unit('line-height') ?>
          </div>
          <div class="col-12">
            <div class="yprm-font-preview" style="display: none;"><?php echo esc_html__('Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 'pt-addons') ?></div>
          </div>
        </div>
      </div>
      
      
      <?php
    }

    /**
     * Enqueue Function.
     *
     * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
     *
     * @since       1.0.0
     * @access      public
     * @return      void
     */
    public function enqueue() {
      if (!wp_style_is('select2-css')) {
        wp_enqueue_style( 'select2-css' );
      }

      wp_enqueue_script( 'redux-field-yprm-typography-js', $this->extension_url . 'field_yprm_typography.js', array( 'jquery', 'wp-color-picker', 'select2-js', 'redux-js' ), time(), true );
    }

    /**
     * Output Function.
     *
     * Used to enqueue to the front-end
     *
     * @since       1.0.0
     * @access      public
     * @return      void
     */
    public function output() {
      if ($this->field['enqueue_frontend']) {
        if(is_array($this->field['output']) && count($this->field['output']) > 0) {

          if($this->value['weight'] == 'regular') {
            $this->value['weight'] = '400';
          }

          $css_code = implode(',', $this->field['output'])."{";
            if(!empty($this->value['family']) && $this->value['family'] != 'inherit') {
              $css_code .= "font-family: ".$this->value['family'].",".$this->value['backup-family'];
              $css_code = trim($css_code, ',');
              $css_code .= ";";
            }
            if(!empty($this->value['weight']) && strpos($this->value['weight'], 'italic') !== false) {
              $css_code .= "font-style: italic;";
              $this->value['weight'] = str_replace('italic', '', $this->value['weight']);
            }
            if(!empty($this->value['weight'])) {
              $css_code .= "font-weight: ".$this->value['weight'].";";
            }
            if(!empty($this->value['text-transform'])) {
              $css_code .= "text-transform: ".$this->value['text-transform'].";";
            }
            if(!empty($this->value['font-size'])) {
              $css_code .= "font-size: ".$this->value['font-size'].";";
            }
            if(!empty($this->value['letter-spacing'])) {
              $css_code .= "letter-spacing: ".$this->value['letter-spacing'].";";
            }
            if(!empty($this->value['line-height'])) {
              $css_code .= "line-height: ".$this->value['line-height'].";";
            }
          $css_code .= "}";

          $this->parent->outputCSS .= $css_code;
        }
      }
    }
  }
}
