<?php

// Element Description: PT Music Albums

class PT_Music_Album_Items extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_music_album_items_mapping'));
    add_shortcode('pt_music_album_items', array($this, 'pt_music_album_items_html'));
  }

  public function get_all_music_album_items_items() {
    $result = array();

    $args = array(
      'post_type' => 'pt-music-album',
      'post_status' => 'publish',
      'posts_per_page' => '-1',
    );

    $music_album_array = new WP_Query($args);
    $result[0] = "";

    if (!empty($music_album_array->posts)) {
      foreach ($music_album_array->posts as $item) {
        $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
      }
    }

    return $result;
  }

  // Element Mapping
  public function pt_music_album_items_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Music Albums", "sansara"),
      "base" => "pt_music_album_items",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-music-album-items",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "sansara"),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "sansara"),
          "param_name" => "uniqid",
          "value" => uniqid(),
          "group" => esc_html__("General", "sansara"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Count items", "sansara"),
          "param_name" => "count_items",
          "value" => '9',
          "admin_label" => true,
          "group" => esc_html__("General", "sansara"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Colums", "sansara"),
          "param_name" => "cols",
          "admin_label" => true,
          "value" => array(
            esc_html__("Col 1", "sansara") => "1",
            esc_html__("Col 2", "sansara") => "2",
            esc_html__("Col 3", "sansara") => "3",
            esc_html__("Col 4", "sansara") => "4",
          ),
          "std" => '3',
          "group" => esc_html__("General", "sansara"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Gap", "sansara"),
          "param_name" => "gap",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "dependency" => "",
          "default_set" => true,
          "group" => esc_html__("General", "sansara"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Navigation", "sansara"),
          "param_name" => "navigation",
          "value" => array(
            esc_html__("None", "sansara") => "none",
            esc_html__("Load More", "sansara") => "load_more",
            esc_html__("Pagination", "sansara") => "pagination",
          ),
          "group" => esc_html__("General", "sansara"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Order by", "sansara"),
          "param_name" => "orderby",
          "value" => array(
            esc_html__('Default', 'sansara') => 'post__in',
            esc_html__('Author', 'sansara') => 'author',
            esc_html__('Date', 'sansara') => 'date',
            esc_html__('ID', 'sansara') => 'ID',
            esc_html__('Title', 'sansara') => 'title',
          ),
          "group" => esc_html__("Sorting", "sansara"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Order", "sansara"),
          "param_name" => "order",
          "value" => array(
            esc_html__('Ascending order', 'sansara') => 'ASC',
            esc_html__('Descending order', 'sansara') => 'DESC',
          ),
          "group" => esc_html__("Sorting", "sansara"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Source", "sansara"),
          "param_name" => "source",
          "value" => array(
            esc_html__("---", "sansara") => "",
            esc_html__("Items", "sansara") => "items",
          ),
          "group" => esc_html__("Source", "sansara"),
        ),
        array(
          "type" => "dropdown_multi",
          "heading" => esc_html__("Items", "sansara"),
          "param_name" => "items",
          "dependency" => Array("element" => "source", "value" => array("items")),
          "value" => PT_Music_Album_Items::get_all_music_album_items_items(),
          "group" => esc_html__("Source", "sansara"),
        ),
        array(
          "type" => "animation_style",
          "heading" => esc_html__("Animation In", "sansara"),
          "param_name" => "animation",
          "group" => esc_html__("General", "sansara"),
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_music_album_items_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'count_items' => '9',
          'cols' => '3',
          'navigation' => 'none',
          'orderby' => 'post__in',
          'order' => 'ASC',
          'source' => '',
          'items' => '',
          'source' => '',
          'animation' => '',
        ),
        $atts
      )
    );

    $animation = $this->getCSSAnimation($animation);

    $wrap_id = 'portfolio-' . $uniqid;

    if (is_front_page()) {
      $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    } else {
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    if ($items) {
      $items = explode(',', $items);
    } else {
      $items = '';
    }
    $args = array(
      'post__in' => $items,
      'posts_per_page' => $count_items,
      'paged' => $paged,
      'orderby' => $orderby,
      'order' => $order,
      'post_type' => 'pt-music-album',
      'post_status' => 'publish',
    );

    $album_array = new WP_Query($args);

    $item_num = $max_num_pages = 0;
    $max_num_pages = $album_array->max_num_pages;

    $html = $wrap_classes = $custom_css = "";

    switch ($cols) {
    case '1':
      $item_col = "col-12";
      break;
    case '2':
      $item_col = "col-12 col-sm-6 col-md-6";
      $mobile_cols = "1";
      $tablet_cols = "2";
      $desktop_cols = "2";
      break;
    case '3':
      $item_col = "col-12 col-sm-4 col-md-4";
      $mobile_cols = "1";
      $tablet_cols = "2";
      $desktop_cols = "3";
      break;
    case '4':
      $item_col = "col-12 col-sm-4 col-md-3";
      $mobile_cols = "1";
      $tablet_cols = "2";
      $desktop_cols = "4";
      break;

    default:
      $item_col = "";
      break;
    }

    wp_enqueue_style('sansara-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('sansara-custom-style', $custom_css);

    $html = "";

    if (empty($gap)) {
      $gap = 'on';
    }

    if (is_array($album_array->posts) && count($album_array->posts) > 0) {
      $html .= '<div class="portfolio-items music-albums row gap-' . $gap . ' cols-' . $cols . ' ' . $wrap_id . ' ' . $wrap_classes . '">';
      while ($album_array->have_posts()): $album_array->the_post();
        $id = get_the_ID();
        $item = get_post($id);
        $name = $item->post_title;
        $thumb = get_post_meta($id, '_thumbnail_id', true);
        $image_size = 'large';
        if(yprm_get_theme_setting('lazyload') == 'true') {
          $image_size = 'yprm-lazyloading-placeholder';
        }
        $image = wp_get_attachment_image_src($thumb, $image_size);
        $image_original = wp_get_attachment_image_src($thumb, 'large');
        $image_full = wp_get_attachment_image_src($thumb, 'full');

        $link = get_permalink($id);

        $html .= '<article class="portfolio-item ' . esc_attr($item_col) . '">';
        $html .= '<div class="wrap ' . esc_attr($animation) . '">';
        $html .= '<div class="a-img" data-original="'.esc_url($image_original[0]).'"><div style="background-image: url(' . esc_url($image[0]) . ');"></div></div>';
        $html .= '</div>';
        $html .= '<a href="' . esc_url($link) . '" data-size="' . esc_attr($image[1] . 'x' . $image[2]) . '"><span></span></a>';
        $html .= '</article>';
      endwhile;
      wp_reset_postdata();
      $html .= '</div>';
    }

    if ($navigation == "pagination") {
      if (function_exists('yprm_wp_corenavi')) {
        $html .= yprm_wp_corenavi($max_num_pages);
      } else {
        $html .= wp_link_pages();
      };
    }

    if (is_array($album_array->posts) && $navigation == "load_more" && $max_num_pages > $paged) {
      $html .= '<div class="load-button tac"><a href="#" data-wrap=".' . esc_attr($wrap_id) . '" data-max="' . esc_attr($max_num_pages) . '" data-start-page="' . esc_attr($paged) . '" data-next-link="' . esc_url(next_posts($max_num_pages, false)) . '" class="button-style1 gray"><span>' . esc_html('Load more', 'sansara') . '</span></a></div>';
    }

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Music_Album_Items();