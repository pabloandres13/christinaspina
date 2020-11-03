<?php

// Element Description: PT Blog

class PT_Blog_Items extends WPBakeryShortCode {

  public static $g_array = array(
    'index' => 0,
    'paged' => 1,
    'count' => 0,
    'col' => 0,
  );

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_blog_mapping'));
    add_shortcode('pt_blog', array($this, 'pt_blog_html'));
    add_action('wp_ajax_loadmore_blog', array($this, 'loadmore'));
    add_action('wp_ajax_nopriv_loadmore_blog', array($this, 'loadmore'));
  }

  public static function get_all_blog_category() {
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
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  public static function get_all_blog_items($param = 'All') {
    $result = array();

    $args = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => '10000',
    );

    $blog_array = new WP_Query($args);
    $result[0] = "";

    if (is_array($blog_array->posts) && !empty($blog_array->posts)) {
      foreach ($blog_array->posts as $item) {
        $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
      }
    }

    return $result;
  }

  // Element Mapping
  public function pt_blog_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Blog", "novo"),
      "base" => "pt_blog",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-blog",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Count items", "novo"),
          "param_name" => "count_items",
          "value" => '9',
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Type", "novo"),
          "param_name" => "type",
          "value" => array(
            esc_html__("Grid", "novo") => "grid",
            esc_html__("Masonry", "novo") => "masonry",
            esc_html__("Horizontal", "novo") => "horizontal",
          ),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Colums", "novo"),
          "param_name" => "cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '3',
          "dependency" => Array("element" => "type", "value" => array("grid", "masonry")),
          "group" => esc_html__("General", "novo"),
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
          "group" => esc_html__("General", "novo"),
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
          //"dependency"  => Array( "element" => "filter_buttons", "value" => array( "on" ) ),
           "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Navigation", "novo"),
          "param_name" => "navigation",
          "value" => array(
            esc_html__("None", "novo") => "none",
            esc_html__("Load More", "novo") => "load_more",
            esc_html__("Pagination", "novo") => "pagination",
          ),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Description symbols size", "novo"),
          "param_name" => "desc_size",
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Image", "novo"),
          "param_name" => "show_image",
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
          "heading" => esc_html__("Date", "novo"),
          "param_name" => "show_date",
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
          "heading" => esc_html__("Like", "novo"),
          "param_name" => "show_like",
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
          "heading" => esc_html__("Comments", "novo"),
          "param_name" => "show_comments",
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
          "heading" => esc_html__("Read More", "novo"),
          "param_name" => "show_read_more",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => false,
          "group" => esc_html__("Fields", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Author", "novo"),
          "param_name" => "show_author",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => false,
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
          "value" => PT_Blog_Items::get_all_blog_items(),
          "group" => esc_html__("Source", "novo"),
        ),
        array(
          "type" => "dropdown_multi",
          "heading" => esc_html__("Category", "novo"),
          "param_name" => "categories",
          "dependency" => Array("element" => "source", "value" => array("categories")),
          "value" => PT_Blog_Items::get_all_blog_category(),
          "group" => esc_html__("Source", "novo"),
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_blog_html($atts, $content = null) {

    // Params extraction
    extract(
      $atts = shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'count_items' => '9',
          'type' => 'grid',
          'cols' => '3',
          'desc_size' => '',
          'filter_buttons' => 'on',
          'filter_buttons_align' => 'tal',
          'navigation' => 'none',
          'show_image' => 'on',
          'show_date' => 'on',
          'show_heading' => 'on',
          'show_desc' => 'on',
          'show_like' => 'on',
          'show_comments' => 'on',
          'show_read_more' => 'off',
          'show_author' => 'off',
          'orderby' => 'post__in',
          'order' => 'ASC',
          'source' => '',
          'items' => '',
          'categories' => '',
          'source' => '',
        ),
        $atts
      )
    );

    $wrap_id = 'blog-' . $uniqid;

    if (is_front_page()) {
      self::$g_array['paged'] = $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    } else {
      self::$g_array['paged'] = $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    $tax_query = array();

    $categories_s = array();

    if (!empty($categories) && $categories != '0') {
      $categories_s = explode(',', $categories);
      $tax_query = array(
        array(
          'taxonomy' => 'category',
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
      'post_type' => 'post',
      'post_status' => 'publish',
      'tax_query' => $tax_query,
    );

    $blog_array = new WP_Query($args);

    $args = array(
      'post__in' => $items,
      'posts_per_page' => -1,
      'paged' => $paged,
      'orderby' => $orderby,
      'order' => $order,
      'post_type' => 'post',
      'post_status' => 'publish',
      'tax_query' => $tax_query,
    );

    $blog_l_array = new WP_Query($args);

    $loadmore_array = array();
  
    if(is_object($blog_l_array) && count($blog_l_array->posts) > 0) {
      foreach($blog_l_array->posts as $key => $item) {
        $loadmore_array[$key] = array(
          'id' => $item->ID
        );

        foreach (wp_get_post_terms($item->ID, 'category') as $s_item) {
          $loadmore_array[$key]['cat'][] = $s_item->slug;
        }
      }
    }

    $loadmore_array = array_slice($loadmore_array, $count_items);
    $loadmore_array = json_encode($loadmore_array);

    $max_num_pages = 0;
    $max_num_pages = $blog_array->max_num_pages;

    $html = '';

    if ($type == 'horizontal') {
      $cols = '1';
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
      $item_col = "";
      break;
    }

    self::$g_array['item_col'] = $item_col;

    $item_num = 0;
    
    $category_array = array();
    if ($items) {
      $i = 0;
      while ($blog_array->have_posts()): $blog_array->the_post();
        $id = get_the_ID();
        $category_array[$i] = array();
        foreach (wp_get_post_terms($id, 'category') as $key2 => $s_item) {
          $category_array[$i][$key2] = array('slug' => $s_item->slug, 'name' => $s_item->name);
        }
        $i++;
      endwhile;

      $arrOut = array();
      foreach ($category_array as $subArr) {
        $arrOut = array_merge($arrOut, $subArr);
      }

      $category_array = array_map('unserialize', array_unique(array_map('serialize', $arrOut)));
    } elseif (is_array($categories_s) && count($categories_s) > 0) {
      $args = array(
        'hide_empty' => true,
        'include' => $categories_s,
      );
      $taxonomy = 'category';
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
      $taxonomy = 'category';
      $terms = get_terms($taxonomy, $args);
      if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $s_item) {
          $category_array[] = array('slug' => $s_item->slug, 'name' => $s_item->name);
        }
      }
    }

    wp_enqueue_script('imagesloaded');
    wp_enqueue_script('isotope');
    wp_enqueue_script('pt-load-posts');

    $wrap_classes = "";

    $html = '<div class="blog-block">';

      if (is_array($blog_array->posts) && count($blog_array->posts) > 0) {
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
        $html .= '<div class="blog-items load-wrap row blog-type-' . $type . ' ' . $wrap_id . ' ' . $wrap_classes . '">';
        while ($blog_array->have_posts()): $blog_array->the_post();
          $id = get_the_ID();
          $item = get_post($id);
          $item_num++;
          $name = $item->post_title;
          $item_class = "";
          if (is_array(wp_get_post_terms($id, 'category'))) {
            for ($i = 0; $i < count(wp_get_post_terms($id, 'category')); $i++) {
              $item_class .= 'category-' . wp_get_post_terms($id, 'category')[$i]->slug . ' ';
            }
          }

          $atts['id'] = $id;

          $item_class = trim($item_class, ' ');

          $html .= self::yprm_render_grid($atts);
          
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
      if (is_array($blog_array->posts) && $navigation == "load_more" && $max_num_pages > $paged) {
        $html .= '<div class="load-button tac"><a href="#" data-array="'.esc_attr($loadmore_array).'" data-count="'.esc_attr($count_items).'" data-atts="'.esc_attr(json_encode($atts)).'" class="button-style1 loadmore-button"><span>' . yprm_get_theme_setting('tr_load_more') . '</span></a></div>';
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

    if (is_array($cat_array = wp_get_post_terms($id, 'category'))) {
      foreach($cat_array as $category_item) {
        $css_class[] = 'category-' . $category_item->slug;
        $categories[] = $category_item->name;
      }
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

    if (!empty($desc_size)) {
    } elseif ($atts['type'] == 'horizontal') {
      $desc_size = '455';
    } else {
      $desc_size = '195';
    }
    if(function_exists('get_field') && $desc = get_field('short_desc', $id)) {
      $desc = strip_tags($desc);
    } else {
      $desc = strip_tags(preg_replace( '~\[[^\]]+\]~', '', $item->post_content));
    }

    if(yprm_get_theme_setting('lazyload') == 'true') {
      $thumb_size = 'yprm-lazyloading-placeholder';
    } else {
      $thumb_size = 'large';
    }

    $thumb = get_post_meta($id, '_thumbnail_id', true);

    $array['id'] = $id;
    $array['index'] = self::$g_array['index'];
    $array['post_author'] = $item->post_author;
    $array['index_num'] = $index_num;
    $array['item_col'] = $item_col;
    $array['css_class'] = yprm_implode($css_class);
    $array['post_title'] = $item->post_title;
    $array['post_content'] = mb_strimwidth($desc, 0, $desc_size, '...');
    $array['categories'] = yprm_implode($categories, '', ', ');
    $array['post_date'] = $item->post_date;
    $array['permalink'] = get_the_permalink();
    $array['image_array'] = wp_get_attachment_image_src($thumb, $thumb_size);
    $array['image_html'] = wp_get_attachment_image($thumb, $thumb_size);
    $array['image_original_array'] = wp_get_attachment_image_src($thumb, 'large');
    $array['image_original_html'] = wp_get_attachment_image($thumb, 'large');
    $array['full_image_array'] = wp_get_attachment_image_src($thumb, 'full');
    
    $array['settings'] = $atts;
    $array['link_attr'] = '';

    $array['link_html'] = '<a href="'.esc_url($array['permalink']).'" data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_view').'" data-id="'.$array['index_num'].'"></a>';
    $array['link_html_bg'] = '<a href="'.esc_url($array['permalink']).'" style="background-image: url('.$array['image_array'][0].')" data-magic-cursor="link-w-text" data-magic-cursor-text="'.yprm_get_theme_setting('tr_view').'" data-id="'.$array['index_num'].'"></a>';

    return $array;
  }

  public function yprm_render_grid($atts) {
    extract(self::yprm_item_array($atts));

    if($settings['type'] == 'horizontal') {
      $item_col = 'col-12';
    }

    if(!empty($image_html)) {
      $css_class .= ' with-image';
    }

    //var_dump($atts);

    $author_block = '
    <div class="author-info-block">
      <div class="author-info-avatar" style="background-image: url('.get_avatar_url($post_author).')"></div>
      <div class="author-info-content">
        <div class="name">'.get_the_author_meta('display_name', $post_author).'</div>
        '.($settings['show_date'] == 'on' ? '<div class="date">'.get_the_date('', $id).'</div>' : '').'
      </div>
    </div>
    ';

    if($settings['show_author'] != 'on') {
      $author_block = '';
    }

    $html = '<article class="blog-item ' . esc_attr($css_class . ' ' . $item_col) . '">';
    $html .= '<div class="wrap">';
    if (isset($image_array[0]) && !empty($image_array[0]) && empty($video_url)) {
      if ($settings['type'] == 'masonry') {
        $html .= '<div class="img">'.$author_block.'<a href="' . esc_url(get_permalink($id)) . '" data-original="'.esc_url($image_original_array[0]).'">' . $image_html . '</a></div>';
      } else {
        $html .= '<div class="img" data-original="'.esc_url($image_original_array[0]).'">'.$author_block.'<a href="' . esc_url(get_permalink($id)) . '" style="background-image: url(' . esc_url($image_array[0]) . ');"></a></div>';
      }
    } elseif (!empty($video_url)) {
      $html .= '<div class="video"><iframe src="' . esc_url($video_url) . '" frameborder="0"></iframe></div>';
    }
    $html .= '<div class="content">';
    if (post_password_required($id)) {
      $html .= '<div class="locked"><i class="fa fa-lock"></i></div>';
    }
    if ($settings['show_heading'] == 'on') {
      $html .= '<h5><a href="' . esc_url(get_permalink($id)) . '">' . esc_html($post_title) . '</a></h5>';
    }if ($settings['show_date'] == 'on' && !$author_block) {
      $html .= '<div class="date">' . get_the_date('', $id) . '</div>';
    }if ($post_content && $settings['show_desc'] == 'on') {
      $html .= '<p>' . esc_html($post_content) . '</p>';
    }
    if($settings['show_read_more'] == 'on') {
      $html .= '<a href="' . esc_url(get_permalink($id)) . '" class="button-style2">'.yrpm_get_l('tr_read_more', esc_html__('Read More', 'novo')).'</a>';
    }
    $html .= '</div>';
    if ($settings['show_like'] == 'on' || $settings['show_comments'] == 'on') {
      $html .= '<div class="clear"></div>';
      $html .= '<div class="bottom like-' . $settings['show_like'] . ' comment-' . $settings['show_comments'] . '">';
      if ($settings['show_like'] == 'on' && function_exists('zilla_likes')) {
        $html .= '<div class="col">' . zilla_likes($id) . '</div>';
      }
      if ($settings['show_comments'] == 'on') {
        $html .= '<div class="col"><i class="multimedia-icon-speech-bubble-1"></i> <a href="' . esc_url(get_permalink($id)) . '#comments">' . get_comments_number_text() . '</a></div>';
      }
      $html .= '</div>';
    }
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
} // End Element Class

// Element Class Init
new PT_Blog_Items();