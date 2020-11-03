<?php

function yprm_enable_extended_upload($mime_types = array()) {
  $mime_types['eot'] = 'application/vnd.ms-fontobject';
  $mime_types['ttf'] = 'application/x-font-ttf';
  $mime_types['woff'] = 'application/font-woff';

  return $mime_types;
}

add_filter('upload_mimes', 'yprm_enable_extended_upload');

if(!function_exists('yprm_modify_tag_output_buffer_start')) {
  add_action('wp_loaded', 'yprm_modify_tag_output_buffer_start');
  function yprm_modify_tag_output_buffer_start() {
    ob_start("yprm_modify_tag_output_callback");
  }

  function yprm_modify_tag_output_callback($buffer) {
    return preg_replace("%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer);
  }
}

/**
 * Lead Zero
 */

if (!function_exists('yprm_lead_zero')) {
  function yprm_lead_zero($number = false) {
    if (empty($number)) {
      return false;
    }

    $number = (int)$number;
    if ($number < 10) {
      $number = '0' . $number;
    }

    return $number;
  }
}

/**
 * Add Custom Inline CSS
 */

if (!function_exists('yprm_inline_css')) {
  function yprm_inline_css($css = false) {
    if (empty($css)) {
      return false;
    }

    wp_enqueue_style('pt-inline');
    wp_add_inline_style('pt-inline', yprm_minify_code($css));
  }
  add_action('yprm_inline_css', 'yprm_inline_css');
}

/**
 * Add Custom Inline JS
 */

if (!function_exists('yprm_inline_js')) {
  function yprm_inline_js($js = false) {
    if (empty($js)) {
      return false;
    }

    $js = "jQuery(document).ready(function (jQuery) {
      $js
    });";

    wp_enqueue_script('pt-scripts');
    wp_add_inline_script('pt-scripts', yprm_minify_code($js));
  }
  add_action('yprm_inline_js', 'yprm_inline_js');
}

/**
 * Get Portfolio Categories
 */

if (!function_exists('yprm_portfolio_categories')) {
  function yprm_portfolio_categories() {
    $taxonomy = 'fw-portfolio-category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        if (empty($name)) {
          $name = $term->name;
        }
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }
}

/**
 * Get Blog Categories
 */

if (!function_exists('yprm_blog_categories')) {
  function yprm_blog_categories() {
    $taxonomy = 'category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        if (empty($name)) {
          $name = $term->name;
        }
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }
}

/**
 * Get Product Categories
 */

if (!function_exists('yprm_product_categories')) {
  function yprm_product_categories() {
    $taxonomy = 'product_cat';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        if (empty($name)) {
          $name = $term->name;
        }
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }
}

/**
 * Get Blog Items
 */

if (!function_exists('yprm_blog_items')) {
  function yprm_blog_items() {
    $result = array();

    $args = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => '10000',
    );

    $post_array = new WP_Query($args);
    $result[0] = "";

    if (!empty($post_array->posts)) {
      foreach ($post_array->posts as $item) {
        $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
      }
    }

    return $result;
  }
}

/**
 * Get Portfolio Items
 */

if (!function_exists('yprm_portfolio_items')) {
  function yprm_portfolio_items() {
    $result = array();

    $args = array(
      'post_type' => 'fw-portfolio',
      'post_status' => 'publish',
      'posts_per_page' => '10000',
    );

    $porfolio_array = new WP_Query($args);
    $result[0] = "";

    if (!empty($porfolio_array->posts)) {
      foreach ($porfolio_array->posts as $item) {
        $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
      }
    }

    return $result;
  }
}

/**
 * Get Product Items
 */

if (!function_exists('yprm_product_items')) {
  function yprm_product_items() {
    $result = array();

    $args = array(
      'post_type' => 'product',
      'post_status' => 'publish',
      'posts_per_page' => '10000',
    );

    $porfolio_array = new WP_Query($args);
    $result[0] = "";

    if (!empty($porfolio_array->posts)) {
      foreach ($porfolio_array->posts as $item) {
        $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
      }
    }

    return $result;
  }
}

/**
 * HEX to RGBA
 */

if (!function_exists('yprm_hex2rgba')) {
  function yprm_hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    if (empty($color)) {
      return $default;
    }

    if ($color[0] == '#') {
      $color = substr($color, 1);
    }

    if (strlen($color) == 6) {
      $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
      $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
      return $default;
    }

    $rgb = array_map('hexdec', $hex);

    if ($opacity) {
      if (abs($opacity) > 1) {
        $opacity = 1.0;
      }
      $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
      $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    return $output;
  }
}

/**
 * Parse Shortcode
 */

