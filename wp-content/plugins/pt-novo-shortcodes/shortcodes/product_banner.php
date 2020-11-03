<?php

// Element Description: PT Banner
if (class_exists('WooCommerce')) {
  class PT_Product_Banner extends WPBakeryShortCode {

    // Element Init
    public function __construct() {
      add_action('init', array($this, 'pt_product_banner_mapping'));
      add_shortcode('pt_product_banner', array($this, 'pt_product_banner_html'));
      add_shortcode('pt_product_banner_item', array($this, 'pt_product_banner_item_html'));
    }

    public static function get_all_products_items($param = 'All') {
      $result = array();

      $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => '10000',
      );

      $product_array = new WP_Query($args);
      //$result[0] = "";
      if (is_array($product_array->posts) && !empty($product_array->posts) && count($product_array->posts) > 0) {
        foreach ($product_array->posts as $item) {
          $result['ID [' . $item->ID . '] ' . $item->post_title] = $item->ID;
        }
      }

      return $result;
    }

    // Element Mapping
    public function pt_product_banner_mapping() {

      // Stop all if VC is not enabled
      if (!defined('WPB_VC_VERSION')) {
        return;
      }

      // Map the block with vc_map()
      vc_map(array(
        "name" => esc_html__("Product Banner", "novo"),
        "base" => "pt_product_banner",
        "as_parent" => array('only' => 'pt_product_banner_item'),
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => "shortcode-icon-product-banner",
        "is_container" => true,
        "category" => esc_html__("Novo Shortcodes", "novo"),
        "params" => array(
          array(
            "type" => "textfield",
            "heading" => esc_html__("Uniq ID", "novo"),
            "param_name" => "uniqid",
            "value" => uniqid(),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("External indent", "novo"),
            "param_name" => "external_indent",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => "Yes",
                "off" => "No",
              ),
            ),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Carousel navigation", "novo"),
            "param_name" => "carousel_nav",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => "Yes",
                "off" => "No",
              ),
            ),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Infinite loop", "novo"),
            "param_name" => "infinite_loop",
            "value" => "on",
            "options" => array(
              "on" => array(
                "label" => esc_html__("Restart the slider automatically as it passes the last slide.", "novo"),
                "on" => "On",
                "off" => "Off",
              ),
            ),
            "default_set" => true,
          ),
          array(
            "type" => "number",
            "heading" => esc_html__("Transition speed", "novo"),
            "param_name" => "speed",
            "value" => "300",
            "min" => "100",
            "max" => "10000",
            "step" => "100",
            "suffix" => "ms",
            "description" => esc_html__("Speed at which next slide comes.", "novo"),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Autoplay Slides", "novo"),
            "param_name" => "autoplay",
            "value" => "on",
            "options" => array(
              "on" => array(
                "label" => esc_html__("Enable Autoplay", "novo"),
                "on" => "Yes",
                "off" => "No",
              ),
            ),
            "default_set" => true,
          ),
          array(
            "type" => "number",
            "heading" => esc_html__("Autoplay Speed", "novo"),
            "param_name" => "autoplay_speed",
            "value" => "5000",
            "min" => "100",
            "max" => "10000",
            "step" => "10",
            "suffix" => "ms",
            "dependency" => Array("element" => "autoplay", "value" => array("on")),
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Extra Class", "novo"),
            "param_name" => "el_class",
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Adaptive Height", "novo"),
            "param_name" => "adaptive_height",
            "value" => "on",
            "options" => array(
              "on" => array(
                "label" => esc_html__("Turn on Adaptive Height", "novo"),
                "on" => "Yes",
                "off" => "No",
              ),
            ),
          ),
          array(
            "type" => "number",
            "heading" => esc_html__("Height", "novo"),
            "param_name" => "height",
            "min" => "540",
            "max" => "1500",
            "step" => "10",
            "suffix" => "px",
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Social buttons", "novo"),
            "param_name" => "social_buttons",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => "On",
                "off" => "Off",
              ),
            ),
            "default_set" => true,
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Navigation Arrows", "novo"),
            "param_name" => "arrows",
            "value" => "on",
            "options" => array(
              "on" => array(
                "label" => esc_html__("Display next / previous navigation arrows", "novo"),
                "on" => "On",
                "off" => "Off",
              ),
            ),
            "default_set" => true,
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Arrow Color", "novo"),
            "param_name" => "arrow_color",
            "dependency" => Array("element" => "arrows", "value" => array("on")),
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Arrow position", "novo"),
            "param_name" => "arrows_position",
            "dependency" => Array("element" => "arrows", "value" => array("on")),
            "value" => array(
              esc_html__("Left Bottom", "novo") => "left-bottom",
              esc_html__("Right Bottom", "novo") => "right-bottom",
            ),
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Pagination", "novo"),
            "param_name" => "dots",
            "value" => "on",
            "options" => array(
              "on" => array(
                "on" => "On",
                "off" => "Off",
              ),
            ),
            "default_set" => true,
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Pagination position", "novo"),
            "param_name" => "dots_position",
            "dependency" => Array("element" => "dots", "value" => array("on")),
            "value" => array(
              esc_html__("Left", "novo") => "left",
              esc_html__("Left Outside", "novo") => "left-outside",
              esc_html__("Left Bottom", "novo") => "left-bottom",
              esc_html__("Bottom", "novo") => "bottom",
              esc_html__("Right Bottom", "novo") => "right-bottom",
              esc_html__("Right", "novo") => "right",
              esc_html__("Right Outside", "novo") => "right-outside",
            ),
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Pagination color", "novo"),
            "param_name" => "dots_color",
            "dependency" => Array("element" => "dots", "value" => array("on")),
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Pause on hover", "novo"),
            "param_name" => "pauseohover",
            "value" => "on",
            "options" => array(
              "on" => array(
                "label" => esc_html__("Pause the slider on hover", "novo"),
                "on" => "Yes",
                "off" => "No",
              ),
            ),
            "dependency" => Array("element" => "autoplay", "value" => "on"),
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Pagination color", "novo"),
            "param_name" => "dots_color",
            "dependency" => Array("element" => "dots", "value" => array("on")),
            "group" => esc_html__("Navigation", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Social icon 1", "novo"),
            "param_name" => "social_icon1",
            "value" => yprm_social_links_array(),
            "group" => esc_html__("Social links", "novo"),
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Social link 1", "novo"),
            "param_name" => "social_link1",
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
            "group" => esc_html__("Social links", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Social icon 2", "novo"),
            "param_name" => "social_icon2",
            "value" => yprm_social_links_array(),
            "group" => esc_html__("Social links", "novo"),
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Social link 2", "novo"),
            "param_name" => "social_link2",
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
            "group" => esc_html__("Social links", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Social icon 3", "novo"),
            "param_name" => "social_icon3",
            "value" => yprm_social_links_array(),
            "group" => esc_html__("Social links", "novo"),
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Social link 3", "novo"),
            "param_name" => "social_link3",
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
            "group" => esc_html__("Social links", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Social icon 4", "novo"),
            "param_name" => "social_icon4",
            "value" => yprm_social_links_array(),
            "group" => esc_html__("Social links", "novo"),
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Social link 4", "novo"),
            "param_name" => "social_link4",
            "dependency" => Array("element" => "social_buttons", "value" => array("on")),
            "group" => esc_html__("Social links", "novo"),
          ),
        ),
        "js_view" => 'VcColumnView',
      ));
      vc_map(array(
        "name" => esc_html__("Product Banner item", "novo"),
        "base" => "pt_product_banner_item",
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => "shortcode-icon-product-banner",
        "as_child" => array('only' => 'pt_product_banner'),
        "params" => array(
          array(
            "type" => "textfield",
            "heading" => esc_html__("Uniq ID", "novo"),
            "param_name" => "uniqid",
            "value" => uniqid(),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Item", "novo"),
            "param_name" => "item",
            "admin_label" => true,
            "value" => PT_Product_Banner::get_all_products_items(),
          ),
          array(
            "type" => "attach_image",
            "heading" => esc_html__("Background image", "novo"),
            "param_name" => "image",
            "admin_label" => true,
          ),
          array(
            "type" => "textarea",
            "heading" => esc_html__("Heading", "novo"),
            "param_name" => "heading",
            "description" => esc_html__('(optional)', 'novo'),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Link Button", "novo"),
            "param_name" => "link_button",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => "Yes",
                "off" => "No",
              ),
            ),
            "default_set" => false,
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Link text", "novo"),
            "param_name" => "link_text",
            "value" => esc_html__('Buy', 'novo'),
            "dependency" => Array("element" => "link_button", "value" => "on"),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Inner shadow", "novo"),
            "param_name" => "inner_shadow",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => "Yes",
                "off" => "No",
              ),
            ),
            "default_set" => false,
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Color overlay", "novo"),
            "param_name" => "color_overlay",
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Text color", "novo"),
            "param_name" => "text_color",
            "value" => array(
              esc_html__("Black", "novo") => "black",
              esc_html__("White", "novo") => "white",
              esc_html__("Custom", "novo") => "custom",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Select Text color", "novo"),
            "param_name" => "text_color_hex",
            "dependency" => Array("element" => "text_color", "value" => "custom"),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Heading size", "novo"),
            "param_name" => "heading_size",
            "value" => array(
              esc_html__("H1", "novo") => "h1",
              esc_html__("H2", "novo") => "h2",
              esc_html__("H3", "novo") => "h3",
              esc_html__("H4", "novo") => "h4",
              esc_html__("H5", "novo") => "h5",
              esc_html__("H6", "novo") => "h6",
            ),
            "std" => 'h5',
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Text align", "novo"),
            "param_name" => "text_align",
            "value" => array(
              esc_html__("Left", "novo") => "tal",
              esc_html__("Center", "novo") => "tac",
              esc_html__("Right", "novo") => "tar",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Text vertical align", "novo"),
            "param_name" => "text_vertical_align",
            "value" => array(
              esc_html__("Top", "novo") => "top",
              esc_html__("Middle", "novo") => "middle",
              esc_html__("Bottom", "novo") => "bottom",
            ),
            "std" => 'bottom',
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text color", "novo"),
            "param_name" => "button_text_color",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hover color", "novo"),
            "param_name" => "button_text_color_hover",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border color", "novo"),
            "param_name" => "button_border_color",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hover color", "novo"),
            "param_name" => "button_border_color_hover",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background color", "novo"),
            "param_name" => "button_bg_color",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hover color", "novo"),
            "param_name" => "button_bg_color_hover",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
        ),
      ));
    }

    // Element HTML
    public function pt_product_banner_html($atts, $content = null) {

      // Params extraction
      extract(
        shortcode_atts(
          array(
            'uniqid' => uniqid(),
            'external_indent' => 'off',
            'carousel_nav' => 'off',
            'infinite_loop' => 'on',
            'speed' => '500',
            'autoplay' => 'on',
            'autoplay_speed' => '3000',
            'el_class' => '',
            'adaptive_height' => '',
            'height' => '',
            'arrows' => 'on',
            'arrow_color' => '',
            'arrows_position' => 'left',
            'dots' => 'on',
            'dots_position' => 'left',
            'dots_color' => '',
            'pauseohover' => 'on',
            'about_block' => 'off',
            'social_buttons' => 'off',
            'categories' => 'off',
            'social_icon1' => '',
            'social_link1' => '',
            'social_icon2' => '',
            'social_link2' => '',
            'social_icon3' => '',
            'social_link3' => '',
            'social_icon4' => '',
            'social_link4' => '',
          ),
          $atts
        )
      );

      $id = 'banner-' . $uniqid;

      $banner_class = $id;
      $banner_class .= ' ' . $el_class;

      $banner_style = "";

      if (!empty($height)) {
        $banner_class .= ' fixed-height';
        $banner_style = 'height:' . $height . 'px;';
      }

      $custom_css = "";

      if (isset($dots_color) && !empty($dots_color)) {
        $custom_css .= '.' . $id . ' .owl-dots {
          color: ' . $dots_color . ';
        }';
      }

      $custom_area_css = " banner-area-" . $uniqid;
      if ($external_indent == 'on') {
        $custom_area_css .= " external-indent";
      }

      wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
      wp_add_inline_style('novo-custom-style', $custom_css);

      if ($infinite_loop == 'on') {
        $infinite_loop = 'true';
      } else {
        $infinite_loop = 'false';
      }
      if ($autoplay == 'on') {
        $autoplay = 'true';
      } else {
        $autoplay = 'false';
      }
      if ($arrows == 'on' && $carousel_nav == 'off') {
        $arrows = 'true';
        $banner_class .= ' arrows-' . $arrows_position;
      } else {
        $arrows = 'false';
      }
      if ($dots == 'on') {
        $dots = 'true';
        $banner_class .= ' pagination-' . $dots_position;
      } else {
        $dots = 'false';
      }
      if ($pauseohover == 'on') {
        $pauseohover = 'true';
      } else {
        $pauseohover = 'false';
      }

      $carousel_js = '';
      if ($carousel_nav == 'on') {
        $custom_area_css .= ' with-carousel-nav';
        $carousel_js = "

    				var child_carousel = head_slider.parent().find('.banner-carousel');

    				var i = 0;
    				var flag = false;
                    var c_items = '3';
    				head_slider.find('.owl-item:not(.cloned)').find('.item').each(function(){
    					i++;
    					var heading = jQuery(this).data('heading');
    					var text = jQuery(this).data('text');
                        if(!child_carousel.hasClass('owl-carousel')) {
    					   child_carousel.append('<div class=\"item\"><div class=\"num\">'+leadZero(i)+'</div><div class=\"h\">'+heading+'</div><div class=\"p\">'+text+'</div></div>');
                        }
    				});


                    if(head_slider.find('.owl-item:not(.cloned)').find('.item').length < 3) {
                        c_items = head_slider.find('.owl-item:not(.cloned)').find('.item').length;
                    }

                    child_carousel = child_carousel.addClass('owl-carousel').owlCarousel({
                        loop:true,
                        items:1,
                        nav: true,
                        dots: false,
                        autoplay: false,
                        smartSpeed: " . esc_js($speed) . ",
                        navClass: ['owl-prev basic-ui-icon-left-arrow','owl-next basic-ui-icon-right-arrow'],
                        navText: false,
                        margin: 30,
                        responsive:{
                            0:{
                                nav: false,
                            },
                            480:{

                            },
                            768:{
                                nav: true,
                                items: c_items
                            },
                        },
                    })
    	            .on('click', '.item', function(e) {
    				    e.preventDefault();
    				    head_slider.trigger('to.owl.carousel', [jQuery(e.target).parents('.owl-item').index()+1, 300, true]);
    				}).data('owl.carousel');

    				head_slider.on('change.owl.carousel', function(e) {
    					if (e.namespace && e.property.name === 'position' && !flag) {
    					  	flag = true;
    					  	child_carousel.to(e.relatedTarget.relative(e.property.value), 300, true);
    					  	flag = false;
    					}
    				}).data('owl.carousel');
    			";
      }

      wp_enqueue_style('owl-carousel');
      wp_enqueue_script('owl-carousel');
      wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');

      wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
                jQuery('." . esc_attr($id) . "').each(function(){
                    jQuery(this).on('initialize.owl.carousel',function(property){
                        jQuery(this).find('.item').each(function() {
                            var num = leadZero(jQuery(this).index()+1);
                            jQuery(this).find('.num').text(num);
                        });
                    });
                    var head_slider = jQuery(this);

                    if(head_slider.find('.item').length == 1) {
                        head_slider.parent().removeClass('with-carousel-nav');
                    }
                    if(jQuery(this).find('.item').length > 1){
                        head_slider.addClass('owl-carousel').owlCarousel({
                            loop:true,
                            items:1,
                            nav: " . esc_js($arrows) . ",
                            dots: " . esc_js($dots) . ",
                            autoplay: " . esc_js($autoplay) . ",
                            autoplayTimeout: " . esc_js($autoplay_speed) . ",
                            autoplayHoverPause: " . esc_js($pauseohover) . ",
                            smartSpeed: " . esc_js($speed) . ",
                            navClass: ['owl-prev basic-ui-icon-left-arrow','owl-next basic-ui-icon-right-arrow'],
                            navText: false,
                            responsive:{
                                0:{
                                    nav: false,
                                },
                                480:{

                                },
                                768:{
                                    nav: " . esc_js($arrows) . ",
                                },
                            },
                        });

                        " . $carousel_js . "


                    }
                });
            });");

      // Fill $html var with data
      $html = '<div class="banner-area' . esc_attr($custom_area_css) . '">';

      if ($social_buttons == 'on') {
        $social_links_array = array();
  
        $flag = true;
        $a = 0;
        while ($a <= 4) {
          $a++;
          $s_type = 'social_icon' . $a;
          $s_link = 'social_link' . $a;
  
          if (!empty($$s_type) && !empty($$s_link)) {
            $flag = false;
  
            array_push($social_links_array, array(
              'type' => $$s_type,
              'url' => $$s_link,
            ));
          }
        }
  
        if ($flag) {
          $social_links_html = yprm_build_social_links('with-label');
        } else {
          $social_links_html = yprm_build_social_links('with-label', $social_links_array);
        }
  
        if(!empty($social_links_html)) {
          $html .= '<div class="banner-social-buttons">';
            $html .= '<div class="links">';
              $html .= $social_links_html;
            $html .= '</div>';
          $html .= '</div>';
        }
      }

      $html .= '<div class="banner ' . esc_attr($banner_class) . '" style="' . $banner_style . '">';
      $html .= do_shortcode($content);
      $html .= '</div>';

      if ($carousel_nav == 'on') {
        $html .= '<div class="banner-carousel"></div>';
      }
      $html .= '</div>';

      return $html;

    }

    // Element HTML
    public function pt_product_banner_item_html($atts) {

      // Params extraction
      extract(
        shortcode_atts(
          array(
            'uniqid' => uniqid(),
            'image' => '',
            'heading' => '',
            'item' => '',
            'link_button' => '',
            'link_text' => esc_html__('Buy', 'novo'),
            'inner_shadow' => 'off',
            'color_overlay' => '',
            'heading_size' => 'h5',
            'heading_style' => 'default',
            'text_align' => 'tal',
            'text_vertical_align' => 'bottom',
            'text_color' => 'black',
            'text_color_hex' => '',
            'button_text_color' => '',
            'button_text_color_hover' => '',
            'button_border_color' => '',
            'button_border_color_hover' => '',
            'button_bg_color' => '',
            'button_bg_color_hover' => '',
          ),
          $atts
        )
      );

      // Fill $html var with data

      $heading_html = '';
      $link_html = '';
      $price_html = '';
      $custom_css = '';
      $item_class = $item_id = 'banner-item-' . $uniqid;

      $product = wc_get_product($item);
      if(!$product) return false;

      if (!$heading && is_object($product)) {
        $heading = $product->get_name();
      }

      $item_attr = "";
      if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
        $item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')';
      } elseif (has_post_thumbnail($id)) {
        $attachment_ids[0] = get_post_thumbnail_id($id);
        $item_attr = 'background-image: url(' . wp_get_attachment_image_src($attachment_ids[0], 'full')[0] . ')';
      }

      if ($heading_style == 'number') {
        $heading_html = '<div class="heading-with-num">
                    <div class="num"></div>
                    <' . $heading_size . '>' . wp_kses($heading, 'post') . '</' . $heading_size . '>
                </div>';
      } elseif ($heading_style == 'decor-line') {
        $heading_html = '<div class="heading-decor">
                    <' . $heading_size . '>' . wp_kses($heading, 'post') . '</' . $heading_size . '>
                </div>';
      } else {
        $heading_html = '<div class="heading">
                    <' . $heading_size . '>' . wp_kses($heading, 'post') . '</' . $heading_size . '>
                </div>';
      }

      if ($link_button == 'on' && !empty($link_text)) {
        $link_html = '<a href="' . esc_url(get_permalink($item)) . '" class="button-style1">' . esc_html($link_text) . '</a>';
        if (!empty($button_text_color) || !empty($button_border_color) || !empty($button_bg_color)) {
          $custom_css .= '.' . $item_id . ' .button-style1 {';
          if (!empty($button_text_color)) {
            $custom_css .= 'color: ' . $button_text_color . ';';
          }
          if (!empty($button_border_color)) {
            $custom_css .= 'border-color: ' . $button_border_color . ';';
          }
          if (!empty($button_bg_color)) {
            $custom_css .= 'background-color: ' . $button_bg_color . ';';
          }
          $custom_css .= '}';
        }

        if (!empty($button_text_color_hover) || !empty($button_border_color_hover) || !empty($button_bg_color_hover)) {
          $custom_css .= '.' . $item_id . ' .button-style1:hover {';
          if (!empty($button_text_color_hover)) {
            $custom_css .= 'color: ' . $button_text_color_hover . ';';
          }
          if (!empty($button_border_color_hover)) {
            $custom_css .= 'border-color: ' . $button_border_color_hover . ';';
          }
          if (!empty($button_bg_color_hover)) {
            $custom_css .= 'background-color: ' . $button_bg_color_hover . ';';
          }
          $custom_css .= '}';
        }
      }

      if (!empty($color_overlay)) {
        $custom_css .= '.' . $item_id . ':after {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    z-index: 1;
                    background-color: ' . $color_overlay . ';
                }';
      }

      $item_class .= ' ' . $text_align;

      if ($inner_shadow == 'on') {
        $item_class .= ' with-shadow';
      }

      if (isset($text_color) && $text_color != 'custom') {
        $item_class .= ' ' . $text_color;
      }

      if (isset($text_color) && $text_color == 'custom') {
        $custom_css .= '.' . $item_id . ' {
                    color: ' . $text_color_hex . ';
                }';
      }

      if ($product->get_price_html()) {
        $price_html = '<div class="heading-decor"><div class="price">' . $product->get_price_html() . '</div></div>';
      }

      wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
      wp_add_inline_style('novo-custom-style', $custom_css);

      $html = '<div class="item ' . esc_attr($item_class) . '" style="' . esc_attr($item_attr) . '" data-heading="' . esc_html($heading) . '" data-text=\'' . $product->get_price_html() . '\'>
          <div class="container">
              <div class="cell ' . esc_attr($text_vertical_align) . '">
                  ' . wp_kses($price_html, 'post') . '
                  ' . wp_kses($heading_html, 'post') . '
                  ' . wp_kses($link_html, 'post') . '
              </div>
          </div>
      </div>';

      return $html;

    }

  } // End Element Class

  // Element Class Init
  new PT_Product_Banner();
  if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_PT_Product_Banner extends WPBakeryShortCodesContainer {
    }
  }
  if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_PT_Product_Banner_Item extends WPBakeryShortCode {
    }
  }
}
