<?php

/**
 * Widget: Social Buttons
 */

class YPRM_Social_Buttons_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'social_links',
      esc_html__('Social links', 'pt-addons'),
      array('description' => esc_html__('Show Social Links from Theme Options', 'pt-addons'))
    );
  }

  public function widget($args, $instance) {
    $title = $instance['title'];
    if (function_exists('yprm_build_social_links') && yprm_build_social_links()) {
      echo '<div class="social-links-widget widget">';
        if (!empty($title)) {
          echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
        }
        echo '<div class="social-links">' . yprm_build_social_links() . '</div>';
      echo '</div>';
    }
  }

  public function form($instance) {
    $title = "";
    if (isset($instance['title'])) {
      $title = $instance['title'];
    }
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Heading:', 'pt-addons') ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <?php
  }

  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    return $instance;
  }
}

function YPRM_Social_Buttons_Widget() {
  register_widget('YPRM_Social_Buttons_Widget');
}
add_action('widgets_init', 'YPRM_Social_Buttons_Widget');