if (!function_exists('yprm_the_shortcodes')) {
  function yprm_get_pattern($text) {
    $pattern = get_shortcode_regex();
    preg_match_all("/$pattern/s", $text, $c);
    return $c;
  }

  function yprm_parse_atts($content) {
    return shortcode_parse_atts($content);
  }

  function yprm_the_shortcodes(&$output, $text, $child = false) {
    $patts = yprm_get_pattern($text);
    $t = array_filter(yprm_get_pattern($text));
    if (!empty($t)) {
      list($d, $d, $parents, $atts, $d, $contents) = $patts;
      $out2 = array();
      $n = 0;
      foreach ($parents as $k => $parent) {
        ++$n;
        $name = $child ? 'child' . $n : $n;
        $t = array_filter(yprm_get_pattern($contents[$k]));
        $t_s = yprm_the_shortcodes($out2, $contents[$k], true);
        $output[$name] = yprm_parse_atts($atts[$k]);
        if(!empty($t_s) && is_array($t_s)) {
          $output[$name]['items'] = $t_s;
        }
      }
    }
    return array_values($output);
  }
}

/**
 * Parse Shortcode Params
 */

if (!function_exists('yprm_parse_params')) {
  function yprm_parse_params($array = array()) {
    $return = '';
    foreach($array as $item) {

      $value = '';
      if($item['type'] == 'dropdown' || $item['type'] == 'dropdown_multi') {
        if(isset($item['std'])) {
          $value = $item['std'];
        } else {
          $value = array_shift($item['value']);
        }
      } else if(!empty($item['value'])) {
        $value = $item['value'];
      }

      if($item['type'] != 'heading') {
        $return .= "'".$item['param_name']."' => '".$value."',\n";
      }
    }

    echo '<pre>'.$return.'</pre>';
  }
}

/**
 * Parse Shortcode Params
 */

if (!function_exists('yprm_vc_link')) {
  function yprm_vc_link($link, $target = '_self', $title = '') {
    if(!empty(vc_build_link($link)['url'])) {
      $url = vc_build_link($link)['url'];
      if(!empty(vc_build_link($link)['target'])) {
        $target = vc_build_link($link)['target'];
      }
      if(!empty(vc_build_link($link)['title'])) {
        $title = vc_build_link($link)['title'];
      }

      return array(
        'url' => $url,
        'target' => $target,
        'title' => $title
      );
    } else {
      return false;
    }
  }
}

/**
 * Heading filter
 */

if (!function_exists('yprm_heading_filter')) {
  function yprm_heading_filter($heading, $type = false) {
    if(!$type) {
      return wp_kses_post(str_replace(array('{', '}'), array('<span>', '</span>'), $heading));
    }

    return false;
  }
}

/**
 * Implode
 */

if (!function_exists('yprm_implode')) {
  function yprm_implode($array = array(), $before = ' ', $separator = ' ') {
    return $before.implode($separator, $array);
  }
}

/**
 * VC Animation
 */

if (!function_exists('yprm_get_animation_css')) {
  function yprm_get_animation_css($css_animation) {
    $result = '';
    if ( '' !== $css_animation && 'none' !== $css_animation ) {
      wp_enqueue_script( 'vc_waypoints' );
      wp_enqueue_style( 'vc_animate-css' );
      $result = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
    }

    return $result;
  }
}

if(!function_exists('yprm_add_css_animation')) {
  function yprm_add_css_animation($label = true, $heading = 'CSS Animation', $param_name = 'css_animation', $type = 'in') {
    $data = array(
      'type' => 'animation_style',
      'heading' => $heading,
      'param_name' => $param_name,
      'admin_label' => $label,
      'value' => '',
      'settings' => array(
        'type' => $type,
        'custom' => array(
          array(
            'label' => esc_html__( 'Default', 'pt-addons' ),
            'values' => array(
              esc_html__( 'Top to bottom', 'pt-addons' ) => 'top-to-bottom',
              esc_html__( 'Bottom to top', 'pt-addons' ) => 'bottom-to-top',
              esc_html__( 'Left to right', 'pt-addons' ) => 'left-to-right',
              esc_html__( 'Right to left', 'pt-addons' ) => 'right-to-left',
              esc_html__( 'Appear from center', 'pt-addons' ) => 'appear',
            ),
          ),
        ),
      ),
      'description' => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'pt-addons' ),
    );
  
    return apply_filters( 'vc_map_add_css_animation', $data, $label );
  }
}

/**
 * Parce Cols
 */

