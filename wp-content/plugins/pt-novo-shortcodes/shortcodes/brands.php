<?php

// Element Name: Brands

class YPRM_Brands {

  public function __construct() {
    add_action('init', array($this, 'yprm_brands_mapping'));
    add_shortcode( 'yprm_brands', array( $this, 'yprm_brands_html' ) );
    add_shortcode( 'yprm_brands_item', array( $this, 'yprm_brands_item_html' ) );
  }

  public function yprm_vc_map_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "cols",
          "heading" => esc_html__("Cols", "pt-addons"),
          "param_name" => "cols",
          "mode" => "owl"
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Loop", "pt-addons"),
          "param_name" => "slider_loop",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay", "pt-addons"),
          "param_name" => "slider_autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Autoplay TimeOut", "pt-addons"),
          "param_name" => "slider_autoplay_timeout",
          "value" => "5000",
          "suffix" => esc_html__("ms", "pt-addons"),
          "dependency" => Array("element" => "slider_autoplay", "value" => "on"),
        ),
        yprm_add_css_animation(),
        array(
          "type" => "css_editor",
          "heading" => esc_html__("CSS box", "pt-addons"),
          "param_name" => "css",
          "edit_field_class" => "simple",
          "group" => esc_html__( "Design Options", "pt-addons" ),
        ),
      )
    );
  }

  public function yprm_vc_map_item_array() {
    return array_merge(
      array(
        yprm_vc_uniqid(),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background Image", "pt-addons"),
          "param_name" => "background_image",
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background Image On Hover", "pt-addons"),
          "param_name" => "background_image_hover",
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "pt-addons"),
          "param_name" => "link",
        ),
      )
    );
  }

  public function yprm_brands_mapping() {

    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    vc_map(array(
      "name" => esc_html__("Brands", "pt-addons"),
      "as_parent" => array('only' => 'yprm_brands_item'),
      "base" => "yprm_brands",
      "show_settings_on_create" => true,
      "is_container" => true,
      "icon" => "shortcode-icon-brand",
      "js_view" => 'VcColumnView',
      "category" => esc_html__("Novo Shortcodes", "pt-addons"),
      "params" => self::yprm_vc_map_array(),
    ));

    vc_map(array(
      "name" => esc_html__("Brand Item", "pt-addons"),
      "as_child" => array('only' => 'yprm_brands'),
      "base" => "yprm_brands_item",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-brand",
      "params" => self::yprm_vc_map_item_array(),
    ));
  }

  public function yprm_brands_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'cols' => '',
          'slider_loop' => 'on',
          'slider_autoplay' => 'on',
          'slider_autoplay_timeout' => '5000',
          'css_animation' => '',
          'css' => '',
        ),
        $atts
      )
    );

    $block_class = array();

    $block_class[] = $block_id = 'brand-block-'.$uniqid;

    if(!empty($css)) {
      $block_class[] = vc_shortcode_custom_css_class($css);
    }

    if(!empty($css_animation)) {
      $block_class[] = yprm_get_animation_css($css_animation);
    }

    if($slider_autoplay == 'on') {
      $autoplay_js = "autoplay: {
        delay: $slider_autoplay_timeout,
      },";
    } else {
      $autoplay_js = '';
    }

    if($slider_loop == 'on') {
      $slider_loop = 'true';
    } else {
      $slider_loop = 'false';
    }

    $inline_js = "var \$carousel = jQuery('.$block_id'),
    \$carousel_swiper = new Swiper(\$carousel, {
      loop: $slider_loop,
      spaceBetween: 30,
      watchSlidesVisibility: true,
      loopAdditionalSlides: 2,
      $autoplay_js
      breakpointsInverse: true,
      breakpoints: {
        ".yprm_parce_cols($cols, 'swiper')."
      }
    });";

    wp_enqueue_script('swiper');
    wp_enqueue_style('swiper');
    
    do_action('yprm_inline_js', $inline_js);

    ob_start();
    ?>
    <div class="brand-block swiper-container<?php echo yprm_implode($block_class) ?>" data-magic-cursor="link-w-text" data-magic-cursor-text="<?php echo esc_attr(yprm_get_theme_setting('tr_drag')); ?>">
      <div class="swiper-wrapper">
        <?php echo do_shortcode($content); ?>
      </div>
    </div>
    <?php
    return ob_get_clean();

  }

  public function yprm_brands_item_html($atts, $content = null) {

    extract(
      shortcode_atts(
        array(
          'uniqid' => '',
          'background_image' => '',
          'background_image_hover' => '',
          'link' => '',
        ),
        $atts
      )
    );

    $img_html = $img_html_hover = '';

    $block_class = array();

    $block_class[] = $block_id = 'brand-item-'.$uniqid;

    if ($img = yprm_get_image($background_image, 'img')) {
      $img_html = $img;
    } else {
      return false;
    }

    if ($img = yprm_get_image($background_image_hover, 'img')) {
      $img_html_hover = $img;
    }

    if(empty($img_html_hover)) {
      $block_class[] = 'without-hover';
    }

    ob_start();
    ?>
    <div class="brand-item swiper-slide<?php echo yprm_implode($block_class) ?>">
      <div class="content">
        <?php if($button = yprm_vc_link($link)) { ?>
          <a href="<?php echo esc_url($button['url']) ?>" target="<?php echo esc_attr($button['target']) ?>">
        <?php } ?>
          <?php echo wp_kses_post($img_html) ?>
          <?php if(!empty($img_html_hover)) { 
            echo wp_kses_post($img_html_hover);
          } ?>
        <?php if(yprm_vc_link($link)) { ?>
          </a>
        <?php } ?>
      </div>
    </div>
    <?php
    return ob_get_clean();

  }

}

new YPRM_Brands();
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
  class WPBakeryShortCode_YPRM_Brands extends WPBakeryShortCodesContainer {
  }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
  class WPBakeryShortCode_YPRM_Brands_Item extends WPBakeryShortCode {
  }
}