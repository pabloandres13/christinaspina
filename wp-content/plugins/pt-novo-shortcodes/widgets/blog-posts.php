<?php

/**
 * Widget: Blog Posts
 */

class YPRM_Blog_Post_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'blog_post',
      esc_html__('Blog posts', 'pt-addons'),
      array('description' => esc_html__('A list your blog post', 'pt-addons'))
    );
  }

  public function widget($args, $instance) {
    $title = $instance['title'];
    $amount = $instance['amount'];
    $orderby = $instance['orderby'];
    $order = $instance['order'];
    $display_image = $instance['display_image'];
    $display_date = $instance['display_date'];

    $post_array = get_posts(array(
      'numberposts' => $amount,
      'orderby' => $orderby,
      'order' => $order,
      'post_type' => 'post',
      'post_status' => 'publish',
    )
    );

    echo wp_kses_post($args['before_widget']);
    if (!empty($title)) {
      echo wp_kses_post($args['before_title'] . strip_tags($title) . $args['after_title']);
    }

    ?>
    <div class="blog-post-widget">
      <?php foreach ($post_array as $item) {
        setup_postdata($item);
        $id = $item->ID;
        $name = $item->post_title;

        $thumb = get_post_meta($id, '_thumbnail_id', true);
        $image_array = wp_get_attachment_image_src($thumb, 'thumbnail')[0];

        $category = '';
        if (is_array(wp_get_post_terms($id, 'category'))) {
          for ($i = 0; $i < count(wp_get_post_terms($id, 'category')); $i++) {
            $category .= wp_get_post_terms($id, 'category')[$i]->name . ', ';
          }
          $category = trim($category, ', ');
        }
      ?>
        <div class="item">
          <?php if ($display_image == "yes" && isset($image_array) && !empty($image_array)) { ?>
            <a href="<?php echo esc_url(get_permalink($id)) ?>" class="image"
            style="background-image: url(<?php echo esc_url($image_array) ?>)"></a>
          <?php } ?>
          <div class="text">
            <a href="<?php echo esc_url(get_permalink($id)) ?>" class="name"><?php echo esc_html($name) ?></a>
            <div class="blog-detail">
              <?php if ($display_date == 'yes') { ?>
                <div class="bd-item"><span><?php echo get_the_date('', $id) ?></span></div>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
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
    $orderby = "";
    if (isset($instance['orderby'])) {
      $orderby = $instance['orderby'];
    }
    $order = "";
    if (isset($instance['order'])) {
      $order = $instance['order'];
    }
    $display_image = "";
    if (isset($instance['display_image'])) {
      $display_image = $instance['display_image'];
    }
    $display_date = "";
    if (isset($instance['display_date'])) {
      $display_date = $instance['display_date'];
    }
    ?>
<p>
  <label
    for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Heading:', 'pt-addons') ?></label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
    name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
    value="<?php echo esc_attr($title); ?>" />
</p>
<p>
  <label
    for="<?php echo esc_attr($this->get_field_id('amount')); ?>"><?php esc_html_e('Number posts:', 'pt-addons') ?></label>
  <input id="<?php echo esc_attr($this->get_field_id('amount')); ?>"
    name="<?php echo esc_attr($this->get_field_name('amount')); ?>" type="number"
    value="<?php echo ($amount) ? esc_attr($amount) : '3'; ?>" size="3" />
</p>
<p>
  <label
    for="<?php echo esc_attr($this->get_field_id('orderby')); ?>"><?php esc_html_e('Order by:', 'pt-addons') ?></label>
  <select name="<?php echo esc_attr($this->get_field_name('orderby')); ?>"
    id="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
    <option value="date" <?php echo ($orderby == 'date') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Date', 'pt-addons') ?></option>
    <option value="author" <?php echo ($orderby == 'author') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Author', 'pt-addons') ?></option>
    <option value="category" <?php echo ($orderby == 'category') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Category', 'pt-addons') ?></option>
    <option value="ID" <?php echo ($orderby == 'ID') ? 'selected' : ''; ?>><?php echo esc_html__('ID', 'pt-addons') ?>
    </option>
    <option value="title" <?php echo ($orderby == 'title') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Title', 'pt-addons') ?></option>
  </select>
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php esc_html_e('Order:', 'pt-addons') ?></label>
  <select name="<?php echo esc_attr($this->get_field_name('order')); ?>"
    id="<?php echo esc_attr($this->get_field_id('order')); ?>">
    <option value="DESC" <?php echo ($order == 'DESC') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Descending order', 'pt-addons') ?></option>
    <option value="ASC" <?php echo ($order == 'ASC') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Ascending order', 'pt-addons') ?></option>
  </select>
</p>
<p>
  <label
    for="<?php echo esc_attr($this->get_field_id('display_image')); ?>"><?php esc_html_e('Image:', 'pt-addons') ?></label>
  <select name="<?php echo esc_attr($this->get_field_name('display_image')); ?>"
    id="<?php echo esc_attr($this->get_field_id('display_image')); ?>">
    <option value="yes" <?php echo ($display_image == 'yes') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Yes', 'pt-addons') ?></option>
    <option value="no" <?php echo ($display_image == 'no') ? 'selected' : ''; ?>>
      <?php echo esc_html__('No', 'pt-addons') ?></option>
  </select>
</p>
<p>
  <label
    for="<?php echo esc_attr($this->get_field_id('display_date')); ?>"><?php esc_html_e('Date:', 'pt-addons') ?></label>
  <select name="<?php echo esc_attr($this->get_field_name('display_date')); ?>"
    id="<?php echo esc_attr($this->get_field_id('display_date')); ?>">
    <option value="yes" <?php echo ($display_date == 'yes') ? 'selected' : ''; ?>>
      <?php echo esc_html__('Yes', 'pt-addons') ?></option>
    <option value="no" <?php echo ($display_date == 'no') ? 'selected' : ''; ?>>
      <?php echo esc_html__('No', 'pt-addons') ?></option>
  </select>
</p>
<?php
}

  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['amount'] = (is_numeric($new_instance['amount'])) ? $new_instance['amount'] : '2';
    $instance['orderby'] = (!empty($new_instance['orderby'])) ? $new_instance['orderby'] : 'date';
    $instance['order'] = (!empty($new_instance['order'])) ? $new_instance['order'] : 'DESC';
    $instance['display_image'] = (!empty($new_instance['display_image'])) ? $new_instance['display_image'] : 'yes';
    $instance['display_date'] = (!empty($new_instance['display_date'])) ? $new_instance['display_date'] : 'yes';
    return $instance;
  }
}

function YPRM_Blog_Post_Widget() {
  register_widget('YPRM_Blog_Post_Widget');
}
add_action('widgets_init', 'YPRM_Blog_Post_Widget');