if (!function_exists('yprm_parce_cols')) {
  function yprm_parce_cols($cols = true, $type = 'cols') {
    if($type == 'owl' && !$cols) return '0: { items: 1 }';
    if($type == 'swiper' && !$cols) return '0: { slidesPerView: 1 }';
    if(!$cols) return 'col';

    $css = $array = $owl_array = $swiper_array = array();
    $cols = trim($cols, ',');
    $cols = explode(',', $cols);
    
    foreach($cols as $item) {
      $val = explode(':', $item);
      $array[$val[0]] = $val[1];
      $value = 12/$val[1];

      if($val[0] == 'xs') {
        $css[] = 'col-'.$value;
      } else {
        $css[] = 'col-'.$val[0].'-'.$value;
      }
      
      if($val[0] == 'xs') {
        $owl_array[] = '0: { items: '.$val[1].' },';
      }
      if($val[0] == 'sm') {
        $owl_array[] = '576: { items: '.$val[1].' },';
      }
      if($val[0] == 'md') {
        $owl_array[] = '768: { items: '.$val[1].' },';
      }
      if($val[0] == 'lg') {
        $owl_array[] = '992: { items: '.$val[1].' },';
      }
      if($val[0] == 'xl') {
        $owl_array[] = '1200: { items: '.$val[1].' },';
      }
      
      if($val[0] == 'xs') {
        $swiper_array[] = '200: { slidesPerView: '.$val[1].' },';
      }
      if($val[0] == 'sm') {
        $swiper_array[] = '576: { slidesPerView: '.$val[1].' },';
      }
      if($val[0] == 'md') {
        $swiper_array[] = '768: { slidesPerView: '.$val[1].' },';
      }
      if($val[0] == 'lg') {
        $swiper_array[] = '992: { slidesPerView: '.$val[1].' },';
      }
      if($val[0] == 'xl') {
        $swiper_array[] = '1200: { slidesPerView: '.$val[1].' },';
      }
      
    }

    if($type == 'array') {
      return $array;
    } else if($type == 'owl') {
      return yprm_implode($owl_array, '');
    } else if($type == 'swiper') {
      return yprm_implode($swiper_array, '');
    }

    return yprm_implode($css);
  }
}

/**
 * Get Image
 */

if (!function_exists('yprm_get_image')) {
  function yprm_get_image($id = false, $out = '', $size = 'full') {
    if(empty($id) || empty(wp_get_attachment_image($id, $size))) return false;

    $result = '';

    if($out == 'bg') {
      $result = 'background-image: url(' . esc_url(wp_get_attachment_image_src($id, $size)[0]) . ');';
    } else if($out == 'img') {
      $result = wp_get_attachment_image($id, $size);
    } else {
      $result = wp_get_attachment_image_src($id, $size);
    }


    return $result;
  }
}

/**
 * Build BG Overlay
 */

