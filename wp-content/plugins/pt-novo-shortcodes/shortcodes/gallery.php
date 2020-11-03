<?php

// Element Description: PT Gallery

class PT_Gallery extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_gallery_mapping'));
    add_shortcode('pt_gallery', array($this, 'pt_gallery_html'));
  }

  // Element Mapping
  public function pt_gallery_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Gallery", "novo"),
      "base" => "pt_gallery",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-gallery",
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "attach_images",
          "heading" => esc_html__("Images", "novo"),
          "param_name" => "images",
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Type", "novo"),
          "param_name" => "type",
          "admin_label" => true,
          "value" => array(
            esc_html__("Grid", "novo") => "grid",
            esc_html__("Masonry", "novo") => "masonry",
            esc_html__("Slider", "novo") => "slider",
          ),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Thumbs", "pt-addons"),
          "param_name" => "slider_thumbs",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "dependency" => Array("element" => "type", "value" => array("slider") ),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Count items", "novo"),
          "param_name" => "count_items",
          "value" => '9',
          "admin_label" => true,
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry") ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Colums", "novo"),
          "param_name" => "cols_masonry",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '3',
          "dependency" => Array("element" => "type", "value" => "masonry" ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Colums", "novo"),
          "param_name" => "cols_grid",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
            esc_html__("Set Min Max Width", "pt-addons") => "min-max",
          ),
          "std" => '3',
          "dependency" => Array("element" => "type", "value" => "grid" ),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Min Width", "pt-addons"),
          "param_name" => "col_min",
          "vc_edit_field" => "vc_col-auto",
          "suffix" => esc_html__("px", "pt-addons"),
          "dependency" => Array("element" => "cols_grid", "value" => "min-max" ),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Max Width", "pt-addons"),
          "param_name" => "col_max",
          "vc_edit_field" => "vc_col-auto",
          "suffix" => esc_html__("px", "pt-addons"),
          "dependency" => Array("element" => "cols_grid", "value" => "min-max" ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Navigation", "novo"),
          "param_name" => "navigation",
          "value" => array(
            esc_html__("None", "novo") => "none",
            esc_html__("Load More", "novo") => "load_more",
            esc_html__("Load More On Scroll", "novo") => "load_more_on_scroll",
          ),
          "std" => "load_more",
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry") ),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Gap", "novo"),
          "param_name" => "gap",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Popup mode title", "pt-addons"),
          "param_name" => "popup_mode_title",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Popup mode descripton", "pt-addons"),
          "param_name" => "popup_mode_desc",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Hover animation", "novo"),
          "param_name" => "hover",
          "admin_label" => true,
          "value" => array(
            esc_html__("Content always is shown", "novo") => "none",
            esc_html__("Type 1", "novo") => "type_1",
            esc_html__("Type 2", "novo") => "type_2",
            esc_html__("Type 3", "novo") => "type_3",
            esc_html__("Type 4", "novo") => "type_4",
            esc_html__("Type 5", "novo") => "type_5",
            esc_html__("Type 6", "novo") => "type_6",
            esc_html__("Type 7", "novo") => "type_7",
            esc_html__("Type 8", "novo") => "type_8",
            esc_html__("Type 9", "novo") => "type_9",
          ),
          "std" => 'type_1',
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Hover disable", "pt-addons"),
          "param_name" => "hover_disable",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Show Heading", "pt-addons"),
          "param_name" => "show_heading",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Show Description", "pt-addons"),
          "param_name" => "show_desc",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Images Type", "pt-addons"),
          "param_name" => "slider_image_type",
          "value" => array(
            esc_html__("Cropped", "pt-addons") => "cropped",
            esc_html__("Original", "pt-addons") => "original",
          ),
          "dependency" => Array("element" => "type", "value" => array("slider")),
          "group" => esc_html__("Slider Settings", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Infinite loop", "novo"),
          "param_name" => "slider_loop",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Restart the slider automatically as it passes the last slide.", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("slider")),
          "group" => esc_html__("Slider Settings", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay Slides", "novo"),
          "param_name" => "slider_autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Enable Autoplay", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("slider")),
          "group" => esc_html__("Slider Settings", "pt-addons"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Autoplay Speed", "novo"),
          "param_name" => "slider_autoplay_timeout",
          "value" => "5000",
          "min" => "100",
          "max" => "10000",
          "step" => "10",
          "suffix" => "ms",
          "dependency" => Array("element" => "slider_autoplay", "value" => array("on")),
          "group" => esc_html__("Slider Settings", "pt-addons"),
        ),
        array(
          "type" => "animation_style",
          "heading" => esc_html__("Animation In", "novo"),
          "param_name" => "animation",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_gallery_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'images' => '',
          'type' => 'grid',
          'slider_thumbs' => 'off',
          'count_items' => '9',
          'popup_mode_title' => 'off',
          'popup_mode_desc' => 'off',
          'cols_masonry' => '3',
          'cols_grid' => '3',
          'col_min' => '',
          'col_max' => '',
          'navigation' => 'load_more',
          'gap' => 'on',
          'hover' => 'type_1',
          'hover_disable' => 'off',
          'show_heading' => 'off',
          'show_desc' => 'off',
          'slider_image_type' => 'cropped',
          'slider_loop' => 'on',
          'slider_autoplay' => 'on',
          'slider_autoplay_timeout' => '5000',
          'animation' => '',
        ),
        $atts
      )
    );

    $wrap_classes = ' id-'.$uniqid . ' ' . $type . ' portfolio_hover_' . $hover;

    if($hover_disable == 'on') {
      $wrap_classes .= ' hover-disable';
    }

    if($gap == 'off') {
      $wrap_classes .= ' gap-off';
    }

    $wrap_classes .= ' ' . $this->getCSSAnimation($animation);

    if($type == 'grid') {
      $cols = $cols_grid;
      $wrap_classes .= ' disable-iso';
    } else {
      $cols = $cols_masonry;
    }

    switch ($cols) {
    case '1':
      $item_col = "col-12";
      break;
    case '2':
      $item_col = "col-12 col-sm-6 col-md-6";
      break;
    case '3':
      $item_col = "col-12 col-sm-4 col-md-4";
      break;
    case '4':
      $item_col = "col-12 col-sm-4 col-md-3";
      break;

    default:
      $item_col = "col-12";
      break;
    }

    if (!empty($images)) {
      $images = explode(',', $images);
    }

    $i1 = 1;

    $key2 = 0;

    if(yprm_get_theme_setting('lazyload') == 'true') {
      $thumb_size = 'yprm-lazyloading-placeholder';
    } else {
      $thumb_size = 'large';
    }

    if($col_min && $col_max) {
      $css_code = ".id-$uniqid .portfolio-item {
        min-width: {$col_min}px;
        max-width: {$col_max}px;
        flex: 1;
      }";

      yprm_inline_css($css_code);
    }

    ob_start();

    if($type == 'slider') { ?>
      <?php
        if($slider_loop == 'on') {
          $slider_loop = 'true';
        } else {
          $slider_loop = 'false';
        }
    
        if($slider_autoplay == 'on') {
          $autoplay_js = "autoplay: {
            delay: $slider_autoplay_timeout,
          },";
        } else {
          $autoplay_js = '';
        }

        $inline_js = "var \$photo_gallery_block = jQuery('.id-$uniqid');

        var \$photo_gallery_slider_swiper = new Swiper(\$photo_gallery_block.find('.slider'), {
          loop: $slider_loop,
          $autoplay_js
          ".($slider_thumbs == 'on' ? "thumbs: {
            swiper: {
              el: \$photo_gallery_block.find('.thumbs'),
              breakpointsInverse: true,
              spaceBetween: 5,
              slideToClickedSlide: true,
              watchOverflow: true,
              freeMode: true,
              loopedSlides: 5,
              breakpoints: {
                0: {
                  slidesPerView: 3,
                },
                480: {
                  slidesPerView: 4,
                },
                640: {
                  slidesPerView: 5,
                },
                768: {
                  slidesPerView: 7,
                },
                998: {
                  slidesPerView: 8,
                },
                1200: {
                  slidesPerView: 9,
                },
              }
            }
          }," : "")."
          watchSlidesVisibility: true,
          loopAdditionalSlides: 2,
          speed: 800,
          navigation: {
            nextEl: \$photo_gallery_block.find('.next'),
            prevEl: \$photo_gallery_block.find('.prev'),
          },
          breakpointsInverse: true,
        });";

        wp_enqueue_script('swiper');
        wp_enqueue_style('swiper');
        
        do_action('yprm_inline_js', $inline_js);
      ?>
      <div class="project-slider-block <?php echo esc_attr('id-'.$uniqid) ?>">
        <div class="slider swiper-container">
          <div class="swiper-wrapper">
            <?php foreach ($images as $key => $thumb) { 
              $img_array = wp_get_attachment_image_src($thumb, 'large');
              $img_full_array = wp_get_attachment_image_src($thumb, 'full');
              $img_html = wp_get_attachment_image($thumb, 'large');
              $img_info = get_post($thumb);

              $img_info = array(
                'title' => $img_info->post_title,
                'desc' => $img_info->post_content
              );
            ?>
              <?php if($slider_image_type == 'cropped') { ?>
                <div class="swiper-slide full-height" style="<?php echo esc_attr(yprm_get_image($thumb, 'bg')) ?>"></div>
              <?php } else { ?>
                <div class="swiper-slide full-height">
                  <?php echo wp_kses($img_html, 'post') ?>
                  <?php if(($show_heading == 'on' && !empty($img_info['title'])) || ($show_desc == 'on' && !empty($img_info['desc']))) { ?>
                  <div class="content">
                    <?php if ($show_heading == 'on') { ?>
                      <h6><?php echo esc_html($img_info['title']) ?></h6>
                    <?php } if ($img_info['desc'] && $show_desc == 'on' && function_exists('mb_strimwidth')) { 
                      $img_info['desc'] = mb_strimwidth($img_info['desc'], 0, 45, '...');
                      ?>
                      <p><?php echo strip_tags($img_info['desc']) ?></p>
                    <?php } ?>
                  </div>
                <?php } ?>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
        <?php if($slider_thumbs == 'on') { ?>
          <div class="thumbs swiper-container">
            <div class="swiper-wrapper">
              <?php foreach ($images as $key => $thumb) { ?>
                <div class="swiper-slide" style="<?php echo esc_attr(yprm_get_image($thumb, 'bg')) ?>"></div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } else { 
      wp_enqueue_script('imagesloaded');
      wp_enqueue_script('isotope');
      wp_enqueue_script('pt-load-posts');
    ?>
      <div class="project-grid-page">
        <div class="post-gallery-grid <?php echo esc_attr($wrap_classes) ?> row popup-gallery">
          <?php foreach ($images as $key => $thumb) { 
            $img_array = wp_get_attachment_image_src($thumb, $thumb_size);
            $img_full_array = wp_get_attachment_image_src($thumb, 'full');
            $img_html = wp_get_attachment_image($thumb, $thumb_size);
            $img_info = get_post($thumb);

            $index_num = $key+1;

            $img_info = array(
              'title' => $img_info->post_title,
              'desc' => $img_info->post_content
            );
            
            $link_attr = '';

            if($popup_mode_title == 'on' && !empty($img_info['title'])) {
              $link_attr .= ' data-title="'.esc_attr($img_info['title']).'"';
            }
            
            if($popup_mode_desc == 'on' && !empty($img_info['desc'])) {
              $link_attr .= ' data-desc="'.esc_attr(mb_strimwidth($img_info['desc'], 0, yrpm_get_l('project_image_desc_size', 55), '...')).'"';
            }
          ?>
          <?php if ($navigation != 'none' && $count_items > 0 && count($images) > $count_items && $count_items == $key) { ?>
        </div>
        <div class="load-items load-items<?php echo esc_html($i1); ?>">
          <?php $key2 = $key;
            $i1++;} ?>
          <?php if ($navigation != 'none' && $count_items > 0 && count($images) > $count_items && $count_items + $key2 == $key) { ?>
        </div>
        <div class="load-items load-items<?php echo esc_html($i1); ?>">
          <?php $key2 = $key;
            $i1++;} ?>

            <div class="portfolio-item <?php echo esc_attr($item_col) ?> popup-item" >
              <div class="wrap">
                <?php if ($type == 'masonry') { ?>
                  <div class="a-img" data-original="<?php echo esc_attr($img_full_array[0]); ?>"><?php echo wp_kses_post($img_html); ?></div>
                <?php } else { ?>
                  <div class="a-img" data-original="<?php echo esc_attr($img_full_array[0]); ?>"><div style="background-image: url(<?php echo esc_url($img_array[0]); ?>)"></div></div>
                <?php } if(($show_heading == 'on' && !empty($img_info['title'])) || ($show_desc == 'on' && !empty($img_info['desc']))) { ?>
                  <div class="content<?php echo esc_attr(($show_desc == 'on' && !empty($img_info['desc'])) ? '' : ' without-desc') ?>">
                    <?php if ($show_heading == 'on') {
                      if ($hover == 'type_5') {
                        echo '<h5><span>' . yprm_lead_zero($index_num) . '</span> ' . esc_html($img_info['title']) . '</h5>';
                      } else {
                        echo '<h5>' . esc_html($img_info['title']) . '</h5>';
                      }
                    } if ($img_info['desc'] && $show_desc == 'on' && function_exists('mb_strimwidth')) {
                      $img_info['desc'] = mb_strimwidth($img_info['desc'], 0, 45, '...');
                      echo '<p>' . esc_html($img_info['desc']) . '</p>';
                    } ?>
                  </div>
                <?php } ?>
                <a href="<?php echo esc_url($img_full_array[0]); ?>" data-size="<?php echo esc_attr($img_full_array[1]); ?>x<?php echo esc_attr($img_full_array[2]); ?>"<?php echo $link_attr ?>></a>
              </div>
            </div>
          <?php } ?>
        </div>
        <?php if ($navigation != 'none' && $count_items > 0 && count($images) > $count_items) { ?>
        <div class="project-image-load-button tac">
          <a href="#" class="button-style1 <?php echo esc_attr($navigation); ?>"><span><?php echo yprm_get_theme_setting('tr_load_more') ?></span></a>
        </div>
        <?php } ?>
      </div>
    <?php }
    return ob_get_clean();

  }

} // End Element Class

// Element Class Init
new PT_Gallery();