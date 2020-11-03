<?php

/**
 * Widget: About Me
 */

class YPRM_About_Me_Widget extends WP_Widget {
	 
  function __construct() {
    add_action('admin_enqueue_scripts', array($this, 'scripts'));

    parent::__construct(
      'about_me', 
      esc_html__('About Me', 'pt-addons')
    );
  }

  public function widget( $args, $instance ) {
     // Our variables from the widget settings
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
    $image = ! empty( $instance['image'] ) ? $instance['image'] : '';
    $name = ! empty( $instance['name'] ) ? $instance['name'] : '';
    $post = ! empty( $instance['post'] ) ? $instance['post'] : '';
    $description = ! empty( $instance['description'] ) ? $instance['description'] : '';
    $social_links = ! empty( $instance['social_links'] ) ? $instance['social_links'] : 'yes';

    ob_start();
    echo wp_kses_post($args['before_widget']);
    ?>

    <?php if(!empty($title)) { ?>
      <?php echo wp_kses_post($args['before_title']) ?>
        <?php echo strip_tags($title) ?>
      <?php echo wp_kses_post($args['after_title']) ?>
    <?php } ?>
    <div class="about-me-block">
      <?php if(!empty($description)) { ?>
        <div class="desc"><?php echo wp_kses_post($description) ?></div>
      <?php } ?>
      <div class="people-block">
        <?php if($image) { ?>
          <div class="avatar">
            <div style="background-image: url(<?php echo esc_url($image); ?>);"></div>
          </div>
        <?php } ?>
        <div class="content">
          <?php if(!empty($name)) { ?>
            <div class="name"><?php echo strip_tags($name) ?></div>
          <?php } if(!empty($post)) { ?>
            <div class="post"><?php echo strip_tags($post) ?></div>
          <?php } if($social_links == 'yes' && $social_links = yprm_build_social_links()) { ?>
            <div class="social-links-circle"><?php echo wp_kses_post($social_links) ?></div>
          <?php } ?>
        </div>
      </div>
    </div>

    <?php
    echo wp_kses_post($args['after_widget']);
    ob_end_flush();
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $name = ! empty( $instance['name'] ) ? $instance['name'] : '';
    $post = ! empty( $instance['post'] ) ? $instance['post'] : '';
    $description = ! empty( $instance['description'] ) ? $instance['description'] : '';
    $social_links = ! empty( $instance['social_links'] ) ? $instance['social_links'] : 'yes';
    $image = ! empty( $instance['image'] ) ? $instance['image'] : '';
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'pt-addons' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id( 'name' )); ?>"><?php echo esc_html__( 'Name:', 'pt-addons' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'name' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'name' )); ?>" type="text" value="<?php echo esc_attr( $name ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id( 'post' )); ?>"><?php echo esc_html__( 'Post:', 'pt-addons' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'post' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post' )); ?>" type="text" value="<?php echo esc_attr( $post ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php echo esc_html__( 'Description:', 'pt-addons' ); ?></label>
      <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>"><?php echo wp_kses_post( $description ); ?></textarea>
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id( 'social_links' )); ?>"><?php esc_html_e( 'Show Social Links:', 'pt-addons') ?></label>
      <select name="<?php echo esc_attr($this->get_field_name( 'social_links' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'social_links' )); ?>">
        <option value="yes" <?php echo ($social_links =='yes')?'selected':''; ?>><?php echo esc_html__('Yes' ,'pt-addons') ?></option>
        <option value="no" <?php echo ($social_links =='no')?'selected':''; ?>><?php echo esc_html__('No' ,'pt-addons') ?></option>
      </select>
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id( 'image' )); ?>"><?php echo esc_html__( 'Image:', 'pt-addons' ); ?></label>
      <div class="upload_image_block">
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" type="text" value="<?php echo esc_url( $image ); ?>" />
        <button class="upload_image_button button button-primary"><?php echo esc_html__('Upload Image', 'pt-addons') ?></button>
      </div>
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['image'] = ( ! empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';
    $instance['name'] = ( ! empty( $new_instance['name'] ) ) ? $new_instance['name'] : '';
    $instance['post'] = ( ! empty( $new_instance['post'] ) ) ? $new_instance['post'] : '';
    $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';
    $instance['social_links'] = ( ! empty( $new_instance['social_links'] ) ) ? $new_instance['social_links'] : '';

    return $instance;
  }

  public function scripts() {
    wp_enqueue_script( 'media-upload' );
    wp_enqueue_media();
  }
}

function YPRM_About_Me_Widget() {
  register_widget( 'YPRM_About_Me_Widget' );
}
add_action( 'widgets_init', 'YPRM_About_Me_Widget' );