if (!function_exists('yprm_build_bg_overlay')) {
  function yprm_build_bg_overlay($atts, $block_id, $clippy = false) {
    extract(
      shortcode_atts(
        array(
          'background_image' => '',
          'background_parallax' => 'off',
          'background_parallax_align' => 'center',
          'background_parallax_speed' => '0.2',
          'bg_overlay' => 'off',
          'color_overlay' => 'off',
          'color_overlay_hex' => '',
          'color_overlay_opacity' => '',
          'circles_overlay' => 'off',
          'circles_overlay_style' => 'style1',
          'circles_overlay_opacity' => '',
          'gradient_overlay' => 'off',
          'gradient_overlay_start_hex' => '',
          'gradient_overlay_end_hex' => '',
          'video_url' => '',
          'background_video_quality' => '720p',
          'background_video_controls' => 'off',
          'background_video_autoplay' => 'on',
          'background_video_mute' => 'on',
          'background_video_playing_on' => 'auto',
          'text_overlay' => '',
          'text_overlay_top' => '',
          'text_overlay_fs' => '',
          'text_overlay_color' => '',
          'text_overlay_opacity' => '',
          'overlay_bottom_offset' => '',
          'overlay_height' => '',
          'color_change_overlay' => 'off',
          'color_change_overlay_array' => '',
        ),
        $atts
      )
    );

    if($bg_overlay != 'on' && $background_parallax != 'on' && empty($background_image) && empty($video_url)) {
      return false;
    }

    $css_code = array();
    $video_html = '';

    if (!empty($overlay_bottom_offset) && empty($overlay_height)) {
      $css_code[] = ".$block_id .bg-overlay { bottom: " . $overlay_bottom_offset . "px; }";
    }

    if (!empty($overlay_height)) {
      $css_code[] = ".$block_id .bg-overlay { height: " . $overlay_height . "px; }";
    }

    if ($color_overlay == 'on') {
      if (!empty($color_overlay_hex)) {
        $css_code[] = ".$block_id .bg-overlay .color { background-color: $color_overlay_hex }";
      }
      if (!empty($color_overlay_opacity)) {
        $css_code[] = ".$block_id .bg-overlay .color { opacity: " . ($color_overlay_opacity / 100) . " }";
      }
    }

    if ($circles_overlay == 'on' && !empty($circles_overlay_opacity)) {
      $css_code[] = ".$block_id .bg-overlay .circles { overlay: $circles_overlay_opacity }";
    }

    if ($gradient_overlay == 'on') {
      if (!empty($gradient_overlay_start_hex) && !empty($gradient_overlay_end_hex)) {
        $css_code[] = ".$block_id .bg-overlay .gradient {" .
          "  background-image: -webkit-gradient(linear, left top, left bottom, from($gradient_overlay_start_hex), to($gradient_overlay_end_hex));" .
          "  background-image: -webkit-linear-gradient(top, $gradient_overlay_start_hex 0%, $gradient_overlay_end_hex 100%);" .
          "  background-image: -o-linear-gradient(top, $gradient_overlay_start_hex 0%, $gradient_overlay_end_hex 100%);" .
          "  background-image: linear-gradient(to bottom, $gradient_overlay_start_hex 0%, $gradient_overlay_end_hex 100%);" .
          "}";
      }
    }

    if(!empty($text_overlay) && (!empty($text_overlay_top) || !empty($text_overlay_fs) || !empty($text_overlay_color) || !empty($text_overlay_opacity))) {
      $css_code[] = ".$block_id .bg-overlay .text {";
        if(!empty($text_overlay_top)) {
          $css_code[] = "top: $text_overlay_top;";
        }

        if(!empty($text_overlay_fs)) {
          $css_code[] = "font-size: $text_overlay_fs;";
        }

        if(!empty($text_overlay_color)) {
          $css_code[] = "color: $text_overlay_color;";
        }

        if(!empty($text_overlay_opacity)) {
          $css_code[] = "opacity: ".($text_overlay_opacity/100).";";
        }
      $css_code[] = "}";
    }

    if(!empty($video_url)) {
      if($background_video_mute == 'off') {
        $muted = '';
      } else {
        $muted = 'muted';
      }

      if($background_video_playing_on != 'click-in-popup')  {
        $video_html = VideoUrlParser::get_background_video($video_url, $background_video_quality, $muted, $atts);
      }

      $player_popup = VideoUrlParser::get_player($video_url);
      
      wp_enqueue_script('video');
    }

    do_action('yprm_inline_css', yprm_implode($css_code, ''));

    ob_start();
    ?>

    <div class="bg-overlay<?php echo (!empty($overlay_bottom_offset) || !empty($overlay_height)) ? ' half' : ''; ?>">
      <?php if ($img_url = yprm_get_image($background_image)) { ?>
        <?php if($background_parallax == 'on') {
          wp_enqueue_script('parallax');
        ?>
          <div class="image" data-parallax="true" data-image-src="<?php echo esc_url($img_url[0]) ?>" data-position-y="<?php echo esc_attr($background_parallax_align) ?>" data-speed="<?php echo esc_attr($background_parallax_speed) ?>"></div>
        <?php } else { ?>
          <div class="image" style="background-image: url(<?php echo esc_url($img_url[0]) ?>)"></div>
        <?php } ?>
      <?php } if (!empty($video_html) || !empty($player_popup)) { ?>
        <?php echo $video_html; ?>
        <?php if($background_video_playing_on == 'click') { ?>
          <div class="play-video" data-magic-cursor="link-w-text" data-magic-cursor-text="<?php echo yprm_get_theme_setting('tr_play') ?>" data-strings="<?php echo yprm_get_theme_setting('tr_play').'||'.yprm_get_theme_setting('tr_pause') ?>"></div>
        <?php } else if($background_video_playing_on == 'click-in-popup') { ?>
          <div class="play-video single-popup-item" data-magic-cursor="link-w-text" data-magic-cursor-text="<?php echo yprm_get_theme_setting('tr_play') ?>" data-type="video" data-size="1920x1080" data-video='<div class="wrapper"><div class="video-wrapper"><?php echo $player_popup ?></div></div>'></div>
        <?php } else if($background_video_controls == 'on') { ?>
          <div class="video-controls<?php echo ($background_video_playing_on == 'click') ? ' hide' : ''; ?>">
            <div class="button mute fa fa-volume-off<?php echo ($background_video_mute == 'on') ? '' : ' active' ?>" data-magic-cursor="link-small"><i class="fa fa-volume-up"></i></div>
            <div class="button pause fa fa-pause<?php echo ($background_video_autoplay == 'on') ? '' : ' active' ?>" data-magic-cursor="link-small"><i class="fa fa-play"></i></div>
          </div>
        <?php } ?>
      <?php } if (!empty($text_overlay)) { ?>
        <div class="circles <?php echo esc_attr($circles_overlay_style) ?>">
          <span></span>
          <span></span>
        </div>
      <?php } if (!empty($text_overlay)) { ?>
        <div class="text"><?php echo strip_tags($text_overlay) ?></div>
      <?php } if ($color_overlay == 'on') { ?>
        <div class="color"></div>
      <?php } if ($gradient_overlay == 'on') { ?>
        <div class="gradient"></div>
      <?php } if ($color_change_overlay == 'on' && !empty($color_change_overlay_array)) { ?>
        <div class="color-change" data-color="<?php echo esc_attr($color_change_overlay_array) ?>"></div>
      <?php } ?>
    </div>

    <?php
    return ob_get_clean();
  }
}

function yprm_camel_case($string) {
  return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/', '/\s+/'], '$1_$2', strip_tags($string)));
}

/**
 * Build Font Size
 */

