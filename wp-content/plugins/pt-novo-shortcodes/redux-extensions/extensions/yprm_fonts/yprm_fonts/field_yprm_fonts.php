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
if (!class_exists('ReduxFramework_yprm_fonts')) {

  /**
   * Main ReduxFramework_yprm_fonts class
   *
   * @since       1.0.0
   */
  class ReduxFramework_yprm_fonts {

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

      if (empty($this->extension_dir)) {
        $this->extension_dir = trailingslashit(str_replace('\\', '/', dirname(__FILE__)));
        $this->extension_url = site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', $this->extension_dir));
      }

      // Set default args for this field to avoid bad indexes. Change this to anything you use.
      $defaults = array(
        'fonts' => '',
        'typekit_project_id' => '',
        'options' => array(),
        'stylesheet' => '',
        'output' => true,
        'enqueue' => true,
        'enqueue_frontend' => true,
      );
      $this->field = wp_parse_args($this->field, $defaults);

      $defaults = array(
        'fonts' => '',
        'typekit_project_id' => '',
      );
      $this->value = wp_parse_args($this->value, $defaults);
    }

    /**
     * Google Fonts Array
     */

    public function google_fonts_array() {
      if(function_exists('file_get_contents')) {
        $array = json_decode(file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCiNr2XP1r9oqxWCOfK2oIsOStGMdxPieQ'), true)['items'];
      } else {
        $array = include dirname(__FILE__) . '/googlefonts.php';
      }
      
      return $this->group_by('family', $array);
    }

    /**
     * TypeKit Array
     */

    public function typekit_array() {
      if(!isset($this->value['typekit_project_id'])) {
        return false;
      }

      return yprm_typekit_array($this->value['typekit_project_id']);
    }

    /**
     * Group By
     */

    public function group_by($key, $data) {
      $result = array();

      foreach ($data as $val) {
        if (array_key_exists($key, $val)) {
          $v = substr($val[$key], 0, 1);
          $result[$v][] = $val;
        } else {
          $result[""][] = $val;
        }
      }

      return $result;
    }

    /**
     * Is Active
     */

    public function is_active($el) {
      $array = json_decode('['.$this->value['fonts'].']');

      if(is_array($array) && count($array) > 0) {
        foreach($array as $item) {
          if($el == $item->family) {
            return true;
          }
        }
      }
      return false;
    }

    /**
     * TypeKit Form
     */

    public function render_typekit_form() {
      $array = json_encode($this->typekit_array());
      $array = substr($array , 1, -1);
      ?>
      <div class="yprm-typekit-widget yprm-widget dropdown">
        <div class="title">
          <?php echo esc_html__('TypeKit', 'pt-addons') ?>
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="dropdown-wrap">
          <div class="yprm-typekit-form">
            <div class="input-col">
              <label><?php echo esc_html__('Project ID', 'pt-addons') ?></label>
              <input class="yprm-input required" type="text" name="<?php echo esc_attr($this->field['name']); ?>[typekit_project_id]" value="<?php echo esc_attr($this->value['typekit_project_id']); ?>">
            </div>
            <div class="button-col">
              <?php if(!empty($this->value['typekit_project_id'])) { ?>
                <a href="#" class="button current" data-array="<?php echo esc_attr($array); ?>"><?php echo esc_html__('Deregister Key', 'pt-addons') ?></a>
              <?php } else { ?>
                <a href="#" class="button"><?php echo esc_html__('Register Key', 'pt-addons') ?></a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php
    }

    /**
     * Custom Font Form
     */

    public function render_custom_font_form() {
      ?>
      <div class="yprm-typekit-widget yprm-widget dropdown">
        <div class="title">
          <?php echo esc_html__('Custom Font', 'pt-addons') ?>
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="dropdown-wrap">
          <div class="yprm-custom-font-form">
            <div class="input-row">
              <label><?php echo esc_html__('Font family', 'pt-addons') ?></label>
              <input class="yprm-input required" type="text" name="<?php echo esc_attr($this->field['name']); ?>[custom_font_family]">
            </div>
            <div class="input-row">
              <label><?php echo esc_html__('Files', 'pt-addons') ?></label>
              <label class="upload">
                <input class="upload-input" type="file" name="<?php echo esc_attr($this->field['name']); ?>[custom_font_family_eot]" accept=".eot">
                <span>
                  <i class="fas fa-check"></i>
                  <?php echo esc_html__('.eot', 'pt-addons') ?>
                </span>
              </label>
              <label class="upload">
                <input class="upload-input" type="file" name="<?php echo esc_attr($this->field['name']); ?>[custom_font_family_ttf]" accept=".ttf">
                <span>
                  <i class="fas fa-check"></i>
                  <?php echo esc_html__('.ttf', 'pt-addons') ?>
                </span>
              </label>
              <label class="upload">
                <input class="upload-input" type="file" name="<?php echo esc_attr($this->field['name']); ?>[custom_font_family_woff]" accept=".woff">
                <span>
                  <i class="fas fa-check"></i>
                  <?php echo esc_html__('.woff', 'pt-addons') ?>
                </span>
              </label>
            </div>
            <div class="button-block">
              <a href="#" class="button"><?php echo esc_html__('Add Font', 'pt-addons') ?></a>
            </div>
          </div>
        </div>
      </div>
      <?php
    }

    /**
     * Upload Custom Font
     */

    public function upload_custom_font() {
      $upload_dir = wp_upload_dir();
    }

    /**
     * Letters Array
     */

    public function render_results() {
      ?>
      <input class="result-input" type="hidden" name="<?php echo esc_attr($this->field['name']); ?>[fonts]" value="<?php echo esc_attr($this->value['fonts']); ?>">
      <div class="yprm-custom-fonts-widget yprm-widget">
        <div class="title">
          <?php echo esc_html__('Fonts', 'pt-addons') ?>
        </div>
        <div class="yprm-font-items"<?php echo (empty($this->value['fonts'])) ? ' style="display: none;"' : ''; ?>>
          <div class="items">
            <?php if(!empty($this->value['fonts'])) {
              $array = json_decode('['.$this->value['fonts'].']');
              if(is_array($array) && count($array) > 0) {
                foreach($array as $item) {
                  yprm_render_result_item($item);
                }
              }
            } ?>
          </div>
        </div>
        <div class="yprm-fonts-empty"<?php echo (!empty($this->value['fonts'])) ? ' style="display: none;"' : ''; ?>><?php echo esc_html__('Nothing Found', 'pt-addons') ?></div>
      </div>
      <?php
    }

    /**
     * Google Fonts Row
     */

    public function render_google_fonts() {
      $array = $this->google_fonts_array();
      ?>
      <div class="yprm-googlefonts-widget yprm-widget dropdown">
        <div class="title">
          <?php echo esc_html__('Google Fonts', 'pt-addons') ?>
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="dropdown-wrap">
          <div class="yprm-font-items">
            <div class="nav">
              <?php foreach($array as $key => $item) { ?>
                <div class="item<?php echo ($key == 'A') ? ' current' : ''; ?>" data-group="<?php echo esc_attr($key) ?>"><?php echo strip_tags($key) ?></div>
              <?php } ?>
            </div>
            <div class="items">
              <?php foreach($array as $key => $group_item) { ?>
                <div class="group-item<?php echo ($key == 'A') ? ' current' : ''; ?>" data-group="<?php echo esc_attr($key) ?>">
                  <?php foreach($group_item as $key => $item) {
                    $array = array(
                      'type' => 'google',
                      'family' => $item['family'],
                      'variants' => implode(', ',$item['variants']),
                      'subsets' => implode(', ',$item['subsets'])
                    );
                  ?>
                    <div class="item<?php echo $this->is_active($item['family']) ? ' active' : ''; ?>" data-font-family="<?php echo strip_tags($item['family']); ?>">
                      <div class="title"><?php echo strip_tags($item['family']); ?></div>
                      <div class="variants"><?php echo implode(', ',$item['variants']); ?></div>
                      <div class="subsets"><?php echo implode(', ',$item['subsets']); ?></div>
                      <a href="<?php echo esc_url('https://fonts.google.com/specimen/').str_replace(' ', '+', $item['family']) ?>" class="external-link fas fa-search" target="_blank"></a>
                      <div class="buttons">
                        <a href="#" class="button" data-item="<?php echo esc_attr(json_encode($array)) ?>"><?php if($this->is_active($item['family'])) {
                          echo esc_html__('Added', 'pt-addons');
                        } else {
                          echo esc_html__('Add', 'pt-addons');
                        } ?></a>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </div>
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
      $this->render_results();
      $this->render_google_fonts();
      $this->render_typekit_form();
      $this->render_custom_font_form();
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
      wp_enqueue_script( 'redux-field-yprm-fonts-js', $this->extension_url . 'field_yprm_fonts.js', array('jquery'), time(), true );

      if(!isset($this->value['fonts'])) {
        return false;
      }
      
      $array = (object) json_decode('['.$this->value['fonts'].']');
      $typekit = false;

      foreach($array as $font_item) {
        if($font_item->type == 'google') {
          $font_family = yprm_kebab_case($font_item->family);
          $font_link = '//fonts.googleapis.com/css?family='.str_replace(' ', '+', $font_item->family).':'.str_replace(array(' ') , array(''), $font_item->variants).'&display=swap';
        } elseif($font_item->type == 'typekit' && !$typekit) {
          if(isset($this->value['typekit_project_id']) && !empty($this->value['typekit_project_id'])) {
            $font_family = 'typekit';
            $font_link = '//use.typekit.net/'.$this->value['typekit_project_id'].'.css';
          }

          $typekit = true;
        } elseif($font_item->type == 'custom font') {
          $font_family = yprm_kebab_case($font_item->family);
          $font_link = $font_item->css_url;
        } else {
          continue;
        }

        wp_enqueue_style( 'novo-'.$font_family, $font_link, time(), true);
      }
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
      if ($this->field['enqueue_frontend']) {}
    }
  }
}
