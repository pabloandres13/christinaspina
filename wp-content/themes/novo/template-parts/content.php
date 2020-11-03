<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package novo
 */


$class = "";

$type = yprm_get_theme_setting('blog_type');
$cols = yprm_get_theme_setting('blog_cols');

$id = get_the_ID(); 
$item = get_post($id);
setup_postdata($item);
$name = $item->post_title;
$post_author = $item->post_author;
$thumb = get_post_meta( $id, '_thumbnail_id', true );
$link = get_permalink($id);

$desc_size = '195';

if(function_exists('get_field') && !empty(get_field('short_desc'))) {
	$desc = strip_tags(strip_shortcodes(get_field('short_desc')));
} else {
	$desc = strip_tags(strip_shortcodes($item->post_content));
}

$desc = substr($desc, 0, $desc_size);
$desc = rtrim($desc, "!,.-");
$desc = substr($desc, 0, strrpos($desc, ' '))."...";

$class = "";
if(!empty($thumb)) {
	$class = " with-image";
}

if(!class_exists('WPBakeryShortCode')) {
	$class .= " min";
}

if ($type == 'horizontal') {
	$cols = 'col1';
	$desc_size = '455';
}

$desc = mb_strimwidth($desc, 0, $desc_size, '...');

switch ($cols) {
case 'col1':
	$item_col = "col-12";
	break;
case 'col2':
	$item_col = "col-12 col-sm-6 col-md-6";
	break;
case 'col3':
	$item_col = "col-12 col-sm-4 col-md-4";
	break;
case 'col4':
	$item_col = "col-12 col-sm-4 col-md-3";
	break;

default:
	$item_col = "";
	break;
}

$author_block = '
<div class="author-info-block">
	<div class="author-info-avatar" style="background-image: url('.get_avatar_url($post_author).')"></div>
	<div class="author-info-content">
		<div class="name">'.get_the_author_meta('display_name', $post_author).'</div>
		<div class="date">'.get_the_date('', $id).'</div>
	</div>
</div>
';


?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-item '.$item_col.' '.$class) ?>>
	<div class="wrap">
		<?php if(!empty($thumb)) { ?>
			<?php if($type == 'masonry') { ?>
				<div class="img">
					<?php echo $author_block; ?>
					<a href="<?php echo esc_url($link); ?>"><img src="<?php echo wp_get_attachment_image_src($thumb, 'large')[0] ?>" alt="<?php echo esc_html($name); ?>"></a>
				</div>
			<?php } else { ?>
				<div class="img">
					<?php echo $author_block; ?>
					<a href="<?php echo esc_url($link); ?>" style="background-image: url(<?php echo wp_get_attachment_image_src($thumb, 'large')[0] ?>);"></a>
				</div>
			<?php } ?>
		<?php } ?>
		<div class="content">
			<h5><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a></h5>
			<div class="date">
				<?php if(is_sticky()) { ?>
				<div class="sticky-a"><i class="basic-ui-icon-clip"></i> <span><?php echo esc_html__('Sticky ', 'novo') ?></span></div>
				<?php } ?>
				<?php echo get_the_date() ?>
			</div>
			<?php if(!class_exists('WPBakeryShortCode')) { ?>
				<div class="text"><?php the_content(); ?></div>
			<?php } else { ?>
				<p><?php echo esc_html($desc); ?></p>
			<?php } if(function_exists('wp_link_pages')) {
				wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>'));
			} ?>
		</div>
		<div class="clear"></div>
		<div class="bottom like-on comment-on">
			<?php if(function_exists('zilla_likes')){ ?>
			<div class="col"><?php echo zilla_likes($id) ?></div>
			<?php } ?>
			<div class="col"><i class="multimedia-icon-speech-bubble-1"></i> <a href="<?php echo esc_url($link); ?>#comments"><?php echo get_comments_number_text() ?></a></div>
		</div>
	</div>
</article>
<?php wp_reset_postdata(); ?> 