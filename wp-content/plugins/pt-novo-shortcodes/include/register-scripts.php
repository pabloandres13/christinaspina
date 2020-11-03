<?php

/* Scripts */
wp_deregister_script('wpb_composer_front_js');
wp_register_script('wpb_composer_front_js', plugins_url('pt-novo-shortcodes') . '/assets/js/js_composer_front.min.js', array('jquery'), '1.0.0', true);

wp_register_script('pt-admin', plugins_url('pt-novo-shortcodes') . '/assets/js/admin.js', array('jquery'), '1.0.0', true);
wp_register_script('pt-scripts', plugins_url('pt-novo-shortcodes') . '/assets/js/pt-scripts.js', array('jquery'), '1.0.0', true);

wp_register_script('isotope', plugins_url('pt-novo-shortcodes') . '/assets/js/isotope.pkgd.min.js', array('jquery'), '3.0.6', true);
wp_register_script('background-video', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.background-video.js', array('jquery'), null, true);
wp_register_script('countdown', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.countdown.js', array('jquery'), '1.0', true);
wp_register_script('flipster', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.flipster.min.js', array('jquery'), null, true);
wp_register_script('justified-gallery', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.justifiedGallery.js', array('jquery'), '', true);
wp_register_script('scrollbar', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.scrollbar.min.js', array('jquery'), '0.2.10', true);
wp_register_script('owl-carousel', plugins_url('pt-novo-shortcodes') . '/assets/js/owl.carousel.min.js', array('jquery'), '2.3.4', true);
wp_register_script('owl-linked', plugins_url('pt-novo-shortcodes') . '/assets/js/owl.linked.js', array('owl-carousel'), '1.0.0', true);
wp_register_script('photoswipe', plugins_url('pt-novo-shortcodes') . '/assets/js/photoswipe.min.js', array('jquery'), '4.1.1', true);
wp_register_script('photoswipe-ui', plugins_url('pt-novo-shortcodes') . '/assets/js/photoswipe-ui-default.min.js', array('photoswipe'), '4.1.1', true);
wp_register_script('video', plugins_url('pt-novo-shortcodes') . '/assets/js/video.js', array('jquery'), '7.3.0', true);
wp_register_script('circle-progress', plugins_url('pt-novo-shortcodes') . '/assets/js/circle-progress.min.js', array('jquery'), '1.2.2', true);
wp_register_script('swiper-6.1.1', plugins_url('pt-novo-shortcodes') . '/assets/js/swiper.min.js', array('jquery'), '6.1.1', true);
wp_register_script('swiper', plugins_url('pt-novo-shortcodes') . '/assets/js/swiper-4.5.0.min.js', array('jquery'), '4.5.0', true);
wp_register_script('parallax', plugins_url('pt-novo-shortcodes') . '/assets/js/parallax.min.js', array('jquery'), null, true);
wp_register_script('touch-swipe', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.touchSwipe.min.js', array('jquery'), '1.6.18', true);
wp_register_script('textfill', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.textfill.min.js', array('jquery'), '0.6.2', true);
wp_register_script('sticky-kit', plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.sticky-kit.min.js', array('jquery'), '1.1.2', true);
wp_register_script('typed', plugins_url('pt-novo-shortcodes') . '/assets/js/typed.min.js', array('jquery'), '2.0.9', true);

wp_register_script('pt-load-posts', plugins_url('pt-novo-shortcodes') . '/assets/js/load-posts.js', array('jquery'), '0.6.2', true);
wp_register_script('pt-accordion', plugins_url('pt-novo-shortcodes') . '/assets/js/pt-accordion.js', array('jquery'), '1.0.0', true);
wp_register_script('pt-split-screen', plugins_url('pt-novo-shortcodes') . '/assets/js/pt-split-screen.js', array('jquery'), '1.0.0', true);
wp_register_script('pt-tabs', plugins_url('pt-novo-shortcodes') . '/assets/js/pt-tabs.js', array('jquery'), '1.0.0', true);
wp_register_script('pt-youtube-video', plugins_url('pt-novo-shortcodes') . '/assets/js/youtube-video.js', array('jquery'), '2.0.9', true);
wp_register_script('pixi', 'https://cdnjs.cloudflare.com/ajax/libs/pixi.js/5.1.3/pixi.min.js', null, '5.1.3', true);
wp_register_script('three.js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r119/three.min.js', null, '5.1.3', true);
wp_register_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.4.2/gsap.min.js', null, '3.4.2', true);
wp_register_script('pt-liquidSlider', plugins_url('pt-novo-shortcodes') . '/assets/js/liquidSlider.js', array('three.js', 'gsap', 'swiper-6.1.1'), '1.0.0', true);

if(function_exists('yprm_get_theme_setting') && !empty(yprm_get_theme_setting('google_maps_api_key'))) {
  wp_register_script('pt-googleapis', '//maps.googleapis.com/maps/api/js?v=3.exp&amp;key=' . yprm_get_theme_setting('google_maps_api_key') . '&amp;sensor=false', array('jquery'), '1.0.0', true);
}

/* Styles */
wp_register_style('pt-admin', plugins_url('pt-novo-shortcodes') . '/assets/css/admin.css', false, '1.0.0');
wp_register_style('pt-addons', plugins_url('pt-novo-shortcodes') . '/assets/css/pt-addons.css');
wp_register_style('pt-inline', plugins_url('pt-novo-shortcodes') . '/assets/css/pt-inline.css');
wp_register_style('pt-custom', plugins_url('pt-novo-shortcodes') . '/assets/css/custom.css', false);
wp_register_style('flipster', plugins_url('pt-novo-shortcodes') . '/assets/css/jquery.flipster.css', false, '1.1.2');
wp_register_style('justified-gallery', plugins_url('pt-novo-shortcodes') . '/assets/css/justifiedGallery.min.css', false, '3.6.3');
wp_register_style('owl-carousel', plugins_url('pt-novo-shortcodes') . '/assets/css/owl.carousel.css', false, '2.3.4');
wp_register_style('photoswipe', plugins_url('pt-novo-shortcodes') . '/assets/css/photoswipe.css', false, null);
wp_register_style('swiper', plugins_url('pt-novo-shortcodes') . '/assets/css/swiper.css', false, '4.5.0');