if (!function_exists('yprm_build_font_size')) {
  function yprm_build_font_size($class, $val) {
    if(!empty($val)) {
      $val = str_replace(array('``', '`{`', '`}`'), array('"', '[', ']'), $val);
      $array = json_decode($val);
      $output = '';

      foreach($array as $key => $item) {
        if(!$item) {
          continue;
        }
        switch ($key) {
          case 'xs':
            $width = 'max-width: 575.98px';
            break;
          
          case 'sm':
            $width = 'min-width: 576px';
            break;
        
          case 'md':
            $width = 'min-width: 768px';
            break;
        
          case 'lg':
            $width = 'min-width: 992px';
            break;
        
          case 'xl':
            $width = 'min-width: 1200px';
            break;
        }


        $output .= '@media ('.$width.') {';
          $output .= $class.' {';
            $output .= 'font-size: '.$item->value.$item->size.';';
          $output .= '}';
        $output .= '}';
      }

      do_action('yprm_inline_css', $output);
    } else {
      return false;
    }
  }
}

/**
 * Build CSS Code
 */

if (!function_exists('yprm_build_css_code')) {
  function yprm_build_css_code($class, $val) {
    if(!empty($val)) {
      $val = str_replace(array('``', '`{`', '`}`'), array('"', '[', ']'), $val);
      $array = json_decode($val);
      $output = '';

      foreach($array as $key => $array_item) {
        switch ($key) {
          case 'mobile_portrait':
            $width = 'max-width: 575.98px';
            break;
          
          case 'mobile_landscape':
            $width = 'min-width: 576px';
            break;
        
          case 'tablet_portrait':
            $width = 'min-width: 768px';
            break;
        
          case 'tablet_landscape':
            $width = 'min-width: 992px';
            break;
        
          case 'desktop':
            $width = 'min-width: 1200px';
            break;
        }


        $output .= '@media ('.$width.') {';
          $output .= '.'.$class.' {';
            foreach($array_item as $key => $item) {
              if(is_numeric($item) && $key != 'z-index') {
                $item = $item.'px';
              }
              $output .= $key.': '.$item.';';
            }
          $output .= '}';
        $output .= '}';
      }

      do_action('yprm_inline_css', $output);
    } else {
      return false;
    }
  }
}

/**
 * Parse Google Font
 */

if(!function_exists('yprm_parse_google_font')) {
  function yprm_parse_google_font($array) {
    if(!$array) return false;
    
    $gf_array = $google_fonts_array = array();
    foreach(explode('|', $array) as $gf_item) {
      $gf_array[] = explode(':', $gf_item);
    }

    if($gf_array[0][0] == 'font_family') {
      $google_fonts_array['font_family_url'] = $gf_array[0][1];
      $google_fonts_array['font_family'] = explode('%3A', str_replace('%20', ' ', $gf_array[0][1]))[0];
    }

    if($gf_array[1][0] == 'font_style') {
      $google_fonts_array['font_weight'] = explode('%20', $gf_array[1][1])[0];
    }

    wp_enqueue_style('google_font_'.yprm_camel_case($google_fonts_array['font_family']), '//fonts.googleapis.com/css?family='.$google_fonts_array['font_family_url']);

    return $google_fonts_array;
  }
}

/**
 * Minify CSS
 */

if(!function_exists('yprm_minify_code')) {
  function yprm_minify_code($code){
    $code = preg_replace('/\/\*((?!\*\/).)*\*\//','',$code);
    $code = preg_replace('/\s{2,}/',' ',$code);
    $code = preg_replace('/\s*([:;{}])\s*/','$1',$code);
    $code = preg_replace('/;}/','}',$code);
    return $code;
  }
}

/**
 * Share Links
 */

if(!function_exists('yprm_share_buttons')) {
  function yprm_share_buttons($post_id = '') {
    if(empty($post_id)) return false;

		$title = get_the_title($post_id);
		$link = get_permalink($post_id);
		$links = '';

		if(yprm_get_theme_setting('share_facebook') == 'true') {
			$links .= '<a href="http://www.facebook.com/sharer.php?u='.$link.'" target="_blank"><i class="fab fa-facebook-square"></i></a>';
		}
		if(yprm_get_theme_setting('share_pinterest') == 'true') {
			$links .= '<a href="http://pinterest.com/pin/create/button/?url='.$link.'" target="_blank"><i class="fab fa-pinterest-square"></i></a>';
		}
		if(yprm_get_theme_setting('share_google_plus') == 'true') {
			$links .= '<a href="https://plus.google.com/share?url='.$link.'" target="_blank"><i class="fab fa-google-plus-square"></i></a>';
		}
		if(yprm_get_theme_setting('share_tumblr') == 'true') {
			$links .= '<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl='.$link.'&title='.$title.'" target="_blank"><i class="fab fa-tumblr-square"></i></a>';
		}
		if(yprm_get_theme_setting('share_twitter') == 'true') {
			$links .= '<a href="https://twitter.com/intent/tweet?url='.$link.'" target="_blank"><i class="fab fa-twitter-square"></i></a>';
		}

		return '<div class="social-links">'.wp_kses($links, 'post').'</div>';
  }

  function yprm_ajax_share_buttons() {
    echo yprm_share_buttons($_POST['id']);
    wp_die();
  }
  add_action( 'wp_ajax_share_buttons', 'yprm_ajax_share_buttons' );
  add_action( 'wp_ajax_nopriv_share_buttons', 'yprm_ajax_share_buttons' );
}

