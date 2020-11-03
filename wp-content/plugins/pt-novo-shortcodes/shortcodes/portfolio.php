<?php

// Element Description: PT Portfolio

class PT_Portfolio_Items extends WPBakeryShortCode {

  public static $g_array = array(
    'index' => 0,
    'paged' => 1,
    'count' => 0,
    'col' => 0,
  );

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_portfolio_mapping'));
    add_shortcode('pt_portfolio', array($this, 'pt_portfolio_html'));
    add_action('wp_ajax_loadmore_portfolio', array($this, 'loadmore'));
    add_action('wp_ajax_nopriv_loadmore_portfolio', array($this, 'loadmore'));
  }

  public static function get_all_portfolio_category() {
    $taxonomy = 'pt-portfolio-category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    $result[0] = "";

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        if (get_category_parents($term->term_id)) {
          $name = get_category_parents($term->term_id);
        } else {
          $name = $term->name;
        }
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  public static function get_all_portfolio_items($param = 'All') {
    $result = array();

    $args = array(
      'post_type' => 'pt-portfolio',
      'post_status' => 'publish',
      'posts_per_page' => '10000',
    );

    $porfolio_array = new WP_Query($args);
    $result[0] = "";

    if (is_array($porfolio_array->posts) && !empty($porfolio_array->posts)) {
      foreach ($porfolio_array->posts as $item) {
        $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
      }
    }

    return $result;
  }

  // Element Mapping
  public function pt_portfolio_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Portfolio", "novo"),
      "base" => "pt_portfolio",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-portfolio",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "number",
          "heading" => esc_html__("Count items", "novo"),
          "param_name" => "count_items",
          "value" => '9',
          "admin_label" => true,
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Type", "novo"),
          "param_name" => "type",
          "admin_label" => true,
          "value" => array(
            esc_html__("Grid", "novo") => "grid",
            esc_html__("Masonry", "novo") => "masonry",
            esc_html__("Flow", "novo") => "flow",
            esc_html__("Horizontal", "novo") => "horizontal",
            esc_html__("Carousel", "novo") => "carousel",
            esc_html__("Carousel Type 2", "novo") => "carousel-type2",
            esc_html__("Scattered", "novo") => "scattered",
          ),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Colums", "novo"),
          "param_name" => "cols",
          "admin_label" => true,
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '3',
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Hover animation", "novo"),
          "param_name" => "hover",
          "admin_label" => true,
          "value" => array(
            esc_html__("Content always is shown", "novo") => "none",
            esc_html__("Gallery", "novo") => "gallery",
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
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry", "flow", "horizontal")),
          "description" => esc_html__("Type \"Gallery\" only for Grid and Masonry", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Popup Gallery", "pt-addons"),
          "param_name" => "popup_gallery",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "dependency" => Array("element" => "hover", "value" => "gallery" ),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Thumbnail Size", "pt-addons"),
          "param_name" => "thumb_size",
          "description" => esc_html__("Enter image size (Example: \"thumbnail\", \"medium\", \"large\", \"full\" or other sizes defined by theme).", "pt-addons"),
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
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry", "flow", "horizontal")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Filter buttons", "novo"),
          "param_name" => "filter_buttons",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Filter buttons align", "novo"),
          "param_name" => "filter_buttons_align",
          "value" => array(
            esc_html__('Left', 'novo') => 'tal',
            esc_html__('Center', 'novo') => 'tac',
            esc_html__('Right', 'novo') => 'tar',
          ),
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Navigation", "novo"),
          "param_name" => "navigation",
          "value" => array(
            esc_html__("None", "novo") => "none",
            esc_html__("Load More", "novo") => "load_more",
            esc_html__("Load More On Scroll", "novo") => "load_more_on_scroll",
            esc_html__("Pagination", "novo") => "pagination",
          ),
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry", "scattered")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Width", "novo"),
          "param_name" => "width",
          "value" => "600",
          "dependency" => Array("element" => "type", "value" => array("horizontal")),
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
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Desc Size", "pt-addons"),
          "param_name" => "desc_size",
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Save Aspect Ratio", "novo"),
          "param_name" => "save_aspect_ratio",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => false,
          "dependency" => Array("element" => "type", "value" => array("horizontal")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Carousel navigation", "novo"),
          "param_name" => "carousel_nav",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => Array("element" => "type", "value" => array("horizontal", "carousel")),
          "group" => esc_html__("Slider Settings", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Infinite loop", "novo"),
          "param_name" => "infinite_loop",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Restart the slider automatically as it passes the last slide.", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("horizontal", "carousel")),
          "group" => esc_html__("Slider Settings", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Mousewheel", "novo"),
          "param_name" => "mousewheel",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("carousel-type2", "horizontal")),
          "group" => esc_html__("Slider Settings", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Transition speed", "novo"),
          "param_name" => "speed",
          "value" => "300",
          "min" => "100",
          "max" => "10000",
          "step" => "100",
          "suffix" => "ms",
          "description" => esc_html__("Speed at which next slide comes.", "novo"),
          "dependency" => Array("element" => "type", "value" => array("horizontal", "carousel")),
          "group" => esc_html__("Slider Settings", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay Slides", "novo"),
          "param_name" => "autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Enable Autoplay", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("horizontal", "carousel")),
          "group" => esc_html__("Slider Settings", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Autoplay Speed", "novo"),
          "param_name" => "autoplay_speed",
          "value" => "5000",
          "min" => "100",
          "max" => "10000",
          "step" => "10",
          "suffix" => "ms",
          "dependency" => Array("element" => "autoplay", "value" => array("on")),
          "group" => esc_html__("Slider Settings", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Popup mode", "novo"),
          "param_name" => "popup_mode",
          "value" => "on",
          "admin_label" => true,
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry", "flow", "horizontal", "scattered", "carousel",
          "carousel-type2")),
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
          "dependency" => Array("element" => "popup_mode", "value" => "on" ),
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
          "dependency" => Array("element" => "popup_mode", "value" => "on" ),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Project link", "novo"),
          "param_name" => "project_link",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => Array("element" => "popup_mode", "value" => array("on")),
          "default_set" => false,
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "show_heading",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("Fields", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Description", "novo"),
          "param_name" => "show_desc",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("Fields", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Categories", "novo"),
          "param_name" => "show_categories",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "type", "value" => array("carousel", "carousel-type2")),
          "group" => esc_html__("Fields", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Order by", "novo"),
          "param_name" => "orderby",
          "value" => array(
            esc_html__('Default', 'novo') => 'post__in',
            esc_html__('Author', 'novo') => 'author',
            esc_html__('Category', 'novo') => 'category',
            esc_html__('Date', 'novo') => 'date',
            esc_html__('ID', 'novo') => 'ID',
            esc_html__('Title', 'novo') => 'title',
          ),
          "group" => esc_html__("Sorting", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Order", "novo"),
          "param_name" => "order",
          "value" => array(
            esc_html__('Ascending order', 'novo') => 'ASC',
            esc_html__('Descending order', 'novo') => 'DESC',
          ),
          "group" => esc_html__("Sorting", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Source", "novo"),
          "param_name" => "source",
          "value" => array(
            esc_html__("---", "novo") => "",
            esc_html__("Items", "novo") => "items",
            esc_html__("Categories", "novo") => "categories",
          ),
          "group" => esc_html__("Source", "novo"),
        ),
        array(
          "type" => "dropdown_multi",
          "heading" => esc_html__("Items", "novo"),
          "param_name" => "items",
          "dependency" => Array("element" => "source", "value" => array("items")),
          "value" => PT_Portfolio_Items::get_all_portfolio_items(),
          "group" => esc_html__("Source", "novo"),
        ),
        array(
          "type" => "dropdown_multi",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "categories",
          "dependency" => Array("element" => "source", "value" => array("categories")),
          "value" => PT_Portfolio_Items::get_all_portfolio_category(),
          "group" => esc_html__("Source", "novo"),
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_portfolio_html($atts, $content = null) {

    // Params extraction
    extract(
      $atts = shortcode_atts(
          array(
            'uniqid' => uniqid(),
            'count_items' => '9',
            'type' => 'grid',
            'cols' => '3',
            'hover' => 'type_1',
            'hover_disable' => 'off',
            'popup_gallery' => 'on',
            'popup_mode' => 'on',
            'popup_mode_title' => 'off',
            'popup_mode_desc' => 'off',
            'project_link' => 'off',
            'filter_buttons' => 'on',
            'filter_buttons_align' => 'tal',
            'desc_size' => '45',
            'gap' => 'on',
            'thumb_size' => 'large',
            'navigation' => 'none',
            'show_heading' => 'on',
            'show_desc' => 'on',
            'show_categories' => 'on',
            'orderby' => 'post__in',
            'order' => 'ASC',
            'source' => '',
            'items' => '',
            'categories' => '',
            'source' => '',
            'save_aspect_ratio' => 'off',
            'carousel_nav' => 'off',
            'infinite_loop' => 'on',
            'mousewheel' => 'on',
            'speed' => '300',
            'autoplay' => 'on',
            'autoplay_speed' => '5000',
            'width' => '600',
          ),
          $atts
        )
    );

    $wrap_id = 'portfolio-' . $uniqid;

    if (is_front_page()) {
      self::$g_array['paged'] = $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    } else {
      self::$g_array['paged'] = $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    $tax_query = array();
    $categories_s = '';

    if (!empty($categories) && $categories != '0') {
      $categories_s = explode(',', $categories);
      $tax_query = array(
        array(
          'taxonomy' => 'pt-portfolio-category',
          'field' => 'id',
          'terms' => $categories_s,
        ),
      );
    }
    if ($items) {
      $items = explode(',', $items);
    } else {
      $items = '';
    }

    self::$g_array['count'] = $count_items;
    
    $args = array(
      'post__in' => $items,
      'posts_per_page' => $count_items,
      'paged' => $paged,
      'orderby' => $orderby,
      'order' => $order,
      'post_type' => 'pt-portfolio',
      'post_status' => 'publish',
      'tax_query' => $tax_query,
    );

    $porfolio_array = new WP_Query($args);

    $args = array(
      'post__in' => $items,
      'posts_per_page' => -1,
      'paged' => $paged,
      'orderby' => $orderby,
      'order' => $order,
      'post_type' => 'pt-portfolio',
      'post_status' => 'publish',
      'tax_query' => $tax_query,
    );

    $porfolio_l_array = new WP_Query($args);

    $loadmore_array = array();
  
    if(is_object($porfolio_l_array) && count($porfolio_l_array->posts) > 0) {
      foreach($porfolio_l_array->posts as $key => $item) {
        $loadmore_array[$key] = array(
          'id' => $item->ID
        );

        foreach (wp_get_post_terms($item->ID, 'pt-portfolio-category') as $s_item) {
          $loadmore_array[$key]['cat'][] = $s_item->slug;
        }
      }
    }

    $loadmore_array = array_slice($loadmore_array, $count_items);
    $loadmore_array = json_encode($loadmore_array);

    $max_num_pages = 0;
    $max_num_pages = $porfolio_array->max_num_pages;

    $html = '';

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
      $item_col = "";
      break;
    }

    self::$g_array['item_col'] = $item_col;

    $item_num = 0;

    if ($infinite_loop == 'on') {
      $infinite_loop = 'true';
    } else {
      $infinite_loop = 'false';
    }
    if ($autoplay == 'on') {
      $autoplay = 'true';
    } else {
      $autoplay = 'false';
    }
    if ($carousel_nav == 'on') {
      $arrows = 'true';
    } else {
      $arrows = 'false';
    }

    $category_array = array();
    if ($items && ($navigation != "load_more" || $navigation != "load_more_on_scroll")) {
      $i = 0;
      while ($porfolio_array->have_posts()): $porfolio_array->the_post();
        $id = get_the_ID();
        $category_array[$i] = array();
        foreach (wp_get_post_terms($id, 'pt-portfolio-category') as $key2 => $s_item) {
          $category_array[$i][$key2] = array('slug' => $s_item->slug, 'name' => $s_item->name);
        }
        $i++;
      endwhile;

      $arrOut = array();
      foreach ($category_array as $subArr) {
        $arrOut = array_merge($arrOut, $subArr);
      }

      $category_array = array_map('unserialize', array_unique(array_map('serialize', $arrOut)));
    } elseif (is_array($categories_s) && count($categories_s) > 0 && ($navigation != "load_more" || $navigation != "load_more_on_scroll")) {
      $args = array(
        'hide_empty' => true,
        'include' => $categories_s,
      );
      $taxonomy = 'pt-portfolio-category';
      $terms = get_terms($taxonomy, $args);
      if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $s_item) {
          $category_array[] = array('slug' => $s_item->slug, 'name' => $s_item->name);
        }
      }
    } else {
      $args = array(
        'hide_empty' => true,
      );
      $taxonomy = 'pt-portfolio-category';
      $terms = get_terms($taxonomy, $args);
      if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $s_item) {
          $category_array[] = array('slug' => $s_item->slug, 'name' => $s_item->name);
        }
      }
    }

    $wrap_classes = "";

    if ($popup_mode == 'on' && $hover != 'gallery') {
      $wrap_classes .= 'popup-gallery';
    }

    if($hover_disable == 'on') {
      $wrap_classes .= ' hover-disable';
    }

    if ($gap == 'off') {
      $wrap_classes .= ' gap-off';
    }

    if ($type == 'flow' || $type == 'horizontal' || $type == 'carousel' || $type == 'shift' || $type == 'carousel-type2' || $type == 'scattered') {
      $filter_buttons = "off";
    }

    wp_enqueue_script('imagesloaded');
    wp_enqueue_script('isotope');
    wp_enqueue_script('pt-load-posts');

    $html = '<div class="portfolio-block">';

      if (is_array($porfolio_array->posts) && count($porfolio_array->posts) > 0) {
        if (is_array($category_array) && $filter_buttons == "on" && count($category_array) > 1) {
          $html .= '<div class="filter-button-group ' . esc_attr($filter_buttons_align) . '">';
          $html .= '<button data-filter="*" class="active">' . yprm_get_theme_setting('tr_all') . '</button>';
          foreach ($category_array as $item) {
            $name = $item["name"];
            $slug = $item["slug"];
            $html .= '<button data-filter=".category-' . esc_attr($slug) . '">' . esc_html($name) . '</button>';
          }
          $html .= '</div>';
        }
        if ($type == 'flow') {
          wp_enqueue_style('flipster', get_template_directory_uri() . '/css/jquery.flipster.css');
          wp_enqueue_script('flipster', get_template_directory_uri() . '/js/jquery.flipster.min.js', array('jquery'), '', true);
          wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');
          wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
            jQuery('." . esc_attr($wrap_id) . "').flipster({
              style: 'carousel',
              loop: true,
              start: 2,
              spacing: -0.5,
              nav: false,
              buttons: true,
            });
          });");

          $html .= '<div class="portfolio-type-' . $type . ' portfolio_hover_' . $hover . ' ' . $wrap_id . ' ' . $wrap_classes . '"><ul>';
        } elseif ($type == 'horizontal') {
          wp_enqueue_style('owl-carousel');
          wp_enqueue_script('owl-carousel');
          wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');
          wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
            jQuery('." . esc_attr($wrap_id) . "').each(function(){
              var head_slider = jQuery(this);
              if(head_slider.find('.item').length > 1){
                head_slider.imagesLoaded( function() {
                  head_slider.addClass('owl-carousel').owlCarousel({
                    loop:true,
                    items:1,
                    center: true,
                    autoWidth: true,
                    nav: " . esc_js($arrows) . ",
                    dots: false,
                    autoplay: " . esc_js($autoplay) . ",
                    autoplayTimeout: " . esc_js($autoplay_speed) . ",
                    autoplayHoverPause: true,
                    smartSpeed: " . esc_js($speed) . ",
                    navClass: ['owl-prev basic-ui-icon-left-arrow','owl-next basic-ui-icon-right-arrow'],
                    navText: false,
                    margin: 30,
                    responsive:{
                      0:{
                        nav: false,
                      },
                      768:{
                        nav: " . esc_js($arrows) . ",
                      },
                    },
                  });
                  ".(($mousewheel == 'on') ? 'head_slider.on(\'mousewheel\', \'.owl-stage\', function (e) {
                    var delta = e.originalEvent.deltaY;

                    if (delta>0) {
                        head_slider.trigger(\'next.owl\');
                    } else {
                        head_slider.trigger(\'prev.owl\');
                    }
                    e.preventDefault();
                  });' : '')."
                });
              }
            });
          });");
          $html .= '<div class="portfolio-type-' . $type . ' portfolio_hover_' . $hover . ' ' . $wrap_id . ' ' . $wrap_classes . '" style="height: ' . esc_attr($width) . 'px;">';
        } elseif ($type == 'carousel') {
          wp_enqueue_style('owl-carousel');
          wp_enqueue_script('owl-carousel');
          wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');
          wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
            jQuery('." . esc_attr($wrap_id) . "').each(function(){
              var head_slider = jQuery(this);
              if(head_slider.find('.item').length > 1){
                head_slider.imagesLoaded( function() {
                  head_slider.addClass('owl-carousel').owlCarousel({
                    loop:true,
                    items:1,
                    center: true,
                    autoWidth: true,
                    nav: false,
                    dots: " . esc_js($arrows) . ",
                    autoplay: " . esc_js($autoplay) . ",
                    autoplayTimeout: " . esc_js($autoplay_speed) . ",
                    autoplayHoverPause: true,
                    smartSpeed: " . esc_js($speed) . ",
                    navText: false,
                    margin: 30,
                    responsive:{
                      0:{
                        nav: false,
                      },
                      768:{
                        nav: " . esc_js($arrows) . ",
                      },
                    },
                  });
                });
              }
            });
          });");
          $html .= '<div class="portfolio-type-' . $type . ' ' . $wrap_id . ' ' . $wrap_classes . '">';
        } elseif ($type == 'carousel-type2') {
          wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');
          wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
            var \$portfolio_carousel = jQuery('.$wrap_id'),
            \$portfolio_carousel_swiper = new Swiper(\$portfolio_carousel.find('.swiper-container'), {
              slidesPerView: 'auto',
              spaceBetween: 30,
              breakpoints: {
                576: {
                  autoHeight: true
                }
              },
              ".(($mousewheel == 'on') ? 'mousewheel: {},' : '')."
            });
          });");

          wp_enqueue_script('swiper');
          wp_enqueue_style('swiper');
          $html .= '<div class="portfolio-block portfolio-type-carousel2 ' . $wrap_id . ' ' . $wrap_classes . '">
            <div class="swiper-container">
              <div class="swiper-wrapper">';
        } else {
          $html .= '<div class="portfolio-items load-wrap row portfolio-type-' . $type . ' portfolio_hover_' . $hover . ' ' . $wrap_id . ' ' . $wrap_classes . '">';
        }
        $key = 0;
        $index = 0;
        $srcs = '';
        while ($porfolio_array->have_posts()): $porfolio_array->the_post();
          $id = get_the_ID();
          $item = get_post($id);
          $item_num++;
          $name = $item->post_title;
          $item_class = "";
          $categories = "";
          if (is_array(wp_get_post_terms($id, 'pt-portfolio-category'))) {
            for ($i = 0; $i < count(wp_get_post_terms($id, 'pt-portfolio-category')); $i++) {
              $item_class .= 'category-' . wp_get_post_terms($id, 'pt-portfolio-category')[$i]->slug . ' ';
              $categories .= wp_get_post_terms($id, 'pt-portfolio-category')[$i]->name . ', ';
            }
          }

          $item_class = trim($item_class, ' ');
          $categories = trim($categories, ', ');
          $thumb = get_post_meta($id, '_thumbnail_id', true);
          $image_size = 'large';
          if(yprm_get_theme_setting('lazyload') == 'true' && ($type != 'horizontal')) {
            //$image_size = 'yprm-lazyloading-placeholder';
          }
          $image = wp_get_attachment_image_src($thumb, $image_size);
          $image_original = wp_get_attachment_image_src($thumb, 'large');
          $image_full = wp_get_attachment_image_src($thumb, 'full');

          if ($popup_mode == 'off') {
            $link = get_permalink($id);
          } else {
            $link = $image_full[0];
          }

          if ($popup_mode == 'on') {
            $item_class .= ' popup-item';
          }

          if ($show_desc == 'on') {
            $desc_s = strip_tags(strip_shortcodes($item->post_content));
          } else {
            $desc_s = "";
          }

          $desc = '';
          if ($desc_s && $show_desc == 'on') {
            $desc = mb_strimwidth($desc_s, 0, $desc_size, '...');
          }

          if ($paged > 1) {
            $num = $item_num + $paged * $count_items - $count_items;
          } else {
            $num = $item_num;
          }

          $num = str_pad($num, 2, '0', STR_PAD_LEFT);

          $video_url = '';
          if (function_exists('get_field') && get_field('video_url') && $popup_mode == 'on') {
            $video_url = VideoUrlParser::get_url_embed(get_field('video_url'));
          }

          if (!empty($video_url)) {
            $item_class .= ' with-video';
          }

          if (function_exists('get_field') && get_field('project_image_position', $id)) {
            $item_class .= ' image-' . get_field('project_image_position', $id);
          }

          $link_attr = '';

          if($popup_mode_title == 'on') {
            $link_attr .= ' data-title="'.esc_attr($name).'"';
          }
          
          if($popup_mode_desc == 'on') {
            $link_attr .= ' data-desc="'.esc_attr(mb_strimwidth($desc_s, 0, yrpm_get_l('project_image_desc_size', 55), '...')).'"';
          }

          $link_attr .= ' data-like-id="'.esc_attr($id).'"';
          $link_attr .= ' data-like-count="'.get_post_meta($id, '_zilla_likes', true).'"';

          if ($type == 'flow') {
            $html .= '<li class="portfolio-item ' . esc_attr($item_class) . '">';
            $html .= '<div class="a-img" data-original="'.esc_url($image_original[0]).'">' . wp_get_attachment_image($thumb, 'full') . '</div>';
            if ($popup_mode != 'on' && post_password_required($id)) {
              $html .= '<div class="locked"><i class="fa fa-lock"></i></div>';
            } else {
              $html .= '<div class="content">';
              if ($show_heading == 'on') {
                if ($hover == 'type_5') {
                  $html .= '<h5><span>' . esc_html($num) . '</span> ' . esc_html($name) . '</h5>';
                } else {
                  $html .= '<h5>' . esc_html($name) . '</h5>';
                }
              }if ($desc && $show_desc == 'on') {
                $html .= '<p>' . esc_html($desc) . '</p>';
              }
              $html .= '</div>';
            }
            if (empty($video_url)) {
              $html .= '<a href="' . esc_url($link) . '" data-size="' . esc_attr($image[1] . 'x' . $image[2]) . '"'.$link_attr.'></a>';
            } else {
              $html .= '<a href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="960" height="640" src="' . esc_url($video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\'></a>';
            }
            $html .= '</li>';
          } elseif ($type == 'horizontal') {
            $html .= '<article class="portfolio-item item ' . esc_attr($item_class) . '" data-id="' . esc_attr($item_num - 1) . '">';
            if ($save_aspect_ratio == 'on') {
              $html .= '<div class="a-img" data-original="'.esc_url($image_original[0]).'"><img width="' . esc_attr($image[1]) . '" height="' . esc_attr($image[2]) . '" src="' . esc_url($image[0]) . '" alt="' . esc_html($name) . '" style="height: ' . esc_attr($width) . 'px;"></div>';
            } else {
              $html .= '<div class="a-img" data-original="'.esc_url($image_original[0]).'"><div style="background-image: url(' . esc_url($image[0]) . '); width: ' . esc_attr($width) . 'px;"></div></div>';
            }
            if ($popup_mode != 'on' && post_password_required($id)) {
              $html .= '<div class="locked"><i class="fa fa-lock"></i></div>';
            } else {
              $html .= '<div class="content">';
              if ($show_heading == 'on') {
                if ($hover == 'type_5') {
                  $html .= '<h5><span>' . esc_html($num) . '</span> ' . esc_html($name) . '</h5>';
                } else {
                  $html .= '<h5>' . esc_html($name) . '</h5>';
                }
              }if ($desc && $show_desc == 'on') {
                $html .= '<p>' . esc_html($desc) . '</p>';
              }
              $html .= '</div>';
            }
            if (empty($video_url)) {
              $html .= '<a href="' . esc_url($link) . '" data-size="' . esc_attr($image[1] . 'x' . $image[2]) . '"'.$link_attr.'></a>';
            } else {
              $html .= '<a href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="960" height="640" src="' . esc_url($video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\'></a>';
            }
            $html .= '</article>';
          } elseif ($type == 'carousel') {
            $html .= '<article class="portfolio-item item ' . esc_attr($item_class) . '" data-id="' . esc_attr($item_num - 1) . '">';
            $html .= '<div class="a-img" data-original="'.esc_url($image_original[0]).'"><div style="background-image: url(' . esc_url($image[0]) . ');">';
            if (!empty($video_url)) {
              $html .= '<a href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="960" height="640" src="' . esc_url($video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\' data-id="' . esc_attr($item_num - 1) . '"><i class="music-and-multimedia-play-button"></i></a>';
            } else {
              $html .= '<a href="' . esc_url($link) . '" data-size="' . esc_attr($image[1] . 'x' . $image[2]) . '" data-id="' . esc_attr($item_num - 1) . '"'.$link_attr.'></a>';
            }
            $html .= '</div></div>';
            $html .= '<div class="bottom-content">';
            if ($show_heading == 'on') {
              $html .= '<h5><a href="' . esc_url(get_permalink($id)) . '" class="permalink">' . esc_html($name) . '</a></h5>';
            }if ($categories && $show_categories == 'on') {
              $html .= '<div class="cat">' . esc_html($categories) . '</div>';
            }
            $html .= '</div>';
            $html .= '</article>';
          } elseif ($type == 'carousel-type2') {
            $html .= '<article class="swiper-slide ' . esc_attr($item_class) . '">';
              $html .= '<div class="wrap">';
                $html .= '<img width="' . esc_attr($image[1]) . '" height="' . esc_attr($image[2]) . '" src="' . esc_url($image[0]) . '" alt="' . esc_html($name) . '" style="height: ' . esc_attr($width) . 'px;">';
                $html .= '<div class="content">';
                  if($categories && $show_categories == 'on') {
                    $html .= '<div class="category">'.strip_tags($categories).'</div>';
                  }
                  if ($show_heading == 'on') {
                    $html .= '<h6 class="title">' . esc_html($name) . '</h6>';
                  }
                  if ($desc && $show_desc == 'on') {
                    $html .= '<p>' . esc_html($desc) . '</p>';
                  }
                $html .= '</div>';
                if (empty($video_url)) {
                  $html .= '<a href="' . esc_url($link) . '" data-size="' . esc_attr($image[1] . 'x' . $image[2]) . '" data-id="' . esc_attr($item_num - 1) . '"'.$link_attr.'></a>';
                } else {
                  $html .= '<a href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="960" height="640" src="' . esc_url($video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\' data-id="' . esc_attr($item_num - 1) . '"></a>';
                }
              $html .= '</div>';
            $html .= '</article>';
          } elseif ($type == 'grid' || $type == 'masonry' || $type == 'scattered') {
            $atts['id'] = get_the_ID();
            $html .= self::yprm_render_grid($atts);
          }
        endwhile;
        wp_reset_postdata();
        if ($type == 'flow') {
          $html .= '</ul></div>';
        } elseif ($type == 'carousel-type2') {
          $html .= '</div></div></div>';
        } else {
          $html .= '</div>';
        }
      }

      if ($navigation == "pagination") {
        if (function_exists('novo_wp_corenavi')) {
          $html .= novo_wp_corenavi($max_num_pages);
        } else {
          $html .= wp_link_pages();
        };
      }
      if (is_array($porfolio_array->posts) && ($navigation == "load_more" || $navigation == "load_more_on_scroll") && $max_num_pages > $paged) {
        $html .= '<div class="load-button tac"><a href="#" data-array="'.esc_attr($loadmore_array).'" data-count="'.esc_attr($count_items).'" data-atts="'.esc_attr(json_encode($atts)).'" class="button-style2 loadmore-button '.esc_attr($navigation).'"><span>' . yprm_get_theme_setting('tr_load_more') . '</span></a></div>';
      }

    $html .= '</div>';

    return $html;
  }

  public function yprm_item_array($atts) {

    $id = get_the_ID();
    if(empty($id) && isset($atts['id'])) {
      $id = $atts['id'];
    }
    $item = get_post($id);
    $css_class = $array = $categories = array();

    if (is_array($cat_array = wp_get_post_terms($id, 'pt-portfolio-category'))) {
      foreach($cat_array as $category_item) {
        $css_class[] = 'category-' . $category_item->slug;
        $categories[] = $category_item->name;
      }
    }

    if($atts['popup_mode'] == 'on') {
      $css_class[] = 'popup-item';
    }

    self::$g_array['index']++;

    if(self::$g_array['paged'] > 1) {
      $index_num = self::$g_array['index']+self::$g_array['paged']*self::$g_array['count']-self::$g_array['count'];
    } else {
      $index_num = self::$g_array['index'];
    }

    switch ($atts['cols']) {
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
        $item_col = "";
        break;
    }

    if(function_exists('get_field') && $desc = get_field('short_desc', $id)) {
      $desc = strip_tags($desc);
    } else {
      $desc = strip_tags(preg_replace( '~\[[^\]]+\]~', '', $item->post_content));
    }

    $thumb = get_post_meta($id, '_thumbnail_id', true);

    if(yprm_get_theme_setting('lazyload') == 'true') {
      $thumb_size = 'yprm-lazyloading-placeholder';
    } else {
      $thumb_size = $atts['thumb_size'];
    }

    $array['id'] = $id;
    $array['index'] = self::$g_array['index'];
    $array['index_num'] = $index_num;
    $array['item_col'] = $item_col;
    $array['css_class'] = yprm_implode($css_class);
    $array['post_title'] = $item->post_title;
    $array['post_content'] = $desc;
    $array['categories'] = yprm_implode($categories, '', ', ');
    $array['post_date'] = $item->post_date;
    $array['permalink'] = get_the_permalink($id);
    $array['image_original_array'] = wp_get_attachment_image_src($thumb, 'large');
    $array['image_original_html'] = wp_get_attachment_image($thumb, 'large');
    $array['image_array'] = wp_get_attachment_image_src($thumb, $thumb_size);
    $array['image_html'] = wp_get_attachment_image($thumb, $thumb_size);
    $array['full_image_array'] = wp_get_attachment_image_src($thumb, 'full');

    $array['project_director'] = '';
    $array['project_location'] = '';
    $array['project_duration'] = '';
    $array['project_year_created'] = '';
    $array['project_video_sourse'] = '';
    $array['project_video_url'] = '';
    $array['project_video_media'] = '';
    $array['project_short_desc'] = '';

    if(function_exists('get_field')) {
      $array['project_director'] = get_field('project_director', $id);
      $array['project_location'] = get_field('project_location', $id);
      $array['project_duration'] = get_field('project_duration', $id);
      $array['project_year_created'] = get_field('project_year_created', $id);
      $array['project_video_sourse'] = get_field('project_video_sourse', $id);
      $array['project_video_url'] = get_field('video_url', $id);
      $array['project_video_media'] = isset(get_field('project_video_media', $id)['url']) ? get_field('project_video_media', $id)['url'] : '';
      $array['project_short_desc'] = strip_tags(strip_shortcodes(get_field('project_short_desc', $id)));
    }
    
    $array['settings'] = $atts;
    $array['link_attr'] = '';

    if($atts['popup_mode_title'] == 'on') {
      $array['link_attr'] .= ' data-title="'.esc_attr($item->post_title).'"';
    }

    if($atts['popup_mode_desc'] == 'on') {
      $array['link_attr'] .= ' data-desc="'.esc_attr(mb_strimwidth($desc, 0, yrpm_get_l('project_image_desc_size', 55), '...')).'"';
    }
    
    $array['link_attr'] .= ' data-like-id="'.esc_attr($id).'"';
    $array['link_attr'] .= ' data-like-count="'.get_post_meta($id, '_zilla_likes', true).'"';

    if($array['settings']['popup_mode'] == 'on') {
      if($array['project_video_sourse'] != 'none' && (!empty($array['project_video_url']) || !empty($array['project_video_media']))) {
        if(!empty($array['project_video_url'])) {
          $video_player = VideoUrlParser::get_player($array['project_video_url']);
          $array['css_class'] .= ' with-video';
        } else if(!empty($array['project_video_media'])) {
          $video_player = VideoUrlParser::get_player($array['project_video_media']);
        }
        $array['link_html'] = '<a href="#" data-type="video" data-size="1920x1080" data-video=\'<div class="wrapper"><div class="video-wrapper">'.$video_player.'</div></div>\' data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_play').'" data-id="'.$array['index_num'].'"'.$array['link_attr'].'></a>';
        $array['link_html_bg'] = '<a href="#" style="background-image: url('.$array['image_array'][0].')" data-type="video" data-size="1920x1080" data-video=\'<div class="wrapper"><div class="video-wrapper">'.$video_player.'</div></div>\' data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_play').'" data-id="'.$array['index_num'].'"></a>';
      } else {
        $array['link_html'] = '<a href="'.esc_url($array['full_image_array'][0]).'" data-size="'.esc_attr($array['full_image_array'][1].'x'.$array['full_image_array'][2]).'" data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_view').'" data-id="'.$array['index_num'].'"'.$array['link_attr'].'></a>';
        $array['link_html_bg'] = '<a href="'.esc_url($array['full_image_array'][0]).'" style="background-image: url('.$array['image_array'][0].')" data-size="'.esc_attr($array['full_image_array'][1].'x'.$array['full_image_array'][2]).'" data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_view').'" data-id="'.$array['index_num'].'"></a>';
      }
    } else {
      $array['link_html'] = '<a href="'.esc_url($array['permalink']).'" data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_view').'" data-id="'.$array['index_num'].'"></a>';
      $array['link_html_bg'] = '<a href="'.esc_url($array['permalink']).'" style="background-image: url('.$array['image_array'][0].')" data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_view').'" data-id="'.$array['index_num'].'"></a>';
    }

    return $array;
  }

  public function yprm_render_grid($atts) {
    extract(self::yprm_item_array($atts));

    $img_gallery = '';

    if($settings['hover'] == 'gallery') {
      $css_class .= ' popup-gallery';
      $thumbnails = get_post_meta($id, 'pt_gallery', true);
      if (is_array($thumbnails) && !empty($thumbnails) && count($thumbnails) > 0) {
        $css_class .= ' with-gallery';
        $img_gallery = '<ul class="portfolio-item-gallery">';
        foreach ($thumbnails as $thumb) {
          $full_img_array = yprm_get_image($thumb, 'array', 'full');

          if ($settings['type'] == 'grid') {
            $img_gallery .= '<li class="popup-item" style="'.yprm_get_image($thumb, 'bg', 'large').'"><a href="'.esc_url($full_img_array[0]).'" data-size="'.esc_attr($full_img_array[1].'x'.$full_img_array[2]).'"></a></li>';
          } elseif ($settings['type'] == 'masonry') {
            $img_gallery .= '<li class="popup-item">'.yprm_get_image($thumb, 'img', 'large').'<a href="'.esc_url($full_img_array[0]).'" data-size="'.esc_attr($full_img_array[1].'x'.$full_img_array[2]).'"></a></li>';
          }
        }
        $img_gallery .= '</ul>';
      } else {
        $css_class .= ' popup-gallery images';
      }
    }

    if($settings['hover'] == 'gallery' && $settings['popup_gallery'] == 'off') {
      $css_class .= ' popup-gallery';
    }

    $html = '<article class="portfolio-item ' . esc_attr($css_class . ' ' . $item_col) . '">';
    $html .= '<div class="wrap">';
    if ($settings['type'] == 'grid') {
      $html .= '<div class="a-img" data-original="'.esc_url($image_original_array[0]).'"><div style="background-image: url(' . esc_url($image_array[0]) . ');"></div>'.$img_gallery.'</div>';
    } elseif ($settings['type'] == 'masonry') {
      $html .= '<div class="a-img" data-original="'.esc_url($image_original_array[0]).'">' . $image_html . ''.$img_gallery.'</div>';
    }elseif ($settings['type'] == 'scattered') {
      $html .= '<div class="a-img" data-original="'.esc_url($image_original_array[0]).'">' . $image_original_html . '</div>';
    }
    if ($settings['popup_mode'] != 'on' && post_password_required($id)) {
      $html .= '<div class="locked"><i class="fa fa-lock"></i></div>';
    } else {
      if ($settings['popup_mode'] == 'on' && $settings['project_link'] == 'on' && !post_password_required($id)) {
        $html .= '<a href="' . esc_url(get_permalink($id)) . '" class="permalink"><i class="basic-ui-icon-link"></i></a>';
      }
      $html .= '<div class="content">';
      if ($settings['show_heading'] == 'on') {
        if ($settings['hover'] == 'type_5') {
          $html .= '<h5><span>' . yprm_lead_zero($index_num) . '</span> ' . esc_html($post_title) . '</h5>';
        } else {
          $html .= '<h5>' . esc_html($post_title) . '</h5>';
        }
      }if ($post_content && $settings['show_desc'] == 'on') {
        $post_content = mb_strimwidth($post_content, 0, $settings['desc_size'], '...');
        $html .= '<p>' . esc_html($post_content) . '</p>';
      }
      $html .= '</div>';
    }
    $html .= $link_html;
    $html .= '</div>';
    $html .= '</article>';
    
    return $html;
  }

  public function loadmore() {
    $array = $_POST['array'];
    $atts = $_POST['atts'];
    $type = $_POST['type'];
    $start_index = $_POST['start_index'];

    self::$g_array['index'] = $start_index;
    
    if(is_array($array) && count($array) > 0) {
      foreach($array as $item) {
        $atts['id'] = $item['id'];
        $atts['start_index'] = $start_index;

        echo self::yprm_render_grid($atts);
      }
    } else {
      echo array(
        'return' => 'error'
      );
    }

    wp_die();
  }

}

new PT_Portfolio_Items();