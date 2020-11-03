<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="all" class="site">
			<?php if(yprm_get_theme_setting('preloader_show') == 'true' && yprm_get_theme_setting('preloader_type') == 'words' && !empty(yprm_get_theme_setting('preloader_static_word'))) { 
        $words_html = '';
        $words_count = 0;
        if($word = yprm_get_theme_setting('preloader_dinamic_word_1')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_2')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_3')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_4')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_5')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        }
      ?>
				<div class="preloader">
					<div class="preloader_content">
						<div class="preloader_content__container">
							<p class="preloader_content__container__text"><?php echo strip_tags(yprm_get_theme_setting('preloader_static_word')) ?></p>
							<?php if($words_count > 0) { ?>
								<ul class="preloader_content__container__list count_<?php echo esc_attr($words_count) ?>">
									<?php echo wp_kses_post($words_html) ?>
								</ul>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } if(yprm_get_theme_setting('preloader_show') == 'true' && yprm_get_theme_setting('preloader_type') == 'image' && isset(yprm_get_theme_setting('preloader_img')['background-image'])) { ?>
				<div class="preloader">
					<div class="preloader_img"><img src="<?php echo esc_url(yprm_get_theme_setting('preloader_img')['background-image']) ?>" alt="<?php echo get_bloginfo( 'name' ) ?>"></div>
				</div>
			<?php } if(yprm_get_theme_setting('header_style') == 'logo_left' || yprm_get_theme_setting('header_style') == 'logo_center') { ?>
				<header class="site-header<?php echo esc_attr(yprm_header_class()) ?> main-row">
					<div class="<?php echo esc_attr(yprm_get_theme_setting('header_container')) ?>">
						<?php if(is_active_sidebar('sidebar')) { ?>
							<div class="side-bar-button multimedia-icon-list"></div>
						<?php } ?>
						<div class="logo"><?php echo yprm_site_logo(); ?></div>
						<div class="fr">
							<?php if(has_nav_menu('navigation') && yprm_get_theme_setting('navigation_type') != 'disabled') { ?>
								<nav class="navigation <?php echo esc_attr(yprm_get_theme_setting('navigation_type').' hover-'.yprm_get_theme_setting('navigation_item_hover_style')) ?>"><?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?></nav>
								<div class="butter-button nav-button <?php echo esc_attr(yprm_get_theme_setting('navigation_type')) ?>">
									<div></div>
								</div>
							<?php } if((yprm_get_theme_setting('header_cart') == 'yes' || yprm_get_theme_setting('header_cart') == 'true') && class_exists( 'WooCommerce' )) { ?>
								<div class="header-minicart woocommerce header-minicart-novo">
									<?php global $woocommerce;
									$count = $woocommerce->cart->cart_contents_count;
									if($count == 0) { ?>
									<div class="hm-count empty"><i class="base-icon-minicart"></i></div>
									<?php } else { ?>
									<a class="hm-count" href="<?php echo esc_url(wc_get_cart_url()) ?>"><i class="base-icon-minicart"></i><span><?php echo esc_html($count) ?></span></a>
									<?php } ?>
									<div class="minicart-wrap">
										<?php woocommerce_mini_cart(); ?>
									</div>
								</div>
							<?php } if(yprm_get_theme_setting('header_search') == 'yes' || yprm_get_theme_setting('header_search') == 'true') { ?>
								<div class="search-button"><i class="basic-ui-icon-search"></i></div>
							<?php } ?>
						</div>
					</div>
				</header>
			<?php } else if(yprm_get_theme_setting('header_style') == 'logo_center_t2') { ?>
				<header class="site-header<?php echo esc_attr(yprm_header_class()) ?> main-row">
					<div class="<?php echo esc_attr(yprm_get_theme_setting('header_container')) ?>">
						<?php if(is_active_sidebar('sidebar')) { ?>
							<div class="side-bar-button multimedia-icon-list"></div>
						<?php } if(yprm_get_theme_setting('header_search') == 'yes' || yprm_get_theme_setting('header_search') == 'true') { ?>
							<div class="search-button"><i class="basic-ui-icon-search"></i></div>
						<?php } ?>
						<div class="logo"><?php echo yprm_site_logo(); ?></div>
						<div class="fr">
							<?php if(has_nav_menu('navigation') && yprm_get_theme_setting('navigation_type') != 'disabled') { ?>
								<nav class="navigation <?php echo esc_attr(yprm_get_theme_setting('navigation_type').' hover-'.yprm_get_theme_setting('navigation_item_hover_style')) ?>"><?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?></nav>
								<div class="butter-button nav-button <?php echo esc_attr(yprm_get_theme_setting('navigation_type')) ?>">
									<div></div>
								</div>
							<?php } if((yprm_get_theme_setting('header_cart') == 'yes' || yprm_get_theme_setting('header_cart') == 'true') && class_exists( 'WooCommerce' )) { ?>
								<div class="header-minicart woocommerce header-minicart-novo">
									<?php global $woocommerce;
									$count = $woocommerce->cart->cart_contents_count;
									if($count == 0) { ?>
									<div class="hm-count empty"><i class="base-icon-minicart"></i></div>
									<?php } else { ?>
									<a class="hm-count" href="<?php echo esc_url(wc_get_cart_url()) ?>"><i class="base-icon-minicart"></i><span><?php echo esc_html($count) ?></span></a>
									<?php } ?>
									<div class="minicart-wrap">
										<?php woocommerce_mini_cart(); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</header>
			<?php } else if(yprm_get_theme_setting('header_style') == 'side') { ?>
				<header class="site-header<?php echo esc_attr(yprm_header_class()) ?> main-row">
					<div class="<?php echo esc_attr(yprm_get_theme_setting('header_container')) ?>">
						<?php if(is_active_sidebar('sidebar')) { ?>
							<div class="side-bar-button multimedia-icon-list"></div>
						<?php } ?>
						<div class="logo"><?php echo yprm_site_logo(); ?></div>
						<div class="fr">
							<?php if(has_nav_menu('navigation') && yprm_get_theme_setting('navigation_type') != 'disabled') { ?>
								<nav class="navigation <?php echo esc_attr(yprm_get_theme_setting('navigation_type').' hover-'.yprm_get_theme_setting('navigation_item_hover_style')) ?>"><?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?></nav>
								<div class="butter-button nav-button <?php echo esc_attr(yprm_get_theme_setting('navigation_type')) ?>">
									<div></div>
								</div>
							<?php } if((yprm_get_theme_setting('header_cart') == 'yes' || yprm_get_theme_setting('header_cart') == 'true') && class_exists( 'WooCommerce' )) { ?>
								<div class="header-minicart woocommerce header-minicart-novo">
									<?php global $woocommerce;
									$count = $woocommerce->cart->cart_contents_count;
									if($count == 0) { ?>
									<div class="hm-count empty"><i class="base-icon-minicart"></i></div>
									<?php } else { ?>
									<a class="hm-count" href="<?php echo esc_url(wc_get_cart_url()) ?>"><i class="base-icon-minicart"></i><span><?php echo esc_html($count) ?></span></a>
									<?php } ?>
									<div class="minicart-wrap">
										<?php woocommerce_mini_cart(); ?>
									</div>
								</div>
							<?php } if(yprm_get_theme_setting('header_search') == 'yes' || yprm_get_theme_setting('header_search') == 'true') { ?>
								<div class="search-button"><i class="basic-ui-icon-search"></i></div>
							<?php } ?>
						</div>
					</div>
				</header>
				<div class="side-header main-row<?php echo esc_attr(yprm_header_class()) ?>">
					<div class="logo"><?php echo yprm_site_logo(); ?></div>
					<div class="wrap">
						<div class="cell">
							<nav class="side-navigation"><?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'menu', 'link_before' => '<span>', 'link_after' => '</span>', 'walker' => new Child_Wrap(), ) ); ?></nav>
						</div>
					</div>
					<?php if(!empty(yprm_get_theme_setting('copyright_text'))) { ?>
						<div class="copyright"><?php echo yprm_get_theme_setting('copyright_text') ?></div>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if(is_active_sidebar('sidebar')) { ?>
				<div class="side-bar-area main-row">
          <div class="close basic-ui-icon-cancel"></div>
          <?php if($sidebar_word = yprm_get_theme_setting('header_sidebar_word')) { ?>
            <div class="bg-word"><?php echo strip_tags($sidebar_word) ?></div>
          <?php } ?>
					<div class="wrap">
						<?php dynamic_sidebar( 'sidebar' ); ?>
					</div>
					<?php if(!empty(yprm_get_theme_setting('copyright_text'))) { ?>
						<div class="copyright"><?php echo yprm_get_theme_setting('copyright_text') ?></div>
					<?php } ?>
				</div>
			<?php } if(yprm_get_theme_setting('header_space') == 'yes' || yprm_get_theme_setting('header_space') == 'true') { ?>
				<div class="header-space"></div>
			<?php } else { ?>
				<div class="header-space hide"></div>
			<?php } if(yprm_get_theme_setting('header_search') == 'yes' || yprm_get_theme_setting('header_search') == 'true') { ?>
				<div class="search-popup main-row">
					<div class="close basic-ui-icon-cancel"></div>
					<div class="centered-container"><?php get_search_form(); ?></div>
				</div>
			<?php } if(yprm_get_theme_setting('navigation_type')) { ?>
				<nav class="full-screen-nav main-row">
					<div class="close basic-ui-icon-cancel"></div>
					<div class="fsn-container">
						<?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'cell' ) ); ?>
					</div>
				</nav>
      <?php } ?>