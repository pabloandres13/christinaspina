<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product, $post;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
  'col-12',
  'col-lg-6',
  'vc_column_container',
) );

$attachment_ids = $product->get_gallery_image_ids();

$featured_image = yprm_get_theme_setting('product_featured_image');

?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>">
  <?php if ( is_array($attachment_ids) && count($attachment_ids) > 0 && $post_thumbnail_id ) {
    if($thumb = $product->get_image_id()) {
      array_unshift($attachment_ids, $thumb);
    } 
    
    wp_enqueue_script('swiper');
    wp_enqueue_style('swiper');
  ?>
    <div class="product-image-block popup-gallery <?php echo esc_attr($featured_image) ?>">
      <div class="slider swiper-container">
        <?php if ( $product->is_on_sale() ) : ?>
          <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale accent"><span>' . esc_html__( 'Sale', 'novo' ) . '</span></span>', $post, $product ); ?>
        <?php endif; ?>
        <div class="swiper-wrapper">
          <?php foreach ( $attachment_ids as $key => $attachment_id ) { 
            $full_src = wp_get_attachment_image_src( $attachment_id, 'full' );
            $thumb_src = wp_get_attachment_image_src( $attachment_id, 'large' );
            $img_html = wp_get_attachment_image( $attachment_id, 'large' );
          ?>
            <div class="swiper-slide popup-item">
              <?php if($featured_image == 'adaptive') { ?>
                <a href="<?php echo esc_url($full_src[0]) ?>" data-size="<?php echo esc_attr($full_src[1].'x'.$full_src[2]) ?>"><?php echo $img_html ?></a>
              <?php } else { ?>
                <a href="<?php echo esc_url($full_src[0]) ?>" class="img" data-size="<?php echo esc_attr($full_src[1].'x'.$full_src[2]) ?>" style="background-image: url(<?php echo esc_url($thumb_src[0]) ?>)"></a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>
      
      <div class="thumbs">
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php foreach ( $attachment_ids as $key => $attachment_id ) { 
              $full_src = wp_get_attachment_image_src( $attachment_id, 'full' );
              $thumb_src = wp_get_attachment_image_src( $attachment_id, 'large' );
              $img_html = wp_get_attachment_image( $attachment_id, 'large' );
            ?>
              <div class="swiper-slide" style="background-image: url(<?php echo esc_url($thumb_src[0]) ?>)"></div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    
  <?php } else if ( $post_thumbnail_id ) { 
    $full_src = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
    $img_src = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
    $img_html = wp_get_attachment_image( $post_thumbnail_id, 'large' );
  ?>
    <div class="product-image popup-gallery <?php echo esc_attr($featured_image) ?>">
      <?php if ( $product->is_on_sale() ) : ?>
        <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale accent"><span>' . esc_html__( 'Sale', 'novo' ) . '</span></span>', $post, $product ); ?>
      <?php endif; ?>
      <div class="item popup-item">
        <?php if($featured_image == 'adaptive') { ?>
          <a href="<?php echo esc_url($full_src[0]) ?>" data-size="<?php echo esc_attr($full_src[1].'x'.$full_src[2]) ?>"><?php echo wp_kses($img_html, 'post') ?></a>
        <?php } else { ?>
          <a href="<?php echo esc_url($full_src[0]) ?>" class="img" data-size="<?php echo esc_attr($full_src[1].'x'.$full_src[2]) ?>" style="background-image: url(<?php echo esc_url($img_src[0]) ?>)"></a>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
</div>
