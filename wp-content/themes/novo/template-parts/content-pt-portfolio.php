<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package novo
 */


$class = "";

$id = get_the_ID(); 
$item = get_post($id);
setup_postdata($item);
$name = $item->post_title;
$thumb = get_post_meta( $id, '_thumbnail_id', true );
$link = get_permalink($id);
$image = wp_get_attachment_image_src( $thumb , 'full' );

$desc_size = '45';

$desc = strip_tags(strip_shortcodes($item->post_content));
if(function_exists('mb_strimwidth')) {
	$desc = mb_strimwidth($desc, 0, $desc_size, '...');
}

$cols_css = '';

switch (yprm_get_theme_setting('portfolio_cols')) {
	case 'col2':
		$cols_css = 'col-12 col-sm-6';
		break;
	case 'col3':
		$cols_css = 'col-12 col-sm-6 col-md-4';
		break;
	case 'col4':
		$cols_css = 'col-12 col-sm-6 col-md-4 col-lg-3';
		break;
	default:
		$cols_css = 'col-12';
		break;
}

if(yprm_get_theme_setting('project_in_popup') == 'no') {
    $link = get_permalink($id);
} else {
    $link = wp_get_attachment_image_src( $thumb , 'full' )[0];
    $cols_css .= ' popup-item';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-item '.$cols_css) ?>>
    <div class="a-img">
    	<?php if(yprm_get_theme_setting('portfolio_style') == 'grid') { ?>
	    	<div style="background-image: url(<?php echo wp_get_attachment_image_src($thumb, 'large')[0] ?>);"></div>
	    <?php } else { ?>
	    	<?php echo wp_get_attachment_image($thumb, 'large') ?>
	    <?php } ?>
   	</div>
    <div class="content">
    	<h5><?php echo esc_html($name) ?></h5>
    	<p><?php echo esc_html($desc); ?></p>
    </div>
    <a href="<?php echo esc_url($link) ?>" data-size="<?php echo esc_attr($image[1].'x'.$image[2]) ?>"></a>
</article>
<?php wp_reset_postdata(); ?> 