/**
 * Custom Fons Ajax
 */

if(!function_exists('yprm_ajax_custom_fonts')) {
  function yprm_kebab_case($string) {
    $result = str_replace(' ', '-', $string);
    $result = strtolower($result);

    return $result;
  }

  function yprm_render_result_item($array) {
    $link = '';
    if($array->type == 'google') {
      $link = 'https://fonts.google.com/specimen/'.str_replace(' ', '+', $array->family);
    } elseif($array->type == 'typekit') {
      $link = 'https://fonts.adobe.com/fonts/'.$array->slug;
    } ?>
    <div class="item" data-font-family="<?php echo strip_tags($array->family); ?>" data-type="<?php echo strip_tags($array->type); ?>">
      <div class="title"><?php echo strip_tags($array->family); ?></div>
      <div class="type"><?php echo strip_tags($array->type); ?></div>
      <div class="variants"><?php echo strip_tags($array->variants); ?></div>
      <div class="subsets"><?php echo strip_tags($array->subsets); ?></div>
      <a href="<?php echo esc_url($link) ?>" class="external-link fas fa-search<?php echo !empty($link) ? '' : ' hide'; ?>" target="_blank"></a>
      <div class="buttons">
        <?php if($array->type != 'typekit') { ?>
          <a href="#" class="button remove" data-item="<?php echo esc_attr(json_encode($array)) ?>"><?php echo esc_html__('Remove', 'pt-addons') ?></a>
        <?php } ?>
      </div>
    </div>
    <?php
  }

  function yprm_typekit_array($typekit_project_id) {
    if(empty($typekit_project_id)) return false;

    $typekit = new Typekit();

    $fonts_array = $typekit->get($typekit_project_id)['kit'];
    $result_array = array();
    
    $font_weight_change_array = array(
      'search' => array('n1', 'i1', 'n2', 'i2', 'n3', 'i3', 'n4', 'i4', 'n5', 'i5', 'n6', 'i6', 'n7', 'i7', 'n8', 'i8', 'n9', 'i9'),
      'replace' => array('100', '100 Italic', '200', '200 Italic', '300', '300 Italic', 'Regular', 'Italic', '500', '500 Italic', '600', '600 Italic', '700', '700 Italic', '800', '800 Italic', '900', '900 Italic')
    );
    
    if(isset($fonts_array['families']) && is_array($fonts_array['families']) && count($fonts_array['families']) > 0) {
      foreach($fonts_array['families'] as $item) {
        $result_array[] = array(
          'type' => 'typekit',
          'family' => $item['name'],
          'slug' => $item['slug'],
          'variants' => str_replace($font_weight_change_array['search'], $font_weight_change_array['replace'], implode(', ', $item['variations'])),
          'subsets' => false,
          'css' => $item['css_names']
        );
      }
    }
    
    if(is_array($result_array) && count($result_array) > 0) {
      return $result_array;
    } else {
      return false;
    }
  }

  function yprm_upload_dir($upload) {
    $upload['subdir'] = '/yprm_custom_fonts/tmp';
    $upload['path'] = $upload['basedir'] . $upload['subdir'];
    $upload['url'] = $upload['baseurl'] . $upload['subdir'];

    return $upload;
  }

  add_action( 'wp_ajax_custom_fonts', 'yprm_ajax_custom_fonts' );
  add_action( 'wp_ajax_typekit_fonts', 'yprm_ajax_typekit_fonts' );
  add_action( 'wp_ajax_custom_font', 'yprm_ajax_custom_font' );
  add_action( 'wp_ajax_build_custom_font', 'yprm_ajax_build_custom_font' );
  add_action( 'wp_ajax_upload_icon_font', 'yprm_ajax_upload_icon_font' );
  add_action( 'wp_ajax_delete_icon_font', 'yprm_ajax_delete_icon_font' );

  function yprm_ajax_custom_fonts() {
    $array = str_replace('\"', '"', $_POST['array']);
    $array = json_decode($array);

    echo yprm_render_result_item($array);

    wp_die();
  }

  function yprm_ajax_typekit_fonts() {
    $array = yprm_typekit_array($_POST['typekit_project_id']);
    $html = '';
    
    foreach($array as $item) {
      ob_start();
      yprm_render_result_item((object) $item);

      $html .= ob_get_clean();
    }

    $result_array = array(
      'array' => $array,
      'html' => $html
    );

    echo json_encode($result_array);

    wp_die();
  }

  function yprm_ajax_custom_font() {
    //$WP_Filesystem_Base = new WP_Filesystem_Base();

    $upload_path = wp_get_upload_dir()['basedir'].'/yprm_custom_fonts/tmp/';
    
    if(!file_exists($upload_path)){
			mkdir($upload_path, 0755, true);
		}

    $upload_overrides = array( 'test_form' => false );
    add_filter('upload_dir', 'yprm_upload_dir');
    $uploaded = wp_handle_upload( $_FILES['file'], $upload_overrides );
    remove_filter('upload_dir', 'yprm_upload_dir');

    if(isset($uploaded['file'])) {
      echo json_encode(array(
        'status' => 'completed',
        'file' => $uploaded['file']
      ));
    } else {
      echo json_encode(array(
        'status' => 'error',
        'error' => $uploaded['error']
      ));
    }

    wp_die();
  }

  function yprm_ajax_build_custom_font() {
    //$WP_Filesystem_Base = new WP_Filesystem_Base();
    $data = $_POST;
    $font_family = yprm_kebab_case($data['font_family']);
    $upload_path = wp_get_upload_dir()['basedir'].'/yprm_custom_fonts/'.$font_family;
    $tmp_path = wp_get_upload_dir()['basedir'].'/yprm_custom_fonts/tmp/';
    $fonts_array = [];
    $css_code = '';

    if(!file_exists($upload_path)){
      $mkdir = mkdir($upload_path, 0755);
    }
    
    foreach($data['fonts'] as $font) {
      $filename = basename($font);
      $new_patch = $upload_path.'/'.$filename;
      $new_patch = str_replace('\\', '\\\\', $new_patch);

      rename($font, $new_patch);
      $fonts_array[] = pathinfo($font);
    }

    $css_file = $upload_path.'/'.$font_family.'.css';
    $css_file_url =  wp_get_upload_dir()['baseurl'].'/yprm_custom_fonts/'.$font_family.'/'.$font_family.'.css';
    $css_file = fopen($css_file, 'w') or die('error');

    $css_code = "@font-face {\n";
      $css_code .= "\tfont-family: \"".$data['font_family']."\";\n";
      $css_code .= "\tsrc:";
      foreach($fonts_array as $font) {
        if($font['extension'] == 'eot') {
          $css_code .="\n\t\turl('".$font['basename']."?#iefix') format('embedded-opentype'),";
        } else if($font['extension'] == 'woff') {
          $css_code .="\n\t\turl('".$font['basename']."') format('woff'),";
        } else if($font['extension'] == 'ttf') {
          $css_code .="\n\t\turl('".$font['basename']."') format('truetype'),";
        }
      }
      $css_code = substr($css_code, 0, -1);
      $css_code .= ";\n";
      $css_code .= "\tfont-weight: normal;\n";
      $css_code .= "\tfont-style: normal;\n";
    $css_code .= "}\n";
    
    fwrite($css_file, $css_code);
    fclose($css_file);

    $array = array(
      'family' => $data['font_family'],
      'type' => 'custom font',
      'variants' => '',
      'subsets' => '',
      'css_url' => $css_file_url,
    );

    ob_start();
    yprm_render_result_item((object) $array);
    $html = ob_get_clean();

    $result_array = array(
      'html' => $html,
      'json' => json_encode($array)
    );

    echo json_encode($result_array);

    wp_die();
  }

  function yprm_ajax_upload_icon_font() {
    //$WP_Filesystem_Base = new WP_Filesystem_Base();

    $upload_path = wp_get_upload_dir()['basedir'].'/yprm_custom_fonts/tmp/';
    
    if(!file_exists($upload_path)){
			mkdir($upload_path, 0755, true);
		}

    $upload_overrides = array( 'test_form' => false );
    add_filter('upload_dir', 'yprm_upload_dir');
    $uploaded = wp_handle_upload( $_FILES['file'], $upload_overrides );
    remove_filter('upload_dir', 'yprm_upload_dir');

    $new_path = wp_get_upload_dir()['basedir'].'/yprm_custom_fonts/'.basename($uploaded['file'], '.zip').'/';
    $file_path = wp_get_upload_dir()['baseurl'].'/yprm_custom_fonts/'.basename($uploaded['file'], '.zip').'/';

    if(file_exists($new_path)) {
      wp_delete_file($uploaded['file']);
      wp_die();
      return false;
    }
    $unzip = unzip_file($uploaded['file'], $new_path);

    if($unzip) {
      wp_delete_file($uploaded['file']);
    }

    if(isset($uploaded['file'])) {
      $font_family = scandir($new_path.'fonts');
      if(is_array($font_family) && count($font_family) > 0) {
        $font_family = str_replace(array('.ttf', '.eot', '.svg', '.woff'), '', $font_family[count($font_family)-1]);
        $font_family = str_replace(array('-', '.'), array(' ', ''), $font_family);
      }

      $icon_array = array(
        'font_family' => $font_family,
        'path' => $new_path,
        'file' => esc_url($file_path.'style.css'),
        'classes' => yprm_get_class_icon_font($new_path.'style.css')
      );

      ob_start();
      yprm_preview_icon_font($icon_array);
      $html = ob_get_clean();

      ob_start();
      yprm_enqueue_icon_font($icon_array, 'link');
      $link = ob_get_clean();

      echo json_encode(array(
        'json' => $icon_array,
        'html' => $html,
        'link' => $link
      ));
    } else {
      echo json_encode(array(
        'status' => 'error',
        'error' => $uploaded['error']
      ));
    }

    wp_die();
  }

  function yprm_rmdir($dirPath) {
    if (!is_dir($dirPath)) {
      throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
      $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
      if (is_dir($file)) {
        yprm_rmdir($file);
      } else {
        unlink($file);
      }
    }
    rmdir($dirPath);
  }

  function yprm_ajax_delete_icon_font() {
    $array = json_decode('['.str_replace('\"', '"', $_POST['array']).']');
    $value = json_decode(str_replace('\"', '"', $_POST['value']));
    $result_array = [];

    $path = $value->path;
    $path = str_replace('\\/', '/', $path);

    yprm_rmdir($path);

    foreach($array as $key => $item) {
      if($item->font_family != $value->font_family) {
        $result_array[] = $item;
      }
    }

    echo str_replace(array('[', ']'), '', json_encode($result_array));

    wp_die();
  }
}

