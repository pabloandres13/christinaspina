<?php
class ZillaLikes {

  public function __construct() {
    add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
    add_filter('the_content', array(&$this, 'the_content'));
    add_filter('the_excerpt', array(&$this, 'the_content'));
    add_filter('body_class', array(&$this, 'body_class'));
    add_action('publish_post', array(&$this, 'setup_likes'));
    add_action('wp_ajax_zilla-likes', array(&$this, 'ajax_callback'));
    add_action('wp_ajax_nopriv_zilla-likes', array(&$this, 'ajax_callback'));
  }

  public function enqueue_scripts() {
    $options = get_option('zilla_likes_settings');
    if (!isset($options['disable_css'])) {
      $options['disable_css'] = '0';
    }

    wp_enqueue_script('zilla-likes', plugins_url('pt-novo-shortcodes') . '/assets/js/zilla-likes.js', array('jquery'));
    wp_enqueue_script('jquery');

    wp_localize_script('zilla-likes', 'zilla_likes', array('ajaxurl' => admin_url('admin-ajax.php')));
  }

  public function the_content($content) {
    // Don't show on custom page templates
    if (is_page_template()) {
      return $content;
    }

    // Don't show on Stacked slides
    if (get_post_type() == 'slide') {
      return $content;
    }

    global $wp_current_filter;
    if (in_array('get_the_excerpt', (array)$wp_current_filter)) {
      return $content;
    }

    $options = get_option('zilla_likes_settings');
    if (!isset($options['add_to_posts'])) {
      $options['add_to_posts'] = '0';
    }

    //if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
    if (!isset($options['add_to_other'])) {
      $options['add_to_other'] = '0';
    }

    if (!isset($options['exclude_from'])) {
      $options['exclude_from'] = '';
    }

    $ids = explode(',', $options['exclude_from']);
    if (in_array(get_the_ID(), $ids)) {
      return $content;
    }

    if (is_singular('post') && $options['add_to_posts']) {
      $content .= $this->do_likes($id);
    }

    //if(is_page() && !is_front_page() && $options['add_to_pages']) $content .= $this->do_likes($id);
    if ((is_front_page() || is_home() || is_category() || is_tag() || is_author() || is_date() || is_search()) && $options['add_to_other']) {
      $content .= $this->do_likes($id);
    }

    return $content;
  }

  public function setup_likes($post_id) {
    if (!is_numeric($post_id)) {
      return;
    }

    add_post_meta($post_id, '_zilla_likes', '0', true);
  }

  public function ajax_callback($post_id) {

    $options = get_option('zilla_likes_settings');
    if (!isset($options['add_to_posts'])) {
      $options['add_to_posts'] = '0';
    }

    //if( !isset($options['add_to_pages']) ) $options['add_to_pages'] = '0';
    if (!isset($options['add_to_other'])) {
      $options['add_to_other'] = '0';
    }

    if (!isset($options['zero_postfix'])) {
      $options['zero_postfix'] = '';
    }

    if (!isset($options['one_postfix'])) {
      $options['one_postfix'] = '';
    }

    if (!isset($options['more_postfix'])) {
      $options['more_postfix'] = '';
    }

    if (isset($_POST['likes_id'])) {
      // Click event. Get and Update Count
      $post_id = str_replace('zilla-likes-', '', $_POST['likes_id']);
      echo esc_html($this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'update'));
    } else {
      // AJAXing data in. Get Count
      $post_id = str_replace('zilla-likes-', '', $_POST['post_id']);
      echo esc_html($this->like_this($post_id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'get'));
    }

    exit;
  }

  public function like_this($post_id, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get') {
    if (!is_numeric($post_id)) {
      return;
    }

    $zero_postfix = strip_tags($zero_postfix);
    $one_postfix = strip_tags($one_postfix);
    $more_postfix = strip_tags($more_postfix);

    switch ($action) {

    case 'get':
      $likes = get_post_meta($post_id, '_zilla_likes', true);
      if (!$likes) {
        $likes = 0;
        add_post_meta($post_id, '_zilla_likes', $likes, true);
      }

      if ($likes == 0) {$postfix = $zero_postfix;} elseif ($likes == 1) {$postfix = $one_postfix;} else { $postfix = $more_postfix;}

      return $likes;
      break;

    case 'update':
      $likes = get_post_meta($post_id, '_zilla_likes', true);
      
      if (isset($_COOKIE['zilla_likes_' . $post_id])) {
        return $likes;
      }

      $likes++;
      
      update_post_meta($post_id, '_zilla_likes', $likes);
      
      setcookie('zilla_likes_' . $post_id, $post_id, time() * 20, '/');
      
      if ($likes == 0) {$postfix = $zero_postfix;} elseif ($likes == 1) {$postfix = $one_postfix;} else { $postfix = $more_postfix;}

      return $likes;
      break;

    }
  }

  public function shortcode($atts) {
    extract(shortcode_atts(array(
    ), $atts));

    return $this->do_likes();
  }

  public function do_likes($id) {
    global $post;

    $options = get_option('zilla_likes_settings');
    if (!isset($options['zero_postfix'])) {
      $options['zero_postfix'] = '';
    }

    if (!isset($options['one_postfix'])) {
      $options['one_postfix'] = '';
    }

    if (!isset($options['more_postfix'])) {
      $options['more_postfix'] = '';
    }

    $output = $this->like_this($id, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix']);

    $class = 'zilla-likes';
    $title = esc_html__('Like this', 'novo');

    if (isset($_COOKIE['zilla_likes_' . $id])) {
      $class = 'zilla-likes active';
      $title = esc_html__('You already like this', 'novo');
    }
    if ($output == 0) {
      return '<a href="#" class="' . $class . '" id="zilla-likes-' . $id . '" title="' . $title . '" data-postfix="' . esc_html__(' like', 'novo') . '"><i class="multimedia-icon-heart"></i> <span>' . $output . esc_html__(' likes', 'novo') . '</span></a>';
    }if ($output == 1) {
      return '<a href="#" class="' . $class . '" id="zilla-likes-' . $id . '" title="' . $title . '" data-postfix="' . esc_html__(' like', 'novo') . '"><i class="multimedia-icon-heart"></i> <span>' . $output . esc_html__(' like', 'novo') . '</span></a>';
    } else {
      return '<a href="#" class="' . $class . '" id="zilla-likes-' . $id . '" title="' . $title . '" data-postfix="' . esc_html__(' likes', 'novo') . '"><i class="multimedia-icon-heart"></i> <span>' . $output . esc_html__(' likes', 'novo') . '</span></a>';
    }

  }

  public function body_class($classes) {
    $options = get_option('zilla_likes_settings');

    if (!isset($options['ajax_likes'])) {
      $options['ajax_likes'] = false;
    }

    if ($options['ajax_likes']) {
      $classes[] = 'ajax-zilla-likes';
    }
    return $classes;
  }

}
global $zilla_likes;
$zilla_likes = new ZillaLikes();

/**
 * Template Tag
 */
function zilla_likes($id) {
  global $zilla_likes;
  return $zilla_likes->do_likes($id);
}
