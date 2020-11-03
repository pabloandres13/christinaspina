<?php

// Element Description: PT Product

if (class_exists('WooCommerce')) {
  class YPRM_Product_Items {

    public function __construct() {
      add_action('init', array($this, 'yprm_product_mapping'));
      add_shortcode('pt_product', array($this, 'yprm_product_html'));
      add_action('wp_ajax_loadmore_product', array($this, 'loadmore'));
      add_action('wp_ajax_nopriv_loadmore_product', array($this, 'loadmore'));
    }

    // Element Mapping
    public function yprm_product_mapping() {

      // Stop all if VC is not enabled
      if (!defined('WPB_VC_VERSION')) {
        return;
      }

      // Map the block with vc_map()
      vc_map(array(
        "name" => esc_html__("Products", "pt-addons"),
        "base" => "pt_product",
        "show_settings_on_create" => true,
        "icon" => "shortcode-icon-product",
        "is_container" => true,
        "category" => esc_html__("Novo Shortcodes", "pt-addons"),
        "params" => array(
          yprm_vc_uniqid(),
          array(
            "type" => "number",
            "heading" => esc_html__("Count items", "pt-addons"),
            "param_name" => "count_items",
            "value" => '9',
            "admin_label" => true
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Filter buttons", "pt-addons"),
            "param_name" => "filter_buttons",
            "value" => "on",
            "options" => array(
              "on" => array(
                "on" => esc_html__("On", "pt-addons"),
                "off" => esc_html__("Off", "pt-addons"),
              ),
            ),
            "default_set" => true,
            "dependency" => Array("element" => "type", "value" => array("grid", "packery")),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Filter buttons align", "pt-addons"),
            "param_name" => "filter_buttons_align",
            "value" => array(
              esc_html__('Left', 'pt-addons') => 'tal',
              esc_html__('Center', 'pt-addons') => 'tac',
              esc_html__('Right', 'pt-addons') => 'tar',
            ),
            "dependency" => Array("element" => "filter_buttons", "value" => "on" ),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Colums", "pt-addons"),
            "param_name" => "cols",
            "value" => array(
              esc_html__("Col 1", "pt-addons") => "1",
              esc_html__("Col 2", "pt-addons") => "2",
              esc_html__("Col 3", "pt-addons") => "3",
              esc_html__("Col 4", "pt-addons") => "4",
            ),
            "std" => '3',
            "dependency" => Array("element" => "type", "value" => array("grid") ),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Products", "pt-addons"),
            "param_name" => "sort_type",
            "value" => array(
              esc_html__("Simple Products", "pt-addons") => "d",
              esc_html__("Featured Products", "pt-addons") => "fp",
              esc_html__("Sale Products", "pt-addons") => "sp",
              esc_html__("New Products", "pt-addons") => "rp",
              esc_html__("Best-Selling Products", "pt-addons") => "bsp",
              esc_html__("Top Rated Products", "pt-addons") => "trp",
            ),
            "std" => 'd',
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Navigation", "pt-addons"),
            "param_name" => "navigation",
            "value" => array(
              esc_html__("None", "pt-addons") => "none",
              esc_html__("Pagination", "pt-addons") => "pagination",
              esc_html__("Load More", "pt-addons") => "load_more",
            ),
            "dependency" => Array("element" => "type", "value" => array("grid", "packery") ),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Order by", "pt-addons"),
            "param_name" => "orderby",
            "value" => array(
              esc_html__('Default', 'pt-addons') => 'post__in',
              esc_html__('Author', 'pt-addons') => 'author',
              esc_html__('Category', 'pt-addons') => 'category',
              esc_html__('Date', 'pt-addons') => 'date',
              esc_html__('ID', 'pt-addons') => 'ID',
              esc_html__('Title', 'pt-addons') => 'title',
            ),
            "group" => esc_html__("Sorting", "pt-addons"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Order", "pt-addons"),
            "param_name" => "order",
            "value" => array(
              esc_html__('Ascending order', 'pt-addons') => 'ASC',
              esc_html__('Descending order', 'pt-addons') => 'DESC',
            ),
            "group" => esc_html__("Sorting", "pt-addons"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Source", "pt-addons"),
            "param_name" => "source",
            "value" => array(
              esc_html__("---", "pt-addons") => "",
              esc_html__("Items", "pt-addons") => "items",
              esc_html__("Categories", "pt-addons") => "categories",
            ),
            "group" => esc_html__("Source", "pt-addons"),
          ),
          array(
            "type" => "dropdown_multi",
            "heading" => esc_html__("Items", "pt-addons"),
            "param_name" => "items",
            "dependency" => Array("element" => "source", "value" => array("items")),
            "value" => yprm_product_items(),
            "group" => esc_html__("Source", "pt-addons"),
          ),
          array(
            "type" => "dropdown_multi",
            "heading" => esc_html__("Category", "pt-addons"),
            "param_name" => "categories",
            "dependency" => Array("element" => "source", "value" => array("categories")),
            "value" => yprm_product_categories(),
            "group" => esc_html__("Source", "pt-addons"),
          ),
          yprm_add_css_animation(),
          array(
            "type" => "css_editor",
            "heading" => esc_html__("CSS box", "pt-addons"),
            "param_name" => "css",
            "edit_field_class" => "simple",
            "group" => esc_html__( "Design Options", "pt-addons" ),
          ),
        ),
      ));
    }

    private static function product_loop($query_args, $atts, $loop_name) {
      global $woocommerce_loop;
      $columns = absint($atts['columns']);
      $woocommerce_loop['columns'] = $columns;
      $woocommerce_loop['name'] = $loop_name;
      $query_args = apply_filters('woocommerce_shortcode_products_query', $query_args, $atts, $loop_name);
      $transient_name = 'wc_loop' . substr(md5(json_encode($query_args) . $loop_name), 28) . WC_Cache_Helper::get_transient_version('product_query');
      $products = get_transient($transient_name);
      if (false === $products || !is_a($products, 'WP_Query')) {
        $products = new WP_Query($query_args);
        set_transient($transient_name, $products, DAY_IN_SECONDS * 30);
      }
      woocommerce_reset_loop();
      wp_reset_postdata();
      return $products;
    }

    private static function __maybe_add_category_args($args, $category, $operator) {
      if (!empty($category)) {
        if (empty($args['tax_query'])) {
          $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
          array(
            'taxonomy' => 'product_cat',
            'terms' => array_map('sanitize_title', explode(',', $category)),
            'field' => 'id',
            'operator' => $operator,
          ),
        );
      }
      return $args;
    }

    public static function featured_products($atts) {
      $atts = shortcode_atts(array(
        'per_page' => '12',
        'columns' => '4',
        'orderby' => 'date',
        'order' => 'desc',
        'category' => '', // Slugs
         'paged' => '1',
        'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
      ), $atts, 'featured_products');
      $meta_query = WC()->query->get_meta_query();
      $tax_query = WC()->query->get_tax_query();
      $tax_query[] = array(
        'taxonomy' => 'product_visibility',
        'field' => 'name',
        'terms' => 'featured',
        'operator' => 'IN',
      );
      $query_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => $atts['per_page'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'paged' => $atts['paged'],
        'meta_query' => $meta_query,
        'tax_query' => $tax_query,
      );
      $query_args = self::__maybe_add_category_args($query_args, $atts['category'], $atts['operator']);
      return self::product_loop($query_args, $atts, 'featured_products');
    }

    public static function recent_products($atts) {
      $atts = shortcode_atts(array(
        'per_page' => '12',
        'columns' => '4',
        'orderby' => 'date',
        'order' => 'desc',
        'category' => '', // Slugs
         'paged' => '1',
        'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
      ), $atts, 'recent_products');
      $query_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => $atts['per_page'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'paged' => $atts['paged'],
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
      );
      $query_args = self::__maybe_add_category_args($query_args, $atts['category'], $atts['operator']);
      return self::product_loop($query_args, $atts, 'recent_products');
    }

    public static function sale_products($atts) {
      $atts = shortcode_atts(array(
        'per_page' => '12',
        'columns' => '4',
        'orderby' => 'title',
        'order' => 'asc',
        'category' => '', // Slugs
         'paged' => '1',
        'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
      ), $atts, 'sale_products');
      $query_args = array(
        'posts_per_page' => $atts['per_page'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'paged' => $atts['paged'],
        'no_found_rows' => 1,
        'post_status' => 'publish',
        'post_type' => 'product',
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
        'post__in' => array_merge(array(0), wc_get_product_ids_on_sale()),
      );
      $query_args = self::__maybe_add_category_args($query_args, $atts['category'], $atts['operator']);
      return self::product_loop($query_args, $atts, 'sale_products');
    }

    public static function best_selling_products($atts) {
      $atts = shortcode_atts(array(
        'per_page' => '12',
        'columns' => '4',
        'category' => '', // Slugs
         'paged' => '1',
        'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
      ), $atts, 'best_selling_products');
      $query_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => $atts['per_page'],
        'paged' => $atts['paged'],
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
      );
      $query_args = self::__maybe_add_category_args($query_args, $atts['category'], $atts['operator']);
      return self::product_loop($query_args, $atts, 'best_selling_products');
    }

    public static function top_rated_products($atts) {
      $atts = shortcode_atts(array(
        'per_page' => '12',
        'columns' => '4',
        'orderby' => 'title',
        'order' => 'asc',
        'paged' => '1',
        'category' => '', // Slugs
         'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
      ), $atts, 'top_rated_products');
      $query_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'paged' => $atts['paged'],
        'posts_per_page' => $atts['per_page'],
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
      );
      $query_args = self::__maybe_add_category_args($query_args, $atts['category'], $atts['operator']);
      add_filter('posts_clauses', array(__CLASS__, 'order_by_rating_post_clauses'));
      $return = self::product_loop($query_args, $atts, 'top_rated_products');
      remove_filter('posts_clauses', array(__CLASS__, 'order_by_rating_post_clauses'));
      return $return;
    }

    public static function products($atts) {
      $atts = shortcode_atts(array(
        'columns' => '4',
        'per_page' => '12',
        'paged' => '1',
        'orderby' => 'title',
        'order' => 'asc',
        'ids' => '',
        'skus' => '',
        'category' => '', // Slugs
         'operator' => 'IN', // Possible values are 'IN', 'NOT IN', 'AND'.
      ), $atts, 'products');
      $query_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'paged' => $atts['paged'],
        'posts_per_page' => $atts['per_page'],
        'meta_query' => WC()->query->get_meta_query(),
        'tax_query' => WC()->query->get_tax_query(),
      );
      $query_args = self::__maybe_add_category_args($query_args, $atts['category'], $atts['operator']);
      if (!empty($atts['skus'])) {
        $query_args['meta_query'][] = array(
          'key' => '_sku',
          'value' => array_map('trim', explode(',', $atts['skus'])),
          'compare' => 'IN',
        );
      }
      if (!empty($atts['ids'])) {
        $query_args['post__in'] = array_map('trim', explode(',', $atts['ids']));
      }
      return self::product_loop($query_args, $atts, 'products');
    }

    public function return_get_template_part() {

      ob_start();
      wc_get_template_part('content', 'product');
      $content = ob_get_contents();
      ob_end_clean();

      return $content;
    }

    // Element HTML
    public function yprm_product_html($atts, $content = null) {

      // Params extraction
      extract(
        $atts = shortcode_atts(
          array(
            'uniqid' => uniqid(),
            'count_items' => '9',
            'cols' => '3',
            'type' => 'grid',
            'photo_orientation' => 'portrait',
            'navigation_arrows' => 'on',
            'filter_buttons' => 'on',
            'filter_buttons_style' => 'style1',
            'filter_buttons_align' => 'tal',
            'navigation' => 'none',
            'orderby' => 'post__in',
            'order' => 'ASC',
            'source' => '',
            'items' => '',
            'categories' => '',
            'sort_type' => 'd',
            'css_animation' => '',
            'css' => ''
          ),
          $atts
        )
      );

      $block_class = $category_array = array();

      $block_class[] = $block_id = 'product-' . $uniqid;
      if (!empty($css)) {
        yprm_build_css_code($block_id, $css);
      }

      $block_class[] = yprm_get_animation_css($css_animation);

      if (is_front_page()) {
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
      } else {
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      }

      if ($source == 'items' && $items) {
        $items = $items;
      } else {
        $items = '';
      }

      if ($source == 'categories' && $categories) {
        $categories = $categories;
        $categories_s = explode(',', $categories);
      } else {
        $categories = $categories_s = '';
      }

      switch ($cols) {
        case '1':
          $item_col = "col-12";
          break;
        case '2':
          $item_col = "col-12 col-sm-6";
          $mobile_cols = "1";
          $tablet_cols = "2";
          $desktop_cols = "2";
          break;
        case '3':
          $item_col = "col-12 col-sm-6 col-md-4";
          $mobile_cols = "1";
          $tablet_cols = "2";
          $desktop_cols = "3";
          break;
        case '4':
          $item_col = "col-12 col-sm-4 col-md-4 col-lg-3";
          $mobile_cols = "1";
          $tablet_cols = "2";
          $desktop_cols = "4";
          break;
  
        default:
          $item_col = "";
          break;
      }

      $atts_array = array(
        'per_page' => $count_items,
        'paged' => $paged,
        'columns' => $cols,
        'ids' => $items,
        'category' => $categories,
        'orderby' => $orderby,
        'order' => $order,
      );

      $atts_l_array = array(
        'ids' => $items,
        'per_page' => -1,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $order,
        'category' => $categories,
      );

      if (empty($items)) {
        switch ($sort_type) {
        case 'd':
          $products = self::products($atts_array);
          $products_loadmore = self::products($atts_l_array);
          break;
        case 'fp':
          $products = self::featured_products($atts_array);
          $products_loadmore = self::featured_products($atts_l_array);
          break;
        case 'sp':
          $products = self::sale_products($atts_array);
          $products_loadmore = self::sale_products($atts_l_array);
          break;
        case 'bsp':
          $products = self::best_selling_products($atts_array);
          $products_loadmore = self::best_selling_products($atts_l_array);
          break;
        case 'trp':
          $products = self::top_rated_products($atts_array);
          $products_loadmore = self::top_rated_products($atts_l_array);
          break;
        case 'rp':
          $products = self::recent_products($atts_array);
          $products_loadmore = self::recent_products($atts_l_array);
          break;

        default:

          break;
        }
      } else {
        $products = self::products($atts_array);
        $products_loadmore = self::products($atts_l_array);
      }

      $loadmore_array = array();
  
      if(is_object($products_loadmore) && count($products_loadmore->posts) > 0) {
        foreach($products_loadmore->posts as $key => $item) {
          $loadmore_array[$key] = array(
            'id' => $item->ID
          );

          foreach (wp_get_post_terms($item->ID, 'product_cat') as $s_item) {
            $loadmore_array[$key]['cat'][] = $s_item->slug;
          }
        }
      }

      $loadmore_array = array_slice($loadmore_array, $count_items);
      $loadmore_array = json_encode($loadmore_array);

      if ($items && ($navigation != "load_more" || $navigation != "load_more_on_scroll")) {
        $i = 0;
        while ($products_loadmore->have_posts()): $products_loadmore->the_post();
          $id = get_the_ID();
          $category_array[$i] = array();
          foreach (wp_get_post_terms($id, 'product_cat') as $key2 => $s_item) {
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
        $taxonomy = 'product_cat';
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
        $taxonomy = 'product_cat';
        $terms = get_terms($taxonomy, $args);
        if (!empty($terms) && !is_wp_error($terms)) {
          foreach ($terms as $s_item) {
            $category_array[] = array('slug' => $s_item->slug, 'name' => $s_item->name);
          }
        }
      }

      $max_num_pages = $products->max_num_pages;

      wp_enqueue_script('imagesloaded');
      wp_enqueue_script('isotope');
      wp_enqueue_script('pt-load-posts');

      ob_start(); ?>

      <div class="product-block<?php echo yprm_implode($block_class) ?>">
        <div class="woocommerce">
          <?php if ($filter_buttons == "on") { ?>
            <div class="filter-button-group <?php echo esc_attr($filter_buttons_align) ?>">
              <div class="wrap">
                <button class="active" data-filter="*" data-magic-cursor="link"><span><?php echo yprm_get_theme_setting('tr_all') ?></span></button>
                <?php if (!empty($category_array) && !is_wp_error($category_array)) {
                    foreach ($category_array as $item) {
                ?>
                  <button data-filter=".product_cat-<?php echo esc_attr($item['slug']) ?>" data-magic-cursor="link"><span><?php echo esc_html($item['name']) ?></span></button>
                <?php }
              } ?>
              </div>
            </div>
          <?php } ?>
          <ul class="products isotope load-wrap row">
            <li class="grid-sizer col-1"></li>
            <?php
              global $woocommerce_loop;
              $woocommerce_loop['columns'] = $cols;

              if ($products->have_posts()) {

                while ($products->have_posts()): $products->the_post();

                  echo wc_get_template_part( 'content', 'product' );

                endwhile;

              }
              woocommerce_reset_loop();
              wp_reset_postdata();
            ?>
          </ul>

        </div>
        <?php if ($navigation == "pagination") {
          if (function_exists('yprm_wp_corenavi')) {
            echo yprm_wp_corenavi($max_num_pages);
          } else {
            wp_link_pages();
          }
        } if (is_array($products->posts) && $navigation == "load_more" && $max_num_pages > 1) { ?>
          <div class="load-button tac"><a href="#" data-array="<?php echo esc_attr($loadmore_array) ?>" data-count="<?php echo esc_attr($count_items) ?>" data-atts="<?php echo esc_attr(json_encode($atts)) ?>" class="button-style1 accent loadmore-button <?php echo esc_attr($navigation) ?>"><span><?php echo yprm_get_theme_setting('tr_load_more') ?></span></a></div>
        <?php } ?>
      </div>

      <?php return ob_get_clean();

    }

    public function loadmore() {
      $array = $_POST['array'];
      $atts = $_POST['atts'];
      $type = $_POST['type'];
      $start_index = $_POST['start_index'];
      $ids = [];

      foreach($array as $item) {
        $ids[] = $item['id'];
      }
      
      $atts_array = array(
        'ids' => implode(',', $ids),
        'per_page' => -1,
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'category' => $atts['categories'],
      );

      switch ($atts['sort_type']) {
        case 'd':
          $products = self::products($atts_array);
          break;
        case 'fp':
          $products = self::featured_products($atts_array);
          break;
        case 'sp':
          $products = self::sale_products($atts_array);
          break;
        case 'bsp':
          $products = self::best_selling_products($atts_array);
          break;
        case 'trp':
          $products = self::top_rated_products($atts_array);
          break;
        case 'rp':
          $products = self::recent_products($atts_array);
          break;

        default:
          $products = self::products($atts_array);
          break;
        }
      
      global $woocommerce_loop;
      $woocommerce_loop['columns'] = $atts['cols'];

      if ($products->have_posts()) {

        while ($products->have_posts()): $products->the_post();

          echo wc_get_template_part( 'content', 'product' );

        endwhile;

      } else {
        echo array(
          'return' => 'error'
        );
      }
      woocommerce_reset_loop();
      wp_reset_postdata();
    
  
      wp_die();
    }

  } // End Element Class

  // Element Class Init
  new YPRM_Product_Items();
}