/**
 * Enqueue Fonts
 */

if(!function_exists('yprm_enqueue_fonts')) {
  function yprm_enqueue_fonts() {
    global $novo_theme;

    $array = (object) json_decode('['.$novo_theme['custom_fonts']['fonts'].']');
    $typekit = false;

    foreach($array as $font_item) {
      if($font_item->type == 'google') {
        if(get_locale() == 'ru_RU') {
          $subsets = '&subset=cyrillic';
        } else {
          $subsets = '';
        }
        $font_family = yprm_kebab_case($font_item->family);
        $font_link = '//fonts.googleapis.com/css?family='.str_replace(' ', '+', $font_item->family).':'.str_replace(array(' ') , array(''), $font_item->variants).'&display=swap'.$subsets;
      } elseif($font_item->type == 'typekit' && !$typekit && isset(yprm_get_theme_setting('custom_fonts')['typekit_project_id']) && !empty(yprm_get_theme_setting('custom_fonts')['typekit_project_id'])) {
        $font_family = 'typekit';
        $font_link = '//use.typekit.net/'.yprm_get_theme_setting('custom_fonts')['typekit_project_id'].'.css';

        $typekit = true;
      } elseif($font_item->type == 'custom font') {
        $font_family = yprm_kebab_case($font_item->family);
        $font_link = $font_item->css_url;
      } else {
        continue;
      }

      wp_enqueue_style( 'somo-'.$font_family, $font_link, time(), true);
    }
  }
}

