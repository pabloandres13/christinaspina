<?php

/**
 * Widget: Portfolio
 */

class YPRM_Portfolio_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'portfolio',
      esc_html__('Portfolio', 'pt-addons'),
      array('description' => esc_html__('A list your portfolio items', 'pt-addons'))
    );
  }

  public function widget($args, $instance) {
    $title = $instance['title'];
    $amount = $instance['amount'];
    $cols = $instance['cols'];
    $orderby = 'date';
    if(isset($instance['orderby'])) {
      $orderby = $instance['orderby'];
    }
    $order = 'DESC';
    if(isset($instance['order'])) {
      $order = $instance['order'];
    }

    switch ($cols) {
    case '1':
      $class = "col-12";
      break;
    case '2':
      $class = "col-6 col-sm-6";
      break;
    case '3':
      $class = "col-4";
      break;
    case '4':
      $class = "col-6 col-md-3";
      break;

    default:
      $class = "";
      break;
    }

    $porfolio_array = get_posts(array(
      'numberposts' => $amount,
      'orderby' => $orderby,
      'order' => $order,
      'post_type' => 'pt-portfolio',
      'post_status' => 'publish',
    )
    );

    echo wp_kses_post($args['before_widget']);
    if (!empty($title)) {
      echo wp_kses_post($args['before_title'] . strip_tags($title) . $args['after_title']);
    }
    ?>
    <div class="gallery-module row">
      <?php foreach ($porfolio_array as $item) {
        setup_postdata($item);
        $id = $item->ID;
        $name = $item->post_title;

        $thumb = get_post_meta($id, '_thumbnail_id', true);

        $link = get_permalink($id);
      ?>
      <div class="<?php echo esc_attr($class) ?> item"><a href="<?php echo esc_url($link) ?>" data-magic-cursor="link-w-text" data-magic-cursor-text="<?php echo esc_attr(yprm_get_theme_setting('tr_view')) ?>"><?php echo wp_get_attachment_image($thumb, 'thumbnail', true, array('title' => $name)) ?></a></div>
         <?php } ?></div>
    <?php
    echo wp_kses_post($args['after_widget']);
  }

  public function form($instance) {
    $title = "";
    if (isset($instance['title'])) {
      $title = $instance['title'];
    }
    $amount = "";
    if (isset($instance['amount'])) {
      $amount = $instance['amount'];
    }
    $cols = "";
    if (isset($instance['cols'])) {
      $cols = $instance['cols'];
    }
    $orderby = "";
    if (isset($instance['orderby'])) {
      $orderby = $instance['orderby'];
    }
    $order = "";
    if (isset($instance['order'])) {
      $order = $instance['order'];
    }
    ?>
     <p>
       <label for="<?php echo esc_html($this->get_field_id('title')); ?>"><?php esc_html_e('Heading:', 'pt-addons') ?></label>
       <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_html($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
     </p>
     <p>
       <label for="<?php echo esc_html($this->get_field_id('amount')); ?>"><?php esc_html_e('Amount:', 'pt-addons') ?></label>
       <input id="<?php echo esc_html($this->get_field_id('amount')); ?>" name="<?php echo esc_html($this->get_field_name('amount')); ?>" type="number" value="<?php echo ($amount) ? esc_attr($amount) : '9'; ?>" size="3" />
     </p>
     <p>
       <label for="<?php echo esc_html($this->get_field_id('cols')); ?>"><?php esc_html_e('Cols:', 'pt-addons') ?></label>
       <input id="<?php echo esc_html($this->get_field_id('cols')); ?>" name="<?php echo esc_html($this->get_field_name('cols')); ?>" type="number" value="<?php echo ($cols) ? esc_attr($cols) : '3'; ?>" size="3" />
     </p>
     <p>
       <label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>"><?php esc_html_e('Order by:', 'pt-addons') ?></label>
       <select name="<?php echo esc_attr($this->get_field_name('orderby')); ?>" id="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
         <option value="date" <?php echo ($orderby == 'date') ? 'selected' : ''; ?>><?php echo esc_html__('Date', 'pt-addons') ?></option>
         <option value="author" <?php echo ($orderby == 'author') ? 'selected' : ''; ?>><?php echo esc_html__('Author', 'pt-addons') ?></option>
         <option value="category" <?php echo ($orderby == 'category') ? 'selected' : ''; ?>><?php echo esc_html__('Category', 'pt-addons') ?></option>
         <option value="ID" <?php echo ($orderby == 'ID') ? 'selected' : ''; ?>><?php echo esc_html__('ID', 'pt-addons') ?></option>
         <option value="title" <?php echo ($orderby == 'title') ? 'selected' : ''; ?>><?php echo esc_html__('Title', 'pt-addons') ?></option>
       </select>
     </p>
     <p>
       <label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php esc_html_e('Order:', 'pt-addons') ?></label>
       <select name="<?php echo esc_attr($this->get_field_name('order')); ?>" id="<?php echo esc_attr($this->get_field_id('order')); ?>">
         <option value="DESC"<?php echo ($order == 'DESC') ? 'selected' : ''; ?>><?php echo esc_html__('Descending order', 'pt-addons') ?></option>
         <option value="ASC"<?php echo ($order == 'ASC') ? 'selected' : ''; ?>><?php echo esc_html__('Ascending order', 'pt-addons') ?></option>
       </select>
     </p>
     <?php
}

  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['amount'] = (is_numeric($new_instance['amount'])) ? $new_instance['amount'] : '8';
    $instance['cols'] = (is_numeric($new_instance['cols'])) ? $new_instance['cols'] : '5';
    $instance['orderby'] = (!empty($new_instance['orderby'])) ? $new_instance['orderby'] : 'date';
    $instance['order'] = (!empty($new_instance['order'])) ? $new_instance['order'] : 'DESC';
    return $instance;
  }
}

function YPRM_Portfolio_Widget() {
  register_widget('YPRM_Portfolio_Widget');
}
add_action('widgets_init', 'YPRM_Portfolio_Widget');