/**
 * Build Custom Icons
 */

if(!function_exists('yprm_get_class_icon_font')) {
  function yprm_get_class_icon_font($file) {
    $css = file_get_contents($file);

    $results = array();

    preg_match_all('/(.+?)\s?\{\s?(.+?)\s?\}/', $css, $matches);
    foreach ($matches[0] AS $i => $original) {
      $results[] = str_replace(array('.', ':before'), '', $matches[1][$i]);
    }

    return implode(',', $results);
  }

  function yprm_preview_icon_font($icon_array) {
    $icon_array = (object) $icon_array;

    if(!isset($icon_array->classes) || empty($icon_array->classes)) {
      return false;
    }

    yprm_enqueue_icon_font($icon_array);

    $classes = explode(',', $icon_array->classes);
    ?>
    <div class="yprm-icon-font-grid">
      <div class="title">
        <span><?php echo strip_tags($icon_array->font_family) ?></span>
        <a href="#" data-json="<?php echo esc_attr(json_encode($icon_array)); ?>"><?php echo esc_html__('remove', 'pt-addons') ?></a>
      </div>
      <div class="items">
        <?php if(is_array($classes) && count($classes) > 0) {
          foreach($classes as $class) {
            ?>
            <div class="item">
              <i class="<?php echo esc_attr($class) ?>"></i>
            </div>
            <?php
          }
        } ?>
      </div>
    </div>
    <?php
  }

  function yprm_enqueue_icon_font($icon_array, $style = 'enqueue') {
    if(!is_array($icon_array)) return false;
    
    $icon_array = (object) $icon_array;

    if($style == 'enqueue') {
      wp_enqueue_style( 'somo-'.$icon_array->font_family, $icon_array->file, time(), true);
    } else {
      echo '<link rel="stylesheet" href="'.$icon_array->file.'" media="all">';
    }
  }
}

/**
 * Get String From
 */

if(!function_exists('yprm_get_string_from')) {
  function yprm_get_string_from($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return false;
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
  }
}

if(!function_exists('yrpm_get_l')) {
  function yrpm_get_l($word, $default = '') {
    if($word = yprm_get_theme_setting($word)) {
      return $word;
    } else {
      return $default;
    }
  }
}

/**
 * Maintenance Mode
 */

function yprm_maintenance_mode() {
	global $novo_theme;

	if(isset($novo_theme['maintenance_mode']) && $novo_theme['maintenance_mode'] == 'true' && !is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php') {
		if (!current_user_can('edit_themes') || !is_user_logged_in()) {
			require_once YPRM_PLUGINS_URL. '/include/maintenance-mode.php';
			exit();
		}
	}
}
add_action('init', 'yprm_maintenance_mode');